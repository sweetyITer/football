/**
 * Created by chenmingming on 2016/8/7.
 */
define(['application','dire/pagination'], function (application) {
    application.controller('system-master', ['$scope', '$http', '$compile', function ($scope, $http, $compile) {
        $scope.$state.actName = 'system/master';

        //分页配置
        $scope.pageConfig = {
            key: 'master-list',
            pagevar: 'page',
            listrows: '10'
        };

        var loadData = function () {
            $http.post(CONF.url('master/mlist'), {page: $scope.$stateParams.p})
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

        //添加
        $scope.add = function (model) {
            $scope.editModel = model;
            $('body').append($compile('<master-model data="editModel" load-data="loadData()"></master-model>')($scope));
        };

        //修改
        $scope.update = function (model) {
            $scope.editModel = model;
            $('body').append($compile('<master-update-model data="editModel" load-data="loadData()"></master-update-model>')($scope));
        };

        //删除提示
        $scope.remove = function (v) {
            $('body').append($compile('<ui-confirm data-title="确定要删除么？" on-approve="delete(' + v.id + ')"></ui-confirm>')($scope));
        };
        //删除页
        $scope.delete = function (id) {
            $http.post(CONF.url('master/del'), {id: id})
                .success(function (json) {
                    dealJson(json, $scope.loadData);
                })
        };
    }])
        .directive('masterModel', ['$http', function ($http) {
            return {
                restrict: 'E',
                replace: true,
                scope: {
                    data: '=',
                    loadData: '&'
                },
                templateUrl: CONF.tpl('system/master-model'),
                link: function ($scope, elem, link) {
                    $scope.submit = function () {
                        $scope.is_submit = true;
                        var data = {
                            'email': $scope.data.email,
                            'phone': $scope.data.phone,
                            'user_face': $scope.data.user_face,
                            'user_name': $scope.data.user_name,
                            'nick_name': $scope.data.nick_name,
                            'password': $scope.data.password
                        };
                        $http.post(CONF.url('master/add'), data)
                            .success(function (json) {
                                dealJson(json, function (json) {
                                    $scope.loadData();
                                });
                            })
                    };

                    $scope.imgParams = {dir: 'admin'};
                }
            };
        }])

        .directive('masterUpdateModel', ['$http', function ($http) {
            return {
                restrict: 'E',
                replace: true,
                scope: {
                    data: '=',
                    loadData: '&'
                },
                templateUrl: CONF.tpl('system/master-update-model'),
                link: function ($scope, elem, link) {
                    $scope.submit = function () {
                        $scope.is_submit = true;
                        var data = {
                            'id': $scope.data.id,
                            'user_face': $scope.data.user_face,
                            'nick_name': $scope.data.nick_name,
                            'is_lock': $scope.data.is_lock
                        };
                        $http.post(CONF.url('master/update'), data)
                            .success(function (json) {
                                dealJson(json, function (json) {
                                    $scope.loadData();
                                });
                            })
                    };

                    $scope.imgParams = {dir: 'admin'};
                }
            };
        }])
});