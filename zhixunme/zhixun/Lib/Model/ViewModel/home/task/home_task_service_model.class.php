<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class home_task_service_model{
    /**
     * 当前任务编号
     * @var <int>
     */
    public $id;
    /**
     *
     * @var <type>
     * 分类下置顶个数
     */
    public $top;
     /**
     *
     * @var <type> 下一次置顶时间间隔
     */
    public $top_next_time;
    /**
     *
     * @var <type> 任务分类标题
     */
    public $class_title;
    /**
     *
     * @var <type> 推广服务信息
     */
    public $service_list;
    
}

?>
