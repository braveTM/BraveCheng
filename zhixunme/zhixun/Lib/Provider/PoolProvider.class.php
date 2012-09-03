<?php
/**
 * Description of PoolProvider
 *
 * @author zhiguo
 */
class PoolProvider extends BaseProvider {

    const POOL_LIST_FIELD = 'r_name,r_qual,r_province,r_city,r_phone,type';
    
    /**
     *添加资源库
     * @param <int> $user_id  用户编号
     * @param <int> $user_name 用户名
     * @param <string> $r_name 资源名称
     * @param <string> $r_qual 资质
     * @param <int> $r_province 省份代号
     * @param <int> $r_city 城市代号
     * @param <string> $r_phone 联系电话
     * @param <int> $type 资源类型（1为人才，2为企业）
     * @return <bool> 是否成功
     */
    public function add_pool($user_id,$user_name,$r_name,$r_qual,$r_province,$r_city,$r_phone,$type) {
        $this->da->setModelName('manager_pool');
        $date = date_f();
        $data['user_id']     = $user_id;
        $data['user_name']      = $user_name;
        $data['r_name']    = $r_name;
        $data['r_qual']   = $r_qual;
        $data['r_province']  = $r_province;
        $data['r_city'] = $r_city;
        $data['r_phone']    = $r_phone;
        $data['date']      = $date;
        $data['type']   = $type;
        return $this->da->add($data) !== false;
    }

    /**
     * 获取个人资源库列表
     * @param <int> $user_id 用户编号
     * @param <int> $type 资源类型（1为人才，2为企业）
     * @param <string> $like 模糊查询关键字
     * @param <int> $page 第几页
     * @param <int> $size 每页条数
     * @return <mixed> 个人资源库列表
     */
    public function get_pool_list($user_id,$type,$like,$page,$size,$order) {
        $this->da->setModelName('manager_pool');         //使用任务表
        $where['is_del'] = 0;
        if(!empty($user_id)) {
            $where['user_id'] = $user_id;
        }
        if(!empty($type)) {                           //分类筛选
            $where['type'] = $type;
        }
        if(!empty($like)) {                              //关键字筛选
            $where['r_name'] = array('like', "%$like%");
        }
        if (empty($order)){
            $order = 'date DESC';
        }
        return $this->da->where($where)->page("$page,$size")->field(self::POOL_LIST_FIELD)->order($order)->select();
    }

    /**
     *获取个人资源库总条数
     * @param <type> $user_id 用户编号
     * @param <type> $type 资源类型（1为人才，2为企业）
     * @param <type> $like 模糊查询关键字
     * @return <mixed> 成功返回数字，失败返回false
     */
    public function get_pool_total_count($user_id,$type,$like){
        $this->da->setModelName('manager_pool');         //使用任务表
        $where['is_del'] = 0;
        if(!empty($user_id)) {
            $where['user_id'] = $user_id;
        }
        if(!empty($type)) {                           //分类筛选
            $where['type'] = $type;
        }
        if(!empty($like)) {                              //关键字筛选
            $where['r_name'] = array('like', "%$like%");
        }
        return $this->da->where($where)->count('id');
    }
}
?>
