<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><?php include template('content', 'header'); ?>

<?php include template('member', 'top'); ?>

<div class="container">
    <?php include template('member', 'left'); ?>
    <div class="page_right">
        <div class="current_crumb">
            <div class="crumb">个人中心 > 修改密码</div>
            <div class="category_title">修改密码</div>
        </div>
        <div class="page_content">
            <form class="layui-form" action="">
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">旧密码</label>
                        <div class="layui-input-inline">
                            <input type="password" name="info[old_pwd]" id="old_pwd" class="layui-input">
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">新密码</label>
                        <div class="layui-input-inline">
                            <input type="password" name="info[new_pwd]" id="new_pwd" class="layui-input">
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">确认新密码</label>
                        <div class="layui-input-inline">
                            <input type="password" name="info[new_pwd_confirm]" id="new_pwd_confirm" class="layui-input">
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button type="button" class="layui-btn" id="layui_btn">确认修改</button>
                    </div>
                </div>
                <input type="hidden" name="dosubmit" value="1">   
            </form>
        </div>
    </div>
    <div class="clear"></div>
</div>

<script type="text/javascript">
    $('#layui_btn').click(function(){
        var _this = $(this);
        if(_this.hasClass('disabled')) return false;

        if($.trim($('#old_pwd').val()) == ''){
            tips('旧密码必填', '#old_pwd');
            return false;
        }

        if($.trim($('#new_pwd').val()) == ''){
            tips('新密码必填', '#new_pwd');
            return false;
        }

        if($.trim($('#new_pwd_confirm').val()) != $.trim($('#new_pwd').val())){
            layer.msg('两次密码不一致',);
            return false;
        }

        // _this.addClass('disabled');
        $.ajax({
            url: '?m=member&a=changePassword',
            dataType: 'json',
            type: 'post',
            data: _this.parents('form').serialize(),
            success: function(data){
                if(data.code == 400){
                    layer.msg(data.msg);
                    
                }
                if(data.code == 200){
                    layer.msg(data.msg, function(){
                       window.location.reload();
                    });
                }
            },
            error: function(){
                layer.msg('服务器错误');
            }
        })
        
    })

    function tips(message, id){
        layer.tips(message, id, {tips:[2, '#000']})
    }
</script>
<?php include template('content', 'footer'); ?>