<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/26 0026
 * Time: 0:04
 */
if (isset($_GET['cid'])) {
    require_once 'DBCN.php';
    $cid = $_GET['cid'];
    $db = new DB();
    $rs = $db->fetch("select * from contest_blue where contest_id=".$cid);
    $BEGIN_TIME = $rs['start_time'];
    $END_TIME = $rs['end_time'];
}
