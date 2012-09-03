<?php

/**
 * Description of UserService
 *
 * @author moi
 */
class ReportService{
    //----------------private-------------------
    private $provider;

    //----------------public--------------------
    public function  __construct() {
        $this->provider = new ReportProvider();
    }
    
    public function addReport($data){
        $data=argumentValidate($this->provider->reportArgRule, $data);
        if(is_zerror($data)){
            return $data;
        }
        return $this->provider->addReport($data);
    }
    
}
?>
