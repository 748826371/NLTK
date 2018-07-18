<?php if (!defined('THINK_PATH')) exit(); function _sp_helloworld(){ echo "hello ThinkCMF!"; } function _sp_helloworld2(){ echo "hello ThinkCMF2!"; } function _sp_helloworld3(){ echo "hello ThinkCMF3!"; } function sp_get_breadcrumb($term_id){ $terms_model= M("Terms"); $data=array(); $path=$terms_model->where(array('term_id'=>$term_id))->getField('path'); if(!empty($path)){ $parents=explode('-', $path); if(!empty($parents)){ $data=$terms_model->where(array('term_id'=>array('in',$parents)))->order('path ASC')->select(); } } return $data; } ?>
<?php $portal_index_lastnews="2"; $portal_hot_articles="4,5,6,10,11,13"; $portal_last_post="1,2"; $portal_index_news = [ '武汉大学' => 5, '南京大学' => 6, '华中师范大学' => 4, '科研' => 9 ]; $tmpl=sp_get_theme_path(); $default_home_slides=array( array( "slide_name"=>"ThinkCMFX2.1.0发布啦！", "slide_pic"=>$tmpl."Public/images/demo/1.jpg", "slide_url"=>"", ), array( "slide_name"=>"ThinkCMFX2.1.0发布啦！", "slide_pic"=>$tmpl."Public/images/demo/2.jpg", "slide_url"=>"", ), array( "slide_name"=>"ThinkCMFX2.1.0发布啦！", "slide_pic"=>$tmpl."Public/images/demo/3.jpg", "slide_url"=>"", ), ); ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1 , user-scalable=no">
	<title>NLTK网站模板</title>
	<link rel="stylesheet" href="/themes/simplebootx_nltk/Public/css/bootstrap.min.css"/>
	<link rel="stylesheet" href="/themes/simplebootx_nltk/Public/css/slippry/slippry.css" />
	<script src="/themes/simplebootx_nltk/Public/js/jquery.js"></script>
	<script src="/themes/simplebootx_nltk/Public/js/bootstrap.min.js"></script>
	<style type="text/css">
			<style>
			.caption-wraper{position: absolute;left:50%;bottom:2em;}
			.caption-wraper .caption{
			position: relative;left:-50%;
			background-color: rgba(0, 0, 0, 0.54);
			padding: 0.4em 1em;
			color:#fff;
			-webkit-border-radius: 1.2em;
			-moz-border-radius: 1.2em;
			-ms-border-radius: 1.2em;
			-o-border-radius: 1.2em;
			border-radius: 1.2em;
			}
			@media (max-width: 767px){
				.sy-box{margin: 12px -20px 0 -20px;}
				.caption-wraper{left:0;bottom: 0.4em;}
				.caption-wraper .caption{
				left: 0;
				padding: 0.2em 0.4em;
				font-size: 0.92em;
				-webkit-border-radius: 0;
				-moz-border-radius: 0;
				-ms-border-radius: 0;
				-o-border-radius: 0;
				border-radius: 0;}
			}
		</style>
	</style>
</head>
<body>
	<!--导航-->
	<nav class="navbar navbar-default">
		<div class="container">
			<!--小屏幕导航按钮和logo-->
			<div class="navbar-header">
				<button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="index.html" class="navbar-brand"><?php echo ($site_seo_title); ?></a>
			</div>
			<!--小屏幕导航按钮和logo-->
			<!--导航-->
			<div class="navbar-collapse collapse ">
				<?php $effected_id="menu-header"; $filetpl="<a href='\$href' target='\$target'>\$label</a>"; $foldertpl="<a class='dropdown-toggle' href='\$href' target='\$target' data-toggle='dropdown'>\$label<span class='caret'></span></a>"; $ul_class="dropdown-menu" ; $li_class="text-center" ; $style="nav navbar-nav navbar-center"; $showlevel=6; $dropdown='dropdown'; ?>
<?php echo sp_get_menu("1",$effected_id,$filetpl,$foldertpl,$ul_class,$li_class,$style,$showlevel,$dropdown);?>

<!-- 				<ul class="nav navbar-nav navbar-center">
					<li><a href="./">首页</a></li>
					<li class="dropdown text-center">
						<a href="index.html" class="dropdown-toggle " data-toggle="dropdown">院校动态<span class='caret'></span> </a>
						<ul class="dropdown-menu">
							<li class="text-center"><a href="">武汉大学</a></li>
							<li class="text-center"><a href="">北京大学</a></li>
							<li class="text-center"><a href="">南京大学</a></li>
							<li class="text-center"><a href="">中山大学</a></li>
						</ul>
					</li>
					<li class="text-center dropdown">
						<a href="index.html" class="dropdown-toggle " data-toggle="dropdown">热门分词<span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li class="text-center"><a href="">考研</a></li>
							<li class="text-center"><a href="">讲座</a></li>
							<li class="text-center"><a href="">就业</a></li>
							<li class="text-center"><a href="">调研</a></li>
						</ul>
					</li>
					<li class="text-center"><a href="index.html">自主检索</a></li>
					<li class="text-center"><a href="index.html">网站公告</a></li>
					<li class="text-center"><a href="index.html">登录</a></li>
				</ul> -->
				<!-- 搜索 -->
				<form action="" class="navbar-form navbar-right">
					<div class="form-group">
						<input type="text" class="form-control"  placeholder="搜索"/>
					</div>
					<button class="btn btn-default">搜索</button>
				</form>
			</div>
			<!--导航-->
		</div>
	</nav>
	<!--导航-->
<form id="ff">
	<!-- 搜索区域开始 -->
	<div class="panel panel-primary">
		<div class="panel-heading text-center">检索</div>
		<div class="panel-body">
			<div class="form-group">
				<div class="col-md-1 text-right">
					<label class="controle-label">新闻标题</label>
				</div>
				<div class="col-md-3">
					<input type="text" name="title" class="form-control" value=""/>
				</div>
				<div class="col-md-1 text-right">
					<label class="controle-label">关键词</label>
				</div>
				<div class="col-md-3">
					<input type="text" name="keyword" class="form-control" value=""/>
				</div>
				<div class="col-md-4">
					<button class="btn btn-primary btn-block" id="ts" onclick="javascript:return false">搜索</button>
				</div>
			</div>			
		</div>
	</div>
	<!-- 搜索区域结束 -->
</form>
<script>
	$('#ts').click(function(){
		$.ajax({
			method : 'POST',
			url : "<?php echo U('nltkSearch');?>",
			data : $('#ff').serialize(),
			success : function(data) {
				var status = data.status;
				if(status == 1) {
					var scope = data.info;
					scope = eval('(' + scope + ')');
					console.log(scope);
					var info = scope.posts;
					var count = info.length;
					var page = scope.page;
					$('.panel-heading').html(count + '条搜索结果');
					var str = '';
					for (var i = 0; i < info.length; i++) {
						var temp = info[i];
						str += '<li class="list-group-item">';
						str += '<a href="';
						str += 'index.php?g=portal&m=article&id=';
						str += temp.tid;	
						str += '" >';			
						str +=       "<small class="+"'pull-right'>"+temp.post_date+"</small>";
						str += temp.post_title + "</a></li>";
					};
					$('.list-group').html(str);	
					console.log(page);
						$('.pagination').html(page);					
				} else {
					$('.panel-heading').html('无结果');
				}
			},
			type : 'JSON'
		});
	});
</script>
<!-- 搜索结果开始 -->
<div class="panel panel-primary">
	<div class="panel-heading text-center">xx的检索结果</div>	
	<div class="panel-body">
		<ul class="list-group">
		</ul>
		<ul class="pagination"></ul>
	</div>
</div>
<!-- 搜索开始结束 -->