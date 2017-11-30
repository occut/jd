<?php

/**
 * Functions: 任务管理控制器.
 * Author: Zhu Jinhao
 * Link: http://www.hfyefan.com
 * Copyright: HfYefan NetWork Co.,Ltd.
 */

namespace Seller\Controller;

use Think\Controller;

class TasksController extends SuperController {

    /**
     * 任务界面
     */
    public function listTasks() {
        //实列化Tasks模型
        $taskModel = D('SellerTask');//商家任务
        $status = I('status');
        if($status != '') {
            $con['yefan_seller_task.payWay'] = $status;
        }

        $start = I('start');
        $end = I('end');
        if(!empty($start) && !empty($end)) {
            $con['yefan_seller_task.addtasktime'] = array(array('gt',$start),array('lt',$end));
        }
        $con['yefan_seller_task.seller_id']=session('SellerId');
        $count = $taskModel->selectTasksTotalSize($con);
        //实例化分页类
        $page = new \Org\Page\Page($count,100);
        //获取每页显示的数据集
        $tasks = $taskModel->selectTasksByPage($page,$con);
        //分页显示输出
        $show = $page->show();
        $this->assign('tasks', $tasks);
        $this->assign('count', $count);
        $this->assign('page', $show);
        $this->display('Tasks/listtasks');
    }
   /**
   * 添加任务的方法
   */
   public function taskscreate(){
        $shopModel=D('Shop');
        //查找当前登录商家的店铺
        $shop=$shopModel->selectShopBySeller(session('SellerId'));
       //赋值到模版
       $this->assign('shop',$shop);
       $this->display('Tasks/taskscreate');
   }
    /**
     * 保存任务的方法
     */
    public function tasksstore(){
        $skuid=I('skuid');
        $num=I('num');
        $keyword=I('keyword');
//        $page=I('page');
        $description=I('description');
        $order_num =I('order_num');
        $task_type=I('task_type');
        $doTime=I('doTime');
        $shop=I('shop');
        $buyer_mark=I('buyer_mark');
//        $likes=I('likes');
        $order_money=I('order_money');
        $task_name=I('task_name');

        $payWay=I('payWay');
        $yongjing=I('yongjing');
//        $allMoney=I('allMoney');
        $transfer=I('transfer');

        $sellertaskModel = D('seller_task');

        $sellerBalance = D('seller_balance');//余额表
        $dd['seller_id'] = session('SellerId');
        $con = $sellerBalance->where($dd)->find();//余额

        if($transfer==0){
            $d['all_transfer_pay'] = 0;//总物流费用

        }else{
            $d['all_transfer_pay']=($order_num)*2.5;//总物流费用
        }
        if ($payWay==0){
            $d['all_yongjing']=($order_num)*9;//总佣金
            $data['yongjing'] =9;//佣金
            $d['pay_over'] = 1;//总物流费用
        }else{
            if (($order_money)<=200){
                $d['all_yongjing']=($order_num)*10;//总佣金
                $data['yongjing'] =10;//佣金
            }else if(($order_money)>200 && ($order_money)<=500){
                $d['all_yongjing']=($order_num)*11;//总佣金
                $data['yongjing'] =11;//佣金
            }else if(($order_money)>500 && ($order_money)<=1000){
                $d['all_yongjing']=($order_num)*13;//总佣金
                $data['yongjing'] =13;//佣金
            }else if(($order_money)>1000 && ($order_money)<=1500){
                $d['all_yongjing']=($order_num)*15;//总佣金
                $data['yongjing'] =15;//佣金
            }else if(($order_money)>1500 && ($order_money)<=2000){
                $d['all_yongjing']=($order_num)*17;//总佣金
                $data['yongjing'] =17;//佣金
            }else if(($order_money)>2000 && ($order_money)<=2500){
                $d['all_yongjing']=($order_num)*19;//总佣金
                $data['yongjing'] =19;//佣金
            }else if(($order_money)>2500 && ($order_money)<=3000){
                $d['all_yongjing']=($order_num)*21;//总佣金
                $data['yongjing'] =21;//佣金
            }else{
                $d['all_yongjing']=($order_num)*(($order_money)*0.008);
                $data['yongjing'] =($order_money)*0.008;//佣金
            }
            $d['pay_over'] = 0;//WEI JIU SUAN
        }
        $data['transfer'] = $transfer;

        $data['payWay'] = $payWay;
        $data['skuId'] = $skuid;
        $data['num'] = $num;
        $data['keyword'] = $keyword;
//        $data['page'] = $page;
        $data['description'] = $description;
        $data['order_num'] = $order_num;
        $data['task_type'] = $task_type;
        $data['doTime'] = $doTime;
        $data['shop'] = $shop;
        $data['buyer_mark'] = $buyer_mark;
//        $data['likes'] = $likes;
        $data['order_money'] = $order_money;
        $data['task_name'] = $task_name;
        $data['seller_id'] = session('SellerId');

        $ag = D('management');
        $man['ag_id'] = session('SellerId');
        $managementvalus = $ag->where($man)->find();
        $data['ag_id'] = $managementvalus['ag_ag'];
        $sellertaskModel = D('seller_task');
        $sellerpaymodel=D('seller_pay');//费用明细表
        $managemenModel=D('management');
        $con['ag_id'] = session('SellerId');
        $v=$managemenModel->where($con)->find();
        $d['all_pay']=($order_num)*($order_money);//总货款
        $d['sum']= $d['all_transfer_pay']+$d['all_yongjing']+ $d['all_pay'];//总费用
        $d['seller'] = session('SellerId');
        $d['agent'] = $v['ag_ag'];
        $d['yongjing'] = $data['yongjing'];

        $data['allmoney']= $d['all_transfer_pay']+$d['all_yongjing']+ $d['all_pay'];//总费用
        if (empty($con)){
            echo 0;
//            $this->error(L('请充值'));
        }else{
            if (($con['seller_money'])<($data['allmoney'])){//余额小于下单的金额
//                $this->error(L('余额不足,请充值'));
                echo 0;
            }else{
                $d['seller_money']=($con['seller_money'])-($data['allmoney']);
                $sellerBalance->where($dd)->save($d);

                $value = $sellertaskModel->add($data);
                $d['task_id']=$value;
                $sellerpaymodel->add($d);
                if ($value) {
                    echo 1;
//                    $this->success(L('添加成功'), U('Tasks/listTasks'));
                } else {
                    echo 2;
//                    $this->error(L('添加失败'));
                }
            }
        }

    }

    /**
     * 编辑任务
     */
    public function edittimeTasks(){
        $sellertaskModel=D('seller_task');
        if(IS_GET) {
            $shopModel=D('Shop');
            //查找当前登录商家的店铺
            $shop=$shopModel->selectShopBySeller(session('SellerId'));

            $task_id= I('task_id');
            $data['task_id']= $task_id;
            $result = $sellertaskModel->where($data)->find();
            //赋值到模版
            $this->assign('result',$result);
            $this->assign('shop',$shop);
            $this->display('Tasks/edittimeTasks');
        }else {
            $sellerBalance = D('seller_balance');//余额表
            $dd['seller_id'] = session('SellerId');
            $con = $sellerBalance->where($dd)->find();//余额
            $task_id = I('task_id');
            $skuid = I('skuid');
            $num = I('num');
            $keyword = I('keyword');
            $description = I('description');
            $order_num = I('order_num');
            $task_type = I('task_type');
            $doTime = I('doTime');
            $shop = I('shop');
            $buyer_mark = I('buyer_mark');
            $order_money = I('order_money');
//            $task_name = I('task_name');
            $payWay = I('payWay');
            $yongjing = I('yongjing');
            $transfer = I('transfer');
            $data['transfer'] = $transfer;
            $data['yongjing'] = $yongjing;
            $data['payWay'] = $payWay;
            $data['skuId'] = $skuid;
            $data['num'] = $num;
            $data['keyword'] = $keyword;
            $data['description'] = $description;
            $data['order_num'] = $order_num;
            $data['task_type'] = $task_type;
            $data['doTime'] = $doTime;
            $data['shop'] = $shop;
            $data['buyer_mark'] = $buyer_mark;
            $data['order_money'] = $order_money;
//            $data['task_name'] = $task_name;
            $sellertaskModel = D('seller_task');
            $cons['task_id'] = $task_id;

            $sellerpaymodel=D('seller_pay');
            $managemenModel=D('management');
            $v=$managemenModel->where($dd)->find();

            if($transfer==0){
                $d['all_transfer_pay'] = 0;//总物流费用
            }else{
                $d['all_transfer_pay']=($order_num)*2.5;//总物流费用
            }

            if ($payWay==0){
                $d['all_yongjing']=($order_num)*9;//总佣金
                $data['yongjing'] =9;//佣金
                $d['pay_over'] = 1;
            }else{
                if (($order_money)<=200){
                    $d['all_yongjing']=($order_num)*10;//总佣金
                    $data['yongjing'] =10;//佣金
                }else if(($order_money)>200 && ($order_money)<=500){
                    $d['all_yongjing']=($order_num)*11;//总佣金
                    $data['yongjing'] =11;//佣金
                }else if(($order_money)>500 && ($order_money)<=1000){
                    $d['all_yongjing']=($order_num)*13;//总佣金
                    $data['yongjing'] =13;//佣金
                }else if(($order_money)>1000 && ($order_money)<=1500){
                    $d['all_yongjing']=($order_num)*15;//总佣金
                    $data['yongjing'] =15;//佣金
                }else if(($order_money)>1500 && ($order_money)<=2000){
                    $d['all_yongjing']=($order_num)*17;//总佣金
                    $data['yongjing'] =17;//佣金
                }else if(($order_money)>2000 && ($order_money)<=2500){
                    $d['all_yongjing']=($order_num)*19;//总佣金
                    $data['yongjing'] =19;//佣金
                }else if(($order_money)>2500 && ($order_money)<=3000){
                    $d['all_yongjing']=($order_num)*21;//总佣金
                    $data['yongjing'] =21;//佣金
                }else{
                    $d['all_yongjing']=($order_num)*(($order_money)*0.008);
                    $data['yongjing'] =($order_money)*0.008;//佣金
                }
                $d['pay_over'] = 0;
            }

            $d['all_pay']=($order_num)*($order_money);//总货款
            $d['sum']= $d['all_transfer_pay']+$d['all_yongjing']+ $d['all_pay'];//总费用
            $d['yongjing'] = $data['yongjing'];
            $data['allmoney']= $d['all_transfer_pay']+$d['all_yongjing']+ $d['all_pay'];//总费用

            $result = $sellertaskModel->where($cons)->find();
            $m['seller_money']=($con['seller_money'])+($result['allmoney']);//编辑提交先返回之前的钱
            $sellerBalance->where($dd)->save($m);

            $last=$sellerBalance->where($dd)->find();

            if(empty($last)){
                echo 0;
//                $this->error(L('请充值'));
            }else{
                if (($last['seller_money']) < ($data['allmoney'])) {//余额小于下单的金额
                    echo 0;
//                    $this->error(L('余额不足,请充值'));
                }else{
                    $d['seller_money']=($last['seller_money'])-($data['allmoney']);//再重新扣除
                    $sellerBalance->where($dd)->save($d);

//dump($cons);die;
                    $value = $sellertaskModel->where($cons)->save($data);
                    $sellerpaymodel->where($cons)->save($d);
                    if ($value) {
                        echo 1;
//                        $this->success(L('修改成功'), U('Tasks/listTasks'));
                    } else {
                        echo 2;
//                        $this->error(L('修改失败'));
                    }
                }
            }
        }
    }

//流量任务
    public function liuliangtasks() {
        //实列化Tasks模型
        $taskModel = D('liuliang');//商家任务
        $start = I('start');
        $end = I('end');
        if(!empty($start) && !empty($end)) {
            $con['yefan_liuliang.addtime'] = array(array('gt',$start),array('lt',$end));
        }
        $con['yefan_liuliang.seller']=session('SellerId');
        $count = $taskModel->where($con)->count();
        //实例化分页类
        $page = new \Org\Page\Page($count,100);
        //获取每页显示的数据集
        $tasks = $taskModel->join('LEFT JOIN yefan_shop ON  yefan_liuliang.shop = yefan_shop.id')->where($con)->limit($page->firstRow . ',' . $page->listRows)->select();
        //分页显示输出
        $show = $page->show();
        $this->assign('tasks', $tasks);
        $this->assign('count', $count);
        $this->assign('page', $show);
        $this->display('Tasks/liuliangtasks');
    }

//    流量任务添加
    public function liuliangcreate(){
        if ($_POST){
            $skuid=I('skuid');
            $keyword=I('keyword');
            $port_type=I('port_type');
            $report_num =I('report_num');
            $shop=I('shops');
            $doTime=I('doTime');
            $allMoney=I('allMoney');
            //取id，组名
            $data['port'] = $port_type;
            $data['fabushuliang'] = $report_num;
            $data['cost'] = $allMoney;
            $data['sku'] = $skuid;
            $data['keyword'] = $keyword;
            $data['excute'] = $doTime;
            $data['shop'] = $shop;
            $data['seller'] = session('SellerId');
            $ag = D('management');
            $man['ag_id'] = session('SellerId');
            $managementvalus = $ag->where($man)->find();
            $data['ag_id'] = $managementvalus['ag_ag'];
            $liuliangModel = D('liuliang');
            $sellerBalance = D('seller_balance');//余额表
            $dd['seller_id'] = session('SellerId');
            $con = $sellerBalance->where($dd)->find();//余额
            if (empty($con)){
                echo 0;
//                $this->error(L('请充值'));
            }else{
                if (($con['seller_money'])<($allMoney)){//余额小于下单的金额
                    echo 0;
//                    $this->error(L('余额不足,请充值'));
                }else{
                    $d['seller_money']=($con['seller_money'])-($allMoney);
                    $sellerBalance->where($dd)->save($d);

                    $value = $liuliangModel->add($data);
                    $sellerpaymodel=D('seller_pay');
                    $managemenModel=D('management');
                    $con['ag_id'] = session('SellerId');
                    $v=$managemenModel->where($con)->find();
                    $d['skuid'] = $skuid;
                    $d['pay_money'] = ($allMoney);
                    $d['seller'] = session('SellerId');
                    $d['agent'] = $v['ag_ag'];
                    $sellerpaymodel->add($d);

                    $managemenModel=D('management');//商家表
                    $con['ag_id'] = session('SellerId');
                    $v=$managemenModel->where($con)->find();

                    $liuliang_detailModel=D('liuliang_detail');//流量任务记录表
                    $c['num']=$report_num;
                    $c['all_money']=($report_num)*0.3;
                    $c['port']=$port_type;
                    $c['seller'] = session('SellerId');
                    $c['agent'] = $v['ag_ag'];
                    $liuliang_detailModel->add($c);
                    
                    if ($value) {
                        echo 1;
//                        $this->success(L('添加成功'), U('Tasks/liuliangtasks'));
                    } else {
                        echo 2;
//                        $this->error(L('添加失败'));
                    }
                }
            }
        }else{
            $shopModel=D('Shop');
            $con['seller_id']=session('SellerId');
            //查找当前登录商家的店铺
            $shops=$shopModel->where($con)->select();
            // dump($shops);die;
            //赋值到模版
            $this->assign('shops',$shops);
            $this->display('Tasks/liuliangcreate');
        }
    }

//    流量任务编辑
    public function liuliangEdit(){
        if ($_POST){
            $liuliang_id=I('liuliang_id');
            $id['liuliang_id']=$liuliang_id;
            $skuid=I('skuid');
            $keyword=I('keyword');
            $port_type=I('port_type');
            $report_num =I('report_num');
            $shop=I('shop');
            $doTime=I('doTime');
            $allMoney=I('allMoney');
            //取id，组名
            $data['port'] = $port_type;
            $data['fabushuliang'] = $report_num;
            $data['cost'] = $allMoney;
            $data['sku'] = $skuid;
            $data['keyword'] = $keyword;
            $data['excute'] = $doTime;
            $data['shop'] = $shop;
            $data['seller'] = session('SellerId');
            $liuliangModel = D('liuliang');
            $sellerBalance = D('seller_balance');//余额表
            $dd['seller_id'] = session('SellerId');
            $con = $sellerBalance->where($dd)->find();//余额
            if (empty($con)){
                $this->error(L('请充值'));
                echo 0;
            }else{
                if (($con['seller_money'])<($allMoney)){//余额小于下单的金额
                    echo 0;
//                    $this->error(L('余额不足,请充值'));
                }else{
                    $liuId['liuliang_id']= $liuliang_id;
                    $result = $liuliangModel->where($liuId)->find();
                    $m['seller_money']=($con['seller_money'])+($result['cost']);//编辑提交先返回之前的钱
                    $sellerBalance->where($dd)->save($m);

                    $con1 = $sellerBalance->where($dd)->find();//余额
                    $value = $liuliangModel->where($id)->save($data);

                    $d['seller_money']=($con1['seller_money'])-($allMoney);//再重新扣除

                    $sellerBalance->where($dd)->save($d);
                    $sellerpaymodel=D('seller_pay');
                    $managemenModel=D('management');
                    $con['ag_id'] = session('SellerId');
                    $v=$managemenModel->where($con)->find();
                    $d['skuid'] = $skuid;
                    $d['pay_money'] = ($allMoney);
                    $d['seller'] = session('SellerId');
                    $d['agent'] = $v['ag_ag'];
                    $sellerpaymodel->add($d);
                    if ($value) {
                        echo 1;
//                        $this->success(L('添加成功'), U('Tasks/liuliangtasks'));
                    } else {
                        echo 2;
//                        $this->error(L('添加失败'));
                    }
                }
            }
        }else{
            $shopModel=D('Shop');
            $con['seller_id']=session('SellerId');
            //查找当前登录商家的店铺
            $shops=$shopModel->where($con)->select();
            //查找当前登录商家的店铺
            $sellertaskModel=D('liuliang');
            $liuliang_id= I('liuliang_id');
            $data['liuliang_id']= $liuliang_id;
            $result = $sellertaskModel->where($data)->find();
            //赋值到模版
            $this->assign('result',$result);
            $this->assign('shops',$shops);
            $this->display('Tasks/liuliangEdit');
        }
    }
//    删除流量任务
    public function deleteliuliang(){
        $liuliang_id = I('liuliang_id');
        $taskModel = D('liuliang');
        $balanceModel=D('seller_balance');
        $con['liuliang_id'] = $liuliang_id;
        $seller['seller_id']=session('SellerId');

        $liuliang=$taskModel->where($con)->find();
        $balance=$balanceModel->where($seller)->find();

        $data['seller_money']=($balance['seller_money'])+($liuliang['cost']);
        $balanceModel->where($seller)->save($data);

        $res = $taskModel->where($con)->delete();
        if ($res) {
            //管理员操作记录到日志表中
            $logcontent = C('SYS_LOG_ACTION_DELETE')."删除成功" . "任务ID：" .$liuliang_id;
            sys_log(session('SellerId'),session('SellerName'),$logcontent);
            $this->success(L('删除成功'), U('Tasks/liuliangtasks'));
        } else {
            //管理员操作记录到日志表中
            $logcontent = C('SYS_LOG_ACTION_DELETE')."删除失败" . "任务ID：" .$liuliang_id;
            sys_log(session('SellerId'),session('SellerName'),$logcontent);
            $this->error(L('删除失败'));
        }
    }
//    批量删除流量任务
    public function deletesliulaingS(){
        $liuliang_id = I('liuliang_id');
        $taskModel = D('liuliang');
        $balanceModel=D('seller_balance');
        $taskid=I('ids');

        $seller['seller_id']=session('SellerId');
        $str=0;
        foreach ($taskid as $vo){
            $res=$taskModel->where($vo)->find();
            $str=$str+($res['cost']);
        }
        $val=$balanceModel->where($seller)->find();
        $money['seller_money']=($str)+($val['seller_money']);
        $balanceModel->where($seller)->save($money);

        $a['liuliang_id'] = array('in',$taskid);
        $value = $taskModel->where($a)->delete();
        if ($value){
            echo 1;
            die;
        }
        echo 2;
    }
    /**
     * 删除任务
     */
    public function deletetimeTasks(){
        $task_id = I('task_id');
        $taskModel = D('seller_task');
        $balanceModel=D('seller_balance');
        $con['task_id'] = $task_id;

        $seller['seller_id']=session('SellerId');

        $task=$taskModel->where($con)->find();

        $balance=$balanceModel->where($seller)->find();

        $data['seller_money']=($balance['seller_money'])+($task['allmoney']);
        $balanceModel->where($seller)->save($data);

        $res = $taskModel->where($con)->delete();
        if ($res) {
            //管理员操作记录到日志表中
            $logcontent = C('SYS_LOG_ACTION_DELETE')."删除成功" . "任务ID：" .$task_id;
            sys_log(session('SellerId'),session('SellerName'),$logcontent);
            $this->success(L('删除成功'), U('Tasks/listTasks'));
        } else {
            //管理员操作记录到日志表中
            $logcontent = C('SYS_LOG_ACTION_DELETE')."删除失败" . "任务ID：" .$task_id;
            sys_log(session('SellerId'),session('SellerName'),$logcontent);

            $this->error(L('删除失败'));
        }
    }
    /**
     * city
     */
    public function city(){
        $id = I('configId');
        $ProvinceModel = D('Province');
        $data['id'] = $id;
        $province = $ProvinceModel->where($data)->find();
        $cityMode = D('city');
        $a['fatherID'] = $province['provinceid'];
        $aa = $cityMode->where($a)->select();
        $value = '';
        foreach ($aa as $vo){
            $value .= "<option value=".$vo['id'].">".$vo['city']."</option>";
        }
        $data = ['error' => 1,'value'=>$value];
        echo json_encode($data);
    }
    /**
     * 更改IP
     */
    public function ip(){
        $time_id=I('time_id');
        $ip=I('ip');
        $data['time_ip'] = $ip;
        $a['time_id'] = $time_id;
        $taskModel = D('Taskstime');
        $res = $taskModel->where($a)->save($data);
        if($res){
            echo 1;
        }else{
            echo 2;
        }
    }

    /**
     * 开启和关闭任务
     */
    public function isHidden(){
        $task_id=I('task_id');
        $status=I('status');
        $TaskstimeModel = D('SellerTask');
        $a['task_id'] = $task_id;
//        $data['equipment_id'] = 0;
        $data['status'] = $status;
        $value = $TaskstimeModel->where($a)->save($data);
        if($value){
            echo 1;
        }else{
            echo 2;
        }
    }


    /**
     * 清空
     */
    public function disable(){
        $DisableModel = D('Disable');
        $test=$DisableModel->select();
        $value = $test[0]['id'];
        $a = $DisableModel->where('id',$value)->save(['value'=>0]);
//        var_dump($a);
//        die;
        if ($a){
            echo 1;
            die;
        }else{
            echo 2;
        }

    }
    /**
     *一键开启关闭
     */
    public function buttonopen(){
//        echo 123;
        $taskid=I('id');
//        var_dump($taskid);
//        die;
        $taskModel = D('Tasks');
        $a['tasks_status'] = $taskid;
        if($taskid ==1){
            $b = 0;
        }else{
            $b = 1;
        }
       $aaa = $taskModel->where($b)->save($a);
//        var_dump($aaa);
        echo 1;
    }
//    /**
//     * 添加任务的方法
//     */
public function Upload(){
    $taskid=I('taskid');
    $navModel=D('Navigation');
    $nav= $navModel->selectNavigationById($taskid);
    $url=$nav['nav_url'];
//    $url=1212;
    if($url==1212){
        $file = $_FILES['tasks'];
        //    echo $file;
        $webConfigModel = D('WebConfig');
        $webConfig = $webConfigModel->selectWebConfig();

        // 实例化上传类
        $upload = new \Think\Upload();
        // 设置附件上传大小
        $upload->maxSize = $webConfig['upload_size'] * 1024 * 1024;
        // 设置附件上传类型
        $upload->exts = explode('|', $webConfig['upload_type']);
        // 设置附件上传根目录
        $upload->rootPath = './';
        $upload->saveName="";
        // 设置附件上传（子）目录
        $upload->savePath = C('UPLOAD_IMG_DIRECTORY').$url."/";
        $info = $upload->uploadOne($file);
        //获取上传路径
        var_dump($info);
        $taskPic = $info['savepath'].$info['savename'];
        die;
    }
    //调用上传图片的方法
    $file = $_FILES['tasks'];
//    echo $file;
    $webConfigModel = D('WebConfig');
    $webConfig = $webConfigModel->selectWebConfig();

    // 实例化上传类
    $upload = new \Think\Upload();
    // 设置附件上传大小
    $upload->maxSize = $webConfig['upload_size'] * 1024 * 1024;
    // 设置附件上传类型
    $upload->exts = explode('|', $webConfig['upload_type']);
    // 设置附件上传根目录
    $upload->rootPath = './';
    $upload->saveName="";
    // 设置附件上传（子）目录
    $upload->savePath = C('UPLOAD_IMG_DIRECTORY')."/".$url."/";
    $info = $upload->uploadOne($file);
    //获取上传路径
    $taskPic = $info['savepath'].$info['savename'];

    
    
    //if($taskid != ""){
    //   $this->redirect('Tasks/editTasks/tasksid/'.$taskid);
    //}else{
        $this->redirect('Tasks/addtask');
    //}
}
public function addTask(){
        if (IS_POST) {
            //接受POST传递过来的值
            $tasksid= I('navid') ;
            $groupid=I('tasksgroupid');
            //实例化导航
            $navModel=D('navigation');
            //取id，任务名
            $nav= $navModel->selectNavigationById($tasksid);
            //实例化TasksGroup类
            $tasksgroupModel = D('TasksGroup');
            //取id，组名
            $tasksgroup=$tasksgroupModel->selectTasksGroupById( $groupid);
            $groupname=$tasksgroup['group_name'];
            $tasksname=$nav['nav_name'];
            $taskskey=I('taskkey');
            $tasksvalue=I('taskvalue');
            $taskstatus=I('taskstutas');
            $taskName = I('taskname');
            $taskTitle = I('tasktitle');
            $taskKeywords = I('taskkeywords');
            $taskDescription = I('taskdescription');
            $str='';
            $index = 1;
            for ($i = 0;$i< count($taskskey) ; $i++){
                if($index != 1){
                    $str .= ";";
                }
                $str =  $str .$taskskey[$i] .":" .$tasksvalue[$i];

                $index ++;
            }
//            var_dump(urldecode($str));
          for($i =0; $i++ ; $i < len($tasksvalue)){
          }
            $url=$nav['nav_url'];
            //调用上传图片的方法
            $file = $_FILES['tasks'];
            //echo $file;
            $webConfigModel = D('WebConfig');
            $webConfig = $webConfigModel->selectWebConfig();
            // 实例化上传类
            $upload = new \Think\Upload();
            // 设置附件上传大小
            $upload->maxSize = $webConfig['upload_size'] * 1024 * 1024;
            // 设置附件上传类型
            $upload->exts = explode('|', $webConfig['upload_type']);
            // 设置附件上传根目录
            $upload->rootPath = './';
            $upload->saveName="";
            // 设置附件上传（子）目录
            $upload->savePath = C('UPLOAD_IMG_DIRECTORY')."/".$url."/";
            $info = $upload->uploadOne($file);
            //获取上传路径
            $taskPic = $info['savepath'].$info['savename'];

            $taskContent = I('taskcontent');
            $taskbrowse=I('taskbrowse');
            $taskclick=I('taskclick');
            $taskauthor=I('taskauthor');
            $taskSummary = I('tasksummary');
            $taskaddTime=I('taskaddtime');
            $tasksnumber=I('tasksnumber');
            //封装数据
            $data['group_name'] = $groupname;
            $data['tasks_name'] = $tasksname;
            $data['tasks_status']=$taskstatus;
            $data['tasks_configs']=$str;
            $data['task_title'] = $taskTitle;
            $data['task_keywords'] = $taskKeywords;
            $data['task_pic'] = $taskPic;
            $data['task_description'] = $taskDescription;
            $data['task_content'] = $taskContent;
            $data['task_summary'] = $taskSummary;
            $data['task_browse']= $taskbrowse;
            $data['task_click']=$taskclick;
            $data['task_author']=$taskauthor;
            $data['tasks_number']=$tasksnumber;
            $data['admin_id']=session('adminId');
            if(empty($taskaddTime)){
               $data['task_addtime'] = time();
            }else{
               $data['task_addtime']=strtotime($taskaddTime);
            }

            //实列化Tasks模型
            $taskModel = D('Tasks');
            //添加任务信息
            $result = $taskModel->addTasks($data);
            //返回添加结果
            if ($result) {
                //管理员操作记录到日志表中
                $logcontent = C('SYS_LOG_ACTION_ADD')."任务管理添加成功。" . "任务名：" . $taskName;
                sys_log(session('adminId'),session('adminName'),$logcontent);

                $this->success(L('ADD_ARTICLE_SUCCESS'), U('Tasks/listtasks'));
            } else {
                //管理员操作记录到日志表中
                $logcontent = C('SYS_LOG_ACTION_ADD')."任务管理添加失败。" . "任务名：" . $taskName;
                sys_log(session('adminId'),session('adminName'),$logcontent);

                $this->error(L('ADD_ARTICLE_FAILURE'));
            }
        } else{
                //实例化导航
            $navModel=D('navigation');
            //取id，任务名
            $nav= $navModel->selectAllNavigations();

            //实例化TasksGroup类
            $tasksgroupModel = D('TasksGroup');
            //取id，组名
            $tasksgroup=$tasksgroupModel->selectAllTasksGroups();
            //实例化TasksGroup模型
            $taskModel = D('Tasks');
            //查找任务分组表中所有的数据
            $task = $taskModel->selectAllTasks();
            $navLen = count($nav);
            if($navLen > 0){
                $this->assign('firstNavId',$nav[0]['nav_id']);
            }
            //赋值到模版
            $this->assign('nav',$nav);
            $this->assign('string',$string);
            $this->assign('tasksgroup',$tasksgroup);
            $this->assign('task', $task);
            $this->display('Tasks/addtask');
        }
    }
    
    /**
     * 删除任务的方法
     */
    public function deleteTasks() {
        if (IS_GET){
            //接受GET传递过来的值
            $taskId = I('tasksid');

            //实列化Tasks模型
            $taskModel = D('Tasks');
            //查找任务表中task_id为$taskId的一条数据
            $task = $taskModel->selectTasksById($taskId);
            // 删除任务表中task_id为$taskid的一条数据
            $result = $taskModel->deleteTasksById($taskId);
            if ($result) {
                //管理员操作记录到日志表中
                $logcontent = C('SYS_LOG_ACTION_DELETE')."任务删除成功。" . "任务名：" .$task['task_name'];
                sys_log(session('adminId'),session('adminName'),$logcontent);

                $this->success(L('DELTE_ARTICLE_SUCCESS'), U('Tasks/listtasks'));
        } else {
                //管理员操作记录到日志表中
                $logcontent = C('SYS_LOG_ACTION_DELETE')."会员删除成功。" . "用户名：" .$task['task_name'];
                sys_log(session('adminId'),session('adminName'),$logcontent);

                $this->error(L('DELTE_ARTICLE_FAILURE'));
        }
    }
    }
    public function deletesTasks(){
        $task_id = I('task_id');
        $taskModel = D('SellerTask');
        $balanceModel=D('seller_balance');
        $taskid=I('ids');
        $seller['seller_id']=session('SellerId');
        $str=0;

        foreach ($taskid as $vo){
            $res=$taskModel->where($vo)->find();
            $str=$str+$res['allmoney'];
        }

        $last=$balanceModel->where($seller)->find();
        $money['seller_money']=$str+$last['seller_money'];
        $balanceModel->where($seller)->save($money);
        $a['task_id'] = array('in',$taskid);
        $value = $taskModel->where($a)->delete();
        if ($value){
            echo 1;
            die;
        }
        echo 2;
    }

    /*
     * ajax调取数据
     */
    public function getConfigs(){
        $navid=I('configId');


        //实例化导航
        $navModel=D('navigation');
        //取id，任务名
        $nav= $navModel->selectNavigationById($navid);
        $navconfigs=$nav['nav_title'];
        $navimg=$nav['nav_url'];
        $navid=$nav['nav_id'];
        if(empty($navimg))
        {
            $aaa=0;
        }
        else {$aaa=1;}
        $navconfig=explode(',',$navconfigs);
        $str='';

        foreach( $navconfig as $v){
            $str.="<lable><input value=" .$v." type='text'   readonly='true' name='taskkey[]' style='backgroud:#fff; width:200px; border:0px ; border: 0px;' ></lable>";
            $str.='<input type="text"  name="taskvalue[]">';
            $str.='<br>';
        }

        $userdata = array(
            'status' => C('JSON_SUCCESS_CODE'),
            'content' => $str,
            'uploadimg'=>$navimg,
            'id'=>$navid,
        );
        
        $this->ajaxReturn($userdata);

    }


    /*
     * ajax调取数据
     */
    public function getConfigsEdit(){         
                
        $taskid=I('taskid');
        
        $tasksModel=D('Tasks');
                
        $tasks=$tasksModel->selectTasksById($taskid);
        
        $configs=explode(';',$tasks[tasks_configs]);
        
        //var_dump($tasks[tasks_configs]);
        
        $str='';
        
        for($i = 0;$i < count($configs);$i++){
            
            $subConfig = explode(':',$configs[$i]);
            
            $str.="<lable><input value=".$subConfig[0]." type='text'   readonly='true' name='taskkey[]' style='backgroud:#fff; width:200px; border:0px ; border: 0px;' ></lable>";
            $str.="<input type='text'  name='taskvalue[]' value='".$subConfig[1]."'>";
            $str.="<br>";
        }
        
        
        

        $userdata = array(
            'status' => C('JSON_SUCCESS_CODE'),
            'content' => $str,
        );
        //$string="";
        
        
        //for($i=1;$i<=3;$i++)
        //{
        //    $string.="<input type='file' name='tasks[]' id='tasks'/>";
        //}
        
        
        $this->ajaxReturn($userdata);
        
        

    }

    /**
     * 编辑任务
     */
    public function editTasks()
    {

        if (IS_POST) {
            //接受POST传递过来的值

            $tasksid = I('tasksid');
            
            $groupid = I('tasksgroupid');
            $navid=I('navid');
            //实例化导航
            $navModel = D('navigation');
            //取id，任务名
            $nav = $navModel->selectNavigationById($navid);
            
            //实例化TasksGroup模型
            $taskModel = D('Tasks');
            //查找任务分组表中所有的数据
            $task = $taskModel->selectAllTasks();
            $navLen = count($nav);
            if($navLen > 0){
                $this->assign('firstNavId',$nav[0]['nav_id']);
            }

            //实例化TasksGroup类
            $tasksgroupModel = D('TasksGroup');
            //取id，组名
            $tasksgroup = $tasksgroupModel->selectTasksGroupById($groupid);
            $groupname = $tasksgroup['group_name'];


            $tasksname = $nav['nav_name'];
            if(I('taskkey')!=" "&&I('taskvalue')!=" ")
            {
                $taskskey = I('taskkey');
                $tasksvalue = I('taskvalue');
            }


            $taskstatus = I('taskstutas');


            $taskName = I('taskname');
            $taskTitle = I('tasktitle');
            $taskKeywords = I('taskkeywords');
            $taskDescription = I('taskdescription');


            $str = '';
            $index = 1;


            for ($i = 0; $i < count($taskskey); $i++) {
                if ($index != 1) {
                    $str .= ";";
                }
                $str = $str . $taskskey[$i] . ":" . $tasksvalue[$i];

                $index++;
            }


            for ($i = 0; $i++; $i < len($tasksvalue)) {

            }

            //调用上传图片的方法
            $file = $_FILES['taskpic'];
            $info = upload_img($file);
            //获取上传路径
            $taskPic = $info['savepath'] . $info['savename'];

            $taskContent = I('taskcontent');
            $taskbrowse = I('taskbrowse');
            $taskclick = I('taskclick');
            $taskauthor = I('taskauthor');
            $taskSummary = I('tasksummary');
            $taskaddTime = I('taskaddtime');
            $tasksnumber=I('tasksnumber');
            //接收到的值不能为空

            //封装数据


            $data['group_name'] = $groupname;
            $data['tasks_name'] = $taskName;
            $data['tasks_status'] = $taskstatus;

            $data['tasks_configs'] = $str;

            $data['task_title'] = $taskTitle;
            $data['task_keywords'] = $taskKeywords;
            $data['task_pic'] = $taskPic;
            $data['task_description'] = $taskDescription;
            $data['task_content'] = $taskContent;
            $data['task_summary'] = $taskSummary;
            $data['task_browse'] = $taskbrowse;
            $data['task_click'] = $taskclick;
            $data['task_author'] = $taskauthor;
            $data['tasks_number']=$tasksnumber;
            if (empty($taskaddTime)) {
                $data['task_addtime'] = time();
            } else {
                $data['task_addtime'] = strtotime($taskaddTime);
            }

            //实列化Tasks模型
            $taskModel = D('Tasks');
            //添加任务信息
            $result = $taskModel->saveTask($tasksid,$data);
            //返回添加结果
            if ($result) {
                //管理员操作记录到日志表中
                $logcontent = C('SYS_LOG_ACTION_ADD') . "任务管理添加成功。" . "任务名：" . $taskName;
                sys_log(session('adminId'), session('adminName'), $logcontent);

                $this->success(L('ADD_ARTICLE_SUCCESS'), U('Tasks/listtasks'));
            } else {
                //管理员操作记录到日志表中
                $logcontent = C('SYS_LOG_ACTION_ADD') . "任务管理添加失败。" . "任务名：" . $taskName;
                sys_log(session('adminId'), session('adminName'), $logcontent);

                $this->error(L('ADD_ARTICLE_FAILURE'));
            }
        } else {
                $tasksid=I('tasksid');
                $data['tasks_id']=$tasksid;
                $user=M('tasks')->where($data)->find(); 
                $name=$user["tasks_name"];
                $data['nav_name']=$name;
                $navuser=M('navigation')->where($data)->find();
                $navname=$navuser["nav_url"];
                $this->assign('tasksid',$tasksid);
                $this->assign('navname',$navname);
                $tasksModel=D('Tasks');
                $tasks=$tasksModel->selectTasksById($tasksid);
                $data['nav_name']=$tasks['tasks_name'];
 
                //实例化导航
                $navModel = D('navigation');
                //取id，任务名
                //实例化TasksGroup模型
                $taskModel = D('Tasks');
                //查找任务分组表中所有的数据
                $task = $taskModel->selectAllTasks();
                $navLen = count($nav);
                if($navLen > 0){
                    $this->assign('firstNavId',$nav[0]['nav_id']);
                }
                //实例化TasksGroup类
                $tasksgroupModel = D('TasksGroup');
                //取id，组名
                $tasksgroup = $tasksgroupModel->selectAllTasksGroups();
                //实例化TasksGroup模型
                $taskModel = D('Tasks');
                //查找任务分组表中所有的数据
                $task = $taskModel->selectAllTasks();
                //赋值到模版
                $this->assign('tasks',$tasks);
                $this->assign('nav', $nav);
                $this->assign('tasksgroup', $tasksgroup);
                $this->assign('task', $task);
                $this->assign('tasksid',$tasksid);
                $this->display();
            }
    }

    /**
     * 任务分组界面
     */
    public function listTaskGroups() {
        //实列化Tasks模型
        $taskGroupModel = D('TasksGroup');
        //获取总的任务数
        $data['ag_id'] = session('AgentId');
        //获取每页显示的数据集
        $count = $taskGroupModel->selectTasksGroupTotalSize($data);
        //实例化分页类
        $page = new \Org\Page\Page($count,$this->adminPageSize);
        //获取每页显示的数据集
        $tasksGroup = $taskGroupModel->selectTasksGroupByPage($data,$page);
        //分页显示输出
        $show = $page->show();
        $this->assign('value','设备分组');
        $this->assign('tasksGroup', $tasksGroup);
        $this->assign('count', $count);
        $this->assign('page', $show);
        $this->display('Tasks/listtaskgroups');
    }
    /**
     * 添加任务分组的方法
     */
    public function addTaskGroup(){
        if (IS_POST) {
            //接受POST传递过来的值
            $groupName = I('groupname');
            $equlist = I('equlist');
            $taskKeywords = I('taskkeywords');
            $taskDescription = I('taskdescription');
            $groupId = I('groupid');
            //调用上传图片的方法
            $file = $_FILES['taskpic'];
            $info = upload_img($file);
            //获取上传路径
            $taskPic = $info['savepath'] . $info['savename'];
            $taskContent = I('taskcontent');
            $taskbrowse=I('taskbrowse');
            $taskclick=I('taskclick');
            $taskauthor=I('taskauthor');
            $taskSummary = I('tasksummary');
            $taskaddTime=I('taskaddtime');
            //接收到的值不能为空
            if (empty($groupName)) {
                $this->error('任务分组名称不能为空');
            }
            if (empty(  $equlist)) {
                $this->error('设备列表不能为空');
            }
            //封装数据
            $data['group_name'] =$groupName;
            $data['equlist'] = $equlist;
            $data['task_keywords'] = $taskKeywords;
            $data['group_id'] = $groupId;
            $data['task_pic'] = $taskPic;
            $data['task_description'] = $taskDescription;
            $data['task_content'] = $taskContent;
            $data['task_summary'] = $taskSummary;
            $data['task_browse']= $taskbrowse;
            $data['task_click']=$taskclick;
            $data['task_author']=$taskauthor;
            $data['admin_id'] = 46;
            $data['ag_id'] = session('AgentId');
            if(empty($taskaddTime)){
                $data['task_addtime'] = time();
            }else{
                $data['task_addtime']=strtotime($taskaddTime);
            }
            $array =  explode(',',$equlist);
            //添加设备信息
            foreach ($array as $va){
                $data1['equlist'] = $va;
                $data1['group_name'] = $groupName;
                $data1['admin_id'] = 46;
                $data1['ag_id'] = session('AgentId');
                $Grouping = D('Grouping');
                $Grouping->addUserGroup($data1);
            }
            //实列化Tasks模型
            $taskModel = D('TasksGroup');
            //添加任务信息
            $result = $taskModel->addTasksGroup($data);
            //返回添加结果
            if ($result) {
                $this->success(L('ADD_ARTICLE_SUCCESS'), U('Tasks/listtaskGroups'));
            } else {
                $this->error(L('ADD_ARTICLE_FAILURE'));
            }
        } else{
            //实例化TasksGroup模型
            $taskGroupModel = D('TasksGroup');
            //查找任务分组表中所有的数据
            $taskGroup = $taskGroupModel->selectAllTasksGroups();
            //赋值到模版
            $this->assign('taskgroup', $taskGroup);
            $this->display('Tasks/addtaskGroup');
        }
    }

    /**
     * 删除任务分组的方法
     */
    public function deleteTaskGroup() {
        if (IS_GET){
            //接受GET传递过来的值
            $taskGroupId = I('taskGroupid');
            //实列化Tasks模型
            $taskGroupModel = D('TasksGroup');
            $Grouping = D('Grouping');
            $a['group_id']=$taskGroupId;
            $taskGroupModel1 =$taskGroupModel->where($a)->select();
            $arr = explode(',',$taskGroupModel1[0]['equlist']);
            foreach ($arr as $va){
                $b['equlist']=$va;
                $Grouping->where($b)->delete();

            }

            //查找任务表中task_id为$taskId的一条数据
            $task =  $taskGroupModel->selectTasksGroupById($taskGroupId);
            // 删除任务表中task_id为$taskid的一条数据
            $result = $taskGroupModel->deleteTasksGroupById($taskGroupId);
            if ($result) {

                $this->success(L('DELTE_ARTICLE_SUCCESS'), U('Tasks/listtaskGroups'));
            } else {

                $this->error(L('DELTE_ARTICLE_FAILURE'));
            }
        }
    }

    /**
     * 编辑任务分组
     */
    public function editTaskGroup() {
        if (IS_POST) {
            //接受POST传递过来的参数
            $taskGroupId = I('taskGroupid');
            $groupName = I('groupname');
            $equlist = I('equlist');
            $taskDescription = I('taskdescription');

            // 调用上传图片的方法
            $file = $_FILES['taskpic'];
            $info = upload_img($file);
            //获取上传路径
            if ($info) {
                $taskPic = $info['savepath'] . $info['savename'];
            } else {
                $taskPic = $_FILES['taskpic'];
            }
            $taskContent = I('taskcontent');
            $taskSummary = I('tasksummary');
            $taskaddtime=I('taskaddtime');

            //接收到的值不能为空
            if (empty($groupName)) {
                $this->error('任务分组名称不能为空');
            }
            if (empty( $equlist)) {
                $this->error('配置列表不能为空');
            }
            //封装数据
            $data['group_name'] = $groupName;
            $data['equlist'] = $equlist;
            $data['group_id'] = $taskGroupId;
            $data['task_pic'] = $taskPic;
            $data['task_description'] = $taskDescription;
            $data['task_content'] = $taskContent;
            $data['task_summary'] = $taskSummary;
            if(empty($taskaddtime)){
                $data['task_addtime'] = time();
            }else{
                $data['task_addtime']=strtotime($taskaddtime);
            }
            //修改设备信息先删后插入
            $Grouping = D('Grouping');
            $a['group_id']=$taskGroupId;
            $taskGroupModel = D('TasksGroup');
            $taskGroupModel1 =$taskGroupModel->where($a)->select();
            $arr = explode(',',$taskGroupModel1[0]['equlist']);
            foreach ($arr as $va){
                $b['equlist']=$va;
                $Grouping->where($b)->delete();
            }
            $array =  explode(',',$equlist);
            foreach ($array as $va){
                $data1['equlist'] = $va;
                $data1['group_name'] = $groupName;
                $data1['admin_id'] = 46;
                $data1['ag_id'] = session('AgentId');
                $Grouping = D('Grouping');
                $Grouping->addUserGroup($data1);
            }

            //实列化Tasks模型
            $taskModel = D('TasksGroup');
            //添加任务信息
            $result = $taskModel->saveAriticle($taskGroupId, $data);
            //返回编辑结果
            if ($result) {

                $this->success(L('EDIT_ARTICLE_SUCCESS'), U('Tasks/listtaskgroups'));
            } else {

                $this->error(L('EDIT_ARTICLE_FAILURE'));
            }
        } else{

            //接受GET传递过来的参数
            $taskGroupId = I('taskGroupid');

            //实列化Tasks模型
            $taskModel = D('TasksGroup');
            // //实例化TasksGroup模型
            $taskGroupModel = D('TasksGroup');

            //查找任务表中task_id为$taskId的一条数据
            $taskgroup = $taskGroupModel->selectTasksGroupById($taskGroupId );

            //赋值到模版
            $this->assign('taskgroup', $taskgroup);
            $this->display();
        }
    }
//map api
       public function getlocation2(){
        if(IS_GET){
            $keyword=I('keyword');
            $flie = "http://apis.map.qq.com/ws/geocoder/v1/?address=".$keyword."&key=AYTBZ-ZREKJ-ATVF3-FWMEW-FFXC5-CVF5Y";

            $arr = get($flie,'array');
            $jinwei = $arr['result']['location'];
            // $this->assign('location',$html);//将获取的值传到搜索框
            $this->assign('jinwei',$jinwei);
            $this->display('Tasks/map3');
        }else{
            $keyword=I('keyword');
            $shownum=I('shownum');//yao xian shi de tiao shu
//根据地址搜索经纬度
            $flie = "http://apis.map.qq.com/ws/geocoder/v1/?address=".$keyword."&key=AYTBZ-ZREKJ-ATVF3-FWMEW-FFXC5-CVF5Y";
            $arr = get($flie,'array');
//根据搜索地址的经纬度再查找附近的小区
            $arrA=['小区','大厦','写字楼','街道','公司','饭店','餐厅','酒店','旅社','酒吧','网吧','工厂','医院','咖啡馆','小吃街'];
            $arr2=[];
            $ran=mt_rand(0,count($arrA)-1);
            for($i=0;$i<count($arrA);$i++){
                    $file2="http://apis.map.qq.com/ws/place/v1/search?boundary=region(".$keyword.",1)&keyword=".$arrA[$i]."&page_size=20&page_index=1&orderby=_distance&key=AYTBZ-ZREKJ-ATVF3-FWMEW-FFXC5-CVF5Y";
                    $arr2s = get($file2,'array');
                $arr2[]=array_merge($arr2s);
            }
            $addr="";

                if(!empty($shownum)){
                    $a=[];
                    for ($i=0; $i < $shownum+5; $i++) {
                        $rnum=mt_rand(0,count($arr2)-1);
//                        print_r($arr2[$rnum]);
                        $rnum1=mt_rand(0,count($arr2[$rnum])-1);
                        $random=mt_rand(1,20);//栋
                        $random2=mt_rand(1,20);//层
                        $random3=mt_rand(1,4);//室
                        $random4=mt_rand(1,3);//随机值
                        $up=['A','B','C','D'];

                        if(!in_array($arr2[$rnum]['data'][$rnum1]['title'],$a)){
                            if (!empty($arr2[$rnum]['data'][$rnum1]['title'])){
                            $a[]=$arr2[$rnum]['data'][$rnum1]['title'];
                            if($rnum == 0){
                                if($random4==1){
                                    $addr=$addr."<li class='pull-left' style='padding: 10px'>".$arr['result']['address_components']['province'].'||'.$arr['result']['address_components']['city'].'||'.$arr['result']['address_components']['district'].'||'.$arr2[$rnum]['data'][$rnum1]['title'].$random."栋".$random2.'0'.$random3."室</li>";
                                }
                                elseif($random4==2){
                                    $addr=$addr."<li class='pull-left' style='padding: 10px'>".$arr['result']['address_components']['province'].'||'.$arr['result']['address_components']['city'].'||'.$arr['result']['address_components']['district'].'||'.$arr2[$rnum]['data'][$rnum1]['title'].$random2.'0'.$random3."公寓</li>";
                                }
                                elseif ($random4==3){
                                    $addr=$addr."<li class='pull-left' style='padding: 10px'>".$arr['result']['address_components']['province'].'||'.$arr['result']['address_components']['city'].'||'.$arr['result']['address_components']['district'].'||'.$arr2[$rnum]['data'][$rnum1]['title'].$random2.'单元'.$up[$random4]."座</li>";
                                }
                                else{
                                    $addr=$addr."<li class='pull-left' style='padding: 10px'>".$arr['result']['address_components']['province'].'||'.$arr['result']['address_components']['city'].'||'.$arr['result']['address_components']['district'].'||'.$arr2[$rnum]['data'][$rnum1]['title'].'对面'.$up[$random4]."座</li>";
                                }
                            }elseif ($rnum==1){
                                if ($random4==1){
                                    $addr=$addr."<li class='pull-left' style='padding: 10px'>".$arr['result']['address_components']['province'].'||'.$arr['result']['address_components']['city'].'||'.$arr['result']['address_components']['district'].'||'.$arr2[$rnum]['data'][$rnum1]['title'].$random."号楼".$random2.'0'.$random3."</li>";
                                }
                                elseif($random4==2){
                                    $addr=$addr."<li class='pull-left' style='padding: 10px'>".$arr['result']['address_components']['province'].'||'.$arr['result']['address_components']['city'].'||'.$arr['result']['address_components']['district'].'||'.$arr2[$rnum]['data'][$rnum1]['title'].$random2.'0'.$random3."公寓</li>";
                                }
                                elseif ($random4==3){
                                    $addr=$addr."<li class='pull-left' style='padding: 10px'>".$arr['result']['address_components']['province'].'||'.$arr['result']['address_components']['city'].'||'.$arr['result']['address_components']['district'].'||'.$arr2[$rnum]['data'][$rnum1]['title'].$random2.'单元'.$up[$random4]."座</li>";
                                }
                                else{
                                    $addr=$addr."<li class='pull-left' style='padding: 10px'>".$arr['result']['address_components']['province'].'||'.$arr['result']['address_components']['city'].'||'.$arr['result']['address_components']['district'].'||'.$arr2[$rnum]['data'][$rnum1]['title'].'对面'.$up[$random4]."座</li>";
                                }
                            }elseif($rnum==2){
                                if ($random4==1){
                                    $addr=$addr."<li class='pull-left' style='padding: 10px'>".$arr['result']['address_components']['province'].'||'.$arr['result']['address_components']['city'].'||'.$arr['result']['address_components']['district'].'||'.$arr2[$rnum]['data'][$rnum1]['title'].'('.$random."幢".$random2.'0'.$random3.")</li>";
                                }
                                elseif($random4==2){
                                    $addr=$addr."<li class='pull-left' style='padding: 10px'>".$arr['result']['address_components']['province'].'||'.$arr['result']['address_components']['city'].'||'.$arr['result']['address_components']['district'].'||'.$arr2[$rnum]['data'][$rnum1]['title'].$random2.'0'.$random3."公寓</li>";
                                }
                                elseif ($random4==3){
                                    $addr=$addr."<li class='pull-left' style='padding: 10px'>".$arr['result']['address_components']['province'].'||'.$arr['result']['address_components']['city'].'||'.$arr['result']['address_components']['district'].'||'.$arr2[$rnum]['data'][$rnum1]['title'].$random2.'单元'.$up[$random4]."座</li>";
                                }
                                else{
                                    $addr=$addr."<li class='pull-left' style='padding: 10px'>".$arr['result']['address_components']['province'].'||'.$arr['result']['address_components']['city'].'||'.$arr['result']['address_components']['district'].'||'.$arr2[$rnum]['data'][$rnum1]['title'].'对面'.$up[$random4]."座</li>";
                                }
                            }
//                            elseif($rnum=3){
//                                $addr=$addr."<li class='pull-left' style='padding: 10px'>".$arr['result']['address_components']['province'].'||'.$arr['result']['address_components']['city'].'||'.$arr['result']['address_components']['district'].'||'.$arr2[$rnum]['data'][$rnum1]['title'].$random."号</li>";
//                            }
                            elseif($rnum==3){
                                if ($random4==1){
                                    $addr=$addr."<li class='pull-left' style='padding: 10px'>".$arr['result']['address_components']['province'].'||'.$arr['result']['address_components']['city'].'||'.$arr['result']['address_components']['district'].'||'.$arr2[$rnum]['data'][$rnum1]['title'].$random2."楼".$random.'单元'.$random3."号</li>";
                                } elseif($random4==2){
                                    $addr=$addr."<li class='pull-left' style='padding: 10px'>".$arr['result']['address_components']['province'].'||'.$arr['result']['address_components']['city'].'||'.$arr['result']['address_components']['district'].'||'.$arr2[$rnum]['data'][$rnum1]['title'].$random2.'0'.$random3."公寓</li>";
                                }
                                elseif ($random4==3){
                                    $addr=$addr."<li class='pull-left' style='padding: 10px'>".$arr['result']['address_components']['province'].'||'.$arr['result']['address_components']['city'].'||'.$arr['result']['address_components']['district'].'||'.$arr2[$rnum]['data'][$rnum1]['title'].$random2.'单元'.$up[$random4]."座</li>";
                                }
                                else{
                                    $addr=$addr."<li class='pull-left' style='padding: 10px'>".$arr['result']['address_components']['province'].'||'.$arr['result']['address_components']['city'].'||'.$arr['result']['address_components']['district'].'||'.$arr2[$rnum]['data'][$rnum1]['title'].'对面'.$up[$random4]."座</li>";
                                }
                            }
                            elseif($rnum==4){
                                if ($random4==1){
                                    $addr=$addr."<li class='pull-left' style='padding: 10px'>".$arr['result']['address_components']['province'].'||'.$arr['result']['address_components']['city'].'||'.$arr['result']['address_components']['district'].'||'.$arr2[$rnum]['data'][$rnum1]['title']."隔壁".$random2."号楼</li>";
                                }elseif($random4==2){
                                    $addr=$addr."<li class='pull-left' style='padding: 10px'>".$arr['result']['address_components']['province'].'||'.$arr['result']['address_components']['city'].'||'.$arr['result']['address_components']['district'].'||'.$arr2[$rnum]['data'][$rnum1]['title'].$random2.'0'.$random3."公寓</li>";
                                }
                                elseif ($random4==3){
                                    $addr=$addr."<li class='pull-left' style='padding: 10px'>".$arr['result']['address_components']['province'].'||'.$arr['result']['address_components']['city'].'||'.$arr['result']['address_components']['district'].'||'.$arr2[$rnum]['data'][$rnum1]['title'].$up[$random4]."座</li>";
                                }
                                else{
                                    $addr=$addr."<li class='pull-left' style='padding: 10px'>".$arr['result']['address_components']['province'].'||'.$arr['result']['address_components']['city'].'||'.$arr['result']['address_components']['district'].'||'.$arr2[$rnum]['data'][$rnum1]['title'].'对面'.$up[$random4]."座</li>";
                                }
                            }
                            else{
                                if ($random4==1){


                                    $addr=$addr."<li class='pull-left' style='padding: 10px'>".$arr['result']['address_components']['province'].'||'.$arr['result']['address_components']['city'].'||'.$arr['result']['address_components']['district'].'||'.$arr2[$rnum]['data'][$rnum1]['title'].$random2."#".$random.'单元'.$random3."房</li>";
                                }elseif($random4==2){
                                    $addr=$addr."<li class='pull-left' style='padding: 10px'>".$arr['result']['address_components']['province'].'||'.$arr['result']['address_components']['city'].'||'.$arr['result']['address_components']['district'].'||'.$arr2[$rnum]['data'][$rnum1]['title'].$random2.'0'.$random3."公寓</li>";
                                }
                                elseif ($random4==3){
                                    $addr=$addr."<li class='pull-left' style='padding: 10px'>".$arr['result']['address_components']['province'].'||'.$arr['result']['address_components']['city'].'||'.$arr['result']['address_components']['district'].'||'.$arr2[$rnum]['data'][$rnum1]['title'].$random2."单元</li>";
                                }
                                else{
                                    $addr=$addr."<li class='pull-left' style='padding: 10px'>".$arr['result']['address_components']['province'].'||'.$arr['result']['address_components']['city'].'||'.$arr['result']['address_components']['district'].'||'.$arr2[$rnum]['data'][$rnum1]['title'].$up[$random4]."栋</li>";
                                }
                            }
                        }
                else{
                        foreach ($arr2['data'] as $key){
                            $random=mt_rand(1,20);//栋
                            $random2=mt_rand(1,20);//层
                            $random3=mt_rand(1,4);//室
                            $addr=$addr."<li class='pull-left' style='padding: 10px'>".$arr['result']['address_components']['province'].'||'.$arr['result']['address_components']['city'].'||'.$arr['result']['address_components']['district'].'||'.$key['title'].'('.$random."栋".$random2.'0'.$random3."室)"."</li>";
                        }
                    }
                        }
                           }
                }

            $data=['error'=>true,'data'=>$addr];
            echo json_encode($data);
        }
    }

    public function addrSearch(){
        $this->display('Tasks/map3');
    }

    public function addto(){
        $idModel=D('id_card');
        $copyModel=D('id_cardcopy');//地址库副本
        $firstModel=D('firstname');//名
        $lastModel=D('lastname');//姓
        $count=$firstModel->count();//名
        $count2=$lastModel->count();//姓
        
        $str=I('str');
        //dump($str);
        $val=explode(",", $str);
        //dump($val);die;
        foreach ($val as $key=>$value) {
            $random=mt_rand(1,$count);//名
            $random1=mt_rand(1,$count);//名
            $random2=mt_rand(1,$count2);//姓
            $con['id']=$random;
            $con1['id']=$random1;
            $con2['last_id']=$random2;
            $num=mt_rand(1,2);
            if(!empty($value)){
                $r=explode("||",$value);
            $first1=$firstModel->where($con1)->find(); //名
               $first=$firstModel->where($con)->find(); //名
               $last=$lastModel->where($con2)->find(); //姓
               if($num==1){
                    $data['card_name']=$last['lastname'].$first['firstname'];  
               }else{
                    $data['card_name']=$last['lastname'].$first['firstname'].$first1['firstname'];
               }
               $cc['card_path']=$r[0].$r[1].$r[2].$r[3];//判断是否重复
                $cc1['card_path']=$cc['card_path'];
               $rr=$idModel->where($cc1)->select();
               if(empty($rr)){
               $rr1=$copyModel->where($cc1)->select();
                if(empty($rr1)){
                   $data['card_product']=$r[0];
                    $data['card_city']=$r[1];
                    $data['admin_id'] = session('adminId');
                    $data['card_area']=$r[2];
                    $data['card_path']=$r[2].$r[3];     
                    $res=$idModel->add($data);
                    $res1=$copyModel->add($data);
               }
               }
                
            }             
    }
    if($res){
    echo 1;}
else{
    echo 2;
    }

}
}