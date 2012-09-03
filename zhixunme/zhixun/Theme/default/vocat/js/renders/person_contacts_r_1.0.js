/*我的人脉渲染器*/
var personnetRender={
    /*
     *功能：成功获取我关注的人
     *参数：无
     *jack
     *2012-2-20
     */
    a:function(data){
        var count=personnetRender.c(data);
        personnetController.a(count,"#pagination2",personnetController.c);
        personnetRender.f();
    },
    /*
     *功能：获取我关注的人失败
     *参数：无
     *jack
     *2012-2-20
     */
    b:function(ret){
       personnetController.a(0,"#pagination2",personnetController.c);
       $("#focus_person").html("<li class='no-data'>暂无相关数据</li>");
    },
    /*
     *获取异步数据，生成我所关注的人才|企业|猎头列表
     *jack
     *2012-2-20
     */
    c:function(data){
         var dt=data.data;
        var count=data.count;
        var mytemp=[];
        var cert='';
        var rz;
        mytemp[0]=personnetRender.d("1");//人才
        mytemp[1]=personnetRender.d("2");//企业
        mytemp[2]=personnetRender.d("3");//猎头
        $.each(dt,function(i,o){
            //公共部分
            o.u_photo=o.photo;
            o.u_name=o.name;     
            rz=baseRender.zh(o.real_auth,o.phone_auth,o.email_auth);
            o.email_auth=rz.mil;
            o.phone_auth=rz.pho;
            o.real_auth=rz.nam;
            o.ntitle=rz.tnam;
            o.ptitle=rz.tpho;
            o.mtitle=rz.tmil;              
            o.u_id=o.user_id;
            o.focus_id=o.user_id;
            o.hflow="";
            o.follow="";
            o.fname="";
            o.certs=cert;
            if(o.type==1){
                o.temp=0;
                o.role="人才";
                if(typeof(o.certs)=="undefined"){o.certs=[];}
                 $.each(o.certs,function(k,item){
                   cert+='<p><span class="gray">证书情况: </span><span>'+item+'</span></p>';
                });
            }
            else if(o.type=="2"){
                o.temp=1;
                o.role="企业";//企业
            }
            else if(o.type=="3"){
                o.temp=2;
                o.role="猎头";//猎头
            }else{
                dt[i]=null;
            }
        });
        var varr=[];
        varr[0]=['role','fname','hflow','focus_id','user_id','u_photo','u_name','name','real_auth','email_auth','phone_auth','ntitle','ptitle','mtitle','location','active','follow','certs',"ntitle","ptitle","mtitle"];
        varr[1]=['role','fname','hflow','focus_id','user_id','u_photo','u_name','name','real_auth','email_auth','phone_auth','ntitle','ptitle','mtitle','summary','location','active','follow',"ntitle","ptitle","mtitle"];
        varr[2]=varr[1];
        HGS.Base.GenMTemp("focus_person",varr,dt,mytemp);
        $("#focus_person div.info p:last-child").addClass("lst_p");
        baseController.RemoveFocusPerson("#focus_person a.unfocus");
        return count;
    },
    /*
     *返回生成的模板
     *参数：无
     *jack
     *2012-2-20
     */
    d:function(type){
        var tmp=TEMPLE;
        var show='';
        var mtmp='';
        var rtmp='';
        var ltmp='';
       ltmp=tmp.T00040;
       rtmp=tmp.T00071;
       if(type=="1"){
           show="{certs}";
       }else{
           show=tmp.T00072;
       }
       mtmp=tmp.T00070.replace('{show}',show);
       return baseController.GenBListTemp(ltmp,mtmp,rtmp);
    },
    /*
     *获取人脉动态列表成功
     *参数：无
     *jack
     *2012-2-20
     */
    ret_suc:function(data){
        var count=personnetRender.gen_netList(data);
        personnetController.a(count,"#pagination1",personnetController.f);
        personnetRender.f();
    },
    /*
     *获取人脉动态列表失败
     *参数：无
     *jack
     *2012-2-20
     */
    ret_fail:function(data){
       personnetController.a(0,"#pagination1",personnetController.f);
       $("#dynamic").html("<li class='no-data'>暂无相关数据</li>");
    },
    /*异步获取人脉动态数据成功生成列表
     *参数：无
     *jack
     *2012-2-20
     */
    gen_netList:function(data){
        var dt=data.data;
        var count=data.count;
        var mytmp=[];
        mytmp[0]=personnetRender.e();
        $.each(dt,function(i,o){
            //公共部分
            o.temp=0;
            if(o.role=="1"){
                o.role="";//人才
            }else if(o.role=="3"){
                o.role="猎头";//猎头
            }else{
                o.role="企业";//企业
            }
            o.u_id=o.user_id;
            o.focus_id=o.user_id;
            o.hflow="";
            o.follow="";
            o.fname="";
        });
        var varr=[];
        varr[0]=['follow','role','fname','hflow','focus_id','user_id','photo','name','date','content','action'];
        HGS.Base.GenMTemp("dynamic",varr,dt,mytmp);
        $("#dynamic div.identify").remove();
        $("#dynamic div.info p:last-child").addClass("lst_p");
        return count;
    },
    /*生成公共模板*/
    e:function(){
       var tmp=TEMPLE;
        var mtmp=tmp.T00073;
        var ltmp=tmp.T00039;
        var rtmp="";;
       return baseController.GenBListTemp(ltmp,mtmp,rtmp);
    },
    /*
     *列表回滚
     *参数：无
     */
    f:function(){
         $("html,body").animate({
            scrollTop:$("body").offset().top
        },500);
    }
};
