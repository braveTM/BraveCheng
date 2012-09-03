/* 
 * 人才找企业首页渲染器
 */
var tfcompanyRender={
    /*
     * 功能：地区选择回调方法
     * 参数：
     * data:后台返回数据
     */
    a:function(r){
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
        TfcompanyController.b(0);
    },
    /*
     * 功能：成功异步获取我发布的职位列表
     * 参数：
     * data：后台返回数据
     */
    b:function(data){
        var count=tfcompanyRender.d(data);
        TfcompanyController.e(count,"#pagination1",TfcompanyController.c);
    },
    /*
     * 功能：失败异步获取我发布的职位列表
     * 参数：
     * data：后台返回数据
     */
    c:function(data){
        TfcompanyController.e(0,"#pagination1",TfcompanyController.c);
        $("#companylist").html("<li class='no-data'>暂无数据!</li>");
    },
    /*
     * 功能：成功异步获取可能感兴趣的企业列表
     * 参数：
     * data：后台返回数据
     */
    d:function(data){
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
        });
        var varr=["focus_id",'u_name','u_photo','follow','real_auth','phone_auth','email_auth','com_name','intro','location','id',"ntitle","ptitle","mtitle"];
        HGS.Base.GenTemp("companylist",varr,dt,mytmp);
        return count;
    },
    /*
     * 功能：定位到列表顶部
     * 参数：
     * 无
     */
    e:function(){
        $("html,body").animate({
            scrollTop:$("body").offset().top
        },500);
    }
};
