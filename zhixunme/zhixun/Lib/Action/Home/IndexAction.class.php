<?php

header('content-type:text/html;charset=utf-8');

/**
 * Module:001
 */
class IndexAction extends BaseAction {

    //----------------页面---------------
    /**
     * 首页10000
     */
    public function index() {
        $redirect = empty($_GET['redirect']) ? C('WEB_ROOT') : var_validation($_GET['redirect'], VAR_STRING, OPERATE_FILTER);
        $this->assign('redirect', $redirect);
        $this->assign('human', home_index_index_page::get_recommend_human(5));
        $this->assign('company', home_index_index_page::get_recommend_company(10));
        $this->assign('agent', home_index_index_page::get_recommend_agent(8));
        $this->assign('article', home_article_index_page::get_articles(11, 1, 8));
        $this->assign('blog', home_blog_page::getLatestBlog(null, 4));
        $jobService = new JobService();
        //热门关键词
        $this->assign('hot_keyword', $jobService->getSearchHotKeyword());
        //热点招聘职位
        $this->assign('left_hot_job', home_job_index_page::searchJob(null, null, null, null, null, null, null, 1, 5, 1));
        $this->assign('right_hot_job', home_job_index_page::searchJob(null, null, null, null, null, null, null, 2, 5, 1));
        //新增职位数
        $new_job_count_base = DataCache::get('new_job_count_base'.date_f('Ymd'));
        $addup = DataCache::get('job_addup');
        $new_job_count=DataCache::get('new_job_count');
        if (empty($new_job_count_base)) {
            $new_job_count_base = rand(500, 1000);
            $new_job_count=$new_job_count_base;
            DataCache::set('new_job_count_base'.date_f('Ymd'), $new_job_count_base, 24 * 3600);
            DataCache::set('new_job_count', $new_job_count, 30* 3600);
        }
        if (empty($addup)) {
            $addup=rand(1, 10);
            $new_job_count+=$addup;
            DataCache::set('job_addup', $addup, 180*rand(1,3));
            DataCache::set('new_job_count', $new_job_count, 30 * 3600);
        }
        $this->assign('new_job_count', $new_job_count);
        //新增简历数
        $new_resume_count_base = DataCache::get('new_resume_count_base'.date_f('Ymd'));
        $addup = DataCache::get('resume_addup');
        $new_resume_count=DataCache::get('new_resume_count');
        if (empty($new_resume_count_base)) {
            $new_resume_count_base = rand(2000, 4000);
            $new_resume_count=$new_resume_count_base;
            DataCache::set('new_resume_count_base'.date_f('Ymd'), $new_resume_count_base, 24 * 3600);
            DataCache::set('new_resume_count', $new_resume_count, 30 * 3600);
        }
        if (empty($addup)) {
            $addup=rand(1, 10);
            $new_resume_count+=$addup;
            DataCache::set('resume_addup', $addup, 300*rand(1,3));
            DataCache::set('new_resume_count', $new_resume_count, 30 * 3600);
        }
        $this->assign('new_resume_count', $new_resume_count);
        $this->display();
    }

    /**
     * 找人才10000
     */
    public function talents() {
        $this->display();
    }

    /**
     * 找企业10000
     */
    public function enterprise() {
        $this->assign('company', home_index_company_page::get_company_wall());
        $this->display();
    }

    /**
     * 登录页面10000 
     */
    public function login() {
        $redirect = empty($_GET['redirect']) ? C('WEB_ROOT') : var_validation($_GET['redirect'], VAR_STRING, OPERATE_FILTER);
        $this->assign('redirect', $redirect);
        $this->display();
    }

    /**
     * 企业登录页面10000
     */
    public function clogin() {
        $redirect = empty($_GET['redirect']) ? C('WEB_ROOT') : var_validation($_GET['redirect'], VAR_STRING, OPERATE_FILTER);
        $this->assign('redirect', $redirect);
        $this->display();
    }

    //----------------动作---------------
    /**
     * 获取人才列表10000
     */
    public function get_talents() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $data = home_index_index_page::get_talents($_POST['page'], $_POST['size']);
        if (empty($data))
            echo jsonp_encode(false);
        else
            echo jsonp_encode(true, $data, home_index_index_page::get_talents_count());
    }

    /**
     * 获取企业列表10000
     */
    public function get_enterprise() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $data = home_index_index_page::get_job($_POST['page'], $_POST['size']);
        if (empty($data))
            echo jsonp_encode(false);
        else
            echo jsonp_encode(true, $data, home_index_index_page::get_job_count());
    }

    /**
     * 获取任务大厅列表10000
     */
    public function get_tasks() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $data = home_index_index_page::get_tasks($_POST['page'], $_POST['size']);
        if (empty($data))
            echo jsonp_encode(false);
        else
            echo jsonp_encode(true, $data, home_index_index_page::get_tasks_count());
    }

    /**
     * Ta发布了11111
     */
    public function get_tpost() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $data = home_index_index_page::it_post();
        if (empty($data))
            echo jsonp_encode(false);
        else
            echo jsonp_encode(true, $data);
        //示例数据格式
        //({"ret":true,"data":[{"tid":"1","ttitle":"task1","turl":"http://localhost/1","cid":"4","ctitle":"求职招聘测试1","curl":"http://localhost/4","uid":"8","uname":"moi_liu","uurl":"http://localhost/8","date":"1秒前"},{"tid":"2","ttitle":"task1","turl":"http://localhost/2","cid":"4","ctitle":"求职招聘测试1","curl":"http://localhost/4","uid":"8","uname":"moi_liu","uurl":"http://localhost/8","date":"22秒前"}]});
    }

    /**
     * Ta中标了11111
     */
    public function get_tbid() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $data = home_index_index_page::it_bid();
        if (empty($data))
            echo jsonp_encode(false);
        else
            echo jsonp_encode(true, $data);
        //示例数据格式
        //({"ret":true,"data":[{"tid":"2","ttitle":"task1","turl":"http://localhost/2","cid":"4","ctitle":"求职招聘测试1","curl":"http://localhost/4","uid":"10","uname":"ytl","uurl":"http://localhost/10","date":"28分钟前"},{"tid":"5","ttitle":"task4","turl":"http://localhost/5","cid":"4","ctitle":"求职招聘测试1","curl":"http://localhost/4","uid":"10","uname":"ytl","uurl":"http://localhost/10","date":"28分钟前"}]});
    }

    /**
     * 获取指定父标签的子标签数据11111
     */
    public function get_labels() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $data = home_common_front_page::get_labels($_POST['pid']);
        if (empty($data))
            echo jsonp_encode(false);
        else
            echo jsonp_encode(true, $data);
        //示例数据格式
        //({"ret":true,"data":[{"id":"13","name":"建筑工程专业","icon":""},{"id":"14","name":"公路工程","icon":""},{"id":"15","name":"铁路工程","icon":""},{"id":"16","name":"民航机场工程","icon":""},{"id":"17","name":"港口与航道工程","icon":""},{"id":"18","name":"水利水电工程","icon":""},{"id":"19","name":"机电工程","icon":""},{"id":"20","name":"矿业工程","icon":""},{"id":"21","name":"市政公用工程","icon":""},{"id":"22","name":"通讯与广电工程","icon":""}]});
    }

    /**
     * 用户上传头像11111
     */
    public function do_upload_photo() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        require_cache(APP_PATH . '/Common/Function/file.php');
        $result = file_upload('file_name', get_user_path_root(AccountInfo::get_user_id()) . get_user_path_photo(), 'IMAGE');
        if (is_int($result)) {
            echo "<script type=\"text/javascript\">window.parent.avatarRender.g(\"上传失败\")</script>";
            //echo jsonp_encode(false, $result);
        } else {
            require_cache(APP_PATH . '/Common/Function/image.php');
            $info = get_image_info($result);
            echo "<script type=\"text/javascript\">window.parent.avatarRender.c({url:'" . C('FILE_ROOT') . $result . "',width:" . $info["width"] . ",height:" . $info["height"] . "})</script>";
            //echo jsonp_encode(true, $result);
        }
    }

    /**
     * 用户上传认证文件01111
     */
    public function do_upload_identify() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        require_cache(APP_PATH . '/Common/Function/file.php');
        $result = file_upload('file_name', get_user_path_root(AccountInfo::get_user_id()) . get_user_path_identify(), 'IMAGE');
        if (is_int($result)) {
            echo "<script type=\"text/javascript\">window.parent.accountRender.upfail(\"上传失败\")</script>";
        } else {
            require_cache(APP_PATH . '/Common/Function/image.php');
            //$res = image_compress(C('IMAGE_NORMAL_MAX_W'), C('IMAGE_NORMAL_MAX_H'), $result);
            $res = $result;
            if (!$res) {
                echo "<script type=\"text/javascript\">window.parent.accountRender.upfail(\"上传失败\")</script>";
                return;
            }
            echo "<script type=\"text/javascript\">window.parent.accountRender.upsuccess(" . $_POST['type'] . ",\"" . $result . "\")</script>";
        }
    }

}

?>
