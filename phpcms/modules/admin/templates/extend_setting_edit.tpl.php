<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>


<div class="pad-10">
	<div class="common-form">
		<form action="?m=admin&c=extend_setting&a=edit" method="post" name="myform" id="myform">
			<table cellpadding="2" cellspacing="1" class="table_form" width="100%">
				

				<tr>
					<th width="100">网站服务：</th>
					<td>
						<input type="radio" name="setting[close]" <?php if($close == 1) echo 'checked=checked'?> value="1"> 开启
						<input type="radio" name="setting[close]" <?php if($close == 0) echo 'checked=checked'?> value="0"> 关闭
					</td>
				</tr>
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
					<td><?php echo form::upfiles('setting[index_video]', 'index_video', "$index_video", '', '', 50, '', '', 'mp4');?></td>
				</tr>
				<?php if($siteid == '2') { ?>
				<tr>
					<th width="100">首页公司简介</th>
					<td>
						<textarea name="setting[en_index_about]" id="en_index_about"><?php echo $en_index_about;?></textarea>
						<?php echo form::ueditor('en_index_about', 'basic');?>
					</td>
				</tr>
				<?php } ?>
				<?php if($siteid=='1') { ?>
				<tr>
					<th width="100">热搜职位：</th>
					<td><input type="text" name="setting[hot_job]" value="<?php echo $hot_job;?>" size="50"></td>
				</tr>
				<tr>
					<th width="100">引导页合作伙伴：</th>
					<td><?php echo form::images('setting[partner]', 'partner', "$partner");?></td>
				</tr>
				<tr>
					<th width="100">简历logo</th>
					<td><?php echo form::images('setting[resume_logo]', 'resume_logo', "$resume_logo");?></td>
				</tr>
					<th width="100">付款二维码</th>
					<td><?php echo form::images('setting[pay_code]', 'pay_code', "$pay_code");?></td>
				</tr>
				<tr>
					<th width="100">医疗报销联系方式</th>
					<td>
						<textarea name="setting[reimbursement_contact]" id="reimbursement_contact"><?php echo $reimbursement_contact;?></textarea>
						<?php echo form::editor('reimbursement_contact', 'basic');?>
					</td>
				</tr>
				<tr>
					<th width="100">北京FASCO用户服务协议</th>
					<td>
						<textarea name="setting[registration_agreement]" id="registration_agreement"><?php echo $registration_agreement;?></textarea>
						<?php echo form::ueditor('registration_agreement', 'full');?>
					</td>
				</tr>
				<?php } ?>
			</table>
			<div class="bk15"></div>

			<input name="dosubmit" type="submit" id="dosubmit" value="<?php echo L('submit')?>" class="button">
		
		</form>
	</div>
</div>
</body>
</html> 