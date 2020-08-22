<?php
    function category(){
        function show(){
            mysqlModel();
            global $selectModel;
            $sql = "SELECT * FROM ew_category ORDER BY CONCAT(path,id) ASC";
            $arr = $selectModel($sql);
            include './view/category/index.html';
        }
        function add(){
            mysqlModel();
            global $selectModel;
            $sql = "SELECT * FROM ew_category ORDER BY CONCAT(path,id) ASC";
            $arr = $selectModel($sql);
//            var_dump($arr);
            include './view/category/add.html';
        }
        function do_add(){
//            var_dump($_POST);
            if($_POST['str'] == 'xz'){
                $pid = 0;
                $path = '0,';
                //添加顶级栏目
            }else{
                //添加子栏目 1
                $pid = ltrim(strrchr($_POST['str'],','),',');
                $path = $_POST['str'].',';
            }
//            echo $pid.'<br/>'.$path.'<hr/>';

            $sql = "INSERT INTO ew_category(name,description,pid,path) VALUES('{$_POST['name']}','{$_POST['description']}',{$pid},'{$path}')";
//           echo $sql;
//           var_dump($_POST);
//           EXIT;
            mysqlModel();
            global $dmlModel;
            if($dmlModel($sql)){
                success('添加成功','?m=category&a=show');
            }else{
                error('添加失败','?m=category&a=add');
            }
        }
        function edit(){
            mysqlModel();
            global $getModel;
            global $selectModel;
            $sql = "SELECT * FROM ew_category ORDER BY CONCAT(path,id) ASC";
            $arr = $selectModel($sql);
            $sql = "SELECT * FROM ew_category WHERE id={$_GET['id']}";
            $data = $getModel($sql);
            //var_dump($data);
            include './view/category/edit.html';
        }
        function do_edit(){
            var_dump($_POST);

            //1.判断顶级类是否移动
            if($_POST['pid'] == 0){
                if($_POST['str'] != 'xz'){
                    error('不能移动顶级类','?m=category&a=edit&id='.$_POST['id']);
                }
            }
            if($_POST['str'] != 'xz'){
                $pid = ltrim(strrchr($_POST['str'],','),',');
                $path = $_POST['str'].',';
            }else{
                $pid = 0;
                $path = '0,';
            }

            $sql = "UPDATE ew_category SET name='{$_POST['name']}',description='{$_POST['description']}',pid={$pid},path='{$path}' WHERE id={$_POST['id']}";
            mysqlModel();
            global $dmlModel;
            if($dmlModel($sql)){
                success('修改成功','?m=category&a=show');
            }else{
                error('修改失败','?m=category&a=edit&id='.$_POST['id']);
            }
        }
    }