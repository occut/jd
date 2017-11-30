<?php

/**
 * Functions: .
 * Author: Zhu Jinhao
 * Link: http://www.hfyefan.com
 * Copyright: HfYefan NetWork Co.,Ltd.
 */

namespace Admin\Model;

use Think\Model;

class RecordModel extends Model {

    /**
     * 获取文章表中的总条数
     */
    static public function selectSize($where) {
        $result = M('Record')->where($where)->count();
        return $result;

    }
    /**
     * 分页数据集
     */
     static public function selectByPages($where,$page){
        $result = M('Record')->where($where)->limit($page->firstRow . ',' . $page->listRows)->order('re_time desc')->select();
        return $result;
    }
    /*
     * 添加数据
     */
    public static function addAgent($data){
        $a['ag_name'] = $data['adminname'];
        $result = M('Agent')->where($a)->find();
        if(!empty($result)) return false;
        $a['ag_pw'] = admin_md5($data['adminpass']);
        $a['ag_mb'] = $data['adminemail'];
        $a['ag_phone'] = $data['adminmobile'];
        $a['ag_ban'] = $data['adminstatus'];
        $a['ag_time'] = date('Y-m-d H:i:s');
        $a['ag_admin'] = session('adminId');
        $result = M('Agent')->add($a);
        return $result;
    }
    public static function selectid($id){
        $a['ag_id'] = $id;
        $result = M('Agent')->where($a)->find();
        return $result;
    }

    public static function selectByName($id){
        $a['ag_name'] = $id;
        $result = M('Agent')->where($a)->find();
        return $result;
    }

    public static function saveAgent($adminId, $admin){
        $result = M('Agent')->where('ag_id=' . $adminId)->save($admin);
        return $result;
    }
}