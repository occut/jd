<?php
/**
 * Created by PhpStorm.
 * User: occur
 * Date: 2017/7/9
 * Time: 18:49
 */
namespace Agent\Controller;

use Think\Controller;
use Think\Model;

class AgentController extends SuperController {

    public function index(){
        //实例化UserGroup模型
        $AgentModel = D('Agent');
        //获取总的用户数
        if(session('adminId') != 46){
            $data['ag_admin'] = session('adminId');
        }
        $count = $AgentModel::selectSize($data);
        //实例化分页类
        $page = new \Org\Page\Page($count, 100);
        //获取每页显示的数据集
        $Agent = $AgentModel::selectByPages($data,$page);
        //分页显示输出
        $show = $page->show();
        //管理员操作记录到日志表中
        $logcontent = C('SYS_LOG_ACTION_SELECT') . "二级代理查询成功。";
        sys_log(session('adminId'), session('adminName'), $logcontent);
        //赋值到模版
        $this->assign('Agent', $Agent);
        $this->assign('count', $count);
        $this->assign('page', $show);
        $this->assign('value', '二级代理');
        $this->display('Agent/listAgent');
    }
    /*
     * 添加
     */
    public function create(){
        if(IS_GET) {
        $this->display('Agent/addAgent');
        }else{
            $data = $this->data();
            //实例化UserGroup模型
            $AgentModel = D('Agent');
            $value = $AgentModel::addAgent($data);
            $AccountBalance = D('AccountBalance');
            if($value){
                $a['ba_name'] = $value;
                $a['ba_admin_id'] = session('adminId');
                $AccountBalance->add($a);
                //管理员操作记录到日志表中
                $logcontent = C('SYS_LOG_ACTION_ADD')."代理添加成功。" . "用户名：" .$data['adminname'];
                sys_log(session('adminId'),session('adminName'),$logcontent);
                $this->success(L('ADD_ADMIN_SUCCESS'), U('Agent/index'));
            }else {
                //管理员操作记录到日志表中
                $logcontent = C('SYS_LOG_ACTION_ADD')."代理添加失败。" . "用户名：" .$data['adminname'];
                sys_log(session('adminId'),session('adminName'),$logcontent);
                $this->error(L('ADD_ADMIN_FAILURE'));
            }
        }
    }
    /*
     * 删除
     */
    public function dell(){
        $id = I('id');
        $AgentModel = D('Agent');
        $a['ag_id'] = $id;
        $value = $AgentModel->where($a)->delete();
        $b['ba_name'] = $id;
        D('AccountBalance')->where($b)->delete();
        if($value){
            $this->success(L('删除成功'));
        }else{
            $this->error(L('删除失败'));
        }
    }
    //yefan_account_number
    public function account(){
        $AccountNumber =  D('AccountNumber');
        //获取总的用户数
        if(session('adminId') != 46){
            $data['ac_admin_id'] = session('adminId');
        }
        $count = $AccountNumber::selectSize($data);
        //实例化分页类
        $page = new \Org\Page\Page($count, 100);
        //获取每页显示的数据集
        $Agent = $AccountNumber::selectByPages($data,$page);
        //分页显示输出
        $show = $page->show();
        //管理员操作记录到日志表中
        $logcontent = C('SYS_LOG_ACTION_SELECT') . "二级代理查询成功。";
        sys_log(session('adminId'), session('adminName'), $logcontent);
        //赋值到模版
        $this->assign('Agent', $Agent);
        $this->assign('count', $count);
        $this->assign('page', $show);
        $this->assign('value', '二级代理');
        $this->display('Agent/listAccount');
    }
    /*
     * 余额管理
     */
    public function balance(){
        if(IS_GET) {
        $balance = session('balance');
        if(!empty($balance)){
            $AccountBalance = D('AccountBalance');
            //获取总的用户数
            if(session('adminId') != 46) $data['ba_admin_id'] = session('adminId');
            $count = $AccountBalance::selectSize($data);
            //实例化分页类
            $page = new \Org\Page\Page($count, 100);
            //获取每页显示的数据集
            $Agent = $AccountBalance::selectByPages($data,$page);
            //分页显示输出
            $show = $page->show();
            //管理员操作记录到日志表中
            $logcontent = C('SYS_LOG_ACTION_SELECT') . "二级代理查询成功。";
            sys_log(session('adminId'), session('adminName'), $logcontent);
            //赋值到模版
            $this->assign('Agent', $Agent);
            $this->assign('count', $count);
            $this->assign('page', $show);
            $this->assign('value', '余额管理');
            $this->display('Agent/listbalance');
        }else{
            $vo = rand(111111,999999);
            session('vo',$vo);
            $adminModel = D('Admin');
            $con = $adminModel->where(['admin_id'=>46])->find();
            $a = $con['admin_email'];
            $c = sendMail($a,'验证消息',"本次验证码是：$vo");
            $this->display('Agent/listmima');
        }
        }else{
            $vo = I('vo');
            $a = session('vo');
            if($a == $vo){
                session('balance',$vo);
                $this->success(L('成功'));
            }else{
                $this->error(L('失败'));
            }
        }
    }
    public function payment(){
        //实例化UserGroup模型
        $PaymentModel = D('Payment');
        $pa_name = I('tiao');
        $start = I('startTime');
        $end = I('endTime');
        if(!empty($pa_name)) $data['pa_name'] = array('like','%'.$pa_name.'%');
        if(!empty($start) and empty($end)) $data['pa_time']=array(array('gt',$start),array('lt',$end));
        //获取总的用户数
        if(session('adminId')!= 46) $data['admin_id'] = session('adminId');
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

    public function Import(){
        if($_GET){
            $id = I('pa_id');
            $PaymentModel = D('Payment');
            $a['pa_id'] = $id;
            $con = $PaymentModel->where($a)->find();
            if($con['pa_static'] != 1) $this->error(L('账单已提交'));
            $this->assign('value', '余额管理');
            $this->assign('pa_id', $id);
            $this->display('Agent/payment');
        }else{
            $title = I('title');
            $id = I('id');
            $PaymentModel = D('Payment');
            $a['pa_id'] = $id;
            $con = $PaymentModel->where($a)->find();
            $data['pa_static'] = 0;
            $PaymentModel->where($a)->save($data);
            $AccountBalance = D('AccountBalance');
            $b['ba_name'] = $con['ag_id'];
            $vo = $AccountBalance->where($b)->find();
            $mone = $vo['ba_balance'];
            $dataa['ba_balance'] = $mone+$title;
            $dataa['ba_time'] = date('Y-m-d H:s:i');
            $value = $AccountBalance->where($b)->save($dataa);
            if($value){
                $this->error(L('提交申请成功'));
            }else{
                $this->error(L('账单已提交'));
            }
        }

    }
    /*
     * 商家管理
     */
    public function management(){
        $Management = D('Management');
        //获取总的用户数
        $data['ag_ag'] = session('AgentId');
        $count = $Management::selectSize($data);
        //实例化分页类
        $page = new \Org\Page\Page($count, 100);
        //获取每页显示的数据集
        $Agent = $Management::selectByPages($data,$page);
        //分页显示输出
        $show = $page->show();
        //赋值到模版
        $this->assign('Agent', $Agent);
        $this->assign('count', $count);
        $this->assign('page', $show);
        $this->assign('value', '商家管理');
        $this->display('Agent/listmanagement');
    }
    /*
     * 修改密码
     */
    public function ModifyPassword(){
        if($_GET) {
            $id = I('id');
            $this->assign('id', $id);
            $this->display('Agent/ModifyPassword');
        }else{
            $id = I('id');
            $pass = I('pass');
            $lpass = I('lpass');
            $Management = D('Management');
            if($pass != $lpass) $this->error(L('两次密码不一致'));
            $a['ag_id'] = $id;
            $data['ag_pw'] = admin_md5($lpass);
            $value = $Management->where($a)->save($data);
            if($value){
                $this->success(L('修改成功'),U('Agent/management'));
            }else{
                $this->error(L('修改失败'));
            }
        }
    }
    /*
     * 修改状态
     */
    public function modifystate(){
        $id         = I('id');
        $Management = D('Management');
        $a['ag_id'] = $id;
        $value  = $Management->where($a)->find();
        $ban    = $value['ag_ban']==1?0:1;
        $data['ag_ban'] = $ban;
        $value = $Management->where($a)->save($data);
        if($value){
            $this->success(L('修改成功'),U('Agent/management'));
        }else{
            $this->error(L('修改失败'));
        }

    }
    /*
     * 添加店铺
     */
    public function addmanagement(){
        $this->display('Agent/addmanagement');
    }
    /*
     * 保存店铺
     */
    public function createmanagement(){
        $data = I('');
        $Management = D('Management');
        $a['ag_name'] = $data['adminname'];
        $result =$Management->where($a)->find();
        $adminModel = D('Agent');
        $admin['ag_id'] = session('AgentId');
        $vl = $adminModel->where($admin)->find();
        if(!empty($result)) return false;
        $a['ag_pw'] = admin_md5($data['adminpass']);
        $a['ag_mb'] = $data['adminemail'];
        $a['ag_phone'] = $data['adminmobile'];
        $a['ag_ban'] = $data['adminstatus'];
        $a['ag_time'] = date('Y-m-d H:i:s');
        $a['ag_admin'] = $vl['ag_admin'];
        $a['ag_ag'] = session('AgentId');
        $result = $Management->add($a);
        if($result){
            $this->success(L('添加成功'),U('Agent/management'));
        }else{
            $this->error(L('添加失败'));
        }
    }
    public function selectmanagement(){
        $a = I('id');
        $Management = D('Management');
        $con = $Management

            ->where(['yefan_management.ag_id'=>$a])
            ->join('yefan_shop ON yefan_shop.seller_id = yefan_management.ag_id')
            ->find();
        $this->assign('con', $con);
        $this->display('Agent/selectmanagement');
    }
//Address
    public function selectaddress(){
        $a = I('id');
        $Address = D('begin');
        $con = $Address
            ->join('LEFT JOIN yefan_shop as a ON a.id = yefan_begin.shop')
            ->join('LEFT JOIN yefan_province as b ON b.id = yefan_begin.province')
            ->join('LEFT JOIN yefan_city as c ON c.id = yefan_begin.city')
            ->where(['fid'=>$a])
            ->select();
//        dump($con);die;
        $this->assign('con', $con);
        $this->display('Agent/selectaddress');

    }
}