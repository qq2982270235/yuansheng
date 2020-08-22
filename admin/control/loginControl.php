<?php
    function login(){
        function show (){
            include './view/login.html';
        }
        function do_login(){
//            var_dump($_POST);
//            var_dump($_SESSION);die;
//            $_SESSION['user']['islogin']= true;
            //1.判断验证码
//            if(strtolower($_POST['mycode'])){
//                error('验证码错误','?m=login&a=show');
//            }

            //2.查询指定用户名的数据 并且 判断权限
            $sql = "SELECT * FROM ew_user WHERE username='{$_POST['username']}' AND level=0";
            mysqlModel();
            global $getModel;
            $data = $getModel($sql);
//            var_dump($data);
            //3.判断密码是否正确
            if(md5($_POST['pwd']) != $data['pwd']){
                error('密码错误','?m=login&a=show&eno=3');
            }
            //4.登录成功 做会员卡
            $_SESSION['user']['islogin'] = true;
            $_SESSION['user']['level'] = $data['level'];
            $_SESSION['user']['username'] = $data['username'];
            success('登陆成功','index.php');
        }
        function logout(){
            setcookie(session_name(),null,time()-1,null);
            $_SESSION['user'] = array();
            success('退出成功','index.php');
        }
    }