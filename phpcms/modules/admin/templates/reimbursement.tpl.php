<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');?>
<div class="pad_10">
	<div id="searchid">
		<form name="searchform" action="" method="get" >
			<input type="hidden" value="admin" name="m">
			<input type="hidden" value="reimbursement" name="c">
			<input type="hidden" value="init" name="a">
			<input type="hidden" value="false" name="menuid">
			<input type="hidden" value="1" name="search">
			<input type="hidden" value="<?php echo $_SESSION['pc_hash'];?>" name="pc_hash">
			<table width="100%" cellspacing="0" class="search-form">
			    <tbody>
					<tr>
						<td>
							<div class="explain-col">
									<select name="searchType">
										<option value="fullname">姓名</option>
										<option value="ID_number">身份证号</option>
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
<div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
			<tr>
				<th width="5%" align="left">序号</th>
				<th width="20%" align="left">姓名</th>
				<th width="20%" align="left">身份证号</th>
				<th width="20%" align="left">手机号</th>
				<th width="15%">操作</th>
			</tr>
        </thead>
	    <tbody>
			<?php 
			if(is_array($datas)){
				foreach($datas as $info){
			?>
			<tr>
				<td><?php echo $info['id']?></td>
				<td><?php echo $info['fullname']?></td>
				<td><?php echo $info['ID_number']?></td>
				<td><?php echo $info['phone']?></td>
				<td align="center">
					<a href="?m=admin&c=reimbursement&a=getOneMember&member_id=<?php echo $info['member_id'];?>">审批</a>
				</td>
			</tr>
			<?php 
				}
			}
			?>
		</tbody>
	</table>
 	<div id="pages"> <?php echo $pages?></div>
</div>
</div>
</body>
</html>