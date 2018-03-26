<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><?php include template('content', 'header'); ?>
<div class="jq22-container min-width-1300">
	<div class="flexslider">
		<ul class="slides">
			<?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"get\" data=\"op=get&tag_md5=390fbb994a2ecd8cc0f863723a8ef451&sql=SELECT+setting+FROM+phpcms_poster+WHERE+spaceid+%3D+11+AND+disabled%3D0+ORDER+BY+listorder+ASC\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">修改</a>";}pc_base::load_sys_class("get_model", "model", 0);$get_db = new get_model();$r = $get_db->sql_query("SELECT setting FROM phpcms_poster WHERE spaceid = 11 AND disabled=0 ORDER BY listorder ASC LIMIT 20");while(($s = $get_db->fetch_next()) != false) {$a[] = $s;}$data = $a;unset($a);?>
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

<div class="min-width-1300">
	<div class="container index_title">
		<a href="<?php echo $CATEGORYS['30']['url'];?>" class="more"><img src="<?php echo APP_PATH;?>statics/default/images/index_24.jpg" width="100" alt="MORE" title="MORE"></a>
		<img src="<?php echo APP_PATH;?>statics/default/images/index_21.jpg" width="230" alt="">
	</div>

	<div class="index_news container">
		<div class="index_news_video">
			<video id="video" src="<?php echo get_extend_setting(index_video);?>" width="550" height="370" controls preload>
				您的浏览器暂不支持播放该视频，请升级至最新版浏览器。
			</video>
		</div>
		<div class="index_news_box">
			<ul>
				<?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=32bf69858fe29b58e3ad4cec3d63b78a&action=lists&catid=30&num=20&order=listorder+desc%2C+id+DESC\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">修改</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$data = $content_tag->lists(array('catid'=>'30','order'=>'listorder desc, id DESC','limit'=>'20',));}?>
				<?php $n=1;if(is_array($data)) foreach($data AS $r) { ?>
				<?php if($n == 1) { ?>
				<li>
					<div class="pic"><a href="<?php echo $r['url'];?>"><img src="<?php echo thumb($r[thumb], 200, 125);?>" width="200" height="125" alt=""></a></div>
					<div class="infor">
						<span class="title"><a href="<?php echo $r['url'];?>"><?php echo $r['title'];?></a></span>
						<span class="des" title="$r[description]"><?php echo strcut($r[description], 36);?></span>
					</div>
				</li>
				<?php } else { ?>
				<li>
					<div class="title"><a href="<?php echo $r['url'];?>" target="_blank"><span class="time">[<?php echo date('Y-m-d', $r[inputtime]);?>]</span><?php echo strcut($r[title], 23);?></a></div>
				</li>
				<?php } ?>
				<?php $n++;}unset($n); ?>
				<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
			</ul>
		</div>
	</div>

	<div class="container index_title">
		<a href="" class="more"><img src="<?php echo APP_PATH;?>statics/default/images/index_24.jpg" width="100" alt="MORE" title="MORE"></a>
		<img src="<?php echo APP_PATH;?>statics/default/images/index_36.jpg" width="280" alt="">
	</div>
	<div class="container index_zhaopin">
		<ul>
			<li>
				<div class="pic"><a href=""><img src="<?php echo APP_PATH;?>statics/default/images/index_39.jpg" width="190" height="210" alt=""></a></div>
				<div class="infor">
					<div class="title"><a href="">是的记录圣诞节施蒂利克是的记录圣诞节施蒂利克</a></div>
					<div class="des">睡觉了是都结束了的空间是地脚螺栓肯德基是的两款圣诞节沙德雷克</div>
					<div class="time">2018-12-12</div>
				</div>
			</li>
			<li>
				<div class="pic"><a href=""><img src="<?php echo APP_PATH;?>statics/default/images/index_39.jpg" width="190" height="210" alt=""></a></div>
				<div class="infor">
					<div class="title"><a href="">是的记录圣诞节施蒂利克是的记录圣诞节施蒂利克</a></div>
					<div class="des">睡觉了是都结束了的空间是地脚螺栓肯德基是的两款圣诞节沙德雷克</div>
					<div class="time">2018-12-12</div>
				</div>
			</li>
			<li>
				<div class="pic"><a href=""><img src="<?php echo APP_PATH;?>statics/default/images/index_39.jpg" width="190" height="210" alt=""></a></div>
				<div class="infor">
					<div class="title"><a href="">是的记录圣诞节施蒂利克是的记录圣诞节施蒂利克</a></div>
					<div class="des">睡觉了是都结束了的空间是地脚螺栓肯德基是的两款圣诞节沙德雷克</div>
					<div class="time">2018-12-12</div>
				</div>
			</li>
			<li>
				<div class="pic"><a href=""><img src="<?php echo APP_PATH;?>statics/default/images/index_39.jpg" width="190" height="210" alt=""></a></div>
				<div class="infor">
					<div class="title"><a href="">是的记录圣诞节施蒂利克是的记录圣诞节施蒂利克</a></div>
					<div class="des">睡觉了是都结束了的空间是地脚螺栓肯德基是的两款圣诞节沙德雷克</div>
					<div class="time">2018-12-12</div>
				</div>
			</li>
		</ul>
	</div>

	<div class="container index_title">
		<a href="" class="more"><img src="<?php echo APP_PATH;?>statics/default/images/index_24.jpg" width="100" alt="MORE" title="MORE"></a>
		<img src="<?php echo APP_PATH;?>statics/default/images/index_43.jpg" width="340" alt="">
	</div>
	<div class="container index_zhaopin">
		<ul>
			<li>
				<div class="pic"><a href=""><img src="<?php echo APP_PATH;?>statics/default/images/index_39.jpg" width="190" height="210" alt=""></a></div>
				<div class="infor">
					<div class="title"><a href="">是的记录圣诞节施蒂利克是的记录圣诞节施蒂利克</a></div>
					<div class="des">睡觉了是都结束了的空间是地脚螺栓肯德基是的两款圣诞节沙德雷克</div>
					<div class="time">2018-12-12</div>
				</div>
			</li>
			<li>
				<div class="pic"><a href=""><img src="<?php echo APP_PATH;?>statics/default/images/index_39.jpg" width="190" height="210" alt=""></a></div>
				<div class="infor">
					<div class="title"><a href="">是的记录圣诞节施蒂利克是的记录圣诞节施蒂利克</a></div>
					<div class="des">睡觉了是都结束了的空间是地脚螺栓肯德基是的两款圣诞节沙德雷克</div>
					<div class="time">2018-12-12</div>
				</div>
			</li>
			<li>
				<div class="pic"><a href=""><img src="<?php echo APP_PATH;?>statics/default/images/index_39.jpg" width="190" height="210" alt=""></a></div>
				<div class="infor">
					<div class="title"><a href="">是的记录圣诞节施蒂利克是的记录圣诞节施蒂利克</a></div>
					<div class="des">睡觉了是都结束了的空间是地脚螺栓肯德基是的两款圣诞节沙德雷克</div>
					<div class="time">2018-12-12</div>
				</div>
			</li>
			<li>
				<div class="pic"><a href=""><img src="<?php echo APP_PATH;?>statics/default/images/index_39.jpg" width="190" height="210" alt=""></a></div>
				<div class="infor">
					<div class="title"><a href="">是的记录圣诞节施蒂利克是的记录圣诞节施蒂利克</a></div>
					<div class="des">睡觉了是都结束了的空间是地脚螺栓肯德基是的两款圣诞节沙德雷克</div>
					<div class="time">2018-12-12</div>
				</div>
			</li>
		</ul>
	</div>

	<div class="container indexmidmenu">
		<ul>
			<li><a href=""><img src="<?php echo APP_PATH;?>statics/default/images/index_47.jpg" width="366" height="190" alt=""></a></li>
			<li><a href=""><img src="<?php echo APP_PATH;?>statics/default/images/index_48.jpg" width="366" height="190" alt=""></a></li>
			<li><a href="<?php echo $CATEGORYS['10']['url'];?>"><img src="<?php echo APP_PATH;?>statics/default/images/index_49.jpg" width="366" height="190" alt=""></a></li>
			<li><a href="<?php echo $CATEGORYS['23']['url'];?>"><img src="<?php echo APP_PATH;?>statics/default/images/index_50.jpg" width="366" height="190" alt=""></a></li>
			<li><a href="<?php echo $CATEGORYS['17']['url'];?>"><img src="<?php echo APP_PATH;?>statics/default/images/index_51.jpg" width="366" height="190" alt=""></a></li>
			<li><a href="<?php echo $CATEGORYS['2']['url'];?>"><img src="<?php echo APP_PATH;?>statics/default/images/index_52.jpg" width="366" height="190" alt=""></a></li>
		</ul>
	</div>
	<div class="container index_title">
		<a href="/index.php?m=link" class="more"><img src="<?php echo APP_PATH;?>statics/default/images/index_24.jpg" width="100" alt="MORE" title="MORE"></a>
		<img src="<?php echo APP_PATH;?>statics/default/images/index_55.jpg" width="320" alt="">
	</div>
	<div class="container index_customer">
		<ul>
			<?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"link\" data=\"op=link&tag_md5=49d791832404be6575cfa0de1f15881c&action=lists&siteid=%24siteid&num=10&linktype=1&order=listorder+desc%2C+linkid+desc\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">修改</a>";}$link_tag = pc_base::load_app_class("link_tag", "link");if (method_exists($link_tag, 'lists')) {$data = $link_tag->lists(array('siteid'=>$siteid,'linktype'=>'1','order'=>'listorder desc, linkid desc','limit'=>'10',));}?>
			<?php $n=1;if(is_array($data)) foreach($data AS $r) { ?>
			<li>
				<a href="<?php echo $r['url'];?>" target="_blank"><img src="<?php echo $r['logo'];?>" width="260" height="130" alt=""></a>
				<p class="title"><a href="<?php echo $r['url'];?>" target="_blank">[ <?php echo $r['name'];?> ]</a></p>
			</li>
			<?php $n++;}unset($n); ?>
			<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
		</ul>
	</div>
</div>
<script type="text/javascript">
	// 我们的客户 滚动效果
	$(function(){
		var oul = $('.index_customer ul');
		var oulHtml = oul.html();
		oul.html(oulHtml+oulHtml)
		var timeId = null;

		var ali = $('.index_customer ul li');
		var aliWidth = ali.eq(0).width();
		var aliSize = ali.size();
		var ulWidth = aliWidth*aliSize + aliSize*20;
		oul.width(ulWidth);	//1600px
		
		var speed = -2;

		function slider(){

			if(speed<0){
				if(oul.css('left')==-ulWidth/2+'px'){
		 		oul.css('left',0);
			 	}
			 	oul.css('left','+=-2px');
			}

		 	
			if(speed>0){
				if(oul.css('left')=='0px'){
		 		oul.css('left',-ulWidth/2+'px');
			 	}
			 	oul.css('left','+='+speed+'px');
			}
		 	
		 }
		
		// setInterval()函数的作用是：每隔一段时间，执行该函数里的代码
		 timeId = setInterval(slider,30);

		$('.index_customer').mouseover(function(){
			// clearInterval()函数的作用是用来清除定时器
			clearInterval(timeId);
		});

		$('.index_customer').mouseout(function(){
			timeId = setInterval(slider,30);
		});

	});

	// 图片移入特效
	$(function(){
		$('.indexmidmenu img').hover(function(){
			$(this).stop(false, true);
			$(this).animate({opacity: 0.6}, 300);
		}, function(){
			$(this).stop(false, true);
			$(this).animate({opacity: 1}, 300);
		})
	})
</script>

<!-- html5 video 兼容处理 -->
<script src="//api.html5media.info/1.2.2/html5media.min.js"></script>
<style type="text/css">
    video::-webkit-media-controls-enclosure {
        overflow:hidden;
    }
    video::-webkit-media-controls-panel {
        width: calc(100% + 30px);
    }
</style>

<?php include template('content', 'footer'); ?>