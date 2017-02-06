/**
 * Created by chenmingming on 2016/7/4.
 */
define(['application'], function (application) {
    application
        .factory('$page', ['$rootScope', function ($rootScope) {
            var PAGE = function () {
                this.pagevar = 'page';
                this.listrows = 10;
                this.coolpage = 5;
                this.key = 'page';
            };
            PAGE.prototype = {
                init: function (total, key) {
                    key && (this.key = key);
                    this.total = parseInt(total) || 0;
                    this.page = Math.max(parseInt($rootScope.$stateParams[this.pagevar]), 1) || 1;

                    this.is_show = true;
                    this.total <= 0 && (this.is_show = false);
                    this.lastpage = this.pages = Math.ceil(this.total / this.listrows);
                    this.page > this.lastpage && (this.page = this.lastpage);

                    this.list = [];
                    if (this.is_show) {
                        var ceil_now_coolpage, i, p;
                        ceil_now_coolpage = Math.ceil(this.coolpage / 2);
                        for (i = 1; i <= this.coolpage; i++) {
                            if ((this.page - ceil_now_coolpage) <= 0) {
                                p = i;
                            } else if ((this.page + ceil_now_coolpage ) >= this.pages) {
                                p = this.pages - this.coolpage + i;
                            } else {
                                p = this.page - ceil_now_coolpage + i;
                            }
                            if (p >= 1 && p <= this.pages)
                                this.list.push(p);
                        }
                    }
                },
                selectPage: function (page) {
                    page < 1 && (page = 1);
                    page > this.pages && (page = this.pages);
                    if (this.page == page) {
                        return false;
                    }
                    $rootScope.$stateParams[this.pagevar] = page;
                    $rootScope.$state.go('.', $rootScope.$stateParams, {notify: false});
                    this.init(this.total);
                    $rootScope.$emit('reload-page-data', this.key);
                }
            };
            return PAGE;
        }])
        .directive('pagination', ['$page', function ($page) {
            return {
                restrict: 'E',
                replace: true,
                scope: {
                    total: '=',
                    config: '='
                },
                template: '<div class="pagination" ng-show="total>0">'
                + '<li><span>共 {{total}} 条记录</span></li>'
                + '<li ng-class="{active:P.page==1}" ng-click="P.selectPage(1);"><a href="#">首页</a></li>'
                + '<li ng-show="P.page > 1" ng-click="P.selectPage(P.page-1);"><a href="#">«</a></li>'
                + '<li  ng-class="{active:listp == P.page}" ng-click="P.selectPage(listp);" ng-repeat="listp in P.list"><a href="javascript:;">{{listp}}</a></li>'
                + '<li  ng-show="P.lastpage > P.page" ng-click="P.selectPage(P.page+1);"><a href="#">»</a></li>'
                + '<li ng-class="{active:P.lastpage == P.page}" ng-click="P.selectPage(P.lastpage);"><a href="#">尾页</a></li></div>',
                link: function ($scope) {

                    $scope.P = new $page();
                    $scope.$watch('total', function () {
                        if ($scope.total !== undefined) {
                            $scope.config && ($scope.P = $.extend($scope.P, $scope.config));
                            $scope.P.init($scope.total, $scope.config.key);
                        }
                    })

                }
            };
        }])
});