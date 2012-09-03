<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of BlogProvider
 *
 * @author jackWgz
 */
class FeedbackProvider extends BaseProvider{
    //put your code here
    	public $feadbackArgRule=array(
        'user_id'=>array(
            'name'=>'反馈意见的用户',
        ),
        'user_name'=>array(
            'name'=>'反馈人',
        ),
        'phone'=>array(
            'name'=>'反馈电话',
        ),
        'email'=>array(
            'name'=>'反馈人邮箱',
        ),
        'content'=>array(
            'name'=>'content',
            'length'=>10240,
            'null'=>false
        ),
        'type'=>array(
            'name'=>'反馈分类',
            'filter'=>VAR_ID,
            'null'=>false
        ),
    );
    public function addfeedback($data){
        $this->da->setModelName('feedback');
        $data['is_del']=0;
        $data['is_del']=0;
        $data['start_date']=date_f();
        return $this->da->add($data);
    }
}
?>
