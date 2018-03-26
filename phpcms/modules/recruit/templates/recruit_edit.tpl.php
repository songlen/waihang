<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<script type="text/javascript">
<!--
	$(function(){
	$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'200',height:'50'}, function(){this.close();$(obj).focus();})}});
	$("#title").formValidator({
		onshow:"<?php echo L("input").'广告标题';?>",
		onfocus:"<?php echo L("input").'广告标题';?>",
	}).inputValidator({
			min:1,
			onerror:"<?php echo L("input").'广告标题'?>"});
	})
//-->
</script>
<style type="text/css">
	.selectedJobList {margin-top: 5px;}
	.delSelectedJob {cursor: pointer; padding:2px 4px; background: #efefef;}
	.delSelectedJob {margin-left: 10px;}
</style>
<div class="pad_10">
<form action="?m=recruit&c=recruit&a=edit&id=<?php echo $id;?>" method="post" name="myform" id="myform">
	<table cellpadding="2" cellspacing="1" class="table_form" width="100%">
		
		<tr>
			<th width="100">广告标题：</th>
			<td>
				<input type="text" name="info[title]" id="title" size="30" class="input-text" value="<?php echo $title;?>">
			</td>
		</tr>
		<tr>
			<th width="100">广告类型：</th>
			<td>
				<input class="type" type="radio" name="info[type]" value="1" <?php if($type == '1'){echo 'checked="checked"';}?>> 广告一类
				<input class="type" type="radio" name="info[type]" value="2" <?php if($type == '2'){echo 'checked="checked"';}?>> 广告二类
			</td>
		</tr>
		
		<tr>
			<th width="100">缩略图：</th>
			<td> <?php echo form::images('info[image]', 'image', $image, 'recruit')?><br>
				<?php if($type == '1'){ ?>
				<span class="tip">图片尺寸 540*270</span> 
				<?php } else { ?>
				<span class="tip"">图片尺寸 260*260</span> 
				<?php } ?>
			</td>
		</tr>

		<tr>
			<th width="100">所属航司：</th>
			<td>
				<input type="hidden" name="info[enterprise_id]" id="enterprise_id" size="30" value="<?php echo $enterprise_id;?>">
				<input type="text" name="info[enterprise_name]" id="enterprise_name" readonly="readonly" size="30" class="input-text" value="<?php echo $enterprise_name;?>">
			</td>
		</tr>
		
		<tr>
			<th width="100">选择职位：</th>
			<td>
				<button class="selectjobButton" type="button">选择职位</button>
				<div class="jobListBox">
				<?php foreach ($jobinfos as $jobinfo) {?>
					<div class="selectedJobList"><?php echo $jobinfo['job_name']; ?>
						<input type="hidden" name="info[job_ids][]" value="<?php echo $jobinfo['id']; ?>">
						<span class="delSelectedJob">×</span>
					</div>
				<?php } ?>
				</div>
				
			</td>
		</tr>
		<tr>
			<th width="100"><?php echo L('status');?>：</th>
			<td>
				<input type="radio" name="info[status]" value="1"  <?php if($status == '1'){echo 'checked="checked"';}?>> 正常
				<input type="radio" name="info[status]" value="0"  <?php if($status == '0'){echo 'checked="checked"';}?>> 关闭
			</td>
		</tr>
		<tr>
			<th width="100">详细介绍：</th>
			<td>
				<textarea name="info[content]" id="content"><?php echo $content;?></textarea>
				<?php echo form::ueditor('content','full')?>
			</td>
		</tr>


		<tr>
			<th></th>
			<td>
				<input type="hidden" name="forward" value="?m=recruit&c=recruit&a=edit"> 
				<input type="submit" name="dosubmit" id="dosubmit" class="dialog" value="提交">
			</td>
		</tr>

	</table>
</form>
</div>
<script type="text/javascript">
	// 选择公司
	$(function(){
		$('#enterprise_name').focus(function(){
			var enterprise_id = $('#enterprise_id').val();
			window.top.art.dialog(
				{
					id:'selectEnterprise',
					iframe:'?m=recruit&c=enterprise&a=recruitSelectEnterprise&enterprise_id='+enterprise_id,
					title:'选择航司',
					width:'800',
					height:'450',
					drag:false,

				},
				function(){
					var d = window.top.art.dialog({id:'selectEnterprise'}).data.iframe;
					var radio = d.document.getElementsByName('selectedEnterprise');
					var enterpriseInfo = '';
					if(radio.length > 1){
						for (i=0; i<radio.length; i++) {  
							if (radio[i].checked) {
								enterpriseInfo = radio[i].value;
							}
						}
					}

					var enterpriseInfo = enterpriseInfo.split('-');
					var enterprise_id = $('#enterprise_id').val(); // 获取原始选择的航司id
					$('#enterprise_id').val(enterpriseInfo[0]);
					$('#enterprise_name').val(enterpriseInfo[1]);
					// 如果改变了航司，清除选中的职位
					if((enterprise_id != '') && (enterprise_id != enterpriseInfo[0])){
						$('.jobListBox').html('');
					}

				},
				function(){
					window.top.art.dialog({id:'selectEnterprise'}).close()
				}
			);
		})
	})

	// 选择职位
	$(function(){
		$('.selectjobButton').click(function(){
			var enterprise_id = $('#enterprise_id').val();
			if(enterprise_id == ''){
				alert('请选择航司');
				return false;
			}
			// 获取已选择的职业id
			var selectedJobIds = '';
			var inputJobId = $("input[name='info[job_ids][]'");
			if(inputJobId.length > 0) {
				for (var i = 0; i < inputJobId.length; i++) {
					selectedJobIds += inputJobId[i].value+',';
				}
			}

			window.top.art.dialog(
				{
					id:'selectJob',
					iframe:'?m=recruit&c=job&a=recruitSelectJob&enterprise_id='+enterprise_id+'&selectedJobIds='+selectedJobIds,
					title:'选择职位',
					width:'800',
					height:'450',
					drag:false,

				},
				function(){
					var d = window.top.art.dialog({id:'selectJob'}).data.iframe;
					var jobs = d.document.getElementsByName('selectedJob[]');
					var jobInfo = '';
					if(jobs.length > 0){
						$('.jobListBox').html('');
						for (i=0; i<jobs.length; i++) {  
							if (jobs[i].checked) {
								jobInfo = jobs[i].value;
								jobInfo = jobInfo.split('-');
								var html = '<div class="selectedJobList">'+jobInfo[1]
								+'<input type="hidden" name="info[job_ids][]" value="'+jobInfo[0]+'">'
								+'<span class="delSelectedJob">×</span>'
								+'</div>'
								$('.jobListBox').append(html);
							}
						}
					}

					// var jobInfo = jobInfo.split('-');
					// $('#enterprise_id').val(jobInfo[0]);
					// $('#enterprise_name').val(jobInfo[1]);
				},
				function(){
					window.top.art.dialog({id:'selectJob'}).close()
				}
			);
		})
	})
	
	// 删除职位
	$(document).on('click', '.delSelectedJob', function(){
		$(this).parents('.selectedJobList').remove();
	})

	// 选择广告类别
	$(function(){
		$('.type').click(function(){
			var type_val = $(this).val();
			$('.tip').hide();
			$('.tip').eq(type_val-1).show();
		})
	})
</script>
</body>
</html> 