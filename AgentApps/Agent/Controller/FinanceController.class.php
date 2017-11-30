<?php
/**
 * Created by PhpStorm.
 * User: occur
 * Date: 2017/7/9
 * Time: 18:49
 */
namespace Agent\Controller;

use Think\Controller;

class FinanceController extends SuperController {
    /*
     * 员工做单登记
     */
    public function index(){
        //实例话模型
        $Employee = D('EmployeeRegistration');
        //查询条件
        $a['ag_id'] = session('SellerId');
        //统计数据
        $count  = $Employee->where($a)->count();
        //实例化分页类
        $page = new \Org\Page\Page($count, 100);
        //分页数据
        $usergroups=$Employee->where($a)->limit($page->firstRow . ',' . $page->listRows)->order('en_time desc')->select();
        $show = $page->show();
        $this->assign('usergroups', $usergroups);
        $this->assign('value', '员工做单登记');
        $this->assign('va', '设备号');
        $this->assign('count', $count);//显示总条数
        $this->assign('page', $show);//显示分页
        $this->display('Finance/EmployeeRegistration');//将值显示在静态页面上
    }
    /*
    * 物流登记
    */
    public function logistics(){
        //实例话模型
        $Employee = D('logistics');
        //查询条件
        $a['ag_id'] = session('AgentId');
        //统计数据
        $count  = $Employee->where($a)->count();
        
        //实例化分页类
        $page = new \Org\Page\Page($count, 100);
        //分页数据
        $usergroups=$Employee->where($a)->limit($page->firstRow . ',' . $page->listRows)->order('en_time desc')->select();
        $show = $page->show();
        $this->assign('value', '物流登记');
        $this->assign('va', '购买量');
        $this->assign('usergroups', $usergroups);
        $this->assign('count', $count);//显示总条数
        $this->assign('page', $show);//显示分页
        $this->display('Finance/EmployeeRegistration');//将值显示在静态页面上
    }
    /*
   * 流量登记
   */
    public function flow(){
        //实例话模型
        $Employee = D('flow');
        //查询条件
        $a['ag_id'] = session('SellerId');
        //统计数据
        $count  = $Employee->where($a)->count();

        //实例化分页类
        $page = new \Org\Page\Page($count, 100);
        //分页数据
        $usergroups=$Employee->where($a)->limit($page->firstRow . ',' . $page->listRows)->order('en_time desc')->select();
        $show = $page->show();
        $this->assign('value', '流量登记');
        $this->assign('va', '购买量');
        $this->assign('usergroups', $usergroups);
        $this->assign('count', $count);//显示总条数
        $this->assign('page', $show);//显示分页
        $this->display('Finance/EmployeeRegistration');//将值显示在静态页面上
    }
    /*
   * 单量登记
   */
    public function volume(){
        //实例话模型
        $Employee = D('volume');
        //查询条件
        $a['ag_id'] = session('SellerId');
        //统计数据
        $count  = $Employee->where($a)->count();
        //实例化分页类
        $page = new \Org\Page\Page($count, 100);
        //分页数据
        $usergroups=$Employee->where($a)->limit($page->firstRow . ',' . $page->listRows)->order('en_time desc')->select();
        $show = $page->show();
        $this->assign('value', '流量登记');
        $this->assign('usergroups', $usergroups);
        $this->assign('count', $count);//显示总条数
        $this->assign('page', $show);//显示分页
        $this->display('Finance/volume');//将值显示在静态页面上
    }
}