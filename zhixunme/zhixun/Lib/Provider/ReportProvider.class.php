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
class ReportProvider extends BaseProvider{
    //put your code here
    public $reportArgRule=array(
        'report_user_id'=>array(
            'name'=>'举报人',
            'filter'=>VAR_ID,
            'null'=>false
        ),
        'reported_id'=>array(
            'name'=>'被举报的id',
            'filter'=>VAR_ID,
            'null'=>false
        ),
        'type'=>array(
            'name'=>'举报类型',
            'filter'=>VAR_ID,
            'null'=>false
        ),
        'newtype'=>array(
            'name'=>'举报信息种类',
            'filter'=>VAR_ID,
            'null'=>false
        ),
        'content'=>array(
            'name'=>'举报信息',
            'length'=>10240,
            'null'=>false
        ),
        'status'=>array(
            'name'=>'状态',
            'filter'=>VAR_ID,
            'null'=>false
        ),
        'date'=>array(
            'name'=>'日期',
            'length'=>10240,
            'null'=>false
        ),
    );
    public function addReport($data){
        $this->da->setModelName('report');
        $data['is_del']=0;
        $data['date']=date_f();
        return $this->da->add($data);
    }
}
?>
