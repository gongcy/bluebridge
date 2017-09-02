<?php
/**
 * Created by PhpStorm.
 * User: gongcy
 * Date: 2017/2/2 0002
 * Time: 8:42
 */
session_start();
header("Content-type:text/html;charset=utf-8");
if (!isset($_SESSION['administrator'])) {
    die("<h1>您没有权限查看此内容!</h1>");
}
?>
    <!doctype html>
    <html class="no-js fixed-layout">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>蓝桥训练系统后台管理</title>
        <meta name="description" content="Background Admin">
        <meta name="keywords" content="index">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="renderer" content="webkit">
        <meta http-equiv="Cache-Control" content="no-siteapp"/>
        <link rel="icon" type="image/png" href="../assets/i/favicon.png">
        <link rel="apple-touch-icon-precomposed" href="../assets/i/app-icon72x72@2x.png">
        <meta name="apple-mobile-web-app-title" content="Amaze UI"/>
        <link rel="stylesheet" href="../assets/css/amazeui.min.css"/>
        <link rel="stylesheet" href="../assets/css/admin.css">
    </head>
<body>
<!--[if lte IE 9]>
<p class="browsehappy">你正在使用<strong>过时</strong>的浏览器。 请 <a href="http://browsehappy.com/" target="_blank">升级浏览器</a>
    以获得更好的体验！</p>
<![endif]-->
<?php require_once "admin-header.php" ?>
<div class="am-cf admin-main">
    <!-- sidebar start -->
    <?php require_once "admin-sidebar.php" ?>
    <!-- sidebar end -->

    <!-- content start -->
    <div class="admin-content">
        <div class="admin-content-body">
            <div class="am-cf am-padding am-padding-bottom-0">
                <div class="am-fl am-cf">
                    <strong class="am-text-primary am-text-lg">添加填空题</strong> /
                    <small>Add fillblank problem</small>
                </div>
            </div>
            <hr>

            <div class="am-g">
                <div class="am-u-sm-12 am-u-md-4 am-u-md-push-8">
                </div>

                <div class="am-u-sm-12 am-u-md-8 am-u-md-pull-4">
                    <form class="am-form am-form-horizontal" method="post">
                        <div class="am-form-group">
                            <label for="problem-id" class="am-u-sm-3 am-form-label">题目编号</label>
                            <div class="am-u-sm-9">
                                自动生成
<!--                                <input name="id" type="text" id="problem-id" value="自动生成" readonly>-->
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="problem-title" class="am-u-sm-3 am-form-label">标题</label>
                            <div class="am-u-sm-9">
                                <input name="title" type="text" id="problem-title" placeholder="标题">
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="problem-des" class="am-u-sm-3 am-form-label">描述</label>
                            <div class="am-u-sm-9">
                                <textarea name="des" class="" rows="5" id="problem-des" placeholder="描述"></textarea>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="problem-ans" class="am-u-sm-3 am-form-label">答案</label>
                            <div class="am-u-sm-9">
                                <input name="ans" type="text" id="problem-ans" placeholder="正确答案">
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="problem-hint" class="am-u-sm-3 am-form-label">提示</label>
                            <div class="am-u-sm-9">
                                <textarea name="hint" class="" rows="5" id="problem-hint" placeholder="提示"></textarea>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <div class="am-u-sm-9 am-u-sm-push-3">
                                <input type="submit" value="保存修改" class="am-btn am-btn-primary"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    if(isset($_POST)) {
        $mData['title'] = $_POST['title'];
        $mData['description'] = $_POST['des'];
        $mData['solution'] = $_POST['ans'];
        $mData['hint'] = $_POST['hint'];
        require_once "../DBCN.php";
        $db = new DB();
        $flag = $db->insert("problem_fillblank",$mData, true);
        if ($flag) {
            print ("<script>alert('保存成功');</script>");
        }
    }
?>


<a href="#" class="am-icon-btn am-icon-th-list am-show-sm-only admin-menu"
   data-am-offcanvas="{target: '#admin-offcanvas'}"></a>

<!--[if lt IE 9]>
<script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>
<script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
<script src="../assets/js/amazeui.ie8polyfill.min.js"></script>
<![endif]-->

<!--[if (gte IE 9)|!(IE)]><!-->
<script src="../assets/js/jquery.min.js"></script>
<!--<![endif]-->
<script src="../assets/js/amazeui.min.js"></script>
<script src="../assets/js/app.js"></script>
</body>
</html>
