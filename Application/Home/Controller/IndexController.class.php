<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        //$this->this = D('User')->Index();

        $this->view->display('login');
    }


    /* 登录操作 */
    public function login(){
        if (!IS_POST) {
            $this->view->assign('title','一个匿名微博，登录');
            $this->view->display('login');
            return;
        }
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $m = D('User');
        $res = $m->checkUser($username,$password,$login = true);
        if($res!= false){
            session('[start]');
            session('name',$username); 
            $this->success("success", U('User/index'), 1);
        }
        else {
            $this->error("用户名或密码错误");
            return;
        }
    }
    /* 登录操作 */
    public function register(){
        // 判断是否已经登录

        if (!IS_POST) {
            $this->view->assign('title','一个匿名微博，注册');
            $this->view->display('register');
            return;
        }
        $username = trim($_POST['username']);
        $password = trim($_POST['password']); 
        $repassword = trim($_POST['repassword']);
      
        //密码不同
        if($password != $repassword){
            $this->error("密码两次不同");
            return;
        }
        else{
             $m = D('User');
             $res = $m->checkUser($username,$password);
            //没有重名
            if($res == true){
                $data = array(
                    'time'=>date(),
                    'username'=>$username,
                    'password'=>$password);
                $res = $m->addUser($data);
                session('[start]');
                session('name',$username); 
                $this->success('注册成功', U('User/index'), 3);
            }else {
                $this->error("有重名用户");
                return;
            }
        }


    }

}
