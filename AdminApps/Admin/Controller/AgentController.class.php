<?php
/**
 * Created by PhpStorm.
 * User: occur
 * Date: 2017/7/9
 * Time: 18:49
 */
namespace Admin\Controller;

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
     * 修改
     */
    public function edit(){
    $id = I('id');
    $AgentModel = D('Agent');
    $con = $AgentModel::selectid($id);
    $this->assign('con', $con);
    $this->assign('value', '信息修改');
    $this->display('Agent/editAgent');
    }
    /*
     * 修改保存
     */
    public function editsave(){
        $ag_mb = I('ag_mb');
        $ag_phone = I('ag_phone');
        $ag_money = I('ag_money');
        $ag_ban = I('ag_ban');
        $id = I('id');
        $AgentModel = D('Agent');
        $a['ag_id'] = $id;
        $data['ag_phone'] = $ag_phone;
        $data['ag_mb'] = $ag_mb;
        $data['ag_money'] = $ag_money;
        $data['ag_ban'] = $ag_ban;
        $value = $AgentModel->where($a)->save($data);
        if($value){
            $this->success(L('修改成功'),U('Agent/index'));
        }else{
            $this->error(L('修改失败'));
        }
    }
    /*
     * 修改密码
     */
    public function editpaw(){
        if(IS_GET) {
            $id = I('id');
            $AgentModel = D('Agent');
            $con = $AgentModel::selectid($id);
            $this->assign('con', $con);
            $this->assign('value', '密码修改');
            $this->display('Agent/editpaw');
        }else{
            $ag_pw = I('ag_pw');
            $ag_lpw = I('ag_lpw');
            $id = I('id');
            if($ag_pw != $ag_lpw) $this->error(L('密码错误'));
            $AgentModel = D('Agent');
            $a['ag_id'] = $id;
            $data['ag_pw'] = admin_md5($ag_pw);
            $value = $AgentModel->where($a)->save($data);
            if($value){
                $this->success(L('修改成功'),U('Agent/index'));
            }else{
                $this->error(L('修改失败'));
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
        $AccountNumber =  D('Record');
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
        $this->assign('value', '账目登记');
        $this->display('Agent/listAccount');
    }
    /*
     * 导出
     */
    public function AgExport(){
        $id=I('ids');
        if(empty($id)){
            $this->error(L('请勾选数据'));
        }
        $ids = explode(",",$id);
        array_pop($ids);

        $Record =  D('Record');
        $a['em_id'] = array('in',$ids);
        $Re = $Record->where($a)->order('re_time desc')->select();
        vendor("PHPExcel.PHPExcel");
        $objExcel = new \PHPExcel();
        $objWriter = \PHPExcel_IOFactory::createWriter($objExcel, 'Excel5');
        $objExcel->getActiveSheet()->setCellValue('A1','二级代理用户名');
        $objExcel->getActiveSheet()->setCellValue('B1','账号类型');
        $objExcel->getActiveSheet()->setCellValue('C1','数量');
        $objExcel->getActiveSheet()->setCellValue('D1','金额');
        $objExcel->getActiveSheet()->setCellValue('E1','购买时间');
        $objExcel->getActiveSheet()->setCellValue('F1','状态');
        $objExcel->getActiveSheet()->setCellValue('G1','IP');
        $count = count($Re);//$driver 为数据库表取出的数据
        for ($i = 2; $i <= $count+1; $i++) {
            $objExcel->getActiveSheet()->setCellValue('A' . $i, selectagent($Re[$i-2]['ag_id'])['ag_name']);
            $objExcel->getActiveSheet()->setCellValue('B' . $i, $Re[$i-2]['re_style']);
            $objExcel->getActiveSheet()->setCellValue('C' . $i, $Re[$i-2]['re_num']);
            $objExcel->getActiveSheet()->setCellValue('D' . $i, $Re[$i-2]['re_mone']);
            $objExcel->getActiveSheet()->setCellValue('E' . $i, $Re[$i-2]['re_time']);
            $objExcel->getActiveSheet()->setCellValue('F' . $i, $Re[$i-2]['re_static']);
            $objExcel->getActiveSheet()->setCellValue('G' . $i, $Re[$i-2]['re_ip']);
        }
        $objExcel->setActiveSheetIndex();
        header('Content-Type: applicationnd.ms-excel');
        header('Content-Disposition: attachment;filename="账目登记.xls"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        exit;
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
            sendMail($a,'验证消息',"本次验证码是：$vo");
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
    /*
     * 记录查询
     */
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
    public function management(){
        if(IS_GET) {
            $balance = session('management');
            if(!empty($balance)){
                $Management = D('Management');
                //获取总的用户数
                if(session('adminId') != 46){
                    $data['ag_admin'] = session('adminId');
                }
                $count = $Management::selectSize($data);
                //实例化分页类
                $page = new \Org\Page\Page($count, 100);
                //获取每页显示的数据集
                $Agent = $Management::selectByPages($data,$page);
                //分页显示输出
                $show = $page->show();
                //管理员操作记录到日志表中
                $logcontent = C('SYS_LOG_ACTION_SELECT') . "二级代理查询成功。";
                sys_log(session('adminId'), session('adminName'), $logcontent);
                //赋值到模版
                $this->assign('Agent', $Agent);
                $this->assign('count', $count);
                $this->assign('page', $show);
                $this->assign('value', '商家管理');
                $this->display('Agent/listmanagement');
            }else{
                $vo = rand(111111,999999);
                session('vomanagement',$vo);
                $adminModel = D('Admin');
                $con = $adminModel->where(['admin_id'=>46])->find();
                $a = $con['admin_email'];
                sendMail($a,'验证消息',"本次验证码是：$vo");
                $this->display('Agent/listmimamanagement');
            }
        }else{
            $vo = I('vo');
            $a = session('vomanagement');
            if($a == $vo){
                session('management',$vo);
                $this->success(L('成功'));
            }else{
                $this->error(L('失败'));
            }
        }
    }

    /*
     * 金币充值
     */
    public function Import(){
        if($_GET){
            $id = I('pa_id');
            $PaymentModel = D('Payment');
            $a['pa_id'] = $id;
            $con = $PaymentModel->where($a)->find();
            if($con['pa_static'] != 1) $this->error(L('账单已提交'));
            $vo = rand(111111,999999);
            session('import',$vo);
            $adminModel = D('Admin');
            $con = $adminModel->where(['admin_id'=>46])->find();
            $email = $con['admin_email'];
            sendMail($email,'验证消息',"本次验证码是：$vo");
            $this->assign('value', '余额管理');
            $this->assign('pa_id', $id);
            $this->display('Agent/payment');
        }else{
        $title = I('title');
        $id = I('id');
        $pa_operator = I('pa_operator');
        $verification = I('verification');
        $import = session('import');
        if($import != $verification) $this->error(L('验证码错误'));
        $PaymentModel = D('Payment');
        $a['pa_id'] = $id;
        $con = $PaymentModel->where($a)->find();
        $data['pa_static'] = 0;
        $data['ba_mone'] = $title;
        $data['pa_operator'] = $pa_operator;
        $PaymentModel->where($a)->save($data);
        $AccountBalance = D('AccountBalance');
        $b['ba_name'] = $con['ag_id'];
        $vo = $AccountBalance->where($b)->find();
        $mone = $vo['ba_balance'];
        $dataa['ba_balance'] = $mone+$title;
        $dataa['ba_time'] = date('Y-m-d H:s:i');
        $value = $AccountBalance->where($b)->save($dataa);
            if($value){
                echo 1;
            }else{
                echo 0;
            }
        }

    }
    public function selectmanagement(){
        $a = I('id');
        $Management = D('Management');
        $con = $Management->where(['$Management'=>$a])->find();
        $this->assign('con', $con);
        $this->display('Agent/selectmanagement');
    }
//Address
    public function selectaddress(){
        $a = I('id');
        $Address = D('Address');
        $con = $Address->where(['ad_ma_id'=>$a])->find();
        $this->assign('con', $con);
        $this->display('Agent/selectaddress');

    }
//agent_logistics
    /*
     * 物流登记
     */
    public function AgentLogistics(){
        $AccountNumber =  D('AgentLogistics');
        //获取总的用户数
        if(session('adminId') != 46){
            $data['admin_id'] = session('adminId');
        }
        $count = $AccountNumber->where($data)->count();
        //实例化分页类
        $page = new \Org\Page\Page($count, 100);
        //获取每页显示的数据集
        $Agent = $AccountNumber->where($data)->limit($page->firstRow . ',' . $page->listRows)->order('lo_time desc')->select();
        //分页显示输出
        $show = $page->show();
        //管理员操作记录到日志表中
        $logcontent = C('SYS_LOG_ACTION_SELECT') . "二级代理物流登记。";
        sys_log(session('adminId'), session('adminName'), $logcontent);
        //赋值到模版
        $this->assign('Agent', $Agent);
        $this->assign('count', $count);
        $this->assign('page', $show);
        $this->assign('value', '物流登记');
        $this->display('Agent/AgentLogistics');
    }
    /*
     * 流量登记
     */
    public function AgentFlow(){
        $AccountNumber =  D('AgentFlow');
        //获取总的用户数
        if(session('adminId') != 46){
            $data['admin_id'] = session('adminId');
        }
        $count = $AccountNumber->where($data)->count();
        //实例化分页类
        $page = new \Org\Page\Page($count, 100);
        //获取每页显示的数据集
        $Agent = $AccountNumber->where($data)->limit($page->firstRow . ',' . $page->listRows)->order('lo_time desc')->select();
        //分页显示输出
        $show = $page->show();
        //管理员操作记录到日志表中
        $logcontent = C('SYS_LOG_ACTION_SELECT') . "二级代理物流登记。";
        sys_log(session('adminId'), session('adminName'), $logcontent);
        //赋值到模版
        $this->assign('Agent', $Agent);
        $this->assign('count', $count);
        $this->assign('page', $show);
        $this->assign('value', '流量登记');
        $this->display('Agent/AgentLogistics');
    }
    /*
* 单量登记
*/
    public function volume(){
        //实例话模型
        $Employee = D('volume');
        //查询条件
        //获取总的用户数
        if(session('adminId') != 46){
            $data['admin_id'] = session('adminId');
        }
        //统计数据
        $count  = $Employee->where($data)->count();
        //实例化分页类
        $page = new \Org\Page\Page($count, 100);
        //分页数据
        $usergroups=$Employee->where($data)->limit($page->firstRow . ',' . $page->listRows)->order('en_time desc')->select();
        $show = $page->show();
        $this->assign('value', '流量登记');
        $this->assign('usergroups', $usergroups);
        $this->assign('count', $count);//显示总条数
        $this->assign('page', $show);//显示分页
        $this->display('Agent/volume');//将值显示在静态页面上
    }
}