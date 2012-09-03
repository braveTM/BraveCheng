/* 
 * 顶级命名空间HGS
 */
if(typeof(HGS)=="undefined"){
    HGS = new Object||{};
}
/* 
 * 页面标志，用以加载不同页面所对应的js文件等
 */
if(typeof(PAGE)=="undefined"){
    var PAGE="";
}
PAGE=$("#loader").html().replace(/[\n\r]/gm,'').replace(" ","");
/*
 * 页面资源加载方法统一管理
 */
var PAGE_INI={
    /*资源管理页*/
    load95:function(){
        HGS.Base.LoadResourceResource();
    },
    /*修改人才资源详细页面*/
    load96:function(){
        HGS.Base.LoadResourceDetail();
    },
    /*修改企业资源详细*/
    load97:function(){
        HGS.Base.LoadResourceDetail();
    }
};
/* 
 * 二级命名空间Base，主要包含所有基本方法
 */
HGS.Base=function(){
    /* 
     * 功能：模板生成
     * 参数：
     * id：string 模板的父容器id
     * varr：Array 所有变量的名称的数组
     * arr：Array 模板中变量对应项的数据
     * tmp：string 模板编号
     */
    function GenTemp(id,varr,arr,tmp){
        var dom = $("#"+id);        
        if(dom.hasClass("hgstemp")){
            dom.html('');
            var temp=tmp.toString().replace(/[\n\r]/gm,'');
            var t='';
            var html='';
            $.each(arr,function(i,item){
                t=temp;                
                $.each(varr,function(i,o){
                    t=t.replace(new RegExp("{"+o+"}","g"),item[o]);
                });
                html=html+t;
            });
            dom.html(html);
        }
    }
    /*
     * 功能：混合模板生成
     * 参数：
     * id：string 模板的父容器id
     * varr：Array 多个模板所对应的所有变量的名称的数组,例如:var varr=[["",""],["","",""],...]
     * arr：Array 模板中变量对应项的数据（数组中需包含指定使用哪个模板的元素 temp -> 其值对应tmp里的指定项）
     * tmp：Array 模板数组,例如:var tmp=["temp1","temp2",...]
     */
    function GenMTemp(id,varr,arr,tmp){
        var dom = $("#"+id);
        if(dom.hasClass("hgstemp")){
            dom.html('');
            $.each(tmp,function(i,o){
                o=o.toString().replace(/[\n\r]/gm,'');
            });
            var t='';
            var num=0;
            var ivarr=null;
            var html='';
            $.each(arr,function(i,item){
                num=item.temp;
                t=tmp[num];
                ivarr=varr[num];
                $.each(ivarr,function(i,o){
                    t=t.replace(new RegExp("{"+o+"}","g"),item[o]);                    
                });                
                html=html+t;                
            });
            dom.html(html);
        }
    }
    /* 功能：实现类的扩展
     * 参数：
     * Child：object 派生类
     * Parent：object 父类
     */
    function Extend(Child, Parent){
        var F = function(){};
        F.prototype = Parent.prototype;
        Child.prototype = new F();
        Child.prototype.constructor = Child;
        Child.superclass=Parent.prototype;
        if(Parent.prototype.constructor == Object.prototype.constructor){
            Parent.prototype.constructor = Parent;
        }
    }
    /* 功能：异步后台方法访问
     * 参数：
     * settings：object 异步配置项参数
     * 格式：var settings={
     *          url:"",         //必需配置项，后台方法访问路径，不能为空
     *          params:"",      //必需配置项，后台方法参数，可为 ""
     *          sucrender:null, //异步成功后页面渲染方法对象，可为null
     *          failrender:null //异步失败后页面渲染方法对象，可为null
     *      };
     * 无
     */
    function HAjax(settings,async){
        var res=null;
        if(async!=false){
            async=true;
        }
        $.ajax({
            async: async,
            type: "POST",
            url: settings.url+"",
            data: settings.params+"",
            dataType: "jsonp",
            jsonp: "jsoncallback",
            success: function (jsonp) {
                if(jsonp!=null&&jsonp!=""){
                    var r=eval(jsonp);                    
                    r.ret=typeof(r.ret)=="undefined"?false:r.ret;
                    if(async){
                        if(r.ret==true){
                            var sr=settings.sucrender;
                            if(typeof(sr)!="undefined"&&sr!=null){
                                sr(r);
                            }
                        }
                        else{
                            var fr=settings.failrender;
                            if(typeof(fr)!="undefined"&&fr!=null){
                                fr(r);
                            }
                        }
                    }
                    else{
                        res=r;
                    }
                }
            }
        });
        if(async==false){
            return res;
        }
    }
    /* 功能：登录
     * 参数：
     * a：用户名
     * b：用户密码
     * c：是否记住登录状态
     * d：回调方法名
     * sf：退出成功执行方法
     * ff：退出失败执行方法
     * 返回值：true || false
     */
    function Login(a,b,c,d,sf,ff){
        var s={
            url:WEBURL.Login,
            params:"uname="+a+"&pword="+b+"&rem="+c+"&&func="+d,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(s);
    }
    /* 功能：退出
     * 参数：
     * sf：退出成功执行方法
     * ff：退出失败执行方法
     * 返回值：true || false
     */
    function Exit(sf,ff){
        var s={
            url:WEBURL.Exit,
            params:"",
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(s);
    }
    /* 功能：存储cookie
     * 参数：
     * c_name：cookie的名称
     * value：cookie的值
     * expiredays：cookie存储时间
     */
    function SetCookie(c_name,value,expiredays){
        var exdate=new Date()
        exdate.setDate(exdate.getDate()+expiredays)
        document.cookie=c_name+ "=" +escape(value)+((expiredays==null) ? "" : ";expires="+exdate.toGMTString())+";path=/";
    }
    /* 功能：读取cookie
     * 参数：
     * c_name：cookie的名称
     */
    function GetCookie(c_name){
        if(document.cookie.length>0){
            var c_start=document.cookie.indexOf(c_name + "=");
            var c_end='';
            if(c_start!=-1){
                c_start=c_start + c_name.length+1;
                c_end=document.cookie.indexOf(";",c_start);
                if (c_end==-1) c_end=document.cookie.length;
                return unescape(document.cookie.substring(c_start,c_end));
            }
        }
        return "";
    //     var arr = document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)"));
    //     if(arr != null) return unescape(arr[2]); return "";
    }
    /* 功能：删除cookie
     * 参数：
     * c_name：cookie的名称
     */
    function DelCookie(c_name){
        var exp = new Date();
        exp.setTime(exp.getTime() - 1);
        var cval=HGS.Base.GetCookie(c_name);
        if(cval!=null) document.cookie= c_name + "="+cval+";expires="+exp.toGMTString()+";path=/";
    }
    /* 功能：动态加载页面资源文件（js和css）
     * 参数：
     * 无
     */
    function LoadPageSource(){
        var sn=SOURCENAME;
        
        In.add('p1',{
            path:sn.R0001,
            type:'js',
            charset:'utf-8'
        });
        In.add('p2',{
            path:sn.M0005,
            type:'js',
            charset:'utf-8',
            rely:['p1']
        });
        In.add('p3',{
            path:sn.CT0001,
            type:'js',
            charset:'utf-8',
            rely:['p2']
        });
        In('p1','p2','p3',function() {
            if(typeof(PAGE)=="undefined"){
                PAGE="";
                return;
            }
            var func=PAGE_INI["load"+PAGE];
            if(func!=null){
                func();
            }
        });
    }
    /******************************************CRM系统部分***********************************************/
    /*
      *功能：加载资源管理页面文件 Crm_CIndex_index
      *参数：无
      *2012-4-9
     */
    function LoadResourceResource(){
       var sn=SOURCENAME;
       var cr=CRMURLROOT;
              
       In.add('p8',{path:sn.c_M0002,type:'js',charset:'utf-8'});
       In.add('p1',{path:sn.c_M0001,type:'js',charset:'utf-8',rely:['p8']});       
       In.add('p2',{path:sn.r_Rn0001,type:'js',charset:'utf-8',rely:['p1']});
       In.add('p3',{path:sn.c_CT0001,type:'js',charset:'utf-8',rely:['p2']});
       In.add('p4',{path:sn.L0006,type:'js',charset:'utf-8'});
        In.add('p5',{path:sn.L0013,type:'js',charset:'utf-8'});
       In.add('p6',{path:sn.L0001,type:'js',charset:'utf-8'});
       In.add('p7',{path:sn.c_L0001,type:'js',charset:'utf-8'});       
       In('p1','p2','p3','p4','p5','p6','p7','p8');
    }
     /*
      *功能：加载客户资源详细页面文件 Crm_CCHuman_index/Crm_CCompany_index
      *参数：无
      *2012-4-9
     */
      function LoadResourceDetail(){
       var sn=SOURCENAME;
       var cr=CRMURLROOT;
       
       In.add('p8',{path:sn.c_M0002,type:'js',charset:'utf-8'});
       In.add('p1',{path:sn.c_M0001,type:'js',charset:'utf-8',rely:['p8']});       
       In.add('p2',{path:sn.r_Rn0002,type:'js',charset:'utf-8',rely:['p1']});
       In.add('p3',{path:sn.c_CT0002,type:'js',charset:'utf-8',rely:['p2']});
       In.add('p4',{path:sn.L0013,type:'js',charset:'utf-8'});
       In.add('p5',{path:sn.L0003,type:'js',charset:'utf-8'}); 
       In.add('p6',{path:sn.L0001,type:'js',charset:'utf-8'});
       In.add('p7',{path:sn.c_L0001,type:'js',charset:'utf-8'});
       In('p1','p2','p3','p4','p5','p6','p7','p8');
    }
    return{
        GenTemp:GenTemp,/*模板生成*/
        GenMTemp:GenMTemp,/*多模板生成*/
        Extend:Extend,
        HAjax:HAjax,/*异步公用方法*/
        Exit:Exit,/*退出*/
        Login:Login,/*弹出框方式登录*/
        SetCookie:SetCookie,/*设置cookie*/
        GetCookie:GetCookie,/*读取cookie*/
        DelCookie:DelCookie,/*删除cookie*/
        LoadPageSource:LoadPageSource,/*加载页面公用资源*/
        /******************************CRM系统部分***************************************/
        LoadResourceResource:LoadResourceResource,/*CRM资源加载*/
        LoadResourceDetail:LoadResourceDetail/*CRM资源详细页*/
    }
}();
