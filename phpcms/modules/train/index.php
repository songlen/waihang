<?php

defined('IN_PHPCMS') or exit('No permission resources.');
class index {
	function __construct() {
		pc_base::load_app_func('global');
		$siteid = isset($_GET['siteid']) ? intval($_GET['siteid']) : get_siteid();
  		define("SITEID",$siteid);

  		$this->db = pc_base::load_model('train_lesson_model');
	}
	
	public function init() {

		$where = array(
			'status'=>'1',
			'is_delete' => '0',
		);

		$where = "status='1' and is_delete='0'";

		$lesson_keyword = isset($_GET['lesson_keyword']) ? $_GET['lesson_keyword'] : '';
		if($lesson_keyword){
			$where .= " and title like '%{$lesson_keyword}%'";
		}

		$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

		$lists = $this->db->listinfo($where, 'listorder desc, id desc', $page, 10);
		$pages = $this->db->pages;

		if(!empty($lists) && is_array($lists)){
			foreach ($lists as &$v) {
				$v['url'] = 'index.php?m=train&a=show&id='.$v['id'];
			}
		}

		$siteid = SITEID;
		include template('train', 'index');
	}

	// 职位广告详情
	public function show(){
		$id = intval($_GET['id']);

		$where = array(
			'id' => $id,
			'status' => '1',
			'is_delete' => '0',
		);
		$info = $this->db->get_one($where);

		if(empty($info)) {
			showmessage('数据不存在');
		}

		extract($info);

		$siteid = SITEID;
		include template('train', 'show');
	}

	// 应聘职位
	public function buy(){

		$id = intval($_GET['id']);
		if(!$id){
			showmessage('该课程不存在', HTTP_REFERER);
		}

		// 检测是否登录
		$phpcms_auth = param::get_cookie('auth');
		if(!$phpcms_auth){
			showmessage('请先登录，跳转中..', '?m=member&a=login&forward='.urlencode(HTTP_REFERER));
		}
		

		$info = $this->db->get_one(array('id'=>$id, 'status'=>'1', 'is_delete'=>'0'));
		if(empty($info)){
			showmessage('该课程不存在', HTTP_REFERER);
		}

		$member_model = pc_base::load_model('member_model');
		$userid = param::get_cookie('_userid');
		$userinfo = $member_model->getOne(array('useid'=>$userid));

		$train_order_model = pc_base::load_model('train_order_model');
		$count = $train_order_model->count(array('lesson_id'=>$id, 'user_id'=>$userid));
		if($count) {
			showmessage('您已购买此课程', HTTP_REFERER);
		}

		$data = array(
			'lesson_id'=>$id,
			'user_id'=>$userid,
			'mobile' => $userinfo['mobile'],
			'price' => $info['price'],
		);
		if($train_order_model->insert($data)){
			showmessage('下单成功，去付款', "index.php?m=train&a=pay&id=$id");
		} else {
			showmessage('服务器错误，请稍后再试');
		}
	}

	public function pay(){
		$id = intval($_GET['id']);

		if(!$id){
			showmessage('该课程不存在', HTTP_REFERER);
		}

		$where = array(
			'id' => $id,
			'status' => '1',
			'is_delete' => '0',
		);
		$info = $this->db->get_one($where);

		if(empty($info)) {
			showmessage('数据不存在');
		}

		extract($info);

		$siteid = SITEID;
		include template('train', 'pay');
	}
}