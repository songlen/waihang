<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);

class order extends admin {
	private $db;
	function __construct() {
		parent::__construct();

		$this->db = pc_base::load_model('train_order_model');
	}
	//首页
	public function init() {
		$lesson_id = $_GET['lesson_id'];

		$searchType = isset($_GET['searchType']) ? $_GET['searchType'] : '';
		$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$pernum = 20;
		$limit_start = ($page-1)*$pernum;

		$where = "o.lesson_id=$lesson_id and mr.language='zh'";
		if($_GET['search']){
			if($searchType == 'title' && $keyword){
				$where .= " and l.title like '%{$keyword}%'";
			}
			if($searchType == 'fullname' && $keyword){
				$where .= " and mr.fullname like '%{$keyword}%'";
			}
			if($searchType == 'account' && $keyword){
				$where .= " and o.mobile = '{$keyword}'";
			}
		}

		if($_GET['export']){
			$this->export($where, $lesson_id);
		}

		// 订单列表数据
		$sql = "select o.id, o.price, o.mobile, o.status, o.inputtime, mr.member_id, mr.fullname, mr.ID_number, mr.sex, m.headimg from phpcms_train_order as o left join phpcms_member_resume mr on o.user_id=mr.member_id left join phpcms_member m on mr.member_id=m.userid where {$where} order by o.id desc limit {$limit_start},{$pernum}";

		$this->db->query($sql);
		$lists = $this->db->fetch_array();

		$count = $this->db->count();
		$pages = pages($count, $page, $pernum);
		// 枚举字典
		$enums = pc_base::load_config('enums', 'member');
		// 课程信息
		$model_lesson = pc_base::load_model('train_lesson_model');
		$lesson = $model_lesson->get_one(array('id'=>$lesson_id), 'title');

		include $this->admin_tpl('order_list');
	}

	/**
	 * 删除
	 * @param	intval	$sid
	 */
	public function delete() {
  		if((!isset($_GET['id']) || empty($_GET['id'])) && (!isset($_POST['id']) || empty($_POST['id']))) {
			showmessage(L('illegal_parameters'), HTTP_REFERER);
		} else {
			if(is_array($_POST['id'])){
				foreach($_POST['id'] as $id_arr) {
 					//批量删除
					$this->db->delete(array('id'=>$id_arr));
				}
				showmessage(L('operation_success'), HTTP_REFERER);
			}else{
				$id = intval($_GET['id']);

				if($id < 1) return false;
				//删除
				$result = $this->db->delete(array('id'=>$id));
				
				if($result){
					showmessage(L('operation_success'), HTTP_REFERER);
				}else {
					showmessage(L("operation_failure"), HTTP_REFERER);
				}
			}
			showmessage(L('operation_success'), HTTP_REFERER);
		}
	}

	// 导出课程订单
	public function export($where = '', $lesson_id){
		$sql = "select o.id, o.price, o.mobile, o.status, o.inputtime, mr.fullname, mr.ID_number, mr.sex, m.headimg from phpcms_train_order as o left join phpcms_member_resume mr on o.user_id=mr.member_id left join phpcms_member m on mr.member_id=m.userid where {$where} order by o.id desc";

		$this->db->query($sql);
		$result = $this->db->fetch_array();

		$enums = pc_base::load_config('enums', 'member');
		
		$csvcontent = "用户姓名,身份证号,账号,性别,下单时间,订单状态";

		foreach ($result as $item) {
			extract($item);
			// $fullname = str_replace(array(',', "\r\n", "\r", "\n", ' '), array('，',''), $item['fullname']);
			// $sex = $item['sex'] == '1' ? '男' : '女';
			$status = ($status == 1) ? '未支付' : '已支付';
			$csvcontent .= "\r\n"
				.$fullname.','
				.$ID_number."\t".','
				.$mobile."\t".','
				.$enums['sex'][$sex].','
				.$inputtime."\t".','
				.$status
				;
		}
		$csvcontent = mb_convert_encoding($csvcontent,'gb2312','utf-8');
		// 课程信息
		$model_lesson = pc_base::load_model('train_lesson_model');
		$lesson = $model_lesson->get_one(array('id'=>$lesson_id), 'title');

		$filename = '《'.$lesson['title'].'》订单列表.csv';
		doexport($csvcontent, $filename);
	}

	public function ajax_change_status(){
		$id = $_GET['id'];
		$status = $_GET['status'];

		$this->db->update(array('status'=>$status), array('id'=>$id));
	}


	// 查看报名者简历
	public function userResume(){
		$member_id = $_GET['member_id'];

		$language = isset($_GET['language']) ? $_GET['language'] : 'zh';

		$recruit_enterprise_model = pc_base::load_model('recruit_enterprise_model');
		$member_model = pc_base::load_model('member_model');
		$member_resume_model = pc_base::load_model('member_resume_model');
		$member_education_model = pc_base::load_model('member_education_model');
		$member_work_model = pc_base::load_model('member_work_model');
		$member_language_model = pc_base::load_model('member_language_model');


		// 获取基本信息
		$basicinfo = $member_resume_model->get_one(array('member_id'=>$member_id, 'language'=>$language));

		// 头像
		$memberinfo = $member_model->get_one(array('userid'=>$member_id), 'headimg');
		// 教育经历
		$educationlist = $member_education_model->select(array('member_id'=>$member_id, 'language'=>$language), '*', '', 'start_time desc, end_time desc');
		// 工作经历
		$worklist = $member_work_model->select(array('member_id'=>$member_id, 'language'=>$language), '*', '', 'start_time desc, end_time desc');
		// 外语经历
		$languagelist = $member_language_model->select(array('member_id'=>$member_id, 'language'=>$language), '*', '', 'id desc');
		// 如果是英文简历，英文名和中文名抓取中文简历里填写的
		$name = $member_resume_model->get_one(array('member_id'=>$member_id, 'language'=>'zh'), 'fullname, foreign_name');

		$enums = pc_base::load_config('enums', 'member');

		$show_header = false;

		if($language == 'zh'){
			if($_GET['resume'] == '1'){
				include template('member', 'personalResume');
			} else {
				include $this->admin_tpl('userResume');
			}
		} elseif($language == 'en'){
			if($_GET['resume'] == '1'){
				include template('member', 'personalResume_en');
			} else {
				include $this->admin_tpl('userResume_en');
			}
		}

	}
}