<?php
    function mylist(){
        function show(){

            mysqlModel();
            global $selectModel;
            global $getModel;
            global $totalModel;
            //广告
            //分类遍历
            $sql = "SELECT * FROM ew_category";
            $types = $selectModel($sql);
            $childTypes = $types;
            //友情链接
            $sql = "SELECT * FROM ew_link WHERE status=1 ORDER BY ord DESC,id DESC";
            $arr = $selectModel($sql);

            //二号广告位
            $sql = "SELECT * FROM ew_poster WHERE position = 1 AND status=1 ORDER BY id DESC LIMIT 4";
            $positionTwo = $getModel($sql);
//            var_dump($positionTwo);

            // $sql = "SELECT * FROM ew_article WHERE catid or catid IN(SELECT id FROM ew_category WHERE pid={$_GET['id']})";
            // 
            // 
            // 
             /*分页处理*/
            $page = 5;
            $sql = "SELECT ew_article FROM  keywords='{$_GET['id']}'";
//            var_dump($sql);die;
            $total = $totalModel($sql);
            $pageAll = ceil($total / $page);  
            $dpage = $_GET['page'] ?? 1;
            $prePage = $dpage - 1 < 1 ? 1 : ($dpage - 1);
            $nextPage = $dpage + 1 > $pageAll ? $pageAll : ($dpage + 1);
            $num = ($dpage - 1) * $page;
            $limit = " LIMIT {$num},{$page}";
            /*分页处理结束*/
            $sql = "SELECT * FROM ew_article  WHERE catid={$_GET['id']} {$limit}";
            // var_dump($sql);die;
            $articles = $selectModel($sql);
//            var_dump($articles);
            include './view/list.html';


        }


        function wenzhang(){

            mysqlModel();
            global $selectModel;
            global $getModel;
            global $totalModel;
            //广告
            //分类遍历
            
            $sql = "SELECT * FROM ew_category";
            $types = $selectModel($sql);
            $childTypes = $types;
            //友情链接
            $sql = "SELECT * FROM ew_link WHERE status=1 ORDER BY ord DESC,id DESC";
            $arr = $selectModel($sql);

            //二号广告位
            $sql = "SELECT * FROM ew_poster WHERE position = 1 AND status=1 ORDER BY id DESC LIMIT 4";
            $positionTwo = $getModel($sql);
//            var_dump($positionTwo);

            $sql = "SELECT * FROM ew_article WHERE catid or catid IN(SELECT id FROM ew_category WHERE pid={$_GET['id']})";
//            var_dump($sql);die;
            $articles = $selectModel($sql);

//            var_dump($articles);
//            
//            //二号广告位
//            
             /*分页处理*/
            $page = 5;
            $sql = "SELECT * FROM ew_pinlun WHERE pid={$_GET['id']}";
            $total = $totalModel($sql);
            $pageAll = ceil($total / $page);  
            $dpage = $_GET['page'] ?? 1;
            $prePage = $dpage - 1 < 1 ? 1 : ($dpage - 1);
            $nextPage = $dpage + 1 > $pageAll ? $pageAll : ($dpage + 1);
            $num = ($dpage - 1) * $page;
            $limit = " LIMIT {$num},{$page}";
            /*分页处理结束*/
            $sql = "SELECT * FROM ew_pinlun WHERE pid = {$_GET['id']} ORDER BY id DESC  {$limit}";
            $pinlun = $selectModel($sql);
           //var_dump($pinlun);
            include './view/wenzhang.html';


        }

         function pinlun(){
             var_dump($_POST);
              $createtime = date("Y-m-d H:i:s",time());
              $id=$_GET['id'];
            $sql = "INSERT INTO ew_pinlun(pid,content,createtime) VALUES('{$id}','{$_POST['pinglun']}','{$createtime}')";
            mysqlModel();
            global $dmlModel;
            if($dmlModel($sql)){
                success('评论成功','?m=mylist&a=wenzhang&id='.$id);
            }else{
                error('评论失败','?m=mylist&a=wenzhang&id='.$id);
            }
        }




    }