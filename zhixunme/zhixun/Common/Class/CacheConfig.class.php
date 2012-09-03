<?php
/**
 * Description of CacheConfig
 *
 * @author moi
 */
class KeyConfig {
    public $_config_table = array(
        'zx_agent'          => array(
            'pre'           => 'zx_agent',
            'key'           => 'agent_id',
            'expire'        => 36000
        ),
        'zx_article'        => array(
            'pre'           => 'zx_article',
            'key'           => 'art_id',
            'expire'        => 86400
        ),
        'zx_article_class'  => array(
            'pre'           => 'zx_article_class',
            'key'           => 'class_id',
            'expire'        => 864000
        ),
        'zx_city'           => array(
            'pre'           => 'zx_city',
            'key'           => 'code',
            'expire'        => 864000
        ),
        'zx_company'        => array(
            'pre'           => 'zx_company',
            'key'           => 'company_id',
            'expire'        => 36000
        ),
        'zx_degree'         => array(
            'pre'           => 'zx_degree',
            'key'           => 'degree_id',
            'expire'        => 36000
        ),
        'zx_delegate'       => array(
            'pre'           => 'id',
            'key'           => 'id',
            'expire'        => 36000
        ),
        'zx_delegate_job'   => array(
            'pre'           => 'zx_delegate_job',
            'key'           => 'id',
            'expire'        => 36000
        ),
        'zx_delegate_resume'    => array(
            'pre'           => 'zx_delegate_resume',
            'key'           => 'id',
            'expire'        => 36000
        ),
        'zx_grade_certificate'  => array(
            'pre'           => 'zx_grade_certificate',
            'key'           => 'grade_certificate_id',
            'expire'        => 864000
        ),
        'zx_grade_certificate_type' => array(
            'pre'           => 'zx_grade_certificate_type',
            'key'           => 'grade_certificate_type_id',
            'expire'        => 864000
        ),
        'zx_hang_card_intent'   => array(
            'pre'           => 'zx_hang_card_intent',
            'key'           => 'hang_card_intent_id',
            'expire'        => 36000
        ),
        'zx_human'          => array(
            'pre'           => 'zx_human',
            'key'           => 'human_id',
            'expire'        => 36000
        ),
        'zx_information'    => array(
            'pre'           => 'zx_information',
            'key'           => 'info_id',
            'expire'        => 36000
        ),
        'zx_information_reply'  => array(
            'pre'           => 'zx_information_reply',
            'key'           => 'id',
            'expire'        => 36000
        ),
        'zx_job'            => array(
            'pre'           => 'zx_job',
            'key'           => 'job_id',
            'expire'        => 36000
        ),
        'zx_job_intent'     => array(
            'pre'           => 'zx_job_intent',
            'key'           => 'job_intent_id',
            'expire'        => 36000
        ),
        'zx_message'        => array(
            'pre'           => 'zx_message',
            'key'           => 'id',
            'expire'        => 36000
        ),
        'zx_notify_tpl'     => array(
            'pre'           => 'zx_notify_tpl',
            'key'           => 'id',
            'expire'        => 864000
        ),
        'zx_package'        => array(
            'pre'           => 'zx_package',
            'key'           => 'id',
            'expire'        => 864000
        ),
        'zx_package_module' => array(
            'pre'           => 'zx_package_module',
            'key'           => 'id',
            'expire'        => 864000
        ),
        'zx_pay_type'       => array(
            'pre'           => 'zx_pay_type',
            'key'           => 'id',
            'expire'        => 864000
        ),
        'zx_permission_action'  => array(
            'pre'           => 'zx_permission_action',
            'key'           => array('ac+ro' => 'action_code,role_id', 'ro+ac' => 'role_id,action_code'),
            'expire'        => 864000
        ),
        'zx_permission_role_action' => array(
            'pre'           => 'zx_permission_role_action',
            'key'           => array('ac+ro' => 'action_code,role_id', 'ro+ac' => 'role_id,action_code'),
            'expire'        => 864000
        ),
        'zx_permission_role_not_active_action'  => array(
            'pre'           => 'zx_permission_role_not_active_action',
            'key'           => array('ac+ro' => 'action_code,role_id', 'ro+ac' => 'role_id,action_code'),
            'expire'        => 864000
        ),
        'zx_province'       => array(
            'pre'           => 'zx_province',
            'key'           => 'code',
            'expire'        => 864000
        ),
        'zx_register_certificate'   => array(
            'pre'           => 'zx_register_certificate',
            'key'           => 'register_certificate_id',
            'expire'        => 864000
        ),
        'zx_register_certificate_info'  => array(
            'pre'           => 'zx_register_certificate_info',
            'key'           => 'register_certificate_info_id',
            'expire'        => 864000
        ),
        'zx_register_certificate_major' => array(
            'pre'           => 'zx_register_certificate_major',
            'key'           => 'register_certificate_major_id',
            'expire'        => 864000
        ),
        'zx_resume'         => array(
            'pre'           => 'zx_resume',
            'key'           => 'resume_id',
            'expire'        => 36000
        ),
        'zx_service_category'   => array(
            'pre'           => 'zx_service_category',
            'key'           => 'service_category_id',
            'expire'        => 864000
        ),
        'zx_system_message' => array(
            'pre'           => 'zx_system_message',
            'key'           => 'id',
            'expire'        => 36000
        ),
        'zx_task_class'     => array(
            'pre'           => 'zx_task_class',
            'key'           => 'class_id',
            'expire'        => 864000
        ),
        'zx_work_exp'       => array(
            'pre'           => 'zx_work_exp',
            'key'           => 'work_exp_id',
            'expire'        => 36000
        )
    );
}
//        'zx_user'           => array(
//            'pre'           => 'zx_user',
//            'key'           => array('uid' => 'user_id', 'em' => 'email', 'ph' => 'phone', 'ro+da' => 'role_id,data_id', 'da+ro' => 'data_id,role_id'),
//            'expire'        => 36000
//        ),
class CacheOperate {
    private $_key_connector = '_';

    private $_config;
    
    public function  __construct() {
        $this->_config = new KeyConfig();
    }

    public function get_cache($table, $where, &$cache_key){
        $_config = $this->_config->_config_table;
        if(array_key_exists($table, $_config)){
            $key = $this->get_table_key($where);
            if(is_string($_config[$table]['key']) && $_config[$table]['key'] == $key['key']){
                $cache_key = $this->get_cache_key($table, $key['value']);
                return DataCache::get($cache_key);
            }
            else if(is_array($_config[$table]['key']) && array_search($key['key'], $_config[$table]['key']) !== false){
                $index = array_search($key['key'], $_config[$table]['key']);
                $cache_key = $this->get_cache_key($table, $key['value'], $index);
                return DataCache::get($cache_key);
            }
        }
        return false;
    }

    public function set_cache($table, $key, $value){
        $expire = $this->_config->_config_table[$table]['expire'];
        DataCache::set($key, $value, $expire);
    }

    public function remove_cache($table, $where){
        $_config = $this->_config->_config_table;
        if(array_key_exists($table, $_config)){
            $key = $this->get_table_key($where);
            if(is_string($_config[$table]['key']) && $_config[$table]['key'] == $key['key']){
                $cache_key = $this->get_cache_key($table, $key['value']);
                DataCache::remove($cache_key);
            }
            else if(is_array($_config[$table]['key']) && array_search($key['key'], $_config[$table]['key']) !== false){
                $index = array_search($key['key'], $_config[$table]['key']);
                $cache_key = $this->get_cache_key($table, $key['value'], $index);
                $data = DataCache::get($cache_key);
                foreach($_config[$table]['key'] as $c_key => $value){
                    $array = explode(',', $value);
                    $k = array();
                    foreach($array as $v){
                        $k[$v] = $data[0][$v];
                    }
                    $kstr = implode(',', $k);
                    $cache_key = $this->get_cache_key($table, $kstr, $c_key);
                    DataCache::remove($cache_key);
                }
            }
        }
    }

    protected function get_cache_key($table, $key, $pre){
        if(empty($pre))
            return 'single'.$this->_key_connector.$table.$this->_key_connector.$key;
        else
            return 'single'.$this->_key_connector.$table.$this->_key_connector.$pre.'~'.$this->_key_connector.$key;
    }

    protected function get_table_key($where){
        $result['key'] = '';
        $result['value'] = '';
        foreach($where as $key => $value){
            if($key == 'is_del'){
                unset($where['is_del']);
                continue;
            }
            $result['key'] .= $key.',';
            $result['value'] .= addslashes($value).',';
        }
        $result['key'] = rtrim($result['key'], ',');
        $result['value'] = rtrim($result['value'], ',');
        return $result;
    }
}
?>
