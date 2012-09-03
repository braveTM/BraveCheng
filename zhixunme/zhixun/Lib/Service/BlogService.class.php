<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BlogService
 *
 * @author JZG
 */
class BlogService {
    //put your code here

    /**
     * 创建Blog
     * @param <type> $creator_id
     * @param <type> $title
     * @param <type> $body
     * @param <int> $status
     * @return <type>
     */
    public function createBlog($creator_id, $title, $body, $status, $source) {
        $data = array(
            'creator_id' => $creator_id,
            'title' => $title,
            'body' => $body,
            'status' => $status,
            'source' => $source,
        );
        if ($status != 1 && $status != 2) {
            return E(ErrorMessage::$BLOG_STATUS_INVALID);
        }
        $blogProvider = new BlogProvider();
        $data = argumentValidate($blogProvider->blogArgRule, $data);
        if (is_zerror($data)) {
            return $data;
        }
        while (true) {                                        //生成唯一主键
            $id = build_id();
            $temp = $blogProvider->getBlog($id);
            if (empty($temp))
                break;
        }
        $data['blog_id'] = $id;
        $blog_id = $blogProvider->addBlog($data);
        if (!$blog_id) {
            return E(ErrorMessage::$OPERATION_FAILED);
        } else {
            //ExperienceCrmService::add_experience_post_office($creator_id);  //调用经验模块增加经验
            return $blog_id;
        }
    }

    /**
     * 修改Blog
     * @param <type> $blog_id
     * @param <type> $title
     * @param <type> $body
     * @param <type> $status
     */
    public function updateBlog($creator_id, $blog_id, $title, $body, $status, $source) {
        $blogProvider = new BlogProvider();
        if (!$blogProvider->isOwnBlog($creator_id, $blog_id)) {
            return E(ErrorMessage::$BLOG_NOT_OWN);
        }
        if ($status != 1 && $status != 2) {
            return E(ErrorMessage::$BLOG_STATUS_INVALID);
        }

        $blog = $blogProvider->getBlog($blog_id);
        if ($blog['status'] == 2) {
            return E(ErrorMessage::$BLOG_STATUS_INVALID);
        }


        $data = array(
            'title' => $title,
            'body' => $body,
            'status' => $status,
            'source' => $source,
        );
        $data = argumentValidate($blogProvider->blogArgRule, $data);
        if (is_zerror($data)) {
            return $data;
        }
        $result = $blogProvider->updateBlog($blog_id, $data);
        if (!$result) {
            return E(ErrorMessage::$OPERATION_FAILED);
        } else {
            return true;
        }
    }

    /**
     * 删除Blog
     * @param <type> $creator_id
     * @param <type> $blog_id
     * @return <type> 
     */
    public function deleteBlog($creator_id, $blog_id) {
        $blogProvider = new BlogProvider();
        if (!$blogProvider->isOwnBlog($creator_id, $blog_id)) {
            return E(ErrorMessage::$BLOG_NOT_OWN);
        }
        $data = array(
            'is_del' => 1
        );

        $result = $blogProvider->updateBlog($blog_id, $data);
        if ($result) {
            return true;
        } else {
            return E(ErrorMessage::$OPERATION_FAILED);
        }
    }

    /**
     * 获取Blog
     * @param <type> $blog_id
     */
    public function getBlog($blog_id) {
        $blogProvider = new BlogProvider();
        return $blogProvider->getBlog($blog_id);
    }

    /**
     * 获取Blog列表
     * @param <type> $creator_id
     * @param <type> $page
     * @param <type> $size
     */
    public function getBlogList($creator_id, $status, $page, $size, $count, $order = null) {
        $blogProvider = new BlogProvider();
        return $blogProvider->getBlogList($creator_id, $status, null, null, $page, $size, $count, $order);
    }

    /**
     * 获取指定creator最近发布的Blog
     * @param <type> $creator_id
     * @param <type> $size
     */
    public function getLatestBlog($creator_id, $size) {
        $blogProvider = new BlogProvider();
        return $blogProvider->getBlogList($creator_id, 3, null, null, 1, $size, false, 'blog.update_datetime desc');
    }

    /**
     * 获取指定时间段的热门Blog
     * @param <type> $start_time
     * @param <type> $end_time
     * @param <type> $page
     * @param <type> $size
     * @param <type> $count
     * @return <type>
     */
    public function getHotBlogList($start_time, $end_time, $page, $size, $count) {
        $blogProvider = new BlogProvider();
        return $blogProvider->getBlogList(null, 3, $start_time, $end_time, $page, $size, $count, 'blog.read_count desc');
    }

    /**
     * 更新Blog状态
     * @param <type> $creator_id
     * @param <type> $blog_id
     * @param <type> $status
     * @return <type>
     */
    public function updateBlogStatus($creator_id, $blog_id, $status) {
        $blogProvider = new BlogProvider();
        if (!$blogProvider->isOwnBlog($creator_id, $blog_id)) {
            return E(ErrorMessage::$BLOG_NOT_OWN);
        }
        $data = array(
            'status' => $status,
        );
        $result = $blogProvider->updateBlog($blog_id, $data);
        if ($result) {
            return true;
        } else {
            return E(ErrorMessage::$OPERATION_FAILED);
        }
    }

    /**
     * 判断是否是指定创建人拥有的Blog
     * @param <type> $creator_id
     * @param <type> $blog_id
     * @return <type>
     */
    public function isOwnBlog($creator_id, $blog_id) {
        $blogProvider = new BlogProvider();
        if (!$blogProvider->isOwnBlog($creator_id, $blog_id)) {
            return E(ErrorMessage::$BLOG_NOT_OWN);
        } else {
            return true;
        }
    }

    /**
     * 判断是否是审核的Blog
     * @param <type> $blog_id
     */
    public function isAuditBlog($blog_id) {
        $blogProvider = new BlogProvider();
        $blog = $blogProvider->getBlog($blog_id);
        if (!empty($blog)) {
            $status = $blog['status'];
            if ($status != 3) {
                return E(ErrorMessage::$BLOG_NOT_AUDIT);
            }
        } else {
            return E(ErrorMessage::$BLOG_NOT_EXIST);
        }
    }

    /**
     * 添加阅读数
     * @param <type> $blog_id
     * @return <type>
     */
    public function addReadCount($blog_id) {
        $blogProvider = new BlogProvider();
        $blog = $blogProvider->getBlog($blog_id);
        $read_count = intval($blog['read_count']) + 1;
        $data = array(
            'read_count' => $read_count,
        );
        $result = $blogProvider->updateBlog($blog_id, $data);
        if ($result) {
            return true;
        } else {
            return E(ErrorMessage::$OPERATION_FAILED);
        }
    }

    /**
     * 获取Blog发布排行列表
     * @param <type> $page
     * @param <type> $size
     * @param <type> $count
     * @return <type> 
     */
    public function getCreatorByBlogCount($page, $size, $count) {
        $blogProvider = new BlogProvider();
        return $blogProvider->getCreatorByBlogCount($page, $size, $count);
    }

    public function getNextPreBlog($blog_id) {
        $blogProvider = new BlogProvider();
        $preBlog = $blogProvider->getPreBlog($blog_id);
        $nextBlog = $blogProvider->getNextBlog($blog_id);
        $preNextBlog['preBlog'] = $preBlog;
        $preNextBlog['nextBlog'] = $nextBlog;
        return $preNextBlog;
    }

    /**
     * 赞一下
     * @param <type> $creator_id
     * @param <type> $blog_id
     * @param <type> $status
     * @return <type>
     */
    public function updateBlogPraise($blog_id) {
        $blogProvider = new BlogProvider();
        $blog = $blogProvider->getBlog($blog_id);
        $praise = intval($blog['praise']) + 1;
        $data = array(
            'praise' => $praise,
        );
        $result = $blogProvider->updateBlog($blog_id, $data);
        if ($result) {
            //发送通知邮件
            $args=array(
                '[blog_title]'=>$blog['title'],
                '[blog_link]'=>C('WEB_ROOT').'/article/1/'.$blog['blog_id']
                );
            $notifyService=new NotifyService();
            $notifyService->fillCommonArgs($args,$blog['creator_id'], null);
            $userService=new UserService();
            $user=$userService->get_user($blog['creator_id']);
            email_send($user['email'], 27, $user['user_id'], null, $args);
            return true;
        } else {
            return E(ErrorMessage::$OPERATION_FAILED);
        }
    }

    /**
     * 返回推荐列表 
     */
    public function getBlogRecommendList($page = null, $size = null) {
        $blogProvider = new BlogProvider();
        $result = $blogProvider->getBlogRecommendList($page, $size);
        return $result;
    }

    /**
     * 发布排行榜
     * @return type 
     */
    public function getReleaseList() {
        $blogProvider = new BlogProvider();
        $blogReleaseList = $blogProvider->getReleaseList();
        return $blogReleaseList;
    }

    /**
     * 统计经纪人的发布文章数
     * @param int $user_id 用户编号
     * @param string $start 开始时间
     * @param string $end 结束时间
     * @param int $type 统计类型（1文章数2文章被赞数3文章阅读数）
     * @return int
     */
    public function count_user_blogs($user_id, $start, $end, $type) {
        $blogProvider = new BlogProvider();
        return $blogProvider->count_user_blogs($user_id, $start, $end, $type);
    }

    /**
     * 统计用户心得被阅读次数
     * @param int $user_id 用户编号
     * @param string $start 开始时间
     * @param string $end 结束时间
     * @return int 
     */
    public function count_blog_read($user_id, $start, $end) {
        $blogProvider = new BlogProvider();
        return $blogProvider->count_blog_read($user_id, $start, $end);
    }

    /**
     * 统计用户心得被赞次数
     * @param int $user_id 用户编号
     * @param string $start 开始时间
     * @param string $end 结束时间
     * @return int 
     */
    public function count_blog_praise($user_id, $start, $end) {
        $blogProvider = new BlogProvider();
        return $blogProvider->count_blog_praise($user_id, $start, $end);
    }

    /**
     * 添加文章阅读记录
     * @param int $user_id 用户编号
     * @param int $client_ip 客户端IP
     * @param int $blog_id 文章编号
     * @param string $date 日期
     * @return bool
     */
    public function add_read_record($user_id, $client_ip, $blog_id, $date) {
        $blogProvider = new BlogProvider();
        if (!$blogProvider->add_read_record($user_id, $client_ip, $blog_id, $date)) {
            return E();
        }
        return true;
    }

    /**
     * 添加文章被赞记录
     * @param int $user_id 用户编号
     * @param int $client_ip 客户端IP
     * @param int $blog_id 文章编号
     * @param string $date 日期
     * @return bool
     */
    public function add_praise_record($user_id, $client_ip, $blog_id, $date) {
        $blogProvider = new BlogProvider();
        if (!$blogProvider->add_praise_record($user_id, $client_ip, $blog_id, $date)) {
            return E();
        }
        return true;
    }

    /**
     * 统计用户文章被阅读次数
     * @param int $user_id 用户编号
     * @param string $start 开始时间
     * @param string $end 结束时间
     * @return int
     */
    public function count_user_blog_readed($user_id, $start, $end) {
        $provider = new BlogProvider();
        return $provider->count_user_blog_readed($user_id, $start, $end);
    }

    /**
     * 统计用户文章被赞次数
     * @param int $user_id 用户编号
     * @param string $start 开始时间
     * @param string $end 结束时间
     * @return int
     */
    public function count_user_blog_praised($user_id, $start, $end) {
        $provider = new BlogProvider();
        return $provider->count_user_blog_praised($user_id, $start, $end);
    }

}

?>
