<?php
/**
 * Description of home_article_index_page
 *
 * @author moi
 */
class home_article_index_page {
    /**
     * 获取站内动态
     * @return <mixed>
     */
    public static function get_web_moving(){
        $service = new ArticleService();
        $data = $service->get_article_list(2, 1, 3, null, null, null, 3, null, false, null);
        return FactoryVMap::list_to_models($data, 'home_index_article');
    }

    /**
     * 获取指定固定文章
     * @param  <int> $id 文章编号
     * @return <mixed>
     */
    public static function get_fixed_article($id){
        $service = new ArticleService();
        $data = $service->get_fixed_article($id);
        return FactoryVMap::array_to_model($data, 'home_article_fixed');
    }

    /**
     * 获取文章
     * @param <type> $id
     * @return <type>
     */
    public static function get_article($id){
        $service=new ArticleService();
        $data=$service->get_article($id);
        $data['class_title']=$data['class_title'];
        $data['blog_id']=$data['art_id'];
        $data['title']=$data['art_title'];
        $data['body']=$data['art_content'];
        $data['name']=$data['art_author'];
        $data['create_datetime']=$data['publish_date'];
        return FactoryVMap::array_to_model($data,'home_blog');
    }

    /**
     * 获取文章列表--考证
     * @param <type> $class_id
     * @param <type> $page
     * @param <type> $size
     * @return <type>
     */
    public static function get_articles_kaozhen($class_id, $page, $size,$user_id = null, $from = null, $to = null, $status = null, $order = null, $count = false, $like = null){
        $service = new ArticleService();
        $data = $service->get_article_list($class_id, $page, $size, $user_id, $from, $to, $status, $order, $count, $like);
        return FactoryVMap::list_to_models($data, 'home_index_article_kaozhen');
    }
    
     /**
     * 获取文章列表
     * @param <type> $class_id
     * @param <type> $page
     * @param <type> $size
     * @return <type>
     */
    public static function get_articles($class_id, $page, $size,$user_id = null, $from = null, $to = null, $status = null, $order = null, $count = false, $like = null){
        $service = new ArticleService();
        $data = $service->get_article_list($class_id, $page, $size, $user_id, $from, $to, $status, $order, $count, $like);
        return FactoryVMap::list_to_models($data, 'home_index_article');
    }

    /**
     * 获取文章条数
     * @param <type> $class_id
     * @return <type>
     */
    public static function get_articles_count($class_id){
        $service = new ArticleService();
        return $service->get_article_list($class_id, 1, 1, null, null, null, null, null, true);
    }
}
?>
