<?php
/**
 * Module:021
 */
class InformationAction extends BaseAction{
    /**
     * 资讯首页11111 
     */
    public function index(){
        $page=1;
        $size=6;
        if(AccessControl::is_logined()){
            $usvc = new UserService();
            $user = $usvc->get_user(AccountInfo::get_user_id());
            $this->assign('user',$user);
        }
        //最新职场热文
        $this->assign('newBlog',home_blog_page::getBlogListWithSum(null, 3, $page, 4,FALSE,$order="update_datetime desc"));
         //本周热门资讯
        $hot_blog_in_week=home_blog_page::getHotBlogInWeek();
        foreach($hot_blog_in_week as $key=>$value){
            $hot_blog_in_week[$key]->number=$key+1;
        }
        $this->assign('hot_blog_in_week',$hot_blog_in_week);
        //发布排行榜
        $this->assign('releaseblog',home_blog_page::getReleaseList());
        //推荐职场经验
        $this->assign('recommendblog',home_blog_page::getBlogRecommendList($page, 9));
        //培训资讯
        $this->assign('trainArt',home_article_index_page::get_articles_kaozhen(12, $page, 9, '', '', '', '', "sort asc,edit_date desc"));
        //建筑行业资讯
        $this->assign('industryArt',home_article_index_page::get_articles(11, $page, 4, '', '', '', '', "sort asc,edit_date desc"));
        //公示公告
        $this->assign('publicityArt',home_article_index_page::get_articles(8, $page, 10, '', '', '', '', "sort asc,edit_date desc"));
        //帮助中心
        $this->assign('helpArt',home_article_index_page::get_articles(13, $page, 10, '', '', '', '', "sort asc,edit_date desc"));
        //政策法规
        $this->assign('policyArt',home_article_index_page::get_articles(10, $page, 8, '', '', '', '', "sort asc,edit_date desc"));
        //文件通知
        $this->assign('fileArt',home_article_index_page::get_articles(9, $page, 8, '', '', '', '', "sort asc,edit_date desc"));
        //媒体报道
        $this->assign('mediaArt', home_article_index_page::get_articles(14, $page, 5, '', '', '', '', "sort asc,edit_date desc"));

        $this->assign('pub_show', AccountInfo::get_role_id() == C('ROLE_AGENT') ? 1 : 0);
        $this->display('Blog:infoIndex');
    }

    /**
     * 资讯列表页11111
     */
    public function infoListIndex(){
        if($_GET['user_id'] != 0){
            $usvc = new UserService();
            $user = $usvc->get_user($_GET['user_id']);
            if(empty($user) || $user['role_id'] != C('ROLE_AGENT')){
                redirect(C('ERROR_PAGE'));              //用户不存在或者不为经纪人
            }
            $data = FactoryVMap::array_to_model($user, 'home_user_base');
            $this->assign('data',$data);
            $this->assign('user_id',$_GET['user_id']);
            $page=1;    
            if (!empty($_GET['art_blog'])){
                    $page=$_GET['art_blog'];
            }
            $blog_list=home_blog_page::getBlogListWithSum($_GET['user_id'], 3,$page, 6,FALSE,$order="update_datetime desc");
            $count=home_blog_page::getBlogListCount($_GET['user_id'], 3);
            $this->assign('blog_list', $blog_list);
            $this->assign('count', $count);
            $this->assign('page', $page);
            $this->assign('url',1);
            $this->assign('link_pre',C('WEB_ROOT').'/articles/'.$_GET['user_id'].'/');
            $this->assign('sub_title',  info_sub_title_format($data->name,null, null));
        }elseif($_GET['art_blog'] != ''){
             $page=1;
             $data=null;
             $count=0;
             $class_id=0;
             $url=1;
            if($_GET['art_blog'] == 1){   //blog
                if (!empty($_GET['class_id'])){
                    $page=$_GET['class_id'];
                }
                $data= home_blog_page::getBlogListWithSum(null, 3, $page,6,FALSE,$order="update_datetime desc");
                $count=home_blog_page::getBlogListCount(null, 3);
            }elseif($_GET['art_blog'] == 2) {   //article
                if (!empty($_GET['page'])){
                    $page=$_GET['page'];
                }
                if ($_GET['class_id']!=0) {
                    $class_id = $_GET['class_id'];
                    $order = "sort asc,edit_date desc";
                    $sub_title='';
                } else {
                    $order = "read_count desc";
                }
                $url=0;
                $data = home_article_index_page::get_articles($class_id,$page,6, '', '', '', '', $order);
                $count=home_article_index_page::get_articles_count($class_id);
            }elseif($_GET['art_blog'] == 3) {   //article
                if (!empty($_GET['class_id'])){
                    $page=$_GET['class_id'];
                }
                $data=home_blog_page::getBlogRecommendList($page, 6);
                $count=home_blog_page::getBlogRecommendCount();
            }elseif($_GET['art_blog'] == 4){
                if (!empty($_GET['class_id'])){
                    $page=$_GET['class_id'];
                }
                $data=home_blog_page::getBlogListWithSum(null, 3, $page,6,FALSE,$order="read_count desc");
                $count = home_blog_page::getBlogListCount(null, 3);
            }else{
                redirect(C('ERROR_PAGE'));              //资讯类型参数错误
            }
            $this->assign('art_blog',$_GET['art_blog']); //类型(1-最新职场热文(职场经验),2-资讯,3-推荐职场经验,4-热门职场经验)
            $this->assign('class_id', $class_id);
            $this->assign('blog_list',$data);                 //数据
            $this->assign('count',$count);               //总条数
            $this->assign('page',$page);                 //第几页   
            $this->assign('url',$url);                   //1-职场经验，0-资讯   
            if ($_GET['art_blog'] == 2){                 //链接前缀
                $this->assign('link_pre',C('WEB_ROOT').'/articles/0/2/'.$class_id.'/');
            }else{
                $this->assign('link_pre',C('WEB_ROOT').'/articles/0/'.$_GET['art_blog'].'/');
            }
            $this->assign('sub_title',  info_sub_title_format(null,$_GET['art_blog'], $class_id));
        }
        if(AccessControl::is_logined()){
            $usvc = new UserService();
            $user = $usvc->get_user(AccountInfo::get_user_id());
            $this->assign('user',$user);
        }
        $page=1;
        $size=8;
        $this->assign('hotblog',home_blog_page::getBlogListWithSum(null, 3, $page, $size,FALSE,$order="read_count desc"));
        $this->assign('recommendblog',home_blog_page::getBlogRecommendList($page, $size));
        $this->assign('hotInfo',home_article_index_page::get_articles('', $page, $size, '', '', '', '', "read_count desc"));
        
        $this->display('Blog:infoListIndex');
    }

    /**
     * 资讯详细页11111
     */
    public function infoDetailIndex(){
        $page=1;
        $size=8;
        $this->assign('hotblog',home_blog_page::getBlogListWithSum(null, 3, $page, $size,FALSE,$order="read_count desc"));
        $this->assign('recommendblog',home_blog_page::getBlogRecommendList($page, $size));
        $this->assign('hotInfo',home_article_index_page::get_articles('', $page, $size, '', '', '', '', "read_count desc"));
        
        $is_blog=$_GET['is_blog'];
        if ($is_blog){
            $this->isblog=1;
            $blog_id=$_GET['blog_id'];
            $blog=home_blog_page::getBlog($blog_id);
            if (is_zerror($blog)){
                redirect(C('ERROR_PAGE'));
            }
            $blogService = new BlogService();
            $nextPreBlog = $blogService->getNextPreBlog($blog_id);
            $agent=home_agent_account_page::get_agent_detail($blog->creator_id);
            $blog->name=$agent->name;
            $this->assign('information',$blog);
            $this->assign('nextBlog',$nextPreBlog['nextBlog']);
            $this->assign('preBlog',$nextPreBlog['preBlog']);
            $this->assign('agent',$agent);
            
            //十分钟以内同一人访问该页面不增加该文章的阅读次数
            $cache_key = 'infodetail_blog_'.get_client_ip().'_00'.$_GET['blog_id'];
            if(!DataCache::get($cache_key)){
                $blogService=new BlogService();
                $blogService->addReadCount($blog_id);
                $blogService->add_read_record(AccountInfo::get_user_id(), get_client_ip(), $blog_id, date_f());
                DataCache::set($cache_key, '1', 600);
            }
        }else{
            $this->isblog=0;
            $info_id=$_GET['blog_id'];
            $this->assign('information',  home_article_index_page::get_article($info_id));
            $artService = new ArticleService;
            $nextPreArt = $artService->getNextPreArt($info_id);
            $this->assign('nextArt',$nextPreArt['nextArt']);
            $this->assign('preArt',$nextPreArt['preArt']);
            //十分钟以内同一人访问该页面不增加该文章的阅读次数
            $cache_key = 'infodetail_article_'.get_client_ip().'_00'.$_GET['blog_id'];
            if(!DataCache::get($cache_key)){
                $service = new ArticleService();
                $service->add_read_count($info_id);
                DataCache::set($cache_key, '1', 600);
            }
        }
        if(AccessControl::is_logined()){
            $usvc = new UserService();
            $user = $usvc->get_user(AccountInfo::get_user_id());
            $this->assign('user',$user);
        }
        $this->display('Blog:infoDetailIndex');
    }

    /**
     * 获取网站资讯列表11111
     */
    public function get_info_list(){
        if (!$this->is_legal_request()){
            return;
        }
        if($_POST['class_id']){
            $class_id = $_POST['class_id'];
            //$order = "art_id desc";
            $order = "sort asc,edit_date desc";
        }else{
            $order = "read_count desc";
        }
        $data = home_article_index_page::get_articles($class_id, $_POST['page'], $_POST['size'], '', '', '', '', $order);
        if(empty($data)){
            echo jsonp_encode(false);
        }
        else{
            $count = home_article_index_page::get_articles_count($class_id);
            echo jsonp_encode(true, $data,$count);
        }
    }
    
    /**
     * 获取网站心得推荐11111
     */
    public function get_blogrecommend_list(){
        if (!$this->is_legal_request()){
            return;
        }
        $data = home_blog_page::getBlogRecommendList($_POST['page'], $_POST['size']);
        if(empty($data)){
            echo jsonp_encode(false);
        }else{
            $count = home_blog_page::getBlogRecommendCount();
            echo jsonp_encode(true, $data, $count);
        }
    }
    
    /**
     * 获取网站资讯列表11111
     */
    public function get_bloghot_list(){
        if (!$this->is_legal_request()){
            return;
        }
        $data = home_blog_page::getBlogListWithSum(null, 3, $_POST['page'], $_POST['size'],FALSE,$order="read_count desc");
        if(empty($data)){
            echo jsonp_encode(false);
        }
        else{
            $count = home_blog_page::getBlogListCount(null, 3);
            echo jsonp_encode(true, $data, $count);
        }
    }
    
    /**
     * 获取网站资讯列表11111
     */
    public function get_blogagent_list(){
        if (!$this->is_legal_request()){
            return;
        }
        $data = home_blog_page::getBlogListWithSum($_POST['user_id'], 3, $_POST['page'], $_POST['size'],FALSE,$order="update_datetime desc");
        if(empty($data)){
            echo jsonp_encode(false);
        }
        else{
            $count = home_blog_page::getBlogListCount($_POST['user_id'], 3);
            echo jsonp_encode(true, $data, $count);
        }
    }
    
     /**
     * 获取网站资讯列表11111
     */
    public function get_blognew_list(){
        if (!$this->is_legal_request()){
            return;
        }
        $data = home_blog_page::getBlogListWithSum(null, 3, $_POST['page'], $_POST['size'],FALSE,$order="update_datetime desc");
        if(empty($data)){
            echo jsonp_encode(false);
        }
        else{
            $count = home_blog_page::getBlogListCount(null, 3);
            echo jsonp_encode(true, $data, $count);
        }
    }
    
    /**
     *行业资讯赞一下11111
     */
    public function do_Article_Praise(){
        if (!$this->is_legal_request()){
            return;
        }
        $art_id = $_POST['art_id'];
        $cache_key = 'praise_article_'.get_client_ip().'_00'.$art_id;
        if(!DataCache::get($cache_key)){
            $articleService = new ArticleService();
            $articleService->add_praise($art_id);
            DataCache::set($cache_key, '1', 600);
            echo jsonp_encode(TRUE);
        }else{
            echo jsonp_encode(false);
        }
       
    }
    
    /**
     * 经纪人心得赞一下11111
     */
    public function do_Blog_Praise(){
        if (!$this->is_legal_request()){
            return;
        }
        $blog_id = $_POST['blog_id'];
        $cache_key = 'praise_blog_'.get_client_ip().'_00'.$blog_id;
        if(!DataCache::get($cache_key)){
            $blogService = new BlogService();
            $blogService->updateBlogPraise($blog_id);
            $blogService->add_praise_record(AccountInfo::get_user_id(), get_client_ip(), $blog_id, date_f());
            DataCache::set($cache_key, '1', 600);
            echo jsonp_encode(true);
        }else{
            echo jsonp_encode(false);
        }
    }
    
}

?>
