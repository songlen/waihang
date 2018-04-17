<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');?>
<div class="pad_10">
<div class="explain-col" style="margin-bottom: 10px;">
	《<?php echo $title;?>》 报名列表
</div>
<div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
			<tr>
				<th width="10%" align="left">姓名</th>
				<th width="10%" align="left">家属人数</th>
				<th width="20%" align="left">联系电话</th>
				<th width="20%" align="left">其他说明</th>
				<th width="20%" align="left">报名时间</th>
			</tr>
        </thead>
	    <tbody>
			<?php 
			if(is_array($datas)){
				foreach($datas as $info){
			?>
			<tr>
				<td><?php echo $info['fullname']?></td>
				<td><?php echo $info['people_num']?></td>
				<td><?php echo $info['phone']?></td>
				<td><?php echo $info['mark']?></td>
				<td><?php echo $info['inputtime'];?></td>
				
			</tr>
			<?php 
				}
			}
			?>
		</tbody>
	</table>
</div>
</div>
</body>
</html>