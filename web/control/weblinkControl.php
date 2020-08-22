<?php
    function weblink(){
        function add(){
            include './view/link/add.html';
        }
        function do_add(){
//            var_dump($_POST);
            $time = time();
            $sql = "INSERT INTO ew_link(webname,url,lname,lemail,addtime) VALUES('{$_POST['webname']}','{$_POST['url']}','{$_POST['lname']}','{$_POST['lemail']}',{$time})";
            mysqlModel();
            global $dmlModel;
            if($dmlModel($sql)){
                success('申请成功','index.php');
            }else{
                error('申请失败','index.php');
            }
        }
    }