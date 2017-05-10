<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/20
 * Time: 11:21
 */
namespace Common\Model;
use Think\Model;

class AdminModel extends Model {

    public $_db;

    public function __construct() {
        $this->_db = M('admin');
    }

    public function getAdminByUsername($username='') {
        $result = $this->_db->where("username='{$username}'")->find();
        return $result;
    }

}