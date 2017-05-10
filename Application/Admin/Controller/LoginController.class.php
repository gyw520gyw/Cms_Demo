<?php
namespace Admin\Controller;
use Think\Controller;

/**
 * use Common\Model 这块可以不需要使用，框架默认会加载里面的内容
 */
class LoginController extends Controller {

    public function index(){
        if(session('adminUser')) {
            redirect('/admin.php?c=index');
        }
    	return $this->display();
    }

    public function check() {

        $username = $_POST['username'];
        $password = $_POST['password'];

        if(!trim($username)) {
            return show(0, '用户名不能为空');
        }

        if(!trim($password)) {
            return show(0, '密码不能为空');
        }

        $result = D('Admin')->getAdminByUsername($username);

        if(!$result) {
            return show(0, '用户名不存在');
        }

        if($result['password'] != md5Password($password)) {
            return show(0, '密码错误');
        }

        //保存数据到session
        session('adminUser', $result);
        return show(1, '登录成功');
    }


    //退出登录
    public function loginout() {
        session('adminUser', null);
        redirect('/admin.php?c=login');
    }
}