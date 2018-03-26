<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=1300" /> 
	<title>注册-<?php if(isset($SEO['title']) && !empty($SEO['title'])) { ?><?php echo $SEO['title'];?><?php } ?><?php echo $SEO['site_title'];?></title>
	<meta name="keywords" content="<?php echo $SEO['keyword'];?>">
	<meta name="description" content="<?php echo $SEO['description'];?>">
	<link rel="stylesheet" href="statics/default/css/style.css">
	<link rel="stylesheet" href="statics/plugin/layui/css/modules/layer/default/layer.css">
	<script type="text/javascript" src="statics/default/js/jquery-1.11.0.min.js"></script>
	<script type="text/javascript" src="<?php echo JS_PATH;?>jquery.cookie.js"></script>
	<script type="text/javascript" src="statics/plugin/layui/lay/modules/layer.js"></script>
</head>
<body>
<div class="regbg">
	<img class="bgimg" src="statics/default/images/regbg.png" alt="">
</div>
<div class="regbox">
	<div class="container">
		<div class="reg_right">
			<div class="regform loginform">
				<div class="person_reg">
					<div class="tit">登录</div>
					<form action="">
					<input type="text" class="input input-phone" name="info[phone]" id="phone" value="" placeholder="请输入手机号">
					<input type="password" class="input" name="info[pwd]" id="pwd" value="" placeholder="请输入密码">
					<div class="xieyi"></div>
					<input type="button" class="submit" name="dosubmit" value="登录">
					<input type="hidden" name="dosubmit" value="1">
					<div class="subbot">
						<a href="?m=member&a=forgetPassword" class="forgetpwd">忘记密码</a>
						<input type="checkbox" name="remember" value="记住密码"> 记住密码
					</div>
					</form>
				</div>
			</div>
		</div>
		
	</div>
</div>
<script type="text/javascript">
	$(function(){
		// 提交表单验证
		$('.submit').click(function(){
			if($(this).hasClass('disabled')) return false;

			var form = $(this).parents('form');

			// 手机号码验证
			var phone = form.find('#phone').val();
			if(!isPhone(phone)){
				tips('手机号格式错误', '#phone');
				return false;
			}

			var pwd = form.find('#pwd').val();
			if(pwd == ''){
				tips('请填写密码', '#pwd');
				return false;
			}

			// $(this).addClass('disabled');
			var load = layer.load();
			$.ajax({
				url: '?m=member&a=login',
				type: 'post',
				dataType: 'json',
				data: form.serialize(),
				success: function (data){
					layer.close(load);
					if(data.code == 400){
						layer.msg(data.msg);
						$('.submit').removeClass('disabled');
					}
					if(data.code == 200){
						layer.msg('登录成功，正在跳转...', function(){
							window.location='?m=member&c=index';
						});
					}
				},
				error: function (){
					layer.close(load);
					layer.msg('服务器错误');
				}
			})

		})

		function tips(message, id){
			layer.tips(message, id, {tips:[1, '#000']})
		}

		function isPhone(phone){
			var reg_mobile = /^1[34578]\d{9}$/;
			return reg_mobile.test(phone);
		}
	})
</script>
</body>
</html>