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
$contest_id = trim($_POST['contest_id']);
$upConData['contest_id'] = $contest_id;
$upConJudge['contest_id'] = '=';
$condition = array(
    'data' => $upConData,
    'judge' => $upConJudge,
    'link' => 'and'
);
$upData['title'] = trim($_POST['title']);
$upData['description'] = trim($_POST['des']);
$upData['start_time'] = trim($_POST['start_time']);
$upData['end_time'] = trim($_POST['end_time']);
$upData['lang'] = trim($_POST['lang']);
$upData['password'] = trim($_POST['pwd']);
$changeRows = $db->update('contest_blue', $upData, $condition);

// remove old problem map
list($delCon, $mapDelCon) = $db->FDField('contest_id', $contest_id);
$delRet = $db->delete('contest_blue_problem', $delCon, $mapDelCon);

// insert new problem map
$list = trim($_POST['list'], ' ;');
$pro_array = explode(";", $list);
foreach ($pro_array as $key => $value) {
    $inData['contest_id'] = $contest_id;
    $inData['num'] = $key + 1;
    $per_attr = explode(",", $value);
    $inData['type'] = $per_attr[0];
    $inData['problem_id'] = $per_attr[1];
    $inData['score'] = $per_attr[2];
    $ret2 = $db->insert("contest_blue_problem", $inData,true);
}

echo '更新行数:' . (int) $changeRows . '<br/>';

if ($changeRows === 1){
    print ("<script>alert('编辑成功');</script>");
}
else {
    print ("<script>alert('编辑失败！');</script>");
}
