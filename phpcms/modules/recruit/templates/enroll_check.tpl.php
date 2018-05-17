<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>


<div class="pad_10">
<div class="common-form">
<form name="myform" action="?m=recruit&c=enroll&a=check" method="post" id="myform">
	<?php foreach($ids as $v) {?>
	<input type="hidden" name="ids[]" value="<?php echo $v?>" />
	<?php }?>
	<table width="100%" class="table_form">
		<tr>
			<td width="80">状态：</td> 
			<td>
				<select name="status" id="">
					<option value="">选择状态</option>
					<?php foreach ($enroll_status as $key => $value) { ?>
					<option value="<?php echo $key ?>"><?php echo $value ?></option>
					<?php } ?>
				</select>
			</td>
		</tr>
	</table>


    <div class="bk15"></div>
    <input name="dosubmit" id="dosubmit" type="submit" value="<?php echo L('submit')?>" class="dialog">
</form>
</div>
</div>
</body>
</html>