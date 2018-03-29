<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><?php include template('content', 'header'); ?>

<?php include template('member', 'top'); ?>
<script type="text/javascript" src="<?php echo JS_PATH;?>placeholder.js"></script>
<div class="container">
    <?php include template('member', 'left'); ?>
    <div class="page_right">
        <div class="current_crumb">
            <div class="crumb">个人中心 > 外语经历</div>
            <div class="category_title">外语经历</div>
        </div>
        <div class="page_content">
            <div class="basicinfo">
                <div class="tit"><div class="language"><a <?php if($language=='en') { ?> href="?m=member&a=language" <?php } else { ?>class="current"<?php } ?>>中文</a><a <?php if($language=='zh') { ?> href="?m=member&a=language&l=en" <?php } else { ?>class="current"<?php } ?>>英文</a></div>
                    <button class="layui-btn layui-btn-normal" onclick="add()">添加</button></div>
                <table class="layui-table">
                    <colgroup>
                        <col width="200">
                        <col width="200">
                        <col width="100">
                        <col width="150">
                        <col width="">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>语言</th>
                            <th>证书</th>
                            <th>等级</th>
                            <th>获得时间</th>
                            <th>操作</th>
                        </tr> 
                    </thead>
                    <tbody>
                        <?php if(!empty($lists)) { ?>
                        <?php $n=1;if(is_array($lists)) foreach($lists AS $r) { ?>
                        <tr>
                            <td><?php echo $r['name'];?></td>
                            <td><?php echo $r['certificate'];?></td>
                            <td><?php echo $r['level'];?></td>
                            <td><?php echo date('Y-m', strtotime($r[gettime]));?></td>
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
            title: '添加',
            type: 2,
            area: ['500px', '500px'],
            content: '?m=member&a=language_modify&l=<?php echo $language;?>',
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
            title: '修改',
            type: 2,
            area: ['500px', '500px'],
            content: '?m=member&a=language_modify&id='+id,
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
            url: '?m=member&a=language_del&id='+id,
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