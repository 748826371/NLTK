<?php if (!defined('THINK_PATH')) exit();?>	<?php  function _sp_helloworld(){ echo "hello ThinkCMF!"; } function _sp_helloworld2(){ echo "hello ThinkCMF2!"; } function _sp_helloworld3(){ echo "hello ThinkCMF3!"; } function sp_get_breadcrumb($term_id){ $terms_model= M("Terms"); $data=array(); $path=$terms_model->where(array('term_id'=>$term_id))->getField('path'); if(!empty($path)){ $parents=explode('-', $path); if(!empty($parents)){ $data=$terms_model->where(array('term_id'=>array('in',$parents)))->order('path ASC')->select(); } } return $data; } ?>
	<?php
$portal_index_lastnews="2"; $portal_hot_articles="4,5,6,10,11,13"; $portal_last_post="1,2"; $portal_index_news = [ '武汉大学' => 5, '华中师范大学' => 4, ]; $tmpl=sp_get_theme_path(); $default_home_slides=array( array( "slide_name"=>"ThinkCMFX2.1.0发布啦！", "slide_pic"=>$tmpl."Public/images/demo/1.png", "slide_url"=>"", ), array( "slide_name"=>"ThinkCMFX2.1.0发布啦！", "slide_pic"=>$tmpl."Public/images/demo/2.png", "slide_url"=>"", ), array( "slide_name"=>"ThinkCMFX2.1.0发布啦！", "slide_pic"=>$tmpl."Public/images/demo/3.png", "slide_url"=>"", ), ); ?>
	<!DOCTYPE html>
	<html lang="zh-CN">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1 , user-scalable=no">
		<meta name="keywords" content="<?php echo ($site_seo_keywords); ?>"/>
		<meta name="description" content="<?php echo ($site_seo_description); ?>"/>
		<title><?php echo ($site_seo_title); ?></title>
		<link rel="stylesheet" href="/themes/simplebootx_nltk/Public/css/bootstrap.min.css"/>
		<link rel="stylesheet" href="/themes/simplebootx_nltk/Public/css/slippry/slippry.css" />
		<!-- 腾讯网站数据统计 -->
		<script type="text/javascript" src="http://tajs.qq.com/stats?sId=62665828" charset="UTF-8"></script>
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
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="container">
				<!--小屏幕导航按钮和logo-->
				<div class="navbar-header">
					<button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a href="/" class="navbar-brand"><?php echo ($site_seo_title); ?></a>
				</div>
				<!--小屏幕导航按钮和logo-->
				<!--导航-->
				<div class="navbar-collapse collapse ">
					<?php $effected_id="menu-header"; $filetpl="<a href='\$href' target='\$target'>\$label</a>"; $foldertpl="<a class='dropdown-toggle' href='\$href' target='\$target' data-toggle='dropdown'>\$label<span class='caret'></span></a>"; $ul_class="dropdown-menu" ; $li_class="text-center" ; $style="nav navbar-nav navbar-center"; $showlevel=6; $dropdown='dropdown'; ?>
	<?php echo sp_get_menu("1",$effected_id,$filetpl,$foldertpl,$ul_class,$li_class,$style,$showlevel,$dropdown);?>
					<!-- 搜索 -->
					<form method="post" action="<?php echo U('portal/search/index');?>" class="navbar-form navbar-right">
						<div class="form-group">
							<input type="text" class="form-control"  placeholder="搜索" name="keyword"/>
						</div>
						<input type="submit" class="btn" value="Go" style="margin:0"/>
					</form>
				</div>
				<!--导航-->
			</div>
		</nav>
		<!--导航-->
	<!-- 面包屑开始 -->
	<?php  $data = sp_get_breadcrumb($term['term_id']); ?>
	<div class="container">
		<ol class="breadcrumb">
			<li><a href="./">首页</a></li>
			<?php if(is_array($data)): foreach($data as $key=>$vo): ?><li><a href="<?php echo U('list/index', ['id'=>$vo['term_id']]);?>"><?php echo ($vo['name']); ?></a></li><?php endforeach; endif; ?>
		</ol>	
	</div>	
	<!-- 面包屑结束 -->
	<!-- 主体开始 -->
	<div class="container">
		<div class="row">
			<!-- 左侧列表显示开始 -->
			<div class="col-md-3">
				<div class="panel panel-default text-center">
					<div class="panel-heading panel-info">本篇文章关键字</div>
					<div class="panel-body panel-primary">
						<?php echo ($post_keywords); ?>
					</div>
				</div>
				<div class="panel panel-default text-center">
					<div class="panel-heading panel-info">相关文章推荐</div>
	        		<?php $keywords = explode(' ', $post_keywords); $keywords = $keywords[0]; $condition = []; $condition['post_keywords'] = ['like', '%'.$keywords.'%']; $hot_articles=sp_sql_posts("field:post_title,tid,term_id;order:post_hits desc;limit:5;", $condition); ?>
		        	<ul class="list-group">
		        		<?php if(is_array($hot_articles)): foreach($hot_articles as $key=>$vo): ?><li class="list-group-item"><a title="<?php echo ($vo["post_title"]); ?>" href="<?php echo leuu('article/index',array('id'=>$vo['tid'],'cid'=>$vo['term_id']));?>"><?php echo msubstr($vo['post_title'], 0, 10);?></a></li><?php endforeach; endif; ?>
					</ul>
				</div>
				<div class="panel panel-default text-center">
					<div class="panel-heading panel-info">原文章链接</div>
					<div class="panel-body panel-primary">
						<?php if(!empty($post_url)): ?>
							<a href="{post_url}" title"点击访问" target="_blank"><?php echo ($post_url); ?></a>
						<?php endif ?>
					</div>
				</div>				
			</div>
			<!-- 左侧列表显示结束 -->
			<!-- 右侧列表显示开始 -->
			<div class="col-md-9">
				 <div class="panel panel-default text-center">
					<div class="panel-heading">
						<h4><?php echo ($post_title); ?></h4>
						<span><?php echo ($post_date); ?>发布  <?php echo ($post_hits); ?>阅读量 </span>
					</div>
					<div class="panel-body">
		    			<?php echo ($post_content); ?>		    	
		    		
						<?php if(!empty($post_source)): ?><div>
		                        <b>注：本文转载自<?php echo ($post_source); ?>，转载目的在于传递更多信息，并不代表本网赞同其观点和对其真实性负责。如有侵权行为，请联系我们，我们会及时删除。</b>
		                    </div><?php endif; ?>
	    				<?php if(!empty($prev)): ?><a href="<?php echo leuu('article/index',array('id'=>$prev['tid'],'cid'=>$prev['term_id']));?>" class="btn btn-primary pull-left">上一篇</a><?php endif; ?>
						<?php if(!empty($next)): ?><a href="<?php echo leuu('article/index',array('id'=>$next['tid'],'cid'=>$next['term_id']));?>" class="btn btn-warning pull-right">下一篇</a><?php endif; ?>
					</div>
				</div>			
			</div>
			<!-- 右侧列表显示结束 -->

		</div>
	</div>
	<!-- 主体结束 -->
<!-- 底部开始 -->

	<nav class="navbar navbar-default navbar-fixed-bottom">
		<div class="container">
			<ul class="nav">
				
				<li class="text-center col-xs-3"><a href="#">关于我们</a></li>
				<li class="text-center col-xs-3"><a href="#">网站地图</a></li>
				<li class="text-center col-xs-3"><a href="#">网站公告</a></li>
				<li class="text-center col-xs-3"><a href="#">联系我们</a></li>
			</ul>
		<div class="text-center"><h5>@copyrirht华中师范大学信息管理学院啄木鸟团队</h5></div>			
		</div>
	</nav>
	<!-- 底部的菜单 需要在后台重新加载
	<!-- 底部结束 -->
       <!--  <div class="main_nav_bottom" style="margin-bottom:0">
                <nav class="navbar navbar-default">
                    <div class="container" align="center">
                        <style>
                            .nav-tabs
                            {
                                text-align: center;
                                height: 40px;
                                line-height: 40px;
                            }
                        </style>
                        <ul class="nav nav-tabs nav-tabs-justified">
                            <div class="row" align="center">
                                <div class="col-md-4 col-sm-4 col-xs-4" align="center"><li><a href="#">Bootstrap1</a></li></div>
                                <div class="col-md-4 col-sm-4 col-xs-4" align="center"><li><a href="#">Bootstrap2</a></li></div>
                                <div class="col-md-4 col-sm-4 col-xs-4" align="center"><li><a href="#">Bootstrap3</a></li></div>
                            </div>
                        </ul>
                    </div>
                </nav>
            </div>   -->