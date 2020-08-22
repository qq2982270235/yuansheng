<?php
    function regis(){
        function show(){
            include './view/login/login.html';
        }
        function do_regis(){
//            var_dump($_POST);die;
            //1.判断的验证码

            //2.判断密码
            if(!empty($_POST['pwd'])){
                if($_POST['pwd'] == $_POST['repwd']){
                    $_POST['pwd'] = md5($_POST['repwd']);
                }else{
                    error('密码不一致','?m=regis&a=show');
                }
            }
            $user = $_POST['username'];
            //3.插入数据
            $time = time();
            $sql = "INSERT INTO ew_user(username,pwd,level,addtime) VALUES('{$user}','{$_POST['pwd']}','1',{$time})";
//            var_dump($sql);die;
            mysqlModel();
            global $dmlModel;
            $insertId = $dmlModel($sql);

            if($insertId){
                //注册成功直接做会员卡
                $_SESSION['user']['username'] = $user;
                $_SESSION['user']['id'] = $insertId;
                $_SESSION['user']['level'] = 1;
                $_SESSION['user']['islogin'] = true;
                success('注册成功','index.php');
            }else{
                error('注册失败','?m=regis&a=show');
            }
        }
    }