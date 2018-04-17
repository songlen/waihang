<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>

<div class="pad-lr-10">
<div class="table-list">
<div class="common-form">
	<input type="hidden" name="info[userid]" value="<?php echo $memberinfo['userid']?>"></input>
	<input type="hidden" name="info[username]" value="<?php echo $memberinfo['username']?>"></input>
<fieldset>
	<legend><?php echo L('basic_configuration')?></legend>
	<table width="100%" class="table_form">
		<tr>
			<td width="80">手机号</td>
			<td>
			<?php echo $memberinfo['mobile'];?>
			</td>
		</tr>
		<tr>
			<td><?php echo L('avatar')?></td> 
			<td><img src="<?php echo $memberinfo['headimg'];?>" onerror="this.src='<?php echo IMG_PATH?>member/nophoto.gif'" height=90 width=90></td>
		</tr>
		<tr>
			<td><?php echo L('email')?></td>
			<td>
			<?php echo $memberinfo['email']?>
			</td>
		</tr>
		
	</table>
</fieldset>
<div class="bk15"></div>
</div>
<div class="bk15"></div>
<input type="button" class="dialog" name="dosubmit" id="dosubmit" onclick="window.top.art.dialog({id:'modelinfo'}).close();"/>
</div>
</div>
</body>
</html>