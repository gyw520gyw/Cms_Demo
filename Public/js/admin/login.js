/**
 * Created by Administrator on 2017/4/20.
 */
/**
 * 前端登录业务
 * @type {{check: login.check}}
 */
var login = {

    check : function() {
        //获取用户名密码
        var username = $('input[name="username"]').val();
        var password = $('input[name="password"]').val();

        //校验
        if(!username) {
            dialog.error('用户名不能为空');
        }

        if(!password) {
            dialog.error('密码不能为空');
        }

        var url = 'admin.php?c=login&a=check';
        var data = {'username':username, 'password':password};

        $.post(url, data, function(result){
            if(result.status == 0) {
                dialog.error(result.msg);
            }
            if(result.status == 1) {
                dialog.success(result.msg, '/admin.php?c=index');
            }
        },'JSON');
    }
}