/* 
 * 角色首页渲染器
 */
var bdIndexRender={
    /*
     * 功能:换一换人才推荐数据模板生成
     * 参数：
     * data:插件返回结果,id生成模板容器id,varr模板变量名数组,arr,变量数组，tmp引用模板编号
     */     
    a:function(data){        
        var id='recman';        
        var varr=new Array('web_root','hm.id','hm.name','hm.photo');        
        var arr=new Array();        
        for(var i=0,length=data.data.length;i<length;i++){
            arr.push({
                'web_root':SWEBURL.UserDetail,
                'hm.id':data.data[i].id,
                'hm.name':data.data[i].name,
                'hm.photo':data.data[i].photo
            });                                   
        }                
        $("#recman").fadeOut("normal",function(){
            HGS.Base.GenTemp(id,varr,arr,TEMPLE.T00091);
            $(this).fadeIn("normal");            
//            baseController.LimitContr($(this).find("a"));//权限控制
        });
    },
    /* 
     * 功能:换一换人才推荐 添加换一换按键模块及绑定事件
     * 参数：data返回JSON数据     
     */
    aa:function(data){
        var count=data.data.length;
        if(count>=8){
            $("#rec").append(TEMPLE.T00100);
            var that=bdIndexController;
            that.a();
        }
    },
    /*
     * 功能：推荐人才 换一换功能ajax失败后获取
     * 参数：
     * data:插件返回结果
     */
    b:function(){
        var recman=$("#recman");
        var lt=recman.prev();
        if(lt.hasClass("Lt"))
            lt.remove();
        recman.parent().css("height","85px");
        recman.fadeIn(300);        
        recman.html(TEMPLE.T00101);
    },
    /*
     * 功能：推荐人才切换下一组数据加载等待
     * 参数：obj
     * obj:推荐人才标题,
     * recman:推荐人才obj
     * loadergif:加载等待
    */    
    c:function(obj){
        var recman=obj.next();                
        setTimeout("bdIndexRender.ca()",300);//300ms后调用加载等待
        if(!recman.hasClass('hgstemp'))
            recman.remove();      
    },
    /*
    * 功能：猎头页面换一换推荐 加载等待效果
    * 参数：
    */
    ca:function(){
        var loadergif='<ul><li class="loading"><p></p></li></ul>';
        var recman=$("#recman");               
        if(!$("#recman").children().length)
            recman.html(loadergif);
    },
    /*
     * 功能：换一换猎头推荐 添加换一换按键模块及绑定事件
     * 参数：data异步后返回JSON
    */
    d:function(data){       
        var count=data.data.length;
        if(count>=8){
            $("#recmidman").append(TEMPLE.T00100);
            var that=bdIndexController;
            that.ca();
        }
    },
    /*功能:幻灯
    * 参数：
    * sliderid:幻灯id
    * t1:幻灯滚动时间,
    * t2:切换时间,
    * t3:点击结束后启动幻灯时间
    */  
    dc:function(sliderid,t1,t2,t3){       
        var w=$("#"+sliderid).width();
        var wrap= $("#"+sliderid).children(".wrap");
        var count=wrap.children().length-1;    //可滚动条数
        var button=$("#"+sliderid).prev();                
        var butn=button.find("span");
        var br=button.children(".pr"); 
        var bl=button.children(".pl"); 
        var sumwidth=(count+1)*w;
        var left=0,r=1; 
        var autoslider=null;//初始循环
        var nextslide;//第二次setTimeout
        t1=t1*1000;
        t2=t2*1000+t1;
        t3=t3*1000;
        wrap.css("width",sumwidth);
        var auto=function(){                       
            if(r){ //右
                left=bdIndexRender.dd(sliderid,br,left,t1);
                if(left>=w*count)
                    r=0;
            }
            else{//左
                left=bdIndexRender.dd(sliderid,bl,left,t1);
                if(left<=0)
                    r=1
            }  
            autoslider=setTimeout(auto,t2);
        }
        setTimeout(auto,4000);
        butn.bind("click",function(){
            clearTimeout(nextslide);
            clearTimeout(autoslider); 
            var l=$("#recompanys").find(".wrap").attr("style").match(/[0-9]{1,}/g);
            if(!l[1])
                l[1]=0;           
            if(($(this).hasClass("pr")&&l[1]>=left)||($(this).hasClass("pl")&&l[1]<=left)){
                left=bdIndexRender.dd(sliderid,$(this),left,500);                     
                nextslide=setTimeout(auto,t3);
            }            
        });
        $("#"+sliderid).mouseover(function(){
            clearTimeout(nextslide);
            clearTimeout(autoslider);
        }).mouseout(function(){
            nextslide=setTimeout(auto,t3);
        });
    },
    /*功能:幻灯
    * 参数：
    * sliderid:幻灯id,
    * butn:当前滚动按键
    * t1:幻灯滚动时间,
    * left:当前定位的left值
    */ 
    dd:function(sliderid,butn,left,t1){      
        var w=$("#"+sliderid).width();
        var wrap= $("#"+sliderid).children(".wrap");
        var count=wrap.children().length-1;    //可滚动条数                     
        if(butn.hasClass("pr")){             //右
            left+=w;                                 
            butn.next().removeClass("stop").addClass("h");
            if(left>=w*count){
                left=w*count;                                             
                butn.removeClass("h").addClass("stop"); 
            }
        }else{
            left-=w;
            butn.prev().removeClass("stop").addClass("h");
            if(left<=0){       //左
                left=0;
                butn.removeClass("h").addClass("stop");
            }  
        }              
        wrap.animate({
            right:left
        },t1);        
        return left;
    },
    /*
     * 功能：猎头推送弹出框 - 关注成功
     * 参数：
     * data：异步后返回JSON
    */
    e:function(data){       
        var par=$("#careta").parent();
        var ppar=par.parent();
        par.remove();
        ppar.append('<p class="cared_btn"><span>已关注</span></p>');
    },
    /*
     * 功能：猎头推送弹出框 - 关注失败
     * 参数：
     * data：异步后返回JSON
    */
    f:function(data){       
        alert(data.data);
    }
}

