<?php

/**
 * Functions: .
 * Author: Zhu Jinhao
 * Link: http://www.hfyefan.com
 * Copyright: HfYefan NetWork Co.,Ltd.
 */

namespace Admin\Model;

use Think\Model;

class PaymentModel extends Model {

    public function selectSize($where) {
        $result = M('Payment')->where($where)->count();
        return $result;
    }
    public function selectByPages($where,$page){
        $result = M('Payment')->where($where)->limit($page->firstRow . ',' . $page->listRows)->order('pa_id desc')->select();
        return $result;
    }
}