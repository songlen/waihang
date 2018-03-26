<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=1300" /> 
	<title><?php echo L('retrieve_password');?>-<?php if(isset($SEO['title']) && !empty($SEO['title'])) { ?><?php echo $SEO['title'];?><?php } ?><?php echo $SEO['site_title'];?></title>
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
					<div class="tit"><?php echo L('retrieve_password');?></div>
					<form action="">
					<input type="password" class="input" name="info[pwd]" id="pwd" value="" placeholder="请输入新密码">
					<input type="password" class="input" name="info[confirm_pwd]" id="confirm_pwd" value="" placeholder="请确认新密码">
					<div class="xieyi"></div>
					<input type="button" class="submit" name="dosubmit" value="完成">
					<input type="hidden" name="dosubmit" value="1">
					<input type="hidden" name="step" value="<?php echo $step;?>">
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

			var pwd = form.find('#pwd').val();
			if(pwd == ''){
				tips('请输入新密码', '#pwd');
				return false;
			}

			var confirm_pwd = form.find('#confirm_pwd').val();
			if(confirm_pwd != pwd){
				tips('两次密码不一致', '#confirm_pwd');
				return false;
			}

			$(this).addClass('disabled');
			var load = layer.load();
			$.ajax({
				url: '?m=member&a=forgetPassword',
				type: 'post',
				dataType: 'json',
				data: form.serialize(),
				success: function (data){
					layer.close(load);
					if(data.code == 400){
						layer.msg(data.msg, function(){
							$('.submit').removeClass('disabled');
							if(data.jump_url){
								window.location=data.jump_url;
							}
						});
					}
					if(data.code == 200){
						layer.msg(data.msg, function(){
							if(data.jump_url){
								window.location=data.jump_url;
							}
						})
					}
				},
				error: function (){
					layer.close(load);
					layer.msg('服务器错误');
				}
			})

		})
	})

</script>
</body>
</html>
