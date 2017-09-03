<?php
/**
 * bluebridge
 * @author gongchenyu
 * @since 2017/9/3 0003 23:55
 */
session_start();
header("Content-type:text/html;charset=utf-8");
if (!isset($_POST['contest_id'])) die('访问参数错误');
require_once "../DBCN.php";
$db = new DB();
$upConData['contest_id'] = $_POST['contest_id'];
$upConJudge['contest_id'] = '=';
$condition = array(
    'data' => $upConData,
    'judge' => $upConJudge,
    'link' => 'and'
);
$upData['title'] = $_POST['title'];
$upData['description'] = $_POST['des'];
$upData['start_time'] = $_POST['start_time'];
$upData['end_time'] = $_POST['end_time'];
$upData['lang'] = $_POST['lang'];
$upData['password'] = $_POST['pwd'];
$changeRows = $db->update('contest_blue', $upData, $condition);

$upData1['contest_id'] = $_POST['contest_id'];
$upConData['contest_id'] = $_POST['contest_id'];
$upConJudge['contest_id'] = '=';
$condition1 = array(
    'data' => $upConData,
    'judge' => $upConJudge,
    'link' => 'and'
);
$list = trim($_POST['list'], ' ;');
$pro_array = explode(";", $list);
foreach ($pro_array as $key => $value) {
    $upData1['num'] = $key + 1;
    $per_attr = explode(",", $value);
    $upData1['type'] = $per_attr[0];
    $upData1['problem_id'] = $per_attr[1];
    $upData1['score'] = $per_attr[2];
    $ret2 = $db->update("contest_blue_problem", $upData1, $condition1);
}

echo '更新行数:' . (int) $changeRows . '<br/>';

if ($changeRows === 1){
    print ("<script>alert('编辑成功');</script>");
}
else {
    print ("<script>alert('编辑失败！');</script>");
}
