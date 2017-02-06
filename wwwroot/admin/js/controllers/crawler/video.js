/**
 * Created by Administrator on 2016/11/9.
 */
define(['application', 'dire/pagination'], function (application) {
    application.controller('crawler-video', ['$scope', '$http', '$compile', function ($scope, $http, $compile) {
        //分页配置
        $scope.pageConfig = {
            pagevar: 'page',
            listrows: 10,
            key: 'video_list'
        };

        var loadData = function () {
            $http.get(CONF.url('crawler/videoList'), {
                params: {
                    page: $scope.$stateParams.page || 1
                }
            })
                .success(function (json) {
                    $scope.list = json.data.list;
                    $scope.total_count = json.data.total_count;
                })
        };

        var stop1 = $scope.$parent.$on('reload-page-data', function (e, name) {
            name == $scope.pageConfig.key && loadData();
        });
        //数据销毁
        $scope.$on('$destroy', function () {
            stop1();
        });

        loadData();
    }])
});