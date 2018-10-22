<?php
defined('IN_ADMIN') or exit('No permission resources.');
$show_dialog = 1;
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-10">

	<div class="content-menu ib-a blue line-x">
		<a class="add fb" href="javascript:;" onclick="add()"><em>添加课程</em></a> <span></span>
		
	</div>
	<div id="searchid">
		<form name="searchform" action="" method="get" >
			<input type="hidden" value="train" name="m">
			<input type="hidden" value="lesson" name="c">
			<input type="hidden" value="init" name="a">
			<input type="hidden" value="1" name="search">
			<input type="hidden" value="<?php echo $_SESSION['pc_hash'];?>" name="pc_hash">
			<table width="100%" cellspacing="0" class="search-form">
			    <tbody>
					<tr>
						<td>
							<div class="explain-col">
									<input name="keyword" type="text" value="<?php if(isset($keyword)) echo $keyword;?>" class="input-text" placeholder="课程名称" />
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
				<th width="3%" align="center"><?php echo L('listorder')?></th>
				<th width="3%">ID</th>
				<th width="30%" align="center">课程名称</th>
				<th width="10%" align="center">课程类别</th>
				<th width="15%" align="center">添加时间</th>
				<th width="15%" align="center">操作</th>
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
			<td align="center" width="30%"><?php echo $info['title']?></td>
			<td align="center" width="10%">
				<?php if($info['type'] == '1') echo '线下课程';?>
				<?php if($info['type'] == '2') echo '线上课程';?>
			</td>
			<td align="center" width="15%"><?php echo date('Y-m-d', strtotime($info['inputtime']))?></td>
			<td align="center" width="15%">
				<a href="index.php?m=train&c=order&lesson_id=<?php echo $info['id'];?>">订单管理</a> |  
				<a href="###" onclick="edit(<?php echo $info['id']?>)">修改</a> |  
				<a href='?m=train&c=lesson&a=delete&id=<?php echo $info['id']?>' onClick="return confirm('<?php echo L('confirm', array('message' => new_addslashes(new_html_special_chars($info['title']))))?>')">删除</a> 
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
		<input type="submit" class="button" name="dosubmit" onClick="document.myform.action='?m=train&c=lesson&a=delete'" value="<?php echo L('delete')?>"/>&nbsp;&nbsp;
		<input name="dosubmit" type="submit" class="button"
		value="<?php echo L('listorder')?>">
		
	</div>
	<div id="pages"><?php echo $pages?></div>
	</form>
</div>
<script type="text/javascript">
	function add() {
		window.top.art.dialog({id:'add'}).close();
		window.top.art.dialog(
			{
				title:'添加课程',
				id:'add',
				iframe:'?m=train&c=lesson&a=add',
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

	function edit(id) {
		window.top.art.dialog({id:'edit'}).close();
		window.top.art.dialog(
			{
				title:'<?php echo L('edit')?>',
				id:'edit',
				iframe:'?m=train&c=lesson&a=edit&id='+id,
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
