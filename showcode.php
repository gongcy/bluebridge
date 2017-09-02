<?php
/**
 * Created by PhpStorm.
 * User: gongcy
 * Date: 16-10-31
 * Time: 下午8:17
 */

session_start();
if (!isset($_SESSION['user_id'])) {
    die("用户未登录!");
}
if ($_GET) {
    require_once 'DBCN.php';
//    require_once 'config.php';
    $db = new DB();
    if (!isset($_GET['user_id'])) {
        $data['user_id'] = $_SESSION['user_id'];
        $judge['user_id'] = '=';
    }
    if (isset($_GET['pid'])) {
        //查询
        $data['pid'] = $_GET['pid'];
        $judge['pid'] = '=';
    }
    $data['contest_code'] = $_GET['cid'];
    $judge['contest_code'] = '=';
    list($conSql, $mapConData) = $db->FDFields($data, 'and', $judge);
    $mData = $db->fetch('select * from blueSySSubmit where ' . $conSql . ' order by `submit_id` desc', $mapConData);
    if ($mData['ans'] != NULL) {
        print($mData['ans']);
    } else {
        $data1['solution_id'] = $mData['solution_id'];
        $judge1['solution_id'] = '=';
        list($conSql1, $mapConData1) = $db->FDFields($data1, 'and', $judge1);
        $mData1 = $db->fetch('select * from source_code where ' . $conSql1, $mapConData1);
        print($mData1['source']);
    }
}
?>