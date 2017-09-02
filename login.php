<?php
/**
 * Created by PhpStorm.
 * User: gongcy
 * Date: 16-10-31
 * Time: 下午8:17
 */

if ($_POST) {
    require_once 'DBCN.php';
    require_once 'my_fun.php';

    if ($_POST['user_id'] != '') {
        $db = new DB();
        $data['user_id'] = $_POST['user_id'];
        $judge['user_id'] = '=';
        list($conSql, $mapConData) = $db->FDFields($data, 'and', $judge);
        $mData = $db->fetch('select * from users where ' . $conSql, $mapConData);
//        var_dump($mData);
        $data1['user_id'] = $_POST['user_id'];
        $data1['ip'] = $_SERVER['REMOTE_ADDR'];
        $data1['time'] = date("Y/m/d H:i:s");
        $data1['password']= 'No Saved';
        $db->insert('loginlog',$data1);
        if (pwCheck($_POST['pwd'], $mData['password'])) {
            session_start();
            $row = $db->fetchAll('SELECT * FROM privilege WHERE ' . $conSql, $mapConData);
//            var_dump($row);
            foreach ($row as $key=>$value) {
                $_SESSION[$value['rightstr']] = true;
            }
            $_SESSION['user_id'] = $_POST['user_id'];
            $_SESSION['nick'] = $mData['nick'];
            header("Location: index.php");
        } else {
            print("<script>alert('用户名或密码错误')</script>");
        }
    } else {
        print("<script>alert('用户名不能为空')</script>");
    }

}
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>蓝桥模式登陆页</title>
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
    (function() {
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
            <li class="am-hide-sm-only"><a href="javascript:;" id="admin-fullscreen"><span
                        class="am-icon-arrows-alt"></span> <span class="admin-fullText">开启全屏</span></a></li>
        </ul>
    </div>
</header>
<div class="header">
    <div class="am-g">
        <h1>蓝桥模式登陆</h1>
    </div>
    <hr/>
</div>
<div class="am-g">
    <div class="am-u-lg-6 am-u-md-8 am-u-sm-centered">
        <form method="post" class="am-form" action="login.php">
            <label for="user_id">用户名（学号）:</label>
            <input type="text" name="user_id" id="user_id" value="">
            <br>
            <label for="pwd">密码:</label>
            <input type="password" name="pwd" id="pwd" value="">
            <br>
            <!--            <label for="remember-me">-->
            <!--                <input id="remember-me" type="checkbox">-->
            <!--                记住密码-->
            <!--            </label>-->
            <br/>
            <div class="am-cf">
                <input type="submit" name="" value="登 录" class="am-btn am-btn-primary am-btn-sm am-fl">
                <input type="button" onclick="location.href='sign.php'" name="" value="注 册"
                       class="am-btn am-btn-default am-btn-sm am-fr">
            </div>
        </form>
        <?php include_once "blue-footer.php" ?>
    </div>
</div>

<!--[if (gte IE 9)|!(IE)]><!-->
<script src="assets/js/jquery.min.js"></script>
<!--<![endif]-->
<script src="assets/js/amazeui.min.js"></script>
<script src="assets/js/app.js"></script>
</body>
</html>
