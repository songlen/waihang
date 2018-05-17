<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<script type="text/javascript">
<!--
	$(function(){
	$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'200',height:'50'}, function(){this.close();$(obj).focus();})}});
	$("#name").formValidator({onshow:"<?php echo L("input").L('enterprise_name')?>",onfocus:"<?php echo L("input").L('enterprise_name')?>"}).inputValidator({min:1,onerror:"<?php echo L("input").L('enterprise_name')?>"});

	 
	})
//-->
</script>

<div class="pad_10">
<form action="?m=recruit&c=enterprise&a=edit&id=<?php echo $id;?>" method="post" name="myform" id="myform">
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">
	<tr>
		<th width="100"><?php echo L('enterprise_name')?>：</th>
		<td><input type="text" name="info[name]" id="name" size="30" class="input-text" value="<?php echo $name;?>"></td>
	</tr>
	<tr>
		<th width="100">公司缩写：</th>
		<td><input type="text" name="info[abbreviation]" id="name" size="30" class="input-text" value="<?php echo $abbreviation;?>"></td>
	</tr>
	
	<tr id="logolink">
		<th width="100"><?php echo L('enterprise_logo')?>：</th>
		<td><?php echo form::images('info[logo]', 'logo', $logo, 'recruit')?></td>
	</tr>

	<tr>
		<th></th>
		<td>
			<input type="hidden" name="forward" value="?m=recruit&c=enterprise&a=edit"> 
			<input type="submit" name="dosubmit" id="dosubmit" class="dialog" value="提交">
		</td>
	</tr>

</table>
</form>
</div>
</body>
</html> 