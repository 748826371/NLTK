<?php
namespace Nltk\Controller;
use Common\Controller\AdminbaseController;
//use Think\Controller\RestController;
class CollegeAdminController extends AdminbaseController {
	protected $college_model;
	//protected $navcat_model;	
	function _initialize() {
		parent::_initialize();
		$this->college_model = D("College");
		//$this->navcat_model =D("Common/NavCat");
	}
	/**
	 * 列表显示
	 */
	public function index() {
		$list = $this->college_model->getList();
		$this->assign('list', $list);
		$this->display();
	}
	/**
	 * 删除
	 */
	public function delete() {

	}
	/**
	 * 修改
	 */
	public function update() {
		if (I('get.id')) {
			$coll_id = I('get.id');
			$res = $this->college_model->getOne(['coll_id'=>$coll_id]);
			if ($res) {
				// 数据分配
				$this->assign('one', $res);
			} else {
				$this->error('数据不存在');
			}
			
		} 
		// 修改
		if (I('post.coll_id')) {
			$data = I("post.");
			$this->checkOrder('coll_id != '.I('post.coll_id'));
			if($this->college_model->update($data)){
				$this->success("保存成功！", U("index"));
			}				
			else
				$this->error("保存失败！");
		}
		$this->display();
		
		
	}
	public function add() {
		if (IS_POST) {
			$data = I("post.");
			// 检查排名
			$this->checkOrder([]);
			if($this->college_model->add($data)){
				$this->success("保存成功！", U("index"));
			}				
			else {
				$this->error("保存失败！");
			}				
		}
		$this->display();
	}
	/**
	 * 检查排名 
	 */
	private function checkOrder($data = []) {
		$orders = $this->college_model->getListWithFiled('coll_order', $data); // 
		$order = [];
		foreach ($orders as $key => $value) {
			$order[] = $value['coll_order'];
		}
		if(in_array(I('post.coll_order'), $order)) $this->error("排名重复！");		
	}
	public function test() {
		header('Content-type:text/html; charset=utf-8');
		$post = M('posts')->field('post_keywords')->select();
		$res = [];
		$str = '';
		 foreach ($post as $key => $v) {
	 		if (empty($v['post_keywords'])) {
	 			continue;
	 		} else {
	 			$str .= ltrim(rtrim($v['post_keywords'], ']'), '[').',';
	 		}
		 }
		 $str = substr($str, 0, -1);
		 $res = explode(',', $str);
		 $count = array_count_values($res);
		 unset($count[' 学院']);
		 unset($count[' 管理']);
		 unset($count[' 创新']);
		 $S = [];
		 foreach ($count as $key => $value) {
		 	if($value == 4)
		 		$S[] = $key;
		 	else
		 		continue;
		 }
		 var_dump($S);exit;
		 $pos = array_search(max($count), $count);
		 var_dump($pos);
		 print_r($count);
		 var_dump(max($count));
		// $demo = '[科研,考研,就业,传销]';
		// $demo = explode(',', ltrim(rtrim($demo, ']'), '['));
		// var_dump($demo);
		// $demo = rtrim($demo, ']');
		// $demo = ltrim($demo, '[');
		// $demo = explode(',', $demo);
	}
	public function term() {
		/**
		 * 华师 term_id = 4 [554, 568]
		 * 武大 term_id = 5 [529, 545]
		 */
		$where['id'] = ['between', [529, 545]]; // imd
		$imd = M('posts')->where($where)->field('id')->select();
		foreach ($imd as $key => $value) {
			$data = [];
			$data['term_id'] = 5;
			$data['object_id'] = $value['id'];
			M('term_relationships')->add($data);
		}
		//var_dump($imd);
	}
}