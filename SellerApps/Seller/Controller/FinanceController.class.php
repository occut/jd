<?php
/**
 * Created by PhpStorm.
 * User: occur
 * Date: 2017/7/9
 * Time: 18:49
 */
namespace Seller\Controller;

use Think\Controller;

class FinanceController extends SuperController {
    public function index(){
//        账目明细Start
        $sellerpayModel = D('seller_pay');//查找数据表seller_pay费用明细表
        $skuid = I('skuid');
        $start = I('startTime');
        $end = I('endTime');
        if(!empty($skuid))
            $a['skuid'] = array('like','%'.$skuid.'%');
        if(!empty($start) and !empty($end))
            $a['pay_time']=array(array('gt',$start),array('lt',$end));

        $a['seller'] = session('SellerId');
        $total=$sellerpayModel->where($a)->count();
        $page = new \Org\Page\Page($total, 100);
        $usergroups=$sellerpayModel ->where($a)->limit($page->firstRow . ',' . $page->listRows)->order('pay_id desc')->select();
        $show = $page->show();
//        账目明细Over
        $this->assign('usergroups', $usergroups);
        $this->assign('count', $total);//显示总条数
        $this->assign('page', $show);//显示分页

        $this->display('Finance/lists');//将值显示在静态页面上
    }


    public function charge(){
        //        充值明细Start
        $chargeModel = D('seller_charge_detail');//查找数据表seller_pay费用明细表
        $ordernum = I('ordernum');
        $chargeStart = I('chargeStart');
        $chargeEnd = I('chargeEnd');
        if(!empty($ordernum))
            $c['order_num'] = array('like','%'.$ordernum.'%');
        if(!empty($chargeStart) and !empty($chargeEnd))
            $c['time']=array(array('gt',$chargeStart),array('lt',$chargeEnd));
        $c['seller'] = session('SellerId');
        $total1=$chargeModel->where($c)->count();
        $page1 = new \Org\Page\Page($total1, 100);
        $usergroups1=$chargeModel->where($c)->limit($page1->firstRow . ',' . $page1->listRows)->order('id desc')->select();
        $show1 = $page1->show();
//        充值明细Over
        $this->assign('usergroups1', $usergroups1);
        $this->assign('count1', $total1);//显示总条数
        $this->assign('page1', $show1);//显示分页
        $this->display('Finance/charge');//将值显示在静态页面上
    }



    public function liuliang(){
        //        流量明细Start
        $liuliang_detailModel = D('liuliang_detail');//查找数据表seller_pay费用明细表
//        $skuid = I('skuid');
//        $start = I('startTime');
//        $end = I('endTime');
//        if(!empty($skuid))
//            $a['skuid'] = array('like','%'.$skuid.'%');
//        if(!empty($start) and !empty($end))
//            $a['pay_time']=array(array('gt',$start),array('lt',$end));
        $a['seller'] = session('SellerId');
        $total2=$liuliang_detailModel->where($a)->count();
        $page2 = new \Org\Page\Page($total2, 100);
        $usergroups2=$liuliang_detailModel ->where($a)->limit($page2->firstRow . ',' . $page2->listRows)->order('id desc')->select();
        $show2 = $page2->show();
//        流量明细Over
        $this->assign('usergroups2', $usergroups2);
        $this->assign('count2', $total2);//显示总条数
        $this->assign('page2', $show2);//显示分页
        $this->display('Finance/liuliang');//将值显示在静态页面上
    }
}