/*
 * 猎头职位管理页面渲染器
 */
var comdetailRender={
    /*
     * 功能：成功异步获取职位列表
     * 参数：
     * data：后台返回数据
     */
    a:function(data){
        var count=comdetailRender.d(data);
        ComDetailController.a(count,"#pagination1",ComDetailController.c);
    },
    /*
     * 功能：失败异步获取职位列表
     * 参数：
     * data：后台返回数据
     */
    b:function(data){
        ComDetailController.a(0,"#pagination1",ComDetailController.c);
        $("#joblist").html("<li class='no-data'>暂无数据!</li>");
    },
    /*
     * 功能：定位到列表顶部
     * 参数：
     * 无
     */
    c:function(){
        $("html,body").animate({
            scrollTop:$("#talfilter").offset().top-55
        },500);
    },
    /*
     * 功能：成功异步获取职位列表
     * 参数：
     * data：后台返回数据
     */
    d:function(data){
        var dt=data.data;
        var count=data.count;
        var mytmp=[];
        mytmp[0]=comdetailRender.e("1", "2");//全职 招聘中
        mytmp[1]=comdetailRender.e("2", "2");//兼职 招聘中
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
        varr[0]=['cert','title','pos','count','location','degree','r_count','date','r_class','salary','id','face'];
        varr[1]=['cert','title','place','location','r_count','date','r_class','salary','id','face'];
        HGS.Base.GenMTemp("joblist",varr,dt,mytmp);
        $("#joblist").find("p.own").remove();
        $("#joblist div.info p.lst_p").removeClass("lst_p");
        $("#joblist div.info p:last-child").addClass("lst_p");
        return count;
    },
    /*
     * 功能：生成我发布的职位列表模板
     * 参数：
     * 无
     */
    e:function(type,status){
        var tmp=TEMPLE;
        var mtmp='';
        var rtmp=tmp.T00063.replace('<em class="ident_pic {role}"></em>','');
        if(type=="1"){
            mtmp=tmp.T00046.replace('<p><span class="gray">企业: </span><span>{company}</span></p>',"");
        }else if(type=="2"){
            mtmp=tmp.T00045.replace('<p><span class="gray">企业: </span><span>{company}</span></p>',"");
        }
        return baseController.GenBListTemp(null, mtmp, rtmp);
    },
    /*
     * 功能：加关注成功
     * 参数：
     * data：后台返回数据
     */
    f:function(){
        var that=$("#add_focus");
        var temp=TEMPLE.T00102;
        that.unbind("click");         
        temp=temp.replace('{id}',that.data("uid")).replace('{name}',that.data("uname"));
        that.parent().replaceWith(temp);
        ComDetailController.i();                
    },
    /*
     * 功能：加关注失败
     * 参数：
     * data：后台返回数据
     */
    g:function(data){
        alert(data.data);
    },
     /*
     * 功能：取消关注成功
     * 参数：
     * 无
     */
    h:function(){
        var that=$("#re_focus");
        var temp=TEMPLE.T00103;          
        temp=temp.replace('{id}',that.data("uid")).replace('{name}',that.data("uname"));
        that.parent().parent().replaceWith(temp);
        ComDetailController.g();
    },
    /*
     * 功能：取消关注失败
     * 参数：
     * 无
     */
    i:function(){
        alert("暂时不能取消关注!")
    }
};