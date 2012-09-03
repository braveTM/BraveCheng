/*
 * 资质数据
 */
function TaskcatData(){
    this._select = "选择分类";
    this._count = 5;
    this._taskcat = new Array(this._count);
    this._taskcat[0] = new Array(["求职招聘", "人才找企业","企业找人才","企业找企业"], [1, 6, 7, 8]);
    this._taskcat[1] = new Array(["委托任务", "猎头服务", "工程项目代理", "材料销售代理", "设备租赁代理", "其他代理"], [2, 9, 10, 25, 11, 12]);
    this._taskcat[2] = new Array(["工程项目", "政府工程", "路桥工程", "水利工程", "园林景观设计", "室内装修装饰"], [3, 13, 14, 15, 16, 17]);
    this._taskcat[3] = new Array(["材料买卖", "建筑材料", "装修材料", "装饰"], [4, 18, 19, 20]);
    this._taskcat[4] = new Array(["设备租赁", "挖掘设备", "起重机械", "铲运机械", "其他设备"], [5, 21, 22, 23, 24]);
}
TaskcatData.prototype={
    _set:function(object){
        if(object == null || typeof object != "object"){
            return false;
        }
        this._count = this._count+1;
        this._taskcat[this._count] = new Array(object);
        return true;
    },
    _get:function(i){
        if(typeof i =="undefined"){
            return this._taskcat;
        }
        if(isNaN(i)||i>this.length){
            return null;
        }
        return this._taskcat[i];
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
        this.splice(this._taskcat,i);
        return true;
    }
}
