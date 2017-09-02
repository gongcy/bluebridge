<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/21 0021
 * Time: 2:25
 */
require_once "DBCN.php";
$db = new DB();

$data['code_length'] = 1;
$judge['code_length'] = '=';
list($conSql, $mapConData) = $db->FDFields($data, 'and', $judge);
$id = $db->fetchAll('select solution_id from solution where ' . $conSql, $mapConData);
//var_dump($id);

$row = 0;


foreach ($id as $key => $i) {
    foreach ($i as $key1 => $i1) {
//        var_dump($i1) ;
        $data1['solution_id'] = $i1;
        $judge1['solution_id'] = '=';
        list($conSql1, $mapConData1) = $db->FDFields($data1, 'and', $judge1);
//        var_dump($conSql1, $mapConData1);

        $source = $db->fetch('select source from source_code where ' . $conSql1, $mapConData1);
//        var_dump($source);

        $length = strlen($source['source']);
//    var_dump($length);
        $db->exec("update solution set code_length=" . $length . " where solution_id=" . $i['solution_id'] . ";");
        $row++;
    }
}
var_dump($row);

