<?php
/**
 * Created by PhpStorm.
 * User: occur
 * Date: 2017/7/9
 * Time: 18:49
 */
namespace Seller\Controller;

use Think\Controller;

class WechatController extends SuperController {
    /**
     * 显示weichat用户  全部
     */
    public function WechaGroupsWhole() {
        //实例化UserGroup模型
        $WechaModel = D('Weichat');
        $eqsModel=D('grouping');
        $options=$eqsModel->select();
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
        $this->assign('alleqs', $options);
        $this->assign('count', $count);
        $this->assign('page', $show);
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
        $options=$eqsModel->select();
        $this->assign('alleqs', $options);
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
        //实例化UserGroup模型
        $WechaModel = D('Weichat');
        $eqsModel=D('grouping');
        $options=$eqsModel->select();
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
        //实例化UserGroup模型
        $WechaModel = D('Weichat');
        $eqsModel=D('grouping');
        $options=$eqsModel->select();
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
        $options=$eqsModel->select();
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
        $this->display('Wechat/listWechatGroups');
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
        $objExcel->getActiveSheet()->setCellValue('C1','密码');
        $objExcel->getActiveSheet()->setCellValue('D1','支付密码');
        $objExcel->getActiveSheet()->setCellValue('E1','注册时间');
        $objExcel->getActiveSheet()->setCellValue('F1','IP');
        $objExcel->getActiveSheet()->setCellValue('G1','地址');
        $count = count($Wecha);//$driver 为数据库表取出的数据
        for ($i = 2; $i <= $count+1; $i++) {
            $objExcel->getActiveSheet()->setCellValue('A' . $i, $Wecha[$i-2]['wei_number']);
            $objExcel->getActiveSheet()->setCellValue('B' . $i, $Wecha[$i-2]['wei_name']);
            $objExcel->getActiveSheet()->setCellValue('C' . $i, $Wecha[$i-2]['wei_password']);
            $objExcel->getActiveSheet()->setCellValue('D' . $i, $Wecha[$i-2]['pay_password']);
            $objExcel->getActiveSheet()->setCellValue('E' . $i, $Wecha[$i-2]['wei_time']);
            $objExcel->getActiveSheet()->setCellValue('F' . $i, $Wecha[$i-2]['wei_ip']);
            $objExcel->getActiveSheet()->setCellValue('G' . $i, $Wecha[$i-2]['wei_address']);
        }
        $objExcel->setActiveSheetIndex();
        header('Content-Type: applicationnd.ms-excel');
        header('Content-Disposition: attachment;filename="账户信息.xls"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        exit;
    }





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
    public function deleteWechats(){
        $WechaModel = D('Weichat');
        $taskid=I('ids');
        $a['wei_id'] = array('in',$taskid);
        $value = $WechaModel->where($a)->delete();
//        dump($taskid);die;
        if ($value){
            echo 1;
            die;
        }
           echo 2;
    }
    public function state(){
        $WechaModel = D('Weichat');
        $taskid=I('ids');
//        var_dump($taskid);
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
        $wei_number = I('wei_number');//相当于 $_GET['wei_id']
        // dump($wei_id);
        $data['wei_number']= $wei_number;
        $Weicha = $WechaModel->where($data)->find();
        // dump($Weicha['comment']);
        $this->assign('data',$Weicha['comment']);
        $this->assign('number',$wei_number);
        $this->display('Wechat/comment');
    }

    public function  editComment(){
        $WechaModel = D('Weichat');
        $wei_number = I('wei_number');
        $comment = I('comment');
        // die;
        $a['wei_number']= $wei_number;
        $data['comment'] =  $comment;
        $value = $WechaModel->where($a)->save($data);
        if($value){
            echo 1;
             // $this->success(L('添加成功'), U('Shop/shops'));
        }else{
            echo 0;
            // $this->success(L('添加失败'), U('Shop/shops'));
        }
    }
     public function bindeqis(){
        $WechaModel = D('Weichat');
        $taskid=I('ids');//wechat
        $sid=I('id');//shebei
        $grouping = D('grouping');
        $a['id'] = $sid;
        $gr = $grouping->where($a)->find();
        $gr_name = $gr['equlist'];
        $a['wei_id'] = array('in',$taskid);
        $data['wei_equipment'] = $gr_name;
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
        $options=$eqsModel->select();
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
           $this->assign('value', '购买账号');
           $this->assign('con', $con);
           $this->display('Wechat/purchase');


   }
   public function purchases(){
        $n = I('title');
        $wei_data = I('wei_data');
        $mone = $n*2;
       $AccountBalance = D('AccountBalance');
       $wechatModel=D('weichat');
       $Account_data['ba_name'] = session('AgentId');
       $con = $AccountBalance->where($Account_data)->find();
       if ($con['ba_balance']<$mone) return $this->error(L('余额不足'));
       $wei_data = 'jd';
       $data['wei_data'] = $wei_data;
       $data['wei_static']= 0;
       $data['agent_id']= 0;
       $val = $wechatModel->where($data)->limit($n)->select();
       foreach ($val as $v){
           $vv['wei_id'] = $v['wei_id'];
           $vdata['agent_id'] = session('AgentId');
           $value = $wechatModel->where($vv)->save($vdata);
       }
       $Record = D('Record');
       $adminModel = D('Agent');
       $admi['ag_id'] = session('AgentId');
       $vl = $adminModel->where($admi)->find();
       if($value){
           if(count($val)!= $n){
               $mone = count($val)*2;
               $Balance_con['ba_balance'] = $con['ba_balance']-$mone;
               $AccountBalance->where($Account_data)->save($Balance_con);
           }else{
               $mone = $n*2;
               $Balance_con['ba_balance'] = $con['ba_balance']-$mone;
               $AccountBalance->where($Account_data)->save($Balance_con);
           }
           $redata['re_num'] =  count($val);
           $redata['re_mone'] =  count($val)*2;
           $redata['re_static'] = 1;
           $redata['ag_id'] = session('AgentId');
           $redata['admin_id'] = $vl['ag_admin'];
           $redata['re_ip'] = get_client_ip();
           $redata['re_time'] = date('Y-m-d H:s:i');
           $Record->add($redata);
           $this->success(L('购买成功'));
       }else{
           $redata['re_num'] =  count($val);
           $redata['re_mone'] =  count($val)*2;
           $redata['re_static'] = 0;
           $redata['ag_id'] = session('AgentId');
           $redata['admin_id'] = $vl['ag_admin'];
           $redata['re_ip'] = get_client_ip();
           $redata['re_time'] = date('Y-m-d H:s:i');
           $Record->add($redata);
           $this->error(L('购买失败'));
       }
   }
   public function Record(){

       //实例化UserGroup模型
       $Record = D('Record');
       //获取总的用户数
//       $data['wei_data'] = 'jd';
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