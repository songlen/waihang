<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);

class recruit extends admin {
	private $db;
	function __construct() {
		parent::__construct();

		$this->db = pc_base::load_model('recruit_recruit_model');
		$this->job_db = pc_base::load_model('recruit_job_model');
	}
	//首页
	public function init() {
		$show_header = $show_dialog = '';
		// 搜索

		$where = 'is_delete = 0';
		if(isset($_GET['keyword']) && $_GET['keyword'] != ''){
			$keyword = new_addslashes($_GET['keyword']);
			$where = " and title like '%{$keyword}%'";
		}
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$infos = $this->db->listinfo($where, $order = 'listorder desc, id desc', $page, 20);
		$pages = $this->db->pages;

		include $this->admin_tpl('recruit_list');
	}
	
	//添加
 	public function add() {
 		if(isset($_POST['dosubmit'])) {
			if(empty($_POST['info']['title'])) {
				showmessage('广告标题不能为空', HTTP_REFERER);
			} else {
				$_POST['info']['title'] = safe_replace($_POST['info']['title']);
			}

			$data = new_addslashes($_POST['info']);
			$data['job_ids'] = ','.implode(',', $data['job_ids']).',';

			$data = array_merge($data, array(
				'inputtime' => SYS_TIME,
			));
			$id = $this->db->insert($data, true);
			//更新附件状态
			if(pc_base::load_config('system','attachment_stat') & $_POST['info']['image']) {
				$this->attachment_db = pc_base::load_model('attachment_model');
				$this->attachment_db->api_update($_POST['info']['image'], 'recruit-'.$id, 1);
			}
			if(!$id){
				showmessage(L('operation_failure'), HTTP_REFERER, '', 'add');
			} 

			showmessage(L('operation_success'), HTTP_REFERER, '', 'add');
		} else {
			$show_validator = $show_scroll = $show_header = true;
			pc_base::load_sys_class('form', '', 0);

 			include $this->admin_tpl('recruit_add');
		}
	}
 
	public function edit() {
		if(isset($_POST['dosubmit'])){
 			$id = intval($_GET['id']);
			if($id < 1) return false;
			if(!is_array($_POST['info']) || empty($_POST['info'])) return false;
			if((!$_POST['info']['title']) || empty($_POST['info']['title'])) return false;

			$data = new_addslashes($_POST['info']);
			$data['job_ids'] = ','.implode(',', $data['job_ids']).',';

			$this->db->update($data, array('id'=>$id));

			//更新附件状态
			if(pc_base::load_config('system','attachment_stat') & $_POST['info']['image']) {
				$this->attachment_db = pc_base::load_model('attachment_model');
				$this->attachment_db->api_update($_POST['info']['image'], 'recruit-'.$id, 1);
			}

			showmessage(L('operation_success'), HTTP_REFERER,'', 'edit');
			
		}else{
 			$show_validator = $show_scroll = $show_header = true;
			pc_base::load_sys_class('form', '', 0);
			
			//解出内容
			$info = $this->db->get_one(array('id'=>$_GET['id']));
			if(!$info) showmessage('该内容不存在');
			// 处理职位
			$info['jobinfos'] = array();
			$job_ids = trim($info['job_ids'], ',');
			$job_ids_arr = explode(',', $job_ids);

			if(is_array($job_ids_arr) && !empty(current($job_ids_arr))){
				$info['jobinfos'] = $this->job_db->select("id in ({$job_ids})", 'id, job_name');
			}

			extract($info); 

 			include $this->admin_tpl('recruit_edit');
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
	 * @param	intval	$sid	
	 */
	public function delete() {
  		if((!isset($_GET['id']) || empty($_GET['id'])) && (!isset($_POST['id']) || empty($_POST['id']))) {
			showmessage(L('illegal_parameters'), HTTP_REFERER);
		} else {
			if(is_array($_POST['id'])){
				foreach($_POST['id'] as $id_arr) {
 					//批量删除
					$this->db->update(array('is_delete'=>'1') ,array('id'=>$id_arr));
				}
				showmessage(L('operation_success'), HTTP_REFERER);
			}else{
				$id = intval($_GET['id']);

				if($id < 1) return false;
				//删除
				$result = $this->db->update(array('is_delete'=>'1') ,array('id'=>$id));
				
				if($result){
					showmessage(L('operation_success'), HTTP_REFERER);
				}else {
					showmessage(L("operation_failure"), HTTP_REFERER);
				}
			}
			showmessage(L('operation_success'), HTTP_REFERER);
		}
	}


	public function generateCode($num = 8){
		$str = 'abcdefghigklmnopqrstuvwxyz0123456789ABCDEFGHIGKLMNOPQRSTUVWXYZ';

		if($num < 1) return false;

		$r = '';
		for ($i=0; $i < $num; $i++) { 
			$r .= $str[mt_rand(0, strlen($str)-1)];
		}

		// 检测编码是否重复
		$iscode = $this->db->get_one(array('code'=>$code));
		if($iscode) $this->generateCode($num);

		return $r;
	}
}
?>