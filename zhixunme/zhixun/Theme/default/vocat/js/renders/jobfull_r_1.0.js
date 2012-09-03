/*
 * 全职|兼职职位详细页页面渲染器
 */
var jobfullRender={
    /*
     * 功能：获取联系方式成功
     * 参数：
     * data：后台返回数据
     */
    a:function(data){        
        var dt=data.data;
        var temp=TEMPLE.T00108;                
        if(dt.qq!="")
            temp=temp.replace("{qq}",dt.qq).replace("{qq}",dt.qq);
        else
            temp='';
        $("#ckcontact").parent().remove();
        $("#loading").addClass("hidden");
//        $("#ap_msg").css("display","block");
        $("#pu_phone").text(dt.phone);        
        $("#pu_qq").html(temp);
        $("#pu_email").text(dt.email);
        $("#com_phone").text(dt.company_phone);
        $("#cont_way").slideDown(200);
    },
    /*
     * 功能：获取联系方式失败|投递简历失败
     * 参数：
     * data：后台返回数据
     * 修改:joe 2012/7/17 修改弹出框样式
     */
    b:function(data){
        if(data.data=="YEBZ0001"){
            paytipController.NoScore();
        }else{
            baseController.InitialSureDialog("error",data.data,"confirm","购买套餐",function(){
                var url=WEBROOT+"/mpackage/1";
                $("#confirm").attr({href:url,target:"_blank"});
            });
        }
    },
    /*
     * 功能：投递简历成功
     * 参数：
     * data：后台返回数据
     */
    c:function(data){
        alert("投递简历成功!");
    },
    /*
     * 功能：加关注成功
     * 参数：
     * data：后台返回数据
     */
    d:function(data){
        var that=$("#add_focus");               
        var temp=TEMPLE.T00102;
        that.unbind("click");          
        temp=temp.replace('{id}',that.data("uid")).replace('{name}',that.data("uname"));
        that.parent().replaceWith(temp);
        jobfullController.j();
    },
    /*
     * 功能：加关注失败
     * 参数：
     * data：后台返回数据
     */
    e:function(data){
        alert(data.data);
    },
     /*
     * 功能：取消关注成功
     * 参数：
     * data：后台返回数据
     */
    f:function(){
        var that=$("#re_focus");
        var temp=TEMPLE.T00103;         
        temp=temp.replace('{id}',that.data("uid")).replace('{name}',that.data("uname"));
        that.parent().parent().replaceWith(temp);
        jobfullController.g();
    },
    /*
     * 功能：取消关注失败
     * 参数：
     * data：后台返回数据
     */
    g:function(data){
        alert(data.data);
    }
};