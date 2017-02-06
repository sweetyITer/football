/**
 * Created by chenmingming on 2016/7/2.
 */
define(['application'], function (application) {
    return application
    //下拉菜单
        .directive('jqueryChosen', ['$timeout', function ($timeout) {
            return {
                restrict: 'A',
                link: function ($scope, elem, attrs) {
                    $timeout(function () {
                        if (!attrs.config) {
                            attrs.config = {};
                        }
                        $(elem).chosen(attrs.config);
                    });
                }
            };
        }])


        .directive('uiModal', function () {
            return {
                restrict: 'A',
                link: function ($scope, elem, attrs) {
                    $(elem)
                        .modal({
                            onHide: function () {
                                if (attrs.onHide) {
                                    return $scope.$apply(function () {
                                        $scope.$eval(attrs.onHide)
                                    });
                                } else {
                                    return true;
                                }
                            },
                            onDeny: function () {
                                if (attrs.onDeny) {
                                    return $scope.$apply(function () {
                                        $scope.$eval(attrs.onDeny)
                                    });
                                } else {
                                    return true;
                                }
                            },
                            onApprove: function () {
                                if (attrs.onApprove) {
                                    return $scope.$apply(function () {
                                        return $scope.$eval(attrs.onApprove);
                                    });
                                } else {
                                    return true;
                                }
                            }
                        });
                    if (attrs.show != 'false') {
                        $(elem).modal('show');
                    }

                    $scope.$on('close-modal', function () {
                        $(elem).modal('hide');
                    })
                }
            };
        })
        .directive('inputFile', function () {
            return {
                restrict: 'E',
                template: '<input type="file" />',
                replace: true,
                link: function (scope, elem) {
                    $(elem).bind("change", function (changeEvent) {
                        if (changeEvent.target.files) {
                            var reader = new FileReader();
                            reader.onload = function (loadEvent) {
                                scope.$apply(function () {
                                    scope.uploadfile = loadEvent.target.result.replace(/\+/g, '_');
                                });
                            };
                            reader.readAsDataURL(changeEvent.target.files[0]);
                        }
                    });
                }
            };
        })
        .directive('initNavbar', ['$http', '$rootScope', '$timeout', function ($http, $rootScope, $timeout) {
            return {
                restrict: 'A',
                link: function ($scope) {
                    $http.get(CONF.url('common/userinfo'))
                        .success(function (json) {
                            $rootScope.master = json.data;
                        });
                    var loadData = function () {
                        $http.get(CONF.url('common/navlist'))
                            .success(function (json) {
                                dealJson(json, function (json) {
                                    $rootScope.navlist = json.data;
                                })
                            });
                    };
                    $scope.$on('reload-navlist', function () {
                        loadData();
                    });

                    loadData();
                    $scope.jump = function (url) {
                        if (url.toString().indexOf('http://') == 0) {
                            window.location.href = url;
                        } else {
                            $rootScope.$state.go(url);
                        }
                    }
                }
            };
        }])
        .directive('datepicker', function () {
            return {
                restrict: 'A',
                require: 'ngModel',
                link: function ($scope, elem, attrs, ngModelCtrl) {
                    var options = {
                        dateFormat: attrs.format || 'yy/mm/dd',
                        onSelect: function (dateText) {
                            $scope.$apply(function () {
                                ngModelCtrl.$setViewValue(dateText);
                                if (attrs.onselect) {
                                    $scope.$eval(attrs.onselect);
                                }
                            });
                        }
                    };
                    if (attrs.minDate) {
                        options.minDate = attrs.minDate;
                    }
                    $(elem).datepicker(options);
                }
            }
        })
        .directive('datetimepicker', function () {
            return {
                restrict: 'A',
                require: 'ngModel',
                link: function ($scope, elem, attrs, ngModelCtrl) {
                    var options = {
                        format: attrs.format || 'yyyy-mm-dd',
                        stepHour: 1,
                        minView:2,
                        stepMinute: 5,
                        showHour: false,
                        showMinute: false,
                        autoclose:true,
                        language:'zh-CN',
                        startDate:new Date(),
                    };
                    $(elem).datetimepicker(options);
                }
            }
        })
        //格式化价格
        .directive('priceFormat', function () {
            //格式化input框中的合法价格
            return {
                require: 'ngModel',
                link: function (scope, elem, attrs, ngModelCtrl) {
                    ngModelCtrl.$parsers.push(function (value) {
                        return '' + value;
                    });
                    ngModelCtrl.$formatters.push(function (value) {
                        return parseFloat(value);
                    });
                }
            };
        })
        .directive('dragX', function () {
            return {
                restrict: 'A',
                link: function ($scope, elem, attrs) {
                    var start = false;
                    var nowX, scrollLeft, minX, maxX, minY, maxY;
                    $(elem).css({
                        '-moz-user-select': 'none',
                        '-webkit-user-select': 'none',
                        '-ms-user-select': 'none',
                        'user-select': 'none',
                        'cursor': 'pointer',
                    })
                    ;
                    var parent = $(elem).parent();
                    minX = parent.offset().left;
                    maxX = minX + parent.width();
                    minY = parent.offset().top;
                    maxY = parent.height() + minY;
                    var first = false;
                    var loadConfig = function () {
                        minX = parent.offset().left;
                        maxX = minX + parent.width();
                        minY = parent.offset().top;
                        maxY = parent.height() + minY;
                        first = true;
                    };

                    parent.bind('dragstart', function () {
                        return false;
                    });
                    $(document).mousemove(function (e) {
                        if (!start) {
                            return false;
                        }
                        if (e.clientX > maxX || e.clientX < minX || e.clientY < minY || e.clientY > maxY) {
                            start = false;
                        }
                    });
                    $(elem).mousedown(function (e) {
                        !first && loadConfig();
                        if (start) {
                            return false;
                        }
                        nowX = e.clientX;
                        scrollLeft = parent.scrollLeft();
                        start = true;
                    });
                    $(elem).mousemove(function (e) {
                        if (!start) {
                            return false;
                        }
                        var space = nowX - e.clientX;
                        parent.scrollLeft(space + scrollLeft);
                        scrollLeft = space + scrollLeft;
                        nowX = e.clientX;
                    })
                    $(elem).mouseup(function (e) {
                        if (!start) {
                            return false;
                        }
                        start = false;
                    })
                }
            };
        })
        .filter('default', function () {
            return function (input, default_text) {
                if (!input || input == '￥0.00') {
                    return default_text;
                }
                return input;
            };
        })
        .filter('textover', function () {
            return function (input, limit) {
                if (input && input.toString().length > limit) {
                    input = input.toString().substr(0, limit - 1) + '...';
                }
                return input;
            };
        })
        .filter('date2str', function () {
            return function (date, default_text) {
                if (!arguments.length) return '';
                var timestamp = new Date(date).getTime();
                var arg = arguments,
                    now = arg[1] ? arg[1] : new Date().getTime(),
                    diffValue = now - timestamp,
                    result = '',

                    minute = 1000 * 60,
                    hour = minute * 60,
                    day = hour * 24,
                    month = day * 30,
                    year = month * 12,

                    _year = diffValue / year,
                    _month = diffValue / month,
                    _week = diffValue / (7 * day),
                    _day = diffValue / day,
                    _hour = diffValue / hour,
                    _min = diffValue / minute;

                if (_year >= 1) result = parseInt(_year) + "年前";
                else if (_month >= 1) result = parseInt(_month) + "个月前";
                else if (_week >= 1) result = parseInt(_week) + "周前";
                else if (_day >= 1) result = parseInt(_day) + "天前";
                else if (_hour >= 1) result = parseInt(_hour) + "个小时前";
                else if (_min >= 1) result = parseInt(_min) + "分钟前";
                else result = "刚刚";
                return result;
            };
        })
        .directive('fileInput', [function () {
            return {
                restrict: 'A',
                link: function ($scope, elem, attrs) {
                    $(elem).fileinput({
                        uploadUrl: CONF.url('common/uploadImg'),
                        allowedFileExtensions: (attrs.allowedExt && attrs.allowedExt.split(',')) || ['jpg', 'png', 'gif', 'bmp'],
                        maxFileSize: attrs.maxFileSize || 2048000,
                        maxFilesNum: attrs.maxFilesNum || 1
                    });

                    $(elem).on("fileuploaded", function (event, data, previewId, index) {
                        dealJson(data.response, function (json) {
                            $scope.$apply(function () {
                                $scope.$broadcast(attrs.signal, json);
                            });
                        });
                    });
                }
            };
        }])
        .directive('imgUploader', [function () {
            return {
                restrict: 'E',
                scope: {
                    imgModel: '=',
                    params: '='
                },
                replace: true,
                templateUrl: CONF.tpl('public/img-uploader'),
                link: function ($scope, elem, attrs) {
                    $scope.imgModel && ($scope.imgThumb = $scope.imgModel + '@150w');

                    var data = new FormData();
                    angular.forEach($scope.params, function (v, k) {
                        data.append(k, v);
                    });
                    $scope.choose = function () {
                        $('input[type=file]', elem).click()
                    };

                    $('input[type=file]', elem).change(function () {
                        data.append('file', $('input[type=file]', elem)[0].files[0]);
                        $.ajax({
                            url: CONF.url('common/uploadImg'),
                            type: 'POST',
                            data: data,
                            processData: false,
                            contentType: false
                        }).done(function (json) {
                            dealJson(json, function (json) {
                                $scope.$apply(function () {
                                    $scope.imgModel = json.data;
                                    $scope.imgThumb = $scope.imgModel + '@150w';
                                })
                            })
                        });
                    })
                }
            };
        }])
        //文件上传 bootstrap空间  必须引入相关css和js
        .directive('fileInput', function () {
            return {
                restrict: 'A',
                link: function ($scope, elem, attrs) {
                    var config = $scope.$eval(attrs.config) || false;
                    if (config === false) {
                        console.error('file input need config!');
                        return false;
                    }
                    config = $.extend({
                        removeLabel: '移除',
                        uploadLabel: '上传',
                        browseLabel: '选择图片',
                        dropZoneTitle: '拖放文件到此处...'
                    }, config);
                    var mutilple = $(elem).attr('mutiple') !== undefined;
                    if (mutilple) {
                        $scope.$eval($(elem).attr('ng-model') + '=[];');
                    }
                    $(elem).fileinput(config);
                    $(elem).on("fileuploaded", function (event, data) {
                        $scope.$apply(function () {
                            dealJson(data.response, function (json) {
                                if (mutilple) {
                                    $scope.$eval($(elem).attr('ng-model') + '.push("' + json.url + '")');
                                } else {
                                    $scope.$eval($(elem).attr('ng-model') + '="' + json.url + '"');
                                }

                            })
                        });
                    });
                }
            };
        })
        .directive('fileInputAvatar', function () {
            return {
                restrict: 'A',
                link: function ($scope, elem, attrs) {
                    var default_img = $scope.$eval(attrs.ngModel) || '//cdn.sdxapp.com/images/default_avatar_male.jpg';
                    var config = $scope.$eval(attrs.config) || false;
                    if (config === false) {
                        console.error('file input need config!');
                        return false;
                    }
                    config = $.extend({
                        overwriteInitial: true,
                        maxFileSize: 1500,
                        showClose: false,
                        showCaption: false,
                        browseLabel: '',
                        removeLabel: '',
                        browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
                        removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
                        removeTitle: '重置',
                        elErrorContainer: '#kv-avatar-errors-1',
                        msgErrorClass: 'alert alert-block alert-danger',
                        defaultPreviewContent: '<img src="' + default_img + '" alt="Your Avatar" style="width:100px">',
                        layoutTemplates: {main2: '{preview} {remove} {browse}'},
                        allowedFileExtensions: ["jpg", "png", "gif"]
                    }, config);
                    $(elem).fileinput(config);
                    $(elem).on("fileuploaded", function (event, data) {
                        $scope.$apply(function () {
                            dealJson(data.response, function (json) {
                                $scope.$eval($(elem).attr('ng-model') + '="' + json.url + '"');
                            })
                        });
                    });
                }
            };
        })


        .directive('icheck', ['$timeout', function ($timeout) {
            return {
                restrict: 'A',
                require: 'ngModel',
                link: function ($scope, element, $attrs, ngModel) {
                    return $timeout(function () {
                        var value;
                        value = $attrs['value'];

                        $scope.$watch($attrs['ngModel'], function (newValue) {
                            $(element).iCheck('update');
                        });

                        return $(element).iCheck({
                            checkboxClass: 'icheckbox_square-green',
                            radioClass: 'iradio_square-green',
                            increaseArea: '20%' // optional
                        }).on('ifChanged', function (event) {
                            if ($(element).attr('type') === 'checkbox' && $attrs['ngModel']) {
                                $scope.$apply(function () {
                                    return ngModel.$setViewValue(event.target.checked);
                                });
                            }
                            if ($(element).attr('type') === 'radio' && $attrs['ngModel']) {
                                return $scope.$apply(function () {
                                    return ngModel.$setViewValue(value);
                                });
                            }
                        });
                    });
                }
            }
        }
        ])
        .directive('bootstrapSelect', ['$timeout', function ($timeout) {
            return {
                restrict: 'A',
                link: function ($scope, elem, attrs) {
                    var config = {};
                    if (attrs.config) {
                        config = $scope.$eval(attrs.config);
                    }

                    $timeout(function () {
                        $(elem).selectpicker({noneSelectedText: config.noneSelectText || '请选择'});
                    })
                }
            }
        }])
        .directive('ajaxSelect', ['$timeout', function ($timeout) {
            return {
                restrict: 'A',
                link: function ($scope, elem, attrs) {

                    if (!attrs.config) {
                        console.error('missing config');
                        return;
                    }
                    var config = $scope.$eval(attrs.config);

                    var options = {
                        ajax: {
                            url: config.url,
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                q: '{{{q}}}'
                            }
                        },
                        locale: {
                            emptyTitle: config.emptyTitle,
                            statusInitialized: config.statusInitialized || '请输入查询关键字',
                            statusNoResults: '没有匹配的内容',
                            statusSearching: '查找中...',
                            searchPlaceholder: '关键字',
                            currentlySelected: '当前选择'
                        },
                        preprocessData: function (data) {
                            data = data.data;
                            var i, l = data.length, array = [];
                            if (l) {
                                for (i = 0; i < l; i++) {
                                    array.push($.extend(true, data[i], {
                                        text: data[i].text,
                                        value: data[i].id
                                    }));
                                }
                            }
                            return array;
                        }
                    };
                    $timeout(function () {
                        $(elem).selectpicker({noneSelectedText: config.noneSelectText || '请选择'}).ajaxSelectPicker(options);
                    })

                }
            };
        }])
        .directive('modalDialog', function () {
            return {
                restrict: 'A',
                link: function ($scope, elem, attr) {
                    $(elem).modal();
                }
            };
        })
})
;