<?php

/**
 * Functions: Api控制器.
 * Author: Li Yang
 * Link: http://www.hfyefan.com
 * Copyright: HfYefan NetWork Co.,Ltd.
 */

namespace Api\Controller;

use Think\Controller;

class ApiController extends Controller{
    public function select(){
        if(IS_GET)
        {
            $tasks_status=I('get.tasks_status');
            $admin_name=I('get.admin_name');
            $adminModel = D('Admin');
            $user['admin_name'] = $admin_name;
            $userId = $adminModel->where($user)->find();
//            var_dump($userId['admin_id']);
            $User=M('Taskstime');
            $a['time_status']=$tasks_status;
            $a['admin_id'] = $userId['admin_id'];
//            var_dump($a);
            $data=$User->where($a)->order('time_id ASC')->select();
//            var_dump($data);
//            die;
            foreach ($data as $k=>$v)
            {
                echo $data[$k]['time_id'].",".$data[$k]['time_title'].",".$data[$k]['group_name']."|";
            }
        }
        if(!$data) {// 上传错误提示错误信息
            echo "0";
        }
    }
//返回任务
    public function messages(){
        $id=I('get.id');
        $User=M('Taskstime');
        $a['time_id']=$id;
//            var_dump($a);
        $data=$User->where($a)->find();
        echo '标题:'.$data['time_title'].'|'.'分组:'.$data['group_name'].'|'.'URL:'.$data['time_url'].'|'.'经纬度:'.$data['time_ip'].'|'.'下单量:'.$data['time_flow'].'|'.'完成量:'.$data['time_complete'].'|'.'开始时间:'.$data['time_starttime'].'|'.'结束时间:'.$data['time_endtime'];
//    var_dump($data);
    }

    public function Setup(){
        if(IS_GET){
            $tasks_name=I('get.tasks_id');
            $tasks_status=I('get.tasks_status');
            $User=M('tasks');
            $a['tasks_id'] = $tasks_name;
            $test=$User->where($a)->select();
//            var_dump($test);
            $status = $test[0]["tasks_status"];
            if($tasks_status == $status){//任务代码错误提示
                echo "0";
                die;
            }
            $a['tasks_id'] = $tasks_name;
            $data['tasks_status'] = $tasks_status;
            $data=$User->where($a)->save($data);
            if($data){
                echo "1";
            }else{
                echo "0";
            }
        }
    }
    //任务进度
    public function state(){
        if(IS_GET){
            $tasks_state=I('get.tasks_state');
            $tasks_name=I('get.tasks_id');
            $User=M('tasks');
            $a['tasks_id'] = $tasks_name;
            $test=$User->where($a)->select();
            $status = $test[0]["tasks_state"];
            if($tasks_state == $status){//任务代码错误提示
                echo "0";
                die;
            }
            $data['tasks_state'] = $tasks_state;
            $data=$User->where($a)->save($data);
            if($data){
                echo "1";
            }else{
                echo "0";
            }
        }
    }
    public function states(){
        $equlist=I('get.equlist');
        $tasks_name=I('get.tasks_name');
        $tasks_state=I('get.tasks_state');
        $Grouping = D('Grouping');
        $a['equlist']=$equlist;
//        var_dump($a);
        $tasks = $Grouping->where($a)->select();
//        var_dump($tasks);
        if(empty($tasks)){
            echo "0";
            die;
        }
//        dump($tasks[0]['tasks_name']);
        if($tasks[0]['tasks_name'] ==$tasks_name){
            $data['tasks_state']=$tasks_state;
            $data=$Grouping->where($a)->save($data);
        }else{
            $data['tasks_name']=$tasks_name;
            $data['tasks_state']=$tasks_state;
            $data=$Grouping->where($a)->save($data);
        }
//        var_dump($data);
//        if($data){
        echo "1";
//        }else{
//            echo "失败";
//        }

    }
    //任务量
    public function select_messages(){
        if(IS_GET)
        {
            $name=I('get.tasks_name');
            $id=I('get.tasks_id');
            $navigation=M('navigation');
            $a['nav_name']=$name;
            $data=$navigation->where($a)->select();
            foreach ($data as $k=>$v)
            {
                if($data[$k]['nav_url']!="")
                {
                    $isurl="有图片";
                    $url=$data[$k]['nav_url'];
                    $num=$data[$k]['url_num'];
                }
                if($data[$k]['nav_url']=="")
                {
                    $isurl="无图片";
                    $url="";
                    $num="0";                }
            }
            if($data[$k]['tasks_status']==0)
            {
                $zhuangtai="开启";
            }
            if($data[$k]['tasks_status']==1)
            {
                $zhuangtai="关闭";
            }
            $tasks=M('tasks');
            $b['tasks_id']=$id;
            $data1=$tasks->where($b)->order('tasks_id')->select();
            foreach ($data1 as $k1=>$v1)
            {
                $group=$data1[$k1]['group_name'];
                $info=$data1[$k1]['tasks_configs'];
            }
            echo $isurl.":".$name.",".$group.",".$info.",".$num.",".$url;
        }
        if(!$data) {// 上传错误提示错误信息
            echo "0";
        }
    }

    public function selectgroup(){
        if(IS_GET)
        {
            $group_name=I('get.group_name');
            $user=M('tasks_group');
            $a['group_name']=$group_name;
            $data=$user->where($a)->order('group_id ASC')->select();
            foreach ($data as $k=>$v)
            {
                echo utf8_encode($data[$k]['equlist']);
            }
        }
        if(!$data) {
            echo "0";
        }
    }
    //判断设备
    public function equipment(){
        if(IS_GET) {
            $equlist=I('get.equlist');
            $group_name=I('get.group_name');
            $taskGroupModel = D('TasksGroup');
            $a['group_name']=$group_name;
            $arr = $taskGroupModel->where($a)->select();
            $equlist1 = explode(',',$arr[0]['equlist']);
            $value = in_array($equlist,$equlist1);
            if($value){
                echo "1";
            }else{
                echo "0";
            }
        }
    }
    //返回账号
    public function wechart(){
        if(IS_GET){
            $WechaModel = D('Weichat');
            $b[wei_static] = 0;
            $idcard = $WechaModel->where($b)->find();
//            var_dump($idcard);
//            die;
            $a['wei_id'] = $idcard['wei_id'];
//            var_dump($a);
//            die;
            $data['wei_static'] = 2;
            $value = $WechaModel->where($a)->save($data);
            if($idcard == ''){
                echo "0";
            }else{
                echo $idcard['wei_name'].','.$idcard['wei_password'].','.$idcard['wei_data'];
            }

        }
    }
    //传入账号
    public function account(){
        if(IS_GET) {
            $equlist = I('get.wei_equipment');
            $name = I('get.wei_name');
            $password = I('get.wei_password');
            $static = I('get.wei_static');
            $remarks = I('get.wei_remarks');
            $data['wei_equipment'] = I('get.wei_equipment');
//            $data['wei_name'] = I('get.wei_name');
//            $data['wei_password'] = I('get.wei_password');
            $data['wei_static'] = I('get.wei_static');
            $data['wei_remarks'] = I('get.wei_remarks');
            $WechaModel = D('Weichat');

            $a['wei_name']=str_replace(' ','+',$name);
//            var_dump($a);
//            die;
            $user = $WechaModel->where($a)->select();
//            var_dump($user);
            if(!$user){
                echo "0";
                die;
            }
            if($password == $user[0]['wei_password']){
                $value = $WechaModel->where($a)->save($data);
                if($value){
//                    echo $user[0]['wei_id'];
                    echo "1";
                    die;
                }else{
                    echo "0";
                    die;
                };
            }else{
                echo "0";
            }
        }
    }
    //删除账号
    public function accountdelete(){
        if(IS_GET) {
            $name = I('get.wei_name');
            $a['wei_name']= str_replace(' ','+',$name);
            $WechaModel = D('Weichat');
            $user = $WechaModel->where($a)->delete();
            //var_dump($user);
            if($user){
                echo "1";
            }else{
                echo "0";
            }
        }
    }
    //返回身份证账号
    public function idcard(){
        if(IS_GET){
            $IdCardModel = D('IdCard');
            $idcard = $IdCardModel->find();
//            var_dump($idcard);
            $a['card_id']= $idcard['card_id'];
            $user = $IdCardModel->where($a)->delete();
            if(!empty($idcard)){
                echo $idcard['card_id'].','.$idcard['card_name'].','.$idcard['card_product'].','.$idcard['card_city'].','.$idcard['card_area'].','.$idcard['card_path'];
            }else{
                echo "0";
            }

        }
    }
    //删除身份证账号
    public function idcarddelete(){
        if(IS_GET) {
            $name = I('get.card_id');
            $a['card_id']= $name;
            $IdCardModel = D('IdCard');
            $user = $IdCardModel->where($a)->delete();
            if($user){
                echo "1";
            }else{
                echo "0";
            }
        }
    }
    //返回任务量
    public function quantity(){
        $tasks_status=I('get.tasks_id');
        $User=M('tasks');
        $a['tasks_id'] = $tasks_status;
        $user = $User->where($a)->find();
        if(!empty($user)){
            echo $user['tasks_number'];
            die;
        }else{
            echo "失败";
        }

    }
    //任务完成量
    public function quancomplete(){
        $tasks_status=I('get.tasks_id');
        $User=M('tasks');
        $a['tasks_id'] = $tasks_status;
        $user = $User->where($a)->find();
        if(!empty($user)){
            echo $user['tasks_complete'];
            die;
        }else{
            echo "失败";
        }
    }
    //返回文件资源
    public function images(){
        if(IS_GET){
            $admin_name=I('get.name');
            $adminModel = D('Admin');
            $user['admin_name'] = $admin_name;
            $userId = $adminModel->where($user)->find();
            $UploadModel=D('Upload');
            $a['admin_id'] = $userId['admin_id'];
            $image = $UploadModel->where($a)->select();
//            var_dump($image);
            if(!empty($image)){
                foreach ($image as $vo){
                    $array[]= $vo['upload_name'].'----'.$vo['upload_path'];
                }
//            var_dump($array);
                foreach ($array as $a){
                    echo $a.'|';
                }
            }else{
                echo "0";
            }

        }

    }
    //返回文章资源
    public function content(){
        if(IS_GET){
            $admin_name=I('get.name');
            $adminModel = D('Admin');
            $user['admin_name'] = $admin_name;
            $userId = $adminModel->where($user)->find();
            $a['admin_id'] = $userId['admin_id'];
            $TextaraeaModel=D('Textarea');
            $value = $TextaraeaModel->where($a)->find();
//            var_dump($value['text_content']);
            if(empty($value)){
                echo "0";
            }else{
                $result = preg_split('/[;\r\n]+/s', $value['text_content']);
                foreach ($result as $value){
                    echo $value."----";
                }
            }

        }
    }
    //一键关闭用户下的任务
    public function superesc(){
        if(IS_GET){
            $admin_name=I('get.name');
            $taskid =I('get.static');
//            var_dump($admin_name);
            $taskModel = D('Tasks');
            $adminModel = D('Admin');
            $admin['admin_name'] = $admin_name;
            $value = $adminModel->where($admin)->find();
            if(!$value){
                echo "0";
                die;
            }
            $admin_id = $value['admin_id'];
            $a['tasks_status'] = $taskid;
            $b['admin_id'] = $admin_id;
            $tasks = $taskModel->where($b)->save($a);
            if($tasks){
                echo "1";
            }else{
                echo "0";
            }
        }
    }
    public function disable(){//被删除账号统计
        $DisableModel = D('Disable');
        $test=$DisableModel->select();
        $value = $test[0]['value'];
        ++$value;
        $a['id'] = $test[0]['id'];
        $data['value'] = $value;
        $data=$DisableModel->where($a)->save($data);
    }
    public function modify(){
        if(IS_GET){
            $name = I('get.name');
            $password = I('get.password');
            $WechaModel = D('Weichat');
            $a['wei_name']= str_replace(' ','+',$name);
            $data['wei_password'] = $password;
//            var_dump($name);
            $data=$WechaModel->where($a)->save($data);
            if($data){
                echo '1';
            }else{
                echo '0';
            }
        }
    }
    //更改任务金币数
    public function wechatgold(){
        if(IS_GET){
            $name = I('get.name');
            $gold = I('get.gole');
//            $password = I('get.password');
            $WechaModel = D('Weichat');
            $a['wei_name']= str_replace(' ','+',$name);
            $data['wei_gold'] = $gold;
//            var_dump($name);
            $data=$WechaModel->where($a)->save($data);
            if($data){
                echo '1';
            }else{
                echo '0';
            }
        }
    }
    //大众点评 任务量
    public function complete(){
        if(IS_GET){
            $time_id=I('get.time_id');
            $taskModel = D('Taskstime');
            $a['time_id'] = $time_id;
            $test=$taskModel->where($a)->find();
            $time_flow = $test["time_flow"];//下单
            $time_complete = $test["time_complete"];//完成
            $finish = $test["finish"];//完成
            ++$time_complete;
            ++$finish;
            if( $time_complete >= $time_flow){
                $data['time_status'] = 1;
                $data['time_complete'] = $time_complete;
                $data['finish'] = $finish;
                $data['equipment_id'] = 0;

                $data=$taskModel->where($a)->save($data);
                if($data){
                    echo "1";
                }else{
                    echo "0";
                }
                die;
            }
            $data['time_complete'] = $time_complete;
            $data['finish'] = $finish;
            $d=$taskModel->where($a)->save($data);
            if($d){
                echo "1";
            }else{
                echo "0";
            }
        }
    }
    //大众点评任务
    public function tasks(){
        if(IS_GET) {
            $equipment = I('id');
            $group_name=I('get.group_name');
            $taskGroupModel = D('TasksGroup');
            $equipment_id = [];
            $a['group_name']=$group_name;
            $arr = $taskGroupModel->where($a)->find();
            $equlist1 = explode(',',$arr['equlist']);
            $value = in_array($equipment,$equlist1);
            $taskModel = D('Taskstime');
            $a['time_status'] = 0;
            $a['group_name'] = $arr['group_name'];
            $a['equipment_id'] = 0;
            $res = $taskModel->select();
            foreach ($res as $vo){
                $b['time_id'] = $vo['time_id'];
                $time_lcomplete = $vo['time_lcomplete'];
                $finish = $vo['finish'];
                $cc = $time_lcomplete + $finish;
                $time = (time() - strtotime($vo['time_resources']));
                $day = ($time/(24*3600));
                $time1 = (strtotime($vo['time_endtime']) - time());
                $day1 = floor($time1/(24*3600));
                $day1 = $day1+1;
                $aaa = time()-strtotime($vo['time_resources']);
                $zuo = substr($vo['time_resources'],0,10);
                $jin = date('Y-m-d');
                if($zuo!=$jin){
//                    dump($vo['time_resources']);
                    $data['time_status'] = 0;
                    $data['time_lcomplete'] = $vo['time_complete'];
                    $data['time_resources'] = date("Y-m-d h:i:s", time());
                    $data['time_complete'] = 0;
                    $data['equipment_id'] = 0;
//                        $data['finish'] = $cc;
                    $res = $taskModel->where($b)->save($data);
                }
            }
        }
        if($value){
            $equipment_id['equipment_id'] = $equipment;
            $contnet = $taskModel->where($equipment_id)->find();
            $con = '';
//            dump($equipment_id);
            if(empty($contnet)){
                $va = $taskModel->where($a)->order('time_id')->find();
                $time_id['time_id'] = $va['time_id'];
                $taskModel->where($time_id)->save($equipment_id);
                if(!empty($va)){
                    $con .= 'ID:'.$va['time_id'].'--'.'title:'.$va['time_title'].'--'.'flow:'.$va['time_flow'].'--'.'Jingwei:'.$va['time_ip'].'--'.$va['time_stop'].'|';
                }else{
                    echo "0";
                }
            }else{
                $bb['time_status'] = 0;
                $bb['equipment_id'] = $equipment;
                $bb['group_name'] = $arr['group_name'];
                $contnet = $taskModel->where($bb)->find();
                if(!empty($contnet)){
                    $con .= 'ID:'.$contnet['time_id'].'--'.'title:'.$contnet['time_title'].'--'.'flow:'.$contnet['time_flow'].'--'.'Jingwei:'.$contnet['time_ip'].'--'.$contnet['time_stop'].'|';
                }else{
                    echo "0";
                }

            }
            echo $con;
        } else{
            echo "0";
        }
    }
    //添加wechart
    public function addwechart(){
//number='..phone..'&name='..jdname..'&password='..jdpass..'&ip='..ipxxx..'&address=&admin=admin&remarks=

        $phonenum = I('get.number');
//        dump($phonenum);
        $name = I('get.name');
        $password = I('get.password');
        $ip = I('get.ip');
        $address = I('get.address');//地址
        $remarks = I('get.remarks');//备注
        $admin_name = I('get.admin');
        
        $comment = I('comment');
        $shop_name=I('shop_name');
        $WechaModel = D('Weichat');
        $adminModel = D('Admin');
        $user['admin_name'] = $admin_name;
        $userId = $adminModel->where($user)->find();
        $data['wei_name'] = $name;
        $f['wei_name'] = $name;
        $data['wei_password'] =$password;

        $data['wei_number'] =$phonenum;
        $data['wei_ip'] =$ip;
        $data['wei_address'] =$address;

        // $data[''] =$address;
        $data['wei_time'] =date('Y-m-d H:i:s',time());
        $data['bought_time'] =date('Y-m-d H:i:s',time());
        if(!empty($remarks)){
            $data['wei_remarks'] =$remarks;
        }
        $data['admin_id']=$userId['admin_id'];
//        var_dump($data);
        $va = $WechaModel->where($f)->select();
        if(!empty($va)){
            $data = '';
        }
        $value = '';
        if($data !=''){
            $value = $WechaModel->add($data);
        }
        if($value){
            echo "1";
        }else{
            echo "0";
        }
    }
    //IP池判断
    public function ipJudge(){
        $equipment = I('get.id');
        $ip=I('get.ip');
        $Ipjudge = D('Ipjudge');
        $a['ip_value'] = $ip;
        $time = $Ipjudge->find();
//        dump($time['ip_time']);die;
        $zuo = substr($time['ip_time'],0,10);
        $jin = date('Y-m-d');
        $b['ip_tatic'] = 1;
        if($zuo!=$jin){
            $Ipjudge->where($b)->delete();
        }
        $taskGroupModel = D('TasksGroup');
        $aa = $taskGroupModel->select();
        $equlist1= [];
        foreach ($aa as $vo){
            $equlist1 = explode(',',$vo['equlist']);
            $value = in_array($equipment,$equlist1);
            if ($value){
                break;
            }
        }
        if(!$value) {
            echo "0";
            return;
        }
        $value = $Ipjudge->where($a)->select();
        if(!empty($value)){
            echo "0";
            return;
        }
        $data['ip_value'] = $ip;
        $data['ip_equipment'] = $equipment;
//         $data['ip_tatic'] = 1;
        $data['ip_time'] = date('Y-m-d H:i:s',time());
        $con = $Ipjudge->add($data);
        if(!empty($con)){
            echo "1";
            return;
        }
    }

    public function address(){
        $IdCardModel = D('IdCard');
        $address = I('address');
        $a['card_number'] =  array('like','%'.$address.'%');
        $value = $IdCardModel->where($a)->select();
        $a = count($value);
        echo $a;
    }
    public function Returnaddress(){
        $IdCardModel = D('IdCard');
        $address = I('address');
        $a['card_number'] =  array('like','%'.$address.'%');
        $value = $IdCardModel->where($a)->find();
        if(empty($value)){
            echo "0";
            return false;
        }
        $data['card_id'] = $value['card_id'];
        $IdCardModel->where($data)->delete();
        echo $value['card_name']."|".$value['card_number'];
    }

    public function getShop(){
        $shopModel=D('weichat');
        $name=I('name');
        $a['shop_name']=$name;
        $value=$shopModel->where($a)->select();
        if(empty($value)){
            echo "0";
            return false;
        }
        $data='';
        foreach ($value as $va) {
            $data.=$va['wei_remarks'].'|';
        }
        echo $data;
    }

//根据关键字查找到所有的地址 
    public function getAddress(){
        $addrModel=D('weichat');
        $address=I('address');
        $a['wei_address']=array('like','%'.$address.'%');
        $value=$addrModel->where($a)->select();
        if(empty($value)){
            echo "0";
            return false;
        }
        $data='';
        foreach ($value as $va) {
            $data.='订单号:'.$va['wei_remarks'].'--'.'帐号:'.$va['wei_name'].'<br/>';
        }
        // echo "<meta http-equiv='content-Type' content='text/html' charset='utf-8'>";
        echo $data;
    }


    public function get($url, $data_type = 'text', $USERPWD = null)
    {
        $cl = curl_init();
        if (stripos($url, 'https://') !== FALSE) {
            curl_setopt($cl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($cl, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($cl, CURLOPT_SSLVERSION, 1);
        }
        curl_setopt($cl, CURLOPT_URL, $url);
        curl_setopt($cl, CURLOPT_RETURNTRANSFER, 1);
        if ($USERPWD !== null) {
            curl_setopt($cl, CURLOPT_USERPWD, $USERPWD);
        }
        $content = curl_exec($cl);
        $status = curl_getinfo($cl);
        curl_close($cl);
        if (isset($status['http_code']) && $status['http_code'] == 200) {
            if ($data_type == 'json') {
                $content = json_decode($content);
            }
            if ($data_type == 'array') {
                $content = json_decode($content, true);
            }
            return $content;
        } else {
            return FALSE;
        }
    }


    public function me(){

        $flie = "http://apis.map.qq.com/ws/place/v1/search?keyword=%E9%85%92%E5%BA%97&boundary=nearby(39.908491,116.374328,1000)&key=AYTBZ-ZREKJ-ATVF3-FWMEW-FFXC5-CVF5Y";

        $arr = $this->get($flie,'array');
        // echo "<meta http-equiv='content-Type' content='text/html' charset='utf-8'>";
        dump ($arr);
    }
// ce shi yong de
    public function getN(){
        $testModel=D('test');
        $name=I('name');
        $data['name']=$name;
        $val=$testModel->add($data);
        if($val){
            echo "1";
        }else{
            echo "0";
        }
    }
    //vpn地址查找相对应的网址
    public function getUrl(){
        $addrModel = D('vpnaddress');
        $address = I('address');
        $a['address_addr'] =  array('like','%'.$address.'%');
        $value = $addrModel->where($a)->find();
        if(empty($value)){
            echo "0";
            return false;
        }
        $data = '';
        // foreach ($value as $va) {
        //     $data.=$va['address_url'].'<br/>';
        // }
        $data = $value['address_url'].'<br/>';
        // echo "<meta http-equiv='content-Type' content='text/html' charset='utf-8'>";
        echo $data;
    }
    //vpn设备名查找相对应的账号，密码
    public function getEqu(){
        $addrModel = D('vpnaccount');
        $equ = I('equ');
        $a['equipment'] =  array('like','%'.$equ.'%');
        $value = $addrModel->where($a)->select();
        if(empty($value)){
            echo "0";
            return false;
        }
        $data = '';
        foreach ($value as $va) {
            $data.=$va['account_name'].'-'.$va['account_password'].'<br/>';
        }
        // echo "<meta http-equiv='content-Type' content='text/html' charset='utf-8'>";
        echo $data;
    }
    //实名认证：省市查找相对应的整条
    public function getId(){
        $addrModel = D('IdCard');
        $province= I('province');//省
        $city= I('city');//市
        if(empty($province)){
            echo "0|必要参数为空";
            return false;
        }
        $a['card_product'] =  array('like','%'.$province.'%');
        $a['card_city']=array('like','%'.$city.'%');
        $value = $addrModel->where($a)->find();
        $c['card_id'] = $value['card_id'];
        if(empty($value)){
            echo "0";
            return false;
        }
        $data = '';
        // foreach ($value as $va) {
        $data.=$value['card_name'].'-'.$value['card_product'].'-'.$value['card_city'].'-'.$value['card_area'].'-'.$value['card_path'].'<br/>';
        // }
        // echo "<meta http-equiv='content-Type' content='text/html' charset='utf-8'>";
        echo $data;
        $addrModel->where($c)->delete();
    }
//查找该帐号下的所有任务
    public function getTask(){
        $admin=I('admin');
        $eqid=I('eq_id');
         $grouping = M('grouping');
        $a['equlist'] = $eqid;
        $id = $grouping->where($a)->find();//获取设备id
        if(empty($id)){
            echo "0|当前设备没有权限获取任务，请联系管理员";
            return false;
        }

        $adminModel = D('Admin');
        $user['admin_name'] = $admin;
        $userId = $adminModel->where($user)->find();//根据输入的用户名查找对应的id
        if(empty($admin)){
            echo "0|必要参数为空";
            return false;
        }
        $tasksModel=D('taskstime');
        $con['tasks_status']=0;
        $con['admin_id']=$userId['admin_id'];
        $con['group_name']=$id['group_name'];
        $res=$tasksModel->where($con)->select();//查找该帐号下的所有任务
        //dump($res);
        $data = '';
        foreach ($res as $va) {
            $data.=$va['time_id'].'-'.$va['time_title'].'-'.$va['time_flow'].'-'.$va['group_name'].'-'.$va['wei_province'].'-'.$va['wei_city'].'<br/>';
        }
        // echo "<meta http-equiv='content-Type' content='text/html' charset='utf-8'>";
        echo $data;
    }
//根据任务id返回任务，去一次任务，当前的完成量+1，完成量=下单量的时候，完成量=0，状态=1，总量=下单量
    public function gettaskId(){
        $tasksId=I('tasksid');
        if(empty($tasksId)){
            echo "0|必要参数为空";
            return false;
        }
        $con['time_id']=$tasksId;
        $tasksModel=D('taskstime');
        $res=$tasksModel->where($con)->find();//查找该帐号下的所有任务
        if($res['time_complete']<$res['time_flow']){
            $res['time_complete']++;
            $data['time_complete']=$res['time_complete'];
        }else{
            $res['total']=$res['time_complete'];
            $data['time_status']=1;
            $data['time_complete']=0;
            $data['total']=$res['total'];
        }

        $val=$tasksModel->where($con)->save($data);
        if($val){
            echo "1";
        }else{
            echo "0";
        }
    }
    //根据设备id、设备分组查找有无该设备：1有 0无
    public function getRes(){
        $equId=I('equid');
        $groupName=I('groupname');
        if(empty($equId) && empty($groupName)){
            echo "0|必要参数为空";
            return false;
        }

        $groupModel=D('grouping');
        $con['equlist']=$equId;
        $con['group_name']=$groupName;
        $val=$groupModel->where($con)->select();
        if(empty($val)){
            echo '0';
        }else{
            echo '1';
        }
    }
    function creatlist(){

        $list = I('list');
        $datamodel = D('Data');
        $data['data'] = $list;
        // echo 1;
        $a = $datamodel->add($data);
        dump($a);
    }
    //返回设备账号
    public function returnjd(){
        $equId=I('equid');
        if(empty($equId)){
            echo "0|必要参数为空";
            return false;
        }
        $WechaModel = D('Weichat');
        $a['wei_equipment'] = $equId;
        $content = $WechaModel->where($a)->find();
        if(empty($content)){
            echo "0|当前设备没有账号";
            return false;
        }
        $b['wei_id'] = $content['wei_id'];
        $datas['wei_equipment'] = NULL;
        $datas['we_we'] = $content['wei_equipment'];
        $datas['wei_remarks'] = "下单中";
        $datas['wei_static'] = 6;
        $WechaModel->where($b)->save($datas);
        echo $content['wei_number']."|".$content['wei_address']."|".$content['wei_id'];

    }
    //返回店铺名
    public function returnshop(){
        $shop = D('Shop');
        $conten = $shop->select();
        if(empty($conten)){
            echo "0|店铺查询失败";
            return false;
        }
        $shop_name = '';
        foreach ($conten as $vo){
            $shop_name .=  $vo['shop_name']."|";
        }
        echo $shop_name;
    }
    //添加假订单数据
    public function addwc(){
        date_default_timezone_set('PRC');
        $number = I('number');
        $shopname = I('shopname');
        $order = I('order');
        $money = I('money');
        $WechaModel = D('Weichat');
        $a['wei_number'] = $number;
        $data['shop_name'] = $shopname;
        $data['we_order'] = $order; //订单
        $data['wei_gold'] = $money;
        $data['wei_remarks'] = "已下单";
        $data['wei_static'] = 6;
        $data['bought_time'] = date('y-m-d H:i:s',time());
        //dump($data);
        //dump($a);
//        $data['comment'] = $comment;
        $content = $WechaModel->where($a)->save($data);
        if(empty($content)){
            echo 1;
            return true;
        }else{
            echo 0;
            return false;
        }
    }
//返回收货账户
    public function returnshopsreceipt(){
        header("Content-Type: text/html; charset=utf-8");
        $WechaModel = D('Weichat');
        $a['wei_remarks'] = '收货';
        $a['wei_static'] = ['eq','6'];
        $a['receipt_time'] = ['ELT',date('Y-m-d')];
        $a['receipt_time'] = array('NEQ','');//模糊查询
        $aaa = mt_rand(1,9999);
                $con = $WechaModel->where($a)->find();
                if(empty($con)){
                    echo "0|当前没有需要收货的账户";
                    return false;
                }

                $b[wei_id] = $con['wei_id'];
                if (!empty($con['longs'])){
                    $times = $con['longs'];
                    $data['longs'] = '';
                    $data['receipt_time'] = date('Y-m-d',strtotime("+ $times day"));
                }else{
                    $data['wei_remarks'] = '已收货';
                    $data['wei_static'] = 1;
                }
                $WechaModel->where($b)->save($data);
                echo $con['wei_number']."|".$con['wei_address']."|".$con['comment'];
    }
    public function receipt(){
        $number = I('number');
        $id = I('id');
        $WechaModel = D('Weichat');
        //一是否收货
        $a['wei_number'] = $number;
        $con = $WechaModel->where($a)->find();
        if($id == '1'){
//            dump($con['pay_password']);
//            dump(empty($con['pay_password']));
            if(empty($con['pay_password'])){
                echo '1';
                return false;
            }else{
                echo '2';
                return false;
            }
        }
        //是否评价
        if($id == '2'){
            if($con['pay_password'] == 2){
                if(!empty($con['comment']) and empty($con['longs']) and date('Y-m-d') == $con['receipt_time']){
                    echo $con['comment'];
                    return false;
                }else{
                    echo '2';
                    return false;
                }
            }else{
                echo '2';
                return false;
            }
        }
        //是否追评
        if($id == '3'){
            if($con['pay_password'] == 3){
//                dump(date('Y-m-d') == $con['receipt_time']);
                if(!empty($con['ratings']) and empty($con['ratings_time']) and date('Y-m-d') == $con['receipt_time']){
                    echo $con['ratings'];
                    return false;
                }else{
                    echo '2';
                    return false;
                }
            }else{
                echo '2';
                return false;
            }
        }
    }
    public function receiptstatic(){
        $number = I('number');
        $id = I('id');
        $WechaModel = D('Weichat');
        //一是否收货
        $a['wei_number'] = $number;
        $con = $WechaModel->where($a)->find();
        $data['pay_password'] = $id;
        if($id == 3){
            if (!empty($con['ratings_time'])){
                $times = $con['ratings_time'];
                $data['ratings_time'] = '';
                $data['wei_static'] = 6;
                $data['wei_remarks'] = '收货';
                $data['receipt_time'] = date('Y-m-d',strtotime("+ $times day"));
            }
        }
        if($id == 4){
            $data['wei_static'] = 1;
            $data['wei_remarks'] = '以追评';
        }
        $WechaModel->where($a)->save($data);
    }
    //更新状态
    public function staticwe(){
        $number = I('number');
        $static = I('static');
        $remarks = I('remarks');
        
        if ($static == ''){
            $static = 6;
        };
        $WechaModel = D('Weichat');
        $a['wei_number'] = $number;
        $data['wei_static'] = $static;
        if(empty($remarks)){
            $data['wei_remarks'] = '已评价';
        }else{
            $data['wei_remarks'] = $remarks;
        }
        
        //$data['shop_name'] = NULL;
        $a = $WechaModel->where($a)->save($data);
        dump($a);
    }

    public function uptasks(){
        $time_id = I('id');
        $tasksModel=D('taskstime');
        $a['time_id'] = $time_id;
        $tasks = $tasksModel->where($a)->find();
        $data['finish'] = $tasks['finish']+1;
        $tasks = $tasksModel->where($a)->save($data);

    }

    public function aaa(){
        $a = file_get_contents("http://x.sryun.com/tools/jsonp.php?arg=area");
        $c = decodeUnicode($a);
        $c = json_decode($c);
        
        $vpnmodel = D('vpnaddress');
        $aa = [];
        foreach ($c->list as $vo){
            $aa[]= ["address_addr"=>$vo->areaname,'address_url'=>$vo->srvid];
        }
        $cc = $vpnmodel->addAll($aa);
        dump($cc);
    }


    public function latlng(){
        $addr=I('addr');
        $file2="http://apis.map.qq.com/ws/geocoder/v1/?address=".$addr."&key=AYTBZ-ZREKJ-ATVF3-FWMEW-FFXC5-CVF5Y";
        $res=get($file2,'array');
       
        echo $res['result']['location']['lng'].'|'.$res['result']['location']['lat'];
    }

    public function upip(){

        $number = I('number');
        $static = I('static');
        
        $WechaModel = D('Weichat');
        $a['wei_number'] = $number;
        $data['wei_ips'] = $static;
       
        //$data['shop_name'] = NULL;
        $a = $WechaModel->where($a)->save($data);
    }
    //代理店铺
    public function Agentshop(){
        $name = I('name');
        $GroupingModel = D('Grouping');
        $a['equlist'] = $name;
        $val = $GroupingModel->where($a)->find();
         
        $shop = D('Shop');
        $b['ag_id'] = $val['ag_id'];
        $conten = $shop->where($b)->select();

        if(empty($conten)){
            echo "0|店铺查询失败";
            return false;
        }
        $shop_name = '';
        foreach ($conten as $vo){
            $shop_name .=  $vo['shop_name']."|";
        }
        echo $shop_name;
    }
    //代理收货
    public function Agentdelivery(){
        header("Content-Type: text/html; charset=utf-8");
        $name = I('name');
        $GroupingModel = D('Grouping');
        $a['equlist'] = $name;
        $val = $GroupingModel->where($a)->find();
        $WechaModel = D('Weichat');
        $a['wei_remarks'] = '收货';
        $a['agent_id'] =$val['ag_id'];
        $a['wei_static'] = ['eq','6'];
        $a['receipt_time'] = ['ELT',date('Y-m-d')];
        $a['receipt_time'] = array('NEQ','');//模糊查询
        $aaa = mt_rand(1,9999);
                $con = $WechaModel->where($a)->find();
                if(empty($con)){
                    echo "0|当前没有需要收货的账户";
                    return false;
                }

                $b[wei_id] = $con['wei_id'];
                if (!empty($con['longs'])){
                    $times = $con['longs'];
                    $data['longs'] = '';
                    $data['receipt_time'] = date('Y-m-d',strtotime("+ $times day"));
                }else{
                    $data['wei_remarks'] = '已收货';
                    $data['wei_static'] = 1;
                }
                $WechaModel->where($b)->save($data);
                echo $con['wei_number']."|".$con['wei_address']."|".$con['comment'];

    }

}