<?php
/**
 *  extention.func.php 用户自定义函数库

 * @lastmodify			2010-10-27
 */
 
 // 获取扩展配置 2018-02-01
 function get_extend_setting($key=null){
 	if($key==null) return false;
 	$db = pc_base::load_model('extend_setting_model');

    $catid = isset($_GET['catid']) ? intval($_GET['catid']) : '';
    if($catid){
        $siteids = getcache('category_content','commons');
        $siteid = $siteids[$catid];
    } else {
        $siteid = isset($_GET['siteid']) ? intval($_GET['siteid']) : get_siteid();
    }

 	$where = array(
 		'key' => $key,
 		'siteid' => $siteid
 	);

 	$data = $db->get_one($where, 'data');
 	if($data)
 		return $data['data'];
 	else 
 		return false;
 }


function strcut($str, $lenght = 60, $suffix = '...'){
 	if($str == '') return '';

 	$str = str_replace(array("'","\r\n","\t",'[page]','[/page]','&ldquo;','&rdquo;','&nbsp;'), '', strip_tags($str));

 	if(mb_strlen($str, 'utf-8') > $lenght) {
 		return mb_substr($str, 0, $lenght, 'utf-8').$suffix;
 	} else {
 		return mb_substr($str, 0, $lenght, 'utf-8');
 	}
	
 }

function p(){
	$args = func_get_args();
	echo '<pre>';
	foreach ($args as $item) {
		print_r($item);
		echo '---------';
	}
	die();
}

function error($msg = '错误', $jump_url=false){
	$data = array(
		'code' => 400,
		'msg' => $msg
	);

	if($jump_url) $data['jump_url'] = $jump_url;

	echo json_encode($data);
	exit;
}

function success($msg = '成功', $jump_url=false){
	$data = array(
		'code' => 200,
		'msg' => $msg,
	);
	
	if($jump_url) $data['jump_url'] = $jump_url;

	echo json_encode($data);
	exit;
}


function is_login(){
	pc_base::load_sys_class('param');
	return (bool)param::get_cookie('auth');
}

function historySearch(){
	$historySearch = array();
	if(is_login()){
		$userid = param::get_cookie('_userid');
		$history_model = pc_base::load_model('search_history_model');

		$siteid = get_siteid();
		$history_keyword = $history_model->select(array('member_id'=>$userid, 'siteid'=>$siteid), 'keyword', 3, 'id desc');
	} else {
		$historySearch = param::get_cookie('historySearch');
	}

	return $history_keyword;
}



function doexport($content, $filename){

	header('Pragma: public');
	header('Last-Modified: '.gmdate('D, d M Y H:i:s') . ' GMT');
	header('Cache-Control: no-store, no-cache, must-revalidate');
	header('Cache-Control: pre-check=0, post-check=0, max-age=0');
	header('Content-Transfer-Encoding: binary');
	header('Content-Encoding: none');
	header('Content-Disposition: attachment; filename='.$filename);

	echo $content;
	exit();
}


/**
 *  根据身份证号码获取生日
 *  author:xiaochuan
 *  @param string $idcard    身份证号码
 *  @return $birthday
 */
function get_birthday($idcard) {
    if(empty($idcard)) return null; 
    $bir = substr($idcard, 6, 8);
    $year = substr($bir, 0, 4);
    $month = substr($bir, 4, 2);
    $day = substr($bir, 6, 2);
    return $year . "-" . $month . "-" . $day;
}
 
/**
 *  根据身份证号码计算年龄
 *  author:xiaochuan
 *  @param string $idcard    身份证号码
 *  @return int $age
 */
function get_age($idcard){  
    if(empty($idcard)) return null; 
    #  获得出生年月日的时间戳 
    $date = strtotime(substr($idcard,6,8));
    #  获得今日的时间戳 
    $today = strtotime('today');
    #  得到两个日期相差的大体年数 
    $diff = floor(($today-$date)/86400/365);
    #  strtotime加上这个年数后得到那日的时间戳后与今日的时间戳相比 
    $age = strtotime(substr($idcard,6,8).' +'.$diff.'years')>$today?($diff+1):$diff; 
    return $age; 
} 



//验证身份证是否有效
function validateIDCard($IDCard) {
    if (strlen($IDCard) == 18) {
        return check18IDCard($IDCard);
    } elseif ((strlen($IDCard) == 15)) {
        $IDCard = convertIDCard15to18($IDCard);
        return check18IDCard($IDCard);
    } else {
        return false;
    }
}

//计算身份证的最后一位验证码,根据国家标准GB 11643-1999
function calcIDCardCode($IDCardBody) {
    if (strlen($IDCardBody) != 17) {
        return false;
    }

    //加权因子 
    $factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
    //校验码对应值 
    $code = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
    $checksum = 0;

    for ($i = 0; $i < strlen($IDCardBody); $i++) {
        $checksum += substr($IDCardBody, $i, 1) * $factor[$i];
    }

    return $code[$checksum % 11];
}

// 将15位身份证升级到18位 
function convertIDCard15to18($IDCard) {
    if (strlen($IDCard) != 15) {
        return false;
    } else {
        // 如果身份证顺序码是996 997 998 999，这些是为百岁以上老人的特殊编码 
        if (array_search(substr($IDCard, 12, 3), array('996', '997', '998', '999')) !== false) {
            $IDCard = substr($IDCard, 0, 6) . '18' . substr($IDCard, 6, 9);
        } else {
            $IDCard = substr($IDCard, 0, 6) . '19' . substr($IDCard, 6, 9);
        }
    }
    $IDCard = $IDCard . calcIDCardCode($IDCard);
    return $IDCard;
}

// 18位身份证校验码有效性检查 
function check18IDCard($IDCard) {
    if (strlen($IDCard) != 18) {
        return false;
    }

    $IDCardBody = substr($IDCard, 0, 17); //身份证主体
    $IDCardCode = strtoupper(substr($IDCard, 17, 1)); //身份证最后一位的验证码

    if (calcIDCardCode($IDCardBody) != $IDCardCode) {
        return false;
    } else {
        return true;
    }
}


function get_linkage_name($linkageid, $language='name'){
    $linkage_model = pc_base::load_model('linkage_model');
    $data = $linkage_model->get_one(array('linkageid'=>$linkageid), 'name, pinyin');
    return $data[$language];
}

/**
 * [sdmail 发送邮件]
 * @param  [type] $toemail    [description]
 * @param  [type] $subject    [description]
 * @param  [type] $message    [description]
 * @param  string $attachment [description]
 * @param  string $sitename   [description]
 * @return [type]             [description]
 */
function sdmail($toemail, $subject, $message, $attachment='', $sitename = ''){
    if($sitename=='') {
        $siteid = get_siteid();
        $siteinfo = siteinfo($siteid);
        $sitename = $siteinfo['site_title'];
    }

    $cfg = getcache('common','commons');

    pc_base::load_sys_class('smtp');
    $phpmailer = pc_base::load_sys_class('phpmailer');

    $phpmailer->IsSMTP(); // 启用SMTP  
    $phpmailer->Host = $cfg['mail_server']; //SMTP服务器 163邮箱例子  
    //$phpmailer->Host = "smtp.126.com"; //SMTP服务器 126邮箱例子  
    //$phpmailer->Host = "smtp.qq.com"; //SMTP服务器 qq邮箱例子  

    $phpmailer->Port = $cfg['mail_port'];  //邮件发送端口  
    $phpmailer->SMTPAuth   = true;  //启用SMTP认证  

    $phpmailer->CharSet  = "UTF-8"; //字符集  
    $phpmailer->Encoding = "base64"; //编码方式  

    $phpmailer->Username = $cfg['mail_from'];  //你的邮箱  
    $phpmailer->Password = $cfg['mail_password'];  //你的密码  
    $phpmailer->Subject = '['.$sitename.']-'.$subject; //邮件标题  

    $phpmailer->From = $cfg['mail_from'];  //发件人地址（也就是你的邮箱）  
    $phpmailer->FromName = $sitename;   //发件人姓名  

    $phpmailer->SingleTo = true;
    $phpmailer->AddBCC($toemail);    ///收件人email  

    if($attachment){

        $phpmailer->AddAttachment($attachment); // 添加附件,并指定名称 
        
    }

    $phpmailer->IsHTML(true); //支持html格式内容 
    $phpmailer->Body = $message; //邮件主体内容  

    //发送  
    if($phpmailer->Send()) {  
        return true;
    }

    return false;
}


 function isMobile(){  
     $useragent=isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';  
     $useragent_commentsblock=preg_match('|\(.*?\)|',$useragent,$matches)>0?$matches[0]:'';        

     $mobile_os_list=array('Google Wireless Transcoder','Windows CE','WindowsCE','Symbian','Android','armv6l','armv5','Mobile','CentOS','mowser','AvantGo','Opera Mobi','J2ME/MIDP','Smartphone','Go.Web','Palm','iPAQ');
     $mobile_token_list=array('Profile/MIDP','Configuration/CLDC-','160×160','176×220','240×240','240×320','320×240','UP.Browser','UP.Link','SymbianOS','PalmOS','PocketPC','SonyEricsson','Nokia','BlackBerry','Vodafone','BenQ','Novarra-Vision','Iris','NetFront','HTC_','Xda_','SAMSUNG-SGH','Wapaka','DoCoMo','iPhone','iPod');  
           
     $found_mobile = CheckSubstrs($mobile_os_list,$useragent_commentsblock) || CheckSubstrs($mobile_token_list,$useragent);  
           
    if ($found_mobile){  
        return true;  
    }else{  
         return false;  
    }  
 }

function CheckSubstrs($substrs,$text){  
  foreach($substrs as $substr)  
     if(false!==strpos($text,$substr)){  
        return true;  
      }  
      return false;  
}


function downloadExcel($strTable,$filename)
{
    header("Content-type: application/vnd.ms-excel");
    header("Content-Type: application/force-download");
    header("Content-Disposition: attachment; filename=".$filename."_".date('Y-m-d').".xls");
    header('Expires:0');
    header('Pragma:public');
    echo '<html><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'.$strTable.'</html>';
}


    function request()
    {
        pc_base::load_sys_class('request', '', 0);
        return Request::instance();
    }

/**
     * 获取输入数据 支持默认值和过滤
     * @param string    $key 获取的变量名
     * @param mixed     $default 默认值
     * @param string    $filter 过滤方法
     * @return mixed
     */
    function input($key = '', $default = null, $filter = '')
    {
        if (0 === strpos($key, '?')) {
            $key = substr($key, 1);
            $has = true;
        }
        if ($pos = strpos($key, '.')) {
            // 指定参数来源
            list($method, $key) = explode('.', $key, 2);
            if (!in_array($method, ['get', 'post', 'put', 'patch', 'delete', 'route', 'param', 'request', 'session', 'cookie', 'server', 'env', 'path', 'file'])) {
                $key    = $method . '.' . $key;
                $method = 'param';
            }
        } else {
            // 默认为自动判断
            $method = 'param';
        }

        if (isset($has)) {
            return request()->has($key, $method, $default);
        } else {
            return request()->$method($key, $default, $filter);
        }
    }


    function my_include($filepath){
        return include $filepath;
    }