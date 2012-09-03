/*
 *委托 - model类
 */
function Delegate(){
}
//HGS.Base.Extend(User,BaseClass);
Delegate.prototype={
//    /* 功能：获取指定用户发布的委托列表
//     * 参数：
//     * a：委托类型（1为委托任务，2为职讯委托，3为指定委托）
//     * b：第几页
//     * sf：异步搜索数据成功后执行的方法对象
//     * ff：异步搜索数据失败后执行的方法对象
//     * 返回值：无
//     */
//    GetUserPostDele:function(a,b,sf,ff){
//        var set={
//            url:WEBURL.GetUserPDele,
//            params:"type="+a+"&page="+b,
//            sucrender:sf,
//            failrender:ff
//        };
//	HGS.Base.HAjax(set);
//    },
//    /* 功能：获取指定用户收到的委托列表
//     * 参数：
//     * a：第几页
//     * b：状态:(0：全部，2：未回复，3：已拒绝，4：已接受)
//     * sf：异步搜索数据成功后执行的方法对象
//     * ff：异步搜索数据失败后执行的方法对象
//     * 返回值：无
//     */
//    GetUserGetDele:function(a,b,sf,ff){
//        var set={
//            url:WEBURL.GetUserGDele,
//            params:"page="+a+"&status="+b,
//            sucrender:sf,
//            failrender:ff
//        };
//	HGS.Base.HAjax(set);
//    },
    /* 功能：验证猎头是否存在
     * 参数：
     * a：用户昵称
     * sf：异步搜索数据成功后执行的方法对象
     * ff：异步搜索数据失败后执行的方法对象
     * 返回值：无
     */
    ValidateAgent:function(a,sf,ff){
        var s={
            url:WEBURL.ValiAgent,
            params:"nick="+a,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(s);
    },
//    /* 功能：发布委托
//     * 参数：
//     * a：代理编号
//     * b：委托标题
//     * c：委托内容
//     * d：联系电话
//     * e：邮箱
//     * f：QQ
//     * g：天数
//     * h：委托分类号
//     * i：委托类型（1：委托任务，2：指定委托代理，3：职讯代理）
//     * sf：异步搜索数据成功后执行的方法对象
//     * ff：异步搜索数据失败后执行的方法对象
//     * 返回值：无
//     */
//    PubDelegate:function(a,b,c,d,e,f,g,h,i,sf,ff){
//        var s={
//            url:WEBURL.PubDelegate,
//            params:"aid="+a+"&title="+b+"&content="+c+"&contact="+d+"&email="+e+"&qq="+f+"&days="+g+"&bc="+h+"&status="+i,
//            sucrender:sf,
//            failrender:ff
//        };
//	HGS.Base.HAjax(s);
//    },
    /* 功能：接受委托
     * 参数：
     * a：委托编号
     * b：联系电话
     * c：邮箱
     * d：QQ
     * e：内容
     * f：状态（3：拒绝，4：接受）
     * sf：异步成功后执行的方法对象
     * ff：异步失败后执行的方法对象
     * 返回值：无
     */
    ReplyDele:function(a,b,c,d,e,f,sf,ff){
        var s={
            url:WEBURL.ReplyDele,
            params:"id="+a+"&contact="+b+"&email="+c+"&qq="+d+"&content="+e+"&status="+f,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(s);
    }
};