<?php
/**
 * Created by PhpStorm.
 * User: occur
 * Date: 2017/7/9
 * Time: 18:49
 */
namespace Agent\Controller;

use Think\Controller;

class WechatController extends SuperController {
    /**
     * 显示weichat用户  全部
     */
    public function WechaGroupsWhole() {
        $taskModel = D('SellerTask');//商家任务
        $data['status'] = 1;
        $data['ag_id'] = session('AgentId');

        $sellertask = $taskModel->where($data)->select();

        //实例化UserGroup模型
        $WechaModel = D('Weichat');
        $eqsModel=D('grouping');
        $eq['ag_id'] =session('AgentId');
        $options=$eqsModel->where($eq)->select();
        $taskModel = D('SellerTask');//商家任务
        $data['status'] = '1';
        $data['ag_id'] = session('AgentId');
        $sellertask = $taskModel->where($data)->select();
        //获取总的用户数
        $data['wei_data'] = 'jd';
        $data['agent_id'] = session('AgentId');
        //获取每页显示的数据集
        $count = $WechaModel->selectSize($data);
        //实例化分页类
        $page = new \Org\Page\Page($count, 100);
        $userGroups = $WechaModel->selectByPages($data,$page);
        //分页显示输出
        $show = $page->show();
        //赋值到模版
        $this->assign('usergroups', $userGroups);
        $this->assign('sellertask', $sellertask);
        $this->assign('alleqs', $options);
        $this->assign('count', $count);
        $this->assign('page', $show);
        $this->assign('sellertask', $sellertask);
        $this->assign('static','');
        $this->assign('id','');
        $this->assign('value', '全部账户');
        $this->display('Wechat/listWechatGroups');
    }
    /**
     * 显示weichat用户  正常
     */
    public function WechaGroups() {
        //实例化UserGroup模型
        $WechaModel = D('Weichat');
        $eqsModel=D('grouping');
        $eq['ag_id'] =session('AgentId');
        $options=$eqsModel->where($eq)->select();
        $this->assign('alleqs', $options);
        $taskModel = D('SellerTask');//商家任务
        $data['status'] = '1';
        $data['ag_id'] = session('AgentId');
        $sellertask = $taskModel->where($data)->select();
        $this->assign('sellertask', $sellertask);
        //获取总的用户数
        $data['wei_data'] = 'jd';
        $data['wei_static']= 0;
        $data['agent_id'] = session('AgentId');
        //获取每页显示的数据集
        $count = $WechaModel->selectSize($data);
        //实例化分页类
        $page = new \Org\Page\Page($count, 100);
        //获取每页显示的数据集
        $userGroups = $WechaModel->selectByPages($data,$page);
        //分页显示输出
        $show = $page->show();
        //赋值到模版
        $this->assign('usergroups', $userGroups);
        $this->assign('value', '正常账户');
        $this->assign('count', $count);
        $this->assign('page', $show);
        $this->assign('static',0);
        $this->assign('id',0);
        $this->display('Wechat/listWechatGroups');
    }
    /*
     * 已用账号
     */
    public function WechaGroupsLogin(){
        $this->assign('value', '使用中');
        $taskModel = D('SellerTask');//商家任务
        $data['status'] = '1';
        $data['ag_id'] = session('AgentId');
        $sellertask = $taskModel->where($data)->select();
        $this->assign('sellertask', $sellertask);
        //实例化UserGroup模型
        $WechaModel = D('Weichat');
        $eqsModel=D('grouping');
        $eq['ag_id'] =session('AgentId');
        $options=$eqsModel->where($eq)->select();
        //获取总的用户数
        $data['wei_data'] = 'jd';
        $data['wei_static']= 6;
        $data['agent_id'] = session('AgentId');
        //获取每页显示的数据集
        $count = $WechaModel->selectSize($data);
        //实例化分页类
        $page = new \Org\Page\Page($count, 100);
        //获取每页显示的数据集
        $userGroups = $WechaModel->selectByPages($data,$page);
        //分页显示输出
        $show = $page->show();
        //赋值到模版
        $this->assign('usergroups', $userGroups);
        $this->assign('alleqs', $options);
        $this->assign('count', $count);
        $this->assign('page', $show);
        $this->assign('static','');
        $this->assign('id',6);
        $this->display('Wechat/listWechatGroups');
    }
    /*
     * 账号异常
     */
    public function WechaAbnormal() {
        $this->assign('value', '账户异常');
        $taskModel = D('SellerTask');//商家任务
        $data['status'] = '1';
        $data['ag_id'] = session('AgentId');
        $sellertask = $taskModel->where($data)->select();
        $this->assign('sellertask', $sellertask);
        //实例化UserGroup模型
        $WechaModel = D('Weichat');
        $eqsModel=D('grouping');
        $eq['ag_id'] =session('AgentId');
        $options=$eqsModel->where($eq)->select();
        $this->assign('alleqs', $options);
        //获取总的用户数
        $data['wei_data'] = 'jd';
        $data['wei_static']= 5;
        $data['agent_id'] = session('AgentId');
        //获取每页显示的数据集
        $count = $WechaModel->selectSize($data);
        //实例化分页类
        $page = new \Org\Page\Page($count, 100);
        //获取每页显示的数据集
        $userGroups = $WechaModel->selectByPages($data,$page);
        //分页显示输出
        $show = $page->show();
        //赋值到模版
        $this->assign('usergroups', $userGroups);
        $this->assign('count', $count);
        $this->assign('page', $show);
        $this->assign('static',0);
        $this->assign('id',5);
        $this->display('Wechat/listWechatGroups');
    }
    /*
     * 收货异常
     */
    public function WechaGroupsDisable(){
        //实例化UserGroup模型
        $WechaModel = D('Weichat');
        $eqsModel=D('grouping');
        $eq['ag_id'] =session('AgentId');
        $options=$eqsModel->where($eq)->select();
        $taskModel = D('SellerTask');//商家任务
        $data['status'] = '1';
        $data['ag_id'] = session('AgentId');
        $sellertask = $taskModel->where($data)->select();
        $this->assign('sellertask', $sellertask);
        $this->assign('alleqs', $options);
        //获取总的用户数
        $data['wei_static']= 1;
        $data['agent_id'] = session('AgentId');
        //获取每页显示的数据集
        $count = $WechaModel->selectSize($data);
        //实例化分页类
        $page = new \Org\Page\Page($count, $this->adminPageSize);
        //获取每页显示的数据集
        $userGroups = $WechaModel->selectByPages($data,$page);
        //分页显示输出
        $show = $page->show();
        //赋值到模版
        $this->assign('value', '收货异常');
        $this->assign('usergroups', $userGroups);
        $this->assign('count', $count);
        $this->assign('page', $show);
        $this->assign('static',1);
        $this->assign('id',1);
        $this->display('Wechat/WechaGroupsDisable');
    }
    //导出
    public function WeExport(){
        $id=I('ids');
        if(empty($id)){
            $this->error(L('请勾选数据'));
        }
        $ids = explode(",",$id);
        array_pop($ids);
        //取出需要导出的数据
        $WechaModel = D('Weichat');
        $a['wei_id'] = array('in',$ids);
        $Wecha = $WechaModel->where($a)->select();
        vendor("PHPExcel.PHPExcel");
        $objExcel = new \PHPExcel();
        $objWriter = \PHPExcel_IOFactory::createWriter($objExcel, 'Excel5');
        $objExcel->getActiveSheet()->setCellValue('A1','手机号');
        $objExcel->getActiveSheet()->setCellValue('B1','账户');
        $objExcel->getActiveSheet()->setCellValue('C1','IP');
        $objExcel->getActiveSheet()->setCellValue('D1','地址');
        $objExcel->getActiveSheet()->setCellValue('E1','状态');
        $objExcel->getActiveSheet()->setCellValue('F1','评论');
        $objExcel->getActiveSheet()->setCellValue('G1','备注');
        $objExcel->getActiveSheet()->setCellValue('H1','设备');
        $objExcel->getActiveSheet()->setCellValue('I1','完成设备');
//        $objExcel->getActiveSheet()->setCellValue('J1','完成设备');
        $count = count($Wecha);//$driver 为数据库表取出的数据
        for ($i = 2; $i <= $count+1; $i++) {
            if($Wecha[$i-2]['wei_static'] == 0){
                $Wecha[$i-2]['wei_static'] = '正常';
            }elseif ($Wecha[$i-2]['wei_static'] == 2){
                $Wecha[$i-2]['wei_static'] = '登录中';
            }elseif ($Wecha[$i-2]['wei_static'] == 3){
                $Wecha[$i-2]['wei_static'] = '登录成功';
            }elseif ($Wecha[$i-2]['wei_static'] == 4){
                $Wecha[$i-2]['wei_static'] = '任务完成';
            }elseif ($Wecha[$i-2]['wei_static'] == 5){
                $Wecha[$i-2]['wei_static'] = '任务未完成';
            }else{
                $Wecha[$i-2]['wei_static'] = '禁用';
            }
            $objExcel->getActiveSheet()->setCellValue('A' . $i, $Wecha[$i-2]['wei_number']);
            $objExcel->getActiveSheet()->setCellValue('B' . $i, $Wecha[$i-2]['wei_name']);
            $objExcel->getActiveSheet()->setCellValue('C' . $i, $Wecha[$i-2]['wei_ip']);
            $objExcel->getActiveSheet()->setCellValue('D' . $i, $Wecha[$i-2]['wei_address']);
            $objExcel->getActiveSheet()->setCellValue('E' . $i, $Wecha[$i-2]['wei_static']);
            $objExcel->getActiveSheet()->setCellValue('F' . $i, $Wecha[$i-2]['comment']);
            $objExcel->getActiveSheet()->setCellValue('G' . $i, $Wecha[$i-2]['wei_remarks']);
            $objExcel->getActiveSheet()->setCellValue('H' . $i, $Wecha[$i-2]['wei_equipment']);
            $objExcel->getActiveSheet()->setCellValue('I' . $i, $Wecha[$i-2]['we_we']);
        }
        $objExcel->setActiveSheetIndex();
        header('Content-Type: applicationnd.ms-excel');
        header('Content-Disposition: attachment;filename="京东账户信息.xls"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        exit;
    }
    /*
     * 删除
     */
    public function deleteWechat(){
        $WechaModel = D('Weichat');
        $taskid=I('wei_id');
        $a['wei_id'] = $taskid;
        $value = $WechaModel->where($a)->delete();
        if($value){
            $this->success(L('删除成功'));
        }else{
            $this->error(L('删除失败'));
        }
    }
    /*
     * 批量删除
     */
    public function deleteWechats(){
        $WechaModel = D('Weichat');
        $taskid=I('ids');
        $a['wei_id'] = array('in',$taskid);
        $value = $WechaModel->where($a)->delete();
        if ($value){
            echo 1;
            return false;
        }
        echo 2;
    }
    /*
     * 更改状态
     */
    public function state(){
        $WechaModel = D('Weichat');
        $taskid=I('ids');
        $a['wei_id'] = array('in',$taskid);
        $data['wei_static'] = 0;
        $value = $WechaModel->where($a)->save($data);
        if ($value){
            echo 1;
        }else{
            echo 2;
        }

    }
// 显示评论
    public function  comment(){
        $WechaModel = D('Weichat');
        $wei_number = I('wei_id');//相当于 $_GET['wei_id']
        $data['wei_number']= $wei_number;
        $Weicha = $WechaModel->where($data)->find();
        $this->assign('data',$Weicha['comment']);
        $this->assign('number',$wei_number);
        $this->display('Wechat/comment');
    }

    public function  editComment(){
        $WechaModel = D('Weichat');
        $wei_id = I('wei_number');
        $comment = I('comment');
        $result = preg_split('/[;\r\n]+/s', $comment);
        $wei_ids = explode(",",$wei_id);
        foreach( $wei_ids as $k=>$v){
            if( empty($v) )
                unset( $wei_ids[$k] );
        }
        foreach( $result as $k=>$v){
            if( empty($v) )
                unset( $result[$k] );
        }
        //更新数据
        foreach ($result as $k=>$vo){
            $a['wei_id']= $wei_ids[$k];
            $data['comment'] =  $vo;
            $value = $WechaModel->where($a)->save($data);
        }
        //返回消息
        if($value){
            echo 1;
        }else{
            echo 1;
        }
    }
public function bindeqis(){
        $WechaModel = D('Weichat');
        $taskid=I('ids');//wechat
        $sid=I('id');//shebei
        $nubmer=I('nubmer');//shebei
        $sellertask=I('sellertask');//shebei
if(empty($sellertask)){
            echo 2;
            die;
        }
        $taskModel = D('SellerTask');//商家任务
        $data['task_id'] = $sellertask;
        $sellertask = $taskModel->where($data)->find();
//        dump($sellertask);die;
        if (empty($taskid) and !empty($nubmer)){
            $data['wei_static'] = 0;
            $data['wei_equipment'] = array('exp',' is NULL');
            $con = $WechaModel->where($data)->limit($nubmer)->order('wei_time desc')->select();
            $arr = [];
            foreach ($con as $k=>$v){
                $arr[] = $v['wei_id'];
            }
            $taskid = $arr;
        }
        if (empty($taskid) and empty($nubmer)){
            echo 2;
            return false;
        }
        $grouping = D('grouping');
        $a['id'] = $sid;
        $gr = $grouping->where($a)->find();
        $gr_name = $gr['equlist'];
        $a['wei_id'] = array('in',$taskid);
        $data['wei_equipment'] = $gr_name;
        $data['we_SKU'] = $sellertask['skuid'];
        $data['we_word'] = $sellertask['keyword'];
//        $data['we_port'] = $sellertask['keyword'];
        $value = $WechaModel->where($a)->save($data);
        if ($value){
            echo 1;
            die;
        }
        echo 2;
    }

    // 搜索地址
    public function searchAddr(){
        $wechatModel=D('weichat');
        $eqsModel=D('grouping');
        $eq['ag_id'] =session('AgentId');
        $options=$eqsModel->where($eq)->select();
        $title=I('title');
        $static=I('static');
        $shebei=I('shebei');
        $we_we = I('we_we');
        $id = I('id');//店铺名称
        $ids = I('ids');//查询条件
        $tiao = I('tiao');
        if(!empty($tiao)){
            if ($ids == 1){
                $where['wei_name'] = array('like','%'.$tiao.'%');
            }
            if ($ids == 2){
                $where['wei_address'] = array('like','%'.$tiao.'%');
            }
            if ($ids == 3){
                $where['wei_number'] = array('like','%'.$tiao.'%');
            }
            if ($ids == 4){
                $where['we_order'] = array('like','%'.$tiao.'%');
            }
            if ($ids == 5){
                $where['wei_remarks'] = array('like','%'.$tiao.'%');
            }
        }
        if($shebei == 2){
            $where['wei_equipment'] = array('NEQ','');//模糊查询
        }
        if($shebei == 3){
            $where['wei_equipment'] = array('exp',' is NULL');
        }
        if($we_we != "we_we"){
            $where['we_we'] = $we_we;
        }
        if ($static != ''){
            $where['wei_static'] = $static;
        }
        $where['agent_id'] = session('AgentId');
        $where['wei_data'] = 'jd';
        $result=$wechatModel->where($where)->select();
        $count=count($result);
        $page = new \Org\Page\Page($count, 100);
        $usergroups=$wechatModel->selectByPages($where,$page);
        $show = $page->show();
        $this->assign("usergroups",$usergroups);
        $this->assign("count",$count);
        $this->assign('alleqs', $options);
        $this->assign('page', $show);//显示分页
        $this->display('Wechat/listWechatGroups');
    }
    /*
     * 账号购买
     */
   public function purchase(){
           $AccountBalance = D('AccountBalance');
           $data['ba_name'] = session('AgentId');
           $con = $AccountBalance->where($data)->find();
           //账号数量
           $wechatModel=D('weichat');
            $data['wei_data'] = 'jd';
           $data['wei_static']= 0;
           $data['agent_id']= 0;
           $val = $wechatModel->where($data)->select();
           $jd = count($val);
           $wechatModel=D('weichat');
           $data['wei_data'] = 'qq';
           $data['wei_static']= 0;
           $data['agent_id']= 0;
           $val = $wechatModel->where($data)->select();
           $qq = count($val);
           //单价
           $AgentModel = D('Agent');
           $aa['ag_id'] = session('AgentId');
           $value = $AgentModel->where($aa)->find();
           $jia = $value['ag_money'];
           $this->assign('value', '购买账号');
           $this->assign('jia', $jia);
           $this->assign('count', $jd);
           $this->assign('qq', $qq);
           $this->assign('con', $con);
           $this->display('Wechat/purchase');
   }
    /*
     * 账号购买提交
     */
   public function purchases(){
       //接收参数
       $n = I('title');
       $wei_data = I('wei_data');
       //实例化模型
       $AgentModel     = D('Agent');
       $wechatModel    = D('weichat');
       $AccountBalance = D('AccountBalance');
       $Record = D('Record');
       $adminModel = D('Agent');
       //查询二级代理
       $admi['ag_id'] = session('AgentId');
       $vl = $adminModel->where($admi)->find();
       //查询用户余额
       $Account_data['ba_name'] = session('AgentId');
       $con = $AccountBalance->where($Account_data)->find();
        //查询用户单价
       $aa['ag_id'] = session('AgentId');
       $money = $AgentModel->where($aa)->find();
       $jia = $money['ag_money'];
       //计算用户购买账号所需的价格
       $mone = $n*$jia;
       //判断余额
       if ($con['ba_balance']<$mone) {
           $redata['re_num'] =  $n;
           $redata['re_mone'] =  $mone;
           $redata['re_static'] = 0;
           $redata['ag_id'] = session('AgentId');
           $redata['admin_id'] = $vl['ag_admin'];
           $redata['re_ip'] = get_client_ip();
           $redata['re_time'] = date('Y-m-d H:s:i');
           $Record->add($redata);
           return $this->error(L('余额不足'));
       }
       //查询账号
       $data['wei_data'] = $wei_data;
       $data['wei_static']= 0;
       $data['agent_id']= 0;
       $val = $wechatModel->where($data)->limit($n)->select();
       if(count($val)!= $n) {
           $redata['re_num'] =  $n;
           $redata['re_mone'] =  $mone;
           $redata['re_static'] = 0;
           $redata['ag_id'] = session('AgentId');
           $redata['admin_id'] = $vl['ag_admin'];
           $redata['re_ip'] = get_client_ip();
           $redata['re_time'] = date('Y-m-d H:s:i');
           $Record->add($redata);
           return $this->error(L('账号数量不足'));
       }
       foreach ($val as $v){
           $vv['wei_id'] = $v['wei_id'];
           $vdata['agent_id'] = session('AgentId');
           $vdata['wei_equipment'] = '';
           $value = $wechatModel->where($vv)->save($vdata);
       }
       $Record = D('Record');
       $adminModel = D('Agent');
       $admi['ag_id'] = session('AgentId');
       $vl = $adminModel->where($admi)->find();
       if($value){
           if(count($val)!= $n){
               $mone = count($val)*$jia;
               $Balance_con['ba_balance'] = $con['ba_balance']-$mone;
               $AccountBalance->where($Account_data)->save($Balance_con);
           }else{
               $mone = $n*$jia;
               $Balance_con['ba_balance'] = $con['ba_balance']-$mone;
               $AccountBalance->where($Account_data)->save($Balance_con);
           }
           $redata['re_num'] =  count($val);
           $redata['re_mone'] =  count($val)*$jia;
           $redata['re_static'] = 1;
           $redata['re_style'] = $wei_data;
           $redata['ag_id'] = session('AgentId');
           $redata['admin_id'] = $vl['ag_admin'];
           $redata['re_ip'] = get_client_ip();
           $redata['re_time'] = date('Y-m-d H:s:i');
           $Record->add($redata);
           $this->success(L('购买成功'));
       }else{
           $redata['re_num'] =  count($val);
           $redata['re_mone'] =  count($val)*$jia;
           $redata['re_static'] = 0;
           $redata['re_style'] = $wei_data;
           $redata['ag_id'] = session('AgentId');
           $redata['admin_id'] = $vl['ag_admin'];
           $redata['re_ip'] = get_client_ip();
           $redata['re_time'] = date('Y-m-d H:s:i');
           $Record->add($redata);
           $this->error(L('购买失败'));
       }
   }
   /*
    * 购买记录
    */
   public function Record(){
       //实例化UserGroup模型
       $Record = D('Record');
       //获取总的用户数
       $data['ag_id'] = session('AgentId');
       //获取每页显示的数据集
       $count = $Record->selectSize($data);
       //实例化分页类
       $page = new \Org\Page\Page($count, 100);
       $userGroups = $Record->selectByPages($data,$page);
       //分页显示输出
       $show = $page->show();
       $AccountBalance = D('AccountBalance');
       $data['ba_name'] = session('AgentId');
       $con = $AccountBalance->where($data)->find();
       $this->assign('con', $con);
       //赋值到模版
       $this->assign('usergroups', $userGroups);
       $this->assign('count', $count);
       $this->assign('page', $show);
       $this->assign('value', '购买记录');
       $this->display('Wechat/Record');
   }
}