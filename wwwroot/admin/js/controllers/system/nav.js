/**
 * Created by chenmingming on 2016/8/7.
 */
define(['application', 'angular'], function (application, angular) {
    application.controller('system-nav', ['$scope', '$http', '$compile', function ($scope, $http, $compile) {
        $scope.activeGroup = undefined;
        var loadData = function () {
            $http.post(CONF.url('nav/nlist'))
                .success(function (json) {
                    dealJson(json, function (json) {
                        $scope.list = json.data.list;
                        $scope.parent_nav = json.data.parent_nav;
                        $scope.activeGroup && angular.forEach($scope.list, function (v) {
                            if (v.id == $scope.activeGroup.id) {
                                $scope.activeGroup = v;
                            }
                        });
                        !$scope.activeGroup && ($scope.activeGroup = $scope.list[0]);
                    })
                });
        };
        $scope.$on('reload-data', function () {
            loadData();
        });
        $scope.add = function (model, parent_nav) {
            $scope.editModel = angular.copy(model);
            $scope.parentNav = parent_nav;
            $('body').append($compile('<nav-model data="editModel" data1="parentNav"></nav-model>')($scope));
        };
        $scope.remove = function (id) {
            if (!confirm("确认删除？")) {
                return false;
            }
            $http.post(CONF.url('nav/del'), {id: id})
                .success(function (json) {
                    dealJson(json, function (json) {
                        loadData();
                        $scope.$parent.$emit('reload-navlist');
                    });
                })
        };
        loadData();
    }])
        .directive('navModel', ['$http', '$rootScope', function ($http, $rootScope) {
            return {
                restrict: 'E',
                replace: true,
                scope: {
                    data: '=',
                    data1: '='
                },
                templateUrl: CONF.tpl('system/nav-model'),
                link: function ($scope, elem, link) {
                    if ($scope.data && $scope.data.id) {
                        $scope.action_text = '修改';
                        $scope.data.old_id = $scope.data.id;
                    } else {
                        $scope.data.old_id = 0;
                        $scope.action_text = '添加';
                    }
                    $scope.changeStatus = function (data) {
                        if (data.status == 'open') {
                            data.status = 'close';
                        } else {
                            data.status = 'open';
                        }
                    };

                    $scope.submit = function () {
                        $scope.is_submit = true;
                        $http.post(CONF.url('nav/add'), {
                            id: $scope.data.id,
                            pid: $scope.data.pid,
                            text: $scope.data.text,
                            url: $scope.data.url,
                            icon: $scope.data.icon,
                            group: $scope.data.group,
                            old_id: $scope.data.old_id,
                            target: $scope.data.target,
                            status: $scope.data.status,
                            orderNum: $scope.data.orderNum
                        })
                            .success(function (json) {
                                dealJson(json, function (json) {
                                    $(elem).modal('hide');
                                    $scope.$emit('reload-data');
                                    $rootScope.$emit('reload-navlist');
                                }, function (json) {
                                    $scope.is_submit = false;
                                    tip(json.msg);
                                })
                            });
                        return false;
                    }
                }
            };
        }])
});