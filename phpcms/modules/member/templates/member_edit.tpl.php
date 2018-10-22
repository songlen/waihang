<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>member_common.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidator.js" charset="UTF-8"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidatorregex.js" charset="UTF-8"></script>
<script type="text/javascript">
  $(document).ready(function() {
	$.formValidator.initConfig({autotip:true,formid:"myform",onerror:function(msg){}});
 //  	$("#mobile").formValidator({onfocus:"请输入手机号", onshow:"请输入手机号"}).regexValidator({regexp:"1[0-9]{10}",onerror:"手机号错误"}).ajaxValidator({
	//     type : "get",
	// 	url : "",
	// 	data :"m=member&c=member&a=public_checkmobile_ajax&userid=<?php echo $memberinfo['userid'];?>",
	// 	datatype : "html",
	// 	async:'false',
	// 	success : function(data){
 //            if( data == "1" ) {
 //                return true;
	// 		} else {
 //                return false;
	// 		}
	// 	},
	// 	buttons: $("#dosubmit"),
	// 	onerror : "手机号已存在",
	// 	onwait : "<?php echo L('connecting_please_wait')?>"
	// }).defaultPassed();
	$("#password").formValidator({empty:true,onshow:"<?php echo L('not_change_the_password_please_leave_a_blank')?>",onfocus:"<?php echo L('password').L('between_6_to_20')?>"}).inputValidator({min:6,max:20,onerror:"<?php echo L('password').L('between_6_to_20')?>"});
	$("#pwdconfirm").formValidator({empty:true,onshow:"<?php echo L('not_change_the_password_please_leave_a_blank')?>",onfocus:"<?php echo L('passwords_not_match')?>",oncorrect:"<?php echo L('passwords_match')?>"}).compareValidator({desid:"password",operateor:"=",onerror:"<?php echo L('passwords_not_match')?>"});


  });
</script>
<div class="pad-10">
<div class="common-form">
<form name="myform" action="?m=member&c=member&a=edit" method="post" id="myform">
	<input type="hidden" name="info[userid]" id="userid" value="<?php echo $memberinfo['userid']?>"></input>
<fieldset>
	<legend><?php echo L('basic_configuration')?></legend>
	<table width="100%" class="table_form">

		<tr>
			<td>账号</td>
			<td><?php
					if($memberinfo['mobile']){
						echo $memberinfo['mobile'];
					} else {
						echo $memberinfo['email'];
					}
				?>
			</td>
		</tr>

		<tr>
			<td><?php echo L('avatar')?></td> 
			<td><img src="<?php echo $memberinfo['avatar']?>" onerror="this.src='<?php echo IMG_PATH?>member/nophoto.gif'" height=90 width=90></td>
		</tr>
		<tr>
			<td><?php echo L('password')?></td> 
			<td><input type="password" name="info[password]" id="password" class="input-text"></input></td>
		</tr>
		<tr>
			<td><?php echo L('cofirmpwd')?></td> 
			<td><input type="password" name="info[pwdconfirm]" id="pwdconfirm" class="input-text"></input></td>
		</tr>
		<tr>
			<td width="80">是否员工</td> 
			<td>
				<input type="radio" name="info[is_employee]" value="1" <?php if($memberinfo['is_employee'] == '1') echo 'checked';?>> 是
				<input type="radio" name="info[is_employee]" value="0" <?php if($memberinfo['is_employee'] == '0') echo 'checked';?>> 否
			</td>
		</tr>
		<tr>
			<td width="80">政治面貌</td>
			<td>
				<select name="political_outlook">
					<option value="">请选择</option>
					<?php foreach ($enums_member['political_outlook'] as $key => $value) { ?>
					<option value="<?php echo $key ?>" <?php if($key == $resumeinfo['political_outlook']) echo 'selected=selected' ?>><?php echo $value ?></option>
					<?php } ?>
				</select>
			</td>
		</tr>
	</table>
</fieldset>



    <div class="bk15"></div>
    <input name="dosubmit" id="dosubmit" type="submit" value="<?php echo L('submit')?>" class="dialog">
</form>
</div>
</div>
</body>
<script language="JavaScript">
<!--
	function changemodel(modelid) {
		redirect('?m=member&c=member&a=edit&userid=<?php echo $memberinfo[userid]?>&modelid='+modelid+'&pc_hash=<?php echo $_SESSION['pc_hash']?>');
	}
//-->
</script>
</html>