/*
 * 全职职位详细页页面渲染器
 */
var agentdetailRender={
    /*
     * 功能：加关注成功
     * 参数：
     * data：后台返回数据
     */
    a:function(data){
        var that=$("#add_focus");
        var temp=TEMPLE.T00102;
        that.unbind("click");         
        temp=temp.replace('{id}',that.data("uid")).replace('{name}',that.data("uname"));
        that.parent().replaceWith(temp);
        agentdetailController.b();
    },
    /*
     * 功能：加关注失败|投递简历失败
     * 参数：
     * data：后台返回数据
     */
    b:function(data){
        alert(data.data);
    },
    /*
     * 功能：委托简历成功
     * 参数：
     * data：后台返回数据
     */
    c:function(data){
        alert("简历委托成功!");
    },
    /*
     * 功能：委托职位成功
     * 参数：
     * data：后台返回数据
     */
    d:function(data){
        alert("职位委托成功!");
        var a=$("#cd_resume");
        a.fadeOut(200);
        if(a.find("#cdres_list li").length==1){
            a.find("a.okbtn").unbind("click");
        }
    },
    /*
     * 功能：显示可委托职位列表成功
     * 参数：
     * data：后台返回数据
     */
    e:function(data){
        var dt=data.data;
        baseRender.al("cd_resume", true, "确定" ,agentdetailController.f);
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
    f:function(data){
        alert("对不起，您暂时没有可以委托的职位");
    },
    /*
     *人才委托简历成功
     *jack
     *2012-2-14
     */
    g:function(ret){
        alert('委托简历成功',"","","",function(){
            location.reload();
        });
    },
    /*
     *功能：人才委托简历失败
     *jack
     *2012-2-14
     */
    h:function(ret){
        alert(ret.data);
    },
    /*
     *初始化委托简历选框
     *jack
     *2012-2-12
     */
    i:function(){
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
    },
    /*
     * 功能：成功异步获取正在运作的职位列表
     * 参数：
     * data：后台返回数据
     * 修改:joe  2012/7/12
     */
    j:function(data){
        var count=agentdetailRender.m(data);        
        agentdetailRender.oa(1);
        if(count>CONSTANT.C0003)
            agentdetailController.h(count,"#pagination2,#pt2",agentdetailController.j);
    },
    /*
     * 功能：失败异步获取正在运作的职位列表
     * 参数：
     * data：后台返回数据
     */
    k:function(data){
        agentdetailController.h(0,"#pagination2,#pt2",agentdetailController.j);
        $("#runlist1").html("<li class='no-data'>暂无数据!</li>");
    },
    /*
     * 功能：定位到列表顶部
     * 参数：
     * 无
     */
    l:function(){
        $("html,body").animate({
            scrollTop:$("div.layout2_l").offset().top-55
        },500);
    },
    /*
     * 功能：成功异步获取正在运作的职位列表
     * 参数：
     * data：后台返回数据
     */
    m:function(data){
        var dt=data.data;
        var count=data.count;
        var mytmp=[];
        mytmp[0]=agentdetailRender.n("1");//全职 招聘中
        mytmp[1]=agentdetailRender.n("2");//兼职 招聘中
        $.each(dt, function(i,o){
            var type=o.category;
            var certs="";
            if(type=="1"){
                o.temp=0;
                o.pos=o.name;
            }else if(type=="2"){
                o.temp=1;
            }
            if(typeof(o.cert)=="undefined"){
                o.cert=[];
            }
            $.each(o.cert,function(k,item){
                certs+='<p><span class="gray">证书要求: </span><span>'+item+'</span></p>';
            });
            o.cert=certs;
            o.r_class="";
            if(o.salary=="面议"){
                o.face="face";
            }else{
                o.face="";
            }
        });
        var varr=[];
        varr[0]=['cert','company','title','pos','count','location','degree','r_count','date','r_class','salary','id','face'];
        varr[1]=['cert','company','title','place','location','r_count','date','r_class','salary','id','face'];
        HGS.Base.GenMTemp("runlist1",varr,dt,mytmp);
        $("#runlist1").find("p.own").remove();
        $("#runlist1 div.info p.lst_p").removeClass("lst_p");
        $("#runlist1 div.info p:last-child").addClass("lst_p");
        return count;
    },
    /*
     * 功能：生成正在运作的职位列表模板
     * 参数：
     * 无
     */
    n:function(type){
        var tmp=TEMPLE;
        var mtmp='';
        var rtmp=tmp.T00063.replace('<em class="ident_pic {role}"></em>','');
        if(type=="1"){
            mtmp=tmp.T00046;
        }else if(type=="2"){
            mtmp=tmp.T00045;
        }
        return baseController.GenBListTemp(null, mtmp, rtmp);
    },
    /*
     * 功能：成功异步获取正在运作的简历列表
     * 参数：
     * data：后台返回数据
     * 修改:joe  2012/7/12
     */
    o:function(data){
        var count=agentdetailRender.q(data);         
        agentdetailRender.oa(0);
        if(count>CONSTANT.C0003)
        agentdetailController.h(count,"#pagination1,#pt1",agentdetailController.m);
    },
    /*
     * 功能：url定位当前运作的简历|职位
     * 参数：i
     * i：0简历 1职位
     * author:joe  2012/7/12
     */
    oa:function(i){
        var that=agentdetailController;
        var id=that.r();
        var url=location.href;        
        if(!id){
            if(!i)
                location.href=url+"#res";
            else
                location.href=url+"#job";
        }
        that.ra(i);        
    },
    /*
     * 功能：失败异步获取正在运作的简历列表
     * 参数：
     * data：后台返回数据
     */
    p:function(data){
        agentdetailController.h(0,"#pagination1,#pt1",agentdetailController.m);
        $("#runlist").html("<li class='no-data'>暂无数据!</li>");
    },
    /*
     * 功能：成功异步获取正在运作的简历列表
     * 参数：
     * data：后台返回数据
     */
    q:function(data){
        var dt=data.data;
        var count=data.count;
        var mytmp=[];
        mytmp[0]=agentdetailRender.r("1");//全职 招聘中
        mytmp[1]=agentdetailRender.r("2");//兼职 招聘中
        var da=[];
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
            //            certs+='<p><span class="gray">简历投递: </span><span>'+o.send_count+'</span> 次</p>'
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
            //            oitem[myres.u_photo]=o.user_photo;
            oitem[myres.date]=o.pub_date;
            oitem[myres.salary]=o.salary;
            //            oitem[myres.email_auth]=o.is_auth_email;
            //            oitem[myres.phone_auth]=o.is_auth_phone;
            //            oitem[myres.real_auth]=o.is_auth_real;
            oitem[myres.h_id]=o.human_id;
            oitem["reid"]=o.human_id;
            da[i]=oitem;
        });
        var varr=[];
        varr[0]=["reid","url","face",res.h_id,res.rid,res.cert,res.date,res.exp,res.pos,res.location,res.u_name,res.name,res.salary,res.role];
        varr[1]=["reid","url","face",res.h_id,res.rid,res.cert,res.date,res.place,res.u_name,res.name,res.salary,res.role];
        HGS.Base.GenMTemp("runlist",varr,da,mytmp);
        $("#runlist").find("p.own").remove();
        $("#runlist div.info p.lst_p").removeClass("lst_p");
        $("#runlist div.info p:last-child").addClass("lst_p");
        return count;
    },
    /*
     * 功能：生成正在运作的简历列表模板
     * 参数：
     * 无
     */
    r:function(type){
        var tmp=TEMPLE;
        var mtmp='';
        var rtmp=tmp.T00063.replace('<em class="ident_pic {role}"></em>','');
        if(type=="1"){
            mtmp=tmp.T00047.replace("{rid}","").replace('修改于','公开于');//全职
        }else if(type=="2"){
            mtmp=tmp.T00041.replace("{rid}","").replace("投递于","公开于");//兼职
        }
        return baseController.GenBListTemp(null, mtmp, rtmp);
    },
    /*
     * 功能：取消关注成功
     * 参数：
     * 无
     */
    s:function(){
        var that=$("#re_focus");
        var temp=TEMPLE.T00103;          
        temp=temp.replace('{id}',that.data("uid")).replace('{name}',that.data("uname"));
        that.parent().parent().replaceWith(temp);
        agentdetailController.a();
    },
    /*
     * 功能：取消关注失败
     * 参数：
     * 无
     */
    t:function(){
        alert("暂时不能取消关注!")
    },
    /*
     * 功能：赞一下 成功
     * 参数：
     * data：后台返回数据
     */
    u:function(data){
        var that=$($("a.good:eq(0)").data("prise"));
        var num=parseInt(that.next().html(),10)+1;
        $("a.good").next().html(num);
    },
    /*
     * 功能：赞一下 失败
     * 参数：
     * data：后台返回数据
     */
    v:function(data){
        alert('您已经赞过了，请稍后再试.');
    }
};
