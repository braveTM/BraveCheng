<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

/**
 * Description of CertificateService
 *
 * @author JZG
 */
class CertificateService {
    //----------------private-------------------
    private $provider;

    //----------------public--------------------
    public function  __construct() {
        $this->provider = new CertificateProvider();
    }
    
    /**
     *获取人才的注册证书列表
     * @param <int> $human_id 人才信息ID
     * @return <mixed> 成功返回人才的注册证书数组或空数组，失败返回false
     */
    public function getRegisterCertificateListByHuman($human_id) {
        return $this->provider->getRegisterCertificateListByHuman($human_id,null);
    }

    /**
     * 获取人才的职称证书列表
     * @param <int> $human_id  人才信息ID
     * @return <mixed> 成功返回人才的职称证书数组或空数组，失败返回false
     */
    public function getGradeCertificateListByHuman($human_id){
        return $this->provider->getGradeCertificateListByHuman($human_id,null);
    }

    /**
     * 获取所有注册证书信息
     * @return <mixed> 成功返回所有的注册证书信息数组或空数组，失败返回false
     */
    public function getAllRegisterCertificateInfo(){
        return $this->provider->getAllRegisterCertificateInfo(null);
    }

    /**
     *根据注册证书信息ID获取注册证书级别列表
     * @param <int> $RCI_id 注册证书信息ID
     * @return <mixed> 成功返回级别数组（如{1,2}或{0}）或空数组，失败返回false
     */
    public function getRegisterCertificateClassList($RCI_id){
        return $this->provider->getRegisterCertificateClassList($RCI_id);
    }
    
    /**
     * 根据注册证书信息ID和级别获取注册证书专业列表
     * @param <int> $RCI_id 注册证书信息ID
     * @param <int> $RC_class 级别（0为无级别之分）
     * @return <mixed>返回专业名称和注册证书ID组成的数组（无专业的返回证书编号）
     */
    public function getRegisterCertificateMajorList($RCI_id,$RC_class){
        $result = $this->provider->getRegisterCertificateMajorList($RCI_id, $RC_class);
        if(empty ($result)){
            $result = $this->provider->getRegisterCertificate($RCI_id, 0, $RC_class);
            if(!empty($result))
                return $result['register_certificate_id'];
            else
                return null;
        }
        return $result;
    }

    /**
     * 添加人才的注册证书
     * @param <int> $human_id 人才信息ID
     * @param <int> $RC_id 注册证书ID
     * @param <int> $register_place 注册地（省份编号）
     * @param <int> $register_case 注册情况
     * @return <mixed> 成功返回新增记录ID,失败返回错误信息
     */
    public function addRegisterCertificateToHuman($human_id,$RC_id,$register_place,$register_case){
        $data=array(
            'register_place'=>$register_place,
            'register_case'=>$register_case
        );
        if (!$this->provider->exists_rc_id($RC_id)){
            return E(ErrorMessage::$RC_NOT_EXISTS);
        }
        if ($this->provider->isExistHumanRC($human_id, $RC_id)){
            //证书重复
            return E(ErrorMessage::$CERT_REPEAT);
        }
        $certificate_id=$this->provider->addRegisterCertificateToHuman($human_id, $RC_id, $data);
        if ($certificate_id){
            //添加证书时触发推荐更新
            $recommendService=new RecommendService();
            $recommendService->alterResumeTriggerUpdate(AccountInfo::get_user_id(),AccountInfo::get_role_id());            
            return $certificate_id;
        }else{
            return E(ErrorMessage::$OPERATION_FAILED);
        }
    }

    public function addMutiRegisterCertificateToHuman($human_id,$rids,$pids,$cases){
        $rs = explode(',', $rids);
        $ps = explode(',', $pids);
        $cs = explode(',', $cases);
        if(count($rs) != count($ps) || count($rs) != count($cs)){
            return E(ErrorMessage::$CERTIFICATE_INFO_FORMAT_ERROR);
        }
        $this->provider->trans();
        foreach($rs as $key => $r){
            $result = $this->addRegisterCertificateToHuman($human_id, $r, $ps[$key], $cs[$key]);
            if(is_zerror($result)){
                $this->provider->rollback();
                return $result;
            }
        }
        $this->provider->commit();
        return true;
    }

    /**
     * 获取指定职称证书类型的职称证书列表
     * @param <int> $grade_certificate_type_id 职称证书类型ID
     * @return <mixed> 成功返回职称证书数组或空数组，失败返回false
     */
    public function getGradeCertificateList($grade_certificate_type_id){
        return $this->provider->getGradeCertificateList($grade_certificate_type_id,null);
    }

    /**
     * 获取所有职称证书类型
     * @return <mixed> 成功返回职称证书类型数组或空数组，失败返回false
     */
    public function getAllGradeCertificateType(){
        return $this->provider->getAllGradeCertificateType();
    }
    
    /**
     * 添加人才的职称证书
     * @param <int> $human_id  人才信息ID
     * @param <int> $GC_id 职称证书ID
     * @param <int> $GC_class 职称证书级别
     * @return <mixed> 成功返回true,失败返回false
     */
    public function addGradeCertificateToHuman($human_id,$GC_id,$GC_class){
        if(!$this->provider->addGradeCertificateToHuman($human_id, $GC_id,$GC_class,null))
            return E(ErrorMessage::$OPERATION_FAILED);
        return true;
    }

    /**
     *删除证书
     * @param <int> $human_id 人才ID
     * @param <int> $certificate_id 证书ID
     * @return <mixed> 成功返回true,失败返回false
     */
    public function deleteCertificate($human_id, $certificate_id){
        $cert = $this->provider->get_certificate($certificate_id);
        if(empty($cert))
            return E(ErrorMessage::$CERT_NOT_EXISTS);
        if($cert['human_id'] != $human_id)
            return E(ErrorMessage::$CERT_NO_PERMISSION);
        if(!$this->provider->deleteCertificate($certificate_id))
            return E(ErrorMessage::$OPERATION_FAILED);
        else{
            //删除证书时触发推荐更新
            $recommendService=new RecommendService();
            $recommendService->alterResumeTriggerUpdate(AccountInfo::get_user_id(),AccountInfo::get_role_id());            
            return $certificate_id;
        }
        return true;
    }

    public function get_register_certificate_info($id){
        $data = $this->provider->get_register_certificate($id);
        if(!empty($data)){
            $info = $this->provider->get_register_certificate_info($data['register_certificate_info_id']);
            $data['cert_name'] = $info['name'];
            if($data['register_certificate_major_id'] > 0){
                $major = $this->provider->get_register_certificate_major($data['register_certificate_major_id']);
                $data['major_name'] = $major['name'];
            }
        }
        return $data;
    }
    
    /**
     * 更新人才职称证书信息
     * @param  <int> $human_id       人才编号
     * @param  <int> $certificate_id 证书编号
     * @param  <int> $GC_id          职称证书编号
     * @param  <int> $GC_class       职称等级
     * @return <bool>
     */
    public function updateGradeCertificate($human_id, $certificate_id, $GC_id,$GC_class){
        $cert = $this->provider->get_certificate($certificate_id);
        if(empty($cert))
            return E(ErrorMessage::$CERT_NOT_EXISTS);
        return $certificate_id;
        if($cert['human_id'] != $human_id)
            return E(ErrorMessage::$CERT_NO_PERMISSION);
        $data['grade_certificate_id'] = $GC_id;
        $data['grade_certificate_class'] = $GC_class;
        if(!$this->provider->updateCertificate($certificate_id, $data))
            return E(ErrorMessage::$OPERATION_FAILED);
        return true;
    }

    /**
     * 检测是否存在指定注册证书编号
     * @param  <int> $id 注册证书编号
     * @return <bool> 是否存在
     */
    public function exists_rc_id($id){
        return $this->provider->exists_rc_id($id);
    }

    /**
     * 获取指定编号职称证书信息
     * @param  <int> $id 编号
     * @return <mixed>
     */
    public function get_grade_certificate($id){
        return $this->provider->get_grade_certificate($id);
    }

    /**
     * 证书认证申请
     * @param  <int>    $human_id 人才编号
     * @param  <int>    $cert_id  证书编号
     * @param  <string> $picture  认证图片
     * @return <bool>
     */
    public function certificate_auth($human_id, $cert_id, $picture){
        $cert = $this->provider->get_certificate($cert_id);
        if(empty($cert)){
            return E(ErrorMessage::$CERT_NOT_EXISTS);
        }
        if($cert['human_id'] != $human_id){
            return E(ErrorMessage::$CERT_NO_PERMISSION);
        }
        if(!$this->provider->updateCertificate($cert_id, array('picture' => $picture, 'status' => 2)))
            return E(ErrorMessage::$OPERATION_FAILED);
        return true;
    }

    /**
     * 解除证书认证
     * @param  <int> $human_id 人才编号
     * @param  <int> $cert_id  证书编号
     * @return <bool>
     */
    public function remove_certification($human_id, $cert_id){
        $cert = $this->provider->get_certificate($cert_id);
        if(empty($cert)){
            return E(ErrorMessage::$CERT_NOT_EXISTS);
        }
        if($cert['human_id'] != $human_id){
            return E(ErrorMessage::$CERT_NO_PERMISSION);
        }
        if(!$this->provider->updateCertificate($cert_id, array('status' => 1)))
            return E(ErrorMessage::$OPERATION_FAILED);
        return true;
    }

    //----------------protected--------------
    /**
     * 注册地过滤
     * @param  <int> $place
     * @return <int>
     */
    protected function filter_place($place){
        $provider = new ProvinceProvider();
        if($provider->is_exists_province($place)){
            return $place;
        }
        return 0;
    }

    /**
     * 获取招聘的注册证书要求列表
     * @param <int> $job_id 职位ID
     * @return <mixed> 成功返回招聘的注册证书要求列表或空数组，失败返回false
     */
    public function getRegisterCertificateListByJob($job_id){
        return $this->provider->getRegisterCertificateListByJob($job_id,null);
    }
}
?>
