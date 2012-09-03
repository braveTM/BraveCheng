<?php
/**
 * Description of ProfileDomain
 *
 * @author moi
 */
class ProfileDomain{
    //----------------private-------------------
    private $provider;

    //----------------public--------------------
    public function  __construct() {
        $this->provider = new ProfileProvider();
    }

    /**
     * 魔术方法
     * @param <type> $name
     * @param <type> $arguments
     * @return <type>
     */
    public function  __call($name, $arguments) {
        if(substr($name, 0, 7) == 'filter_')
            return $arguments[0];
    }
    
    /**
     * 修改用户资料
     * @param  <ProfileDomainModel> 资料实体
     * @return <bool> 是否成功
     */
    public function update_profile(ProfileDomainModel $model){
        if(!$this->check_user_name($model->__get('user_name'), $model->__get('user_id')))
            return E(ErrorMessage::$NICK_EXISTS);
        $model = $this->model_filter($model);
        $provider = new CityProvider();
        if(!$provider->check_city_province($model->__get('city'), $model->__get('province')))
            $model->__set('city', 0);    //省份与城市不对应，则设置城市为未选择
        if($this->provider->update_profile_by_user_id($model))
            return true;
        return E(ErrorMessage::$SAVE_FAILED);
    }

    /**
     * 根据用户编号获取用户资料
     * @param  <int> $user_id 用户编号
     * @return <array> 用户资料
     */
    public function get_profile_by_user_id($user_id){
        $data = $this->provider->get_profile_by_user_id($user_id);
        if($data !== false)
            return $data;
        return E(ErrorMessage::$OPERATION_FAILED);
    }

    /**
     * 用户积分变化
     * @param  <int>    $user_id   用户编号
     * @param  <string> $user_name 用户名
     * @param  <int>    $integral  积分
     * @param  <string> $reason    变化原因
     * @param  <int>    $type      变化类型
     * @param  <bool>   $in        是否是增加
     * @return <bool> 是否成功
     */
    public function integral_change($user_id, $user_name, $integral, $reason, $type, $in = true){
        $provider = new IntegralProvider();
        if($provider->add_integral_record($user_id, $user_name, $integral, $reason, $type)){
            if($in)
                return $this->provider->increase_integral ($user_id, $integral);
            return $this->provider->decrease_integral($user_id, $integral);
        }
        return false;
    }

    /**
     * 用户信誉度变化
     * @param  <int>    $user_id   用户编号
     * @param  <string> $user_name 用户名
     * @param  <int>    $credit    信誉度
     * @param  <string> $reason    变化原因
     * @param  <int>    $type      变化类型
     * @param  <bool>   $in        是否是增加
     * @return <bool> 是否成功
     */
    public function credit_change($user_id, $user_name, $credit, $reason, $type, $in = true){
        $provider = new CreditProvider();
        if($provider->add_credit_record($user_id, $user_name, $credit, $reason, $type)){
            if($in)
                return $this->provider->increase_credit ($user_id, $credit);
            return $this->provider->decrease_credit($user_id, $credit);
        }
        return false;
    }

    /**
     * 获取资源库资料列表
     * @param  <mixed>  $label     标签编号
     * @param  <int>    $role_id   角色编号
     * @param  <string> $auth_code 认证代码
     * @param  <int>    $province  省份编号（可选）
     * @param  <int>    $city      城市编号（可选）
     * @param  <int>    $page      第几页
     * @param  <int>    $size      每页几条
     * @param  <string> $key       关键字（可选）
     * @param  <string> $order     排序方式（可选）
     * @param  <bool>   $count     是否是统计总条数
     * @return <mixed>
     */
    public function get_resource_profile_list($label, $role_id, $auth_code, $province, $city, $page, $size, $key = null, $order = null, $count = false){
        $label = $this->filter_label($label);           //标签编号过滤
        $page  = intval($page);
        $size  = intval($size);
        if($label == null)
            return $this->provider->get_resource_list(intval($role_id), $auth_code, $province, $city, $page, $size, $key, $order, $count);
        else
            return $this->provider->get_resource_list_by_label($label, $auth_code, $province, $city, $page, $size, $key, $order, $count);
    }
    
    /**
     * 检测指定昵称用户角色
     * @param  <string> $name 昵称
     * @return <int>
     */
    public function get_role_by_nick($name){
        $id = $this->provider->get_id_by_nick($name);
        if(empty($id))
            return null;
        $provider = new UserProvider();
        return $provider->get_role_by_id($id);
    }

    /**
     * 根据用户名获取用户编号
     * @param  <string> $name 昵称
     * @return <int>
     */
    public function get_id_by_nick($name){
        return $this->provider->get_id_by_nick($name);
    }
    
    /**
     * 获取人才资料列表
     * @param  <string> $role_code 角色代码
     * @param  <string> $auth_code 认证代码
     * @param  <int>    $page      第几页
     * @param  <int>    $size      每页几条
     * @param  <string> $order     排序条件
     * @return <mixed> 资料列表
     */
    public function get_talent_profile_list($role_code, $auth_code, $page, $size, $order){}

    /**
     * 获取企业资料列表
     * @param  <string> $role_code 角色代码
     * @param  <string> $auth_code 认证代码
     * @param  <int>    $page      第几页
     * @param  <int>    $size      每页几条
     * @param  <string> $order     排序条件
     * @return <mixed> 资料列表
     */
    public function get_enterprise_profile_list($role_code, $auth_code, $page, $size, $order){}

    /**
     * 获取经纪资料列表
     * @param  <string> $type_code 用户类型代码
     * @param  <string> $auth_code 认证代码
     * @param  <int>    $page      第几页
     * @param  <int>    $size      每页几条
     * @param  <string> $order     排序条件
     * @return <mixed> 资料列表
     */
    public function get_manager_profile_list($type_code, $auth_code, $page, $size, $order){}

    /**
     * 检测用户昵称是否存在
     * @param  <string> $user_name 用户昵称
     * @param  <int>    $user_id   排除指定编号用户
     * @return <bool> 是否存在
     */
    public function exists_user_name($user_name, $user_id){
        return $this->provider->exists_user_name($user_name, $user_id);
    }

    /**
     * 根据信誉度分数获取对应信誉度等级信息
     * @param  <int> $credit 信誉度分数
     * @return <array> 等级信息
     */
    public function get_credit_level($credit){
        $provider = new CreditProvider();
        return $provider->get_credit_level(intval($credit));
    }

    /**
     * 获取指定省份信息
     * @param  <int> $code 省份代码
     * @return <array> 省份信息
     */
    public function get_province($code){
        $provider = new ProvinceProvider();
        return $provider->get_province($code);
    }

    /**
     * 获取指定城市信息
     * @param  <int> $code 城市代码
     * @return <array> 城市信息
     */
    public function get_city($code){
        $provider = new CityProvider();
        return $provider->get_city($code);
    }

    /**
     * 获取省份列表
     * @return <array> 省份列表
     */
    public function get_province_list(){
        $provider = new ProvinceProvider();
        return $provider->get_province_list();
    }

    /**
     * 获取指定省份的城市列表
     * @param  <int> $province 省份代码
     * @return <array> 城市编号
     */
    public function get_city_list($province){
        $provider = new CityProvider();
        return $provider->get_city_list($province);
    }

    //-------------------protected--------------------
    /**
     * 模型字段过滤
     * @param  <mixed> $model 模型
     * @return <mixed>
     */
    protected function model_filter($model){
        $array = get_object_vars($model);
        foreach($array as $key => $value){
            $method = 'filter_'.$key;
            if($array[$key] !== null) $model->$key = $this->$method($value);
        }
        return $model;
    }

    /**
     * 用户昵称过滤
     * @param  <string> $user_name 昵称
     * @return <string>
     */
    protected function filter_user_name($user_name){
        $user_name = trim($user_name);
        if(strlen($user_name) > 60) $user_name = msubstr($user_name, 60);
        return htmlspecialchars($user_name);
    }

    /**
     * 联系方式过滤
     * @param  <string> $contact 联系方式
     * @return <string>
     */
    protected function filter_contact($contact){
        if(empty($contact))
            return '';
        $contact = trim($contact);
        if(strlen($contact) > 30) $contact = substr($contact, 0, 30);
        return htmlspecialchars($contact);
    }

    /**
     * QQ过滤
     * @param  <string> $qq QQ
     * @return <string>
     */
    protected function filter_qq($qq){
        if(empty($qq))
            return '';
        $qq = trim($qq);
        if(strlen($qq) > 20) $qq = substr($qq, 0, 20);
        return htmlspecialchars($qq);
    }

    /**
     * 照片过滤
     * @param  <string> $photo 照片
     * @return <string>
     */
    protected function filter_photo($photo){
        $photo = trim($photo);
        if(strlen($photo) > 100) $photo = substr($photo, 0, 100);
        return addslashes($photo);
    }

    /**
     * 用户简介过滤
     * @param  <string> $intro 简介
     * @return <string>
     */
    protected function filter_introduction($intro){
        if(empty($intro))
            return '';
        return htmlspecialchars($intro);
    }

    /**
     * 用户经历过滤
     * @param  <string> $exp 经历
     * @return <string>
     */
    protected function filter_experience($exp){
        if(empty($exp))
            return '';
        return htmlspecialchars($exp);
    }

    /**
     * 日期过滤
     * @param  <string> $date 日期
     * @return <string>
     */
    protected function filter_date($date){
        if(!preg_match('/^\d{4}-[01]{1}\d-[01]{1}\d [01]{1}[0-9]{1}:[0-5]{1}[0-9]{1}:[0-5]{1}[0-9]{1}$/',$date) && !preg_match('/^\d{4}-[01]{1}\d-[01]{1}\d$/',$date))
            return null;
        return $date;
    }

    /**
     * 性别过滤
     * @param  <int> $gender 性别
     * @return <int>
     */
    protected function filter_gender($gender){
        switch ($gender){
            case 0 :
            case 1 : return $gender;
            default: return 1;
        }
    }

    /**
     * 用户类型过滤
     * @param  <int> $user_type 用户类型
     * @return <int>
     */
    protected function filter_user_type($user_type){
        if($user_type != 1)
            return 2;
        return 1;
    }

    /**
     * 省份过滤
     * @param  <int> $province 省份编号
     * @return <int>
     */
    protected function filter_province($province){
        $provider = new ProvinceProvider();
        if(!$provider->is_exists_province($province))
            return 0;
        return $province;
    }

    /**
     * 城市过滤
     * @param  <int> $city 城市编号
     * @return <int>
     */
    protected function filter_city($city){
        $provider = new CityProvider();
        if(!$provider->is_exists_city($city))
            return 0;
        return $city;
    }

    /**
     * 检测用户昵称是否合法
     * @param  <string> $user_name 用户昵称
     * @return <bool> 是否合法
     */
    protected function check_user_name($user_name, $user_id){
        if(empty($user_name) || $this->provider->exists_user_name($user_name, $user_id))
            return false;
        return true;
    }

    /**
     * 标签编号过滤
     * @param  <int> $label 编号
     * @return <mixed>
     */
    protected function filter_label($label){
        if($label < 1)
            $label = null;                                  //设置不分类
        else{
            $provider = new LabelProvider();
            $clabel   = $provider->get_children($label);    //获取子分类
            if(!empty ($clabel)){
                foreach ($clabel as $item) {
                    $larray[] = $item['id'];
                }
                $label = $larray;                          //化为子分类编号数组
            }
        }
        return $label;
    }
}
?>
