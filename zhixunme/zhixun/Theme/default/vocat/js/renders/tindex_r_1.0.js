/*
 * 人才首页渲染器
 */
var tindexRender={
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
     * 功能：成功异步获取推荐的职位列表
     * 参数：
     * data：后台返回数据
     */
    b:function(data){
        var count=tindexRender.d(data);
        TIndexController.a(count,"#pagination1",TIndexController.c);
    },
    /*
     * 功能：失败异步获取推荐的职位列表
     * 参数：
     * data：后台返回数据
     */
    c:function(data){
        TIndexController.a(0,"#pagination1",TIndexController.c);
        $("#joblist").html("<li class='no-data'>暂无数据!</li>");
    },
    /*
     * 功能：成功异步获取猎头首页推荐职位列表
     * 参数：
     * data：后台返回数据
     */
    d:function(data){
        var dt=data.data;
        var count=data.count;
        var mytmp=[];
        mytmp[0]=tindexRender.e("1");//全职
        mytmp[1]=tindexRender.e("2");//兼职
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
            if(typeof(o.RC_list)=="undefined"){
                o.RC_list=[];
            }
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
//            oitem.email_auth=o.publisher_auth_email;
//            oitem.real_auth=o.publisher_auth_real;
//            oitem.phone_auth=o.publisher_auth_phone;
            
            rz=baseRender.zh(o.real_auth,o.phone_auth,o.email_auth);                       
            oitem.email_auth=rz.mil;
            oitem.real_auth=rz.nam;
            oitem.phone_auth=rz.pho;
            oitem.ntitle=rz.tnam;
            oitem.ptitle=rz.tpho;
            oitem.mtitle=rz.tmil;
            
            oitem.follow="";
            oitem.id=o.job_id;
            oitem.focus_id=o.publisher_id;
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
        TIndexController.f("#joblist a.uoper");
        return count;
    },
    /*
     * 功能：生成推荐的职位列表模板
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
        alert(data.data);
    },
    /************************************* 推荐企业 ****************************************/
    /*
     * 功能：地区选择回调方法
     * 参数：
     * data:后台返回数据
     */
    h:function(r){
        var that=r.obj;
        if(r.nolmt){
            that.val(r.noname);
            that.data("pid","0");
            that.data("cid","0");
        }
        else{
            var pname=r.provname;
            var cname=r.cityname;
            that.val(pname+" - "+cname);
            that.data("pid",r.prov);
            that.data("cid",r.city);
        }
        TIndexController.h(0);
    },
    /*
     * 功能：成功异步获取推荐企业列表
     * 参数：
     * data：后台返回数据
     */
    i:function(data){
        var count=tindexRender.k(data);
        TIndexController.a(count,"#pagination2",TIndexController.c);
    },
    /*
     * 功能：失败异步获取推荐企业列表
     * 参数：
     * data：后台返回数据
     */
    j:function(data){
        TIndexController.a(0,"#pagination2",TIndexController.c);
        $("#reccom").html("<li class='no-data'>暂无数据!</li>");
    },
    /*
     * 功能：成功异步获取推荐企业列表
     * 参数：
     * data：后台返回数据
     */
    k:function(data){
        var dt=data.data;
        var count=data.count;
        var tmp=TEMPLE;
        var mytmp=baseController.GenBListTemp(tmp.T00040, tmp.T00058, tmp.T00059);
        var rz;
        $.each(dt, function(i,o){
            o.u_name=o.name;
            o.u_photo=o.user_photo;
            o.focus_id=o.user_id;
//            o.real_auth=o.user_auth_real;
//            o.phone_auth=o.user_auth_phone;
//            o.email_auth=o.user_auth_email;
            
            rz=baseRender.zh(o.real_auth,o.phone_auth,o.email_auth);                       
            o.email_auth=rz.mil;
            o.real_auth=rz.nam;
            o.phone_auth=rz.pho;
            o.ntitle=rz.tnam;
            o.ptitle=rz.tpho;
            o.mtitle=rz.tmil;
            
            o.com_name=o.company_name;
            o.intro=o.company_introduce;
            o.id=o.user_id;
        });
        var varr=["focus_id",'u_name','u_photo','follow','real_auth','phone_auth','email_auth','com_name','intro','location','id',"ntitle","ptitle","mtitle"];
        HGS.Base.GenTemp("reccom",varr,dt,mytmp);
        return count;
    },
    /************************************* 推荐猎头 ****************************************/
    /*
     *功能：选择省份城市回调函数
     *jack
     *2012-2-12
     */
    l:function(r){
        var that=r.obj;
        if(r.nolmt){
            that.val(r.noname);
            that.data("pid","0");
            that.data("cid","0");
        }
        else{
            var pname=r.provname;
            var cname=r.cityname;
            that.val(pname+" - "+cname);
            that.data("pid",r.prov);
            that.data("cid",r.city);
        }
        TIndexController.l(0);
    },
    /*
     * 功能：成功异步获取委托来的职位列表
     * 绑定分页插件
     * 参数：
     * data：后台返回数据
     */
    m:function(data){
        var count=tindexRender.o(data);
        TIndexController.a(count,"#pagination3",TIndexController.m);
    },
    /*
     * 功能：失败异步获取委托来的职位列表
     * 参数：
     * data：后台返回数据
     */
    n:function(data){
        TIndexController.a(0,"#pagination3",TIndexController.m);
        $("#recagent").html("<li class='no-data'>暂无数据!</li>");
    },
    /*
     * 功能：成功异步获取猎头列表
     * 参数：
     * data：后台返回数据
     */
    o:function(ret){
        var count=ret.count;
        var data=ret.data;
        var mytmp=tindexRender.p();//不显示所属企业名称
        var rz;
        $.each(data,function(i,o){
            if(o.company_name!=""){
                o.temp=0;
            }else{
                o.temp=1;
            }
            o.u_photo=o.user_photo;
            o.u_name=o.name          
            rz=baseRender.zh(o.real_auth,o.phone_auth,o.email_auth);                       
            o.email_auth=rz.mil;
            o.real_auth=rz.nam;
            o.phone_auth=rz.pho;
            o.ntitle=rz.tnam;
            o.ptitle=rz.tpho;
            o.mtitle=rz.tmil;            
            o.focus_id=o.user_id;
        });
        var varr=['focus_id','user_id','u_photo','u_name','follow','real_auth','email_auth','phone_auth','agent_introduce','addr_province_code','addr_city_code','activity',"ntitle","ptitle","mtitle"];
        HGS.Base.GenTemp("recagent",varr,data,mytmp);
        $("#recagent a.degate_reu").bind("click",function(){
            TIndexController.p(this);
        });
        return count;
    },
    /*
     *功能：生成找猎头模板
     * 参数：
     * stat：是否显示所属公司
     */
    p:function(){
        var tmp=TEMPLE;
//        var show='';
        var ltemp=tmp.T00040,mtemp,rtemp=tmp.T00055;
//        if(stat==1){
//            show=tmp.T00056;
//        }else{
//            show="";
//        }
        mtemp=tmp.T00053.replace("{show}","");
        return baseController.GenBListTemp(ltemp,mtemp,rtemp);
    },
    /*
     *功能：委托简历成功
     *参数：无
     */
    q:function(){
        var type=$("div").data("type");
        alert('简历委托成功',"","","",function(){
            if(type==2){
                window.location.href="http://localhost"+WEBROOT+"/resume/";
            }else{
                window.location.href="http://localhost"+WEBROOT+"/resume/1";
            }
        });
    },
    /*
     * 功能：委托简历失败
     * 参数：无
     */
    r:function(ret){
        alert(ret.data);
    },
    /*
     * 功能：初始化委托简历选框
     * 参数：
     * 无
     */
    s:function(){
        var p=$("div.sure_dialog div.oper_middle");
        if(p.find("input[type='radio']").length==0){
            p.parent('div.alr_msgbox').css({
                "width":"245px",
                "height":"120px"
            });
            p.find("p.msg").css({
                "padding-left":"0",
                "padding-top":"8px"
            });
            $("div.sure_dialog p.msg").after(COMMONTEMP.T0027);
            p.find("span:first").css({
                "display":"inline-block",
                "width":"120px",
                "padding-right":"40px"
            });
            p.find("p.alr_box").css({
                "text-align":"left",
                "padding-top":"20px",
                "height":"30px"
            });
        }
    }
};
