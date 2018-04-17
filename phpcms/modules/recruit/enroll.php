<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);

class enroll extends admin {
	private $db;
	function __construct() {
		parent::__construct();

		$this->db = pc_base::load_model('recruit_enroll_model');
	}
	//首页
	public function init() {
		$show_header = $show_dialog = '';
		// 搜索
		$diploma = isset($_GET['diploma']) ? $_GET['diploma'] : '';
		$height = isset($_GET['height']) ? $_GET['height'] : '';
		$sex = isset($_GET['sex']) ? $_GET['sex'] : '';
		$searchType = isset($_GET['searchType']) ? $_GET['searchType'] : '';
		$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

		$where = 'language="zh"';
		if($_GET['search']){
			if($diploma){
				$where .= " and mr.diploma = $diploma";
			}
			if($height){
				$where .= " and mr.height >= $height";
			}
			if($sex || $sex == "0"){
				$where .= " and mr.sex = $sex";
			}

			if($keyword){
				if($searchType == 'fullname'){
					$where .= " and mr.fullname = '$keyword'";
				}
				if($searchType == 'email'){
					$where .= " and mr.email = '$keyword'";
				}
				if($searchType == 'ID_number'){
					$where .= " and mr.ID_number = '$keyword'";
				}
			}
		}

		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$pernum = 15;
		$limit_start = ($page-1)*$pernum;

		$sql = "SELECT *, re.id  FROM phpcms_recruit_enroll re LEFT JOIN phpcms_member_resume mr on re.member_id=mr.member_id WHERE {$where} order by re.id desc limit {$limit_start}, $pernum";
		$this->db->query($sql);
		$result = $this->db->fetch_array();

		$count = $this->db->count();
		$pages = pages($count, $page, $pernum);

		$enums = pc_base::load_config('enums', 'member');
		$recruit_enroll_status = pc_base::load_config('enums', 'recruit_enroll_status');

		include $this->admin_tpl('enroll_list');
	}

	public function detail(){
		$id = $_GET['id'];

		$recruit_enroll_model = pc_base::load_model('recruit_enroll_model');
		$member_model = pc_base::load_model('member_model');
		$member_resume_model = pc_base::load_model('member_resume_model');
		$member_education_model = pc_base::load_model('member_education_model');
		$member_work_model = pc_base::load_model('member_work_model');
		$member_language_model = pc_base::load_model('member_language_model');

		$enrollinfo = $recruit_enroll_model->get_one(array('id'=>$id));

		// 获取基本信息
		$basicinfo = $member_resume_model->get_one(array('member_id'=>$enrollinfo['member_id']));

		// 头像
		$memberinfo = $member_model->get_one(array('userid'=>$enrollinfo['member_id']), 'headimg');
		// 教育经历
		$educationlist = $member_education_model->select(array('member_id'=>$enrollinfo['member_id'], 'language'=>'zh'), '*', '', 'start_time desc, end_time desc');
		// 工作经历
		$worklist = $member_work_model->select(array('member_id'=>$enrollinfo['member_id'], 'language'=>'zh'), '*', '', 'start_time desc, end_time desc');
		// 外语经历
		$languagelist = $member_language_model->select(array('member_id'=>$enrollinfo['member_id'], 'language'=>'zh'), '*', '', 'id desc');

		
		$enums = pc_base::load_config('enums');

		include $this->admin_tpl('enroll_detail');
	}

	public function ajax_change_status(){
		$id = $_GET['id'];
		$status = $_GET['status'];

		$recruit_enroll = pc_base::load_model('recruit_enroll_model');
		$recruit_enroll->update(array('status'=>$status), array('id'=>$id));

	}
}