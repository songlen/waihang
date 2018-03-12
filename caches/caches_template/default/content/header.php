<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<!-- <meta name="viewport" content="width=1200" /> -->
	<title><?php if(isset($SEO['title']) && !empty($SEO['title'])) { ?><?php echo $SEO['title'];?><?php } ?><?php echo $SEO['site_title'];?></title>
	<meta name="keywords" content="<?php echo $SEO['keyword'];?>">
	<meta name="description" content="<?php echo $SEO['description'];?>"> 
	<title>外航</title>
	<link rel="stylesheet" href="<?php echo APP_PATH;?>statics/default/css/style.css?v=<?php echo create_randomstr(6);?>">
	<link rel="stylesheet" href="<?php echo APP_PATH;?>statics/default/css/flexslider.css">
	<link rel="stylesheet" href="<?php echo JS_PATH;?>ueditor/themes/table_default.css">
	<script type="text/javascript" src="<?php echo APP_PATH;?>statics/default/js/jquery-1.11.0.min.js"></script>

</head>
<body>
<div id="top">
	<div class="container">
		<div class="menu">
			<?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=c8248b6e14f55ae7ab7445fed168915d&action=category&catid=0&num=7&siteid=%24siteid&order=listorder+ASC\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'category')) {$data = $content_tag->category(array('catid'=>'0','siteid'=>$siteid,'order'=>'listorder ASC','limit'=>'7',));}?>
			<ul>
				<li><a href="<?php echo siteurl($siteid);?>">首页</a></li>
				<?php $n=1;if(is_array($data)) foreach($data AS $r) { ?>
				<li>
					<a href="<?php echo $r['url'];?>"><?php echo $r['catname'];?></a>
					<?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=806778b4a7cc16bc82ff203a0c4e5c24&action=category&catid=%24r%5Bcatid%5D&return=subcats\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'category')) {$subcats = $content_tag->category(array('catid'=>$r[catid],'limit'=>'20',));}?>
					<?php if(!empty($subcats)) { ?>
					<dl>
						<?php $n=1;if(is_array($subcats)) foreach($subcats AS $sub) { ?>
						<dt><a href="<?php echo $sub['url'];?>"><?php echo $sub['catname'];?></a></dt>
						<?php $n++;}unset($n); ?>
					</dl>
					<?php } ?>
					<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
				</li>
				<?php $n++;}unset($n); ?>
			</ul>
			<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
		</div>
		<div class="menuright">
			<div class="language">English <div class="zh"><a href="">中文</a></div></div>
			<div class="shu">|</div>
			<div class="person">
				<img src="<?php echo APP_PATH;?>statics/default/images/index_03.jpg" alt="">
				<ul class="loginreg">
					<li><a href="">登录</a></li>
					<li style="border-top:1px solid #e5e5e5;"><a href="">注册</a></li>
				</ul>
			</div>
		</div>
		<div class="clear"></div>
	</div>

</div>

<div class="container logotop">
	<div class="logo"><a href=""><img src="<?php echo APP_PATH;?>statics/default/images/logo.jpg" width="295" alt=""></a></div>
	<div class="searchbox">
		<div class="search"><input type="text" name="keyword" placeholder="搜索关键词"><span class="sbutton"></span></div>
		<div class="history">历史搜索：<a href="">员工培训</a></div>
	</div>
</div>
