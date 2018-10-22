<?php
defined('IN_ADMIN') or exit('No permission resources.');
$show_dialog = 1;
$layui = true;
include $this->admin_tpl('header', 'admin');
?>
<style type="text/css">
	.pictd {position: relative;}
	.bodyimg {position: absolute; display: none; top:-100px;  right: -200px; z-index: 2}
</style>
<script type="text/javascript">
	$(function(){
		$('.headimg').hover(function(){
			$(this).next().show();
		}, function(){
			$(this).next().hide();
		})
	})
</script>
<div class="pad-10">

	<div id="searchid">
		<form name="searchform" action="" method="get" >
			<input type="hidden" value="recruit" name="m">
			<input type="hidden" value="enroll" name="c">
			<input type="hidden" value="init" name="a">
			<input type="hidden" value="1" name="search">
			<input type="hidden" value="<?php echo $_SESSION['pc_hash'];?>" name="pc_hash">

			<input type="hidden" name="job_id" value="<?php echo $job_id ?>">
			<table width="100%" cellspacing="0" class="search-form">
			    <tbody>
					<tr>
						<td>
							<div class="explain-col">
								年龄
								<input type="text" size="2" name="age_l" value="<?php echo $age_l;?>">-
								<input type="text" size="2" name="age_r" value="<?php echo $age_r;?>">

								&nbsp;
								身高
								<input type="text" size="2" name="height_l" value="<?php echo $height_l;?>">-
								<input type="text" size="2" name="height_r" value="<?php echo $height_r;?>">
								&nbsp;
								毕业日期
								<?php echo form::date('graduation_date_l', $graduation_date_l);?>-
								<?php echo form::date('graduation_date_r', $graduation_date_r);?>
								&nbsp;
								空乘经验
								<input size="2" type="text" name="aviation_experience_l" value="<?php echo $aviation_experience_l?>">-
								<input size="2" type="text" name="aviation_experience_r" value="<?php echo $aviation_experience_r?>">

								&nbsp;
								航空经验
								<input size="2" type="text" name="flight_experience_l" value="<?php echo $flight_experience_l?>">-
								<input size="2" type="text" name="flight_experience_r" value="<?php echo $flight_experience_r?>">

								<div style="margin-top: 10px;">
									<select name="diploma_l" id="">
										<option value="">>=学历</option>
										<?php foreach($enums['diploma'] as $k => $v) { ?>
										<option <?php if($diploma_l == $k) echo 'selected';?> value="<?php echo $k;?>"><?php echo $v;?></option>
										<?php } ?>
									</select>


									&nbsp;
									<select name="sex" id="">
										<option value="">性别</option>
										<?php foreach($enums['sex'] as $k => $v) { ?>
										<option <?php if($sex == $k && $sex != '') echo 'selected';?> value="<?php echo $k;?>"><?php echo $v;?></option>
										<?php } ?>
									</select>


									&nbsp;
									<select name="status" id="">
										<option value="">审核状态</option>
										<?php foreach($recruit_enroll_status as $k => $v) { ?>
										<option <?php if($status == $k) echo 'selected';?> value="<?php echo $k;?>"><?php echo $v;?></option>
										<?php } ?>
									</select>

									&nbsp;
									<select name="marital_status" id="">
										<option value="">婚姻状况</option>
										<?php foreach($enums['marital_status'] as $k => $v) { ?>
										<option <?php if($marital_status == $k) echo 'selected';?> value="<?php echo $k;?>"><?php echo $v;?></option>
										<?php } ?>
									</select>

									&nbsp;
									<select name="searchType" id="">
										<option <?php if($searchType == 'enroll_number') echo 'selected'; ?> value="enroll_number">报名号</option>
										<option <?php if($searchType == 'fullname') echo 'selected'; ?> value="fullname">姓名</option>
										<option <?php if($searchType == 'email') echo 'selected'; ?> value="email">邮箱</option>
										<option <?php if($searchType == 'passport_number') echo 'selected'; ?> value="passport_number">护照号</option>
										<option <?php if($searchType == 'registered_residence') echo 'selected'; ?> value="registered_residence">户口所在地</option>
										<option <?php if($searchType == 'living_city') echo 'selected'; ?> value="living_city">现居住地</option>
										<option <?php if($searchType == 'profession') echo 'selected'; ?> value="profession">最高学历专业</option>
									</select>
									<input name="keyword" type="text" value="<?php if(isset($keyword)) echo $keyword;?>" class="input-text" />
									身份证号
									<input type="text" name="ID_number" value="<?php echo $ID_number;?>" placeholder="">
									<input type="submit" name="search" class="button" value="<?php echo L('search');?>" />
									
									
								</div>
								<div style="margin-top: 10px;">
									<input type="submit" name="export" class="button" value="导出" />
									<input type="submit" name="export_en" class="button" value="导出英文" />
									<?php if($job_id) { ?>
									<input type="submit" name="pass" class="button" value="一键通过" />
									<input type="submit" name="refuse" class="button" value="一键拒绝" />
									<?php } ?>
								</div>
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
				<th width="80" align="center">报名号等</th>
				<th width="80" align="center">姓名等</th>
				<th width="5%" align="center">批注</th>
				<th width="80" align="center">头像</th>
				<th width="5%" align="center">身高(cm)</th>
				<th width="5%" align="center">体重(kg)</th>
				<th width="80" align="center">最高学历</th>
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
			<td align="center" width="10%">
				<?php echo $info['enroll_number']?> <br>
				<?php echo date('Y-m-d', strtotime($info['inputtime']));?>
			</td>
			<td align="center" width="10%">
				<?php echo $info['fullname']?> <br>
				<?php echo $enums['sex'][$info['sex']]?> <?php echo get_age($info['ID_number'])?>岁<br>
				<?php echo $info['birthday']?> <br>
				<?php echo $info['ID_number']?> <br>
			</td>
			<td align="center" width="10%"><textarea class="annotation" cols="10" rows="3"><?php echo $info['annotation'];?></textarea></td>
			<td align="center" width="10%" class="pictd"><img class="headimg" src="<?php echo $info['headimg'];?>" onerror="this.src='statics/images/nophoto.gif'" width="60" height="80" alt="">
				<img class="bodyimg" src="<?php echo $info['bodyimg'];?>" onerror="this.src='statics/images/nophoto.gif'" width="200" height="300" alt="">
			</td>
			<td align="center" width="5%"><?php echo $info['height'];?></td>
			<td align="center" width="5%"><?php echo $info['weight'];?></td>
			<td align="center" width="10%">
				<?php echo $info['graduation_university']?> <br>
				<?php echo $info['profession']?> <br>
				<?php echo $enums['diploma'][$info['diploma']];?> <br>
				<?php echo $info['graduation_date']?> <br>
			</td>
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
				<?php if($job_id){ ?>
				|
				<a href="###" onclick="statistics(<?php echo $job_id?>)">统计</a>
				<?php } ?>
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
		<!-- <input type="submit" class="button" name="dosubmit" onClick="document.myform.action='?m=recruit&c=enroll&a=delete'" value="<?php echo L('delete')?>"/> -->
		<input type="button" class="button" name="dosubmit" onclick="check()" value="批量审核"/>
	</div>
	<div id="pages"><?php echo $pages?></div>
	</form>
</div>
<script type="text/javascript">

	function detail(id){
		window.top.art.dialog({
				id:'add',
				iframe:'?m=recruit&c=enroll&a=detail&id='+id,
				title:'详情',
				width:'1000',
				height:'550'
			}, function(){
				window.top.art.dialog({id:'statistics'}).close()
			}, function(){
				window.top.art.dialog({id:'detail'}).close()
			}
		);
	}
	// 统计
	function statistics(id){
		window.top.art.dialog({
				id:'add',
				iframe:'?m=recruit&c=enroll&a=statistics&id='+id,
				title:'详情',
				width:'1000',
				height:'550'
			}, function(){
				window.top.art.dialog({id:'statistics'}).close()
			}, function(){
				window.top.art.dialog({id:'statistics'}).close()
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

	// 批量审批
	function check() {
		var ids='';
		$("input[name='id[]']:checked").each(function(i, n){
			ids += $(n).val() + ',';
		});
		if(ids=='') {
			window.top.art.dialog({content:'请至少选择一项',lock:true,width:'200',height:'50',time:1.5},function(){});
			return false;
		}
		window.top.art.dialog({id:'check'}).close();
		window.top.art.dialog({
				title:'批量审批',
				id:'check',
				iframe:'?m=recruit&c=enroll&a=check&ids='+ids,
				width:'300',
				height:'200'
			}, function(){
				var d = window.top.art.dialog({id:'check'}).data.iframe;
				d.$('#dosubmit').click();
				return false;
			}, function(){
				window.top.art.dialog({id:'check'}).close()
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
				url: '?m=recruit&c=enroll&a=ajax_change_status&pc_hash=<?php echo input("pc_hash")?>&id='+id+'&status='+status,
				type: 'get',
				dateType: 'json',
				success: function(data){

				}
			})
		})

		// 批注
		$('.annotation').blur(function(){
			var id = $(this).parents('tr').find('input[name="id[]"]').val();
			var annotation = $(this).val();
			
			$.ajax({
				url: '?m=recruit&c=enroll&a=ajax_update_annotation&pc_hash=<?php echo input("pc_hash")?>&id='+id+'&annotation='+annotation,
				type: 'get',
				success: function(){
					layer.msg('批注成功');
				}
			})
		})
	})
</script>

</body>
</html>
