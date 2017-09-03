<?php
/**
 * bluebridge
 * @author gongchenyu
 * @since 2017/9/4 0004 2:24
 */
session_start();
header("Content-type:text/html;charset=utf-8");
if (!isset($_GET['contest_id'])) die("访问参数错误");
$contest_id = $_GET['contest_id'];
require_once "../DBCN.php";
$db = new DB();
$data['contest_id'] = $contest_id;
$judge['contest_id'] = '=';
list($conSql, $mapConData)  = $db->FDFields($data, 'and', $judge);
$contest_base_info = $db->fetch('select * from contest_blue where'.$conSql, $mapConData);
$start_time = explode(' ', $contest_base_info['start_time']);
$contest_base_info['start_time'] = $start_time[0]."T".$start_time[1];
$end_time = explode(' ', $contest_base_info['end_time']);
$contest_base_info['end_time'] = $end_time[0]."T".$end_time[1];
$mData1 = $db->fetchAll('select * from contest_blue_problem where contest_id='.$contest_id);
$problem_list = "";
foreach ($mData1 as $value) {
    $problem_list .= $value['type'].','.$value['num'].','.$value['score'].';';
}
$problem_list = trim($problem_list, ' ;');
$problem_list = array('problem_list' => $problem_list);
$res = array_merge($contest_base_info, $problem_list);
print json_encode($res);