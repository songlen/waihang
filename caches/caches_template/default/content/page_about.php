<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><?php include template('content', 'header'); ?>

<div class="categoryimage"><img src="<?php echo $image;?>" alt=""></div>

<div class="container">
	<div class="page_left">
		<div class="title">关于公司</div>
		<ul class="navlist">
			<?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=ef9b1d6ade0246d68e39644948c46b77&action=category&catid=1&num=25&siteid=%24siteid&order=listorder+desc%2C+id+desc\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'category')) {$data = $content_tag->category(array('catid'=>'1','siteid'=>$siteid,'order'=>'listorder desc, id desc','limit'=>'25',));}?>
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
		<div class="page_content">
			<?php echo $content;?>
		</div>
	</div>
	<div class="clear"></div>
</div>

<script type="text/javascript">
	if(GetQueryString('catid')=='1'){
		var url = window.location.href.replace('catid=1', 'catid=2');
		window.location.href=url
	}
	function GetQueryString(name)
	{
	     var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
	     var r = window.location.search.substr(1).match(reg);
	     if(r!=null)return  unescape(r[2]); return null;
	}
</script>

<?php include template('content', 'footer'); ?>