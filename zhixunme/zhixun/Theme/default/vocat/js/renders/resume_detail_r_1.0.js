/*
 *简历详细页渲染器
 */
var resumedetailRender={
    /*
     *获取联系方式成功
     *jack
     *2012-2-12
     */
    b:function(ret){
        $("#se_agphone").parent().remove();
        $("#loading").addClass("hidden");
        var par=$("#cont_way");
        var data=ret.data;
        var phone=data.phone;
        var email=data.email;
        var qq=data.qq;
        var temp=TEMPLE.T00108;
        if(qq!="")
            temp=temp.replace("{qq}",qq).replace("{qq}",qq);
        else
            temp='';
        par.find("span.ph_num").text(phone);
        par.find("span.ph_ema").text(email);
        par.find("span.ph_qq").html(temp);
        par.fadeIn(500);
    },
      /*
     *查看兼职人才联系方式失败
     *查看猎头联系方式失败
     *jack
     *2012-2-12
     *修改:joe 2012/7/17 修改弹出框样式
     */
    c:function(ret){
        if(ret.data=="YEBZ0001"){
            paytipController.NoScore();
        }else{
            baseController.InitialSureDialog("error",ret.data,"confirm","购买套餐",function(){
                var url=WEBROOT+"/mpackage/1";
                $("#confirm").attr({href:url,target:"_blank"});
            });
        }
    },
      /*
     *获取代理猎头联系方式成功
     *jack
     *2012-2-12
     */
    d:function(ret){
       $("#se_agphone").parent().remove();
       $("#loading").addClass("hidden");
        var par=$("#cont_way");
        var data=ret.data;
        var phone=data.phone;
        var email=data.email;
        var qq=data.qq;
        var temp=TEMPLE.T00108;
        if(qq!="")
            temp=temp.replace("{qq}",qq).replace("{qq}",qq);
        else
            temp='';
        par.find("span.ph_num").text(phone);
        par.find("span.ph_ema").text(email);
        par.find("span.ph_qq").html(temp);
        par.fadeIn(500);
    },
    /*
     * 功能：加关注成功
     * 参数：
     * data：后台返回数据
     */
    e:function(data){
        var that=$("#add_focus");
        var temp=TEMPLE.T00102;
        that.unbind("click");         
        temp=temp.replace('{id}',that.data("uid")).replace('{name}',that.data("uname"));
        that.parent().replaceWith(temp);
        ResumeDetailController.l();
    },
    /*
     * 功能：加关注失败
     * 参数：
     * data：后台返回数据
     */
    f:function(data){
        alert(data.data);
    },
     /*
     * 功能：取消关注成功
     * 参数：
     * data：后台返回数据
     */
    g:function(){
        var that=$("#re_focus");
        var temp=TEMPLE.T00103;          
        temp=temp.replace('{id}',that.data("uid")).replace('{name}',that.data("uname"));
        that.parent().parent().replaceWith(temp);
        ResumeDetailController.k();
    },
    /*
     * 功能：取消关注失败
     * 参数：
     * data：后台返回数据
     */
    h:function(data){
        alert(data.data);
    }
};



