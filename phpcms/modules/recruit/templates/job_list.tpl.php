<?php
defined('IN_ADMIN') or exit('No permission resources.');
$show_dialog = 1;
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-10">

	<div class="content-menu ib-a blue line-x">
		<a class="add fb" href="javascript:;" onclick="javascript:window.top.art.dialog({id:'add',iframe:'?m=recruit&c=job&a=add&enterprise_id=<?php echo input("enterprise_id");?>&enterprise_name=<?php echo input("enterprise_name");?>', title:'<?php echo l('job_add');?>', width:'800', height:'450'}, function(){var d = window.top.art.dialog({id:'add'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'add'}).close()});void(0);"><em><?php echo l('job_add');?></em></a> <span></span>
		<a href="javascript:;" onclick="javascript:$('#searchid').css('display','');"><em><?php echo L('search');?></em></a>
	</div>
	<div id="searchid" style="display:<?php if(!isset($_GET['search'])) echo 'none';?>">
		<form name="searchform" action="" method="get" >
			<input type="hidden" value="recruit" name="m">
			<input type="hidden" value="job" name="c">
			<input type="hidden" value="init" name="a">
			<input type="hidden" name="enterprise_id" value="<?php echo $enterprise_id;?>">
			<input type="hidden" value="1" name="search">
			<!-- <input type="hidden" value="<?php echo $_SESSION['pc_hash'];?>" name="pc_hash"> -->
			<table width="100%" cellspacing="0" class="search-form">
			    <tbody>
					<tr>
						<td>
							<div class="explain-col">
									<select name="searchType" id="">
										<option value="job_name">职位名称</option>
										<option value="interview_place">面试地点</option>
									</select>
									<input name="keyword" type="text" value="<?php if(isset($keyword)) echo $keyword;?>" class="input-text" placeholder="<?php echo L('job_name');?>" />
									<input type="submit" name="search" class="button" value="<?php echo L('search');?>" />
							</div>
						</td>
					</tr>
			    </tbody>
			</table>
		</form>
	</div>

	<form name="myform" id="myform" action="?m=recruit&c=job&a=listorder" method="post" >
	<div class="table-list">
	<table width="100%" cellspacing="0">
		<thead>
			<tr>
				<th width="3%" align="center"><input type="checkbox" value="" id="check_box" onclick="selectall('id[]');"></th>
				<th width="3%" align="center"><?php echo L('listorder')?></th>
				<th width="3%">ID</th>
				<th width="25%" align="center"><?php echo L('job_name')?></th>
				<th width="10%" align="center">所属航司</th>
				<th width="10%" align="center"><?php echo L('job_code')?></th>
				<th width="5%" align="center"><?php echo L('job_status')?></th>
				<th width="15%" align="center">添加时间</th>
				<th width="20%" align="center">操作</th>
			</tr>
		</thead>
	<tbody>

	<?php
		if(is_array($infos)){
			foreach($infos as $info){
	?>
		<tr>
			<td align="center" width="3%"><input type="checkbox" name="id[]" value="<?php echo $info['id']?>"></td>
			<td align="center" width="3%"><input name='listorders[<?php echo $info['id']?>]' type='text' size='3' value='<?php echo $info['listorder']?>' class="input-text-c"></td>
			<td align="center" width="3%"><?php echo $info['id'];?></td>
			<td align="center" width="25%"><?php echo $info['job_name']?></td>
			<td align="center" width="10%"><?php echo $info['enterprise_name']?></td>
			<td align="center" width="10%"><?php echo $info['code'];?></td>
			<td align="center" width="5%"><?php if($info['status'] == '1'){echo L('job_status_1');} else {echo L('job_status_0');}?></td>
			<td align="center" width="15%"><?php echo date('Y-m-d H:i:s', $info['inputtime'])?></td>
			<td align="center" width="20%">
				<a href="?m=recruit&c=enroll&a=init&job_id=<?php echo $info['id']?>">应聘者</a> |
				<a href="###" onclick="copy(<?php echo $info['id'];?>)">关联复制</a> |
				<a href="###" onclick="edit(<?php echo $info['id']?>, '<?php echo new_addslashes(new_html_special_chars($info['job_name']))?>')">修改</a> |  
				<a href='?m=recruit&c=job&a=delete&id=<?php echo $info['id']?>' onClick="return confirm('<?php echo L('confirm', array('message' => new_addslashes(new_html_special_chars($info['name']))))?>')">删除</a> <!--  |
				<a href="###" onclick="statistics(<?php echo $info['job_id'];?>)">统计</a> -->
			</td>
		</tr>
		<?php
		}
	}
	?>
	</tbody>
	</table>
	</div>
	<div class="btn">
		<input type="submit" class="button" name="dosubmit" onClick="document.myform.action='?m=recruit&c=job&a=delete'" value="<?php echo L('delete')?>"/>&nbsp;&nbsp;
		<input name="dosubmit" type="submit" class="button"
		value="<?php echo L('listorder')?>">
		
	</div>
	<div id="pages"><?php echo $pages?></div>
	</form>
</div>
<script type="text/javascript">
// 统计
function statistics(id){
	window.top.art.dialog({
			id:'add',
			iframe:'?m=recruit&c=enroll&a=statistics&id='+id,
			title:'详情',
			width:'1000',
			height:'550'
		}, function(){
			window.top.art.dialog({id:'statistics'}).close()
		}, function(){
			window.top.art.dialog({id:'statistics'}).close()
		}
	);
}

function copy(id) {
	window.top.art.dialog({id:'add'}).close();
	window.top.art.dialog(
		{
			title:'添加职位',
			id:'add',
			iframe:'?m=recruit&c=job&a=add&copy=1&job_id='+id,
			width:'800',
			height:'450'
		},
		function(){
			var d = window.top.art.dialog({id:'add'}).data.iframe;
			var form = d.document.getElementById('dosubmit');
			form.click();
			return false;
		},
		function(){
			window.top.art.dialog({id:'add'}).close()
		}
	);
}

function edit(id, name) {
	window.top.art.dialog({id:'edit'}).close();
	window.top.art.dialog(
		{
			title:'<?php echo L('edit')?> '+name+' ',
			id:'edit',
			iframe:'?m=recruit&c=job&a=edit&id='+id,
			width:'800',
			height:'450'
		},
		function(){
			var d = window.top.art.dialog({id:'edit'}).data.iframe;
			var form = d.document.getElementById('dosubmit');
			form.click();
			return false;
		},
		function(){
			window.top.art.dialog({id:'edit'}).close()
		}
	);
}
</script>
</body>
</html>
