<?php session_start(); ?>
<?php
/**
 * Created by PhpStorm.
 * User: gongcy
 * Date: 2017/1/22 0022
 * Time: 14:21
 */
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
}
require_once 'config.php';
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>蓝桥训练系统</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <link rel="alternate icon" type="image/png" href="assets/i/favicon.png">
    <link rel="stylesheet" href="assets/css/amazeui.min.css"/>

    <style>
        .header {
            text-align: center;
        }

        .header h1 {
            font-size: 200%;
            color: #333;
            margin-top: 30px;
        }

        .header p {
            font-size: 14px;
        }
    </style>
    <script>
        var _hmt = _hmt || [];
        (function () {
            var hm = document.createElement("script");
            hm.src = "https://hm.baidu.com/hm.js?c6913a16d3550e551dc3c0869c510963";
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(hm, s);
        })();
    </script>
</head>
<body>
<div id="browser-unsupported" style="display: none">人生苦短, 何必还在用这么老的浏览器~
    当前网页 <strong>不支持</strong> 你正在使用的浏览器, 为了正常的访问,
    请 <a href="http://browsehappy.com/">升级你的浏览器</a>。
</div>
<script>
    if (navigator.userAgent.indexOf("MSIE") > -1) {
        document.getElementById("browser-unsupported").removeAttribute("style");
    }
</script>
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
            <!-- <li><a href="javascript:;"><span class="am-icon-envelope-o"></span> 收件箱 <span class="am-badge am-badge-warning">5</span></a></li> -->
            <li class="am-dropdown" data-am-dropdown>
                <a class="am-dropdown-toggle" data-am-dropdown-toggle href="javascript:;">
                    <span class="am-icon-users"></span> <?php print($_SESSION['user_id']); ?> <span
                            class="am-icon-caret-down"></span>
                </a>
                <ul class="am-dropdown-content">
                    <!--                     <li><a href="#"><span class="am-icon-user"></span> 资料</a></li>-->
                    <?php

                    if (isset($_SESSION['administrator']) || isset($_SESSION['contest_creator'])) {
                        print "<li><a href='admin/index.php'><span class='am-icon-cog'></span> 管理</a></li>";
                    }
                    ?>
                    <li><a href="logout.php"><span class="am-icon-power-off"></span> 退出</a></li>
                </ul>
            </li>
            <li class="am-hide-sm-only"><a href="javascript:;" id="admin-fullscreen"><span
                            class="am-icon-arrows-alt"></span> <span class="admin-fullText">开启全屏</span></a></li>
        </ul>
    </div>
</header>
<div class="am-g">
    <h1 style="text-align:center; margin:0;">比赛列表</h1>
</div>
<div class="am-g">
    <h4 style="text-align:center; margin:0; color:red;">
        <?php require_once 'config.php'; ?>
        <span id=nowdate>服务器时间：<?php echo date("Y-m-d H:i:s") ?></span>
    </h4>
</div>
<hr/>
<marquee style="background-color: lightblue">
    <?php
    $msg = file_get_contents("admin/msg.txt");
    print($msg);
    ?>
</marquee>
<div class="am-g">
    <div class="am-u-lg-6 am-u-md-8 am-u-sm-centered">
        <table class="am-table am-table-bd am-table-striped admin-content-table">
            <thead>
            <th>ID</th>
            <th>Name</th>
            <th>Status</th>
            <th>Language</th>
            </thead>
            <tbody>
            <?php
            require_once 'DBCN.php';
            require_once 'config.php';
            $db = new DB();

            $rs = $db->fetchAll('select * from contest_blue');
            foreach ($rs as $key => $value) {
                print("<tr>");
                print("<td>" . $value['contest_id'] . "</td>");
                print("<td><a href=contest.php?cid=" . $value['contest_id'] . ">" . $value['title'] . "</a></td>");
                print("<td>");
                $now = time();
                $start_time = strtotime($value['start_time']);
                $end_time = strtotime($value['end_time']);
                if ($now > $end_time)
                    print "<span style='color: black'>已结束</span>@" . $value['start_time'];
                else if ($now < $start_time)
                    print "<span style='color: red'>未开始</span>@" . $value['start_time'];
                else
                    print "<span style='color: green'>进行中</span>@" . $value['start_time'];
                print("</td>");
                print("<td>" . (($value['lang'] == 1) ? "Java" : "C/C++") . "</td>");
                print("</tr>");
            }
            ?>
            </tbody>
        </table>

    </div>
</div>
<?php require_once "blue-footer.php" ?>

<script type="text/javascript">
    var diff = new Date("<?php echo date("Y/m/d H:i:s")?>").getTime() - new Date().getTime();

    function clock() {
        var x, h, m, s, n, xingqi, y, mon, d;
        var x = new Date(new Date().getTime() + diff);
        y = x.getYear() + 1900;
        if (y > 3000) y -= 1900;
        mon = x.getMonth() + 1;
        d = x.getDate();
        xingqi = x.getDay();
        h = x.getHours();
        m = x.getMinutes();
        s = x.getSeconds();
        n = y + "-" + mon + "-" + d + " " + (h >= 10 ? h : "0" + h) + ":" + (m >= 10 ? m : "0" + m) + ":" + (s >= 10 ? s : "0" + s);
        document.getElementById('nowdate').innerHTML = "服务器时间：" + n;
        setTimeout("clock()", 1000);
    }

    clock();
</script>

<!--[if (gte IE 9)|!(IE)]><!-->
<script src="assets/js/jquery.min.js"></script>
<!--<![endif]-->
<script src="assets/js/amazeui.min.js"></script>
<script src="assets/js/app.js"></script>
</body>
</html>