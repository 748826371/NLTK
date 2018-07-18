/**
 * 入口JS
 * 定义路由
 */

var news = angular.module('news', ['ui.router']);
// 定义路由
news.config(function($stateProvider, $urlRouterProvider){
	// 默认配置 默认回到首页
	$urlRouterProvider.otherwise('/');
	// 定义路由 设置状态
	$stateProvider
		.state('/', {

		})
		.state('list', { // 菜单列表页
			url : '/list/{id}',
			templateUrl : 'views/list.html'
		})
		.state('detail', { // 文章详情页
			url : '/detail/{id}',
			templateUrl : 'views/detail.html'
		})
		.state('detailTest', {
			url : '/detail/{id}',
			templateUrl : 'detailTest.html'
		})
		.state('listtest', {
			url : '/listTest/{id}',
			templateUrl : 'listTest.html'
		});
});
