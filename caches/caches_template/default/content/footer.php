<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?>
<div class="footer min-width-1300">
	<div class="container" style="overflow: hidden;">
		<div class="foot_l">
			<ul>
				<li><span class="lable">友情链接：</span><?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"get\" data=\"op=get&tag_md5=7247d13fefb58181a72853557a7e21c4&sql=select+%2A+from+phpcms_keylink+where+siteid%3D%24siteid+order+by+keylinkid+desc\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}pc_base::load_sys_class("get_model", "model", 0);$get_db = new get_model();$r = $get_db->sql_query("select * from phpcms_keylink where siteid=$siteid order by keylinkid desc LIMIT 20");while(($s = $get_db->fetch_next()) != false) {$a[] = $s;}$data = $a;unset($a);?><?php $n=1;if(is_array($data)) foreach($data AS $r) { ?><span class="huoban"><a href="<?php echo $r['url'];?>" target="_blank"><?php echo $r['word'];?></a></span><?php $n++;}unset($n); ?><?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?></li>
				<li><span class="lable">版权所有：</span><?php echo get_extend_setting(copyright);?></li>
				<li><span class="lable">联系电话：</span><?php echo get_extend_setting(phone);?> <span class="tousu"><a href="">投诉与建议</a></span></li>
			</ul>
		</div>
		<div class="foot_r">
			<?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"get\" data=\"op=get&tag_md5=56127cc7f574b62e6d1d22ec33080376&sql=SELECT+name%2C+setting+FROM+phpcms_poster+WHERE+spaceid+%3D+12+AND+disabled%3D0+ORDER+BY+listorder+ASC\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}pc_base::load_sys_class("get_model", "model", 0);$get_db = new get_model();$r = $get_db->sql_query("SELECT name, setting FROM phpcms_poster WHERE spaceid = 12 AND disabled=0 ORDER BY listorder ASC LIMIT 20");while(($s = $get_db->fetch_next()) != false) {$a[] = $s;}$data = $a;unset($a);?>
			<ul>
				<?php $n=1;if(is_array($data)) foreach($data AS $r) { ?>
				<?php 
					$image = json_decode($r['setting'], true);
					$image = $image[1];
				?>
				<li><p><?php echo $r['name'];?></p><img src="<?php echo $image['imageurl'];?>" width="110" height="110" alt="<?php echo $image['alt'];?>"></li>
				<?php $n++;}unset($n); ?>
			</ul>
			<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
		</div>

	</div>
</div>

<!-- 检测浏览器版本 低于ie8-->
<div class="floating-black" style="display: none;">
	<div class="close">X</div>
    <div id="browser-fail" class="alltips">
        <div class="alltips-box">
            <div class="pic"></div>
            <p>您的浏览器版本太低了，<br>赶快去升级或者更换别的浏览器吧！</p>
        </div>
    </div>

    <div class="shadow"></div>
</div>
<link rel="stylesheet" type="text/css" href="/statics/checkie/checkie.css">
<script type="text/javascript" src="/statics/checkie/checkie.js"></script>
<!-- 检测浏览器版本 低于ie8 -->

<!-- banner -->
<script type="text/javascript" src="<?php echo APP_PATH;?>statics/default/js/jquery.flexslider-min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('.flexslider').flexslider({
			directionNav: false,
			pauseOnAction: false,
			pauseOnHover: true,
			slideshowSpeed: 3000,
		});
	});
</script>
<script type="text/javascript">
	$(function(){
		// 显示语言

		$('.language').click(function(event){
			visible($('.zh'))
			event.stopPropagation();
		})

		$('.person').click(function(event){
			visible($('.loginreg'))
			event.stopPropagation();
		})
		$(document).click(function(){
			unvisible($('.zh'));
			unvisible($('.loginreg'));
		})

		// 显示
		function visible($obj){
			$obj.stop();
			$obj.css({opacity:0}).show();
			$obj.animate({opacity:1}, 500);
		}
		// 隐藏
		function unvisible($obj){
			$obj.stop();
			$obj.animate({opacity:0}, 500, function(){
				$obj.hide();
			});
		}
	})
</script>
<script type="text/javascript">
	// 导航下拉
	$(function(){
		$('.menu li').hover(function(){
			$(this).find('dl').show();
		}, function(){
			$(this).find('dl').hide();
		})
	})
</script>
</body>
</html>