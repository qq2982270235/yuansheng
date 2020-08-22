<?php
    //thumb('./phpjs4c.png','./thumb');
    /*
     * 作用：图片缩放函数
     * @param $imgUrl 图片地址
     * @param $path  = 图片保存路径 可选参数
     * @param $w 图片缩放宽度  可选参数
     * @param $h 图片缩放高度  可选参数
     * @param $pre 缩放图片的前缀  可选参数
     */
    function thumb($imgUrl,$path='./',$w = 100,$h = 100,$pre="s_"){
        //1.判断用户需要缩放的图片格式（）
        $suffix = ltrim(strrchr($imgUrl,'.'),'.');
        //var_dump($suffix);
        if($suffix == 'jpg'){
            $suffix = 'jpeg';
        }
        //2.jpg 则调用 jpeg函数   gif  调用 gif函数   png调用函数
        $funcStr = 'imagecreatefrom'.$suffix;

        //3.使用变量函数 调用对应打开图片的函数
        $imgSrc = $funcStr($imgUrl);
        //4. 获取原图的宽高
        $width = imagesx($imgSrc);
        $height = imagesy($imgSrc);
        $x = 0;
        $y = 0;
        //5.等比例缩放
        if($width < $height){
            $dh = $h;
            $dw = $width * ($h / $height);
            $x = ($w - $dw) / 2;
        }else{
            $dw = $w;
            $dh = $height * ($w /  $width);
            $y = ($h - $dh) / 2;
        }
        //6.创建画布
        $newImg = imagecreatetruecolor($w,$h);
        $back = imagecolorallocate($newImg,255,255,255);
        imagefill($newImg,0,0,$back);
        //7.拷贝图像
        imagecopyresampled($newImg,$imgSrc,$x,$y,0,0,$dw,$dh,$width,$height);
        //8.将缩略图保存到本地
        $img_func = 'image'.$suffix;
        //8.1需要判断要保存的目录是否存在 不存在则创建
        if(!file_exists($path)){
            //如果$path的目录不存在 则创建
            //mkdir（） 创建目录
            mkdir($path);
        }
        //8.2获取原图片名称
        $imgName = basename($imgUrl);

        //9.通过变量函数的方式 调用对应格式的保存图片函数
        $result = $img_func($newImg,$path.'/'.$pre.$imgName);
        //10.释放资源
        imagedestroy($imgSrc);
        imagedestroy($newImg);
        return $result;
    }


