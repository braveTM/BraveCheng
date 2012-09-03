/*
 *CRM资源管理 - model类
 */
function Resource(){
    this.id="id";//ID
    this.title="title";
    this.name="name";//名称
    this.type="type";//类型
    this.mobile="mobile";//手机
    this.use="use";
    this.phone="phone";//座机
    this.qq="qq";//qq
    this.cert="certs";
    this.source="source";//来源
    this.period="period";//阶段
    this.money="money";
    this.province="province";
    this.notes="notes";
}
Resource.prototype={
    /*
    *功能：获取人才资源列表
    *参数：
    *page：页面索引
    *size：每页显示数量
    *sf：成功执行
    *ff：失败执行
    */
    GetHumanList:function(page,size,sf,ff){
        var setings={
            url:CRMURL.GetHumanResourceLis,
            params:"page="+page+"&size="+size,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(setings);
    },
    /*
    *功能：获取筛选后的人才资源列表
    *参数：keywords：关键字
    *cate_id：阶段
    *pro_id：//进度
    *sour_id：来源
    *cert_id//证书
    *in_id//专业
    *reg_info:注册情况
    *title_level_id职称等级
    *title_id//职称名称
    *title_type_id//职称类别
    *province_id：省份
    *page：页面索引
    *size：每页显示数量
    *sf：成功执行
    *ff：失败执行
    */ 
    GetFilterHumanList:function(page,size,is_fultime,cate_id,pro_id,sour_id,apt_id,reg_info,title_level_id,title_type_id,title_id,province_id,price,keywords,sf,ff){
        var str="page="+page+"&size="+size+"&is_fultime="+is_fultime+"&cate_id="+cate_id+"&pro_id="+pro_id;
        str+="&sour_id="+sour_id+"&apt_id="+apt_id+"&reg_info="+reg_info+"&title_level_id="+title_level_id+"&title_type_id="+title_type_id+"&title_id="+title_id;
        str+="&province_id="+province_id+"&quote="+price+"&keywords="+keywords;
        var setings={
            url:CRMURL.GetfilterListHuman,
            params:str,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(setings);
    },
    /*
    *功能：获取企业资源列表数据
    *参数：
    *page：当前页
    *size：页面显示数量
    */
    GetCompanresource:function(page,size,sf,ff){
        var setings={
            url:CRMURL.GetCmRelist,
            params:"page="+page+"&size="+size,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(setings);
    },
    /*
    *功能：获取筛选后的人才资源列表
    *参数：keywords：关键字
    *cate_id：阶段
    *pro_id：//进度
    *sour_id：来源
    *cert_id//证书
    *in_id//专业
    *reg_info:注册情况
    *title_level_id职称等级
    *title_id//职称名称
    *title_type_id//职称类别
    *province_id：省份
    *page：页面索引
    *size：每页显示数量
    *sf：成功执行
    *ff：失败执行
    */ 
    GetFilterCmpList:function(page,size,is_fultime,cate_id,pro_id,sour_id,apt_id,reg_info,province_id,keywords,price,sf,ff){
        var str="page="+page+"&size="+size+"&is_fultime="+is_fultime+"&cate_id="+cate_id+"&pro_id="+pro_id;
        str+="&sour_id="+sour_id+"&apt_id="+apt_id+"&reg_info="+reg_info;
        str+="&province_id="+province_id+"&keywords="+keywords+"&quote="+price;
        var setings={
            url:CRMURL.GetFilterEnterResoue,
            params:str,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(setings);
    },
    /*
    *功能：删除人才资源
    *参数：
    *ids：人才资源ID集合
    *sf：成功回调函数
    *ff：失败回调函数
    */
    DeleHumanReource:function(ids,sf,ff){
        var setings={
            url:CRMURL.DeleHuamnsRes,
            params:"ids="+ids,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(setings); 
    },
    /*
    *功能：删除企业资源
    *参数：
    *ids：企业资源ID集合
    *sf：成功回调函数
    *ff：失败回调函数
    */
    DeleCompanyRes:function(ids,sf,ff){
        var setings={
            url:CRMURL.DeleEnterpriseRes,
            params:"ids="+ids,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(setings); 
    },
    /*
    *功能：企业更新基本信息
    *参数：
    * enter_id:企业id
    *name:企业名称
    *source_id:来源
    *type_id:企业性质
    *found_time:成立时间
    *site:网址
    *brief:简介
    *sf：成功回调函数
    *ff：失败回调函数
    */
    UpdateEnterpriseBasic:function(p,sf,ff){
        var str="enter_id="+p.enter_id+"&name="+p.name+"&source_id="+p.source_id;
        str+="&type_id="+p.type_id+"&found_time="+p.found_time+"&site="+p.site+"&brief="+p.brief;
        var setings={
            url:CRMURL.DoupdateEnterprise,
            params:str,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(setings); 
    },
    /*
    *功能:添加企业资质
    *参数：
    *enter_id：企业ID
    *name：资质名称
    */
    DoAddEnterQuali:function(enter_id,name,sf,ff){
        var setings={
            url:CRMURL.AddEnterPriseQual,
            params:"enter_id="+enter_id+"&name="+name,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(setings); 
    },
    /*
    *功能：删除企业资质
    *参数：无
    *cn_id：关系ID
    *name：资质名称
    *sf:成功回调函数
    *ff:失败回调函数
    */
    DeleEnterpriseQuali:function(cn_id,name,sf,ff){
        var setings={
            url:CRMURL.DeleEnterQual,
            params:"cn_id="+cn_id+"&name="+name,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(setings); 
    },
    /*
    *功能：更新企业资质
    *参数：无
    *cn_id：关系ID
    *name：资质名称
    *sf:成功回调函数
    *ff:失败回调函数
    *
    */
    DoupEnterrequali:function(cn_id,name,sf,ff){
        var setings={
            url:CRMURL.UpdateEnterpriseQual,
            params:"cn_id="+cn_id+"&name="+name,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(setings); 
    },
    /*
    *功能：更新企业联系人
    *参数：
    enter_id:企业ID
    name:联系人名字
    mobile:手机
    email:邮箱
    phone:座机
    qq:QQ号码
    fax:传真
    zipcode:邮编
    province_id:省ID
    city_id:市ID
    region_id:区ID
    community_id:镇ID
    address:详细地址
    *sf:成功回调函数
    *ff:失败回调函数
    *
    */
    DoUpContacter:function(p,sf,ff){
        var str="enter_id="+p.enter_id+"&name="+p.name+"&mobile="+p.mobile+"&email="+p.email+"&phone="+p.phone+"&qq="+p.qq;
        str+="&fax="+p.fax+"&zipcode="+p.zipcode+"&province_id="+p.province_id+"&city_id="+p.city_id+"&region_id="+p.region_id+"&community_id="+p.community_id;
        str+="&address="+p.address;
        var setings={
            url:CRMURL.DoUdateContacter,
            params:str,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(setings); 
    },
    /*
    *功能：获取对应区域
    */
    GetAreaLis:function(id,level,sf,ff){
        var setings={
            url:CRMURL.GetAreaInfo,
            params:"id="+id+"&level="+level,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(setings);  
    },
    /* 功能：人才 - 更新基本信息
     * 参数：
     * a：人才id
     * b：姓名
     * c：性别
     * d：客户来源
     * e：生日
     * f：证件类型
     * g：证件号
     * h：手机
     * i：座机
     * j：邮箱
     * k：qq
     * l：传真
     * m：邮编
     * n：省id
     * o：市id
     * p：区id
     * q：镇id
     * r：地址
     * s：人才附件关系id
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：array =>
     */
    TUpdateBase:function(a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,sf,ff){
        var setings={
            url:CRMURL.TUpdateBase,
            params:"human_id="+a+"&name="+b+"&sex="+c+"&sour_id="+d+"&birthday="+e
                   +"&att_type_id="+f+"&identifier="+g+"&mobile="+h+"&phone="+i
                   +"&email="+j+"&qq="+k+"&fax="+l+"&zipcode="+m+"&province_id="+n
                   +"&city_id="+o+"&region_id="+p+"&community_id="+q+"&address="+r+"&att_human_id="+s,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(setings);  
    },
    /* 功能：人才 - 更新资质证书
     * 参数：
     * a：证书id
     * b：行业id
     * c：资质人才关系id
     * d：人才id
     * e：注册情况
     * f：证书省id
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：array =>
     */
    TUpdateAptiude:function(a,b,c,d,e,f,sf,ff){
        var setings={
            url:CRMURL.TUpdateAptiude,
            params:"cert_id="+a+"&in_id="+b+"&aman_id="+c+"&human_id="+d+"&reg_info="+e
                   +"&province_id="+f,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(setings);  
    },
    /*
    *功能：更新单条企业需求数据
    *参数集合：p
    * enter_id 企业ID 
    * demand_id 需求ID
    * apt_id 资质Id
    * reg_info  注册情况
    * need_price 需求价格
    * need_year 需求年数
    * need_num  需求个数
    * is_fulltime 是否全职/兼职
    * service_charge  服务费
    * demand_is_tax 是否含税
    * use  用途
    * demand_notes 需求备注
    * sf：成功回调函数
    * ff:失败回调函数
    */
   UpComRequire:function(p,sf,ff){
         var str="enter_id="+p.enter_id+"&demand_id="+p.demand_id+"&apt_id="+p.apt_id+"&reg_info="+p.reg_info+"&need_price="+p.need_price;
             str+="&need_year="+p.need_year+"&need_num="+p.need_num+"&is_fulltime="+p.is_fulltime+"&service_charge="+p.service_charge+"&demand_is_tax="+p.demand_is_tax+"&use="+p.use;
             str+="&demand_notes="+p.demand_notes;
         var setings={
            url:CRMURL.UpEntEnterRequire,
            params:str,
            sucrender:sf,
            failrender:ff
       };
       HGS.Base.HAjax(setings);  
   },
    /* 功能：人才 - 更新资质证书
     * 参数：
     * a：人才id
     * b：开户行数据id
     * c：开户行
     * d：开户帐号
     * e：开户名
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：array =>
     */
    TUpdateBank:function(a,b,c,d,e,sf,ff){
        var setings={
            url:CRMURL.TUpdateBank,
            params:"human_id="+a+"&bank_id="+b+"&bank_name="+c+"&account="+d+"&username="+e,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(setings);  
    },
    /* 功能：人才 - 更新注册企业信息
     * 参数：
     * a：人才id
     * b：支付时间
     * c：支付方式
     * d：到期时间
     * e：合同期
     * f：签约时间
     * g：聘用工资
     * h：负责单位合作者
     * i：聘用单位地址
     * j：单位名称
     * k：人才附件关系id
     * l：证件类型id
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：array =>
     */
    TUpdateEmploy:function(a,b,c,d,e,f,g,h,i,j,k,l,sf,ff){
        var setings={
            url:CRMURL.TUpdateEmploy,
            params:"human_id="+a+"&pay_time="+b+"&payment="+c+"&expr_time="+d+"&contract="+e
                    +"&sign_time="+f+"&pay="+g+"&charger="+h+"&location="+i+"&company_name="+j
                    +"&att_human_id="+k+"&att_type_id="+l,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(setings);  
    },
    /* 功能：人才 - 更新备注信息
     * 参数：
     * a：人才id
     * b：备注
     * c：人才附件关系id
     * d：证件类型id
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：array =>
     */
    TUpdateRemark:function(a,b,c,d,sf,ff){
        var setings={
            url:CRMURL.TUpdateRemark,
            params:"human_id="+a+"&remark="+b+"&att_human_id="+c+"&att_type_id="+d,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(setings);  
    },
    /*
     *功能：删除企业需求
     *参数：需求ID
     *demand_id
     *sf：成功回调函数
     *ff：失败回调函数
     */
    DeleEnterPriseRequire:function(b,sf,ff){
        var setings={
            url:CRMURL.DeleEnterRequire,
            params:"demand_id="+b,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(setings);
    },
    /* 功能：人才 - 添加资质证
     * 参数：
     * a：资质证书id
     * b：人才id
     * c：注册情况
     * d：证书注册省id
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：array =>
     */
    TAddQual:function(a,b,c,d,sf,ff){
        var setings={
            url:CRMURL.TAddQual,
            params:"apt_id="+a+"&human_id="+b+"&reg_info="+c+"&province_id="+d,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(setings);  
    },
    /* 功能：人才 - 删除资质证
     * 参数：
     * a：资质人才关系ID
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：array =>
     */
    TDeleQual:function(a,sf,ff){
        var setings={
            url:CRMURL.TDeleQual,
            params:"aman_id="+a,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(setings);  
    },
      /* 功能：人才 - 删除自己导入的资质证书
     * 参数：
     * a：资质证书ID
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：array =>
     */
    TaDeOwnResource:function(a,sf,ff){
        var setings={
            url:CRMURL.TalDelOres,
            params:"certificate_id="+a,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(setings);  
    },
    /* 功能：人才 - 更新职称证
     * 参数：
     * a：人才id
     * b：职称id
     * c：职称等级
     * d：人才附件关系id
     * e：证件类型id
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：array =>
     */
    TUpdateTitle:function(a,b,c,d,e,price,sf,ff){
        var setings={
            url:CRMURL.TUpdateTitle,
            params:"human_id="+a+"&title_id="+b+"&title_level="+c+"&att_human_id="+d+"&att_type_id="+e+"&quote="+price,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(setings);  
    },
    /*
     *功能：添加企业需求
     *参数集合：p
    * enter_id 企业ID 
    * apt_id:资质Id
    * reg_info  注册情况
    * need_price 需求价格
    * need_year 需求年数
    * need_num  需求个数
    * is_fulltime 是否全职/兼职
    * service_charge  服务费
    * demand_is_tax 是否含税
    * use  用途
    * demand_notes 需求备注
    * sf：成功回调函数
    * ff:失败回调函数
     */
    addEnterRequire:function(p,sf,ff){
         var str="enter_id="+p.enter_id+"&apt_id="+p.apt_id+"&reg_info="+p.reg_info+"&need_price="+p.need_price+"&need_year="+p.need_year+"&need_num="+p.need_num;
             str+="&is_fulltime="+p.is_fulltime+"&service_charge="+p.service_charge+"&demand_is_tax="+p.demand_is_tax+"&use="+p.use;
             str+="&demand_notes="+p.demand_notes;
         var setings={
            url:CRMURL.AddEnterRequires,
            params:str,
            sucrender:sf,
            failrender:ff
       };
       HGS.Base.HAjax(setings);  
    },
    /* 功能：企业 - 更新备注信息
     * 参数：
     * a：企业id
     * b：备注
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：array =>
     */
    CUpdateRemark:function(a,b,sf,ff){
        var setings={
            url:CRMURL.CUpdateRemark,
            params:"enter_id="+a+"&remark="+b,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(setings);  
    },
    /*
     *功能：添加企业注册人信息
     *参数
     *enter_id:企业ID
     name:注册人名字
     sex:性别
     pay:聘用工资
     apt_id: 资质证书ID
     reg_info:注册情况
     sign_time:签约时间
     contract_period:合同期
     expiration_time:到期时间
     pay_way:支付方式
     pay_time支付时间
     is_refund:是否退款
     refund_time:退款时间
     *sf：成功执行函数
     *ff：失败执行函数
     */
    AddNewRegPerson:function(p,sf,ff){
       var str="enter_id="+p.enter_id+"&name="+p.name+"&sex="+p.sex+"&pay="+p.pay+"&apt_id="+p.apt_id+"&reg_info="+p.reg_info;
             str+="&sign_time="+p.sign_time+"&contract_period="+p.contract_period+"&expiration_time="+p.expiration_time+"&pay_way="+p.pay_way;
             str+="&pay_time="+p.pay_time+"&is_refund="+p.is_refund+"&refund_time="+p.refund_time+"&refund_money="+p.refund_money+"&refund_singor="+p.refund_singor+"&refund_signer="+p.refund_signer+"&refund_reseaon="+p.refund_reseaon;
        var setings={
            url:CRMURL.AddEnterRegTa,
            params:str,
            sucrender:sf,
            failrender:ff
       };
       HGS.Base.HAjax(setings);    
    },
    /*
     *功能：更新企业注册人才信息
     *参数：
     *rc_id:注册人企业关系
     name:注册人名字
     sex:性别
     pay:聘用工资
     apt_id: 资质证书ID
     reg_info:注册情况
     sign_time:签约时间
     contract_period:合同期
     expiration_time:到期时间
     pay_way:支付方式
     pay_time支付时间
     is_refund:是否退款
     refund_time:退款时间
     *sf：成功执行函数
     *ff：失败执行函数
     */
    UpCompanyRetan:function(p,sf,ff){
         var str="rc_id="+p.rc_id+"&name="+p.name+"&sex="+p.sex+"&pay="+p.pay+"&apt_id="+p.apt_id+"&reg_info="+p.reg_info;
             str+="&sign_time="+p.sign_time+"&contract_period="+p.contract_period+"&expiration_time="+p.expiration_time+"&pay_way="+p.pay_way;
             str+="&pay_time="+p.pay_time+"&is_refund="+p.is_refund+"&refund_time="+p.refund_time+"&refund_money="+p.refund_money+"&refund_singor="+p.refund_singor+"&refund_signer="+p.refund_signer+"&refund_reseaon="+p.refund_reseaon;
        var setings={
            url:CRMURL.UpdateEnterRegTa,
            params:str,
            sucrender:sf,
            failrender:ff
       };
       HGS.Base.HAjax(setings);  
    },
    /*
     *功能：删除企业注册人才数据
     *参数：关系ID
     */
    DeleComReTan:function(rc_id,sf,ff){
        var setings={
            url:CRMURL.DeleComReTan,
            params:"rc_id="+rc_id,
            sucrender:sf,
            failrender:ff
       };
       HGS.Base.HAjax(setings);   
    }
}



