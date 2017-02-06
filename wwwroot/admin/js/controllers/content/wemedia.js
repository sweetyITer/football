/**
 * Created by chenmingming on 2016/8/7.
 */
define(['application', 'dire/pagination'], function (application) {
    application.controller('content-wemedia', ['$scope', '$http', '$compile', function ($scope, $http, $compile) {
        //分页配置
        $scope.pageConfig = {
            pagevar: 'page',
            listrows: 10,
            key: 'wemedia'
        };

        //加载列表数据
        var loadData = function () {
            $http.post(CONF.url('content/wemediaList'))
                .success(function (json) {
                    $scope.list = json.data.data;
                })
        };

        //删除提示
        $scope.remove = function (v) {
            $('body').append($compile('<ui-confirm data-title="确定要删除吗？" on-approve="delete(' + v.id + ')"></ui-confirm>')($scope))
        };

        //删除
        $scope.delete = function (id) {
            $http.post(CONF.url('content/wemediaDel'), {id: id})
                .success(function (json) {
                    dealJson(json, loadData);
                })
        };

        //添加，更新
        $scope.add = function (model) {
            $scope.editModel = model;
            $('body').append($compile('<wemedia-model data="editModel"></wemedia-model>')($scope));
        };
        //监听
        $scope.$on('reload-data', function () {
            loadData();
        });

        loadData();
    }])

        .directive('wemediaModel', ['$http', function ($http) {
            return {
                restrict: 'E',
                replace: true,
                scope: {
                    data: '='
                },
                templateUrl: CONF.tpl('content/wemedia-model'),
                link: function ($scope, elem, link) {
                    $scope.submit = function () {
                        $scope.is_submit = true;
                        $http.post(CONF.url('content/wemediaAdd'), {
                            id: $scope.data.id || 0,
                            name: $scope.data.name,
                            icon: $scope.data.icon
                        })
                            .success(function (json) {
                                $scope.$emit('reload-data');
                                $(elem).modal('hide');
                            })
                    };

                    $scope.imgParams = {dir: 'nav'};
                }
            };
        }])
});