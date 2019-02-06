<?php
if ($_POST) {
    session_start();
//    require 'config.php';
    require_once 'DBCN.php';
    $current_time = time();
    //usleep(rand(5000,2000000));
    $cid = $_POST['cid'];
    $db = new DB();
    $rs = $db->fetch("select * from contest_blue where contest_id=".$cid);
    $BEGIN_TIME = $rs['start_time'];
    $END_TIME = $rs['end_time'];
    $lang = $rs['lang'];
    if ((strtotime($BEGIN_TIME) < $current_time && $current_time < strtotime($END_TIME))||isset($_SESSION['administrator'])) {
        $contest_pid = $_POST['contest_pid'];
        $rs1 = $db->fetch("select * from contest_blue_problem where num=".$contest_pid." and contest_id=".$cid);
        if ($rs1['type'] == 0) {
            // result fillblank
            $inData['contest_code'] = $cid;
            $inData['user_id'] = $_SESSION['user_id'];
            $inData['ans'] = $_POST['ans'];
            $inData['pid'] = $contest_pid;
            $inData['type'] = 0;
            $inData['ip'] = $_SERVER['REMOTE_ADDR'];
            $inData['submit_time'] = date('Y-m-d H:i:s', time());
            $ret = $db->insert('solution_blue', $inData, true);
            if ($ret) echo "ok:$ret";
            else echo "error:1";
        } else if ($rs1['type'] == 1) {
            // code fillblank
            $pid = $rs1['problem_id'];

            ($lang==0) ? ($replace=$pid.".cpp") : ($replace=$pid.".java");
            $ansfile = fopen('fillblank/' . $replace, 'r') or dir("error:3");
            $ansfileread = fread($ansfile, filesize('fillblank/' . $replace));
            $keyword_list = trim($_POST['ans']);
            $keyword_arr = explode("\n", $keyword_list);
            foreach ($keyword_arr as $key => $value) {
                $ansfileread = str_replace(($key + 1) . "_______", $value, $ansfileread);
            }
            $ans = $ansfileread;

            $inData['problem_id'] = $rs1['problem_id'];
            $inData['user_id'] = $_SESSION['user_id'];
            $inData['in_date'] = date('Y-m-d H:i:s', time());
            $inData['result'] = '0';
            ($lang==0) ? ($inData['language'] = '1') : ($inData['language'] = '3');
            $inData['ip'] = $_SERVER["REMOTE_ADDR"];
            $inData['code_length'] = strlen($ans);
            $ret = $db->insert('solution', $inData, true);
            //echo 'so插入' . ($ret ? '成功' : '失败') . '<br/>';

            $inData1['solution_id'] = $ret;
            $inData1['source'] = $ans;
            $db->insert('source_code_user', $inData1);
            $ret1 = $db->insert('source_code', $inData1);
            //echo 'co插入' . ($ret1 ? '成功' : '失败') . '<br/>';

            $inData2['contest_code'] = $cid;
            $inData2['user_id'] = $_SESSION['user_id'];
            $inData2['solution_id'] = $ret;
            $inData2['submit_time'] = date('Y-m-d H:i:s', time());
            $inData2['pid'] = $contest_pid;
            $inData2['type'] = 1;
            $inData2['ans'] = $_POST['ans'];
            $inData2['ip'] = $_SERVER['REMOTE_ADDR'];
            $ret2 = $db->insert('solution_blue', $inData2, true);
            //echo 'bl插入' . ($ret2 ? '成功' : '失败') . '<br/>';

            if ($ret && $ret1 && $ret2) echo "ok:$ret2";
            else echo "error:5";
        } else if ($rs1['type'] == 2){
            // programming
            $inData['problem_id'] = $rs1['problem_id'];
            $inData['user_id'] = $_SESSION['user_id'];
            $inData['in_date'] = date('Y-m-d H:i:s', time());
            $inData['result'] = '0';

            ($lang==0) ? ($inData['language'] = '1') : ($inData['language'] = '3');
            $inData['ip'] = $_SERVER["REMOTE_ADDR"];
            $inData['code_length'] = strlen($_POST['ans']);
            $ret = $db->insert('solution', $inData, true);
            //echo '插入' . ($ret ? '成功' : '失败') . '<br/>';

            $inData1['solution_id'] = $ret;
            $inData1['source'] = $_POST['ans'];
            $db->insert('source_code_user', $inData1);
            $ret1 = $db->insert('source_code', $inData1);
//            echo '插入' . ($ret1 ? '成功' : '失败') . '<br/>';

            $inData2['contest_code'] = $cid;
            $inData2['user_id'] = $_SESSION['user_id'];
            $inData2['solution_id'] = $ret;
            $inData2['pid'] = $contest_pid;
            $inData2['submit_time'] = date('Y-m-d H:i:s', time());
            $inData2['type'] = 2;
            $inData2['ip'] = $_SERVER['REMOTE_ADDR'];
//            $inData2['ans'] = $_POST['ans'];
            $ret2 = $db->insert('solution_blue', $inData2, true);
//            echo '插入' . ($ret2 ? '成功' : '失败') . '<br/>';

            if ($ret && $ret1 && $ret2) echo "ok:$ret2";
            else echo "error:2";
        } else {
            echo "error:0";
        }
    } else {
        echo "时间超时";
    }
}
?>
