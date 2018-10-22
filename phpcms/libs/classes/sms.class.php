<?php
/*
 * 账号：csxqhy
 * 密码：5a791qn0
 * 测试内容：【快用科技】验证码123
 */
class sms {
	/**
	 * [send 发送验证码]
	 * @return [type] [register 注册  forget 找回密码 ]
	 */
	function send($phone, $type){

		// 检测手机号格式
		if(!preg_match('/^1[34578]\d{9}$/', $phone)) error('手机号格式错误');

		$sms_log_model = pc_base::load_model('sms_log_model');
		$sms_code_model = pc_base::load_model('sms_code_model');

		// 检测手机号发送次数是否超限
		$smscode = $sms_code_model->get_one(array('phone'=>$phone));
		if($smscode && $smscode['count'] >= 5 && date('Y-m-d', $smscode['inputtime']) == date('Y-m-d')) error('短信发送次数已超限');

		/*到此验证通过，可以发送验证码*/
		$code = random(6);
		$log_id = $sms_log_model->insert(array('phone'=>$phone, 'code' => $code, 'inputtime'=>date('Y-m-d H:i:s')), true); //记录短信日志

		if($type == 'register'){
			$content = "【北京FASCO】您本次验证码为：{$code}，五分钟内有效。感谢您注册北京FASCO。";
		} else {
			$content = "【北京FASCO】您本次验证码为：{$code}，五分钟内有效。";
		}

		$result = $this->exec($phone, $content, 'bjwhhy', 'frppmjnz');

		// 如果发送成功
		if(strpos($result, 'success') !== false){
			
			// 更新日志状态
			$sms_log_model->update(array('status'=>'1'), array('id'=>$log_id));
			// 记录验证码和次数以及发送时间
			$sms_code = $sms_code_model->get_one(array('phone'=>$phone));
			if($sms_code){
				if(date('Y-m-d', $smscode['inputtime']) == date('Y-m-d')){
					$sms_code_model->update(array('code'=>$code, 'count'=>'+=1', 'inputtime'=>time()), array('phone'=>$phone));
				} else {
					$sms_code_model->update(array('code'=>$code, 'count'=>'1', 'inputtime'=>time()), array('phone'=>$phone));
				}
				
			} else {
				$data = array(
					'phone' => $phone,
					'code' => $code,
					'count' => 1,
					'inputtime' => time(),
				);
				$sms_code_model->insert($data);
			}
			success('短信已发送');
		} else {
			error('短信发送失败');
		}
	}

	    /**
     * 下行
     * 返回实例： success:042012492286044102
     */
    public function exec($mobile, $content, $name, $passwd, $ext='', $reference='') {

        $encode = mb_detect_encoding( $content, array( "UTF-8" , "GB2312" , "GBK" )  );
        //编码转换
        if( $encode == "UTF-8" ) {
            $content = iconv('UTF-8' , 'gbk//TRANSLIT', $content );
        }

        $data =array(
            'name'=>$name,
            'seed'=>date('YmdHis', time()),
            'key'=>md5(md5($passwd).date('YmdHis', time())),
            'dest'=>$mobile,
            'content'=>$content,
            'ext'=>$ext,
            'reference'=>$reference
        );

        return $this->http_curl( 'http://210.51.191.35:8080/eums/sms/send.do' , 1 ,$data);
    }

    /**
     * 共用函数
     * http请求
     *
     */
    public function http_curl($url, $post = 0, $data = array(), $port = 8080){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_PORT, $port);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        if (ini_get("max_execution_time") > 0) {
            $max_execution_time = intval(ini_get('max_execution_time') / 4) > 30 ? 30 : intval(ini_get('max_execution_time') / 4);
            curl_setopt($curl, CURLOPT_TIMEOUT, $max_execution_time);
        } else if (ini_get("max_execution_time") == 60) {
            curl_setopt($curl, CURLOPT_TIMEOUT, 60);
        }

        if ($post) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        }

        $return = curl_exec($curl);
        curl_close($curl);
        return $return;
    }
}