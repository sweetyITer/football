/**
 * Created by chenmingming on 2016/8/7.
 */
define(['application', 'dire/pagination', 'fileinput', 'ajax-bootstrap-select'], function (application) {
    application.controller('system-master', ['$scope', '$http', '$compile', function ($scope, $http, $compile) {

        //分页配置
        $scope.pageConfig = {
            key: 'master-list',
            pagevar: 'page',
            listrows: '20'
        };
        var loadDataGroup = function () {
            $http.post(CONF.url('master/groupList'), {search: 'all'})
                .success(function (json) {
                    dealJson(json, function (json) {
                        $scope.groupList = json.data;
                    })
                });
        };
        loadDataGroup();
        var loadData = function () {
            $http.post(CONF.url('master/mList'), {page: $scope.$stateParams.page})
                .success(function (json) {
                    dealJson(json, function (json) {
                        $scope.list = json.data.list;
                        $scope.totalCount = json.data.count;
                    })
                });
        };
        $scope.$parent.$on('reload-page-data', function () {
            loadData();
        });
        loadData();

        $scope.fileinputConfig = {
            uploadUrl: CONF.url('common/uploadimg') + '?dir=goods',
            allowedFileExtensions: ['jpg', 'png', 'gif', 'bmp'],
            maxFileSize: 2000000,
            maxFilesNum: 2
        };

        //添加
        $scope.add = function (model) {
            $scope.editModel = model;
            $('body').append($compile('<master-model data="editModel" group-list="groupList" fileinput-config="fileinputConfig" load-data="loadData()"></master-model>')($scope));
        };

        //修改
        $scope.update = function (model) {
            $scope.editModel = model;
            $('body').append($compile('<master-model data="editModel" group-list="groupList" fileinput-config="fileinputConfig" load-data="loadData()"></master-model>')($scope));
        };

        //删除页
        $scope.remove = function (id) {
            if (!confirm("确认删除？")) {
                return false;
            }
            $http.post(CONF.url('master/del'), {id: id})
                .success(function (json) {
                    dealJson(json, function (json) {
                        tip('ok');
                        loadData();
                    });
                })
        };
    }])
        .directive('masterModel', ['$http', function ($http) {
            return {
                restrict: 'E',
                replace: true,
                scope: {
                    data: '=',
                    loadData: '&',
                    fileinputConfig: '=',
                    groupList: "="
                },
                templateUrl: CONF.tpl('system/master-model'),
                link: function ($scope, elem, link) {
                    $scope.changeStatus = function (data) {
                        if (data.isLock == '1') {
                            data.isLock = '0';
                        } else {
                            data.isLock = '1';
                        }
                    };
                    $scope.submit = function () {
                        $scope.is_submit = true;
                        var data = {
                            'id': $scope.data.id,
                            'email': $scope.data.email,
                            'phone': $scope.data.phone,
                            'user_face': $scope.data.userFace,
                            'nick_name': $scope.data.nickName,
                            'password': $scope.data.password,
                            'group_id': $scope.data.groupId,
                            'is_lock': $scope.data.isLock || 0,
                            'user_name': $scope.data.userName
                        };
                        $http.post(CONF.url('master/add'), data)
                            .success(function (json) {
                                dealJson(json, function (json) {
                                    tip('ok');
                                    $(elem).modal('hide');
                                    $scope.$emit('reload-page-data');
                                });
                            })
                    };

                    $scope.imgParams = {dir: 'admin'};
                }
            };
        }])
});