<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><?php include template('content', 'header'); ?>

<div class="categoryimage"><img src="<?php echo $image;?>" alt=""></div>

<div class="container">
	<div class="current_crumb">
		<div class="crumb"><?php echo catpos($catid);?></div>
		<div class="category_title"><?php echo $catname;?></div>
	</div>
	<div class="page_list">
		<ul class="dangjian">
			<?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=6fd9260bdf41e5d4325946e7890633dc&action=lists&catid=%24catid&num=10&order=listorder+desc%2C+id+DESC&page=%24page\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$pagesize = 10;$page = intval($page) ? intval($page) : 1;if($page<=0){$page=1;}$offset = ($page - 1) * $pagesize;$content_total = $content_tag->count(array('catid'=>$catid,'order'=>'listorder desc, id DESC','limit'=>$offset.",".$pagesize,'action'=>'lists',));$pages = pages($content_total, $page, $pagesize, $urlrule);$data = $content_tag->lists(array('catid'=>$catid,'order'=>'listorder desc, id DESC','limit'=>$offset.",".$pagesize,'action'=>'lists',));}?>
			<?php $n=1;if(is_array($data)) foreach($data AS $r) { ?>
			<li>
				<div class="tit"><a href="<?php echo $r['url'];?>" target="_blank"><?php echo $r['title'];?></a></div>
				<div class="pic"><a href="<?php echo $r['url'];?>" target="_blank"><img src="<?php echo thumb($r[thumb], 300, 190);?>" width="300" height="190" alt=""></a><div class="date"><span class="day"><?php echo date('d', $r[inputtime]);?></span><span class="year"><?php echo date('Y.m', $r[inputtime]);?></span></div></div>
				<div class="des"><?php echo strcut($r[description], 200);?></div>
			</li>
			<?php $n++;}unset($n); ?>
			<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
		</ul>
	</div>
	<div id="pages"><?php echo $pages;?></div>
</div>

<?php include template('content', 'footer'); ?>