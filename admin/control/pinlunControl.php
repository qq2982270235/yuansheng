<?php
    //做网站配置相关的功能
    function pinlun(){
        //显示表单函数
        function lists(){
            MySQLModel();
            global $selectModel;
            global $totalModel;
            /*分页处理*/
            $page = 10;
            $sql = "SELECT * FROM ew_pinlun";
            $total = $totalModel($sql);
            $pageAll = ceil($total / $page);  
            $dpage = $_GET['page'] ?? 1;
            $prePage = $dpage - 1 < 1 ? 1 : ($dpage - 1);
            $nextPage = $dpage + 1 > $pageAll ? $pageAll : ($dpage + 1);
            $num = ($dpage - 1) * $page;
            $limit = " LIMIT {$num},{$page}";
            /*分页处理结束*/
            $sql = "SELECT * FROM ew_pinlun ORDER BY id ASC {$limit}";
            $arr = $selectModel($sql);
            

            if (isset($_GET['select'])){
                //搜索的sql加分页
                $sql="SELECT * FROM ew_pinlun WHERE content LIKE '%".$_GET['select']."%'{$limit}";
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
                $sql="SELECT * FROM ew_pinlun ORDER BY id DESC {$limit}";
                $selectModel($sql);
                $arr=($selectModel($sql));
            }else{
                echo '';
            }

            if (!empty($asc) && isset($_GET['select']))
            {       //搜索加倒序加分页的sql
                $sql="SELECT * FROM ew_pinlun WHERE content LIKE '%".$_GET['select']."%' ORDER BY id DESC {$limit}";
                $selectModel($sql);
                $arr=($selectModel($sql));
//                var_dump($sql);
            }
            include './view/pinlun/lists.html';
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
                $res = "DELETE FROM ew_pinlun WHERE id=" . $_GET['id'];
                $dmlModel($res);
                success('删除成功', '?m=pinlun&a=lists');
            } else {
                error('删除失败', '?m=pinlun&a=lists');
            }


        }
       
    }