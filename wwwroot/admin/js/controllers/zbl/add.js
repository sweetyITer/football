/**
 * Created by chenmingming on 2016/10/24.
 */
define(['application', 'angular', 'fileinput', 'ajax-bootstrap-select', 'icheck'], function (application) {
    application.controller('zbl-add', ['$scope', '$http', function ($scope, $http) {
        $scope.types = [{name: '4图片推荐位', type: 'img-4'},
            {name: '广告推荐位', type: 'img-banner'},
            {name: '商品推荐位', type: 'banner'},
            {name: '商品群位', type: 'goods-group'}];
        $scope.fileinputConfig = {
            uploadUrl: CONF.url('common/uploadimg') + '?dir=goods',
            allowedFileExtensions: ['jpg', 'png', 'gif', 'bmp'],
            maxFileSize: 2000000,
            maxFilesNum: 1
        };
        $scope.content = [{}];
        $scope.keywords = [{}];
        $scope.typeChange = function (tpv) {
            console.log(tpv);
            if (tpv.type_select) {
                if (tpv.type_select.type == 'img-4') {
                    $scope.addContent(3);
                    $scope.state = 1;
                }
                if (tpv.type_select.type == 'img-banner' || tpv.type_select.type == 'goods-group') {
                    $scope.addContent(0);
                    $scope.state = 1;
                }
                if (tpv.type_select.type == 'banner') {
                    $scope.addContent(7);
                    $scope.addKetword(5);
                    $scope.status = 1;
                    $scope.state = 1;
                }
            }
        };
        $scope.addContent = function (num) {
            for (var i = 0; i < num; i++) {
                $scope.content.push({
                    'url': '',
                    'cover': '',
                    'heading': '',
                    'heading_url': '',
                    'price': ''
                })
            }
        };
        $scope.addKetword = function (num) {
            for (var i = 0; i < num; i++) {
                $scope.keywords.push({
                    'keyword': '',
                    'keyword_url': '',
                })
            }
        };
        $scope.commit = function () {
            console.log($scope.tpv.type_select.type);
            $scope.zbl.type = $scope.tpv.type_select.type;
            $scope.zbl.content = [
                {'img_info': $scope.conetent},
                {'keyword': $scope.keywords}
            ];
            console.log($scope.zbl);
            /* $http.post(CONF.url('zbl/add'), $scope.zbl)
             .success(function (json) {
             dealJson(json, function (json) {
             /!*if (!$scope.$stateParams.id) {
             $scope.$state.go('.', {id: json.data.id});
             }*!/
             tip('提交成功');
             })
             })*/
        }
    }])
});