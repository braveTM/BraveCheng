/*资讯控制器*/
var InformationController={
    /*
     * 功能：资讯详细|初始化文章的内容格式
     * 参数：
     * 无
     */
    a:function(){
        var that=$("#infodata");
        var cont='';
        if(that.attr('btype')=="1"){
            cont=that.val().replace(new RegExp("{nbsp}","g"),"&nbsp;").replace(new RegExp("&lt;br/&gt;","g"),"<br/>");
            $("#infocont").html(cont);
        }
        $("div.loading").fadeOut(10);
        $("#infocont").fadeIn(100);
    },
    /*
     * 功能：初始化翻页插件
     * 参数：
     * id：分页插件的父容器id
     * t：总共的条数
     * id:翻页插件绑定id
     * func:翻页回调函数
     */
    b:function(t,func){
        var cur=$("input[name='cpge']").val();
        cur=cur-1;
        var lan=LANGUAGE;
        $("#pagination1").pagination(t,{
            callback:func,
            prev_text: lan.L0066,
            next_text: lan.L0067,
            items_per_page:CONSTANT.C0003,
            num_display_entries:9,
            current_page:cur,
            num_edge_entries:2,
            link_to:"javascript:;"
        });  
        if(!func)
            this.ba();
    },
     /*
     * 功能：翻页href初始化绑定
     * 参数：
     * author:joe
     */
    ba:function(){
        var href=$("input[name='href']").val();
        var pagination=$("#pagination1");
        var pages=pagination.find("a").not(".prev").not(".next");
        pagination.find("a").unbind("click").bind("click",function(){
            return ture;
        })
        var phref='';
        var selp=pagination.find("span.current").not(".prev").not(".next").text()*1;
        $.each(pages,function(i,item){          
            phref=href+item.innerHTML;
            item.href=phref;          
        });
        var pre=pagination.find("a.prev");
        var next=pagination.find("a.next");
        pre.attr("href",href+(selp-1));
        next.attr("href",href+(selp+1));        
    },
    /**********************资讯列表页面数据操作*******************************/
    /*
     *功能：分页回调保存当前页面索引
     *参数：无
     *@author：jack
     */
    d:function(){
        var href=$("input[name='href']").val();
        var o=$("div.pagination").find("span.current").not(".prev").not(".next").text();
        window.location.href=href+o;
    },
    /*
     *功能：分页效果初始化
     *参数：无
     *@author：jack
     */
    e:function(){
        var that=InformationController;
        var count=$("input[name='total']").val();
        if(count==0){
            count=1;
        }
        that.b(count);
    },
    /*
     * 功能：资讯详细|资讯|推荐职场经验列表 - 赞一下
     * 参数：
     * i：第几页
     * suc：成功回调方法
     * fail：失败回调方法
     */
    m:function(obj){
        $(obj).unbind("click").bind("click",function(){
            var a=$(this).attr("bid");
            $("a.good:eq(0)").data("prise",this);
            var that=informationRender;
            var info=new Information();
            if($(this).attr("id").substring(8)=="1"){
                info.blogPraise(a, that.g, that.h);
            }else{
                info.InfoPraise(a, that.g, that.h);
            }
        });
    },
    /*
     * 功能：举报职场经验绑定事件
     * 参数：无
     * @author:Jhon
     */
    an:function(){        
        $("#report_artcl").unbind("click").bind("click",InformationController.ao);        
        $("#report_artcl1").unbind("click").bind("click",InformationController.ao);        
    },
    /*
     * 功能：举报职场经验
     * 参数：无
     * @author:Jhon
     */
    ao:function(){
        var newtype=2;//举报职场经验
        var blog_id=$("#praise0_1").attr("bid")*1;
        var url=WEBURL.RerportSpam;
        url+='/'+newtype+'/'+blog_id;
        var that=baseRender;                
        that.OpenWin(url,600,600);
    },
    /*
     * 功能：发布排行榜hover
     * 参数：无
     * @author:Jhon
     */
    ap:function(){      
        var that=informationRender;                
        that.ac();
    },
    /*
     * 功能：分享绑定
     * 参数：无
     * @author:Jhon
     */
    aq:function(obj){           
        $(obj).unbind("click").bind("click",function(){
            var par=$(this),sum,pic;
            var type=par.attr("tp"),
            tit=par.attr("tit"),                 
            ur=par.attr("ur");                                                                           
            if($("#infocont").length){
                sum=$("#infocont").text();
                sum=sum.substr(0,200);
                pic=$("div.publisher").find("img").not("img.lit_small").attr("src");
            }
            else{
                sum=$(this).parents("div.info,div.bdetail").find("p.des,div.z_deil").text();
                pic=$(this).parents("div.info").prev("div.photo").find("img").attr("src");
            }                        
            zxshare(type,[tit,ur,'',sum,pic]);
        });
        $("div.z_deil").text().replace(new RegExp("{nbsp}","g"),"&nbsp;").replace(new RegExp("&lt;br/&gt;","g"),"<br/>");
    },
    /***************************资讯详细页面数据操作***********************************/
    /*
     * 功能：初始化资讯列表页
     * 参数：无
     */
    IniPage:function(){
        this.e();
        this.aq("#texp li div.shares a.share");
    },
    /*
     * 功能：初始化资讯详细页
     * 参数：无
     */
    IniPage1:function(){
        this.a();
        this.m($("a.good"));
        this.an();
        this.aq($("#share1 a.share,#share2 a.share"));        
    },
    /*
     * 功能：初始化资讯首页
     * 参数：
     * 无
     */
    IniPage2:function(){
        this.ap();
        this.aq("#exp_list li div.shares a.share,#majinfo li div.shares a.share");
    }
};
$().ready(function(){
    if(typeof(PAGE)=="undefined"){
        PAGE="";
    }
    var that=InformationController;
    /*资讯列表页*/
    if(PAGE=="92"){
        that.IniPage();
    }
    /*资讯详细页*/
    if(PAGE=="93"){
        that.IniPage1();
    }
    /*资讯首页*/
    if(PAGE=="89"){
        that.IniPage2();
    }

});
