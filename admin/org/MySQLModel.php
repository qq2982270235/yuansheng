<?php
/*
 *  连接数据库函数
 * 使用方法：
 *  1.调用外部函数 mysqlModel
 *  2. 调用对应内部操作函数 传入要操作的SQL语句即可
 */
function mysqlModel(){
    //1.初始化连接数据库并且选择数据库函数
    function construct(){
        include '../config/config.php';
        $link = mysqli_connect(HOST,USER,PWD,DBNAME) or die('连接或者选择数据库失败');
        return $link;
    }
    $link = construct();
    //2.支持增、删、改的功能
    GLOBAL $dmlModel;
    $dmlModel = function ($sql) use($link){
        //发送SQL语句
        $result = mysqli_query($link,$sql);
        if($result && mysqli_affected_rows($link)>0){
            $id = mysqli_insert_id($link);
            $affected = mysqli_affected_rows($link);
            return !empty($id)?$id:$affected;
            
        }else{
            return false;
        }
    };
    //3.支持查询的功能
    GLOBAL $selectModel;
    $selectModel = function ($sql) use($link){
        $result = mysqli_query($link,$sql);
        $arr = [];
        if($result && mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_assoc($result)){
                $arr[] = $row;
            }
            
            return $arr;
        }else{
            
            return $arr;
        }
    };
    //4.支持单条数据查询
    GLOBAL $getModel;
    $getModel = function ($sql) use($link){
        $result = mysqli_query($link,$sql);
        //echo mysqli_num_rows($result);
        if($result && mysqli_num_rows($result)>0){
            
            return mysqli_fetch_assoc($result);
        }else{
            
            return array();
        }
    };
    //5.支持统计条数的功能
    GLOBAL $totalModel;
    $totalModel = function($sql) use($link){
        $result =  mysqli_query($link,$sql);
        if($result && mysqli_num_rows($result)){
            
            return mysqli_num_rows($result);
        }else{
            
            return false;
        }
    };
}