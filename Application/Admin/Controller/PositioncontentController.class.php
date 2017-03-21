<?php
/**
 * 后台Index相关
 */
namespace Admin\Controller;
use Think\Controller;
use Think\Exception;

class PositioncontentController extends CommonController {
    public function index(){
        //获取推荐位里面的内容
        $positions = D("Position")->getNormalPositions();
        $data['status'] = array('neq', -1);
        if($_GET['title']) {
            $data['title'] = trim($_GET['title']);
            $this->assign('title', $data['title']);
        }
        $data['position_id'] = $_GET['position_id'] ? intval($_GET['position_id']) : $positions[0]['id'];
        //获取推荐位管理里面的内容
        $contents = D("PositionContent")->select($data);

        $this->assign('positions', $positions);
        $this->assign('contents', $contents);
        $this->assign('positionId', $data['position_id']);
        $this->display();
    }

    public function add() {
        if($_POST) {
            if(!isset($_POST['position_id']) || !$_POST['position_id']) {
                return show(0, '推荐位ID不能为空');
            }
            if(!isset($_POST['title']) || !$_POST['title']) {
                return show(0, '推荐位标题不能为空');
            }
            if(!$_POST['url'] && !$_POST['news_id']) {
                return show(0, 'url和news_id不能同时为空');
            }
            if(!isset($_POST['thumb']) || !$_POST['thumb']) {
                if($_POST['news_id']) {
                    $res = D("News")->find($_POST['news_id']);
                    if($res && is_array($res)) {
                        $_POST['thumb'] = $res['thumb'];
                    }
                }else{
                    return show(0,'图片不能为空');
                }

            }
            if($_POST['id']) {
                //更新过来的数据
              return $this->save($_POST);
            }
            try{
                //数据插入数据库
                $id = D("PositionContent")->insert($_POST);
                if($id) {
                    return show(1, '新增成功');
                }
                return show(0, '新增失败');
            }catch(Exception $e) {
                return show(0, $e->getMessage());
            }
        }else {
            $positions = D("Position")->getNormalPositions();
            $this->assign('positions', $positions);
            $this->display();
        }
    }

    public function edit() {

        $id = $_GET['id'];
        $position = D("PositionContent")->find($id);
        $positions = D("Position")->getNormalPositions();
        $this->assign('positions', $positions);
        $this->assign('vo', $position);
        $this->display();
    }

    public function save($data) {
        $id = $data['id'];
        unset($data['id']);

        try {
            $resId = D("PositionContent")->updateById($id, $data);
            //做判断
            if($resId === false) {
                return show(0, '更新失败');
            }
            return show(1, '更新成功');
        }catch(Exception $e) {
            return show(0, $e->getMessage());
        }
    }

    public function setStatus() {
        $data = array(
            'id' => intval($_POST['id']),
            'status' => intval($_POST['status']),
        );
        //ctrl+P查看函数参数，公用函数，写在commonController里面
        return parent::setStatus($data, 'PositionContent');
    }

    public function listorder() {
        return parent::listorder("PositionContent");
    }

}