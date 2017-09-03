<?php
/**
 * Created by PhpStorm.
 * User: gongcy
 * Date: 2017/2/2 0002
 * Time: 8:45
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
                    <strong class="am-text-primary am-text-lg">添加比赛</strong> /
                    <small>Add contest</small>
                </div>
            </div>
            <hr>

            <div class="am-g">
                <div class="am-u-sm-12 am-u-md-4 am-u-md-push-8">
                </div>

                <div class="am-u-sm-12 am-u-md-8 am-u-md-pull-4">

                    <form class="am-form am-form-horizontal" method="post" role="form">
                        <div class="am-form-group">
                            <label for="problem-id" class="am-u-sm-3 am-form-label">比赛编号</label>
                            <div class="am-u-sm-9">
                                自动生成
                                <!--                                <input name="id" type="text" id="problem-id" value="自动生成" readonly>-->
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="contest-title" class="am-u-sm-3 am-form-label">标题</label>
                            <div class="am-u-sm-9">
                                <input name="title" type="text" id="contest-title" placeholder="标题">
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="contest-des" class="am-u-sm-3 am-form-label">描述</label>
                            <div class="am-u-sm-9">
                                <textarea name="des" class="" rows="5" id="contest-des" placeholder="描述"></textarea>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="contest-st" class="am-u-sm-3 am-form-label">开始时间</label>
                            <div class="am-u-sm-9">
                                <div class="am-form-group am-form-icon">
                                    <i class="am-icon-calendar"></i>
                                    <input name="start_time" type="datetime-local" class="am-form-field am-input-sm"
                                           placeholder="开始时间">
                                </div>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="contest-et" class="am-u-sm-3 am-form-label">结束时间</label>
                            <div class="am-u-sm-9">
                                <div class="am-form-group am-form-icon">
                                    <i class="am-icon-calendar"></i>
                                    <input name="end_time" type="datetime-local" class="am-form-field am-input-sm"
                                           placeholder="结束时间">
                                </div>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="contest-lang" class="am-u-sm-3 am-form-label">比赛语言</label>
                            <div class="am-u-sm-9">
                                <label class="am-radio-inline">
                                    <input type="radio" name="lang" value="0" data-am-ucheck> C/C++
                                </label>
                                <label class="am-radio-inline">
                                    <input type="radio" name="lang" value="1" data-am-ucheck> Java
                                </label>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="contest-pwd" class="am-u-sm-3 am-form-label">密码</label>
                            <div class="am-u-sm-9">
                                <input name="pwd" type="text" class="" placeholder="密码(可不填)"/>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="problem_list" class="am-u-sm-3 am-form-label">题目列表</label>
                            <div class="am-u-sm-9">
                                <textarea name="list" class="" rows="5" id="problem_list"
                                          placeholder="题目类型，题目编号，分值；题目类型，题目编号，分值；..."></textarea>
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
if (isset($_POST)) {
    $mData['title'] = $_POST['title'];
    $mData['description'] = $_POST['des'];
    $mData['start_time'] = $_POST['start_time'];
    $mData['end_time'] = $_POST['end_time'];
    $mData['lang'] = $_POST['lang'];
    $mData['password'] = $_POST['pwd'];
    require_once "../DBCN.php";
    $db = new DB();
    $ret1 = $db->insert("contest_blue", $mData, true);

    $mData1['contest_id'] = $ret1;

    $list = trim($_POST['list']);
    $pro_array = explode(";", $list);
    foreach ($pro_array as $key => $value) {
        $mData1['num'] = $key + 1;
        $per_attr = explode(",", $value);
        $mData1['type'] = $per_attr[0];
        $mData1['problem_id'] = $per_attr[1];
        $mData1['score'] = $per_attr[2];
        $ret2 = $db->insert("contest_blue_problem", $mData1, true);
    }

    if ($ret1) {
        print ("<script>alert('保存成功');</script>");
    }
}
?>


<a href="#" class="am-icon-btn am-icon-th-list am-show-sm-only admin-menu"
   data-am-offcanvas="{target: '#admin-offcanvas'}"></a>

<script type="text/javascript">
    function addpro() {
        $("#mdiv").append('<div class="iptdiv" ><input type="file" name="img[]" class="ipt" /><a href="#" name="rmlink">X</a></div>');
    }
</script>

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