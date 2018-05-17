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