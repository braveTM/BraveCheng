/*
 *市场行情 - model类
 */
function Tool(){
}
//HGS.Base.Extend(User,BaseClass);
Tool.prototype={
    /*
     * 功能：获取市场行情-本月交易价
     * pid:省份编号   
     * like:关键字
     * page:第几页
     * size:每页几条 
     * sf：成功返回列表数据和总条数
     * ff：失败返回错误信息
     */
    GetDealPrice:function(pid,like,page,size,sf,ff){
         var s={
            url:WEBURL.GetDealTool,
            params:"pid="+pid+"&like="+like+"&page="+page+"&size="+size,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(s);
    },
     /*
     * 功能：获取市场行情-年度走势图
     * cid:证书编号   
     * pid:省份编号
     * year:年份
     * sf：成功返回列表数据和总条数
     * ff：失败返回错误信息
     */
    getRequestData:function(cid,pid,year,sf,ff){
         var s={
            url:WEBURL.GetReqData,
            params:"cid="+cid+"&pid="+pid+"&year="+year,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(s);
    },
     /*
     * 功能：获取市场行情-历年走势图
     * cid:证书编号   
     * pid:省份编号
     * sf：成功返回列表数据和总条数
     * ff：失败返回错误信息
     */
    getYearData:function(cid,pid,sf,ff){
         var s={
            url:WEBURL.getYearData,
            params:"cid="+cid+"&pid="+pid,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(s);
    }
}
