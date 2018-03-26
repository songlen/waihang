<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><?php include template('content', 'header'); ?>
	<style type="text/css">
		.flex-control-nav {bottom: 30px;}
		.flex-control-nav li{display:inline-block;width:13px;height:13px;margin:0 5px;*display:inline;zoom:1;}
		.flex-control-nav a{display:inline-block;width:13px;height:13px;line-height:40px;overflow:hidden;background:url(statics/default/images/dot.png) right 0 no-repeat;cursor:pointer;}

	</style>
<div class="search-recruit-bg">
	<div class="container">
		<div class="recruit_form">
			<form class="jobSearchForm" action="" method="get">
				<input type="hidden" name="m" value="recruit">
				<input type="hidden" name="a" value="search">
				<input type="text" name="recruit_keyword" placeholder="搜索职位">
				<button class="button" type="button">搜索</button>
			</form>
		</div>
		<div class="hot_recruit">热门搜索：<a href="">外航是多少空乘</a><a href="">外航空dsd说的乘</a><a href="">外航空乘</a></div>
	</div>
</div>
<div class="container">
	<div class="recruit_top_title">
		<?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=edd44cc8bd7a4208e1a031f4bdaa948b&action=lists&catid=8&num=4&order=listorder+desc%2C+id+desc\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$data = $content_tag->lists(array('catid'=>'8','order'=>'listorder desc, id desc','limit'=>'4',));}?>
		<?php $n=1;if(is_array($data)) foreach($data AS $r) { ?>
		<?php if($n != 1) { ?><span>|</span><?php } ?><a href="<?php echo $r['url'];?>" target="_blank"><?php echo $r['title'];?></a>
		<?php $n++;}unset($n); ?>
		<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
	</div>
	<div class="jq22-container min-width-1300">
		<div class="flexslider">
			<ul class="slides">
				<?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"get\" data=\"op=get&tag_md5=b16f01063d67a3b4d133d2d2ebbaaf8e&sql=SELECT+setting+FROM+phpcms_poster+WHERE+spaceid+%3D+13+AND+disabled%3D0+ORDER+BY+listorder+ASC\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}pc_base::load_sys_class("get_model", "model", 0);$get_db = new get_model();$r = $get_db->sql_query("SELECT setting FROM phpcms_poster WHERE spaceid = 13 AND disabled=0 ORDER BY listorder ASC LIMIT 20");while(($s = $get_db->fetch_next()) != false) {$a[] = $s;}$data = $a;unset($a);?>
					<?php $n=1;if(is_array($data)) foreach($data AS $r) { ?>
					<?php 
						$r = json_decode($r['setting'], true);
						$r = $r[1];
					?>
					<li><a href="<?php if($r[linkurl] != '') { ?><?php echo $r['linkurl'];?><?php } else { ?>javascript:;<?php } ?>" target="_blank"><img src="<?php echo $r['imageurl'];?>" alt="<?php echo $r['alt'];?>" title="<?php echo $r['alt'];?>"></a></li>
					<?php $n++;}unset($n); ?>
				<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
			</ul>
		</div>
	</div>
	
	<div class="advs" id="advs">
		<!-- 一类广告 -->
		<?php $n=1;if(is_array($recruits1)) foreach($recruits1 AS $r) { ?>
		<a href="<?php echo $r['url'];?>" target="_blank"><img src="<?php echo $r['image'];?>" alt="<?php echo $r['title'];?>" width="540" height="260" title="<?php echo $r['title'];?>"></a>
		<?php $n++;}unset($n); ?>
		<!-- 二类广告 -->
		<?php $n=1;if(is_array($recruits2)) foreach($recruits2 AS $r) { ?>
		<a href="<?php echo $r['url'];?>" target="_blank"><img src="<?php echo $r['image'];?>" alt="<?php echo $r['title'];?>" width="260" height="260" title="<?php echo $r['title'];?>"></a>
		<?php $n++;}unset($n); ?>

	</div>

</div>

<link rel="stylesheet" type="text/css" href="statics/plugin/layui/css/layui.css">
<script type="text/javascript" src="statics/plugin/layui/layui.js"></script>
<script type="text/javascript">
	layui.use('flow', function(){
		var $ = layui.jquery; //不用额外加载jQuery，flow模块本身是有依赖jQuery的，直接用即可。
		var flow = layui.flow;
		flow.load({
			elem: '#advs', //指定列表容器
			isAuto: false,
			end: ' ',
			done: function(page, next){ //到达临界点（默认滚动触发），触发下一页
				var lis = [];
				//以jQuery的Ajax请求为例，请求下一页数据（注意：page是从2开始返回）
				$.get('index.php?m=recruit&a=loadMore<?php echo $urlsiteid;?>&page='+page, function(res){
					res = JSON.parse(res);
					//假设你的列表返回在data集合中
					layui.each(res.data, function(index, item){

						var html = '<a href="'+item.url+'" target="_blank"><img src="'+item.image+'" alt="'+item.title+'" width="260" height="260" title="'+item.title+'"></a>';
						lis.push(html);
					}); 
					//执行下一页渲染，第二参数为：满足“加载更多”的条件，即后面仍有分页
					//pages为Ajax返回的总页数，只有当前页小于总页数的情况下，才会继续出现加载更多
					next(lis.join(''), page < res.pages);  
				});
			}
		});	
	});
</script>

<script type="text/javascript">
	$('.jobSearchForm button').click(function(){
		var form = $('.jobSearchForm');
		var recruit_keyword = form.find('input[name=recruit_keyword]').val();
		if($.trim(recruit_keyword) == '') return false;

		form.submit();
	})
</script>


<?php include template('content', 'footer'); ?>