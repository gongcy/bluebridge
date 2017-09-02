<!--
 * Created by PhpStorm.
 * User: gongcy
 * Date: 16-11-1
 * Time: 下午9:30
-->
<html>
<head>
    <meta charset="UTF-8">
    <title>蓝桥训练系统</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <link rel="alternate icon" type="image/png" href="assets/i/favicon.png">
    <link rel="stylesheet" href="assets/css/amazeui.min.css"/>
    <link rel="stylesheet" href="assets/highlight/styles/default.css">
    <script src="assets/highlight/highlight.pack.js"></script>
    <script>hljs.initHighlightingOnLoad();</script>
</head>
<body>
<header class="am-topbar admin-header">
    <div class="am-topbar-brand">
        <strong>软件梦工厂</strong>
        <small>蓝桥杯模拟训练系统</small>
    </div>

    <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only"
            data-am-collapse="{target: '#topbar-collapse'}"><span class="am-sr-only">导航切换</span> <span
            class="am-icon-bars"></span></button>

    <div class="am-collapse am-topbar-collapse" id="topbar-collapse">

        <ul class="am-nav am-nav-pills am-topbar-nav am-topbar-right admin-header-list">
            <li class="am-hide-sm-only">
                <div class="am-topbar-form am-topbar-left am-form-inline" role="search">
                    <form class="am-form-group" action="listcode.php" method="get">
                        <input type="text" class="am-form-field am-input-sm" placeholder="请在此输入运行编号！" name='sid'>
                        <input type="submit" class="am-btn am-btm-primary" value="确定"/>
                    </form>
                </div>
            </li>
            <li class="am-hide-sm-only"><a href="javascript:;" id="admin-fullscreen"><span
                        class="am-icon-arrows-alt"></span> <span class="admin-fullText">开启全屏</span></a></li>
        </ul>
    </div>
</header>
<?php
session_start();
if (!isset($_SESSION['administrator'])) {
    die("您没有权限查看此内容!");
}
require_once "DBCN.php";
$db = new DB();
$data['solution_id'] = $_GET['sid'];
$judge ['solution_id'] = '=';
if ($_GET['sid']) {
    list($conSql, $mapConData) = $db->FDFields($data, 'and', $judge);
    $mData = $db->fetch('select * from source_code where ' . $conSql, $mapConData);
    if ($mData) {
        $code = $mData['source'];
        print $_GET['sid'] . ":";
    }
    ?>
    <pre><code><?php print htmlentities($code) ?></code></pre>
    <?php
} else {
    print "<h3>solution_id : " . $_GET['sid'] . " does not exist!</h3>";
}
?>
<?php include_once "blue-footer.php" ?>
<!--[if (gte IE 9)|!(IE)]><!-->
<script src="assets/js/jquery.min.js"></script>
<!--<![endif]-->
<script src="assets/js/amazeui.min.js"></script>
<script src="assets/js/app.js"></script>
</body>
</html>
