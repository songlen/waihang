<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><?php include template('content', 'header'); ?>

<?php include template('member', 'top'); ?>
<script type="text/javascript" src="<?php echo JS_PATH;?>placeholder.js"></script>
<div class="container">
    <?php include template('member', 'left'); ?>
    <div class="page_right">
        <div class="current_crumb">
            <div class="crumb">个人中心 > 基本资料</div>
            <div class="category_title">基本资料</div>
        </div>
        <div class="page_content">
            <div class="basicinfo">
                <div class="tit"><div class="language"><a <?php if($language=='en') { ?> href="?m=member&a=education" <?php } else { ?>class="current"<?php } ?>>中文</a><a <?php if($language=='zh') { ?> href="?m=member&a=education&l=en" <?php } else { ?>class="current"<?php } ?>>英文</a></div>
                    <button class="layui-btn layui-btn-normal" onclick="add()">添加一条</button></div>
                <table class="layui-table">
                    <colgroup>
                        <col width="170">
                        <col width="150">
                        <col width="80">
                        <col width="80">
                        <col width="50">
                        <col width="80">
                        <col width="50">
                        <col width="50">
                        <col width="50">
                        <col width="">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>学校名称</th>
                            <th>专业</th>
                            <th>入学时间</th>
                            <th>毕业时间</th>
                            <th>学历</th>
                            <th>已取得<br>毕业证</th>
                            <th>留学</th>
                            <th>民航院校</th>
                            <th>最高学历</th>
                            <th>操作</th>
                        </tr> 
                    </thead>
                    <tbody>
                        <?php if(!empty($education)) { ?>
                        <?php $n=1;if(is_array($education)) foreach($education AS $r) { ?>
                        <tr>
                            <td><?php echo $r['school_name'];?></td>
                            <td><?php echo $r['major'];?></td>
                            <td><?php echo date('Y-m', strtotime($r[start_time]));?></td>
                            <td><?php echo date('Y-m', strtotime($r[end_time]));?></td>
                            <td><?php echo $enums['diploma'][$r['diploma']];?></td>
                            <td><?php if($r[has_diploma]) { ?>是<?php } else { ?>否<?php } ?></td>
                            <td><?php if($r[study_abroad]) { ?>是<?php } else { ?>否<?php } ?></td>
                            <td><?php if($r[civil_viation]) { ?>是<?php } else { ?>否<?php } ?></td>
                            <td><?php if($r[highest_degree]) { ?>是<?php } else { ?>否<?php } ?></td>
                            <td>
                                <a href="javascript:;" onclick="edit(<?php echo $r['id'];?>)">修改</a>
                                <a href="javascript:;" onclick="del(<?php echo $r['id'];?>, this)">删除</a>
                            </td>
                        </tr>
                        <?php $n++;}unset($n); ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="clear"></div>
</div>

<script type="text/javascript">

    function add(){

        layer.open({
            id:'add',
            title: '添加教育经历',
            type: 2,
            area: ['800px', '500px'],
            content: '?m=member&a=education_modify&l=<?php echo $language;?>',
            btn: '确定',
            yes: function(index, layero){
                var btn_submit = layer.getChildFrame('.layui-btn', index);
                btn_submit.click();
            }
        })
    }
    function edit(id) {
        layer.open({
            id:'edit',
            title: '修改教育经历',
            type: 2,
            area: ['800px', '500px'],
            content: '?m=member&a=education_modify&id='+id,
            btn: '确定',
            yes: function(index, layero){
                var btn_submit = layer.getChildFrame('.layui-btn', index);
                btn_submit.click();
            }
        }); 
    }

    function del(id, obj){
        debugger
        if(!confirm('确定删除吗')){
            return false;
        }
        $.ajax({
            url: '?m=member&a=education_del&id='+id,
            type: 'get',
            dataType: 'json',
            success: function(data){
                if(data.code == 200){
                    $(obj).parents('tr').animate({opacity:0}, 500, function(){
                        $(this).remove();
                    })
                }
            },
            error: function(){
                layer.msg('服务器错误');
            }
        })
    }
</script>

<?php include template('content', 'footer'); ?>