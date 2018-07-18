/**
 * 自定义服务
 */

/**
 * 分类菜单服务
 */

 news.factory('List', function($http){
 	var obj = {
 		data : {},
 		getListById : function(id){
 			return $http({url : 'http://localhost/index.php?g=Portal&m=list&a=ngList&id=' + id, method : 'get', cache : true});
 		},
 		getTermDetailById : function(id){
 			return $http({url : 'http://localhost/index.php?g=Portal&m=list&a=ngDetail&id=' + id, method : 'get', cache : true});
 		},
 		getSiblingsById : function(id){
 			return $http({url : 'http://localhost/index.php?g=Portal&m=list&a=ngSiblings&id=' + id, method : 'get', cache : true});
 		}
 	};
 	return obj;
 });
 news.factory('Detail', function($http){
 	var obj = {
 		data : {},
 		getDetailById : function(id){
 			return $http({url : 'http://localhost/index.php?g=Portal&m=article&a=ngArticle&id=' + id, method : 'get', cache : true});
 		}
 		// getTermDetailById : function(id){
 		// 	return $http({url : 'http://localhost/index.php?g=Portal&m=list&a=ngDetail&id=' + id, method : 'get'});
 		// }
 	};
 	return obj;
 });