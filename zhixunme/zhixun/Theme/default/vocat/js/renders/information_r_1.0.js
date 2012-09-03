/* 
 *资讯页面渲染器
 */
var informationRender={
    /*
     *定位到顶部
     *参数：无
     */
    f:function(){
          $("html,body").animate({scrollTop:$("body").offset().top},500);
    },
    /*
     * 功能：赞一下 成功
     * 参数：
     * data：后台返回数据
     */
    g:function(data){
        var that=$($("a.good:eq(0)").data("prise"));
        var num=parseInt(that.next().html(),10)+1;
        $("a.good").next().html(num);
    },
    /*
     * 功能：赞一下 失败
     * 参数：
     * data：后台返回数据
     */
    h:function(data){
        alert('您已经赞过了，请稍后再试.');
    },
   /*
    *功能：发布排行榜hover效果
    *参数：无
    */
   ac:function(){
       $("#publist").children("li.gray").unbind("mouseenter").bind("mouseenter",function(){           
           $(this).siblings("li.hover").addClass("hidden");
           $(this).siblings("li.gray").removeClass("hidden");
           $(this).prev(".hover").removeClass("hidden");
           $(this).addClass("hidden");
       })
   }
};

