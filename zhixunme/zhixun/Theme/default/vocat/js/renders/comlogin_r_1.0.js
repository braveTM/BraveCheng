/* 
 * 企业登录页
 * 
 */
var comloginRender={
    /* 功能:企业登录按键效果
     * 参数:id
     * 
     */
    a:function(){
        baseController.BtnBind("#logbtn div.btn_common", "regbtn", "regbtn_hov");
    },
    /* 功能:企业登录成功后
     * 参数:data:返回json
     * 
     */
    b:function(data){
         window.location=data.data; 
    },
    /* 功能:企业登录失败
     * 参数:data:返回json     
     */
    c:function(data){
        var d=data;
        if(d.sup==1){//不是企业用户
            alert(data.data,"",true,"",function(){
               window.location=WEBROOT+'/login/'; 
            });            
        }else
        alert(data.data);
    }
}

