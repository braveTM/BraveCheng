/* 
 * 
 * 隐私设置渲染
 * 
 */
var setIndexRender={
    /*
     * 功能：保存隐私设置成功后执行
     * 参数：
     * 无
     */
    a:function(data){
        alert("保存成功!");
    },
    /*
     * 功能：保存隐私设置失败后执行
     * 参数：
     * 无
     */
    b:function(data){
        alert("保存失败!");
    },
    /*
     * 功能：时段选择
     * 参数：
     * 无
     */
    c:function(){
      $('#stime input').ptTimeSelect();
    },
    /*
     * 功能：联系方式切换成功
     * 参数：
     * 无
     */
    d:function(){
       alert('成功切换当前联系方式!',"right",true,"",function(){
            location.reload();
        });           
    },
     /*
     * 功能：企业|人才联系方式切换失败
     * 参数：
     * 无
     */
    e:function(data){        
         var callback=function(){
             $("#select").unbind("click").bind("click",function(){
                 location.href=WEBROOT+'/profiles/3 ';
             })               
        }; 
         baseController.InitialSureDialog("error",data.data, "select",'去认证',callback);        
    },
     /*
     * 功能：猎头联系方式切换失败
     * 参数：
     * 无
     */
    ea:function(data){        
         var callback=function(){
             $("#select").unbind("click").bind("click",function(){
                 location.href=WEBROOT+'/profiles/2 ';
             })               
        }; 
         baseController.InitialSureDialog("error",data.data, "select",'去认证',callback);        
    },
      /*
     * 功能：设置接听添加时段事件绑定
     * 参数：
     * 无
     */
    f:function(){
        var temp='<div class="addtime"><input type="text" readonly="readonly" value="" class="gray" name="t1" />-'
                +'<input type="text" readonly="readonly" class="gray" value="" name="t2" />'
                +'<a class="blue del" href="javascript:;">删除时段</a><span class="gray">(点击文本框可编辑)</span></div>';  
         var t='<a class="blue add" href="javascript:;">+添加时段</a>';
         var g='<span class="gray">(最多可添加3个时段)</span>';        
         var d=$("#stime").find("div.addtime").last().find("a.del");
             d.next().replaceWith(g);
             d.replaceWith(t);             
        $("#stime").find("a.add").unbind("click").bind("click",function(){               
              if($("#stime").find("div.addtime").length<3){
                $(this).parent().parent().children().first().next().before(temp);                                                
                setIndexRender.h(); 
                setIndexRender.c();
              }
        });
    },
     /*
     * 功能：接听时段事件绑定
     * 参数：me当前radio按键
     * 无
     */
    g:function(me){        
        if(me.val()==2)
          $("#stime").slideDown();
        else
          $("#stime").slideUp();  
        
    },
     /*
     * 功能：接听时段删除时段事件绑定
     * 参数：
     * 无
     */
    h:function(){
        $("#stime").find("a.del").click(function(){
          if($("#stime").find("div.addtime").length>1){
                $(this).parent().remove();
          }         
        });
    },
   /*
     * 功能：接听时段验证
     * 参数：
     * 无
     */
    i:function(){         
            var st=$("#stime").find("div.addtime");
            var t1=new Array();
            var p=1;
            st.each(function(){
                if($(this).children("input[name='t1']").val()&&$(this).children("input[name='t2']").val()){
                    t1.push($(this).children("input[name='t1']").val());
                    t1.push($(this).children("input[name='t2']").val());                    
                }
                else if(!$(this).children("input[name='t1']").val()||!$(this).children("input[name='t2']").val()){
                    p=0;
                    return false;
                }
            })
            if(p)
                return t1;
            else{
                alert("请选择完整的通话时段!")
                return p;
            }            
    }    
}
                

