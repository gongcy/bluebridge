<?php
/**
 * Created by PhpStorm.
 * User: gongcy
 * Date: 16-10-31
 * Time: 下午8:17
 */

function pwCheck($password,$saved)
{
//    if ($saved){
//        $mpw = md5($password);
//        if ($mpw==$saved) return True;
//        else return False;
//    }
    $svd=base64_decode($saved);
    $salt=substr($svd,20);
    $hash = base64_encode( sha1(md5($password) . $salt, true) . $salt );
    if (strcmp($hash,$saved)==0) return True;
    else return False;
}

function pwGen($password,$md5ed=False)
{
    if (!$md5ed) $password=md5($password);
    $salt = sha1(rand());
    $salt = substr($salt, 0, 4);
    $hash = base64_encode( sha1($password . $salt, true) . $salt );
    return $hash;
}

function checkPrivilge(){
    if (isset($_SESSION['administrator'])||isset($_SESSION['contest_creator'])){
        print "<li><a href='admin/index.php'><span class='am-icon-cog'></span> 管理</a></li>";
        return true;
    }
    return false;
}