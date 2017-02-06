/**
 * Created by chenmingming on 2016/8/7.
 */
define(['application', 'dire/pagination'], function (application) {
    application.controller('content-nav', ['$scope', '$http', '$compile', function ($scope, $http, $compile) {
        //分页配置
        $scope.pageConfig = {
            pagevar: 'page',
            listrows: 10,
            key: 'nav_list'
        };

        $scope.loadData = function () {
            $http.get(CONF.url('content/navList'), {
                params: {
                    page: $scope.$stateParams.page || 1
                }
            })
                .success(function (json) {
                    $scope.list = json.data.list;
                    $scope.total_count = json.data.total_count;
                });
        };

        var stop1 = $scope.$parent.$on('reload-page-data', function (e, name) {
            name == $scope.pageConfig.key && $scope.loadData();
        });
        //数据销毁
        $scope.$on('$destroy', function () {
            stop1();
        });

        //删除提示
        $scope.remove = function (v) {
            $('body').append($compile('<ui-confirm data-title="确定要删除么？" on-approve="delete(' + v.id + ')"></ui-confirm>')($scope));
        };
        //删除
        $scope.delete = function (id) {
            $http.post(CONF.url('content/navDel'), {id: id})
                .success(function (json) {
                    dealJson(json, $scope.loadData);
                })
        };
        //添加，更新
        $scope.add = function (model) {
            $scope.editModel = model;
            $('body').append($compile('<nav-model data="editModel" load-data="loadData()"></nav-model>')($scope));
        };

        //初始化
        $scope.loadData();
    }])

        .directive('navModel', ['$http', function ($http) {
            return {
                restrict: 'E',
                replace: true,
                scope: {
                    data: '=',
                    loadData: '&'
                },
                templateUrl: CONF.tpl('content/nav-model'),
                link: function ($scope, elem, link) {
                    $scope.submit = function () {
                        $scope.is_submit = true;
                        $http.post(CONF.url('content/navAdd'), {
                            id: $scope.data.id || 0,
                            name: $scope.data.name,
                            icon: $scope.data.icon
                        })
                            .success(function (json) {
                                dealJson(json, function (json) {
                                    $scope.loadData();
                                });
                            })
                    };

                    $scope.imgParams = {dir: 'nav'};
                }
            };
        }])
});