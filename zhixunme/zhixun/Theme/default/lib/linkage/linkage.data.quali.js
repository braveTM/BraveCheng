/* 
 * 资质数据
 */
function Quali(){
    this._select = "—请选择—";
    this._count = 12;
    this._quali = new Array(this._count);
    this._quali[0] = new Array(["一级建造师", "建筑工程专业", "公路工程", "铁路工程", "民航机场工程", "港口与航道工程", "水利水电工程", "机电工程", "矿业工程", "市政公用工程", "通讯与广电工程"], ["1", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22"]);
    this._quali[1] = new Array(["二级建造师", "建筑工程", "公路工程", "水利水电工程", "机电工程", "矿业工程", "市政公用工程"], ["2", "38", "39", "40", "41", "42", "43"]);
    this._quali[2] = new Array(["一级注册结构工程师"], ["3"]);
    this._quali[3] = new Array(["二级注册结构工程师"], ["4"]);
    this._quali[4] = new Array(["一级建筑师"], ["5"]);
    this._quali[5] = new Array(["二级建筑师"], ["6"]);
    this._quali[6] = new Array(["注册监理工程师"], ["7"]);
    this._quali[7] = new Array(["注册造价工程师", "土建类", "安装类"], ["8", "44", "45"]);
    this._quali[8] = new Array(["注册电气工程师", "供配电工程", "发输变电工程"], ["9", "46", "47"]);
    this._quali[9] = new Array(["注册土木工程师", "岩土工程", "港口与航道工程", "水利水电工程", "道路工程"], ["10", "48", "49", "50", "51"]);
    this._quali[10] = new Array(["注册公用设备工程师", "给排水", "暖通空调工程", "动力工程"], ["11", "52", "53", "54"]);
    this._quali[11] = new Array(["注册安全工程师"], ["12"]);

}
Quali.prototype={
    _set:function(object){
        if(object == null || typeof object != "object"){
            return false;
        }
        this._count = this._count+1;
        this._quali[this._count] = new Array(object);
        return true;
    },
    _get:function(i){
        if(typeof i =="undefined"){
            return this._quali;
        }
        if(isNaN(i)||i>this.length){
            return null;
        }
        return this._quali[i];
    },
    _get_count:function(){
        return this._count;
    },
    _get_select:function(){
        return this._select;
    },
    _remove:function(i){
        if(isNaN(i)||i>this.length){
            return false;
        }
        this.splice(this._quali,i);
        return true;
    }
}
