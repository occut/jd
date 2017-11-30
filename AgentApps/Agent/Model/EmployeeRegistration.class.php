<?php

/**
 * Functions: .
 * Author: Zhu Jinhao
 * Link: http://www.hfyefan.com
 * Copyright: HfYefan NetWork Co.,Ltd.
 */

namespace Agent\Model;

use Think\Model;

class EmployeeRegistration extends Model {

    /**
     * 获取文章表中的总条数
     */
     public function selectSize($where) {
        $result = M('EmployeeRegistration')->where($where)->count();
        return $result;
    }
    public function aa(){

    }
    /**
     * 分页数据集
     */
     public function selectByPages($where,$page){
        $result = M('EmployeeRegistration')->where($where)->limit($page->firstRow . ',' . $page->listRows)->order('en_time desc')->select();
        return $result;
    }

}