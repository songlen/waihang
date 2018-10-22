<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>

<div class="pad_10">
<form action="?m=admin&c=reimbursement&a=editOneMember&id=<?php echo $id;?>" method="post" name="myform" id="myform">
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">
	<tr>
		<th width="100">单据号：</th>
		<td><input type="text" name="info[ordernum]" id="ordernum" size="30" class="input-text" value="<?php echo $ordernum;?>"></td>
	</tr>
	<tr>
		<th width="100">交易日期：</th>
		<td><?php echo form::date('info[date]', $date);?></td>
	</tr>
	<tr>
		<th width="100">航司代码：</th>
		<td><input type="text" name="info[number]" id="number" size="30" class="input-text" value="<?php echo $number;?>"></td>
	</tr>
	<tr>
		<th width="100">自付一金额：</th>
		<td><input type="text" name="info[amount]" id="amount" size="30" class="input-text" value="<?php echo $amount;?>"></td>
	</tr>
	<tr>
		<th width="100">其他说明：</th>
		<td><textarea name="info[remark]" id="" cols="30" rows="5"><?php echo $remark;?></textarea></td>
	</tr>

	<tr>
		<th></th>
		<td>
			<input type="submit" name="dosubmit" id="dosubmit" class="dialog" value="提交">
		</td>
	</tr>

</table>
</form>
</div>
</body>
</html> 