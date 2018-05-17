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

		$where = "o.lesson_id=$lesson_id";
		if($_GET['search']){
			if($searchType == 'title' && $keyword){
				$where .= " and l.title like '%{$keyword}%'";
			}
			if($searchType == 'mobile' && $keyword){
				$where .= " and o.mobile = {$keyword}";
			}
		}

		$sql = "select o.id, o.price, o.mobile, o.status, o.inputtime, l.title from phpcms_train_order as o left join phpcms_train_lesson l on o.lesson_id=l.id where {$where} order by o.id desc limit {$limit_start},{$pernum}";

		$this->db->query($sql);
		$lists = $this->db->fetch_array();

		$count = $this->db->count();
		$pages = pages($count, $page, $pernum);

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

	public function ajax_change_status(){
		$id = $_GET['id'];
		$status = $_GET['status'];

		$this->db->update(array('status'=>$status), array('id'=>$id));
	}
}