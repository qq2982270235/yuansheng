<?php
    /*
     * 显示前台首页
     * */
    function index(){

        function show(){
            mysqlModel();

            keywords();
            $keywords = keywords();
//            var_dump($keywords);
//            include '../config/sysConfig.php';
            //查询网站底部的友情链接
            $sql = "SELECT * FROM ew_link WHERE status=1 ORDER BY ord DESC,id DESC";

            global $selectModel;

            $arr = $selectModel($sql);

            //一号广告位
            $sql = "SELECT * FROM ew_poster WHERE position = 0 AND status=1 ORDER BY id DESC LIMIT 4";
            $positionOne = $selectModel($sql);

            //二号广告位
            $sql = 'SELECT * FROM ew_poster WHERE position = 1 AND status=1 ORDER BY id DESC LIMIT 1';
            global $getModel;
            $positionTwo = $getModel($sql);

            //三号广告位
            $sql = 'SELECT * FROM ew_poster WHERE position = 2 AND status=1 ORDER BY id DESC LIMIT 1';
            global $getModel;
            $positionThree = $getModel($sql);

            //四号广告位
            $sql = 'SELECT * FROM ew_poster WHERE position = 3 AND status=1 ORDER BY id DESC LIMIT 1';
            global $getModel;
            $positionFour = $getModel($sql);
            //var_DUMP($positionTwo);
            //var_dump($positionOne);
            //
             //5号广告位
            $sql = "SELECT * FROM ew_poster WHERE position = 5 AND status=1 ORDER BY id DESC LIMIT 8";
            $position5 = $selectModel($sql);

              //6号广告位
            $sql = "SELECT * FROM ew_poster WHERE position = 6 AND status=1 ORDER BY id DESC LIMIT 4";
            $position6 = $selectModel($sql);



            //分类遍历
            $sql = 'SELECT * FROM ew_category';

            $types = $selectModel($sql);
//            var_dump($types);die;
//            
//            
//          技术分享 
            $sql = "SELECT * FROM ew_article WHERE catid=7 ORDER BY id DESC";
           
            global $selectModel;
            $jsfx = $selectModel($sql);
             // 行业资讯
            $sql = "SELECT * FROM ew_article WHERE catid=16 ORDER BY id DESC";
            global $selectModel;
            $hyzx = $selectModel($sql);

            $sql = "SELECT * FROM ew_article WHERE catid=9 ORDER BY id DESC";
            global $selectModel;
            $art9 = $selectModel($sql);
             $sql = "SELECT * FROM ew_article WHERE catid=8 ORDER BY id DESC";
            global $selectModel;
            $art8 = $selectModel($sql);
             $sql = "SELECT * FROM ew_article WHERE catid=17 ORDER BY id DESC";
            global $selectModel;
            $art17 = $selectModel($sql);

            $sql = "SELECT * FROM ew_article WHERE catid=11 ORDER BY id DESC";
            global $selectModel;
            $art11 = $selectModel($sql);
             $sql = "SELECT * FROM ew_article WHERE catid=12 ORDER BY id DESC";
            global $selectModel;

            $art12 = $selectModel($sql);
             $sql = "SELECT * FROM ew_article WHERE catid=13 ORDER BY id DESC";
            global $selectModel;
            $art13 = $selectModel($sql);

            $sql = "SELECT * FROM ew_article WHERE catid=12 ORDER BY id DESC";
            global $selectModel;
            $art14 = $selectModel($sql);




            $childTypes = $types;
            include './view/index.html';
        }

         function search(){
            mysqlModel();
            global $selectModel;
            global $getModel;
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
            $key=$_GET['key'];
            $sql = "SELECT * FROM ew_article WHERE title Like '%".$key."%'";
//            var_dump($sql);die;
            $articles = $selectModel($sql);
             include './view/search.html';
         }
    }