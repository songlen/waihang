<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');?>
<div class="pad_10">
<div class="explain-col" style="margin-bottom: 10px;">
	<?php echo $memberinfo['fullname'].', '.$enums['member']['sex'][$memberinfo['sex']].', 身份证号 '.$memberinfo['ID_number'];?>
</div>
<div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
			<tr>
				<th width="5%" align="left">序号</th>
				<th width="15%" align="left">单据号</th>
				<th width="10%" align="left">申报日期</th>
				<th width="10%" align="left">航司代码</th>
				<th width="10%" align="left">自付一金额</th>
				<th width="10%" align="left">其他说明</th>
				<th width="10%" align="left">状态</th>
				<th width="15%">操作</th>
			</tr>
        </thead>
	    <tbody>
			<?php 
			if(is_array($lists)){
				foreach($lists as $info){
			?>
			<tr>
				<td><?php echo $info['id']?></td>
				<td><?php echo $info['ordernum']?></td>
				<td><?php echo date('Y-m-d', strtotime($info['inputtime']));?></td>
				<td><?php echo $info['number']?></td>
				<td><?php echo $info['amount']?></td>
				<td><?php echo $info['remark']?></td>
				<td>
					<input type="hidden" name="id" value="<?php echo $info['id'];?>">
					<select name="status" id="status">
						<?php foreach($reimbursement_status as $k => $v){ ?>
						<option value="<?php echo $k;?>" <?php if($info['status'] == $k) echo 'selected'; ?>><?php echo $v;?></option>
						<?php } ?>
					</select>
				</td>
				<td align="center">
					<a href="javascript:;" onclick="edit(<?php echo $info['id'];?>, <?php echo $info['ordernum'];?>)">修改</a> <span>|</span>
					<a href="javascript:;" onclick="del(<?php echo $info['id'];?>)">删除</a>
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

<script type="text/javascript">
	function edit(id, name) {
		window.top.art.dialog({id:'edit'}).close();
		window.top.art.dialog(
			{
				title:'<?php echo L('edit')?> '+name+' ',
				id:'edit',
				iframe:'?m=admin&c=reimbursement&a=editOneMember&id='+id,
				width:'700',
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

	function del(id){
		if(confirm('确定删除吗？')){
			window.location='?m=admin&c=reimbursement&a=del&pc_hash=<?php echo input('pc_hash');?>&id='+id;
		}
	}

	$(function(){
		$('select[name=status]').change(function(){
			var status = $(this).val();
			var id = $(this).parent('td').find('input[name=id]').val();
			
			$.ajax({
				url: '?m=admin&c=reimbursement&a=changeOneStatus&pc_hash=<?php echo input('pc_hash')?>&id='+id+'&status='+status,
				type: 'get',
				dataType: 'json',
				success: function(){
					
				}
			})

		})
	})
</script>
</body>
</html>