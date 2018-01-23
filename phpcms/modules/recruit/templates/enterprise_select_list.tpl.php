<?php
defined('IN_ADMIN') or exit('No permission resources.');
$show_dialog = 1;
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-10">


	<div id="searchid">
		<form name="searchform" action="" method="get" >
			<input type="hidden" value="recruit" name="m">
			<input type="hidden" value="enterprise" name="c">
			<input type="hidden" value="recruitSelectEnterprise" name="a">
			<input type="hidden" value="1" name="search">
			<!-- <input type="hidden" value="<?php echo $_SESSION['pc_hash'];?>" name="pc_hash"> -->
			<table width="100%" cellspacing="0" class="search-form">
			    <tbody>
					<tr>
						<td>
							<div class="explain-col">
									<input name="keyword" type="text" value="<?php if(isset($keyword)) echo $keyword;?>" class="input-text" placeholder="<?php echo L('enterprise_name');?>" />
									<input type="submit" name="search" class="button" value="<?php echo L('search');?>" />
							</div>
						</td>
					</tr>
			    </tbody>
			</table>
		</form>
	</div>

	<form name="myform" id="myform" action="?m=recruit&c=enterprise&a=listorder" method="post" >
	<div class="table-list">
	<table width="100%" cellspacing="0">
		<thead>
			<tr>
				<th width="3%" align="center"></th>
				<th width="3%">ID</th>
				<th width="50%" align="center"><?php echo L('enterprise_name')?></th>
				<th width="10%" align="center"><?php echo L('enterprise_logo')?></th>
				<th width="10%" align="center">添加时间</th>
			</tr>
		</thead>
	<tbody>

	<?php
		if(is_array($infos)){
			foreach($infos as $info){
	?>
		<tr>
			<td align="center" width="3%"><input type="radio" <?php if($_GET['enterprise_id'] == $info['id']){echo 'checked="checked"';}?> name="selectedEnterprise" value="<?php echo $info['id'].'-'.$info['name'];?>"></td>
			<td align="center" width="3%"><?php echo $info['id'];?></td>
			<td align="center" width="50%"><?php echo $info['name']?></td>
			<td align="center" width="10%"><img width="100" height="50" src="<?php echo $info['logo']?>" alt="<?php echo L('enterprise_logo')?>"></td>
			<td align="center" width="10%"><?php echo date('Y-m-d H:i:s', $info['inputtime'])?></td>

		</tr>
		<?php
		}
	}
	?>
	</tbody>
	</table>
	</div>
	<div id="pages"><?php echo $pages?></div>
	</form>
</div>
</body>
</html>
