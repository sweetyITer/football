/**
 * Created by chenmingming on 2016/8/7.
 */
define(['application', 'angular', 'fileinput', 'ajax-bootstrap-select', 'icheck'], function (application, angular) {
    application.controller('goods-add', ['$scope', '$http', '$compile', '$timeout', function ($scope, $http, $compile, $timeout) {
        $scope.$state.actName = 'goods/list';
        $scope.fileinputConfig = {
            uploadUrl: CONF.url('common/uploadimg') + '?dir=goods',
            allowedFileExtensions: ['jpg', 'png', 'gif', 'bmp'],
            maxFileSize: 2000000,
            maxFilesNum: 1
        };
        $scope.productImgConfig = {
            uploadUrl: CONF.url('common/uploadimg') + '?dir=goods',
            allowedFileExtensions: ['jpg', 'png', 'gif', 'bmp'],
            maxFileSize: 2000000,
            maxFilesNum: 1,
            showCaption: false
        };
        $scope.brandConfig = {
            url: CONF.url('brand/blist'),
            noneSelectText: '请选择品牌'
        };
        $scope.categoryConfig = {
            url: CONF.url('category/clist'),
            noneSelectText: '请选择分类'
        };

        /**
         * 该分类下集合列表
         * @type {Array}
         */
        $scope.attrsetList = [];
        $scope.loadGoods = function () {
            if ($scope.$stateParams.id) {
                $http.post(CONF.url('goods/detail'), {id: $scope.$stateParams.id})
                    .success(function (json) {
                        dealJson(json, function (json) {
                            $scope.goods = json.data.goods;
                            $scope.attrList = json.data.attrList;
                            $scope.products = json.data.productsList;
                            $scope.changeAttributeSet();
                            $timeout(function () {
                                //渲染分类和品牌
                                selectInit('goods.brand', $scope.goods.brand, $scope.goods.brandName);
                                selectInit('goods.category', $scope.goods.category, $scope.goods.categoryName);
                                $('.selectpicker').selectpicker('refresh');
                            })

                        })
                    })
            }
        };


        $scope.commit = function () {
            $http.post(CONF.url('goods/add'), $scope.goods)
                .success(function (json) {
                    dealJson(json, function (json) {
                        $scope.goods.id = json.data.id;
                        if ($scope.goods.attributeSetId > 0) {
                            $scope.saveProducts();
                        } else {
                            if (!$scope.$stateParams.id) {
                                $scope.$state.go('.', {id: json.data.id});
                            }
                            tip('保存成功');
                        }
                    })
                })
        };

        $scope.changeAttributeSet = function () {
            $http.post(CONF.url('attrset/listByCategory'), {
                categoryId: $scope.goods && $scope.goods.category,
                goodsId: $scope.goods && $scope.goods.id
            })
                .success(function (json) {
                    dealJson(json, function (json) {
                        $scope.attrsetList = json.data;
                        if ($scope.goods && $scope.goods.attributeSetId > 0) {
                            angular.forEach($scope.attrsetList, function (attrset) {
                                if (attrset.id == $scope.goods.attributeSetId) {
                                    $scope.goods.attributeSet = attrset;
                                    return true;
                                }
                            })
                        }
                        $timeout(function () {
                            $('select[ng-model="goods.attributeSet"]').selectpicker('refresh');
                        });
                    })
                })
        };

        $scope.saveProducts = function () {
            try {
                var styles = [], products = [], attrs = {}, i = 0, flag;
                angular.forEach($scope.goods.attributeSet.list, function (v) {
                    attrs[v.id] = '';
                    //默认false
                    flag = true;
                    angular.forEach(v.valuesArray, function (vv) {
                        if (vv.checked) {
                            flag = false;
                            styles.push({attrId: v.id, value: vv.text, id: vv.id});
                        }
                    });
                    if (flag) {
                        //说明该属性没有任何一个值是选中的
                        throw "请至少选一个属性 " + v.attrName + '的一个值~';
                    }
                });
                angular.forEach($scope.products, function (pro) {
                    i = 0;
                    if (!pro.product_sn) {
                        throw "请填写款式 " + pro.brief + ' 的货号';
                    }
                    if (pro.price < 0) {
                        throw "款式 " + pro.brief + ' 的差价不能小于0';
                    }
                    angular.forEach(attrs, function (text, key) {
                        attrs[key] = pro.style[i++];
                    });
                    pro.attrs = attrs;
                    products.push(angular.copy(pro));
                });

                $http.post(CONF.url('goods/updateProduct'), {
                    goods_id: $scope.goods.id,
                    styles: angular.toJson(styles),
                    products: angular.toJson(products),
                    attrset_id: $scope.goods.attributeSet.id
                })
                    .success(function (json) {
                        dealJson(json, function (json) {
                            if (!$scope.$stateParams.id) {
                                $scope.$state.go('.', {id: json.data.id});
                            }
                            tip('保存成功');
                        })
                    })
            } catch (e) {
                tip(e || e.message);
            }

        };

        //排雷组合算法
        $scope.conbination = function (array, deep) {
            if (array.length <= 0) {
                return [];
            }
            if (array.length == 1) {
                if (deep > 0) {
                    return array[0];
                }
                var arr = [];
                angular.forEach(array[0], function (v) {
                    arr.push([v]);
                });
                return arr;
            }
            var a, b, c = [], tmp;
            a = array.splice(0, 1)[0];
            b = array.splice(0, 1)[0];
            angular.forEach(a, function (aa) {
                angular.forEach(b, function (bb) {
                    if (deep > 0) {
                        tmp = angular.copy(aa);
                        tmp.push(bb);
                        c.push(tmp);
                    } else {
                        c.push([aa, bb]);
                    }
                })
            });
            array.splice(0, 0, c);
            return $scope.conbination(array, 1);
        };

        //初始化款式表格
        $scope.initAttrTable = function () {
            var arrs = [];
            $scope.products = [];
            if (!$scope.goods.attributeSet) {
                return false;
            }
            angular.forEach($scope.goods.attributeSet.list, function (v) {
                var tmp = [];
                angular.forEach(v.valuesArray, function (vv) {
                    vv.checked && tmp.push(vv.text);
                });
                tmp.length > 0 && arrs.push(tmp);
            });
            var styleList = $scope.conbination(arrs, 0);
            angular.forEach(styleList, function (style) {
                $scope.products.push({
                    style: style,
                    brief: style.join('、'),
                    product_sn: '',
                    stock: 0,
                    img: undefined,
                    price: 0
                });
            });
        };

        //初始化商品信息
        $scope.loadGoods();
        $scope.changeAttributeSet();
    }])
});