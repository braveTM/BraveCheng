/*
 * 全职职位详细页 控制器
 */
var jobfullController={
    /*
     * 功能：初始化查看联系方式按钮
     * 参数：
     * 无
     */
    a:function(){
        baseController.BtnBind(".btn10", "btn10", "btn10_hov", "btn10_click");
        $("#ckcontact").bind("click",function(){
            $("#ckcontact").parent().hide();
            $("#loading").removeClass("hidden");
            var uid='&uid='+$(this).attr("uid");
            paytipController.checkCContactTip(jobfullController.aa,null,this,uid);
        });
    },
    /*
     * 功能：查看联系方式
     * 参数：
     * 无
     */
    aa:function(){
        var a=$("#ckcontact").attr("uid");
        var that=jobfullRender;
        var ct=new Contacts();
        ct.CheckContWay(a,2,that.a, that.b);
    },
    /*
     * 功能：初始化投递简历按钮
     * 参数：
     * 无
     */
    b:function(){
        baseController.BtnBind("div.ftimejob div.btn_par div.btn5,div.ptimejob div.btn_par div.btn5", "btn5", "btn5_hov", "btn5_click");
        var type=$("#app_ftr").attr("type");
        if(type!="3"){
            $("#app_ftr").bind("click",function(){
                var a=$("#jobid").attr("jid");
                var that=jobfullRender;
                var res=new Resume();
                res.SendResume(a, that.c, that.b);
            });
        }else{
            jobfullController.c();
        }
    },
    /*
     * 功能：猎头首页 推荐的职位 投递简历
     * 参数：
     * 无
     */
    c:function(){
        $("#app_ftr").hgsShowCard({
            accurl:WEBURL.ASendResumes,
            dataurl:WEBURL.GetAResumes,
            getcat:function(o){
                var cat=$("#jobid").val().replace(new RegExp(" ","g"),"");
                if(cat=="[兼职]"){
                    cat="2";
                }else{
                    cat="1";
                }
                return cat;
            },
            getjid:function(o){
                return $("#jobid").attr("jid");
            }
        });
    },
    /*
     * 功能：初始化关注
     * 参数：
     * 无
     */
    g:function(){
        baseController.BtnBind(".btn17", "btn17", "btn17_hov", "btn17_click");
        $("#add_focus").bind("click",function(){
            var a=$(this).attr("uid");
            var uname=$(this).attr("uname");
            var that=jobfullRender;
            var msg=new Message();
            $(this).data("uid",a);
            $(this).data("uname",uname);
            msg.Add_FocusPerson(a, that.d, that.e);
        });
    },
    /*
     * 功能：举报绑定事件
     * 参数：
     * 无
     */
    h:function(){
        $("#report").bind("click",function(){
            var newtype=$("#jobid").attr("type")*1;
            var job_id=$("#jobid").attr("jid")*1;
            var url=WEBURL.RerportSpam;
            url+='/'+newtype+'/'+job_id;
            var that=baseRender;                
            that.OpenWin(url,600,600);
        });
    },   
    /*
     * 功能：分享绑定
     * 参数：
     * 无
     */
    i:function(obj){                                
        $(obj).unbind("click").bind("click",function(){
            var par=$(this);             
            var sum=$("div.module_1 div.item"),summary='';            
            var pics=[];
            sum.each(function(){
                summary+=$.trim($(this).find("p").text())+'\n';
            });            
            var pic=$("div.layout2").find("img").not("img.lit_small");
            pic.each(function(i,item){
                pics.push(item.src);
            })
            pics=pics.join("|");
            var type=par.attr("tp"),
            tit=par.attr("tit"),
            des=$("div.module_4").find("p.detail").text(),
            ur=par.attr("ur");                 
            zxshare(type,[tit,ur,des,summary,pics]);
        });
    },
    /*
     * 功能：取消关注
     * 参数：
     * 无
     */
    j:function(){
        $("#re_focus").unbind("click").bind("click",function(){
            var that=jobfullRender;
            var uid=$(this).attr("uid");
            var uname=$(this).attr("uname");
            $(this).data("uid",uid);
            $(this).data("uname",uname);
            var msg="确定取消关注—"+uname;            
            baseController.InitialSureDialog("error",msg, "select",'确 定',function(){    
                $("#select").unbind("click").bind("click",function(){
                    $("div.alr_opermsg_cover").fadeOut();
                    var m=new Message();
                    m.removeFocus(uid,that.f,that.g);                
                })                  
            });  
        })
    },
    /*
     * 功能：查看联系方式等待加载
     * 参数：
     * i:1直接还原显示buton
     * i:0绑定事件后显示buton
     * author:joe 2012/7/19
     */
    k:function(i){
        i=i||0;
        if(i){
            $("#ckcontact").parent().show();
            $("#loading").addClass("hidden");
        }
        else{
            $("a.cancel").live("click",function(){
                $("#ckcontact").parent().show();
                $("#loading").addClass("hidden");
            })
        }        
    },
    /*
     * 功能：初始化首页
     * 参数：
     * 无
     */
    IniPage:function(){
        this.a();
        this.b();
        this.g();
        this.h();
        this.i("#share a.share");
        this.j();
        this.k();
    },
    /*
     * 功能：初始化首页
     * 参数：
     * 无
     */
    IniPage1:function(){
        this.i("#share a.share");
    }
};
$().ready(function(){
    if(typeof(PAGE)=="undefined"){
        PAGE="";
    }
    //根据PAGE来初始化页面
    if(PAGE=="55"||PAGE=="54"){
        //初始化页面js等
        jobfullController.IniPage();
    }
     //根据PAGE来初始化页面
    if(PAGE=="113"||PAGE=="112"){
        //初始化页面js等
        baseController.BtnBind("div.ftimejob div.btn_par div.btn5,div.ptimejob div.btn_par div.btn5", "btn5", "btn5_hov", "btn5_click");
        baseController.BtnBind(".btn10", "btn10", "btn10_hov", "btn10_click");
        baseController.BtnBind(".btn17", "btn17", "btn17_hov", "btn17_click");
        jobfullController.IniPage1();
    }
});
