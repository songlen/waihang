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

	public function enroll_list(){
		$activity_id = $_GET['activity_id'];
		$title = $_GET['title'];
		$page = isset($_GET['page']) ? intval($_GET['page']) : '';

		$enroll_model = pc_base::load_model('activity_enroll_model');

		$datas = $enroll_model->listinfo(array('activity_id'=>$activity_id), 'id desc', $page);

		include $this->admin_tpl('activity_enroll_list');
	}
}