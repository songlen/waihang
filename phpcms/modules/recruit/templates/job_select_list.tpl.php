<?php
defined('IN_ADMIN') or exit('No permission resources.');
$show_dialog = 1;
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-10">

	<div id="searchid">
		<form name="searchform" action="" method="get" >
			<input type="hidden" value="recruit" name="m">
			<input type="hidden" value="job" name="c">
			<input type="hidden" value="recruitSelectJob" name="a">
			<input type="hidden" name="enterprise_id" value="<?php echo $enterprise_id;?>">
			<input type="hidden" value="1" name="search">
			<!-- <input type="hidden" value="<?php echo $_SESSION['pc_hash'];?>" name="pc_hash"> -->
			<table width="100%" cellspacing="0" class="search-form">
			    <tbody>
					<tr>
						<td>
							<div class="explain-col">
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
				<th width="3%" align="center"></th>
				<th width="3%">ID</th>
				<th width="40%" align="center"><?php echo L('job_name')?></th>
				<th width="10%" align="center"><?php echo L('job_code')?></th>
				<th width="15%" align="center">添加时间</th>
			</tr>
		</thead>
	<tbody>

	<?php
		if(is_array($infos)){
			foreach($infos as $info){
	?>
		<tr>
			<td align="center" width="3%"><input <?php if(in_array($info['id'], $selectedJobIds)){echo 'checked="checked"';}?> type="checkbox" name="selectedJob[]" value="<?php echo $info['id'].'-'.$info['job_name'];?>"></td>
			<td align="center" width="3%"><?php echo $info['id'];?></td>
			<td align="center" width="40%"><?php echo $info['job_name']?></td>
			<td align="center" width="10%"><?php echo $info['code'];?></td>
			<td align="center" width="15%"><?php echo date('Y-m-d H:i:s', $info['inputtime'])?></td>

		</tr>
		<?php
		}
	}
	?>
	</tbody>
	</table>
	</div>

	<!-- <div id="pages"><?php echo $pages?></div> -->
	</form>
</div>
<script type="text/javascript">

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
