/**
 * 控制器文件
 */

 /**
  * 菜单控制器
  */

 /**
  * 文章列表控制器
  * 注意执行的顺序
  * 先执行除了服务之外的东西
  */
news.controller('listController', function($scope, $state, $stateParams, List){
  var cid = $stateParams.id;
  console.log('分类ID是' + $stateParams.id);
  //cid = 5;
  // 分类名字
  $scope.term = {};
  var data = {};
  List.getTermDetailById(cid).then(function(responce){
    console.log('cid是' + cid);
    data = responce.data;;
    if(data.status == 0) { // 没有找到数据
      alert(data.referer);
      $state.go('/'); // 返回首页
    } else if(data.status == 1) {
      $scope.term.name = data.info.name; // 分类名称
       $scope.newsList = {};
      // 获取文章列表    
      List.getListById(cid).then(function(responce){
        var data = responce.data;
        var status = data.status;
        if(status == 0) {
          $scope.newsList.status = 0;
          $scope.newsList.info = data.referer;
        } else if(status == 1) {
         // $scope.newsList.status = 1;
          $scope.newsList.list = data.info;
        }
      });  
      // 获取同类菜单
      List.getSiblingsById(cid).then(function(responce){
        var data = responce.data;
        var status = data.status;
        if(status == 0) {
          $scope.newsList.status = 0;
          $scope.newsList.info = data.referer;
        } else if(status == 1) {
         // $scope.newsList.status = 1;
          $scope.newsList.Siblings = data.info;
        }       
      });    
    }
  });
});
 /**
  * 文章详情控制器
  */
news.controller('detailController', function($scope, $state, $stateParams, Detail){
  var tid = $stateParams.id;
  $scope.article = {};
  Detail.getDetailById(tid).then(function(responce){
    var data = responce.data;
    
    if(data.status == 1){
      $scope.article.content = data.info.post_content;
    } else {

    }
  });
});