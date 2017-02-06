/**
 * Created by chenmingming on 2016/8/7.
 */
define(['application', 'dire/pagination'], function (application) {
    application.controller('crawler-wemedia', ['$scope', '$http', '$rootScope', '$compile', function ($scope, $http, $rootScope, $compile) {
            //分页配置
            $scope.pageConfig = {
                pagevar: 'page',
                listrows: 10,
                key: 'wemedia_resource'
            };
            $http.get(CONF.url('crawler/videoFromList'), {cache: true})
                .success(function (json) {
                    dealJson(json, function (json) {
                        $scope.from_list = json.data;
                    })
                });
            $scope.total_count = 0;
            //加载数据
            var loadData = function () {
                $http.get(CONF.url('crawler/wemediaList'), {
                        params: {
                            page: $scope.$stateParams.page || 1,
                            from: $scope.$stateParams.from || undefined,
                            size: $scope.pageConfig.listrows
                        }
                    })
                    .success(function (json) {
                        dealJson(json, function (json) {
                            $scope.list = json.data.list;
                            $scope.total_count = json.data.total_count;
                        })
                    });
            };

            var stop1 = $scope.$parent.$on('reload-page-data', function (e, name) {
                name == $scope.pageConfig.key && loadData();
            });

            //数据销毁
            $scope.$on('$destroy', function () {
                stop1();
            });

            $scope.$on('reload-data', function () {
                loadData();
            });
            $scope.add = function () {
                $('body').append($compile('<add-wemedia-model></add-wemedia-model>')($scope));
            };

            $scope.remove = function (v) {
                $('body').append($compile('<ui-confirm data-title="确定要删除么？" on-approve="delete(' + v.id + ')"></ui-confirm>')($scope));

            };
            $scope.delete = function (v) {
                $http.post(CONF.url('crawler/DelWemedia'), {id: v})
                    .success(function (json) {
                        dealJson(json, loadData)
                    })
            }
            $scope.refresh = function (v) {
                $http.post(CONF.url('crawler/updateWemedia'), {id: v.id})
                    .success(function (json) {
                        dealJson(json, loadData)
                    })
            };
            loadData();
            $scope.screen = $.extend({},$scope.$stateParams);
            $scope.img_params = {dir: 'video'};

            //查询
            $scope.query = function () {
                $scope.$stateParams.page = 1;
                $param = {
                    params: {
                        page: $scope.$stateParams.page || 1,
                        size: $scope.pageConfig.listrows,
                        from: $scope.screen.from,
                        status: $scope.screen.status,
                        kw: $scope.screen.kw
                    }
                };
                $http.get(CONF.url('crawler/WemediaList'), $param)
                    .success(function (json) {
                        $scope.list = json.data.list;
                        $scope.total_count = json.data.total_count;
                        $scope.$state.go('.', $scope.$stateParams, {notify: false});
                        //将参数传递给rootScope.
                        angular.forEach($scope.$stateParams, function (v, k) {
                            v ? ($rootScope.$stateParams[k] = v) : (delete  $rootScope.$stateParams[k]);
                        });
                    })
            }
        }])
        .directive('addWemediaModel', ['$http', function ($http) {
            return {
                restrict: 'E',
                replace: true,
                scope: {},
                templateUrl: CONF.tpl('crawler/add-wemedia-model'),
                link: function ($scope, elem, link) {
                    $http.get(CONF.url('crawler/videoFromList'), {cache: true})
                        .success(function (json) {
                            dealJson(json, function (json) {
                                $scope.from_list = json.data;
                            })
                        });

                    $scope.submit = function () {
                        $scope.is_submit = true;
                        $http.post(CONF.url('crawler/addWemedia'), {from: $scope.data.from, url: $scope.data.url})
                            .success(function (json) {
                                $scope.is_submit = false;
                                dealJson(json, function (json) {
                                    $scope.$emit('reload-data');
                                    $(elem).modal('hide');
                                })
                            });
                        return false;
                    };

                }
            };
        }])
});