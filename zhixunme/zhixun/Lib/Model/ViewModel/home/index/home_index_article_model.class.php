<?php
/**
 * Description of home_index_arts_model
 *
 * @author moi
 */
class home_index_article_model {
    /**
     * 文章编号
     * @var <int>
     */
    public $art_id;

    /**
     * 文章标题
     * @var <string>
     */
    public $title;

    /**
     * 最后编辑日期
     * @var <date>
     */
    public $date;

    /**
     * 文章详细页面链接地址
     * @var <string>
     */
    public $url;
    
    /**
     *内容
     * @var type 
     */
    public $body;
    
    
    /**
     *浏览数
     * @var type 
     */
    public $read_count;
    
    /**
     *赞
     * @var type 
     */
    public $praise;
    
    /**
     * 
     */
    public $create_datetime;
    
    /**
     *文章作者 
     */
    public $name;
    
    
}
?>
