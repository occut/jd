<?php

/**
 * Functions: .
 * Author: Zhu Jinhao
 * Link: http://www.hfyefan.com
 * Copyright: HfYefan NetWork Co.,Ltd.
 */

namespace Seller\Model;

use Think\Model;

class SellerTaskModel extends Model {

    /**
     * 增加文章信息
     */
    public function addTasks($tasks) {
        $result = M('seller_task')->add($tasks);
        return $result;
    }

    /**
     *  删除文章表tasks中tasks_id为$tasksid的一条数据
     */
    public function deleteTasksById($tasksId) {
        $result = M('seller_task')->delete($tasksId);
        return $result;
    }

//    /**
//     * 删除文章表tasks中group_id为$groupId的一条数据
//     */
//    public function deleteTasksByGroupId($groupId) {
//        $result = M('tasks')->where('group_id=' . $groupId)->delete();
//        return $result;
//    }

    /**
     *  编辑文章表tasks中tasks_id为$tasksId的一条数据
     */
    public function saveTask($tasksId, $tasks) {
        $result = M('seller_task')->where('task_id=' . $tasksId)->save($tasks);
        return $result;
    }

    /**
     * 查找文章表中的所有文章
     */
    public function selectAllTasks() {
        $result = M('seller_task')->select();
        return $result;
    }

    /**
     *  查找文章表tasks中tasks_id为$tasksId的一条数据
     */
    public function selectTasksById($tasksId) {
        $result = M('seller_task')->find($tasksId);
        return $result;
    }

    /**
     *  查找文章表tasks中group_id为$groupId的所有数据
     */
    public function selectTasksByGroupId($groupId) {
        $result = M('seller_task')->where('group_id=' . $groupId)->select();
        return $result;
    }

     /**
     * 获取文章表中的总条数
     */  /**
     * 获取文章表中的总条数
     */
    public function selectTasksTotalSize($data) {

        $result = M('seller_task')->where($data)->count();
        return $result;
    }

    /**
     * 分页数据集
     */
    public function selectTasksByPage($Page,$data) {
            $result = M('seller_task')->join('LEFT JOIN yefan_shop ON  yefan_seller_task.shop = yefan_shop.id')->where($data)->order('addTaskTime asc')->limit($Page->firstRow . ',' . $Page->listRows)->select();
            return $result;
    }

}
