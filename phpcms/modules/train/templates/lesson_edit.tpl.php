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
	}).defaultPassed();
//-->
</script>

<div class="pad_10">
<form action="?m=train&c=lesson&a=edit&id=<?php echo $id;?>" method="post" name="myform" id="myform">
	<table cellpadding="2" cellspacing="1" class="table_form" width="100%">
		
		<tr>
			<th width="100">课程标题：</th>
			<td>
				<input type="text" name="info[title]" id="title" size="50" value="<?php echo $title;?>" class="input-text">
			</td>
		</tr>
		
		<tr>
			<th width="100">缩略图：</th>
			<td> <?php echo form::images('info[thumb]', 'thumb', $thumb, 'train')?>
			</td>
		</tr>
		
		<tr>
			<th width="100">详情页图：</th>
			<td> <?php echo form::images('info[video]', 'video', $video, 'train')?>
			</td>
		</tr>
		<tr>
			<th width="100">价格：</th>
			<td>
				<input type="text" name="info[price]" id="price" size="10" value="<?php echo $price;?>" class="input-text">
			</td>
		</tr>

		<tr>
			<th width="100"><?php echo L('status');?>：</th>
			<td>
				<input type="radio" name="info[status]" value="1" <?php if($status=='1'){ ?>checked="checked"<?php } ?>> 正常
				<input type="radio" name="info[status]" value="2" <?php if($status=='2'){ ?>checked="checked"<?php } ?>> 关闭
			</td>
		</tr>

		<tr>
			<th width="100">是否面试：</th>
			<td>
				<input type="radio" name="info[is_interview]" value="0" <?php if($is_interview=='0'){ ?>checked="checked"<?php } ?>> 否
				<input type="radio" name="info[is_interview]" value="1" <?php if($is_interview=='1'){ ?>checked="checked"<?php } ?>> 是
			</td>
		</tr>
		<tr>
			<th width="100">课程简介</th>
			<td><textarea name="info[description]" style="width:400px; height:50px"><?php echo $description;?></textarea></td>
		</tr>
		<tr>
			<th width="100">详细介绍：</th>
			<td>
				<textarea name="info[content]" id="content"><?php echo $content; ?></textarea>
				<?php echo form::ueditor('content','full')?>
			</td>
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