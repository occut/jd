<?php

/**
 * Functions: .
 * Author: Zhu Jinhao
 * Link: http://www.hfyefan.com
 * Copyright: HfYefan NetWork Co.,Ltd.
 */

namespace Agent\Controller;

use HttpCurl\HttpCurl;
use Think\Controller;

class IndexController extends SuperController {

    /**
     * 展示后台首页
     */
    public function index() {
        //实例化MenuGroup模型
        $uploadModel=D('upload');
        $con['admin_id']=session('adminId');
        $res=$uploadModel->where($con)->find();
        $ex=explode("|",$res['upload_name']);
        $ex1=explode("|",$res['upload_path']);
//        有上传的头像就用，没有就系统默认的
        if(!empty($ex[1])){
            $path=$ex1[1].$ex[1];
        }else{
            $path='/UploadImages/images/main.jpg';
        }
        //查询首页图标
        $WinMenuModel=D('WinMenu');
        $WinMenu = $WinMenuModel->select();

        $AccountBalance = D('AccountBalance');
        $data['ba_name'] = session('AgentId');
        $con = $AccountBalance->where($data)->find();
        //赋值模板
        $this->assign('address',F('address'));
        $this->assign('con', $con);
        $this->assign('res',$path);
        $this->assign('WinMenu', $WinMenu);
        $this->display('Index/index');
    }
//根据ip获取当前所在位置hj
    public function map()
    {
        $addr=I('addr');
        $file="http://apis.map.qq.com/ws/location/v1/ip?&key=AYTBZ-ZREKJ-ATVF3-FWMEW-FFXC5-CVF5Y";//根据端ip获取所在位置
        $address = get($file,'array');
        F('address',$address);//用于首页界面的地图显示
        $this->assign('LngLat',$address);
        $this->display("Index/map");
    }
    /*
     * 充值页面 钻石
     */
    public function payment(){
           $AccountBalance = D('AccountBalance');
           $data['ba_name'] = session('AgentId');
           $con = $AccountBalance->where($data)->find();
           $this->assign('value', '金币充值');
           $this->assign('con', $con);
           $this->display('Wechat/payment');
    }
    /*
    * 提交申请
    */
    public function paypost(){
        //接收数据
        $ba_name = I('ba_name');
        $ba_channel = I('ba_channel');
        $ba_remarks = I('ba_remarks');
        //实例化模型
        $adminModel = D('Agent');
        $PaymentModel = D('Payment');
        //查询数据
        $con = $PaymentModel->where(['pa_name'=>$ba_name])->find();
        //判断用户是否提交过订单
        if(!empty($con)) return $this->error(L('订单已经提交过啦！！请耐心等待。'));
        //查询屌丝账户数据
        $a['ag_id'] = session('AgentId');
        $vl = $adminModel->where($a)->find();
        //组装屌丝充值数据
        $data['pa_name'] = $ba_name;
        $data['ba_channel'] = $ba_channel;
        $data['ba_remarks'] = $ba_remarks;
        $data['pa_time'] = date('Y-m-d H:s:i');
        $data['ag_id'] = session('AgentId');
        $data['admin_id'] = $vl['ag_admin'];
        $data['pa_ip'] = get_client_ip();
        //写入屌丝充值数据
        $val = $PaymentModel->add(
            $data
        );
        //返回充值数据
        if($val){
            $this->success(L('提交申请成功'));
        }else{
            $this->error(L('提交申请失败'));
        }
    }
    /*
   * 申请查询 钻石
   */
    public function selectpayment(){
        //实例化UserGroup模型
        $PaymentModel = D('Payment');
        $pa_name = I('tiao');
        $start = I('startTime');
        $end = I('endTime');
        if(!empty($pa_name)) $data['pa_name'] = array('like','%'.$pa_name.'%');
        if(!empty($start) and empty($end)) $data['pa_time']=array(array('gt',$start),array('lt',$end));
        $data['ag_id'] = session('AgentId');
        //获取每页显示的数据集
        $count = $PaymentModel->selectSize($data);
        //实例化分页类
        $page = new \Org\Page\Page($count, 100);
        $userGroups = $PaymentModel->selectByPages($data,$page);
        //分页显示输出
        $show = $page->show();
        //赋值到模版
        $this->assign('usergroups', $userGroups);
        $this->assign('count', $count);
        $this->assign('page', $show);
        $this->assign('value', '记录查询');
        $this->display('Wechat/selectpayment');
    }
    /*
     * 充值申请 老板
     */
    public function chargedetail(){
        $AccountBalance = D('SellerChargeDetail');
        //获取总的用户数
        $data['agent'] = session('AgentId');
        $count = $AccountBalance::selectSize($data);
        //实例化分页类
        $page = new \Org\Page\Page($count, 100);
        //获取每页显示的数据集
        $Agent = $AccountBalance::selectByPages($data,$page);
        //分页显示输出
        $show = $page->show();
        //赋值到模版
//        dump($Agent);die;
        $this->assign('Agent', $Agent);
        $this->assign('count', $count);
        $this->assign('page', $show);
        $this->assign('value', '金币申请');
        $this->display('Wechat/chargedetail');
    }
    /*
     * 店铺充值 金币
     */
    public function Import(){
        if($_GET){
            $id = I('id');
            $PaymentModel = D('SellerChargeDetail');
            $a['id'] = $id;
            $con = $PaymentModel->where($a)->find();
            if($con['status'] != 1) $this->error(L('账单已提交'));
            $this->assign('value', '余额管理');
            $this->assign('pa_id', $id);
            $this->display('Wechat/payments');
        }else{
            $title = I('title');
            $operation = I('operation'); //操作人
            $id = I('id');
            $PaymentModel = D('SellerChargeDetail');
            $a['id'] = $id;
            $con = $PaymentModel->where($a)->find();
            $data['status'] = 0;
            $data['money'] = $title;
            $data['operation'] = $operation;
            $PaymentModel->where($a)->save($data);
            $AccountBalance = D('SellerBalance');
            $b['seller_id'] = $con['seller'];
            $vo = $AccountBalance->where($b)->find();
            if(empty($vo)){
                $dataa['seller_id'] = $con['seller'];
                $dataa['seller_money'] = $title;
                $dataa['charge_time'] = date('Y-m-d H:s:i');
                $value = $AccountBalance->add($dataa);
            }else{
                $mone = $vo['seller_money'];
                $dataa['seller_money'] = $mone+$title;
                $dataa['charge_time'] = date('Y-m-d H:s:i');
                $value = $AccountBalance->where($b)->save($dataa);
            }

            if($value){
                echo 1;
//                $this->error(L('提交申请成功'));
//                $this->success(L('提交申请成功'), U('Agent/management'));
            }else{
                echo 0;
//                $this->error(L('账单已提交'));
            }
        }
    }

    /*
     * 充值取消
     */
    public function cancel(){
        $id = I('id');
        $PaymentModel = D('SellerChargeDetail');
        $a['id'] = $id;
        $con = $PaymentModel->where($a)->find();
        $data['status'] = 1;
        $PaymentModel->where($a)->save($data);
        $AccountBalance = D('SellerBalance');
        $b['seller_id'] = $con['seller'];
        $money = $con['money'];
        $vo = $AccountBalance->where($b)->find();
        $mone = $vo['seller_money'];
        $dataa['seller_money'] = $mone-$money;
        $dataa['charge_time'] = date('Y-m-d H:s:i');
        $value = $AccountBalance->where($b)->save($dataa);
        if($value){

                $this->success(L('申请成功'));
//                $this->success(L('提交申请成功'), U('Agent/management'));
        }else{

                $this->error(L('申请失败'));
        }
    }
    /*
     * 申请查询
     */
    public function selectcharge(){
        //实例化UserGroup模型
        $PaymentModel = D('SellerChargeDetail');
        $pa_name = I('tiao');
        $start = I('startTime');
        $end = I('endTime');
        if(!empty($pa_name)) $data['order_num'] = array('like','%'.$pa_name.'%');
        if(!empty($start) and empty($end)) $data['time']=array(array('gt',$start),array('lt',$end));
        $data['agent'] = session('AgentId');

        //获取每页显示的数据集
        $count = $PaymentModel->selectSize($data);
        //实例化分页类
        $page = new \Org\Page\Page($count, 100);
        $userGroups = $PaymentModel->selectByPages($data,$page);
        //分页显示输出
        $show = $page->show();
        //赋值到模版
        $this->assign('usergroups', $userGroups);
        $this->assign('count', $count);
        $this->assign('page', $show);
        $this->assign('value', '记录查询');
        $this->display('Wechat/selectcharge');
    }
}
