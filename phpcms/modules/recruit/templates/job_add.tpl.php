<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<script type="text/javascript">
<!--
	$(function(){
	$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'200',height:'50'}, function(){this.close();$(obj).focus();})}});
	$("#name").formValidator({onshow:"<?php echo L("input").L('job_name')?>",onfocus:"<?php echo L("input").L('job_name')?>"}).inputValidator({min:1,onerror:"<?php echo L("input").L('job_name')?>"});

	})
//-->
</script>

<div class="pad_10">
<form action="?m=recruit&c=job&a=add" method="post" name="myform" id="myform">
	<table cellpadding="2" cellspacing="1" class="table_form" width="100%">
		<tr>
			<th width="100">所属公司：</th>
			<td>
				<?php if($is_copy){  ?>
				<input type="hidden" name="info[enterprise_id]" id="enterprise_id" value="<?php echo $enterprise_id;?>" size="30">
				<input type="hidden" name="info[enterprise_name]" id="enterprise_name" value="<?php echo $enterprise_name;?>" size="30">
				<?php echo $enterprise_name;?>
				<?php } else { ?>
				<input type="hidden" name="info[enterprise_id]" id="enterprise_id" size="30">
				<input type="text" name="info[enterprise_name]" id="enterprise_name" readonly="readonly" size="30" class="input-text">
				<?php } ?>
			</td>
		</tr>

		<tr>
			<th width="100">职位类别：</th>
			<td>
				<input type="radio" name="info[type]" <?php if($type == '1') echo 'checked="checked"';?> value="1"> 空乘类
				<input type="radio" name="info[type]" <?php if($type == '2') echo 'checked="checked"';?> value="2"> 非空乘类
			</td>
		</tr>
		
		<tr>
			<th width="100"><?php echo L('job_name')?>：</th>
			<td><input type="text" name="info[job_name]" id="job_name" size="30" value="<?php echo $job_name;?>" class="input-text"></td>
		</tr>
		
		<tr>
			<th width="100">招聘人数：</th>
			<td><input type="text" name="info[people_num]" id="people_num" size="30" value="<?php echo $people_num;?>" class="input-text"></td>
		</tr>
		
		<tr>
			<th width="100">工作经验：</th>
			<td><input type="text" name="info[work_experience]" id="work_experience" size="30" value="<?php echo $work_experience;?>" class="input-text"></td>
		</tr>
		
		<tr>
			<th width="100">工资待遇：</th>
			<td><input type="text" name="info[salary]" id="salary" size="30" value="<?php echo $salary;?>"" class="input-text"></td>
		</tr>
		
		<tr>
			<th width="100">工作地点：</th>
			<td><input type="text" name="info[location]" id="location" size="30" value="<?php echo $location;?>"" class="input-text"></td>
		</tr>
		
		<tr>
			<th width="100">面试地点：</th>
			<td><input type="text" name="info[interview_place]" id="interview_place" size="30" value="<?php echo $interview_place;?>"" class="input-text"></td>
		</tr>

		<tr>
			<th width="100"><?php echo L('status');?>：</th>
			<td>
				<input type="radio" name="info[status]" value="1" checked="checked"?> <?php echo L('job_status_1');?>
				<input type="radio" name="info[status]" value="0"> <?php echo L('job_status_0');?>
			</td>
		</tr>

		<tr>
			<th width="100">详细介绍：</th>
			<td>
				<textarea name="info[content]" id="content"><?php echo $content;?></textarea>
				<?php echo form::ueditor('content')?>
			</td>
		</tr>


		<tr>
			<th></th>
			<td>
				<input type="hidden" name="forward" value="?m=recruit&c=job&a=add"> 
				<input type="submit" name="dosubmit" id="dosubmit" class="dialog" value="提交">
			</td>
		</tr>

	</table>
	<?php if($is_copy) { ?>
		<input type="hidden" name="info[code]" value="<?php echo $code;?>">
		<input type="hidden" name="copy"  value="1">
	<?php } ?>
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


				},
				function(){
					window.top.art.dialog({id:'selectEnterprise'}).close()
				}
			);
		})
	})
</script>
</body>
</html> 