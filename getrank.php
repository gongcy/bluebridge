<?php
header("Content-type:text/html;charset=utf-8");
if (isset($_GET['cid']) && isset($_GET['method'])) {
    require_once 'DBCN.php';
    require_once 'updateans.php';
    $db = new DB();
    $cid = $_GET['cid'];
    $method = $_GET['method'];
    $_SESSION['contest_code'] = $cid;
    $data1['contest_code'] = $cid;
    $judge1['contest_code'] = '=';
    list($conSql1, $mapConData1) = $db->FDFields($data1, 'and', $judge1);
    $mData1 = $db->fetchALL('select * from solution_blue where ' . $conSql1 . 'and score is null order by submit_id asc', $mapConData1, array(0, 5000));

    foreach ($mData1 as $key => $value) {
        updateans($value['submit_id'], $cid);
    }

    $data['contest_code'] = $cid;
    $judge['contest_code'] = '=';

    list($conSql, $mapConData) = $db->FDFields($data, 'and', $judge);
    $mData = $db->fetchALL('select b.*,a.* from solution_blue as a join users as b on a.user_id=b.user_id where a.' . $conSql . 'and a.score is not null order by a.submit_id asc', $mapConData, array(0, 5000));

    if ($mData) {
        $table = array();

        if ($method == "sc") {
            foreach ($mData as $key1 => $value1) {
                $user_id = $value1['nick'] . "  (" . $value1['user_id'] . ")";
                $pid = $value1['pid'];

                if (!isset($table[$user_id][$pid]['times'])) {
                    $table[$user_id][$pid]['times'] = 0;
                }
                if (!isset($table[$user_id][$pid]['score'])) {
                    $table[$user_id][$pid]['score'] = 0;
                }

                $rs = $db->fetch("select * from contest_blue_problem where contest_id=".$cid." and num=".$pid);

                $table[$user_id][$pid]['score'] = intval($value1['score']);
                $table[$user_id][$pid]['realsc'] = intval($value1['score']) * intval($rs['score']) / 100;
                $table[$user_id][$pid]['times']++;
            }
            uasort($table, function ($a, $b) {
                $al = 0;
                $bl = 0;
                foreach ($a as $key => $value) {
                    $al += $value['realsc'];//$value['score'] * $value['realsc'] / 100;
                }
                foreach ($b as $key => $value) {
                    $bl += $value['realsc'];//$value['score'] * $value['realsc'] / 100;
                }
                if ($al == $bl)
                    return 0;
                return ($al > $bl) ? -1 : 1;
            });
            print("<table class ='am-table am-table-bordered am-table-striped am-table-centered am-table-hover'>");
            print("<tr>");
            print("<th>排名</th>");
            print("<th>用户名</th>");
            $problemNum = $db->fetch("select count(*) as num from contest_blue_problem where contest_id=".$cid);
            $rs1 = $db->fetchAll("select * from contest_blue_problem where contest_id=".$cid);

            foreach ($rs1 as $key=>$value) {
                $scoresum = $value['score'];
                print("<th>第 ".($key+1)." 题 ($scoresum 分)</th>");
            }

            print("<th>总分</th>");
            print("</tr>");
            $ranki = 0;

            foreach ($table as $key => $value) {
                print("<tr>");
                ++$ranki;
                print("<td>$ranki</td>");
                print("<td>$key</td>");
                $sum = 0;

                for ($i = 1; $i <= $problemNum['num']; $i++) {
                    if (isset($value[$i])) {
                        $score = $value[$i]['score'];
                        $sc = $value[$i]['realsc'];
                        $times = $value[$i]['times'];
                        $sum += $sc;
                        if ($score == 100) {
                            print("<td style='background-color: lightgreen'>$sc / $score%($times)</td>");
                        } else {
                            print("<td style='background-color: pink'>$sc / $score%($times)</td>");
                        }
                    } else {
                        print("<td >0%(0)</td>");
                    }
                }

                print("<td>$sum</td>");
                print("</tr>");
            }
        }
        else if ($method == "ac") {
            foreach ($mData as $key1 => $value1) {
                $user_id = $value1['nick'] . "  (" . $value1['user_id'] . ")";
                $pid = $value1['pid'];

                if (!isset($table[$user_id][$pid]['times'])) {
                    $table[$user_id][$pid]['times'] = 0;
                }
                if (!isset($table[$user_id][$pid]['is_correct'])) {
                    $table[$user_id][$pid]['is_correct'] = 0;
                }

                $table[$user_id][$pid]['is_correct'] = intval($value1['is_correct']);
                $table[$user_id][$pid]['times']++;
            }
            uasort($table, function ($a, $b) {
                $al = 0;
                $bl = 0;
                require 'config.php';
                foreach ($a as $key => $value) {
                    $al += intval($value['is_correct']);
                }
                foreach ($b as $key => $value) {
                    $bl += intval($value['is_correct']);
                }
                if ($al == $bl)
                    return 0;
                return ($al > $bl) ? -1 : 1;
            });

            print("<table class ='am-table am-table-bordered am-table-striped am-table-centered am-table-hover'>");
            print("<tr>");
            print("<th>排名</th>");
            print("<th>用户名</th>");
            $problemNum = $db->fetch("select count(*) as num from contest_blue_problem where contest_id=".$cid);
            $rs1 = $db->fetchAll("select * from contest_blue_problem where contest_id=".$cid);

            foreach ($rs1 as $key=>$value) {
                print("<th>第 ".($key+1)." 题</th>");
            }

            print("<th>正确题数</th>");
            print("</tr>");
            $ranki = 0;

            foreach ($table as $key => $value) {
                print("<tr>");
                ++$ranki;
                print("<td>$ranki</td>");
                print("<td>$key</td>");
                $sum = 0;

                for ($i = 1; $i <= $problemNum['num']; $i++) {
                    if (isset($value[$i])) {
                        $times = $value[$i]['times'];
                        $sum++;
                        print("<td style='background-color: lightgreen'>答案正确($times)</td>");
                    } else {
                        print("<td style='background-color: pink'>答案错误(0)</td>");
                    }
                }
                print("<td>$sum</td>");
                print("</tr>");
            }
        }
        print("</table>");
    } else {
        print("<h1>不存在该比赛或该比赛无人提交！</h1>");
    }
}
?>
