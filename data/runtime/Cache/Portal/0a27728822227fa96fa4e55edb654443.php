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
<form id="ff">
	<!-- 搜索区域开始 -->
	<!--
		2017/9/24修改
		搜索按钮变小，
		需要一个检索时间的检索框，
		无法返回首页的bug
		功能上的要求：
			搜索框要匹配关键词，不能只以标题中出现来匹配
			热门文章不能以点击量排序，要按相关关键词
			新增新闻原网址
	-->
	<div class="panel panel-primary">
		<div class="panel-heading text-center">检索(每个文本框都填写的时候就是"与")</div>
		<div class="panel-body text-center row">
			<center>
			<div class="form-horizontal">
				<div class="form-group">
					<label class="control-label col-md-1">新闻标题</label>
					<div class="col-md-3">
						<input type="text" name="title" class="form-control" value="" id="title"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-1">关键词</label>
					<div class="col-md-3">
						<input type="text" name="keyword" class="form-control" value="" id="keywords"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-1">发布时间</label>
					<div class="col-md-3">
						<input type="date" name="post_date" class="form-control" value=""/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-1">区间查询开始</label>
					<div class="col-md-3">
						<input type="date" name="beginTime" class="form-control" value=""/>
					</div>
				</div>	
				<div class="form-group">
					<label class="control-label col-md-1">区间查询结束</label>
					<div class="col-md-3">
						<input type="date" name="endTime" class="form-control" value=""/>
					</div>
				</div>				
				<div class="col-md-3">
					<button class="btn btn-primary" id="ts" onclick="javascript:return false">搜索</button>
					<input type="reset" class="btn btn-defaul" value="重置">
				</div>			
			</div>	
			</center>		
		</div>
	</div>
	<!-- 搜索区域结束 -->
</form>
<script language="javascript" type="text/javascript" src="./public/flot/jquery.flot.js"></script>
<script type="text/javascript" type="text/javascript" src="./public/flot/jquery.flot.pie.js"></script>
<script language="javascript" type="text/javascript" src="./public/flot/jquery.flot.categories.js"></script>
<script>
$(function(){
	$('#ts').click(function(){
		/* 处理日期 
			开始时间也结束时间要么都存在，要么都不存在
		*/
		var timeFlag = false;
		var begin = $('input[name="beginTime"]').val();
		var end = $('input[name="endTime"]').val();
		if((begin && end && end > begin) || (!begin && !end)) {
			timeFlag = true;			
		}
		if(!timeFlag) {
			alert('开始时间和结束时间要同时出现，同时开始时间要早于结束时间');
		} else {
			$.ajax({
				method : 'POST',
				url : "<?php echo U('search/nltkSearch');?>",
				data : $('#ff').serialize(),
				success : function(data) {
					/* 清除body里面的内容 */
					if($('list-group').html()) $('list-group').html('');
					var keyword = $('#keywords').val();
					var title = $('#title').val();
					var status = data.status;
					if(status == 1) {
					 	var scope = data.info;
					 	scope = $.parseJSON(scope); // 获取到的数据
					 	console.log(scope);
					 	
					 	var count = scope.length;
						var str = '';
						for (var i = 0; i < scope.length; i++) {
							var temp = scope[i];
							str += '<li class="list-group-item">';
							str += '<a href="';
							str += 'index.php?g=portal&m=article&id=';
							str += temp.tid;	
							str += '" >';			
							str +=       "<small class="+"'pull-right'>"+comphasize(keyword, temp.post_keywords)+"</small>";
							str += titleRed(title, temp.post_title) + "</a></li>";
						};
						$('.list-group').html(str);	
						$('#sR').html(count + '条检索结果');
						/* 统计分析 */		
						Plot.plotData(scope).pie($('#placeholder')).bar($('#bar'));			
					} else {
					 	$('.panel-default .panel-heading').html('无结果');
					}
				},
				type : 'JSON'
			});			
		}
	});
	/**
	 * 画图
	 */
	
		var Plot = {
			data: null,
			/**
			 * 数据统计
			 */
			plotData: function(scope) {
				/* 高校配置ID */
				var coll = [
					'',
					'武汉大学',
					'北京大学',
					'中国人民大学',
					'南京大学',
					'中山大学',
					'华中师范大学'
				];
				/*
					[coll_name, count]
				*/
				var hashArr = [];
				for(var item in scope) {
					item = scope[item];
					var coll_name = coll[item.coll_id] ? coll[item.coll_id] : false;
					if(!coll_name) {
						continue;
						alert('系统传出的数据有误,刷新页面');
						return false;
					}
					// 统计
					var flag = false;
					for (var i = 0; i < hashArr.length; i++) {
						var h = hashArr[i];
						if(coll_name === h[0]){
							hashArr[i][1]++;
							flag = true;
						}	 						
					};
					// 没有找到
					if(!flag) {
						var temp = [];
						temp.push(coll_name);	
						temp.push(1); 				
						hashArr.push(temp);
					}
				}
				Plot.data = hashArr;
				return Plot;
			},
			/**
			 * 画饼图
			 */
			pie: function(dom) {
				/* 数据处理 */
				var pieData = [];
				if(!Plot.data) {
					alert('无数据!');
					return false;
				}
				for(var i in Plot.data) {
					var o  = {};
					o.label = Plot.data[i][0];
					o.data = Plot.data[i][1];
					pieData.push(o);
				}
				$.plot(dom, pieData, {  
					series: {  
						pie: {   
							show: true //显示饼图  
						}  
					},  
					legend: {  
						show: false //不显示图例  
					}  
				});
				return Plot;
			},
			/**
			 * 柱状图
			 */
			bar: function(dom) {
				if(!Plot.data) {
					alert('无数据!');
					return false;
				}	
				$.plot(dom, [ Plot.data ], {
					series: {
						bars: { // 用的组件是bars来画图
							show: true,
							barWidth: 0.6,
							align: 'center'					
						}
					},
					xaxis: {
						mode: 'categories',
						tickLength: 0
					}					
				});	
				return Plot;	
			},
			/**
			 * 折线图
			 */
			lineChart: function(dom) {
				if(!Plot.data) {
					alert('无数据!');
					return false;
				}	
				$.plot(dom, [Plot.data]);
				return Plot;				
			}
		}
		/**
		 * 去重
		 */
		function trimSame(arr){
			var res = [];
			for(var i = 0; i < arr.length; i++){
				var temp = arr[i];
				var formerId = temp.object_id;
				for(var j = i+1; j < arr.length; j++) {
					var laterId = arr[j].object_id;
					if(laterId == formerId) {
						arr.splice(j, 1); // 元素删除
					}
				}
			};
			return arr;
		}
		/**
		 * 关键词匹配标红
		 */
		function comphasize(input, keywords) {
			var arr = keywords.split(' ');
			var index = $.inArray(input, arr);
			arr[index] = "<span style='color:red'>" + input +"</span>";
			var result = arr.join(' ');
			return result;
		}
		/**
		 * 文章标题标红
		 */
		function titleRed(input, str) {
			str = str.replace(input, "<span style='color:red'>" + input +"</span>"); // 搜索和替换
			return str;
		}
	});
	
</script>
<!-- 搜索结果开始 -->
<div class="panel panel-default">
	<div class="panel-heading text-center" id="sR">检索结果</div>	
	<div class="panel-body">
		<div style="width:300px;height:300px;display:inline-block" id="placeholder"></div>
		<div id="bar" style="width:300px;height:300px;display:inline-block"></div>
		<ul class="list-group">
		</ul>
		<ul class="pagination"></ul>
	</div>
</div>
<!-- 搜索开始结束 -->

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