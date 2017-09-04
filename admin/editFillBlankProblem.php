<?php
/**
 * bluebridge
 * @author gongchenyu
 * @since 2017/9/5 0005 0:07
 */
session_start();
header("Content-type:text/html;charset=utf-8");
if (!isset($_POST['problem_id'])) die('访问参数错误');
require_once "../DBCN.php";
$db = new DB();
$upConData['problem_id'] = trim($_POST['problem_id']);
$upConJudge['problem_id'] = '=';
$condition = array(
    'data' => $upConData,
    'judge' => $upConJudge,
    'link' => 'and'
);
$upData['title'] = trim($_POST['title']);
$upData['description'] = trim($_POST['des']);
$upData['solution'] = trim($_POST['ans']);
$upData['hint'] = trim($_POST['hint']);
$changeRows = $db->update('problem_fillblank', $upData, $condition);

echo '更新行数:' . (int) $changeRows . '<br/>';

if ($changeRows === 1){
    print ("<script>alert('编辑成功');</script>");
}
else {
    print ("<script>alert('编辑失败！');</script>");
}
