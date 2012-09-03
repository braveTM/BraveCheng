<?php
/**
 * Description of PoolService
 *
 * @author zhiguo
 */
class PoolService {
    //----------------private-------------------
    private $provider;

    //----------------public--------------------
    public function  __construct() {
        $this->provider = new PoolProvider();
    }

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
        if (!$this->check_r_name($r_name) || !$this->check_r_qual($r_qual) || !$this->check_phone($r_phone) || !is_numeric($r_city) || !is_numeric($r_province) || !is_numeric($type))
            return E(ErrorMessage::$PARAMETER_FORMAT_ERROR);           //参数有误
        $r_name=htmlspecialchars($r_name);
        if($this->provider->add_pool($user_id, $user_name, $r_name, $r_qual, $r_province, $r_city, $r_phone,$type))
            return true;
        return E(ErrorMessage::$OPERATION_FAILED);
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
        return $this->provider->get_pool_list($user_id, intval($type), $like, $page, $size, $order);
    }

    /**
     *获取个人资源库总条数
     * @param <type> $user_id 用户编号
     * @param <type> $type 资源类型（1为人才，2为企业）
     * @param <type> $like 模糊查询关键字
     * @return <mixed> 成功返回数字，失败返回false
     */
    public function get_pool_total_count($user_id,$type,$like){
        return $this->provider->get_pool_total_count($user_id, $type, $like);
    }

    //----------------private-------------------
    /**
     *验证资源名称（长度不超过30字符）
     * @param <string> $r_name
     * @return <bool>
     */
    private function check_r_name($r_name) {
        return strlen($r_name)<=30;
    }

    /**
     * 检测手机号码是否合法
     * @param  <string> $phone 手机号码
     * @return <bool> 是否合法
     */
    private function check_phone($phone) {
        return preg_match(REGULAR_USER_PHONE, $phone) == 1;
    }

    /**
     *检测资源名称是否合法
     * @param <type> $r_qual 资源名称
     * @return <bool> 是否合法
     */
    private function check_r_qual($r_qual) {
        if (strlen($r_qual)>300)
            return false;
        $labels=split(",",$r_qual);
        foreach($labels as $value) {
            if (!is_numeric($value)) {
                return false;
            }
        }
        if (count($labels)<0) {
            if (!is_numeric($r_qual))
                return false;
        }
        return true;
    }
}
?>
