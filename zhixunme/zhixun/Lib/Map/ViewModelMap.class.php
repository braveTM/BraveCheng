<?php

/**
 * Description of ViewModelMap
 *
 * @author moi
 */
class ViewModelMap {

    public static function __callStatic($name, $arguments) {
        return null;
    }

    //-------------------array to model------------------
    public static function array_to_home_index_rhuman_model($array) {
        $model = new home_index_rhuman_model();
        $model->id = $array['id'];
        $model->name = $array['name'];
        $temp = $array['cert']['register_certificate_name'];
        if (!empty($array['cert']['register_certificate_major']))
            $temp .= ' - ' . $array['cert']['register_certificate_major'];
        switch ($array['cert']['register_case']) {
            case 1 : $temp .= ' - 初始注册';
                break;
            case 2 : $temp .= ' - 变更注册';
                break;
            case 3 : $temp .= ' - 重新注册';
                break;
        }
        $model->cert = $temp;
        $model->salary = year_salary($array['salary']);
        return $model;
    }

    public static function array_to_home_index_rcompany_model($array) {
        $model = new home_index_rcompany_model();
        $model->id = $array['id'];
        $model->name = $array['name'];
        $model->logo = C('WEB_ROOT') . '/' . $array['logo'];
        foreach ($array['jobs'] as $job) {
            $empty = new common_common_empty_model();
            $empty->id = $job['job_id'];
            $empty->name = $job['title'];
            $empty->job_category=$job['job_category'];
            $model->jobs[] = $empty;
        }
        return $model;
    }

    public static function array_to_home_index_ragent_model($array) {
        $model = new home_index_ragent_model();
        $model->id = $array['id'];
        $model->name = $array['name'];
        $model->photo = C('WEB_ROOT') . '/' . $array['photo'];
        return $model;
    }

    public static function array_to_home_market_normal_model($array) {
        $model = new home_market_normal_model();
        $model->name = $array['cert_name'];
        if (array_key_exists('major_name', $array))
            $model->name .= ' - ' . $array['major_name'];
        $model->i_price = $array['irmin_price'] . '～' . $array['irmax_price'];
        $model->c_price = $array['crmin_price'] . '～' . $array['crmax_price'];
        $model->trend = $array['trend'];
        return $model;
    }

    public static function array_to_home_market_chart_model($array) {
        $model = new home_market_chart_model();
        $model->imin_price = $array['irmin_price'];
        $model->imax_price = $array['irmax_price'];
        $model->iave_price = round(($array['irmin_price'] + $array['irmax_price']) / 2, 1);
        $model->cmin_price = $array['crmin_price'];
        $model->cmax_price = $array['crmax_price'];
        $model->cave_price = round(($array['crmin_price'] + $array['crmax_price']) / 2, 1);
        $model->month = intval(substr($array['date'], 5, 2));
        return $model;
    }

    public static function array_to_home_market_year_model($array) {
        $model = new home_market_year_model();
        $model->i_price = $array['i_price'];
        $model->c_price = $array['c_price'];
        $model->year = $array['year'];
        return $model;
    }

    public static function array_to_home_article_fixed_model($array) {
        $model = new home_article_fixed_model();
        $model->id = $array['id'];
        $model->title = $array['title'];
        $model->en = $array['en_title'];
        $model->content = $array['content'];
        return $model;
    }

    public static function array_to_home_package_current_model($array) {
        $model = new home_package_current_model();
        $model->id = $array['precord']['id'];
        $model->pid = $array['precord']['package_id'];
        $model->price = $array['package']['price'];
        $model->title = $array['package']['title'];
        $model->free = $array['package']['free'];
        $model->date = nt_date_format($array['precord']['end_time']);
        $model->days = get_date_differ(date_f(), $array['precord']['end_time']);
        $model->deadline = $array['package']['deadline'];
        $model->modules = FactoryVMap::list_to_models($array['modules'], 'home_package_module');
        return $model;
    }

    public static function array_to_home_package_module_model($array) {
        $model = new home_package_module_model();
        $model->id = $array['id'];
        $model->name = mfree_format($array['m_title']);
        $model->t_count = $array['initial_free_count'];
        $model->s_count = $array['free_count'];
        $model->price = $array['price'];
        $model->unit = $array['unit'];
        return $model;
    }

    public static function array_to_home_pm_relation_model($array) {
        $model = new home_package_module_model();
        $model->name = mfree_format($array['m_title']);
        $model->count = $array['free_count'];
        $model->unit = $array['unit'];
        return $model;
    }

    public static function array_to_home_package_list_model($array) {
        $model = new home_package_list_model();
        $model->id = $array['id'];
        $model->title = $array['title'];
        $model->deadline = $array['deadline'];
        $model->price = $array['price'];
        $model->use = $array['current'];
        $model->modules = $array['modules'];
        $model->recom = $array['recommend'];
        return $model;
    }

    public static function array_to_home_contacts_follow_model($array) {
        $model = new home_contacts_follow_model();
        $model->user_id = $array['user_id'];
        $model->name = $array['name'];
        $model->photo = C('FILE_ROOT') . $array['photo'];
        $model->active = $array['_info']['activity'];
        $model->type = $array['role_id'];
        $model->real_auth = $array['is_real_auth'];
        $model->phone_auth = $array['is_phone_auth'];
        $model->email_auth = $array['is_email_auth'];
//        if ($array['is_real_auth'] == 1) {
//            $model->real_auth = C('FILE_ROOT') . C('AUTH_REAL_OK');
//        } else {
//            $model->real_auth = C('FILE_ROOT') . C('AUTH_REAL_NO');
//        }
//        if ($array['is_phone_auth'] == 1) {
//            $model->phone_auth = C('FILE_ROOT') . C('AUTH_PHONE_OK');
//        } else {
//            $model->phone_auth = C('FILE_ROOT') . C('AUTH_PHONE_NO');
//        }
//        if ($array['is_email_auth'] == 1) {
//            $model->email_auth = C('FILE_ROOT') . C('AUTH_EMAIL_OK');
//        } else {
//            $model->email_auth = C('FILE_ROOT') . C('AUTH_EMAIL_NO');
//        }
        $service = new ProvinceService();
        if ($array['role_id'] == C('ROLE_TALENTS')) {
            foreach ($array['_cert'] as $cert) {
                $temp = $cert['register_certificate_name'];
                if (!empty($cert['register_certificate_major']))
                    $temp .= ' - ' . $cert['register_certificate_major'];
                switch ($cert['register_case']) {
                    case 1 : $temp .= ' - 初始注册';
                        break;
                    case 2 : $temp .= ' - 变更注册';
                        break;
                    case 3 : $temp .= ' - 重新注册';
                        break;
                }
                $certs[] = $temp;
            }
            $model->certs = $certs;
            $province = $service->get_province($array['_info']['province_code']);
            if (!empty($province)) {
                $model->location = $province['name'];
                $city = $service->get_city($array['_info']['city_code']);
                if (!empty($city)) {
                    $model->location .= ' - ' . $city['name'];
                }
            }
            if (empty($model->location)) {
                $model->location = '未知';
            }
        } elseif ($array['role_id'] == C('ROLE_ENTERPRISE')) {
            $province = $service->get_province($array['_info']['company_province_code']);
            if (!empty($province)) {
                $model->location = $province['name'];
                $city = $service->get_city($array['_info']['company_city_code']);
                if (!empty($city)) {
                    $model->location .= ' - ' . $city['name'];
                }
            }
            if (empty($model->location)) {
                $model->location = '未知';
            }
            $model->summary = $array['_info']['introduce'];
        } elseif ($array['role_id'] == C('ROLE_AGENT')) {
            $province = $service->get_province($array['_info']['addr_province_code']);
            if (!empty($province)) {
                $model->location = $province['name'];
                $city = $service->get_city($array['_info']['addr_city_code']);
                if (!empty($city)) {
                    $model->location .= ' - ' . $city['name'];
                }
            }
            if (empty($model->location)) {
                $model->location = '未知';
            }
            $model->summary = $array['_info']['introduce'];
            $model->company = $array['_info']['company_name'];
        }
        return $model;
    }

    public static function array_to_home_contacts_moving_model($array) {
        $model = new home_contacts_moving_model();
        $model->user_id = $array['user_id'];
        $model->photo = C('FILE_ROOT') . $array['photo'];
        $model->name = $array['name'];
        $model->role = $array['role_id'];
        $model->action = strtr($array['action'], array('[f_root]' => C('FILE_ROOT'), '[root]' => C('WEB_ROOT')));
        ;
        $model->content = strtr($array['content'], array('[f_root]' => C('FILE_ROOT'), '[root]' => C('WEB_ROOT')));
        $model->date = cdate_format($array['date']);
        return $model;
    }

    public static function array_to_home_agent_promote_model($array) {
        $model = new home_agent_promote_model();
        $model->id = $array['id'];
        $model->m_count = $array['max_count'] . '';
        if (array_key_exists('s_count', $array))
            $model->s_count = $array['s_count'] . '';
        else
            $model->s_count = '-1';
        $model->price = $array['price'];
        $model->min_days = $array['min_days'];
        $model->max_days = $array['max_days'];
        if (array_key_exists('status', $array))
            $model->status = $array['status'];
        if (array_key_exists('date', $array))
            $model->date = $array['date'];
        return $model;
    }

    public static function array_to_home_promote_location_model($array) {
        $model = new home_promote_location_model();
        $model->id = $array['id'];
        $model->title = $array['title'];
        $model->price = $array['price'];
        $model->min_days = $array['min_days'];
        $model->max_days = $array['max_days'];
        $model->sort = $array['sort'];
        if (array_key_exists('_hold', $array))
            $model->hold = $array['_hold'];
        return $model;
    }

    /**
     * 将数组转化为HOME_INDEX_SLIDE对象
     * @param <array> $array
     */
    public static function array_to_home_index_slide_model($array) {
        $model = new home_index_slide_model();
        $model->src = C('FILE_ROOT') . $array['image'];
        $model->alt = $array['alt'];
        return $model;
    }

    /**
     * 将数组转化为HOME_INDEX_ACLASS对象
     * @param <array> $array
     */
    public static function array_to_home_index_aclass_model($array) {
        $model = new home_index_aclass_model();
        $model->id = $array['class_id'];
        $model->title = $array['class_title'];
        $model->arts = $array['arts'];
        return $model;
    }

    /**
     * 将数组转化为HOME_INDEX_ARTICLE对象
     * @param <array> $array
     */
    public static function array_to_home_index_article_model($array) {
        $model = new home_index_article_model();
        $model->blog_id = $array['art_id'];
        $model->art_id = $array['art_id'];
        $model->title = $array['art_title'];
        $model->picture = $array['picture'];
        //$model->body = str_sub(strtr($array['art_content'], array('{nbsp}' => ' ', '&lt;br/&gt;' => ' ')), 90);

        $model->body = preg_replace("/<(\/?br.*?)>/si", "", $array['art_content']);
        $model->body = preg_replace("/\s+/", "", $model->body);
        $model->body = str_sub(html2txt($model->body), 105);
        $model->create_datetime = nt_date_format($array['edit_date']);
        $model->read_count = $array['read_count'];
        $model->name = $array['art_author'];
        $model->praise = $array['praise'];
        return $model;
    }

    /**
     * 将数组转化为HOME_INDEX_ARTICLE对象
     * @param <array> $array
     */
    public static function array_to_home_index_article_kaozhen_model($array) {
        $model = new home_index_article_model();
        $model->blog_id = $array['art_id'];
        $model->art_id = $array['art_id'];
        $model->title = $array['art_title'];
        $model->picture = $array['picture'];
        //$model->body = str_sub(strtr($array['art_content'], array('{nbsp}' => ' ', '&lt;br/&gt;' => ' ')), 90);

        $model->body = preg_replace("/<(\/?br.*?)>/si", "", $array['art_content']);
        $model->body = preg_replace("/\s+/", " ", $model->body);
        $model->body = str_sub(html2txt($model->body), 60);
        $model->create_datetime = nt_date_format($array['edit_date']);
        $model->read_count = $array['read_count'];
        $model->name = $array['art_author'];
        $model->praise = $array['praise'];
        return $model;
    }

    public static function array_to_home_index_company_model($array) {
        $model = new home_index_company_model();
        $model->id = $array['user_id'];
        $model->name = $array['_name'];
        $model->picture = C('FILE_ROOT') . $array['picture'];
        $model->jcount = $array['_job'];
        $model->tcount = $array['_task'];
        $model->sort = $array['sort'];
        return $model;
    }

    /**
     * 将数组转化为COMMON_COMMON_LOCATION_MODEL对象
     * @param <array> $array
     */
    public static function array_to_common_common_location_model($array) {
        $model = new common_common_location_model();
        $model->id = $array['code'];
        $model->name = $array['name'];
        if (array_key_exists('children', $array)) {
            $model->children = $array['children'];
        }
        return $model;
    }

    /**
     * 将数组转化为HOME_USER_AGENT_MODEL对象
     * @param <array> $array
     */
    public static function array_to_home_user_agent_model($array) {
        $model = new home_user_agent_model();
        $model->name = $array['name'];
        $model->url = $array['url'];
        return $model;
    }

    /**
     * 将数组转化为HOME_USER_ENTERPRISE_MODEL对象
     * @param <array> $array
     */
    public static function array_to_home_user_enterprise_model($array) {
        $model = new home_user_enterprise_model();
        $model->name = $array['name'];
        $model->url = $array['url'];
        return $model;
    }

    /**
     * 将数组转化为HOME_USER_SUBCONTRACTOR_MODEL对象
     * @param <array> $array
     */
    public static function array_to_home_user_subcontractor_model($array) {
        $model = new home_user_subcontractor_model();
        $model->name = $array['name'];
        $model->url = $array['url'];
        return $model;
    }

    /**
     * 将数组转化为HOME_USER_TALENTS_MODEL对象
     * @param <array> $array
     */
    public static function array_to_home_user_talents_model($array) {
        $model = new home_user_talents_model();
        $model->name = $array['name'];
        $model->url = $array['url'];
        return $model;
    }

    /**
     * 将数组转化为HOME_BILL_INDEX_MODEL对象
     * @param <array> $array
     */
    public static function array_to_home_bill_index_model($array) {
        $model = new home_bill_index_model();
        $model->name = $array['name'];
        $model->cash = $array['cash'];
        return $model;
    }

    /**
     * 将数组转化为HOME_BILL_PAYMENT_MODEL对象
     * @param <array> $array
     */
    public static function array_to_home_bill_payment_model($array) {
        $model = new home_bill_payment_model();
        $model->id = $array['id'];
        $model->name = $array['title'];
        $model->description = $array['description'];
        $model->icon = C('FILE_ROOT') . $array['logo'];
        $model->text = $array['dtext'];
        return $model;
    }

    /**
     * 将数组转化为HOME_BILL_DETAILS_MODEL对象
     * @param <array> $array
     */
    public static function array_to_home_bill_details_model($array) {
        $model = new home_bill_details_model();
        $model->id = $array['id'];
        $model->title = $array['bill_title'];
        $model->type = $array['bill_type'];
        if ($array['bill_type'] == 1)
            $model->money = $array['income_money'];
        else
            $model->money = $array['outlay_money'];
        $model->date = $array['date'];
        return $model;
    }

    /**
     * 将数组转化为HOME_MESSAGE_PAGE_MODEL对象
     * @param <array> $array
     */
    public static function array_to_home_message_page_model($array) {
        $model = new home_message_page_model();
        $model->unread_s = $array['unread_s'];
        $model->unread_p = $array['unread_p'];
        if (array_key_exists('unread_slist', $array))
            $model->unread_slist = $array['unread_slist'];
        if (array_key_exists('unread_plist', $array))
            $model->unread_plist = $array['unread_plist'];
        return $model;
    }

    /**
     * 将数组转化为HOME_MESSAGE_LIST_MODEL对象
     * @param <array> $array
     */
    public static function array_to_home_message_list_model($array) {
        $model = new home_message_list_model();
        $model->id = $array['id'];
        $model->title = $array['title'];
        if (array_key_exists('from_id', $array)) {
            $model->fid = $array['from_id'];
            $model->furl = C('WEB_ROOT') . $array['from_id'];
        }
        if (array_key_exists('from_name', $array))
            $model->fname = $array['from_name'];
        if (array_key_exists('to_id', $array)) {
            $model->tid = $array['to_id'];
            $model->turl = C('WEB_ROOT') . $array['to_id'];
        }
        if (array_key_exists('to_name', $array))
            $model->tname = $array['to_name'];
        if (array_key_exists('to_read', $array))
            $model->read = $array['to_read'];
        if (array_key_exists('content', $array))
            $model->content = str_sub($array['content'], 15);
        $model->date = cdate_format($array['date']);
        $model->url = C('WEB_ROOT') . '/message/' . $array['id'];
        return $model;
    }

    /**
     * 将数组转化为HOME_MESSAGE_DETAIL_MODEL对象
     * @param <array> $array
     */
    public static function array_to_home_message_detail_model($array) {
        $model = new home_message_detail_model();
        $model->id = $array['id'];
        $model->title = $array['title'];
        $model->content = $array['content'];
        $model->date = cdate_format($array['date']);
        $model->uid = $array['uid'];
        $model->uname = $array['uname'];
        $model->uphoto = C('FILE_ROOT') . $array['uphoto'];
        $model->url = C('WEB_ROOT'); //.$array['uid'];
        return $model;
    }

    /**
     * 将数组转化为COMMON_COMMON_ROLE_MODEL对象
     * @param <array> $array
     */
    public static function array_to_common_common_role_model($array) {
        $model = new common_common_role_model();
        $model->id = $array['role_id'];
        $model->name = $array['role_name'];
        return $model;
    }

    /**
     * 将数组转化为HOME_INDEX_RURL_MODEL对象
     * @param <array> $array
     */
    public static function array_to_home_index_rurl_model($array) {
        $model = new home_index_rurl_model();
        $model->turl = $array['turl']; //C('WEB_ROOT').'/register/'.C('ROLE_TALENTS');
        $model->eurl = $array['eurl']; //C('WEB_ROOT').'/register/'.C('ROLE_ENTERPRISE');
        $model->aurl = $array['aurl']; //C('WEB_ROOT').'/register/'.C('ROLE_AGENT');
        $model->surl = $array['surl']; //C('WEB_ROOT').'/register/'.C('ROLE_SUBCONTRACTOR');
        return $model;
    }

    /**
     * 将数组转化为HOME_USER_AUTH对象
     * @param <array> $array
     */
    public static function array_to_home_user_auth_model($array) {
        $model = new home_user_auth_model();
        if ($array['wait_real'] == 1) {
            $array['is_real_auth'] = 2;         //实名认证等待审核中
        }
        $model->real_auth = $array['is_real_auth'];
        $model->phone_auth = $array['is_phone_auth'];
        $model->email_auth = $array['is_email_auth'];
        if ($array['is_real_auth'] == 1)
            $model->ricon = C('FILE_ROOT') . C('AUTH_REAL_OK');
        else
            $model->ricon = C('FILE_ROOT') . C('AUTH_REAL_NO');
        if ($array['is_phone_auth'] == 1)
            $model->picon = C('FILE_ROOT') . C('AUTH_PHONE_OK');
        else
            $model->picon = C('FILE_ROOT') . C('AUTH_PHONE_NO');
        if ($array['is_email_auth'] == 1)
            $model->eicon = C('FILE_ROOT') . C('AUTH_EMAIL_OK');
        else
            $model->eicon = C('FILE_ROOT') . C('AUTH_EMAIL_NO');
        if (array_key_exists('a_real_name', $array))
            $model->name = $array['a_real_name'];
        if (array_key_exists('a_real_num', $array))
            $model->num = $array['a_real_num'];
        if (array_key_exists('a_phone', $array))
            $model->phone = $array['a_phone'];
        if (array_key_exists('a_email', $array))
            $model->email = $array['a_email'];
        if ($array['is_real_auth'] == 1 && $array['is_phone_auth'] == 1 && $array['is_email_auth'] == 1) {
            $model->all = 1;
        } else {
            $model->all = 0;
        }
        if ($array['is_real_auth'] == 0 && $array['is_phone_auth'] == 0 && $array['is_email_auth'] == 0) {
            $model->none = 1;
        } else {
            $model->none = 0;
        }
        return $model;
    }

    /**
     * 将数组转化为COMMON_COMMON_BANK对象
     * @param <array> $array
     */
    public static function array_to_common_common_bank_model($array) {
        $model = new common_common_bank_model();
        $model->id = $array['bank_id'];
        $model->name = $array['bank_name'];
        $model->icon = C('FILE_ROOT') . $array['logo'];
        return $model;
    }

    /**
     * 将数组转化为COMMON_COMMON_HEADER对象
     * @param <array> $array
     */
    public static function array_to_common_common_header_model($array) {
        $model = new common_common_header_model();
        $model->status = $array['status'];
        if (array_key_exists('uname', $array)) {
            $model->uname = $array['uname'];
        }
        return $model;
    }

    /**
     * 将数组转化为HOME_USER_CONTACT对象
     * @param <array> $array
     */
    public static function array_to_home_user_contact_model($array) {
        $model = new home_user_contact_model();
        $model->phone = empty($array['phone']) ? '暂无' : $array['phone'];
        $model->email = empty($array['email']) ? '暂无' : $array['email'];
        $model->qq = empty($array['qq']) ? '暂无' : $array['qq'];
        $model->company_phone = $array['company_phone'];
        return $model;
    }

    /**
     * 将数组转化为HOME_USER_CONTACT对象
     * @param <array> $array
     */
    public static function array_to_home_user_ncontact_model($array) {
        $model = new home_user_contact_model();
        $model->phone = empty($array['phone']) ? '' : $array['phone'];
        $model->email = empty($array['email']) ? '' : $array['email'];
        $model->qq = empty($array['qq']) ? '' : $array['qq'];
        return $model;
    }

    public function array_to_task_service_list_model($array) {
        $model = new home_task_service_list_model();
        $model->id = $array['id'];
        $model->name = $array['name'];
        $model->description = $array['description'];
        $model->price = $array['price'];
        return $model;
    }

    /**
     * 将数组转化为HOME_PACKAGE_USE对象
     * @param <array> $array
     */
    public static function array_to_home_package_use_model($array) {
        $model = new home_package_use_model();
        $model->tcount = $array['tsc'];
        $model->bcount = $array['bsc'];
        $model->dcount = $array['dsc'];
        $model->scount = $array['ssc'];
        return $model;
    }

    //-----------------model to array-----------------
    /**
     * 模型对象转化为数组
     * @param <mixed> $model
     * @return <array>
     */
    public static function model_to_array($model) {
        return get_object_vars($model);
    }

    /**
     * 将数组转换为HOME_PROMOTE对象
     * @param <array> $array
     */
    public static function array_to_home_promote_model($array) {
        $model = new home_promote_model();
        $model->id = $array['id'];
        $model->title = $array['title'];
        $model->price = $array['price'];
        $model->min_days = $array['min_days'];
        $model->max_days = $array['max_days'];
        $service = new PromoteService();
        $model->is_hold = $service->is_hold_promote($array['id']);
        if ($model->is_hold) {
            $promote_record = $service->get_current_promote_record($array['id']);
            $model->hold_record = self::array_to_home_promote_record_model
                            ($promote_record);
        }
        return $model;
    }

    /**
     * 将数组转换位HOME_PROMOTE_RECORD对象
     * @param <array> $array
     */
    public static function array_to_home_promote_record_model($array) {
        $model = new home_promote_record_model();
        $model->id = $array['id'];
        $model->title = $array['title'];
        $model->end = nt_date_format($array['end']);
        if (!empty($array['pic']))
            $model->pic = C('FILE_ROOT') . $array['pic'];
        return $model;
    }

    public static function array_to_home_human_detail_model($array) {
        $model = new home_human_detail_model();
        $model->uid = $array['user_id'];
        $model->hid = $array['human_id'];
        $model->rid = $array['resume_id'];
        $model->name = $array['name'];
        $model->photo = C('FILE_ROOT') . $array['photo'];
        $model->work_age = exp_format($array['work_age']);
        $model->ji_id = $array['job_intent_id'];
        $model->hc_id = $array['hang_card_intent_id'];
        $model->category = $array['job_category'];
        $model->active = $array['_active'];
        $model->rcount = $array['_rcount'];
        $model->view = $array['view'];
        $model->real_auth = $array['is_real_auth'];
        $model->phone_auth = $array['is_phone_auth'];
        $model->email_auth = $array['is_email_auth'];
//        if ($array['is_email_auth'] == 1) {
//            $model->email_auth = C('FILE_ROOT') . C('AUTH_EMAIL_OK');
//        } else {
//            $model->email_auth = C('FILE_ROOT') . C('AUTH_EMAIL_NO');
//        }
//        if ($array['is_phone_auth'] == 1) {
//            $model->phone_auth = C('FILE_ROOT') . C('AUTH_PHONE_OK');
//        } else {
//            $model->phone_auth = C('FILE_ROOT') . C('AUTH_PHONE_NO');
//        }
//        if ($array['is_real_auth'] == 1) {
//            $model->real_auth = C('FILE_ROOT') . C('AUTH_REAL_OK');
//        } else {
//            $model->real_auth = C('FILE_ROOT') . C('AUTH_REAL_NO');
//        }
        $service = new ProfileService();
        if (!empty($array['province_code'])) {
            $province = $service->get_province($array['province_code']);
            $model->place = $province['name'];
            if (!empty($array['city_code'])) {
                $city = $service->get_city($array['city_code']);
                $model->place .= ' - ' . $city['name'];
            }
        } else {
            $model->place = '未知';
        }
        foreach ($array['_certs'] as $cert) {
            $temp = $cert['register_certificate_name'];
            if (!empty($cert['register_certificate_major']))
                $temp .= ' - ' . $cert['register_certificate_major'];
            switch ($cert['register_case']) {
                case 1 : $temp .= ' - 初始注册';
                    break;
                case 2 : $temp .= ' - 变更注册';
                    break;
                case 3 : $temp .= ' - 重新注册';
                    break;
            }
            $certs[] = $temp;
        }
        $model->certs = $certs;
        if (!empty($array['_gcert'])) {
            switch ($array['_gcert']['grade_certificate_class']) {
                case 2 : $gcert = '中级';
                    break;
                case 3 : $gcert = '高级';
                    break;
                default: $gcert = '初级';
                    break;
            }
            $model->gcert = $gcert . ' - ' . $array['_gcert']['grade_certificate_type'] . ' ' . $array['_gcert']['major'];
        }
        return $model;
    }

    public static function array_to_home_resume_status_model($array) {
        $model = new home_resume_status_model();
        $model->f_wsd = $array['fsp'];
        $model->p_wsd = $array['psp'];
        $model->f_salary = year_salary($array['fsa']);
        $model->p_salary = year_salary($array['psa']);
        $model->f_status = $array['fst'];
        $model->p_status = $array['pst'];
        return $model;
    }

    /**
     * 将数组转换位HOME_HUMAN_PROFILE对象
     * @param <array> $array
     */
    public static function array_to_home_human_profile_model($array) {
        $model = new home_human_profile_model();
        $model->id = $array['human_id'];
        $model->name = $array['name'];
        $model->gender = $array['gender'];
        $model->birth = $array['birthday'];
        $model->province = $array['province_code'];
        $model->city = $array['city_code'];
        $model->phone = $array['contact_mobile'];
        $model->email = $array['contact_email'];
        $model->qq = $array['contact_qq'];
        if (array_key_exists('user_id', $array)) {
            $model->user_id = $array['user_id'];
            $userService = new UserService();
            $model->activity = $userService->get_user_activity($array['user_id']);
        }
        if (array_key_exists('photo', $array))
            $model->photo = C('FILE_ROOT') . $array['photo'];
        if (array_key_exists('work_age', $array))
            $model->exp = array($array['work_age'], exp_format($array['work_age']));
        if (array_key_exists('is_real_auth', $array))
            $model->real_auth = $array['is_real_auth'];
        if (array_key_exists('is_phone_auth', $array))
            $model->phone_auth = $array['is_phone_auth'];
        if (array_key_exists('is_email_auth', $array))
            $model->email_auth = $array['is_email_auth'];
        if ($array['is_email_auth'] == 1) {
            $model->email_auth_path = C('FILE_ROOT') . C('AUTH_EMAIL_OK');
        } else {
            $model->email_auth_path = C('FILE_ROOT') . C('AUTH_EMAIL_NO');
        }
        if ($array['is_phone_auth'] == 1) {
            $model->phone_auth_path = C('FILE_ROOT') . C('AUTH_PHONE_OK');
        } else {
            $model->phone_auth_path = C('FILE_ROOT') . C('AUTH_PHONE_NO');
        }
        if ($array['is_real_auth'] == 1) {
            $model->real_auth_path = C('FILE_ROOT') . C('AUTH_REAL_OK');
        } else {
            $model->real_auth_path = C('FILE_ROOT') . C('AUTH_REAL_NO');
        }
        $profileService = new ProfileService();
        $province = $profileService->get_province($array['province_code']);
        $city = $profileService->get_city($array['city_code']);
        $model->addr = $province['name'] . ' - ' . $city['name'];
        return $model;
    }

    /**
     * 将数组转换位HOME_COMPANY_PROFILE对象
     * @param <array> $array
     */
    public static function array_to_home_company_profile_model($array) {
        $model = new home_company_profile_model();
        $model->id = $array['company_id'];
        $model->name = $array['company_name'];
        $model->category = $array['company_category'];
        $model->province = $array['company_province_code'];
        $model->city = $array['company_city_code'];
        $model->company_phone = $array['company_phone'];
        $model->cname = $array['contact_name'];
        $model->phone = $array['contact_mobile'];
        $model->email = $array['contact_email'];
        $model->qq = $array['contact_qq'];
        $model->summary = $array['introduce'];
        $model->photo = C('FILE_ROOT') . $array['photo'];
        if (array_key_exists('user_id', $array))
            $model->user_id = $array['user_id'];
        if (array_key_exists('is_real_auth', $array))
            $model->real_auth = $array['is_real_auth'];
        if (array_key_exists('is_phone_auth', $array))
            $model->phone_auth = $array['is_phone_auth'];
        if (array_key_exists('is_email_auth', $array))
            $model->email_auth = $array['is_email_auth'];
        $model->company_qualification=$array['company_qualification'];
        $model->company_regtime=$array['company_regtime'];
        $model->company_scale=$array['company_scale'];
        return $model;
    }

    /**
     * 将数组转换位HOME_AGENT_PROFILE对象
     * @param <array> $array
     */
    public static function array_to_home_agent_profile_model($array) {
        $model = new home_agent_profile_model();
        $model->id = $array['human_id'];
        $model->name = $array['name'];
        $model->gender = $array['gender'];
        $model->province = $array['addr_province_code'];
        $model->city = $array['addr_city_code'];
        $model->company = $array['company_name'];
        $model->phone = $array['contact_mobile'];
        $model->email = $array['contact_email'];
        $model->qq = $array['contact_qq'];
        $model->summary = $array['introduce'];
        $model->photo = C('FILE_ROOT') . $array['photo'];
        if (array_key_exists('user_id', $array))
            $model->user_id = $array['user_id'];
        if (array_key_exists('is_real_auth', $array))
            $model->real_auth = $array['is_real_auth'];
        if (array_key_exists('is_phone_auth', $array))
            $model->phone_auth = $array['is_phone_auth'];
        if (array_key_exists('is_email_auth', $array))
            $model->email_auth = $array['is_email_auth'];
        return $model;
    }

    public static function array_to_home_agent_statistics_model($array) {
        $model = new home_agent_statistics_model();
        $model->view = $array['view'];
        $model->praise = $array['praise'];
        $model->score = $array['score'];
        return $model;
    }
    
    public static function array_to_home_human_degree_model($array) {
        $model = new home_human_degree_model();
        $model->degree_id = $array['degree_id'];
        $model->degree_name = array($array['degree_name'], degree_format($array['degree_name']));
        $model->major_name = $array['major_name'];
        $model->school = $array['school'];
        $format = 'Y-m-d';
        $stamp = strtotime($array['study_enddate']);
        if ($stamp) {
            $model->study_enddate = date_f($format, $stamp);
        } else {
            $model->study_enddate = '';
        }
        $stamp = strtotime($array['study_startdate']);
        if ($stamp) {
            $model->study_startdate = date_f($format, $stamp);
        } else {
            $model->study_startdate = '';
        }

        return $model;
    }

    public static function array_to_home_human_grade_certificate_model($array) {
        $model = new home_human_grade_certificate_model();
        $model->certificate_id = $array['certificate_id'];
        $model->grade_certificate_id = $array['grade_certificate_id'];
        $model->grade_certificate_class_name = GC_C_format($array['grade_certificate_class']);
        $model->grade_certificate_class = $array['grade_certificate_class'];
        $model->grade_certificate_major = $array['grade_certificate_major'];
        $model->grade_certificate_type = $array['grade_certificate_type'];
        return $model;
    }

    public static function array_to_home_human_jobIntent_model($array) {
        $model = new home_human_jobIntent_model();
        $model->job_intent_id = $array['job_intent_id'];
        $profileService = new ProfileService();
        $model->job_city_code = $array['job_city_code'];
        if (!empty($model->job_city_code)) {
            $city = $profileService->get_city($model->job_city_code);
            $model->job_city = $city['name'];
        }
        $model->job_describle = $array['job_describle'];
        $model->job_name = $array['job_name'];
        $model->job_name_ids = $array['job_name_ids'];
        $model->job_province_code = $array['job_province_code'];
        if (!empty($model->job_province_code)) {
            $province = $profileService->get_province($model->job_province_code);
            $model->job_province = $province['name'];
        }
        $model->job_salary = array($array['job_salary'], salary_format($array['job_salary'], $array['input_salary']));
        $model->salary_unit = $array['salary_unit'];
        return $model;
    }

    public static function array_to_home_human_projectAchievement_model($array) {
        $model = new home_human_projectAchievement_model();
        $model->project_achievement_id = $array['project_achievement_id'];
        $format = 'Y-m-d';
        $stamp = strtotime($array['end_date']);
        if ($stamp) {
            $model->end_date = date_f($format, $stamp);
        } else {
            $model->end_date = '';
        }
        $model->job_describle = $array['job_describle'];
        $model->job_name = $array['job_name'];
        $model->name = $array['name'];
        $model->scale = array($array['scale'], project_scale_format($array['scale']));
        $stamp = strtotime($array['start_date']);
        if ($stamp) {
            $model->start_date = date_f($format, $stamp);
        } else {
            $model->start_date = '';
        }
        return $model;
    }

    public static function array_to_home_human_register_certificate_model($array) {
        $model = new home_human_register_certificate_model();
        $model->certificate_id = $array['certificate_id'];
        $model->class = $array['class'];
        $model->register_case = registerCase_format($array['register_case']);
        $model->register_certificate_major = $array['register_certificate_major'];
        if (empty($model->register_certificate_major)) {
            $model->register_certificate_major = '';
        }
        $model->register_certificate_name = $array['register_certificate_name'];
        $profileService = new ProfileService();
        $model->register_place = $array['register_place'];
        if (!empty($model->register_place)) {
            $province = $profileService->get_province($model->register_place);
            $model->register_place = $province['name'];
        }
        return $model;
    }

    public static function array_to_home_human_resume_model($array) {
        $model = new home_human_resume_model();
        $model->resume_id = $array['resume_id'];
        $model->human = ViewModelMap::array_to_home_human_profile_model($array['human']);
        $model->degree = ViewModelMap::array_to_home_human_degree_model($array['degree']);
        $grade_certificate_list = FactoryVMap::list_to_models($array['grade_certificate_list'], 'home_human_grade_certificate');
        $model->grade_certificate = $grade_certificate_list[0];
        $model->job_intent = ViewModelMap::array_to_home_human_jobIntent_model($array['job_intent']);
        $model->project_achievement_list = FactoryVMap::list_to_models($array['project_achievement_list'], 'home_human_projectAchievement');
        $model->register_certificate_list = FactoryVMap::list_to_models($array['register_certificate_list'], 'home_human_register_certificate');
        $model->work_exp_list = FactoryVMap::list_to_models($array['work_exp_list'], 'home_human_workExp');
        $model->certificate_remark = $array['human']['certificate_remark'];
        $model->agent_id = $array['agent_id'];
        $model->publisher_id = $array['publisher_id'];
        $model->job_category = $array['job_category'];
        $model->resume_status = $array['resume_status'];
        $model->read_count = $array['read_count'];
        return $model;
    }

    public static function array_to_home_human_workExp_model($array) {
        $model = new home_human_workExp_model();
        $model->work_exp_id = $array['work_exp_id'];
        $model->company_industry = $array['company_industry'];
        $model->company_name = $array['company_name'];
        $model->company_property = array($array['company_property'], cc_format($array['company_property']));
        $model->company_scale = array($array['company_scale'], company_scale_format($array['company_scale']));
        $model->department = $array['department'];
        $model->job_describle = $array['job_describle'];
        $model->job_name = $array['job_name'];
        $format = 'Y-m-d';
        $stamp = strtotime($array['work_enddate']);
        if ($stamp) {
            $model->work_enddate = date_f($format, $stamp);
        } else {
            $model->work_enddate = '';
        }
        $stamp = strtotime($array['work_startdate']);
        if ($stamp) {
            $model->work_startdate = date_f($format, $stamp);
        } else {
            $model->work_enddate = '';
        }
        return $model;
    }

    public static function array_to_home_human_gc_major_model($array) {
        $model = new home_human_GC_major_model();
        $model->grade_certificate_id = $array['grade_certificate_id'];
        $model->major = $array['major'];
        return $model;
    }

    public static function array_to_home_human_gc_type_model($array) {
        $model = new home_human_GC_type_model();
        $model->grade_certificate_type_id = $array['grade_certificate_type_id'];
        $model->grade_certificate_type = $array['grade_certificate_type'];
        return $model;
    }

    public static function array_to_home_human_rc_info_model($array) {
        $model = new home_human_RC_info_model();
        $model->register_certificate_info_id = $array['register_certificate_info_id'];
        $model->name = $array['name'];
        return $model;
    }

    public static function array_to_home_human_rc_major_model($array) {
        $model = new home_human_RC_major_model();
        $model->register_certificate_id = $array['register_certificate_id'];
        $model->name = $array['name'];
        return $model;
    }

    public static function array_to_home_cert_register_model($array) {
        $model = new home_cert_normal_model();
        $model->id = intval($array['register_certificate_info_id']);
        $model->name = $array['name'];
        return $model;
    }

    public static function array_to_home_rcert_major_model($array) {
        $model = new home_cert_normal_model();
        $model->id = intval($array['register_certificate_id']);
        $model->name = $array['name'];
        return $model;
    }

    public static function array_to_home_hcert_register_model($array) {
        $model = new home_cert_human_model();
        $model->id = $array['certificate_id'];
        $model->status = $array['status'];
        $model->name = $array['register_certificate_name'];
        if (!empty($array['register_certificate_major']))
            $model->name .= ' - ' . $array['register_certificate_major'];
        $model->name .= ' - ' . registerCase_format($array['register_case']);
        return $model;
    }

    public static function array_to_home_hcert_grade_model($array) {
        $model = new home_cert_human_model();
        $model->id = $array['certificate_id'];
        $model->status = $array['status'];
        $model->name = GC_C_format($array['grade_certificate_class']) . ' - ' . $array['grade_certificate_type'] . ' - ' . $array['grade_certificate_major'];
        return $model;
    }

    public static function array_to_home_gcert_type_model($array) {
        $model = new home_cert_normal_model();
        $model->id = intval($array['grade_certificate_type_id']);
        $model->name = $array['grade_certificate_type'];
        return $model;
    }

    public static function array_to_home_grade_cert_model($array) {
        $model = new home_cert_normal_model();
        $model->id = intval($array['grade_certificate_id']);
        $model->name = $array['major'];
        return $model;
    }

    public static function array_to_home_human_hc_resume_model($array) {
        $model = new home_human_HC_resume_model();
        $model->certificate_remark = $array['human']['certificate_remark'];
        $grade_certificate_list = FactoryVMap::list_to_models($array['grade_certificate_list'], 'home_human_grade_certificate');
        $model->grade_certificate = $grade_certificate_list[0];
        $model->register_certificate_list = FactoryVMap::list_to_models($array['register_certificate_list'], 'home_human_register_certificate');
        $model->human = ViewModelMap::array_to_home_human_profile_model($array['human']);
        $model->job_salary = array($array['job_salary'], salary_format($array['job_salary'], $array['input_salary']));
        $model->register_province_ids = $array['register_province_ids'];
        $profileService = new ProfileService();
        if (!empty($array['register_province_ids'])) {
            $provinces = $profileService->get_province_list($array['register_province_ids']);
            $count = count($provinces);
            foreach ($provinces as $key => $province) {
                $model->register_provinces.=$province['name'];
                if ($key < $count - 1) {
                    $model->register_provinces.='、';
                }
            }
        } else {
            $model->register_provinces = '';
        }
        $model->resume_id = $array['resume_id'];
        $model->salary_unit = $array['salary_unit'];
        $model->agent_id = $array['agent_id'];
        $model->job_category = $array['job_category'];
        $model->publisher_id = $array['publisher_id'];
        $model->resume_status = $array['resume_status'];
        return $model;
    }

    public static function array_to_home_agent_type_model($array) {
        $model = new home_agent_type_model();
        $model->id = $array['service_category_id'];
        $model->name = $array['name'];
        return $model;
    }

    public static function array_to_home_resume_job_model($array) {
        $model = new home_resume_simple_model();
        $model->send_resume_id = $array['send_resume_id'];
        $model->user_id = intval($array['sender_id']);
        $model->name = $array['name'];
        $model->photo = C('FILE_ROOT') . $array['photo'];
        $model->h_name = resume_title_format($array['role_id'] == C('ROLE_AGENT') ? 1 : 0, $array['category'], $array['resume_id']);
        $model->salary = year_salary($array['job_salary']);
        $model->role = intval($array['role_id']);
        $model->date = cdate_format($array['send_datetime']);
        $model->type = $array['category'];
        $model->h_id = $array['human_id'];
        $model->follow = $array['follow'];
        foreach ($array['certs'] as $cert) {
            $temp = $cert['register_certificate_name'];
            if (!empty($cert['register_certificate_major']))
                $temp .= ' - ' . $cert['register_certificate_major'];
            switch ($cert['register_case']) {
                case 1 : $temp .= ' - 初始注册';
                    break;
                case 2 : $temp .= ' - 变更注册';
                    break;
                case 3 : $temp .= ' - 重新注册';
                    break;
            }
            $certs[] = $temp;
        }
        $model->cert = $certs;
        $model->real_auth = $array['is_real_auth'];
        $model->phone_auth = $array['is_phone_auth'];
        $model->email_auth = $array['is_email_auth'];
        if (array_key_exists('exp', $array))
            $model->exp = exp_format($array['exp']);
        if (array_key_exists('place', $array))
            $model->place = $array['place'];
        $model->pos = $array['job_name'];
        $profileService = new ProfileService();
        $province = $profileService->get_province($array['job_province_code']);
        $city = $profileService->get_city($array['job_city_code']);
        $model->location = $province['name'] . ' - ' . $city['name'];
//        if ($array['is_real_auth'] == 1) {
//            $model->real_auth = C('FILE_ROOT') . C('AUTH_REAL_OK');
//        } else {
//            $model->real_auth = C('FILE_ROOT') . C('AUTH_REAL_NO');
//        }
//        if ($array['is_phone_auth'] == 1) {
//            $model->phone_auth = C('FILE_ROOT') . C('AUTH_PHONE_OK');
//        } else {
//            $model->phone_auth = C('FILE_ROOT') . C('AUTH_PHONE_NO');
//        }
//        if ($array['is_email_auth'] == 1) {
//            $model->email_auth = C('FILE_ROOT') . C('AUTH_EMAIL_OK');
//        } else {
//            $model->email_auth = C('FILE_ROOT') . C('AUTH_EMAIL_NO');
//        }
        return $model;
    }

    public static function array_to_home_resume_read_model($array) {
        $model = new home_resume_simple_model();
        $job_category = $array['job_category'];
        $model->type = $job_category;
        $model->real_auth = $array['is_real_auth'];
        $model->phone_auth = $array['is_phone_auth'];
        $model->email_auth = $array['is_email_auth'];
//        if ($array['is_email_auth'] == 1) {
//            $model->email_auth = C('FILE_ROOT') . C('AUTH_EMAIL_OK');
//        } else {
//            $model->email_auth = C('FILE_ROOT') . C('AUTH_EMAIL_NO');
//        }
//        if ($array['is_phone_auth'] == 1) {
//            $model->phone_auth = C('FILE_ROOT') . C('AUTH_PHONE_OK');
//        } else {
//            $model->phone_auth = C('FILE_ROOT') . C('AUTH_PHONE_NO');
//        }
//        if ($array['is_real_auth'] == 1) {
//            $model->real_auth = C('FILE_ROOT') . C('AUTH_REAL_OK');
//        } else {
//            $model->real_auth = C('FILE_ROOT') . C('AUTH_REAL_NO');
//        }
        $model->name = $array['name'];
        $model->resume_id = $array['resume_id'];
        $model->user_id = $array['user_id'];
        $model->h_id = $array['human_id'];
        $model->photo = C('FILE_ROOT') . $array['photo'];
        $model->role = $array['role_id'];
        $model->date = cdate_format($array['read_datetime']);
        $model->h_name = $array['h_name'];
        $model->follow = $array['follow'];
        $profileService = new ProfileService();
        $model->cert = FactoryVMap::list_to_models($array['cert'], 'home_human_register_certificate');
        foreach ($model->cert as $key => $rc) {
            $model->cert[$key] = $rc->register_certificate_name;
            if (!empty($rc->register_certificate_major)) {
                $model->cert[$key].=(' - ' . $rc->register_certificate_major);
            }
            $model->cert[$key].=(' - ' . $rc->register_case . ' - ' . $rc->register_place);
        }
        if ($job_category == 1) {
            $province = $profileService->get_province($array['job_province_code']);
            $city = $profileService->get_city($array['job_city_code']);
            $model->place = $province['name'] . ' - ' . $city['name'];
            $model->exp = exp_format($array['work_age']);
            $model->salary = year_salary($array['fsalary']);
        } else if ($job_category == 2) {
            $model->place = $array['register_province_ids'];
            if (!empty($model->place)) {
                $provinces = $profileService->get_province_list($model->place);
                $count = count($provinces);
                $model->place = '';
                foreach ($provinces as $key => $province) {
                    $model->place.=$province['name'];
                    if ($key < $count - 1) {
                        $model->place.='、';
                    }
                }
            }
            else{
                $model->place = '不限';
            }
            $model->salary = year_salary($array['psalary']);
        }
        return $model;
    }

    public static function array_to_home_recommend_job_certificate_model($array) {
        $model = new home_recommend_job_certificate_model();
        $model->RC_count = $array['count'];
        $model->class = $array['class'];
        $model->id = $array['id'];
        $model->register_case = registerCase_format($array['status']);
        if (empty($array['register_certificate_major'])) {
            $model->register_certificate_major = 0;
        } else {
            $model->register_certificate_major = $array['register_certificate_major'];
        }
        $model->register_certificate_name = $array['register_certificate_name'];
        return $model;
    }

    public static function array_to_home_recommend_job_model($array) {
        $model = new home_recommend_job_model();
        $job_category = $array['job_category'];
        $model->company_name = $array['company_name'];
        $model->job_id = $array['job_id'];
        $model->job_title = $array['job_title'];
        $model->follow = $array['follow'];
        $model->real_auth = $array['is_real_auth'];
        $model->phone_auth = $array['is_phone_auth'];
        $model->email_auth = $array['is_email_auth'];
//        if ($array['is_email_auth'] == 1) {
//            $model->publisher_auth_email = C('FILE_ROOT') . C('AUTH_EMAIL_OK');
//        } else {
//            $model->publisher_auth_email = C('FILE_ROOT') . C('AUTH_EMAIL_NO');
//        }
//        if ($array['is_phone_auth'] == 1) {
//            $model->publisher_auth_phone = C('FILE_ROOT') . C('AUTH_PHONE_OK');
//        } else {
//            $model->publisher_auth_phone = C('FILE_ROOT') . C('AUTH_PHONE_NO');
//        }
//        if ($array['is_real_auth'] == 1) {
//            $model->publisher_auth_real = C('FILE_ROOT') . C('AUTH_REAL_OK');
//        } else {
//            $model->publisher_auth_real = C('FILE_ROOT') . C('AUTH_REAL_NO');
//        }
        $model->publisher_id = $array['publisher_id'];
        $model->publisher_name = $array['name'];
        $model->publisher_role = $array['publisher_role'];
        $model->pub_datetime = cdate_format($array['pub_datetime']);
        $model->publisher_photo = C('FILE_ROOT') . $array['photo'];
        $model->job_category = $job_category;
        $model->job_salary = salary_format($array['job_salary'], $array['input_salary']);
        $model->salary_unit = $array['salary_unit'];
        $profileService = new ProfileService();
        //1为全职，2为兼职
        if ($job_category == 1) {
            $model->degree = degree_format($array['degree']);
            if (!empty($array['job_province_code'])) {
                $province = $profileService->get_province($array['job_province_code']);
                $model->job_province_code = $province['name'];
            } else {
                $model->job_province_code = '不限';
            }
            if (!empty($array['job_city_code'])) {
                $city = $profileService->get_city($array['job_city_code']);
                $model->job_city_code = $city['name'];
            } else {
                $model->job_city_code = '不限';
            }
            $model->job_count = $array['count'];
            $model->job_name = $array['job_name'];
        } else if ($job_category == 2) {
            $province = $profileService->get_province($array['job_province_code']);
            $model->C_use_place = $province['name'];
            if (!empty($array['require_place'])) {
                $provinces = $profileService->get_province_list($array['require_place']);
                $count = count($provinces);
                foreach ($provinces as $key => $province) {
                    $model->require_place.=$province['name'];
                    if ($key < $count - 1) {
                        $model->require_place.='、';
                    }
                }
            } else {
                $model->require_place = '不限';
            }
        }
        $model->RC_list = FactoryVMap::list_to_models($array['job_certificate_list'], 'home_recommend_job_certificate');
        foreach ($model->RC_list as $key => $rc) {
            $model->RC_list[$key] = $rc->register_certificate_name;
            if (!empty($rc->register_certificate_major)) {
                $model->RC_list[$key].=(' - ' . $rc->register_certificate_major);
            }
            $model->RC_list[$key].=(' - ' . $rc->register_case);
            if ($rc->RC_count > 0)
                $model->RC_list[$key].= ' - ' . $rc->RC_count . '人';
        }
        return $model;
    }

    public static function array_to_home_job_simple_model($array) {
        $model = new home_job_list_model();
        $model->id = $array['job_id'];
        $model->title = $array['title'];
        $model->category = $array['job_category'];
        $model->salary = salary_format($array['job_salary'], $array['input_salary']);
        $model->name = $array['job_name'];
        $model->degree = degree_format($array['degree']);
        $model->count = $array['count'];
        $model->status = $array['status'];
        $model->date = cdate_format($array['date']);
        $service = new ProfileService();
        $province = $service->get_province($array['job_province_code']);
        if (!empty($array['job_city_code'])) {
            $city = $service->get_city($array['job_city_code']);
            $model->location = $province['name'] . ' - ' . $city['name'];
        } else {
            $model->location = $province['name'];
        }
        if (!empty($array['require_place'])) {
            $pids = explode(',', $array['require_place']);
            foreach ($pids as $pid) {
                $pro = $service->get_province($pid);
                if (!empty($pro))
                    $place .= $pro['name'] . '、';
            }
            if (!empty($place)) {
                $model->place = rtrim($place, '、');
            }
        }
        if (empty($model->place)) {
            $model->place = '不限';
        }
        return $model;
    }

    public static function array_to_home_job_list_model($array) {
        $model = new home_job_list_model();
        $model->id = $array['job_id'];
        $model->title = $array['title'];
        $model->company = $array['company_name'];
        $model->category = $array['job_category'];
        $model->salary = salary_format($array['job_salary'], $array['input_salary']);
        $model->name = $array['job_name'];
        $model->degree = degree_format($array['degree']);
        $model->count = $array['count'];
        $model->r_count = $array['r_count'];
        $model->status = $array['status'];
        $model->date = cdate_format($array['date']);
        if (array_key_exists('_promote', $array))
            $model->promote = $array['_promote'];           //是否已推广
        foreach ($array['certs'] as $cert) {
            $temp = $cert['register_certificate_name'];
            if (!empty($cert['register_certificate_major']))
                $temp .= ' - ' . $cert['register_certificate_major'];
            switch ($cert['status']) {
                case 1 : $temp .= ' - 初始注册';
                    break;
                case 2 : $temp .= ' - 变更注册';
                    break;
                case 3 : $temp .= ' - 重新注册';
                    break;
            }
            if ($cert['count'] > 0)
                $temp .= ' - ' . $cert['count'] . '人';
            $certs[] = $temp;
        }
        $model->cert = $certs;
        $service = new ProfileService();
        $province = $service->get_province($array['job_province_code']);
        if (!empty($array['job_city_code'])) {
            $city = $service->get_city($array['job_city_code']);
            $model->location = $province['name'] . ' - ' . $city['name'];
        } else {
            $model->location = $province['name'];
        }
        if (!empty($array['require_place'])) {
            $pids = explode(',', $array['require_place']);
            $first=true;
            foreach ($pids as $pid) {
                $pro = $service->get_province($pid);
                if ($first){
                   $model->place  .=$pro['name'];
                   $first=false;
                }else{
                   $model->place  .= '、'.$pro['name'];
                }
            }
        }
        if (empty($model->place)) {
            $model->place = '不限';
        }
        if (array_key_exists('agent_id', $array))
            $model->agent_id = $array['agent_id'];
        if (array_key_exists('agent_name', $array))
            $model->agent = $array['agent_name'];
        return $model;
    }

    public static function array_to_home_job_agented_model($array) {
        $model = new home_job_agented_model();
        $model->main_role = C('ROLE_ENTERPRISE');       //委托方角色编号（暂时只有企业）
        $model->id = $array['job_id'];
        $model->title = $array['title'];
        $model->company = $array['company_name'];
        $model->category = $array['job_category'];
        $model->salary = salary_format($array['job_salary'], $array['input_salary']);
        $model->name = $array['job_name'];
        $model->degree = degree_format($array['degree']);
        $model->count = $array['count'];
        $model->r_count = $array['r_count'];
        $model->status = $array['status'];
        $model->date = cdate_format($array['date']);
        $model->u_id = $array['user_id'];
        $model->u_name = $array['name'];
        $model->u_photo = C('FILE_ROOT') . $array['photo'];
        $model->follow = $array['follow'];
        $model->real_auth = $array['is_real_auth'];
        $model->phone_auth = $array['is_phone_auth'];
        $model->email_auth = $array['is_email_auth'];
//        if ($array['is_real_auth'] == 1) {
//            $model->real_auth = C('FILE_ROOT') . C('AUTH_REAL_OK');
//        } else {
//            $model->real_auth = C('FILE_ROOT') . C('AUTH_REAL_NO');
//        }
//        if ($array['is_phone_auth'] == 1) {
//            $model->phone_auth = C('FILE_ROOT') . C('AUTH_PHONE_OK');
//        } else {
//            $model->phone_auth = C('FILE_ROOT') . C('AUTH_PHONE_NO');
//        }
//        if ($array['is_email_auth'] == 1) {
//            $model->email_auth = C('FILE_ROOT') . C('AUTH_EMAIL_OK');
//        } else {
//            $model->email_auth = C('FILE_ROOT') . C('AUTH_EMAIL_NO');
//        }
        foreach ($array['certs'] as $cert) {
            $temp = $cert['register_certificate_name'];
            if (!empty($cert['register_certificate_major']))
                $temp .= ' - ' . $cert['register_certificate_major'];
            switch ($cert['status']) {
                case 1 : $temp .= ' - 初始注册';
                    break;
                case 2 : $temp .= ' - 变更注册';
                    break;
                case 3 : $temp .= ' - 重新注册';
                    break;
            }
            if ($cert['count'] > 0)
                $temp .= ' - ' . $cert['count'] . '人';
            $certs[] = $temp;
        }
        $model->cert = $certs;
        $service = new ProfileService();
        $province = $service->get_province($array['job_province_code']);
        if (!empty($array['job_city_code'])) {
            $city = $service->get_city($array['job_city_code']);
            $model->location = $province['name'] . ' - ' . $city['name'];
        } else {
            $model->location = $province['name'];
        }
        if (!empty($array['require_place'])) {
            $pids = explode(',', $array['require_place']);
            foreach ($pids as $pid) {
                $pro = $service->get_province($pid);
                if (!empty($pro))
                    $place .= $pro['name'] . '、';
            }
            if (!empty($place)) {
                $model->place = rtrim($place, '、');
            }
        }
        if (empty($model->place)) {
            $model->place = '不限';
        }
        if (array_key_exists('_promote', $array))
            $model->promote = $array['_promote'];           //是否已推广
        return $model;
    }

    public static function array_to_home_job_detail_model($array) {
        $model = new home_job_detail_model();
        $model->id = $array['job_id'];
        $model->title = $array['title'];
        $model->company = $array['company_name'];
        $model->category = $array['job_category'];
        $model->state = jstate_format($array['job_state']);
        $model->name = $array['job_name'];
        $model->degree = degree_format($array['degree']);
        $model->count = $array['count'];
        $model->salary = salary_format($array['job_salary'], $array['input_salary']);
        $model->date = cdate_format($array['pub_datetime']);
        $model->status = $array['status'];
        $model->descript = $array['job_describle'];
        $model->exp = exp_format($array['job_exp']);
        $model->bcard = $array['safety_b_card'] ? '是' : '否';
        $model->muti = $array['muti_certificate'] ? '是' : '否';
        $model->follow = $array['follow'];
        $model->read_count = $array['read_count'];
        switch ($array['social_security']) {
            case 2 : $model->social = '需缴纳';
                break;
            case 3 : $model->social = '不需缴纳';
                break;
            default : $model->social = '不限';
        }
        $service = new ProfileService();
        $province = $service->get_province($array['job_province_code']);
        if (!empty($array['job_city_code'])) {
            $city = $service->get_city($array['job_city_code']);
            $model->location = $province['name'] . ' - ' . $city['name'];
        } else {
            $model->location = $province['name'];
        }
        if (!empty($array['require_place'])) {
            $pids = explode(',', $array['require_place']);
            foreach ($pids as $pid) {
                $pro = $service->get_province($pid);
                if (!empty($pro))
                    $place .= $pro['name'] . '、';
            }
            if (!empty($place)) {
                $model->place = rtrim($place, '、');
            }
        }
        if (empty($model->place)) {
            $model->place = '不限';
        }
        foreach ($array['certs'] as $cert) {
            $temp = $cert['register_certificate_name'];
            if (!empty($cert['register_certificate_major']))
                $temp .= ' - ' . $cert['register_certificate_major'];
            switch ($cert['status']) {
                case 1 : $temp .= ' - 初始注册';
                    break;
                case 2 : $temp .= ' - 变更注册';
                    break;
                case 3 : $temp .= ' - 重新注册';
                    break;
            }
            if ($cert['count'] > 0)
                $temp .= ' - ' . $cert['count'] . '人';
            $certs[] = $temp;
        }
        $model->cert = $certs;
        if (array_key_exists('gcert', $array)) {
            switch ($array['grade_certificate_class']) {
                case 2 : $gcert = '中级';
                    break;
                case 3 : $gcert = '高级';
                    break;
                default: $gcert = '初级';
                    break;
            }
            $model->gcert = $gcert . ' - ' . $array['gcert']['grade_certificate_type'] . ' ' . $array['gcert']['major'];
        }
        if (array_key_exists('pub_model', $array)) {
            $model->pub_model = $array['pub_model'];
            $model->is_agent = 0;
        }
        if (array_key_exists('agent_model', $array)) {
            $model->agent_model = $array['agent_model'];
            $model->is_agent = 1;
        }
        $model->job_agent = empty($array['agent_id']) ? 0 : 1;
        $model->job_type=$array['job_type'];
        $model->company_qualification=$array['company_qualification'];
        $model->company_category=cc_format($array['company_category']);
        $model->company_regtime= nt_date_format($array['company_regtime']);
        $model->company_scale= company_scale_format($array['company_scale']);
        $model->company_introduce=$array['company_introduce'];
        return $model;
    }

    public static function array_to_home_agent_detail_model($array) {
        $model = new home_agent_detail_model();
        $model->praise = $array['praise'];      //被赞次数
        $model->id = $array['data_id'];
        $model->user_id = $array['user_id'];
        $model->name = $array['name'];
        $model->photo = C('FILE_ROOT') . $array['photo'];
        $model->follow = $array['follow'];
        $model->view = $array['view'];
        if (!empty($array['addr_province_code'])) {
            $service = new ProfileService();
            $province = $service->get_province($array['addr_province_code']);
            if (!empty($array['addr_city_code'])) {
                $city = $service->get_city($array['addr_city_code']);
                $model->location = $province['name'] . ' - ' . $city['name'];
            } else {
                $model->location = $province['name'];
            }
        } else {
            $model->location = '不限';
        }
        $service = new MiddleManService();
        $ses = $service->get_agent_services($array['data_id']);
        if (empty($ses)) {
            $model->service = '暂无';
        } else {
            foreach ($ses as $se) {
                $model->service .= $se['name'] . '、';
            }
            $model->service = rtrim($model->service, '、');
        }
        $model->company = empty($array['company_name']) ? '无' : $array['company_name'];
        $model->summary = empty($array['introduce']) ? '您好！本人从事建筑行业猎头工作，我将竭诚为您服务！' : $array['introduce'];
        $userService = new UserService();
        $model->activity = $userService->get_user_activity($array['user_id']);
        $model->real_auth = $array['is_real_auth'];
        $model->phone_auth = $array['is_phone_auth'];
        $model->email_auth = $array['is_email_auth'];
//        if ($array['is_real_auth'] == 1) {
//            $model->real_auth = C('FILE_ROOT') . C('AUTH_REAL_OK');
//        } else {
//            $model->real_auth = C('FILE_ROOT') . C('AUTH_REAL_NO');
//        }
//        if ($array['is_phone_auth'] == 1) {
//            $model->phone_auth = C('FILE_ROOT') . C('AUTH_PHONE_OK');
//        } else {
//            $model->phone_auth = C('FILE_ROOT') . C('AUTH_PHONE_NO');
//        }
//        if ($array['is_email_auth'] == 1) {
//            $model->email_auth = C('FILE_ROOT') . C('AUTH_EMAIL_OK');
//        } else {
//            $model->email_auth = C('FILE_ROOT') . C('AUTH_EMAIL_NO');
//        }
        return $model;
    }

    public static function array_to_home_company_detail_model($array) {
        $model = new home_company_detail_model();
        $model->id = $array['data_id'];
        $model->user_id = $array['user_id'];
        $model->name = $array['company_name'];
        $model->cname = $array['contact_name'];
        $model->summary = $array['introduce'];
        $model->photo = C('FILE_ROOT') . $array['photo'];
        $model->category = cc_format($array['company_category']);
        $model->follow = $array['follow'];
        $model->view = $array['view'];
        $model->real_auth = $array['is_real_auth'];
        $model->phone_auth = $array['is_phone_auth'];
        $model->email_auth = $array['is_email_auth'];
        if (!empty($array['company_province_code'])) {
            $service = new ProfileService();
            $province = $service->get_province($array['company_province_code']);
            if (!empty($array['company_city_code'])) {
                $city = $service->get_city($array['company_city_code']);
                $model->location = $province['name'] . ' - ' . $city['name'];
            } else {
                $model->location = $province['name'];
            }
        } else {
            $model->location = '';
        }
//        if ($array['is_real_auth'] == 1) {
//            $model->real_auth = C('FILE_ROOT') . C('AUTH_REAL_OK');
//        } else {
//            $model->real_auth = C('FILE_ROOT') . C('AUTH_REAL_NO');
//        }
//        if ($array['is_phone_auth'] == 1) {
//            $model->phone_auth = C('FILE_ROOT') . C('AUTH_PHONE_OK');
//        } else {
//            $model->phone_auth = C('FILE_ROOT') . C('AUTH_PHONE_NO');
//        }
//        if ($array['is_email_auth'] == 1) {
//            $model->email_auth = C('FILE_ROOT') . C('AUTH_EMAIL_OK');
//        } else {
//            $model->email_auth = C('FILE_ROOT') . C('AUTH_EMAIL_NO');
//        }
        return $model;
    }

    public static function array_to_home_user_base_model($array) {
        $model = new home_user_base_model();
        $model->id = $array['user_id'];
        $model->name = $array['name'];
        $model->photo = C('FILE_ROOT') . $array['photo'];
        $model->role_id = $array['role_id'];
        $model->real_auth = $array['is_real_auth'];
        $model->phone_auth = $array['is_phone_auth'];
        $model->email_auth = $array['is_email_auth'];
//        if (array_key_exists('is_real_auth', $array)) {
//            if ($array['is_real_auth'] == 1) {
//                $model->real_auth = C('FILE_ROOT') . C('AUTH_REAL_OK');
//            } else {
//                $model->real_auth = C('FILE_ROOT') . C('AUTH_REAL_NO');
//            }
//            if ($array['is_phone_auth'] == 1) {
//                $model->phone_auth = C('FILE_ROOT') . C('AUTH_PHONE_OK');
//            } else {
//                $model->phone_auth = C('FILE_ROOT') . C('AUTH_PHONE_NO');
//            }
//            if ($array['is_email_auth'] == 1) {
//                $model->email_auth = C('FILE_ROOT') . C('AUTH_EMAIL_OK');
//            } else {
//                $model->email_auth = C('FILE_ROOT') . C('AUTH_EMAIL_NO');
//            }
//        }
        return $model;
    }

    public static function array_to_home_recommend_human_model($array) {
        $model = new home_recommend_human_model();
        $job_category = $array['job_category'];
        $model->RC_list = FactoryVMap::list_to_models($array['RC_list'], 'home_human_register_certificate');
        foreach ($model->RC_list as $key => $rc) {
            $model->RC_list[$key] = $rc->register_certificate_name;
            if (!empty($rc->register_certificate_major)) {
                $model->RC_list[$key].=(' - ' . $rc->register_certificate_major);
            }
            $model->RC_list[$key].=(' - ' . $rc->register_case . ' - ' . $rc->register_place);
        }
        $model->human_name = resume_title_format($array['role_id'] == C('ROLE_AGENT'), $job_category, $array['resume_id']); //$array['human_name'];
        $model->human_id = $array['human_id'];
        $model->job_category = $job_category;
        $model->follow = $array['follow'];
        $model->real_auth = $array['is_real_auth'];
        $model->phone_auth = $array['is_phone_auth'];
        $model->email_auth = $array['is_email_auth'];
//        if ($array['is_email_auth'] == 1) {
//            $model->publisher_auth_email = C('FILE_ROOT') . C('AUTH_EMAIL_OK');
//        } else {
//            $model->publisher_auth_email = C('FILE_ROOT') . C('AUTH_EMAIL_NO');
//        }
//        if ($array['is_phone_auth'] == 1) {
//            $model->publisher_auth_phone = C('FILE_ROOT') . C('AUTH_PHONE_OK');
//        } else {
//            $model->publisher_auth_phone = C('FILE_ROOT') . C('AUTH_PHONE_NO');
//        }
//        if ($array['is_real_auth'] == 1) {
//            $model->publisher_auth_real = C('FILE_ROOT') . C('AUTH_REAL_OK');
//        } else {
//            $model->publisher_auth_real = C('FILE_ROOT') . C('AUTH_REAL_NO');
//        }
        $model->publisher_id = $array['user_id'];
        $model->publisher_name = $array['name'];
        $model->publisher_role = $array['role_id'];
        $model->publisher_photo = C('FILE_ROOT') . $array['photo'];
        $model->resume_id = $array['resume_id'];
        $model->update_datetime = cdate_format($array['update_datetime']);
        $profileService = new ProfileService();
        //1为全职，2为兼职
        if ($job_category == 1) {
            $model->human_work_age = exp_format($array['work_age']);
            $model->work_addr = '不限';
            if (!empty($array['job_province_code'])) {
                $province = $profileService->get_province($array['job_province_code']);
                $model->work_addr = $province['name'];
                if (!empty($array['job_city_code'])) {
                    $city = $profileService->get_city($array['job_city_code']);
                    $model->work_addr.=' - ' . $city['name'];
                }
            }
            $model->job_name = $array['job_name'];
            $model->job_salary = salary_format($array['job_salary'], $array['input_salary']);
            //$model->salary_unit=$array['salary_unit'];
        } else {
            if (!empty($array['register_province_ids'])) {
                $provinces = $profileService->get_province_list($array['register_province_ids']);
                $count = count($provinces);
                foreach ($provinces as $key => $province) {
                    $model->register_province_ids.=$province['name'];
                    if ($key < $count - 1) {
                        $model->register_province_ids.='、';
                    }
                }
            } else {
                $model->register_province_ids = '不限';
            }
//            $model->job_salary = year_salary($array['hang_card_salary']);
            //待遇修改
            $model->job_salary = salary_format($array['hang_card_salary'], $array['hang_input_salary']);
            $model->salary_unit = $array['hang_salary_unit'];
        }
        return $model;
    }

    public static function array_to_home_job_certificate_model($array) {
        $model = new home_job_certificate_model();
        $model->RC_count = $array['count'];
        $model->class = $array['class'];
        $model->id = $array['id'];
        $model->register_case = $array['status'];
        $model->register_certificate_major = $array['register_certificate_major'];
        $model->register_certificate_name = $array['register_certificate_name'];
        return $model;
    }

    public static function array_to_home_job_sent_model($array) {
        $model = new home_job_sent_model();
        $job_category = $array['job_category'];
        $model->id = $array['send_resume_id'];
        $model->company_name = $array['company_name'];
        $model->job_id = $array['job_id'];
        $model->job_title = $array['title'];
        $model->real_auth = $array['is_real_auth'];
        $model->phone_auth = $array['is_phone_auth'];
        $model->email_auth = $array['is_email_auth'];
//        if ($array['is_email_auth'] == 1) {
//            $model->publisher_auth_email = C('FILE_ROOT') . C('AUTH_EMAIL_OK');
//        } else {
//            $model->publisher_auth_email = C('FILE_ROOT') . C('AUTH_EMAIL_NO');
//        }
//        if ($array['is_phone_auth'] == 1) {
//            $model->publisher_auth_phone = C('FILE_ROOT') . C('AUTH_PHONE_OK');
//        } else {
//            $model->publisher_auth_phone = C('FILE_ROOT') . C('AUTH_PHONE_NO');
//        }
//        if ($array['is_real_auth'] == 1) {
//            $model->publisher_auth_real = C('FILE_ROOT') . C('AUTH_REAL_OK');
//        } else {
//            $model->publisher_auth_real = C('FILE_ROOT') . C('AUTH_REAL_NO');
//        }
        $model->publisher_id = $array['publisher_id'];
        $model->publisher_name = $array['name'];
        $model->publisher_role = $array['publisher_role'];
        $model->publisher_photo = C('FILE_ROOT') . $array['photo'];
        $model->job_category = $job_category;
        $model->job_salary = salary_format($array['job_salary'], $array['input_salary']);
        //$model->salary_unit=$array['salary_unit'];
        $model->send_datetime = cdate_format($array['send_datetime']);
        $profileService = new ProfileService();
        //1为全职，2为兼职
        if ($job_category == 1) {
            $model->degree = degree_format($array['degree']);
            $model->job_count = $array['count'];
            $model->job_name = $array['job_name'];
            $model->job_city_code = $array['job_city_code'];
            $model->job_province_code = $array['job_province_code'];
            if (!empty($model->job_province_code)) {
                $province = $profileService->get_province($model->job_province_code);
                $model->job_province_code = $province['name'];
            } else {
                $model->job_province_code = '不限';
            }
            if (!empty($model->job_city_code)) {
                $city = $profileService->get_city($model->job_city_code);
                $model->job_city_code = $city['name'];
            } else {
                $model->job_city_code = '不限';
            }
        } else if ($job_category == 2) {
            $province = $profileService->get_province($array['job_province_code']);
            $model->C_use_place = $province['name'];
            if (!empty($array['require_place'])) {
                $provinces = $profileService->get_province_list($array['require_place']);
                $count = count($provinces);
                foreach ($provinces as $key => $province) {
                    $model->require_place.=$province['name'];
                    if ($key < $count - 1) {
                        $model->require_place.='、';
                    }
                }
            } else {
                $model->require_place = '不限';
            }
        }
        $model->RC_list = FactoryVMap::list_to_models($array['job_certificate_list'], 'home_job_certificate');
        foreach ($model->RC_list as $key => $rc) {
            $model->RC_list[$key] = $rc->register_certificate_name;
            if (!empty($rc->register_certificate_major)) {
                $model->RC_list[$key].=(' - ' . $rc->register_certificate_major);
            }
            $model->RC_list[$key].=(' - ' . registerCase_format($rc->register_case));
            if ($rc->RC_count > 0)
                $model->RC_list[$key].= ' - ' . $rc->RC_count . '人';
        }
        return $model;
    }

    public static function array_to_home_interested_company_model($array) {
        $model = new home_interested_company_model();
        //$model->company_city_code=$array['company_city_code'];
        $model->company_introduce = $array['introduce'];
        $model->company_name = $array['company_name'];
        //$model->company_province_code=$array['company_province_code'];
        $service = new ProvinceService();
        if (!empty($array['company_province_code'])) {
            $province = $service->get_province($array['company_province_code']);
            $city = $service->get_city($array['company_city_code']);
            $model->location = $province['name'] . ' - ' . $city['name'];
        } else {
            $model->location = '不限';
        }
        $model->name = $array['name'];
        $model->real_auth = $array['is_real_auth'];
        $model->phone_auth = $array['is_phone_auth'];
        $model->email_auth = $array['is_email_auth'];
//        if ($array['is_email_auth'] == 1) {
//            $model->user_auth_email = C('FILE_ROOT') . C('AUTH_EMAIL_OK');
//        } else {
//            $model->user_auth_email = C('FILE_ROOT') . C('AUTH_EMAIL_NO');
//        }
//        if ($array['is_phone_auth'] == 1) {
//            $model->user_auth_phone = C('FILE_ROOT') . C('AUTH_PHONE_OK');
//        } else {
//            $model->user_auth_phone = C('FILE_ROOT') . C('AUTH_PHONE_NO');
//        }
//        if ($array['is_real_auth'] == 1) {
//            $model->user_auth_real = C('FILE_ROOT') . C('AUTH_REAL_OK');
//        } else {
//            $model->user_auth_real = C('FILE_ROOT') . C('AUTH_REAL_NO');
//        }
        $model->user_id = $array['user_id'];
        $model->user_photo = C('FILE_ROOT') . $array['photo'];
        $model->follow = $array['follow'];
        return $model;
    }

    public static function array_to_home_found_agent_model($array) {
        $model = new home_found_agent_model();
        $profileService = new ProfileService();
        $model->follow = $array['follow'];
        $model->addr_city_code = $array['addr_city_code'];
        if (!empty($model->addr_city_code)) {
            $city = $profileService->get_city($model->addr_city_code);
            $model->addr_city_code = $city['name'];
        }
        $model->addr_province_code = $array['addr_province_code'];
        if (!empty($model->addr_province_code)) {
            $province = $profileService->get_province($model->addr_province_code);
            $model->addr_province_code = $province['name'];
        }
        $model->agent_introduce = (empty($array['introduce']) or $array['introduce'] == '暂无') ? '您好！本人从事建筑行业猎头工作，我将竭诚为您服务！' : $array['introduce'];
        $model->company_name = $array['company_name'];
        $model->name = $array['name'];
        $model->user_id = $array['user_id'];
        $model->user_photo = C('FILE_ROOT') . $array['photo'];
        $model->real_auth = $array['is_real_auth'];
        $model->phone_auth = $array['is_phone_auth'];
        $model->email_auth = $array['is_email_auth'];
//        if ($array['is_email_auth'] == 1) {
//            $model->user_auth_email = C('FILE_ROOT') . C('AUTH_EMAIL_OK');
//        } else {
//            $model->user_auth_email = C('FILE_ROOT') . C('AUTH_EMAIL_NO');
//        }
//        if ($array['is_phone_auth'] == 1) {
//            $model->user_auth_phone = C('FILE_ROOT') . C('AUTH_PHONE_OK');
//        } else {
//            $model->user_auth_phone = C('FILE_ROOT') . C('AUTH_PHONE_NO');
//        }
//        if ($array['is_real_auth'] == 1) {
//            $model->user_auth_real = C('FILE_ROOT') . C('AUTH_REAL_OK');
//        } else {
//            $model->user_auth_real = C('FILE_ROOT') . C('AUTH_REAL_NO');
//        }
        if (!empty($array['services'])) {
            $model->service_list = FactoryVMap::list_to_models($array['services'], 'home_agent_type');
        }
        $userService = new UserService();
        $model->activity = $userService->get_user_activity($array['user_id']);
        return $model;
    }

    public static function array_to_home_delegate_human_model($array) {
        $model = new home_delegate_human_model();
        $model->main_role = C('ROLE_TALENTS');      //委托方角色编号（暂时只有人才）
        $model->id = $array['id'];
        $job_category = $array['job_category'];
        $model->job_category = $job_category;
        $model->follow = $array['follow'];
        $model->status = $array['status'];
        $model->real_auth = $array['is_real_auth'];
        $model->phone_auth = $array['is_phone_auth'];
        $model->email_auth = $array['is_email_auth'];
        if (empty($model->status)) {
            if (empty($array['publisher_id'])) {
                $model->status = 1;
            } else {
                $model->status = 2;
            }
        }
        $model->delegate_datetime = cdate_format($array['delegate_datetime']);
//        if ($array['is_email_auth'] == 1) {
//            $model->is_auth_email = C('FILE_ROOT') . C('AUTH_EMAIL_OK');
//        } else {
//            $model->is_auth_email = C('FILE_ROOT') . C('AUTH_EMAIL_NO');
//        }
//        if ($array['is_phone_auth'] == 1) {
//            $model->is_auth_phone = C('FILE_ROOT') . C('AUTH_PHONE_OK');
//        } else {
//            $model->is_auth_phone = C('FILE_ROOT') . C('AUTH_PHONE_NO');
//        }
//        if ($array['is_real_auth'] == 1) {
//            $model->is_auth_real = C('FILE_ROOT') . C('AUTH_REAL_OK');
//        } else {
//            $model->is_auth_real = C('FILE_ROOT') . C('AUTH_REAL_NO');
//        }
        $model->name = $array['name']; //resume_title_format(0, $job_category, $array['resume_id']);
        $model->rname = resume_title_format(0, $job_category, $array['resume_id']);
        $model->resume_id = $array['resume_id'];
        $model->send_count = $array['send_count'];
        $model->user_id = $array['user_id'];
        $model->human_id = $array['human_id'];
        $model->user_photo = C('FILE_ROOT') . $array['photo'];
        $profileService = new ProfileService();
        $model->RC_list = FactoryVMap::list_to_models($array['RC_list'], 'home_human_register_certificate');
        foreach ($model->RC_list as $key => $rc) {
            $model->RC_list[$key] = $rc->register_certificate_name;
            if (!empty($rc->register_certificate_major)) {
                $model->RC_list[$key].=(' - ' . $rc->register_certificate_major);
            }
            $model->RC_list[$key].=(' - ' . $rc->register_case . ' - ' . $rc->register_place);
        }
        $model->send_count = $array['send_count'];
        if ($job_category == 1) {
            $province = $profileService->get_province($array['job_province_code']);
            $city = $profileService->get_city($array['job_city_code']);
            $model->job_addr = $province['name'] . ' - ' . $city['name'];
            $model->job_name = $array['job_name'];
            $model->work_exp = exp_format($array['work_age']);
            $model->salary = salary_format($array['fsalary'], $array['fisalary']);
        } else if ($job_category == 2) {
            $model->register_place = $array['register_province_ids'];
            if (!empty($model->register_place)) {
                $provinces = $profileService->get_province_list($model->register_place);
                $model->register_place = '';
                $count = count($provinces);
                foreach ($provinces as $key => $province) {
                    $model->register_place.=$province['name'];
                    if ($key < $count - 1) {
                        $model->register_place.='、';
                    }
                }
            } else {
                $model->register_place = '不限';
            }
            $model->salary = salary_format($array['psalary'], $array['pisalary']);
        }
        if (array_key_exists('_promote', $array))
            $model->promote = $array['_promote'];           //是否已推广
        $model->delegate_resume_id = $array['id'];
        return $model;
    }

    public static function array_to_common_common_index_model($array) {
        $model = new common_common_index_model();
        if ($array['count1'] > 10000)
            $array['count1'] = round($array['count1'] / 10000, 1) . '万';
        $model->count1 = $array['count1'];
        $model->count2 = $array['count2'];
        $model->count3 = $array['count3'];
        return $model;
    }

    public static function array_to_home_resume_sent_model($array) {
        $model = new home_resume_sent_model();
        $job_category = $array['job_category'];
        $model->job_category = $job_category;
        $model->real_auth = $array['is_real_auth'];
        $model->phone_auth = $array['is_phone_auth'];
        $model->email_auth = $array['is_email_auth'];
//        if ($array['is_email_auth'] == 1) {
//            $model->is_auth_email = C('FILE_ROOT') . C('AUTH_EMAIL_OK');
//        } else {
//            $model->is_auth_email = C('FILE_ROOT') . C('AUTH_EMAIL_NO');
//        }
//        if ($array['is_phone_auth'] == 1) {
//            $model->is_auth_phone = C('FILE_ROOT') . C('AUTH_PHONE_OK');
//        } else {
//            $model->is_auth_phone = C('FILE_ROOT') . C('AUTH_PHONE_NO');
//        }
//        if ($array['is_real_auth'] == 1) {
//            $model->is_auth_real = C('FILE_ROOT') . C('AUTH_REAL_OK');
//        } else {
//            $model->is_auth_real = C('FILE_ROOT') . C('AUTH_REAL_NO');
//        }
        $model->sender_name = $array['name'];
        $model->send_resume_id = $array['send_resume_id'];
        $model->resume_id = $array['resume_id'];
        $model->sender_id = $array['user_id'];
        $model->human_id = $array['human_id'];
        $model->sender_photo = C('FILE_ROOT') . $array['photo'];
        $model->sender_role = $array['role_id'];
        $model->send_datetime = cdate_format($array['send_datetime']);
        $model->send_status = $array['status'];
        $model->human_name = resume_title_format($array['role_id'] == C('ROLE_AGENT'), $job_category, $array['resume_id']);
        $model->job = $array['job'];
        $model->follow = $array['follow'];
        $profileService = new ProfileService();
        $model->RC_list = FactoryVMap::list_to_models($array['RC_list'], 'home_human_register_certificate');
        foreach ($model->RC_list as $key => $rc) {
            $model->RC_list[$key] = $rc->register_certificate_name;
            if (!empty($rc->register_certificate_major)) {
                $model->RC_list[$key].=(' - ' . $rc->register_certificate_major);
            }
            $model->RC_list[$key].=(' - ' . $rc->register_case . ' - ' . $rc->register_place);
        }
        if ($job_category == 1) {
            $province = $profileService->get_province($array['job_province_code']);
            $city = $profileService->get_city($array['job_city_code']);
            $model->job_addr = $province['name'] . ' - ' . $city['name'];
            $model->job_name = $array['job_name'];
            $model->work_exp = exp_format($array['work_age']);
            $model->salary = salary_format($array['fsalary'], $array['fisalary']); // year_salary($array['fsalary']);
        } else if ($job_category == 2) {
            $model->register_place = $array['register_province_ids'];
            if (!empty($model->register_place)) {
                $provinces = $profileService->get_province_list($model->register_place);
                $count = count($provinces);
                $model->register_place = '';
                foreach ($provinces as $key => $province) {
                    $model->register_place.=$province['name'];
                    if ($key < $count - 1) {
                        $model->register_place.='、';
                    }
                }
            }
            else{
                $model->register_place = '不限';
            }
            $model->salary = salary_format($array['psalary'], $array['pisalary']); //year_salary($array['psalary']);
        }
        return $model;
    }

    public static function array_to_home_resume_own_model($array) {
        $model = new home_resume_own_model();
        $job_category = $array['job_category'];
        $model->job_category = $job_category;
        $model->delegate_datetime = cdate_format($array['delegate_datetime']);
        $model->pub_date = cdate_format($array['pub_datetime']);
        $model->name = resume_title_format(1, $job_category, $array['resume_id']);
        $model->resume_id = $array['resume_id'];
        $model->human_id = $array['human_id'];
        $profileService = new ProfileService();
        $model->RC_list = FactoryVMap::list_to_models($array['RC_list'], 'home_human_register_certificate');
        foreach ($model->RC_list as $key => $rc) {
            $model->RC_list[$key] = $rc->register_certificate_name;
            if (!empty($rc->register_certificate_major)) {
                $model->RC_list[$key].=(' - ' . $rc->register_certificate_major);
            }
            $model->RC_list[$key].=(' - ' . $rc->register_case . ' - ' . $rc->register_place);
        }
        if ($job_category == 1) {
            $province = $profileService->get_province($array['job_province_code']);
            $city = $profileService->get_city($array['job_city_code']);
            $model->job_addr = $province['name'] . ' - ' . $city['name'];
            $model->job_name = $array['job_name'];
            $model->work_exp = exp_format($array['work_age']);
            $model->salary = salary_format($array['fsalary'], $array['fisalary']); //year_salary($array['fsalary']);
        } else if ($job_category == 2) {
            $model->register_place = $array['register_province_ids'];
            if (!empty($model->register_place)) {
                $provinces = $profileService->get_province_list($model->register_place);
                $model->register_place = '';
                $count = count($provinces);
                foreach ($provinces as $key => $province) {
                    $model->register_place.=$province['name'];
                    if ($key < $count - 1) {
                        $model->register_place.='、';
                    }
                }
            } else {
                $model->register_place = '不限';
            }
            $model->salary = salary_format($array['psalary'], $array['pisalary']); //year_salary($array['psalary']);
        }
        if (empty($array['data_id'])) {
            $model->type = 2;
        } else {
            $model->type = 1;
        }
        return $model;
    }

    public static function array_to_home_blog_rank_model($array) {
        $model = new home_blog_rank_model();
        $model->id = $array['user_id'];
        $model->name = $array['name'];
        $model->photo = C('FILE_ROOT') . $array['photo'];
        $model->count = $array['blog_count'];
        return $model;
    }

    public static function array_to_home_blog_model($array) {
        $model = new home_blog_model();
        $model->blog_id = $array['blog_id'];
        $model->title = $array['title'];
        $model->body = $array['body'];
        $model->status = $array['status'];
        $model->create_datetime = nt_date_format($array['create_datetime']);
        $model->read_count = $array['read_count'] + 1;
        $model->creator_id = $array['creator_id'];
        $model->class_title = $array['class_title'];
        $model->class_id = $array['class_id'];
        $model->user_id = $array['user_id'];
        $model->name = $array['name'];
        $model->praise = $array['praise'];
        $model->photo = C('FILE_ROOT') . $array['photo'];
        $model->real_auth = $array['is_real_auth'];
        $model->phone_auth = $array['is_phone_auth'];
        $model->email_auth = $array['is_email_auth'];
//        if ($array['is_email_auth'] == 1) {
//            $model->is_auth_email = C('FILE_ROOT') . C('AUTH_EMAIL_OK');
//        } else {
//            $model->is_auth_email = C('FILE_ROOT') . C('AUTH_EMAIL_NO');
//        }
//        if ($array['is_phone_auth'] == 1) {
//            $model->is_auth_phone = C('FILE_ROOT') . C('AUTH_PHONE_OK');
//        } else {
//            $model->is_auth_phone = C('FILE_ROOT') . C('AUTH_PHONE_NO');
//        }
//        if ($array['is_real_auth'] == 1) {
//            $model->is_auth_real = C('FILE_ROOT') . C('AUTH_REAL_OK');
//        } else {
//            $model->is_auth_real = C('FILE_ROOT') . C('AUTH_REAL_NO');
//        }
        $model->creator_id = $array['creator_id'];
        $model->blog_count = $array['blog_count'];
        $model->source = $array['source']; //心得来源
        return $model;
    }

    public static function array_to_home_blog_sum_model($array) {
        $model = new home_blog_model();
        $model->blog_id = $array['blog_id'];
        $model->title = $array['title'];
        $model->body = str_sub(strtr($array['body'], array('{nbsp}' => ' ', '&lt;br/&gt;' => ' ', '&amp;lt;br/&amp;gt;' => ' ')), 1000);
        $model->body = preg_replace("/<(\/?br.*?)>/si", "", $model->body);
        $model->body = preg_replace("/\s+/", " ", $model->body);
        $model->body = str_sub(html2txt($model->body), 105);
        $model->status = $array['status'];
        $model->create_datetime = nt_date_format($array['update_datetime']);
        $model->read_count = $array['read_count'];
        $model->user_id = $array['user_id'];
        $model->name = $array['name'];
        $model->praise = $array['praise'];
        $model->photo = C('FILE_ROOT') . $array['photo'];
//        if($array['is_email_auth'] == 1) {
//            $model->is_auth_email= C('FILE_ROOT').C('AUTH_EMAIL_OK');
//        }else {
//            $model->is_auth_email = C('FILE_ROOT').C('AUTH_EMAIL_NO');
//        }
//        if($array['is_phone_auth'] == 1) {
//            $model->is_auth_phone = C('FILE_ROOT').C('AUTH_PHONE_OK');
//        }else {
//            $model->is_auth_phone = C('FILE_ROOT').C('AUTH_PHONE_NO');
//        }
//        if($array['is_real_auth'] == 1) {
//            $model->is_auth_real  = C('FILE_ROOT').C('AUTH_REAL_OK');
//        }else {
//            $model->is_auth_real = C('FILE_ROOT').C('AUTH_REAL_NO');
//        }
        $model->creator_id = $array['creator_id'];
        return $model;
    }

    public static function array_to_home_blog_recommend_model($array) {
        $model = new home_blog_model();
        $model->blog_id = $array['blog_id'];
        $model->title = $array['title'];
        $model->body = str_sub(strtr($array['body'], array('{nbsp}' => ' ', '&lt;br/&gt;' => ' ', '&amp;lt;br/&amp;gt;' => ' ')), 1000);
        $model->body = preg_replace("/<(\/?br.*?)>/si", "", $model->body);
        $model->body = preg_replace("/\s+/", " ", $model->body);
        $model->body = str_sub(html2txt($model->body), 105);
        $model->status = $array['status'];
        $model->create_datetime = nt_date_format($array['update_datetime']);
        $model->read_count = $array['read_count'];
        $model->user_id = $array['user_id'];
        $model->name = $array['name'];
        $model->praise = $array['praise'];
        $model->photo = C('FILE_ROOT') . $array['photo'];
        return $model;
    }

    /**
     * 发布排行榜
     * @param type $array
     * @return \home_blog_model 
     */
    public static function array_to_home_blog_release_model($array) {
        $model = new home_blog_model();
        $model->key = $array['key'];
        $model->blog_id = $array['blog_id'];
        $model->title = $array['title'];
        $model->read_count = $array['read_count'];
        $model->blog_count = $array['blog_count'];
        $model->praise = $array['praise'];
        $model->creator_id = $array['creator_id'];
        $model->user_id = $array['user_id'];
        $model->name = $array['name'];
        $model->praise = $array['praise'];
        $model->photo = C('FILE_ROOT') . $array['photo'];
        return $model;
    }

    /**
     * ================================CRM================================ 
     */
    //====================公用====================

    public function array_to_crm_index_category_model($array) {
        $model = new crm_index_category_model();
        $model->id = $array['cate_id'];
        $model->name = $array['cate_name'];
        return $model;
    }

    public function array_to_crm_index_progress_model($array) {
        $model = new crm_index_category_model();
        $model->id = $array['pro_id'];
        $model->name = $array['pro_name'];
        return $model;
    }

    public function array_to_crm_index_district_model($array) {
        $model = new crm_index_category_model();
        $model->id = $array['dist_id'];
        $model->name = $array['dist_name'];
        return $model;
    }

    public function array_to_crm_index_certificate_model($array) {
        $model = new crm_index_category_model();
        $model->id = $array['cert_id'];
        $model->name = $array['cert_name'];
        return $model;
    }

    public function array_to_crm_index_industry_model($array) {
        $model = new crm_index_category_model();
        $model->id = $array['apt_id'];
        $model->name = $array['indstry'];
        return $model;
    }

    /*     * ********************************CRM人才资源模型提供******************************************* */

    /**
     * 人才默认列表数据
     * @param type $array 底层提供数组
     * @return \crm_index_human_model 
     */
    public function array_to_crm_human_list_model($array) {
        $model = new crm_index_human_model();
        $model->id = $array['human_id'];
        $model->name = empty($array['name']) ? '' : $array['name'];
        $model->fulltime = empty($array['fulltime']) ? '' : $array['fulltime'];
        $model->province = empty($array['province']) ? '' : $array['province'];
        $model->aptitude = '';
        foreach ($array['aptitude'] as $k => $v) {
            $apt = empty($v['certificate']) ? '' : $v['certificate'];
            $apt .= (empty($v['industry']) ? '' : '-' . $v['industry']);
            $apt .= (empty($v['reg_case']) ? '' : '-' . $v['reg_case']);
            $apt .= (empty($v['province']) ? '' : '-' . $v['province']);
            $model->aptitude[$k] = $apt;
        }
        /*         * 新增资源导入的资质证书 */
        if ($array['certificate_copy']) {
            $model->certificate_copy = $array['certificate_copy'];
        }
        $model->cate_id = empty($array['cate_id']) ? '' : $array['cate_id'];  //阶段id
        $model->pro_id = empty($array['pro_id']) ? '' : $array['pro_id'];  //进度id
        $model->title = !empty($array['title']['tp_name']) ? $array['title_level'] . '-' . $array['title']['tp_name'] : '';
        $model->title .=!empty($array['title']['title_type']) ? '-' . $array['title']['title_type'] : '';
        $model->quote = empty($array['quote']) ? '' : $array['quote'];
        $model->mobile = empty($array['mobile']) ? '' : $array['mobile'];
        $model->qq = empty($array['qq']) ? '' : $array['qq'];
        $model->source = empty($array['sour_name']) ? '' : trim($array['sour_name']);
        $model->status_id = empty($array['status_id']) ? 0 : $array['status_id'];
        $model->status_stage = empty($array['cate_name']) ? '' : $array['cate_name'];
        $model->status_progress = empty($array['pro_name']) ? '' : $array['pro_name'];
        $model->status_notes = empty($array['status_notes']) ? '' : $array['status_notes'];
        return $model;
    }

    /**
     * 人才条件筛选
     * @param array $array 底层提供数组
     * @return crm_index_human_model 
     */
    public function array_to_crm_human_filter_model($array) {
        $model = new crm_index_human_model();
        $model->id = $array['human_id'];
        $model->name = empty($array['name']) ? '' : $array['name'];
        $model->fulltime = empty($array['fulltime']) ? '' : $array['fulltime'];
        $model->province = empty($array['province']) ? '' : $array['province'];
        foreach ($array['aptitude'] as $k => $v) {
            $apt = empty($v['certificate']) ? '' : $v['certificate'];
            $apt .= (empty($v['industry']) ? '' : '-' . $v['industry']);
            $apt .= (empty($v['reg_case']) ? '' : '-' . $v['reg_case']);
            $apt .= (empty($v['province']) ? '' : '-' . $v['province']);
            $model->aptitude[$k] = $apt;
        }
        $model->title = !empty($array['titles']['tp_name']) ? $array['tp_level_name'] . '-' . $array['titles']['tp_name'] : '';
        $model->title .=!empty($array['titles']['title_type']) ? '-' . $array['titles']['title_type'] : '';
        $model->quote = empty($array['quote']) ? '' : $array['quote'];
        $model->mobile = empty($array['mobile']) ? '' : $array['mobile'];
        $model->qq = empty($array['qq']) ? '' : $array['qq'];
        $model->source = empty($array['sour_name']) ? '' : trim($array['sour_name']);
        $model->status_id = empty($array['status']['status_id']) ? '' : $array['status']['status_id'];
        $model->status_stage = empty($array['status']['cate_name']) ? '' : $array['status']['cate_name'];
        $model->status_progress = empty($array['status']['pro_name']) ? '' : $array['status']['pro_name'];
        $model->status_notes = empty($array['status']['status_notes']) ? '' : $array['status']['status_notes'];
        $model->cate_id = empty($array['status']['cate_id']) ? 0 : $array['status']['cate_id'];  //阶段id
        $model->pro_id = empty($array['status']['pro_id']) ? 0 : $array['status']['pro_id']; //进度id
        return $model;
    }

    /**
     * 人才详情页面数据提供层
     * @param type $array 底层提供数组 
     * @return \crm_detail_human_model 
     */
    public function array_to_crm_human_detail_model($array) {
        $model = new crm_detail_human_model();
        $model->id = $array['human_id'];
        $model->name = empty($array['name']) ? '' : $array['name'];
        $model->sex = $array['sex'];
        $model->sex_name = $array['sex_name'];
        $model->is_fulltime = $array['is_fulltime'] ? $array['is_fulltime'] : '';
        $model->fulltime = $array['fulltime'] ? $array['fulltime'] : '';
        $model->birthday = $array['birthday'] == '0000-00-00' ? '' : $array['birthday'];
        $model->mobile = $array['mobile'] ? $array['mobile'] : '';
        $model->phone = $array['phone'] ? $array['phone'] : '';
        $model->fax = $array['fax'] ? $array['fax'] : '';
        $model->email = $array['email'] ? $array['email'] : '';
        $model->qq = $array['qq'] ? $array['qq'] : '';
        $model->zipcode = $array['postcode'] ? $array['postcode'] : '';
        $model->province_id = $array['province_id'] ? $array['province_id'] : '';
        $model->province = $array['province'] ? $array['province'] : '';
        $model->city_id = $array['city_id'] ? $array['city_id'] : '';
        $model->city = $array['city'] ? $array['city'] : '';
        $model->region_id = $array['region_id'] ? $array['region_id'] : '';
        $model->region = $array['region'] ? $array['region'] : '';
        $model->community_id = $array['community_id'] ? $array['community_id'] : '';
        $model->community = $array['community'] ? $array['community'] : '';
        $model->address = $array['address'] ? $array['address'] : '';
        $model->quote = $array['quote'] != '0.00' ? $array['quote'] : '';
        $model->source_id = $array['sour_id'] ? $array['sour_id'] : '';
        $model->source = $array['source'] ? $array['source'] : '';
        $model->remark = trim($array['remark']) == '' ? "" : $array['remark'];
        $model->employ['pay_time'] = $array['employ_pay_time'] != '0000-00-00' ? $array['employ_pay_time'] : ''; //付款时间
        $model->employ['payment'] = $array['employ_payment'] ? $array['employ_payment'] : ''; //付款方式
        $model->employ['expr_time'] = $array['employ_expr_time'] != '0000-00-00' ? $array['employ_expr_time'] : ''; //到期时间
        $model->employ['contract'] = $array['employ_contract'] ? $array['employ_contract'] : ''; //合同期
        $model->employ['sign_time'] = $array['employ_sign_time'] != '0000-00-00' ? $array['employ_sign_time'] : ''; //签约时间
        $model->employ['pay'] = $array['employ_pay'] ? $array['employ_pay'] : ''; //聘用工资
        $model->employ['charger'] = $array['employ_charger'] ? $array['employ_charger'] : ''; //负责单位合作者
        $model->employ['location'] = $array['employ_location'] ? $array['employ_location'] : ''; //单位地址
        $model->employ['name'] = $array['employ_name'] ? $array['employ_name'] : ''; //单位名称
        $model->employ = empty($array['employ_name']) ? '' : $model->employ;
        $model->humanInforPercent = $array['humanInforPercent'];
        $model->humanCertPercent = $array['humanCertPercent'];
        $model->humanStatusPercent = $array['humanStatusPercent'];
        $model->humanRegisterPercent = $array['humanRegisterPercent'];
        $model->humanBankPercent = $array['humanBankPercent'];
        $model->humanAttPercent = $array['humanAttPercent'];
        foreach ($array['bank'] as $v) {
            $model->bank['id'] = $v['bank_id'];
            $model->bank['name'] = empty($v['bank_name']) ? '' : $v['bank_name'];
            $model->bank['username'] = empty($v['bank_username']) ? '' : $v['bank_username'];
            $model->bank['account'] = empty($v['bank_account']) ? '' : $v['bank_account'];
        }
        $model->bank = empty($array['bank']) ? '' : $model->bank;
        //附件处理模型
        foreach ($array['att_array'] as $key) {
            $attInfo[$key['att_info']['att_type_id']][] = array(
                'att_name' => $key['att_info']['att_name'],
                'identifier' => $key['att_info']['identifier'],
                'att_path' => $key['att_info']['att_path'],
                'att_id' => $key['att_id'],
                'att_relation_id' => $key['att_human_id'],
            );
        }
        $model->doc_type = $array['doc_type'];
        $model->doc_number = $array['doc_number'];
        $model->attach = $attInfo;
        $model->title['id'] = $array['title']['tp_id'];
        $model->title['name'] = $array['title']['tp_name'];
        $model->title['type_id'] = $array['title']['t_id'];
        $model->title['type'] = $array['title']['title_type'];
        $model->title['level_id'] = $array['tp_level'];
        $model->title['level'] = $array['title_level'];
        $model->title = empty($array['title']) ? '' : $model->title;
        $model->aptitude = empty($array['aptitude']) ? '' : $array['aptitude'];
        /*         * 新增资源导入的资质证书 */
        if ($array['certificate_copy']) {
            $model->certificate_copy = $array['certificate_copy'];
        }
        $model->status = $array['status'];
        $model->attachment = $array['attachment'];
        return $model;
    }

    public function array_to_crm_human_completed_model($array) {
        $model = new crm_detail_human_completed_model();
        $model->human_id = $array['human_id'];
        $model->base = $array['base'];
        $model->aptitude = $array['aptitude'];
        $model->status = $array['status'];
        $model->bank = $array['bank'];
        $model->employ = $array['employ'];
        $model->attachment = $array['attachment'];
        $model->remark = $array['remark'];
        return $model;
    }

    public function array_to_crm_index_title_model($array) {
        $model = new crm_index_title_model();
        $model->id = $array['tp_id'];
        $model->name = $array['tp_name'];
        return $model;
    }

    public function array_to_crm_index_title_type_model($array) {
        $model = new crm_index_title_model();
        $model->id = $array['t_id'];
        $model->name = $array['t_name'];
        return $model;
    }

    public function array_to_crm_index_source_model($array) {
        $model = new crm_index_category_model();
        $model->id = $array['sour_id'];
        $model->name = $array['sour_name'];
        return $model;
    }

    /*     * ********************************CRM企业资源模型提供******************************************* */

    /**
     * 企业搜索结果数据
     * @param type $array 底层提供数组
     * @return \crm_index_company_model 
     */
    public function array_to_crm_company_filter_model($array) {
        $model = new crm_index_company_model();
        $model->id = $array['enter_id'];
        $model->name = $array['name'];
        foreach ($array['demand_array'] as $k => $v) {
            $demand = empty($v['demand_apt_info']['cert_name']) ? '' : $v['demand_apt_info']['cert_name'];
            $demand .= ('-' . (empty($v['demand_apt_info']['in_name']) ? '' : $v['demand_apt_info']['in_name']));
            $demand .= ('-' . (empty($v['demand_reg_info']) ? '' : $v['demand_reg_info']));
            $model->demand[$k]['aptitude'] = $demand;
            $model->demand[$k]['number'] = (empty($v['demand_need_num']) ? '0' : $v['demand_need_num']);
            $model->demand[$k]['price'] = empty($v['demand_need_price']) ? '0.00' : $v['demand_need_price'];
            $model->demand[$k]['per_year'] = empty($v['demand_need_year']) ? '0.00' : $v['demand_need_year'];
            $model->demand[$k]['fulltime'] = empty($v['demand_fulltime']) ? '' : $v['demand_fulltime'];
            $model->demand[$k]['use'] = empty($v['demand_use']) ? '' : $v['demand_use'];
        }
        $model->cate_id = empty($array['status_array']['cate_id']) ? 0 : $array['status_array']['cate_id'];  //阶段id
        $model->pro_id = empty($array['status_array']['pro_id']) ? 0 : $array['status_array']['pro_id'];  //进度id
        $model->demand = empty($model->demand) ? '' : $model->demand; //企业需求返回空
        $model->province = empty($array['province']) ? '' : $array['province'];
        $model->mobile = empty($array['mobile']) ? '' : $array['mobile'];
        $model->phone = empty($array['phone']) ? '' : $array['phone'];
        $model->qq = empty($array['qq']) ? '' : $array['qq'];
        $model->source = empty($array['sour_name']) ? '' : trim($array['sour_name']);
        $model->status_id = (!empty($array['status_array']['status_id'])) ? $array['status_array']['status_id'] : 0;
        $model->status_stage = empty($array['status_array']['cate_name']) ? '' : $array['status_array']['cate_name'];
        $model->status_progress = empty($array['status_array']['pro_name']) ? '' : $array['status_array']['pro_name'];
        $model->status_notes = empty($array['status_array']['status_notes']) ? '' : $array['status_array']['status_notes'];
        return $model;
    }

    /**
     * 企业默认结果数据
     * @param type $array 底层提供数组
     * @return \crm_index_company_model 
     */
    public function array_to_crm_company_list_model($array) {
        $model = new crm_index_company_model();
        $model->id = $array['enter_id'];
        $model->name = $array['name'];
        foreach ($array['demand_array'] as $k => $v) {
            $demand = empty($v['demand_apt_info']['cert_name']) ? '' : $v['demand_apt_info']['cert_name'];
            $demand .= ('-' . (empty($v['demand_apt_info']['in_name']) ? '' : $v['demand_apt_info']['in_name']));
            $demand .= ('-' . (empty($v['demand_reg_info']) ? '' : $v['demand_reg_info']));
            $model->demand[$k]['aptitude'] = $demand;
            $model->demand[$k]['number'] = (empty($v['demand_need_num']) ? '0' : $v['demand_need_num']);
            $model->demand[$k]['price'] = empty($v['demand_need_price']) ? '0.00' : $v['demand_need_price'];
            $model->demand[$k]['per_year'] = empty($v['demand_need_year']) ? '0.00' : $v['demand_need_year'];
            $model->demand[$k]['fulltime'] = empty($v['demand_fulltime']) ? '' : $v['demand_fulltime'];
            $model->demand[$k]['use'] = empty($v['demand_use']) ? '' : $v['demand_use'];
        }
        $model->demand = empty($model->demand) ? '' : $model->demand; //企业需求返回空
        $model->province = empty($array['province']) ? '' : $array['province'];
        $model->mobile = empty($array['mobile']) ? '' : $array['mobile'];
        $model->phone = empty($array['phone']) ? '' : $array['phone'];
        $model->qq = empty($array['qq']) ? '' : $array['qq'];
        $model->source = empty($array['sour_name']) ? '' : trim($array['sour_name']);
        $model->status_id = (!empty($array['status_array']['status_id'])) ? $array['status_array']['status_id'] : 0;
        $model->status_stage = empty($array['status_array']['cate_name']) ? '' : $array['status_array']['cate_name'];
        $model->status_progress = empty($array['status_array']['pro_name']) ? '' : $array['status_array']['pro_name'];
        $model->status_notes = empty($array['status_array']['status_notes']) ? '' : $array['status_array']['status_notes'];
        $model->cate_id = empty($array['status_array']['cate_id']) ? 0 : $array['status_array']['cate_id'];  //阶段id
        $model->pro_id = empty($array['status_array']['pro_id']) ? 0 : $array['status_array']['pro_id'];  //进度id
        return $model;
    }

    public function array_to_crm_company_detail_model($array) {
        $model = new crm_detail_company_model();
        $model->id = $array['enter_id'];
        $model->name = $array['name'];
        $model->type_id = $array['nature'];
        $model->type = $array['property'];
        $model->found_time = $array['found_time'] != '0000-00-00' ? $array['found_time'] : '';
        $model->site = $array['site'];
        $model->source_id = $array['sour_id'];
        $model->source = $array['source_name'];
        $model->brief = $array['brief'];
        $model->remark = $array['remark'];
        $model->contact = $array['contact'];
        $model->mobile = $array['mobile'];
        $model->phone = $array['phone'];
        $model->fax = $array['fax'];
        $model->email = $array['email'];
        $model->qq = empty($array['qq']) ? '' : $array['qq'];
        $model->zipcode = empty($array['zipcode']) ? '' : $array['zipcode'];
        $model->province_id = $array['province_id'];
        $model->province = $array['province'];
        $model->city_id = $array['city_id'];
        $model->city = $array['city'];
        $model->region_id = $array['region_id'];
        $model->region = $array['region'];
        $model->community_id = $array['community_id'];
        $model->community = $array['community'];
        $model->address = $array['address'];
        $model->nature = $array['nature_array'];
        $model->status = $array['status_array'];
        $model->demand = empty($array['demand_array']) ? '' : $array['demand_array'];
        $model->comInforPercent = $array['comInforPercent'];
        $model->comNaturePercent = $array['comNaturePercent'];
        $model->comContactPercent = $array['comContactPercent'];
        $model->comDemandPercent = $array['comDemandPercent'];
        $model->comStatusPercent = $array['comStatusPercent'];
        $model->comRegisterPercent = $array['comRegisterPercent'];
        $model->comAttPercent = $array['comAttPercent'];
        $model->brief_short = $array['brief_short'];
        //附件处理模型
        foreach ($array['att_array'] as $key) {
            $attInfo[$key['att_info']['att_type_id']][] = array(
                'att_name' => $key['att_info']['att_name'],
                'identifier' => $key['att_info']['identifier'],
                'att_path' => $key['att_info']['att_path'],
                'att_id' => $key['att_id'],
                'att_relation_id' => $key['att_human_id'],
            );
        }
        $model->attach = $attInfo;
        foreach ($array['reg_array'] as $k => $v) {
            $model->registers[$k] = $v['reg_info'] ? $v['reg_info'] : array();
            $model->registers[$k]['reg_info_id'] = $v['reg_info']['reg_info_id'] ? $v['reg_info']['reg_info_id'] : 0;
            $model->registers[$k]['reg_com_id'] = $v['rc_id'];
            $st = $v['aptitude']['cert_name'] ? $v['aptitude']['cert_name'] : '';
            $st.= $v['reg_info']['registration'] ? ' - ' . $v['reg_info']['registration'] : '';
            $st.= $v['aptitude']['in_name'] ? ' - ' . $v['aptitude']['in_name'] : '';
            $model->registers[$k]['cert_name'] = $st;
            $model->registers[$k]['cert_id'] = $v['aptitude']['cert_id'] ? $v['aptitude']['cert_id'] : 0;
            $model->registers[$k]['in_id'] = $v['aptitude']['in_id'] ? $v['aptitude']['in_id'] : 0;
        }
        return $model;
    }

    public function array_to_crm_company_completed_model($array) {
        $model = new crm_detail_company_completed_model();
        $model->enter_id = $array['enter_id'];
        $model->base = $array['base'];
        $model->nature = $array['nature'];
        $model->contact = $array['contact'];
        $model->demand = $array['demand'];
        $model->status = $array['status'];
        $model->register = $array['register'];
        $model->attachment = $array['attachment'];
        $model->status = $array['remark'];
        return $model;
    }

    public function array_to_crm_natures_model($array) {
        $model = new crm_index_category_model();
        $model->id = $array['nid'];
        $model->name = $array['nature_name'];
        return $model;
    }

    /**
     * 企业隐私
     * Enter description here ...
     * @param unknown_type $array
     * @return home_privacy_compay_model
     */
    public function array_to_home_privacy_company_model($array) {
        $model = new home_privacy_company_model();
        $model->company_privacy_id = $array['company_privacy_id'];
        $model->user_id = $array['user_id'];
        $model->company_id = $array['company_id'];
        $model->job = $array['job'];
        $model->min = $array['min'];

        //回拨
        $model->call_type = $array['call_time_slot']['call_type'];
        $model->call_time = $array['call_time_slot']['call_time'];
        //电话是否绑定
        $model->is_phone_auth = $array['is_phone_auth'];
        $model->phone = $array['phone'];

        $model->company_name = $array['company_name'];
        $model->contact_name = $array['contact_name'];
        $model->contact_way = $array['contact_way'];

        $model->names['name_type'] = $array['contact_name'];
        $model->names['quanname'] = $array['names']['quanname'];
        $model->names['banname'] = $array['names']['banname'];
        $model->names['company_type'] = $array['company_name'];
        $model->names['company_quanname'] = $array['names']['company_quanname'];
        $model->names['company_banname'] = $array['names']['company_banname'];
        return $model;
    }

    /**
     * 经纪人隐私
     * Enter description here ...
     * @param unknown_type $array
     * @return home_privacy_compay_model
     */
    public function array_to_home_privacy_agent_model($array) {
        $model = new home_privacy_agent_model();
        $model->agent_privacy_id = $array['agent_privacy_id'];
        $model->user_id = $array['user_id'];
        $model->agent_id = $array['agent_id'];
        $model->job = $array['job'];
        $model->resume = $array['resume'];
        $model->contact_way = $array['contact_way'];
        $model->name = $array['name'];
        $model->contact_way = $array['contact_way'];
        $model->min = $array['min'];
        //回拨
        $model->call_type = $array['call_time_slot']['call_type'];
        $model->call_time = $array['call_time_slot']['call_time'];
        //电话是否绑定
        $model->is_phone_auth = $array['is_phone_auth'];
        $model->phone = $array['phone'];
        $model->names['type'] = $array['names']['type'];
        $model->names['quanname'] = $array['names']['quanname'];
        $model->names['banname'] = $array['names']['banname'];
        return $model;
    }

    /**
     * 人才隐私
     * Enter description here ...
     * @param unknown_type $array
     * @return home_privacy_compay_model
     */
    public function array_to_home_privacy_human_model($array) {
        $model = new home_privacy_human_model();
        $model->human_privacy_id = $array['human_privacy_id'];
        $model->user_id = $array['user_id'];
        $model->human_id = $array['human_id'];
        $model->resume_id = $array['resume_id'];
        $model->name = $array['name'];
        $model->birthday = $array['birthday'];
        $model->resume_name = $array['resume_name'];
        $model->resume = $array['resume'];
        $model->contact_way = $array['contact_way'];
        $model->min = $array['min'];
        //回拨
        $model->call_type = $array['call_time_slot']['call_type'];
        $model->call_time = $array['call_time_slot']['call_time'];
        //电话是否绑定
        $model->is_phone_auth = $array['is_phone_auth'];
        $model->phone = $array['phone'];
        $model->birthdays['type'] = $array['birthdays']['type'];
        $model->birthdays['time'] = $array['birthdays']['time'];
        $model->birthdays['duantime'] = $array['birthdays']['duantime'];
        $model->names['type'] = $array['names']['type'];
        $model->names['quanname'] = $array['names']['quanname'];
        $model->names['banname'] = $array['names']['banname'];
        return $model;
    }

    /** crm提醒模块 */

    /**
     * 人才、企业资源提醒方式前端提供 
     * @param $array $array
     * @return \crm_index_notice_model 
     */
    public function array_to_crm_notice_model($array) {
        $model = new crm_index_notice_model();
        if ($array['wid']) {
            $model->time_type = $array['time_type'];
            $model->time_desc = $array['time_desc'];
            $model->time = $array['time'];
            $model->wid = $array['wid'];
        } else {
            $model->time_type = 0;
            $model->time_desc = 'day';
            $model->time = 0;
            $model->wid = 0;
        }
        return $model;
    }

    public function array_to_home_broker_model($array) {
        $count = 0;
        foreach ($array as $value) {
            $total_resume +=$value['public_resume'];
            $total_job +=$value['public_job'];
            $total_article += $value['public_article'];
            $total_view +=$value['page_view'];
            if ($value['is_online'])
                $count++;
        }
        $model = new home_broker_model();
        $model->person = $array;
        $model->total_resume = $total_resume ? $total_resume : 0;
        $model->total_job = $total_job ? $total_job : 0;
        $model->total_article = $total_article ? $total_article : 0;
        $model->total_view = $total_view ? $total_view : 0;
        $model->total_person = count($array);
        $model->is_online = $count;
        $model->off_line = ($model->total_person - $model->is_online);
        $model->broker = $array['broker'];
        return $model;
    }

    public function array_to_home_broker_info_model($array) {
        $model = new home_broker_info_model();
        $model->name = $array['name'];
        $model->photo = $array['photo'];
        $model->id = $array['id'];
        return $model;
    }

    public function array_to_home_agent_popup_model($array) {
        $model = new home_agent_popup_model();
        $model->agent_name = $array['name'];
        if (!empty($array['photo']))
            $model->agent_photo = C('FILE_ROOT') . $array['photo'];
        $model->agent_uid = $array['user_id'];
        $model->company_name = $array['company_name'];
        $model->human_name = $array['human_name'];
        $model->is_follow = $array['is_follow'];
        return $model;
    }
    
    public function array_to_home_job_read_model($array){
        $model=new home_job_read_model();
        $model->job_id=$array['job_id'];
        $model->title=$array['title'];
        return $model;
    }

}

?>
