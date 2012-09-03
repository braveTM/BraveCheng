<?php

/**
 * Description of CompanyService
 *
 * @author JZG
 */
class CompanyService {

    //----------------private-------------------
    private $provider;

    //----------------public--------------------
    public function __construct() {
        $this->provider = new CompanyProvider();
    }

    /**
     * 添加企业信息
     * @param <string> $name      企业名称
     * @param <int>    $category  企业性质
     * @param <string> $c_name    联系人
     * @param <string> $c_phone   联系人手机
     * @param <string> $c_qq      联系人QQ
     * @param <string> $c_email   联系人邮箱
     * @param <int>    $pid       省份编号
     * @param <int>    $cid       城市编号
     * @param <string> $introduce 简介
     * @param <string> $company_phone 公司电话
     * @return <mixed> 成功返回记录编号，失败返回ZERROR
     */
    public function add_company($name, $category, $c_name, $c_phone, $c_qq, $c_email, $pid, $cid, $introduce, $company_phone) {
        if (!var_validation($name, VAR_ENAME)) {              //企业名称格式错误
            return E(ErrorMessage::$ENAME_FORMAT_ERROR);
        }
        if (!var_validation($company_phone, VAR_FIXED_PHONE)) {
            return E(ErrorMessage::$FIXED_PHONE_FORMAT_ERROR); //企业固定电话格式错误
        }
        if (!var_validation($c_name, VAR_NAME)) {             //联系人姓名格式错误
            return E(ErrorMessage::$NAME_FORMAT_ERROR);
        }
        if (!var_validation($c_email, VAR_EMAIL)) {           //联系人邮箱格式错误
            return E(ErrorMessage::$EMAIL_FORMAT_ERROR);
        }
        filter_location($pid, $cid);
        $data['company_name'] = var_validation($name, VAR_ENAME, OPERATE_FILTER);
        $data['company_category'] = $this->filter_category($category);
        $data['contact_name'] = var_validation($c_name, VAR_NAME, OPERATE_FILTER);
        $data['contact_qq'] = var_validation($c_qq, VAR_QQ, OPERATE_FILTER, true);
        $data['contact_mobile'] = var_validation($c_phone, VAR_PHONE, OPERATE_FILTER);
        $data['contact_email'] = $c_email;
        $data['company_province_code'] = $pid;
        $data['company_city_code'] = $cid;
        $data['introduce'] = var_validation($introduce, VAR_INTRODUCE, OPERATE_FILTER, true);
        $data['company_industry'] = '';
        $data['company_scale'] = '';
        $data['is_del'] = 0;
        $data['company_phone'] = $company_phone;
        while (true) {                                        //生成唯一主键
            $id = build_id();
            $temp = $this->provider->getCompany($id);
            if (empty($temp))
                break;
        }
        $data['company_id'] = $id;
        $result = $this->provider->addCompany($data);
        if (!$result)
            return E(ErrorMessage::$OPERATION_FAILED);
        return $result;
    }

    /**
     * 获取指定企业信息
     * @param  <int> $id 编号
     * @return <array>
     */
    public function get_company($id) {
        return $this->provider->getCompany($id);
    }

    /**
     * 更新企业基本信息
     * @param  <int>    $user_id   用户编号
     * @param  <int>    $id        资料编号
     * @param  <string> $name      联系人姓名
     * @param  <string> $qq        联系人QQ
     * @param <int>     $category  公司性质
     * @param  <int>    $pid       省份编号
     * @param  <int>    $cid       城市编号
     * @param  <string> $introduce 简介
     * @param  <string> $photo     头像
     * @param  <string> $company_qualification 企业资质
     * @param  <date>   $company_regtime 企业成立时间
     * @param  <int>    $company_scale   企业规模
     * @param  <string> $email     头像
     * @param  <string> $phone     头像
     * @return <bool>
     */
    public function update_company($user_id, $id, $name, $qq, $category, $pid, $cid, $introduce, $photo, $company_phone, $company_qualification, $company_regtime, $company_scale, $email, $phone) {
        if (!var_validation($name, VAR_NAME)) {
            return E(ErrorMessage::$NAME_FORMAT_ERROR);
        }
        if (!var_validation($company_phone, VAR_FIXED_PHONE)) {
            return E(ErrorMessage::$FIXED_PHONE_FORMAT_ERROR);
        }
        if (!var_validation($company_regtime, VAR_DATE)) {
            $company_regtime = '1970-01-01';
            //return E(ErrorMessage::$PARAMETER_FORMAT_ERROR);
        }
        filter_location($pid, $cid);
        $data['contact_name'] = $name;
        $data['company_category'] = $this->filter_category($category);
        $data['introduce'] = var_validation($introduce, VAR_INTRODUCE, OPERATE_FILTER);
        $data['contact_qq'] = var_validation($qq, VAR_QQ, OPERATE_FILTER);
        $data['company_province_code'] = $pid;
        $data['company_city_code'] = $cid;
        $data['company_phone'] = $company_phone;
        $data['company_qualification'] = filter_string($company_qualification, 128);
        $data['company_regtime'] = $company_regtime;
        $data['company_scale'] = filter_company_scale($company_scale);
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
        if (!$this->provider->updateCompany($id, $data)) {
            $this->provider->rollback();
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        $service = new UserService();
        $update = $service->update_user_name($user_id, $name);
        if (is_zerror($update)) {
            $this->provider->rollback();                       //回滚事务
            return $update;
        }
        if (!empty($photo)) {
            $provider->set_user_photo($user_id, $photo);
        }
        $this->provider->commit();
        $service = new ContactsService();
        $service->moving_update_profile($user_id);
        return true;
    }

    //------------------protected--------------------
    /*
     * 公司性质过滤
     */
    protected function filter_category($category) {
        switch ($category) {
            case 1 :
            case 2 :
            case 3 :
            case 4 :
            case 5 :
            case 6 :
            case 7 :
            case 8 :
            case 9 : break;
            default : $category = 1;
                break;
        }
        return $category;
    }

}

?>
