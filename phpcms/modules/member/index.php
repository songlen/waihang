<?php
/**
 * 会员前台管理中心、账号管理、收藏操作类
 */

defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('foreground');
pc_base::load_sys_class('format', '', 0);
pc_base::load_sys_class('form', '', 0);

class index extends foreground {

	private $member_model;
	
	function __construct() {
		parent::__construct();
		$siteid = isset($_GET['siteid']) ? intval($_GET['siteid']) : get_siteid();
  		define("SITEID",$siteid);

  		$this->member_model = pc_base::load_model('member_model');
  		$this->member_resume_model = pc_base::load_model('member_resume_model');
	}

	/*public function excel(){
		// die('hao');
		include 'spreadsheet-reader/php-excel-reader/excel_reader2.php';
		include 'spreadsheet-reader/SpreadsheetReader.php';

		ini_set('memory_limit', '-1');
		$db_member=pc_base::load_model('member_model');
		$db_member_resume=pc_base::load_model('member_resume_model');

		$reader = new SpreadsheetReader('spreadsheet-reader/waihang.csv');

		foreach ($reader as $k => $row) {

			file_put_contents('mem.log', "\r\n $k ---- $row[25]", FILE_APPEND);
			$encrypt = create_randomstr(6);
			$userinfo = array(
				'username' => $row[25],
				'nickname' => $row[25],
				'regdate' => time(),
				'lastdate' => time(),
				'email' => $row[27],
				'mobile' => $row[25],
				'encrypt' => $encrypt,
				'password' => password('123456', $encrypt),
			);

			$userid = $db_member->insert($userinfo, 1);
			if($userid){
				$userinfo = array(
					'member_id' => $userid,
					'hardware' => $row[0],
					'english_lever' => $row[1],
					'remark' => $row[2],
					'fullname' => $row[10],
					'surname' => $row[11],
					'firstname' => $row[12],
					'surname_spell' => $row[14],
					'firstname_spell' => $row[13],
					'sex' => $row[15],
					'birthday' => $row[16],
					'age' => $row[17],
					'swimming_ability' => $row[18],
					'living_city' => $row[19],
					'registered_residence' => $row[20],
					'education' => $row[21],
					'profession' => $row[22],
					'graduation_university' => $row[23],
					'graduation_date' => $row[24],
					'mobile_phone' => $row[25],
					'telphone' => $row[26],
					'email' => $row[27],
					'ID_number' => $row[28],
					'flight_experience' => $row[29],
					'aviation_experience' => $row[30],
					'work_experience' => $row[31],
					'height' => $row[32],
					'weight' => $row[33],
					'passport_number' => $row[34],
					'passport_deadline' => $row[35],
					'marital_status' => $row[36],
					'nation' => $row[37],
					'political_outlook' => $row[38],
					'mother_name' => $row[39],
					'mother_phone' => $row[40],
					'father_name' => $row[41],
					'father_phone' => $row[42],
					'spouse_name' => $row[43],
					'spouse_phone' => $row[44],
					'archiving_organization' => $row[45],
					'address' => $row[46],
					'zip_code' => $row[47],
				);
				$userinfo = new_addslashes($userinfo);
				$db_member_resume->insert($userinfo);
			}

		}
	}*/

	public function init() {
		$memberinfo = $this->memberinfo;
		if($_POST['dosubmit']){
			$info = $_POST['info'];
			$language = $info['language'];
			$info['member_id'] = $memberinfo['userid'];
			$info['fullname'] = $info['surname'].$info['firstname'];

			$where = array('member_id'=>$info['member_id'], 'language'=>$language);
			$resume_exist = $this->member_resume_model->count($where);
			if($resume_exist){
				$this->member_resume_model->update($info, $where);
			} else {
				$this->member_resume_model->insert($info);
			}
			showmessage('保存成功', "?m=member&l=$language");
		} else {
			
			// 取enum
			$enums = pc_base::load_config('enums', 'member');
			// 语言
			$language = isset($_GET['l']) && in_array($_GET['l'], array('zh', 'en')) ? $_GET['l'] : 'zh';
			
			$layui = true;
			$siteid = SITEID;
			$SEO = seo(SITEID);

			$basicinfo = $this->member_resume_model->get_one(array('member_id'=>$memberinfo['userid'], 'language'=>$language));
			if($language == 'zh'){
				include template('member', 'basic_info');
			} else {
				include template('member', 'basic_info_en');
			}
		}
		
	}

	// 教育列表
	public function education(){
		$memberinfo = $this->memberinfo;
		$edu_model = pc_base::load_model('member_education_model');


		// 取enum
		$enums = pc_base::load_config('enums', 'member');
		// 语言
		$language = isset($_GET['l']) && in_array($_GET['l'], array('zh', 'en')) ? $_GET['l'] : 'zh';
		
		$layui = true;
		$siteid = SITEID;
		$SEO = seo(SITEID);

		$education = $edu_model->select(array('member_id'=>$memberinfo['userid'], 'language'=>$language));

		if($language == 'zh'){
			include template('member', 'education');
		} else {
			include template('member', 'education_en');
		}

	}

	// 教育增加/修改
	public function education_modify(){
		$memberinfo = $this->memberinfo;

		// 实例化教育经历模型
		$edu_model = pc_base::load_model('member_education_model');
		// 增加/修改
		if($_POST['dosubmit']){
			$info = $_POST['info'];
			$info['has_diploma'] = $info['has_diploma'] ? 1 : 0;
			$info['study_abroad'] = $info['study_abroad'] ? 1 : 0;
			$info['civil_viation'] = $info['civil_viation'] ? 1 : 0;
			$info['highest_degree'] = $info['highest_degree'] ? 1 : 0;
			$info['start_time'] = $info['start_time'].'-00';
			$info['end_time'] = $info['end_time'].'-00';

			if($id = intval($_POST['id'])){
				$edu_model->update($info, array('id'=>$id));
			} else {
				$info['member_id'] = $memberinfo['userid'];
				$edu_model->insert($info);
			}

			showmessage('success', '', 1500, 'close');
		} else {
			// 取enum
			$enums = pc_base::load_config('enums', 'member');
			// 语言
			$language = isset($_GET['l']) && in_array($_GET['l'], array('zh', 'en')) ? $_GET['l'] : 'zh';

			$education = array();
			if(isset($_GET['id']) && $id = intval($_GET['id'])){
				$education = $edu_model->get_one(array('id'=>$id));
				if($education){
					$language = $education['language'];
				} else {
					showmessage('not exist');
				}
			}

			$layui = true;
			$siteid = SITEID;
			$SEO = seo(SITEID);
			include template('member', 'education_modify');
		}
	}

	public function education_del(){
		$id = intval($_GET['id']);

		$edu_model = pc_base::load_model('member_education_model');

		if($edu_model->delete(array('id'=>$id))){
			success('success');
		} else {
			error('fail');
		}
	}

	// 工作列表
	public function work(){
		$memberinfo = $this->memberinfo;
		$work_model = pc_base::load_model('member_work_model');

		// 语言
		$language = isset($_GET['l']) && in_array($_GET['l'], array('zh', 'en')) ? $_GET['l'] : 'zh';
		
		$layui = true;
		$siteid = SITEID;
		$SEO = seo(SITEID);

		$work = $work_model->select(array('member_id'=>$memberinfo['userid'], 'language'=>$language));

		if($language == 'zh'){
			include template('member', 'work');
		} else {
			include template('member', 'work_en');
		}

	}

	// 教育增加/修改
	public function work_modify(){
		$memberinfo = $this->memberinfo;

		// 实例化教育经历模型
		$work_model = pc_base::load_model('member_work_model');
		// 增加/修改
		if($_POST['dosubmit']){
			$info = $_POST['info'];

			if($id = intval($_POST['id'])){
				$work_model->update($info, array('id'=>$id));
			} else {
				$info['member_id'] = $memberinfo['userid'];
				$work_model->insert($info);
			}

			showmessage('success', '', 1500, 'close');
		} else {
			// 语言
			$language = isset($_GET['l']) && in_array($_GET['l'], array('zh', 'en')) ? $_GET['l'] : 'zh';

			$work = array();
			if(isset($_GET['id']) && $id = intval($_GET['id'])){
				$work = $work_model->get_one(array('id'=>$id));
				if($work){
					$language = $work['language'];
				} else {
					showmessage('not exist');
				}
			}

			$layui = true;
			$siteid = SITEID;
			$SEO = seo(SITEID);
			include template('member', 'work_modify');
		}
	}

	public function work_del(){
		$id = intval($_GET['id']);

		$work_model = pc_base::load_model('member_work_model');

		if($work_model->delete(array('id'=>$id))){
			success('success');
		} else {
			error('fail');
		}
	}

	// 外语经历列表
	public function language (){
		$memberinfo = $this->memberinfo;
		$language_model = pc_base::load_model('member_language_model');

		// 语言
		$language = isset($_GET['l']) && in_array($_GET['l'], array('zh', 'en')) ? $_GET['l'] : 'zh';
		
		$layui = true;
		$siteid = SITEID;
		$SEO = seo(SITEID);

		$lists = $language_model->select(array('member_id'=>$memberinfo['userid'], 'language'=>$language));

		if($language == 'zh'){
			include template('member', 'language');
		} else {
			include template('member', 'language_en');
		}

	}
	// 外语增加/修改
	public function language_modify(){
		$memberinfo = $this->memberinfo;

		// 实例化教育经历模型
		$member_language_model = pc_base::load_model('member_language_model');
		// 增加/修改
		if($_POST['dosubmit']){
			$info = $_POST['info'];
			$info['gettime'] = $info['gettime'].'-00';

			if($id = intval($_POST['id'])){
				$member_language_model->update($info, array('id'=>$id));
			} else {
				$info['member_id'] = $memberinfo['userid'];
				$member_language_model->insert($info);
			}

			showmessage('success', '', 1500, 'close');
		} else {
			// 语言
			$language = isset($_GET['l']) && in_array($_GET['l'], array('zh', 'en')) ? $_GET['l'] : 'zh';

			$data = array();
			if(isset($_GET['id']) && $id = intval($_GET['id'])){
				$data = $member_language_model->get_one(array('id'=>$id));
				if($data){
					$language = $data['language'];
				} else {
					showmessage('not exist');
				}
			}

			$layui = true;
			$siteid = SITEID;
			$SEO = seo(SITEID);
			include template('member', 'language_modify');
		}
	}

	public function language_del(){
		$id = intval($_GET['id']);

		$language_model = pc_base::load_model('member_language_model');

		if($language_model->delete(array('id'=>$id))){
			success('success');
		} else {
			error('fail');
		}
	}

	public function pic(){
		$memberinfo = $this->memberinfo;

		if($_POST['dosubmit']){
			$type = $_GET['type'];
			if(!in_array($type, array('head', 'body'))){
				error('异常错误');
			}

			$attachment = pc_base::load_sys_class('attachment');
			
			$a = $attachment->upload('file', 'jpg|png|jpeg|gif');

			if($a){
				$filepath = $attachment->uploadedfiles[0]['filepath'];
				$filepath = pc_base::load_config('system', 'upload_url').$filepath;
				
				if($type == 'head'){
					$updata = array('headimg'=>$filepath);
				}
				if($type == 'body'){
					$updata = array('bodyimg'=>$filepath);
				}

				$member_model = pc_base::load_model('member_model');
				$member_model->update($updata, array('userid'=>$memberinfo['userid']));

				echo json_encode(array('code'=>200, 'data'=>array('filepath'=>$filepath)));
				exit;
			} else {
				$error = $attachment->error();
				error($error);
			}
		} else {
			$layui = true;
			$siteid = SITEID;
			$SEO = seo(SITEID);
			include template('member', 'pic');
		}
	}

	public function register(){
		if($_POST['dosubmit']){
			$info = $_POST['info'];
			// 检测手机号格式
			if(!preg_match('/^1[34578]\d{9}$/', $info['phone'])) error(L('phone_number_error'));
			// 验证验证码

			// 验证密码
			if($info['pwd'] != $info['confirm_pwd']) error(L('different_password'));
			// 检测手机号是否注册
			if($this->member_model->count(array('mobile'=>$info['phone']))) error(L('phone_registered'));

			$encrypt = create_randomstr(6);
			$userinfo = array(
				'username' => $info['phone'],
				'nickname' => $info['phone'],
				'regdate' => time(),
				'lastdate' => time(),
				'mobile' => $info['phone'],
				'encrypt' => $encrypt,
				'password' => password($info['pwd'], $encrypt),
			);
			
			
			$userid = $this->member_model->insert($userinfo, true);

			if($userid > 0) {
				//执行登陆操作
				if(!$cookietime) $get_cookietime = param::get_cookie('cookietime');
				$_cookietime = $cookietime ? intval($cookietime) : ($get_cookietime ? $get_cookietime : 0);
				$cookietime = $_cookietime ? TIME + $_cookietime : 0;

				$phpcms_auth = sys_auth($userid."\t".$userinfo['password'], 'ENCODE', get_auth_key('login'));
				
				param::set_cookie('auth', $phpcms_auth, $cookietime);
				param::set_cookie('_userid', $userid, $cookietime);
				param::set_cookie('_username', $userinfo['username'], $cookietime);
				param::set_cookie('_nickname', $userinfo['nickname'], $cookietime);
				param::set_cookie('cookietime', $_cookietime, $cookietime);
				success('注册成功');
			} else {
				error('注册失败，请稍后再试');
			}
		} else {
			$SEO = seo(SITEID);
			include template('member', 'register');
		}
	}

	public function login(){
		if($_POST['dosubmit']){
			$info = $_POST['info'];
			// 检测手机号格式
			if(!preg_match('/^1[34578]\d{9}$/', $info['phone'])) error('手机号格式错误');

			$memberInfo = $this->member_model->get_one(array('mobile'=>$info['phone']));

			if(empty($memberInfo)) error('该手机号未注册');
			if($memberInfo['islock'] == '1') error('该用户被锁定');
			if(password($info['pwd'], $memberInfo['encrypt']) != $memberInfo['password']) error('密码错误');


			//执行登陆操作
			$cookietime = 0;
			if(isset($_POST['remember'])) $cookietime = time() + 7*86400;

			$phpcms_auth = sys_auth($memberInfo['userid']."\t".$memberInfo['password'], 'ENCODE', get_auth_key('login'));

			param::set_cookie('auth', $phpcms_auth, $cookietime);
			param::set_cookie('_userid', $memberInfo['userid'], $cookietime);
			param::set_cookie('_username', $memberInfo['username'], $cookietime);
			param::set_cookie('_nickname', $memberInfo['nickname'], $cookietime);
			param::set_cookie('cookietime', $_cookietime, $cookietime);
			success('登录成功, 正在跳转...', $_POST['forward']);
		} else {
			$SEO = seo(SITEID);
			$forward = $_GET['forward'];
			include template('member', 'login');
		}
	}

	public function forgetPassword(){
		$step = isset($_GET['step']) ? intval($_GET['step']) : (isset($_POST['step']) ? intval($_POST['step']) : 1);

		// 第一步，输入手机号验证码
		if($_POST['dosubmit'] && $step == 1){
			$info = $_POST['info'];
			// 检测手机号格式
			if(!preg_match('/^1[34578]\d{9}$/', $info['phone'])) error('手机号格式错误');
			// 检测手机号是否注册
			if(!$this->member_model->count(array('mobile'=>$info['phone'], 'islock'=>'0'))) error('该手机号未注册');
			// 检测验证码

			// 将要修改密码的手机号写入cookie
			param::set_cookie('forget_phone', $info['phone']);
			success('信息无误');
		}
		// 第二步，设置新密码
		if($_POST['dosubmit'] && $step == 2){
			$forget_phone = param::get_cookie('forget_phone');
			if(!$forget_phone) error(L('illegal_operation'), '?m=member&a=forgetPassword&step=1');
			$info = $_POST['info'];
			// 检测手机号是否注册
			if(!$this->member_model->count(array('mobile'=>$info['phone'], 'islock'=>'0'))) error('该手机号未注册');
			// 执行修改密码操作
			$encrypt = create_randomstr(6);
			$newPassword = password($info['pwd'], $encrypt);
			$updata = array(
				'password' => $newPassword,
				'encrypt' => $encrypt
			);

			if($this->member_model->update($updata, array('mobile'=>$forget_phone))){
				param::set_cookie('forget_phone', time()-3600);
				success(L('change_password_success'), '?m=member&a=login');
			} else {
				error(L('operation_failure'));
			}
		}


		$SEO = seo(SITEID);

		if($step == 1){
			include template('member', 'forget_password1');
		} elseif($step == 2) {
			if(!param::get_cookie('forget_phone')){
				header('location:?m=member&a=forgetPassword');
			}
			include template('member', 'forget_password2');
		}
	}
  	
	public function logout() {
		param::set_cookie('auth', '');
		param::set_cookie('_userid', '');
		param::set_cookie('_username', '');
		param::set_cookie('_nickname', '');
		param::set_cookie('cookietime', '');
		$forward = isset($_GET['forward']) && trim($_GET['forward']) ? $_GET['forward'] : '/';
		showmessage(L('logout_success'), $forward);
	}

	public function changePassword(){
		$memberinfo = $this->memberinfo;
		if($_POST['dosubmit']){
			$info = $_POST['info'];
			if(trim($info['old_pwd'] == '')) error('旧密码必填');
			if(trim($info['new_pwd'] == '')) error('新密码必填');
			if(trim($info['new_pwd'] == '') != trim($info['new_pwd_confirm'] == '')) error('两次新密码不一致');
			$memberinfo = $this->memberinfo;

			if(password($info['old_pwd'], $memberinfo['encrypt']) != $memberinfo['password']) error('旧密码错误');

			$encrypt = create_randomstr(6);
			$updata = array(
				'encrypt' => $encrypt,
				'password' => password(trim($info['new_pwd']), $encrypt),
			);
			$this->member_model->update($updata, array('userid'=>$memberinfo['userid']));

			// $this->logout();
			success('密码修改成功，请重新登录');
		} else {

			$layui = true;
			$siteid = SITEID;
			$SEO = seo(SITEID);
			include template('member', 'change_password');
		}
	}

	// 职位申请列表
	public function enrolledJob(){
		$memberinfo = $this->memberinfo;
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

		$recruit_enroll = pc_base::load_model('recruit_enroll_model');
		$enrolled = $recruit_enroll->listinfo(array('member_id'=>$memberinfo['userid']), 'id DESC', $page, 15);
		$page = $this->db->page;

		$lists = array();
		if(!empty($enrolled) && is_array($enrolled)){
			$job_model = pc_base::load_model('recruit_job_model');
			foreach ($enrolled as $v) {
				$jobinfo = $job_model->get_one(array('id'=>$v['job_id']));
				if(!empty($jobinfo)){
					$lists[] = array(
						'id' => $v['id'],
						'job_name' => $jobinfo['job_name'],
						'location' => $jobinfo['location'],
						'enterprise_name' => $jobinfo['enterprise_name'],
						'status' => $v['status'],
					);
				}
			}
		}

		$siteid = SITEID;
		$SEO = seo(SITEID);
		include template('member', 'enrolled_job');
	}

	// 简历表格查看
	public function personalResume(){

		$id = intval($_GET['id']);
		$recruit_enroll_model = pc_base::load_model('recruit_enroll_model');
		$member_model = pc_base::load_model('member_model');
		$member_resume_model = pc_base::load_model('member_resume_model');
		$member_education_model = pc_base::load_model('member_education_model');
		$member_work_model = pc_base::load_model('member_work_model');
		$member_language_model = pc_base::load_model('member_language_model');

		$enrollinfo = $recruit_enroll_model->get_one(array('id'=>$id));
		
		$memberinfo = $this->memberinfo;
		if($enrollinfo['member_id'] != $memberinfo['userid']){
			showmessage('非法访问');
		}

		if($enrollinfo['status'] != '2'){
			showmessage('审核未通过');
		}

		// 获取基本信息
		$basicinfo = $member_resume_model->get_one(array('member_id'=>$enrollinfo['member_id']));

		// 头像
		$memberinfo = $member_model->get_one(array('userid'=>$enrollinfo['member_id']), 'headimg');
		// 教育经历
		$educationlist = $member_education_model->select(array('member_id'=>$enrollinfo['member_id'], 'language'=>'zh'), '*', '', 'start_time desc, end_time desc');
		// 工作经历
		$worklist = $member_work_model->select(array('member_id'=>$enrollinfo['member_id'], 'language'=>'zh'), '*', '', 'start_time desc, end_time desc');
		// 外语经历
		$languagelist = $member_language_model->select(array('member_id'=>$enrollinfo['member_id'], 'language'=>'zh'), '*', '', 'id desc');

		
		$enums = pc_base::load_config('enums', 'member');

		$siteid = SITEID;
		$SEO = seo(SITEID);
		include template('member', 'personalResume');
	}

	// 报销
	public function reimbursement(){
		$memberinfo = $this->memberinfo;
		if(!$memberinfo['is_employee']){
			showmessage('您不是员工，无权访问', HTTP_REFERER);
		}

		$reimbursement_model = pc_base::load_model('member_reimbursement_model');

		if($_POST['dosubmit']){
			$info = $_POST['info'];

			if(empty($info['ordernum']) || empty($info['date']) || empty($info['number']) || empty($info['amount'])){
				showmessage('信息填写不完整', HTTP_REFERER);
			}

			$info['member_id'] = $memberinfo['userid'];
			// 获取用户姓名、电话、身份证
			$resume_model = pc_base::load_model('member_resume_model');
			$oneinfo = $resume_model->get_one(array('member_id'=>$memberinfo['userid']));
			$info['fullname'] = $oneinfo['surname'].$oneinfo['firstname'];
			$info['ID_number'] = $oneinfo['ID_number'];
			$info['phone'] = $oneinfo['mobile'];

			
			if($reimbursement_model->insert($info)){
				showmessage('申请成功', HTTP_REFERER);
			} else {
				showmessage('服务器错误', HTTP_REFERER);
			}
		} else {
			$resume_model = pc_base::load_model('member_resume_model');
			$resume = $resume_model->get_one(array('member_id'=>$memberinfo['userid'], 'language'=>'zh'), 'surname, firstname, sex, ID_number');

			$lists = $reimbursement_model->listinfo(array('member_id'=>$memberinfo['userid']));
			$page = $this->db->page;

			$reimbursement_status = pc_base::load_config('enums', 'reimbursement_status_admin');

			$layui = true;
			$siteid = SITEID;
			$SEO = seo(SITEID);
			include template('member', 'reimbursement');
		}
	}
 }
