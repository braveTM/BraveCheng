/*
 * 我的消息管理控制器
 */
var MsgListController={
    /*
     * 功能：初始化全部消息翻页插件
     * 参数：
     * id：分页插件的父容器id
     * t：总共的条数
     */
    a:function(t){
        var lan=LANGUAGE;
        $("#pagination").pagination(t, {
            callback: MsgListController.c,
            prev_text: lan.L0066,
            next_text: lan.L0067,
            items_per_page:CONSTANT.C0002,
            num_display_entries:9,
            current_page:0,
            num_edge_entries:1,
            link_to:"javascript:;"
        });
    },
    /*
     * 功能：获取全部消息列表数据
     * 参数：
     * 无
     */
    b:function(i){
        var that=msgListRender;
        MsgListController.d(i, "ames", "1", that.a, that.b);
    },
    /*
     * 功能：全部消息分页回调函数
     * 参数：
     * 无
     */
    c:function(i){
        var that=msgListRender;
        MsgListController.d(i, "ames", "1", that.c, that.b);
        that.d();
    },
    /*
     * 功能：获取全部消息列表数据
     * 参数：
     * i:当前页
     * tid：筛选栏的父容器id
     * type:消息类型
     * suc:成功获取数据时的方法
     * fail:失败获取数据时的方法
     */
    d:function(i,tid,type,suc,fail){
        var t=$("#"+tid+" a.red");
         var a='';
        if(t.length>0){
            a=t.attr("tp");
            a=(a==""?"2":a);
        }
        i+=1;
        var msg=new Message();
        msg.GetMsgList(i, type, a, suc, fail);
    },
    /*
     * 功能：初始化全部消息类别选择时的列表数据刷新和翻页插件重新绑定
     * 参数：
     * i:当前页
     */
    e:function(){
        $("#ames a").click(function(){
            $(this).parent().find("a").removeClass("red");
            $(this).addClass("red");
            MsgListController.b(0);
            msgListRender.d();
        });
    },
    /*
     * 功能：全选或全不选
     * 参数：
     * 无
     */
    s:function(){
        $("input[name='msg_del_all']").click(function(){
            msgListRender.o(this);
        });
        $("div.module_3 div.mcols_sctitle div.s_cl a.chsall").click(function(){
            msgListRender.p(this,true);
        });
        $("div.module_3 div.mcols_sctitle div.s_cl a.chsnone").click(function(){
            msgListRender.p(this,false);
        });
    },
    /*
     * 功能：标记为已读
     * 参数：
     * 无
     */
    t:function(){
        $("div.module_3 div.mcols_sctitle div.s_cl a.markread_cont").click(function(){
            var ck=$(this).parent().parent().next().find("li input:checked");
            var ids='';
            var len=ck.length;
            $.each(ck, function(i,o){
                var mar=$(o).parent().next().find("a");
                if(mar.hasClass("blue")){
                    if(i==0){
                        ids+=$(o).attr("mid");
                    }
                    else{
                        ids+=","+$(o).attr("mid");
                    }
                    mar.removeClass("blue");
                }
            });
            if(ids!=""){
                var that=msgListRender;
                var ms=new Message();
                ms.MarkRead(ids, that.s, that.r);
            }else if(len>0){
                alert(LANGUAGE.L0128);
            }else{
                alert(LANGUAGE.L0215);
            }
        });
    },    
    /*
     * 功能：批量删除消息按键绑定事件
     * 参数：
     * 无
     */
     ta:function(){
        var allmsg=$("#ames_ch"); 
        var msgtab={
            'allmsg':{
                'a':allmsg,
                'b':'all_msg'
            }
        };         
        $.each(msgtab,function(i,item){                                                   
            item.a.children(".del").unbind("click").bind("click",function(){
                MsgListController.tb(item.b);                
                MsgListController.te($(this));                
            });                       
        });
    }, 
     /*
     * 功能：删除单条消息按键绑定事件
     * 参数：
     * 无
     */
    _ta:function(){
        var msgtab={
            'allmsg':'all_msg'          
            };             
         $.each(msgtab,function(i,item){
            $("#"+item).find("a.del").unbind("click").bind("click",function(){
                MsgListController.tc($(this),$("#"+item));
            }); 
         });         
    },
    /*
     * 功能：批量删除消息
     * 参数：msgid:消息列表id
     * 无
     */
    tb:function(msgid){           
        var deldata=$("#"+msgid).find("input[name='msg_del']:checked");
        var ids=new Array();          
        if(!deldata.length)
            alert("请选择要删除的消息!");
        else{
            deldata.each(function(){
                ids.push($(this).attr("mid")*1);
            });         
            $("#"+msgid).prev().data("data",{d:deldata.parent().parent()});         
            MsgListController.td(ids,1);
        }                                        
    },
     /*
     * 功能：删除单条消息
     * 参数：me当前删除事件对象,list,消息列表对象
     */
    tc:function(me,list){        
        var check=me.parent().children().first().find("input[type='checkbox']");              
        list.prev().data("data",{d:me.parent()});                        
        var id=check.attr("mid")*1;        
        MsgListController.td(id);
    },
     /*
     * 功能：删除消息
     * 参数：check:消息列表checkbox,p=1批量删除
     * 无
     */
    td:function(ids,p1){
        var meg=confirm('确定要删除消息?');
        if(meg){           
            var p="ids="+ids;                               
            var that=msgListRender;
            var sc=that.sa;
            if(p1==1)
                sc=that.sc;
            var s={
                url:WEBURL.DelMsgList,
                params:p,
                sucrender:sc,
                failrender:that.sb
            };
            HGS.Base.HAjax(s);
        }
    },
    /*
     * 功能：确定当前删除消息类别，页码,并保存数据
     * 参数：me当前删除事件按键
     * 无
     */
    te:function(me){
        var type,page,pnum;
        type=me.attr("rel");        
        if(me.hasClass("_p")){//批量删除            
            page=me.parent().nextAll(".pages").find("span.current").not("span.prev").not("span.next");            
        }          
        pnum=page.text();          
        $("#ipost_task").data({
                    "type":type,
                    "page":pnum
                });
    },
    /*
     * 功能：初始化任务管理页面
     * 参数：
     * 无
     */
    IniPage:function(){
        baseRender.ae(0);
        this.b(0);
        this.e();
        this.s();
        this.t();
        this.ta();
    }
};
$().ready(function(){
    if(typeof(PAGE)=="undefined"){
        PAGE="";
    }
    //根据PAGE来初始化页面
    if(PAGE=="12"){
        //初始化页面js等
        MsgListController.IniPage();
    }
});
