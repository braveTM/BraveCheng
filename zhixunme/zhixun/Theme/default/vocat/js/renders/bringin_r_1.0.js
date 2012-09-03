/*
 * 企业职位管理页面渲染器
 */
var bringinRender={
    /*
     * 功能：成功异步获取我发布的职位列表
     * 参数：
     * data：后台返回数据
     */
    n:function(data){
        var count=bringinRender.p(data);        
        BringinController.o(count,"#pagination1",BringinController.q);
    },
    /*
     * 功能：失败异步获取我发布的职位列表
     * 参数：
     * data：后台返回数据
     */
    o:function(data){
        BringinController.o(0,"#pagination1",BringinController.q);
        $("#epublist").html("<li class='no-data'>暂无数据!</li>");
    },
    /*
     * 功能：成功异步获取我发布的职位列表
     * 参数：
     * data：后台返回数据
     */
    p:function(data){
        var dt=data.data;
        var count=data.count;
        var mytmp=[];
        mytmp[0]=bringinRender.r("1", "3");//全职 已结束招聘
        mytmp[1]=bringinRender.r("1", "2");//全职 招聘中
        mytmp[2]=bringinRender.r("2", "3");//兼职 已结束招聘
        mytmp[3]=bringinRender.r("2", "2");//兼职 招聘中
        mytmp[4]=bringinRender.r("1", "4");//全职 已暂停
        mytmp[5]=bringinRender.r("2", "4");//兼职 已暂停
        $.each(dt, function(i,o){
            var type=o.category;
            var status=o.status;
            var certs="";
            if(type=="1"&&status=="3"){
                o.temp=0;
                o.stdes="招聘结束";
            }else if(type=="1"&&status=="2"){
                o.temp=1;
                o.stdes="发布";
            }
            else if(type=="2"&&status=="3"){
                o.temp=2;
                o.stdes="招聘结束";
            }
            else if(type=="2"&&status=="2"){
                o.temp=3;
                o.stdes="发布";
            }else if(type=="1"&&status=="4"){
                o.temp=4;
                 o.stdes="招聘";
            }else if(type=="2"&&status=="4"){
                o.temp=5;
                 o.stdes="招聘";
            }
            if(typeof(o.cert)=="undefined"){o.cert=[];}
            $.each(o.cert,function(k,item){
                certs+='<p><span class="gray">证书情况: </span><span>'+item+'</span></p>';
            });
            o.cert=certs;
            if(o.r_count>0){
                o.r_class="red";
            }
            else{
                o.r_class="";
            }
            if(o.promote=="1"){
               o.promote="promote";
               o.pname="已推广";
            }else{
                 o.promote="";
                 o.pname="立即推广";
            }
            if(o.salary=="面议"){
                o.face="face";
            }else{
                o.face="";
            }
        });
        var varr=[];
        varr[0]=['promote','pname','cert','company','title','name','count','location','degree','r_count','date','r_class','stdes','id'];
        varr[1]=['promote','pname','cert','company','title','name','count','location','degree','r_count','date','r_class','salary','stdes','id','face'];
        varr[2]=['promote','pname','cert','company','title','place','location','r_count','date','r_class','stdes','id'];
        varr[3]=['promote','pname','cert','company','title','place','location','r_count','date','r_class','salary','stdes','id','face'];
        varr[4]=['pname','promote','cert','company','title','name','count','location','degree','r_count','date','r_class','salary','stdes','id','face'];
        varr[5]=['pname','promote','cert','company','title','place','location','r_count','date','r_class','salary','stdes','id','face'];
        HGS.Base.GenMTemp("epublist",varr,dt,mytmp);
        var that=BringinController;
        $("#epublist").find("p.own").remove();
        that.t("#epublist");
        that.u("epublist",true);
        that.ag();
        that.ebd("#epublist");
        return count;
    },
    /*
     * 功能：定位到列表顶部
     * 参数：
     * 无
     */
    q:function(){
        $("html,body").animate({
            scrollTop:$("body").offset().top
        },500);
    },
    /*
     * 功能：生成我发布的职位列表模板
     * 参数：
     * 无
     */
    r:function(type,status){
        var tmp=TEMPLE;
        var mtmp='';
        var rtmp='';
        if(type=="1"&&status=="3"){
            mtmp=tmp.T00037;//全职
            rtmp=tmp.T00036;//已停止招聘
        }else if(type=="1"&&status=="2"){
            mtmp=tmp.T00037;
            rtmp=tmp.T00035;//招聘中
        }
        else if(type=="2"&&status=="3"){
            mtmp=tmp.T00034;//兼职
            rtmp=tmp.T00036;
        }
        else if(type=="2"&&status=="2"){
            mtmp=tmp.T00034;
            rtmp=tmp.T00035;
        }else if(type=="1"&&status=="4"){
             mtmp=tmp.T00037;
             rtmp=tmp.T00035.replace('<a href="javascript:;" class="btn white pausejob" rid="{id}">暂停公开招聘</a>','<a href="javascript:;" class="white btn continuejob" rid="{id}">继续公开招聘</a>');
        }else if(type=="2"&&status=="4"){
            mtmp=tmp.T00034;
           rtmp=tmp.T00035.replace('<a href="javascript:;" class="btn white pausejob" rid="{id}">暂停公开招聘</a>','<a href="javascript:;" class="white btn continuejob" rid="{id}">继续公开招聘</a>');
        }
        return baseController.GenBListTemp(null, mtmp, rtmp);
    },
     /*
     * 功能：企业-发布职位 - 立即公开招聘/继续招聘
     * 参数：
     * obj：当前点击a标签
     */
    gopub:function(){
        var obj=$("div").data("obj");
        var par=$(obj).parent();
        $(obj).remove();
        par.html('<span class="b_lf"></span><span class="b_rf"></span><a href="javascript:;" class="btn white pausejob" rid="'+$(obj).attr("rid")+'">暂停公开招聘</a>');
        par.find("a.pausejob").unbind("click");
        par.find("a.pausejob").bind("click",function(){
            BringinController.epauseb(this);
        });
    },
    /*
     *功能：企业-发布的职位 - 暂停招聘成功
     *参数：
     *obj：当前元素
     */
    ppub:function(){
        var obj=$("div").data("obj");
        var par=$(obj).parent();
        $(obj).remove();
        par.html('<span class="b_lf"></span><span class="b_rf"></span><a href="javascript:;" class="btn white continuejob" rid="'+$(obj).attr("rid")+'">继续公开招聘</a>');
        par.find("a.continuejob").unbind("click");
        par.find("a.continuejob").bind("click",function(){
            BringinController.econtinueb(this);
        });
    },
    /*
     * 功能：我发布的职位 - 立即结束招聘 页面效果
     * 参数：
     * obj：当前点击a标签
     */
    s:function(){
        var obj=$("div").data("obj");
        var par=$(obj).parent();
        var date=bringinRender.w();
        par.prev().find("p:eq(0) span.gray").html('(招聘结束于 '+date+')');
        par.html(TEMPLE.T00036);
    },
    /*
     * 功能：初始化简历列表父容器
     * 参数：
     * obj：当前行
     */
    t:function(obj,pid,cls){
        var tmp=TEMPLE.T00038;
        var id=pid+"res"+$("#"+pid+" div.mlist_list").length;
        var cl='';
        if(cls){
            cl="mlist_s";
        }
        tmp=tmp.replace("{id}",id).replace("{mlist_s}",cl);
        $("input#tempsave").data("rid",id);
        $(obj).parent().parent().parent().append(tmp);
        var oul=$("#"+id);
        oul.next().find("a.blue").attr("href",oul.parent().parent().find("a.jtitle").attr("href"));
    },
    /*
     * 功能：成功异步获取简历列表
     * 参数：
     * data：后台返回数据
     */
    u:function(data){
        var pid=$("input#tempsave").data("rid");
        var dt=data.data;
        var mytmp=[];
        mytmp[0]=bringinRender.v("1");//全职
        mytmp[1]=bringinRender.v("2");//兼职
        $.each(dt, function(i,o){
            var certs='';
            var type=o.type;
            if(type=="1"){
                o.temp=0;
            }
            else{
                o.temp=1;
            }
            if(o.role=="1"){
                o.role="人才";//人才
            }else if(o.role=="3"){
                o.role="猎头";//猎头
            }
            if(typeof(o.cert)=="undefined"){o.cert=[];}
            var len=o.cert.length;
            $.each(o.cert,function(k,item){
                  certs+='<p><span class="gray">证书情况: </span><span>'+item+'</span></p>';
            });
            o.cert=certs;
            if(o.salary=="面议"){
                o.face="face";
            }else{
                o.face="";
            }
            o.u_name=o.h_name;
            o.rid=o.send_resume_id;
            o.focus_id=o.user_id;
            o.reid=o.send_resume_id;
        });
        var varr=[[],[]];
        varr[0]=['reid','u_name','focus_id','rid',"cert","date","exp","h_name","name","photo","salary","face","role","follow"];
        varr[1]=['reid','u_name','focus_id','rid',"cert","date","place","h_name","name","photo","salary","face","role","follow"];
        HGS.Base.GenMTemp(pid,varr,dt,mytmp);      
        return $("#"+pid);
    },
    /*
     * 功能：生成收到的简历列表模板
     * 参数：
     * 无
     */
    v:function(type){
        var tmp=TEMPLE;
        var ltmp='';
        var mtmp='';
        var rtmp='';
        var wu=SWEBURL;
        var ou=wu.ResumeDetail;
        var nu=wu.SResumeDetail
        ltmp=tmp.T00039;
        rtmp=tmp.T00062.replace(ou,nu);//右侧
        if(type=="1"){
            mtmp=tmp.T00042.replace(ou,nu);//全职
        }else{
            mtmp=tmp.T00041.replace(ou,nu);//兼职
        }
        return baseController.GenBListTemp(ltmp, mtmp, rtmp);
    },
    /*
     * 功能：获取当前日期
     * 参数：
     *
     */
    w:function(){
        var mydate = new Date();
        var month=mydate.getMonth()+1;
        var day=mydate.getDate();
        month=(month<10?"0"+month:month);
        day=(day<10?"0"+day:day);
        var date=mydate.getFullYear()+"-"+month+"-"+day;
        return date;
    },

    /************************************************************************************************/
    /*
     * 功能：成功异步获取委托出去的职位列表
     * 参数：
     * data：后台返回数据
     */
    x:function(data){
        var count=bringinRender.z(data);
        BringinController.o(count,"#pagination2",BringinController.x);
    },
    /*
     * 功能：失败异步获取委托出去的职位列表
     * 参数：
     * data：后台返回数据
     */
    y:function(data){
        BringinController.o(0,"#pagination2",BringinController.x);
        $("#delelist").html("<li class='no-data'>暂无数据!</li>");
    },
    /*
     * 功能：成功异步获取委托出去的职位列表
     * 参数：
     * data：后台返回数据
     */
    z:function(data){
        var dt=data.data;
        var count=data.count;
        var mytmp=[];
        mytmp[0]=bringinRender.aa("1", "3");//全职 委托中
        mytmp[1]=bringinRender.aa("1", "2");//全职 已结束
        mytmp[2]=bringinRender.aa("2", "3");//兼职 委托中
        mytmp[3]=bringinRender.aa("2", "2");//兼职 已结束
        $.each(dt, function(i,o){
            var type=o.category;
            var status=o.status;
            var certs="";
            if(type=="1"&&status=="3"){
                o.temp=0;
                o.stdes="招聘结束";
            }else if(type=="1"&&status!="3"){
                o.temp=1;
                o.stdes="发布";
            }
            else if(type=="2"&&status=="3"){
                o.temp=2;
                o.stdes="招聘结束";
            }
            else if(type=="2"&&status!="3"){
                o.temp=3;
                o.stdes="发布";
            }
            if(typeof(o.cert)=="undefined"){o.cert=[];}
            $.each(o.cert,function(k,item){
                certs+='<p><span class="gray">证书情况: </span><span>'+item+'</span></p>';
            });
            o.cert=certs;
            if(o.r_count>0){
                o.r_class="red";
            }
            else{
                o.r_class="";
            }
            if(o.salary=="面议"){
                o.face="face";
            }else{
                o.face="";
            }
            o.del_name=o.agent;
            o.del_id=o.agent_id;
        });
        var varr=[];
        varr[0]=['del_name','del_id','cert','company','title','name','count','location','degree','r_count','date','r_class','salary','stdes','id','face'];
        varr[1]=['del_name','del_id','cert','company','title','name','count','location','degree','r_count','date','r_class','salary','stdes','id','face'];
        varr[2]=['del_name','del_id','cert','company','title','place','location','r_count','date','r_class','salary','stdes','id','face'];
        varr[3]=['del_name','del_id','cert','company','title','place','location','r_count','date','r_class','salary','stdes','id','face'];
        HGS.Base.GenMTemp("delelist",varr,dt,mytmp);
        $("#delelist").find("p.own").remove();
        BringinController.aa();
        return count;
    },
    /*
     * 功能：生成委托出去的职位列表模板
     * 参数：
     * 无
     */
    aa:function(type,status){
        var tmp=TEMPLE;
        var mtmp='';
        var rtmp='';
        if(type=="1"&&status=="3"){
            mtmp=tmp.T00037.replace(SWEBURL.JobDetail+'/{id}',"javascript:;").replace('<span class="gray">收到简历: </span><span class="{r_class}">{r_count} 份</span>','<span class="gray">委托给: </span><a href="'+SWEBURL.AGENTDetail+'/{del_id}" target="_blank" class="blue">{del_name}</a>');//全职
            rtmp=tmp.T00036.replace("招聘","");//已停止招聘
        }else if(type=="1"&&status!="3"){
            mtmp=tmp.T00037.replace(SWEBURL.JobDetail+'/{id}',"javascript:;").replace('<span class="gray">收到简历: </span><span class="{r_class}">{r_count} 份</span>','<span class="gray">委托给: </span><a href="'+SWEBURL.AGENTDetail+'/{del_id}" target="_blank" class="blue">{del_name}</a>');
            rtmp=tmp.T00048;//委托中
        }
        else if(type=="2"&&status=="3"){
            mtmp=tmp.T00034.replace(SWEBURL.JobDetail+'/{id}',"javascript:;").replace('<span class="gray">收到简历: </span><span class="{r_class}">{r_count} 份</span>','<span class="gray">委托给: </span><a href="'+SWEBURL.AGENTDetail+'/{del_id}" target="_blank" class="blue">{del_name}</a>');//兼职
            rtmp=tmp.T00036.replace("招聘","");
        }
        else if(type=="2"&&status!="3"){
            mtmp=tmp.T00034.replace(SWEBURL.JobDetail+'/{id}',"javascript:;").replace('<span class="gray">收到简历: </span><span class="{r_class}">{r_count} 份</span>','<span class="gray">委托给: </span><a href="'+SWEBURL.AGENTDetail+'/{del_id}" target="_blank" class="blue">{del_name}</a>');
            rtmp=tmp.T00048;
        }
        return baseController.GenBListTemp(null, mtmp, rtmp);
    },
    /*
     * 功能：成功终止职位委托
     * 参数：
     * data：后台返回数据
     */
    ab:function(data){
        var page=parseInt($("#pagination2").find("span.current").not("span.prev,span.next").val(),10);
        page=page-1;
        if($("ul#delelist li").length==0){
            page=page-1;
        }
        BringinController.w(page);
        BringinController.ab(page);
    },
    /*
     * 功能：成功异步获取未处理的职位列表
     * 参数：
     * data：后台返回数据
     */
    ac:function(data){
        var count=bringinRender.ae(data);
        BringinController.o(count,"#pagination3",BringinController.ac);
    },
    /*
     * 功能：失败异步获取未处理的职位列表
     * 参数：
     * data：后台返回数据
     */
    ad:function(data){
        BringinController.o(0,"#pagination3",BringinController.ac);
        $("#jobboxlist").html("<li class='no-data'>暂无数据!</li>");
    },
    /*
     * 功能：成功异步获取未处理的职位列表
     * 参数：
     * data：后台返回数据
     */
    ae:function(data){
        var dt=data.data;
        var count=data.count;
        var mytmp=[];
        mytmp[0]=bringinRender.af("1");//全职
        mytmp[1]=bringinRender.af("2");//兼职
        $.each(dt, function(i,o){
            var type=o.category;
            var certs="";
            if(type=="1"){
                o.temp=0;
            }else{
                o.temp=1;
            }
            if(typeof(o.cert)=="undefined"){o.cert=[];}
            $.each(o.cert,function(k,item){
                certs+='<p><span class="gray">证书情况: </span><span>'+item+'</span></p>';
            });
            o.cert=certs;
            if(o.r_count>0){
                o.r_class="red";
            }
            else{
                o.r_class="";
            }
            if(o.salary=="面议"){
                o.face="face";
            }else{
                o.face="";
            }
            o.stdes="创建";
        });
        var varr=[];
        varr[0]=['face','cert','company','title','name','count','location','degree','r_count','date','r_class','salary','stdes','id'];
        varr[1]=['face','cert','company','title','place','location','r_count','date','r_class','salary','stdes','id'];
        HGS.Base.GenMTemp("jobboxlist",varr,dt,mytmp);
        $("#jobboxlist").find("p.own").remove();
        BringinController.af();
        return count;
    },
    /*
     * 功能：生成我未处理的职位列表模板
     * 参数：
     * 无
     */
    af:function(type){
        var tmp=TEMPLE;
        var mtmp='';
        var rtmp=tmp.T00054;//
        if(type=="1"){
            mtmp=tmp.T00037.replace('<p class="lst_p rec_res"><span class="gray">收到简历: </span><span class="{r_class}">{r_count} 份</span></p>',"");//全职
        }else{
            mtmp=tmp.T00034.replace('<p class="lst_p rec_res"><span class="gray">收到简历: </span><span class="{r_class}">{r_count} 份</span></p>',"");
        }
        return baseController.GenBListTemp(null, mtmp, rtmp);
    },
    /*
     * 功能：待处理的职位 - 立即发布成功数据刷新
     * 参数：
     * data：后台返回数据
     */
    ag:function(data){
        var obj=$("#jobboxlist").data("cur");
        var par=$(obj).parent().parent().parent();
        par.slideUp(300,function(){
            par.remove();
        });
        var page=parseInt($("#pagination3").find("span.current").not("span.prev,span.next").val(),10);
        page=page-1;
        if($("ul#jobboxlist li").length==0){
            page=page-1;
        }
        BringinController.ab(page);
        BringinController.p(0);
    },
    /*
    * 功能：立即终止委托失败|待处理的职位立即发布
    * 参数：
    * data:异步失败返回数据
    */
   m:function(data){
       $("#agentpub").removeClass("clicked");
       $("#redpub").removeClass("clicked");
       if(data.data=="YEBZ0001"){
            paytipController.NoScore();
        }else{
            alert(data.data);
        }
   },
    /*
    * 功能：应聘来的简历异步成功后数据渲染
    * 参数：
    * data:异步成功后返回数据,count:数据总条数
    */
   ns:function(data){
       var count=bringinRender.os(data);       
       BringinController.o(count,'#pagination6',BringinController.ai);       
   },
    /*
    * 功能：应聘来的简历异步失败后的数据渲染
    * 参数：
    * data:异步失败后返回数据
    */
   nf:function(data){       
       BringinController.o(0,'#pagination6',BringinController.ah);
       $("#applied_resume").html("<li class='no-data'>暂无数据!</li>");       
   },
    /*
    * 功能：应聘来的简历异步成功后的数据渲染
    * 参数：
    * data:异步成功后返回数据
    */
   os:function(data){       
       var dt=data.data;       
       var count=data.count;         
       var mytmp=[];       
       mytmp[0]=bringinRender.ot("1","1");//全职 未查看   根据不同的状态调用相应的模板
       mytmp[1]=bringinRender.ot("1","2");//全职 已查看
       mytmp[2]=bringinRender.ot("2","1");//兼职 未查看
       mytmp[3]=bringinRender.ot("2","2");//兼职 已查看
       var da=[];
       var res=new Resume();       
       var rz;
       $.each(dt, function(i,o){
            var myres=res;
            var oitem={};//单条数据临时存储对象
            var certs='';
            var type=o.job_category;                
            var status=o.send_status;            
            if(type=="1"&&status=="1"){
                oitem["temp"]=0;
            }else if(type=="1"&&status=="2"){
                oitem["temp"]=1;
            }else if(type=="2"&&status=="1"){
                oitem["temp"]=2;
            }else if(type=="2"&&status=="2"){    //兼职 已查看
                oitem["temp"]=3;
            }
            else{
                oitem["temp"]=0;
            }
            if(typeof(o.RC_list)=="undefined"){ //证书情况
                o.RC_list=[];
            }
            if(o.sender_role=="3"){
                oitem[myres.role]="猎头";//猎头
            }else{
                oitem[myres.role]="人才";//人才
            }
            var len=o.RC_list.length;
            $.each(o.RC_list,function(k,item){
                 certs+='<p><span class="gray">证书情况: </span><span>'+item+'</span></p>';
            });
            certs +='<p><span class="gray">应聘职位: </span><span class="blue">'+o.job+'</span></p>';     
            //全职
            if(type=="1"){
                oitem[myres.exp]=o.work_exp;
                oitem[myres.pos]=o.job_name;
                oitem[myres.location]=o.job_addr;               
            }
            else{
                oitem[myres.place]=o.register_place;//兼职
                oitem["url"]=SWEBURL.APResume+o.h_id;
            }
            if(o.salary=="面议"){
                oitem["face"]="face";
            }else{
                oitem["face"]="";
            }
            //公有
            oitem[myres.rid]=o.send_resume_id;
            oitem[myres.cert]=certs;
            oitem[myres.follow]="";
            oitem[myres.u_name]=o.sender_name;
            oitem[myres.name]=o.human_name;
            oitem[myres.u_photo]=o.sender_photo;
            oitem[myres.date]=o.send_datetime;
            oitem[myres.salary]=o.salary;
            rz=baseRender.zh(o.real_auth,o.phone_auth,o.email_auth);
            oitem.email_auth=rz.mil;
            oitem.real_auth=rz.nam;
            oitem.phone_auth=rz.pho;
            oitem.ntitle=rz.tnam;
            oitem.ptitle=rz.tpho;
            oitem.mtitle=rz.tmil;             
            oitem[myres.h_id]=o.send_resume_id;
            oitem[myres.send_resume_id]=o.send_resume_id; 
            oitem["focus_id"]=o.sender_id;
            oitem["reid"]=o.send_resume_id;
            da[i]=oitem;              
        });        
       var varr=[];       
         //varr模板变量数组
       varr[0]=['focus_id',"face","ntitle","ptitle","mtitle","reid",res.h_id,res.rid,res.cert,res.date,res.exp,res.follow,res.pos,res.location,res.u_name,res.name,res.u_photo,res.salary,res.role,res.email_auth,res.phone_auth,res.real_auth,res.send_resume_id];
       varr[1]=['focus_id',"face","ntitle","ptitle","mtitle","reid",res.h_id,res.rid,res.cert,res.date,res.exp,res.follow,res.pos,res.location,res.u_name,res.name,res.u_photo,res.salary,res.role,res.email_auth,res.phone_auth,res.real_auth,res.send_resume_id];
       varr[2]=['focus_id',"face","ntitle","ptitle","mtitle","reid",res.h_id,res.rid,res.cert,res.date,res.follow,res.place,res.u_name,res.name,res.u_photo,res.salary,res.role,res.email_auth,res.phone_auth,res.real_auth,res.send_resume_id];
       varr[3]=['focus_id',"face","ntitle","ptitle","mtitle","reid",res.h_id,res.rid,res.cert,res.date,res.follow,res.place,res.u_name,res.name,res.u_photo,res.salary,res.role,res.email_auth,res.phone_auth,res.real_auth,res.send_resume_id];
       HGS.Base.GenMTemp("applied_resume",varr,da,mytmp);      
       $("#applied_resume div.info p:last-child").addClass("lst_p");
//       BringinController.ba("#applied_resume a.chec_now");        
       var obj=$("#applied_resume a.chec_now,#applied_resume a.jtitle");
       BringinController.ba(obj);
       return count;
   },
   /*
     * 功能：生成应聘来的简历列表模板
     * 参数：
     * type：简历类型
     * 2兼职
     * 1全职
     * status：投递状态
     * 1未查看
     * 2已查看
     */
    ot:function(type,status){
        var tmp=TEMPLE;
        var ltmp='';
        var mtmp='';
        var rtmp='';
        ltmp=tmp.T00040;
        rtmp=tmp.T00043;//右侧
        var wu=SWEBURL;
        var ou=wu.ResumeDetail;
        var nu=wu.SResumeDetail;
        if(type=="1"&&status=="1"){
            mtmp=tmp.T00047.replace(ou,nu);//全职
            rtmp=rtmp.replace('<a href="javascript:;" class="btn white uoper">查看简历</a>','<a  href="'+SWEBURL.SResumeDetail+'/{h_id}" target="_blank" title="立即查看" class="btn white chec_now">立即查看</a>');
        }else if(type=="1"&&status=="2"){
            mtmp=tmp.T00047.replace(ou,nu);
            rtmp=rtmp.replace('<div class="btn_common lbtn btn22"><span class="b_lf"></span><span class="b_rf"></span><a href="javascript:;" class="btn white uoper">查看简历</a></div>','<span class="gray">已查看</span>');
        }else if(type=="2"&&status=="1"){
            mtmp=tmp.T00041.replace(ou,nu);//兼职
            rtmp=rtmp.replace('<a href="javascript:;" class="btn white uoper">查看简历</a>','<a href="'+SWEBURL.SResumeDetail+'/{h_id}" target="_blank" title="立即查看" class="btn white chec_now">立即查看</a>');
        }else if(type=="2"&&status=="2"){
            mtmp=tmp.T00041.replace(ou,nu);//兼职
            rtmp=rtmp.replace('<div class="btn_common lbtn btn22"><span class="b_lf"></span><span class="b_rf"></span><a href="javascript:;" class="btn white uoper">查看简历</a></div>','<span class="gray">已查看</span>');
        }
        mtmp=mtmp.replace('修改于','投递于');
        return baseController.GenBListTemp(ltmp, mtmp, rtmp);
    },
     /*
    *查看应聘来的简历点击处理
    *参数：无
    *
    *2012-2-18
    */
    p_c:function(){
        $("ul#applied_resume").data("obj").replaceWith("<span class='gray'>已查看</span>");
    },
    /*
    *查看应聘来的简历成功
    *参数：无
    *jack
    *2012-2-18
    */
//    p_s:function(ret){        
//         location.href=$("ul#applied_resume").data("rurl");        
//    },
    /*
    *查看应聘来的简历失败
    *参数：无
    *jack
    *2012-2-18
    */
    p_f:function(ret){
        event.preventDefault();
        alert(ret.data);
    }
};
