<?php
    function login(){
        //显示登录页面
        function show(){
            include './view/login/login.html';
        }
        function do_login(){
//            var_dump($_POST);die;
            $sql = "SELECT * FROM ew_user WHERE username='{$_POST['username']}' AND level != 2";
            //echo $sql;
            mysqlModel();
            global $getModel;
            $data = $getModel($sql);
            //var_dump($data);exit;
            if(is_array($data) && !empty($data)){
                //判断密码
                if(md5($_POST['pwd']) == $data['pwd']) {
                    $_SESSION['user']['islogin'] = true;
                    $_SESSION['user']['username'] = $data['username'];
                    $_SESSION['user']['id'] = $data['ID'];
                    $_SESSION['user']['level'] = $data['level'];
                    success('登录成功', 'index.php');
                }else{
                    error('m密码错误','?m=login&a=show');
                }
            }else{
                error('登录失败用户名错误','?m=login&a=show');
            }
        }
        function outlog(){
            //1.删除cookie中的新
            setcookie(session_name(),null,time()-1,'/');
            //2.清空数组
            $_SESSION['user'] = array();
            success('退出成功','index.php');
        }
    }