<?php

/**
 * 企业资质情况处理模型
 *
 * @author Brave
 */
class NatureCrmProvider extends BaseProvider {

    //资质情况验证规则
    public static $natureArgRule = array(
        'nid' => array(
            'name' => '资质情况ID',
            'filter' => VAR_ID,
            'null' => false
        ),
        'nature_name' => array(
            'name' => '资质名称',
            'length' => 64,
            'null' => false
        ),
    );

    /**
     * 获取指定记录的资质情况信息
     * @param type $nid 资质情况id
     * @return type 
     */
    public function getNatureById($nid) {
        $this->da->setModelName('crm_nature');
        $where = array(
            'nid' => $nid,
            'is_delete' => 0
        );
        return $this->da->where($where)->find();
    }

    /**
     * 添加一条资质情况
     * @param array $data
     * @return type 
     */
    public function addNature($data) {
        $this->da->setModelName('crm_nature');
        $data['is_delete'] = 0;
        return $this->da->add($data);
    }

    /**
     * 更新企业资质信息
     * @param type $nid
     * @param array $data
     * @return type 
     */
    public function updateNature($nid, $data) {
        $this->da->setModelName('crm_nature');
        return $this->da->where('nid =' . $nid)->save($data);
    }

    /**
     * 获取所有资质情况列表
     * @return type 
     */
    public function getNature() {
        $this->da->setModelName('crm_nature');
        $where = array(
            'is_delete' => 0,
        );
        return $this->da->where($where)->select();
    }

}
?>
