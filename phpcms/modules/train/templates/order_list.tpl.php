<?php
defined('IN_ADMIN') or exit('No permission resources.');
$show_dialog = 1;
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-10">

	<div id="searchid">
		<form name="searchform" action="" method="get" >
			<input type="hidden" value="train" name="m">
			<input type="hidden" value="order" name="c">
			<input type="hidden" value="init" name="a">
			<input type="hidden" value="1" name="search">
			<input type="hidden" value="<?php echo $_SESSION['pc_hash'];?>" name="pc_hash">
			<input type="hidden" value="<?php echo $lesson_id;?>" name="lesson_id">
 			<table width="100%" cellspacing="0" class="search-form">
			    <tbody>
					<tr>
						<td>
							<div class="explain-col">
								<select name="searchType" id="">
									<option value="">请选择</option>
									<option value="title" <?php if($searchType == 'title') echo 'selected=selected';?>>课程名称</option>
									<option value="mobile" <?php if($searchType == 'mobile') echo 'selected=selected';?>>手机号</option>
								</select>
								<input name="keyword" type="text" value="<?php if(isset($keyword)) echo $keyword;?>" class="input-text" placeholder="搜索关键词" />
								<input type="submit" name="search" class="button" value="<?php echo L('search');?>" />
							</div>
						</td>
					</tr>
			    </tbody>
			</table>
		</form>
	</div>

	<form name="myform" id="myform" action="?m=train&c=lesson&a=listorder" method="post" >
	<div class="table-list">
	<table width="100%" cellspacing="0">
		<thead>
			<tr>
				<th width="3%" align="center"><input type="checkbox" value="" id="check_box" onclick="selectall('id[]');"></th>
				<th width="200" align="center">课程名称</th>
				<th width="100" align="center">用户手机</th>
				<th width="100" align="center">订单金额</th>
				<th width="100" align="center">订单状态</th>
				<th width="15%" align="center">下单时间</th>
				<th width="15%" align="center">操作</th>
			</tr>
		</thead>
	<tbody>

	<?php
		if(is_array($lists)){
			foreach($lists as $info){
	?>
		<tr>
			<td align="center" width="3%"><input type="checkbox" name="id[]" value="<?php echo $info['id']?>"></td>
			<td align="center" width="200"><?php echo $info['title']?></td>
			<td align="center" width="100"><?php echo $info['mobile']?></td>
			<td align="center" width="100"><?php echo $info['price']?></td>
			<td align="center" width="100">
				<select name="status" id="status">
					<option value="1" <?php if($info['status'] == '1'){ ?>selected="selected"<?php } ?>>未支付</option>
					<option value="2" <?php if($info['status'] == '2'){ ?>selected="selected"<?php } ?>>已支付</option>
				</select>
				
			</td>
			<td align="center" width="15%"><?php echo date('Y-m-d', strtotime($info['inputtime']))?></td>
			<td align="center" width="15%">
				<a href='?m=train&c=order&a=delete&id=<?php echo $info['id']?>' onClick="return confirm('确定删除吗？')">删除</a> 
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

		
	</div>
	<div id="pages"><?php echo $pages?></div>
	</form>
</div>
<link rel="stylesheet" href="statics/plugin/layui/css/modules/layer/default/layer.css">
<script type="text/javascript" src="statics/plugin/layui/lay/modules/layer.js"></script>
<script type="text/javascript">
	$('select[name=status]').change(function(){
		var id = $(this).parents('tr').find('input[name="id[]"]').val();
		var status = $(this).val();

		$.ajax({
			url: '?m=train&c=order&a=ajax_change_status&pc_hash=<?php echo $_GET["pc_hash"]?>&id='+id+'&status='+status,
			type: 'get',
			dateType: 'json',
			success: function(data){
				layer.msg('修改成功');
			}
		})
	})
</script>
</body>
</html>
