<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');?>
<div class="pad_10">
<div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
			<tr>
				<th width="60%" align="left">活动标题</th>
				<th width="20%" align="left">创建时间</th>
				<th width="15%">操作</th>
			</tr>
        </thead>
	    <tbody>
			<?php 
			if(is_array($datas)){
				foreach($datas as $info){
			?>
			<tr>
				<td><?php echo $info['title']?></td>
				<td><?php echo date('Y-m-d H:i:s', $info['inputtime']);?></td>
				<td align="center">
					<a href="?m=admin&c=activity&a=enroll_list&activity_id=<?php echo $info['id'];?>&title=<?php echo $info['title'];?>">报名列表</a>
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