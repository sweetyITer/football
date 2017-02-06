/**
 * Created by chenmingming on 2016/8/7.
 */
define(['application', 'dire/pagination'], function (application) {
    application.controller('system-master-group', ['$scope', '$http', '$compile', function ($scope, $http, $compile) {
        $scope.$state.actName = 'system/master';
        //分页配置
        $scope.page_config = {
            key: 'master-group-list',
            pagevar: 'page',
            listrows: '20'
        };
        var loadData = function () {
            $http.post(CONF.url('master/groupList'), {page: $scope.$stateParams.page})
                .success(function (json) {
                    dealJson(json, function (json) {
                        $scope.list = json.data;
                        $scope.total_count = json.count;
                    })
                });
        };

        $scope.$parent.$on('reload-page-data', function () {
            loadData();
        });
        loadData();
        //添加
        $scope.add = function (model) {
            $scope.editModel = model;
            $('body').append($compile('<master-group-model data="editModel" load-data="loadData()"></master-group-model>')($scope));
        };

        //修改
        $scope.update = function (model) {
            $scope.editModel = model;
            $('body').append($compile('<master-group-model data="editModel" load-data="loadData()"></master-group-model>')($scope));
        };

        //删除页
        $scope.remove = function (id) {
            if (!confirm("确认删除？")) {
                return false;
            }
            $http.post(CONF.url('master/delGroup'), {id: id})
                .success(function (json) {
                    dealJson(json, function (json) {
                        tip('ok');
                        loadData();
                    });
                })
        };
    }])
        .directive('masterGroupModel', ['$http', function ($http) {
            return {
                restrict: 'E',
                replace: true,
                scope: {
                    data: '=',
                    loadData: '&',
                },
                templateUrl: CONF.tpl('system/master-group-model'),
                link: function ($scope, elem, link) {
                    $scope.submit = function () {
                        $scope.is_submit = true;
                        var data = {
                            'id': $scope.data.id,
                            'name': $scope.data.name,
                        };
                        $http.post(CONF.url('master/addGroup'), data)
                            .success(function (json) {
                                dealJson(json, function (json) {
                                    tip('OK~');
                                    $(elem).modal('hide');
                                    $scope.$emit('reload-page-data');
                                });
                            })
                    };
                }
            };
        }])
});