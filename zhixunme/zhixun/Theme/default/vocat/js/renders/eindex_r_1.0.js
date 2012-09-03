/*
 * 人才首页渲染器
 */
var eindexRender={
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
     * 功能：成功异步获取推荐人才列表
     * 参数：
     * data：后台返回数据
     */
    b:function(data){
        var count=eindexRender.d(data);
        EIndexController.a(count,"#pagination1",EIndexController.c);
    },
    /*
     * 功能：失败异步获取推荐的职位列表
     * 参数：
     * data：后台返回数据
     */
    c:function(data){
        EIndexController.a(0,"#pagination1",EIndexController.c);
        $("#talentlist").html("<li class='no-data'>暂无数据!</li>");
    },
    /*
     * 功能：成功异步获取企业首页推荐简历列表
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
        mytmp[0]=eindexRender.e("1");//全职
        mytmp[1]=eindexRender.e("2");//兼职
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
            }else{
                oitem[myres.role]="猎头";//猎头
            }
            if(typeof(o.RC_list)=="undefined"){o.RC_list=[];}
            var len=o.RC_list.length;
            $.each(o.RC_list,function(k,item){
                if(k<len-1){
                    certs+='<p><span class="gray">证书情况: </span><span>'+item+'</span></p>';
                }else{
                    certs+='<p><span class="gray">证书情况: </span><span>'+item+'</span></p>';
                }
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
            oitem[myres.h_id]=o.human_id;
            oitem["focus_id"]=o.publisher_id;
            oitem["reid"]=o.human_id;
            oitem["send_resume_id"]="";
            da[i]=oitem;
        });
        var varr=[];
        varr[0]=['send_resume_id','reid','focus_id','face',"ntitle","ptitle","mtitle",res.h_id,res.rid,res.cert,res.date,res.exp,res.follow,res.pos,res.location,res.u_name,res.name,res.u_photo,res.salary,res.role,res.email_auth,res.phone_auth,res.real_auth];
        varr[1]=['send_resume_id','reid','focus_id','face',"ntitle","ptitle","mtitle",res.h_id,res.rid,res.cert,res.date,res.follow,res.place,res.u_name,res.name,res.u_photo,res.salary,res.role,res.email_auth,res.phone_auth,res.real_auth];
        HGS.Base.GenMTemp("talentlist",varr,da,mytmp);
        EIndexController.f();
        return count;
    },
    /*
     * 功能：生成推荐的人才列表模板
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
        EIndexController.h(0);
    },
    /*
     * 功能：成功异步获取猎头列表
     * 绑定分页插件
     * 参数：
     * data：后台返回数据
     */
    m:function(data){
        var count=eindexRender.o(data);
        EIndexController.a(count,"#pagination2",EIndexController.i);
    },
    /*
     * 功能：失败异步获取猎头列表
     * 参数：
     * data：后台返回数据
     */
    n:function(data){
        EIndexController.a(0,"#pagination2",EIndexController.i);
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
        var mytmp=eindexRender.p();//不显示所属企业名称
        var rz;
//        mytmp[0]=eindexRender.p("1");//显示所属企业名称
//        mytmp[1]=//不显示所属企业名称
        $.each(data,function(i,o){
            var service='';
//            if(o.company_name!=""){
//                o.temp=0;
//            }else{
//                o.temp=1;
//            }
            if(typeof(o.service_list)=="undefined"){
                o.service_list=[];
            }
            $.each(o.service_list,function(i,o){
                if(i>0){
                    service+="、"+o.name;
                }else{
                    service+=o.name;
                }
            });
            o.u_photo=o.user_photo;
            rz=baseRender.zh(o.real_auth,o.phone_auth,o.email_auth);
            o.email_auth=rz.mil;
            o.real_auth=rz.nam;
            o.phone_auth=rz.pho;
            o.ntitle=rz.tnam;
            o.ptitle=rz.tpho;
            o.mtitle=rz.tmil;             
            o.u_name=o.name;
            o.focus_id=o.user_id;
            o.service=service;
        });
        var varr=["focus_id",'user_id','u_photo','u_name','follow','real_auth','email_auth','phone_auth','agent_introduce','addr_province_code','addr_city_code','activity',"ntitle","ptitle","mtitle"];
        HGS.Base.GenTemp("recagent",varr,data,mytmp);
        var that=EIndexController;
        that.l("#recagent a.position_delgate");//职位委托
        return count;
    },
    /*
     *功能：生成找猎头模板
     * 参数：
     * stat：是否显示所属公司
     */
    p:function(){
        var tmp=TEMPLE;
       // var show='';
        var ltemp=tmp.T00040,mtemp,rtemp=tmp.T00060;
//        if(stat==1){
//            show=tmp.T00061;
//        }else{
//            show="";
//        }
        mtemp=tmp.T00057.replace("{show}","");
        return baseController.GenBListTemp(ltemp,mtemp,rtemp);
    },
    /*
     * 功能：获取可委托职位列表成功
     * 参数：
     * data：后台返回数据
     */
    q:function(data){
        var dt=data.data;
        baseRender.al("cd_resume", true, "确定" ,EIndexController.n);
        var ct=$("#cd_resume").find("div.content");
        if(ct.html()==""){
            ct.html("<ul class='hgstemp' id='cdres_list'></ul>");
        }
        var tmp='<li jid="{id}"><input type="radio" name="sjob"/><span class="red">[{category}]</span><span>{title}</span></li>';
        $.each(dt,function(i,o){
            if(o.category=="1"){
                o.category="全职";
            }
            else{
                o.category="兼职";
            }
        });
        var varr=["id","category","title"];
        HGS.Base.GenTemp("cdres_list",varr,dt,tmp);
        $("#cdres_list").find("li input[name='sjob']:eq(0)").attr("checked","checked");
    },
    /*
     * 功能：显示可委托职位列表失败
     * 参数：
     * data：后台返回数据
     */
    r:function(data){
        alert("对不起，您暂时没有可以委托的职位");
    },
    /*
     * 功能：委托职位成功
     * 参数：
     * data：后台返回数据
     */
    s:function(data){
        alert("职位委托成功!");
        var a=$("#cd_resume");
        a.fadeOut(200);
        if(a.find("#cdres_list li").length==1){
            a.find("a.okbtn").unbind("click");
        }
    },
    /*
     * 功能：委托职位失败
     * 参数：
     * data：后台返回数据
     */
    t:function(data){
        alert(data.data);
        $("#cd_resume").fadeOut(200);
    }
};


