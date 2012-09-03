<?php
/**
 * Description of home_task_index_page
 *
 * @author moi
 */
class home_task_index_page {
    /**
     * 任务详细页数据提供
     * @param  <int> $id      任务编号
     * @param  <int> $user_id 用户编号
     * @return <mixed>
     */
    public static function task_detail($id, $user_id){
        $service = new TaskService();
        $data = $service->get_task($id);
        if(empty($data))
            return null;
        $data['_show_text'] = 0;
        $data['_show_contact'] = 0;
        $data['_show_ps'] = 0;
        if($data['user_id'] != $user_id){                       //不是任务发布人
            $bider = $service->check_user_reply_task($id, $user_id);
            if($data['status'] == 1){                           //待选标状态
                $data['_show_text'] = 1;                        //显示竞标框
                if($bider){                                     //竞标者显示发布人联系方式
                    $data['_show_contact'] = 1;
                }
            }
            elseif($data['status'] == 2){                       //已完成状态
                $bided = $service->check_user_bid_task($id, $user_id);
                if($bided)                                      //中标者显示发布人联系方式
                    $data['_show_contact'] = 1;
                else
                    $data['_show_ps'] = 1;                      //未中标者显示PS
            }
            else{                                               //任务结束后显示PS
                $data['_show_ps'] = 1;
            }
        }
        $class = $service->get_class_info($data['info_class_b']);
        $data['_self'] = P();
        $data['info_class_b'] = $class['class_title'];
        $service->task_scan($user_id, P('name'), $id, $data['info_title']);     //任务查看记录
        $service = new UserService();
        $data['_user'] = $service->get_user($data['user_id']);
        return FactoryVMap::array_to_model($data, 'home_task_detail');
    }
}
?>
