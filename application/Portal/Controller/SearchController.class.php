<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2014 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Dean <zxxjjforever@163.com>
// +----------------------------------------------------------------------
/**
 * 搜索结果页面
 */
namespace Portal\Controller;
use Common\Controller\HomebaseController;
class SearchController extends HomebaseController {
    //文章内页
    public function index() {
    	$_GET = array_merge($_GET, $_POST);
		$k = I("get.keyword");
		
		if (empty($k)) {
			$this -> error("关键词不能为空！请重新输入！");
		}
		$this -> assign("keyword", $k);
		$this -> display(":search");
    }
    public function test() {$this->display(':test');}
    /**
     * nltk文章搜索
     * 8.18
     * 搜索项数量判定
     * 只搜索一个
     * 搜索两个
     * 全部搜索
     * 数组去重需要的函数以及数据结构的重组JSON格式的改变
     */
    public function dotest() {
    	if(isset($_POST['test'])) {
			$result = sp_sql_posts_paged_bykeyword($_POST['test'],"field:post_date,post_title,object_id,tid,term_id",20);

			$res = json_encode($result);
			$this->success($res, 'success', 1);
    	} else {
    		$this->success(0, 'success', 0);
    	}
    	
    }
    /** 
     * 9.24搜索算法优化
     * 
     */
    public function nltkSearch() {
    	if (IS_POST) {       
            $title = I('post.title');
            $keyword = I('post.keyword');
            $post_date = I('post.post_date');
            $begin_time = I('post.beginTime');
            $end_time = I('post.endTime');
            $condition = [];
            if($title) $condition['post_title'] = ['like', '%'.$title.'%'];
            if($keyword) $condition['post_keywords'] = ['like', '%'.$keyword.'%'];
            if($post_date && !($beginTime && $end_time)) $condition['post_date'] = ['like', '%'.$post_date.'%'];
            /* 10/16 处理区间查询 */
            if($begin_time && $end_time) {
                $begin = strtotime($begin_time);
                $end = strtotime($end_time);
                $time_dif = [];
                while($end >= $begin) {                    
                    $time_dif[] = date('Y-m-d', $begin);  
                    $begin = $begin + 86400;                  
                }
                $condition['post_date'] = ['in', $time_dif];
            }
            $result =  sp_sql_posts("field:post_date,post_title,object_id,tid,term_id,coll_id,post_keywords;order:post_date asc", $condition);
            if ($result) {
                $res = json_encode($result);
                $this->success($res, 'success', 1);
            } else {
               $this->error(0, 'fail', 0);
            }             
            /* 只传标题 */
            // if(!empty($title) && empty($keyword)) {
            //     $result = sp_posts("field:post_date,post_title,object_id,tid,term_id,post_keywords;order:post_date asc", ['post_title' => ['like', '%'.$title.'%']]);
            //     if ($result) {
            //         $res = json_encode($result);
            //         $this->success($res, 'success', 1);
            //     } else {
            //        $this->error(0, 'fail', 0);
            //     }               
            // }
            // /* 只传关键字 */
            // if(empty($title) && !empty($keyword)) {
            //     $result = sp_posts("field:post_date,post_title,object_id,tid,term_id;order:post_date asc", ['post_keywords' => ['like', '%'.$keyword.'%']]);
            //     if ($result) {
            //         $res = json_encode($result);
            //         $this->success($res, 'success', 1);
            //     } else {
            //        $this->error(0, 'fail', 0);
            //     }   
            // }
            // /* 都传 */
            // if(!empty($title) && !empty($keyword)) {
            //     $result = sp_posts("field:post_date,post_title,object_id,tid,term_id;order:post_date asc", ['post_keywords' => ['like', '%'.$keyword.'%'], ['post_title'=> ['like', '%'.$title.'%'] ]]);
            //     if ($result) {
            //         $res = json_encode($result);
            //         $this->success($res, 'success', 555);
            //     } else {
            //        $this->error(0, 'fail', 1);
            //     }   
            // }
            // if(empty($title) && empty($keyword)) 
            //      $this->error(0, 'fail', 1);
    	} else {
    		$this->display(':nltkSearch');
    	}
    }
    public function termApi() {
    	if (IS_POST) {
    		$term_id = I('get.term_id');
    		$name = M('terms')->field('name')->where('term_id = '.$term_id)->find();
    		if ($name) {
    			$name = json_encode($name);
    			var_dump($name);exit;
    			$this->success($name, 'success', 1);
    		} else {
    			$this->error(0, '失败', 0);
    		}    		
    	} else {
    		$this->error(0, '失败', 0);
    	}
    	
    }
    
}
