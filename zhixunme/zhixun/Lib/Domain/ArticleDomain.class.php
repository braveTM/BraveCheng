<?php
/**
 * Description of ArticleDomain
 *
 * @author moi
 */
class ArticleDomain{
    //----------------private-------------------
    private $provider;

    //----------------public--------------------
    public function  __construct() {
        $this->provider = new ArticleProvider();
    }

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
        if(!$this->check_class_id($class_id) || !$this->check_title($title) || !$this->check_author($author) || !$this->check_picture($picture)){
            return E(ErrorMessage::$PARAMETER_FORMAT_ERROR);       //参数有误
        }
        //参数内容过滤
        $title   = $this->filter_title($title);
        $author  = $this->filter_author($author);
        $content = $this->filter_content($content);
        if($this->provider->add_article($class_id, $user_id, $title, $author, $content, $picture))
            return true;
        return E(ErrorMessage::$PARAMETER_FORMAT_ERROR);
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
        if(!$this->check_class_id($class_id) || !$this->check_title($title) || !$this->check_author($author) || !$this->check_picture($picture)){
            return E(ErrorMessage::$PARAMETER_FORMAT_ERROR);           //参数有误
        }
        //参数内容过滤
        $title   = $this->filter_title($title);
        $author  = $this->filter_author($author);
        $content = $this->filter_content($content);
        if($this->provider->update_article($art_id, $class_id, $title, $author, $content, $picture))
            return true;
        return E(ErrorMessage::$OPERATION_FAILED);
    }

    /**
     * 删除文章
     * @param  <int>    $art_id   文章编号
     * @return <bool> 是否成功
     */
    public function del_article($art_id){
        if($this->provider->del_article($art_id))
            return true;
        return E(ErrorMessage::$OPERATION_FAILED);
    }

    /**
     * 增加文章阅读次数
     * @param  <int>    $art_id   文章编号
     * @return <bool> 是否成功
     */
    public function increase_read_count($art_id){
        if($this->provider->increase_read_count($art_id))
            return true;
        return E(ErrorMessage::$OPERATION_FAILED);
    }

    /**
     * 获取指定编号文章
     * @param  <int>    $art_id   文章编号
     * @return <mixed> 文章
     */
    public function get_article($art_id){
        return $this->provider->get_article($art_id);
    }

    /**
     * 获取分类文章列表（默认排序）
     * @param  <int> $class_id 分类编号
     * @param  <int> $page     第几页
     * @param  <int> $size     每页几条
     * @return <mixed> 文章列表
     */
    public function get_article_list($class_id, $page, $size){
        $class_id = $this->filter_number($class_id);
        $page     = $this->filter_number($page);
        $size     = $this->filter_number($size);
        $data     = $this->provider->get_article_list($class_id, $page, $size);
        if($data === false)
            return E(ErrorMessage::$OPERATION_FAILED);
        return $data;
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
        $class_id = $this->filter_number($class_id);
        $page     = $this->filter_number($page);
        $size     = $this->filter_number($size);
        
        return $this->domain->get_article_list($class_id, $page, $size, $user_id, $from, $to, $status, $order, $count, $like);
    }

    /**
     * 获取指定父栏目编号文章分类类别
     * @param  <int> $pid 父栏目编号
     * @return <mixed>
     */
    public function get_class_list($pid){
        return $this->provider->get_class_list($pid);
    }

    //-----------------protected----------------
    /**
     * 检测文章类别编号是否合法
     * @param  <int> $class_id 类别编号
     * @return <bool> 是否合法
     */
    protected function check_class_id($class_id){
        return !$this->provider->exists_class_id($class_id);
    }

    /**
     * 检测文章标题是否合法
     * @param  <string> $title 标题
     * @return <bool> 是否合法
     */
    protected function check_title($title){
        return strlen($title) <= 90;
    }

    /**
     * 检测文章作者是否合法
     * @param  <string> $author 作者
     * @return <bool> 是否合法
     */
    protected function check_author($author){
        return strlen($title) <= 90;
    }

    /**
     * 检测文章图片路径是否合法
     * @param  <string> $picture 图片路径
     * @return <bool> 是否合法
     */
    protected function check_picture($picture){
        return strlen($title) <= 100;
    }
    
    /**
     * 文章标题过滤
     * @param  <string> $title 标题
     * @return <string>
     */
    protected function filter_title($title){
        return htmlspecialchars($title);
    }

    /**
     * 文章作者过滤
     * @param  <string> $author 作者
     * @return <string>
     */
    protected function filter_author($author){
        return htmlspecialchars($author);
    }

    /**
     * 文章内容过滤
     * @param  <string> $content 内容
     * @return <string>
     */
    protected function filter_content($content){
        return htmlspecialchars($content);
    }

    /**
     * 数字过滤
     * @param  <int> $num 数字
     * @return <int>
     */
    protected function filter_number($num){
        $num = intval($num);
        if($num < 1)
            $num = 1;
        return $num;
    }
}
?>
