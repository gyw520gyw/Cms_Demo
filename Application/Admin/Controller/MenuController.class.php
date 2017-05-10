<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/20
 * Time: 18:25
 */
namespace Admin\Controller;
use Think\Controller;
use think\Exception;


class MenuController extends CommonController {

    public function add() {
        if($_POST) {

//            print_r($_POST);

            if(!isset($_POST['name']) || !$_POST['name']) {
                return show(0, '菜单名不能为空');
            }

            if(!isset($_POST['m']) || !$_POST['m']) {
                return show(0, '模块不能为空');
            }

            if(!isset($_POST['c']) || !$_POST['c']) {
                return show(0, '控制器不能为空');
            }

            if(!isset($_POST['f']) || !$_POST['f']) {
                return show(0, '方法名不能为空');
            }


            if($_POST['menu_id']) {
                return $this->save($_POST);
            }

            $menuId = D("Menu")->insert($_POST);

            if(!$menuId) {
                return show(0, '添加菜单失败');
            } else {
                return show(1, '添加菜单成功');
            }

        } else {

            $this->display();
        }
    }

    public function index() {


        $data = array();


        if(isset($_REQUEST['type']) && in_array($_REQUEST['type'], array(0, 1))) {
            $data['type'] = intval($_REQUEST['type']);
            $this->assign('type', $data['type']);
        } else {

            $this->assign('type', -1);
        }


        /**
         * 分页逻辑
         */
        $pageIndex = $_REQUEST['p'] ? $_REQUEST['p'] : 1;
        $pageSize = $_REQUEST['pageSize'] ? $_REQUEST['pageSize'] : 5;

        $menus = D("Menu")->getMenus($data, $pageIndex, $pageSize);
        $count = D("Menu")->getMenusCount($data);

        $page = new \Think\Page($count, $pageSize);
        $pageRes = $page->show();

        //模板赋值
        $this->assign('menus', $menus);
        $this->assign('pageRes', $pageRes);


        $this->display();
    }



    public function edit() {

        $menuId = $_GET['id'];

        $menuData = D("Menu")->getMenuDataById($menuId);

        $this->assign('menuData', $menuData);

//        var_dump($menuData);

        $this->display();
    }

    private function save($data){
        $id = $data['menu_id'];
        unset($data['menu_id']);

        try {
            $menuId = D("Menu")->updateMenuDataById($id, $data);

            if($menuId === false) {
                return show(0, "更新失败");
            }
            return show(1, "更新成功");
        } catch(Exception $e) {
            return show(0, $e->getMessage());
        }
    }

    // 删除
    public function setStatus() {
        if($_POST) {
            $id = $_POST['id'];
            $status = $_POST['status'];

            try {

                $res = D("Menu")->updateStatusById($id, $status);

                if($res === false) {
                    return show(0, '删除失败');
                }
                return show(1, "删除成功");
            }catch(Exception $e) {
                return show(0, $e->getMessage());
            }
        }
        return show(0, '没有提交数据');
    }

    // 排序
    public function listorder() {
        $listorder = $_POST['listorder'];
        if($listorder) {
            $errs = array();
            try{
                foreach($listorder as $menuId => $value) {

                    $res = D("Menu")->updateListorderById($menuId, $value);
                    if($res === false) {
                        $errs[] = $menuId;
                    }
                }
            } catch(Exception $e) {
                return show(0, $e->getMessage());
            }

            if($errs) {
                return show(0, '排序失败'.implode(',', $errs));
            }
            $ref_url = $_SERVER['HTTP_REFERER'];
            return show(1, '排序成功', array('ref_url'=>$ref_url));
        }

        return show(0, '排序失败');
    }
}