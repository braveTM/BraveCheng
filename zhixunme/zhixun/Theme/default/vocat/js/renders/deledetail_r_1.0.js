/*
 * 委托详细页面渲染器
 */
var deledetailRender={
    /*
     * 功能：根据选择的不同的联系方式展开不同的文本输入框
     * 参数：
     * obj：当前复选框
     */
    a:function(obj){
        var that=$(obj);
        var name=that.attr("name");
        var id="#"+name;
        var p=$(id).parent();
        var dis=p.css("display");
        if(dis=="none"){
            p.slideDown(200);
        }
        else{
            p.slideUp(200);
        }

    },
    /*
     * 功能：回复委托成功
     * 参数：
     * data：后台返回数据
     */
    b:function(data){
        alert("回复委托成功!","","","",function(){
            location.href=WEBROOT+"/matask/";
        });
    },
    /*
     * 功能：回复委托失败
     * 参数：
     * data：后台返回数据
     */
    c:function(data){
        alert(data.data);
    },
    /*
     * 功能：回复委托失败
     * 参数：
     * data：后台返回数据
     */
    d:function(data){
        alert("回复私信成功!","","","",function(){
            location.href=WEBROOT+"/messages/3";
        });
    }
};