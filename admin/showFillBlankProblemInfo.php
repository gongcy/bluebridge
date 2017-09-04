<?php
/**
 * bluebridge
 * @author gongchenyu
 * @since 2017/9/5 0005 0:04
 */
session_start();
header("Content-type:text/html;charset=utf-8");
if (!isset($_GET['problem_id'])) die("访问参数错误");
$problem_id = $_GET['problem_id'];
require_once "../DBCN.php";
$db = new DB();

$data['problem_id'] = $problem_id;
$judge['problem_id'] = '=';
list($conSql, $mapConData) = $db->FDFields($data, 'and', $judge);
$problem_info = $db->fetch('select * from problem_fillblank where'.$conSql, $mapConData);
print json_encode($problem_info);