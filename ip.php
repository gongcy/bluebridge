<?php
/**
 * Created by PhpStorm.
 * User: gongcy
 * Date: 2017/1/22 0022
 * Time: 1:02
 */
function search_ip($ip) {
    require_once "DBCN.php";
    $db = new DB();
    $data['ip'] = $ip;
    $judge['ip'] = '=';
    list($conSql, $mapConData) = $db->FDFields($data, 'and', $judge);
    $ip = $db->fetchAll('solution', $conSql, $mapConData);
    var_dump($ip);
    foreach($ip as $key=>$value) {

    }
    $url = "http://ip.taobao.com/service/getIpInfo.php?ip=".$ip;
}
search_ip("127.0.0.1");
