<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>
<div class="pad-lr-10">
<form name="searchform" action="" method="get" >
<input type="hidden" value="member" name="m">
<input type="hidden" value="member" name="c">
<input type="hidden" value="manage" name="a">
<input type="hidden" value="72" name="menuid">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td>
		<div class="explain-col">
				
				<?php echo L('regtime')?>：
				<?php echo form::date('start_time', $start_time)?>-
				<?php echo form::date('end_time', $end_time)?>

				<select name="status">
					<option value='0' <?php if(isset($_GET['status']) && $_GET['status']==0){?>selected<?php }?>><?php echo L('status')?></option>
					<option value='1' <?php if(isset($_GET['status']) && $_GET['status']==1){?>selected<?php }?>><?php echo L('lock')?></option>
					<option value='2' <?php if(isset($_GET['status']) && $_GET['status']==2){?>selected<?php }?>><?php echo L('normal')?></option>
				</select>
				<select name="sex">
					<option value='0' <?php if(isset($_GET['sex']) && $_GET['sex']==0){?>selected<?php }?>>性别</option>
					<option value='1' <?php if(isset($_GET['sex']) && $_GET['sex']==1){?>selected<?php }?>>男</option>
					<option value='2' <?php if(isset($_GET['sex']) && $_GET['sex']==2){?>selected<?php }?>>女</option>
				</select>

				
				<select name="type">
					<option value=''>请选择</option>
					<option value='fullname' <?php if(isset($_GET['type']) && $_GET['type']=='fullname'){?>selected<?php }?>>姓名</option>
					<option value='ID_number' <?php if(isset($_GET['type']) && $_GET['type']=='ID_number'){?>selected<?php }?>>身份证号</option>
					<option value='mobile' <?php if(isset($_GET['type']) && $_GET['type']=='mobile'){?>selected<?php }?>>手机号</option>
				</select>
				
				<input name="keyword" type="text" value="<?php if(isset($_GET['keyword'])) {echo input('keyword');}?>" class="input-text" />
				<input type="submit" name="search" class="button" value="<?php echo L('search')?>" />
				<input type="submit" name="export" class="button" value="导出" />
	</div>
		</td>
		</tr>
    </tbody>
</table>
</form>

<form name="myform" action="?m=member&c=member&a=delete" method="post" onsubmit="checkuid();return false;">
<div class="table-list">
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			<th  align="left" width="20"><input type="checkbox" value="" id="check_box" onclick="selectall('userid[]');"></th>
			<th align="left"><?php echo L('uid')?></th>
			<th align="left">姓名</th>
			<th align="left">身份证号</th>
			<th align="left">性别</th>
			<th align="left">账号</th>
			<th align="left">头像</th>
			<th align="left">是否员工</th>
			<th align="left">状态</th>
			<th align="left"><?php echo L('lastlogintime')?></th>
			<th align="left"><?php echo L('operation')?></th>
		</tr>
	</thead>
<tbody>
<?php
	if(is_array($memberlist)){
	foreach($memberlist as $k=>$v) {
?>
    <tr>
		<td align="left"><input type="checkbox" value="<?php echo $v['userid']?>" name="userid[]"></td>
		<td align="left"><?php echo $v['userid']?></td>
		<td align="left"><?php echo $v['fullname']?></td>
		<td align="left"><?php echo $v['ID_number']?></td>
		<td align="left"><?php echo $enums['sex'][$v['sex']]?></td>
		<td align="left"><?php 
			if($v['mobile']){
				echo $v['mobile'];
			} else {
				echo $v['email'];
			}
			
		?></td>
		<td align="left"><img src="<?php if($v['headimg']){echo $v['headimg'];} else {echo IMG_PATH.'member/nophoto.gif';}?>" height=20 width=20 /></td>
		<td align="left">
			<?php if($v['is_employee']){echo '是';} else {echo '否';}?>
		</td>
		<td align="left">
			<?php if($v['islock']){echo '<img title="锁定" src="'.IMG_PATH.'icon/icon_padlock.gif">';} else {echo '正常';}?>
		</td>
		<td align="left"><?php echo format::date($v['lastdate'], 1);?></td>
		<td align="left">
			<a href="javascript:member_infomation(<?php echo $v['userid']?>)">查看</a> <span>|</span>
			<a href="javascript:edit(<?php echo $v['userid']?>)"><?php echo L('edit')?></a>
		</td>
    </tr>
<?php
	}
}
?>
</tbody>
</table>

<div class="btn">
<label for="check_box"><?php echo L('select_all')?>/<?php echo L('cancel')?></label> <input type="submit" class="button" name="dosubmit" value="<?php echo L('delete')?>" onclick="return confirm('<?php echo L('sure_delete')?>')"/>
<input type="submit" class="button" name="dosubmit" onclick="document.myform.action='?m=member&c=member&a=lock'" value="<?php echo L('lock')?>"/>
<input type="submit" class="button" name="dosubmit" onclick="document.myform.action='?m=member&c=member&a=unlock'" value="<?php echo L('unlock')?>"/>
<input type="submit" class="button" name="dosubmit" onclick="document.myform.action='?m=member&c=member&a=changeEmployee&type=1'" value="设为员工"/>
<input type="submit" class="button" name="dosubmit" onclick="document.myform.action='?m=member&c=member&a=changeEmployee&type=0'" value="取消员工"/>
</div>

<div id="pages"><?php echo $pages?></div>
</div>
</form>
</div>
<script type="text/javascript">
<!--
function edit(id) {
	window.top.art.dialog({id:'edit'}).close();
	window.top.art.dialog({title:'<?php echo L('edit').L('member')?>',id:'edit',iframe:'?m=member&c=member&a=edit&userid='+id,width:'700',height:'500'}, function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;d.document.getElementById('dosubmit').click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
}
function move() {
	var ids='';
	$("input[name='userid[]']:checked").each(function(i, n){
		ids += $(n).val() + ',';
	});
	if(ids=='') {
		window.top.art.dialog({content:'<?php echo L('plsease_select').L('member')?>',lock:true,width:'200',height:'50',time:1.5},function(){});
		return false;
	}
	window.top.art.dialog({id:'move'}).close();
	window.top.art.dialog({title:'<?php echo L('move').L('member')?>',id:'move',iframe:'?m=member&c=member&a=move&ids='+ids,width:'700',height:'500'}, function(){var d = window.top.art.dialog({id:'move'}).data.iframe;d.$('#dosubmit').click();return false;}, function(){window.top.art.dialog({id:'move'}).close()});
}

function checkuid() {
	var ids='';
	$("input[name='userid[]']:checked").each(function(i, n){
		ids += $(n).val() + ',';
	});
	if(ids=='') {
		window.top.art.dialog({content:'<?php echo L('plsease_select').L('member')?>',lock:true,width:'200',height:'50',time:1.5},function(){});
		return false;
	} else {
		myform.submit();
	}
}

function member_infomation(userid, modelid, name) {
	window.top.art.dialog({id:'modelinfo'}).close();
	window.top.art.dialog({title:'<?php echo L('memberinfo')?>',id:'modelinfo',iframe:'?m=member&c=member&a=memberinfo&userid='+userid+'&modelid='+modelid,width:'700',height:'500'}, function(){var d = window.top.art.dialog({id:'modelinfo'}).data.iframe;d.document.getElementById('dosubmit').click();return false;}, function(){window.top.art.dialog({id:'modelinfo'}).close()});
}

//-->
</script>
</body>
</html>