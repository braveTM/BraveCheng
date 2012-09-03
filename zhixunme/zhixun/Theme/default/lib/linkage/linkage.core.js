/* 
 * 联动下拉
 */
(function($){
    $.extend($.fn,{
        linkage:function(settings){
            var _defaults={
                first_val:"0",
                second_val:"0",
                second_id:"city",
                has_second:true,
                select:"—请选择—",
                data:[]
            };
            var opts = $.extend(_defaults,settings);
            var that = this;
            var link = function(){

            }
            $.extend(link,{
                _load_province:function(){
                    var city = opts.data;
                    var obj = that.get(0);
                    if ( obj == null) {
                        return;
                    }
                    for (var i = 0; i < city.length; i++) {
                        if (city[i]) {
                            obj.options[obj.length] = new Option(city[i][0][0], city[i][1][0]); //city[i][0][0]
                        }
                    }
                    for(var j=0; j<city.length; j++){
                        if(opts.first_val==obj[j].value){
                            obj[j].selected=true;
                            $("input[name="+obj.id+"]").attr("alt", obj[j].text);
                            break;
                        }
                    }
                    if(opts.second_val!="0"&&opts.has_second){
                        link._load_city(that.get(0));
                        var obj3 = document.getElementById(opts.second_id);
                        for(var k=0; k<obj3.length; k++){
                            if(obj3[k].value==opts.second_val){
                                obj3[k].selected=true;
                                var n = document.getElementsByName(opts.second_id)[0];
                                n.value = obj3[k].value;
                                n.alt = obj3[k].text;
                                break;
                            }
                        }
                    }
                    if(!opts.has_second){
                        $("#"+opts.second_id).hide()//.attr("disabled", true);
                    }
                },
                _load_city:function(obj){
                    if(!opts.has_second){
                        $("#"+opts.second_id).hide();//.attr("disabled", true);
                        return;
                    }
                    var city = opts.data;
                    var index = obj.selectedIndex-1;
                    if(city[index][0].length<=1){
                        $("#"+opts.second_id).hide();//.attr("disabled", true);
                        return;
                    }else{
                        $("#"+opts.second_id).show();//show second select
                    }
                    var obj1 = document.getElementById(opts.second_id);
                    if (index < 0) {
                        document.getElementsByName(opts.second_id)[0].value=0;
                        $(obj1).children().remove();
                        obj1.options[0] = new Option(opts.select, opts.select);
                        return;
                    }
                    var ops=$("#"+opts.second_id);
                    //obj1.length = 0;
                     ops.children().remove();
                    //alert(childs.length);
//                    for(var g = childs.length; g >0; g--) {
//                        //alert(childs[g].nodeName);
//                        ops.removeChild(childs[g0]);
//                    }
                    //obj1.options[0] = new Option(opts.select, 0);
                    //var op = new Option(opts.select, 0);
//                    var op = document.createElement("option");
//                    op.text = opts.select;
//                    op.value = 0;
//                    obj1.appendChild(op);

                    ops.append("<option value='0'>"+opts.select+"</option>");
                    var op1='';
                    for (var i = 1; i < city[index][0].length; i++){
                        //obj1.options[obj1.length] = new Option(city[index][0][i], city[index][1][i]); //i0
                        op1+="<option value='"+city[index][1][i]+"'>"+city[index][0][i]+"</option>";
                        //var op1 = new Option(city[index][0][i], city[index][1][i]);
                        
                    }
                    ops.append(op1);
                    ops[0].selectedIndex = 0;
                    var n = $("input[name='"+opts.second_id+"']");
                    n.attr("value",ops[0].options[ops[0].selectedIndex].value);
                    n.attr("alt",ops[0].options[ops[0].selectedIndex].text);
                    
                    if($.browser.msie&&$.browser.version=="6.0"){
                        alert("欢迎");
                    }
                },
                _bind:function(){
                    that.change(function () {
                        var v = this.options[this.selectedIndex].value;
                        $("input[name='"+that.get(0).id+"']").val(v).attr("alt", this.options[this.selectedIndex].text);
                        link._load_city(this);
                    });
                    var _next = $("#"+opts.second_id)||that.after("<select id='"+opts.second_id+"'>");
                    _next.change(function () {
                        var v = this.options[this.selectedIndex].value;
                        $("input[name='"+opts.second_id+"']").val(v).attr("alt", this.options[this.selectedIndex].text);
                    });
                }
            });
            link._load_province();
            link._bind();
        }
    });
    
})(jQuery);

