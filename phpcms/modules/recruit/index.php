<?php
defined('IN_PHPCMS') or exit('No permission resources.');
class index {
	function __construct() {
		pc_base::load_app_func('global');
		$siteid = isset($_GET['siteid']) ? intval($_GET['siteid']) : get_siteid();
  		define("SITEID",$siteid);

  		$this->db = pc_base::load_model('recruit_recruit_model');
	}
	
	public function init() {
		// $urlsiteid = (SITEID == 1) ? '' : '&siteid=2';// 根据站点id 计算url后缀

		// 一类广告
		$where = array(
			'type'=>'1',
			'status'=>'1',
			'is_delete' => '0',
			'siteid'=>SITEID
		);
		$recruits1 = $this->db->select($where, 'id, title, image', 4, 'listorder desc, id desc');
		if(!empty($recruits1) && is_array($recruits1)){
			foreach ($recruits1 as &$v) {
				$v['url'] = '?m=recruit&a=show&id='.$v['id'];
			}
		}
		// 二类广告
		$where['type'] = '2';
		$recruits2 = $this->db->select($where, 'id, title, image', 12, 'listorder desc, id desc');
		if(!empty($recruits2) && is_array($recruits2)){
			foreach ($recruits2 as &$v) {
				$v['url'] = '?m=recruit&a=show&id='.$v['id'];
			}
		}

		// 文字广告 - 空乘类
		$where['type'] = '3';
		$where['category'] = '1'; 
		$kongcheng = $this->db->select($where, 'id, title', 12, 'listorder desc, id desc');
		if(!empty($kongcheng) && is_array($kongcheng)){
			foreach ($kongcheng as &$v) {
				$v['url'] = '?m=recruit&a=show&id='.$v['id'];
			}
		}

		// 文字广告 - 非空乘类
		$where['category'] = '2'; 
		$feikongcheng = $this->db->select($where, 'id, title', 12, 'listorder desc, id desc');
		if(!empty($feikongcheng) && is_array($feikongcheng)){
			foreach ($feikongcheng as &$v) {
				$v['url'] = '?m=recruit&a=show&id='.$v['id'];
			}
		}

		$siteid = SITEID;
		include template('recruit', 'index');
	}

	// 加载更多二类广告
	public function loadMore(){
		// $urlsiteid = (SITEID == 1) ? '' : '&siteid=2'; // 根据站点id 计算url后缀

		$type = isset($_GET['type']) ? intval($_GET['type']) : '2';
		$category = isset($_GET['category']) ? intval($_GET['category']) : '';
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$pagesize = 12;


		$where = array(
			'type'=> $type,
			'status'=>'1',
			'is_delete' => '0',
			'siteid'=>SITEID
		);

		// 如果是文字广告
		if($category){
			$where['category'] = $category;
		}

		$count = $this->db->count($where); // 总条数
		$pages = ceil($count/$pagesize);

		if($page == '1'){
			die(json_encode(array('data'=>'', 'pages'=>$pages)));
		}
		// 二类广告
		$data = $this->db->listinfo($where, 'listorder desc, id desc', $page, $pagesize);
		if(!empty($data) && is_array($data)){
			foreach ($data as &$v) {
				$v['url'] = '?m=recruit&a=show&id='.$v['id'];
			}
		}

		echo json_encode(array('data'=> $data, 'pages'=>$pages));
	}

	// 职位广告详情
	public function show(){
		$id = intval($_GET['id']);

		$where = array(
			'id' => $id,
			'status' => '1',
			'is_delete' => '0',
		);
		$data = $this->db->get_one($where, 'id, title, content, job_ids');

		if(empty($data)) {
			showmessage('数据不存在');
		}

		// 处理职位
		$job_ids = trim($data['job_ids'], ',');

		if(empty($job_ids)){
			$jobs = array();
		} else {
			$job_model = pc_base::load_model('recruit_job_model');
			$where = "status = 1 and is_delete = '0' and id in ($job_ids)";
			$jobs = $job_model->select($where, 'id, job_name');
		}

		extract($data);

		$siteid = SITEID;
		include template('recruit', 'show');
	}

	// 应聘职位
	public function enroll(){
		$job_id = intval($_GET['job_id']);
		if(!$job_id){
			showmessage('请选择职位', HTTP_REFERER);
		}

		// 检测是否登录
		$phpcms_auth = param::get_cookie('auth');
		if(!$phpcms_auth){
			showmessage('请先登录，跳转中..', '?m=member&a=login&forward='.urlencode(HTTP_REFERER));
		}
		$userid = param::get_cookie('_userid');

		// 检测简历是否完整
		$resume_model = pc_base::load_model('member_resume_model');
		if($resume_model->count(array('member_id'=>$userid, 'language'=>'zh')) < 1){
			showmessage('请完善基本资料', '?m=member');
		}
		if($resume_model->count(array('member_id'=>$userid, 'language'=>'en')) < 1){
			showmessage('请完善基本资料', '?m=member');
		}
		$edu_model = pc_base::load_model('member_education_model');
		if($edu_model->count(array('member_id'=>$userid, 'language'=>'zh')) < 1){
			showmessage('请完善教育经历', '?m=member&a=education');
		}
		if($edu_model->count(array('member_id'=>$userid, 'language'=>'en')) < 1){
			showmessage('请完善教育经历', '?m=member&a=education&l=en');
		}
		$work_model = pc_base::load_model('member_work_model');
		if($work_model->count(array('member_id'=>$userid, 'language'=>'zh')) < 1){
			showmessage('请完善工作经历', '?m=member&a=work');
		}
		if($work_model->count(array('member_id'=>$userid, 'language'=>'en')) < 1){
			showmessage('请完善工作经历', '?m=member&a=work&l=en');
		}
		$language_model = pc_base::load_model('member_language_model');
		if($language_model->count(array('member_id'=>$userid, 'language'=>'zh')) < 1){
			showmessage('请完善外语经历', '?m=member&a=language');
		}		
		if($language_model->count(array('member_id'=>$userid, 'language'=>'en')) < 1){
			showmessage('请完善外语经历', '?m=member&a=language&l=en');
		}

		// 检查头像是否上传
		$member_model = pc_base::load_model('member_model');
		$member = $member_model->get_one(array('userid'=>$userid), 'headimg, bodyimg, is_working');

		if(empty($member['headimg']) || empty($member['bodyimg'])){
			showmessage('请完善图像信息', '?m=member&a=pic');
		}

		// 检测是否在职
		if($member['is_working'] == '1'){
			showmessage('您是在职状态，无法申请职位', HTTP_REFERER);
		}

		$job_model = pc_base::load_model('recruit_job_model');
		$jobinfo = $job_model->get_one(array('id'=>$job_id, 'status'=>'1', 'is_delete'=>'0'), 'enterprise_id, code');
		if(empty($jobinfo)){
			showmessage('该职位不存在或停止报名', HTTP_REFERER);
		}

		// 检测是否已经报名
		$enroll_model = pc_base::load_model('recruit_enroll_model');
		$where = "member_id=$userid and job_id=$job_id or job_code='{$jobinfo['code']}'";
		if($enroll_model->count($where)){
			showmessage('您已申请过该职位', HTTP_REFERER);
		}
		// 申请写入数据库
		// 生成报名编码 企业缩写(两位)+年月(201808)+四位报名号

		$enterprise_model = pc_base::load_model('recruit_enterprise_model');
		$enterpriseInfo = $enterprise_model->get_one(array('id'=>$jobinfo['enterprise_id']), 'abbreviation');

		$jobtimes = $enroll_model->get_one(array('job_id'=>$job_id), 'max(orderNumber) max_orderNumber');
		$orderNumber = $jobtimes['max_orderNumber']+1;
		$enroll_number = $enterpriseInfo['abbreviation'].date('Ym').str_pad($orderNumber, 4, '0', STR_PAD_LEFT);

		$data = array(
			'member_id'=>$userid,
			'job_id'=>$job_id,
			'job_code'=>$jobinfo['code'],
			'enroll_number'=>$enroll_number,
			'orderNumber' => $orderNumber,
		);
		if($enroll_model->insert($data)){
			showmessage('申请成功，请等待审核', HTTP_REFERER);
		} else {
			showmessage('服务器错误，请稍后再试', HTTP_REFERER);
		}
	}

	// 职位搜索
	public function search(){
		$recruit_keyword = isset($_GET['recruit_keyword']) ? $_GET['recruit_keyword'] : '';
		$type = isset($_GET['type']) ? intval($_GET['type']) : 1;
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		
		$job_model = pc_base::load_model('recruit_job_model');

		$where = 'status=1 and type='.$type;
		if($recruit_keyword){
			$where .= ' and job_name like "%'.$recruit_keyword.'%"';
		}

		$jobs = $job_model->listinfo($where, 'listorder desc, id desc', $page);
		$pages = $this->db->pages;

		$siteid = SITEID;
		include template('recruit', 'job_list');
	}
}