<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><?php include template('content', 'header'); ?>

<div class="ch"></div>
<div class="container">
    <div class="current_crumb">
        <div class="crumb">首页 > <?php echo L('link');?></div>
        <div class="category_title"><?php echo L('link');?></div>
    </div>
    <div class="page_list">
        <ul class="link">
           <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"link\" data=\"op=link&tag_md5=2f41ebbfc5f453e75bad9fb05115e535&action=lists&siteid=%24siteid&linktype=1&order=listorder+desc%2C+linkid+desc\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$link_tag = pc_base::load_app_class("link_tag", "link");if (method_exists($link_tag, 'lists')) {$data = $link_tag->lists(array('siteid'=>$siteid,'linktype'=>'1','order'=>'listorder desc, linkid desc','limit'=>'20',));}?>
            <?php $n=1;if(is_array($data)) foreach($data AS $r) { ?>
            <li>
                <a href=""><img src="<?php echo $r['logo'];?>" alt=""></a>
                <p>[ <a href=""><?php echo $r['name'];?></a> ]</p>
            </li>
            <?php $n++;}unset($n); ?>
            <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
        </ul>
    </div>
</div>

<?php include template('content', 'footer'); ?>