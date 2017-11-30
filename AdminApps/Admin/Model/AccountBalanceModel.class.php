<?php

/**
 * Functions: .
 * Author: Zhu Jinhao
 * Link: http://www.hfyefan.com
 * Copyright: HfYefan NetWork Co.,Ltd.
 */

namespace Admin \ Model;

use Think \ Model;

class AccountBalanceModel extends Model {

    /**
     * 获取文章表中的总条数
     */
    static public function selectSize($where) {
        $result = M('AccountBalance')->where($where)->count();
        return $result;

    }
    /**
     * 分页数据集
     */
    static public function selectByPages($where,$page){
        $result = M('AccountBalance')->where($where)->limit($page->firstRow . ',' . $page->listRows)->order('ba_id desc')->select();
        return $result;
    }

}
