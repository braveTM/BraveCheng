var promoteRender={
    /*
     *品牌墙hover事件处理
     *jack
     *2012-2-23
     */
    a:function(_cu){
        $("p.co_nm").addClass("hidden");
        $(".bn div").removeClass("hco");
        var p=$(_cu).text();
        var title=$(_cu).prev().find("input[name='btitle_"+p+"']").val();
        var price=$(_cu).prev().find("input[name='bprice_"+p+"']").val();
        var p1=$("div.fee_tps span.show_info").find("span#number");
        var p2= $("div.fee_tps span.show_info").find("em#price");
        p1.text(title);
        p2.text(price);
        $(_cu).addClass("hco");
        $("div.fee_tps span.show_info").removeClass("hidden");
        $("div.fee_tps span#worth").addClass("hidden");
    },
    /*
     *功能：品牌墙hover事件处理
     *参数：无
     *jack
     *2012-2-23
     */
    b:function(_t){
        $(_t).removeClass("hco");
        if($(".bn div.unhold").hasClass("chosen")){
            $("div.fee_tps span.show_info").find("span#number").text($("div").data("title"));
            $("div.fee_tps span.show_info").find("em#price").text( $("div").data("price"));
        }else{
            $("div.fee_tps span.show_info").find("span#number").text("");
            $("div.fee_tps span.show_info").find("em#price").text("");
            $("div.fee_tps span.show_info").addClass("hidden");
            $("div.fee_tps span#worth").removeClass("hidden");
        }
        $("p.co_nm").removeClass("hidden");
    },
    /*
     *功能：点击选取品牌位
     *参数：无
     *jack
     *2012-2-24
     */
    c:function(_cu){
        var p=$(_cu).text();
        var title=$(_cu).prev().find("input[name='btitle_"+p+"']").val();
        var price=$(_cu).prev().find("input[name='bprice_"+p+"']").val();
        $("div").data("title",title);
        $("div").data("price",price);
        $(".bn div").removeClass("chosen");
        $(_cu).addClass("chosen");
        promoteController.e();
        promoteController.f();
        $("div.fee_tps span#worth").addClass("hidden");
        $("div.fee_tps span.show_info").find("span#number").text(title);
        $("div.fee_tps span.show_info").find("em#price").text(price);
        $("div.fee_tps input[name='number']").val(p);
        $("div.fee_tps span.show_info").removeClass("hidden");
    },
    /*
     *取消选择品牌位
     *参数：无
     */
    d:function(_t){
        $(_t).removeClass("chosen");
        promoteController.e();
        promoteController.f();
        $("div.fee_tps span#worth").removeClass("hidden");
        $("div.upload p#num em").text("");
        $("div.fam_tip span#bd").text("");
        $("div.fee_tps span.show_info").find("span#number").text("");
        $("div.fee_tps span.show_info").find("em#price").text("");
        $("div.fee_tps span.show_info").addClass("hidden");
    },
    /*
     *购买推广位一成功执行
     *参数：无
     *jack
     *2012-2-23
     */
    b_s:function(ret){
        alert('购买成功',"","","",function(){
            window.location=WEBROOT+"/epromotion/0";
        });
    },
    /*
     *购买推广位一失败执行
     *抢占推广位失败
     *参数：无
     *jack
     *2012-2-23
     */
    b_f:function(data){
        if(data.data=="YEBZ0001"){
            paytipController.NoScore();
        }else{
            alert(data.data);
        }
    },
    /*
     *企业抢占品牌墙推广位一成功执行
     *参数：无
     *jack
     *2012-2-23
     */
    r_s:function(ret){
        alert('抢占成功',"","","",function(){
            window.location=WEBROOT+"/epromotion/0";
        });
    },
    /*
     *参数：无
     * 上传图片
     * jack
     * 2012-2-28
     */
    e:function(_this){
        try{
            var file = $(_this).val();
            if(promoteRender.f(file)){
                $('#form_upload').submit();
            }
        }catch(e){
            promoteRender.g(e)
        }
    },
    /**
     * 是否是图片
     * jack
     * 2012-2-28
     */
    f:function(file){
        //验证是否是图片格式
        if(/^.*?\.(gif|png|jpg|jpeg|bmp)$/i.test(file))
            return true;
        alert("图片格式不正确，请选择图片。");
        return false
    },
    /**
     * 错误处理
     * @author yoyiorlee
     * @date 2012-12-07
     */
    g:function(e){
        if(typeof e == "undefined"){
            alert("上传失败，刷新页面或稍后再试。");
        }else{
            alert(e);
        }
    },
    /*
     *图片上传成功处理
     *jack
     *2012-2-28
     */
    h:function(data){
        $(".Ep div.fam_tip p.Nb").remove();
        $(".Ep div.up_fileBox").remove();
        $(".Ep div.exf div.sf").find("input#file_name").remove();
        $(".Ep div.exf div.sf").removeClass("hidden").append('<input id="file_name" name="file_name" type="file"/>');
        promoteController.d();
        $(".Ep div.fm img.mbig").attr("src",data);
        $(".Ep div.fm").removeClass("hidden");
    },
    /*
     *抢占失败
     **/
    i:function(data){
        alert(data);
    }
};


