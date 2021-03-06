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
        function editClick(problem_id) {
            var getcodehttp;
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                getcodehttp = new XMLHttpRequest();
            }
            else {
                // code for IE6, IE5
                getcodehttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            getcodehttp.onreadystatechange = function () {
                if (getcodehttp.readyState == 4 && getcodehttp.status == 200) {
                    var responseJson = getcodehttp.responseText;
                    var objData = jQuery.parseJSON(responseJson);
                    console.log(objData);
                    $('#problem-title').val(objData.title);
                    $('#problem-des').val(objData.description);
                    $('#problem-id').val(problem_id);
                    $('#problem-ans').val(objData.solution);
                    $('#problem-hint').val(objData.hint);
                    $('#editbox').modal();
                    $(function () {
                        var $prompt = $('#editbox');
                        var $confirmBtn = $prompt.find('[data-am-modal-confirm]');
                        var $cancelBtn = $prompt.find('[data-am-modal-cancel]');
                        $confirmBtn.unbind("click");
                        $confirmBtn.on('click', function (e) {
                            // do something
                            getcodehttp.open("POST", 'editFillBlankProblem.php', true);
                            getcodehttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                            getcodehttp.send("problem_id=" + problem_id
                                + "&title=" + encodeURIComponent($("#problem-title").val())
                                + "&des=" + encodeURIComponent($("#problem-des").val())
                                + "&ans=" + encodeURIComponent($("#problem-ans").val())
                                + "&hint=" + encodeURIComponent($("#problem-hint").val()));
                            $.AMUI.progress.start();
                        });
                    });
                    $.AMUI.progress.done();
                }
            };

            getcodehttp.open("GET", "showFillBlankProblemInfo.php?problem_id="+problem_id, true);
            getcodehttp.send();
            $.AMUI.progress.start();
        }

        function deleteClick() {

        }
        function getResult() {
            $.AMUI.progress.start();
            method = $('#smethod option:selected').val();
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
                                    <th class="table-set">启用</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                    require_once "../DBCN.php";
                                    $db = new DB();
                                    $mTable = $db->fetchAll("select * from problem_fillblank");
                                    foreach ($mTable as $key=>$value){
                                        $problem_id = $value['problem_id'];
                                ?>
                                    <tr>
                                        <td><input type="checkbox" /></td>
                                        <td><?php print $value['problem_id'];?></td>
                                        <td><a><?php print $value['title']?></a></td>
                                        <td><?php print $value['defunct']?></td>

                                        <td>
                                            <div class="am-btn-toolbar">
                                                <div class="am-btn-group am-btn-group-xs">
                                                    <?php
                                                    print("<button type='button' onclick='editClick($problem_id)' id='btn$problem_id'
                                                            class=\"am-btn am-btn-default am-btn-xs am-text-secondary\">
                                                        <span class=\"am-icon-pencil-square-o\"></span> Edit
                                                    </button>");
                                                    print("<button type='button' onclick='deleteClick($problem_id)' id='btn$problem_id'
                                                            class=\"am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only\">
                                                        <span class=\"am-icon-trash-o\"></span> Delete
                                                    </button>");

                                                    ?>
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
                                道题目。
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

<div class="am-modal am-modal-prompt" tabindex="-1" id="editbox">
    <div class="am-modal-dialog">
        <div class="am-modal-hd">修改比赛</div>
        <div class="am-modal-bd">
            <div class="am-g">
                <div class="am-u-sm-12 am-u-md-4 am-u-md-push-8">
                </div>

                <form class="am-form am-form-horizontal" method="post" role="form">
                    <div class="am-form-group">
                        <label for="problem-id" class="am-u-sm-3 am-form-label">题目编号</label>
                        <div class="am-u-sm-9">
                            <input id="problem-id" type="text" readonly/>
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

                </form>
            </div>
        </div>
        <div class="am-modal-footer">
            <span class="am-modal-btn" data-am-modal-cancel>取消</span>
            <span class="am-modal-btn" data-am-modal-confirm>提交</span>
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
