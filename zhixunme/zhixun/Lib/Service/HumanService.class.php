<?php
/**
 * Description of HumanService
 *
 * @author JZG
 */
class HumanService {
    //----------------private-------------------
    private $provider;

    //----------------public--------------------
    public function  __construct() {
        $this->provider = new HumanProvider();
    }

    /**
     * 添加人才资料
     * @param <string> $name   姓名
     * @param <int>    $gender 性别（0女，1男）
     * @param <string> $birth  生日
     * @param <int>    $pid    省份编号
     * @param <int>    $cid    城市编号
     * @param <string> $phone  手机
     * @param <string> $qq     QQ
     * @param <string> $email  邮箱
     * @return <mixed> 成功返回人才信息编号，失败返回ZERROR
     */
    public function add_human($name, $gender, $birth, $pid, $cid, $phone, $qq, $email){
        if(!var_validation($name, VAR_NAME)){           //姓名格式错误
            return E(ErrorMessage::$NAME_FORMAT_ERROR);
        }
        $this->provider->trans();                       //事务开启
        $service = new ResumeService();
        $result  = $service->createResume();            //添加人才简历
        if(is_zerror($result)){
            $this->provider->rollback();                //事务回滚
            return $result;
        }
        $data['name']           = var_validation($name, VAR_NAME, OPERATE_FILTER);       //姓名过滤
        $data['birthday']       = var_validation($birth, VAR_DATE, OPERATE_FILTER);      //生日过滤
        $data['gender']         = var_validation($gender, VAR_GENDER, OPERATE_FILTER);   //性别过滤
        $data['contact_qq']     = var_validation($qq, VAR_QQ, OPERATE_FILTER);           //QQ过滤
        $data['contact_email']  = var_validation($email, VAR_EMAIL, OPERATE_FILTER);     //邮箱过滤
        $data['contact_mobile'] = $phone;     
        filter_location($pid, $cid);                                    //省份城市过滤
        $data['province_code']      = $pid;
        $data['city_code']          = $cid;
        $data['identity_card']      = '';
        $data['certificate_remark'] = '';
        $data['work_age']           = 0;
        $data['is_del']             = 0;
        while(true){                                        //生成唯一主键
            $id = build_id();
            $temp = $this->provider->getHuman($id);
            if(empty($temp))
                break;
        }
        $data['human_id']           = $id;
        $human = $this->provider->addHuman($result, $data);             //添加人才信息
        if(!$human){
            $this->provider->rollback();
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        $this->provider->commit();
        return $human;
    }

    /**
     * 获取指定人才基本信息
     * @param  <string> $id 人才资料编号
     * @return <array>
     */
    public function get_human($id){
        $id = var_validation($id, VAR_ID, OPERATE_FILTER);
        return $this->provider->getHuman($id);
    }

    /**
     * 根据简历编号获取人才信息
     * @param <type> $id
     */
    public function get_human_by_resume($id){
        return $this->provider->getHumanByResumeId($id);
    }

    /**
     * 更新人才基本信息
     * @param  <int>    $user_id 用户编号
     * @param  <int>    $id      资料编号
     * @param  <string> $name    姓名
     * @param  <int>    $gender  性别
     * @param  <string> $birth   生日
     * @param  <int>    $pid     省份编号
     * @param  <int>    $cid     城市编号
     * @param  <string> $qq      QQ
     * @param  <int>    $exp     工作经验
     * @param  <string> $photo   头像
     * @param  <string> $phone   手机号码
     * @param  <string> $email   邮箱
     * @return <bool>
     */
    public function update_human($user_id, $id, $name, $gender, $birth, $pid, $cid, $qq, $exp, $photo, $phone, $email){
        if(!var_validation($name, VAR_NAME)){
            return E(ErrorMessage::$NAME_FORMAT_ERROR);
        }
        filter_location($pid, $cid);
        $data['name']          = $name;
        $data['gender']        = var_validation($gender, VAR_GENDER, OPERATE_FILTER);
        $data['birthday']      = var_validation($birth, VAR_DATE, OPERATE_FILTER);
        $data['contact_qq']    = var_validation($qq, VAR_QQ, OPERATE_FILTER);
        $data['province_code'] = $pid;
        $data['city_code']     = $cid;
        if(!empty($exp)){
            $data['work_age']  = var_validation($exp, VAR_WEXP, OPERATE_FILTER);
        }
        $provider = new UserProvider();
        $user['name'] = $name;
        if(!empty($photo)){
            $user['photo'] = $photo;
        }
        $uinfo = $provider->get_user_info($user_id);
        if(!empty($uinfo)){
            if($uinfo['is_phone_auth'] == 0 && var_validation($phone, VAR_PHONE)){
                $data['contact_mobile'] = $phone;
            }
            if($uinfo['is_email_auth'] == 0 && var_validation($email, VAR_EMAIL)){
                $data['contact_email'] = $email;
            }
        }
        $this->provider->trans();
        if(!$this->provider->updateHuman($id, $data)){
            $this->provider->rollback();                       //回滚事务
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        if(!$provider->update_user($user_id, $user)){
            $this->provider->rollback();                       //回滚事务
            return E();
        }
        $this->provider->commit();
        $service = new ContactsService();
        $service->moving_update_profile($user_id);
        return true;
    }


     /**
      * 添加私有人才
      * @param <string> $name
      * @param <int> $gender
      * @param <datetime> $birthday
      * @param <int> $province_code
      * @param <int> $city_code
      * @param <string> $contact_mobile
      * @param <string> $contact_qq
      * @param <string> $contact_email
      * @param <int> $work_age
      * @return <mixed> 成功返回人才ID，失败返回错误信息
      */
    public function add_private_human($name,$gender,$birthday,$province_code,$city_code,$contact_mobile,$contact_qq,$contact_email,$work_age){
        filter_location($province_code, $city_code);
        $data=array(
            'name'=>$name,
            'gender'=>$gender,
            'birthday'=>$birthday,
            'province_code'=>$province_code,
            'city_code'=>$city_code,
            'contact_mobile'=>$contact_mobile,
            'contact_qq'=>$contact_qq,
            'contact_email'=>$contact_email,
            'work_age'=>$work_age,
        );
        $humanProvider=new HumanProvider();
        //参数验证
        $data=argumentValidate($humanProvider->humanArgRule, $data);
        if (is_zerror($data)){
            return $data;
        }
        //开启事务
        $humanProvider->trans();
        $resumeService=new ResumeService();
        //创建简历
        $resume_id=$resumeService->createResume();
        if (is_zerror($resume_id)){
            //创建简历失败，事务回滚
            $humanProvider->rollback();
            return $resume_id;
        }
        while(true){                                        //生成唯一主键
            $id = build_id();
            $temp = $this->provider->getHuman($id);
            if(empty($temp))
                break;
        }
        $data['human_id']           = $id;
        //添加人才数据
        $human_id=$humanProvider->addHuman($resume_id, $data);
        if ($human_id){
            //添加人才数据成功，提交事务
            $humanProvider->commit();
            return $human_id;
        }else{
            //添加人才数据失败，回滚事务
            $humanProvider->rollback();
            return E(ErrorMessage::$OPERATION_FAILED);
        }
    }

    /**
     * 更新私有人才信息
     * @param <int> $creator
     * @param <int> $human_id
     * @param <int> $name
     * @param <int> $gender
     * @param <int> $birthday
     * @param <int> $province_code
     * @param <int> $city_code
     * @param <string> $contact_mobile
     * @param <string> $contact_qq
     * @param <string> $contact_email
     * @param <int> $work_age
     * @return <mixed>
     */
    public function update_private_huamn($creator,$human_id,$name,$gender,$birthday,$province_code,$city_code,$contact_mobile,$contact_qq,$contact_email,$work_age){
        filter_location($province_code, $city_code);
        $data=array(
            'name'=>$name,
            'gender'=>$gender,
            'birthday'=>$birthday,
            'province_code'=>$province_code,
            'city_code'=>$city_code,
            'contact_mobile'=>$contact_mobile,
            'contact_qq'=>$contact_qq,
            'contact_email'=>$contact_email,
            'work_age'=>$work_age,
        );
        $humanProvider=new HumanProvider();
        //参数验证
        $data=argumentValidate($humanProvider->humanArgRule, $data);
        if (is_zerror($data)){
            return $data;
        }
        if (!$humanProvider->isAddHuman($creator, $human_id)){
            return E(ErrorMessage::$HUMAN_NOT_OWN);
        }
        $result=$humanProvider->updateHuman($human_id, $data);
        if ($result){
            return true;
        }else{
            return E(ErrorMessage::$OPERATION_FAILED);
        }
    }

    /**
     * 获取人才信息列表
     * @param <int>    $page  第几页
     * @param <int>    $size  每页条数
     * @param <string> $order 排序方式
     * @param <bool>   $count 是否统计总条数
     * @return <mixed> 成功返回数组（无数据为空数组），失败返回false
     */
    public function get_human_list($page, $size, $order = null, $count = false){
        $provider = new HumanProvider();
        return $provider->get_human_list(var_validation($page, VAR_PAGE, OPERATE_FILTER), var_validation($size, VAR_SIZE, OPERATE_FILTER), $order, $count);
    }

    /**
     * 查看简历
     * @param <type> $user_id
     * @param <type> $resume_id
     * @return <type>
     */
    public function read_resume($user_id, $resume_id){
        $provider = new JobOperateProvider();
        $r = $provider->getReadResume($user_id, $resume_id);
        if(empty($r))
            $provider->addReadResume(array('reader_id' => $user_id, 'resume_id' => $resume_id));
        else
            $provider->updateReadResume($r['read_resume_id'], date_f());
        return;
    }
}
?>
