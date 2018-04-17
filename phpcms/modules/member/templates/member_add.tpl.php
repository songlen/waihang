<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidator.js" charset="UTF-8"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidatorregex.js" charset="UTF-8"></script>
<script type="text/javascript">
<!--
$(function(){
	$.formValidator.initConfig({autotip:true,formid:"myform",onerror:function(msg){}});

	$("#mobile").formValidator({onfocus:"请输入手机号", onshow:"请输入手机号"}).regexValidator({regexp:"1[0-9]{10}",onerror:"手机号错误"}).ajaxValidator({
	    type : "get",
		url : "",
		data :"m=member&c=member&a=public_checkmobile_ajax",
		datatype : "html",
		async:'false',
		success : function(data){
            if( data == "1" ) {
                return true;
			} else {
                return false;
			}
		},
		buttons: $("#dosubmit"),
		onerror : "手机号已存在",
		onwait : "<?php echo L('connecting_please_wait')?>"
	});
	$("#password").formValidator({onshow:"<?php echo L('input').L('password')?>",onfocus:"<?php echo L('password').L('between_6_to_20')?>"}).inputValidator({min:6,max:20,onerror:"<?php echo L('password').L('between_6_to_20')?>"});
	$("#pwdconfirm").formValidator({onshow:"<?php echo L('input').L('cofirmpwd')?>",onfocus:"<?php echo L('input').L('passwords_not_match')?>",oncorrect:"<?php echo L('passwords_match')?>"}).compareValidator({desid:"password",operateor:"=",onerror:"<?php echo L('input').L('passwords_not_match')?>"});
});
//-->
</script>
<div class="pad-10">
<div class="common-form">
<form name="myform" action="?m=member&c=member&a=add" method="post" id="myform">
<fieldset>
	<legend><?php echo L('basic_configuration')?></legend>
	<table width="100%" class="table_form">
		<tr>
			<td><?php echo L('mp')?></td>
			<td>
			<input type="text" name="info[mobile]" value="" class="input-text" id="mobile"></input>
			</td>
		</tr>
		<tr>
		<tr>
			<td><?php echo L('password')?></td> 
			<td><input type="password" name="info[password]" class="input-text" id="password" value=""></input></td>
		</tr>
		<tr>
			<td><?php echo L('cofirmpwd')?></td> 
			<td><input type="password" name="info[pwdconfirm]" class="input-text" id="pwdconfirm" value=""></input></td>
		</tr>
	</table>
</fieldset>

    <div class="bk15"></div>
    <input name="dosubmit" type="submit" id="dosubmit" value="<?php echo L('submit')?>" class="dialog">
</form>
</div>
</div>
</body>
</html>