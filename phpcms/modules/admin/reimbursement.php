<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);
class reimbursement extends admin {
	public $siteid;
	function __construct() {
		parent::__construct();
		$this->siteid = $this->get_siteid();
	}
	
	/**
	 * 报销人汇总列表
	 */
	public function init () {

		$pernum = 15;
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		$limit_start = ($page-1)*$pernum;
		$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

		$where = '1';
		if($_GET['searchType'] && $keyword != ''){
			if($_GET['searchType'] == 'fullname'){
				$where .= " and fullname='$keyword'";
			}
			if($_GET['searchType'] == 'ID_number'){
				$where .= " and ID_number='$keyword'";
			}
		}

		$reimbursement_model = pc_base::load_model('member_reimbursement_model');
		$all_result = $reimbursement_model->select($where, '*', '', '', 'member_id');
		$count = count($all_result);

		$datas = $reimbursement_model->select($where, '*', "$limit_start, $pernum", 'id desc', 'member_id');
		$pages = pages($count, $page, $pernum);

		include $this->admin_tpl('reimbursement');
	}

	// 报销汇总
	public function summary(){

		$pernum = 15;
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		$limit_start = ($page-1)*$pernum;
		$start_time = isset($_GET['start_time']) ? $_GET['start_time'] : '';
		$end_time = isset($_GET['end_time']) ? $_GET['end_time'] : '';

		$where = '1';
		if($start_time && $end_time){
			$where .= " and status=2 and audit_date between '{$start_time}' and '{$end_time}' group by member_id";

			// 导出
			if($_GET['export']){
				$this->export($where);
			}

			$reimbursement_model = pc_base::load_model('member_reimbursement_model');
			
			$count = $reimbursement_model->count($where);
			$sql = "select fullname, ID_number, sum(amount) sum_amount from phpcms_member_reimbursement where {$where} order by id desc limit $limit_start, $pernum";
			$reimbursement_model->query($sql);
			$datas = $reimbursement_model->fetch_array();

			$pages = pages($count, $page, $pernum);
		}

		
		pc_base::load_sys_class('form');
		include $this->admin_tpl('reimbursement_summary');
	}

	// 导出报销汇总
	public function export($where){

		$reimbursement_model = pc_base::load_model('member_reimbursement_model');
			
		$sql = "select fullname, ID_number, sum(amount) sum_amount from phpcms_member_reimbursement where {$where} order by id desc";
		$reimbursement_model->query($sql);
		$datas = $reimbursement_model->fetch_array();

		$csvcontent = "姓名,身份证号,累计有效支付,补充报销95%";

		foreach ($datas as $item) {
			extract($item);
			// $mark = str_replace(array(',', "\r\n", "\r", "\n", ' '), array('，',''), $mark);

			$csvcontent .= "\r\n"
				.$fullname.','
				.$ID_number."\t".','
				.$sum_amount.','
				.sprintf('%.2f', $sum_amount*0.95)
				;
		}

		$csvcontent = mb_convert_encoding($csvcontent,'gb2312','utf-8');
		$filename = "报销汇总.csv";
		doexport($csvcontent, $filename);
	}

	public function getOneMember(){
		$member_id = $_GET['member_id'];

		$resume_model = pc_base::load_model('member_resume_model');
		$reimbursement_model = pc_base::load_model('member_reimbursement_model');

		$memberinfo = $resume_model->get_one(array('member_id'=>$member_id), 'surname, firstname, sex, ID_number');

		$lists = $reimbursement_model->listinfo(array('member_id'=>$member_id));
		$pages = $this->db->pages;

		$reimbursement_status = pc_base::load_config('enums', 'reimbursement_status_admin');

		include $this->admin_tpl('reimbursement_oneMember');
	}

	public function editOneMember(){
		$reimbursement_model = pc_base::load_model('member_reimbursement_model');
		if($_POST['dosubmit']){
			$id = $_GET['id'];
			$info = $_POST['info'];

			$reimbursement_model->update($info, array('id'=>$id));
			showmessage('修改成功', '', '', 'edit');
		} else {

			$id = $_GET['id'];
			
			$info = $reimbursement_model->get_one(array('id'=>$id));

			extract($info);
			pc_base::load_sys_class('form');
			include $this->admin_tpl('reimbursement_editOneMember');
		}
	}

	public function del(){
		$id = intval($_GET['id']);
		$reimbursement_model = pc_base::load_model('member_reimbursement_model');
		$reimbursement_model->delete(array('id'=>$id));

		showmessage('删除成功', HTTP_REFERER);
	}

	public function changeOneStatus(){
		$id = intval($_GET['id']);
		$status = intval($_GET['status']);

		$reimbursement_model = pc_base::load_model('member_reimbursement_model');
		$reimbursement_model->update(array('status'=>$status, 'audit_date'=>date('Y-m-d')), array('id'=>$id));
		success('更改成功');
	}
}