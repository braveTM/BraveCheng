<?php
/**
 * Description of ArticleProvider
 *
 * @author moi
 */
class ArticleProvider extends BaseProvider{
    /**
     * 添加文章
     * @param  <int>    $class_id 分类编号
     * @param  <int>    $user_id  用户编号
     * @param  <string> $title    文章标题
     * @param  <string> $author   文章作者
     * @param  <string> $content  文章内容
     * @param  <string> $picture  文章图片
     * @return <bool> 是否成功
     */
    public function add_article($class_id, $user_id, $title, $author, $content, $picture){
        $this->da->setModelName('article');                 //使用文章表
        $date = date_f();
        $data['class_id']     = $class_id;
        $data['user_id']      = $user_id;
        $data['art_title']    = $title;
        $data['art_author']   = $author;
        $data['art_content']  = $content;
        $data['publish_date'] = $date;
        $data['edit_date']    = $date;
        $data['picture']      = $picture;
        $data['read_count']   = 0;
        $data['status']       = 3;
        $data['is_del']       = 0;
        return $this->da->add($data) !== false;
    }

    /**
     * 更新文章
     * @param  <int>    $art_id   文章编号
     * @param  <int>    $class_id 分类编号
     * @param  <string> $title    文章标题
     * @param  <string> $author   文章作者
     * @param  <string> $content  文章内容
     * @param  <string> $picture  文章图片
     * @return <bool> 是否成功
     */
    public function update_article($art_id, $class_id, $title, $author, $content, $picture){
        $this->da->setModelName('article');                 //使用文章表
        $where['art_id']      = $art_id;
        $data['class_id']     = $class_id;
        $data['art_title']    = $title;
        $data['art_author']   = $author;
        $data['art_content']  = $content;
        $data['edit_date']    = date_f();
        $data['picture']      = $picture;
        return $this->da->where($where)->save($data) !== false;
    }

    /**
     * 删除文章
     * @param  <int>    $art_id   文章编号
     * @return <bool> 是否成功
     */
    public function del_article($art_id){
        $this->da->setModelName('article');                 //使用文章表
        return $this->da->delete($art_id) !== false;
    }

    /**
     * 增加文章阅读次数
     * @param  <int>    $art_id   文章编号
     * @return <bool> 是否成功
     */
    public function increase_read_count($art_id){
        $this->da->setModelName('article');                 //使用文章表
        $where['art_id'] = $art_id;
        return $this->da->setInc('read_count', $where) !== false;
    }

    /**
     * 获取指定编号文章
     * @param  <int>    $art_id   文章编号
     * @return <mixed> 文章
     */
    public function get_article($art_id){
        //$this->da->setModelName('article');                 //使用文章表
        $table=C('DB_PREFIX').'article article';
        $join[0]='left join '.C('DB_PREFIX').'article_class article_class on article_class.class_id=article.class_id';
        $where['article.art_id'] = $art_id;
        $where['article.is_del'] = 0;
        $fields = "article.*,article_class.class_title";
        return $this->da->table($table)->field($fields)->join($join)->where($where)->find();
    }

    /**
     * 获取分类文章列表（默认排序）
     * @param  <int> $class_id 分类编号
     * @param  <int> $page     第几页
     * @param  <int> $size     每页几条
     * @param <type> $user_id  用户编号
     * @param <type> $from     起始时间
     * @param <type> $to       终止时间
     * @param <type> $status   状态
     * @param <type> $order    排序方式
     * @param <type> $count    是否统计总条数
     * @param <type> $like     关键字
     * @return <mixed> 文章列表
     */
    public function get_article_list($class_id, $page, $size, $user_id = null, $from = null, $to = null, $status = null, $order = null, $count = false, $like = null){
        $this->da->setModelName('article');                 //使用文章表
        $where['is_del']   = 0;
        if(!empty($class_id)){
            $where['class_id'] = $class_id;
        }
        if(!empty($user_id)){
            $where['user_id'] = $user_id;
        }
        if(!empty($from) && !empty($to)){
            $where['edit_date'] = array('between', "'$from','$to'");
        }
        else if(!empty($from)){
            $where['edit_date'] = array('egt', $from);
        }
        else if(!empty($to)){
            $where['edit_date'] = array('elt', $to);
        }
        if(!empty($status)){
            $where['status'] = $status;
        }
        else{
            $where['status'] = 3;
        }
        if(!empty($like)){
            $where['title'] = array('like', "%$like%");
        }
        if($count){
            return $this->da->where($where)->count('art_id');
        }
        else{
            if(empty($order))
                $order = 'sort asc,edit_date DESC';
            $field = 'art_id,art_title,art_author,edit_date,read_count,art_content,praise,picture';
            return $this->da->where($where)->order($order)->page($page.','.$size)->field($field)->select();
        }
    }

    /**
     * 检测指定文章类别编号是否存在
     * @param  <int> $class_id 类别编号
     * @return <bool> 是否存在
     */
    public function exists_class_id($class_id){
        $this->da->setModelName('article_class');           //使用文章类别表
        $where['class_id'] = $class_id;
        $where['is_del']   = 0;
        return $this->da->where($where)->count() > 0;
    }

    /**
     * 获取指定父栏目编号文章分类类别
     * @param  <int> $pid 父栏目编号
     * @return <mixed>
     */
    public function get_class_list($pid){
        $this->da->setModelName('article_class');           //使用文章类别表
        $where['parent_id'] = $pid;
        $where['is_del']    = 0;
        return $this->da->where($where)->order('sort desc')->select();
    }

    /**
     * 获取固定文章
     * @param  <int> $id 文章编号
     * @return <mixed>
     */
    public function get_fixed_article($id){
        $this->da->setModelName('article_fixed');           //使用文章类别表
        $where['id'] = $id;
        $where['is_del'] = 0;
        return $this->da->where($where)->find();
    }
    
    /**
     * 增加文章赞一下
     * @param  <int>    $art_id   文章编号
     * @return <bool> 是否成功
     */
    public function increase_praise($art_id){
        $this->da->setModelName('article');                 //使用文章表
        $where['art_id'] = $art_id;
        return $this->da->setInc('praise', $where) !== false;
    }
    
     /**
     * 前一个博客
     * Enter description here ...
     * @param $blog_id
     */
    public function getPreArt($art_id){
    	$this->da->setModelName('article');
    	$field=array('art_id,art_title');
        $order='art_id desc';
        return $this->da->where("art_id < $art_id and is_del = 0")->field($field)->order($order)->find();
    }
    
    /**
     * 下一个博客
     * Enter description here ...
     * @param $blog_id
     */
    public function getNextArt($art_id){
    	$this->da->setModelName('article');
    	$field=array('art_id,art_title');
        return $this->da->where("art_id > $art_id and is_del = 0")->field($field)->find();
    }
}
?>
