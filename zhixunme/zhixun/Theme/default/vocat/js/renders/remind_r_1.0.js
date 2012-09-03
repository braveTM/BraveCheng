/*
 * 提醒设置页面控制器
 */
var remindRender={
    /*
     *保存失败
     * @author jack
     * @date 2012-12-09
     */
    fail:function(data){
        alert(data.data);
    },
    /*
     *功能：修改操作成功执行
     *参数：ret/返回值
     *说明：@jack
     *@2011.12.9
     */
    succ:function(){
        alert("操作成功","","","",function(){
           window.location.reload();
        });
    }
};
