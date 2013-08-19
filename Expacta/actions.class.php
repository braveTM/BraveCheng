<?php

/**
 * Site actions.
 *
 * @package    RapidManager2
 * @subpackage Site
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
defined('CSV_FILE_UPLOAD') || define('CSV_FILE_UPLOAD', SF_ROOT_DIR . '/frontend/sites/ccaa/web/fileupload/');
defined("CCAA_LOG_PATH") || define("CCAA_LOG_PATH", SF_ROOT_DIR . '/frontend/sites/ccaa/web/scrapedata/');

class CCAAStatsUploadActions extends sfActions {

    public static $config = array(
        'Mens Soccer Goals' => array('name', 'team', 'goals'),
        'Mens Soccer GoalsAgainst' => array('name', 'team', 'goals against'),
        'Womens Soccer Goals' => array('name', 'team', 'goals'),
        'Womens Soccer GoalsAgainst' => array('name', 'team', 'goals against'),
        'Mens Volleyball Kills' => array('name', 'team', 'kills'),
        'Mens Volleyball Blocks' => array('name', 'team', 'blocks'),
        'Womens Volleyball Kills' => array('name', 'team', 'kills'),
        'Womens Volleyball Blocks' => array('name', 'team', 'blocks'),
        'Mens Basketball Pts' => array('name', 'team', 'points'),
        'Mens Basketball Blocks' => array('name', 'team', 'blocks'),
        'Womens Basketball Pts' => array('name', 'team', 'points'),
        'Womens Basketball Blocks' => array('name', 'team', 'blocks'),
    );

    public function executeIndex() {
        $this->clientCode = sfContext::getInstance()->getUser()->getAttribute('client')->getCode();
        $this->nameSeleced = array_keys(self::$config);

        foreach ($this->nameSeleced as $value) {
            $nameOption[strtr($value, ' ', '_')] = $value;
        }
        $this->nameOptions = $nameOption;
    }

    public function validateUpload() {
        $error = $isEmpty = '';
        $fileValidator = new StatsUploadFileValidator();
        $fileValidator->initialize($this, $parameters = null);
        $result = $fileValidator->execute($this->getRequest()->getFile('uploadfile'), $error);
        if ($result == false) {
            $this->getRequest()->setError("uploadfile", $error);
            return false;
        }
        //match file type with upload file
        $fileType = $this->getRequestParameter('fileType');
        $compare = self::verifyCsv($this->getRequest()->getFilePath('uploadfile'), self::$config[strtr($fileType, '_', ' ')], $isEmpty);
        if (!$compare) {
            $this->getRequest()->setError('uploadfile', 'The selected templates do not match the selected file type!');
            return false;
        }
        if (true === $isEmpty) {
            $this->getRequest()->setError('uploadfile', 'The template data is empty!');
            return false;
        }
        return true;
    }

    public function executeUpload() {
        $fileType = $this->getRequestParameter('fileType');
        $uploadFile = self::uploadFile($this->getRequest()->getFileName('uploadfile'), CSV_FILE_UPLOAD, $this->getRequest()->getFilePath('uploadfile'), $fileType);
        //generate txt file
        if ($uploadFile) {
            $res = self::generateTxtFromCsv($uploadFile);
            if ($res) {
                $this->getRequest()->setError('log', 'File upload success!');
            } else {
                $this->getRequest()->setError('log', 'File upload success,  failed to generate txt file !');
            }
        } else {
            $this->getRequest()->setError('log', 'File upload failed!');
        }
        $this->forward('CCAAStatsUpload', 'index');
    }

    public function handleErrorUpload() {
        $request = $this->getRequest();
        $errors = $request->getErrors();
        $this->forward('CCAAStatsUpload', 'index');
    }

    public static function generateTxtFromCsv($filename, $conference = 'pacwest') {
        $csvData = self::getArrayFromCsv($filename, ',');
        array_shift($csvData);
        $basename = basename($filename, '.csv');
        $split = explode('_', $basename);
        //lcfirst is not exsit in PHP<5.3, strtolower replace it 
        $txtName = strtolower($split[1]) . $split[0] . ucfirst($conference) . '.txt';
        $txtPathName = CCAA_LOG_PATH . $conference . '/' . $txtName;
        $conferenceData = self::convertArray($csvData, $split[1], $split[2]);
        //if the file is not empty, read and append content
        $exsitContent = rapidManagerUtil::readPathFile($txtPathName);
        if ($exsitContent) {
            $exsitArray = unserialize($exsitContent);
            $conferenceData = self::appendExsitArray($exsitArray, $conferenceData);
        }
        if ($conferenceData) {
            $ser = serialize($conferenceData);
            return self::writeOver($txtPathName, $ser);
        }
    }

    public static function appendExsitArray($last, $new) {
        $keys = array_keys($new);
        foreach ($last as $key => $value) {
            if (in_array($key, $keys)) {
                $last[$key] = $new[$key];
            } else {
                $last = array_merge($last, $new);
            }
            unset($value);
        }
        return $last;
    }

    public static function convertArray($array, $ball, $dot) {
        $convert = array();
        switch ($ball) {
            case 'Basketball':
                if ($dot == 'Blocks') {
                    foreach ($array as $value) {
                        $var['name'] = $value[0];
                        $var['team'] = $value[1];
                        $var['AVG'] = $value[2];
                        $convert['AVG'][] = $var;
                        unset($value);
                    }
                }
                if ($dot == 'Pts') {
                    foreach ($array as $value) {
                        $var['name'] = $value[0];
                        $var['team'] = $value[1];
                        $var['PPG'] = $value[2];
                        $convert['PPG'][] = $var;
                        unset($value);
                    }
                }
                break;

            case 'Volleyball':
                if ($dot == 'Blocks') {
                    foreach ($array as $value) {
                        $var['name'] = $value[0];
                        $var['team'] = $value[1];
                        $var['blocks'] = $value[2];
                        $convert['blocks'][] = $var;
                        unset($value);
                    }
                }
                if ($dot == 'Kills') {
                    foreach ($array as $value) {
                        $var['name'] = $value[0];
                        $var['team'] = $value[1];
                        $var['kills'] = $value[2];
                        $convert['kills'][] = $var;
                        unset($value);
                    }
                }
                break;
            case 'Soccer':
                if ($dot == 'Goals') {
                    foreach ($array as $value) {
                        $var['name'] = $value[0];
                        $var['team'] = $value[1];
                        $var['G'] = $value[2];
                        $convert['G'][] = $var;
                        unset($value);
                    }
                }
                if ($dot == 'GoalsAgainst') {
                    foreach ($array as $value) {
                        $var['name'] = $value[0];
                        $var['team'] = $value[1];
                        $var['GA'] = $value[2];
                        $convert['GA'][] = $var;
                        unset($value);
                    }
                }
                break;
        }
        $inKey = array_keys($convert);
        //classic code. sort by code desc
        foreach ($inKey as $item) {
            foreach ($convert[$item] as $k => $v) {
                if ($v[$item]) {
                    $code[$k] = $v[$item];
                }
            }
            array_multisort($code, SORT_DESC, $convert[$item]);
            unset($code);
        }
        return $convert;
    }

    /**
     * write log
     * @param string $filename
     * @param string $data
     * @param string $method
     */
    public static function writeOver($filename, $data, $method = "w") {
        $paths = pathinfo($filename);
        rapidManagerUtil::createDir($paths['dirname'], '775', 'apache', 'design');
        $file = fopen($filename, $method);
        flock($file, LOCK_EX);
        $filedetail = fwrite($file, $data);
        //write log
        if (!$filedetail) {
            //get filename
            $getFilename = explode('.', $paths['basename']);
            rapidManagerUtil::logMessage('File:' . $paths['basename'] . 'Write Log Error!', $getFilename[0] . '.log');
        }
        fclose($file);
        return $filedetail;
    }

    /**
     * upload file
     * @param string $origin
     * @param string $dest
     * @param string $tmp_name
     * @param mixed $newfilename
     * @return mixed
     */
    public static function uploadFile($origin, $dest, $tmp_name, $newfilename = '') {
        $origin = strtolower(basename($origin));
        rapidManagerUtil::createDir($dest, '775', 'apache', 'design');
        $fulldest = $dest . $origin;
        $filename = $origin;
        if ($newfilename) {
            $fileext = (strpos($origin, '.') === false ? '' : '.' . substr(strrchr($origin, "."), 1));
            $filename = substr($origin, 0, strlen($origin) - strlen($fileext)) . $fileext;
            $fulldest = $dest . $newfilename . $fileext;
        }
        if (move_uploaded_file($tmp_name, $fulldest)) {
            return $dest . $newfilename . $fileext;
        }
        return false;
    }

    /**
     * verify csv
     * @param string $csvFile
     * @param array $compare
     * @param boolean $isEmpty
     * @return boolean
     */
    public static function verifyCsv($csvFile, $compare, &$isEmpty = false) {
        $data = self::getArrayFromCsv($csvFile, ',');
        $head = array_shift($data);
        empty($data) && $isEmpty = true;
        return $compare == $head ? true : false;
    }

    /**
     * get array from csv
     * @param string $file
     * @param mixed $delimiter
     * @return array
     */
    public static function getArrayFromCsv($file, $delimiter) {
        $data2DArray = array();
        if (($handle = fopen($file, "r")) !== false) {
            $i = 0;
            while (($lineArray = fgetcsv($handle, 4000, $delimiter)) !== false) {
                for ($j = 0; $j < count($lineArray); $j++) {
                    $data2DArray[$i][$j] = $lineArray[$j];
                }
                $i++;
            }
            fclose($handle);
        }
        return $data2DArray;
    }

    public static function getArrayFromTxt($filename) {
        $file = fopen($filename, "r");
        flock($file, LOCK_SH);
        $filedetail = fread($file, filesize($filename));
        fclose($file);
        return $filedetail;
    }

    public function executeDownloadCsv() {
        $csvName = strtr($this->getRequestParameter('csvName'), ' ', '-');
        $csvHandle = fopen('php://output', 'w');
        header("Content-Type: text/csv");
        header("Content-Disposition: attachment; filename=$csvName.csv");
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');
        if ($csvHandle) {
            fputcsv($csvHandle, self::$config[strtr($csvName, '-', ' ')]);
        }
        exit;
    }

}