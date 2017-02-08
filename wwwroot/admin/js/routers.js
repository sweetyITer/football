/**
 * Created by chenmingming on 2016/6/6.
 */
define(['application'], function (application) {
    application.run(['$state', '$stateParams', '$rootScope', function ($state, $stateParams, $rootScope) {
        $rootScope.$state = $state;
        $rootScope.$stateParams = $stateParams;
        $rootScope.$state.has = function (search) {
            return $rootScope.$state.current.name.indexOf(search) === 0 || search == $rootScope.$state.actName;
        };
        $rootScope.active = {};
    }]);
    application.config(['$stateProvider', '$urlRouterProvider', '$locationProvider', function ($stateProvider, $urlRouterProvider, $locationProvider) {
        $urlRouterProvider.otherwise('/');
        $stateProvider
            .state('index', {
                url: '/',
                templateUrl: CONF.tpl('index/index'),
                controllerUrl: 'ctrl/index',
                controller: 'index'
            })
            //权限列表
            .state('system/permission', {
                url: '/system-permission.html?group&page',
                templateUrl: CONF.tpl('system/permission'),
                controllerUrl: 'ctrl/system/permission',
                controller: 'system-permission'
            })
            //导航列表
            .state('system/nav', {
                url: '/system-nav.html',
                templateUrl: CONF.tpl('system/nav'),
                controllerUrl: 'ctrl/system/nav',
                controller: 'system-nav'
            })
            //管理员列表
            .state('system/master', {
                url: '/system-master.html?page',
                templateUrl: CONF.tpl('system/master'),
                controllerUrl: 'ctrl/system/master',
                controller: 'system-master'
            })
            //商品列表
            .state('goods/list', {
                url: '/goods/list.html?p&cid&bid',
                templateUrl: CONF.tpl('goods/list'),
                controllerUrl: 'ctrl/goods/list',
                controller: 'goods-list'
            })
            //商品列表
            .state('goods/add', {
                url: '/goods/add.html?id',
                templateUrl: CONF.tpl('goods/add'),
                controllerUrl: 'ctrl/goods/add',
                controller: 'goods-add'
            })
            .state('goods/attr-set', {
                url: '/attr-set/list.html?p',
                templateUrl: CONF.tpl('attr-set/list'),
                controllerUrl: 'ctrl/attr-set/list',
                controller: 'attr-set-list'
            })
            .state('goods/attr-set-add', {
                url: '/attr-set/add.html?id',
                templateUrl: CONF.tpl('attr-set/add'),
                controllerUrl: 'ctrl/attr-set/add',
                controller: 'attr-set-add'
            })
            .state('goods/banner', {
                url: '/goods/banner.html?id',
                templateUrl: CONF.tpl('goods/banner'),
                controllerUrl: 'ctrl/goods/banner',
                controller: 'goods-banner'
            })


        $locationProvider.html5Mode(true).hashPrefix('!');
    }]);

});