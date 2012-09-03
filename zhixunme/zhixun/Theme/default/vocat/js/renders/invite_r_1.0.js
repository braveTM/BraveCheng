/* 
 * 首页渲染器
 */
var inviteRender={
    /*
     *功能：设置错误信息提醒
     *参数：无
     */
    b:function(id,value){
       $("div.msg").attr("id",id);
       $("#"+id).html(value);
    },
    /*
     *功能：发送邀请成功
     *参数：无
     */
    c:function(){
        var id=$("div").data("obj");
        $(id).parent().prev().find("a").remove();
         $(id).parent().parent().find("input[id!='cop_link']").val("");
        alert('操作成功',"","",3000);
    },
    /*
     *功能：发送邀请失败
     *参数：无
     */
    d:function(data){
        alert(data.data);
    }
};
