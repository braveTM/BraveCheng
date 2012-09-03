/* 
 *
 * 隐私设置控制器
 */
var setIndexController={
    /*
     * 功能：按键|input事件绑定初始化
     * 参数：
     * 无
     */
    a:function(){
        var that=setIndexRender;
        baseController.BtnBind(".btn6", "btn6","btn6_hov","btn6_hov");
        baseController.BtnBind(".btn13", "btn13","btn13_hov","btn13_hov");
        baseController.BtnBind(".btn4", "btn4","btn4_hov","btn4_hov");
        baseController.BtnBind(".btn14", "btn14","btn14_hov","btn14_hov");
        setIndexController.b("pub1");
        setIndexController.b("pub2",setIndexRender.g);
        setIndexController.b("pub3");
        setIndexController.b("pub4");
        that.c();
        that.f();
        that.h();
    },
    /*
     * 功能：input radio事件绑定
     * 参数：name:radio命名
     * fun:回调函数
     * 无
     */
    b:function(name,fun){        
       $("input[name='"+name+"']").unbind("click").bind("click",function(){
           $("input[name='"+name+"']").removeAttr("checked");
           $(this).attr("checked",true);
           if(fun){
               fun($(this));
           }
       });
    },
     /*
     * 功能：人才隐私提交
     * 参数：
     * 无
     */
    c:function(){        
        $("#save_npd").unbind("click").bind("click",function(){
            var that=setIndexRender;
            var params=setIndexController.d($(this)); 
            if(params){
                var ac=new AccountCat();
                ac.saveHPrivacy(params[0], params[1], params[2], params[3], params[4], params[5], params[6], that.a, that.b);
            }
        })
    },
    /*
     * 功能：人才隐私参数获取
     * 参数：me当前按键
     * 无
     */
    d:function(me){
        var human_privacy_id,resume,name,birthday,call_type,params=[];             
        human_privacy_id=me.attr('rel');
        resume=$("input[name='pub1']:checked").val();
        call_type=$("input[name='pub2']:checked").val();             
        name=$("input[name='pub3']:checked").val();
        birthday=$("input[name='pub4']:checked").val();         
        params[0]=human_privacy_id;                   
        params[1]=resume;
        params[2]=name;
        params[3]=birthday;
        params[4]=call_type;
        params[5]='';
        params[6]=$("input[name='apub4']:checked").val();
        if(call_type==2){          
            var t1=setIndexRender.i();
            if(t1)                
                params[5]=t1;
            else
                return false;  
        }               
        return params;
    },
     /*
     * 功能：企业隐私提交
     * 参数：
     * 无
     */
    e:function(){        
        $("#save_com").unbind("click").bind("click",function(){
            var that=setIndexRender;
            var params=setIndexController.f($(this));
            if(params){
                var ac=new AccountCat();
                ac.saveCPrivacy(params[0], params[1], params[2], params[3], params[4], params[5], params[6], that.a, that.b);
            }
        })       
    },
    /*
     * 功能：企业隐私参数获取
     * 参数：me当前按键
     * 无
     */
    f:function(me){
        var company_privacy_id,job,company_name,contact_name,call_type,params=[];             
        company_privacy_id=me.attr('rel');
        job=$("input[name='pub1']:checked").val();
        call_type=$("input[name='pub2']:checked").val();             
        company_name=$("input[name='pub3']:checked").val();
        contact_name=$("input[name='pub4']:checked").val();  
        params[0]=company_privacy_id;                   
        params[1]=job;
        params[2]=company_name;
        params[3]=contact_name;
        params[4]=call_type;
        params[5]='';
        params[6]=$("input[name='apub4']:checked").val();
        if(call_type==2){          
            var t1=setIndexRender.i();
            if(t1)                
                params[5]=t1;
            else
                return false;  
        }   
        return params;
    },
     /*
     * 功能：猎头隐私提交
     * 参数：
     * 无
     */
    g:function(){        
        $("#save_agent").unbind("click").bind("click",function(){
            var that=setIndexRender;
            var params=setIndexController.h($(this));
            if(params){
                 var ac=new AccountCat();
                ac.saveAPrivacy(params[0], params[1], params[2], params[3], params[4], params[5], params[6], that.a, that.b);
            }
        })
    },
    /*
     * 功能：猎头隐私参数获取
     * 参数：me当前按键
     * 无
     */
    h:function(me){
        var agent_privacy_id,job,resume,name,call_type,params=[];             
        agent_privacy_id=me.attr('rel');
        job=$("input[name='pub4']:checked").val();
        call_type=$("input[name='pub2']:checked").val();             
        resume=$("input[name='pub1']:checked").val();
        name=$("input[name='pub3']:checked").val();          
        params[0]=agent_privacy_id;                   
        params[1]=job;
        params[2]=resume;
        params[3]=name;
        params[4]=call_type;
        params[5]='';
        params[6]=$("input[name='apub4']:checked").val();          
        if(call_type==2){          
            var t1=setIndexRender.i();
            if(t1)                
                params[5]=t1;
            else
                return false;  
        }       
       return params;
    },
    /*
     * 功能：猎头联系方式切换
     * 参数：
     * 无
     */
    i:function(){       
        $("#chgenow").unbind("click").bind("click",function(){
            var that=setIndexRender;
            var contact_way=$("#chgenow").attr("rel"); 
            var id=$("#save").find("a.btn").attr("rel");  
            var s={
                url:ACCOUNTURL.SetPrivacyAgent,
                params:'agent_privacy_id='+id+'&contact_way='+contact_way,
                sucrender:that.d,
                failrender:that.ea
            };   
            HGS.Base.HAjax(s);
        })
    },
    /*
     * 功能：企业联系方式切换
     * 参数：当前按键
     * 无
     */
    j:function(){
        $("#chgenow").unbind("click").bind("click",function(){
             var p={
                url:ACCOUNTURL.SetPrivacyCompany,
                id:'company_privacy_id'
            };   
            var s=setIndexController.l(p);
            HGS.Base.HAjax(s);
        })
    },
     /*
     * 功能：人才联系方式切换
     * 参数：当前按键
     * 无
     */
    k:function(){
          $("#chgenow").unbind("click").bind("click",function(){            
            var p={
                url:ACCOUNTURL.SetPrivacyHuman,
                id:'human_privacy_id'
            };
            var s=setIndexController.l(p);
            HGS.Base.HAjax(s);
        })
    },
    /*
     * 功能：联系方式切换数据获取
     * 参数：
     * pram:url:异步请求链接,id提交id
     * 无
     */
    l:function(pram){        
        var that=setIndexRender;
        var contact_way=$("#chgenow").attr("rel"); 
        var id=$("#save").find("a.btn").attr("rel");
        var s={
            url:pram.url,
            params:pram.id+'='+id+'&contact_way='+contact_way,
            sucrender:that.d,
            failrender:that.e
        };   
        return s;
    },  
    /*
     * 功能：联系方式隐私设置切换
     * 参数：
     * 无
     */
    m:function(){        
        if($("#co_w li.first input").checked){
            $("#contract_w").slideDown();
        }
        $("#co_w li").click(function(){
            if($(this).hasClass("first")){
                $("#contract_w").slideDown();
            }else{
                $("#contract_w").slideUp();
            }
        });
    },  
     /*
     * 功能：人才页面初始化
     * 参数：
     * 无
     */
    IniPage:function(){
        baseRender.ae(0);
        setIndexController.a();
        setIndexController.c();
        setIndexController.k();
        //this.m();
    },
     /*
     * 功能：企业页面初始化
     * 参数：
     * 无
     */
    IniPage1:function(){
         baseRender.ae(0);
         setIndexController.a();
         setIndexController.e();
         setIndexController.j();
        //this.m();
    },
     /*
     * 功能：猎头页面初始化
     * 参数：
     * 无
     */
    IniPage2:function(){
        baseRender.ae(0);
        setIndexController.a();
        setIndexController.g();
        setIndexController.i();
        //this.m();
    }
};
$().ready(function(){
    if(typeof(PAGE)=="undefined"){
        PAGE="";
    }
    if(PAGE=="103"){//人才        
        setIndexController.IniPage();
    }
    if(PAGE=="104"){//企业
        setIndexController.IniPage1();
    }
    if(PAGE=="105"){//猎头
        setIndexController.IniPage2();
    }
});

