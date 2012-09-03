/*
 *站内信 - model类
 */
function Message(){
}
//HGS.Base.Extend(User,BaseClass);
Message.prototype={
    /* 功能：获取我的消息列表
     * 参数：
     * a：第几页
     * b：类型（1、全部  2、系统信息  3、私人收件箱 4、已发送）
     * c：是否已读（0、未读  1、已读  2、全部）
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：array => 行情数据数组
     */
    GetMsgList:function(a,b,c,sf,ff){
        var s={
            url:WEBURL.GetMsgList,
            params:"page="+a+"&type="+b+"&read="+c,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(s);
    },
    /* 功能：发送站内信
     * 参数：
     * a：编号
     * b：姓名
     * c：标题
     * d：内容
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：array
     */
    SendMessage:function(a,b,c,d,sf,ff){
        var s={
            url:WEBURL.SendMsg,
            params:"id="+a+"&name="+b+"&title="+c+"&content="+d,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(s);
    },
    /* 功能：记录是否已阅读
     * 参数：
     * a：所有标记为已读的消息的id字符串
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：true or false
     */
    MarkRead:function(a,sf,ff){
        var s={
            url:WEBURL.RemarkRead,
            params:"ids="+a,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(s);
    },
    /*
     *取消关注某人
     *参数：取消关注者的id
     *sf：成功执行方法
     *ff:失败执行方法
     */
    removeFocus:function(uid,sf,ff){
        var s={
            url:WEBURL.RemoveFollower,
            params:"id="+uid,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(s);
    },
     /*
     *关注某人
     *参数：取消关注者的id
     *sf：成功执行方法
     *ff:失败执行方法
     */
    Add_FocusPerson:function(uid,sf,ff){
        var s={
            url:WEBURL.AddFollower,
            params:"id="+uid,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(s);
    },
    /*
     *功能：信息类-新闻动态
     *参数：
     *page:当前页
     *sf：成功执行方法
     *ff：失败执行方法
     */
    GetDynews:function(page,size,sf,ff){
         var s={
            url:WEBURL.Dodynews,
            params:"page="+page+"&size="+size,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(s);
    },
    /*
     *功能：发送反馈意见
     *参数：
     *name：姓名
     *phone：手机
     *email：电子邮箱
     *type：反馈分类
     *content：反馈内容
     *sf：反馈成功
     *ff：反馈失败
     */
    PostFeedBack:function(name,phone,email,type,cont,sf,ff){
        var s={
            url:WEBURL.DoPostFedBack,
            params:"user_name="+name+"&phone="+phone+"&email="+email+"&type="+type+"&content="+cont,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(s);  
    },
    /*
     *功能：邮箱邀请
     *参数：emails
     *sf：成功执行函数
     *ff：失败执行函数
     */
    SendEmilInvitation:function(emails,sf,ff){
        var s={
            url:WEBURL.SendEmRequest,
            params:"emails="+emails,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(s);   
    },
      /*
     *功能：短信邀请
     *参数：phones
     *sf：成功执行函数
     *ff：失败执行函数
     */
    SendPhonelInvitation:function(phones,sf,ff){
         var s={
            url:WEBURL.SendPhoneReuest,
            params:"phones="+phones,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(s);  
    },
     /* 功能：猎头赞一下
     * 参数：
     * a：猎头id
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：array => 行情数据数组
     */
    agentPraise:function(a,sf,ff){
        var s={
            url:WEBURL.agentPraise,
            params:"id="+a,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(s);
    }
};
