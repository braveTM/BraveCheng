<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BlogProvider
 *
 * @author JZG
 */
class BlogProvider extends BaseProvider{
    //put your code here
    public $blogArgRule=array(
        'blog_id'=>array(
            'name'=>'id',
            'filter'=>VAR_ID,
            'null'=>false
        ),
        'creator_id'=>array(
            'name'=>'创建人',
            'filter'=>VAR_ID,
            'null'=>false
        ),
        'title'=>array(
            'name'=>'标题',
            'length'=>100,
            'null'=>false
        ),
        'body'=>array(
            'name'=>'正文',
            'length'=>10240,
            'null'=>false
        ),
        'source'=>array(
            'name'=>'文章来源',
            'length'=>1024,
            'null'=>true
        )
    );

    public function addBlog($data){
        $this->da->setModelName('blog');
        $data['is_del']=0;
        $data['create_datetime']=date_f();
        $result = $this->da->add($data);
        if($result == false)
            return false;
        return $data['blog_id'];
    }

    public function updateBlog($blog_id,$data){
       $this->da->setModelName('blog');
       $where['blog_id']  = $blog_id;
       return $this->da->where($where)->save($data) !== false;
    }

    public function getBlog($blog_id){
        $this->da->setModelName('blog');
        $where['blog_id']=$blog_id;
        $where['is_del']=0;
        return $this->da->where($where)->find();
    }

    public function getBlogList($creator_id,$status,$start_time,$end_time,$page,$size,$count,$order){
        $table=C('DB_PREFIX').'blog blog';
        $join[0]='inner join '.C('DB_PREFIX').'user user'.' on blog.creator_id=user.user_id';
        if (!empty($creator_id)){
            $where['blog.creator_id']=$creator_id;
        }
        if (!empty($status)) {
            $where['blog.status'] = $status;
        }
        if (!empty($start_time)){
            $where['blog.update_datetime']=array('gt',$start_time);
        }
        if (!empty($end_time)){
            $where['blog.update_datetime']=array('lt',$end_time);
        }
        $where['blog.is_del']=0;
        $where['user.is_del']=0;
        $where['user.is_freeze']=0;
        if ($count){
            return $this->da->table($table)->join($join)->where($where)->count('blog.blog_id');
        }
        if (empty($order)){
            $order='blog.update_datetime desc';
        }
        $field = 'blog.*,user.user_id,user.role_id,user.data_id,user.photo,user.name,user.is_real_auth,user.is_phone_auth,user.is_email_auth';
        return $this->da->table($table)->join($join)->where($where)->page("$page,$size")->field($field)->order($order)->select();
    }

    public function isOwnBlog($creator_id,$blog_id){
        $this->da->setModelName('blog');
        $where['creator_id']=$creator_id;
        $where['blog_id']=$blog_id;
        $where['is_del']=0;
        return $this->da->where($where)->count('blog_id') > 0;
    }

    public function getCreatorByBlogCount($page,$size,$count){
        $this->da->setModelName('user');
        $field=array('user_id,name,photo,blog_count');
        $where['is_del']=0;
        $where['role_id']=3;
        $where['is_freeze']=0;
        $where['is_activate']=1;
        $order='blog_count desc';
        if ($count){
            return $this->da->where($where)->count('user_id');
        }
        return $this->da->where($where)->field($field)->order($order)->page("$page,$size")->select();
    }
    
    /**
     * 前一个博客
     * Enter description here ...
     * @param $blog_id
     */
    public function getPreBlog($blog_id){
    	$this->da->setModelName('blog');
    	$field=array('blog_id,title');
        $order='blog_id desc';
        return $this->da->where("blog_id < $blog_id and status = 3 and is_del = 0")->field($field)->order($order)->find();
    }
    
    /**
     * 下一个博客
     * Enter description here ...
     * @param $blog_id
     */
    public function getNextBlog($blog_id){
    	$this->da->setModelName('blog');
    	$field=array('blog_id,title');
        return $this->da->where("blog_id > $blog_id and status = 3 and is_del = 0")->field($field)->find();
    }
    
    public function getBlogRecommendList($page,$size){
        $table=C('DB_PREFIX').'blog blog';
        $join[0]='inner join '.C('DB_PREFIX').'user user'.' on blog.creator_id=user.user_id';
        $where['blog.is_del']=0;
        $where['blog.status']=3;
        $where['user.is_del']=0;
        $where['user.is_freeze']=0;
        $where['blog.recommend'] = 1;
        if (empty($order)){
            $order='blog.update_datetime desc';
        }
         if(!empty($page) && !empty($size)){
            return $this->da->table($table)->join($join)->where($where)->page("$page,$size")->order($order)->select();
        }else{
            $this->da->setModelName('blog');
            $wheres['is_del']=0;
            $wheres['recommend']=1;
            return $this->da->where($wheres)->count();
        }
    }
    
    /**
     *
     * @return type 
     */
    public function getReleaseList(){
            $Model = new Model(); // 实例化一个model对象 没有对应任何数据表
            
            $list =  $Model->query("SELECT count(b.blog_id) as blog_count, SUM( b.praise ) AS praise,b.creator_id, u.user_id, u.name, u.photo, b.blog_id, b.title
                                    FROM zx_blog b
                                    LEFT JOIN zx_user u ON u.user_id = b.creator_id 
                                    WHERE b.status = 3 and b.is_del = 0 and u.is_freeze = 0
                                    GROUP BY b.creator_id
                                    ORDER BY blog_count DESC, praise DESC 
                                    LIMIT 0 , 6"
                    );
            $this->da->setModelName('blog');
            foreach ($list as $key => $value) {
                
                $fields = "blog_id,title";
                $where['creator_id']=$value['user_id'];
                $where['status']=3;
                $where['is_del']=0;
                
                $info = $this->da->where($where)->order("blog_id desc")->find();
                $list[$key]['blog_id'] = $info['blog_id'];
                $list[$key]['title'] = $info['title'];
                $list[$key]['key'] = $key+1;
            }
            return $list;
    }

    /**
     * 统计经纪人的发布文章数
     * @param int $user_id 用户编号
     * @param string $start 开始时间
     * @param string $end 结束时间
     * @param int $type 统计类型（1文章数2文章被赞数3文章阅读数）
     * @return int
     */
    public function count_user_blogs($user_id, $start, $end, $type){
    	$this->da->setModelName('blog');
        $where['creator_id'] = $user_id;
        $where['update_datetime'] = array('between', "'$start','$end'");
        $where['status'] = 3;
        if($type == 2){
            $result = $this->da->where($where)->field('SUM(read_count) as count')->find();
            return $result['count'];
        }
        else if($type == 3){
            $result = $this->da->where($where)->field('SUM(read_count) as count')->find();
            return $result['count'];
        }
        else{
            return $this->da->where($where)->count('creator_id');
        }
    }
    
    /**
     * 统计用户心得被阅读次数
     * @param int $user_id 用户编号
     * @param string $start 开始时间
     * @param string $end 结束时间
     * @return int 
     */
    public function count_blog_read($user_id, $start, $end){
        $table = C('DB_PREFIX').'blog t1';
        $join[0]='INNER JOIN '.C('DB_PREFIX').'blog_read t2'.' ON t1.creator_id=t2.user_id';
        $where['t2.user_id'] = $user_id;
        $where['t2.date'] = array('between', "'$start','$end'");
        return $this->da->table($table)->join($join)->where($where)->count('t2.user_id');
    }
    
    /**
     * 统计用户心得被赞次数
     * @param int $user_id 用户编号
     * @param string $start 开始时间
     * @param string $end 结束时间
     * @return int 
     */
    public function count_blog_praise($user_id, $start, $end){
        $table = C('DB_PREFIX').'blog t1';
        $join[0]='INNER JOIN '.C('DB_PREFIX').'blog_praise t2'.' ON t1.creator_id=t2.user_id';
        $where['t2.user_id'] = $user_id;
        $where['t2.date'] = array('between', "'$start','$end'");
        return $this->da->table($table)->join($join)->where($where)->count('t2.user_id');
    }
    
    /**
     * 添加文章阅读记录
     * @param int $user_id 用户编号
     * @param int $client_ip 客户端IP
     * @param int $blog_id 文章编号
     * @param string $date 日期
     * @return bool
     */
    public function add_read_record($user_id, $client_ip, $blog_id, $date){
    	$this->da->setModelName('blog_read');
        $data['user_id'] = $user_id;
        $data['client_ip'] = $client_ip;
        $data['blog_id'] = $blog_id;
        $data['date'] = $date;
        return $this->da->add($data) != false;
    }
    
    /**
     * 添加文章被赞记录
     * @param int $user_id 用户编号
     * @param int $client_ip 客户端IP
     * @param int $blog_id 文章编号
     * @param string $date 日期
     * @return bool
     */
    public function add_praise_record($user_id, $client_ip, $blog_id, $date){
    	$this->da->setModelName('blog_praise');
        $data['user_id'] = $user_id;
        $data['client_ip'] = $client_ip;
        $data['blog_id'] = $blog_id;
        $data['date'] = $date;
        return $this->da->add($data) != false;
    }
    
    /**
     * 统计用户文章被阅读次数
     * @param int $user_id 用户编号
     * @param string $start 开始时间
     * @param string $end 结束时间
     * @return int
     */
    public function count_user_blog_readed($user_id, $start, $end){
    	$this->da->setModelName('blog_read t1');
        $join[0]='INNER JOIN '.C('DB_PREFIX').'blog t2'.' on t2.blog_id=t1.blog_id';
        $where['t2.creator_id'] = $user_id;
        $where['t2.status'] = 3;
        $where['t1.date'] = array('between', "'$start','$end'");
        $result = $this->da->join($join)->where($where)->field('SUM(T1.blog_id) as count')->find();
        return $result['count'];
    }
    
    /**
     * 统计用户文章被赞次数
     * @param int $user_id 用户编号
     * @param string $start 开始时间
     * @param string $end 结束时间
     * @return int
     */
    public function count_user_blog_praised($user_id, $start, $end){
    	$this->da->setModelName('blog_praise t1');
        $join[0]='INNER JOIN '.C('DB_PREFIX').'blog t2'.' on t2.blog_id=t1.blog_id';
        $where['t2.creator_id'] = $user_id;
        $where['t2.status'] = 3;
        $where['t1.date'] = array('between', "'$start','$end'");
        $result = $this->da->join($join)->where($where)->field('SUM(T1.blog_id) as count')->find();
        return $result['count'];
    }
}
?>
