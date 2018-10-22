<?php
/**
 * 活动接口
 */
defined('IN_PHPCMS') or exit('No permission resources.'); 


$data = new_addslashes($_POST);

if(empty($data['fullname'])){
	die(json_encode(array('code' => 400, 'msg'=>'请输入姓名')));
}

if($data['people_num'] == '' && intval($data['people_num']) >= 0){
	die(json_encode(array('code' => 400, 'msg'=>'请输入家属人数')));
}

if(empty($data['phone'])){
	die(json_encode(array('code' => 400, 'msg'=>'请输入电话号码')));
}

$db_activity = pc_base::load_model('activity_enroll_model');
if($db_activity->insert($data)){
	die(json_encode(array('code'=>200, 'msg'=>'提交成功')));
} else {
	die(json_encode(array('code'=>400, 'msg'=>'提交失败，请稍后再试')));
}