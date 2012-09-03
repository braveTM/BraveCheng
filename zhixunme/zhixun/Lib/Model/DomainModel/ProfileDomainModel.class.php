<?php
/**
 * Description of UserinfoDomainModel
 *
 * @author moi
 */
class ProfileDomainModel extends ModelBase{
    /**
     * 用户编号
     * @var <int>
     */
    public $user_id;

    /**
     * 用户名
     * @var <string>
     */
    public $user_name;

    /**
     * 照片
     * @var <string>
     */
    public $photo;

    /**
     * 简介
     * @var <string>
     */
    public $introduction;

    /**
     * 经历
     * @var <string>
     */
    public $experience;

    /**
     * 日期
     * @var <date>
     */
    public $date;

    /**
     * 性别（0为女，1为男）
     * @var <int>
     */
    public $gender;

    /**
     * 用户类型（1为单人，2为多人）
     * @var <int>
     */
    public $user_type;

    /**
     * 联系方式
     * @var <string>
     */
    public $contact;

    /**
     * QQ号码
     * @var <string>
     */
    public $qq;

    /**
     * 省份编号
     * @var <int>
     */
    public $province;

    /**
     * 城市编号
     * @var <int>
     */
    public $city;
}
?>
