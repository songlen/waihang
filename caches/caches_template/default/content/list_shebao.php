<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><?php include template('content', 'header'); ?>

<div class="categoryimage"><img src="<?php echo $image;?>" alt=""></div>

<div class="container">
	<div class="page_left">
		<div class="title"><?php echo $CATEGORYS[$parentid]['catname'];?></div>
		<ul class="navlist">
			<?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=a7f6b5ed2256165e3f10a57ccc53c4b4&action=category&catid=%24parentid&num=25&siteid=%24siteid&order=listorder+desc%2C+id+desc\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'category')) {$data = $content_tag->category(array('catid'=>$parentid,'siteid'=>$siteid,'order'=>'listorder desc, id desc','limit'=>'25',));}?>
			<?php $n=1; if(is_array($data)) foreach($data AS $n => $r) { ?>
			<li <?php if($r[catid] == $catid) { ?> class="current"<?php } ?>><a href="<?php echo $r['url'];?>"><?php echo $r['catname'];?></a></li>
			<?php $n++;}unset($n); ?>
			<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
		</ul>
	</div>
	<div class="page_right">
		<div class="current_crumb">
			<div class="crumb"><?php echo catpos($catid);?></div>
			<div class="category_title"><?php echo $catname;?></div>
		</div>
		<div class="page_list">
			<ul class="shebao">
				<?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=6fd9260bdf41e5d4325946e7890633dc&action=lists&catid=%24catid&num=10&order=listorder+desc%2C+id+DESC&page=%24page\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$pagesize = 10;$page = intval($page) ? intval($page) : 1;if($page<=0){$page=1;}$offset = ($page - 1) * $pagesize;$content_total = $content_tag->count(array('catid'=>$catid,'order'=>'listorder desc, id DESC','limit'=>$offset.",".$pagesize,'action'=>'lists',));$pages = pages($content_total, $page, $pagesize, $urlrule);$data = $content_tag->lists(array('catid'=>$catid,'order'=>'listorder desc, id DESC','limit'=>$offset.",".$pagesize,'action'=>'lists',));}?>
				<?php $n=1;if(is_array($data)) foreach($data AS $r) { ?>
				<li>
					<div class="pic"><a href="" target="_blank"><img src="<?php echo thumb($r[thumb], 235, 160);?>" alt=""></a></div>
					<div class="rinfo">
						<div class="tit"><a href="<?php echo $r['url'];?>" target="_blank" <?php echo title_style($r[style]);?>><?php echo $r['title'];?></a></div>
						<div class="des"><?php echo strcut($r[description], 200);?></div>
					</div>
				</li>
				<?php $n++;}unset($n); ?>
				<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
			</ul>
			<div id="pages"><?php echo $pages;?></div>
		</div>
	</div>
	<div class="clear"></div>
</div>

<?php include template('content', 'footer'); ?>