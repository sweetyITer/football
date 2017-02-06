/**
 * Created by chenmingming on 2016/8/7.
 */
define(['application', 'angular', 'dire/pagination'], function (application, angular) {
    application.controller('attr-set-list', ['$scope', '$http', '$compile', function ($scope, $http, $compile) {

        $scope.pageConfig = {
            key: 'attr-set-list',
            pagevar: 'p',
            listrows: '10'
        };


        var loadData = function () {
            $http.post(CONF.url('attrset/alist'), {p: $scope.$stateParams.p})
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

    }])
});