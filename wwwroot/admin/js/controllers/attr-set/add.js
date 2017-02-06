/**
 * Created by chenmingming on 2016/8/7.
 */
define(['application', 'angular', 'ajax-bootstrap-select'], function (application, angular) {
    application.controller('attr-set-add', ['$scope', '$http', '$compile', '$timeout', function ($scope, $http, $compile, $timeout) {
        $scope.attrset = {
            list: []
        };
        $scope.loadData = function () {
            if ($scope.$stateParams.id) {
                $http.post(CONF.url('attrset/detail'), {id: $scope.$stateParams.id})
                    .success(function (json) {
                        dealJson(json, function (json) {
                            $scope.attrset = json.data;
                            $timeout(function () {
                                selectInit('attrset.categoryId', $scope.attrset.categoryId, $scope.attrset.categoryName);
                                $('.selectpicker').selectpicker('refresh');
                            });


                        })
                    })
            }
        };
        $scope.categoryConfig = {
            url: CONF.url('category/clist'),
            noneSelectText: '请选择分类'
        };

        $scope.commit = function () {
            $http.post(CONF.url('attrset/add'), $scope.attrset)
                .success(function (json) {
                    dealJson(json, function (json) {
                        if (!$scope.$stateParams.id) {
                            $scope.$state.go('.', {id: json.data.id});
                        }
                        tip('提交成功');
                    })
                })
        };

        $scope.addAttribute = function () {
            $scope.attrset.list.push({
                name: '',
                attrInputType: 'select'
            });
        };
        $scope.remove = function ($index) {
            $scope.attrset.list.splice($index, 1);
        };

        //初始化商品信息
        $scope.loadData();

    }])
});