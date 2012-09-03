/*简历详细页面控制器*/
var ResumeDetailController={
    /*
     *判断是否具有代理猎头
     *jack
     *2012-2-11
     */
    a:function(){
        ResumeDetailController.b();//无猎头代理
        baseController.BtnBind(".btn10", "btn10", "btn10_hov", "btn10_click");
    },
    /*
     *无猎头代理
     *jack
     *2012-2-12
     */
    b:function(){
        $("#se_agphone").click(function(){
            $("#se_agphone").parent().hide();
            $("#loading").removeClass("hidden");
            var uid='&uid='+$("input[name='resume_number']").val();
            paytipController.checkTContactTip(ResumeDetailController.ba,null,this,uid);
        });
    },
    /*
     * 功能：查看联系方式（无猎头代理）
     * 参数：
     * 
     */
    ba:function(){
        var rid=$("input[name='resume_number']").val();
        var s=new Resume();
        var that=resumedetailRender;
        s.GetTaContact(rid,1,that.b,that.c);
    },
    /*
     * 功能：查看联系方式（有猎头代理）
     * 参数：
     *
     */
    ca:function(){
        var rid=$("input[name='resume_number']").val();
        var s=new Resume();
        var that=resumedetailRender;
        s.GetTaContact(rid,1,that.d,that.c);
    },
    /*
     * 功能：初始化关注
     * 参数：
     * 无
     */
    k:function(){
        baseController.BtnBind("div.myfollow div.btn17", "btn17", "btn17_hov", "btn17_hov");
        $("#add_focus").bind("click",function(){           
            var a=$(this).attr("uid");
            var uname=$(this).attr("uname");
            var that=resumedetailRender;
            var msg=new Message();
            $(this).data("uid",a);
            $(this).data("uname",uname);
            msg.Add_FocusPerson(a, that.e, that.f);                        
        });
    },
    /*
     * 功能：取消关注
     * 参数：
     * 无
     */
    l:function(){
        $("#re_focus").unbind("click").bind("click",function(){
            var that=resumedetailRender;
            var uid=$(this).attr("uid");
            var uname=$(this).attr("uname");
            $(this).data("uid",uid);
            $(this).data("uname",uname);
             var msg="确定取消关注—"+uname;            
            baseController.InitialSureDialog("error",msg, "select",'确 定',function(){    
                    $("#select").unbind("click").bind("click",function(){
                        $("div.alr_opermsg_cover").fadeOut();
                        var m=new Message();
                        m.removeFocus(uid,that.g,that.h);
                    })                  
                });  
        })
    },
    /*
     *功能：邀请投递简历
     *参数：无
     *@jack 2012-7-17
     */
    m:function(){
        $("#inv_apl").hgsShowJobCard({
            accurl:WEBURL.AInviteResumes,
            dataurl:WEBURL.AGetCanInvitJob,
            getcat:function(o){
                var cat=$(o).parent().parent().find("input[name='cate_id']").val();
                return cat;
            },
            getrid:function(o){
                return $(o).parent().parent().find("input[name='rid']").val();
            }
        });
    },
    /*
     * 功能：查看联系方式等待加载
     * 参数：
     * author:joe 2012/7/19
     */
    n:function(){        
        $("a.cancel").live("click",function(){
            $("#se_agphone").parent().show();
            $("#loading").addClass("hidden");
        })
    },
    /*
     *初始化页面
     *参数：无
     */
    IniPage:function(){
        this.a();/*判断是否具有猎头*/
        this.k();
        this.l();
        this.m();
        this.n();
    }
};
$().ready(function(){
    if(typeof(PAGE)=="undefined"){
        PAGE="";
    }
    //根据PAGE来初始化页面
    if(PAGE=="50"||PAGE=="60"){
        //初始化页面js等
        ResumeDetailController.IniPage();
    }

});




