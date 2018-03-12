<?php
/**
 *  extention.func.php 用户自定义函数库
 *
 * @copyright			(C) 2005-2010 PHPCMS
 * @license				http://www.phpcms.cn/license/
 * @lastmodify			2010-10-27
 */
 
 function extend_setting_get($key=null){
 	if($key==null) return false;
 	$db = pc_base::load_model('extend_setting_model');

 	$siteid = get_siteid();

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