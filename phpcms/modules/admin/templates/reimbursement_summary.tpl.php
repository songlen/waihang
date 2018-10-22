<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');?>
<div class="pad_10">
	<div id="searchid">
		<form name="searchform" action="" method="get" >
			<input type="hidden" value="admin" name="m">
			<input type="hidden" value="reimbursement" name="c">
			<input type="hidden" value="summary" name="a">
			<input type="hidden" value="false" name="menuid">
			<input type="hidden" value="1" name="search">
			<input type="hidden" value="<?php echo $_SESSION['pc_hash'];?>" name="pc_hash">
			<table width="100%" cellspacing="0" class="search-form">
			    <tbody>
					<tr>
						<td>
							<div class="explain-col">
									审核日期：
									<?php echo form::date('start_time', $start_time);?>
									- &nbsp;
									<?php echo form::date('end_time', $end_time);?>
									<input type="submit" name="search" class="button" value="<?php echo L('search');?>" />
									<input type="submit" name="export" class="button" value="导出" />
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
				<th width="20%" align="left">航司代码</th>
				<th width="20%" align="left">姓名</th>
				<th width="20%" align="left">身份证号</th>
				<th width="20%" align="left">累计有效自付</th>
				<th width="20%" align="left">补充报销95%</th>
			</tr>
        </thead>
	    <tbody>
			<?php 
			if(is_array($datas)){
				foreach($datas as $info){
			?>
			<tr>
				<td><?php echo $info['number']?></td>
				<td><?php echo $info['fullname']?></td>
				<td><?php echo $info['ID_number']?></td>
				<td><?php echo $info['sum_amount']?></td>
				<td><?php echo sprintf('%.2f', $info['sum_amount']*0.95)?></td>
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