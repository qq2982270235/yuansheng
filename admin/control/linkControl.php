<?php
    //处理友情链接相关的功能
    function mylink(){
        /*
         * 显示添加友情链接页面
         */
        function add(){
            include './view/link/add.html';
        }
        /*
         * 搜索
         */
        function search(){
            $where = array();
            $url = array();
            if(isset($_GET['webname']) && !empty($_GET['webname'])){
                $where[] = "webname LIKE '%{$_GET['webname']}%'";
                //$sql = "SELECT * FROM ew_link WHERE webname LIKE '%a%'";
                $url[] = "&webname={$_GET['webname']}";
            }
            if(isset($_GET['status']) && $_GET['status']!='xz'){
                $where[] = "status={$_GET['status']}";
                $url[] = "&status={$_GET['status']}";
            }
           if(isset($_GET['addtime']) && $_GET['addtime']!='xz'){
               $time = time();
               $startime = strtotime($_GET['addtime']);
               $where[] = "addtime BETWEEN {$startime} AND {$time}";
               $url[] = "&addtime={$_GET['addtime']}";
           }
           $arr = array();
           $arr['where'] = $where;
           $arr['url'] = $url;
           return $arr;
        }
        /*
         * 友情链接列表
         */
        function show(){
            $search = search();
//            Var_dump($search);
            mysqlModel();
            //判断是否有搜索
            if(count($search['where'])>0){
                //有搜
                $where = ' WHERE '.implode(' AND ',$search['where']);
//                echo $where.'<br/>';
                //拼接url
                $url = implode($search['url']);
//                echo $url;
            }else{
                //没有
                $where = '';
                $url = '';
            }
            global $selectModel;
            global $totalModel;
            //WHERE title LIKE '%a%' AND status=1 AND addtime BETWEEN 1天前时间 AND 现在时间
            $sql = "SELECT * FROM ew_link {$where}";
            $total = $totalModel($sql);
            $page = 3;
            $pageAll = ceil($total / $page);
            $dpage = $_GET['page']??1;
            $prePage = $dpage - 1 < 1 ? 1 :($dpage -1);
            $nextPage = $dpage + 1 > $pageAll ? $pageAll : ($dpage + 1);
            $num = ($dpage - 1) * $page;
            $limit = " LIMIT {$num},$page";
            $sql = "SELECT * FROM ew_link {$where} ORDER BY ord DESC,id DESC {$limit}";

            $status = array('审核中','<font color="green">审核通过</font>','<font color="#ccc">禁用</font>');
            $arr = $selectModel($sql);
            include './view/link/index.html';
        }
        /*
         * 处理添加友情链接
         */
        function do_add(){
            //判断状态
            if($_POST['status'] == 'xz'){
                $_POST['status'] = 0;
            }
            $time = time();
            $sql = "INSERT INTO ew_link(webname,url,lname,lemail,status,ord,addtime) VALUES('{$_POST['webname']}','{$_POST['url']}','{$_POST['lname']}','{$_POST['lemail']}','{$_POST['status']}','{$_POST['ord']}',{$time})";
            mysqlModel();
            global $dmlModel;
            if($dmlModel($sql)){
                success('添加成功','?m=mylink&a=show');
            }else{
                error('添加失败','?m=mylink&a=add');
            }
        }
        /*
         * 执行修改状态操作
         */
        function editStatus(){
//            var_dump($_GET);
            $sql = "UPDATE ew_link SET status=1 WHERE id=".$_GET['id'];
            mysqlModel();
            global $dmlModel;
            if($dmlModel($sql)){
                success('审核通过','?m=mylink&a=show');
            }else{
                error('审核失败','?m=mylink&a=show');
            }
        }
        /*
         * 执行删除操作
         */
        function del(){
            if(isset($_GET['id']) && is_numeric($_GET['id'])){
                $sql = "DELETE FROM ew_link WHERE id={$_GET['id']}";
                mysqlModel();
                global $dmlModel;
                if($dmlModel($sql)){
                    success('删除成功','?m=mylink&a=show');
                }else{
                    error('删除失败','?m=mylink&a=show');
                }
            }else{
                error('请传入正确的编号','m=mylink&a=show');
            }
        }
        /*
         * 修改友情链接
         */
        function edit(){
            if(isset($_GET['id']) && is_numeric($_GET['id'])){
                $sql = "SELECT * FROM ew_link WHERE id={$_GET['id']}";
                mysqlModel();
                global $getModel;
                $data = $getModel($sql);
                $sh = $tg = $jy = '';
                switch($data['status']){
                    case 0:
                        $sh = 'selected';
                        break;
                    case 1:
                        $tg = 'selected';
                        break;
                    case 2:
                        $jy = 'selected';
                        break;
                }
//                var_dump($data);
            }else{
                error('请传入正确的编号','m=mylink&a=show');
            }
            include './view/link/edit.html';
        }
        /*
         * 执行修改操作
         */
        function do_edit(){
//            var_dump($_POST);
            $sql  = "UPDATE ew_link SET webname='{$_POST['webname']}',url='{$_POST['url']}',lname='{$_POST['lname']}',lemail='{$_POST['lemail']}',ord='{$_POST['ord']}',status='{$_POST['status']}' WHERE id={$_POST['id']}";
            mysqlModel();
            global $dmlModel;
            if($dmlModel($sql)){
                success('修改成功','?m=mylink&a=show');
            }else{
                error('修改失败','?m=mylink&a=edit&id='.$_POST['id']);
            }
        }



        function del_shan()
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
                $res = "DELETE FROM ew_link WHERE id=" . $_GET['id'];
                $dmlModel($res);
                success('修改成功','?m=mylink&a=show');
            } else {
                error('删除失败','?m=mylink&a=show');
            }

        }

//        function edit(){
//            mysqlModel();
//            global $getModel;
//            $sql="SELECT * FROM ew_link WHERE id={$_GET['id']}";
//            $arr1=$getModel($sql);
////        var_dump($arr1);
//            include './view/link/add.html';
//        }
//        //执行修改页面
//        function do_edit(){
//            var_dump($_POST);
//            $sql="UPDATE ew_link SET webname='{$_POST['webname']}',url='{$_POST['url']}',lname='{$_POST['lname']}',lemail='{$_POST['lemail']}',status='{$_POST['status']}',ord='{$_POST['ord']}' WHERE id={$_POST['id']}";
//            var_dump($sql);
//            mysqlModel();
//            global $dmlModel;
//            if ($dmlModel($sql)){
//                success('修改成功','?m=mylink&a=show');
//            }else{
//                error('修改失败',"?m=mylink&a=add&id={$_POST['id']}");
//            }
//        }

//        //执行修改操作
//        function do_edit()
//        {
//            MySQLModel();
////            var_dump($_GET);
//            //定义全局
//            global $dmlModel;
//            if (!empty($_POST['id'])) {//获取用户id
//                $sql = "SELECT * FROM ew_link WHERE id=" . $_POST['id'];
////                var_dump($sql);die;
//                global $getModel;
//                $data = $getModel($sql);
////                var_dump(empty($_GET['id']));
//                //执行sqlupdate student set name ='php' where id=4
//                $webname = $_POST['webname'];
//                $url = $_POST['url'];
//                $lname = $_POST['lname'];
//                $lemail = $_POST['lemail'];
//                $addtime = $_POST['addtime'];
//                $status = $_POST['status'];
//                $ord = $_POST['ord'];
//                if ($_POST['repwd'] == $_POST['pwd']) {
//                    $password = $_POST['repwd'];
//                } else {
//                    $password = $_POST['password'];
//                }
////                include '../config/config.php';
//                $link = mysqli_connect(HOST, USER, PWD, DBNAME);
//
//                $res = "UPDATE ew_user SET `username`='$username',`level`='$level',`age`='$age',`sex`='$sex',`phone`='$phone' WHERE id=" . $_POST['id'];//data1 data2为字段名 one two为值
////                    var_dump($res);die;
//                if (mysqli_query($link, $res)) {
//                    success('更新成功', '?m=user&a=userlist');
//                } else {
//                    error('更新失败', '?m=user&a=userlist');
//                }
//            } else {
//                error('更新失败', '?m=user&a=userlist');
//            }
//
//        }
    }