<?php
namespace Nltk\Model;
use Common\Model\CommonModel;
/**
 * 校管理模型
 *  8.12
 */
class CollegeModel extends CommonModel {
	protected $db = '';
	public function __construct() {
		$this->db = M('college');
	}
	public function getList($data = []) {
		$res = $this->db->where($data)->select();
		return $res ? $res : false;
	}
	/**
	 * 获取一条
	 */
	public function getOne($data = []) {
		$res = $this->db->where($data)->find();
		return $res ? $res : false;
	}
	/**
	 * 修改
	 */
	public function update($data) {
		$res = $this->db->save($data);
		return $res ? $res : false;
	}
	/**
	 * 获取字段
	 */
	public function getListWithFiled($filed = 'coll_id', $data = []) {
		$res = $this->db->field($filed)->where($data)->select();
		return $res ? $res : false;
	}
	/**
	 * 增加
	 */
	public function add($data) {
		$res = $this->db->add($data);
		return $res ? $res : false;
	}
	/**
	 * 删除暂时不做
	 */
}