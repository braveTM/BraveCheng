/*
 * 猎头职位管理页面渲染器
 */
var jobfullselfRender={
    /*
     * 功能：成功异步获取简历列表
     * 参数：
     * data：后台返回数据
     */
    a:function(data){
        var count=jobfullselfRender.d(data);
        JobfullselfController.b(count,"#pagination",JobfullselfController.d);
        $("#dr_resume").html(" "+count+" ");
    },
    /*
     * 功能：失败异步获取简历列表
     * 参数：
     * data：后台返回数据
     */
    b:function(data){
        JobfullselfController.b(0,"#pagination",JobfullselfController.d);
        $("#reslist").html("<li class='no-data'>暂无数据!</li>");
        $("#dr_resume").html(" 0 ");
    },
    /*
     * 功能：定位到列表顶部
     * 参数：
     * 无
     */
    c:function(){
        $("html,body").animate({
            scrollTop:$("div.res_list").offset().top-55
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
        var mytmp=[];
        mytmp[0]=jobfullselfRender.e("1");//全职
        mytmp[1]=jobfullselfRender.e("2");//兼职
        var rz;
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
            }else{
                o.role="企业";//企业
            }
            if(o.salary=="面议"){
                o.face="face";
            }else{
                o.face="";
            }
            if(typeof(o.cert)=="undefined"){o.cert=[];}
            var len=o.cert.length;
            $.each(o.cert,function(k,item){
                certs+='<p><span class="gray">证书情况: </span><span>'+item+'</span></p>';
            });
            o.cert=certs;
            o.u_name=o.name;
            o.u_photo=o.photo;
            o.rid=o.send_resume_id;
            o.focus_id=o.user_id;
            o.reid=o.send_resume_id;
            rz=baseRender.zh(o.real_auth,o.phone_auth,o.email_auth);
            o.email_auth=rz.mil;
            o.phone_auth=rz.pho;
            o.real_auth=rz.nam;
            o.ntitle=rz.tnam;
            o.ptitle=rz.tpho;
            o.mtitle=rz.tmil; 
            
        });
        var varr=[];
        varr[0]=["reid","focus_id","h_id","rid","cert","date","exp","follow","u_name","h_name","u_photo","salary","face","role",'email_auth','phone_auth','real_auth',"ntitle","ptitle","mtitle","pos","location"];
        varr[1]=["reid","focus_id","h_id","rid","cert","date","follow","place","u_name","h_name","u_photo","salary","face","role",'email_auth','phone_auth','real_auth',"ntitle","ptitle","mtitle"];
        HGS.Base.GenMTemp("reslist",varr,dt,mytmp);
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
        var wu=SWEBURL;
        var ou=wu.ResumeDetail;
        var nu=wu.SResumeDetail;
        ltmp=tmp.T00040;
        rtmp=tmp.T00062.replace(ou,nu);//右侧
        if(type=="1"){
            mtmp=tmp.T00042.replace(ou,nu);//全职
        }else{
            mtmp=tmp.T00041.replace(ou,nu);//兼职
        }
        return baseController.GenBListTemp(ltmp, mtmp, rtmp);
    },
//    /*
//     * 功能：初始化翻页插件
//     * 参数：
//     * id：绑定父容器id
//     */
//    f:function(id,count,cur_page){
//        var pages=count/6;
//        var bl=true;
//        if(cur_page<=pages&&cur_page>0){
//            $(id).find("div.pagination span.num").html(cur_page);
//            $(id).find("div.pagination a").removeClass("unclick");
//            if(cur_page==1){
//                $(id).find("a.prev").addClass("unclick");
//            }
//            if(cur_page<=pages&&pages==0||cur_page==pages){
//                $(id).find("a.next").addClass("unclick");
//            }
//        }
//        else{
//            bl=false;
//        }
//        return bl;
//    }
    /*
     * 功能：结束招聘成功
     * 参数：
     * data：后台返回数据
     */
    f:function(data){
        var that=$("#closejob");
        that.parent().parent().css("visibility","hidden");
        that.unbind("click");
        var date=jobfullselfRender.h();
        $("#fullid").next().html('(招聘结束于 '+date+')');
        $("html,body").animate({
            scrollTop:$("body").offset().top
        },500);
    },
    /*
     * 功能：结束招聘失败
     * 参数：
     * data：后台返回数据
     */
    g:function(data){
        alert(data.data);
    },
    /*
     * 功能：获取当前日期
     * 参数：
     *
     */
    h:function(){
        var mydate = new Date();
        var month=mydate.getMonth()+1;
        var day=mydate.getDate();
        month=(month<10?"0"+month:month);
        day=(day<10?"0"+day:day);
        var date=mydate.getFullYear()+"-"+month+"-"+day;
        return date;
    },
     /*
     * 功能：获取联系方式成功
     * 参数：
     * data：后台返回数据
     */
    i:function(data){
        var dt=data.data;
        $("#ckcontact").parent().remove();
        $("#phone").text(dt.phone);       
        $("#email").text(dt.email);        
        $("#cont_way").slideDown(200);
    },
    /*
     * 功能：获取联系方式失败|投递简历失败
     * 参数：
     * data：后台返回数据
     */
    j:function(data){
        if(data.data=="YEBZ0001"){
            paytipController.NoScore();
        }else{
            alert(data.data);
        }
    }
};
