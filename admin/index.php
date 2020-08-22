<?php
session_start();
date_default_timezone_set('PRC');
//后台的主入口文件
$m = $_GET['m'] ?? 'index';
$a = $_GET['a'] ?? 'show';
include './control/indexControl.php';
include './control/sysControl.php';
include './model/MySQLModel.php';
include './control/userControl.php';
include './control/linkControl.php';
include './control/posterControl.php';
include './control/loginControl.php';
include './control/pinlunControl.php';
//调用文件上传函数
include './org/upload_func.php';
include './org/thumb_func.php';
include './org/helper.php';
include './control/categoryControl.php';
include './control/contentControl.php';
if(isset($_SESSION['user']['islogin']) && $_SESSION['user']['islogin']== true) {
    $m();
    $a();
}else{
    if($m == 'login'){
        $m();
    }else{
        login();
    }
    $a();
}
