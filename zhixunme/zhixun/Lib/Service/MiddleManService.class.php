<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MiddleManService
 *
 * @author JZG
 */
class MiddleManService {
    //----------------private-------------------
    private $provider;

    //----------------public--------------------
    public function  __construct() {
        $this->provider = new MiddleManProvider();
    }

    /**
     * 添加经纪人信息
     * @param  <string> $name      姓名
     * @param  <string> $phone     手机
     * @param  <string> $qq        QQ
     * @param  <string> $email     邮箱
     * @param  <int>    $pid       省份编号
     * @param  <int>    $cid       城市编号
     * @param  <string> $introduce 简介
     * @param  <string> $company   公司名称
     * @param  <string> $service   服务类别
     * @return <mixed> 成功返回信息编号，失败返回ZERROR
     */
    public function add_agent($name, $phone, $qq, $email, $pid, $cid, $introduce, $company, $service){
        if(!var_validation($name, VAR_NAME)){               //姓名格式错误
            return E(ErrorMessage::$NAME_FORMAT_ERROR);
        }
        if(!var_validation($phone, VAR_PHONE)){             //手机格式错误
            return E(ErrorMessage::$PHONE_FORMAT_ERROR);
        }
        if(!var_validation($email, VAR_EMAIL)){             //联系人邮箱格式错误
            return E(ErrorMessage::$EMAIL_FORMAT_ERROR);
        }
        filter_location($pid, $cid);
        $data['name']               = var_validation($name, VAR_NAME, OPERATE_FILTER);
        $data['addr_province_code'] = $pid;
        $data['addr_city_code']     = $cid;
        $data['contact_qq']         = var_validation($qq, VAR_QQ, OPERATE_FILTER, true);
        $data['contact_mobile']     = $phone;
        $data['contact_email']      = $email;
        $data['introduce']          = var_validation($introduce, VAR_INTRODUCE, OPERATE_FILTER, true);
        $data['company_name']       = var_validation($company, VAR_ENAME, OPERATE_FILTER);
        $data['service_category']   = '';
        $data['is_del']             = 0;
        while(true){                                        //生成唯一主键
            $id = build_id();
            $temp = $this->provider->getMiddleMan($id);
            if(empty($temp))
                break;
        }
        $data['agent_id'] = $id;
        $result = $this->provider->addMiddleMan($data);
        if(!$result)
            return E(ErrorMessage::$OPERATION_FAILED);
//        $update = $this->update_agent_service($result, $service);
//        if(is_zerror($update))
//            return $update;
        return $result;
    }

    /**
     * 获取指定经纪人信息
     * @param  <int> $id 编号
     * @return <array>
     */
    public function get_agent($id){
        return $this->provider->getMiddleMan($id);
    }

    /**
     * 更新经纪人基本信息
     * @param  <int>    $user_id   用户编号
     * @param  <int>    $id        资料编号
     * @param  <string> $name      姓名
     * @param  <string> $qq        QQ
     * @param  <int>    $pid       省份编号
     * @param  <int>    $cid       城市编号
     * @param  <string> $introduce 简介
     * @param  <string> $photo     头像
     * @param  <string> $company   所属公司
     * @param  <int>    $gender    性别
     * @param  <string> $email     邮箱
     * @param  <string> $phone     手机
     * @return <bool>
     */
    public function update_agent($user_id, $id, $name, $qq, $pid, $cid, $introduce, $photo, $company, $gender, $email, $phone){
        if(!var_validation($name, VAR_NAME)){
            return E(ErrorMessage::$NAME_FORMAT_ERROR);
        }
        filter_location($pid, $cid);
        $data['name']               = $name;
        $data['introduce']          = var_validation($introduce, VAR_INTRODUCE, OPERATE_FILTER);
        $data['contact_qq']         = var_validation($qq, VAR_QQ, OPERATE_FILTER);
        $data['company_name']       = var_validation($company, VAR_ENAME, OPERATE_FILTER);
        $data['addr_province_code'] = $pid;
        $data['addr_city_code']     = $cid;
        $data['gender']             = var_validation($gender, VAR_GENDER, OPERATE_FILTER);
        $provider = new UserProvider();
        $uinfo = $provider->get_user_info($user_id);
        if(!empty($uinfo)){
            if($uinfo['is_phone_auth'] == 0 && var_validation($phone, VAR_PHONE)){
                $data['contact_mobile'] = $phone;
            }
            if($uinfo['is_email_auth'] == 0 && var_validation($email, VAR_EMAIL)){
                $data['contact_email'] = $email;
            }
        }
        $this->provider->trans();
        if(!$this->provider->updateMiddleMan($id, $data)){
            $this->provider->rollback();                       //回滚事务
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        $service = new UserService();
        $update = $service->update_user_name($user_id, $name);
        if(is_zerror($update)){
            $this->provider->rollback();                       //回滚事务
            return $update;
        }
        if(!empty($photo)){
            $provider->set_user_photo($user_id, $photo);
        }
        $this->provider->commit();
        $service = new ContactsService();
        $service->moving_update_profile($user_id);
        return true;
    }

    /**
     * 更新经纪人服务类别
     * @param  <int>    $id      经纪人资料编号
     * @param  <string> $service 服务类别编号(多个用,隔开)
     * @return <bool>
     */
    public function update_agent_service($id, $service){
        $array = explode(',', $service);
        //删除经纪人原来拥有的服务
        if(!$this->provider->delete_agent_services($id)){
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        foreach($array as $key => $value) {
            $value = intval($value);
            //添加经纪人服务
            if(!$this->provider->add_agent_service($id, $value)){
                return E(ErrorMessage::$OPERATION_FAILED);
            }
        }
        return true;
    }

    /**
     * 获取经纪人列表
     * @param  <int>  $type     类型（1为个人，2为公司）
     * @param  <int>  $service  服务类别
     * @param  <int>  $province 省份编号
     * @param  <int>  $city     城市编号
     * @param  <int>  $page     第几页
     * @param  <int>  $size     每页几条
     * @param  <bool> $count    是否统计总条数
     * @return <mixed>
     */
    public function get_agent_list($type, $service, $province, $city, $page, $size, $count = false){
        $page = var_validation($page, VAR_PAGE, OPERATE_FILTER);
        $size = var_validation($size, VAR_SIZE, OPERATE_FILTER);
        return $this->provider->get_agent_list($type, $service, $province, $city, $page, $size, $count);
    }

    /**
     * 获取经纪人的服务列表
     * @param  <int> $agent_id 经纪人资料编号
     * @return <mixed>
     */
    public function get_agent_services($agent_id){
        return $this->provider->get_agent_services($agent_id);
    }

    /**
     * 获取经纪人服务类别列表
     * @return <mixed>
     */
    public function get_service_category(){
        return $this->provider->get_service_category();
    }

    /**
     * 获取经纪人详细信息列表
     * @param <int> $service_category_id 服务类别ID
     * @param <int> $type 经纪人类别（1为个人，2为公司成员）
     * @param <int> $addr_province_code 所在地省份编号
     * @param <int> $addr_city_code 所在地城市编号
     * @param <int> $page 第几页
     * @param <int> $size 每页条数
     * @param <bool> $count 为true时返回总条数
     * @return <mixed>
     */
    public function getDetailAgentList($service_category_id,$type,$addr_province_code,$addr_city_code,$page,$size,$count){
        $field=array(
          'agent.agent_id','agent.addr_city_code','agent.addr_province_code','agent.introduce','agent.company_name','agent.name',
         'user.user_id','user.photo','user.is_email_auth','user.is_phone_auth','user.is_real_auth'
        );
       $middleManProvider=new MiddleManProvider();
       if (empty($service_category_id)){
           return $middleManProvider->getDetailAgentList($field,  intval($type,0), $addr_province_code, $addr_city_code, $page, $size, $count,null);
       }else{
           return $middleManProvider->getDetailAgentListByS($field, $service_category_id, $type, $addr_province_code, $addr_city_code, $page, $size, $count, null);
       }
    }

    /**
     * 查询最近服务的企业列表
     * @param <int> $agent_id 代理人ID
     * @param <datetime> $end_time 时间阈
     * @param <int> $page 第几页
     * @param <int> $size 每页几条
     * @param <bool> $count 为true时返回分页条数
     * @return <mixed>
     */
    public function getServiceCompanyList($agent_id,$end_time,$page,$size,$count){
        $companyProvider=new CompanyProvider();
        return $companyProvider->getServiceCompanyList($agent_id, $end_time, $page, $size,$count, null);
    }

}
?>
