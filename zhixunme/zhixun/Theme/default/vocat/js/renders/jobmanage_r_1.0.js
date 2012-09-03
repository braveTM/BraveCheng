/*
 * 猎头职位管理页面渲染器
 */
var jobmanageRender={
    /******职位搜索start******/
    /*
    * 功能：地区选择插件选择后执行
    * 参数：无
    * author:joe 2012/7/27
    */
    a:function(r){
       var txt;
       var ids=r.prov;
         if(r.nolmt){
            txt=r.noname;
            ids="0";
        }
        else{
            txt=r.provname;
        }
        $("#pid").val(ids);
        $("#place").val(txt);
        JobmanageController.j(1);
    },
    /*
    * 功能：搜索框事件绑定
    * 参数：无
    * author:joe 2012/7/27
    */
    b:function(){
        var key=$("#keywords");
        var keyword=key.val();
        key.focus(function(){
            if($(this).val()=="请输入您要找的职位")
                $(this).val('');
            else
                $(this).removeClass("gray");
        }).blur(function(){
            if($(this).val()==''){
                $(this).val('请输入您要找的职位');
                $(this).addClass("gray");
            }
        })
    },
    /*
    * 功能：排序方式hover效果
    * 参数：无
    * author:joe 2012/7/27
    */
    c:function(){
        var up,down,upSel,downSel ;
        $("#pos_list").find("a").unbind("mouseover").unbind("mouseout");
        var obj=$("#pos_list").find("a").not(".sel,.gray");        
        obj.mouseover(function(){            
            up=$(this).find("em.up");
            down=$(this).find("em.down");        
            up.addClass("up_hov").removeClass("up");
            down.addClass("down_hov").removeClass("down");                               
        }).mouseout(function(){
            up=$(this).find("em.up_hov");
            down=$(this).find("em.down_hov");
            up.addClass("up").removeClass("up_hov");
            down.addClass("down").removeClass("down_hov");                      
        })
    },
    /*
    * 功能：筛选条件复选框点击事件
    * 参数：无
    * author:joe 2012/7/27
    */
    d:function(){
        $("#cert,#authuser").unbind("click").bind("click",function(){
            if($(this).hasClass("cancel")){
                $(this).removeClass("cancel");
            }
            else{
                $(this).addClass("cancel");
            }
            JobmanageController.j(1);
        });
    },
    /*
    * 功能：高级搜索事件绑定
    * 参数：无
    * author:joe 2012/7/27
    */
    e:function(){
        var that=HGS.Base;    
        var seAdvs=$("#se_advance");
        var adv=$("#advance");
        seAdvs.click(function(){
            var me=$(this);
            if($(this).hasClass("m")){
                adv.slideDown(300,function(){
                    me.find("em").text("-");
                    me.removeClass("m");
                });
            }
            else{
                adv.slideUp(300,function(){
                    me.addClass("m");
                    me.find("em").text("+");
                });  
            }             
        })
    },
    /*
    * 功能：排序方式click效果
    * 参数：无
    * author:joe 2012/7/27
    */
    f:function(){
        //直接点击排序按键
        $("#pos_list").find("a").not("#next,#prev").unbind("click").bind("click",function(){
            var up=$(this).find("em").first();
            var down=up.next(); 
            if(!$(this).hasClass("sel"))
                $(this).siblings("a").removeClass("sel");
            if($(this).hasClass("count")){//浏览数排序
               jobmanageRender.g($(this));               
               $(this).find("em").removeClass("down_hov").addClass("down");               
            }
            else{                
                var i=up.hasClass("up_sel")||(!up.hasClass("up_sel")&&!down.hasClass("down_sel"));            
                if(i){//升序||无排序
                    jobmanageRender.g($(this));
                    down.addClass("down_sel").removeClass("down").removeClass("down_hov");
                    up.addClass("up_hov");
                }else{
                    jobmanageRender.g($(this));
                    up.addClass("up_sel").removeClass("up").removeClass("up_hov");
                    down.addClass("down_hov");
                }                    
            }            
            JobmanageController.j(1);            
        })
        //直接点击排序图标
        $("#pos_list a").find("em").not(".up_sel,.down_sel,.cdw").unbind("click").bind("click",function(e){
            var e=e||window.event;
            e.stopPropagation();
            jobmanageRender.g($(this).parent());            
            if($(this).hasClass("up_hov")){
                $(this).addClass("up_sel").removeClass("up_hov");     
                $(this).next().addClass("down_hov").removeClass("down");
            }
            if($(this).hasClass("down_hov")){
                $(this).addClass("down_sel").removeClass("down_hov");
                $(this).prev().addClass("up_hov").removeClass("up");
            }
            JobmanageController.j(1);
        })
    },
    /*
    * 功能：排序方式初始化效果
    * 参数：
    * me：当前点击对象
    * author:joe 2012/7/27
    */
    g:function(me){
        var list=$("#pos_list");
        list.find("a.sel").removeClass("sel");
        list.find("em.up_sel").addClass("up").removeClass("up_sel");
        list.find("em.up_hov").addClass("up").removeClass("up_hov");
        list.find("em.down_sel").addClass("down").removeClass("down_sel");
        list.find("em.up_hov").addClass("down").removeClass("down_hov");
        me.addClass("sel");
        $("#cert,#authuser").addClass("cancel")
        if(me.hasClass("count")){//浏览数排序
            me.removeClass("count_gray");
        }
        else{
            me.siblings("a.count").addClass("count_gray");  
        }
        jobmanageRender.c();//初始化hover
    },
   /*
    * 功能：第一次异步搜索职位列表成功
    * 参数：无
    * author:joe 2012/7/27
    */
    h:function(data){
        var count=jobmanageRender.j(data);
        JobmanageController.o(count,"#pagination",JobmanageController.k);
        var ep=$("#pagination").find(".next").prev().text();
        $("#pagination").attr("ep",ep);
        JobmanageController.ea();
    },
    /*
    * 功能：异步搜索职位列表失败
    * 参数：无
    * author:joe 2012/7/27
    */
   i:function(data){
       $("#findjoblist").html(TEMPLE.T00114);
       JobmanageController.o(0,"#pagination",JobmanageController.k);
       $("#pagination").attr("ep",1);
       JobmanageController.ea();
   },
    /*
     * 功能：成功异步职位搜索模板数据组合
     * 参数：
     * data：后台返回数据
     * author:joe 2012/7/27
     */
    j:function(data){
        var dt=data.data;      
        var rd=jobmanageRender.k;        
        var mytmp=[],varr=[];
        var detile_url='',
            auth_png,
            certs='';
        mytmp[0]=rd(1);//全职
        mytmp[1]=rd(0);//兼职        
        $.each(dt, function(i,o){
            certs='';            
            if(o.job_category == 2)
                o.temp=1;        
            else
                o.temp=0;
            if(o.real_auth==1){
                o.auth_png='<img class="lit_small" src="{auth_png}" title="已实名认证">';
                o.auth=o.auth_png.replace("{auth_png}",FILEROOT+"/Files/system/auth/ab.png");
                o.lf='lf';
            }
            else{
                o.lf='';
                o.auth='';
            }                
            if(typeof(o.RC_list)!="undefined"){
                o.cert=[];
                $.each(o.RC_list,function(k,item){
                    certs+='<p><span class="gray">证书情况: </span><span>'+item+'</span></p>';
                }); 
                o.cert=certs;
            }else{
                o.cert='';
            }
            if(o.job_salary=="面议"){
                o.face="face";
            }else{
                o.face="";
            }
            if(o.publisher_role==3){
                o.role="猎头"
            }else{
                o.role="企业"
            }                   
        });
        varr[0]=["publisher_name","publisher_photo","lf","auth","publisher_id","job_salary","job_id","job_title","cert","job_name","job_province_code","degree","job_count","role","pub_datetime","face"];
        varr[1]=["publisher_name","publisher_photo","lf","auth","publisher_id","job_salary","job_id","job_title","cert","C_use_place","require_place","job_count","role","pub_datetime","face"];
        HGS.Base.GenMTemp("findjoblist",varr,dt,mytmp);
        baseController.BtnBind("div.btn22", "btn22", "btn22_hov", "btn22_hov");
        $("#pagination").show();
        JobmanageController.af();//投递简历
        return data.count;
    },
     /*
     * 功能：职位搜索全职｜兼职模板生成
     * 参数：
     * i：1全职　0兼职
     * author:joe 2012/7/27
     */
    k:function(i){
        var tmp=TEMPLE;
        var ltmp=tmp.T00111,mtmp='',rtmp=tmp.T00112;
        if(i==1){
            mtmp=tmp.T00109;
        }
        else if(i==0){
            mtmp=tmp.T00110;
        }
        return baseController.GenBListTemp(ltmp, mtmp, rtmp);
    },
    /*
     * 功能：搜索条件初始化
     * 参数：     
     * author:joe 2012/7/28
     */
    l:function(){
        var sal=$("#advance").find("li.salary");
        var date=$("#advance").find("li.pub_date");
        var salary=sal.children("a.sel").attr("rel")*1;
        var pub_date=date.children("a.sel").attr("rel")*1;  
        $("#place").val('不限');
        $("#pid").val(0);
        $("#pslt").remove();
        JobmanageController.a();
        if(salary!=0){
            sal.children("a.sel").removeClass("sel");
            sal.find("a").first().addClass("sel");
        }
        if(pub_date!=0){
            date.children("a.sel").removeClass("sel");
            date.find("a").first().addClass("sel");
        }
        jobmanageRender.g($("#pos_list").find("a").first());
    },
/******职位搜索end******/
    /*
    * 猎头结束招聘失败|猎头获取简历列表失败
    * 参数：
    * data:异步失败返回数据
    */
    m:function(data){
        alert(data.data);
    },
    /*
     * 功能：成功异步获取我发布的职位列表
     * 参数：
     * data：后台返回数据
     */
    n:function(data){
        var count=jobmanageRender.p(data);
        JobmanageController.o(count,"#pagination2",JobmanageController.q);
    },
    /*
     * 功能：失败异步获取我发布的职位列表
     * 参数：
     * data：后台返回数据
     */
    o:function(data){
        JobmanageController.o(0,"#pagination2",JobmanageController.q);
        $("#apublist").html("<li class='no-data'>暂无数据!</li>");
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
        var rd=jobmanageRender.r;
        mytmp[0]=rd("1", "3");//全职 已结束招聘
        mytmp[1]=rd("1", "2");//全职 招聘中
        mytmp[2]=rd("2", "3");//兼职 已结束招聘
        mytmp[3]=rd("2", "2");//兼职 招聘中
        mytmp[4]=rd("1", "4");//全职 已暂停
        mytmp[5]=rd("2", "4");//兼职 已暂停
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
            if(typeof(o.cert)=="undefined"){
                o.cert=[];
            }
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
        varr[0]=['pname','promote','cert','company','title','name','count','location','degree','r_count','date','r_class','stdes','id'];
        varr[1]=['pname','promote','cert','company','title','name','count','location','degree','r_count','date','r_class','salary','stdes','id','face'];
        varr[2]=['pname','promote','cert','company','title','place','location','r_count','date','r_class','stdes','id'];
        varr[3]=['pname','promote','cert','company','title','place','location','r_count','date','r_class','salary','stdes','id','face'];
        varr[4]=['pname','promote','cert','company','title','name','count','location','degree','r_count','date','r_class','salary','stdes','id','face'];
        varr[5]=['pname','promote','cert','company','title','place','location','r_count','date','r_class','salary','stdes','id','face'];
        HGS.Base.GenMTemp("apublist",varr,dt,mytmp);
        $("#apublist p.own").remove();
        var that=JobmanageController;
        that.t("#apublist");
        that.ag();
        that.u("apublist",true);
        that.apa("#apublist");
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
             rtmp=tmp.T00035.replace('<a href="javascript:;" class="btn white pausejob" rid="{id}">暂停公开招聘</a>','<a href="javascript:;" class="btn white continuejob" rid="{id}">继续公开招聘</a>');
        }else if(type=="2"&&status=="4"){
            mtmp=tmp.T00034;
           rtmp=tmp.T00035.replace('<a href="javascript:;" class="btn white pausejob" rid="{id}">暂停公开招聘</a>','<a href="javascript:;" class="btn white continuejob" rid="{id}">继续公开招聘</a>');
        }
        return baseController.GenBListTemp(null, mtmp, rtmp);
    },
    /*
     * 功能：我发布的职位 - 立即结束招聘 页面效果
     * 参数：
     * obj：当前点击a标签
     */
    s:function(){
        var obj=$("#apublist").data("obj");
        var par=$(obj).parent();
        var date=jobmanageRender.aa();
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
        tmp=tmp.replace("{id}",id).replace("{id}",pid).replace("{mlist_s}",cl);
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
        mytmp[0]=jobmanageRender.v("1");//全职
        mytmp[1]=jobmanageRender.v("2");//兼职
        $.each(dt, function(i,o){
            var certs='';
            var type=o.type;
            if(type=="1"){
                o.temp=0;
            }
            else{
                o.temp=1;
            }
            if(o.role=="3"){
                o.role="猎头";//猎头
            }else if(o.role=="2"){
                o.role="企业";//企业
            }
            if(typeof(o.cert)=="undefined"){
                o.cert=[];
            }
            var len=o.cert.length;
            $.each(o.cert,function(k,item){
                    certs+='<p><span class="gray">证书情况: </span><span>'+item+'</span></p>';
            });
            if(o.salary=="面议"){
                o.face="face";
            }else{
                o.face="";
            }
            o.cert=certs;
            o.rid=o.send_resume_id;
            o.reid=o.send_resume_id;
             
            o.focus_id=o.user_id;
            o.u_name=o.name;
            if(o.role=="3"){
                o.role="猎头";//猎头
            }else if(o.role=="1"){
                o.role="人才";//人才
            }
        });
        var varr=[[],[]];
        varr[0]=["reid","u_name","focus_id","rid","cert","date","exp","h_name","name","photo","salary","face","role","follow"];
        varr[1]=["reid","u_name","focus_id","rid","cert","date","place","h_name","name","photo","salary","face","role","follow"];
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
        var nu=wu.SResumeDetail;
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
     * 功能：成功异步获取委托来的职位列表
     * 参数：
     * data：后台返回数据
     */
    w:function(data){
        var count=jobmanageRender.y(data);
        JobmanageController.o(count,"#pagination1",JobmanageController.w);
    },
    /*
     * 功能：失败异步获取委托来的职位列表
     * 参数：
     * data：后台返回数据
     */
    x:function(data){
        JobmanageController.o(0,"#pagination1",JobmanageController.w);
        $("#agentjob").html("<li class='no-data'>暂无数据!</li>");
    },
    /*
     * 功能：成功异步获取委托来的职位列表
     * 参数：
     * data：后台返回数据
     */
    y:function(data){
        var dt=data.data;
        var count=data.count;
        var mytmp=[];
        var rz;
        mytmp[0]=jobmanageRender.z("1", "1");//全职 未公开
        mytmp[1]=jobmanageRender.z("1", "2");//全职 已公开
        mytmp[2]=jobmanageRender.z("1", "3");//全职 已结束招聘
        mytmp[3]=jobmanageRender.z("2", "1");//兼职 未公开
        mytmp[4]=jobmanageRender.z("2", "2");//兼职 已公开
        mytmp[5]=jobmanageRender.z("2", "3");//兼职 已结束招聘
        mytmp[6]=jobmanageRender.z("1", "4");//全职 已被终止
        mytmp[7]=jobmanageRender.z("1", "5");//全职 未查看
        mytmp[8]=jobmanageRender.z("2", "4");//兼职 已被终止
        mytmp[9]=jobmanageRender.z("2", "5");//兼职 未查看
        mytmp[10]=jobmanageRender.z("1", "6");//全职 已暂停
        mytmp[11]=jobmanageRender.z("2", "6");//兼职 已暂停
        $.each(dt, function(i,o){                       
            rz=baseRender.zh(o.real_auth,o.phone_auth,o.email_auth);
            o.email_auth=rz.mil;
            o.phone_auth=rz.pho;
            o.real_auth=rz.nam;
            o.ntitle=rz.tnam;
            o.ptitle=rz.tpho;
            o.mtitle=rz.tmil;              
            var type=o.category;
            var status=o.status;
            var certs="";
           if(o.main_role=="3"){
                o.role="猎头";//猎头
            }else if(o.main_role=="2"){
                o.role="企业";//企业
            }
            if(type=="1"&&status=="1"){
                o.temp=0;
            }else if(type=="1"&&status=="2"){
                o.temp=1;
            }
            else if(type=="1"&&status=="3"){
                o.temp=2;
            }
            else if(type=="2"&&status=="1"){
                o.temp=3;
            }
            else if(type=="2"&&status=="2"){
                o.temp=4;
            }
            else if(type=="2"&&status=="3"){
                o.temp=5;
            }else if(type=="1"&&status=="4"){
                o.temp=6;
            }else if(type=="1"&&status=="5"){
                o.temp=7;
            }else if(type=="2"&&status=="4"){
                o.temp=8;
            }else if(type=="2"&&status=="5"){
                o.temp=9;
            }else if(type=="1"&&status=="6"){
                o.temp=10;
            }else if(type=="2"&&status=="6"){
                o.temp=11;
            }
            o.stdes="职位委托";
            if(o.promote=="1"){
                o.promote="promote";
                o.pname="已推广";
            }else{
                o.promote="";
                o.pname="立即推广";
            }
            if(typeof(o.cert)=="undefined"){
                o.cert=[];
            }
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
            o.focus_id=o.u_id;
            if(o.salary=="面议"){
                o.face="face";
            }else{
                o.face="";
            }
        });
        var varr=[];
        varr[0]=['promote','pname','focus_id','cert','company','title','name','u_name',"u_photo",'count','location','degree','r_count','date','r_class','salary','stdes','id','follow','email_auth','phone_auth','real_auth','face',"ntitle","ptitle","mtitle","role"];
        varr[1]=varr[0];
        varr[2]=['promote','pname','focus_id','cert','company','title','name','u_name',"u_photo",'count','location','degree','r_count','date','r_class','stdes','id','follow','email_auth','phone_auth','real_auth',"ntitle","ptitle","mtitle","role"];
        varr[3]=['promote','pname','focus_id','cert','company','title','place','u_name',"u_photo",'location','r_count','date','r_class','salary','stdes','id','follow','email_auth','phone_auth','real_auth','face',"ntitle","ptitle","mtitle","role"];
        varr[4]=varr[3];
        varr[5]=['promote','pname','focus_id','cert','company','title','place','u_name',"u_photo",'location','r_count','date','r_class','stdes','id','follow','email_auth','phone_auth','real_auth',"ntitle","ptitle","mtitle","role"];
        varr[6]=varr[2];
        varr[7]=varr[2];
        varr[8]=varr[5];
        varr[9]=varr[5];
        varr[10]=varr[3];
        varr[11]=varr[3];
        HGS.Base.GenMTemp("agentjob",varr,dt,mytmp);
        var that=JobmanageController;
        that.t("#agentjob");
        that.u("agentjob");
        that.z("#agentjob");
        that.ah();
        that.aj();
        that.apa("#agentjob");
        return count;
    },
    /*
     * 功能：生成我发布的职位列表模板
     * 参数：
     * 无
     */
    z:function(type,status){
        var tmp=TEMPLE;
        var ltmp='';
        var mtmp='';
        var rtmp='';
        ltmp=tmp.T00040;
        if(type=="1"&&status=="1"){
            mtmp=tmp.T00037;//全职 未公开
            rtmp=tmp.T00044;//立即公开
        }else if(type=="1"&&status=="2"){
            mtmp=tmp.T00037;//全职 已公开
            rtmp=tmp.T00035;//暂停
        }else if(type=="1"&&status=="3"){
            mtmp=tmp.T00037;//全职 已结束
            rtmp=tmp.T00036;
        }else if(type=="2"&&status=="1"){
            mtmp=tmp.T00034;//兼职 未公开
            rtmp=tmp.T00044;
        }else if(type=="2"&&status=="2"){
            mtmp=tmp.T00034;//兼职 已公开
            rtmp=tmp.T00035;
        }else if(type=="2"&&status=="3"){
            mtmp=tmp.T00034;//兼职 已结束
            rtmp=tmp.T00036;
        }else if(type=="1"&&status=="4"){
            mtmp=tmp.T00037;//全职 终止委托
            rtmp=tmp.T00036.replace("已完成","已被终止委托");
        }else if(type=="1"&&status=="5"){
            mtmp=tmp.T00037;//全职 未查看
            rtmp=tmp.T00082;
        }else if(type=="1"&&status=="6"){
            mtmp=tmp.T00037;//全职 已暂停
            rtmp=tmp.T00035.replace('<a href="javascript:;" class="btn white pausejob" rid="{id}">暂停公开招聘</a>','<a href="javascript:;" class="btn white continuejob" rid="{id}">继续公开招聘</a>');
        }else if(type=="2"&&status=="4"){
            mtmp=tmp.T00034;//兼职 终止委托
            rtmp=tmp.T00036.replace("已完成","已被终止委托");
        }else if(type=="2"&&status=="5"){
            mtmp=tmp.T00034;//兼职 未查看
            rtmp=tmp.T00082;
        }else if(type=="2"&&status=="6"){
            mtmp=tmp.T00034;//兼职 已暂停
            rtmp=tmp.T00035.replace('<a href="javascript:;" class="btn white pausejob" rid="{id}">暂停公开招聘</a>','<a href="javascript:;" class="btn white continuejob" rid="{id}">继续公开招聘</a>');
        }
        return baseController.GenBListTemp(ltmp, mtmp, rtmp);
    },
    /*
     * 功能：获取当前日期
     * 参数：
     *
     */
    aa:function(){
        var mydate = new Date();
        var month=mydate.getMonth()+1;
        var day=mydate.getDate();
        month=(month<10?"0"+month:month);
        day=(day<10?"0"+day:day);
        var date=mydate.getFullYear()+"-"+month+"-"+day;
        return date;
    },
    /*
     * 功能：委托来的职位/发布职位 - 立即公开招聘 页面效果
     * 参数：
     * obj：当前点击a标签
     */
    ab:function(){
        var obj=$("div").data("obj");
        var par=$(obj).parent();
        $(obj).remove();
        par.html('<span class="b_lf"></span><span class="b_rf"></span><a href="javascript:;" class="btn white pausejob" rid="'+$(obj).attr("rid")+'">暂停公开招聘</a>');
        par.find("a.pausejob").unbind("click");
        par.find("a.pausejob").bind("click",function(){
            JobmanageController.apause(this);
        });
    },
    /*
     *功能：委托来的职位/发布的职位 - 暂停招聘后的效果
     *参数：
     *obj：当前元素
     */
    afterpa:function(){
        var obj=$("div").data("obj");
        var par=$(obj).parent();
//        var date=jobmanageRender.aa();
//        par.prev().find("p:eq(0) span.gray").html('(招聘暂停于 '+date+')');
        $(obj).remove();
        par.html('<span class="b_lf"></span><span class="b_rf"></span><a href="javascript:;" class="btn white continuejob" rid="'+$(obj).attr("rid")+'">继续公开招聘</a>');
        par.find("a.continuejob").unbind("click");
        par.find("a.continuejob").bind("click",function(){
            JobmanageController.acontinue(this);
        });
    },
    /*
     * 功能：成功异步获取可能感兴趣的职位列表
     * 参数：
     * data：后台返回数据
     */
    ac:function(data){
        var count=jobmanageRender.ae(data);
        JobmanageController.o(count,"#pagination3",JobmanageController.ac);
    },
    /*
     * 功能：失败异步获取可能感兴趣的职位列表
     * 参数：
     * data：后台返回数据
     */
    ad:function(data){
        JobmanageController.o(0,"#pagination3",JobmanageController.ac);
        $("#intrjob").html("<li class='no-data'>暂无数据!</li>");
    },
    /*
     * 功能：成功异步获取可能感兴趣的职位列表
     * 参数：
     * data：后台返回数据
     */
    ae:function(data){
        var dt=data.data;
        var count=data.count;
        var mytmp=[];
        var rz;
        mytmp[0]=jobmanageRender.af("1");//全职
        mytmp[1]=jobmanageRender.af("2");//兼职
        var job=new Jobs();
        var da=[];
        $.each(dt, function(i,o){
            var jb=job;
            var type=o.job_category;
            var certs="";
            var jitem={};
            if(type=="1"){
                jitem["temp"]=0;
            }else{
                jitem["temp"]=1;
            }
            if(o.publisher_role=="3"){
                jitem["role"]="猎头";//猎头
            }else if(o.publisher_role=="2"){
                jitem["role"]="企业";//企业
            }
            if(typeof(o.RC_list)=="undefined"){
                o.RC_list=[];
            }
            $.each(o.RC_list,function(k,item){
                certs+='<p><span class="gray">证书情况: </span><span>'+(item)+'</span></p>';
            });
            if(type=="1"){
                jitem[jb.count]=o.job_count;
                jitem[jb.pos]=o.job_name;
                jitem[jb.degree]=o.degree;
                jitem[jb.location]=o.job_province_code;
                if(typeof(o.job_city_code)!="undefined"){
                    jitem[jb.location]+=" - "+o.job_city_code;
                }
            }else{
                jitem[jb.place]=o.require_place;
                jitem[jb.location]=o.C_use_place;
            }
            if(o.job_salary=="面议"){
                jitem["face"]="face";
            }else{
                jitem["face"]="";
            }
            jitem[jb.cert]=certs;
            jitem[jb.company]=o.company_name;            
            rz=baseRender.zh(o.real_auth,o.phone_auth,o.email_auth);
            jitem[jb.eauth]=rz.mil;
            jitem[jb.pauth]=rz.pho;
            jitem[jb.rauth]=rz.nam;
            jitem["ntitle"]=rz.tnam;
            jitem["ptitle"]=rz.tpho;
            jitem["mtitle"]=rz.tmil;  
            jitem[jb.follows]="";
            jitem[jb.id]=o.job_id;
            jitem[jb.photo]=o.publisher_photo;
            jitem[jb.title]=o.job_title;
            jitem[jb.uname]=o.publisher_name;
            jitem[jb.salary]=o.job_salary;
            jitem[jb.date]=o.pub_datetime;
            jitem["focus_id"]=o.publisher_id;
            jitem["send_resume_id"]="";
            da[i]=jitem;
        });
        var varr=[];
        varr[0]=["send_resume_id","focus_id","face","ntitle","ptitle","mtitle",job.salary,job.date,job.cert,job.company,job.eauth,job.rauth,job.pauth,job.id,job.location,job.photo,job.title,job.uname,job.follows,job.degree,job.count,job.pos,"role"];
        varr[1]=["send_resume_id","focus_id","face","ntitle","ptitle","mtitle",job.salary,job.date,job.cert,job.company,job.eauth,job.rauth,job.pauth,job.id,job.location,job.photo,job.title,job.uname,job.follows,job.place,"role"];
        HGS.Base.GenMTemp("intrjob",varr,da,mytmp);
        JobmanageController.af();
        return count;
    },
    /*
     * 功能：生成可能感兴趣的职位列表模板
     * 参数：
     * type：职位类型
     */
    af:function(type){
        var tmp=TEMPLE;
        var ltmp='';
        var mtmp='';
        var rtmp='';
        ltmp=tmp.T00040;
        rtmp=tmp.T00043.replace("查看","投递");
        if(type=="1"){
            mtmp=tmp.T00046;//全职
        }else{
            mtmp=tmp.T00045;//兼职
        }
        return baseController.GenBListTemp(ltmp, mtmp, rtmp);
    },
    /*
     * 功能：查看职位详细成功
     * 参数：
     * data：后台返回数据
     */
    ag:function(data){
        location.href=data.data;
    },
    /*
     * 功能：查看职位详细失败
     * 参数：
     * data：后台返回数据
     */
    ah:function(data){
        alert(data.data);
    }
};
