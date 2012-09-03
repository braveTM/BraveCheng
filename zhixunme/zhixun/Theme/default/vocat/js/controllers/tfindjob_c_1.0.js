/*
 * 人才首页控制器
 */
var TFindJobController={
    /*
     * 功能：初始化翻页插件
     * 参数：
     * id：分页插件的父容器id
     * t：总共的条数
     * id:翻译插件绑定id
     * func:翻页回调函数
     */
    a:function(t,id,func){
        var lan=LANGUAGE;
        $(id).pagination(t, {
            callback: func,
            prev_text: lan.L0066,
            next_text: lan.L0067,
            items_per_page:CONSTANT.C0004,
            num_display_entries:9,
            current_page:0,
            num_edge_entries:1,
            link_to:"javascript:;"
        });
    },
    /*
     * 功能：获取人才感兴趣的职位列表
     * 参数：
     * 无
     */
    b:function(i){
        var that=tfjobRender;
        TFindJobController.d(i, that.b, that.c);
    },
    /*
     * 功能：人才感兴趣的职位列表分页回调函数
     * 参数：
     * 无
     */
    c:function(i){
        var that=tfjobRender;
        TFindJobController.d(i, that.d, that.c);
        that.a();
    },
    /*
     * 功能：获取人才感兴趣的职位数据
     * 参数：
     * i:当前页
     * id：
     * suc:成功获取数据时的方法
     * fail:失败获取数据时的方法
     */
    d:function(i,suc,fail){
        var par=$("#jobfilter");
        var c=par.find("span.filt_type a.red").attr("tp"),
            d=par.find("span.filt_role a.red").attr("rol");
        if(typeof(i)=="undefined"){i=0;}
        i+=1;
        var job=new Jobs();
        job.GetTInteJobs(i, CONSTANT.C0004, c, d, suc, fail);
    },
    /*
     * 功能：人才感兴趣的职位 排序方式点击事件绑定
     * 参数：
     * 无
     */
    e:function(){
        $("#jobfilter a").click(function(){
            $(this).parent().find("a").removeClass("red");
            $(this).addClass("red");
            TFindJobController.b(0);
        });
    },
    /*
     * 功能：人才找职位 投递简历
     * 参数：
     * 无
     */
    f:function(obj){
        var sr=$(obj);
        sr.unbind("click");
        sr.bind("click",function(){
           var a=$(this).parent().parent().prev().find("a.jtitle").attr("jid");
           var that=tfjobRender;
           var res=new Resume();
           var job=$(this).parent().parent().prev().children("p").first().find("span.red");
           $("#joblist").data("job",job);
           res.SendResume(a, that.f, that.g);
        });
    },
    /*
     * 功能：获取人才应聘过的职位列表
     * 参数：
     * 无
     */
    g:function(i){
        var that=tfjobRender;
        TFindJobController.i(i, that.h, that.i);
    },
    /*
     * 功能：人才应聘过的职位列表分页回调函数
     * 参数：
     * 无
     */
    h:function(i){
        var that=tfjobRender;
        TFindJobController.i(i, that.j, that.i);
        that.a();
    },
    /*
     * 功能：获取人才应聘过的职位数据
     * 参数：
     * i:当前页
     * id：
     * suc:成功获取数据时的方法
     * fail:失败获取数据时的方法
     */
    i:function(i,suc,fail){
        var par=$("#ojobfilter");
        var c=par.find("span.filt_type a.red").attr("tp"),
            d=par.find("span.filt_role a.red").attr("rol");
        if(typeof(i)=="undefined"){i=0;}
        i+=1;
        var job=new Jobs();
        job.GetTCDJobs(i, CONSTANT.C0004, c, d, suc, fail);
    },
    /*
     * 功能：人才应聘过的职位 排序方式点击事件绑定
     * 参数：
     * 无
     */
    j:function(){
        $("#ojobfilter a").click(function(){
            $(this).parent().find("a").removeClass("red");
            $(this).addClass("red");
            TFindJobController.g(0);
        });
    },
/**********************************************    意向职位   *******************************************/
    /*
     * 功能：获取意向职位列表
     * 参数：
     * 无
     */
    k:function(i){
        var that=tfjobRender;
        TFindJobController.m(i, that.l, that.m);
    },
    /*
     * 功能：意向职位列表分页回调函数
     * 参数：
     * 无
     */
    l:function(i){
        var that=tfjobRender;
        TFindJobController.m(i, that.n, that.m);
        that.a();
    },
    /*
     * 功能：获取意向职位数据
     * 参数：
     * i:当前页
     * id：
     * suc:成功获取数据时的方法
     * fail:失败获取数据时的方法
     */
    m:function(i,suc,fail){
        var par=$("#wjobfilter");
        var a=par.find("span.filt_role a.red").attr("rol");
        if(typeof(i)=="undefined"){i=0;}
        i+=1;
        var job=new Jobs();
        job.TGetWantJobs(a, i, CONSTANT.C0004, suc, fail);
    },
    /*
     * 功能：意向职位 排序方式点击事件绑定
     * 参数：
     * 无
     */
    n:function(){
        $("#wjobfilter a").click(function(){
            $(this).parent().find("a").removeClass("red");
            $(this).addClass("red");
            TFindJobController.k(0);
        });
    },
  /*********职位搜索start*************/
    /*
    * 功能：初始化地区选择插件
    * 参数：无
    * author:joe 2012/7/27
    */
    aa:function(){
        $("#place").hgsSelect({
            type:'place',    //default:资质添加，place：地区添加，jobtitle：职称添加
            pid:"pslt",            //省市添加的父容器id
            lishow:true,
            pshow:true,       //是否显示地区选择
            sprov:true,       //是否只精确到省
            single:true,       //省是否为单选
            sure:tfjobRender.aa
        })
    },    
    /*
    * 功能：初始化搜索框|筛选条件|高级搜索事件绑定
    * 参数：无
    * author:joe 2012/7/27
    */
    ab:function(){
        var that=tfjobRender;
        that.ab();
        that.ac();
        that.ad();
        that.ae();       
    },
    /*
     * 功能：翻页事件绑定
     * 参数：
     * id:分页插件的父容器id
     * author:joe
     */
    ae:function(){
        var p=$("#pagination");
        $("#prev").click(function(){
            if(!$(this).hasClass("gray")){
                p.find("a.prev").trigger("click");             
            }
        });
        $("#next").click(function(){
          if(!$(this).hasClass("gray")){
              p.find("a.next").trigger("click");             
          }
        });
    },
     /*
     * 功能：header翻页样式同步
     * 参数：
     * sp:当前页
     * author:joe
     */
    _ea:function(sp){
        sp=sp||1;                
        var ep=$("#pagination").attr("ep");                   
        var pagehtm=sp+'/'+ep;
        $("#prev").next().html(pagehtm);   
        $("#prev,#next").removeClass("gray");
        if(sp==ep){//结束向后翻页
            $("#next").addClass("gray");
        }
        if(sp==1){//结束向前翻页
            $("#prev").addClass("gray");
        }
    },
    /*
     *功能：触发搜索事件绑定
     *参数：无
     *@author：joe
     */
    ag:function(){
        var that=tfjobRender;
        $("#advance").find("a").unbind("click").bind("click",function(){//高级搜索
            $(this).siblings("a.sel").removeClass("sel");
            $(this).addClass("sel");            
            TFindJobController.aj(1);            
        });
        $("#hotwords").find("a").unbind("click").bind("click",function(){//热门关键词
            $("#keywords").val($(this).text()).attr("rel",$(this).text());//区别搜索与条件筛选            
            that.al();
            TFindJobController.aj(1);
        })
        that.af();//排序方式
    },
    /*
     *功能：搜索按键后提交
     *参数：无
     *@author：joe
     */
    ah:function(){
        $("#search").unbind("click").bind("click",function(){
            if($("#keywords").val()=="请输入您要找的职位"){
                $("#keywords").trigger("focus") ;
            }else{
                tfjobRender.al();
                TFindJobController.aj();
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
     * page 当前页
     * author:joe 2012/7/27
     */
    ai:function(i,page){
        var require_place=0,//要求地区
        salary=0,//待遇
        pub_date=0,//发布时间
        cert_type=2,//资质证书
        word,//关键词
        is_real_auth=2,//认证用户
        page=page||1,//当前页
        size=10,//每页条数
        order=0;//排序方式        
        var salarys=$("#advance").find("li.salary");
        var pubs=$("#advance").find("li.pub_date");
        var orders,up,down,params='';
        word=$("#keywords").val();   
        if(word=="请输入您要找的职位")
            word='';
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
                    params=o+'='+item;
                else
                    params+='&'+o+'='+item;
                i++;
            }
        });
        return params;
    },
    /*
     * 功能：职位搜索
     * 参数：   
     * i:1  多条件搜索  
     * page:当前页
     * author:joe 2012/7/27
     */
    aj:function(i,page,suc,fail){
        var params=TFindJobController.ai(i,page);        
        var job=new Jobs();  
        var that=tfjobRender;
        suc=suc||that.ah;
        fail=fail||that.ai;
        TFindJobController.am("findjoblist");
        job.SearchJob(params,0,suc,fail);
    },
    /*
     * 功能：职位搜索分页回调
     * 参数：
     * page:当前页
     * author:joe 2012/7/28
     */
    ak:function(page){
        var that=tfjobRender;
        page=page+1;
        TFindJobController.aj(1,page,that.aj,that.ai);        
        TFindJobController._ea(page);
        $("html,body").scrollTop(0);       
    },
    /*
     * 功能：职位搜索获取数据
     * 参数：
     * page:当前页
     * i:1  多条件搜索  
     * author:joe 2012/7/28
     */
    al:function(page,i){
        var that=tfjobRender;
        i=i||0;
        TFindJobController.aj(i,page,that.ah,that.ai);        
    },
    /*
     * 功能：加载等待
     * 参数：
     * id:加载区id          
     * 
     */
    am:function(id){
        var tmp=TEMPLE;
        $("#"+id).html(tmp.T00113);    
        $("#pagination").hide();
    },
    /*********职位搜索end*************/
    /*
     * 功能：初始化
     * 参数：无
     */
    IniPage:function(){
        baseRender.ae(2);
        this.b(0);
        this.g(0);
        this.k(0);
        this.e();
        this.j();
        this.n();
        this.aa();
        this.ab();        
        this.ae();
        this.ag();
        this.ah();        
        this.al(0); 
    }
};
$().ready(function(){
    if(typeof(PAGE)=="undefined"){
        PAGE="";
    }
    //根据PAGE来初始化页面
    if(PAGE=="39"){
        //初始化页面js等
        TFindJobController.IniPage();
    }
});