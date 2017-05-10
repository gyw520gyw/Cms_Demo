<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/20
 * Time: 10:56
 * 公共函数
 */

function show($status, $msg, $data=array()) {
    $result = array(
        'status' => $status,
        'msg' => $msg,
        'data' => $data
    );

    exit(json_encode($result));

}


function md5Password($password) {
    return md5($password . C('MD5_PRE'));
}



function getMenuType($type) {
    return $type == 1 ? "后台菜单" : "前端栏目";
}


function getMenuStatus($type) {
    if($type == 1) {
        $str = "开启";
    } elseif ($type == 0) {
        $str = "关闭";
    } elseif ($type == -1) {
        $str = "删除";
    }
    return $str;
}

function getAdminMenuUrl($nav) {

    $url = '/admin.php?c='.$nav['c'].'a='.$nav['f'];
    if('index' == $nav['f']) {
        $url = '/admin.php?c='.$nav['c'];
    }

    return $url;

}


function getActive($navc) {
    $c = strtolower(CONTROLLER_NAME);
    if(strtolower($navc) == $c) {
        return 'class="active"';
    }
    return '';

}