/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
var manageAgentRender={   
    /*
     *查看成员详细事件绑定
     *参数：无
     *jang
     *2012-6-21
     */
    a:function(){
        var t;
        $("#member ul.member").live("mouseover",function(event){
            clearTimeout(t);
            var e=event||window.event;
            e.stopPropagation();
            var me=$(this);            
            var dinfo=me.next("div.dinfo");            
            me.siblings("ul.member").removeClass("sel");            
            if(!$(this).hasClass("sel")){//当前元素是新触发元素
                $("#members").data("dtail",dinfo);                
                me.siblings("div.dinfo").slideUp(200);                
                var slide=function(){
                    me.addClass("sel");                                   
                    dinfo.slideDown(300);   
                }            
                t=setTimeout(slide,600);
            }
            dinfo.mouseover(function(event){
                var e=event||window.event;
                e.stopPropagation();
            });            
        });
        $("body").mouseover(function(){
            clearTimeout(t);
            $("#members ul.member").next("div.dinfo").slideUp(200);
            $("#members ul.member").removeClass("sel");
        })
    },
    /*
     *查看成员详细异步请求
     *参数：无
     *jang
     *2012-6-21
     */
    //    aa:function(){        
    //         var s={
    //            url:WEBURL.RemoveFollower,
    //            params:"id=",
    //            sucrender:manageAgentRender.ab,
    //            failrender:manageAgentRender.ac
    //        };
    //	HGS.Base.HAjax(s);
    //    },
    /*
     *查看成员详细异步请求成功
     *参数：无
     *jang
     *2012-6-21
     */
    //    ab:function(data){
    //        var dt=data.data;                 
    //        var tmp=TEMPLE.T00105;   
    //        $.each(dt,function(i,item){     
    //            tmp=tmp.replace(new RegExp("{"+i+"}","g"),item);                                                      
    //        });
    //         var me=$("#members").data("dtail");         
    //         me.html(tmp);
    //    },
    /*
     *查看成员详细异步请求失败
     *参数：无
     *jang
     *2012-6-21
     */
    ac:function(data){
        
        
    },
    /*
     *冻结当前用户
     *参数：无
     *jang
     *2012-6-22
     */
    b:function(){
        this.c();
    },
    /*
     *成功冻结当前用户
     *参数：无
     *jang
     *2012-6-22
     */    
    c:function(){            
        var me=$("#members").data("freeze");       
        $("#freeze").parents("div.sure_dialog").hide(); 
        var tmp='<span class="gray">已冻结|</span>解冻';       
        me.removeClass("off").addClass("on");       
        alert("帐户已冻结!");
        me.html(tmp);
    },
    /*
     *失败冻结当前用户
     *参数：无
     *jang
     *2012-6-22
     */  
    d:function(){
        alert("暂时不能冻结当前用户!");
        $("#freeze").parents("div.sure_dialog").fadeOut(); 
    },
    /*解冻当前用户
     *参数：无
     *jang
     *2012-6-22
     */    
    e:function(){
        this.f();
    },
    /*成功解冻当前用户
     *参数：无
     *jang
     *2012-6-21
     */
    f:function(){
        var me=$("#members").data("freeze");       
        $("#freeze").parents("div.sure_dialog").hide();                     
        me.removeClass("on").addClass("off");
        alert("帐户已解冻!");
        me.html("立即冻结");
    },
    /*失败解冻当前用户
     *参数：无
     *jang
     *2012-6-21
     */
    g:function(){        
        alert("暂时不能解除前冻结帐户!");
        $("#freeze").parents("div.sure_dialog").fadeOut();
    },
    /*
     *功能:获取查询猎头列表数据
     *参数：无
     *jang
     *2012-6-21
     */
    h:function(data){
        var dt=data.data.person;             
        var mytmp=[],rd=manageAgentRender;        
        var varr=[];   
        mytmp[0]=rd.htemp(true);//为被冻结
        mytmp[1]=rd.htemp(false);//解冻
        $.each(dt, function(i,o){               
            if(o.is_online==0)
                o.is_online='off';
            else
                o.is_online='';         
            if(o.is_freeze=="0"){
                o.temp=0;
            }else{
                o.temp=1;
            }
            if(o.logout_time=="0"){
               o.logout_time="-";
            }
            o.photo=FILEROOT+'/'+o.photo;
            o.url=WEBROOT+'/agent/'+o.id;
        });
        //更新总计数据
        rd.ht(data.data);
        varr[0]=varr[1]=["id", "url","public_job","hot_article","page_view","view_article","public_article", "public_resume", "login_time","logout_time","name", "photo", "is_online", "view_resume", "deliver_resume", "entrust_resume", "employ_resume", "view_job", "entrust_job"];
        HGS.Base.GenMTemp("member",varr,dt,mytmp);
        return dt.count;
    },
    /*
     * 功能：更新 总计数据
     * 参数：无
     * 负责人：candice
     * 时间：2012-6-27
     */
    ht:function(dt){
        var par=$("#members ul.count li");
        par.eq(1).html(dt.total_resume);
        par.eq(2).html(dt.total_job);
        par.eq(3).html(dt.total_article);
        par.eq(4).html(dt.total_view);
    },
    /*
     * 功能：猎头管理列表模板生成
     * 参数：
     * a：是否冻结
     * 负责人：candice
     * 时间：2012-6-27
     */
    htemp:function(a){
        var tmp=TEMPLE;
        var tp='';
        if(a){//未冻结
            tp=tmp.T00105.replace("{isfreeze}",tmp.T00106)+tmp.T00104;
        }else{//解冻
            tp=tmp.T00105.replace("{isfreeze}",tmp.T00107)+tmp.T00104;
        }
        return tp;
    },
    /*查询猎头数据列表成功
     *参数：无
     *jang
     *2012-6-21
     */
    hsc:function(data){
        //console.log("ok!");
        var that=manageAgentController;
        var count=manageAgentRender.h(data);
        if(count>20)
            that.b(count,"#pages",that.bb);
    },
    /*查询猎头数据列表失败
     *参数：无
     *jang
     *2012-6-21
     */
    hf:function(data){        
        alert("暂时不能获取列表数据");
    },
    /*
     *参数：无
     *jang
     *
     */
    j:function(){
       
    },
    /*按时间查询,返回字符串日期
     *参数：date对象
     *jang
     */
    k:function(arr){
        var d=new Date;
        var st,et,str,et1;
        var unit=$("#date").next("li.selstep").find("a.sel").attr("rel")*1;
        d.setTime(arr[0]);
        st=gett(d);        
        d.setTime(arr[1]);
        et=gett(d);        
        str=st[0]+'年'+st[1]+'月'+st[2]+'日';
        if(unit==5){
            et1=arr[0]+7*86400000-1000;
            d.setTime(et1);
            et1=gett(d);
            str+='-'+et1[0]+'年'+et1[1]+'月'+et1[2]+'日';
        }            
        else if(unit==6)
            str=st[0]+'年'+st[1]+'月';
        $("#date").html(str);
        if(d<(new Date()).getTime()){            
            $("#next").removeClass("stop");            
        }
        else{            
            $("#next").addClass("stop");
        }
        function gett(_d){
            var y,m,d1;
            y=_d.getFullYear();            
            m=_d.getMonth()+1;                
            d1=_d.getDate();  
            if(m<10)
                m='0'+m;
            if(d1<10)
                d1='0'+d1;
            return [y,m,d1];
        }
    },
    /*
     * 功能：失败
     * 参数：
     * data：后台返回数据
     */
    ca:function(){
        var th=manageAgentController;
        var ob=$("#sort").data("obj");
        var ele=$(ob).find("a");
        if(ele.hasClass("up")){
            ele.removeClass().addClass("down");
            ele.attr("rel","0");
        }else if(ele.hasClass("down")){
            ele.removeClass().addClass("up");
            ele.attr("rel","1"); 
        }
        th.b(0,"#pages",th.bb);
        $("#member").html("<p class='no-data red'>暂无数据!</p>");
    }
}    
