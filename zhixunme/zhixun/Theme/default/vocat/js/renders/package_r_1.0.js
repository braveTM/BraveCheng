/*
 * 我的套餐渲染器
 */
var packageRender={
    /*
     * 功能：立即购买套餐成功
     * 参数：
     * data：后台返回数据
     */
    a:function(data){
        alert("购买成功!","","","",function(){
            //$("#suretobuy").removeClass("clicked");
            location.href=WEBROOT+"/mpackage/0";
        });
    },
    /*
     * 功能：立即购买套餐失败
     * 参数：
     * data：后台返回数据
     */
    b:function(data){
        $("#suretobuy").removeClass("clicked");
        $("#suretorenew").removeClass("clicked");
        //        alert(data.data);
        packageController.d();
    },
    /*
     * 功能：立即购买套餐成功
     * 参数：
     * data：后台返回数据
     */
    c:function(data){
        alert("续费成功!","","","",function(){
            //$("#suretorenew").removeClass("clicked");
            var rand=(new Date()).getTime();            
            location.href=WEBROOT+"/mpackage/?suc="+rand;
        });
    },
    /*
     * 功能：获取续费结果成功
     * 参数：
     * data：后台返回数据
     */
    d:function(data){
        $("#chr_res").html(data.data);
    },
    /*
     * 功能：获取续费结果失败
     * 参数：
     * data：后台返回数据
     */
    e:function(data){
        alert(data.data);
    },
    /*
     * 功能：获取积分续费结果失败
     * 参数：
     * data：后台返回数据
     */
    ea:function(data){
        $("#rechange").removeClass("clicked");
        $("#rechange").removeClass("clicked");     
        alert(data.data);
    },
    /*
     * 功能：单项立即续费成功
     * 参数：
     * data：后台返回数据
     */
    f:function(data){
        alert("续费成功!");
    },
    /*
     * 功能：获取续费结果失败
     * 参数：
     * data：后台返回数据
     */
    g:function(data){
        packageController.d();
    },
    /*
     * 功能：获取续费项提示成功
     * 参数：
     * data：后台返回数据
     */
    h:function(data){     
        var dt=data.data;
        var par=$("#schr_item");
        var tpar=par.parent().parent().next();
        var vl=par.val();
        par.next().html(dt[0]);
        tpar.find("td span.gray").html(dt[1]);
        if(vl=="8"){            
            tpar.find("td.ltd").html("充值金额 :");
            $("#chr_res").text("请输入充值金额!");
//            packageController.k();                    
        }else{
            tpar.find("td.ltd").html("续费个数 :");            
            $("#scr_use").next().next().fadeIn();
            $("#scr_use").val('');
            $("#phone_cz").replaceWith('');
            if($("#scr_use").hasClass("hidden")){
                $("#scr_use").removeClass("hidden");
                $("#scr_use").next(".unit").fadeIn(10);
            }
            $("#chr_res").text("请输入续费个数!");
            tpar.find("td span.unit").text("个");            
            packageController.g();
        }        
    },
    /*
     * 功能：兑换套餐成功
     * 参数：
     * data：后台返回数据
     */
    i:function(data){
        alert("恭喜您兑换套餐成功!","","","",function(){
            location.href=WEBROOT+"/mpackage/0";
        });
    },
    /*
     * 功能：兑换套餐失败
     * 参数：
     * data：后台返回数据
     */
    j:function(data){
        $("#change").removeClass("clicked");
        $("#change").removeClass("clicked");        
        alert(data.data);
    }
//     /*
//     * 功能：获取电话充值续费项提示成功
//     * 参数：
//     * data：后台返回数据
//     */
//    i:function(){
//    },
//      /*
//     * 功能：获取电话充值续费面值请求成功
//     * 参数：
//     * data：后台返回数据
//     */
//    j:function(data){        
//        var temp='<div id="phone_cz" class="cz"><ul>',tempend='</ul></div><input type="text" class="hidden" value="" id="scr_use">';
//        var t='';
//        var temp1='<label><li class="first"><input class="pub1" name="p1" type="radio" value="{price}"><span class="lf cost">{price}元</span><span class="lf">{min}分钟</span></li></label>';
//        $.each(data.data,function(i,item){
//            t+=temp1.replace('{min}',item.min).replace('{price}',item.price).replace('{price}',item.price);            
//        });
//        temp+=t+tempend;        
//        $("#scr_use").replaceWith(temp); 
//        $("#scr_use").val('10');                
//        $("#phone_cz").find("li").first().find("input").attr("checked",'checked');        
//        $("#scr_use").next(".unit").fadeOut(10);
//        $("#scr_use").next().next().html('<em class="red hidden">1</em>');             
//        packageController.h();
//    },
//     /*
//     * 功能：获取电话充值续费面值请求失败
//     * 参数：
//     * data：后台返回数据
//     */
//     k:function(){
//         alert("暂时没有可供选择的面值!");
//     }        
};

