<?php
/**
 * Created by PhpStorm.
 * User: gongcy
 * Date: 16-10-31
 * Time: 下午8:17
 */

require_once 'DBCN.php';
require_once 'my_fun.php';
if ($_POST) {
    if ($_POST['user_id'] == "") {
        // do nothing
    } else if ($_POST['pwd'] != $_POST['pwd1']) {
        print("<script>alert('两次密码不匹配！')</script>");
    } else if ($_POST['pwd'] != "") {
        $db = new DB();
        $inData['user_id'] = $_POST['user_id'];
        $inData['nick'] = $_POST['nick'];
        $inData['password'] = pwGen($_POST['pwd']);
        $inData['school'] = $_POST['school'];
        $inData['email'] = $_POST['email'];
        $ret = $db->insert('users', $inData);
        if ($ret) {
            $inData1['user_id'] = $_POST['user_id'];
            $inData1['password'] = pwGen($_POST['password']);
            $inData1['ip'] = $_SERVER['REMOTE_ADDR'];
            $inData1['time'] = date("Y/m/d H:i:s");
            $db->insert('loginlog', $inData1);
//            print("注册成功，点击<a href='login.php'>这里</a>登录！");
            print("<script>alert('注册成功,跳转到登录页面...');window.location.href='login.php';</script>");
        } else {
            print("<script>alert('注册失败！请重新注册')</script>"); // TODO未判断用户名是否存在
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>注册页</title>
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
            <li class="am-hide-sm-only"><a href="javascript:;" id="admin-fullscreen"><span
                        class="am-icon-arrows-alt"></span> <span class="admin-fullText">开启全屏</span></a></li>
        </ul>
    </div>
</header>
<div class="header">
    <div class="am-g">
        <h1>注册</h1>
    </div>
    <hr/>
</div>
<div class="am-g">
    <div class="am-u-lg-6 am-u-md-8 am-u-sm-centered">
        <form method="post" class="am-form" action="sign.php">
            <label for="user_id">用户名（学号）:</label>
            <input type="text" name="user_id" id="user_id" value="" placeholder="必须使用学号！">
            <br>
            <label for="nick">昵称:</label>
            <input type="text" name="nick" id="nick" value="">
            <br>
            <label for="pwd">密码:</label>
            <input type="password" name="pwd" id="pwd" value="">
            <br>
            <label for="pwd1">重复密码:</label>
            <input type="password" name="pwd1" id="pwd1" value="">
            <br>
            <label for="school">学校:</label>
            <input type="text" name="school" id="school" value="">
            <br>
            <label for="email">邮箱:</label>
            <input type="email" name="email" id="email" value="">
            <br>

            <br/>
            <div class="am-cf">
                <input type="submit" name="" value="提 交" class="am-btn am-btn-primary am-btn-sm am-fl">
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
