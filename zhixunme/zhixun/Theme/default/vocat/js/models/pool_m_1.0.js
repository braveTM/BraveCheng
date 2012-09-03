/*
 *资源库 - model类
 */
function Pool(){
}
//HGS.Base.Extend(User,BaseClass);
Pool.prototype={
    //    /* 功能：获取个人资源库列表
    //     * 参数：
    //     * a: 资源类型（1：人才，2：企业）
    //     * b：第几页
    //     * c：（可选）搜索关键字
    //     * sf：异步获取数据成功后执行的方法对象
    //     * ff：异步获取数据失败后执行的方法对象
    //     * 返回值：array => 个人资源库列表
    //     */
    //    GetPoolList:function(a,b,c,sf,ff){
    //        var s={
    //            url:WEBURL.GetPoolList,
    //            params:"type="+a+"&page="+b+"&like="+c,
    //            sucrender:sf,
    //            failrender:ff
    //        };
    //	HGS.Base.HAjax(s);
    //    },
    //    /*
    //     *功能：添加人才到人才库中
    //     *参数：
    //     *p：人才信息
    //     *jack
    //     *2011.12.22
    //     *
    //     */
    //    addtcLib:function(p,s,f){
    //        var str="r_name="+p.r_name+"&r_province="+p.r_province+"&r_city="+p.r_city+"&r_phone="+p.r_phone+"&r_qual="+p.r_zizhi+"&type="+p.type;
    //         var settings={
    //            url:WEBURL.AddTcLib,
    //            params:str,
    //            sucrender:s,
    //            failrender:f
    //        };
    //	HGS.Base.HAjax(settings);
    //    },
    /*
     *功能：获取资源库对应页面数据列表
     *参数：
     *说明：四个页面数据列表公共方法
     */
    getDataList:function(label,role_id,auth_code,province,city,key,page,order,aid,sf,ff){
        var s={
            url:WEBURL.GetAgentList,
            params:"label="+label+"&role_id="+role_id+"&auth_code="+auth_code+"&province="+province+"&city="+city+"&key="+key+"&page="+page+"&order="+order,
            sucrender:sf,
            failrender:ff
        };
        $("div").attr("pageid",page);
        HGS.Base.HAjax(s);
    },
    /*
     *功能：人才获取猎头列表
     *参数：页数：page
     *类型：不限：0
     *个人：1
     *公司：2
     *地区：不限：0,0
     *省份编号 pid
     *城市编号 cid
     *jack
     *2012-2-12
     */
    TanGetAgentList:function(page,size,type,pid,cid,sf,ff){
        var s={
            url:WEBURL.GetTanAgentList,
            params:"page="+page+"&size="+size+"&type="+type+"&addr_province_code="+pid+"&addr_city_code="+cid,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(s);
    },
    /*
     *功能：企业获取猎头列表
     *参数：页数：page
     *类型：不限：0
     *个人：1
     *公司：2
     *地区：不限：0,0
     *省份编号 pid
     *城市编号 cid
     *jack
     *2012-2-12
     */
    CompanyGetAgentList:function(page,size,type,pid,cid,sid,sf,ff){
        var s={
            url:WEBURL.GetCompnayAgentList,
            params:"page="+page+"&size="+size+"&type="+type+"&addr_province_code="+pid+"&addr_city_code="+cid+"&service_category_id="+sid,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(s);
    },
    /*
     *功能：企业获取感兴趣的人才
     *参数：
     * a：第几页
     * b：工作性质（1为全职，2为兼职）
     * c：注册情况(1-初始，2-变更，3-重新）
     * d：发布人角色（1-人才，3-猎头）
     * e：期望注册地(以“,”分隔的省份编号）
     * f：注册证书ID
     * g：每页条数
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     */
    ComGetTalentList:function(a,b,c,d,e,f,g,sf,ff){
        var s={
            url:WEBURL.EGetTanlentList,
            params:"page="+a+"&size="+g+"&job_category="+b+"&register_case="+c+"&publisher_role="+d
            +"&register_province_ids="+e+"&register_certificate_id="+f,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(s);
    },
    /*
     *功能：人才获取感兴趣的企业
     *参数：
     * a：第几页
     * b：每页条数
     * c：企业注册地省份编号
     * d：企业注册地城市编号
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     */
    TGetCompanyList:function(a,b,c,d,sf,ff){
        var s={
            url:WEBURL.TGetCompanyList,
            params:"page="+a+"&size="+b+"&company_province_code="+c+"&company_city_code="+d,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(s);
    },
    /*
     *功能：人才委托简历
     *参数：猎头id
     *简历类型type
     */
    ApplyAgentResme:function(aid,type,sf,ff){
        var s={
            url:WEBURL.DoapplyAgentResum,
            params:"agent_id="+aid+"&job_category="+type,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(s);
    },
    /*
     *功能：大首页 - 获取人才列表
     *参数：
     *a：页数
     *b：总共条数
     */
    FGetTalents:function(a,b,sf,ff){
        var s={
            url:WEBURL.FGetTalents,
            params:"page="+a+"&size="+b,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(s);
    },
    //    /*
    //     *功能：大首页 - 获取找任务 - 任务列表
    //     *参数：
    //     *a：页数
    //     *b：总共条数
    //     */
    //    FGetTasks:function(a,b,sf,ff){
    //         var s={
    //            url:WEBURL.FGetTasks,
    //            params:"tid=0&page="+a+"&type=0&size="+b,
    //            sucrender:sf,
    //            failrender:ff
    //        };
    //	HGS.Base.HAjax(s);
    //    },
    /*
     *功能：获取我所关注的人列表
     *参数：page：页面索引
     *size：每页条数
     *type：角色类型
     *sf：成功执行方法
     *ff：失败执行函数
     */
    GetFocusPersonList:function(type,page,size,sf,ff){
        var s={
            url:WEBURL.GetFocsPerson,
            params:"page="+page+"&size="+size+"&type="+type,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(s);
    },
    /*
     *功能：获取人脉动态列表
     *参数：
     *page：当前页
     *size：每页显示数据条数
     *type：角色类型
     *sf：成功执行方法
     *ff：失败执行方法
     */
    GetNetworkDynamicLis:function(page,size,type,sf,ff){
        var s={
            url:WEBURL.GetDymicLis,
            params:"page="+page+"&size="+size+"&type="+type,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(s);
    },
    /*
     *功能：获取推荐人才列表
     *参数：
     *sf：成功执行方法
     *ff：失败执行方法
     */
    GetRecHumansLis:function(sf,ff){
        var s={
            url:WEBURL.GetChangeHuman,
            params:'',
            sucrender:sf,
            failrender:ff
        };        
        HGS.Base.HAjax(s);      
    },
    /*
     *功能：获取推荐猎头列表
     *参数：
     *sf：成功执行方法
     *ff：失败执行方法
     */
    GetRecMidmanLis:function(sf,ff){
        var s={
            url:WEBURL.GetChangeMidman,
            params:'',
            sucrender:sf,
            failrender:ff
        };          
        HGS.Base.HAjax(s);      
    },
    /*
     * 功能：关闭猎头推送弹窗
     * 参数：
     * 无
     */
    ClosePopu:function(){
        var s={
            url:WEBURL.ClosePopu,
            params:'',
            sucrender:null,
            failrender:null
        };          
        HGS.Base.HAjax(s);      
    }
}
