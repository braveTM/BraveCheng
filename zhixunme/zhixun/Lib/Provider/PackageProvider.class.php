<?php
/**
 * Description of PackageProvider
 *
 * @author moi
 */
class PackageProvider extends BaseProvider{
//    /**
//     * 根据指定套餐编号获取套餐信息
//     * @param  <int> $id 套餐编号
//     * @return <array> 套餐信息
//     */
//    public function get_package($id){
//        $cache_key = CC('SYSTEM_PACKAGE_ITEM').$id;
//        $data = DataCache::get($cache_key);
//        if(empty($data)){
//            $this->da->setModelName('role_package');            //使用套餐表
//            $where['package'] = $id;
//            $data = $this->da->where($where)->find();
//            if(!empty($data))
//                DataCache::set($cache_key, $data);
//        }
//        return $data;
//    }
//
//    /**
//     * 获取指定角色可拥有套餐列表
//     * @param  <int>  $role_id 角色编号
//     * @param  <bool> $include 是否包含系统默认套餐
//     * @param  <int>  $exclude 排除指定套餐
//     * @return <array> 套餐列表
//     */
//    public function get_packages($role_id, $include = false, $exclude = null){
//        $cache_key = CC('SYSTEM_PACKAGE_LIST').$role_id.'_'.$include;
//        $data = DataCache::get($cache_key);
//        if(empty($data)){
//            $this->da->setModelName('role_package');            //使用套餐表
//            $where['role_id'] = $role_id;
//            if(!$include){
//                $where['package'] = array('gt', 10000);
//            }
//            if(!empty($exclude)){
//                $where['package'] = array('neq', $exclude);
//            }
//            $data = $this->da->where($where)->select();
//            if(!empty($data))
//                DataCache::set($cache_key, $data);
//        }
//        return $data;
//    }

    /**
     * 获取指定角色适用套餐列表
     * @param  <int>  $role_id 角色编号
     * @param  <int>  $page    第几页
     * @param  <int>  $size    每页几条
     * @param  <bool> $count   是否统计总条数
     * @return <mixed>
     */
    public function get_package_list($role_id, $page, $size, $count = false){
        $this->da->setModelName('package');
        $where['role_id'] = $role_id;
        $where['free'] = 0;
        $where['is_del'] = 0;
        if($count){
            return $this->da->where($where)->count('id');
        }
        else{
            $order = 'sort DESC';
            return $this->da->where($where)->page($page.','.$size)->order($order)->select();
        }
    }

    /**
     * 获取指定套餐的模块信息
     * @param  <int> $package_id 套餐编号
     * @return <mixed>
     */
    public function get_package_module_info($package_id) {
        $this->da->setModelName('package_module_relation t1');
        $join[] = C('DB_PREFIX') . 'package_module t2 ON t2.id=t1.module_id';
        $where['t1.package_id'] = $package_id;
        $where['t1.is_del'] = 0;
        $where['t2.is_del'] = 0;
        $field = 't1.module_id,t1.price,t1.free_count,t2.title as m_title,t2.unit';
        return $this->da->join($join)->where($where)->field($field)->select();
    }

    /**
     * 获取指定套餐信息
     * @param  <int> $id 套餐编号
     * @return <mixed>
     */
    public function get_package_info($id){
        $this->da->setModelName('package');
        $where['id'] = $id;
        $where['is_del'] = 0;
        return $this->da->where($where)->find();
    }

    /**
     * 添加套餐记录
     * @param  <int>    $user_id    用户编号
     * @param  <int>    $package_id 套餐编号
     * @param  <int>    $cost       花费
     * @param  <string> $start      开始时间
     * @param  <string> $end        结束时间
     * @return <int> 记录编号
     */
    public function add_package_record($user_id, $package_id, $cost, $start, $end){
        $this->da->setModelName('package_record');
        $data['user_id']    = $user_id;
        $data['package_id'] = $package_id;
        $data['cost']       = $cost;
        $data['start_time'] = $start;
        $data['end_time']   = $end;
        $data['is_del']     = 0;
        return $this->da->add($data);
    }

    /**
     * 更新套餐记录
     * @param  <int>   $id   记录编号
     * @param  <array> $data 信息
     * @return <bool> 是否成功
     */
    public function update_package_record($id, $data){
        $this->da->setModelName('package_record');
        $where['id'] = $id;
        $where['is_del'] = 0;
        return $this->da->where($where)->save($data);
    }

    /**
     * 清除用户之前套餐记录
     * @param  <int> $user_id 用户编号
     * @return <int> 记录编号
     */
    public function delete_user_old_record($user_id){
        $this->da->setModelName('package_record');
        $where['user_id'] = $user_id;
        $where['is_del'] = 0;
        $data['is_del'] = 1;
        return $this->da->where($where)->save($data);
    }

    /**
     * 添加套餐免费政策记录
     * @param  <int> $id         套餐记录编号
     * @param  <int> $module_id  功能编号
     * @param  <int> $free_count 免费条数
     * @param  <int> $price      超额后的价格
     * @return <bool> 是否成功
     */
    public function add_package_record_free($id, $module_id, $free_count, $price){
        $this->da->setModelName('package_record_free');
        $data['pu_id']      = $id;
        $data['module_id']  = $module_id;
        $data['initial_free_count'] = $free_count;
        $data['free_count'] = $free_count;
        $data['price']      = $price;
        $data['is_del']     = 0;
        return $this->da->add($data) != false;
    }

    /**
     * 更新套餐免费政策记录
     * @param  <int>   $id   编号
     * @param  <array> $data 信息
     * @return <bool> 是否成功
     */
    public function update_package_record_free($id, $data){
        $this->da->setModelName('package_record_free');
        $where['id'] = $id;
        $where['is_del'] = 0;
        return $this->da->where($where)->save($data) !== false;
    }

    /**
     * 获取指定用户当前使用套餐记录
     * @param  <int> $user_id 用户编号
     * @return <mixed>
     */
    public function get_package_record($user_id){
        $this->da->setModelName('package_record');
        $where['user_id'] = $user_id;
        $where['end_time'] = array('gt', date_f());
        $where['is_del'] = 0;
        return $this->da->where($where)->find();
    }

    /**
     * 获取指定套餐记录的指定模块免费政策
     * @param  <int> $pu_id     套餐记录编号
     * @param  <int> $module_id 模块编号
     * @return <mixed>
     */
    public function get_package_record_free($pu_id, $module_id){
        $this->da->setModelName('package_record_free');
        $where['pu_id'] = $pu_id;
        $where['module_id'] = $module_id;
        $where['is_del'] = 0;
        return $this->da->where($where)->find();
    }

    /**
     * 获取指定套餐记录所有模块免费政策
     * @param  <int> $pu_id 套餐记录编号
     * @return <mixed>
     */
    public function get_package_record_free_list($pu_id){
        $this->da->setModelName('package_record_free t1');
        $join[] = C('DB_PREFIX') . 'package_module t2 ON t2.id=t1.module_id';
        $where['t1.pu_id'] = $pu_id;
        $where['t1.is_del'] = 0;
        $field = 't1.initial_free_count,t1.free_count,t1.price,t2.title as m_title,t2.id,t2.unit';
        return $this->da->join($join)->where($where)->field($field)->select();
//        $this->da->setModelName('package_record_free');
//        $where['pu_id'] = $pu_id;
//        $where['is_del'] = 0;
//        return $this->da->where($where)->select();
    }

    /**
     * 获取指定模块信息
     * @param  <int> $id 模块编号
     * @return <mixed>
     */
    public function get_package_module($id){
        $this->da->setModelName('package_module');
        $where['id'] = $id;
        $where['is_del'] = 0;
        return $this->da->where($where)->find();
    }

    /**
     * 使用免费条数
     * @param  <int> $id    编号
     * @param  <int> $count 条数
     * @return <bool> 是否成功
     */
    public function use_free_count($id, $count){
        $this->da->setModelName('package_record_free');
        $where['id'] = $id;
        $where['is_del'] = 0;
        return $this->da->setDec('free_count', $where, $count) != false;
    }

    /**
     * 添加免费条数使用记录
     * @param  <int> $id
     * @param  <type> $title
     * @param  <type> $module_id
     * @param  <type> $count
     * @return <type>
     */
    public function add_use_free_record($user_id, $f_id, $title, $module_id, $count){
        $this->da->setModelName('package_record_free_record');
        $data['user_id'] = $user_id;
        $data['f_id'] = $f_id;
        $data['title'] = $title;
        $data['module_id'] = $module_id;
        $data['count'] = $count;
        $data['date'] = date_f();
        $data['is_del'] = 0;
        return $this->da->add($data) != false;
    }
    
    /**
     * 获取指定角色相应的免费套餐
     * @param int $role_id 角色编号
     * @return array 
     */
    public function get_free_package($role_id){
        $this->da->setModelName('package');
        $where['role_id'] = $role_id;
        $where['free'] = 1;
        $where['is_del'] = 0;
        return $this->da->where($where)->find();
    }
    
    /**
     * 获取通话分钟数信息
     * @return array
     */
    public function get_call_min_list(){
        $this->da->setModelName('package_call_min');
        $order = 'sort DESC';
        return $this->da->order($order)->field('price,min')->select();
    }
}
?>
