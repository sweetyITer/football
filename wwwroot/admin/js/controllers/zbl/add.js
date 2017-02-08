/**
 * Created by chenmingming on 2016/10/24.
 */
define(['application'], function (application) {
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
    }])
});