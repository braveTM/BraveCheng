/*
 * 猎头人才管理页面渲染器
 */
var tmanageRender={
    /*
     * 功能：成功异步获取猎头委托来的简历列表
     * 参数：
     * data：后台返回数据
     */
    h:function(data){
        var count=tmanageRender.j(data);
        TManageController.p(count,"#pagination1",TManageController.n);
    },
    /*
     * 功能：失败异步获取猎头委托来的简历列表
     * 参数：
     * data：后台返回数据
     */
    i:function(data){
        TManageController.p(0,"#pagination1",TManageController.n);
        $("#atlist").html("<li class='no-data'>暂无数据!</li>");
    },
    /*
     * 功能：成功异步获取猎头委托来的简历列表
     * 参数：
     * data：后台返回数据
     */
    j:function(data){
        var dt=data.data;
        var count=data.count;
        var mytmp=[];
        var rz;
        mytmp[0]=tmanageRender.l("1","1");//全职 公开简历
        mytmp[1]=tmanageRender.l("1","2");//全职 结束求职
        mytmp[2]=tmanageRender.l("2","1");//兼职 公开简历
        mytmp[3]=tmanageRender.l("2","2");//兼职 结束求职
        mytmp[4]=tmanageRender.l("1","3");//全职 已完成
        mytmp[5]=tmanageRender.l("1","4");//全职 已终止
        mytmp[6]=tmanageRender.l("1","5");//全职 未查看
        mytmp[7]=tmanageRender.l("2","3");//兼职 已完成
        mytmp[8]=tmanageRender.l("2","4");//兼职 已终止
        mytmp[9]=tmanageRender.l("2","5");//兼职 未查看
        var da=[];
        var res=new Resume();
        $.each(dt, function(i,o){
            var myres=res;
            var oitem={};//单条数据临时存储对象
            var certs='';
            var type=o.job_category;
            var status=o.status;
            if(type=="1"&&status=="1"){
                oitem["temp"]=0;
            }else if(type=="1"&&status=="2"){
                oitem["temp"]=1;
            }else if(type=="2"&&status=="1"){
                oitem["temp"]=2;
            }else if(type=="2"&&status=="2"){
                oitem["temp"]=3;
            }else if(type=="1"&&status=="3"){
                oitem["temp"]=4;
            }else if(type=="1"&&status=="4"){
                oitem["temp"]=5;
            }else if(type=="1"&&status=="5"){
                oitem["temp"]=6;
            }else if(type=="2"&&status=="3"){
                oitem["temp"]=7;
            }else if(type=="2"&&status=="4"){
                oitem["temp"]=8;
            }else if(type=="2"&&status=="5"){
                oitem["temp"]=9;
            }
            else{
                oitem["temp"]=0;
            }
            if(typeof(o.RC_list)=="undefined"){
                o.RC_list=[];
            }
            var len=o.RC_list.length;
            $.each(o.RC_list,function(k,item){
                if(k<len-1){
                    certs+='<p><span class="gray">证书情况: </span><span>'+item+'</span></p>';
                }else{
                    certs+='<p class="lst_p"><span class="gray">证书情况: </span><span>'+item+'</span></p>';
                }
            });
            if(o.send_count==0){
                certs+='<p class="lst_p"><span class="gray">投递次数: </span><span>'+o.send_count+'</span> 次</p>';
            }else{
                certs+='<p class="lst_p"><span class="gray">投递次数: </span><span class="red">'+o.send_count+'</span> 次</p>';
            }
             if(o.main_role=="3"){
                oitem[myres.h]="猎头";//猎头
            }else if(o.main_role=="1"){
                oitem[myres.role]="人才";//人才
            }
            //全职
            if(type=="1"){
                oitem[myres.exp]=o.work_exp;
                oitem[myres.pos]=o.job_name;
                oitem[myres.location]=o.job_addr;
            }
            else{
                oitem[myres.place]=o.register_place;//兼职
            }
            if(o.promote=="1"){
                oitem["promote"]="promote";
                oitem["pname"]="已推广";
            }else{
                 oitem["promote"]="";
                 oitem["pname"]="立即推广";
            }
            if(o.salary=="面议"){
                oitem["face"]="face";
            }else{
                oitem["face"]="";
            }
            //公有
            oitem[myres.rid]=o.resume_id;
            oitem[myres.cert]=certs;
            oitem[myres.follow]="";
            oitem[myres.u_name]=o.name;
            oitem[myres.name]=o.rname;
            oitem[myres.u_photo]=o.user_photo;
            oitem[myres.date]=o.delegate_datetime;
            oitem[myres.salary]=o.salary;           
            rz=baseRender.zh(o.real_auth,o.phone_auth,o.email_auth);
            oitem[myres.email_auth]=rz.mil;
            oitem[myres.phone_auth]=rz.pho;
            oitem[myres.real_auth]=rz.nam;
            oitem["ntitle"]=rz.tnam;
            oitem["ptitle"]=rz.tpho;
            oitem["mtitle"]=rz.tmil;  
            oitem[myres.h_id]=o.human_id;
            oitem["focus_id"]=o.user_id;
            oitem["reid"]=o.delegate_resume_id;
            oitem["send_resume_id"]=o.delegate_resume_id;
            da[i]=oitem;
        });
        var varr=[];
        varr[0]=["send_resume_id","reid","focus_id","pname","promote","face","ntitle","ptitle","mtitle","ntitle","ptitle","mtitle",res.h_id,res.rid,res.cert,res.date,res.exp,res.follow,res.pos,res.location,res.u_name,res.name,res.u_photo,res.salary,res.role,res.email_auth,res.phone_auth,res.real_auth];
        varr[1]=varr[0];
        varr[2]=["send_resume_id","reid","focus_id","pname","promote","face","ntitle","ptitle","mtitle","ntitle","ptitle","mtitle",res.h_id,res.rid,res.cert,res.date,res.follow,res.place,res.u_name,res.name,res.u_photo,res.salary,res.role,res.email_auth,res.phone_auth,res.real_auth];
        varr[3]=varr[2];
        varr[4]=varr[0];
        varr[5]=varr[0];
        varr[6]=varr[0];
        varr[7]=varr[2];
        varr[8]=varr[2];
        varr[9]=varr[2];
        HGS.Base.GenMTemp("atlist",varr,da,mytmp);
        $("#atlist div.info p.lst_p").removeClass("lst_p");
        $("#atlist div.info p:last-child").addClass("lst_p");
        var that=TManageController;
        that.v($("#atlist a.uoper"));
        that.w($("#atlist a.closejob"));
        that.aj();
        that.am();
        that.an();
        return count;
    },
    /*
     * 功能：定位到列表顶部
     * 参数：
     * 无
     */
    k:function(){
        $("html,body").animate({
            scrollTop:$("body").offset().top
        },500);
    },
    /*
     * 功能：生成猎头委托来的简历列表模板
     * 参数：
     * 无
     */
    l:function(type, status){
        var tmp=TEMPLE;
        var ltmp='';
        var mtmp='';
        var rtmp='';
        ltmp=tmp.T00040;
        var wu=SWEBURL;
        var ou=wu.ResumeDetail;
        var nu=wu.DResumeDetail;
        if(type=="1"&&status=="1"){
            mtmp=tmp.T00047.replace(ou,nu);//全职
            rtmp=tmp.T00080.replace("{class}","uoper").replace("{txt}","立即公开求职");//右侧
            rtmp=tmp.T00083+rtmp;
        }else if(type=="1"&&status=="2"){
            mtmp=tmp.T00047.replace(ou,nu);//全职
            rtmp=tmp.T00080.replace("{class}","closejob").replace("{txt}","立即结束求职");//右侧
            rtmp=tmp.T00083+rtmp;
        }else if(type=="2"&&status=="1"){
            mtmp=tmp.T00041.replace("投递","修改").replace(ou,nu);//兼职
            rtmp=tmp.T00080.replace("{class}","uoper").replace("{txt}","立即公开求职");//右侧
            rtmp=tmp.T00083+rtmp;
        }else if(type=="2"&&status=="2"){
            mtmp=tmp.T00041.replace("投递","修改").replace(ou,nu);//兼职
            rtmp=tmp.T00080.replace("{class}","closejob").replace("{txt}","立即结束求职");//右侧
            rtmp=tmp.T00083+rtmp;
        }else if(type=="1"&&status=="3"){
            mtmp=tmp.T00047.replace(ou,nu);//全职
            rtmp=tmp.T00036;//已完成
        }else if(type=="1"&&status=="4"){
            mtmp=tmp.T00047.replace(ou,nu);//全职
            rtmp=tmp.T00036.replace("已完成","已终止");//被终止
        }else if(type=="1"&&status=="5"){
            mtmp=tmp.T00047.replace(ou,nu);//全职
            rtmp=tmp.T00082.replace("{id}","{rid}");//未查看
        }else if(type=="2"&&status=="3"){
            mtmp=tmp.T00041.replace("投递","修改").replace(ou,nu);//兼职
            rtmp=tmp.T00036;//已完成
        }else if(type=="2"&&status=="4"){
            mtmp=tmp.T00041.replace("投递","修改").replace(ou,nu);//兼职
            rtmp=tmp.T00036.replace("已完成","已终止");//被终止
        }else if(type=="2"&&status=="5"){
            mtmp=tmp.T00041.replace("投递","修改").replace(ou,nu);//兼职
            rtmp=tmp.T00082.replace("{id}","{rid}");//未查看
        }
        mtmp=mtmp.replace('修改于','委托于');
        return baseController.GenBListTemp(ltmp, mtmp, rtmp);
    },
    /*
     * 功能：成功异步我可能感兴趣的简历列表
     * 参数：
     * data：后台返回数据
     */
    m:function(data){
        var count=tmanageRender.o(data);
        TManageController.p(count,"#pagination3",TManageController.s);
    },
    /*
     * 功能：失败异步获取我可能感兴趣的简历列表
     * 参数：
     * data：后台返回数据
     */
    n:function(data){
        TManageController.p(0,"#pagination3",TManageController.s);
        $("#iatlist").html("<li class='no-data'>暂无数据!</li>");
    },
    /*
     * 功能：成功异步获我可能感兴趣的简历列表
     * 参数：
     * data：后台返回数据
     */
    o:function(data){
        var dt=data.data;
        var count=data.count;
        var mytmp=[];
        mytmp[0]=tmanageRender.p("1");//全职
        mytmp[1]=tmanageRender.p("2");//兼职
        var da=[];
        var rz;
        var res=new Resume();
        $.each(dt, function(i,o){
            var myres=res;
            var oitem={};//单条数据临时存储对象
            var certs='';
            var type=o.job_category;
            if(type=="1"){
                oitem["temp"]=0;
            }else if(type=="2"){
                oitem["temp"]=1;
            }
            if(o.publisher_role=="3"){
                oitem[myres.role]="猎头";//猎头
            }else if(o.publisher_role=="1"){
                oitem[myres.role]="人才";//人才
            }
            if(typeof(o.RC_list)=="undefined"){
                o.RC_list=[];
            }
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
            oitem[myres.email_auth]=rz.mil;
            oitem[myres.phone_auth]=rz.pho;
            oitem[myres.real_auth]=rz.nam;
            oitem["ntitle"]=rz.tnam;
            oitem["ptitle"]=rz.tpho;
            oitem["mtitle"]=rz.tmil;            
            oitem[myres.rid]=o.resume_id;
            oitem[myres.h_id]=o.human_id;
            oitem["focus_id"]=o.publisher_id;
            oitem["reid"]=o.human_id;
            oitem["send_resume_id"]="";
            da[i]=oitem;
        });
        var varr=[];
        varr[0]=["send_resume_id","reid","focus_id","face","ntitle","ptitle","mtitle","ntitle","ptitle","mtitle",res.h_id,res.rid,res.cert,res.date,res.exp,res.follow,res.pos,res.location,res.u_name,res.name,res.u_photo,res.salary,res.role,res.email_auth,res.phone_auth,res.real_auth];
        varr[1]=["send_resume_id","reid","focus_id","face","ntitle","ptitle","mtitle","ntitle","ptitle","mtitle",res.h_id,res.rid,res.cert,res.date,res.follow,res.place,res.u_name,res.name,res.u_photo,res.salary,res.role,res.email_auth,res.phone_auth,res.real_auth];
        HGS.Base.GenMTemp("iatlist",varr,da,mytmp);
        TManageController.x();
        return count;
    },   
    /*
     * 功能：生成我可能感兴趣的简历列表模板
     * 参数：
     * 无
     */
    p:function(type){
        var tmp=TEMPLE;
        var ltmp='';
        var mtmp='';
        var rtmp='';
        ltmp=tmp.T00040;
        rtmp=tmp.T00043.replace("查看","邀请");//右侧
        if(type=="1"){
            mtmp=tmp.T00047;//全职
        }else if(type=="2"){
            mtmp=tmp.T00041.replace("投递","修改");//兼职
        }
        return baseController.GenBListTemp(ltmp, mtmp, rtmp);
    },
    /*
     * 功能：立即公开求职页面效果
     * 参数：
     * 无
     */
    q:function(){
        var that=$("#atlist").data("cur").find("a.uoper");
        that.text("立即结束求职").removeClass("uoper").addClass("closejob");
        TManageController.w(that);
    },
    /*
     * 功能：公开求职成功
     * 参数：
     * data：后台返回数据
     */
    r:function(data){
        alert("公开求职成功!");
    },
    /*
     * 功能：公开求职失败
     * 参数：
     * data：后台返回数据
     */
    s:function(data){
        alert(data.data);
    },
    /*
     * 功能：结束求职成功
     * 参数：
     * data：后台返回数据
     */
    t:function(data){
        alert("结束求职成功!");
    },
    /*
     * 功能：立即结束求职页面效果
     * 参数：
     * obj：当前a标签
     */
    u:function(obj){
        var that=$(obj);
        that.text("立即公开求职").removeClass("closejob").addClass("uoper");
        TManageController.v(obj);
    },
    /*
     *获取应聘来的简历成功
     *jack
     *2012-2-17
     */
    as:function(data){
        var count=tmanageRender.bs(data);
        TManageController.p(count,"#pagination6",TManageController.ac);
    },
    /*
     *获取应聘来的简历失败
     *jack
     *2012-2-17
     */
    af:function(ret){
        TManageController.p(0,"#pagination6",TManageController.ac);
        $("#applied_resume").html("<li class='no-data'>暂无数据!</li>");
    },
    /*
     * 功能：成功异步获取应聘来的简历列表
     * 参数：
     * data：后台返回数据
     */
    bs:function(data){
        var dt=data.data;
        var count=data.count;
        var mytmp=[];
        var rz;
        mytmp[0]=tmanageRender.bf("1","1");//全职 未查看
        mytmp[1]=tmanageRender.bf("1","2");//全职 已查看
        mytmp[2]=tmanageRender.bf("2","1");//兼职 未查看
        mytmp[3]=tmanageRender.bf("2","2");//兼职 已查看
        var da=[];
        var res=new Resume();
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
            }else if(type=="2"&&status=="2"){
                oitem["temp"]=3;
            }
            else{
                oitem["temp"]=0;
            }
            if(typeof(o.RC_list)=="undefined"){
                o.RC_list=[];
            }
            if(o.sender_role=="3"){
                oitem[myres.role]="猎头";//猎头
            }else if(o.sender_role=="1"){
                oitem[myres.role]="人才";//人才
            }
            var len=o.RC_list.length;
            $.each(o.RC_list,function(k,item){
                if(k<len-1){
                    certs+='<p><span class="gray">证书情况: </span><span>'+item+'</span></p>';
                }else{
                    certs+='<p><span class="gray">证书情况: </span><span>'+item+'</span></p>';
                }
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
            oitem[myres.email_auth]=rz.mil;
            oitem[myres.phone_auth]=rz.pho;
            oitem[myres.real_auth]=rz.nam;
            oitem["ntitle"]=rz.tnam;
            oitem["ptitle"]=rz.tpho;
            oitem["mtitle"]=rz.tmil;              
            oitem[myres.h_id]=o.human_id;
            oitem[myres.send_resume_id]=o.send_resume_id;
            oitem["focus_id"]=o.sender_id;
            oitem["reid"]=o.send_resume_id;
            da[i]=oitem;
        });
        var varr=[];
        varr[0]=['reid','focus_id',"face","ntitle","ptitle","mtitle","ntitle","ptitle","mtitle",res.h_id,res.rid,res.cert,res.date,res.exp,res.follow,res.pos,res.location,res.u_name,res.name,res.u_photo,res.salary,res.role,res.email_auth,res.phone_auth,res.real_auth,res.send_resume_id];
        varr[1]=['reid','focus_id',"face","ntitle","ptitle","mtitle","ntitle","ptitle","mtitle",res.h_id,res.rid,res.cert,res.date,res.exp,res.follow,res.pos,res.location,res.u_name,res.name,res.u_photo,res.salary,res.role,res.email_auth,res.phone_auth,res.real_auth,res.send_resume_id];
        varr[2]=['reid','focus_id',"face","ntitle","ptitle","mtitle","ntitle","ptitle","mtitle",res.h_id,res.rid,res.cert,res.date,res.follow,res.place,res.u_name,res.name,res.u_photo,res.salary,res.role,res.email_auth,res.phone_auth,res.real_auth,res.send_resume_id];
        varr[3]=['reid','focus_id',"face","ntitle","ptitle","mtitle","ntitle","ptitle","mtitle",res.h_id,res.rid,res.cert,res.date,res.follow,res.place,res.u_name,res.name,res.u_photo,res.salary,res.role,res.email_auth,res.phone_auth,res.real_auth,res.send_resume_id];
        HGS.Base.GenMTemp("applied_resume",varr,da,mytmp);
        $("#applied_resume div.info p:last-child").addClass("lst_p");
        var obj=$("#applied_resume a.chec_now,#applied_resume a.jtitle");
        TManageController.ai(obj);
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
    bf:function(type,status){
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
            rtmp=rtmp.replace('<a href="javascript:;" class="btn white uoper">查看简历</a>','<a href="'+SWEBURL.SResumeDetail+'/{reid}" title="立即查看" target="_blank" class="btn white chec_now">立即查看</a>');
        }else if(type=="1"&&status=="2"){
            mtmp=tmp.T00047.replace(ou,nu);
            rtmp=rtmp.replace('<div class="btn_common lbtn btn22"><span class="b_lf"></span><span class="b_rf"></span><a href="javascript:;" class="btn white uoper">查看简历</a></div>','<span class="gray">已查看</span>');
        }else if(type=="2"&&status=="1"){
            mtmp=tmp.T00041.replace(ou,nu);//兼职
            rtmp=rtmp.replace('<a href="javascript:;" class="btn white uoper">查看简历</a>','<a href="'+SWEBURL.SResumeDetail+'/{reid}" title="立即查看" target="_blank" class="btn white chec_now">立即查看</a>');
        }else if(type=="2"&&status=="2"){
            mtmp=tmp.T00041.replace(ou,nu);//兼职
            rtmp=rtmp.replace('<div class="btn_common lbtn btn22"><span class="b_lf"></span><span class="b_rf"></span><a href="javascript:;" class="btn white uoper">查看简历</a></div>','<span class="gray">已查看</span>');
        }
        mtmp=mtmp.replace('修改于','投递于');
        return baseController.GenBListTemp(ltmp, mtmp, rtmp);
    },
    /*
    *查看应聘来的简历点击处理/查看应聘来的简历成功
    *参数：无
    *jack
    *2012-2-18
    */
    c_s:function(){
        var obj=$("ul#applied_resume").data("obj");
        if(obj.length)
            obj.replaceWith("<span class='gray'>已查看</span>");
    },
    /*
    *查看应聘来的简历成功
    *参数：无
    *jack
    *2012-2-18
    */
//    t_s:function(ret){
//        location.href=$("ul#applied_resume").data("rurl");
//    },
    /*
    *查看应聘来的简历失败
    *参数：无
    *jack
    *2012-2-18
    */
    c_f:function(ret){
        alert(ret.data);
    },
    /*
    *功能：异步获取我添加的简历列表成功
    *参数：无
    *jack
    *2012-2-20
    */
    get_aded_suc:function(ret){
        var count=tmanageRender.gen_aded_list(ret);
        TManageController.p(count,"#pagination5",TManageController.page_call_aded);
    },
    /*
    *功能：异步获取我添加的简历列表失败
    *jack
    *2012-2-20
    */
    get_aded_fail:function(){
        TManageController.p(0,"#pagination5",TManageController.page_call_aded);
        $("#added_resume").html("<li class='no-data'>暂无数据!</li>");
    },
    /*
    *功能：异步获取返回的我添加的列表数据
    *jack
    *2012-20
    */
    gen_aded_list:function(data){
        var dt=data.data;
        var count=data.count;
        var mytmp=[];
        mytmp[0]=tmanageRender.aded_status("1","1");//全职 公开简历
        mytmp[1]=tmanageRender.aded_status("1","2");//全职 结束求职
        mytmp[2]=tmanageRender.aded_status("2","1");//兼职 公开简历
        mytmp[3]=tmanageRender.aded_status("2","2");//兼职 结束求职
        var da=[];
        var res=new Resume();
        $.each(dt, function(i,o){
            var myres=res;
            var oitem={};//单条数据临时存储对象
            var certs='';
            var type=o.job_category;
            var status=o.status;
            if(type=="1"&&status=="1"){
                oitem["temp"]=0;
            }else if(type=="1"&&status=="2"){
                oitem["temp"]=1;
            }else if(type=="2"&&status=="1"){
                oitem["temp"]=2;
            }else if(type=="2"&&status=="2"){
                oitem["temp"]=3;
            }
            else{
                oitem["temp"]=0;
            }
            if(typeof(o.RC_list)=="undefined"){
                o.RC_list=[];
            }
            var len=o.RC_list.length;
            $.each(o.RC_list,function(k,item){
                if(k<len-1){
                    certs+='<p><span class="gray">证书情况: </span><span>'+item+'</span></p>';
                }else{
                    certs+='<p class="lst_p"><span class="gray">证书情况: </span><span>'+item+'</span></p>';
                }
            });
            if(o.send_count>0){
                certs+='<p><span class="gray">简历投递: </span><span class="red">'+o.send_count+'</span> 次</p>'
            }
            else{
                certs+='<p><span class="gray">简历投递: </span><span>'+o.send_count+'</span> 次</p>'
            }
            //全职
            if(type=="1"){
                oitem[myres.exp]=o.work_exp;
                oitem[myres.pos]=o.job_name;
                oitem[myres.location]=o.job_addr;
                oitem["url"]=SWEBURL.AFResume+o.human_id;
            }
            else{
                oitem[myres.place]=o.register_place;//兼职
                oitem["url"]=SWEBURL.APResume+o.human_id;
            }
             if(o.promote=="1"){
                oitem["promote"]="promote";
                oitem["pname"]="已推广";
            }else{
                 oitem["promote"]="";
                 oitem["pname"]="立即推广";
            }
            if(o.salary=="面议"){
                oitem["face"]="face";
            }else{
                oitem["face"]="";
            }
            //公有
            oitem[myres.rid]=o.resume_id;
            oitem[myres.role]="";
            oitem[myres.cert]=certs;
            oitem[myres.follow]="";
            oitem[myres.u_name]=o.name;
            oitem[myres.name]=o.name;
            oitem[myres.u_photo]=o.user_photo;
            oitem[myres.date]=o.delegate_datetime;
            oitem[myres.salary]=o.salary;
            oitem[myres.email_auth]=o.is_auth_email;
            oitem[myres.phone_auth]=o.is_auth_phone;
            oitem[myres.real_auth]=o.is_auth_real;
            oitem[myres.h_id]=o.human_id;
            oitem["reid"]=o.human_id;;
            oitem["send_resume_id"]="";
            da[i]=oitem;
        });
        var varr=[];
        varr[0]=["send_resume_id","reid","url","pname","promote","face",res.h_id,res.rid,res.cert,res.date,res.exp,res.follow,res.pos,res.location,res.u_name,res.name,res.u_photo,res.salary,res.role,res.email_auth,res.phone_auth,res.real_auth];
        varr[1]=["send_resume_id","reid","url","pname","promote","face",res.h_id,res.rid,res.cert,res.date,res.exp,res.follow,res.pos,res.location,res.u_name,res.name,res.u_photo,res.salary,res.role,res.email_auth,res.phone_auth,res.real_auth];
        varr[2]=["send_resume_id","reid","url","pname","promote","face",res.h_id,res.rid,res.cert,res.date,res.follow,res.place,res.u_name,res.name,res.u_photo,res.salary,res.role,res.email_auth,res.phone_auth,res.real_auth];
        varr[3]=["send_resume_id","reid","url","pname","promote","face",res.h_id,res.rid,res.cert,res.date,res.follow,res.place,res.u_name,res.name,res.u_photo,res.salary,res.role,res.email_auth,res.phone_auth,res.real_auth];
        HGS.Base.GenMTemp("added_resume",varr,da,mytmp);
        $("#added_resume p.lst_p").removeClass("lst_p");
        $("#added_resume p.own").remove();
        $("#added_resume div.info p:last-child").addClass("lst_p");
        var that=TManageController;
        that.v($("#added_resume a.uoper"));
        that.w($("#added_resume a.closejob"));
        that.deleAdedresm();
        that.ak();
        return count;
    },
    /*
    *我添加的简历 状态值判定
    *jack
    *2012-2-20
    */
    aded_status:function(type, status){
        var tmp=TEMPLE;
        var mtmp='';
        var rtmp=tmp.T00081;
        if(type=="1"&&status=="1"){
            mtmp=tmp.T00047.replace("投递于","创建于");//全职
            rtmp+=tmp.T00080.replace("{class}","uoper").replace("{txt}","立即公开求职");//右侧
        }else if(type=="1"&&status=="2"){
            mtmp=tmp.T00047.replace("投递于","创建于");//全职
            rtmp+=tmp.T00080.replace("{class}","closejob").replace("{txt}","立即结束求职");//右侧
        }else if(type=="2"&&status=="1"){
            mtmp=tmp.T00041.replace("投递于","创建于");//兼职
            rtmp+=tmp.T00080.replace("{class}","uoper").replace("{txt}","立即公开求职");//右侧
        }else if(type=="2"&&status=="2"){
            mtmp=tmp.T00041.replace("投递于","创建于");//兼职
            rtmp+=tmp.T00080.replace("{class}","closejob").replace("{txt}","立即结束求职");//右侧
        }
        mtmp=mtmp.replace('修改于','创建于').replace('委托于','创建于');
        return baseController.GenBListTemp(null, mtmp, rtmp);
    },
    /*
     * 功能：完成求职 成功
     * 参数：
     * data：后台返回数据
     */
    bh:function(data){
        var cid=$("#atlist").data("comid");
        var cur=$("#atlist li div.oper a.comp[rid='"+cid+"']");
        cur.parent().html(TEMPLE.T00036);
    },
    /*
     * 功能：完成求职 失败
     * 参数：
     * data：后台返回数据
     */
    bi:function(data){
        alert(data.data);
    },
    /*
     * 功能：查看简历详细成功
     * 参数：
     * data：后台返回数据
     */
    bj:function(data){
        var id=$("#atlist").data("hid");
        var cur=$("#atlist").find("div.oper a.ckjdetail[jid='"+id+"']");
        var url=cur.parent().parent().prev().find("a.jtitle").attr("href");
        location.href=url;
    },
    /*
     * 功能：查看简历详细失败
     * 参数：
     * data：后台返回数据
     */
    bk:function(data){
        alert(data.data);
    },
    /*
     *功能：删除猎头添加的简历成功执行
     *参数：无
     *jack
     *2012-3-7
     */
    cs:function(){
        var obj=$("div").data("obj");
        $(obj).slideUp(200);
        var page=parseInt($("#pagination5").find("span.current").not("span.prev,span.next").text(),10);
        page=page-1;
        var that=TManageController;
        if($("ul#focus_person li").length=="0"){
            page=0;
            that.get_aded(0);
        }else{
           that.get_aded(page);
       }
    },
     /*
     *功能：删除猎头添加的简历失败
     *参数：无
     *jack
     *2012-3-7
     */
    cf:function(ret){
        alert(ret.data);
    }
};
