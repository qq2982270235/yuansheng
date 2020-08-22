<?php
    //调用正确函数
    function success($str = '成功',$path){
        echo '<script>alert("'.$str.'");location="'.$path.'"</script>';
        die();
    }
    //调用错误函数
    function error($str = '错误',$path){
        echo '<script>alert("'.$str.'");location="'.$path.'"</script>';
        die();
    }