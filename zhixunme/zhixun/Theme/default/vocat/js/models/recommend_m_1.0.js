/*
 * 推荐 - model类
 */
function Recommend(){}
Recommend.prototype={
    /* 功能：猎头获取推荐简历列表
     * 参数：
     * a：第几页
     * b：每页条数
     * c：工作性质（1为全职，2为兼职）
     * d：注册情况(1-初始，2-变更，3-重新）
     * e：发布人角色（1-人才，3-猎头）
     * f：期望注册地(以“,”分隔的省份编号）
     * g：注册证书ID
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：array => 推荐人才列表
     */
    AGetRecTalents:function(a,b,c,d,e,f,g,sf,ff){
         var setting={
            url:WEBURL.AGetRecTalents,
            params:"page="+a+"&size="+b+"&job_category="+c+"&register_case="+d+"&publisher_role="
                    +e+"&register_province_ids="+f+"&register_certificate_id="+g,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(setting);
    },
    /* 功能：企业获取推荐简历列表
     * 参数：
     * a：第几页
     * b：每页条数
     * c：工作性质（1为全职，2为兼职）
     * d：注册情况(1-初始，2-变更，3-重新）
     * e：发布人角色（1-人才，3-猎头）
     * f：期望注册地(以“,”分隔的省份编号）
     * g：注册证书ID
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：array => 推荐人才列表
     */
    EGetRecTalents:function(a,b,c,d,e,f,g,sf,ff){
         var setting={
            url:WEBURL.EGetRecTalents,
            params:"page="+a+"&size="+b+"&job_category="+c+"&register_case="+d+"&publisher_role="
                    +e+"&register_province_ids="+f+"&register_certificate_id="+g,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(setting);
    },
    /* 功能：猎头获取推荐职位列表
     * 参数：
     * a：第几页
     * b：每页条数
     * c：工作性质（1为全职，2为兼职）
     * d：注册情况(1-初始，2-变更，3-重新）
     * e：发布人角色（1-人才，3-猎头）
     * f：期望注册地(以“,”分隔的省份编号）
     * g：注册证书ID
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：array => 推荐职位列表
     */
    AGetRecJobs:function(a,b,c,d,e,f,g,sf,ff){
         var setting={
            url:WEBURL.AGetRecJobs,
            params:"page="+a+"&size="+b+"&job_category="+c+"&register_case="+d+"&publisher_role="
                    +e+"&register_province_ids="+f+"&register_certificate_id="+g,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(setting);
    },
    /* 功能：人才获取推荐职位列表
     * 参数：
     * a：第几页
     * b：每页条数
     * c：工作性质（1为全职，2为兼职）
     * d：注册情况(1-初始，2-变更，3-重新）
     * e：发布人角色（1-人才，3-猎头）
     * f：期望注册地(以“,”分隔的省份编号）
     * g：注册证书ID
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：array => 推荐职位列表
     */
    EGetRecJobs:function(a,b,c,d,e,f,g,sf,ff){
         var setting={
            url:WEBURL.EGetRecJobs,
            params:"page="+a+"&size="+b+"&job_category="+c+"&register_case="+d+"&publisher_role="
                    +e+"&register_province_ids="+f+"&register_certificate_id="+g,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(setting);
    },
    /* 功能：获取推荐猎头列表
     * 参数：
     * a：服务类别id
     * b：类型（1为个人，2为公司）
     * c：省份编号
     * d：城市编号
     * e：第几页
     * f：条数
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：array => 推荐职位列表
     */
    GetRecAgent:function(a,b,c,d,e,f,sf,ff){
         var setting={
            url:WEBURL.GetRecAgent,
            params:"service_category_id="+a+"&type="+b+"&addr_province_code="+c+"&addr_city_code="+d+"&page="
                    +e+"&size="+f,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(setting);
    },
    /* 功能：获取推荐企业列表
     * 参数：
     * a：省份编号
     * b：城市编号
     * c：第几页
     * d：条数
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：array => 推荐职位列表
     */
    GetRecCompany:function(a,b,c,d,sf,ff){
         var setting={
            url:WEBURL.GetRecCompany,
            params:"company_province_code="+a+"&company_city_code="+b+"&page="+c+"&size="+d,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(setting);
    }
}
