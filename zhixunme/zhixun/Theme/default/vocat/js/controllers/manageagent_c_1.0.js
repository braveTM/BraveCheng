/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
var manageAgentController={
    /*
     *初始化页面js效果(按键,查看猎头详细)
     *参数：无
     *jang
     *2012-6-21
     */
    a:function(){
        baseController.BtnBind("div.btn21", "btn21", "btn21_hov", "btn21_click");
        manageAgentRender.a();
    },   
    /*
     * 功能：初始化分页插件
     * 参数：
     * id：分页插件的父容器id
     * t：总共的条数
     * func:翻页回调函数
     */
    b:function(t,id,func){
        var lan=LANGUAGE;            
        $(id).pagination(t,{
            callback: func,
            prev_text: lan.L0066,
            next_text: lan.L0067,
            items_per_page:CONSTANT.C0003,
            num_display_entries:9,
            current_page:0,
            num_edge_entries:1,
            link_to:"javascript:;"
        });
    },     
    /*
     *冻结/解冻帐号
     *参数：无
     *jang
     *2012-6-21
     */
    c:function(){
        var msg;
        $("#members ul.member li.freeze a").live("click",function(){
            var nam=$(this).parent().prevAll("li.photo").find("a.name").text();
            var me=$(this);
            $("#members").data("freeze",$(this));
            if($(this).hasClass("off")){//冻结帐号                
                msg='立即冻结"'+nam+'"';
                baseController.InitialSureDialog("error",msg,"freeze","确定",function(){
                    $("#freeze").click(function(){
                        var ca=new Cacrm();
                        var that=manageAgentRender;
                        var a=me.attr("uid");                        
                        ca.OffAgent(a, that.c, that.d);
                    });
                });
            }
            else if($(this).hasClass("on")){//解冻帐号
                msg='解除对"'+nam+'"的冻结';
                baseController.InitialSureDialog("error",msg,"freeze","确定",function(){
                    $("#freeze").click(function(){
                        var ca=new Cacrm();
                        var that=manageAgentRender;
                        var a=me.attr("uid");      
                        ca.OnAgent(a, that.f, that.g);
                    });
                });
            }                          
        })
    },
    /*
     *按时间查询猎头列表数据
     *参数：无
     *jang
     *2012-6-21
     */
    d:function(){        
        var arrtime=[];       
        var that=manageAgentRender;
        $("#date").siblings("li").find("a").unbind("click").bind("click",function(){
            if(!$(this).hasClass("stop")){
                $("#member").html('<div class="loading"><p></p></div>');
                $(this).siblings("a").removeClass("sel");
                $(this).addClass("sel");
                var car=new Cacrm();
                var cur=$("#sort ul li.cur");
                var field=cur.attr("rels");
                var i=0,order=cur.find("a").attr("class")=="up"?1:0;
                arrtime=manageAgentController.e($(this));               
                car.GetCertainData(i,20,field,order,arrtime[0],arrtime[1],that.hsc,that.hf); 
                manageAgentRender.k(arrtime);
            }
        })
    },
    /*
     *按时间查询猎头列表数据时间戳计算
     *参数：me:prev,next对象
     *jang
     *2012-6-21
     */
    e:function(me){
        var starttime,endtime,unit,btn;
        var nowtime=new Date;
        var dtime=86400000;//一天ms
        //      nowtime.setDate(17);
        nowtime.setHours(0,0,0);           
        starttime=nowtime.getTime();/*今天时间戳*/                    
        unit=$("#date").next("li.selstep").find("a.sel").attr("rel")*1;
        btn=me.attr("rel")*1;      
        if(btn==2){
            endtime=$("#date").data("starttime")||starttime;
            starttime=daytime(endtime,unit,0);
            endtime=endtime-1000;
        }
        else if(btn==3){
            starttime=($("#date").data("endtime")+1000)||starttime;
            endtime=daytime(starttime,unit,1);
            endtime=endtime-1000;
        }
        else if(btn==4||btn==1){//天初始化     
            et();
            if(btn==1){
                var a=$("#date").next("li.selstep").find("a");
                a.removeClass("sel").addClass("blue");
                a.first().addClass("sel").removeClass("blue");              
            }
        }
        else if(btn==5){//周初始化          
            var wekd=nowtime.getDay()-1;//一周中的几天
            if(wekd<0)
                wekd=6;//以周一为第一天
            endtime=nowtime.getTime();
            starttime=endtime-dtime*wekd;//返回到本周一,00:00:00
            et();
        }
        else if(btn==6){//月初始化
            var d=new Date();
            d.setTime(starttime);     
            d.setDate(1);//返回到本月１号,00:00:00          
            starttime=d.getTime();//返回到本月１号,00:00:00 时间戳
            et();
        }      
        $("#date").data("starttime",starttime);
        $("#date").data("endtime",endtime);
        return [starttime,endtime];        
        function daytime(nowtime,unit,add){//按天计算时间戳
            var et,days=1;          
            if(unit==5){//周
                days=7;
            }
            else if(unit==6){//月
                var d=new Date();
                var nt=nowtime;
                if(!add)
                    nt=nowtime-1000;//上月
                d.setTime(nt);              
                var m=d.getMonth()+1;              
                var y=d.getFullYear();
                days=(m==2?((y%4||!(y%100)&&y%400)?28:29):(/4|6|9|11/.test(m)?30:31));//当月天数  
            }
            if(add){
                et=nowtime+days*86400000;
            }
            else{
                et=nowtime-days*86400000;
            }
            return et;
        }
        //endtime获取
        function et(){
            nowtime.setHours(23,59,59);
            endtime=nowtime.getTime();         
            me.siblings("a").addClass("blue");
            me.removeClass("blue");
        }
    },
    /*
     *按简历|职位|主页浏览|发布文章数 排序查询猎头列表数据
     *参数：无
     *jang
     *2012-6-21
     */
    f:function(){       
        var parms={};
        $("#sort li.p").mouseenter(function(){
            var ele=$(this).find("a");
            if(ele.hasClass("down")){
                ele.addClass("dhov");
            }else{
                ele.addClass("uhov");
            }
        }).mouseleave(function(){
            var ele= $(this).find("a");
            if(ele.hasClass("down")){
                ele.removeClass("dhov");
            }else{
                ele.removeClass("uhov");
            }
        });
    //        var that=manageAgentRender;
    //        $("#sort li.p").unbind("click").bind("click",function(){
    //            if($(this).hasClass("pres")){//公开简历
    //                parms={
    //                    url:url.pres,
    //                    params:"id=",
    //                    sucrender:that.ab,
    //                    failrender:that.ac
    //                }               
    //            }
    //            if($(this).hasClass("pjob")){//公开职位
    //                
    //            }
    //            if($(this).hasClass("patc")){//发布文章
    //                
    //            }
    //            if($(this).hasClass("brcount")){//主页浏览量
    //                
    //            }
    //            HGS.Base.HAjax(parms);
    //        })
    },    
    //    /*按时间查询,异步请求
    //     *参数：无
    //     *jang
    //     *
    //     */
    //    k:function(t){        
    //        var s={
    //            url:CAURL.GetFilterEmployee,
    //            params:"start_time="+t[0]+"&end_time="+t[1],
    //            sucrender:manageAgentRender.hsc,
    //            failrender:manageAgentRender.hf
    //        };        
    //        HGS.Base.HAjax(s);
    //    },
    /*
     *功能：初始化筛选条件方法
     *参数：无
     *@author：Jack
     */
    ba:function(i){
        var that=manageAgentRender;
        manageAgentController.bc(i,that.hsc,that.ca);
    },
    /*
     *功能：筛选条件方法回调函数
     *参数：i:page索引
     *@author：Jack
     */
    bb:function(i){
        var that=manageAgentRender;
        manageAgentController.bc(i,that.h,that.ca);
    },
    /*
     *功能：筛选套件判断方法
     *参数：i:page索引,suc:成功后回调,fail:失败后回调
     *@author：Jack
     */
    bc:function(i,suc,fail){
        $("#member").html('<div class="loading"><p></p></div>');
        if(typeof(i)=="undefined"){
            i=0;
        }
        i++;
        var me=$("#sort ul li.cur");      
        var field="public_resume";      
        var order=0;
        var nowtime=new Date,starttime,endtime;            
        if(me){                  
            field=me.attr("rels");      
            order=me.find("a").attr("rel");
        }          
        nowtime.setHours(0,0,0);          
        starttime=nowtime.getTime();/*默认为今天时间戳*/  
        nowtime.setHours(23,59,59);
        endtime=nowtime.getTime();  
        if($("#date").data("endtime")&&$("#date").data("starttime")){
            endtime=$("#date").data("endtime");
            starttime=$("#date").data("starttime");
        }
        var car=new Cacrm();
        car.GetCertainData(i,CONSTANT.C0005,field,order,starttime,endtime,suc,fail);      
    },
    /*
     *功能：筛选事件点击事件绑定
     *参数：无
     *@author：Jack
     */
    bd:function(){
        $("#sort li.p").unbind("click").bind("click",function(){
            var ob=$(this);
            ob.parent().find("li.cur").removeClass("cur");
            ob.addClass("cur");
            var ele=ob.find("a");
            if(ele.hasClass("up")){
                ele.removeClass().addClass("down");
                ele.attr("rel","0");
            }else if(ele.hasClass("down")){
                var bro=ele.parent().siblings().find("a");
                bro.removeClass().addClass("down");
                bro.attr("rel","0"); 
                ele.removeClass().addClass("up");
                ele.attr("rel","1"); 
            }
            manageAgentController.ba(0);
        }); 
    },
    /*
     *初始化页面
     *参数：无
     *jang
     *2012-6-21
     */
    IniPage:function(){
        this.a();     
        //        this.b(0,"#pages",manageAgentController.a);
        this.c();
        this.d();
        //        this.f();
        //        this.g();
        this.ba(0);
        this.bd();
    //        manageAgentRender.ab();
    }
}
$().ready(function(){
    if(typeof(PAGE)=="undefined"){
        PAGE="";
    }
    //根据PAGE来初始化页面
    if(PAGE=="114"){
        manageAgentController.IniPage();
        baseRender.ae(0);
    //    manageAgentRender.i();
    }
});

