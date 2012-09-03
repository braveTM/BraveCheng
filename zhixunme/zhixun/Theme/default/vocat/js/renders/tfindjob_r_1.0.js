/*
 * 人才首页渲染器
 */
var tfjobRender={
    /*
     * 功能：定位到列表顶部
     * 参数：
     * 无
     */
    a:function(){
        $("html,body").animate({
            scrollTop:$("body").offset().top
        },500);
    },
    /*
     * 功能：成功异步获取人才感兴趣的职位列表
     * 参数：
     * data：后台返回数据
     */
    b:function(data){
        var count=tfjobRender.d(data);
        TFindJobController.a(count,"#pagination1",TFindJobController.c);
    },
    /*
     * 功能：失败异步获取人才感兴趣的职位列表
     * 参数：
     * data：后台返回数据
     */
    c:function(data){
        TFindJobController.a(0,"#pagination1",TFindJobController.c);
        $("#joblist").html("<li class='no-data'>暂无数据!</li>");
    },
    /*
     * 功能：成功异步获取人才感兴趣的职位列表
     * 参数：
     * data：后台返回数据
     */
    d:function(data){
        var dt=data.data;
        var count=data.count;
        var mytmp=[];
        mytmp[0]=tfjobRender.e("1");//全职
        mytmp[1]=tfjobRender.e("2");//兼职
        var da=[];
        var rz;
        $.each(dt, function(i,o){
            var type=o.job_category;
            var certs="";
            var oitem={};
            if(type=="1"){
                oitem["temp"]=0;
            }else{
                oitem["temp"]=1;
            }
            if(o.publisher_role=="3"){
                oitem["role"]="猎头";//猎头
            }else{
                oitem["role"]="企业";//企业
            }
            if(typeof(o.RC_list)=="undefined"){o.RC_list=[];}
            $.each(o.RC_list,function(k,item){
                certs+='<p><span class="gray">证书情况: </span><span>'+item+'</span></p>';
            });
            if(type=="1"){
                oitem.count=o.job_count;
                oitem.pos=o.job_name;
                oitem.degree=o.degree;
                var pro=o.job_province_code;
                var city=o.job_city_code;
                if(pro!="0"){
                    oitem.location=pro;
                    if(city!="0"){
                        oitem.location+=" - "+city;
                    }
                }
                else{
                    oitem.location="不限";
                }
            }else{
                oitem.place=o.require_place;
                oitem.location=o.C_use_place;
            }
            if(o.job_salary=="面议"){
                oitem["face"]="face";
            }else{
                oitem["face"]="";
            }
            oitem.cert=certs;
            oitem.company=o.company_name;
            rz=baseRender.zh(o.real_auth,o.phone_auth,o.email_auth);
            oitem.email_auth=rz.mil;
            oitem.real_auth=rz.nam;
            oitem.phone_auth=rz.pho;
            oitem.ntitle=rz.tnam;
            oitem.ptitle=rz.tpho;
            oitem.mtitle=rz.tmil;             
            oitem.follow="";
            oitem.focus_id=o.publisher_id;
            oitem.id=o.job_id;
            oitem.u_photo=o.publisher_photo;
            oitem.title=o.job_title;
            oitem.u_name=o.publisher_name;
            oitem.salary=o.job_salary;
            oitem.date=o.pub_datetime;
            oitem.send_resume_id="";
            da[i]=oitem;
        });
        var varr=[];
        varr[0]=["send_resume_id","focus_id","salary","face","date","cert","company","email_auth","real_auth","phone_auth","id","location","u_photo","title","u_name","follow","degree","count","pos","role","ntitle","ptitle","mtitle"];
        varr[1]=["send_resume_id","focus_id","salary","face","date","cert","company","email_auth","real_auth","phone_auth","id","location","u_photo","title","u_name","follow","place","role","ntitle","ptitle","mtitle"];
        HGS.Base.GenMTemp("joblist",varr,da,mytmp);
        TFindJobController.f("#joblist a.uoper");
        return count;
    },
    /*
     * 功能：生成人才感兴趣的职位列表模板
     * 参数：
     * 无
     */
    e:function(type){
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
     * 功能：投递简历成功
     * 参数：
     * data：后台返回数据
     */
    f:function(data){
        alert("简历投递成功!");
    },
    /*
     * 功能：投递简历失败
     * 参数：
     * data：后台返回数据
     */
    g:function(data){
            if(/公开/.test(data.data)){
            baseController.InitialSureDialog("error",data.data, "select",'去公开简历',function(){    
                    $("#select").unbind("click").bind("click",function(){
                       var job=$("#joblist").data("job").html();
                       if(/兼职/.test(job))
                           window.location.href=WEBROOT+'/resume/0';                       
                       else
                           window.location.href=WEBROOT+'/resume/1';
                    })                  
                });
           }
           else
               alert(data.data);
    },
    /*
     * 功能：成功异步获取人才感兴趣的职位列表
     * 参数：
     * data：后台返回数据
     */
    h:function(data){
        var count=tfjobRender.j(data);
        TFindJobController.a(count,"#pagination2",TFindJobController.h);
    },
    /*
     * 功能：失败异步获取人才感兴趣的职位列表
     * 参数：
     * data：后台返回数据
     */
    i:function(data){
        TFindJobController.a(0,"#pagination2",TFindJobController.h);
        $("#ojoblist").html("<li class='no-data'>暂无数据!</li>");
    },
    /*
     * 功能：成功异步获取人才应聘过的职位列表
     * 参数：
     * data：后台返回数据
     */
    j:function(data){
        var dt=data.data;
        var count=data.count;
        var mytmp=[];
        mytmp[0]=tfjobRender.k("1");//全职
        mytmp[1]=tfjobRender.k("2");//兼职
        var da=[];
        var rz;
        $.each(dt, function(i,o){
            var type=o.job_category;
            var certs="";
            var oitem={};
            if(type=="1"){
                oitem["temp"]=0;
            }else{
                oitem["temp"]=1;
            }
            if(o.publisher_role=="3"){
                oitem["role"]="猎头";//猎头
            }else{
                oitem["role"]="企业";//企业
            }
            if(typeof(o.RC_list)=="undefined"){o.RC_list=[];}
            $.each(o.RC_list,function(k,item){
                certs+='<p><span class="gray">证书情况: </span><span>'+item+'</span></p>';
            });
            if(type=="1"){
                oitem.count=o.job_count;
                oitem.pos=o.job_name;
                oitem.degree=o.degree;
                var pro=o.job_province_code;
                var city=o.job_city_code;
                if(pro!="0"){
                    oitem.location=pro;
                    if(city!="0"){
                        oitem.location+=" - "+city;
                    }
                }
                else{
                    oitem.location="不限";
                }
            }else{
                oitem.place=o.require_place;
                oitem.location=o.C_use_place;
            }
            if(o.job_salary=="面议"){
                oitem["face"]="face";
            }else{
                oitem["face"]="";
            }
            oitem.cert=certs;
            oitem.company=o.company_name;                 
            rz=baseRender.zh(o.real_auth,o.phone_auth,o.email_auth);
            oitem.email_auth=rz.mil;
            oitem.real_auth=rz.nam;
            oitem.phone_auth=rz.pho;
            oitem.ntitle=rz.tnam;
            oitem.ptitle=rz.tpho;
            oitem.mtitle=rz.tmil;             
            oitem.follow="";
            oitem.focus_id=o.publisher_id;
            oitem.id=o.job_id;
            oitem.u_photo=o.publisher_photo;
            oitem.title=o.job_title;
            oitem.u_name=o.publisher_name;
            oitem.salary=o.job_salary;
            oitem.date=o.send_datetime;
            oitem.send_resume_id="";
            da[i]=oitem;
        });
        var varr=[];
        varr[0]=["send_resume_id","focus_id","salary","face","date","cert","company","email_auth","real_auth","phone_auth","id","location","u_photo","title","u_name","follow","degree","count","pos","role","ntitle","ptitle","mtitle"];
        varr[1]=["send_resume_id","focus_id","salary","face","date","cert","company","email_auth","real_auth","phone_auth","id","location","u_photo","title","u_name","follow","place","role","ntitle","ptitle","mtitle"];
        HGS.Base.GenMTemp("ojoblist",varr,da,mytmp);
        TFindJobController.f("#ojoblist a.uoper");
        return count;
    },
    /*
     * 功能：生成人才感兴趣的职位列表模板
     * 参数：
     * 无
     */
    k:function(type){
        var tmp=TEMPLE;
        var ltmp='';
        var mtmp='';
        var rtmp='';
        ltmp=tmp.T00040;
        rtmp=tmp.T00043.replace("查看","投递");
        if(type=="1"){
            mtmp=tmp.T00046.replace("发布于","简历投递于");//全职
        }else{
            mtmp=tmp.T00045.replace("发布于","简历投递于");//兼职
        }
        return baseController.GenBListTemp(ltmp, mtmp, rtmp);
    },
    /**********************************************    意向职位   *******************************************/
    /*
     * 功能：成功异步获取意向职位列表
     * 参数：
     * data：后台返回数据
     */
    l:function(data){
        var count=tfjobRender.n(data);
        TFindJobController.a(count,"#pagination3",TFindJobController.l);
    },
    /*
     * 功能：失败异步获取意向职位列表
     * 参数：
     * data：后台返回数据
     */
    m:function(data){
        TFindJobController.a(0,"#pagination3",TFindJobController.l);
        $("#wjoblist").html("<li class='no-data'>暂无数据!</li>");
    },
    /*
     * 功能：成功异步获取意向职位列表
     * 参数：
     * data：后台返回数据
     */
    n:function(data){
        var dt=data.data;
        var count=data.count;
        var mytmp=[];
        mytmp[0]=tfjobRender.e("1");//全职
        mytmp[1]=tfjobRender.e("2");//兼职
        var da=[];
        var rz;
        $.each(dt, function(i,o){
            var type=o.job_category;
            var certs="";
            var oitem={};
            if(type=="1"){
                oitem["temp"]=0;
            }else{
                oitem["temp"]=1;
            }
            if(o.publisher_role=="3"){
                oitem["role"]="猎头";//猎头
            }else{
                oitem["role"]="企业";//企业
            }
            if(typeof(o.RC_list)=="undefined"){o.RC_list=[];}
            $.each(o.RC_list,function(k,item){
                certs+='<p><span class="gray">证书情况: </span><span>'+item+'</span></p>';
            });
            if(type=="1"){
                oitem.count=o.job_count;
                oitem.pos=o.job_name;
                oitem.degree=o.degree;
                var pro=o.job_province_code;
                var city=o.job_city_code;
                if(pro!="0"){
                    oitem.location=pro;
                    if(city!="0"){
                        oitem.location+=" - "+city;
                    }
                }
                else{
                    oitem.location="不限";
                }
            }else{
                oitem.place=o.require_place;
                oitem.location=o.C_use_place;
            }
             
            if(o.job_salary=="面议"){
                oitem["face"]="face";
            }else{
                oitem["face"]="";
            }
            oitem.cert=certs;
            oitem.company=o.company_name;
            rz=baseRender.zh(o.real_auth,o.phone_auth,o.email_auth);
            oitem.email_auth=rz.mil;
            oitem.real_auth=rz.nam;
            oitem.phone_auth=rz.pho;
            oitem.ntitle=rz.tnam;
            oitem.ptitle=rz.tpho;
            oitem.mtitle=rz.tmil;             
            oitem.follow="";
            oitem.focus_id=o.publisher_id;
            oitem.id=o.job_id;
            oitem.u_photo=o.publisher_photo;
            oitem.title=o.job_title;
            oitem.u_name=o.publisher_name;
            oitem.salary=o.job_salary;
            oitem.date=o.pub_datetime;
            da[i]=oitem;
        });
        var varr=[];
        varr[0]=["focus_id","salary","face","date","cert","company","email_auth","real_auth","phone_auth","id","location","u_photo","title","u_name","follow","degree","count","pos","role","ntitle","ptitle","mtitle"];
        varr[1]=["focus_id","salary","face","date","cert","company","email_auth","real_auth","phone_auth","id","location","u_photo","title","u_name","follow","place","role","ntitle","ptitle","mtitle"];
        HGS.Base.GenMTemp("wjoblist",varr,da,mytmp);
        TFindJobController.f("#wjoblist a.uoper");
        return count;
    },
     /******职位搜索start******/
    /*
    * 功能：地区选择插件选择后执行
    * 参数：无
    * author:joe 2012/7/27
    */
    aa:function(r){
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
        TFindJobController.aj(1);
    },
    /*
    * 功能：搜索框事件绑定
    * 参数：无
    * author:joe 2012/7/27
    */
    ab:function(){
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
    ac:function(){
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
    ad:function(){
        $("#cert,#authuser").unbind("click").bind("click",function(){
            if($(this).hasClass("cancel")){
                $(this).removeClass("cancel");
            }
            else{
                $(this).addClass("cancel");
            }
            TFindJobController.aj(1);
        });
    },
    /*
    * 功能：高级搜索事件绑定
    * 参数：无
    * author:joe 2012/7/27
    */
    ae:function(){
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
    af:function(){
        //直接点击排序按键
        $("#pos_list").find("a").not("#next,#prev").unbind("click").bind("click",function(){
            var up=$(this).find("em").first();
            var down=up.next(); 
            if(!$(this).hasClass("sel"))
                $(this).siblings("a").removeClass("sel");
            if($(this).hasClass("count")){//浏览数排序
               tfjobRender.ag($(this));               
               $(this).find("em").removeClass("down_hov").addClass("down");               
            }
            else{                
                var i=up.hasClass("up_sel")||(!up.hasClass("up_sel")&&!down.hasClass("down_sel"));            
                if(i){//升序||无排序
                    tfjobRender.ag($(this));
                    down.addClass("down_sel").removeClass("down").removeClass("down_hov");
                    up.addClass("up_hov");
                }else{
                    tfjobRender.ag($(this));
                    up.addClass("up_sel").removeClass("up").removeClass("up_hov");
                    down.addClass("down_hov");
                }                    
            }            
            TFindJobController.aj(1);            
        })
        //直接点击排序图标
        $("#pos_list a").find("em").not(".up_sel,.down_sel,.cdw").unbind("click").bind("click",function(e){
            var e=e||window.event;
            e.stopPropagation();
            tfjobRender.ag($(this).parent());            
            if($(this).hasClass("up_hov")){
                $(this).addClass("up_sel").removeClass("up_hov");     
                $(this).next().addClass("down_hov").removeClass("down");
            }
            if($(this).hasClass("down_hov")){
                $(this).addClass("down_sel").removeClass("down_hov");
                $(this).prev().addClass("up_hov").removeClass("up");
            }
            TFindJobController.aj(1);
        })
    },
    /*
    * 功能：排序方式初始化效果
    * 参数：
    * me：当前点击对象
    * author:joe 2012/7/27
    */
    ag:function(me){
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
        tfjobRender.ac();//初始化hover
    },
   /*
    * 功能：异步搜索职位列表成功
    * 参数：无
    * author:joe 2012/7/27
    */
    ah:function(data){
        var count=tfjobRender.aj(data);
        TFindJobController.a(count,"#pagination",TFindJobController.ak);
        var ep=$("#pagination").find(".next").prev().text();
        $("#pagination").attr("ep",ep);
        TFindJobController._ea();
    },
    /*
    * 功能：异步搜索职位列表失败
    * 参数：无
    * author:joe 2012/7/27
    */
   ai:function(data){
       $("#findjoblist").html(TEMPLE.T00114);
       TFindJobController.a(0,"#pagination",TFindJobController.k);
       $("#pagination").attr("ep",1);
       TFindJobController._ea();
   },
    /*
     * 功能：成功异步职位搜索模板数据组合
     * 参数：
     * data：后台返回数据
     * author:joe 2012/7/27
     */
    aj:function(data){
        var dt=data.data;      
        var rd=tfjobRender.ak;        
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
                o.lf=''
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
        TFindJobController.f("#findjoblist a.uoper");//投递简历
        return data.count;
    },
     /*
     * 功能：职位搜索全职｜兼职模板生成
     * 参数：
     * i：1全职　0兼职
     * author:joe 2012/7/27
     */
    ak:function(i){
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
    al:function(){
        var sal=$("#advance").find("li.salary");
        var date=$("#advance").find("li.pub_date");
        var salary=sal.children("a.sel").attr("rel")*1;
        var pub_date=date.children("a.sel").attr("rel")*1;  
        $("#place").val('不限');
        $("#pid").val(0);
        $("#pslt").remove();
        TFindJobController.a();
        if(salary!=0){
            sal.children("a.sel").removeClass("sel");
            sal.find("a").first().addClass("sel");
        }
        if(pub_date!=0){
            date.children("a.sel").removeClass("sel");
            date.find("a").first().addClass("sel");
        }
        tfjobRender.ag($("#pos_list").find("a").first());
    }
    /******职位搜索end******/
}