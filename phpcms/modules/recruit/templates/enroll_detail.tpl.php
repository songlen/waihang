<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>

<div class="pad-lr-10">
<div class="table-list">
<div class="common-form">
	<fieldset>
		<legend>基本信息</legend>
		<table width="100%" class="table_form">
			<tr>
				<td width="120">姓名</td> 
				<td><?php echo $basicinfo['fullname']?></td>
			</tr>
			<tr>
				<td>性别</td>
				<td><?php echo $enums['member']['sex'][$basicinfo['sex']]?></td>
			</tr>
			<tr>
				<td>头像</td> 
				<td><img src="<?php echo $memberinfo['headimg']?>" onerror="this.src='<?php echo IMG_PATH?>member/nophoto.gif'" height=120 width=90></td>
			</tr>
			<tr>
				<td>身份证号</td> 
				<td><?php echo $basicinfo['ID_number']?></td>
			</tr>
			<tr>
				<td>民族</td>
				<td><?php echo $enums['member']['nation'][$basicinfo['nation']];?></td>
			</tr>
			<tr>
				<td>出生日期</td>
				<td><?php echo $basicinfo['birthday'];?></td>
			</tr>
			<tr>
				<td>政治面貌</td>
				<td><?php echo $enums['member']['political_outlook'][$basicinfo['political_outlook']];?></td>
			</tr>
			<tr>
				<td>婚姻状况</td>
				<td><?php echo $enums['member']['marital_status'][$basicinfo['marital_status']];?></td>
			</tr>
			<tr>
				<td>身高</td>
				<td><?php echo $basicinfo['height'];?></td>
			</tr>
			<tr>
				<td>体重</td>
				<td><?php echo $basicinfo['weight'];?></td>
			</tr>
			<tr>
				<td>手机号</td>
				<td><?php echo $basicinfo['mobile_phone'];?></td>
			</tr>
			<tr>
				<td>家庭电话</td>
				<td><?php echo $basicinfo['telphone'];?></td>
			</tr>
			<tr>
				<td>现居住城市</td>
				<td><?php echo $basicinfo['living_city'];?></td>
			</tr>
			<tr>
				<td>户口所在地</td>
				<td><?php echo $basicinfo['registered_residence'];?></td>
			</tr>
			<tr>
				<td>存档机构</td>
				<td><?php echo $basicinfo['archiving_organization'];?></td>
			</tr>
			<tr>
				<td>通讯地址</td>
				<td><?php echo $basicinfo['address'];?></td>
			</tr>
			<tr>
				<td>通讯编码</td>
				<td><?php echo $basicinfo['zip_code'];?></td>
			</tr>
			<tr>
				<td>游泳能力</td>
				<td><?php echo $basicinfo['swimming_ability'];?></td>
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
				</tr>
			</thead>
			<tbody>
				<?php foreach($worklist as $work){ ?>
				<tr>
					<td align="center"><?php echo $work['company_name'] ?></td>
					<td align="center"><?php echo $work['position'] ?></td>
					<td align="center"><?php echo $work['start_time'] ?></td>
					<td align="center"><?php echo $work['end_time'] ?></td>
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
</div>
<div class="bk15"></div>
<input type="button" class="dialog" name="dosubmit" id="dosubmit" onclick="window.top.art.dialog({id:'modelinfo'}).close();"/>
</div>
</div>
</body>
</html>