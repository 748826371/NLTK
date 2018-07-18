<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<!-- Set render engine for 360 browser -->
	<meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- HTML5 shim for IE8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <![endif]-->

	<link href="/public/simpleboot/themes/<?php echo C('SP_ADMIN_STYLE');?>/theme.min.css" rel="stylesheet">
    <link href="/public/simpleboot/css/simplebootadmin.css" rel="stylesheet">
    <link href="/public/js/artDialog/skins/default.css" rel="stylesheet" />
    <link href="/public/simpleboot/font-awesome/4.4.0/css/font-awesome.min.css"  rel="stylesheet" type="text/css">
    <style>
		.length_3{width: 180px;}
		form .input-order{margin-bottom: 0px;padding:3px;width:40px;}
		.table-actions{margin-top: 5px; margin-bottom: 5px;padding:0px;}
		.table-list{margin-bottom: 0px;}
	</style>
	<!--[if IE 7]>
	<link rel="stylesheet" href="/public/simpleboot/font-awesome/4.4.0/css/font-awesome-ie7.min.css">
	<![endif]-->
<script type="text/javascript">
//全局变量
var GV = {
    DIMAUB: "/",
    JS_ROOT: "public/js/",
    TOKEN: ""
};
</script>
<!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/public/js/jquery.js"></script>
    <script src="/public/js/wind.js"></script>
    <script src="/public/simpleboot/bootstrap/js/bootstrap.min.js"></script>
<?php if(APP_DEBUG): ?><style>
		#think_page_trace_open{
			z-index:9999;
		}
	</style><?php endif; ?>
</head>
<body>
	<div class="wrap js-check-wrap">
		<ul class="nav nav-tabs">
			<li><a href="<?php echo U('index');?>">标签库列表</a></li>
			<li><a href="<?php echo U('addSimilar');?>">添加近义词</a></li>
			<li class="active"><a href="./">分词</a></li>
		</ul>
		<h3><?php echo ($status); ?></h3>	
		<a href="<?php echo U('test');?>">开始分词</a>
		<!-- <button>开始分词</button> -->
		<?php if ($hot_word): ?>
			<h2>热词统计结果</h2>
			<table class="table table-bordered">
				<colgroup>
					<col style="width:50%">
					<col style="width:50%">
				</colgroup>
				<thead>
					<tr>
						<th width="50">词名</th>
						<th>权重(出现的次数)</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($hot_word as $v => $k){ echo "<tr>
									<td>$v</td>
									<td>$k</td>
								</tr>"; } ?>
				</tbody>
			</table>
			<h2>最终结果</h2>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>词名</th>
						<th>权重(出现的次数)</th>
						<th>文章ID</th>
						<th>关键词</th>
					</tr>
				</thead>
				<tbody>
					<?php if(is_array($final_result)): foreach($final_result as $key=>$vo): if(is_array($vo)): foreach($vo as $key=>$v): ?><tr>
								<td><?php echo ($v["hot_word"]); ?></td>
								<td><?php echo ($v["tab_id"]); ?></td>
								<td><?php echo ($v["id"]); ?></td>
								<td><?php echo ($v["post_keywords"]); ?></td>
							</tr><?php endforeach; endif; endforeach; endif; ?>
				</tbody>
			</table>						
		<?php endif ?>
		
		<div class="common-form">
			<form method="post" class="form-horizontal js-ajax-form" action="<?php echo U('door');?>">
				<fieldset>
					<div class="control-group">
						<label class="control-label">词频界限</label>
						<div class="controls">
							<input type="text" name="count_flag" value="4" required placeholder="不填就是4">
						</div>
						<input type="hidden" name="tab_id" value="<?php echo ($tab_id); ?>">
					</div>
				</fieldset>
				<div class="form-actions">
					<button type="submit" class="btn btn-primary js-ajax-submit">保存</button>
					<a class="btn" href="<?php echo U('index');?>">返回</a>
				</div>
			</form>
		</div>
		<script src="/public/js/common.js"></script>
	</div>