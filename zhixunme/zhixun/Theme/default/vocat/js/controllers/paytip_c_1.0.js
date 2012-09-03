/* 
 * 付费操作提示控制器
 */
var paytipController={
    /*
     * 功能：付费操作检测
     * 参数：
     * a：付费操作编号
     * exp:  付费检查特殊情况所需参数（&a='value1'&b='value2'...）
     */
    payCheck:function(a,exp){
        if(!!!exp){
            exp='';
        }
        var bl=new Bill();
        return bl.PayCheck(a,exp);
    },
    /*
     * 功能：付费确认框事件绑定
     * 参数：
     * oid：继续操作按钮id
     * btn：操作按钮id
     * func：发布职位的函数
     */
    payBtnBind:function(oid,btn,func,parms){
        $("#"+oid).click(function(){
            if(!$(this).hasClass("clicked")){
                $(this).addClass("clicked");
                func(parms);
                $(this).parent().parent().parent().parent().parent().parent().fadeOut(200,function(){
                    $("#"+oid).removeClass("clicked");
                    $(btn).removeClass("clicked");
                });
            }
        });
        $("#"+oid).parent().parent().next().click(function(){
            $("#"+oid).removeClass("clicked");
            $(btn).removeClass("clicked");
        });
    },
    /*
     * 功能：操作付费提示
     * 参数：
     * num：操作编号
     * func：发布职位的函数
     * parms:方法参数数组
     * btn：操作按钮id
     * lan1：免费条数提醒
     * lan2：扣费提示
     * lan3：按钮文本
     * oid：继续操作按钮id
     * exp:  付费检查特殊情况所需参数
     */
    OperaTip:function(num,func,parms,btn,lan1,lan2,lan3,oid,exp){
        var r=this.payCheck(num,exp);
        if(!r.ret||(r.ret&&r.data.free<0)){
            func(parms);
        }else{
            var dt=r.data;
            var tip="";
            if(dt.free>0){
                tip=lan1.replace("{a}",dt.free);
            }else{
                tip=lan2.replace("{p}",dt.price);
            }
            baseController.InitialSureDialog("error", tip, oid, lan3);
            this.payBtnBind(oid,btn,func,parms);
        }
    },
    /*
     * 功能：余额不足去充值
     * 参数：
     * 无
     */
    NoScore:function(){
        baseController.InitialSureDialog("error", LANGUAGE.L0229, "chargescore", "立即充值");
        $("#chargescore").click(function(){
            if(!$(this).hasClass("clicked")){
                $(this).addClass("clicked");
                location.href=WEBROOT+'/bill/';
            }
        });
        $("#chargescore").parent().parent().next().click(function(){
            $("#chargescore").removeClass("clicked");
        });
    },
    /*
     * 功能：发布职位付费提示
     * 参数：
     * func：符合条件下所需执行方法
     * btn：操作按钮id
     * parms：函数所需参数数组
     */
    pubJobTip:function(func,parms,btn){
        var lan=LANGUAGE;
        this.OperaTip(1,func,parms,btn,lan.L0222,lan.L0223,lan.L0106,"payscore");
    },
//    /*
//     * 功能：查看猎头联系方式付费提示
//     * 参数：
//     * func：符合条件下所需执行方法
//     * btn：操作按钮id
//     * parms：函数所需参数数组
//     * exp：检查费用所需特殊参数（字符串）
//     */
//    checkAContactTip:function(func,parms,btn,exp){
//        var lan=LANGUAGE;
//        this.OperaTip(7,func,parms,btn,lan.L0222,lan.L0223,lan.L0224,"payscore",exp);
//    },
    /*
     * 功能：查看人才联系方式付费提示
     * 参数：
     * func：符合条件下所需执行方法
     * btn：操作按钮id
     * parms：函数所需参数数组
     * exp：检查费用所需特殊参数（字符串）
     */
    checkTContactTip:function(func,parms,btn,exp){
        var lan=LANGUAGE;
        this.OperaTip(16,func,parms,btn,lan.L0222,lan.L0223,lan.L0224,"payscore",exp);
    },
    /*
     * 功能：查看企业联系方式付费提示
     * 参数：
     * func：符合条件下所需执行方法
     * btn：操作按钮id
     * parms：函数所需参数数组
     * exp：检查费用所需特殊参数（字符串）
     */
    checkCContactTip:function(func,parms,btn,exp){
        var lan=LANGUAGE;
        this.OperaTip(17,func,parms,btn,lan.L0222,lan.L0223,lan.L0224,"payscore",exp);
    },
    /*
     * 功能：猎头投递简历付费提示
     * 参数：
     * func：符合条件下所需执行方法
     * btn：操作按钮id
     * parms：函数所需参数数组
     */
    ASendResumesTip:function(func,parms,btn){
        var lan=LANGUAGE;
        this.OperaTip(3,func,parms,btn,lan.L0222,lan.L0225,lan.L0227,"payscore");
    },
    /*
     * 功能：邀请简历付费提示
     * 参数：
     * func：符合条件下所需执行方法
     * btn：操作按钮id
     * parms：函数所需参数数组
     */
    VisitResumesTip:function(func,parms,btn){
        var lan=LANGUAGE;
        this.OperaTip(2,func,parms,btn,lan.L0222,lan.L0225,lan.L0226,"payscore");
    },
    /*
     * 功能：企业委托职位付费提示
     * 参数：
     * func：符合条件下所需执行方法
     * btn：操作按钮id
     * parms：函数所需参数数组
     */
    CDeleJobTip:function(func,parms,btn){
        var lan=LANGUAGE;
        this.OperaTip(14,func,parms,btn,lan.L0222,lan.L0223,lan.L0247,"payscore");
    },
    /*
     * 功能：人才委托简历付费提示
     * 参数：
     * func：符合条件下所需执行方法
     * btn：操作按钮id
     * parms：函数所需参数数组
     */
    TDeleResTip:function(func,parms,btn){
        var lan=LANGUAGE;
        this.OperaTip(15,func,parms,btn,lan.L0222,lan.L0223,lan.L0247,"payscore");
    },
    /*
     * 功能：账户推广付费提示
     * 参数：
     * func：符合条件下所需执行方法
     * btn：操作按钮id
     * parms：函数所需参数数组
     */
    AccPromoteTip:function(func,parms,btn){
        var lan=LANGUAGE;
        this.OperaTip(2,func,parms,btn,lan.L0222,lan.L0225,lan.L0226,"payscore");
    }
//    /*
//     * 功能：发布任务付费提示
//     * 参数：
//     * func：符合条件下所需执行方法
//     * btn：操作按钮id
//     * parms：函数所需参数数组
//     */
//    PubTaskTip:function(func,parms,btn){
//        var lan=LANGUAGE;
//        this.OperaTip(8,func,parms,btn,lan.L0222,lan.L0223,lan.L0106,"payscore");
//    },
//    /*
//     * 功能：任务竞标付费提示
//     * 参数：
//     * func：符合条件下所需执行方法
//     * btn：操作按钮id
//     * parms：函数所需参数数组
//     */
//    BidTaskTip:function(func,parms,btn){
//        var lan=LANGUAGE;
//        this.OperaTip(9,func,parms,btn,lan.L0222,lan.L0223,lan.L0106,"payscore");
//    },
//    /*
//     * 功能：选为中标付费提示
//     * 参数：
//     * func：符合条件下所需执行方法
//     * btn：操作按钮id
//     * parms：函数所需参数数组
//     */
//    CheckBidTaskTip:function(func,parms,btn){
//        var lan=LANGUAGE;
//        this.OperaTip(10,func,parms,btn,lan.L0222,lan.L0223,lan.L0228,"payscore");
//    }
};
