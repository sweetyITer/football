/**
 * Created by chenmingming on 2016/8/7.
 */
define(['application'], function (application) {
    application.controller('system-crontab', ['$scope', '$http', '$compile', '$timeout', function ($scope, $http, $compile, $timeout) {
        var loadData = function () {
            $http.post(CONF.url('crontab/list'))
                .success(function (json) {
                    dealJson(json, function (json) {
                        $scope.list = json.data.list;
                        $scope.status = json.data.status;
                    })
                });
        };
        var inter = setInterval(function () {
            $scope.$apply(function () {
                loadData();
            })
        }, 10000);

        $scope.$on('$destroy', function () {
            clearInterval(inter);
        });
        $scope.$on('reload-data', function () {
            loadData();
        });

        //开始主线程
        $scope.startMain = function () {
            $http.post(CONF.url('crontab/startMain'))
                .success(function (json) {
                    dealJson(json, function (json) {
                        tip('开始成功');
                        loadData();
                    })
                })
        };
        //停止主线程
        $scope.stopMain = function () {
            $http.post(CONF.url('crontab/stopMain'))
                .success(function (json) {
                    dealJson(json, function (json) {
                        tip('停止成功');
                        loadData();
                    })
                })
        };

        $scope.stop = function (id) {
            $http.post(CONF.url('crontab/stop'), {id: id})
                .success(function (json) {
                    dealJson(json, function (json) {
                        loadData();
                    })
                })
        };
        $scope.start = function (id) {
            $http.post(CONF.url('crontab/start'), {id: id})
                .success(function (json) {
                    dealJson(json, function (json) {
                        loadData();
                    })
                })
        };

        $scope.add = function (model) {
            $scope.editModel = model;
            $('body').append($compile('<crontab-task-model data="editModel"></crontab-task-model>')($scope));
        };

        $scope.remove = function (v) {
            $('body').append($compile('<ui-confirm data-title="确定要删除么？" on-approve="delete(' + v.id + ')"></ui-confirm>')($scope));
        };

        $scope.stat = function () {
            $('body').append($compile('<status-model></status-model>')($scope));
        };

        loadData();

        $scope.img_params = {dir: 'video'};
    }])
        .directive('crontabTaskModel', ['$http', function ($http) {
            return {
                restrict: 'E',
                replace: true,
                scope: {
                    data: '='
                },
                templateUrl: CONF.tpl('system/crontab-task-model'),
                link: function ($scope, elem, link) {
                    $scope.submit = function () {
                        $scope.is_submit = true;
                        $http.post(CONF.url('crontab/add'), {data: angular.toJson($scope.data)})
                            .success(function (json) {
                                $scope.is_submit = false;
                                dealJson(json, function (json) {
                                    $scope.$emit('reload-data');
                                    $(elem).modal('hide');
                                })
                            });
                        return false;
                    }
                }
            };
        }])
        .directive('statusModel', ['$http', function ($http) {
            return {
                restrict: 'E',
                replace: true,
                scope: {},
                templateUrl: CONF.tpl('system/crontab-status-model'),
                link: function ($scope, elem, link) {
                    $scope.loadData = function () {
                        $scope.load_data = true;
                        $scope.list = [];
                        $http.post(CONF.url('crontab/logList'))
                            .success(function (json) {
                                $scope.load_data = false;
                                dealJson(json, function (json) {
                                    $scope.list = json.data;
                                })
                            })
                    };

                    var inter = setInterval(function () {
                        $scope.$apply(function () {
                            $scope.loadData();
                        });
                    }, 10000);

                    $scope.$on('$destroy', function () {
                        clearInterval(inter);
                    });
                    $scope.onHide = function () {
                        clearInterval(inter);
                    }

                    $scope.loadData();
                }
            };
        }])
});