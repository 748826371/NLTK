<?php
namespace Nltk\Model;
use Common\Model\CommonModel;
/**
 * 词频模型
 *  8.17
 */
class WordModel extends CommonModel {
	protected $tab_db = '';
	public function __construct() {
		$this->tab_db = M('tab');
	}
	/**
	 * 获取标签库
	 */
	public function getTabList($data = []) {
		$res = $this->tab_db->where($data)->select();
		return $res ? $res : false;
	}
	/**
	 * 统计标签数量
	 */
	public function countTab($data = []) {
		$res = $this->tab_db->where($data)->count();
		return $res ? $res : false;
	}
	public function test() {
				//$m = new Model();
		$this->execute("update nltk_tab_term set tab_group = concat(tab_group,',',5) where term_id = 13");
	}
}