/**
 * Created by chenmingming on 2016/10/24.
 */
define(['application', 'angular', 'fileinput', 'ajax-bootstrap-select', 'icheck'], function (application) {
    application.controller('zbl-add', ['$scope', '$http', function ($scope, $http) {
        $scope.zbl = {};
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
        $scope.typeChange = function (tpv) {
            $scope.imgInfo = [{}];
            $scope.keywords = [{}];
            $scope.state = 0;
            $scope.status = 0;
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
                $scope.imgInfo.push({})
            }
        };
        $scope.addKetword = function (num) {
            for (var i = 0; i < num; i++) {
                $scope.keywords.push({})
            }
        };
        $scope.commit = function () {
            $scope.zbl.type = $scope.tpv.type_select.type;
            if ($scope.zbl.type = 'banner') {
                $scope.zbl.content = [
                    {'img_info': $scope.imgInfo},
                    {'keyword': $scope.keywords}
                ];
            } else {
                $scope.zbl.content = [{'img_info': $scope.imgInfo}];
            }
            console.log($scope.zbl.content);
            $http.post(CONF.url('zbl/add'), $scope.zbl)
                .success(function (json) {
                    dealJson(json, function (json) {
                        tip('提交成功');
                    })
                })
        }
    }])
});