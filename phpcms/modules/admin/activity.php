<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);
class activity extends admin {
	private $db;
	public $siteid;
	function __construct() {
		parent::__construct();
		$this->siteid = $this->get_siteid();
	}
	
	/**
	 * 来源管理列表
	 */
	public function init () {
		$type = $_GET['type'];
		$siteid = $this->siteid;

		$page = isset($_GET['page']) ? intval($_GET['page']) : '';

		if($siteid == '1'){
			$catid = $type == 'employee' ? '24' : '19';
			$table_model = pc_base::load_model('news_model');
		}


		$where = array(
			'catid' => $catid,
		);

		$datas = $table_model->listinfo($where, 'listorder desc, id desc', $page);
		$pages = $this->db->pages;

		
		include $this->admin_tpl('activity_list');
	}
	// 报名列表
	public function enroll_list(){
		$activity_id = $_GET['activity_id'];
		$title = $_GET['title'];

		if($_GET['export']){
			$this->export($activity_id, $title);
		}

		$page = isset($_GET['page']) ? intval($_GET['page']) : '';

		$enroll_model = pc_base::load_model('activity_enroll_model');

		$datas = $enroll_model->listinfo(array('activity_id'=>$activity_id), 'id desc', $page);

		include $this->admin_tpl('activity_enroll_list');
	}

	public function export($activity_id, $title = '报名列表'){

		$activity_enroll_model = pc_base::load_model('activity_enroll_model');
		$activity = $activity_enroll_model->select(array('activity_id'=>$activity_id));

		$csvcontent = "姓名,家属人数,联系电话,其他说明,报名时间";

		foreach ($activity as $item) {
			extract($item);
			$mark = str_replace(array(',', "\r\n", "\r", "\n", ' '), array('，',''), $mark);

			$csvcontent .= "\r\n"
				.$fullname.','
				.$people_num.','
				.$phone.','
				.$mark.','
				.date('Y-m-d', strtotime($inputtime))
				;
		}

		$csvcontent = mb_convert_encoding($csvcontent,'gb2312','utf-8');
		$filename = "{$title}报名人员.csv";
		doexport($csvcontent, $filename);
	}
}