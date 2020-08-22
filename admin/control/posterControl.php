<?php
    function poster(){
        function show(){
            $sql = "SELECT * FROM ew_poster";
            mysqlModel();
            global $selectModel;
            $arr = $selectModel($sql);
            $status = array('审核中','<font color="green">审核通过</font>','<font color="#ccc">禁用</font>');
            $position = array('一号广告位','二号广告位','三号广告位','四号广告位','五号广告位','六号广告位','七号广告位','八号广告位','九号广告位','十号广告位');
//            var_dump($position);die;
            include './view/poster/index.html';
        }
        function add(){
            include './view/poster/add.html';
        }
        function do_add(){
//            var_dump($_POST);
//            var_dump($_FILES);
            if($_POST['position'] == 'xz'){
                error('请选择广告位','?m=poster&a=add');
            }
            //1判断是否上传图片
            if(empty($_FILES['pimg']['name'])){
                //没有传图片
                error('请上传图片','?m=poster&a=add');
            }else{
                //图片处理
                $imginfo = upload('pimg','../public/upload');
                if(is_array($imginfo)){
                    thumb($imginfo['pathinfo'],'../public/upload/thumb',50,50);
                    $_POST['pimg'] = $imginfo['name'];
                }else{
                    //var_dump($imginfo);
                    error($imginfo,'?m=poster&a=add');
                }
            }
            if($_POST['status'] == 'xz'){
                $_POST['status'] = 0;
            }
            $sql = "INSERT INTO ew_poster(pimg,position,title,content,status,url) VALUES('{$_POST['pimg']}','{$_POST['position']}','{$_POST['title']}','{$_POST['content']}','{$_POST['status']}','{$_POST['url']}')";
            mysqlModel();
            global $dmlModel;
            if($dmlModel($sql)){
                success('添加成功','?m=poster&a=show');
            }else{
                error('添加失败','?m=poster&a=add');
            }
        }
        function editStatus(){
            $sql = "UPDATE ew_poster SET status = 1 WHERE id={$_GET['id']}";
            mysqlModel();
            global $dmlModel;
            if($dmlModel($sql)){
                success('成功','?m=poster&a=show');
            }else{
                error('失败','?m=poster&a=show');
            }
        }

        function del()
        {
            //使用数据库
            MySQLModel();
//            var_dump($_GET);
            //定义全局
            global $dmlModel;
            //判断
            if (!empty($_GET['id'])) {
//                var_dump(empty($_GET['id']));
                //执行sql
                $res = "DELETE FROM ew_poster WHERE id=" . $_GET['id'];
                $dmlModel($res);
                success('删除成功', '?m=poster&a=show');
            } else {
                error('删除失败','?m=poster&a=show');
            }

        }

        function edit(){
//            var_dump($_POST);die;
            mysqlModel();
            global $getModel;
            $sql="SELECT * FROM ew_poster WHERE id={$_GET['id']}";
            $arr1=$getModel($sql);
//            var_dump($arr1);
//        var_dump($arr1);
            include './view/poster/edit.html';
        }


        //执行修改页面
        function do_edit(){
            //1判断是否上传图片
            if(empty($_FILES['pimg']['name'])){
                //没有传图片
                error('请上传图片','?m=poster&a=add');
            }else{
                //图片处理
                $imginfo = upload('pimg','../public/upload');
                if(is_array($imginfo)){
                    thumb($imginfo['pathinfo'],'../public/upload/thumb',50,50);
                    $_POST['pimg'] = $imginfo['name'];
                }else{
                    //var_dump($imginfo);
                    error($imginfo,'?m=poster&a=add');
                }
            }
            if($_POST['status'] == 'xz'){
                $_POST['status'] = 0;
            }

//            var_dump($_POST);die;
            $sql="UPDATE ew_poster SET title='{$_POST['title']}',pimg='{$_POST['pimg']}',content='{$_POST['content']}',position='{$_POST['position']}',status='{$_POST['status']}',url='{$_POST['url']}' WHERE id={$_POST['id']}";
            var_dump($sql);
            mysqlModel();
            global $dmlModel;
            if ($dmlModel($sql)){
                success('修改成功','?m=poster&a=show');
            }else{
                error('修改失败',"?m=poster&a=add&id={$_POST['id']}");
            }
        }
//        function edit(){
//            var_dump($_POST);
////            $sql  = "UPDATE ew_poster SET pimg='{$_POST['pimg']}',url='{$_POST['url']}',position='{$_POST['position']}',title='{$_POST['title']}',content='{$_POST['content']}',status='{$_POST['status']}' WHERE id={$_POST['id']}";
////            mysqlModel();
////            global $dmlModel;
////            if($dmlModel($sql)){
////                success('修改成功','?m=poster&a=show');
////            }else{
////                error('修改失败','?m=poster&a=edit&id='.$_POST['id']);
////            }
//        }

    }