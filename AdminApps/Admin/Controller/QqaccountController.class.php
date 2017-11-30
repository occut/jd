<?php
/**
 * Created by PhpStorm.
 * User: occur
 * Date: 2017/7/9
 * Time: 18:49
 */
namespace Admin\Controller;

use Think\Controller;

class QqaccountController extends SuperController {
    //全部
    public function WechaGroupsWhole(){
        //实例化UserGroup模型
        $WechaModel = D('Weichat');
        $eqsModel=D('grouping');
        $options=$eqsModel->select();
        //获取总的用户数
        $data['wei_data'] = 'qq';
        if(session('adminId') != 46){
            $data['admin_id'] = session('adminId');
        }
        $count = $WechaModel->selectSize($data);
        //实例化分页类
        $page = new \Org\Page\Page($count, 100);
        //获取每页显示的数据集
        $userGroups = $WechaModel->selectByPages($data,$page);
        //分页显示输出
        $show = $page->show();
        //管理员操作记录到日志表中
        $logcontent = C('SYS_LOG_ACTION_SELECT') . "会员分组查询成功。";
        sys_log(session('adminId'), session('adminName'), $logcontent);
        //赋值到模版
        $this->assign('usergroups', $userGroups);
        $this->assign('alleqs', $options);
        $this->assign('count', $count);
        $this->assign('page', $show);
        $this->assign('static','');
        $this->assign('id','');
        $this->assign('value', '全部账户');
        $this->display('QQ/listWechatGroups');
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
        $data['wei_data'] = 'qq';
        $data['wei_static']= 0;
        if(session('adminId') != 46){
            $data['admin_id'] = session('adminId');
        }
        //获取每页显示的数据集
        $count = $WechaModel->selectSize($data);
        //实例化分页类
        $page = new \Org\Page\Page($count, 100);
        //获取每页显示的数据集
        $userGroups = $WechaModel->selectByPages($data,$page);
        //分页显示输出
        $show = $page->show();
        //管理员操作记录到日志表中
        $logcontent = C('SYS_LOG_ACTION_SELECT') . "会员分组查询成功。";
        sys_log(session('adminId'), session('adminName'), $logcontent);
        //赋值到模版
        $this->assign('usergroups', $userGroups);
        $this->assign('value', '正常账户');
        $this->assign('count', $count);
        $this->assign('page', $show);
        $this->assign('static',0);
        $this->assign('id',0);
        $this->display('QQ/listWechatGroups');
    }
    //账户异常
    public function WechaAbnormal() {
        $this->assign('value', '账户异常');
        //实例化UserGroup模型
        $WechaModel = D('Weichat');
         $eqsModel=D('grouping');
        $options=$eqsModel->select();
        $this->assign('alleqs', $options);
        //获取总的用户数
        $data['wei_data'] = 'qq';
        $data['wei_static']= 5;
        if(session('adminId') != 46){
            $data['admin_id'] = session('adminId');
        }
        //获取每页显示的数据集
        $count = $WechaModel->selectSize($data);
        //实例化分页类
        $page = new \Org\Page\Page($count, 100);
        //获取每页显示的数据集
        $userGroups = $WechaModel->selectByPages($data,$page);
        //分页显示输出
        $show = $page->show();
        //管理员操作记录到日志表中
        $logcontent = C('SYS_LOG_ACTION_SELECT') . "会员分组查询成功。";
        sys_log(session('adminId'), session('adminName'), $logcontent);
        //赋值到模版
        $this->assign('usergroups', $userGroups);
        $this->assign('count', $count);
        $this->assign('page', $show);
        $this->assign('static',0);
        $this->assign('id',5);
        $this->display('QQ/listWechatGroups');
    }

    //登录中
    public function WechaGroupsLogin(){
        $this->assign('value', '使用中');
        //实例化UserGroup模型
        $WechaModel = D('Weichat');
        $eqsModel=D('grouping');
        $options=$eqsModel->select();
        //获取总的用户数
        $data['wei_data'] = 'qq';
        $data['wei_static']= 6;
        if(session('adminId') != 46){
            $data['admin_id'] = session('adminId');
        }
        //获取每页显示的数据集
        $count = $WechaModel->selectSize($data);
        //实例化分页类
        $page = new \Org\Page\Page($count, 100);
        //获取每页显示的数据集
        $userGroups = $WechaModel->selectByPages($data,$page);
        //分页显示输出
        $show = $page->show();
        //管理员操作记录到日志表中
        $logcontent = C('SYS_LOG_ACTION_SELECT') . "会员分组查询成功。";
        sys_log(session('adminId'), session('adminName'), $logcontent);
        //赋值到模版
        $this->assign('usergroups', $userGroups);
        $this->assign('alleqs', $options);
        $this->assign('count', $count);
        $this->assign('page', $show);
        $this->assign('static','');
        $this->assign('id',6);
        $this->display('QQ/listWechatGroups');
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
        $objExcel->getActiveSheet()->setCellValue('B1','账号');
        $objExcel->getActiveSheet()->setCellValue('C1','密码');
        $objExcel->getActiveSheet()->setCellValue('D1','注册时间');
        $objExcel->getActiveSheet()->setCellValue('E1','IP');
        $objExcel->getActiveSheet()->setCellValue('F1','近期IP');
        $objExcel->getActiveSheet()->setCellValue('G1','地址');
        $count = count($Wecha);//$driver 为数据库表取出的数据
        for ($i = 2; $i <= $count+1; $i++) {
            $objExcel->getActiveSheet()->setCellValue('A' . $i, $Wecha[$i-2]['wei_number']);
            $objExcel->getActiveSheet()->setCellValue('B' . $i, $Wecha[$i-2]['wei_name']);
            $objExcel->getActiveSheet()->setCellValue('C' . $i, $Wecha[$i-2]['wei_password']);
            $objExcel->getActiveSheet()->setCellValue('D' . $i, $Wecha[$i-2]['wei_time']);
            $objExcel->getActiveSheet()->setCellValue('E' . $i, $Wecha[$i-2]['wei_ip']);
            $objExcel->getActiveSheet()->setCellValue('F' . $i, $Wecha[$i-2]['wei_ips']);
            $objExcel->getActiveSheet()->setCellValue('G' . $i, $Wecha[$i-2]['wei_address']);
        }
        $objExcel->setActiveSheetIndex();
        header('Content-Type: applicationnd.ms-excel');
        header('Content-Disposition: attachment;filename="账户信息.xls"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        exit;
    }
    //导入
    public function Import(){
        if(IS_GET){
            $this->display('Wechat/Import');
        }else{
         $taskid=I('desc');
         $WechaModel = D('Weichat');
            $result = preg_split('/[;\r\n]+/s', $taskid);
            $a = explode("\r\n",$taskid);
        foreach ($result as $b){
            $c = explode("-",$b);
            $data['wei_number'] = $c[0];
            $data['wei_name'] = $c[1];
            $f['wei_number'] = $c[0];
            $data['wei_password'] = 0;
            $data['wei_ip'] = 0;
            $data['comment'] = 0;
            $data['pay_password'] = 0;
            $data['wei_address'] = $c[2];
            $data['shop_name'] = $c[3];
            $data['admin_id']=session('adminId');
            $va = $WechaModel->where($f)->select();
            if(!empty($va)){
                $data = '';
            }
            if($data !=''){
                $value = $WechaModel->add($data);
            }

        }
            echo 1;
        }
    }
    public function idcardImport(){
        if(IS_GET){
            $this->display('Wechat/idcardImport');
        }else{
            $taskid=I('desc');
            $WechaModel = D('IdCard');
            $result = preg_split('/[;\r\n]+/s', $taskid);
           foreach ($result as $b){
                $c = explode("-",$b);
                $data['card_name'] = $c[0];
                $data['card_product'] = $c[1];
                $f['card_product'] = $c[1];
                $data['card_city'] = $c[2];
                $data['card_area'] = $c[3];
                $data['card_path'] = $c[4];
                $data['admin_id'] = session('adminId');
                if($data !=''){
                    $value = $WechaModel->add($data);
                }
            }
            echo 1;
        }
    }
    //禁用
    public function WechaGroupsDisable(){
        $this->assign('value', '禁用异常');
        //实例化UserGroup模型
        $WechaModel = D('Weichat');
         $eqsModel=D('grouping');
        $options=$eqsModel->select();
        $this->assign('alleqs', $options);
        //获取总的用户数
        $id = 1;
        $count = $WechaModel->selectWeichatTotalSize($id);
        //实例化分页类
        $page = new \Org\Page\Page($count, $this->adminPageSize);
        //获取每页显示的数据集
        $userGroups = $WechaModel->selectWeichatByPage($page,$id);
        //分页显示输出
        $show = $page->show();
        //管理员操作记录到日志表中
        $logcontent = C('SYS_LOG_ACTION_SELECT') . "会员分组查询成功。";
        sys_log(session('adminId'), session('adminName'), $logcontent);
        //赋值到模版
        $this->assign('usergroups', $userGroups);
        $this->assign('count', $count);
        $this->assign('page', $show);
        $this->assign('static',1);
        $this->assign('id',1);
        $this->display('Wechat/listWechatGroups');
    }


    public function  WechaIdCard(){
        $IdCard = D('IdCard');
        $product = I('product');
        $count = $IdCard->selectIdCardTotalSize();
        //实例化分页类
        $page = new \Org\Page\Page($count, 100);
        //获取每页显示的数据集
        $userGroups = $IdCard->selectIdCardByPage($page);
        //分页显示输出
        $show = $page->show();
        session('card_city', NULL);
        if (!empty($product)){
            session('card_city', $product);
            $a['card_city'] = array('like','%'.$product.'%');
            $userGroups = $IdCard->where($a)->select();
            $count = count($userGroups);
        }
        //管理员操作记录到日志表中
        $logcontent = C('SYS_LOG_ACTION_SELECT') . "会员分组查询成功。";
        sys_log(session('adminId'), session('adminName'), $logcontent);
        //赋值到模版
        $this->assign('usergroups', $userGroups);
        $this->assign('count', $count);
        $this->assign('page', $show);
        $this->assign('static','2');
        $this->display('QQ/WechaIdCard');
    }
    public function deleteWechat(){
        $WechaModel = D('Weichat');
        $taskid=I('wei_id');
        $a['wei_id'] = $taskid;
        $content = $WechaModel->where($a)->find();
        if ($content['wei_static'] != 0 ){
            $data['wei_static'] = 0;
            $data['wei_remarks'] = null;
            $value = $WechaModel->where($a)->save($data);
            if($value){
                $this->success(L('删除成功'));
            }else{
                $this->error(L('删除失败'));
            }
            return false;
        }
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
        if ($value){
            echo 1;
            die;
        }
           echo 2;
    }
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
        //接收数据 处理数据
        $wei_id = I('wei_id');
        if(empty($wei_id)){
            $this->error(L('请勾选数据'));
        }
        $wei_ids = explode(",",$wei_id);
        foreach( $wei_ids as $k=>$v){
            if( empty($v) )
                unset( $wei_ids[$k] );
        }
        //查询数据
        $data['wei_id']= array('in',$wei_ids);
        $Weicha = $WechaModel->where($data)->select();
       $comment = '';
        foreach ($Weicha as $vo){
            $comment .= $vo['comment']."\r\n";
        }
        //发送数据到模板
        array_pop($comment);
        $this->assign('data',$comment);
        $this->assign('number',$wei_id);
        $this->display('Wechat/comment');
    }
    //保存评语
    public function  editComment(){
        //实例化模型
        $WechaModel = D('Weichat');
        //接收数据 组装数据
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
        //foreach( $wei_ids as $k=>$v){
                $a['wei_id']= $wei_ids[$k];
                $data['comment'] =  $vo;
                $value = $WechaModel->where($a)->save($data);
            //}
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
        $where['wei_data'] = 'qq';
        $result=$wechatModel->where($where)->select();
        $count=count($result);
        $page = new \Org\Page\Page($count, 100);
        $usergroups=$wechatModel->selectByPages($where,$page);
        $show = $page->show();
        $this->assign("usergroups",$usergroups);
        $this->assign("count",$count);
        $this->assign('alleqs', $options);
        $this->assign('page', $show);//显示分页
        $this->display('QQ/listWechatGroups');
    }
    //删除deletecard
    public function deletecard(){
        $card_id=I('ids');//wechat
        $IdCard = D('IdCard');
        $a['card_id'] = array('in',$card_id);
        $value = $IdCard->where($a)->delete();
        if ($value){
            echo 1;
            die;
        }
        echo 2;
    }
    public function Nubmer(){
        $data['wei_static'] = 0;
        $data['wei_equipment'] = array('exp',' is NULL');
        $WechaModel = D('Weichat');
        $con = $WechaModel->where($data)->order('wei_time desc')->select();
        $cons=I('con');
        $n = count($con);
        if ($cons>$n){
            echo $n;
        }else{
            echo 'ok';
        }
    }

    public function Importshop(){
        $file = $_FILES['ex'];
        // 实例化上传类
        $upload = new \Think\Upload();
        // 设置附件上传大小
        $upload->maxSize = 20 * 1024 * 1024;
        // 设置附件上传类型
        $upload->exts = ['xls','xlsx'];
        // 设置附件上传根目录
        $upload->rootPath = './';
        $upload->saveName = 'time';
        // 设置附件上传（子）目录
        $upload->savePath = C('UPLOAD_IMG_DIRECTORY').'Excer'."/";
        $info = $upload->uploadOne($file);

        if($info){
            import("Org.Util.PHPExcel");
            //要导入的xls文件
            $filename="./UploadImages/Excer/".$info['savename'];
            //创建PHPExcel对象
            $PHPExcel=new \PHPExcel();
            //如果excel文件后缀名为.xls，导入这个类
            import("Org.Util.PHPExcel.Reader.Excel5");
            //如果excel文件后缀名为.xlsx，导入这下类
            import("Org.Util.PHPExcel.Reader.Excel2007");
            if($info['ext'] == 'xlsx'){
                $PHPReader=new \PHPExcel_Reader_Excel2007();
            }else{
                $PHPReader=new \PHPExcel_Reader_Excel5();
            };

//
            //载入文件
            $PHPExcel=$PHPReader->load($filename);
            $currentSheet=$PHPExcel->getSheet(0);
            //获取总列数
            $allColumn=$currentSheet->getHighestColumn();
            //获取总行数
            $allRow=$currentSheet->getHighestRow();
            for($currentRow=1;$currentRow<=$allRow;$currentRow++){
                //从哪列开始，A表示第一列
                for($currentColumn='A';$currentColumn!='AJ';$currentColumn++){
                    //数据坐标
                    $address=$currentColumn.$currentRow;
                    //读取到的数据，保存到数组$arr中
                    $arr[$currentRow][$currentColumn]=$currentSheet->getCell($address)->getValue();
                }

            }
            header("Content-Type: text/html; charset=utf-8");
//            dump($arr);
            $WechaModel = D('Weichat');
            foreach ($arr as $k=>$v){
                if(is_numeric($v['A'])){
                    $a['wei_name'] = $v['A'];
                    $c = $WechaModel->where($a)->find();
                    if(empty($c)){
                        $a['wei_password'] = $v['B'];
                        $a['wei_number'] = $v['C'];
                        $a['pay_password'] = $v['D'];
                        $a['wei_data'] = 'qq';
                        $a['wei_ip'] = get_client_ip();
                        $a['wei_time'] = date("Y-m-d H:i:s");
                        $a['admin_id'] = session('adminId');

                        $WechaModel->add($a);
                    }
                }

            }
            @unlink ("./UploadImages/Excer/".$info['savename']);
            $this->success(L('文件上传成功'));
        }
        $this->error(L('文件上传失败'));
    }
   
}