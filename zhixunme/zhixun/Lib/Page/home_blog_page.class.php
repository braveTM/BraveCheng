<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of home_blog_page
 *
 * @author JZG
 */
class home_blog_page {
    //put your code here
    
    public static function getBlog($blog_id){
        $blogService=new BlogService();
        $result=$blogService->isAuditBlog($blog_id);
        if (is_zerror($result)){
            $is_own=$blogService->isOwnBlog(AccountInfo::get_user_id(), $blog_id);
            if (is_zerror($is_own)){
                return $is_own;
            }
        }
        $blog=$blogService->getBlog($blog_id);
        $usvc = new UserService();
        $user = $usvc->get_user($blog['creator_id']);
        $blog = array_merge($user, $blog);
        return FactoryVMap::array_to_model($blog,'home_blog');
    }

    public static function getBlogList($creator_id,$status,$page,$size){
        $blogService=new BlogService();
        $blogList=$blogService->getBlogList($creator_id,$status,$page, $size,false);
        return FactoryVMap::list_to_models($blogList,'home_blog');
    }

    public static function getBlogListWithSum($creator_id,$status,$page,$size,$count=null ,$order = null){
        $blogService=new BlogService();
        $blogList=$blogService->getBlogList($creator_id,$status,$page, $size,false,$order);
        return FactoryVMap::list_to_models($blogList,'home_blog_sum');
    }

    public static function getBlogListCount($creator_id,$status){
        $blogService=new BlogService();
        $count=$blogService->getBlogList($creator_id,$status,null,null,true);
        return $count;
    }
    /**
     *博客推荐列表
     * @param type $page
     * @param type $size
     * @return type 
     */
    public static function getBlogRecommendList($page,$size){
        $blogService=new BlogService();
        $blogList=$blogService->getBlogRecommendList($page,$size);
        return FactoryVMap::list_to_models($blogList,'home_blog_recommend');
    }
    public static function getBlogRecommendCount(){
        $blogService=new BlogService();
        $blogList=$blogService->getBlogRecommendList();
        return $blogList;
    }
    
    /**
     *获取发布排行榜
     * @return type 
     */
    public static function getReleaseList(){
        $blogService=new BlogService();
        $blogReleaseList=$blogService->getReleaseList();
        return FactoryVMap::list_to_models($blogReleaseList,'home_blog_release');
    }

    /**
     *获取发布排行榜
     * @param <int> $page 第几页
     * @param <int> $size 每页条数
     * @return <type>
     */
    public static function getCreatorByBlogCount($page,$size){
        $blogService=new BlogService();
        $creatorList=$blogService->getCreatorByBlogCount($page, $size,false);
        return FactoryVMap::list_to_models($creatorList,'home_blog_rank');
    }

    /**
     *获取指定时间段的热门Blog
     * @param <datetime> $start_time
     * @param <datetime> $end_time
     * @param <int> $page
     * @param <int> $size
     * @return <type>
     */
    public static function getHotBlogList($start_time,$end_time,$page,$size){
        $blogService=new BlogService();
        $blogList=$blogService->getHotBlogList($start_time, $end_time, $page, $size,false);
        return FactoryVMap::list_to_models($blogList,'home_blog');
    }

    public static function getHotBlogListCount($start_time,$end_time){
        $blogService=new BlogService();
        $count=$blogService->getHotBlogList($start_time, $end_time,null,null,true);
        return $count;
    }

    /**
     * 获取本周热文
     */
    public static function getHotBlogInWeek() {
        $start_time = date_f('Y-m-d H:i:s', strtotime('-7 days'));
        if(home_blog_page::getHotBlogList($start_time, null, 1, 10) && count(home_blog_page::getHotBlogList($start_time, null, 1, 10)) >= 10){
        	return home_blog_page::getHotBlogList($start_time, null, 1, 10);
        }else {
        	return home_blog_page::getHotBlogList(null, null, 1, 10);
        }
    }

    /**
     * 获取本月热文
     */
    public static function getHotBlogInMonth() {
        $start_time = date_f('Y-m-d H:i:s', strtotime('-30 days'));
        return home_blog_page::getHotBlogList($start_time, null, 1, 10);
    }

    /**
     *获取指定Creator最近发布的Blog
     * @param <type> $creator_id
     * @param <type> $size
     * @return <type>
     */
    public static function getLatestBlog($creator_id,$size){
        $blogService=new BlogService();
        $blogList=$blogService->getLatestBlog($creator_id, $size);
        return FactoryVMap::list_to_models($blogList,'home_blog');
    }
}
?>
