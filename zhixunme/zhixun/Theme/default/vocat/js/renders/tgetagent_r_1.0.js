var tgetAgentRender={
    /*
     *功能：选择省份城市回调函数
     *jack
     *2012-2-12
     */
    a:function(data){
        var txt="";
        var pro=data.prov;
        var city=data.city;
        if(data.nolmt){
            txt=data.noname;
            pro="0";
            city="0";
        }
        else{
            txt=data.provname+"-"+data.cityname;
            pro=data.prov;
            city=data.city;
        }
        $("div.tfagent input[name='prov_id']").val(pro);
        $("div.tfagent input[name='city_id']").val(city);
        $("div.tfagent #from_area").val(txt);
        TanGetAgentController.b(0);
        baseRender.b("#from_area");
    },
    /*
     * 功能：成功异步获取委托来的职位列表
     * 绑定分页插件
     * 参数：
     * data：后台返回数据
     */
    b:function(data){
        var count=tgetAgentRender.d(data);
        TanGetAgentController.a(count,"#pagination1",TanGetAgentController.c);
    },
    /*
     * 功能：失败异步获取委托来的职位列表
     * 参数：
     * data：后台返回数据
     */
    c:function(data){
        TanGetAgentController.a(0,"#pagination1",TanGetAgentController.c);
        $("div.tfagent #agent_list").html("<li class='no-data'>暂无数据!</li>");
    },
    /*
     * 功能：成功异步获取猎头列表
     * 参数：
     * data：后台返回数据
     */
    d:function(ret){
        var count=ret.count;
        var data=ret.data;
        var mytmp=[];
        var rz;
        mytmp[0]=tgetAgentRender.f("1");//显示所属企业名称
        mytmp[1]=tgetAgentRender.f("2");//不显示所属企业名称
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
        var varr=[];
        varr[0]=['focus_id','user_id','u_photo','u_name','follow','real_auth','email_auth','phone_auth','agent_introduce','addr_province_code','addr_city_code','company_name','activity',"ntitle","ptitle","mtitle"];
        varr[1]=['focus_id','user_id','u_photo','u_name','follow','real_auth','email_auth','phone_auth','agent_introduce','addr_province_code','addr_city_code','company_name','activity',"ntitle","ptitle","mtitle"];
        HGS.Base.GenMTemp("agent_list",varr,data,mytmp);
        $("div.tfagent #agent_list a.degate_reu").bind("click",function(){
            TanGetAgentController.g(this);
        });
        return count;
    },
    /*
     *生成找猎头模板
     *2012-2-12
     */
    f:function(stat){
        var tmp=TEMPLE;
        var show='';
        var ltemp=tmp.T00040,mtemp,rtemp=tmp.T00055;
//        if(stat==1){
//            show=tmp.T00056;
//        }else{
//            show="";
//        }
//        mtemp=tmp.T00053.replace("{show}",show);
          mtemp=tmp.T00053.replace("{show}","");
        return baseController.GenBListTemp(ltemp,mtemp,rtemp);
    },
    /*
     *功能：委托简历成功
     *参数：无
     */
    app_succ:function(){
        var type=$("div").data("type");
        alert('简历委托成功',"","","",function(){
            if(type==2){
                location.href=WEBROOT+"/resume/";
            }else{
                location.href=WEBROOT+"/resume/1";
            }
        });
    },
    /*
     *功能：委托简历失败
     *参数：无
     */
    app_fail:function(ret){
        alert(ret.data);
    },
    /*
     *初始化委托简历选框
     *jack
     *2012-2-12
     */
    g:function(){
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
     * 功能：定位到列表顶部
     * 参数：
     * 无
     */
    h:function(){
        $("html,body").animate({
            scrollTop:$("body").offset().top-60
        },500);
    }
};


