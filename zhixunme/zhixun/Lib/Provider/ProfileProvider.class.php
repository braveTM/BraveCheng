<?php
/**
 * Description of ProfileProvider
 *
 * @author moi
 */
class ProfileProvider extends BaseProvider{
    /**
     * 添加用户资料
     * @param  <int>    $user_id   用户编号
     * @param  <string> $user_name 用户名
     * @param  <int>    $user_type 用户类型（1为单人，2为多人）
     * @param  <string> $photo     头像
     * @param  <string> $birth     生日
     * @param  <int>    $gender    性别（0女，1男）
     * @param  <string> $phone     手机号码
     * @param  <string> $qq        QQ
     * @param  <int>    $pid       省份编号
     * @param  <int>    $cid       城市编号
     * @return <bool> 是否成功
     */
    public function add_profile($user_id, $user_name, $user_type, $photo, $birth, $gender, $phone, $qq, $pid, $cid){
        $this->da->setModelName('user_profile');            //使用用户资料表
        $data['user_id']       = $user_id;
        $data['user_name']     = $user_name;
        $data['user_type']     = $user_type;
        $data['photo']         = C('PATH_DEFAULT_AVATAR');
        $data['introduction']  = '';
        $data['experience']    = '';
        $data['date']          = date_f();
        $data['gender']        = $gender;
        $data['contact']       = $phone;
        $data['qq']            = $qq;
        $data['province_id']   = $pid;
        $data['city_id']       = $cid;
        $data['info_count']    = 0;
        $data['integral']      = 0;
        $data['credibility']   = 0;
        $data['is_real_auth']  = 0;
        $data['is_phone_auth'] = 0;
        $data['is_email_auth'] = 0;
        $data['is_bank_auth']  = 0;
        $data['sort']          = time() - 1000000000;
        $data['is_del']        = 0;

        return $this->da->add($data) !== false;
    }

    /**
     * 更新用户信息
     * @param  <ProfileDomainModel> $model 用户信息实体
     * @return <bool> 是否成功
     */
    public function update_profile_by_user_id(ProfileDomainModel $model){
        $this->da->setModelName('user_profile');            //使用用户资料表
        $data             = FactoryDMap::model_to_array($model, 'profile');
        $where['user_id'] = $data['user_id'];
        unset($data['user_id']);
        return $this->da->where($where)->save($data) !== false;
    }

    /**
     * 根据用户编号获取用户资料
     * @param  <int> $user_id 用户编号
     * @return <array> 用户资料
     */
    public function get_profile_by_user_id($user_id){
        $this->da->setModelName('user_profile');            //使用用户资料表
        $where['user_id'] = $user_id;
        return $this->da->where($where)->find();
    }

    /**
     * 增加用户信誉度
     * @param  <int> $user_id 用户编号
     * @param  <int> $credit  信誉度
     * @return <bool> 是否成功
     */
    public function increase_credit($user_id, $credit){
        $this->da->setModelName('user_profile');            //使用用户资料表
        return $this->da->setInc('credibility', array('user_id' => $user_id), $credit);
    }

    /**
     * 减少用户信誉度
     * @param  <int> $user_id 用户编号
     * @param  <int> $credit  信誉度
     * @return <bool> 是否成功
     */
    public function decrease_credit($user_id, $credit){
        $this->da->setModelName('user_profile');            //使用用户资料表
        return $this->da->setDec('credibility', array('user_id' => $user_id), $credit);
    }

    /**
     * 增加用户积分
     * @param  <int> $user_id  用户编号
     * @param  <int> $integral 积分
     * @return <bool> 是否成功
     */
    public function increase_integral($user_id, $integral){
        $this->da->setModelName('user_profile');            //使用用户资料表
        return $this->da->setInc('integral', array('user_id' => $user_id), $integral);
    }

    /**
     * 减少用户积分
     * @param  <int> $user_id  用户编号
     * @param  <int> $integral 积分
     * @return <bool> 是否成功
     */
    public function decrease_integral($user_id, $integral){
        $this->da->setModelName('user_profile');            //使用用户资料表
        return $this->da->setDec('integral', array('user_id' => $user_id), $integral);
    }

    /**
     * 根据用户标签获取资源库资料列表
     * @param  <mixed>  $label     标签编号
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
    public function get_resource_list_by_label($label, $auth_code, $province, $city, $page, $size, $key = null, $order = null, $count = false){
        $rlabel_tabel  = C('DB_PREFIX').'user_label_relation';      //用户表名
        $profile_tabel = C('DB_PREFIX').'user_profile';             //资料表名
        if(is_array($label)){
            foreach ($label as $item) {
                $in .= $item.',';
            }
            $in = rtrim($in, ',');
            $where = 'r.label_id in ('.$in.')';
        }
        else{
            $where = 'r.label_id='.$label;
        }
        $where .= ' AND r.user_id=p.user_id AND p.is_del=0';
        if(substr($auth_code, 0, 1) == '1')
            $where .= ' AND p.is_real_auth=1';
        if(substr($auth_code, 1, 1) == '1')
            $where .= ' AND p.is_phone_auth=1';
        if(substr($auth_code, 2, 1) == '1')
            $where .= ' AND p.is_email_auth=1';
        if(substr($auth_code, 3, 1) == '1')
            $where .= ' AND p.is_bank_auth=1';
        if(!empty ($province) && empty ($city))
            $where .= ' AND p.province_id='.intval($province);
        else if(!empty ($city))
            $where .= ' AND p.city_id='.intval($city);
        if(!empty($key))
            $where .= " AND p.user_name like '%$key%'";
        if(empty($order))
            $order = 'p.sort DESC';
        if($page == 0)
            $page = 1;
        $limit = (($page - 1) * $size).", $size";
        if($count)
            $field = 'COUNT(p.user_id)';
        else
            $field = 'p.user_id,p.user_name,p.photo,p.introduction,p.credibility,p.date,p.province_id,p.city_id,is_real_auth,p.is_phone_auth,p.is_email_auth,p.is_bank_auth';
        $sql = "SELECT $field
                FROM $rlabel_tabel r, $profile_tabel p
                WHERE $where
                ORDER BY $order
                LIMIT $limit";
        $result = $this->da->query($sql);
        if($count)
            return intval($result[0]['COUNT(p.user_id)']);
        else
            return $result;
    }

    /**
     * 获取资源库资料列表
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
    public function get_resource_list($role_id, $auth_code, $province, $city, $page, $size, $key = null, $order = null, $count = false){
        $user_tabel    = C('DB_PREFIX').'user';             //用户表名
        $profile_tabel = C('DB_PREFIX').'user_profile';     //资料表名
        $where = 'u.role_id='.$role_id;
        $where .= ' AND u.user_id=p.user_id AND p.is_del=0';
        if(substr($auth_code, 0, 1) == '1')
            $where .= ' AND p.is_real_auth=1';
        if(substr($auth_code, 1, 1) == '1')
            $where .= ' AND p.is_phone_auth=1';
        if(substr($auth_code, 2, 1) == '1')
            $where .= ' AND p.is_email_auth=1';
        if(substr($auth_code, 3, 1) == '1')
            $where .= ' AND p.is_bank_auth=1';
        if(!empty ($province) && empty ($city))
            $where .= ' AND p.province_id='.intval($province);
        else if(!empty ($city))
            $where .= ' AND p.city_id='.intval($city);
        if(!empty($key))
            $where .= " AND p.user_name like '%$key%'";
        if(empty($order))
            $order = 'p.sort DESC';
        if($page == 0)
            $page = 1;
        $limit = (($page - 1) * $size).", $size";
        if($count)
            $field = 'COUNT(p.user_id)';
        else
            $field = 'p.user_id,p.user_name,p.photo,p.introduction,p.credibility,p.date,p.province_id,p.city_id,is_real_auth,p.is_phone_auth,p.is_email_auth,p.is_bank_auth';
        $sql = "SELECT $field
                FROM $user_tabel u, $profile_tabel p
                WHERE $where
                ORDER BY $order
                LIMIT $limit";
        $result = $this->da->query($sql);
        if($count)
            return intval($result[0]['COUNT(p.user_id)']);
        else
            return $result;
;    }

    /**
     * 检测指定昵称用户编号
     * @param  <string> $name 昵称
     * @return <int>
     */
    public function get_id_by_nick($name){
        $this->da->setModelName('user_profile');            //使用用户资料表
        $where['user_name'] = $name;
        $result = $this->da->where($where)->field('user_id')->find();
        if(empty($result))
            return null;
        return intval($result['user_id']);
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
     * 用户信誉度变化
     * @param  <int> $user_id 用户编号
     * @param  <int> $score   变化分数
     * @param  <int> $type    变化类型（1为增长，2为降低）
     */
    public function change_credit($user_id, $score, $type){}

    /**
     * 获取用户邮箱认证状态
     * @param  <int> $user_id 用户编号
     * @return <int> 状态
     */
    public function get_user_auth_email($user_id){}

    /**
     * 设置用户邮箱认证状态
     * @param  <int> $user_id 用户编号
     * @param  <int> $status  状态
     * @return <bool> 是否成功
     */
    public function set_user_auth_email($user_id, $status){
        $this->da->setModelName('user_profile');            //使用资料表
        return $this->da->where(array('user_id' => $user_id))->save(array('is_email_auth' => $status)) !== false;
    }

    /**
     * 获取用户手机认证状态
     * @param  <int> $user_id 用户编号
     * @return <int> 状态
     */
    public function get_user_auth_phone($user_id){}

    /**
     * 设置用户手机认证状态
     * @param  <int> $user_id 用户编号
     * @param  <int> $status  状态
     * @return <bool> 是否成功
     */
    public function set_user_auth_phone($user_id, $status){
        $this->da->setModelName('user_profile');            //使用资料表
        return $this->da->where(array('user_id' => $user_id))->save(array('is_phone_auth' => $status)) !== false;
    }

    /**
     * 获取用户银行卡认证状态
     * @param  <int> $user_id 用户编号
     * @return <int> 状态
     */
    public function get_user_auth_bank($user_id){}

    /**
     * 设置用户银行卡认证状态
     * @param  <int> $user_id 用户编号
     * @param  <int> $status  状态
     * @return <bool> 是否成功
     */
    public function set_user_auth_bank($user_id, $status){
        $this->da->setModelName('user_profile');            //使用资料表
        return $this->da->where(array('user_id' => $user_id))->save(array('is_bank_auth' => $status)) !== false;
    }

    /**
     * 获取用户实名认证状态
     * @param  <int> $user_id 用户编号
     * @return <int> 状态
     */
    public function get_user_auth_real($user_id){}

    /**
     * 设置用户实名认证状态
     * @param  <int> $user_id 用户编号
     * @param  <int> $status  状态
     * @return <bool> 是否成功
     */
    public function set_user_auth_real($user_id, $status){
        $this->da->setModelName('user_profile');            //使用资料表
        return $this->da->where(array('user_id' => $user_id))->save(array('is_real_auth' => $status)) !== false;
    }

    /**
     * 检测用户昵称是否存在
     * @param  <string> $user_name 用户昵称
     * @param  <int>    $user_id   排除指定编号用户
     * @return <bool> 是否存在
     */
    public function exists_user_name($user_name, $user_id){
        $this->da->setModelName('user_profile');            //使用资料表
        $where['user_name'] = $user_name;
        if(!empty($user_id))
            $where['user_id'] = array('neq', $user_id);
        return $this->da->where($where)->count() > 0;
    }

    /**
     * 增加用户发布任务条数
     * @param  <int> $user_id 用户编号
     * @param  <int> $count   任务条数
     * @return <bool> 是否成功
     */
    public function increase_info_count($user_id, $count = 1){
        $this->da->setModelName('user_profile');            //使用用户资料表
        return $this->da->setInc('info_count', array('user_id' => $user_id), $count);
    }

    /**
     * 减少用户发布任务条数
     * @param  <int> $user_id 用户编号
     * @param  <int> $count   任务条数
     * @return <bool> 是否成功
     */
    public function decrease_info_count($user_id, $count = 1){
        $this->da->setModelName('user_profile');            //使用用户资料表
        return $this->da->setDec('info_count', array('user_id' => $user_id), $count);
    }
}
?>
