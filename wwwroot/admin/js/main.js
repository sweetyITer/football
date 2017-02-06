/**
 * Created by chenmingming on 2016/6/6.
 */
requirejs.config({
    //By default load any module IDs from js/lib
    baseUrl: '/js/',
    urlArgs: function (id, url) {
        var args = 'v=' + VERSION;
        if (url.indexOf('cdn.bootcss') !== -1) {
            args = '';
        }

        return (url.indexOf('?') === -1 ? '?' : '&') + args;
    },
    //except, if the module ID starts with "app",
    //load it from the js/app directory. paths
    //config is relative to the baseUrl, and
    //never includes a ".js" extension since
    //the paths config could be for a directory.
    paths: {
        "jquery": [
            '//cdn.sdxapp.com/libs/tools/jquery.min'
        ],
        "angular": [
            '//cdn.sdxapp.com/libs/tools/angular.min'
        ],
        "angular-ui-router": [
            "//cdn.sdxapp.com/libs/tools/angular-ui-router.min"
        ],
        "ctrl": 'controllers',
        "srv": 'services',
        "dire": 'directives',
        "jquery-ui": '//cdn.sdxapp.com/libs/jquery-ui/jquery-ui.min',
        'angular-async-loader': '//cdn.sdxapp.com/libs/angular/angular-async-loader.min',
        'bootstrap': [
            '//cdn.sdxapp.com/libs/tools/bootstrap-3.3.0/js/bootstrap.min'
        ],
        'datetimepicker': [
            '//cdn.sdxapp.com/libs/jquery-ui/jquery-ui-timepicker-addon.min'
        ],
        'bootstrap-datetimepicker': [
            '//cdn.sdxapp.com/libs/tools/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min'
        ],
        'datetimepicker-zhCN':[
            '//cdn.sdxapp.com/libs/tools/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN'
        ],
        'fileinput': [
            '//cdn.sdxapp.com/libs/tools/fileinput.min'
        ],
        'daterange-moment': '//cdn.sdxapp.com/libs/tools/moment.min',
        'daterange': [
            '//cdn.sdxapp.com/libs/tools/daterangepicker'
        ],
        'ajax-bootstrap-select': [
            '//cdn.sdxapp.com/libs/tools/ajax-bootstrap-select.min'
        ],
        'icheck': [
            '//cdn.sdxapp.com/libs/icheck-1.02/icheck.min'
        ],
        'bootstrap-select': [
            '//cdn.sdxapp.com/libs/tools/bootstrap-select.min'
        ]
    },
    shim: {
        "daterange": ['daterange-moment'],
        "functions": ["jquery"],
        'angular': {
            exports: 'angular',
            deps: ['jquery']
        },
        'angular-ui-router': {
            deps: ["angular"]
        },
        'ajax-bootstrap-select': {
            deps: ['bootstrap-select']
        },
        'datetimepicker-zhCN':{
            deps:['bootstrap-datetimepicker']
        },
        'jquery-ui': ['jquery'],
        'bootstrap': ['jquery'],
        'datetimepicker': ['jquery-ui'],
        'config': {
            deps: ['angular'],
            exports: 'config'
        }
    }
});

// Start the main app logic.
requirejs(['jquery', 'angular', 'bootstrap', 'angular-ui-router', 'routers', 'dire/main', 'ajax-loading', 'application'],
    function ($, angular) {
        $(function () {
            angular.bootstrap(document, ['application'])
        });
    });