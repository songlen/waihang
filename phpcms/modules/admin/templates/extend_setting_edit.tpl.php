<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>


<div class="pad-10">
	<div class="common-form">
		<form action="?m=admin&c=extend_setting&a=edit" method="post" name="myform" id="myform">
			<table cellpadding="2" cellspacing="1" class="table_form" width="100%">
				

				<tr>
					<th width="100">版权所有：</th>
					<td> <input type="text" name="setting[copyright]" value="<?php echo $copyright;?>" size=50> </td>
				</tr>

				<tr>
					<th width="100">联系电话：</th>
					<td> <input type="text" name="setting[phone]" value="<?php echo $phone;?>" size=30> </td>
				</tr>
				<tr>
					<th width="100">首页视频：</th>
					<td><?php echo form::upfiles('setting[index_video]', 'index_video', "$index_video;?>", '', '', 50, '', '', 'mp4');?></td>
				</tr>

			</table>
			<div class="bk15"></div>

			<input name="dosubmit" type="submit" id="dosubmit" value="<?php echo L('submit')?>" class="button">
		
		</form>
	</div>
</div>
</body>
</html> 