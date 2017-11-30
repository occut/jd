<?php

/**
 * Functions: .
 * Author: Zhu Jinhao
 * Link: http://www.hfyefan.com
 * Copyright: HfYefan NetWork Co.,Ltd.
 */

namespace Seller\Model;

use Think\Model;

class SellerChargeDetailModel extends Model {

    public function selectSize($where) {
        $result = M('seller_charge_detail')->where($where)->count();
        return $result;
    }
    public function selectByPages($where,$page){
        $result = M('seller_charge_detail')->where($where)->limit($page->firstRow . ',' . $page->listRows)->order('id desc')->select();
        return $result;
    }
}