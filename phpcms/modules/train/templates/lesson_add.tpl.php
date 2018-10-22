<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<script type="text/javascript">
<!--
	$(function(){
	$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'200',height:'50'}, function(){this.close();$(obj).focus();})}});
	$("#title").formValidator({
		onshow:"<?php echo L("input").'课程标题';?>",
		onfocus:"<?php echo L("input").'课程标题';?>",
	}).inputValidator({
			min:1,
			onerror:"<?php echo L("input").'课程标题'?>"});
	})
//-->
</script>

<div class="pad_10">
<form action="?m=train&c=lesson&a=add" method="post" name="myform" id="myform">
	<table cellpadding="2" cellspacing="1" class="table_form" width="100%">
		
		<tr>
			<th width="100">课程标题：</th>
			<td>
				<input type="text" name="info[title]" id="title" size="50" class="input-text">
			</td>
		</tr>
		
		<tr>
			<th width="100">缩略图：</th>
			<td> <?php echo form::images('info[thumb]', 'thumb', '', 'train')?>
			</td>
		</tr>
		<tr>
			<th width="100">视频缩略图：</th>
			<td> <?php echo form::images('info[video]', 'video', '', 'train')?>
			</td>
		</tr>
		
		<tr>
			<th width="100">上传视频：</th>
			<td> <?php echo form::upfiles('info[video_url]', 'video_url', '', '', '', 50, '', '', 'mp4')?>
			</td>
		</tr>
		
		<tr>
			<th width="100">价格：</th>
			<td>
				<input type="text" name="info[price]" id="price" size="10" class="input-text">
			</td>
		</tr>
		<tr>
			<th width="100">课程类别：</th>
			<td>
				<input type="radio" name="info[type]" value="1" checked="checked"> 线下课程
				<input type="radio" name="info[type]" value="2"> 线上课程
			</td>
		</tr>
		<tr>
			<th width="100"><?php echo L('status');?>：</th>
			<td>
				<input type="radio" name="info[status]" value="1" checked="checked"> 正常
				<input type="radio" name="info[status]" value="2"> 关闭
			</td>
		</tr>
		<tr>
			<th width="100">是否面试：</th>
			<td>
				<input type="radio" name="info[is_interview]" value="0" checked="checked"> 否
				<input type="radio" name="info[is_interview]" value="1"> 是
			</td>
		</tr>
		<tr>
			<th width="100">课程简介</th>
			<td><textarea name="info[description]" style="width:400px; height:50px"></textarea></td>
		</tr>
		<tr>
			<th width="100">详细介绍：</th>
			<td>
				<textarea name="info[content]" id="content"></textarea>
				<?php echo form::ueditor('content','full')?>
			</td>
		</tr>


		<tr>
			<th></th>
			<td>
				<!-- <input type="hidden" name="forward" value="?m=recruit&c=recruit&a=add">  -->
				<input type="submit" name="dosubmit" id="dosubmit" class="dialog" value="提交">
			</td>
		</tr>

	</table>
</form>
</div>

</body>
</html> 