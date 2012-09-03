<?php

/**
 * 阶段进度关系
 *
 * @author brave
 */
class StatusCrmService {

    private $statusObj;

    public function __construct() {
        $this->statusObj = new StatusCrmProvider();
    }

    /**
     * 获取阶段列表
     * @return array 
     */
    public function getCategory() {
        return $this->statusObj->getCategory();
    }

    /**
     *  获取进度列表
     * @return type 
     */
    public function getProgress() {
        return $this->statusObj->getProgress();
    }

    /**
     * 添加一条人才阶段进度关系记录
     * @param int $cate_id 阶段id
     * @param int $pro_id 进度id
     * @param char $notes 记录
     * @param int $h_e_id 人才企业ID
     * @param boolean $human
     * @return mixed 
     */
    public function addStatusByHuman($cate_id, $pro_id, $notes, $human_id) {
        $relationObj = new RelationCrmProvider();
        $data = array(
            'cate_id' => $cate_id,
            'pro_id' => $pro_id,
            'notes' => $notes,
        );
        //判断人才或者企业id是否存在
        $data['human_id'] = $human_id;
        if (!$relationObj->isExist('human_id', $data['human_id'], 'crm_human'))
            return E(ErrorMessage::$ACCOUNT_NOT_EXISTS);
        //验证数据是否有效
        $data = argumentValidate(StatusCrmProvider::$statusArgRule, $data);
        if (is_zerror($data))
            return $data;
        $status_id = $this->statusObj->addStatus($data);
        return $status_id ? $status_id : E(ErrorMessage::$OPERATION_FAILED);
    }

    /**
     * 添加一条企业阶段进度关系记录
     * @param int $cate_id 阶段id
     * @param int $pro_id 进度id
     * @param char $notes 记录
     * @param int $h_e_id 人才企业ID
     * @param boolean $human
     * @return mixed 
     */
    public function addStatusByEnter($cate_id, $pro_id, $notes, $enter_id) {
        $relationObj = new RelationCrmProvider();
        $data = array(
            'cate_id' => $cate_id,
            'pro_id' => $pro_id,
            'notes' => $notes,
        );
        //判断人才或者企业id是否存在
        $data['enter_id'] = $enter_id;
        if (!$relationObj->isExist('enter_id', $data['enter_id'], 'crm_company'))
            return E(ErrorMessage::$ACCOUNT_NOT_EXISTS);
        //验证数据是否有效
        $data = argumentValidate(StatusCrmProvider::$statusArgRule, $data);
        if (is_zerror($data))
            return $data;
        $status_id = $this->statusObj->addStatus($data);
        return $status_id ? $status_id : E(ErrorMessage::$OPERATION_FAILED);
    }

    /**
     * 更新指定一条人才关系阶段记录
     * @param type $status_id
     * @param type $cate_id
     * @param type $pro_id
     * @param type $notes
     * @param type $h_e_id
     * @param boolean $human
     * @return type 
     */
    public function updateStatusByHuman($status_id, $cate_id, $pro_id, $notes, $human_id) {
        $relationObj = new RelationCrmProvider();
        $data = array(
            'cate_id' => $cate_id,
            'pro_id' => $pro_id,
            'notes' => $notes,
        );
        //判断人才或者企业id是否存在
        $data['human_id'] = $human_id;
        if (!($relationObj->isExist('human_id', $data['human_id'], 'crm_human')) || !($relationObj->isExist('status_id', $status_id, 'crm_status') ))
            return E(ErrorMessage::$ACCOUNT_NOT_EXISTS);

        //验证数据是否有效
        $data = argumentValidate(StatusCrmProvider::$statusArgRule, $data);
        if (is_zerror($data))
            return $data;
        $status_id = $this->statusObj->updateStatus($status_id, $data);
        return $status_id ? TRUE : E(ErrorMessage::$OPERATION_FAILED);
    }

    /**
     * 更新指定一条企业关系阶段记录
     * @param type $status_id 
     * @param type $cate_id
     * @param type $pro_id
     * @param type $notes
     * @param type $h_e_id
     * @param boolean $human
     * @return type 
     */
    public function updateStatusByEnter($status_id, $cate_id, $pro_id, $notes, $enter_id) {
        $relationObj = new RelationCrmProvider();
        $data = array(
            'cate_id' => $cate_id,
            'pro_id' => $pro_id,
            'notes' => $notes,
        );
        //判断人才或者企业id是否存在
        $data['enter_id'] = $enter_id;
        if (!($relationObj->isExist('enter_id', $data['enter_id'], 'crm_company')) || !($relationObj->isExist('status_id', $status_id, 'crm_status') ))
            return E(ErrorMessage::$ACCOUNT_NOT_EXISTS);

        //验证数据是否有效
        $data = argumentValidate(StatusCrmProvider::$statusArgRule, $data);
        if (is_zerror($data))
            return $data;
        $status_id = $this->statusObj->updateStatus($status_id, $data);
        return $status_id ? TRUE : E(ErrorMessage::$OPERATION_FAILED);
    }

    /**
     * 获取指定人才、企业对应的阶段进度信息列表或者最新的一条阶段进度信息
     * @param int $id 人才、企业id
     * @param int $latest 是否获取最新的一条阶段进度信息
     * @param int $is_human 人才或企业判断条件
     * @return array   返回阶段进度列表
     */
    public function getStatusRows($id, $latest, $is_human = TRUE) {
        return $this->statusObj->getStatusById($id, $is_human, $latest);
    }

    /**
     * 获取指定阶段进度id信息
     * @param 阶段进度id $status_id
     * @return array 返货一条阶段进度信息
     */
    public function getStatusById($status_id) {
        return $this->statusObj->getRelationStatus($status_id);
    }

}

?>
