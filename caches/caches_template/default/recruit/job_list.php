<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><?php include template('content', 'header'); ?>

<div class="ch"></div>
<div class="container">
	<div class="joblist">
		<div class="tab"><a href="<?php if($type=='1') { ?>javascript:;<?php } else { ?>?m=recruit&a=search&type=1&recruit_keyword=<?php echo $keyword;?><?php } ?>" <?php if($type=='1') { ?>class="current"<?php } ?>>空乘类</a><span></span><a href="<?php if($type=='2') { ?>javascript:;<?php } else { ?>?m=recruit&a=search&type=2&recruit_keyword=<?php echo $keyword;?><?php } ?>" <?php if($type=='2') { ?>class="current"<?php } ?>>非空乘类</a></div>

		<ul>
			<?php $n=1;if(is_array($jobs)) foreach($jobs AS $r) { ?>
			<li>
				<div class="info">
					<p class="tit"><?php echo $r['job_name'];?></p>
					<p><label>工作地点</label><?php echo $r['location'];?></p>
					<p><label>公司名称</label><?php echo $r['enterprise_name'];?></p>
				</div>
				<div class="btn"><a href="?m=recruit&a=enroll&job_id=<?php echo $r['id'];?>">应聘职位</a></div>
			</li>
			<?php $n++;}unset($n); ?>
		</ul>
	</div>
	<div id="pages"><?php echo $pages;?></div>
</div>
<?php include template('content', 'footer'); ?>