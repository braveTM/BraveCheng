<?php

/**
  /**
 * 获取指定分类下的所有子分类ID
 * @param type $catid
 * @return type
 */
function getCategoryID($catid, &$str = '') {
        $url = $GLOBALS['_module']->getDataByMod("mod_designer.GetCategoryID", array("catparent" => $catid));
        if ($url) {
                foreach ($url as $value) {
                        $str .= $value['cat_id'] . ',';
                        getCategoryID($value['cat_id'], $str);
                }
        }
        return $str;
}
