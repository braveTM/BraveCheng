/*
 * 我的消息管理渲染器
 */
var msgListRender={
    /*
     * 功能：成功异步获取全部消息列表
     * 参数：
     * data：后台返回数据
     */
    a:function(data){
        var count=msgListRender.c(data);        
        MsgListController.a(count);
    },
    /*
     * 功能：失败异步获取全部消息列表
     * 参数：
     * data：后台返回数据
     */
    b:function(data){
        MsgListController.a(0);
        $("#all_msg").html("<li class='no-data'>暂无数据!</li>");
    },
    /*
     * 功能：成功异步获取全部消息列表
     * 参数：
     * data：后台返回数据
     */
    c:function(data){
        var dt=data.data;
        var count=data.count;
        $.each(dt, function(i,o){
            if(o.read=="0"){
                o.read="blue";
            }else{
                o.read="";
            }
        });
        var varr=['url','title','fname','date','read','id'];        
        HGS.Base.GenTemp("all_msg",varr,dt,TEMPLE.T00017);
        MsgListController._ta();
        return count;
    },
    /*
     * 功能：定位到列表顶部
     * 参数：
     * data：后台返回数据
     */
    d:function(){
        $("html,body").animate({
            scrollTop:$("#ipost_task").offset().top
        },500);
    },
    /*
     * 功能：全选复选框
     * 参数：
     * obj：当前全选复选框
     */
    o:function(obj){
        var par=$(obj).parent().parent().next().find("li input[name='msg_del']");
        if($(obj)[0].checked){
            par.attr("checked", true);
        }
        else{
            par.attr("checked", false);
        }
    },
    /*
     * 功能：全选a标签
     * 参数：
     * obj：当前全选a标签
     * c：是否选中
     */
    p:function(obj,c){
        var par=$(obj).parent().parent().next().find("li input[name='msg_del']");
        var inp=$(obj).parent().parent().find("div.f_cl input[name='msg_del_all']");
        inp[0].checked=c;
        par.attr("checked", c);
    },
    /*
     * 功能： 标记为已读失败
     * 参数：
     * data：后台返回数据
     */
    r:function(data){
        alert(data.data);
    },
    /*
     * 功能： 标记为已读成功
     * 参数：
     * data：后台返回数据
     */
    s:function(data){
        alert("标记成功!");
    },
    /*
     * 功能:单条消息删除成功后
     * 参数：
     * data：后台返回数据
     */
    sa:function(){
        var all_msg=$("#ames_ch");
        var sys_msg=$("#smes_ch");
        var per_msg=$("#pmes_ch");  
        var post_msg=$("#posmes_ch");  
        var msgtab={
            'allmsg':all_msg,
            'sysmsg':sys_msg,
            'mymsg':per_msg,
            'sendmsg':post_msg            
            };            
         $.each(msgtab,function(i,item){            
                    if(item.parent().hasClass("show")){                        
                        item.data("data").d.fadeOut();        
                    }                
         });  
        alert("消息已删除!");      
    },
    /*
     * 功能： 消息删除失败后
     * 参数：
     * data：后台返回数据
     */
    sb:function(){
        alert("暂时不能删除消息!");
    },
    /*
     * 功能：批量删除信息,消息删除成功后初始化分页
     * 参数：
     * 
     */
    sc:function(){
//        var pnum=$("#ipost_task").data("page")*1-1;
        var type=$("#ipost_task").data("type");
        if(type==1){//全部消息
            MsgListController.b(0);
        }
        else if(type==2){//系统消息
            MsgListController.h(0);
        }
        else if(type==3){//私人消息
            MsgListController.m(0);
        }
        else if(type==4){//已发送
            MsgListController.q(0);
        }
        alert("消息已删除!");
    }
    
};