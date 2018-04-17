<?php
defined('IN_ADMIN') or exit('No permission resources.');
$show_dialog = 1;
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-10">

	<div id="searchid">
		<form name="searchform" action="" method="get" >
			<input type="hidden" value="recruit" name="m">
			<input type="hidden" value="enroll" name="c">
			<input type="hidden" value="init" name="a">
			<input type="hidden" value="1" name="search">
			<input type="hidden" value="<?php echo $_SESSION['pc_hash'];?>" name="pc_hash">
			<table width="100%" cellspacing="0" class="search-form">
			    <tbody>
					<tr>
						<td>
							<div class="explain-col">
									<select name="diploma" id="">
										<option value="">学历</option>
										<?php foreach($enums['diploma'] as $k => $v) { ?>
										<option <?php if($diploma == $k) echo 'selected';?> value="<?php echo $k;?>"><?php echo $v;?></option>
										<?php } ?>
									</select>
									&nbsp;
									<select name="height" id="">
										<option value="">身高</option>
										<option <?php if($height == '180') echo 'selected';?> value="180">180 以上</option>
										<option <?php if($height == '175') echo 'selected';?> value="175">175 以上</option>
										<option <?php if($height == '170') echo 'selected';?> value="170">170 以上</option>
										<option <?php if($height == '165') echo 'selected';?> value="165">165 以上</option>
										<option <?php if($height == '160') echo 'selected';?> value="160">160 以上</option>
									</select>
									&nbsp;
									<select name="sex" id="">
										<option value="">性别</option>
										<?php foreach($enums['sex'] as $k => $v) { ?>
										<option <?php if($sex == $k && $sex != '') echo 'selected';?> value="<?php echo $k;?>"><?php echo $v;?></option>
										<?php } ?>
									</select>
									&nbsp;
									<select name="searchType" id="">
										<option <?php if($searchType == 'fullname') echo 'selected'; ?> value="fullname">姓名</option>
										<option <?php if($searchType == 'email') echo 'selected'; ?> value="email">邮箱</option>
										<option <?php if($searchType == 'ID_number') echo 'selected'; ?> value="ID_number">身份证号</option>
									</select>
									<input name="keyword" type="text" value="<?php if(isset($keyword)) echo $keyword;?>" class="input-text" />
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
				<th width="3%">ID</th>
				<th width="80" align="center">姓名</th>
				<th width="5%" align="center">性别</th>
				<th width="5%" align="center">年龄</th>
				<th width="5%" align="center">身高(cm)</th>
				<th width="5%" align="center">体重(kg)</th>
				<th width="80" align="center">联系电话</th>
				<th width="10%" align="center">出生日期</th>
				<th width="5%" align="center">状态</th>
				<th width="15%" align="center">操作</th>
			</tr>
		</thead>
	<tbody>

	<?php
		if(is_array($result)){
			foreach($result as $info){
	?>
		<tr>
			<td align="center" width="3%"><input type="checkbox" name="id[]" value="<?php echo $info['id']?>"></td>
			<td align="center" width="3%"><?php echo $info['id'];?></td>
			<td align="center" width="10%"><?php echo $info['fullname']?></td>
			<td align="center" width="5%"><?php echo $enums['sex'][$info['sex']]?></td>
			<td align="center" width="5%"><?php echo $info['age'];?></td>
			<td align="center" width="5%"><?php echo $info['height'];?></td>
			<td align="center" width="5%"><?php echo $info['weight'];?></td>
			<td align="center" width="10%"><?php echo $info['mobile_phone']?></td>
			<td align="center" width="10%"><?php echo $info['birthday'];?></td>
			<td align="center" width="5%">
				<input type="hidden" name="id" value="<?php echo $info['id'];?>">
				<select name="status">
					<?php foreach($recruit_enroll_status as $k => $v){ ?>
					<option value="<?php echo $k;?>" <?php if($k == $info['status']) echo 'selected'; ?>><?php echo $v; ?></option>
					<?php } ?>
				</select>
			</td>
			<td align="center" width="15%">
				<a href="###" onclick="detail(<?php echo $info['id']?>)">查看</a>
				<!-- <a href="###" onclick="edit(<?php echo $info['id']?>, '<?php echo new_addslashes(new_html_special_chars($info['job_name']))?>')">修改</a>  -->

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
function add(){
	window.top.art.dialog({
			id:'add',
			iframe:'?m=recruit&c=job&a=add&enterprise_id=<?php echo $_GET["enterprise_id"];?>&enterprise_name=<?php echo $_GET["enterprise_name"];?>',
			title:'<?php echo l('job_add');?>',
			width:'800',
			height:'450'
		}, function(){
			var d = window.top.art.dialog({id:'add'}).data.iframe;
			var form = d.document.getElementById('dosubmit');
			form.click();return false;
		}, function(){
			window.top.art.dialog({id:'add'}).close()
		}
	);
}

function detail(id){
	window.top.art.dialog({
			id:'add',
			iframe:'?m=recruit&c=enroll&a=detail&id='+id,
			title:'详情',
			width:'800',
			height:'450'
		}, function(){
			return false;
		}, function(){
			window.top.art.dialog({id:'detail'}).close()
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
<script type="text/javascript">
	$(function(){
		$('select[name=status]').change(function(){
			var id = $(this).parents('tr').find('input[name=id]').val();
			var status = $(this).val();

			$.ajax({
				url: '?m=recruit&c=enroll&a=ajax_change_status&pc_hash=<?php echo $_GET["pc_hash"]?>&id='+id+'&status='+status,
				type: 'get',
				dateType: 'json',
				success: function(data){

				}
			})
		})
	})
</script>
</body>
</html>
