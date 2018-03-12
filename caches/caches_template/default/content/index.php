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
		<a href="" class="more"><img src="<?php echo APP_PATH;?>statics/default/images/index_24.jpg" width="100" alt=""></a>
		<img src="<?php echo APP_PATH;?>statics/default/images/index_21.jpg" width="230" alt="">
	</div>

	<div class="index_news container">
		<div class="index_news_video"><img src="<?php echo APP_PATH;?>statics/default/images/index_31.jpg" width="550" height="370" alt=""></div>
		<div class="index_news_box">
			<ul>
				<li>
					<div class="pic"><img src="<?php echo APP_PATH;?>statics/default/images/index_26.jpg" width="200" height="125" alt=""></div>
					<div class="infor">
						<span class="title">德国含沙集团驻中国首席代表刘泽思博士到访北京外航</span>
						<span class="des">是的记录圣诞节忘记了圣诞节了开始懂了是看得见圣诞节快乐收到了接口</span>
					</div>
				</li>
				<li>
					<div class="title"><a href="" target="_blank"><span class="time">[2018-12-12]</span>关于召开“2018第三届全球物流技术大会”的通知</a></div>
				</li>
				<li>
					<div class="title"><a href="" target="_blank"><span class="time">[2018-12-12]</span>关于召开“2018第三届全球物流技术大会”的通知</a></div>
				</li>
				<li>
					<div class="title"><span class="time">[2018-12-12]</span><a href="" target="_blank">关于召开“2018第三届全球物流技术大会”的通知</a></div>
				</li>
				<li>
					<div class="title"><span class="time">[2018-12-12]</span><a href="" target="_blank">关于召开“2018第三届全球物流技术大会”的通知</a></div>
				</li>
			</ul>
		</div>
	</div>

	<div class="container index_title">
		<a href="" class="more"><img src="<?php echo APP_PATH;?>statics/default/images/index_24.jpg" width="100" alt=""></a>
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
		<a href="" class="more"><img src="<?php echo APP_PATH;?>statics/default/images/index_24.jpg" width="100" alt=""></a>
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
			<li><a href=""><img src="<?php echo APP_PATH;?>statics/default/images/index_49.jpg" width="366" height="190" alt=""></a></li>
			<li><a href=""><img src="<?php echo APP_PATH;?>statics/default/images/index_50.jpg" width="366" height="190" alt=""></a></li>
			<li><a href=""><img src="<?php echo APP_PATH;?>statics/default/images/index_51.jpg" width="366" height="190" alt=""></a></li>
			<li><a href=""><img src="<?php echo APP_PATH;?>statics/default/images/index_52.jpg" width="366" height="190" alt=""></a></li>
		</ul>
	</div>
	<div class="container index_title">
		<a href="" class="more"><img src="<?php echo APP_PATH;?>statics/default/images/index_24.jpg" width="100" alt=""></a>
		<img src="<?php echo APP_PATH;?>statics/default/images/index_55.jpg" width="320" alt="">
	</div>
	<div class="container index_customer">
		<ul>
			<li>
				<a href=""><img src="<?php echo APP_PATH;?>statics/default/images/index_53.jpg" width="260" height="130" alt=""></a>
				<p class="title"><a href="">[ 美国达美航空公司 ]</a></p>
			</li>
			<li>
				<a href=""><img src="<?php echo APP_PATH;?>statics/default/images/index_53.jpg" width="260" height="130" alt=""></a>
				<p class="title"><a href="">[ 美国达美航空公司 ]</a></p>
			</li>
			<li>
				<a href=""><img src="<?php echo APP_PATH;?>statics/default/images/index_53.jpg" width="260" height="130" alt=""></a>
				<p class="title"><a href="">[ 美国达美航空公司 ]</a></p>
			</li>
			<li>
				<a href=""><img src="<?php echo APP_PATH;?>statics/default/images/index_53.jpg" width="260" height="130" alt=""></a>
				<p class="title"><a href="">[ 美国达美航空公司 ]</a></p>
			</li>
		</ul>
	</div>
</div>
<?php include template('content', 'footer'); ?>