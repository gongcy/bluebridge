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
    <script type="text/javascript">
        function editClick() {
            o = document.getElementById('name');
            if (o.childNodes[0].value) {
                o.innerHTML = o.value;
            } else {
                o.innerHTML = "<input type='text' id='temp' value='" + o.innerHTML + "' />";
            }
            return false;
        }

        function saveClick() {
            document.getElementById('name').innerHTML = document
                .getElementById('demo').value;
            return false;
        }

        function deleteClick() {

        }

        function getResult() {
            $.AMUI.progress.start();
            method = $('#smethod option:selected').val();
            //                alert(method);
            condition = $('#txtCondition').val();
            $("#resultdiv").load(
                "search_stu.jsp?method=" + method + "&condition=" + condition);
            $.AMUI.progress.done();
        }
    </script>
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
                    <strong class="am-text-primary am-text-lg">填空题列表</strong> /
                    <small>fillblank problem list</small>
                </div>
            </div>
            <hr>

            <div class="am-g">
                <div class="am-u-sm-12 am-u-md-6">
                    <div class="am-btn-toolbar">
                        <div class="am-btn-group am-btn-group-xs">
                            <button type="button" class="am-btn am-btn-default"><span class="am-icon-plus"></span> 新增</button>
                            <button type="button" class="am-btn am-btn-default"><span class="am-icon-save"></span> 保存</button>
                            <button type="button" class="am-btn am-btn-default"><span class="am-icon-archive"></span> 审核</button>
                            <button type="button" class="am-btn am-btn-default"><span class="am-icon-trash-o"></span> 删除</button>
                        </div>
                    </div>
                </div>
                <div class="am-u-sm-12 am-u-md-3">
                    <div class="am-input-group am-input-group-sm">
                        <input type="text" class="am-form-field">
                        <span class="am-input-group-btn">
                        <button class="am-btn am-btn-default" type="button">搜索</button>
                        </span>
                    </div>
                </div>
                <div class="am-g">
                    <div class="am-u-sm-12">
                        <form class="am-form">
                            <table class="am-table am-table-striped am-table-hover table-main">
                                <thead>
                                <tr>
                                    <th class="table-check"><input type="checkbox" /></th>
                                    <th class="table-id">ID</th>
                                    <th class="table-title">标题</th>
                                    <th class="table-st">开始时间</th>
                                    <th class="table-et">结束时间</th>
                                    <th class="table-des">描述</th>
                                    <th class="table-set">启用</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                require_once "../DBCN.php";
                                $db = new DB();
                                $mTable = $db->fetchAll("select * from contest_blue");
                                foreach ($mTable as $key=>$value){
                                    ?>
                                    <tr>
                                        <td><input type="checkbox" /></td>
                                        <td><?php print $value['contest_id'];?></td>
                                        <td><a><?php print $value['title']?></a></td>
                                        <td><?php print $value['start_time']?></td>
                                        <td><?php print $value['end_time']?></td>
                                        <td><?php print $value['description']?></td>
                                        <td><?php print $value['defunct']?></td>
                                        <td>
                                            <div class="am-btn-toolbar">
                                                <div class="am-btn-group am-btn-group-xs">
                                                    <button onclick="editClick()"
                                                            class="am-btn am-btn-default am-btn-xs am-text-secondary">
                                                        <span class="am-icon-pencil-square-o"></span> Edit
                                                    </button>
                                                    <button onclick="saveClick()"
                                                            class="am-btn am-btn-default am-btn-xs am-hide-sm-only">
                                                        <span class="am-icon-save"></span> Save
                                                    </button>
                                                    <button onclick="deleteClick()"
                                                            class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only">
                                                        <span class="am-icon-trash-o"></span> Delete
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>
                            </table>
                            <div class="am-cf">
                                共有
                                <?php print sizeof($mTable); ?>
                                场比赛。
                            </div>
                            </tbody>
                            </table>
                        </form>
                    </div>

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
    $flag = $db->insert("problem_fillblank",$mData);
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