/*
 * 博客渲染器
 */
var blogRender={
    /*
     * 功能：成功获取猎头行业心得列表
     * 参数：
     * data：后台返回数据
     */
    a:function(data){
        var count=blogRender.d(data);
        BlogController.a(count,"#pagination1",BlogController.c);
    },
    /*
     * 功能获取猎头行业心得列表失败
     * 参数：
     * data：后台返回数据
     */
    b:function(data){
        BlogController.a(0,"#pagination1",BlogController.c);
        $("#amlist").html("<li class='no-data'>暂无数据!</li>");
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
     * 功能：生成猎头行业心得列表
     * 参数：
     * data：后台返回数据
     */
    d:function(data){
        var dt=data.data;
        var count=data.count;
        var tmp=TEMPLE;
        $.each(dt, function(i,o){
            if(o.status=="1"){
                o.status="未审核";
                o.stclass="gray";
                o.oper=tmp.T00089+tmp.T00088;
            }else if(o.status=="2"){
                o.status="审核中";
                o.stclass="lblue";
                o.oper="";
            }else if(o.status=="3"){
                o.status="审核通过";
                o.stclass="green";
                o.oper=tmp.T00089;
            }else if(o.status=="4"){
                o.status="未通过";
                o.stclass="red";
                o.oper=tmp.T00089;
            }
        });
        var info=new Information();
        var varr=[info.title,info.rcount,info.ctime,info.status,"stclass","oper",info.id];
        HGS.Base.GenTemp("amlist",varr,dt,tmp.T00087);
        var that=BlogController;
        that.g();
        that.h();
        return count;
    },
    /*
     * 功能：创建blog成功
     * 参数：
     * data：后台返回数据
     */
    f:function(data){
        alert("操作成功!去 我发布的心得 看看吧","","","",function(){
            location.href=SWEBURL.BlogManage;
        });
    },
    /*
     * 功能：创建blog失败
     * 参数：
     * data：后台返回数据
     */
    g:function(data){
        alert(data.data);
    },
    /*
     * 功能：删除blog成功
     * 参数：
     * data：后台返回数据
     */
    h:function(data){
        var par=$("#amlist");
        var id=par.data("cur");
        par.find("li div.fv_cl[bid='"+id+"']").parent().slideUp(200,function(){
            $(this).remove();
        });
    },
    /*
     * 功能：blog提交审核成功
     * 参数：
     * data：后台返回数据
     */
    i:function(data){
        var par=$("#amlist");
        var id=par.data("cur");
        var that=par.find("li div.fv_cl[bid='"+id+"']");
        that.prev().find("span").text("审核中").removeClass("gray").addClass("lblue");
        that.find("a").remove();
    }
};