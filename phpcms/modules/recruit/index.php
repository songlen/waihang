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

		$siteid = SITEID;
		include template('recruit', 'index');
	}

	// 加载更多二类广告
	public function loadMore(){
		// $urlsiteid = (SITEID == 1) ? '' : '&siteid=2'; // 根据站点id 计算url后缀

		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$pagesize = 12;

		if($page == '1'){
			die(json_encode(array('data'=>'', 'pages'=>$pages)));
		}

		$where = array(
			'type'=>'2',
			'status'=>'1',
			'is_delete' => '0',
			'siteid'=>SITEID
		);
		$count = $this->db->count($where); // 总条数
		$pages = ceil($count/$pagesize);

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
			$where = "status = 1 and id in ($job_ids)";
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
		if(!$_SESSION['userid']){
			showmessage('请先登录，跳转中..', '?m=member&a=login');
		}
	}

	// 职位搜索
	public function search(){
		$keyword = isset($_GET['recruit_keyword']) ? $_GET['recruit_keyword'] : '';
		$type = isset($_GET['type']) ? intval($_GET['type']) : 1;
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		
		$job_model = pc_base::load_model('recruit_job_model');

		$where = 'status=1 and type='.$type;
		if($keyword){
			$where .= ' and job_name like "%'.$keyword.'%"';
		}

		$jobs = $job_model->listinfo($where, 'listorder desc, id desc', $page);
		$pages = $this->db->pages;

		$siteid = SITEID;
		include template('recruit', 'job_list');
	}
}