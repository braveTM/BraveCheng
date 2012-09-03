<?php
/**
 * 数据访问层-回复类
 * @author YoyiorLee
 * @date 2011-11-01
 */
class ReplyProvider extends BaseProvider{

    const REPLY_FIELDS_NOMAL = 'id,info_id,user_id,user_name,contact,email,content,date,is_bid';
    const REPLY_FIELDS_LIST = 'id,info_id,user_id,user_name,contact,email,date,is_bid';

    /**
     * 回复此任务(ok)
     * @param <int>    $task_id    任务编号
     * @param <int>    $user_id    用户编号
     * @param <string> $user_name  用户名
     * @param <string> $content    回复内容
     * @param <string> $contact    联系方式
     * @param <string> $email      邮箱
     * @param <int>    $package_id 套餐编号
     * @return <bool> 是否成功
     */
    public function reply($task_id, $user_id, $user_name, $content, $contact, $email, $qq, $date){
        $this->da->setModelName('information_reply');
        $data['info_id']   = $task_id;
        $data['user_id']   = $user_id;
        $data['user_name'] = $user_name;
        $data['content']   = $content;
        $data['contact']   = $contact;
        $data['email']     = $email;
        $data['qq']        = $qq;
        $data['date']      = $date;
        $data['bid_date']  = $date;
        $data['status']    = 1;
        $data['is_bid']    = 0;
        $data['is_del']    = 0;
        return $this->da->add($data) != false;
    }

    public function delete($id) {
        $this->da->setModelName('information_reply');
        $where['id']  = $id;
        $data['is_del'] = 1;
        return $this->da->where($where)->data($data)->save();
    }

    public function get_reply($id) {
        $this->da->setModelName('information_reply');
        $where['id']  = $id;
        $where['is_del']  = 0;
        return $this->da->where($where)->field(self::REPLY_FIELDS_NOMAL)->find();
    }

    /**
     * 获取中标的竞标列表
     * @param  <int> $page 第几页
     * @param  <int> $size 每页几条
     * @return <mixed> 列表
     */
    public function get_replys_by_bided($page, $size, $tid){
        $this->da->setModelName('information_reply');
        if(isset($tid)){
            $where['info_id']  = $tid;
        }
        $where['status']  = 1;
        $where['is_bid'] = 1;
        $where['is_del'] = 0;
        return $this->da->where($where)->page($page.','.$size)->order('bid_date desc')->select();
    }

    public function get_replys_by_task_id($task_id, $page_index, $page_size, $order) {
        $this->da->setModelName('information_reply');
        $where['info_id']  = $task_id;
        $where['is_del']  = 0;
        $result = $this->da->where($where)->page("$page_index,$page_size")->order($order)->field(self::REPLY_FIELDS_NOMAL)->select();
        if(isset($result))
            return null;
        $models = array();
        foreach($result as $item){
            $one = FactoryDMap::array_to_model($item, 'reply');
            array_push($models, $one);
        }
        return $models;
    }

    public function get_replys_by_user_id($user_id, $page_index, $page_size, $order) {
        $this->da->setModelName('information_reply');
        $where['user_name']  = $user_id;
        $where['is_del']  = 0;
        $result = $this->da->where($where)->page("$page_index,$page_size")->order($order)->field(self::REPLY_FIELDS_NOMAL)->select();
        if(isset($result))
            return null;
        $models = array();
        foreach($result as $item){
            $one = FactoryDMap::array_to_model($item, 'reply');
            array_push($models, $one);
        }
        return $models;
    }

    /**
     * 获取任务回复列表
     * @param  <int>    $task_id   任务编号
     * @param  <string> $role_code 角色代码
     * @param  <string> $auth_code 认证代码
     * @param  <int>    $page      第几页
     * @param  <int>    $size      每页几条
     * @param  <bool>   $count     是否统计条数
     * @return <mixed>
     */
    public function get_reply_list($task_id, $role_code, $auth_code, $page, $size, $count = false){
        $this->da->setModelName('information_reply t1');
        $join[] = C('DB_PREFIX').'user t2 ON t2.user_id=t1.user_id';
        $where['t1.info_id'] = $task_id;
        $where['t1.status'] = 1;
        $where['t1.is_del'] = 0;
        if($role_code != '0000' && $role_code != '1111'){           //角色筛选
            $in = '';
            if(substr($role_code, 0, 1) == 1)                       //人才
                $in .= C('ROLE_TALENTS').',';
            if(substr($role_code, 1, 1) == 1)                       //企业
                $in .= C('ROLE_ENTERPRISE').',';
            if(substr($role_code, 2, 1) == 1)                       //代理
                $in .= C('ROLE_AGENT').',';
            if(substr($role_code, 3, 1) == 1)                       //分包商
                $in .= C('ROLE_SUBCONTRACTOR').',';
            $in = trim($in, ',');
            if(!empty($in)){
                if(substr_count($in, ',') == 0)
                    $where['t2.role_id'] = array('in', $in);
                else
                    $where['t2.role_id'] = $in;
            }
        }
        if($auth_code != '000'){
            if(substr($auth_code, 0, 1) == 1)                       //实名认证
                $where['is_real_auth'] = 1;
            if(substr($auth_code, 1, 1) == 1)                       //手机认证
                $where['is_phone_auth'] = 1;
            if(substr($auth_code, 2, 1) == 1)                       //邮箱认证
                $where['is_email_auth'] = 1;
        }
        if($count){
            return $this->da->join($join)->where($where)->count('t1.id');
        }
        else{
            $order = $order = 't1.is_bid DESC,t1.date DESC';
            $field = 't2.user_id,t2.name,t2.role_id,t2.photo,t2.is_real_auth,t2.is_phone_auth,t2.is_email_auth,t1.id,t1.info_id,t1.content,t1.date,t1.is_bid,t1.contact,t1.email,t1.qq';
            return $this->da->join($join)->where($where)->order($order)->page($page.','.$size)->field($field)->select();
        }
//
//        $reply_tabel   = C('DB_PREFIX').'information_reply';        //回复表名
//        $profile_tabel = C('DB_PREFIX').'user_profile';             //资料表名
//        $user_tabel    = C('DB_PREFIX').'user';                     //用户表名
//        $table = "$reply_tabel r,$profile_tabel p";
//        $where = 'r.is_del=0 AND r.status=1 AND r.info_id='.$task_id;
//        $where .= ' AND r.user_id=p.user_id';
//        if($role_code != '0000' && $role_code != '1111'){           //角色筛选
//            $table = "$reply_tabel r,$profile_tabel p,$user_tabel u";
//            $where .= ' AND p.user_id=u.user_id';
//            $in = '';
//            if(substr($role_code, 0, 1) == 1)                       //人才
//                $in .= C('ROLE_TALENTS').',';
//            if(substr($role_code, 1, 1) == 1)                       //企业
//                $in .= C('ROLE_ENTERPRISE').',';
//            if(substr($role_code, 2, 1) == 1)                       //代理
//                $in .= C('ROLE_AGENT').',';
//            if(substr($role_code, 3, 1) == 1)                       //分包商
//                $in .= C('ROLE_SUBCONTRACTOR').',';
//            $in = trim($in, ',');
//            if(!empty($in)){
//                if(substr_count($in, ',') == 0)
//                    $where .= " AND u.role_id=$in";
//                else
//                    $where .= " AND u.role_id in ($in)";
//            }
//        }
//        if($auth_code != '0000'){
//            if(substr($auth_code, 0, 1) == 1)                       //实名认证
//                $where .= ' AND p.is_real_auth=1';
//            if(substr($auth_code, 1, 1) == 1)                       //手机认证
//                $where .= ' AND p.is_phone_auth=1';
//            if(substr($auth_code, 2, 1) == 1)                       //邮箱认证
//                $where .= ' AND p.is_email_auth=1';
//            if(substr($auth_code, 3, 1) == 1)                       //银行卡认证
//                $where .= ' AND p.is_bank_auth=1';
//        }
//        if($count){                                                 //统计总条数
//            $sql = "SELECT COUNT(r.id)
//                    FROM $table
//                    WHERE $where";
//            $result = $this->da->query($sql);
//            return intval($result[0]['COUNT(r.id)']);
//        }
//        else{                                                       //获取数据列表
//            if($page == 0)
//                $page = 1;
//            $field = 'p.user_id,p.user_name,p.photo,p.credibility,r.id,r.info_id,r.content,r.date,r.is_bid,p.is_real_auth,p.is_phone_auth,p.is_email_auth,p.is_bank_auth';
//            $order = 'r.is_bid DESC,r.date DESC';
//            $limit = (($page - 1) * $size).", $size";
//            $sql   = "SELECT $field
//                      FROM $table
//                      WHERE $where
//                      ORDER BY $order
//                      LIMIT $limit";
//            return $this->da->query($sql);
//        }
    }

    public function is_exist($id){
        $this->da->setModelName('information_reply');
        $where['id']  = $id;
        $result = $this->da->where($where)->field(self::REPLY_FIELDS_NOMAL)->select();
        return $result>0;
    }
    
    public function update(ReplyDomainModel $model) {
        $this->da->setModelName('information_reply');
        $where['id']  = $model->__get("id");
        $data = FactoryDMap::model_to_array($model, 'reply');
        unset($data['id']);
        $result = $this->da->where($where)->data($data)->save();
        return $result>0;
    }

    /**
     * 检测指定用户是否竞标了指定任务
     * @param  <int> $info_id 任务编号
     * @param  <int> $user_id 用户编号
     * @return <bool> 
     */
    public function check_user_reply_task($info_id, $user_id){
        $this->da->setModelName('information_reply');
        $where['info_id'] = $info_id;
        $where['user_id'] = $user_id;
        $where['is_del']  = 0;
        return $this->da->where($where)->count('info_id') > 0;
    }

    /**
     * 检测指定用户是否中标了指定任务
     * @param  <int> $info_id 任务编号
     * @param  <int> $user_id 用户编号
     * @return <bool>
     */
    public function check_user_bid_task($info_id, $user_id){
        $this->da->setModelName('information_reply');
        $where['info_id'] = $info_id;
        $where['user_id'] = $user_id;
        $where['is_bid']  = 1;
        $where['is_del']  = 0;
        return $this->da->where($where)->count('info_id') > 0;
    }
}
?>
