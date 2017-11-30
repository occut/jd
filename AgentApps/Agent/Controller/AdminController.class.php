<?php

/**
 * Functions: 管理员控制器.
 * Author: Zhu Jinhao
 * Link: http://www.hfyefan.com
 * Copyright: HfYefan NetWork Co.,Ltd.
 */

namespace Admin\Controller;

use Think\Controller;

class AdminController extends SuperController {

    /**
     * 显示管理员界面
     */
    public function listAdmins() {
        //实例化Admin模型
        $adminModel = D('Agent');
        //获取总的用管理员数
        $count = $adminModel->selectAdminTotalSize();
        //实例化分页类
        $page = new \Org\Page\Page($count,$this->adminPageSize);
        //获取每页显示的数据集
        $admins = $adminModel->selectAdminByPage($page);
        //分页显示输出
        $show = $page->show();
        //管理员操作记录到日志表中
        $logcontent =C('SYS_LOG_ACTION_SELECT')."管理员查询成功。";
        sys_log(session('adminId'),session('adminName'),$logcontent);
        //赋值到模版
        $this->assign('listadmins', $admins);
        $this->assign('count', $count);
        $this->assign('page', $show);
        $this->display();
    }

    /**
     * 添加管理员信息
     */
    public function addAdmin() {

        if (IS_POST) {
            //接受POST传递出来的信息
            $adminName = I('adminname');
            $adminPass = I('adminpass');
            $repetionPass = I('repetionpass');
            $adminRealname = I('adminrealname');
            $adminEmail = I('adminemail');
            $adminMobile = I('adminmobile');
            $adminStatus = I('adminstatus');
            $size = 10;
            $path = "images";
            $file = $_FILES['profile'];//头像
            $file1 = $_FILES['background'];//桌面背景
            $type = "jpg|png|jpeg|gif";
            $a = up($file,$type,$size,$path);
            $a1 = up($file1,$type,$size,$path);
            if ($adminPass != $repetionPass) {
                $this->error('两次密码输入不一致');
            }

            //实例化Admin模型
            $uploadModel=D('upload');
            $adminModel = D('Agent');

            //查询admin表中 admin_name为$adminName并且admin_status为1的一条数据
            $admin = $adminModel->selectAdminByName($adminName);
            if ($admin){
                $this->error('管理员名已存在');
            }

            //添加的管理员信息存入到数据库中
            $data['admin_name'] = $adminName;
            $data['admin_pass'] = admin_md5($adminPass);
            $data['admin_realname'] = $adminRealname;
            $data['admin_email'] = $adminEmail;
            $data['admin_mobile'] = $adminMobile;
            //添加管理员信息
            $result = $adminModel->addAdmin($data);
            $coinModel = M('coin','yefan_','DB_CONFIG1');
            $d['admin_name']=$adminName;
            $val=$adminModel->where($d)->find();
            $co['admin_id']=$val['admin_id'];
            $co['upload_name']=$a['savename'].'|'.$a1['savename'];
            $co['upload_path']=$a['savepath'].'|'.$a1['savepath'];
            $uploadModel->add($co);
            //返回添加管理员信息的结果
            if ($result) {
                //管理员操作记录到日志表中
                $logcontent = C('SYS_LOG_ACTION_ADD')."管理员添加成功。" . "用户名：" .$adminName;
                sys_log(session('adminId'),session('adminName'),$logcontent);
                
                $this->success(L('ADD_ADMIN_SUCCESS'), U('Agent/listadmins'));
            } else {
                 //管理员操作记录到日志表中
                $logcontent = C('SYS_LOG_ACTION_ADD')."管理员添加失败。" . "用户名：" .$adminName;
                sys_log(session('adminId'),session('adminName'),$logcontent);
                $this->error(L('ADD_ADMIN_FAILURE'));
            }
        } else{
            //显示添加页面
            $this->display('Agent/addadmin');
        }
    }

    /**
     * 编辑一个用户信息方法
     */
    public function editAdmin() {
        //实例化Admin模型
        $adminModel = D('Agent');
        if (IS_POST) {
            //接受POST传递过来的数据
            $adminId = I('adminid');
            $adminName = I('adminname');
            $adminRealname = I('adminrealname');
            $adminEmail = I('adminemail');
            $adminMobile = I('adminmobile');
            $adminStatus = I('adminstatus');
            //把编辑的管理员信息保存到管理员表中
            $data['admin_name'] = $adminName;
            $data['admin_realname'] = $adminRealname;
            $data['admin_email'] = $adminEmail;
            $data['admin_mobile'] = $adminMobile;
            $data['admin_status'] = $adminStatus;
            //编辑admin_id为$id的用户信息
            $result = $adminModel->saveAdmin($adminId, $data);
            //返回一个编辑结果
            if ($result) {
                //管理员操作记录到日志表中
                $logcontent = C('SYS_LOG_ACTION_MODIFY')."管理员编辑成功。" . "用户名：" .$adminName;
                sys_log(session('adminId'),session('adminName'),$logcontent);
                $this->success(L('EDIT_ADMIN_SUCCESS'), U('Agent/listadmins'));
            } else {
                 //管理员操作记录到日志表中
                $logcontent = C('SYS_LOG_ACTION_MODIFY')."管理员编辑失败。" . "用户名：" .$adminName;
                sys_log(session('adminId'),session('adminName'),$logcontent);
                $this->error(L('EDIT_ADMIN_FAILURE'));
            }
        } else{
            //get传递过来的参数
            $adminId = I('adminid');
            // 从管理员表中，查找用户id为$id管理员    ;
            $admin = $adminModel->selectAdminById($adminId);
            //赋值到模版
            $this->assign('selectadmin', $admin);
            $this->display('Agent/editAdmin');
        }
    }
    /**
     * 管理员分配角色(把管理员admin_id和角色role_id一起存入到admin_role表中)
     */
    public function addAdminAndRoles() {

        if (IS_POST) {
            //接受POST传递过来的值
            $adminId = I('adminid');
            $roleId = I('roleid');
            //实列AdminRole模型
            $adminroleModel = D('AdminRole');
            //删除管理员-角色关系表admin_role中admin_id为$adminid的数据信息
            $adminroleModel->deleteAdminRoleByAdminId($adminId);
            //把管理员表中的admin_id和角色表中role_id存入到admin_role关系表中
            foreach ($roleId as $value) {
                $data['role_id'] = $value;
                $data['admin_id'] = $adminId;
                $result = $adminroleModel->addAdminRole($data);                
            }
            //返回添加结果
            if ($result) {
                //管理员操作记录到日志表中
                $logcontent = C('SYS_LOG_ACTION_ADD')."管理员分配角色成功。" . "角色名：" .$adminName;
                sys_log(session('adminId'),session('adminName'),$logcontent);
                
                $this->success(L('ADD_ADMINANDROLES_SUCCESS'), U('Agent/listAdmins'));
            } else {
                $this->success(L('ADD_ADMINANDROLES_FAILURE'), U('Agent/listAdmins'));
            }
        } else{
            //接受GET传递过来的admin_id参数
            $adminId = I('adminid');
            //实例化Admin模型
            $adminModel = D('Agent');
            //实例化Role模型
            $roleModel = D('Role');
            //实例化AdminRole模型
            $adminroleModel = D('AdminRole');
            //查找管理员表中admin_id为$id的一条数据
            $admin = $adminModel->selectAdminById($adminId);
            //查找角色表中的所有信息
            $roles = $roleModel->selectAllRoles();
            //查找所有管理员-角色表admin_id为$adminId
            $adminRole = $adminroleModel->selectAdminRoleByAdminId($adminId);
            //赋值到模版
            $this->assign('roles', $roles);
            $this->assign('admin', $admin);
            $this->assign('adminrole', $adminRole);
            $this->display('Agent/addadminandroles');
        }
    }

    /**
     * 删除一条用户信息的方法
     */
    public function deleteAdmin() {
        if (IS_GET){
            //接受GET传递过来的参数
            $adminId = I('adminid');
            //实例化Admin模型
            $adminModel = D('Agent');
            //实例化AdminRole模型
            $adminroleModel = D('AdminRole');
            //删除管理员-角色admin_role表中admin_id为$id的一条数据
            $adminroleModel->deleteAdminRoleByAdminId($adminId);
            //查询管理员表中的admin_id为$adminId的一条数据
            $adminName=$adminModel->selectAdminById($adminId);
            //删除管理员表中的admin_id为$id的一条数据
            $result = $adminModel->deleteAdminById($adminId);
            //删除此Id所对应的金币账号
            $coinModel = M('coin','yefan_','DB_CONFIG1');
            $d['admin_id']=$adminId;
            $coinModel->where($d)->delete();
            if ($result) {
                //管理员操作记录到日志表中
                $logcontent = C('SYS_LOG_ACTION_DELETE')."管理员删除成功。" . "用户名：" . $adminName['admin_name'];
                sys_log(session('adminId'),session('adminName'),$logcontent);
                $this->success(L('DELTE_ADMIN_SUCCESS'));
        } else {
                //管理员操作记录到日志表中
                $logcontent = C('SYS_LOG_ACTION_DELETE')."会员管理员删除失败。" . "用户名：" . $adminName['admin_name'];
                sys_log(session('adminId'),session('adminName'),$logcontent);
                $this->error(L('EDIT_ADMIN_FAILURE'));
        }
    }
    }

    /**
     * 显示角色管理界面
     */
    public function listRoles() {
        //实例化Role模型
        $roleModel = D('Role');
        //获取总的用户数
        $count = $roleModel->selectRoleTotalSize();
        //实例化分页类
        $page = new \Org\Page\Page($count,$this->adminPageSize);
        //获取每页显示的数据集
        $roles = $roleModel->selectRoleByPage($page);
        //分页显示输出
        $show = $page->show();
         //管理员操作记录到日志表中
        $logcontent =C('SYS_LOG_ACTION_SELECT')."角色管理查询成功。";
        sys_log(session('adminId'),session('adminName'),$logcontent);
        //赋值到模版
        $this->assign('roles', $roles);
        $this->assign('count', $count);
        $this->assign('page', $show);
        $this->display('Agent/listroles');
    }

    /**
     * 添加角色名方法
     */
    public function addRole() {
        if (IS_POST) {
            //接受POST传递过来的值
            $roleName = I('rolename');
            //实例化Role模型
            $roleModel = D('Role');
            //保存角色名
            $data['role_name'] = $roleName;
            $result = $roleModel->addRole($data);
            //返回一个添加结果
            if ($result) {
                //管理员操作记录到日志表中   
               $logcontent = C('SYS_LOG_ACTION_ADD')."角色添加成功。" . "角色名：" . $roleName;
               sys_log(session('adminId'),session('adminName'),$logcontent);
                $this->success(L('ADD_ROLE_SUCCESS'), U('Agent/listroles'));
            } else {
               //管理员操作记录到日志表中   
               $logcontent = C('SYS_LOG_ACTION_ADD')."角色名添加失败。" . "角色名：" . $roleName;
               sys_log(session('adminId'),session('adminName'),$logcontent);
                $this->error(L('ADD_ROLE_FAILURE'));
            }
        } else{
            //显示添加角色界面 
            $this->display('Agent/addrole');
        }
    }

    /**
     * 编辑角色名
     */
    public function editRole() {
        if (IS_POST) {
            //接受POST传递过来的参数
            $roleId = I('roleid');
            $roleName = I('rolename');
            //实例化Role模型
            $roleModel = D('Role');
            //编辑角色名
            $result = $roleModel->saveRole($roleId, $roleName);
            /* 返回一个编辑结果 */
            if ($result) {
                //管理员操作记录到日志表中
                $logcontent = C('SYS_LOG_ACTION_MODIFY')."角色名编辑成功。" . "角色名：" .$roleName;
                sys_log(session('adminId'),session('adminName'),$logcontent);
                $this->success(L('EDIT_ROLE_SUCCESS'), U('Agent/listRoles'));
            } else {
                 //管理员操作记录到日志表中
                $logcontent = C('SYS_LOG_ACTION_MODIFY')."角色名编辑失败。" . "角色名：" .$roleName;
                sys_log(session('adminId'),session('adminName'),$logcontent);
                $this->error(L('EDIT_ROLE_FAILURE'));
            }
        } else{
            //编辑角色界面
            //接受GET传递过来的参数
            $roleId = I('roleid');
            //实例化Role模型
            $roleModel = D('Role');
            //查询某一个角色名
            $roles = $roleModel->selectRoleById($roleId);
            //赋值到模版
            $this->assign('roles', $roles);
            $this->display("Agent/editrole");
        }
    }

    /**
     * 删除角色名
     */
    public function deleteRole() {
        //接受get传递过来的role_id
        $roleId = I('roleid');
        // 实列化RoleModule模型
        $roleModuleModel = D('RoleModule');
        //实例化Role模型
        $roleModel = D('Role');
        //实例化AdminRole模型
        $adminroleModel = D('AdminRole');
        //删除管理员-角色表admin_role 中的role_id为$roleId的数据
        $adminroleModel->deleteAdminRoleByRoleId($roleId);
        //删除角色-模块表role_module表中role_id为$id的数据
        $roleModuleModel->deleteRoleModuleByRoleId($roleId);
        //查询角色
         $roleName=$roleModel->selectRoleById($roleId);
        //删除角色名
        $result = $roleModel->deleteRoleById($roleId);
        //返回一个删除结果
        if ($result) {
            //管理员操作记录到日志表中
              $logcontent = C('SYS_LOG_ACTION_DELETE')."角色名删除成功。" . "角色名：" . $roleName['role_name'];
              sys_log(session('adminId'),session('adminName'),$logcontent);
            $this->success(L('DELTE_ROLE_SUCCESS'));
        } else {
              //管理员操作记录到日志表中
              $logcontent = C('SYS_LOG_ACTION_DELETE')."角色名删除失败。" . "角色名：" . $roleName['role_name'];
              sys_log(session('adminId'),session('adminName'),$logcontent);
            $this->error(L('DELTE_ROLE_FAILURE'));
        }
    }

    /**
     * 显示角色分配资源界面
     */
    public function listResources() {
        //接受GET传递过来的role_id值
        $roleId = I('roleid');
        //实例化Role模型
        $roleModel = D('Role');
        //实列化Module模型
        $moduleModel = D('Module');
        //实列化RoleModul模型
        $roleModuleModel = D('RoleModule');

        //查找角色表中role_id为$roleId一条数据信息
        $role = $roleModel->selectRoleById($roleId);

        //查询模块表中所有的模块资源
        $showmodules = $moduleModel->selectAllModules();

        //查询角色-模块表role_module表中role_id为$roleId的所有数据
        $roleModule = $roleModuleModel->selectRoleModuleByRoleId($roleId);
        $result = [];
        $nodeIds = [];
        $nodeId = '';
        foreach ($roleModule as $vv){
            $nodeId .=$vv['module_id'].",";
            $nodeIds[] = $vv['module_id'];
        }
        $a =strrpos($nodeId,",");
        $nodeId = mb_substr($nodeId,0,$a);
        foreach ($showmodules as $vo){
            if(in_array($vo['module_id'],$nodeIds)){
                $vo['open'] = true;
                $vo['checked'] = true;
                $result[] =$vo;
            }else{
                $result[] =$vo;
            }
        }
        $result = json_encode($result);
        //赋值到模版
        $this->assign('result', $result);
        $this->assign('nodeIds', $nodeId);
        $this->assign('role', $role);
        $this->assign('showmodules', $showmodules);
        $this->assign('rolemodule', $roleModule);
        $this->display();
    }
    /**
     * 添加分配资源方法oiasdhfoiashfoiawheiofhiawhfowae
     */
    public function addRoleResource() {
        if (IS_POST) {
            $roleId = I('roleid');
            $moduleId = I('node_id');
            $moduleId = explode(",",$moduleId);
           //实列化RoleModul模型
            $roleModuleModel = D('RoleModule');
            //删除角色-模块关系表中的role_id为$roleId的数据
            $roleModuleModel->deleteRoleModuleByRoleId($roleId);
            //保存角色-模块关系表中的role_id和module_id
            foreach ($moduleId as $value) {
                $data['module_id'] = $value;
                $data['role_id'] = $roleId;
                $result = $roleModuleModel->addRoleIdModuleId($data);
            }
            //返回添加角色-模块关系表中的id的结果
            if ($result) {
                $this->success(L('ADD_ROLERESOURCE_SUCCESS'), U('Agent/listroles'));
            } else {
                $this->error(L('ADD_ROLERESOURCE_FAILURE'), U('Agent/listroles'));
            }
        }
    }

    /**
     * 显有的所有的模块界面
     */
    public function listModules() {
        //实列化Module模型
        $moduleModel = D('Module');
        //获取总的用户数
        $count = $moduleModel->selectModuleTotalSize();
        //赋值到模版
        $modules = $moduleModel->select();
        $modules = child($modules,0,'module_id','fid');
        $modules = tree($modules);
        $this->assign('modules', $modules);
        $this->assign('count', $count);
//        $this->assign('page', $show);
        $this->display("Agent/listmodules");
    }

    /**
     * 添加模块方法
     */
    public function addModule() {
        if (IS_POST) {
            $fid=I('fid');//父亲的id
            //接受POST传递过来的值
            $moduleName = I('modulename');
            $moduleUrl = I('moduleurl');
            //实列化Module模型
            $moduleModel = D('Module');
            //保存模块信息
            $data['module_name'] = $moduleName;
            $data['module_url'] = $moduleUrl;
            $data['fid'] = $fid;
            $result = $moduleModel->addModule($data);
            //返回模块添加结果
            if ($result) {
               //管理员操作记录到日志表中   
               $logcontent = C('SYS_LOG_ACTION_ADD')."模块添加成功。" . "模块名：" . $moduleName;
               sys_log(session('adminId'),session('adminName'),$logcontent);
                $this->success(L('ADD_MODULE_SUCCESS'), U('Agent/listmodules'));
            } else {
               //管理员操作记录到日志表中   
               $logcontent = C('SYS_LOG_ACTION_ADD')."模块添加失败。" . "模块名：" . $moduleName;
               sys_log(session('adminId'),session('adminName'),$logcontent);
               $this->error(L('ADD_MODULE_FAILURE'));
            }
        } else{
            //显示添加模块界面
            $this->display('Agent/addmodule');
        }
    }

    /**
     * 编辑模块方法
     */
    public function editModule() {

        if (IS_POST) {
            //接受POST传递过来的参数
            $moduleId = I('moduleid');
            $moduleName = I('modulename');
            $moduleUrl = I('moduleurl');
            //实列化Module模型
            $moduleModel = D('Module');
            $data['module_name'] = $moduleName;
            $data['module_url'] = $moduleUrl;
            $result = $moduleModel->saveModule($moduleId, $data);

            //返回编辑结果
            if ($result) {
                 //管理员操作记录到日志表中
                $logcontent = C('SYS_LOG_ACTION_MODIFY')."模块编辑成功。" . "模块名：" .$moduleName;
                sys_log(session('adminId'),session('adminName'),$logcontent);

                $this->success(L('EDIT_MODULE_SUCCESS'), U('Agent/listmodules'));
            } else {
                //管理员操作记录到日志表中
                $logcontent = C('SYS_LOG_ACTION_MODIFY')."模块编辑失败。" . "模块名：" .$moduleName;
                sys_log(session('adminId'),session('adminName'),$logcontent);

                $this->error(L('EDIT_MODULE_FAILURE'));
            }
        } else{

            //接受get传递过来的参数
            $moduleId = I('moduleid');

            //实列化Module模型
            $moduleModel = D('Module');

            //查询模块
            $listmodule = $moduleModel->selectModuleById($moduleId);

            //赋值模版
            $this->assign('listmodule', $listmodule);
            $this->display('Agent/editmodule');

        }
    }

    /**
     * 删除模块方法
     */
    public function deleteModule() {
        if (IS_GET){
            //接受GET传递过来的module_id的值
            $moduleId = I('moduleid');

            //实列化Module模型
            $moduleModel = D('Module');
            //实列化模型Role模型
            $roleModuleModel = D('RoleModule');

            //删除角色-模块关系role_module表中module_id为$moduleId的数据
            $roleModuleModel->deleteRoleModuleByModuleId($moduleId);
            //查询模块
            $module= $moduleModel->selectModuleById($moduleId);
            
            //删除模块
            $result = $moduleModel->deleteModuleById($moduleId);

            //返回删除模块结果
            if ($result) {
                //管理员操作记录到日志表中
                  $logcontent = C('SYS_LOG_ACTION_DELETE')."模块删除成功。" . "模块名：" .$module['module_name'];
                  sys_log(session('adminId'),session('adminName'),$logcontent);
                
                $this->success(L('DELTE_MODULE_SUCCESS'), U('Agent/listmodules'));
        } else {
               //管理员操作记录到日志表中
                  $logcontent = C('SYS_LOG_ACTION_DELETE')."模块删除成功。" . "模块名：" .$module['module_name'];
                  sys_log(session('adminId'),session('adminName'),$logcontent);
                $this->error(L('DELTE_MODULE_FAILURE'));
        }
    }
    }
    /**
     * 修改密码界面
     */
    public function editPass() {
        if (IS_GET){
            //接受GET传递过来的参数
            $adminId = I('adminid');
            //实例化Admin模型
            $adminModel = D('admin');
            //查找管理员表中admin_id为$id的一条数据
            $adminPass = $adminModel->selectAdminById($adminId);
            //赋值到模版
            $this->assign("adminpass", $adminPass);
            $this->display('Agent/editpass');
        } elseif (IS_POST){
            //接受POST传递过来的参数
            $adminId = I('adminid');
            //md5加密POST提交的原密码
            $newPass = I('newpassword');
            $adminPass = I('adminpassword');
            //实例化Admin模型
            $adminModel = D('admin');
            //查找管理员表中admin_id为$adminId的一条数据
            $admin = $adminModel->selectAdminById($adminId);
            if ($newPass != $adminPass) {
                $this->error('两次输入密码不一致');
            }
            //新密码md5加密
            $adminpass = admin_md5($adminPass);
            //修改密码
            $result = $adminModel->savePassword($adminId, $adminpass);
            $admin = $adminModel->selectAdminById($adminId);
            //返回修改密码结果
            if ($result) {
                //管理员操作记录到日志表中
                $logcontent = C('SYS_LOG_ACTION_MODIFY')."密码修改成功。" . "用户名：" .$admin['admin_name'];
                sys_log(session('adminId'),session('adminName'),$logcontent);
                $this->success(L('EDIT_PASSWORD_SUCCESS'), U('Agent/listAdmins'));
            } else{
                //管理员操作记录到日志表中
                $logcontent = C('SYS_LOG_ACTION_MODIFY')."密码修改失败。" . "用户名：" .$admin['admin_name'];
                sys_log(session('adminId'),session('adminName'),$logcontent);
                $this->error(L('EDIT_PASSWORD_FAILURE'));
            }
        }
    }
    
     /**
     * 修改密码的方法
     */
    public function editPassword() {
        //实例化Admin模型
        $adminModel = D('Agent');
        if (IS_POST) {
            //接受POST传递过来的参数
            $adminId = I('adminid');
            //md5加密POST提交的原密码
            $oldPass = admin_md5(I('oldpassword'));
            $newPass = I('newpassword');
            $adminPass = I('adminpassword');
            //查找管理员表中admin_id为$adminId的一条数据
            $admin = $adminModel->selectAdminById($adminId);
            if ($admin['admin_pass'] != $oldPass) {
                $this->error('原密码输入不正确');
            }

            if ($newPass != $adminPass) {
                $this->error('两次输入密码不一致');
            }
            //新密码md5加密
            $adminpass = admin_md5($adminPass);
            //修改密码
            $result = $adminModel->savePassword($adminId, $adminpass);

            //返回修改密码结果
            if ($result) {
                //管理员操作记录到日志表中
                $logcontent = C('SYS_LOG_ACTION_MODIFY')."密码修改成功。" . "用户名：" .session('adminName');
                sys_log(session('adminId'),session('adminName'),$logcontent);
                
                $this->success(L('EDIT_PASSWORD_SUCCESS'), U('Agent/listAdmins'));
            } else{
                //管理员操作记录到日志表中
                $logcontent = C('SYS_LOG_ACTION_MODIFY')."密码修改失败。" . "用户名：" .session('adminName');
                sys_log(session('adminId'),session('adminName'),$logcontent);
                
                $this->error(L('EDIT_PASSWORD_FAILURE'));
            }
        } else{
            //显示密码修改界面
            $this->display("Agent/editpassword");
        }
    }
//    父级添加子级模块
    public function addChildModule(){
        $moduleid=I('moduleid');
        $this->assign('fid',$moduleid);
        $this->display('Agent/addmodule');
    }
    /*
     * 设置页面
     */
    public function setup(){
        $this->display('Agent/setup');
    }
    public function upload(){
        $file = $_FILES['file'];
        $image = I('image');
        $type = "jpg|png|jpeg";
        $size = 10;
        $path = "images";
        $info = up($file,$type,$size,$path);
        $adminModel = D('Agent');
        $a['admin_id'] = session('adminId');
        if($image == 'wallpaper'){
            $data['admin_wallpaper'] = $info['savepath'].$info['savename'];
            $adminModel->where($a)->save($data);
            }
        if($image == 'header'){
            $data['admin_header'] = $info['savepath'].$info['savename'];
            $adminModel->where($a)->save($data);
        }
        if($info){
            echo true;
            return true;
        }else{
            echo false;
            return false;
        }
    }
}
