<?php
/**
 *  extention.func.php 用户自定义函数库

 * @lastmodify			2010-10-27
 */
 
 // 获取扩展配置 2018-02-01
 function get_extend_setting($key=null){
 	if($key==null) return false;
 	$db = pc_base::load_model('extend_setting_model');

 	$siteid = isset($_GET['siteid']) ? intval($_GET['siteid']) : get_siteid();

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