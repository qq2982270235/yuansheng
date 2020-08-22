<?php
    function content(){
        function show(){
            mysqlModel();
            global $selectModel;
            $sql = "SELECT ew_article.*,ew_user.username as username,ew_category.name as name FROM ew_article,ew_user,ew_category WHERE ew_article.uid=ew_user.id AND ew_article.catid=ew_category.id";
            $arr = $selectModel($sql);
//            var_dump($arr);
            $status = array('审核中','<font color="green">审核通过</font>','<font color="#ccc">禁用</font>');
            include './view/content/index.html';
        }
        function add(){
            mysqlModel();
            global $getModel;
            global $selectModel;
            $sql = "SELECT * FROM ew_category ORDER BY CONCAT(path,id) ASC";
            $categorys = $selectModel($sql);
            $sql = "SELECT * FROM ew_user WHERE level != 2";
            $users = $selectModel($sql);
            include './view/content/add.html';
        }
        function do_add(){
//            var_dump($_POST);exit;
            if($_POST['catid'] == 'xz'){
                error('请选择文章类别','?m=content&a=add');
            }
            if($_POST['uid'] == 'xz'){
                $_POST['uid'] = 24;
            }
            if($_POST['allow'] == 'xz'){
                $_POST['allow'] = 0;
            }
            if($_POST['recomment'] == 'xz'){
                $_POST['recomment'] = 0;
            }
            if($_POST['audit'] == 'xz'){
                $_POST['audit'] = 0;
            }
            $time = time();
            $sql = "INSERT INTO ew_article(title,summary,addtime,content,comeform,keywords,recomment,allow,uid,catid,audit) VALUES('{$_POST['title']}','{$_POST['summary']}',{$time},'{$_POST['editorValue']}','{$_POST['comeform']}','{$_POST['keywords']}','{$_POST['recomment']}','{$_POST['allow']}','{$_POST['uid']}','{$_POST['catid']}','{$_POST['audit']}')";
            mysqlModel();
            global $dmlModel;
            if($dmlModel($sql)){
                success('添加成功','?m=content&a=show');
            }else{
                error('添加失败','?m=content&a=add');
            }
        }

        function editStatus(){
            $sql = "UPDATE ew_article SET audit = 1 WHERE id={$_GET['id']}";
            mysqlModel();
            global $dmlModel;
            if($dmlModel($sql)){
                success('审核通过','?m=content&a=show');
            }else{
                error('审核失败','?m=content&a=show');
            }
        }

        function doinsert(){
            $arr = pattern_article('http://www.cmstop.com/news/4.shtml');
            var_dump($arr);
            mysqlModel();
            global $dmlModel;
            foreach($arr['title'] as $k=>$v){
                $time = time();
//                $content = htmlspecialchars($arr['content'][$k]);
                $sql = "INSERT INTO ew_article(title,content,catid,uid,addtime,audit) VALUES('{$v}','{$arr['content'][$k]}',4,19,{$time},1)";
//                echo $sql;exit;
                $dmlModel($sql);
                sleep(0.5);
            }
        }

        function edit(){
//        var_dump($_GET);
            mysqlModel();
            global $getModel;
            global $selectModel;
            $sql = "SELECT ew_article.*,ew_user.username as username,ew_category.name as name FROM ew_article,ew_user,ew_category WHERE ew_article.uid=ew_user.id AND ew_article.catid=ew_category.id";
            $data=$getModel($sql);
            $sql = "SELECT * FROM ew_category ORDER BY CONCAT(path,id) ASC";
            $categorys = $selectModel($sql);
            $sql = "SELECT * FROM ew_user WHERE level != 2";
            $users = $selectModel($sql);
            include './view/content/edit.html';
        }
        function do_edit(){
//            var_dump($_POST);
            mysqlModel();
            global $dmlModel;
            global $getModel;
            if ($_POST['status']=='xz'){
                $_POST['status'] = 0;
            }
            $sql="UPDATE ew_article SET catid={$_POST['catid']},uid='{$_POST['uid']}',title='{$_POST['title']}',comeform='{$_POST['comeform']}',audit={$_POST['status']},content='{$_POST['editorValue']}' WHERE id={$_POST['id']}";
            $haha=$dmlModel($sql);
            if ($haha){
                success('修改成功','?m=content&a=show');
            }else{
                error('修改失败',"?m=content&a=edit&id={$_POST['id']}");
            }
        }
        function del(){
//            var_dump($_GET);
            mysqlModel();
            global $dmlModel;
            $sql="DELETE FROM ew_article WHERE id={$_GET['id']}";
            if ($dmlModel($sql)){
                success('删除成功','?m=content&a=show');
            }else{
                error('删除失败','?m=content&a=show');
            }
        }
    }