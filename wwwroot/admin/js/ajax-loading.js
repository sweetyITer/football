/**
 * Created by chenmingming on 2016/10/24.
 */

define(['jquery', 'angular'], function ($, angula) {
    angular.module('ajaxLoading', [])
        .config(function ($httpProvider, $provide) {
            // Use x-www-form-urlencoded Content-Type
            $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
            $httpProvider.defaults.headers.post['X-Requested-With'] = 'XMLHttpRequest';
            /**
             * The workhorse; converts an object to x-www-form-urlencoded serialization.
             * @param {Object} obj
             * @return {String}
             */
            var param = function (obj) {
                var query = '', name, value, fullSubName, subName, subValue, innerObj, i;

                for (name in obj) {
                    value = obj[name];

                    if (value instanceof Array) {
                        for (i = 0; i < value.length; ++i) {
                            subValue = value[i];
                            fullSubName = name + '[' + i + ']';
                            innerObj = {};
                            innerObj[fullSubName] = subValue;
                            query += param(innerObj) + '&';
                        }
                    }
                    else if (value instanceof Object) {
                        for (subName in value) {
                            subValue = value[subName];
                            fullSubName = name + '[' + subName + ']';
                            innerObj = {};
                            innerObj[fullSubName] = subValue;
                            query += param(innerObj) + '&';
                        }
                    }
                    else if (value !== undefined && value !== null)
                        query += encodeURIComponent(name) + '=' + encodeURIComponent(value) + '&';
                }

                return query.length ? query.substr(0, query.length - 1) : query;
            };
            // Override $http service's default transformRequest
            $httpProvider.defaults.transformRequest = [function (data) {
                return angular.isObject(data) && String(data) !== '[object File]' ? param(data) : data;
            }];
            $httpProvider.interceptors.push('loadingInterceptor');
        })
        .directive('loading', ['$rootScope', '$timeout', function ($rootScope, $timeout) {
            return {
                replace: true,
                restrict: 'AE',
                template: '<div class="loading-style"><div class="progress" style="height: 8px;"><div class="progress-bar  progress-bar-striped" ng-class="class" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" ng-style="{width:percent}"><span class="sr-only">{{percent}} Complete</span> </div></div></div>',
                link: function (scope, elem) {
                    $rootScope.is_loading = 0;
                    var percent = 0, int, obj = $('.progress', elem);
                    $rootScope.$watch('is_loading', function () {
                        int > 0 && clearInterval(int);
                        if ($rootScope.is_loading != 0) {
                            if (percent == 100) {
                                percent = parseInt(Math.random() * 100) % 50;
                            }
                            scope.percent = percent + '%';
                            scope.class = 'progress-bar-danger';
                            obj.show();
                            int = setInterval(function () {
                                percent = percent + parseInt(Math.random() * 100) % 20;
                                if (percent > 50) {
                                    scope.class = 'progress-bar-warning';
                                }
                                if (percent > 80) {
                                    scope.class = 'progress-bar-success';
                                }
                                if (percent > 90) {
                                    percent = 90
                                }
                                scope.percent = percent + '%';
                                scope.$apply();
                            }, 500);
                        } else {
                            percent = 100;
                            scope.percent = 100 + '%';
                            $timeout(function () {
                                obj.hide();
                            })
                        }
                    })
                }
            };
        }])

        .factory('loadingInterceptor', function ($q, $rootScope) {
            $rootScope.logout = function () {
                window.location.href = '/login.html';
            };
            return {
                request: function (config) {
                    $rootScope.is_loading++;
                    config.method == 'GET' && (config.headers['X-Requested-With'] = 'XMLHttpRequest');
                    return config || $q.when(config);
                },
                response: function (response) {
                    $rootScope.is_loading--;
                    if (response.data.code && response.data.code.toString().indexOf('REQUIRE_LOGGED') == 0) {
                        //劫持未登录状态的页面
                        clearAllCookie();
                        window.location.href = '/login.html?redirect=' + encodeURIComponent(window.location.href);
                    } else {
                        return response || $q.when(response);
                    }
                },
                responseError: function (rejection) {
                    $rootScope.is_loading--;
                    return $q.reject(rejection);
                }
            };
        });
})