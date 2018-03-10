<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?>
<div class="footer min-width-1300">
	<div class="container" style="overflow: hidden;">
		<div class="foot_l">
			<ul>
				<li><span class="lable">友情链接：</span><span class="huoban"><a href="">友情链接1</a></span><span class="huoban"><a href="">友情链接2</a></span></li>
				<li><span class="lable">版权所有：</span>外航服务公司 备案号</li>
				<li><span class="lable">联系电话：</span>010-84187577 <span class="tousu"><a href="">投诉与建议</a></span></li>
			</ul>
		</div>
		<div class="foot_r">
			<ul>
				<li><p>官方微信</p><img src="<?php echo APP_PATH;?>statics/default/images/index_62.jpg" width="120" height="120" alt=""></li>
				<li><p>官方微博</p><img src="<?php echo APP_PATH;?>statics/default/images/index_62.jpg" width="120" height="120" alt=""></li>
			</ul>
		</div>

	</div>
</div>
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

		$('.language').click(function(){
			visible($('.zh'))
			return false
		})

		$('.person').click(function(){
			visible($('.loginreg'))
			return false
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