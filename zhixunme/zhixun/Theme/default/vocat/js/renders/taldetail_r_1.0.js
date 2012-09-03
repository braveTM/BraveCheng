/*
 * 人才详细页面渲染器
 */
var taldetailRender={
    /*
     * 功能：加关注成功
     * 参数：
     * data：后台返回数据
     */
    a:function(data){
        var that=$("#add_focus");
        var temp=TEMPLE.T00102;
        that.unbind("click");        
        temp=temp.replace('{id}',that.data("uid")).replace('{name}',that.data("uname"));
        that.parent().replaceWith(temp);
        TalDetailController.d();
    },
    /*
     * 功能：加关注失败
     * 参数：
     * data：后台返回数据
     */
    b:function(data){
        alert(data.data);
    },
    /*
     * 功能：取消关注成功
     * 参数：
     * data：后台返回数据
     */
    c:function(){
        var that=$("#re_focus");
        var temp=TEMPLE.T00103;          
        temp=temp.replace('{id}',that.data("uid")).replace('{name}',that.data("uname"));
        that.parent().parent().replaceWith(temp);
        TalDetailController.b();
    },
    /*
     * 功能：取消关注失败
     * 参数：
     * data：后台返回数据
     */
    d:function(data){
        alert(data.data);
    }
};