/* 
 * 用户首页控制器
 */
var bdIndexController={
    /*
     *功能：角色首页人才推荐 换一换功能 绑定事件
     *参数：
     *    
     */    
    a:function(){
        $("#chuman").unbind("click").bind("click",function(){                
            bdIndexController.ba();  
        });
    },
    /*
     * 功能：角色首页 换一换推荐人才 第一次数据获取
     * 参数：
     * 无
     */
    b:function(){        
        var that=bdIndexRender;           
        var p=new Pool();                
        p.GetRecHumansLis(that.aa,that.b); 
    // $("#chuman").remove();
    },
    /*
     * 功能：角色首页 换一换推荐人才 数据获取
     * 参数：
     * 无
     */
    ba:function(){        
        var that=bdIndexRender;        
        that.c($("#rec"));
        var p=new Pool();                
        p.GetRecHumansLis(that.a,that.b);            
    },   
    /*
     *功能：角色首页 推荐猎头第一次数据获取
     *参数：
     *    
     */    
    c:function(){
        var that=bdIndexRender;            
        var p=new Pool();      
        p.GetRecMidmanLis(that.d,that.b); 
        
    },
    /*
     *功能：角色首页 换一换推荐猎头 绑定事件
     *参数：
     *    
     */    
    ca:function(){
        $("#chuman").unbind("click").bind("click",function(){                
            bdIndexController.cb();  
        });
    },
    /*
     * 功能：角色首页 换一换推荐猎头 数据获取
     * 参数：
     * 无
     */
    cb:function(){        
        var that=bdIndexRender;        
        that.c($("#recmidman"));
        var p=new Pool();                
        p.GetRecMidmanLis(that.a,that.b);            
    },
    /* 功能:幻灯
    * 参数：无
    * 说明：无
    */  
    d:function(){
        var t1=1.5,t2=5,t3=6;
        bdIndexRender.dc("recompanys",t1,t2,t3);            
    },
    /************************************** 猎头推送弹出框 ***********************************/
    /* 
     * 功能：初始化弹出框 - 按钮效果
     * 参数：
     * 无
     */
    ga:function(){
        var base=baseController;
        base.BtnBind("div.agentalert div.btn15", "btn15", "btn15_hov", "btn15_hov");
        base.BtnBind("div.agentalert div.btn14", "btn14", "btn14_hov", "btn14_hov");
    },
    /* 
     * 功能：初始化弹出框 - 关闭按钮
     * 参数：
     * 无
     * 修改:joe 2012/7/16 添加最小化状态
     */
    gb:function(){
        $("#del_alert,#small_close").click(function(){
            if($(this).hasClass("close")){
               $(this).parent("div.small_view").fadeOut();
            }
            else{
             $(this).parents("div.agentalert").fadeOut();   
            }            
            var pl=new Pool();
            pl.ClosePopu();
        });        
    },
    /* 
     * 功能：初始化弹出框 - 加关注
     * 参数：
     * 无
     */
    gc:function(){
        var that=$("#careta");
        if(that){
            baseController.BtnBind("div.agentalert div.care_btn div.btn22", "btn22", "btn22_hov", "btn22_hov");
            that.click(function(){
                var a=$(this).attr("uid");
                var rd=bdIndexRender;
                var msg=new Message();
                msg.Add_FocusPerson(a,rd.e,rd.f);
            });
        }
    },
    /* 
     * 功能：初始化弹出框 - 最小化功能|还原功能
     * 参数：
     * author:joe 2012/7/16
     */
    gd:function(){
        var sv=$("#small_close").parent("div.small_view");
        var recAgent=$("#chg_view").parents("div.agentalert");
        var sw=sv.width(),sh=sv.height();
        var w=recAgent.width(),h=recAgent.height();
        $("#chg_view").click(function(){
            recAgent.fadeOut("300",function(){
                sv.show(1);
            });
        });
        $("#review").click(function(){
            sv.fadeOut(1,function(){
                recAgent.fadeIn("300");
            });
        });
    },
    gini:function(){
        this.ga();
        this.gb();
        this.gc();
        this.gd();
    },
    /************************************** 认证提示关闭功能 ***********************************/
    /*
     * 功能：关闭认证提示框
     * 参数：
     * r：插件返回结果
     * candice 2012-7-7
     * 无修改
     */
    e:function(){
        $("#cltip").click(function(){
            $(this).parent().slideUp();
        });
    },
    /* 
     * 功能：初始化猎头页面
     * 参数：
     * 无
     */
    IniPage:function(){
        baseRender.ae(0);        
        this.b();
        this.d();
        this.e();
    },
    /*
     * 功能：初始化人才页面
     * 参数：
     * 无
     */
    InihumanPage:function(){
        baseRender.ae(0);
        this.c();
        this.d();
        this.gini();
    },
    /*
     * 功能：初始化企业页面
     * 参数：
     * 无
     */
    IniCompany:function(){
        baseRender.ae(0);        
        this.b();
        this.gini();
        this.e();
    }
    
};
$().ready(function(){   
    if(typeof(PAGE)=="undefined"){
        PAGE="";
    }    
    //根据PAGE来初始化页面
    if(PAGE=="72"){
        //初始化页面js等
        bdIndexController.IniCompany();
    }
    if(PAGE=="73"){
        //初始化页面js等
        bdIndexController.IniPage();
    }
    if(PAGE=="74"){
        //初始化页面js等 
        bdIndexController.InihumanPage();       
    }
});
