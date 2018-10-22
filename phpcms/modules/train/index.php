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

		$type = isset($_GET['type']) ? $_GET['type'] : '1';

		$where = "status='1' and is_delete='0' and type='{$type}'";

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

		$is_login = is_login() ? 1 : 0;
		$layui = 1;

		$siteid = SITEID;
		$SEO = seo($siteid);
		$SEO['title'] = '培训课程 - ';
		include template('train', 'index');
	}

	// 职位广告详情
	public function show(){
		$id = intval($_GET['id']);

		if($_GET['buy'] == 1 ){
			// 检测是否登录
			$phpcms_auth = param::get_cookie('auth');
			if(!$phpcms_auth){
				showmessage('请先登录，跳转中..', '?m=member&a=login&forward='.urlencode(HTTP_REFERER));
			}
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

		// 判断用户是否登录，且用户是否购买此视频
		if(is_login()){
			pc_base::load_sys_class('param');
			$userid = param::get_cookie('_userid');
			$train_order_model = pc_base::load_model('train_order_model');

			$where = array(
				'user_id'=>$userid,
				'lesson_id'=>$id,
				'status' => '2',
			);
			if($train_order_model->count($where)){
				$is_buy = 1;
			} else {
				$is_buy = 0;
			}

			$is_login = 1;
		} else {
			$is_buy = 0;
			$is_login = 0;
		}

		$layui = 1;
		$siteid = SITEID;
		$SEO = seo($siteid);
		$SEO['title'] = "{$info['title']} - ";
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
		$userinfo = $member_model->get_one(array('userid'=>$userid));

		$train_order_model = pc_base::load_model('train_order_model');
		$count = $train_order_model->count(array('lesson_id'=>$id, 'user_id'=>$userid));
		if($count) {
			showmessage('您已报名此课程', HTTP_REFERER);
		}

		$account = $userinfo['mobile'] ? $userinfo['mobile'] : $userinfo['email'];

		$data = array(
			'lesson_id'=>$id,
			'user_id'=>$userid,
			'mobile' => $account,
			'price' => $info['price'],
		);
		if($train_order_model->insert($data)){
			if($info['is_interview']){
				showmessage('已收到您的报名申请<br>请尽快联系工作人员预约面试。', HTTP_REFERER, "3000");
			} else {
				showmessage('下单成功，去付款', "index.php?m=train&a=pay&id=$id");
			}
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
		$SEO = seo($siteid);
		$SEO['title'] = "支付 - {$info['title']} - ";
		include template('train', 'pay');
	}
}