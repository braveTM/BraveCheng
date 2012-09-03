/*
 * 猎头首页页面渲染器
 */
var comfindtalRender={
    /*
     * 功能：成功异步获取可能感兴趣的人才列表
     * 参数：
     * data：后台返回数据
     */
    a:function(data){
        var count=comfindtalRender.d(data);
        EfindtalentController.a(count,"#pagination1",EfindtalentController.c);
    },
    /*
     * 功能：失败异步获取可能感兴趣的人才列表
     * 参数：
     * data：后台返回数据
     */
    b:function(data){
        EfindtalentController.a(0,"#pagination1",EfindtalentController.c);
        $("#talentlist").html("<li class='no-data'>暂无数据!</li>");
    },
    /*
     * 功能：定位到列表顶部
     * 参数：
     * 无
     */
    c:function(){
        $("html,body").animate({
            scrollTop:$("body").offset().top
        },500);
    },
    /*
     * 功能：成功异步获取可能感兴趣的人才列表
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
        mytmp[0]=comfindtalRender.e("1");//全职
        mytmp[1]=comfindtalRender.e("2");//兼职
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
            oitem.email_auth=rz.mil;
            oitem.real_auth=rz.nam;
            oitem.phone_auth=rz.pho;
            oitem.ntitle=rz.tnam;
            oitem.ptitle=rz.tpho;
            oitem.mtitle=rz.tmil;             
            oitem[myres.rid]=o.resume_id;
            oitem["reid"]=o.human_id;
            oitem[myres.h_id]=o.human_id;
            oitem["focus_id"]=o.publisher_id;
            //o=null;
            da[i]=oitem;
            //o=oitem;
            oitem["send_resume_id"]="";
        });
        var varr=[];
        varr[0]=["send_resume_id","focus_id","face","ntitle","ptitle","mtitle","reid",res.h_id,res.rid,res.cert,res.date,res.exp,res.follow,res.pos,res.location,res.u_name,res.name,res.u_photo,res.salary,res.role,res.email_auth,res.phone_auth,res.real_auth];
        varr[1]=["send_resume_id","focus_id","face","ntitle","ptitle","mtitle","reid",res.h_id,res.rid,res.cert,res.date,res.follow,res.place,res.u_name,res.name,res.u_photo,res.salary,res.role,res.email_auth,res.phone_auth,res.real_auth];
        HGS.Base.GenMTemp("talentlist",varr,da,mytmp);
        EfindtalentController.f();
        return count;
    },
    /*
     * 功能：生成可能感兴趣的人才列表模板
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
    }
};
