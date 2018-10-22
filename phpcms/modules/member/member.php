<?php
/**
 * 管理员后台会员操作类
 */

defined('IN_PHPCMS') or exit('No permission resources.');
//模型缓存路径
define('CACHE_MODEL_PATH',CACHE_PATH.'caches_model'.DIRECTORY_SEPARATOR.'caches_data'.DIRECTORY_SEPARATOR);

pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_sys_class('format', '', 0);
pc_base::load_sys_class('form', '', 0);
pc_base::load_app_func('util', 'content');

class member extends admin {
	
	private $db, $verify_db;
	
	function __construct() {
		parent::__construct();
		$this->db = pc_base::load_model('member_model');
		$this->_init_phpsso();
	}

	/**
	 * defalut
	 */
	function init() {
		$show_header = $show_scroll = true;
		pc_base::load_sys_class('form', '', 0);
		$this->verify_db = pc_base::load_model('member_verify_model');
		
		//搜索框
		$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
		$type = isset($_GET['type']) ? $_GET['type'] : '';
		$groupid = isset($_GET['groupid']) ? $_GET['groupid'] : '';
		$start_time = isset($_GET['start_time']) ? $_GET['start_time'] : date('Y-m-d', SYS_TIME-date('t', SYS_TIME)*86400);
		$end_time = isset($_GET['end_time']) ? $_GET['end_time'] : date('Y-m-d', SYS_TIME);
		$grouplist = getcache('grouplist');
		foreach($grouplist as $k=>$v) {
			$grouplist[$k] = $v['name'];
		}

		$memberinfo['totalnum'] = $this->db->count();
		$memberinfo['vipnum'] = $this->db->count(array('vip'=>1));
		$memberinfo['verifynum'] = $this->verify_db->count(array('status'=>0));

		$todaytime = strtotime(date('Y-m-d', SYS_TIME));
		$memberinfo['today_member'] = $this->db->count("`regdate` > '$todaytime'");
		include $this->admin_tpl('member_init');
	}
	
	/**
	 * member list
	 */
	function manage() {
		//搜索框
		
		$start_time = $_GET['start_time'] ? strtotime($_GET['start_time']) : '';
		$end_time = $_GET['end_time'] ? strtotime($_GET['end_time']) + 3600*24 : '';

		$status = isset($_GET['status']) ? $_GET['status'] : '';	
		$sex = isset($_GET['sex']) ? $_GET['sex'] : '';	
		$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
		$type = isset($_GET['type']) ? $_GET['type'] : '';
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

		$where = '1';
		if (isset($_GET['search'])) {
			
			if($start_time && $end_time){
				//开始时间大于结束时间，置换变量
				$where .= " and `regdate` BETWEEN '$start_time' AND '$end_time' ";
			}

			if($status) {
				$islock = $status == 1 ? 1 : 0;
				$where .= " and `islock` = '$islock' ";
			}

			if($sex) {
				$sex = $sex == 1 ? 1 : 0;
				$where .= " and mr.sex = '$sex' ";
			}

			if($keyword) {
				if ($type == 'fullname') {
					$where .= " and `fullname` like '%$keyword%'";
				}
				if ($type == 'ID_number') {
					$where .= " and `ID_number` = $keyword";
				}
				if ($type == 'mobile') {
					$where .= " and `mobile` = $keyword";
				}
			}
		}

		// 导出
		if($_GET['export']){
			$this->export($where);
		}

		$pernum = 20;
		$limit = ($page-1)*$pernum. ',' .$pernum;
		$sql = "SELECT m.userid, fullname, ID_number, sex, m.mobile, m.email, headimg, is_employee, islock, lastdate FROM phpcms_member m LEFT JOIN phpcms_member_resume mr on mr.member_id=m.userid WHERE {$where} group by userid ORDER BY userid DESC LIMIT $limit";
		$this->db->query($sql);
		$memberlist = $this->db->fetch_array();
		// 分页
		$sql = "SELECT 1 count FROM phpcms_member m LEFT JOIN phpcms_member_resume mr on mr.member_id=m.userid WHERE {$where} group by userid";
		$this->db->query($sql);
		$count_result = $this->db->fetch_array();
		$count = count($count_result);

		$pages = pages($count, $page, $pernum);
		// P($pages);
		// if($memberlist && is_array($memberlist)){
		// 	$member_resume = pc_base::load_model('member_resume_model');
		// 	foreach ($memberlist as &$item) {
		// 		$resume = $member_resume->get_one(array('member_id'=>$item['userid']), 'email');
		// 		$item['email'] = $resume['email'];
		// 	}
		// }

		$enums = pc_base::load_config('enums', 'member');

		$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=member&c=member&a=add\', title:\''.L('member_add').'\', width:\'700\', height:\'500\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('member_add'));
		include $this->admin_tpl('member_list');
	}

	public function export($where = '', $language='zh'){
		ini_set('memory_limit', '256M');
		// 计算总条数
		$sql = "SELECT 1 count FROM phpcms_member m LEFT JOIN phpcms_member_resume mr on mr.member_id=m.userid WHERE {$where} group by userid";
		$this->db->query($sql);
		$count_result = $this->db->fetch_array();
		$count = count($count_result);
		// 每次获取5000条
		$pernum = 5000;
		$pageCount = ceil($count/5000);

		$enums = pc_base::load_config('enums', 'member');
		$csvcontent = "英文名,姓拼音,名拼音,民族,工作年限,政治面貌,年龄,身高,体重,护照有效期,姓名,游泳能力,身上是否有疤痕及纹身,何时可开始工作,性别,毕业日期,身份证号,护照号码,手机,国内座机,邮箱,档案存放地,出生日期,现居住城市,婚姻状况,紧急联系人,紧急联系人电话,户口地址,通讯编码,最高学历、学位,专业,毕业院校,注册时间,登录时间,备注";
		for($page = 1; $page <= $pageCount; $page++){
			$limit_start = ($page-1)*$pernum;

			$sql = "SELECT *, m.mobile account_mobile, m.email account_email  FROM phpcms_member m LEFT JOIN phpcms_member_resume mr on mr.member_id=m.userid WHERE {$where} group by userid ORDER BY userid DESC limit $limit_start, $pernum";

			$this->db->query($sql);
			$result = $this->db->fetch_array();
			foreach ($result as $item) {
				extract($item);
				// $fullname = str_replace(array(',', "\r\n", "\r", "\n", ' '), array('，',''), $item['fullname']);
				// $sex = $item['sex'] == '1' ? '男' : '女';
				if($language == 'zh'){
					$living_city = get_linkage_name($living_province_id).get_linkage_name($living_city_id); // 现居住城市
					$marital_status = $enums['marital_status'][$marital_status]; // 婚姻桩体
					$diploma = $enums['diploma'][$diploma]; // 最高学历、学位
					$swimming_ability = $enums['swimming_ability'][$swimming_ability];
					$political_outlook = $enums['political_outlook'][$political_outlook];
					$nation = $enums['nation'][$nation];
					$sex = $enums['sex'][$sex];
				} else {
					$living_city = get_linkage_name($living_province_id, 'pinyin').get_linkage_name($living_city_id, 'pinyin'); // 现居住城市
					$marital_status = $enums['marital_status_en'][$marital_status]; // 婚姻桩体
					$diploma = $enums['diploma_en'][$diploma]; // 最高学历、学位
					$swimming_ability = $enums['swimming_ability_en'][$swimming_ability];
					$political_outlook = $enums['political_outlook_en'][$political_outlook];
					$nation = $enums['nation_en'][$nation];
					$sex = $enums['sex_en'][$sex];
				}
				
				$foreign_address = ''; // 国外住址
				$foreign_telphone = ''; // 国外电话
				$mark = ''; // 备注

				$csvcontent .= "\r\n"
					.$foreign_name.',' // 英文名
					.$surname_spell.',' // 姓拼音
					.$firstname_spell.',' // 名拼音
					.$nation.',' // 民族
					.$work_experience.',' // 工作年限
					.$political_outlook.',' // 政治面貌
					.$age.',' // 年龄
					.$height.',' // 身高
					.$weight.',' // 体重
					.$passport_deadline."\t".',' // 护照有效期
					.$fullname.',' // 姓名
					.$swimming_ability.',' // 游泳能力
					.$scar_tattoo.',' // 身上是否有疤痕及纹身
					.$start_work_date."\t".',' // 何时可开始工作
					.$sex.',' // 性别
					.$graduation_date."\t".',' // 毕业日期
					.$ID_number."\t".',' // 身份证号
					.$passport_number.',' // 护照号码
					.$mobile_phone."\t".',' // 手机
					.$telphone."\t".',' // 国内座机
					.$email."\t".',' // 邮箱
					.$archiving_organization.',' // 档案存放地
					.$birthday."\t".',' // 出生日期
					.$living_city.',' // 现居住城市
					.$marital_status.','
					.$urgent_name.',' // 紧急联系人
					.$urgent_phone."\t".',' // 紧急联系人电话
					.$address.',' // 户口地址
					.$zip_code.',' // 通讯编码
					.$diploma.',' // 最高学历、学位
					.$profession.',' // 专业
					.$graduation_university.',' // 毕业院校
					.date('Y-m-d', $regdate).',' // 注册时间
					.date('Y-m-d', $lastdate).',' // 登录时间
					.$mark.',' // 备注
					;
			}
			
		}

		$csvcontent = mb_convert_encoding($csvcontent,'gb2312','utf-8');
		$filename = '人才库名单.csv';
		doexport($csvcontent, $filename);
	}
		
	/**
	 * add member
	 */
	function add() {
		header("Cache-control: private");
		if(isset($_POST['dosubmit'])) {
			$info = array();
			// if(!$this->_checkname($_POST['info']['username'])){
			// 	showmessage(L('member_exist'));
			// }
			// $info = $this->_checkuserinfo($_POST['info']);
			$info = $_POST['info'];
			if(!$this->_checkpasswd($info['password'])){
				showmessage(L('password_format_incorrect'));
			}

			unset($info['pwdconfirm']);			
			$info['regip'] = ip();
			$info['encrypt'] = create_randomstr(6);
			$info['password'] = password($info['password'], $info['encrypt']);
			$info['regdate'] = $info['lastdate'] = SYS_TIME;
			
			$this->db->insert($info);
			if($this->db->insert_id()){
				showmessage(L('operation_success'),'?m=member&c=member&a=add', '', 'add');
			}
		} else {
			$show_header = $show_scroll = true;
			$siteid = get_siteid();
			//会员组缓存
			$group_cache = getcache('grouplist', 'member');
			foreach($group_cache as $_key=>$_value) {
				$grouplist[$_key] = $_value['name'];
			}
			//会员模型缓存
			$member_model_cache = getcache('member_model', 'commons');
			foreach($member_model_cache as $_key=>$_value) {
				if($siteid == $_value['siteid']) {
					$modellist[$_key] = $_value['name'];
				}
			}
			
			include $this->admin_tpl('member_add');
		}
		
	}
	
	/**
	 * edit member
	 */
	function edit() {
		if(isset($_POST['dosubmit'])) {

			$info = $_POST['info'];
			$userid = $info['userid'];
			
			unset($info['userid']);
			
			//如果密码不为空，修改用户密码。
			if($info['password'] && $info['pwdconfirm']) {
				if($info['password'] != $info['pwdconfirm']){
					showmessage('两次密码不一致');
				}
				$encrypt = create_randomstr(6);
				$info['encrypt'] = $encrypt;
				$info['password'] = password($info['password'], $encrypt);
				unset($info['pwdconfirm']);
			} else {
				unset($info['password']);
				unset($info['pwdconfirm']);
			}

			$this->db->update($info, array('userid'=>$userid));
			// 政治面貌
			$political_outlook = $_POST['political_outlook'];
			if($political_outlook){
				$member_resume_model = pc_base::load_model('member_resume_model');
				$count = $member_resume_model->count(array('member_id'=>$userid, 'language'=>'zh'));
				if($count){
					$member_resume_model->update(array('political_outlook'=>$political_outlook), array('member_id'=>$userid));
				} else {
					$resume = array(
						'member_id'=>$userid,
						'political_outlook' => $political_outlook,
						'language'=>'zh',
					);
					$member_resume_model->insert($resume);
				}
			}
			
			showmessage(L('operation_success'), '?m=member&c=member&a=manage', '', 'edit');
			
		} else {
			$show_header = $show_scroll = true;
			$siteid = get_siteid();
			$userid = isset($_GET['userid']) ? $_GET['userid'] : showmessage(L('illegal_parameters'), HTTP_REFERER);
			
			//会员组缓存
			$group_cache = getcache('grouplist', 'member');
			foreach($group_cache as $_key=>$_value) {
				$grouplist[$_key] = $_value['name'];
			}

			//会员模型缓存
			$member_model_cache = getcache('member_model', 'commons');
			foreach($member_model_cache as $_key=>$_value) {
				if($siteid == $_value['siteid']) {
					$modellist[$_key] = $_value['name'];
				}
			}
			
			//如果是超级管理员角色，显示所有用户，否则显示当前站点用户
			if($_SESSION['roleid'] == 1) {
				$where = array('userid'=>$userid);
			} else {
				$where = array('userid'=>$userid, 'siteid'=>$siteid);
			}

			$memberinfo = $this->db->get_one($where);
			
			if(empty($memberinfo)) {
				showmessage(L('user_not_exist').L('or').L('no_permission'), HTTP_REFERER);
			}
			
			$memberinfo['avatar'] = get_memberavatar($memberinfo['phpssouid'], '', 90);
			
			$modelid = isset($_GET['modelid']) ? $_GET['modelid'] : $memberinfo['modelid'];
			
			//获取会员模型表单
			require CACHE_MODEL_PATH.'member_form.class.php';
			$member_form = new member_form($modelid);
			
			$form_overdudate = form::date('info[overduedate]', date('Y-m-d H:i:s',$memberinfo['overduedate']), 1);
			$this->db->set_model($modelid);
			$membermodelinfo = $this->db->get_one(array('userid'=>$userid));
			$forminfos = $forminfos_arr = $member_form->get($membermodelinfo);
			
			//万能字段过滤
			foreach($forminfos as $field=>$info) {
				if($info['isomnipotent']) {
					unset($forminfos[$field]);
				} else {
					if($info['formtype']=='omnipotent') {
						foreach($forminfos_arr as $_fm=>$_fm_value) {
							if($_fm_value['isomnipotent']) {
								$info['form'] = str_replace('{'.$_fm.'}',$_fm_value['form'], $info['form']);
							}
						}
						$forminfos[$field]['form'] = $info['form'];
					}
				}
			}

			$enums_member = pc_base::load_config('enums', 'member');
			$member_resume_model = pc_base::load_model('member_resume_model');
			$resumeinfo = $member_resume_model->get_one(array('member_id'=> $userid, 'language'=>'zh'));

			$show_dialog = 1;
			include $this->admin_tpl('member_edit');		
		}
	}
	
	/**
	 * delete member
	 */
	function delete() {
		$uidarr = isset($_POST['userid']) ? $_POST['userid'] : showmessage(L('illegal_parameters'), HTTP_REFERER);
		$uidarr = array_map('intval',$uidarr);
		$where = to_sqls($uidarr, '', 'userid');
		$phpsso_userinfo = $this->db->listinfo($where);
		$phpssouidarr = array();
		if(is_array($phpsso_userinfo)) {
			foreach($phpsso_userinfo as $v) {
				if(!empty($v['phpssouid'])) {
					$phpssouidarr[] = $v['phpssouid'];
				}
			}
		}
		//查询用户信息
		$userinfo_arr = $this->db->select($where, "userid, modelid");
		$userinfo = array();
		if(is_array($userinfo_arr)) {
			foreach($userinfo_arr as $v) {
				$userinfo[$v['userid']] = $v['modelid'];
			}
		}
		//delete phpsso member first
		if(!empty($phpssouidarr)) {
			$status = $this->client->ps_delete_member($phpssouidarr, 1);
			if($status > 0) {
				if ($this->db->delete($where)) {
					
					//删除用户模型用户资料
					foreach($uidarr as $v) {
						if(!empty($userinfo[$v])) {
							$this->db->set_model($userinfo[$v]);
							$this->db->delete(array('userid'=>$v));
						}
					}
				
					showmessage(L('operation_success'), HTTP_REFERER);
				} else {
					showmessage(L('operation_failure'), HTTP_REFERER);
				}
			} else {
				showmessage(L('operation_failure'), HTTP_REFERER);
			}
		} else {
			if ($this->db->delete($where)) {
				showmessage(L('operation_success'), HTTP_REFERER);
			} else {
				showmessage(L('operation_failure'), HTTP_REFERER);
			}
		}
	}

	/**
	 * lock member
	 */
	function lock() {
		if(isset($_POST['userid'])) {
			$uidarr = isset($_POST['userid']) ? $_POST['userid'] : showmessage(L('illegal_parameters'), HTTP_REFERER);
			$where = to_sqls($uidarr, '', 'userid');
			$this->db->update(array('islock'=>1), $where);
			showmessage(L('member_lock').L('operation_success'), HTTP_REFERER);
		} else {
			showmessage(L('operation_failure'), HTTP_REFERER);
		}
	}
	
	/**
	 * unlock member
	 */
	function unlock() {
		if(isset($_POST['userid'])) {
			$uidarr = isset($_POST['userid']) ? $_POST['userid'] : showmessage(L('illegal_parameters'), HTTP_REFERER);
			$where = to_sqls($uidarr, '', 'userid');
			$this->db->update(array('islock'=>0), $where);
			showmessage(L('member_unlock').L('operation_success'), HTTP_REFERER);
		} else {
			showmessage(L('operation_failure'), HTTP_REFERER);
		}
	}

	public function changeEmployee(){
		if(isset($_POST['userid'])) {
			$uidarr = isset($_POST['userid']) ? $_POST['userid'] : showmessage(L('illegal_parameters'), HTTP_REFERER);
			$type = $_GET['type'];
			$where = to_sqls($uidarr, '', 'userid');
			$this->db->update(array('is_employee'=>$type), $where);
			showmessage('操作成功', HTTP_REFERER);
		} else {
			showmessage(L('operation_failure'), HTTP_REFERER);
		}
	}

	/**
	 * move member
	 */
	function move() {
		if(isset($_POST['dosubmit'])) {
			$uidarr = isset($_POST['userid']) ? $_POST['userid'] : showmessage(L('illegal_parameters'), HTTP_REFERER);
			$groupid = isset($_POST['groupid']) && !empty($_POST['groupid']) ? $_POST['groupid'] : showmessage(L('illegal_parameters'), HTTP_REFERER);
			
			$where = to_sqls($uidarr, '', 'userid');
			$this->db->update(array('groupid'=>$groupid), $where);
			showmessage(L('member_move').L('operation_success'), HTTP_REFERER, '', 'move');
		} else {
			$show_header = $show_scroll = true;
			$grouplist = getcache('grouplist');
			foreach($grouplist as $k=>$v) {
				$grouplist[$k] = $v['name'];
			}
			
			$ids = isset($_GET['ids']) ? explode(',', $_GET['ids']): showmessage(L('illegal_parameters'), HTTP_REFERER);
			array_pop($ids);
			if(!empty($ids)) {
				$where = to_sqls($ids, '', 'userid');
				$userarr = $this->db->listinfo($where);
			} else {
				showmessage(L('illegal_parameters'), HTTP_REFERER, '', 'move');
			}
			
			include $this->admin_tpl('member_move');
		}
	}

	function memberinfo() {
		$show_header = false;
		
		$userid = !empty($_GET['userid']) ? intval($_GET['userid']) : '';
		$username = !empty($_GET['username']) ? trim($_GET['username']) : '';
		if(!empty($userid)) {
			$memberinfo = $this->db->get_one(array('userid'=>$userid));
		} elseif(!empty($username)) {
			$memberinfo = $this->db->get_one(array('username'=>$username));
		} else {
			showmessage(L('illegal_parameters'), HTTP_REFERER);
		}
		
		if(empty($memberinfo)) {
			showmessage(L('user').L('not_exists'), HTTP_REFERER);
		}

		$member_resume_model = pc_base::load_model('member_resume_model');
		$member_education_model = pc_base::load_model('member_education_model');
		$member_work_model = pc_base::load_model('member_work_model');
		$member_language_model = pc_base::load_model('member_language_model');

		// 获取基本信息
		$basicinfo = $member_resume_model->get_one(array('member_id'=>$userid, 'language'=>'zh'));

		// 教育经历
		$educationlist = $member_education_model->select(array('member_id'=>$userid, 'language'=>'zh'), '*', '', 'start_time desc, end_time desc');
		// 工作经历
		$worklist = $member_work_model->select(array('member_id'=>$userid, 'language'=>'zh'), '*', '', 'start_time desc, end_time desc');
		// 外语经历
		$languagelist = $member_language_model->select(array('member_id'=>$userid, 'language'=>'zh'), '*', '', 'id desc');

		
		$enums = pc_base::load_config('enums');


		include $this->admin_tpl('member_moreinfo');
	}

	/*
	 * 通过linkageid获取名字路径
	 */
	private function _get_linkage_fullname($linkageid,  $linkagelist) {
		$fullname = '';
		if($linkagelist['data'][$linkageid]['parentid'] != 0) {
			$fullname = $this->_get_linkage_fullname($linkagelist['data'][$linkageid]['parentid'], $linkagelist);
		}
		//所在地区名称
		$return = $fullname.$linkagelist['data'][$linkageid]['name'].'>';
		return $return;
	}
	
	private function _checkuserinfo($data, $is_edit=0) {
		if(!is_array($data)){
			showmessage(L('need_more_param'));return false;
		} elseif (!is_username($data['username']) && !$is_edit){
			showmessage(L('username_format_incorrect'));return false;
		} elseif (!isset($data['userid']) && $is_edit) {
			showmessage(L('username_format_incorrect'));return false;
		}  elseif (empty($data['email']) || !is_email($data['email'])){
			showmessage(L('email_format_incorrect'));return false;
		}
		return $data;
	}
		
	private function _checkpasswd($password){
		if (!is_password($password)){
			return false;
		}
		return true;
	}
	
	private function _checkname($username) {
		$username =  trim($username);
		if ($this->db->get_one(array('username'=>$username))){
			return false;
		}
		return true;
	}
	
	/**
	 * 初始化phpsso
	 * about phpsso, include client and client configure
	 * @return string phpsso_api_url phpsso地址
	 */
	private function _init_phpsso() {
		pc_base::load_app_class('client', '', 0);
		define('APPID', pc_base::load_config('system', 'phpsso_appid'));
		$phpsso_api_url = pc_base::load_config('system', 'phpsso_api_url');
		$phpsso_auth_key = pc_base::load_config('system', 'phpsso_auth_key');
		$this->client = new client($phpsso_api_url, $phpsso_auth_key);
		return $phpsso_api_url;
	}
	
	/**
	 * 检查用户名
	 * @param string $username	用户名
	 * @return $status {-4：用户名禁止注册;-1:用户名已经存在 ;1:成功}
	 */
	public function public_checkname_ajax() {
		$username = isset($_GET['username']) && trim($_GET['username']) ? trim($_GET['username']) : exit(0);
		if(CHARSET != 'utf-8') {
			$username = iconv('utf-8', CHARSET, $username);
			$username = addslashes($username);
		}

		$status = $this->client->ps_checkname($username);
			
		if($status == -4 || $status == -1) {
			exit('0');
		} else {
			exit('1');
		}
		
	}
	
	/**
	 * 检查邮箱
	 * @param string $email
	 * @return $status {-1:email已经存在 ;-5:邮箱禁止注册;1:成功}
	 */
	public function public_checkemail_ajax() {
		$email = isset($_GET['email']) && trim($_GET['email']) ? trim($_GET['email']) : exit(0);
		
		$status = $this->client->ps_checkemail($email);
		if($status == -5) {	//禁止注册
			exit('0');
		} elseif($status == -1) {	//用户名已存在，但是修改用户的时候需要判断邮箱是否是当前用户的
			if(isset($_GET['phpssouid'])) {	//修改用户传入phpssouid
				$status = $this->client->ps_get_member_info($email, 3);
				if($status) {
					$status = unserialize($status);	//接口返回序列化，进行判断
					if (isset($status['uid']) && $status['uid'] == intval($_GET['phpssouid'])) {
						exit('1');
					} else {
						exit('0');
					}
				} else {
					exit('0');
				}
			} else {
				exit('0');
			}
		} else {
			exit('1');
		}
	}
	
	public function public_checkmobile_ajax() {
		$mobile = isset($_GET['mobile']) && trim($_GET['mobile']) ? trim($_GET['mobile']) : exit(0);
		$userid = isset($_GET['userid']) ? intval($_GET['userid']) : '';

		$where = "mobile = $mobile";
		if($userid){
			$where .= " and userid != $userid";
		}

		$count = $this->db->count($where);

		if($count){
			exit('0');
		} else {
			exit('1');
		}
	}
}