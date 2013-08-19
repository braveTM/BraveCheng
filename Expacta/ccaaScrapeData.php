<?php

/**
 * CCAA Scrape URLs Data (CURL)
 * @author brave.cheng <brave.cheng@expacta.com.cn>
 * @version 1.0
 */
define('SF_ROOT_DIR', realpath(dirname(__FILE__) . '/../..'));
define('SF_APP', 'backend');
define('SF_ENVIRONMENT', 'prod');
define('SF_DEBUG', TRUE);

require_once(SF_ROOT_DIR . DIRECTORY_SEPARATOR . 'apps' . DIRECTORY_SEPARATOR . SF_APP . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php');

set_time_limit(0);
// write logs tag
define('LOGS_IS_OPEN', TRUE);
//log file path
defined("CCAA_LOG_PATH") OR define("CCAA_LOG_PATH", SF_ROOT_DIR . '/frontend/sites/ccaa/web/scrapedata/');
//scrape data from the urls
$scrapeUrls = array(
    'soccer' => array(
        'mens' => array(
            'acac' => 'http://www.acac.ab.ca/printable/stats_msoc.asp',
            'ocaa' => 'http://ocaa.com/sports/msoc/2012-13/players?sort=g',
            'acaa' => 'http://acaa.ca/statistics.php?league_id=24171&schedule_id=151299', //'http://acaa.ca/statistics.php?league_id=24171&lang=1',
        ),
        'womens' => array(
            'acac' => 'http://www.acac.ab.ca/printable/stats_wsoc.asp',
            'ocaa' => 'http://ocaa.com/sports/wsoc/2012-13/players?sort=g',
            'rseq' => array(
                'url' => 'http://www.tsisports.ca/fedeEcole/ligueFede/startPage.aspx?selDiv=1804&page=stat&selYear=1213', //'http://www.sportetudiant-stats.com/collegial/soccer-f-d1/stats/2012/stats.php',
            ),
            'acaa' => 'http://acaa.ca/statistics.php?league_id=24170&schedule_id=151305',
        ),
    ),
    'volleyball' => array(
        'mens' => array(
            'acac' => 'http://www.dakstats.com/WebSync/Pages/MultiTeam/IndividualLeaders.aspx?association=22&sg=MVB&sea=ACAMVB_2012&division=ACAMVB1&statcode=Summary&tab=1',
            'rseq' => array(
                'url' => 'http://www.tsisports.ca/fedeEcole/ligueFede/startPage.aspx?selDiv=1808&page=stat&selYear=1213', // 'http://www.sportetudiant-stats.com/collegial/volleyball-m-d1/stats/1213/stats.php',
            ),
            'acaa' => 'http://www.dakstats.com/WebSync/Pages/MultiTeam/IndividualLeaders.aspx?association=22&sg=MVB&sea=ACAMVB_2012&conference=ACAMVB1_ACAA&statcode=Summary&tab=1',
            'ocaa' => 'http://ocaa.com/sports/mvball/2012-13/players?sort=ptsps',
        ),
        'womens' => array(
            'acac' => 'http://www.dakstats.com/WebSync/Pages/MultiTeam/IndividualLeaders.aspx?association=22&sg=WVB&sea=ACAWVB_2012&division=ACAWVB1&statcode=Summary&tab=1',
            'rseq' => array(
                'url' => 'http://www.tsisports.ca/fedeEcole/ligueFede/startPage.aspx?selDiv=1807&page=stat&selYear=1213', //'http://www.sportetudiant-stats.com/collegial/volleyball-f-d1/stats/1213/stats.php',
            ),
            'acaa' => 'http://www.dakstats.com/WebSync/Pages/MultiTeam/IndividualLeaders.aspx?association=22&sg=WVB&sea=ACAWVB_2012&division=ACAWVB1&statcode=Summary&tab=1',
            'ocaa' => 'http://ocaa.com/sports/wvball/2012-13/players?sort=ptsps',
        ),
    ),
    'basketball' => array(
        'mens' => array(
            'acac' => 'http://www.dakstats.com/WebSync/Pages/MultiTeam/IndividualLeaders.aspx?association=22&sg=MBB&sea=ACAMBB_2012&division=ACAMBB1&statcode=Summary&tab=1',
            'ocaa' => 'http://ocaa.com/sports/mbkb/2012-13/players?sort=ptspg&view=&pos=sh&r=0',
            'rseq' => 'http://www.sportetudiant-stats.com/collegial/basketball-m-d1/stats/1112/confldrs.htm#conf.wki',
            'acaa' => 'http://www.dakstats.com/WebSync/Pages/MultiTeam/IndividualLeaders.aspx?association=22&sg=MBB&sea=ACAMBB_2012&division=ACAMBB1&statcode=Summary&tab=1',
        ),
        'womens' => array(
            'acac' => 'http://www.dakstats.com/WebSync/Pages/MultiTeam/IndividualLeaders.aspx?association=22&sg=WBB&sea=ACAWBB_2012&division=ACAWBB1&statcode=Summary&tab=1',
            'ocaa' => 'http://ocaa.com/sports/wbkb/2012-13/players?sort=ptspg',
            'rseq' => 'http://www.sportetudiant-stats.com/collegial/basketball-f-d1/stats/1112/confldrs.htm#conf.wki',
            'acaa' => 'http://www.dakstats.com/WebSync/Pages/MultiTeam/IndividualLeaders.aspx?association=22&sg=WBB&sea=ACAWBB_2012&division=ACAWBB1&statcode=Summary&tab=1',
        ),
    ),
);

//collect data. this is a function start
scrapeUrlData($scrapeUrls);
#test#
//analysisData::curlGetData($scrapeUrls['basketball']['womens']['rseq'], $resData);
//analysisData::basketballWomensRseq(new simple_html_dom(), $resData);

/**
 * scrapeUrlData
 * @param array $scrapeUrls
 */
function scrapeUrlData($scrapeUrls) {
    $resData = $header = '';
    foreach ($scrapeUrls as $k1 => $v1) {
        foreach ($v1 as $k2 => $v2) {
            foreach ($v2 as $k3 => $v3) {
                $function = trim($k1) . ucfirst(trim($k2)) . ucfirst(trim($k3));
                if (is_array($v3)) {
                    //do with cookie
                    analysisData::curlGetData($scrapeUrls[$k1][$k2][$k3]['url'], $header);
                    //302 
                    if (strpos($header, "Set-Cookie") !== FALSE) {
                        $res = analysisData::curlGetData($scrapeUrls[$k1][$k2][$k3]['url'], $resData, 1, analysisData::getCookieHeader($header));
                    } else {
                        rapidManagerUtil::logMessage('Can\'t Scrape 302 Url:[' . $scrapeUrls[$k1][$k2][$k3] . ']', $function . '.log');
                    }
                } else {
                    // out with cookie
                    $res = analysisData::curlGetData($scrapeUrls[$k1][$k2][$k3], $resData);
                }
                if (!$res && empty($resData) && LOGS_IS_OPEN) {
                    rapidManagerUtil::logMessage('Scrape Remote Url Data Error: can\'t open url[' . $scrapeUrls[$k1][$k2][$k3] . ']', $function . '.log');
                } else {
                    analysisData::$function(new simple_html_dom(), $resData);
                }
            }
        }
    }
}

class analysisData {

    public static $TeamIdentification = array(
        'AHUNT' => 'Ahuntsic',
        'ST-LAMB' => 'Ch.-St-Lambert',
        'DAWSON' => 'Dawson',
        'ED-MONT' => 'Edouart-Montpetit',
        'JOHN-AB' => 'John-Abbott',
        'LIMOILOU' => 'Limoilou',
        'MONTMOR' => 'Montmorency',
        'S-FOY' => 'Sainte-Foy',
        'VANIER' => 'Vanier',
        'ST-LAWR' => 'Ch.-St-Lawrence',
        'T-RIV' => 'Trois-Rivieres',
        'D.-SHERB' => 'D.-SHERB',
        'N-FRONT' => 'N-FRONT',
    );

    /**
     * soccer mens acac
     * @param type $htmlDomObj
     * @param type $soccerMensAcacData
     */
    public static function soccerMensAcac($htmlDomObj, $soccerMensAcacData) {
        $northArr = self::splitArray(self::upSoccerMensAcac($htmlDomObj, $soccerMensAcacData), array('name' => 1, 'team' => 2, 'G' => 4));
        $southArr = self::splitArray(self::upSoccerMensAcac($htmlDomObj, $soccerMensAcacData, 1), array('name' => 1, 'team' => 2, 'G' => 4));
        $downLeft = self::splitArray(self::downSoccerMensAcac($htmlDomObj, $soccerMensAcacData), array('name' => 1, 'team' => 2, 'GA' => 9));
        $downRight = self::splitArray(self::downSoccerMensAcac($htmlDomObj, $soccerMensAcacData, 1), array('name' => 1, 'team' => 2, 'GA' => 9));
        //merge north and south data
        $newArr = array_merge($northArr, $southArr, $downLeft, $downRight);
        //chunk by G/GA
        //create serialize data
        $ser = serialize(self::diffChunk($newArr, array('G', 'GA')));
        self::writeOver(__FUNCTION__ . '.txt', $ser);
    }

    public static function diffChunk($array, $chunk = array()) {
        $chunked = array();
        foreach ($array as $key => $value) {
            foreach ($value as $k => $var) {
                unset($var);
                if (in_array($k, $chunk)) {
                    $chunked[$k][$key] = $value;
                }
            }
        }

        //classic code. sort by code desc
        foreach ($chunk as $item) {
            foreach ($chunked[$item] as $k => $v) {
                if ($v[$item]) {
                    $code[$k] = $v[$item];
                }
            }
            array_multisort($code, SORT_DESC, $chunked[$item]);
            unset($code);
        }
        return $chunked;
    }

    public static function splitArray($array, $replace = array()) {
        foreach ($array as $key => $value) {
            foreach ($replace as $k => $v) {
                $var[$k] = $value[$v];
            }
            unset($value);
            $array[$key] = $var;
        }
        return $array;
    }

    public static function downSoccerMensAcac($htmlDomObj, $data, $number = 0) {
        $htmlDomObj->load($data, FALSE);
        $south = $htmlDomObj->find('table[width=98%]', $number);
        $str = $south->outertext;
        $htmlDomObj->clear();
        return self::scanTableData($htmlDomObj, $str, 11);
    }

    public static function upSoccerMensAcac($htmlDomObj, $soccerMensAcacData, $number = 0) {
        $htmlDomObj->load($soccerMensAcacData, FALSE);
        $south = $htmlDomObj->find('table[width=1000] tr td table', $number);
        $str = $south->outertext;
        $htmlDomObj->clear();
        return self::scanTableData($htmlDomObj, $str);
    }

    public static function scanTableData($htmlDomObj, $soccerMensAcacData, $chunkNum = 6) {
        $htmlDomObj->load($soccerMensAcacData);
        foreach ($htmlDomObj->find('td[height=20]') as $row) {
            $theData[] = $row->plaintext;
        }
        $htmlDomObj->clear();
        $theData = array_chunk($theData, $chunkNum);
        array_shift($theData);
        return $theData;
    }

    /**
     * soccer mens ocaa
     * @param type $htmlDomObj
     * @param type $data
     */
    public static function soccerMensOcaa($htmlDomObj, $data) {
        $htmlDomObj->load($data, FALSE);
        $south = $htmlDomObj->find('table', 0);
        foreach ($south->find('tr') as $row) {
            $rowData = array();
            foreach ($row->find('td') as $cell) {
                $rowData[] = trim($cell->plaintext);
            }
            $theData[] = $rowData;
        }
        $htmlDomObj->clear();
        array_shift($theData);
        $theData = self::splitArray($theData, array('name' => 1, 'team' => 2, 'G' => 5));
        $ser = serialize(self::diffChunk($theData, array('G', 'GA')));
        self::writeOver(__FUNCTION__ . '.txt', $ser);
    }

    /**
     * soccer mens acaa
     * @param type $htmlDomObj
     * @param type $data
     */
    public static function soccerMensAcaa($htmlDomObj, $data) {
        $htmlDomObj->load($data);
        $div = $htmlDomObj->find('div[class=ll_list]', 0);
        $table = $div->find('table', 0);
        foreach ($table->find('tr') as $row) {
            $rowData = array();
            foreach ($row->find('td') as $cell) {
                $rowData[] = trim($cell->plaintext);
            }
            $theData[] = $rowData;
        }
        array_shift($theData);
        $theData = self::splitArray($theData, array('name' => 0, 'G' => 3));
        $htmlDomObj->clear();
        $ser = serialize(self::diffChunk($theData, array('G', 'GA')));
        self::writeOver(__FUNCTION__ . '.txt', $ser);
    }

    /**
     * soccer womens acac
     * @param obj $htmlDomObj
     * @param string $data
     */
    public static function soccerWomensAcac($htmlDomObj, $soccerMensAcacData) {
        $northArr = self::splitArray(self::upSoccerMensAcac($htmlDomObj, $soccerMensAcacData), array('name' => 1, 'team' => 2, 'G' => 4));
        $southArr = self::splitArray(self::upSoccerMensAcac($htmlDomObj, $soccerMensAcacData, 1), array('name' => 1, 'team' => 2, 'G' => 4));
        $downLeft = self::splitArray(self::downSoccerMensAcac($htmlDomObj, $soccerMensAcacData), array('name' => 1, 'team' => 2, 'GA' => 9));
        $downRight = self::splitArray(self::downSoccerMensAcac($htmlDomObj, $soccerMensAcacData, 1), array('name' => 1, 'team' => 2, 'GA' => 9));
        //merge north and south data
        $newArr = array_merge($northArr, $southArr, $downLeft, $downRight);
        //create serialize data
        $ser = serialize(self::diffChunk($newArr, array('G', 'GA')));
        self::writeOver(__FUNCTION__ . '.txt', $ser);
    }

    /**
     * soccer womens ocaa
     * @param obj $htmlDomObj
     * @param string $data
     */
    public static function soccerWomensOcaa($htmlDomObj, $data) {
        $htmlDomObj->load($data, FALSE);
        $south = $htmlDomObj->find('table', 0);
        foreach ($south->find('tr') as $row) {
            $rowData = array();
            foreach ($row->find('td') as $cell) {
                $rowData[] = trim($cell->plaintext);
            }
            $theData[] = $rowData;
        }
        $htmlDomObj->clear();
        array_shift($theData);
        $theData = self::splitArray($theData, array('name' => 1, 'team' => 2, 'G' => 5));
        $ser = serialize(self::diffChunk($theData, array('G', 'GA')));
        self::writeOver(__FUNCTION__ . '.txt', $ser);
    }

    /**
     * soccer womens rseq
     * @param obj $htmlDomObj
     * @param string $data
     */
    public static function soccerWomensRseq($htmlDomObj, $data) {
        $htmlDomObj->load($data, FALSE);
        $html = $htmlDomObj->find('table[id=ctl00_ContentPlaceHolder1_statsSoccer1_gridJ]', 0);
        foreach ($html->find('tr') as $row) {
            $rowData = array();
            foreach ($row->find('td') as $cell) {
                $rowData[] = trim($cell->plaintext);
            }
            $theData[] = $rowData;
        }
        $htmlDomObj->clear();
        array_shift($theData);
        $theData = self::splitArray($theData, array('name' => 0, 'team' => 1, 'G' => 2));
        $ser = serialize(self::diffChunk($theData, array('G', 'GA')));
        self::writeOver(__FUNCTION__ . '.txt', $ser);
    }

    /**
     * soccer womans acaa
     * @param obj $htmlDomObj
     * @param string $data
     */
    public static function soccerWomensAcaa($htmlDomObj, $data) {
        $htmlDomObj->load($data);
        $div = $htmlDomObj->find('div[class=ll_list]', 0);
        $table = $div->find('table', 0);
        foreach ($table->find('tr') as $row) {
            $rowData = array();
            foreach ($row->find('td') as $cell) {
                $rowData[] = trim($cell->plaintext);
            }
            $theData[] = $rowData;
        }
        $htmlDomObj->clear();
        array_shift($theData);
        $theData = self::splitArray($theData, array('name' => 0, 'G' => 3));
        $ser = serialize(self::diffChunk($theData, array('G', 'GA')));
        self::writeOver(__FUNCTION__ . '.txt', $ser);
    }

    /**
     * volleyball mens acac 
     * @param obj $htmlDomObj
     * @param string $data
     */
    public static function volleyballMensAcac($htmlDomObj, $data) {
        $one = self::splitArray(self::findVolleyballMensCcaa($htmlDomObj, $data, 'ctl00_websyncContentPlaceHolder_ctl02_summaryGridView'), array('name' => 1, 'team' => 2, 'kills' => 4, 'blocks' => 6));
        $five = self::splitArray(self::findVolleyballMensCcaa($htmlDomObj, $data, 'ctl00_websyncContentPlaceHolder_ctl06_summaryGridView'), array('name' => 1, 'team' => 2, 'blocks' => 6));
        $theData = array_merge($one, $five);
        $ser = serialize(self::diffChunk($theData, array('kills', 'blocks')));
        self::writeOver(__FUNCTION__ . '.txt', $ser);
    }

    public static function findVolleyballMensCcaa($htmlDomObj, $data, $param) {
        $htmlDomObj->load($data, FALSE);
        $south = $htmlDomObj->find('table[id=' . $param . ']', 0);
        foreach ($south->find('tr') as $row) {
            $rowData = array();
            foreach ($row->find('td') as $cell) {
                $rowData[] = trim($cell->plaintext);
            }
            $theData[] = $rowData;
        }
        $htmlDomObj->clear();
        array_shift($theData);
        return $theData;
    }

    /**
     * volleyball mens rseq
     * @param obj $htmlDomObj
     * @param string $data
     */
    public static function volleyballMensRseq($htmlDomObj, $data) {
        $one = self::splitArray(self::findVolleyballMensCcaa($htmlDomObj, $data, 'ctl00_ContentPlaceHolder1_statsVolley1_gridJ'), array('name' => 0, 'team' => 2, 'kills' => 5, 'blocks' => 6));
        $two = self::splitArray(self::findVolleyballMensCcaa($htmlDomObj, $data, 'ctl00_ContentPlaceHolder1_statsVolley1_gridJ2'), array('name' => 0, 'team' => 2, 'kills' => 5));
        $three = self::splitArray(self::findVolleyballMensCcaa($htmlDomObj, $data, 'ctl00_ContentPlaceHolder1_statsVolley1_gridJ3'), array('name' => 0, 'team' => 2, 'kills' => 5));
        $four = self::splitArray(self::findVolleyballMensCcaa($htmlDomObj, $data, 'ctl00_ContentPlaceHolder1_statsVolley1_gridJ4'), array('name' => 0, 'team' => 2));
        $theData = array_merge($one, $two, $three, $four);
        $ser = serialize(self::diffChunk($theData, array('kills', 'blocks')));
        self::writeOver(__FUNCTION__ . '.txt', $ser);
    }

    /**
     * volleyball mens acaa
     * @param obj $htmlDomObj
     * @param string $data
     */
    public static function volleyballMensAcaa($htmlDomObj, $data) {
        $one = self::splitArray(self::findVolleyballMensCcaa($htmlDomObj, $data, 'ctl00_websyncContentPlaceHolder_ctl02_summaryGridView'), array('name' => 1, 'team' => 2, 'kills' => 4, 'blocks' => 6));
        $five = self::splitArray(self::findVolleyballMensCcaa($htmlDomObj, $data, 'ctl00_websyncContentPlaceHolder_ctl06_summaryGridView'), array('name' => 1, 'team' => 2, 'blocks' => 6));
        $theData = array_merge($one, $five);
        $ser = serialize(self::diffChunk($theData, array('kills', 'blocks')));
        self::writeOver(__FUNCTION__ . '.txt', $ser);
    }

    /**
     * volleyball Mans Ocaa
     * @param obj $htmlDomObj
     * @param string $data
     */
    public static function volleyballMensOcaa($htmlDomObj, $data) {
        $htmlDomObj->load($data, FALSE);
        $south = $htmlDomObj->find('table', 0);
        foreach ($south->find('tr') as $row) {
            $rowData = array();
            foreach ($row->find('td') as $cell) {
                $rowData[] = trim($cell->plaintext);
            }
            $theData[] = $rowData;
        }
        $htmlDomObj->clear();
        array_shift($theData);
        $theData = self::splitArray($theData, array('name' => 1, 'team' => 2, 'kills' => 5, 'blocks' => 18));
        $ser = serialize(self::diffChunk($theData, array('kills', 'blocks')));
        self::writeOver(__FUNCTION__ . '.txt', $ser);
    }

    /**
     * volleyball womens acac
     * @param obj $htmlDomObj
     * @param string $data
     */
    public static function volleyballWomensAcac($htmlDomObj, $data) {
        $one = self::splitArray(self::findVolleyballMensCcaa($htmlDomObj, $data, 'ctl00_websyncContentPlaceHolder_ctl02_summaryGridView'), array('name' => 1, 'team' => 2, 'kills' => 4, 'blocks' => 6));
        $five = self::splitArray(self::findVolleyballMensCcaa($htmlDomObj, $data, 'ctl00_websyncContentPlaceHolder_ctl06_summaryGridView'), array('name' => 1, 'team' => 2, 'blocks' => 6));
        $theData = array_merge($one, $five);
        $ser = serialize(self::diffChunk($theData, array('kills', 'blocks')));
        self::writeOver(__FUNCTION__ . '.txt', $ser);
    }

    /**
     * volleyball Mans rseq
     * @param obj $htmlDomObj
     * @param string $data
     */
    public static function volleyballWomensRseq($htmlDomObj, $data) {
        $one = self::splitArray(self::findVolleyballMensCcaa($htmlDomObj, $data, 'ctl00_ContentPlaceHolder1_statsVolley1_gridJ'), array('name' => 0, 'team' => 2, 'kills' => 5, 'blocks' => 6));
        $two = self::splitArray(self::findVolleyballMensCcaa($htmlDomObj, $data, 'ctl00_ContentPlaceHolder1_statsVolley1_gridJ2'), array('name' => 0, 'team' => 2, 'kills' => 5));
        $three = self::splitArray(self::findVolleyballMensCcaa($htmlDomObj, $data, 'ctl00_ContentPlaceHolder1_statsVolley1_gridJ3'), array('name' => 0, 'team' => 2, 'kills' => 5));
        $four = self::splitArray(self::findVolleyballMensCcaa($htmlDomObj, $data, 'ctl00_ContentPlaceHolder1_statsVolley1_gridJ4'), array('name' => 0, 'team' => 2));
        $theData = array_merge($one, $two, $three, $four);
        $ser = serialize(self::diffChunk($theData, array('kills', 'blocks')));
        self::writeOver(__FUNCTION__ . '.txt', $ser);
    }

    /**
     * volleyball womens acaa
     * @param obj $htmlDomObj
     * @param string $data
     */
    public static function volleyballWomensAcaa($htmlDomObj, $data) {
        $one = self::splitArray(self::findVolleyballMensCcaa($htmlDomObj, $data, 'ctl00_websyncContentPlaceHolder_ctl02_summaryGridView'), array('name' => 1, 'team' => 2, 'kills' => 4, 'blocks' => 6));
        $five = self::splitArray(self::findVolleyballMensCcaa($htmlDomObj, $data, 'ctl00_websyncContentPlaceHolder_ctl06_summaryGridView'), array('name' => 1, 'team' => 2, 'blocks' => 6));
        $theData = array_merge($one, $five);
        $ser = serialize(self::diffChunk($theData, array('kills', 'blocks')));
        self::writeOver(__FUNCTION__ . '.txt', $ser);
    }

    /**
     * volleyball Mans Ocaa
     * @param obj $htmlDomObj
     * @param string $data
     */
    public static function volleyballWomensOcaa($htmlDomObj, $data) {
        $htmlDomObj->load($data, FALSE);
        $south = $htmlDomObj->find('table', 0);
        foreach ($south->find('tr') as $row) {
            $rowData = array();
            foreach ($row->find('td') as $cell) {
                $rowData[] = trim($cell->plaintext);
            }
            $theData[] = $rowData;
        }
        $htmlDomObj->clear();
        array_shift($theData);
        $theData = self::splitArray($theData, array('name' => 1, 'team' => 2, 'kills' => 5, 'blocks' => 18));
        $ser = serialize(self::diffChunk($theData, array('kills', 'blocks')));
        self::writeOver(__FUNCTION__ . '.txt', $ser);
    }

    /**
     * basketball Mens acac
     * @param obj $htmlDomObj
     * @param string $data
     */
    public static function basketballMensAcac($htmlDomObj, $data) {
        $one = self::splitArray(self::findVolleyballMensCcaa($htmlDomObj, $data, 'ctl00_websyncContentPlaceHolder_ctl02_summaryGridView'), array('name' => 1, 'team' => 2, 'PPG' => 9));
        $four = self::splitArray(self::findVolleyballMensCcaa($htmlDomObj, $data, 'ctl00_websyncContentPlaceHolder_ctl05_summaryGridView'), array('name' => 1, 'team' => 2, 'AVG' => 6));
        $theData = array_merge($one, $four);
        $ser = serialize(self::diffChunk($theData, array('PPG', 'AVG')));
        self::writeOver(__FUNCTION__ . '.txt', $ser);
    }

    /**
     * basketball Mens Ocaa
     * @param obj $htmlDomObj
     * @param string $data
     */
    public static function basketballMensOcaa($htmlDomObj, $data) {
        $htmlDomObj->load($data, FALSE);
        $south = $htmlDomObj->find('table', 0);
        foreach ($south->find('tr') as $row) {
            $rowData = array();
            foreach ($row->find('td') as $cell) {
                $rowData[] = trim($cell->plaintext);
            }
            $theData[] = $rowData;
        }
        $htmlDomObj->clear();
        array_shift($theData);
        $theData = self::splitArray($theData, array('name' => 1, 'team' => 2, 'PPG' => 12));
        $ser = serialize(self::diffChunk($theData, array('PPG', 'AVG')));
        self::writeOver(__FUNCTION__ . '.txt', $ser);
    }

    /**
     * basketball Mens Rseq
     * @param obj $htmlDomObj
     * @param string $data
     */
    public static function basketballMensRseq($htmlDomObj, $data) {
        $htmlDomObj->load($data, FALSE);
        $south = $htmlDomObj->find('font[face=verdana]', 2);
        $source = $south->find('center table', 1);
        $threeContent = $source->find('tr td p', 0);
        $contents = $threeContent->outertext;
        $htmlDomObj->clear();
        $tempOne = self::findBasketballMensRseq($htmlDomObj, $contents);
        foreach ($tempOne as $key => $value) {
            $tempString = self::splitString($value[1]);
            $tempOne[$key][10] = $tempString[0];
            $tempOne[$key][11] = $tempString[1];
        }
        $one = self::splitArray($tempOne, array('name' => 10, 'team' => 11, 'AVG' => 8));
        $tempTwo = self::findBasketballMensRseq($htmlDomObj, $contents, 1);
        foreach ($tempTwo as $key => $value) {
            $tempString = self::splitString($value[1]);
            $tempTwo[$key][8] = $tempString[0];
            $tempTwo[$key][9] = $tempString[1];
        }
        $two = self::splitArray($tempTwo, array('name' => 8, 'team' => 9, 'AVG' => 7));
        $theData = array_merge($one, $two);
        $ser = serialize(self::diffChunk($theData, array('PPG', 'AVG')));
        self::writeOver(__FUNCTION__ . '.txt', $ser);
    }

    public static function splitString($string, $split = '-') {
        foreach (self::$TeamIdentification as $key => $value) {
            if (false !== strpos($string, $split . $key)) {
                $array = explode($split . $key, $string);
                return array($array[0], $value);
            }
        }
    }

    public static function findBasketballMensRseq($htmlDomObj, $data, $num = 0) {
        $htmlDomObj->load($data, FALSE);
        $south = $htmlDomObj->find('table', $num);
        foreach ($south->find('tr') as $row) {
            $rowData = array();
            foreach ($row->find('td') as $cell) {
                $rowData[] = trim($cell->plaintext);
            }
            $theData[] = $rowData;
        }
        $htmlDomObj->clear();
        array_shift($theData);
        return $theData;
    }

    /**
     * basketball Mens acaa
     * @param obj $htmlDomObj
     * @param string $data
     */
    public static function basketballMensAcaa($htmlDomObj, $data) {
        $one = self::splitArray(self::findVolleyballMensCcaa($htmlDomObj, $data, 'ctl00_websyncContentPlaceHolder_ctl02_summaryGridView'), array('name' => 1, 'team' => 2, 'PPG' => 9));
        $four = self::splitArray(self::findVolleyballMensCcaa($htmlDomObj, $data, 'ctl00_websyncContentPlaceHolder_ctl05_summaryGridView'), array('name' => 1, 'team' => 2, 'AVG' => 6));
        $theData = array_merge($one, $four);
        $ser = serialize(self::diffChunk($theData, array('PPG', 'AVG')));
        self::writeOver(__FUNCTION__ . '.txt', $ser);
    }

    /**
     * basketball womens acac
     * @param obj $htmlDomObj
     * @param string $data
     */
    public static function basketballWomensAcac($htmlDomObj, $data) {
        $one = self::splitArray(self::findVolleyballMensCcaa($htmlDomObj, $data, 'ctl00_websyncContentPlaceHolder_ctl02_summaryGridView'), array('name' => 1, 'team' => 2, 'PPG' => 9));
        $four = self::splitArray(self::findVolleyballMensCcaa($htmlDomObj, $data, 'ctl00_websyncContentPlaceHolder_ctl05_summaryGridView'), array('name' => 1, 'team' => 2, 'AVG' => 6));
        $theData = array_merge($one, $four);
        $ser = serialize(self::diffChunk($theData, array('PPG', 'AVG')));
        self::writeOver(__FUNCTION__ . '.txt', $ser);
    }

    /**
     * basketball Womens Ocaa
     * @param obj $htmlDomObj
     * @param string $data
     */
    public static function basketballWomensOcaa($htmlDomObj, $data) {
        $htmlDomObj->load($data, FALSE);
        $south = $htmlDomObj->find('table', 0);
        foreach ($south->find('tr') as $row) {
            $rowData = array();
            foreach ($row->find('td') as $cell) {
                $rowData[] = trim($cell->plaintext);
            }
            $theData[] = $rowData;
        }
        $htmlDomObj->clear();
        array_shift($theData);
        $theData = self::splitArray($theData, array('name' => 1, 'team' => 2, 'PPG' => 12));
        $ser = serialize(self::diffChunk($theData, array('PPG', 'AVG')));
        self::writeOver(__FUNCTION__ . '.txt', $ser);
    }

    /**
     * basketball Womens Rseq
     * @param obj $htmlDomObj
     * @param string $data
     */
    public static function basketballWomensRseq($htmlDomObj, $data) {
        $htmlDomObj->load($data, FALSE);
        $south = $htmlDomObj->find('font[face=verdana]', 2);
        $source = $south->find('center table', 1);
        $threeContent = $source->find('tr td p', 0);
        $contents = $threeContent->outertext;
        $htmlDomObj->clear();
        $tempOne = self::findBasketballMensRseq($htmlDomObj, $contents);
        foreach ($tempOne as $key => $value) {
            $tempString = self::splitString($value[1]);
            $tempOne[$key][10] = $tempString[0];
            $tempOne[$key][11] = $tempString[1];
        }
        $one = self::splitArray($tempOne, array('name' => 10, 'team' => 11, 'AVG' => 8));
        $tempTwo = self::findBasketballMensRseq($htmlDomObj, $contents, 1);
        foreach ($tempTwo as $key => $value) {
            $tempString = self::splitString($value[1]);
            $tempTwo[$key][8] = $tempString[0];
            $tempTwo[$key][9] = $tempString[1];
        }
        $two = self::splitArray($tempTwo, array('name' => 8, 'team' => 9, 'AVG' => 7));
        $theData = array_merge($one, $two);
        $ser = serialize(self::diffChunk($theData, array('PPG', 'AVG')));
        self::writeOver(__FUNCTION__ . '.txt', $ser);
    }

    /**
     * basketball womens acaa
     * @param obj $htmlDomObj
     * @param string $data
     */
    public static function basketballWomensAcaa($htmlDomObj, $data) {
        $one = self::splitArray(self::findVolleyballMensCcaa($htmlDomObj, $data, 'ctl00_websyncContentPlaceHolder_ctl02_summaryGridView'), array('name' => 1, 'team' => 2, 'PPG' => 9));
        $four = self::splitArray(self::findVolleyballMensCcaa($htmlDomObj, $data, 'ctl00_websyncContentPlaceHolder_ctl05_summaryGridView'), array('name' => 1, 'team' => 2, 'AVG' => 6));
        $theData = array_merge($one, $four);
        $ser = serialize(self::diffChunk($theData, array('PPG', 'AVG')));
        self::writeOver(__FUNCTION__ . '.txt', $ser);
    }

    //**************************common****************************************//

    /**
     * write log
     * @param string $filename
     * @param string $data
     * @param string $method
     */
    public static function writeOver($filename, $data, $method = "w") {
        //get file name
        $fileRealName = explode('.', $filename);
        //lcfirst is not exsit in PHP<5.3, strtolower replace it 
        $fileRealPath = strtolower(substr($fileRealName[0], -4));
        $logPath = CCAA_LOG_PATH . $fileRealPath . '/' . $filename;
        $paths = pathinfo($logPath);
        rapidManagerUtil::createDir($paths['dirname'], '775', 'brave.cheng', 'design');
        $file = fopen($logPath, $method);
        flock($file, LOCK_EX);
        $filedetail = fwrite($file, $data);
        //write log
        if (!$filedetail && LOGS_IS_OPEN) {
            //get filename
            $getFilename = explode('.', $paths['basename']);
            rapidManagerUtil::logMessage('File:' . $file . $paths['basename'] . ' Write Log Error: file path is ' . $logPath . $data, $getFilename[0] . '.log');
        }
        fclose($file);
    }

    public static function curlGetData($url, &$data, $header = 1, $cookie = '') {
        $userAgent = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; zh-CN; rv:1.9.2) Gecko/20100115 Firefox/3.6 ';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, $header);
        curl_setopt($curl, CURLOPT_COOKIE, $cookie); //it's important for scrape
        curl_setopt($curl, CURLOPT_USERAGENT, $userAgent);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);  //Whether crawl the pages after the jump, it's important for scrape
        curl_setopt($curl, CURLOPT_TIMEOUT, 15);
        $data = curl_exec($curl);
        curl_close($curl);
        if (!eregi("^HTTP/1\.. 200", $data)) {
            if (eregi("^HTTP/1\.. 302", $data)) {
                return true;
            }
            if (eregi("^HTTP/1\.. 403", $data)) {
                $data = '';
            }
            return false;
        } else {
            return true;
        }
    }

    public static function getCookieHeader($header, $findHeader = 'Set-Cookie:', $len = '80') {
        $pos = strpos($header, $findHeader);
        $cookies = substr($header, $pos, $len);
        $arr = explode(';', $cookies);
        return strtr($arr[0], array($findHeader => ''));
    }

}

