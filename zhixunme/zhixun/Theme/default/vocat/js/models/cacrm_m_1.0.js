/*
 * - model类
 */
function Cacrm(){}
Cacrm.prototype={
    /*
     *功能：冻结猎头
     *参数：
     *a：猎头id
     *sf：成功执行方法
     *ff：失败执行方法
     */
    OffAgent:function(a,sf,ff){
        var s={
            url:CAURL.OffAgent,
            params:'user_id='+a,
            sucrender:sf,
            failrender:ff
        };          
        HGS.Base.HAjax(s);      
    },
    /*
     *功能：解冻猎头
     *参数：
     *a：猎头id
     *sf：成功执行方法
     *ff：失败执行方法
     */
    OnAgent:function(a,sf,ff){
        var s={
            url:CAURL.OnAgent,
            params:'user_id='+a,
            sucrender:sf,
            failrender:ff
        };          
        HGS.Base.HAjax(s);      
    },
     /*
     *功能：排序
     *参数：
     *page:页面索引
     *size：每页显示条数
     *resume：公开简历 0降序1升序
     *job：公开职位 0降序1升序
     *article：发布文章 0降序1升序
     *view：文章浏览量 0降序1升序
     *sf：成功执行方法
     *ff：失败执行方法
     */
    GetCertainData:function(page,pagesize,field,order,start_time,end_time,sf,ff){
        var s={
            url:CAURL.GetFilterEmployee,
            params:"curpage="+page+"&page_size="+pagesize+"&field="+field+"&order="+order+"&start_time="+start_time+"&end_time="+end_time,
            sucrender:sf,
            failrender:ff
        };          
        HGS.Base.HAjax(s);      
    },
    /*按时间查询,异步请求
     *参数：无
     *jang
     *
     */
    GetAgentByTime:function(t,sf,ff){        
        var s={
            url:CAURL.GetFilterEmployee,
            params:"start_time="+t[0]+"&end_time="+t[1],
            sucrender:sf,
            failrender:ff
        };        
        HGS.Base.HAjax(s);
    }
}
