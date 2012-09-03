<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CertificateProvider
 *
 * @author JZG
 */
class CertificateProvider extends BaseProvider{

    /**
     * 获取所有注册证书信息
     * @param <string> $order 排序
     * @return <mixed> 成功返回注册证书信息数组或空数组，失败返回false
     */
    public function getAllRegisterCertificateInfo($order){
        $this->da->setModelName('register_certificate_info');
        $where['is_del']    = 0;
        return $this->da->where($where)->order($order)->select();
    }

    /**
     *根据注册证书信息ID获取注册证书级别列表
     * @param <int> $RCI_id 注册证书信息ID
     * @return <mixed> 成功返回级别数组（如{1,2}或{0}）或空数组，失败返回false
     */
    public function getRegisterCertificateClassList($RCI_id){
        $this->da->setModelName('register_certificate');
        $where['register_certificate_info_id']=$RCI_id;
        $where['is_del']    = 0;
        return $this->da->where($where)->field('class')->group('class')->select();
    }

    /**
     * 根据注册证书信息ID和级别获取注册证书专业列表
     * @param <int> $RCI_id 注册证书信息ID
     * @param <int> $RC_class 级别（0为无级别之分）
     * @return <mixed>成功返回专业名称和注册证书ID组成的数组或空数组，失败返回false
     */
    public function getRegisterCertificateMajorList($RCI_id,$RC_class){
        //$table[C('DB_PREFIX').'register_certificate']='t1';
//        $table=array(
//            C('DB_PREFIX').'register_certificate'=>'t1'
//        );
        $table= C('DB_PREFIX').'register_certificate'.' t1';
        $join=array(C('DB_PREFIX').'register_certificate_major t2 on t1.register_certificate_major_id=t2.register_certificate_major_id');
        $where['t1.register_certificate_info_id']=$RCI_id;
        $where['t1.class']=$RC_class;
        $where['t1.is_del']=0;
        $where['t2.is_del']=0;
        return $this->da->table($table)->join($join)->where($where)->field('t1.register_certificate_id,t2.name')->select();
    }

    /**
     * 获取指定注册证书信息
     * @param  <int> $RCI_id
     * @param  <int> $RCM_id
     * @param  <int> $RC_class
     * @return <array>
     */
    public function getRegisterCertificate($RCI_id, $RCM_id, $RC_class){
        $this->da->setModelName('register_certificate');
        $where['register_certificate_info_id'] = $RCI_id;
        $where['register_certificate_major_id'] = $RCM_id;
        $where['class']  = $RC_class;
        $where['is_del'] = 0;
        return $this->da->where($where)->find();
    }

    /**
     *添加人才的注册证书
     * @param <int> $human_id 人才信息ID
     * @param <int> $RC_id 注册证书ID
     * @param <array> $data 证书信息
     * @return <mixed> 成功返回新增记录ID,失败返回false
     */
    public function addRegisterCertificateToHuman($human_id,$RC_id,$data){
        $this->da->setModelName('certificate');
        $data['human_id']=$human_id;
        $data['register_certificate_id']=$RC_id;
        $data['type']=C('REGISTER_CERTIFICATE');
        $data['status'] = 1;
        $data['is_del'] = 0;
        return $this->da->add($data);
    }

    /**
     *添加招聘需要的注册证书
     * @param <int> $job_id 职位ID
     * @param <int> $RC_id  注册证书ID
     * @param <array> $data 证书信息
     * @return <mixed> 成功返回true,失败返回false
     */
    public function addRegisterCertificateToJob($job_id,$RC_id,$data){
        $this->da->setModelName('job_certificate');
        $data['job_id']=$job_id;
        $data['certificate_id']=$RC_id;
        return $this->da->add($data)!==false;
    }

    /**
     * 获取所有职称证书
     * @param <int> $grade_certificate_type_id 职称证书类型ID
     * @param <string> $order 排序
     * @return <mixed> 成功返回职称证书数组或空数组，失败返回false
     */
    public function getGradeCertificateList($grade_certificate_type_id,$order){
        $this->da->setModelName('grade_certificate');
        $where['grade_certificate_type_id']=$grade_certificate_type_id;
        $where['is_del']    = 0;
        return $this->da->where($where)->order($order)->select();
    }

    /**
     * 获取所有职称证书类型
     * @return <mixed> 成功返回职称证书类型数组或空数组，失败返回false
     */
    public function getAllGradeCertificateType(){
        $this->da->setModelName('grade_certificate_type');
        $where['is_del']    = 0;
        return $this->da->where($where)->order('grade_certificate_type_id')->select();
    }

    /**
     * 添加人才的职称证书
     * @param <int> $human_id  人才信息ID
     * @param <int> $GC_id 职称证书ID
     * @param <int> $GC_class 职称证书级别
     * @param <array> $data 证书信息
     * @return <mixed> 成功返回true,失败返回false
     */
    public function addGradeCertificateToHuman($human_id,$GC_id,$GC_class,$data){
        $this->da->setModelName('certificate');
        if (empty($data)){
            $data=array();
        }
        $data['human_id']=$human_id;
        $data['grade_certificate_id']=$GC_id;
        $data['grade_certificate_class']=$GC_class;
        $data['type']=C('GRADE_CERTIFICATE');
        $data['status']=1;
        $data['is_del']=0;
        return $this->da->add($data)!==false;
    }

    /**
     *删除证书
     * @param <id> $certificate_id 证书ID
     * @return <mixed> 成功返回true,失败返回false
     */
    public function deleteCertificate($certificate_id){
        $this->da->setModelName('certificate');
        $data['is_del']=1;
        $where['certificate_id']=$certificate_id;
        return $this->da->where($where)->save($data) !== false;
    }

    /**
     *获取人才的注册证书列表
     * @param <int> $human_id 人才信息ID
     * @param <string> $order 排序
     * @return <mixed> 成功返回人才的注册证书数组(register_place,register_case,class,register_certificate_name,register_certificate_major)或空数组，失败返回false
     */
    public function getRegisterCertificateListByHuman($human_id,$order){
        $table=C('DB_PREFIX').'certificate'.' t1';
        $join[0]=C('DB_PREFIX').'register_certificate t2 on t1.register_certificate_id=t2.register_certificate_id';
        $join[1]=C('DB_PREFIX').'register_certificate_info t3 on t2.register_certificate_info_id=t3.register_certificate_info_id';
        $join[2]=C('DB_PREFIX').'register_certificate_major t4 on t2.register_certificate_major_id=t4.register_certificate_major_id';
        $where['t1.human_id']=$human_id;
        $where['t1.type']=C('REGISTER_CERTIFICATE');
        $where['t1.is_del']=0;
//        $where['t2.is_del']=0;
//        $where['t3.is_del']=0;
//        $where['t4.is_del']=0;
        $field='t2.register_certificate_id,t1.certificate_id,t1.register_place,t1.register_case,t2.register_certificate_info_id,t2.register_certificate_major_id,t1.status,t2.class,t3.name as register_certificate_name,t4.name as register_certificate_major';
        return $this->da->table($table)->join($join)->where($where)->field($field)->order($order)->select();
    }

    /**
     * 获取人才的职称证书列表
     * @param <int> $human_id 人才信息ID
     * @param <string> $order 排序
     * @return <mixed> 成功返回人才的职称证书数组或空数组，失败返回false
     */
    public function getGradeCertificateListByHuman($human_id,$order){
        $table=C('DB_PREFIX').'certificate'.' t1';
        $join[0]=C('DB_PREFIX').'grade_certificate t2 on t1.grade_certificate_id=t2.grade_certificate_id';
        $join[1]=C('DB_PREFIX').'grade_certificate_type t3 on t2.grade_certificate_type_id=t3.grade_certificate_type_id';
        $where['t1.human_id']=$human_id;
        $where['t1.type']=C('GRADE_CERTIFICATE');
//        $where['t1.is_del']=0;
//        $where['t2.is_del']=0;
//        $where['t3.is_del']=0;
        $field='t1.certificate_id,t1.grade_certificate_id,t1.status,t2.major as grade_certificate_major,t3.grade_certificate_type,t1.grade_certificate_class';
        return $this->da->table($table)->join($join)->where($where)->field($field)->order($order)->select();
    }

    /**
     *获取职位的注册证书列表
     * @param <int> $job_id 职位ID
     * @param <string> $order 排序
     * @return <mixed> 成功返回职位的证书数组或空数组，失败返回false
     */
    public function getRegisterCertificateListByJob($job_id,$order){
        $table=C('DB_PREFIX').'job_certificate t1';
        $join[0]=C('DB_PREFIX').'register_certificate t2 on t1.certificate_id=t2.register_certificate_id';
        $join[1]=C('DB_PREFIX').'register_certificate_info t3 on t2.register_certificate_info_id=t3.register_certificate_info_id';
        $join[2]=C('DB_PREFIX').'register_certificate_major t4 on t2.register_certificate_major_id=t4.register_certificate_major_id';
        $where['t1.job_id']=$job_id;
        $where['t1.is_del']=0;
        $field='t1.id,t1.status,t1.count,t1.certificate_id,t2.register_certificate_info_id,t2.register_certificate_major_id,t2.class,t3.name as register_certificate_name,t4.name as register_certificate_major';
        return $this->da->table($table)->join($join)->where($where)->field($field)->order($order)->select();
   }


    /**
     * 是否存在指定编号的职称证书专业
     * @param  <int> $id 编号
     * @return <bool> 是否存在
     */
    public function exists_gc_id($id){
        $this->da->setModelName('grade_certificate');     //使用职称证书专业表
        $where['grade_certificate_id'] = $id;
        $where['is_del'] = 0;
        return $this->da->where($where)->count('grade_certificate_id') > 0;
    }

    /**
     * 是否存在指定编号的职称证书类型
     * @param  <int> $id 编号
     * @return <bool> 是否存在
     */
    public function exists_gct_id($id){
        $this->da->setModelName('grade_certificate_type');      //使用职称证书类型表
        $where['grade_certificate_type_id'] = $id;
        $where['is_del'] = 0;
        return $this->da->where($where)->count('grade_certificate_type_id') > 0;
    }

    /**
     * 检测是否存在指定注册证书编号
     * @param  <int> $id 注册证书编号
     * @return <bool> 是否存在
     */
    public function exists_rc_id($id){
        $this->da->setModelName('register_certificate');           //使用注册证书表
        $where['register_certificate_id'] = $id;
        $where['is_del'] = 0;
        return $this->da->where($where)->count('register_certificate_id') > 0;
    }

    /**
     * 更新资质证书
     * @param <int> $certificate_id 资质证书ID
     * @param <array> $data 数据
     * @return <bool> 成功返回true,失败返回false
     */
    public function updateCertificate($certificate_id,$data){
        $this->da->setModelName('certificate');
        $where['certificate_id']      = $certificate_id;
        return $this->da->where($where)->save($data) !== false;
    }

    /**
     * 获取指定编号职称证书信息
     * @param  <int> $id 编号
     * @return <mixed>
     */
    public function get_grade_certificate($id){
        $this->da->setModelName('grade_certificate t1');
        $where['t1.grade_certificate_id'] = $id;
        $where['t1.is_del'] = 0;
        $join = C('DB_PREFIX').'grade_certificate_type t2 ON t1.grade_certificate_type_id = t2.grade_certificate_type_id';
        $field = 't1.grade_certificate_id,t2.grade_certificate_type,t1.major';
        return $this->da->join($join)->where($where)->field($field)->find();
    }

    /**
     * 获取资质证书信息
     * @param  <int> $id 证书编号
     * @return <mixed>
     */
    public function get_certificate($id){
        $this->da->setModelName('certificate');
        $where['certificate_id'] = $id;
        $where['is_del'] = 0;
        return $this->da->where($where)->find();
    }

    /**
     * 获取资质证书
     * @param  <int> $id 编号
     * @return <mixed>
     */
    public function get_register_certificate($id){
        $this->da->setModelName('register_certificate');
        $where['register_certificate_id'] = $id;
        $where['is_del'] = 0;
        return $this->da->where($where)->find();
    }

    /**
     * 获取资质证书信息
     * @param  <int> $id 证书编号
     * @return <mixed>
     */
    public function get_register_certificate_info($id){
        $this->da->setModelName('register_certificate_info');
        $where['register_certificate_info_id'] = $id;
        $where['is_del'] = 0;
        return $this->da->where($where)->find();
    }

    /**
     * 获取资质证书专业信息
     * @param  <int> $id 专业编号
     * @return <mixed>
     */
    public function get_register_certificate_major($id){
        $this->da->setModelName('register_certificate_major');
        $where['register_certificate_major_id'] = $id;
        $where['is_del'] = 0;
        return $this->da->where($where)->find();
    }

    /**
     * 判断人才是否已经添加过该注册证书
     * @param <int> $human_id 人才ID
     * @param <int> $RC_id 注册证书ID
     * @return <bool>
     */
    public function isExistHumanRC($human_id,$RC_id){
        $this->da->setModelName('certificate');
        $where['human_id']=$human_id;
        $where['register_certificate_id']=$RC_id;
        $where['is_del']=0;
        return $this->da->where($where)->count('certificate_id') > 0;
    }
}
?>
