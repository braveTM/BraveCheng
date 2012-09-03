<?php
/**
 * Description of NotifyProvider
 *
 * @author moi
 */
class NotifyProvider extends BaseProvider{
    /**
     * 获取通知模版
     * @param  <int> $id 模版编号
     * @return <array> 模版信息
     */
    public function get_notify_tpl($id){
        $this->da->setModelName('notify_tpl');            //使用通知模版表
        $where['id']     = $id;
        $where['is_del'] = 0;
        return $this->da->where($where)->find();
    }

    /**
     * 添加通知模版
     * @param  <string> $title   标题
     * @param  <string> $content 内容
     * @param  <string> $remark  备注
     * @param  <int>    $fixed   是否固定模版
     * @param  <int>    $m       是否发送站内信
     * @param  <int>    $e       是否发送邮件
     * @param  <int>    $s       是否发送短信
     * @return <int> 模版编号
     */
    public function add_notify_tpl($title, $content, $remark, $fixed, $m, $e, $s){
        $this->da->setModelName('notify_tpl');            //使用通知模版表
        $data['title']   = $title;
        $data['content'] = $content;
        $data['remark']  = $remark;
        $data['message'] = $m;
        $data['email']   = $e;
        $data['sms']     = $s;
        $data['fixed']   = $fixed;
        $data['date']    = date_f();
        $data['is_del']  = 0;
        return $this->da->add($data);
    }
}
?>
