<?php

/**
 * Description of UserService
 *
 * @author moi
 */
class FeedbackService{
    //----------------private-------------------
    private $provider;

    //----------------public--------------------
    public function  __construct() {
        $this->provider = new FeedbackProvider();
    }
    
    /**
     *
     * @param type $data
     * @return type 
     */
    public function addfeedback($data){
        $data=argumentValidate($this->provider->feedbackArgRule, $data);
        if(is_zerror($data)){
            return $data;
        }
        if(!$this->provider->addfeedback($data)){
            return E();
        }
        return TRUE;
    }
    
}
?>