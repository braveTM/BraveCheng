/*市场指导价页面渲染*/
var toolRender={
   /*
    *选择证书条件获取走势
    *参数：无
    *jack
    *2012-3-22
    */
   a:function(r){
        var mname="";
        var that=r.obj;
        if(r.majname!=""){mname=" - "+r.majname;}
        var txt=r.cname+mname;
        that.val(txt);  
        that.data("mid",r.maj);
        that.data("zid",r.zid);
        if(that.data("mid")){
            $("input#zid").val(r.maj);
        }else{
            $("input#zid").val(r.zid);
        }
        ToolContrller.i();
   },
   /*
    *获取市场行情-本月交易价数据
    *参数：无
    *2012-3-24
    */
   b:function(data){
        var count=toolRender.d(data);
        ToolContrller.a(count,"#Pagination",ToolContrller.f);
   },
   /*
    *获取异步数据失败
    *参数：无
    *2012-3-24
    */
   c:function(){
       ToolContrller.a(0,"#Pagination",ToolContrller.f);
      $("#marketlist").html("<li class='no-data'>暂无相关数据!</li>");
   },
    /*
    *处理异步获取数据
    *参数：无、
    *2012-3-24
    */
   d:function(data){
        var dt=data.data;
        var count=data.count;
        $.each(dt,function(i,o){
            if(o.trend==1){
                o.trend="";
            }else if(o.trend==2){
               o.trend="dwnprice";
            }else{
             o.trend="eqprice";
            }
        });
        var tmp=[];
        tmp=TEMPLE.T00086;
        var varr=['name','i_price','c_price','trend'];
        HGS.Base.GenTemp("marketlist",varr,dt,tmp);
        return count;
   },
   /*
    *获取走势数据成功
    *参数：无
    *2012-3-25
    */
   e:function(ret){
       var d1=[0,0,0,0,0,0,0,0,0,0,0,0];
       var d2=[0,0,0,0,0,0,0,0,0,0,0,0];
        var lines = ret.data;
        $.each(lines, function(lineNo, line) {
            var lm=line.month;//月份
            d1[lm-1] = line.iave_price;
            d2[lm-1] = line.cave_price;
         });
        var options={
            chart: {
                renderTo: 'mbox',
                type: 'line',
                marginRight: 130,
                marginBottom: 25
            },
            colors:['#f27132','#a244d2'],//曲线颜色
            plotOptions:{
                series:{
                    marker:{
                        radius:4,
                        symbol:'circle'
                    }
                }
            },//数据点配置
            tooltip:{
               formatter:function(){
                    var unit = this.series.name;
                  return this.x+unit+"平均成交价:"+'<b>'+this.y+'</b>万/年' ;
               } 
            },//提示配置
            credits:{
               enabled:false
            },
            title: {
                text: '',
                x: -20 //center
            },
            xAxis: {
                categories: ['1月', '2月', '3月', '4月', '5月', '6月',
                    '7月', '8月', '9月','10月', '11月', '12月']
            },
            legend:{
                verticalAlign:'middle',
                layout:'vertical',
                align:'right',
                x:-10,
                y:0,
                borderWidth:0
            },
            yAxis: {
                fillcolor:"#fff",
                title:{
                  text:'平均成交价'
                },
               min:0,
               labels:{
                   formatter:function(){
                       return this.value+'万/年';
                   }
               }
            },
            series: [{
                name:'兼职初始注册',
                data:d1
            },{
                 name:'兼职变更注册',
                 data:d2
            }]
        }; 
      var chart = new Highcharts.Chart(options);
   },
   /*
    *获取走势数据失败
    *参数：无
    *2012-3-25
    */
   f:function(){
       $("#mbox").html('<p class="no-data"><b class="red">!</b>对不起,暂无相关数据</p>');
   },
   
   /*
    *获取走势数据成功
    *参数：无
    *2012-3-25
    */
   g:function(ret){
       var d1=[0,0,0];
       var d2=[0,0,0];
        var dt = ret.data;
        $.each(dt, function(i, o) {
            var k=parseInt(o.year,10)-2010;
            d1[k] = parseFloat(o.i_price,10);
            d2[k] = parseFloat(o.c_price,10);
         });
        var options={
            chart: {
                renderTo: 'mbox',
                type: 'line',
                marginRight: 130,
                marginBottom: 25
            },
            colors:['#f27132','#a244d2'],//曲线颜色
            plotOptions:{
                series:{
                    marker:{
                        radius:4,
                        symbol:'circle'
                    }
                }
            },//数据点配置
            tooltip:{
               formatter:function(){
                    var unit = this.series.name;
                  return this.x+unit+"平均成交价:"+'<b>'+this.y+'</b>万/年' ;
               } 
            },//提示配置
            credits:{
               enabled:false
            },
            title: {
                text: '',
                x: -20 //center
            },
            xAxis: {
                categories: ['2010年', '2011年', '2012年']
            },
            legend:{
                verticalAlign:'middle',
                layout:'vertical',
                align:'right',
                x:-10,
                y:0,
                borderWidth:0
            },
            yAxis: {
                fillcolor:"#fff",
                title:{
                  text:'平均成交价'
                },
               min:0,
               labels:{
                   formatter:function(){
                       return this.value+'万/年';
                   }
               }
            },
            series: [{
                name:'兼职初始注册',
                data:d1
            },{
                 name:'兼职变更注册',
                 data:d2
            }]
        }; 
      var chart = new Highcharts.Chart(options);
   }
};