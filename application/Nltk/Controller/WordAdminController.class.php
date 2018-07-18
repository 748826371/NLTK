<?php
/**
 * 分詞管理控制器
 * 8.16
 * 废词需要去数据库中提取
 * 8.18 还需要的方法
 * 废词管理
 * 开始分词
 */
namespace Nltk\Controller;
use Common\Controller\AdminbaseController;
class WordAdminController extends AdminbaseController {
	
	private $source_data = []; // 原始到的爬取結果
	private $count_result = []; // 词频统计结果
	private $break_word = ['大学', '学院', '管理', '实践', '实践队']; // 废词
	private $tabs = []; // 标签库中的词
	private $hot_word = []; // 热词 一维数组
	private $main_tab_result = []; // 默认标签的搜索结果
	private $final_result = []; //最终的结果 包括文章的信息以及热词
	private $max_post_id = ''; // 上一次文章爬取的最后ID
	private $i = 0; // 统计时间
	private $count_flag = 4; // 词频统计界限
	protected $tab_model; // 标签模型

	public function test(){
		header('Content-type:text/html; charset=utf-8');
		// 获取所有文章
		$this->getList();
		// echo '<pre>';
		// print_r($this->source_data);
		// echo '</pre>';
		// 词频统计
		$this->wordCount();
		// echo '<h1>词频统计结果</h1>';
		// echo '<pre>';
		// print_r($this->count_result);
		// 热词统计
		$this->combineToClass(); // 统计热门分词 根据词频
		// echo '<h1>热门分词</h1>';
		// echo '<pre>';wordCount
		// print_r($this->hot_word);
		// echo '</pre>';	
		// 去除废词
		$this->trimBreakWord(false);
		// echo '<h1>去除废词之后的热门分词</h1>';
		// echo '<pre>';
		// print_r($this->hot_word);
		// echo '</pre>';	
		$this->assign('hot_word', $this->hot_word);
		// 标签库比较
		$this->tabCompare(); // 匹配默认标签
		$this->final_result = $this->countHotPost($this->hot_word, false); // 标签库过滤之后的结果
		echo '<pre>';
		print_r($this->final_result);
		echo '</pre>';
		$this->assign('final_result', $this->final_result);

		$this->display('participle');

	}
	function _initialize() {
		parent::_initialize();
		$this->tab_model =D("Word");
		$this->max_post_id = M('config')->where("name = 'MAX_POST_ID'")->getField('value');
	}
	
	public function index() {
		/* 词频列表 */		
		/* 分页处理 */
		$count = $this->tab_model->countTab(['pid'=>0]);
		$page = $this->page($count, 15);
		$lists = M('tab')
			    	->where(['pid'=>0])
			    	->limit($page->firstRow . ',' . $page->listRows)
			    	->select();
		$this->assign('list', $lists);
		$this->assign("page", $page->show('Admin'));
		$this->display();
	}
	/**
	 * 添加近义词
	 * 添加的近义词不要重复
	 * 疑问的是近义词的标志
	 */
	public function addSimilar() {
		if(I('get.tab_id')) {
			$pid = I('get.tab_id');
			$this->assign('tab_id', $pid);
			//$r = M('tab_term')->select();
			$term_id = '';
			if(I('get.tab_name')){
				/* 找到term_id */
				// foreach ($r as $key => $value) {
				// 	$arr = [];
				// 	$arr = explode(',', $value['tab_group']);
				// 	if(in_array($pid, $arr)) {
				// 		$term_id = $value['term_id'];
				// 		break;
				// 	} else {
				// 		continue;
				// 	}
				// }
				/* 8.17 找到term_id */
				$term_id = M('tab')->where('id = '.$pid)->getField('term_id');
				$tab_arr = []; // 近义词数组
				$tab_arr = explode(' ', I('get.tab_name')); // 把同义词的字符串转化成数组
				/* 添加到标签库 更新标签-分类表*/
				$status = true;
				foreach ($tab_arr as $key => $value) {
					$data = [];
					$data['tab_name'] = $value; // 标签名
					$data['pid'] = $pid; // 保存父级ID 
					$data['term_id'] = $term_id; // 8.17修改
					$tab_id = M('tab')->add($data); // 添加到tab表中
					// $tab_group = M('tab_term')->where('term_id = '.$term_id)->getField('tab_group');
					// $d = [];
					// $d['tab_group'] = $tab_group.','.$tab_id;
					// $res = M('tab_term')->where('term_id = '.$term_id)->save($d);
					// $status = $res ? true : false;
					$status = $tab_id ? true : false;
					if(!$status)
						$this->error('标签-分类表插入失败');
				}
				if($status){
					/* 测试 */
					// $this->assign('flag', true);
					// $this->assign('sta', I('get.tab_name'));
					$this->success('添加成功', U("index"));
				} 				
			} else {
				$this->display();
			}

		} else {
			$this->error('没有ID传过来！');
		}
	}
	/**
	 * 分词入口配置
	 */
	public function participle() {
		/* 显示相关配置 */
		$this->max_post_id = M('config')->where("name = 'MAX_POST_ID'")->getField('value');
		$max_now = M('posts')->max('id');
		$status = ($max_now - $this->max_post_id) > 0 ? ($max_now - $this->max_post_id) : false;
		if ($status) {
			$new_num = M('posts')->where('id > '.$this->max_post_id)->count();
			$this->assign('status', '新加入'.$new_num.'篇文章');	
			$this->assign('max_post_id', $this->max_post_id);						
		} else {
			$this->error('没有文章加入,不需要分词');
		}
		/* 分词展示 8.18*/
		if (session('word_flag')) {
			$this->assign('word_flag', session('word_flag')); // 模板判定使用
			// 词频统计结果

			
		}
		$this->display();
	}
	/**
	 * 相关参数配置
	 */
	/**
	 * 设置参数开始
	 * 分词入口
	 */
	public function door() {
		header('Content-type:text/html; charset=utf-8');
		# 初始化废词
		$this->getList('id > '.$this->max_post_id); // 获取新进的文章
		$this->wordCount(); // 词频统计
		$this->combineToClass(I('post.count_flag')); // 统计热门分词 根据词频
		// 默认标签库
		$this->tabCompare(); // 匹配默认标签
		$this->defaultTabToTerm(); //插入表中
		// 根据词频生成的标签
		$this->trimBreakWord(); // 去除废词
		$this->final_result = $this->countHotPost($this->hot_word, false); // 标签库过滤之后的结果
		$this->updateTab(); // 添加到菜单和分类
	}
	/**
	 * 获取新闻表的全部新闻
	 * 獲取的字段有文章ID，分詞結果，高校ID
	 * 還有最後一次的ID
	 */
	public function getList($data = []) {
		$this->source_data = M('posts')->field('id,post_keywords,coll_id')->where($data)->select();
		return;
		if ($this->source_data) {
			// 更新系统变量 把最后一次的ID传进来
			$max_id = M('posts')->max('id');
			M('config')->where('name = MAX_POST_ID')->save(['MAX_POST_ID'=>$max_id]);
			// 是否需要修改成员变量？
		} else {			
			$this->error('没有新加入的文章,不用分词');
		}
	}
	/**
	 * 词频统计
	 */
	public function wordCount() {
		$wait = [];
		$str = '';
		/* 关键字的转化算法 57-66行 根据关键字的格式的不同进行修改 */
		foreach ($this->source_data as $key => $v) {
			$this->i += 1;
	 		if (empty($v['post_keywords'])) {
	 			continue;
	 		} else {
	 			//$wait[] = explode(', ', $v['post_keywords']); // 加逗号之后的结果
	 			$str .= $v['post_keywords'].', ';
	 		}
		}
		$wait = explode(', ', $str); // 字符串转化成数组
		array_pop($wait); // 去掉最後一個空元素		

		$this->count_result = array_count_values($wait); //词频统计结果
		arsort($this->count_result); // 從低到高排序
		/* 8.17 存入cookie*/
		// session('count_result', $this->count_result);
		// echo '<h1>词频统计结果</h1>';
		// echo '<pre>';
		// print_r($this->count_result);
		// echo '</pre>';
		// $this->combineToClass(); // 统计热门分词	
		// echo '<h1>热门分词</h1>';
		// echo '<pre>';
		// print_r($this->hot_word);
		// echo '</pre>';	
		// $this->trimBreakWord(false); // 去除break_word
		// echo '<h1>去除坏词之后的热门分词</h1>';
		// echo '<pre>';
		// print_r($this->hot_word);
		// echo '</pre>';	
		// $this->final_result = $this->countHotPost($this->hot_word, false); // 最终结果,没有去除标签库
		// echo '<pre>';
		// print_r($this->final_result);
		// echo '</pre>';	
		// $this->tabCompare();
		// exit;	 
	}
	/**
	 * 去除廢詞
	 * 從分出來的熱詞中取出
	 * 注意傳地址
	 * @param $flag bollean 是否在废词中把默认的标签库也算 也就是在默认标签阶段还是自定义标签阶段 
	 */
	public function trimBreakWord($flag = true) {
		/* 默认标签库统计完成之后 */
		if ($flag) {
			$mer = array_values($this->tabs);
			//$mer = array_keys($this->tabs);
			$this->break_word = array_merge($this->break_word, $mer);
		}
		 // echo '<h1>break_word是</h1>';
		 // echo '<pre>';
		 // print_r($this->break_word);
		 // echo '</pre>';	
		foreach ($this->hot_word as $key => $value) {
			$this->i += 1;
			if(in_array($key, $this->break_word))
				unset($this->hot_word[$key]);
			else
				continue;
		}
	}
	/**
	 * 标签库比较
	 */
	public function tabCompare() {
		/* 8.16 添加where限制 来获取默认的标签 所有的标签都要比较*/
		/* 8.17 不加这个限制? 比如 考研=>[考研, ]*/
		$this->tabs = M('tab')->getField('tab_name,tab_id', true); // 获取整列 ->where('flag = 1')
		/* 通过tab_id来找父级ID然后再去判断分类 */
		$this->main_tab_result = $this->countHotPost($this->tabs);
		// echo '<h1>默认标签的结果</h1>';
		// echo '<pre>';
		// print_r($this->main_tab_result);
		// echo '</pre>';
	}
	/**
	 * 得到要加入分类的热词
	 */
	public function combineToClass($flag = 4) {
		//$res = [];
		foreach ($this->count_result as $key => $value) {
			$this->i += 1;
			if($value >= $flag)
				//$res[] = $key;
				continue;
			else
				unset($this->count_result[$key]);
		}
		$this->hot_word = $this->count_result;
		/* 8.17 存入session */
		session('hot_word', $this->hot_word);
	}
	/**
	 * 从源数据中找到与$fin相匹配的数据并组合
	 * 統計熱詞所在的文章
	 * 插入数据表中
	 * $fin = [
	 *		调研 => 4
	 * 	]
	 * $flag boolean * 判断默认标签的还是不行后面加入的以组织不同的数据结构
	 * flag == true ? 标签的结果废标签用false
	 */
	public function countHotPost($fin = [], $flag = true) {
		$res = [];
		if ($flag) {
			/**
			 * 调研 => 4(tab_id)
			 */
			 foreach ($this->source_data as $key => $v) {
			 	$this->i += 1;
		 		if (empty($v['post_keywords'])) { // 文章的分词结果 【科研 研究 理想】
		 			continue;
		 		} else {
		 			foreach ($fin as $k => $value) {
		 				$this->i += 1;
		 				if(strstr($v['post_keywords'], $k)){	// 文章属于某个关键字
		 					/* 8.17 找到父级的ID 这是默认标签库或者说是与现有的标签库比对，不需要更新标签库*/ 	
		 					$pid = M('tab')->where('pid = '.$value)->getField('tab_id');		
		 					$value = $pid == 0 ? $value : $pid;	
		 					$res[] = array_merge(['hot_word'=>$k, 'tab_id'=>$value], $v); // 数组拼接成一个新的数组
		 					break; // 注意：及时跳出循环 要不然一篇文章有两个相同的关键字就会重复
		 				}	 					
		 				else
		 					continue;
		 			}
		 		}
			 }
		} else {
			foreach ($fin as $k => $value) {
				$this->i += 1;
				$res[$k] = [];
				$data = [];
				foreach ($this->source_data as $key => $v) {
					$this->i += 1;
				 	if (empty($v['post_keywords'])) { // 文章的分词结果 【科研 研究 理想】
				 		continue;
				 	} else {
						if(strstr($v['post_keywords'], $k)){	 					
							$data[] = array_merge(['hot_word'=>$k, 'tab_id'=>$value], $v); // 数组拼接成一个新的数组
							continue; // 注意：及时跳出循环 要不然一篇文章有两个相同的关键字就会重复
						}	 					
						else
							continue;
					}					 		
				}
				$res[$k] = $data;
			}			
		}
		return $res;
		}
	/**
	 * 默认标签库插入文章分类表
	 */
	public function defaultTabToTerm() {
		/* 添加到标签_文章表 */
		foreach ($this->main_tab_result as $key => $value) {
			$this->i += 1;
			$data = [];
			$data['tab_id'] = $value['tab_id']; // 最顶层的父级的标签的ID
			$data['post_id'] = $value['id'];
			M('tab_post')->add($data);
		}
		/* 添加到分类表 */
		foreach ($this->main_tab_result as $k => $v) {
			$this->i += 1;
			$tab_id = $v['tab_id']; // 最顶层的父级的标签的ID
			$term_id = '';
			// $relation =  M('tab_term')->select();
			// /* 查找term_id */
			// foreach ($relation as $key => $value) {
			// 	$this->i += 1;
			// 	$tar = explode(',', $value['tab_group']);
			// 	if(in_array($tab_id, $tar)) { // 找到
			// 		$term_id = $value['term_id'];
			// 		break;
			// 	}
			// }
			/* 8.17 找到term_id */
			$term_id = M('tab')->where('tab_id = '.$tab_id)->getField('term_id');
			/* 插入term表 */
			$data = [];
			$data['object_id'] = $v['id']; // 文章ID
			$data['term_id'] = $term_id; // 分类表
			M('term_relationships')->add($data);
		}
	}
	/**
	 * 更新标签库
	 * 插入分类和菜单
	 */
	public function updateTab() {
		foreach ($this->final_result as $key => $value) {
			$this->i += 1;
			if(!empty($value)) {
				/* 添加到分类表 */	
				$data = [];
				$data['name'] = $key;
				$data['taxonomy'] = 'article';
				$data['parent'] = 8;// 热词是8
				$max_id = M('terms')->max('term_id');
				$data['path'] = '0-8-'.($max_id+1);
				$data['list_tpl'] = 'list';
				$data['one_tpl'] = 'article';
				$data['status'] = 1;
				$term_id = M('terms')->add($data);
				unset($data);
				/* 添加到标签库 */
				$data = [];
				$data['flag'] = 1;
				$data['tab_weight'] = count($value); // 出现的次数
				$data['tab_name'] = $key; // 标签名
				$data['term_id'] = $term_id; // 8.17修改
				$tab_id = M('tab')->add($data);	
				unset($data);
				// /* 添加到分类-标签库表 8.17*/
				// unset($data);
				// $data = [];
				// $data['term_id'] = $term_id;
				// $data['tab_group'] = $tab_id.'';
				// M('tab_term')->add($data);
				/* 添加到菜单表 */
				unset($data);
				$data = [];
				$data['cid'] = 1;
				$data['parentid'] = 12; // 热门分词
				$data['label'] = $key;
				$data['href'] = 'a:2:{s:6:"action";s:17:"Portal/List/index";s:5:"param";a:1:{s:2:"id";s:2:"'.$term_id.'";}}';
				$max_id = M('nav')->max('id');
				$data['path'] = '0-12-'.($max_id+1);
				M('nav')->add($data);
				unset($data);
				/* 插入到tab-post表中 */
				foreach ($value as $k => $v) {
					$data = [];
					$data['term_id'] = $tab_id;
					$data['post_id'] = $v['id']; 
					M('tab_post')->add($data);
					/* 添加到分类-文章表 */
					$r = [];
					$r['term_id'] = $term_id;
					$r['object_id'] = $v['id'];
					M('term_relationships')->add($r);
				}				
			} else {
				continue;
			}
		}
	}
	/**
	 * 统计新加入的文章
	 */
	public function countNewPost(){
		$num = M('posts')->where('id > '.$this->max_post_id)->count('id');
		return $num > 0 ? $num : 0;
	}
}