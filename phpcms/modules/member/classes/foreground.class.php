<?php

class foreground {
	public $db, $memberinfo;
	private $_member_modelinfo;
	
	public function __construct() {
		self::check_ip();
		$this->db = pc_base::load_model('member_model');
		//ajax验证信息不需要登录
		if(substr(ROUTE_A, 0, 7) != 'public_') {
			self::check_member();
		}
	}
	
	/**
	 * 判断用户是否已经登陆
	 */
	final public function check_member() {
		$phpcms_auth = param::get_cookie('auth');
		if(ROUTE_M =='member' && ROUTE_C =='index' && in_array(ROUTE_A, array('login', 'register', 'forgetPassword'))) {
			if ($phpcms_auth && ROUTE_A != 'mini') {
				showmessage('您已登录', 'index.php?m=member&c=index');
			} else {
				return true;
			}
		} else {
			//判断是否存在auth cookie
			if ($phpcms_auth) {
				$auth_key = $auth_key = get_auth_key('login');
				list($userid, $password) = explode("\t", sys_auth($phpcms_auth, 'DECODE', $auth_key));
				$userid = intval($userid);
				//验证用户，获取用户信息
				$this->memberinfo = $this->db->get_one(array('userid'=>$userid));
				if($this->memberinfo['islock']) exit('<h1>Bad Request!</h1>');
				$member_resume = pc_base::load_model('member_resume_model');
				$resume = $member_resume->get_one(array('member_id'=>$this->memberinfo['userid'], 'language'=>'zh'));
				if($resume){
					$this->memberinfo['fullname'] = $resume['surname'].$resume['firstname'];
					$this->memberinfo['mobile_phone'] = $resume['mobile_phone'];
					$this->memberinfo['email'] = $resume['email'];
				}
				
				if($this->memberinfo && $this->memberinfo['password'] === $password) {
					
					if (!defined('SITEID')) {
					   define('SITEID', $this->memberinfo['siteid']);
					}

				} else {
					param::set_cookie('auth', '');
					param::set_cookie('_userid', '');
					param::set_cookie('_username', '');
					param::set_cookie('_groupid', '');
				}
				unset($userid, $password, $phpcms_auth, $auth_key);
			} else {
				$forward= isset($_GET['forward']) ?  urlencode($_GET['forward']) : urlencode(get_url());
				showmessage(L('please_login', '', 'member'), 'index.php?m=member&c=index&a=login&forward='.$forward);
			}
		}
	}
	/**
	 * 
	 * IP禁止判断 ...
	 */
	final private function check_ip(){
		$this->ipbanned = pc_base::load_model('ipbanned_model');
		$this->ipbanned->check_ip();
 	}
	
}