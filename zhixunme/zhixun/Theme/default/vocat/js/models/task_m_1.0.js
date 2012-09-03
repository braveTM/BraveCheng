/*
 *任务 - model类
 */
function Task(){
}
//HGS.Base.Extend(User,BaseClass);
Task.prototype={
    /* 功能：获取首页指定任务分类展示的数据
     * 参数：
     * cid：分类编号
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：array => 行情数据数组
     */
    GetTaskShow:function(cid,sf,ff){
        var s={
            url:WEBURL.GetTaskShow,
            params:"cid="+cid,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(s);
    },
    /* 功能：获取指定条件下的任务列表
     * 参数：
     * a：一级任务分类
     * b：二级任务分类
     * s：任务状态
     * t：日期选项
     * k：搜索关键字
     * p:第几页
     * sf：异步搜索数据成功后执行的方法对象
     * ff：异步搜索数据失败后执行的方法对象
     * 返回值：无
     */
    GetTaskList:function(a,b,s,t,k,p,sf,ff){
        var set={
            url:WEBURL.GetTasks,
            params:"ac="+a+"&bc="+b+"&status="+s+"&type="+t+"&key="+k+"&page="+p,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /* 功能：获取指定条件下的任务竞标列表
     * 参数：
     * a：任务编号
     * b：第几页
     * c：用户角色
     * sf：异步搜索数据成功后执行的方法对象
     * ff：异步搜索数据失败后执行的方法对象
     * 返回值：无
     */
    GetTaskBiddingList:function(a,b,c,d,sf,ff){
        var s={
            url:WEBURL.GetTaskBiddings,
            params:"tid="+a+"&page="+b+"&type="+c+"&size="+d,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(s);
    },
    /* 功能：发布任务
     * 参数：
     * a：标题
     * b：内容
     * c：分类a
     * d：分类b
     * e：电话
     * f：邮箱
     * g：QQ
     * h：任务天数
     * sf：异步搜索数据成功后执行的方法对象
     * ff：异步搜索数据失败后执行的方法对象
     * 返回值：无
     */
    PubTask:function(a,b,c,d,e,f,g,h,sf,ff){
        var s={
            url:WEBURL.PubTask,
            params:"title="+a+"&content="+b+"&ac="+c+"&bc="+d+"&phone="+e+"&email="+f+"&qq="+g+"&days="+h,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(s);
    },
    /* 功能：快速发布任务
     * 参数：
     * a：内容
     * b：电话
     * c：邮箱
     * d：QQ
     * e：任务天数
     * sf：异步搜索数据成功后执行的方法对象
     * ff：异步搜索数据失败后执行的方法对象
     * 返回值：无
     */
    FastPub:function(a,b,c,d,e,sf,ff){
        var s={
            url:WEBURL.FastPub,
            params:"content="+a+"&contact="+b+"&email="+c+"&qq="+d+"&days="+e,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(s);
    },
    /* 功能：获取指定用户发布的任务列表
     * 参数：
     * a：第几页
     * b：任务状态(0：全部，1：待选标，2：已完成，3：已过期)
     * c：排序(d：倒序，a:正序)
     * sf：异步搜索数据成功后执行的方法对象
     * ff：异步搜索数据失败后执行的方法对象
     * 返回值：无
     */
    GetUserTaskList:function(a,b,c,sf,ff){
        var set={
            url:WEBURL.GetUserPubTask,
            params:"page="+a+"&status="+b+"&order="+c,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /* 功能：获取指定用户发布的任务列表
     * 参数：
     * a：第几页
     * b：任务状态(0：全部，1：待选标，2：已完成，3：已过期，4：我中标的任务)
     * c：排序(d：倒序，a:正序)
     * sf：异步搜索数据成功后执行的方法对象
     * ff：异步搜索数据失败后执行的方法对象
     * 返回值：无
     */
    GetUserBiddingList:function(a,b,c,sf,ff){
        var set={
            url:WEBURL.GetUserBiddingTask,
            params:"page="+a+"&status="+b+"&order="+c,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /* 功能：我要竞标
     * 参数：
     * a：任务编号
     * b：竞标内容
     * c：是否返回联系方式
     * sf：异步搜索数据成功后执行的方法对象
     * ff：异步搜索数据失败后执行的方法对象
     * 返回值：无
     */
    IBidding:function(a,b,c,sf,ff){
         var s={
            url:WEBURL.IBidding,
            params:"tid="+a+"&content="+b+"&gc="+c,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(s);
    },
    /* 功能：选某人为中标
     * 参数：
     * a：任务编号
     * b：竞标编号
     * sf：异步搜索数据成功后执行的方法对象
     * ff：异步搜索数据失败后执行的方法对象
     * 返回值：无
     */
    ChooseOneBidding:function(a,b,sf,ff){
        var s={
            url:WEBURL.ChooseBidding,
            params:"tid="+a+"&rid="+b,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(s);
    },
    /* 功能：立即推广
     * 参数：
     * a：任务编号
     * b：推广方式（1：标红，2：推荐，3：置顶）
     * c：天数
     * sf：异步搜索数据成功后执行的方法对象
     * ff：异步搜索数据失败后执行的方法对象
     * 返回值：无
     */
    TPubPromoteTask:function(a,b,c,sf,ff){
        var s={
            url:WEBURL.TPubPromoteTask,
            params:"info_id="+a+"&service_type="+b+"&day="+c,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(s);
    },
    /* 功能：获取指定用户收到的委托列表
     * 参数：
     * a：第几页
     * b：状态:(0：全部，2：未回复，3：已拒绝，4：已接受)
     * sf：异步搜索数据成功后执行的方法对象
     * ff：异步搜索数据失败后执行的方法对象
     * 返回值：无
     */
    GetUserGetDele:function(a,b,sf,ff){
        var set={
            url:WEBURL.GetUserGDele,
            params:"page="+a+"&status="+b,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /* 功能：发布委托
     * 参数：
     * a：委托标题
     * b：委托内容
     * c：联系电话
     * d：邮箱
     * e：QQ
     * f：天数
     * g：大分类号
     * h：小分类号
     * sf：异步搜索数据成功后执行的方法对象
     * ff：异步搜索数据失败后执行的方法对象
     * 返回值：无
     */
    PubDelegate:function(a,b,c,d,e,f,g,h,sf,ff){
        var s={
            url:WEBURL.PubDelegate,
            params:"title="+a+"&content="+b+"&contact="+c+"&email="+d+"&qq="+e+"&days="+f+"&ac="+g+"&bc="+h,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(s);
    },
    /* 功能：获取指定用户委托出去的任务列表
     * 参数：
     * a：委托状态
     * b：第几页
     * sf：异步搜索数据成功后执行的方法对象
     * ff：异步搜索数据失败后执行的方法对象
     * 返回值：无
     */
    GetUserPostDele:function(a,b,sf,ff){
        var set={
            url:WEBURL.GetUserPDele,
            params:"status="+a+"&page="+b,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /* 功能：获取指定企业的待处理委托任务列表
     * 参数：
     * a：第几页
     * sf：异步搜索数据成功后执行的方法对象
     * ff：异步搜索数据失败后执行的方法对象
     * 返回值：无
     */
    GetUserPendDele:function(a,sf,ff){
        var set={
            url:WEBURL.GetPendDeles,
            params:"page="+a,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /* 功能：获取指定企业的待处理委托任务列表(不分页)
     * 参数：
     * sf：异步搜索数据成功后执行的方法对象
     * ff：异步搜索数据失败后执行的方法对象
     * 返回值：无
     */
    GetComPendDele:function(sf,ff){
        var set={
            url:WEBURL.GetComPendDele,
            params:"",
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /* 功能：删除指定委托记录
     * 参数：
     * a：委托id
     * sf：异步搜索数据成功后执行的方法对象
     * ff：异步搜索数据失败后执行的方法对象
     * 返回值：无
     */
    DelDelegate:function(a,sf,ff){
        var set={
            url:WEBURL.DelDelegate,
            params:"id="+a,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /* 功能：指定代理 委托任务
     * 参数：
     * a：委托id
     * b：猎头id
     * sf：异步搜索数据成功后执行的方法对象
     * ff：异步搜索数据失败后执行的方法对象
     * 返回值：无
     */
    DeleTask:function(a,b,sf,ff){
        var set={
            url:WEBURL.DeleTask,
            params:"did="+a+"&uid="+b,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /*
     *功能：获取为猎头推荐的任务列表
      * 参数：
     * page：页面索引
     * size：每页显示条数
     * ac：大分类
     * bc：子分类
     * status:状态
     * sf：异步搜索数据成功后执行的方法对象
     * ff：异步搜索数据失败后执行的方法对象
     */
    AGetRecomTaLis:function(page,size,ac,bc,status,sf,ff){
         var set={
            url:WEBURL.DoAGetRecomTaLis,
            params:"page="+page+"&size="+size+"&ac="+ac+"&bc="+bc+"&status="+status,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
       /*
     *功能：获取为企业推荐的任务列表
      * 参数：
     * page：页面索引
     * size：每页显示条数
     * ac：大分类
     * bc：子分类
     * status:状态
     * sf：异步搜索数据成功后执行的方法对象
     * ff：异步搜索数据失败后执行的方法对象
     */
    EnterGetRecomTaLis:function(page,size,ac,bc,status,sf,ff){
         var set={
            url:WEBURL.DoEnterGetRecomTaLis,
            params:"page="+page+"&size="+size+"&ac="+ac+"&bc="+bc+"&status="+status,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    }
};
