<?php
if ($_POST) {
    header("Content-type:text/html;charset=utf-8");
    require_once 'config.php';
    $current_time = time();
    session_start();
    require_once 'DBCN.php';
    require_once 'updateans.php';
    $cid = $_POST['cid'];
    $msg = updateans($_POST['submit_id'], $cid);
//    var_dump($msg);
    //if($msg=='panding')die("panding");
    $db = new DB();
    $rs = $db->fetch("select * from contest_blue where contest_id=".$cid);
    $BEGIN_TIME = $rs['start_time'];
    $END_TIME = $rs['end_time'];
    if ((strtotime($BEGIN_TIME) < $current_time && $current_time < strtotime($END_TIME)) && $MODE == 1 && !isset($_SESSION['administrator'])) {
        die('wait');
    } else print($msg);
    //var_dump($mData);
}
?>