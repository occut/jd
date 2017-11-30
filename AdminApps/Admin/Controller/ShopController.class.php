<?php
/**
 * Created by PhpStorm.
 * User: occur
 * Date: 2017/7/9
 * Time: 18:49
 */
namespace Admin\Controller;

use Think\Controller;

class ShopController extends SuperController {
  public function Shops(){
    $WechaModel = D('Shop');//查找数据表shop
    $count=$WechaModel->selectShops();
    $total=$WechaModel->countShops();
    $page = new \Org\Page\Page($total, 100);
    $usergroups=$WechaModel->selectShopsByPage($page);
    $show = $page->show();
    //赋值到模版
    $this->assign('usergroups', $usergroups);
    $this->assign('count', $total);//显示总条数
    $this->assign('page', $show);//显示分页
    $this->display('Shop/listshops');//将值显示在静态页面上
  }

  public function deleteshop(){
    $WechaModel = D('Shop');//查找数据表shop
    $id=I('id');
     $value = $WechaModel->deleteShopById($id);
        if($value){
            $this->success(L('删除成功'));
        }else{
            $this->error(L('删除失败'));
        }
  }

    public function deleteshops(){
        $WechaModel = D('Shop');
        $id=I('ids');
        $a['id'] = array('in',$id);
        $value = $WechaModel->where($a)->delete();
        if ($value){
            echo 1;
            die;
        }
        echo 2;
    }
    //将编辑的内容显示出来
    public function showShopDetails(){
     $WechaModel = D('Shop');
        $id = I('id');//相当于 $_GET['wei_id']
        $data['id']= $id;
        $Weicha = $WechaModel->where($data)->find();
        $this->assign('data',$Weicha);
        $this->display('Shop/editshop');
    }
    // 编辑店铺
    public function editshop(){
      if (IS_POST) {
            //接受POST传递过来的参数
            $id = I('id');
            $shop_name = I('shop_name');
            $delivery_time = I('delivery_time');
            $order_number = I('order_number');
            $order_details = I('order_details');
            //封装数据
            $data['shop_name'] = $shop_name;
            $data['delivery_time'] = $delivery_time;
             $data['order_number'] = $order_number;
            $data['order_details'] = $order_details;
            $WechaModel = D('Shop');
            $result = $WechaModel->saveShop($id,$data);
            //返回编辑结果
            if ($result) {
                $this->success(L('修改成功'), U('Shop/shops'));
            } else {
                $this->error(L('修改失败'));
            }
        } else{
            //接受GET传递过来的参数
            $id = I('id');
            //实列化Tasks模型
             $WechaModel = D('Shop');
            //查找任务表中task_id为$taskId的一条数据
            $taskgroup = $WechaModel->selectShopById($id);
            //赋值到模版
            $this->assign('taskgroup', $taskgroup);
            $this->display();
        }
    }
    //添加店铺
    public function shopStore(){
      $shop_name=I('shop_name');
       $delivery_time=I('delivery_time');
       $order_number=I('order_number');
       $order_details=I('order_details');
       $data['shop_name'] = $shop_name;
       $data['delivery_time'] = $delivery_time;
        $data['order_number'] = $order_number;
       $data['order_details'] = $order_details;
       $WechaModel = D('Shop');
       $value = $WechaModel->addShop($data);
        if ($value) {
            $this->success(L('添加成功'), U('Shop/shops'));
        } else {
            $this->error(L('添加失败'));
        }
    }
    //通过店铺名查询
    public function shopSearch(){
      $WechaModel = D('Shop');//查找数据表shop
      $WeichatModel = D('weichat');//查找数据表weichat
      $id = I('id');//店铺名称
      $ids = I('ids');//查询条件
      $tiao = I('tiao');
      $start = I('start');//时间
      $end = I('end');//时间
      $we_logistics = I('we_logistics');//时间
        session('timestart', NULL);
        session('timeend', NULL);
//      if(empty($ids)){
          if(empty($id)){
            $shop = $WechaModel->order('id')->find();
            $a['shop_name'] = $shop['shop_name'];
            $con = $WeichatModel->where($a)->select();
          }else{

            $aa['id'] = $id;
            $shop = $WechaModel->where($aa)->find();
              if(!empty($start)){
                  session('timestart', $start);
                  session('timeend', $end);
                  $a['bought_time']=array(array('gt',$start),array('lt',$end));
              }
              if($we_logistics != 1){
                  $a['we_logistics'] = $we_logistics;
              }
              $a['shop_name'] = $shop['shop_name'];
              if (!empty($tiao)){
                  session('wei_ids', $ids);
                  session('wei_tiao', $tiao);
                  if ($ids == 1){
                      $a['wei_name'] = array('like','%'.$tiao.'%');
                  }
                  if ($ids == 2){
                      $a['wei_address'] = array('like','%'.$tiao.'%');
                  }
                  if ($ids == 3){
                      $a['wei_number'] = array('like','%'.$tiao.'%');
                  }
                  if ($ids == 4){
                      $a['we_order'] = array('like','%'.$tiao.'%');
                  }
                  if ($ids == 5){
                      $a['wei_remarks'] = array('like','%'.$tiao.'%');
                  }
              }
            $con = $WeichatModel->where($a)->select();
          }
//      }else{
//          session('wei_ids', $ids);
//          session('wei_tiao', $tiao);
//          $id=I('id');
//          $c['id']=$id;
//          $wechar=$WechaModel->where($c)->find();
//          $a['shop_name']=$wechar['shop_name'];
//          if(!empty($time['start'])){
//                  session('timestart', $time['start']);
//                  session('timeend', $time['end']);
//                  $a['bought_time']=array(array('gt',$time['start']),array('lt',$time['end']));
//              }

//          $con = $WeichatModel->where($a)->select();
//      }
      $total=count($con);
    $page = new \Org\Page\Page($total, 100);
//    $shoppages = $WeichatModel->selectWeichatByPage1($page);
//        print_r($a);
    $shoppages = $WeichatModel->selectByPages($a,$page);
    $show = $page->show();
    $val = $WechaModel->order('id')->select();
    //赋值到模版
    $this->assign('id',$id);
//    $this->assign('shoppages', $shoppages);
        $this->assign('shoppage', $show);//显示分页
        $this->assign('content',$shoppages);
      //赋值到模版
      $this->assign('allShops',$val);//下拉列表的店铺显示

      $this->assign('shop',$shop);
      $this->assign('all',$total);//数量
      $this->display('Shop/shopSearch');//将值显示在静态页面上
    }

// 将订单详情显示出来
     public function showOrderDetails(){
     $WechaModel = D('Shop');
        $id = I('id');//相当于 $_GET['wei_id']
        $data['id']= $id;
        $Weicha = $WechaModel->where($data)->find();
        $this->assign('data',$Weicha);
        $this->display('Shop/editorder');
    }

    public function shopsreceipt(){
         //接收数据 实例化模型
        $wei_id = I('ids');
        $WechaModel = D('Weichat');
        //储存数据
        if(is_array($wei_id)){
            $a['wei_id'] = array('in',$wei_id);
            $data['wei_remarks'] = '收货';
            $data['receipt_time'] =date('Y-m-d');
            $con = $WechaModel->where($a)->save($data);
        }else{
            $a['wei_id'] = $wei_id;
            $data['wei_remarks'] = '收货';
            $data['receipt_time'] =date('Y-m-d');
            $con = $WechaModel->where($a)->save($data);
        }
        //返回消息
        if($con){
            echo 1;
        }else{
            echo 2;
        }
    }
    //导出店铺数据
    public function exportshop(){
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
        $objExcel->getActiveSheet()->setCellValue('D1','IP');
        $objExcel->getActiveSheet()->setCellValue('E1','近期IP');
        $objExcel->getActiveSheet()->setCellValue('F1','地址');
        $objExcel->getActiveSheet()->setCellValue('G1','状态');
        $objExcel->getActiveSheet()->setCellValue('H1','订单号');
        $objExcel->getActiveSheet()->setCellValue('I1','物流单号');
        $objExcel->getActiveSheet()->setCellValue('J1','SKU');
        $objExcel->getActiveSheet()->setCellValue('K1','关键词');
        $objExcel->getActiveSheet()->setCellValue('L1','金额');
        $objExcel->getActiveSheet()->setCellValue('M1','下单时间');
        $objExcel->getActiveSheet()->setCellValue('N1','下单端口');
        $objExcel->getActiveSheet()->setCellValue('O1','收货评语');
        $objExcel->getActiveSheet()->setCellValue('P1','物流');
        $objExcel->getActiveSheet()->setCellValue('Q1','任务进度');
        $objExcel->getActiveSheet()->setCellValue('R1','店铺名');
        $objExcel->getActiveSheet()->setCellValue('S1','收货时间');
        $objExcel->getActiveSheet()->setCellValue('T1','完成设备');
        $count = count($Wecha);//$driver 为数据库表取出的数据
        for ($i = 2; $i <= $count+1; $i++) {
            $objExcel->getActiveSheet()->setCellValue('A' . $i, $Wecha[$i-2]['wei_number']);
            $objExcel->getActiveSheet()->setCellValue('B' . $i, $Wecha[$i-2]['wei_name']);
            $objExcel->getActiveSheet()->setCellValue('C' . $i, $Wecha[$i-2]['wei_password']);
            $objExcel->getActiveSheet()->setCellValue('D' . $i, $Wecha[$i-2]['wei_ip']);
            $objExcel->getActiveSheet()->setCellValue('E' . $i, $Wecha[$i-2]['wei_ips']);
            $objExcel->getActiveSheet()->setCellValue('F' . $i, $Wecha[$i-2]['wei_address']);
            $objExcel->getActiveSheet()->setCellValue('G' . $i, $Wecha[$i-2]['wei_static']);
            $objExcel->getActiveSheet()->setCellValue('H' . $i, $Wecha[$i-2]['we_order']);
            $objExcel->getActiveSheet()->setCellValue('I' . $i, $Wecha[$i-2]['we_oddnumbers']);
            $objExcel->getActiveSheet()->setCellValue('J' . $i, $Wecha[$i-2]['we_SKU']);
            $objExcel->getActiveSheet()->setCellValue('K' . $i, $Wecha[$i-2]['we_word']);
            $objExcel->getActiveSheet()->setCellValue('L' . $i, $Wecha[$i-2]['wei_gold']);
            $objExcel->getActiveSheet()->setCellValue('M' . $i, $Wecha[$i-2]['bought_time']);
            $objExcel->getActiveSheet()->setCellValue('N' . $i, $Wecha[$i-2]['we_port']);
            $objExcel->getActiveSheet()->setCellValue('O' . $i, $Wecha[$i-2]['comment']);
            $objExcel->getActiveSheet()->setCellValue('P' . $i, $Wecha[$i-2]['we_logistics']);
            $objExcel->getActiveSheet()->setCellValue('Q' . $i, $Wecha[$i-2]['wei_remarks']);
            $objExcel->getActiveSheet()->setCellValue('R' . $i, $Wecha[$i-2]['shop_name']);
            $objExcel->getActiveSheet()->setCellValue('S' . $i, $Wecha[$i-2]['receipt_time']);
            $objExcel->getActiveSheet()->setCellValue('T' . $i, $Wecha[$i-2]['we_we']);
        }
        $objExcel->setActiveSheetIndex();
        header('Content-Type: applicationnd.ms-excel');
        header('Content-Disposition: attachment;filename="店铺收货数据.xls"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        exit;
    }

    public function Importshop(){
        $file = $_FILES['ex'];
        // 实例化上传类
        $upload = new \Think\Upload();
        // 设置附件上传大小
        $upload->maxSize = 20 * 1024 * 1024;
        // 设置附件上传类型
        $upload->exts = ['xls'];
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
            //import("Org.Util.PHPExcel.Reader.Excel2007");
            //$PHPReader=new \PHPExcel_Reader_Excel2007();
            $PHPReader=new \PHPExcel_Reader_Excel5();
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
            $WechaModel = D('Weichat');
            foreach ($arr as $k=>$v){
                $a['wei_name'] = $v['A'];
                $data['comment'] = $v['J'];
                $data['longs'] = $v['K'];
                $data['ratings'] = $v['L'];
                $data['ratings_time'] = $v['M'];
                $data['we_logistics'] = $v['S'];
                $Wecha = $WechaModel->where($a)->save($data);
            }
           @unlink ("./UploadImages/Excer/".$info['savename']);
            $this->success(L('文件上传成功'));
        }
        $this->error(L('文件上传失败'));
    }
    /*
     * 收货
     */
    public function Receipt(){
        //接收参数
        $name  = I('name');
        $start = I('start');
        $end   = I('end');
        if(empty($start) or empty($end)){
            echo 4;
            return false;
        }
        //实例化模型
        $ShopModel = D('Shop');
        $WechaModel = D('Weichat');
        $a['id'] = $name;
        //查询店铺数据
        $shop = $ShopModel->where($a)->find();
        //查询账号数据
        $aa['shop_name'] = $shop['shop_name'];
        $aa['bought_time'] = array(array('gt',$start),array('lt',$end));
        $aa['receipt_time'] = array('exp',' is NULL');
        $Wecha = $WechaModel->where($aa)->select();
        if(empty($Wecha)){
            echo 2;
            return false;
        }
        $nu = count($Wecha);
        if($nu<10){
            echo 3;
            return false;
        }
        //写入收货数据
//        $aa['receipt_time'] = array('exp',' is NULL');
        //第一天；
        if(floor($nu*0.4) > 0){
            $one = $WechaModel->where($aa)->limit(floor($nu*0.4))->select();
            foreach ($one as $k=>$v){
                $o['wei_id'] = $v['wei_id'];
                $odata['receipt_time'] = date('Y-m-d');
                $odata['wei_remarks'] = '收货';
                $WechaModel->where($o)->save($odata);
            }
        }
        //第二天
        if(floor($nu*0.3) > 0){
            $two = $WechaModel->where($aa)->limit(floor($nu*0.3))->select();
            foreach ($two as $k=>$v){
                $t['wei_id'] = $v['wei_id'];
                $tdata['receipt_time'] = date('Y-m-d',strtotime('+1 day'));
                $tdata['wei_remarks'] = '收货';
                $WechaModel->where($t)->save($tdata);
            }
        }
        //第三天
        if(floor($nu*0.2) > 0){
            $three = $WechaModel->where($aa)->limit(floor($nu*0.2))->select();
            foreach ($three as $k=>$v){
                $th['wei_id'] = $v['wei_id'];
                $thdata['receipt_time'] = date('Y-m-d',strtotime('+2 day'));
                $thdata['wei_remarks'] = '收货';
                $WechaModel->where($th)->save($thdata);
            }
        }
        //第三天
        if(floor($nu*0.05) > 0){
            $four = $WechaModel->where($aa)->limit(floor($nu*0.05))->select();
            foreach ($three as $k=>$v){
                $f['wei_id'] = $v['wei_id'];
                $fdata['receipt_time'] = date('Y-m-d',strtotime('+3 day'));
                $fdata['wei_remarks'] = '收货';
                $WechaModel->where($f)->save($fdata);
            }
        }
        echo 1;
    }
    /*
    * 收货的笔数
    */
    public function NumberOfPens(){
        $name = I('name');
        $start = I('start');
        $end = I('end');
        $number = I('number');
        //判断参数是否存在
        if(empty($start) or empty($end) or empty($number)){
            echo 4;
            return false;
        }
        //实例化模型
        $ShopModel = D('Shop');
        $WechaModel = D('Weichat');
        $a['id'] = $name;
        //查询店铺数据
        $shop = $ShopModel->where($a)->find();
        //查询账号数据
        $aa['shop_name'] = $shop['shop_name'];
        $aa['bought_time'] = array(array('gt',$start),array('lt',$end));
        $aa['receipt_time'] = array('exp',' is NULL');
        $Wecha = $WechaModel->where($aa)->limit($number)->select();
        if(empty($Wecha)){
            echo 2;
            return false;
        }
        foreach ($Wecha as $k=>$v){
            $f['wei_id'] = $v['wei_id'];
            $fdata['receipt_time'] = date('Y-m-d',strtotime('+3 day'));
            $fdata['wei_remarks'] = '收货';
            $WechaModel->where($f)->save($fdata);
        }
        echo 1;
    }
}