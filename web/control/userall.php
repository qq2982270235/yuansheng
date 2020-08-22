<?php
    function userall(){
        function show(){
            $usename = $_SESSION['user']['username'];
            $sql = "SELECT * FROM ew_user WHERE `username`='{$usename}'";
            mysqlModel();
            global $getModel;
            $userarr = $getModel($sql);
//            var_dump($userarr);die;
            $levelone = ['超级管理员','会员','禁用'];
            //制作性别
            $woman = $man = $baomi = '';
            switch($userarr['sex']){
                case 0:
                    $woman = 'checked';
                    break;
                case 1:
                    $man = 'checked';
                    break;
                case 2:
                    $baomi = 'checked';
                    break;
            }
            $age = ['女','男','保密'];
            $leveltwo = $userarr['level'];


            include './view/user/userall.html';
        }
        function edit(){
            MySQLModel();

            if(!empty($_FILES['pic']['name'])){
                $imgInfo = upload('pic','../public/upload',20000000000);
                //进行图片缩放
                thumb($imgInfo['pathinfo'],'../public/upload/thumb',50,50);
                //将上传图片名称保存到$_POST数组
                $_POST['pic'] = $imgInfo['name'];
            }else{
                $_POST['pic'] = 'a.jpg';
            }
//            echo '<pre>';
//            var_dump($_POST );
//            var_dump($_FILES);
//            echo '</pre>';
            global  $dmlModel;
            $sql = "UPDATE ew_user SET username='{$_POST['username']}',name='{$_POST['username']}',phone='{$_POST['phone']}',sex='{$_POST['sex']}',age='{$_POST['age']}',pic='{$_POST['pic']}' WHERE id =".$_POST['id'];
            echo $sql;
            $result=$dmlModel($sql);
//            var_dump($result);
            if ($result){
                success('修改成功','?m=userall&a=show');
            }else{
                error('修改失败','?m=userall&a=show');
            }
        }
    }