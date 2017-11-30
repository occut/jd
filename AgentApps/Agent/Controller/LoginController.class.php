<?php

/**
 * Functions:管理员登录 .
 * Author: Zhu Jinhao
 * Link: http://www.hfyefan.com
 * Copyright: HfYefan NetWork Co.,Ltd.
 */

namespace Agent\Controller;

use Think\Controller;

class LoginController extends Controller {

    /**
     * 登录界面
     */
    public function index() {
        $id = session('AgentName');
        if(!empty($id)){
            redirect('/Agent.php/Index/', 1, '页面跳转中...');
        }
        $this->display('Login/admin');
    }

    /**
     * 登录方法
     */
    public function login() {
        if (IS_POST) {
            //接受POST传递的值
            $adminName = I('adminname');
            $adminPass = I('adminpass');
            //实例化Admin模型.
            $adminModel = D('Agent');
            //查询admin表中 admin_name为$adminName
            $admin = $adminModel->selectByName($adminName);
            //判断查询的结果是否为空
            if (is_null($admin)) {
                $this->error(L('LOGIN_ERROR_USERNAME'));
            }
            //判断用户状态是否正确
            if($admin['ag_ban'] == C('ADMIN_STATUS_NO')){
            	$this->error(L('LOGIN_ERROR_STATUS'));
            }
//            dump($admin['ag_ban']);
//            dump(C('ADMIN_STATUS_NO'));
//            dump($admin['ag_pw']);
//            dump(admin_md5($adminPass));
//            die;
            //判断用户输入的密码和管理员表中的密码是否一致
            if (admin_md5($adminPass) != $admin['ag_pw']) {
                $this->error(L('LOGIN_ERROR_PASSWORD'));
            }
            //登录时，修改用户的最后登录时间和登录IP
            $adminId = $admin['ag_id'];
            $data['ag_ltime'] = date('Y-m-d H:i:s');
            $data['ag_ip'] = get_client_ip();
            D('Agent')->saveAgent($adminId, $data);
            //用户名和用户id保存到SESSION
            session('AgentId', $admin['ag_id']);
            session('AgentName', $admin['ag_name']);
            session('wallpaper', $admin['admin_wallpaper']);
            session('header', $admin['admin_header']);


            //存入分组ID和菜单ID
            session('groupid',1);
            session('menuid',41);
            //重定向到任务首页
//            sendMail('962956814@qq.com','登录提示',session('adminName').'登录成功');
            redirect('/Agent.php/Index/', 1, '页面跳转中...');
            //跳转到后台界面
//            $this->redirect('Index');
        }
    }

    /**
     * 退出后台
     */
    public function logout() {
        //删除用户名和用户id SESSION
        session('AgentId', null);
        session('AgentName', null);
        session('menuid',null);
        session('groupid',null);
        //跳转到登录界面
        $this->redirect('Login/index');
    }
    /*
     * 查找对应头像
     */
    public function getPic(){
        $adminModel=D('admin');
        $uploadModel=D('upload');
        $name=I('name');
        $con['admin_name'] = array('like','%'.$name.'%');//模糊查询
        $res=$adminModel->where($con)->find();
        $con1['admin_id']=$res['admin_id'];
        $val=$uploadModel->where($con1)->find();
        $ex=explode("|",$val['upload_name']);
        $ex1=explode("|",$val['upload_path']);
        if(!empty($ex)){
            $data = ['error' => 1,'path'=>$ex1[0],'name'=>$ex[0]];
            echo json_encode($data);
        }else{
            echo 1;
        }
    }
}
