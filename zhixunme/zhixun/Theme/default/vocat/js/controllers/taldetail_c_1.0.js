/*
 * 人才详细页控制器
 */
var TalDetailController={
    /*
     * 功能：初始化关注
     * 参数：
     * 无
     */
    b:function(){
        baseController.BtnBind("div.myfollow div.btn17", "btn17", "btn17_hov", "btn17_hov");
        $("#add_focus").bind("click",function(){
            var a=$(this).attr("uid");
            var uname=$(this).attr("uname");
            var that=taldetailRender;
            var msg=new Message();
            $(this).data("uid",a);
            $(this).data("uname",uname);
            msg.Add_FocusPerson(a,that.a,that.b);
        });
    },
     /*
     * 功能：举报个人绑定事件
     * 参数：
     * 无
     */
    c:function(){
        $("#report_h").bind("click",function(){
            var newtype=3;//举报类型会员
            var user_id=$(this).attr("uid")*1;
            var url=WEBURL.RerportSpam;
                url+='/'+newtype+'/'+user_id;
            var that=baseRender;                
                that.OpenWin(url,600,600);
        });
    },
     /*
     * 功能：取消关注
     * 参数：
     * 无
     */
    d:function(){
        $("#re_focus").unbind("click").bind("click",function(){
            var that=taldetailRender;
            var uid=$(this).attr("uid");
            var uname=$(this).attr("uname");
            $(this).data("uid",uid);
            $(this).data("uname",uname);
            var msg="确定取消关注—"+uname;            
            baseController.InitialSureDialog("error",msg, "select",'确 定',function(){    
                $("#select").unbind("click").bind("click",function(){
                    $("div.alr_opermsg_cover").fadeOut();
                    var m=new Message();
                    m.removeFocus(uid,that.c,that.d);                        
                })                  
            });  
        })
    },
    /*
     * 功能：初始化页面
     * 参数：
     * 无
     */
    IniPage:function(){
        this.b();
        this.c();
        this.d();
    }
};
$().ready(function(){
    if(typeof(PAGE)=="undefined"){
        PAGE="";
    }
    //根据PAGE来初始化页面
    if(PAGE=="98"){
        //初始化页面js等
        TalDetailController.IniPage();
    }
});
