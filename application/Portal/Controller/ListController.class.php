<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2014 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Dean <zxxjjforever@163.com>
// +----------------------------------------------------------------------
namespace Portal\Controller;
use Common\Controller\HomebaseController;
/**
 * 文章列表
*/
class ListController extends HomebaseController {

	//文章内页
	public function index() {
		$term=sp_get_term($_GET['id']);
		
		if(empty($term)){
		    header('HTTP/1.1 404 Not Found');
		    header('Status:404 Not Found');
		    if(sp_template_file_exists(MODULE_NAME."/404")){
		        $this->display(":404");
		    }
		    	
		    return ;
		}
		
		$tplname=$term["list_tpl"];
    	$tplname=sp_get_apphome_tpl($tplname, "list");
    	$this->assign($term);
    	$this->assign('cat_id', intval($_GET['id']));
    	$this->display(":$tplname");
	}
	
	public function nav_index(){
		$navcatname="文章分类";
		$datas=sp_get_terms("field:term_id,name");
		$navrule=array(
				"action"=>"List/index",
				"param"=>array(
						"id"=>"term_id"
				),
				"label"=>"name");
		exit(sp_get_nav4admin($navcatname,$datas,$navrule));
		
	}
	/**
	 * 8.25
	 */
	public function ngList() {
		// $term=sp_get_term($_GET['id']);
		// if(empty($term)){
		// 	$this->error(0, '没有数据', 0);
		// 	exit;
		// }
		// $this->success($term, '找到菜单', 1);
		$res = sp_sql_posts_bycatid($_GET['id'], "field:post_date,post_title,object_id,term_id,tid");
		if($res)
			$this->success($res, '找到菜单', 1);
		else
			$this->error(0, '没有文章', 0);
	}
	public function ngDetail() {
		$term=sp_get_term($_GET['id']);
		if(empty($term)){
			$this->error(0, '没有数据', 0);
			exit;
		}
		$this->success($term, '找到菜单', 1);		
	}
	public function ngSiblings() {
		$terms = sp_get_term(I('get.id'));
		$pid = $terms['parent'];
		$childs = sp_get_child_terms($pid);
		if ($childs) {
			$this->success($childs, '找到同级菜单', 1);
		} else {
			$this->error(0, '没有同级菜单', 0);
		}
		
	}
	
}
