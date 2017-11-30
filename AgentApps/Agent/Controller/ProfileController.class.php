<?php

/**
 * Functions: .
 * Author: Zhu Jinhao
 * Link: http://www.hfyefan.com
 * Copyright: HfYefan NetWork Co.,Ltd.
 */
//基本信息
namespace Agent\Controller;

use HttpCurl\HttpCurl;
use Think\Controller;

class ProfileController extends SuperController {

    /**
     * 展示后台首页
     */
    public function index() {
        $managementModel=D('Agent');
        $con['ag_id']=session('AgentId');
        $data=$managementModel->where($con)->find();
        if (IS_POST){
            $pw=I('ag_pw');
            $ag_phone=I('ag_phone');
            $ag_mb=I('ag_mb');
            $ag_qq=I('ag_qq');
            $ag_weixin=I('ag_wx');
            $d['ag_phone']=$ag_phone;
            $d['ag_mb']=$ag_mb;
            $d['ag_qq']=$ag_qq;
            $d['ag_wx']=$ag_weixin;
            if ($pw==''){
                $d['ag_pw']=$data['ag_pw'];
            }else{
                $d['ag_pw']=admin_md5($pw);
            }
            $managementModel->where($con)->save($d);
        }
            //赋值模板
            $this->assign('data',$data);
            $this->display('Setting/editProfile');

    }
}
