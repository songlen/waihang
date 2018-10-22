<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>

<div class="pad-lr-10">
<div class="table-list">
<div class="common-form">
	<fieldset>
		<legend>基本信息</legend>
		<table width="100%" class="table_form">

			<tr align="left">
				<td width="120">账号</td>
				<td><?php 
					if($memberinfo['mobile']){
						echo $memberinfo['mobile'];
					} else {
						echo $memberinfo['email'];
					}
				?></td>
			</tr>
			<tr>
				<td width="120">性别</td>
				<td><?php echo $enums['member']['sex'][$basicinfo['sex']]?></td>
			</tr>
			<tr>
				<td width="120">头像</td> 
				<td><img src="<?php echo $memberinfo['headimg']?>" onerror="this.src='<?php echo IMG_PATH?>member/nophoto.gif'" height=120 width=90></td>
			</tr>
			<tr>
				<td width="120">身份证号</td> 
				<td><?php echo $basicinfo['ID_number']?></td>
			</tr>
			<tr>
				<td width="120">邮箱</td> 
				<td><?php echo $basicinfo['email']?></td>
			</tr>
			<tr>
				<td width="120">民族</td>
				<td><?php echo $enums['member']['nation'][$basicinfo['nation']];?></td>
			</tr>
			<tr>
				<td width="120">出生日期</td>
				<td><?php echo $basicinfo['birthday'];?></td>
			</tr>
			<tr>
				<td width="120">年龄</td>
				<td><?php echo $basicinfo['age'];?></td>
			</tr>
			<tr>
				<td width="120">所学专业</td>
				<td><?php echo $basicinfo['profession'];?></td>
			</tr>
			<tr>
				<td width="120">最高学历</td>
				<td><?php echo $enums['member']['diploma'][$basicinfo['diploma']];?></td>
			</tr>
			<tr>
				<td width="120">毕业院校</td>
				<td><?php echo $basicinfo['graduation_university'];?></td>
			</tr>
			<tr>
				<td width="120">毕业日期</td>
				<td><?php echo $basicinfo['graduation_date'];?></td>
			</tr>
			<tr>
				<td width="120">工作年限</td>
				<td><?php echo $basicinfo['work_experience'];?> 年</td>
			</tr>
			<tr>
				<td width="120">政治面貌</td>
				<td><?php echo $enums['member']['political_outlook'][$basicinfo['political_outlook']];?></td>
			</tr>
			<tr>
				<td width="120">婚姻状况</td>
				<td><?php echo $enums['member']['marital_status'][$basicinfo['marital_status']];?></td>
			</tr>
			<tr>
				<td width="120">身高</td>
				<td><?php echo $basicinfo['height'];?> cm</td>
			</tr>
			<tr>
				<td width="120">体重</td>
				<td><?php echo $basicinfo['weight'];?> kg</td>
			</tr>
			<tr>
				<td width="120">手机号</td>
				<td><?php echo $basicinfo['mobile_phone'];?></td>
			</tr>
			<tr>
				<td width="120">电话</td>
				<td><?php echo $basicinfo['telphone'];?></td>
			</tr>
			<tr>
				<td width="120">护照</td>
				<td><?php echo $basicinfo['passport_number'];?></td>
			</tr>
			<tr>
				<td width="120">护照有效期</td>
				<td><?php echo $basicinfo['passport_deadline'];?></td>
			</tr>
			<tr>
				<td width="120">现居住地址</td>
				<td><?php echo $basicinfo['living_address'];?></td>
			</tr>
			<tr>
				<td width="120">户口所在地</td>
				<td><?php echo get_linkage_name($basicinfo['hukou_province_id'].' '.get_linkage_name($basicinfo['hukou_city_id']));?></td>
			</tr>
			<tr>
				<td width="120">存档机构</td>
				<td><?php echo $basicinfo['archiving_organization'];?></td>
			</tr>
			<tr>
				<td width="120">通讯地址</td>
				<td><?php echo $basicinfo['address'];?></td>
			</tr>
			<tr>
				<td width="120">通讯编码</td>
				<td><?php echo $basicinfo['zip_code'];?></td>
			</tr>
			<tr>
				<td width="120">游泳能力</td>
				<td><?php echo $enums['member']['swimming_ability'][$basicinfo['swimming_ability']];?></td>
			</tr>
			<tr>
				<td width="120">矫正视力</td>
				<td><?php echo $basicinfo['correct_vision'];?></td>
			</tr>
			<tr>
				<td width="120">身上是否有疤痕及纹身</td>
				<td><?php echo $basicinfo['scar_tattoo'];?></td>
			</tr>
			<tr>
				<td width="120">何时可开始工作</td>
				<td><?php echo $basicinfo['start_work_date'];?></td>
			</tr>
			
		</table>
	</fieldset>
	<div class="bk15"></div>
	<fieldset>
		<legend>教育经历</legend>
		<table width="100%" class="">
			<thead>
				<tr>
					<th align="center">学校名称</th>	
					<th align="center">专业</th>	
					<th align="center">入学时间</th>	
					<th align="center">毕业时间</th>	
					<th align="center">学历</th>	
					<th align="center">已取得毕业证</th>
					<th align="center">留学</th>	
					<th align="center">民航院校</th>	
					<th align="center">最高学历</th>	
				</tr>
			</thead>
			<tbody>
				<?php foreach($educationlist as $education){ ?>
				<tr>
					<td align="center"><?php echo $education['school_name'] ?></td>
					<td align="center"><?php echo $education['major'] ?></td>
					<td align="center"><?php echo $education['start_time'] ?></td>
					<td align="center"><?php echo $education['end_time'] ?></td>
					<td align="center"><?php echo $enums['member']['diploma'][$education['diploma']] ?></td>
					<td align="center"><?php echo $education['has_diploma'] ? '是' : '否'; ?></td>
					<td align="center"><?php echo $education['study_aboard'] ? '是' : '否'; ?></td>
					<td align="center"><?php echo $education['civil_viation'] ? '是' : '否'; ?></td>
					<td align="center"><?php echo $education['highest_degree'] ? '是' : '否'; ?></td>
				</tr>
				<?php }?>
			</tbody>
		</table>
	</fieldset>

	<div class="bk15"></div>
	<fieldset>
		<legend>工作经历</legend>
		<table width="100%" class="">
			<thead>
				<tr>
					<th align="center">单位名称</th>	
					<th align="center">职位</th>	
					<th align="center">入职时间</th>	
					<th align="center">离职时间</th>
					<th align="center">薪水</th>
					<th align="center">证明人及联系方式</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($worklist as $work){ ?>
				<tr>
					<td align="center"><?php echo $work['company_name'] ?></td>
					<td align="center"><?php echo $work['position'] ?></td>
					<td align="center"><?php echo $work['start_time'] ?></td>
					<td align="center"><?php echo $work['end_time'] ?></td>
					<td align="center"><?php echo $work['salary'] ?></td>
					<td align="center"><?php echo $work['witness'] ?></td>
				</tr>
				<?php }?>
			</tbody>
		</table>
	</fieldset>

	<div class="bk15"></div>
	<fieldset>
		<legend>外语经历</legend>
		<table width="100%" class="">
			<thead>
				<tr>
					<th align="center">语言</th>	
					<th align="center">证书</th>	
					<th align="center">等级</th>	
					<th align="center">获得时间</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($languagelist as $language){ ?>
				<tr>
					<td align="center"><?php echo $language['name'] ?></td>
					<td align="center"><?php echo $language['certificate'] ?></td>
					<td align="center"><?php echo $language['level'] ?></td>
					<td align="center"><?php echo $language['gettime'] ?></td>
				</tr>
				<?php }?>
			</tbody>
		</table>
	</fieldset>
<input type="button" class="dialog" name="dosubmit" id="dosubmit" onclick="window.top.art.dialog({id:'modelinfo'}).close();"/>
</div>
</div>
</body>
</html>