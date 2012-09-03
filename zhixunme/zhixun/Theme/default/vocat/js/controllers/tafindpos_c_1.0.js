/* 
 * 职位搜索页控制
 * 
 */
var tafindposController={
    /*
    * 功能：初始化地区选择插件
    * 参数：无
    * author:joe 2012/7/20
    */
    a:function(){
        $("#place").hgsSelect({
            type:'place',    //default:资质添加，place：地区添加，jobtitle：职称添加
            pid:"pslt",            //省市添加的父容器id
            lishow:true,
            pshow:true,       //是否显示地区选择
            sprov:true,       //是否只精确到省
            single:true,       //省是否为单选
            sure:tafindposRender.a
        });
    },    
    /*
    * 功能：初始化搜索框|筛选条件|高级搜索事件绑定|查看详细按键
    * 参数：无
    * author:joe 2012/7/20
    */
    b:function(){
        var that=tafindposRender;
        that.b();
        that.c();
        that.d();
        that.e();
        baseController.BtnBind("div.btn22", "btn22", "btn22_hov", "btn22_hov");
    },
    /*
     * 功能：初始化翻页插件
     * 参数：
     * id：分页插件的父容器id
     * t：总共的条数
     * id:翻页插件绑定id
     * func:翻页回调函数
     */
    c:function(t,func){
        var cur=$("input[name='cpge']").val();
        if(!cur)
            cur=0;        
        else
            cur=cur-1;        
        var lan=LANGUAGE;
        $("#pagination").pagination(t,{
            callback:func,
            prev_text:lan.L0258,
            next_text: lan.L0259,
            items_per_page:CONSTANT.C0004,
            num_display_entries:9,
            current_page:cur,
            num_edge_entries:2,
            link_to:"javascript:;"
        });
        tafindposController.f();//翻页链接绑定
    //        if(!func)
    //            this.e();
    },
    /*
     *功能：分页效果初始化
     *参数：无
     *@author：joe
     */
    d:function(){
        var that=tafindposController;
        var count=$("input[name='total']").val();
        if(count>CONSTANT.C0004){//大小10条分页显示
            that.c(count,function(){
                tafindposController.j(1,1);
            }); 
        }        
    },
    /*
     * 功能：翻页事件绑定
     * 参数：
     * id:分页插件的父容器id
     * author:joe
     */
    e:function(id){
        var p=$("#pagination");
        $("#prev").click(function(){
            p.find("")
            p.find("a.prev").trigger("click");
        });
        $("#next").click(function(){
            p.find("a.next").trigger("click");
        });
    },
    /*
     *功能：翻页绑定链接
     *参数：无
     *@author：joe
     */
    f:function(){       
        var params=tafindposController.i(1);
        var href=WEBROOT+"search_job"+params;
        href=href.replace("&page=1","");
        var pagination=$("#pagination");
        var pages=pagination.find("a").not(".prev").not(".next");
        pagination.find("a").unbind("click").bind("click",function(){
            return ture;
        })
        var phref='';
        var selp=pagination.find("span.current").not(".prev").not(".next").text()*1;
        $.each(pages,function(i,item){          
            phref=href+"&page="+item.innerHTML;
            item.href=phref;          
        });
        var pre=pagination.find("a.prev");
        var next=pagination.find("a.next");
        $("#prev").attr("href",href+"&page="+(selp-1));
        $("#next").attr("href",href+"&page="+(selp+1));        
        pre.attr("href",href+"&page="+(selp-1));
        next.attr("href",href+"&page="+(selp+1));        
    },
    /*
     *功能：触发搜索事件绑定
     *参数：无
     *@author：joe
     */
    g:function(){
        $("#advance").find("a").unbind("click").bind("click",function(){//高级搜索
            $(this).siblings("a.sel").removeClass("sel");
            $(this).addClass("sel");
            tafindposController.j(1);            
        });
        $("#hotwords").find("a").unbind("click").bind("click",function(){//热门关键词
            $("#keywords").val($(this).text()).attr("rel",$(this).text());//区别搜索与条件筛选
//            tafindposController.j(1);
        })       
        tafindposRender.f();//排序方式
    },
    /*
     *功能：搜索按键后提交
     *参数：无
     *@author：joe
     */
    h:function(){
        var params;
        $("#search").unbind("click").bind("click",function(){
            if($("#keywords").val()=="请输入您要找的职位"){
                $("#keywords").trigger("focus") ;
            }else{
                tafindposController.j();
            }
        })
        $(document).keydown(function(event){//回车搜索            
            var aid=document.activeElement.id;
            if(event.keyCode==13&&aid=="keywords"){
                $("#search").trigger("click");
            }
        });
    },
    /*
     * 功能：搜索参数获取
     * 参数：    
     * i:1  多条件搜索
     * p:1  记录页数  
     * author:joe 2012/7/20
     */
    i:function(i,p){
        var require_place=0,//要求地区
        salary=0,//待遇
        pub_date=0,//发布时间
        cert_type=2,//资质证书
        word,//关键词
        is_real_auth=2,//认证用户
        page=1,//当前页
        size=10,//每页条数
        order=0;//排序方式        
        var salarys=$("#advance").find("li.salary");
        var pubs=$("#advance").find("li.pub_date");
        var orders,up,down,params='';
        word=$("#keywords").val();
        p=p||0;
        if(p==1)
            page=$("#pagination").find("span.current").not(".prev,.next").text();
        if(i==1){//多条件搜索
            word=$("#keywords").attr("rel");
            orders=$("#pos_list").find("a.sel");  
            require_place=$("#pid").val();
            salary=salarys.find("a.sel").attr("rel");
            pub_date=pubs.find("a.sel").attr("rel");            
            if(orders.hasClass("count")){//浏览数排序
                order=1;
            }
            else{
                up=orders.find("em.up_sel");
                down=orders.find("em.down_sel");
                if(up.length){
                    order=up.attr("rel");
                }
                else if(down.length){
                    order=down.attr("rel");
                }
            }
            if(!$("#cert").hasClass("cancel"))
                cert_type=1;
            if(!$("#authuser").hasClass("cancel"))
                is_real_auth=1;
        }        
        var paramsObj={
            require_place:require_place,
            salary:salary,
            pub_date:pub_date,
            cert_type:cert_type,
            word:word,
            is_real_auth:is_real_auth,
            page:page,
            size:size,
            order:order
        }    
        var i=0;
        $.each(paramsObj,function(o,item){            
            if(item!=0){
                if(i==0)
                    params+="?"+o+'='+item;
                else
                    params+='&'+o+'='+item;
                i++;
            }
        });
        return params;
    },
    /*
     * 功能：多条件搜索
     * 参数：   
     * i:1  多条件搜索  
     * p:1 记录页数
     * author:joe 2012/7/20
     */
    j:function(i,p){
        var params=tafindposController.i(i,p);
        location.href=WEBROOT+'/search_job'+params;
    },
    /*
     *功能：初始化文本输入框
     *参数：无
     */
    aa:function(){
        $("#uname,#password").val("");  
        if($.browser.mozilla){
            var inp=$("input[type='text'],textarea");
            $.each(inp,function(i,o){
                var a=$(o);
                a.val(a[0].defaultValue);
            });
        }
    },
    
    /*
     * 功能：验证用户名
     * 参数：
     * 无
     */
    ab:function(){
        $("#uname").focus(function(){
            $("#err_msg").text("");
            $(this).css("border-color","#0171CA");
            $(this).removeClass("error");
            if($(this).next('span').length>0){
                $(this).next('span').remove();
            }
            if($("#upsd").val()!=""){
                $("#err_msg").text("");
            }else{
                if($("#upsd").hasClass("error")){
                    $("#err_msg").text(LANGUAGE.L0010);
                }else{
                    $("#err_msg").text(""); 
                }
            }
        }).blur(function(){
            var er=$("#err_msg");
            var str=$(this).val().replace(new RegExp(" ","g"),"");
            if(str==""){
                $(this).css("border-color","#c00");
                $(this).addClass("error");
                var msg=LANGUAGE.L0231;
                er.text(msg);
            }
            else{
                $(this).val(str);
                $(this).css("border-color","#0171CA");
                if($("#upsd").val().replace(new RegExp(" ","g"),"")!=""){
                    er.text("");
                }
            }
        });
        $("#upsd").focus(function(){
            $(this).css("border-color","#0171CA");
            $(this).removeClass("error");
            if($(this).next('span').length>0){
                $(this).next('span').remove();
            }
            if($("#uname").val()!=""){
                $("#err_msg").text("");
            }else{
                if($("#uname").hasClass("error")){
                    $("#err_msg").text(LANGUAGE.L0231);
                }else{
                    $("#err_msg").text(""); 
                }
            }
        }).blur(function(){
            var er=$("#err_msg");
            var str=$(this).val().replace(new RegExp(" ","g"),"");
            if(str==""){
                $(this).css("border-color","#c00");
                $(this).addClass("error");
                var msg=LANGUAGE.L0010;
                er.text(msg);
            }
            else{
                $(this).val(str);
                $(this).css("border-color","#0171CA");
                if($("#uname").val().replace(new RegExp(" ","g"),"")!=""){
                    er.text("");
                }
            }
        });
        baseController.BtnBind("div.btn6", "btn6", "btn6_hov", "btn6_click");
    },
    /*
     * 功能：登录输入提示
     * 参数：
     * t：错误类型
     */
    ad:function(){
        $("div.login_box div.txt_cont span.tipmsg").click(function(){
            $(this).parent().find("input").trigger("focus");
        });
    },
    /*
     * 功能：回车登录
     * 参数：
     * t：错误类型
     */
    ae:function(){
        $(document).keydown(function(event){            
            var aid=document.activeElement.id;
            if(event.keyCode==13&&(aid=="uname"||aid=="upsd")){
                var that=$("#login");
                tafindposController.ag(that);
            }
        });
    },
    /*
     * 功能：登录
     * 参数：
     * 无
     */
    af:function(){
        $("#login").click(function(){
            tafindposController.ag(this);
        });
    },
    /*
     * 功能：登录
     * 参数：
     * 无
     */
    ag:function(obj){
        var str=$("#uname").val().replace(new RegExp(" ","g"),"");
        var str1=$("#upsd").val().replace(new RegExp(" ","g"),"");
        if(str==""&&str1==""&&!$("#uname").hasClass("error")&&!$("#upsd").hasClass("error")){
            $("#uname").focus().trigger("blur");  
        }else if(str==""){
            $("#uname").focus().trigger("blur");
        }else if(str1==""){
            $("#upsd").focus().trigger("blur");
        }
        if($(obj).parent().parent().find("input.error").length==0){
            $("#err_msg").html('正在登录...');
            var rem=0;
            if($("input[name='cache']").attr("checked")){
                rem=1;
            }
            var uname=$("#uname").val();
            var pwd=$("#upsd").val();
            var u=$(obj).attr("ru");
            var that=tafindposRender;
            var ac=new AccountCat();
            ac.Login(rem, uname, pwd, u, that.aa, that.ab);
        }
    },
    /*
     * 功能：初始化公共页面
     * 参数：无
     * author:joe 2012/7/20
     */
    iniPage:function(){
        this.a();
        this.e();
        this.b();
        this.d();
        this.h();
        this.g();
        this.aa();
        this.ab();
        this.ad();
        this.ae();
        this.af();
        
    }
}
$().ready(function(){
    tafindposController.iniPage();
});
