<?php

    function keywords()
    {
        global $selectModel;
        $sql = "SELECT keywords FROM ew_article";
        $keys = $selectModel($sql);
//        var_dump($keys);
        //处理关键字
        $arr = array();
        foreach ($keys as $v){
            if (!empty($v['keywords'])){
                $arr[] = strtoupper($v['keywords']);

            }
        }
        $str = implode(',',$arr);
        $newArr = explode(',',$str);
        return array_unique($newArr);
//             var_dump($newArr);
    }