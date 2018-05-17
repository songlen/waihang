<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);

class enterprise extends admin {
	private $db;
	function __construct() {
		parent::__construct();

		$this->db = pc_base::load_model('recruit_enterprise_model');
		$this->db_job = pc_base::load_model('recruit_job_model');
	}
	//首页
	public function init() {
		$show_header = $show_dialog = '';
		// 搜索

		$where = 'is_delete = 0';
		if(isset($_GET['keyword']) && $_GET['keyword'] != ''){
			$keyword = new_addslashes($_GET['keyword']);
			$where .= " and name like '%{$keyword}%'";
		}
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$infos = $this->db->listinfo($where, $order = 'listorder desc, id desc', $page, 20);
		$pages = $this->db->pages;

		include $this->admin_tpl('enterprise_list');
	}
	
	//添加
 	public function add() {
 		if(isset($_POST['dosubmit'])) {
			if(empty($_POST['enterprise']['name'])) {
				showmessage(L('name_noempty'), HTTP_REFERER);
			} else {
				$_POST['enterprise']['name'] = safe_replace($_POST['enterprise']['name']);
			}
			if ($_POST['enterprise']['logo']) {
				$_POST['enterprise']['logo'] = safe_replace($_POST['enterprise']['logo']);
			}
			$data = new_addslashes($_POST['enterprise']);
			$data = array_merge($data, array(
				'inputtime' => SYS_TIME,
			));
			$id = $this->db->insert($data, true);
			if(!$id) return FALSE; 
 			$siteid = $this->get_siteid();
	 		//更新附件状态
			if(pc_base::load_config('system','attachment_stat') & $_POST['enterprise']['logo']) {
				$this->attachment_db = pc_base::load_model('attachment_model');
				$this->attachment_db->api_update($_POST['enterprise']['logo'], 'enterprise-'.$id, 1);
			}
			showmessage(L('operation_success'), HTTP_REFERER, '', 'add');
		} else {
			$show_validator = $show_scroll = $show_header = true;
			pc_base::load_sys_class('form', '', 0);

 			include $this->admin_tpl('enterprise_add');
		}
	}
 
	public function edit() {
		if(isset($_POST['dosubmit'])){
 			$id = intval($_GET['id']);
			if($id < 1) return false;
			if(!is_array($_POST['info']) || empty($_POST['info'])) return false;
			if((!$_POST['info']['name']) || empty($_POST['info']['name'])) return false;
			$info = new_addslashes($_POST['info']);
			$this->db->update($info, array('id'=>$id));
			// 更新职位表中的航司名称
			$this->db_job->update(array('enterprise_name' => $info['name']), array('enterprise_id' => $id));
			//更新附件状态
			if(pc_base::load_config('system','attachment_stat') & $_POST['link']['logo']) {
				$this->attachment_db = pc_base::load_model('attachment_model');
				$this->attachment_db->api_update($_POST['link']['logo'],'enterprise-'.$linkid,1);
			}
			showmessage(L('operation_success'),'?m=link&c=link&a=edit','', 'edit');
			
		}else{
 			$show_validator = $show_scroll = $show_header = true;
			pc_base::load_sys_class('form', '', 0);
			
			//解出内容
			$info = $this->db->get_one(array('id'=>$_GET['id']));
			if(!$info) showmessage(L('enterprise_exit'));
			extract($info); 

 			include $this->admin_tpl('enterprise_edit');
		}

	}

	//更新排序
 	public function listorder() {
		if(isset($_POST['dosubmit'])) {
			foreach($_POST['listorders'] as $id => $listorder) {
				$id = intval($id);
				$this->db->update(array('listorder'=>$listorder),array('id'=>$id));
			}
			showmessage(L('operation_success'),HTTP_REFERER);
		} 
	}

	/**
	 * 删除
	 * @param	intval	$sid	友情链接ID，递归删除
	 */
	public function delete() {
  		if((!isset($_GET['id']) || empty($_GET['id'])) && (!isset($_POST['id']) || empty($_POST['id']))) {
			showmessage(L('illegal_parameters'), HTTP_REFERER);
		} else {
			if(is_array($_POST['id'])){
				foreach($_POST['id'] as $id_arr) {
 					//批量删除友情链接
					$this->db->update(array('is_delete'=>'1') ,array('id'=>$id_arr));
				}
				showmessage(L('operation_success'),'?m=recruit&c=enterprise');
			}else{
				$id = intval($_GET['id']);
				if($id < 1) return false;
				//删除
				$result = $this->db->update(array('is_delete'=>'1') ,array('id'=>$id));
				
				if($result){
					showmessage(L('operation_success'),'?m=recruit&c=enterprise');
				}else {
					showmessage(L("operation_failure"),'?m=recruit&c=enterprise');
				}
			}
			showmessage(L('operation_success'), HTTP_REFERER);
		}
	}

	public function recruitSelectEnterprise() {
		$show_header = $show_dialog = '';
		// 搜索

		$where = '';
		if(isset($_GET['keyword']) && $_GET['keyword'] != ''){
			$keyword = new_addslashes($_GET['keyword']);
			$where = "name like '%{$keyword}%'";
		}
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$infos = $this->db->listinfo($where, $order = 'listorder desc, id desc', $page, 20);
		$pages = $this->db->pages;

		include $this->admin_tpl('enterprise_select_list');
	}
}
?>