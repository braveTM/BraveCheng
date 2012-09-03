/*
 * 新闻动态页面渲染器
 */
var dynewsRender={
    /*
     *获取站内动态
     *参数：无
     *jack
     *2012-3-9
     */
    a:function(data){
         var count=dynewsRender.b(data);
        dynewsController.a(count,"#pagination",dynewsController.c);
    },
    /*
     *异步获取站内动态成功
     *参数：无
     *jack
     *2012-3-9
     */
    b:function(data){
         var dt=data.data;
        var count=data.count;
        var varr=['title','date'];
        HGS.Base.GenTemp("news",varr,dt,TEMPLE.T00085);
        return count;
    },
    /*
     *获取站内动态失败
     *参数：无
     *jack
     *2012-3-9
     */
    c:function(){
        dynewsController.a(0,"#pagination",dynewsController.c);
        $("#news").html("<li class='no-data'>暂无数据!</li>");
    }
};