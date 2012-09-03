/* 
 * 职位搜索页渲染
 * 
 */
var tafindposRender={
/*
    * 功能：地区选择插件选择后执行
    * 参数：无
    * author:joe 2012/7/20
    */
    a:function(r){
       var txt;
       var ids=r.prov;
         if(r.nolmt){
            txt=r.noname;
            ids="0";
        }
        else{
            txt=r.provname;
        }
        $("#pid").val(ids);
        $("#place").val(txt);
        tafindposController.j(1);
    },
    /*
    * 功能：搜索框事件绑定
    * 参数：无
    * author:joe 2012/7/20
    */
    b:function(){
        var key=$("#keywords");
        var keyword=key.val();
        key.focus(function(){
            if($(this).val()=="请输入您要找的职位")
                $(this).val('');
            else
                $(this).removeClass("gray");
        }).blur(function(){
            if($(this).val()==''){
                $(this).val('请输入您要找的职位');
                $(this).addClass("gray");
            }
        })
    },
    /*
    * 功能：排序方式hover效果
    * 参数：无
    * author:joe 2012/7/20
    */
    c:function(){
        var up,down,upSel,downSel ;
        $("#pos_list").find("a").not(".sel,.gray").mouseover(function(){
            up=$(this).find("em.up");
            down=$(this).find("em.down");        
            up.addClass("up_hov").removeClass("up");
            down.addClass("down_hov").removeClass("down");                               
        }).mouseout(function(){
            up=$(this).find("em.up_hov");
            down=$(this).find("em.down_hov");
            up.addClass("up").removeClass("up_hov");
            down.addClass("down").removeClass("down_hov");                      
        })
    },
    /*
    * 功能：筛选条件复选框点击事件
    * 参数：无
    * author:joe 2012/7/20
    */
    d:function(){
        $("#cert,#authuser").unbind("click").bind("click",function(){
            if($(this).hasClass("cancel")){
                $(this).removeClass("cancel");
            }
            else{
                $(this).addClass("cancel");
            }
            tafindposController.j(1);
        });
    },
    /*
    * 功能：高级搜索事件绑定
    * 参数：无
    * author:joe 2012/7/20
    */
    e:function(){        
        var that=HGS.Base;    
        var seAdvs=$("#se_advance");
        var adv=$("#advance");
        seAdvs.click(function(){
            var me=$(this);
            if($(this).hasClass("m")){
                adv.slideDown(300,function(){
                    me.find("em").text("-");
                    me.removeClass("m");
                });
            }
            else{
                adv.slideUp(300,function(){
                    me.addClass("m");
                    me.find("em").text("+");
                });  
            }             
        })
    },
    /*
    * 功能：排序方式click效果
    * 参数：无
    * author:joe 2012/7/20
    */
    f:function(){
        $("#pos_list").find("a").not("#next,#prev").unbind("click").bind("click",function(){
            var up=$(this).find("em").first();
            var down=up.next(); 
            if(!$(this).hasClass("sel"))
                $(this).siblings("a").removeClass("sel");
            if($(this).hasClass("count")){//浏览数                
               $(this).removeClass("count_gray").addClass("sel");
               $(this).find("em").removeClass("down_hov").addClass("down");
            }
            else{
                $(this).siblings("a.count").addClass("count_gray");  
                var i=up.hasClass("up_sel")||(!up.hasClass("up_sel")&&!down.hasClass("down_sel"));            
                if(i){//升序||无排序
                    tafindposRender.g();
                    down.addClass("down_sel").removeClass("down").removeClass("down_hov");
                    up.addClass("up_hov");
                }else{
                    tafindposRender.g();
                    up.addClass("up_sel").removeClass("up").removeClass("up_hov");
                    down.addClass("down_hov");
                }
                $(this).addClass("sel");                
            }            
            tafindposController.j(1);            
        })
        $("#pos_list a").find("em").not(".up_sel,.down_sel").unbind("click").bind("click",function(e){
            var e=e||window.event;
            e.stopPropagation();
            tafindposRender.g();
            $(this).parent().addClass("sel");
            if($(this).hasClass("up_hov")){
                $(this).addClass("up_sel").removeClass("up_hov");     
                $(this).next().addClass("down_hov").removeClass("down");
            }
            if($(this).hasClass("down_hov")){
                $(this).addClass("down_sel").removeClass("down_hov");
                $(this).prev().addClass("up_hov").removeClass("up");
            }            
            tafindposController.j(1);
        })
    },
    /*
    * 功能：排序方式初始化效果
    * 参数：无
    * author:joe 2012/7/20
    */
    g:function(){
        var list=$("#pos_list");
        list.find("a.sel").removeClass("sel");
        list.find("em.up_sel").addClass("up").removeClass("up_sel");
        list.find("em.down_sel").addClass("down").removeClass("down_sel");     
    },
    /*
     * 功能：登录成功
     * 参数：
     * data：后台返回数据
     */
    aa:function(data){        
       window.location.href=data.data; 
    },
    /*
     * 功能：登录失败
     * 参数：
     * data：后台返回数据
     */
    ab:function(data){
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
    }
}
