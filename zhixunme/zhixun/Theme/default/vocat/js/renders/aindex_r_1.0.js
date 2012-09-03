/*
 * 猎头首页页面渲染器
 */
var aindexRender={
    /*
     * 功能：成功异步获取简历列表职位列表
     * 参数：
     * data：后台返回数据
     */
    a:function(data){
        var count=aindexRender.d(data);
        AindexController.b(count,"#pagination1",AindexController.d);
    },
    /*
     * 功能：失败异步获取简历列表职位列表
     * 参数：
     * data：后台返回数据
     */
    b:function(data){
        AindexController.b(0,"#pagination1",AindexController.d);
        $("#talentlist").html("<li class='no-data'>暂无数据!</li>");
    },
    /*
     * 功能：定位到列表顶部
     * 参数：
     * 无
     */
    c:function(){
        $("html,body").animate({
            scrollTop:$("body").offset().top-60
        },500);
    },
    /*
     * 功能：成功异步获取简历列表
     * 参数：
     * data：后台返回数据
     */
    d:function(data){
        var dt=data.data;
        var count=data.count;
        var res=new Resume();
        var da=[];
        var mytmp=[];
        var rz;
        mytmp[0]=aindexRender.e("1");//全职
        mytmp[1]=aindexRender.e("2");//兼职
        $.each(dt, function(i,o){
            var myres=res;
            var oitem={};//单条数据临时存储对象
            var certs='';
            var type=o.job_category;
            if(type=="1"){
                oitem["temp"]=0;
            }
            else{
                oitem["temp"]=1;
            }
            if(o.publisher_role=="1"){
                oitem[myres.role]="人才";//人才
            }else if(o.publisher_role=="3"){
                oitem[myres.role]="猎头";//猎头
            }
            if(typeof(o.RC_list)=="undefined"){o.RC_list=[];}
            var len=o.RC_list.length;
            $.each(o.RC_list,function(k,item){
                 certs+='<p><span class="gray">证书情况: </span><span>'+item+'</span></p>';
            });
            //全职
            if(type=="1"){
                oitem[myres.exp]=o.human_work_age;
                oitem[myres.pos]=o.job_name;
                oitem[myres.location]=o.work_addr;
            }
            else{
                oitem[myres.place]=o.register_province_ids;//兼职
            }
            if(o.job_salary=="面议"){
                oitem["face"]="face";
            }else{
                oitem["face"]="";
            }
            //公有
            oitem[myres.cert]=certs;
            oitem[myres.follow]="";
            oitem[myres.u_name]=o.publisher_name;
            oitem[myres.name]=o.human_name;
            oitem[myres.u_photo]=o.publisher_photo;
            oitem[myres.date]=o.update_datetime;
            oitem[myres.salary]=o.job_salary;
            rz=baseRender.zh(o.real_auth,o.phone_auth,o.email_auth);
            oitem[myres.email_auth]=rz.mil;
            oitem[myres.phone_auth]=rz.pho;
            oitem[myres.real_auth]=rz.nam;
            oitem["ntitle"]=rz.tnam;
            oitem["ptitle"]=rz.tpho;
            oitem["mtitle"]=rz.tmil;              
            oitem["reid"]=o.human_id;   
            oitem[myres.rid]=o.resume_id;
            oitem[myres.h_id]=o.human_id;
            oitem['focus_id']=o.publisher_id;
            oitem["send_resume_id"]="";
            da[i]=oitem;
        });
        var varr=[];
        varr[0]=['send_resume_id','focus_id','face',"ntitle","ptitle","mtitle","reid",res.h_id,res.rid,res.cert,res.date,res.exp,res.follow,res.pos,res.location,res.u_name,res.name,res.u_photo,res.salary,res.role,res.email_auth,res.phone_auth,res.real_auth];
        varr[1]=['send_resume_id','focus_id','face',"ntitle","ptitle","mtitle","reid",res.h_id,res.rid,res.cert,res.date,res.follow,res.place,res.u_name,res.name,res.u_photo,res.salary,res.role,res.email_auth,res.phone_auth,res.real_auth];
        HGS.Base.GenMTemp("talentlist",varr,da,mytmp);
        AindexController.l();
        return count;
    },
    /*
     * 功能：生成我发布的简历列表模板
     * 参数：
     * 无
     */
    e:function(type){
        var tmp=TEMPLE;
        var ltmp='';
        var mtmp='';
        var rtmp='';
        ltmp=tmp.T00040;
        rtmp=tmp.T00043.replace("查看","邀请");//右侧
        if(type=="1"){
            mtmp=tmp.T00047;//全职
        }else{
            mtmp=tmp.T00041.replace("投递","修改");//兼职
        }
        return baseController.GenBListTemp(ltmp, mtmp, rtmp);
    },
    /*
     * 功能：成功异步获取推荐的职位列表
     * 参数：
     * data：后台返回数据
     */
    f:function(data){
        var count=aindexRender.h(data);
        AindexController.b(count,"#pagination2",AindexController.h);
    },
    /*
     * 功能：失败异步获取推荐的职位列表
     * 参数：
     * data：后台返回数据
     */
    g:function(data){
        AindexController.b(0,"#pagination2",AindexController.h);
        $("#joblist").html("<li class='no-data'>暂无数据!</li>");
    },
    /*
     * 功能：成功异步获取猎头首页推荐职位列表
     * 参数：
     * data：后台返回数据
     */
    h:function(data){
        var dt=data.data;
        var count=data.count;
        var mytmp=[];
        mytmp[0]=aindexRender.i("1");//全职
        mytmp[1]=aindexRender.i("2");//兼职
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
            oitem.id=o.job_id;
            oitem.u_photo=o.publisher_photo;
            oitem.title=o.job_title;
            oitem.u_name=o.publisher_name;
            oitem.salary=o.job_salary;
            oitem.date=o.pub_datetime;
            oitem.focus_id=o.publisher_id;
            oitem["send_resume_id"]="";
            da[i]=oitem;
        });
        var varr=[];
        varr[0]=["send_resume_id","focus_id","salary","face","date","cert","company","email_auth","real_auth","phone_auth","id","location","u_photo","title","u_name","follow","degree","count","pos","role","ntitle","ptitle","mtitle",];
        varr[1]=["send_resume_id","focus_id","salary","face","date","cert","company","email_auth","real_auth","phone_auth","id","location","u_photo","title","u_name","follow","place","role","ntitle","ptitle","mtitle",];
        HGS.Base.GenMTemp("joblist",varr,da,mytmp);
        AindexController.k();
        return count;
    },
    /*
     * 功能：生成推荐的职位列表模板
     * 参数：
     * 无
     */
    i:function(type){
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
    /************************************* 推荐企业 ****************************************/
    /*
     * 功能：地区选择回调方法
     * 参数：
     * data:后台返回数据
     */
    j:function(r){
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
        AindexController.n(0);
    },
    /*
     * 功能：成功异步获取推荐企业列表
     * 参数：
     * data：后台返回数据
     */
    k:function(data){
        var count=aindexRender.m(data);
        AindexController.b(count,"#pagination3",AindexController.o);
    },
    /*
     * 功能：失败异步获取推荐企业列表
     * 参数：
     * data：后台返回数据
     */
    l:function(data){
        AindexController.b(0,"#pagination3",AindexController.o);
        $("#reccom").html("<li class='no-data'>暂无数据!</li>");
    },
    /*
     * 功能：成功异步获取推荐企业列表
     * 参数：
     * data：后台返回数据
     */
    m:function(data){
        var dt=data.data;
        var count=data.count;
        var tmp=TEMPLE;
        var mytmp=baseController.GenBListTemp(tmp.T00040, tmp.T00058, tmp.T00059);
        var rz;
        $.each(dt, function(i,o){
            o.u_name=o.name;
            o.u_photo=o.user_photo;
            o.focus_id=o.user_id;
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
            o.role="";
        });
        var varr=["focus_id",'u_name','u_photo','follow','real_auth','phone_auth','email_auth','com_name','intro','location','id',"ntitle","ptitle","mtitle","role"];
        HGS.Base.GenTemp("reccom",varr,dt,mytmp);
        return count;
    }
    
};
