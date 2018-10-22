<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);

class extend_setting extends admin {
	private $db;
	function __construct() {
		parent::__construct();

		$this->db = pc_base::load_model('extend_setting_model');
		$this->siteid = $this->get_siteid();
	}
 
	public function edit() {
		if(isset($_POST['dosubmit'])){

			if(!is_array($_POST['setting']) || empty($_POST['setting'])) return false;
			$settings = $_POST['setting'];
			
			// $this->db->update($settings, array('id'=>$id));
			foreach ($settings as $k => $setting) {
				// 检测是否存在该配置
				$where = array('key'=>$k, 'siteid'=>$this->siteid);

				$res = $this->db->get_one($where);
				if($res){
					$this->db->update(array('data'=>$setting), $where);
				} else {
					$data = array(
						'key' => $k,
						'data' => $setting,
						'siteid' => $this->siteid
					);
					$this->db->insert($data);
				}
			}
			
			showmessage(L('operation_success'), HTTP_REFERER);
			
		}else{
 			$show_validator = $show_scroll = $show_header = true;
			pc_base::load_sys_class('form', '', 0);
			
			//解出内容
			$settings = $this->db->select(array('siteid'=>$this->siteid), 'key, data');

			
			$result = array();
			foreach ($settings as $setting) {
				$result[$setting['key']] = $setting['data'];
			}

			extract($result);
			$siteid = $this->siteid;

 			include $this->admin_tpl('extend_setting_edit');
		}

	}
}