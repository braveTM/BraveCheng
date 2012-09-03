/* 
 * 首页渲染器
 */
var indexRender={
    /*
     * 功能：鼠标移入按钮时的效果
     * 参数：
     * obj：但前按钮
     * btn_old：当前状态下按钮的样式
     * btn_new：新状态下按钮的样式
     * btn_click：点击时的样式
     */
    IBtnChangeBg:function(obj,btn_old,btn_new,btn_click){
        var that=$(obj);
        if(btn_click!=null&&that.hasClass(btn_click)){
            that.removeClass(btn_click);
        }
        that.removeClass(btn_old);
        that.addClass(btn_new);
    },
//    /*
//     * 功能：给职讯留言成功
//     * 参数：
//     * data:后台返回数据
//     */
//    a:function(data){        
//        alert("留言成功");
//        $("#zhixunmsg").val('');
//    },
//    /*
//     * 功能：给职讯留言失败
//     * 参数：
//     * data:后台返回数据
//     */
//    b:function(data){
//        alert("留言失败");
//    },
    /*
     * 功能：异步登录成功
     * 参数：
     * data：后台返回数据
     */
    c:function(data){        
        window.location.href=data.data;
    },
    /*
     * 功能：异步登录失败
     * 参数：
     * data：后台返回数据
     */
    d:function(data){
        if(data.data==3){
            var msg="你的帐户在短时间内密码输入错误5次，为保障您的帐户安全，请在5分钟后重新输入!";    
            baseController.InitialSureDialog("error",msg, "select",'找回密码',function(){    
                    $("#select").unbind("click").bind("click",function(){
                        window.location.href=WEBROOT+'/forgot/';
                    })                  
                });
        }
        else if(data.data=="对不起，您的权限不足"){
            location.reload();
        }else{
            alert(data.data);
         $("#err_msg").html('');
        }
    //        alert(data.data,"error",true,"",function(){
    //            location.reload();
    //        });      
    },
    /*
     * 功能：移入公司图片
     * 参数：
     * obj：当前对象
     */
    e:function(obj){
        clearInterval(ENTERTIMER);
        var that=$(obj).parent().find("li.cur_li div.box_ct");
        that.animate({
            'opacity':'0'
        },300);
        $(obj).parent().find("li").removeClass("cur_li");
        $(obj).addClass("cur_li").find("div.box_ct").animate({
            'opacity':'1'
        },100);

        $(obj).find("div.img_bg div.img_top").animate({
            'top':'-3px'
        },300);

        $(obj).find("div.img_bg div.img_bot").animate({
            'bottom':'-4px'
        },300);
    },
    /*
     * 功能：移出公司图片
     * 参数：
     * obj：当前对象
     */
    f:function(obj){
        var that=$(obj);
        //indexController.h();
        that.removeClass("cur_li").find("div.box_ct").animate({
            'opacity':'0'
        },400);

        that.find("div.img_bg div.img_top").animate({
            'top':'-87px'
        },300);

        that.find("div.img_bg div.img_bot").animate({
            'bottom':'-93px'
        },300);
    }
};