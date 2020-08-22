<?php
session_start();
//前台入口文件
$m = $_GET['m']??'index';
$a = $_GET['a']??'show';
include './org/keywords.php';
include './control/indexControl.php';
include './model/MySQLModel.php';
include './control/weblinkControl.php';
include './org/helper.php';
include './control/loginControl.php';
include './control/regisControl.php';
include '../config/sysConfig.php';
include './control/mylistControl.php';
include './control/userall.php';
include './org/upload_func.php';
include './org/thumb_func.php';
$m();
$a();