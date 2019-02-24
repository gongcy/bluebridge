<?php
header("Content-type:text/html;charset=utf-8");
function updateans($sid, $cid)
{
    $msg;
    $db = new DB();
    $data['submit_id'] = $sid;
    $judge['submit_id'] = '=';
    list($conSql, $mapConData) = $db->FDFields($data, 'and', $judge);
    $mData = $db->fetch('select * from solution_blue where ' . $conSql, $mapConData);
    if ($mData['score'] == '0') {
        return "WA";
    } else if ($mData['score'] == '100') {
        return "AC";
    } else if ($mData['score'] != NULL) {
        return "WA##" . $mData['score'];
    }
    $contest_pid = $mData['pid'];
    $rs = $db->fetch("select * from contest_blue_problem where contest_id=" . $cid . " and num=" . $contest_pid);
    $pid = $rs['problem_id'];
    // 针对结果填空题
    if ($rs['type'] == 0) {
        $rs1 = $db->fetch("select * from problem_fillblank where problem_id=" . $pid);
        if ($mData['ans'] == $rs1['solution']) {
            $msg = "AC";
            $upData = 100;
            $isCorrect = 1;
        } else {
            $msg = "WA";
            $upData = 0;
            $isCorrect = 0;
        }
        if ($mData['score'] == NULL)
            $row = $db->exec("update solution_blue set score=" . $upData . ",is_correct=" . $isCorrect . " where submit_id=" . $sid . ";");
        //$msg = "更新行数:$row";
    } else {
        // 针对编程题和代码填空
        $data1['solution_id'] = $mData['solution_id'];
        $judge1['solution_id'] = '=';
        list($conSql1, $mapConData1) = $db->FDFields($data1, 'and', $judge1);
        $solutionData = $db->fetch('select * from solution where ' . $conSql1, $mapConData1);
        $result = $solutionData['result'];
        if ($result == '4') {
            $msg = "AC";
            if ($mData['score'] == NULL)
                $db->exec("update solution_blue set score=100,is_correct=1 where submit_id=" . $sid . ";");
        } else if ($result == '0' || $result == '2') {
            $msg = "panding";
        } else if ($result == '3') {
            $msg = "TLE####";
        } else if ($result == '6') {
            $msg = "WA" . $solutionData['pass_rate'];
            $score = intval(substr($solutionData['pass_rate'], 2));
            if ($mData['score'] == NULL)
                $db->exec("update solution_blue set score=$score where submit_id=" . $sid . ";");
        } else if ($result == '7') {
            $msg = "TLE" . $solutionData['pass_rate'];
            $score = intval(substr($solutionData['pass_rate'], 2));
            if ($mData['score'] == NULL)
                $db->exec("update solution_blue set score=$score where submit_id=" . $sid . ";");
        } else if ($result == '11') {
            $msg = "CP";
            if ($mData['score'] == NULL)
                $db->exec("update solution_blue set score=0 where submit_id=" . $sid . ";");
        } else if ($result == '8') {
            $msg = "MLE" . $solutionData['pass_rate'];
            $score = intval(substr($solutionData['pass_rate'], 2));
            if ($mData['score'] == NULL)
                $db->exec("update solution_blue set score=$score where submit_id=" . $sid . ";");
        } else if ($result == '10') {
            $msg = "RTE" . $solutionData['pass_rate'];
            $score = intval(substr($solutionData['pass_rate'], 2));
            if ($mData['score'] == NULL)
                $db->exec("update solution_blue set score=$score where submit_id=" . $sid . ";");
        } else {
            $db->exec("update solution_blue set score=0 where submit_id=" . $sid . ";");
        }
    }
    return $msg;
}

?>