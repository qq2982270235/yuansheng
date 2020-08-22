<?php
    //做网站配置相关的功能
    function sys(){
        //显示表单函数
        function info(){
            //包含网站配置文件
            include '../config/sysConfig.php';
            include './view/sysAdd.html';
        }
        function yejiaoya(){
            //包含网站配置文件
            include '../config/sysConfig.php';
            include './view/bottom.html';
        }
        //执行添加网站配置的函数
        function do_add(){
            //1.判断是否有logo上传 如果有 需要调用上传文件函数
            if(!empty($_FILES['logo']['name'])){
                //调用文件上传函数
                include './org/upload_func.php';
                include './org/thumb_func.php';
                $result = upload('logo','../public/logo');
                if(is_array($result)){
                    //文件上传成功
                    $_POST['logo'] = $result['name'];
                    //缩放图片
                    thumb($result['pathinfo'],'../public/logo/thumb',$w = 50,$h = 50,$pre="s_");
                }
            }
            //2.循环准备替换每条配置的正则表达式
            foreach($_POST as $k=>$v){
                $search[] = '/define\(\''.strtoupper($k).'\',\'(.*?)\'\)/S';

                $place[] = 'define(\''.strtoupper($k).'\',\''.$v.'\')';

            }
            //3.读取配置文件
            $config = file_get_contents('../config/sysConfig.php');
            //4.进行匹配替换
            $config = preg_replace($search,$place,$config);
            //5.写入文件保存
            if(file_put_contents('../config/sysConfig.php',$config)){
                echo '<script>alert("保存成功");location="?m=sys&a=info"</script>';
            }else{
                echo '<script>alert("保存失败");location="?m=sys&a=info"</script>';
            }
        }
    }