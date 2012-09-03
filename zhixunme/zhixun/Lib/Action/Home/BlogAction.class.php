<?php

/**
 * Module:022
 */
class BlogAction extends BaseAction {

    /**
     * 创建Blog00010
     */
    public function do_createBlog() {
        if (!$this->is_legal_request()) {
            return;
        }
        $creator_id = AccountInfo::get_user_id();
        $title = $_POST['title'];
        $body = $_POST['body'];
        $status = $_POST['status'];
        $source = trim($_POST['src']); //心得来源
        $blogService = new BlogService();
        $result = $blogService->createBlog($creator_id, $title, $body, $status, $source);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true, $result);
        }
    }

    /**
     * 删除Blog00010
     */
    public function do_deleteBlog() {
        if (!$this->is_legal_request()) {
            return;
        }
        $creator_id = AccountInfo::get_user_id();
        $blog_id = $_POST['blog_id'];
        $blogService = new BlogService();
        $result = $blogService->deleteBlog($creator_id, $blog_id);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true, $result);
        }
    }

    /**
     * 更新Blog00010
     */
    public function do_updateBlog() {
        if (!$this->is_legal_request()) {
            return;
        }
        $blog_id = $_POST['blog_id'];
        $creator_id = AccountInfo::get_user_id();
        $title = $_POST['title'];
        $body = $_POST['body'];
        $status = $_POST['status'];
        $source = trim($_POST['src']);
        $blogService = new BlogService();
        $result = $blogService->updateBlog($creator_id, $blog_id, $title, $body, $status,$source);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true, $result);
        }
    }

    /**
     * 提交审核Blog00010
     */
    public function do_askForValidateBlog() {
        if (!$this->is_legal_request()) {
            return;
        }
        $creator_id = AccountInfo::get_user_id();
        $blog_id = $_POST['blog_id'];
        $status = 2;

        $blogService = new BlogService();
        $result = $blogService->updateBlogStatus($creator_id, $blog_id, $status);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true, $result);
        }
    }

    /**
     * 获取Blog列表00010
     */
    public function get_ownBlogList() {
        if (!$this->is_legal_request()) {
            return;
        }
        $creator_id = AccountInfo::get_user_id();
        $page = $_POST['page'];
        $size = $_POST['size'];
        $status = $_POST['status'];
        $result = home_blog_page::getBlogList($creator_id, $status, $page, $size);
        if (empty($result)) {
            echo jsonp_encode(false);
        } else {
            echo jsonp_encode(true, $result, home_blog_page::getBlogListCount($creator_id, $status));
        }
    }

    /**
     * 获取所有Blog列表11111
     */
    public function get_blogList() {
        if (!$this->is_legal_request()) {
            return;
        }
        $page = $_POST['page'];
        $size = $_POST['size'];
        $result = home_blog_page::getBlogListWithSum(null, 3, $page, $size);
        if (empty($result)) {
            echo jsonp_encode(false);
        } else {
            echo jsonp_encode(true, $result, home_blog_page::getBlogListCount(null, 3));
        }
    }

    /**
     * 获取发布排行榜11111
     */
    public function get_creatorRankList() {
        if (!$this->is_legal_request()) {
            return;
        }
        $page = $_POST['page'];
        $size = $_POST['size'];
        $result = home_blog_page::getCreatorByBlogCount($page, $size);
        if (empty($result)) {
            echo jsonp_encode(false);
        } else {
            echo json_encode(true, $result);
        }
    }

    /**
     * 获取一周或一月的热文11111
     */
    public function get_HotBlogList() {
        if (!$this->is_legal_request()) {
            return;
        }
        $type = $_POST['type'];
        $start_time = null;
        if ($type == 1) {
            //一周
            //$w = date_f('w', time());
            //$x = $w?$w-1:6;
            //$start_time=date_f('Y-m-d', strtotime('-'.$x.' days')).' 00:00:00';
            $start_time = date_f('Y-m-d H:i:s', strtotime('-7 days'));
        } else if ($type == 2) {
            //一月
            //$start_time=date_f('Y-m-d H:i:s', mktime(0,0,0,date('m'),1,date('Y')));
            $start_time = date_f('Y-m-d H:i:s', strtotime('-30 days'));
        }
        $page = $_POST['page'];
        $size = $_POST['size'];
        $result = home_blog_page::getHotBlogList($start_time, null, $page, $size);
        if (empty($result)) {
            echo jsonp_encode(false);
        } else {
            echo jsonp_encode(true, $result, home_blog_page::getHotBlogListCount($start_time, null));
        }
    }

}

?>
