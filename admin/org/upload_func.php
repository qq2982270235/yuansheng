<?php
    //var_dump($_FILES);
    //文件上传函数
//    $result = upload('pic');
//    var_dump($result);
    function upload($pic,$path='./upload',$size=5000000,$type=array('image/jpeg','image/png','image/gif')){
        $file = $_FILES[$pic];
        //var_dump($file);
        //1.判断上传的错误号
        if($file['error'] > 0){
            switch($file['error']){
                case 1:
                    return '超过了php.ini配置文件中upload_max_filesize设置的值';
                    break;
                case 2:
                    return '超过了HTML标签中设置的MAX_FILE_SIZE设置的值';
                    break;
                case 3:
                    return '文件只有部分被上传';
                    break;
                case 4:
                    return '没有文件上传';
                    break;
                case 6:
                    return '找不到临时目录';
                    break;
                case 7:
                    return '写入失败';
                    break;
            }
        }
        //2.判断上传文件的大小
        if($file['size'] >  $size){
            return '上传文件过大';
        }
        //3.判断上传文件的类型
        if(!in_array($file['type'],$type)){
            return '上传文件类型不合法';
        }
        //4.制作新的上传名称
            //5.制作保存图片的路径
            if(!file_exists($path)){
                mkdir($path);
            }
            //5.1处理路径中最后的斜线
            $path = rtrim($path,'/').'/';
        //4.1获取原来的后缀
        $suffix = strrchr($file['name'],'.');
        do {
            $newName = md5(time() . mt_rand() . uniqid()) . $suffix;
        }while(file_exists($path.$newName));

        //echo $path.$newName;
        //6.移动文件
        if(move_uploaded_file($file['tmp_name'],$path.$newName)){
            $pathInfo['pathinfo'] = $path.$newName;
            $pathInfo['name'] = $newName;
            $pathInfo['path'] = $path;
            return $pathInfo;
        }else{
            return '错误，请从新上传';
        }
    }