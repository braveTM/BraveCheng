/*企业找猎头页面渲染*/
var engetAgentRender ={
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
        $("input[name='e_prov']").val(pro);
        $("input[name='e_city']").val(city);
        $("#from_area").val(txt);
        EnterGetAgentController.b(0);
        baseRender.b("#from_area");
    },
    /*
     * 功能：成功异步获取委托来的职位列表
     * 绑定分页插件
     * 参数：
     * data：后台返回数据
     */
    b:function(data){
        var count=engetAgentRender.d(data);
        EnterGetAgentController.a(count,"#pagination1",EnterGetAgentController.c);
    },
    /*
     * 功能：失败异步获取委托来的职位列表
     * 参数：
     * data：后台返回数据
     */
    c:function(data){
        EnterGetAgentController.a(0,"#pagination1",EnterGetAgentController.c);
        $("div.efagent #e_agent_list").empty();
        $("div.efagent #e_agent_list").html("<li class='no-data'>暂无数据!</li>");
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
        mytmp[0]=engetAgentRender.f("1");//显示所属企业名称
        mytmp[1]=engetAgentRender.f("2");//不显示所属企业名称
        $.each(data,function(i,o){
            var service='';
            if(o.company_name!=""){
                o.temp=0;
            }else{
                o.temp=1;
            }
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
        var varr=[];
        varr[0]=["focus_id",'user_id','u_photo','u_name','follow','real_auth','email_auth','phone_auth','agent_introduce','addr_province_code','addr_city_code','company_name','activity',"ntitle","ptitle","mtitle"];
        varr[1]=["focus_id",'user_id','u_photo','u_name','follow','real_auth','email_auth','phone_auth','agent_introduce','addr_province_code','addr_city_code','company_name','activity',"ntitle","ptitle","mtitle"];
        HGS.Base.GenMTemp("e_agent_list",varr,data,mytmp);
        EnterGetAgentController.g("#e_agent_list a.position_delgate");//职位委托
        return count;
    },
    /*
     *生成找猎头模板
     *2012-2-12
     */
    f:function(stat){
        var tmp=TEMPLE;
        var show='';
        var ltemp=tmp.T00040,mtemp,rtemp=tmp.T00060;
//        if(stat==1){
//            show=tmp.T00061;
//        }else{
//            show="";
//        }
//        mtemp=tmp.T00057.replace("{show}",show);
        mtemp=tmp.T00057.replace("{show}","");
        return baseController.GenBListTemp(ltemp,mtemp,rtemp);
    },
    /*
     * 功能：获取可委托职位列表成功
     * 参数：
     * data：后台返回数据
     */
    h:function(data){
        var dt=data.data;
        baseRender.al("cd_resume", true, "确定" ,EnterGetAgentController.i);
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
    i:function(data){
        alert("对不起，您暂时没有可以委托的职位");
    },
    /*
     * 功能：获取联系方式失败|投递简历失败
     * 参数：
     * data：后台返回数据
     */
    j:function(data){
        alert(data.data);
    },
    /*
     * 功能：委托职位成功
     * 参数：
     * data：后台返回数据
     */
    k:function(data){
        alert("职位委托成功!");
        var a=$("#cd_resume");
        a.fadeOut(200);
        if(a.find("#cdres_list li").length==1){
            a.find("a.okbtn").unbind("click");
        }
    },
    /*
     * 功能：获取联系方式失败|投递简历失败
     * 参数：
     * data：后台返回数据
     */
    n:function(data){
        alert(data.data);
    },
    /*
     * 功能：定位到列表顶部
     * 参数：
     * 无
     */
    o:function(){
        $("html,body").animate({
            scrollTop:$("body").offset().top-60
        },500);
    }
};


