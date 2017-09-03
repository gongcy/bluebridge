<?php
/**
 * Created by PhpStorm.
 * User: gongcy
 * Date: 2017/2/2 0002
 * Time: 8:48
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

<?php
if(isset($_POST['do'])) {
    require_once "../my_fun.php";
    require_once "../DBCN.php";
    $db = new DB();

    $upConData['user_id'] = $_POST['id'];
    $upConJudge['user_id'] = '=';
    list($upConStr, $mapUpConData) = $db->FDField('password', 200, '=');
    $condition = array(
        'str' => $upConStr,
        'data' => $upConData,
        'judge' => $upConJudge,
        'link' => 'and'
    );
    $upData['password'] = pwGen($_POST['pwd']);
    $changeRows = $db->update('users', $upData, $condition, $mapUpConData);
    echo '更新行数:' . (int) $changeRows . '<br/>';

    if ($changeRows === 1){
        print ("<script>alert('修改成功');</script>");
    }
    else {
        print ("<script>alert('没有此用户！');</script>");
    }

}

?>

<div class="am-cf admin-main">
    <!-- sidebar start -->
    <?php require_once "admin-sidebar.php" ?>
    <!-- sidebar end -->

    <!-- content start -->
    <div class="admin-content">
        <div class="admin-content-body">
            <div class="am-cf am-padding am-padding-bottom-0">
                <div class="am-fl am-cf">
                    <strong class="am-text-primary am-text-lg">更改密码</strong> /
                    <small>Change password</small>
                </div>
            </div>
            <hr>

            <div class="am-g">
                <div class="am-u-sm-12 am-u-md-4 am-u-md-push-8">
                </div>

                <div class="am-u-sm-12 am-u-md-8 am-u-md-pull-4">
                    <form class="am-form am-form-horizontal" action="changepassword.php" method="post">

                        <div class="am-form-group">
                            <label for="user-id" class="am-u-sm-3 am-form-label">用户名</label>
                            <div class="am-u-sm-9">
                                <input name="id" type="text" class="" id="user-id" placeholder="用户名"/>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="user-pwd" class="am-u-sm-3 am-form-label">新密码</label>
                            <div class="am-u-sm-9">
                                <input name="pwd" type="password" class="" id="user-pwd" placeholder="新密码"/>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <div class="am-u-sm-9 am-u-sm-push-3">
                                <input type='hidden' name='do' value='do'>
                                <input type="submit" value="保存修改" class="am-btn am-btn-primary"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

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