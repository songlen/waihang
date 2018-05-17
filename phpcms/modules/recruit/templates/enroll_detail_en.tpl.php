<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>
<style type="text/css">
	.zh_en {padding: 20px 0;}
	.zh_en a {border: 1px solid #eee; padding: 5px; background: #eee;}
</style>
<div class="pad-lr-10">
	<div class="zh_en">
		<a href="?m=recruit&c=enroll&a=detail&id=<?php echo $id;?>">中文简历</a>
		<a target="_blank" href="?m=recruit&c=enroll&a=detail&language=en&id=<?php echo $id;?>&resume=1">预览简历</a>
	</div>
<div class="table-list">
<div class="common-form">
	<fieldset>
		<legend>Basic Information</legend>
		<table width="100%" class="table_form">
			<tr>
				<td width="120">Fullname</td> 
				<td><?php echo $basicinfo['fullname']?></td>
			</tr>
			<tr>
				<td>Gender</td>
				<td><?php echo $enums['member']['sex'][$basicinfo['sex']]?></td>
			</tr>
			<tr>
				<td>Head Image</td> 
				<td><img src="<?php echo $memberinfo['headimg']?>" onerror="this.src='<?php echo IMG_PATH?>member/nophoto.gif'" height=120 width=90></td>
			</tr>
			<tr>
				<td>ID Numbe</td> 
				<td><?php echo $basicinfo['ID_number']?></td>
			</tr>
			<tr>
				<td>Nation</td>
				<td><?php echo $enums['member']['nation'][$basicinfo['nation']];?></td>
			</tr>
			<tr>
				<td>Birthday</td>
				<td><?php echo $basicinfo['birthday'];?></td>
			</tr>
			<tr>
				<td>Age</td>
				<td><?php echo $basicinfo['age'];?></td>
			</tr>
			<tr>
				<td>Profession</td>
				<td><?php echo $basicinfo['profession'];?></td>
			</tr>
			<tr>
				<td>Highest Education</td>
				<td><?php echo $enums['member']['diploma'][$basicinfo['diploma']];?></td>
			</tr>
			<tr>
				<td>Graduation University</td>
				<td><?php echo $basicinfo['graduation_university'];?></td>
			</tr>
			<tr>
				<td>Marital Status</td>
				<td><?php echo $enums['member']['marital_status'][$basicinfo['marital_status']];?></td>
			</tr>
			<tr>
				<td>Height</td>
				<td><?php echo $basicinfo['height'];?></td>
			</tr>
			<tr>
				<td>Weight</td>
				<td><?php echo $basicinfo['weight'];?></td>
			</tr>
			<tr>
				<td>Cell Phone</td>
				<td><?php echo $basicinfo['mobile_phone'];?></td>
			</tr>
			<tr>
				<td>Home Tel</td>
				<td><?php echo $basicinfo['telphone'];?></td>
			</tr>
			<tr>
				<td>Passport</td>
				<td><?php echo $basicinfo['passport_number'];?></td>
			</tr>
			<tr>
				<td>Date of Expiry</td>
				<td><?php echo $basicinfo['passport_deadline'];?></td>
			</tr>
			<tr>
				<td>Residential Address</td>
				<td><?php echo $basicinfo['living_city'];?></td>
			</tr>
			<tr>
				<td>HuKou</td>
				<td><?php echo $basicinfo['registered_residence'];?></td>
			</tr>
			<tr>
				<td>Archive of Personal Profile</td>
				<td><?php echo $basicinfo['archiving_organization'];?></td>
			</tr>
			<tr>
				<td>Postal Address</td>
				<td><?php echo $basicinfo['address'];?></td>
			</tr>
			<tr>
				<td>Zip Code</td>
				<td><?php echo $basicinfo['zip_code'];?></td>
			</tr>
			<tr>
				<td>Swimming Ability</td>
				<td><?php echo $basicinfo['swimming_ability'];?></td>
			</tr>
			<tr>
				<td>Corrected Eyesight</td>
				<td><?php echo $basicinfo['correct_vision'];?></td>
			</tr>
			<tr>
				<td>Scar or Tattoo on body</td>
				<td><?php echo $basicinfo['scar_tattoo'];?></td>
			</tr>
			<tr>
				<td>When Can Work</td>
				<td><?php echo $basicinfo['start_work_date'];?></td>
			</tr>
			
		</table>
	</fieldset>
	<div class="bk15"></div>
	<fieldset>
		<legend>Educational Background</legend>
		<table width="100%" class="">
			<thead>
				<tr>
					<th align="center">Name of School</th>	
					<th align="center">Major</th>	
					<th align="center">From Time</th>	
					<th align="center">To Time</th>	
					<th align="center">Degree</th>	
					<th align="center">	Certificate Obtained</th>
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
				</tr>
				<?php }?>
			</tbody>
		</table>
	</fieldset>

	<div class="bk15"></div>
	<fieldset>
		<legend>Working Experience</legend>
		<table width="100%" class="">
			<thead>
				<tr>
					<th align="center">Name of Company</th>	
					<th align="center">Industry</th>	
					<th align="center">From Time</th>	
					<th align="center">To Time</th>
					<th align="center">Salary</th>
					<th align="center">Reference Person and Contact Information</th>
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
		<legend>Language Skill</legend>
		<table width="100%" class="">
			<thead>
				<tr>
					<th align="center">Language</th>	
					<th align="center">Certificate</th>	
					<th align="center">Level</th>	
					<th align="center">Date of Issue</th>
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