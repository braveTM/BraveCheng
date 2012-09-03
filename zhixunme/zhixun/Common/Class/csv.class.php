<?php
/**
 * Jason  & brave
 *
 * @author:  顼华伟 <mutou_wu@163.com> QQ: 40722423(木头屋)
 * @Date:    2009-11-27
 * @Update:  2009
 * @abstract 程序经过brave二次修改
 */

/**
 * 导出Excel
 *
 * @package:     Jason
 * @subpackage:  Excel
 * @version:     1.0
 */
class Csv {

    /**
     * Excel 标题
     *
     * @type: Array
     */
    private $_titles = array();

    /**
     * Excel 标题数目
     *
     * @type: int
     */
    private $_titles_count = 0;

    /**
     * Excel 内容
     *
     * @type:  Array
     */
    private $_contents = array();

    /**
     * 错误信息
     * @var type 
     */
    public $error = array();

    /**
     * @return   mixed   Jason_Excel_Export
     */
    public function setFileName($fileName = self::DEFAULT_FILE_NAME) {
        $this->_fileName = $fileName;
        $this->setSplite();
        return $this;
    }

    private function _getType() {
        return substr($this->_fileName, strrpos($this->_fileName, '.') + 1);
    }

    public function setSplite($split = null) {
        if ($split === null) {
            switch ($this->_getType()) {
                case 'xls': $this->_split = "\t";
                    break;
                case 'csv': $this->_split = ",";
                    break;
            }
        }
        else
            $this->_split = $split;
    }

    /**
     * 读取记录
     * @return array 
     */
    public function getRecord($arr = array()) {
        $handle = fopen($this->_fileName, 'r');
        if (!$handle) {
            $this->error[] = '不能打开文件';
            return $this->error;
        }
        while ($record = fgetcsv($handle, 1000, $this->_split)) {
            $this->_toCharset($record, 'GB2312', 'UTF-8');
            array_push($arr, $record);
        }
        fclose($handle);
        return $arr;
    }

    /**
     * 判断是否为utf-8的编码
     * @param type $word
     * @return boolean 
     */
    private function is_utf8($word) {
        if (preg_match("/^([" . chr(228) . "-" . chr(233) . "]{1}[" . chr(128) . "-" . chr(191) . "]{1}[" . chr(128) . "-" . chr(191) . "]{1}){1}/", $word) == true || preg_match("/([" . chr(228) . "-" . chr(233) . "]{1}[" . chr(128) . "-" . chr(191) . "]{1}[" . chr(128) . "-" . chr(191) . "]{1}){1}$/", $word) == true || preg_match("/([" . chr(228) . "-" . chr(233) . "]{1}[" . chr(128) . "-" . chr(191) . "]{1}[" . chr(128) . "-" . chr(191) . "]{1}){2,}/", $word) == true) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 编码转化
     * @param sring $str
     * @param sring $from
     * @param sring $to 
     */
    private function _toCharset(&$str, $from, $to) {
        foreach ($str as $k => $val) {
            if ($this->is_utf8($val))
                return $str;
            $str[$k] = iconv($from, $to, $val);
        }
    }

    /**
     * 设置Excel标题
     *
     * @param    string  param
     * @return   mixed   Jason_Excel_Export
     */
    public function setTitle(&$title = array()) {
        $this->_titles = $title;
        $this->_titles_count = count($title);
        return $this;
    }

    /**
     * 设置Excel内容
     *
     * @param    string  param
     * @return   mixed   Jason_Excel_Export
     */
    public function setContent(&$content = array()) {
        $this->_contents = $content;
        $this->_contents_count = count($content);
        return $this;
    }

    /**
     * 向excel中添加一行内容
     */
    public function addRow($row = array()) {
        $this->_contents[] = $row;
        $this->_contents_count++;
        return $this;
    }

    /**
     * 向excel中添加多行内容
     */
    public function addRows($rows = array()) {
        $this->_contents = array_merge($this->_contents, $rows);
        $this->_contents_count += count($rows);
        return $this;
    }

    /**
     * 数据编码转换
     */
    public function toCode($type = 'GB2312', $from = 'auto') {
        foreach ($this->_titles as $k => $title) {
            $this->_titles[$k] = mb_convert_encoding($title, $type, $from);
        }

        foreach ($this->_contents as $i => $contents) {
            $this->_contents[$i] = $this->_toCodeArr($contents);
        }

        return $this;
    }

    private function _toCodeArr(&$arr = array(), $type = 'GB2312', $from = 'auto') {
        foreach ($arr as $k => $val) {
            $arr[$k] = mb_convert_encoding($val, $type, $from);
        }
        return $arr;
    }

    public function charset($charset = '') {
        if ($charset == '')
            $this->_charset = '';
        else {
            $charset = strtoupper($charset);
            switch ($charset) {
                case 'UTF-8' :
                case 'UTF8' :
                    $this->_charset = ';charset=UTF-8';
                    break;

                default:
                    $this->_charset = ';charset=' . $charset;
            }
        }

        return $this;
    }

    /**
     * 导出Excel
     *
     * @param    string  param
     * @return   mixed   return
     */
    public function export() {
        $header = '';
        $data = array();

        $header = implode($this->_split, $this->_titles);

        for ($i = 0; $i < $this->_contents_count; $i++) {
            $line_arr = array();
            foreach ($this->_contents[$i] as $value) {
                if (!isset($value) || $value == "") {
                    $value = '""';
                } else {
                    $value = str_replace('"', '""', $value);
                    $value = '"' . $value . '"';
                }

                $line_arr[] = $value;
            }

            $data[] = implode($this->_split, $line_arr);
        }

        $data = implode("\n", $data);
        $data = str_replace("\r", "", $data);

        if ($data == "") {
            $data = "\n(0) Records Found!\n";
        }

        header("Content-type: application/vnd.ms-excel" . $this->_charset);
        header("Content-Disposition: attachment; filename=$this->_fileName");
        header("Pragma: no-cache");
        header("Expires: 0");

        echo $header . "\n" . $data;
    }

}

?>
