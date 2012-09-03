<?php
/**
 * 类型分类实体
 * @author YoyiorLee
 */
class TypeDomainModel extends ModelBase{
    /**
     * 编号
     * @var <int>
     */
    protected $id;

    /**
     * 名称
     * @var <string>
     */
    protected $name;

    /**
     * 图标
     * @var <string>
     */
    protected $icon;

    /**
     * 父编号
     * @var <int>
     */
    protected $parent_id;

    /**
     * 角色编号
     * @var <int>
     */
    protected $role_id;

    /**
     * 一级分类编号
     * @var <int>
     */
    protected $class_id_a;
    
    /**
     * 二级分类编号
     * @var <int>
     */
    protected $class_id_b;

    /**
     * 价格
     * @var <string>
     */
    protected $price;

    /**
     * 类型
     * @var <string>
     */
    protected $type;
    
    /**
     * 代号
     * @var <string>
     */
    protected $code;
    /**
     * 描述
     * @var <string>
     */
    protected $description;

    /**
     * 排序级别
     * @var <int>
     */
    protected $sort;
    
    /**
     * 是否删除
     * @var <int>
     */
    protected $is_del;
}
?>
