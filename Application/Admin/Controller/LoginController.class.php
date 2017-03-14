<?php
namespace Admin\Controller;
use Think\Controller;

/**
 * use Common\Model 这块可以不需要使用，框架默认会加载里面的内容
 */
class LoginController extends Controller {

    public function index(){
        if(session('adminUser')) {
            //session存在，跳转到后台首页
           $this->redirect('/admin.php?c=index');
        }
        // admin.php?c=index
        $this->display();
    }

    public function check() {
        $username = $_POST['username'];
        $password = $_POST['password'];
        if(!trim($username)) {
            //show()方法是公用方法
            return show(0,'用户名不能为空');
        }
        if(!trim($password)) {
            return show(0,'密码不能为空');
        }
        //校验，与数据库的数据进行比较
        $ret = D('Admin')->getAdminByUsername($username);
        //print_r($ret);
        if(!$ret || $ret['status'] !=1) {
            return show(0,'该用户不存在');
        }

        if($ret['password'] != $password) {
            return show(0,'密码错误');
        }

        D("Admin")->updateByAdminId($ret['admin_id'],array('lastlogintime'=>time()));
        //登陆成功，记录到session里面
        session('adminUser', $ret);
        return show(1,'登录成功');
    }

    public function loginout() {
        session('adminUser', null);
        //跳转
        $this->redirect('/admin.php?c=login');
    }

}