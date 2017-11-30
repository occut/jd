<?php

/**
 * Functions: .
 * Author: Zhu Jinhao
 * Link: http://www.hfyefan.com
 * Copyright: HfYefan NetWork Co.,Ltd.
 */

namespace Admin \ Model;

use Think \ Model;

class AccountNumberModel extends Model {

    /**
     * 获取文章表中的总条数
     */
    static public function selectSize($where) {
        $result = M('AccountNumber')->where($where)->count();
        return $result;

    }
    /**
     * 分页数据集
     */
    static public function selectByPages($where,$page){
        $result = M('AccountNumber')->where($where)->limit($page->firstRow . ',' . $page->listRows)->order('ac_id desc')->select();
        return $result;
    }

}
