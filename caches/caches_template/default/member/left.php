<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><div class="page_left">
    <div class="title">个人中心</div>
    <ul class="navlist">
        <li <?php if(ROUTE_A == 'init') { ?>class="current"<?php } ?>><a href="?m=member">基本资料</a></li>
        <li <?php if(ROUTE_A == 'education') { ?>class="current"<?php } ?>><a href="?m=member&a=education">教育经历</a></li>
        <li <?php if(ROUTE_A == 'language') { ?>class="current"<?php } ?>><a href="?m=member&a=language">外语经历</a></li>
        <li <?php if(ROUTE_A == 'pic') { ?>class="current"<?php } ?>><a href="?m=member&a=pic">图像采集</a></li>
        <li <?php if(ROUTE_A == 'changePassword') { ?>class="current"<?php } ?>><a href="?m=member&a=changePassword">修改密码</a></li>
        <li class=""><a href="">职位应聘</a></li>
        <li class=""><a href="">我的课程</a></li>
        <li class=""><a href="">医疗报销</a></li>
    </ul>
</div>