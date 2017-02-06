/**
 * Created by chenmingming on 2016/8/7.
 */
define(['application', 'dire/pagination'], function (application) {
    return application
        .controller('system-permission', ['$scope', '$http', '$compile', function ($scope, $http, $compile) {
            var loadGroup = function () {
                $http.post(CONF.url('permission/gList'))
                    .success(function (json) {
                        dealJson(json, function (json) {
                            $scope.glist = json.data;
                            !$scope.activeGroup && ($scope.activeGroup = $scope.glist[0]);
                        })
                    });
            };

            var loadData = function () {
                !$scope.activeGroup && ($scope.activeGroup = $scope.glist[0]);
                $scope.activeGroup.ready = false;
                $http.post(CONF.url('permission/pList'), {
                    model: $scope.activeGroup.model,
                })
                    .success(function (json) {
                        dealJson(json, function (json) {
                            $scope.activeGroup.ready = true;
                            $scope.activeGroup.list = json.data;
                        })
                    })
            };


            $scope.$watch('activeGroup.model', function () {
                if ($scope.activeGroup && $scope.activeGroup.model) {
                    loadData();
                }
            });
            $scope.$on('reload-data', function () {
                loadGroup();
                loadData();
            });
            $scope.add = function (model) {
                $scope.editModel = model;
                $('body').append($compile('<permission-model data="editModel"></permission-model>')($scope));
            };

            $scope.remove = function (id) {
                if (!confirm("确认删除？")) {
                    return false;
                }
                $http.post(CONF.url('permission/del'), {id: id})
                    .success(function (json) {
                        dealJson(json, loadData);
                    })
            };
            $scope.show = function (id) {
                $scope.employee_id = id;
                $('body').append($compile('<permission-employee></permission-employee>')($scope));
            };
            loadGroup();
        }])
        .directive('permissionModel', ['$http', '$rootScope', function ($http, $rootScope) {
            return {
                restrict: 'E',
                replace: true,
                scope: {
                    data: '='
                },
                templateUrl: CONF.tpl('system/permission-model'),
                link: function ($scope, elem, link) {
                    if ($scope.data && $scope.data.id) {
                        $scope.action_text = '修改权限';
                    } else {
                        $scope.action_text = '添加权限';
                    }
                    $scope.changeStatus = function (data) {
                        if (data.status == '1') {
                            data.status = '0';
                        } else {
                            data.status = '1';
                        }
                    };
                    $scope.submit = function () {
                        $scope.is_submit = true;
                        $http.post(CONF.url('permission/add'), {
                            id: $scope.data.id,
                            model: $scope.data.model,
                            action: $scope.data.action,
                            status: $scope.data.status,
                            text: $scope.data.text,
                        })
                            .success(function (json) {
                                dealJson(json, function () {
                                    $(elem).modal('hide');
                                    $scope.$emit('reload-data');
                                }, function (json) {
                                    $scope.is_submit = false;
                                    tip(json.msg);
                                })
                            });
                        return false;
                    };
                }
            };
        }])
        .directive('permissionEmployee', ['$http', '$rootScope', '$timeout', function ($http, $rootScope, $timeout) {
            return {
                restrict: 'E',
                replace: true,
                scope: false,
                templateUrl: CONF.tpl('system/employee-list'),
                link: function ($scope, elem, attrs) {
                    $scope.action_text = '权限员工';
                    $scope.pageConfig = {
                        pagevar: 'page',
                        listrows: 5,
                        key: 'employeeList'
                    };
                    var loadData = function (first) {
                        var page = ($rootScope.$stateParams && $rootScope.$stateParams.page) || 1;
                        if (first) {
                            $rootScope.$state.go('.', {page: 1}, {notify: false});
                            page = 1;
                        }
                        $http.post(CONF.url('permission/getEmployeeList'), {
                            id: $scope.employee_id,
                            page: page
                        })
                            .success(function (json) {
                                dealJson(json, function (json) {
                                    if (first) {
                                        $timeout(function () {
                                            $(elem).modal('show');
                                        })
                                    }
                                    $scope.data = json.data.list;
                                    $scope.total = json.data.total_count;
                                })
                            });
                    };
                    loadData(true);

                    var stop1 = $rootScope.$on('reload-page-data', function (e, name) {
                        name == $scope.pageConfig.key && loadData();
                    });
                    $scope.$on('$destroy', function () {
                        stop1();
                    });
                }
            };
        }])
        .directive('permissionGroup', ['$rootScope', function ($rootScope) {
            return {
                restrict: 'A',
                scope: {},
                template: '{{active.text}} <i class="dropdown icon"></i> <div class="menu"><a class="item" ui-sref="system/permission({group:v.id})" ng-repeat="v in list" ng-hide="v.id==$parent.active.id">{{v.text}}</a></div>',
                transclude: true,
                link: function ($scope, elem, attrs) {
                    var groupArray = [
                        {id: 'admin', text: '后台CMS'}
                    ];
                    $rootScope.$stateParams.group && angular.forEach(groupArray, function (v) {
                        if (v.id == $rootScope.$stateParams.group) {
                            $scope.active = v;
                            return true;
                        }
                    });
                    !$scope.active && ($scope.active = groupArray[0]);
                    $scope.list = groupArray;
                    $(elem).dropdown();
                }
            };
        }])
});