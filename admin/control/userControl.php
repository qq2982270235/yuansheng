<?php
    /******所有跟用户相关的操作*******/
    function user()
    {
        //显示用户列表
        function userList()
        {
            MySQLModel();
            global $selectModel;
            global $totalModel;
            /*分页处理*/
            $page = 2;
            $sql = "SELECT * FROM ew_user";
            $total = $totalModel($sql);
            $pageAll = ceil($total / $page);  
            $dpage = $_GET['page'] ?? 1;
            $prePage = $dpage - 1 < 1 ? 1 : ($dpage - 1);
            $nextPage = $dpage + 1 > $pageAll ? $pageAll : ($dpage + 1);
            $num = ($dpage - 1) * $page;
            $limit = " LIMIT {$num},{$page}";
            /*分页处理结束*/
            $sql = "SELECT * FROM ew_user ORDER BY id ASC {$limit}";
            $arr = $selectModel($sql);
            //定义权限数组
            $level = array('<font size="5" color="green">超级管理员</font>', '普通会员', '<font color="#ccc">禁用</font>');
            //定义性别数组
            $sex = array('女', '男', '保密');
//            var_dump($arr);
//            include './view/user/index.html';

            if (isset($_GET['select'])){
                //搜索的sql加分页
                $sql="SELECT * FROM ew_user WHERE username LIKE '%".$_GET['select']."%'{$limit}";
//                var_dump($sql);
                $arr=$selectModel($sql);
//                var_dump($arr);
            }else{

                echo '';
            }

            //定义倒序
//            var_dump($_GET);
            @$asc=$_GET['asc'];
            if (!empty($asc))
            {           //排序的sql加分页
                $sql="SELECT * FROM ew_user ORDER BY id DESC {$limit}";
                $selectModel($sql);
                $arr=($selectModel($sql));
            }else{
                echo '';
            }

            if (!empty($asc) && isset($_GET['select']))
            {       //搜索加倒序加分页的sql
                $sql="SELECT * FROM ew_user WHERE username LIKE '%".$_GET['select']."%' ORDER BY id DESC {$limit}";
                $selectModel($sql);
                $arr=($selectModel($sql));
//                var_dump($sql);
            }
            include './view/user/index.html';

        }

        //添加会员
        function userAdd()
        {
            include './view/user/add.html';
        }

        //执行添加会员方法
        function do_add()
        {
//            var_dump($_POST);
//            var_dump($_FILES);
            //1.判断两次密码是否正确
            if ($_POST['pwd'] != $_POST['repwd']) {
                error('两次密码不一致', '?m=user&a=userAdd');
            }
            if (empty($_POST['pwd'])) {
                error('密码不能为空', '?m=user&a=userAdd');
            }

            //2.判断是否选择权限 没选择默认普通会员
            if ($_POST['level'] == 'xz') {
                $_POST['level'] = 1;
            }
            //3.判断是否有头像上传
            if (!empty($_FILES['pic']['name'])) {
                $imgInfo = upload('pic', '../public/upload');
                //进行图片缩放
                thumb($imgInfo['pathinfo'], '../public/upload/thumb', 50, 50);
                //将上传图片名称保存到$_POST数组
//                var_dump($imgInfo);
                $_POST['pic'] = $imgInfo['name'];
            } else {
                $_POST['pic'] = 'a.jpg';
            }
            //4.执行数据库
            //密码加密
            $_POST['pwd'] = md5($_POST['pwd']);
            //注册时间
            $time = time();
            //注意：少一个处理 用户传过来的所有内容需要验证
            $sql = "INSERT INTO ew_user(username,pwd,name,age,sex,phone,pic,addtime,level) VALUES('{$_POST['username']}','{$_POST['pwd']}','{$_POST['name']}','{$_POST['age']}','{$_POST['sex']}','{$_POST['phone']}','{$_POST['pic']}',{$time},{$_POST['level']})";
            MySQLModel();

            global $dmlModel;
            if ($dmlModel($sql)) {
                success('添加成功', '?m=user&a=userlist');
            } else {
                error('添加失败', '?m=user&a=userAdd');
            }
//            var_dump($sql);
//            die;
        }

        //执行显示修改会员页面的功能
        function edit()
        {
            MySQLModel();
            //var_dump($_GET);
            global $getModel;
            $sql = "SELECT * FROM ew_user WHERE id=" . $_GET['id'];
            $data = $getModel($sql);
            //制作性别
            $woman = $man = $baomi = '';
            switch ($data['sex']) {
                case 0:
                    $woman = 'checked';
                    break;
                case 1:
                    $man = 'checked';
                    break;
                case 2:
                    $baomi = 'checked';
                    break;
            }
            //制作权限
            $cj = $pu = $jy = '';
            switch ($data['level']) {
                case 0:
                    $cj = 'selected';
                    break;
                case 1:
                    $pu = 'selected';
                    break;
                case 2:
                    $jy = 'selected';
                    break;
            }
            //var_dump($data);
            include './view/user/edit.html';
        }

        //执行修改操作
        function do_edit()
        {
            MySQLModel();
//            var_dump($_GET);
            //定义全局
            global $dmlModel;
            if (!empty($_POST['id'])) {//获取用户id
                $sql = "SELECT * FROM ew_user WHERE id=" . $_POST['id'];
//                var_dump($sql);die;
                global $getModel;
                $data = $getModel($sql);
//                var_dump(empty($_GET['id']));
                //执行sqlupdate student set name ='php' where id=4
                $username = $_POST['username'];
                $name = $_POST['name'];
                $age = $_POST['age'];
                $sex = $_POST['sex'];
                $phone = $_POST['phone'];
                $level = $_POST['level'];
                $username = $_POST['username'];
                if ($_POST['repwd'] == $_POST['pwd']) {
                    $password = $_POST['repwd'];
                } else {
                    $password = $_POST['password'];
                }
//                include '../config/config.php';
                $link = mysqli_connect(HOST, USER, PWD, DBNAME);

                $res = "UPDATE ew_user SET `username`='$username',`level`='$level',`age`='$age',`sex`='$sex',`phone`='$phone' WHERE id=" . $_POST['id'];//data1 data2为字段名 one two为值
//                    var_dump($res);die;
                if (mysqli_query($link, $res)) {
                    success('更新成功', '?m=user&a=userlist');
                } else {
                    error('更新失败', '?m=user&a=userlist');
                }
            } else {
                error('更新失败', '?m=user&a=userlist');
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
                $res = "DELETE FROM ew_user WHERE id=" . $_GET['id'];
                $dmlModel($res);
                success('删除成功', '?m=user&a=userlist');
            } else {
                error('删除失败', '?m=user&a=userAdd');
            }


        }


    }