<?php

/**
 * Functions: .
 * Author: Zhu Jinhao
 * Link: http://www.hfyefan.com
 * Copyright: HfYefan NetWork Co.,Ltd.
 */

namespace Seller\Controller;

use HttpCurl\HttpCurl;
use Think\Controller;

class IndexController extends SuperController {

    /**
     * 展示后台首页
     */
    public function index() {
        //实例化MenuGroup模型
        //查询首页图标
        $balanceModel=D('seller_balance');
        $con['seller_id']=session('SellerId');
        $balance=$balanceModel->where($con)->find();
        $WinMenuModel=D('SellerMenu');
        $WinMenu = $WinMenuModel->select();
        //赋值模板
        $this->assign('address',F('address'));
        $this->assign('balance',$balance);//余额
        $this->assign('admin', session('SellerName'));//登录用户名
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
     * 充值页面
     */
    public function payment(){
           $sellerBalance = D('seller_balance');
           $data['seller_id'] = session('SellerId');
           $con = $sellerBalance->where($data)->find();
           $this->assign('value', '金币充值');
           $this->assign('con', $con);
           $this->display('Wechat/payment');
    }
    /*
    * 提交申请
    */
    public function paypost(){
       $name = I('title');
        $chargeWay = I('chargeWay');
        $mark = I('mark');
        $money=I('money');
        $sellerCharge_detailModel = D('seller_charge_detail');
        $con = $sellerCharge_detailModel->where(['order_num'=>$name])->find();
        $managementModel = D('management');
        $a['ag_id'] = session('SellerId');
        $vl = $managementModel->where($a)->find();

        if(!empty($con)) return $this->error(L('订单已经提交过啦！！请耐心等待。'));
        $data['money'] = $money;
        $data['order_num'] = $name;
        $data['charge_way'] = $chargeWay;
        $data['mark'] = $mark;
        $data['time'] = date('Y-m-d H:s:i');
        $data['seller'] = session('SellerId');
//        $data['pa_ip'] = get_client_ip();
        $data['agent'] = $vl['ag_ag'];
        $val = $sellerCharge_detailModel->add($data);
        if($val){
            $this->success(L('提交申请成功'));
        }else{
            $this->error(L('提交申请失败'));
        }
    }
    /*
     * 申请查询
     */
    public function selectpayment(){
        //实例化UserGroup模型
        $PaymentModel = D('seller_charge_detail');
        $order = I('order');
        $start = I('startTime');
        $end = I('endTime');
        if(!empty($order)) $data['order_num'] = array('like','%'.$order.'%');
        if(!empty($start) and !empty($end))
            $data['time']=array(array('gt',$start),array('lt',$end));
        //获取总的用户数
//        $data['wei_data'] = 'jd';
        $data['seller'] = session('SellerId');
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
}
