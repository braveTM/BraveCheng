<?php
/**
 * Description of NIOClient
 *
 * @author moi
 */
class NIOClient {
    private $sConnType = '';
    private $iTimeOut = 10000000;
    private $iPollTime = 10000;
    private $iReadBlockSize = 8192;
    private $aSockets = array();
    private $aHeaders = array();
    private $aRemoteSockets = array();
    private $iPoolSize = 50;
    private $aFinishSockets = array();
    private $bPool = false;
    private $aPoolSockets = array();
    private $aBaseHeader = array(
        'User-Agent'      => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.2 (KHTML, like Gecko) Ubuntu/11.04 Chromium/15.0.874.106 Chrome/15.0.874.106 Safari/535.2',
        'Accept'          => 'text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5',
        'Accept-Language' => 'zh-cn,zh;q=0.5',
        'Accept-Charset'  => 'gb2312,utf-8;q=0.7,*;q=0.7',
        'Keep-Alive'      => '300',
        'Connection'      => 'keep-alive'
    );
    private $aScheme = array(
        'http' => 'tcp',
        'https' => 'ssl'
    );



    public function __construct( $sConnType = 'HTTP' )
    {
        $this->sConnType = $sConnType;
    }

    /**
     * @brief: 设置超时时间
     * @param: $iMillisecond    int    毫秒
     * */
        public function SetTimeOut( $iMillisecond )
        {
            $this->iTimeOut = $iMillisecond * 1000;
        }

    /**
     * @brief: 设置连接池大小
     * @param: $iPoolSize    int    连接池数量
     * */
    public function SetPoolSize( $iPoolSize )
    {
        $this->iPoolSize = $iPoolSize;
    }

    /**
     * @brief: HTTP请求方法，处理和发出HTTP请求
     * @param: $sReType    string    请求类型['GET','POST'...]
     * @param: $aUrls      array     请求的URL列表
     *         eg: array(
     *                 'http://www.abc.com',
     *                 'http://www.def.cn/ade.php'
     *             )
     * @param: $aParams    string    请求参数列表
     *         eg: array(
     *                 array(
     *                     'username' => 'abc',
     *                     'password' => '123'
     *                 ),
     *                 array(
     *                     'title' => 'test title',
     *                     'text'  => 'test text'
     *                 )
     *             )
     * @return: array    返回的请求结果；
     *          eg: array(
     *                  array(
     *                      'header'  => '',
     *                      'content' => ''
     *                  ),
     *                  array(
     *                      'header'  => '',
     *                      'content' => ''
     *                  )
     *              )
     */
    private function a_HTTP( $sReType, $aUrls, $aParams )
    {
        $aHTTPResult = array();
        $this->RequestParam2Header( $sReType, $aUrls, $aParams );
        $aRemoteSockets = $this->aRemoteSockets;
        if( $this->bPool )
        {
            $this->InitPool( $aRemoteSockets[0] );
        }
        $aResults = $this->a_ConnResult( $aRemoteSockets );
        $this->CloseSocket();
        foreach( $aResults as $iKey => $sResult )
        {
            $aHTTPResult[$iKey] = $this->a_SplitResult( $sResult );
        }
        $this->aHeaders = array();
        $this->aRemoteSockets = array();
        return $aHTTPResult;
    }

    /**
     * @brief: Redis请求方法，处理和发出Redis请求
     * @param: $aRedisInfo    array    Redis服务参数
     * @return: array    返回执行结果
     */
    private function a_Redis( $sReType, $aRedisInfo )
    {
        $aRedisResult = array();
        $this->RedisInfoSplit( $aRedisInfo );
        $aRemoteSockets = $this->aRemoteSockets;
        $aResults = $this->a_ConnResult( $aRemoteSockets );
        $this->CloseSocket();
        $this->aHeaders = array();
        $this->aRemoteSockets = array();
        return $aResults;
    }

    /**
     * @brief: Redis参数拆分成地址与命令
     * @param: $aRedisInfo    array    Redis服务参数
     */
    private function RedisInfoSplit( $aRedisInfo )
    {
        $aRemoteSocket = array();
        foreach( $aRedisInfo as $iKey => $aInfo )
        {
            $aRemoteSocket = array(
                'tcp',
                $aInfo['host'],
                $aInfo['port']
            );
            $sHeader = $aInfo['cmd']."\r\n";
            $this->aHeaders[$iKey] = $sHeader;
            $this->aRemoteSockets[$iKey] = $aRemoteSocket;
        }
    }


    /**
     * @brief: 异步请求入口
     * @param: $sReType    string    请求类型['GET','POST'...]
     * @param: $aUrls      array     请求的URL列表
     *         eg: array(
     *                 'http://www.abc.com',
     *                 'http://www.def.cn/ade.php'
     *             )
     * @param: $aParams    string    请求参数列表
     *         eg: array(
     *                 array(
     *                     'username' => 'abc',
     *                     'password' => '123'
     *                 ),
     *                 array(
     *                     'title' => 'test title',
     *                     'text'  => 'test text'
     *                 )
     *             )
     * @return: array    返回的请求结果；
     *          eg: array(
     *                  array(
     *                      'header'  => '',
     *                      'content' => ''
     *                  ),
     *                  array(
     *                      'header'  => '',
     *                      'content' => ''
     *                  )
     *              )
     */
    public function a_NIORequest( $sReType, $aAddr, $aParams = array() )
    {
        $aCallback = array(
            $this,
            "a_{$this->sConnType}"
        );
        $aCallbackParams = array(
            $sReType,
            $aAddr,
            $aParams
        );

        return call_user_func_array( $aCallback, $aCallbackParams );
    }

    /**
     * @brief: 池化异步请求入口
     * @param: $sReType    string    请求类型['GET','POST'...]
     * @param: $aUrls      array     请求的URL列表
     *         eg: array(
     *                 'http://www.abc.com',
     *                 'http://www.def.cn/ade.php'
     *             )
     * @param: $aParams    string    请求参数列表
     *         eg: array(
     *                 array(
     *                     'username' => 'abc',
     *                     'password' => '123'
     *                 ),
     *                 array(
     *                     'title' => 'test title',
     *                     'text'  => 'test text'
     *                 )
     *             )
     * @return: array    返回的请求结果；
     *          eg: array(
     *                  array(
     *                      'header'  => '',
     *                      'content' => ''
     *                  ),
     *                  array(
     *                      'header'  => '',
     *                      'content' => ''
     *                  )
     *              )
     */
    public function a_PoolNIORequest( $sReType, $aAddr, $aParams = array() )
    {
        $aCallback = array(
            $this,
            "a_{$this->sConnType}"
        );
        $aCallbackParams = array(
            $sReType,
            $aAddr,
            $aParams
        );
        $this->bPool = true;

        return call_user_func_array( $aCallback, $aCallbackParams );
    }

    /**
     * @brief: 接收并向外返回请求结果
     * @return: array    返回请求结果
     */
    private function a_Result()
    {
        return $this->a_SelectSockets();
    }

    /**
     * @brief: 发起socket连接
     * @param: $aRemoteSocket   array     远程地址
     * @return: resource    返回socket链接资源
     */
    private function rs_Connect( $aRemoteSocket )
    {
        $aErrNu = $aErrStr = array();
        $iTimeOut = $this->iTimeOut;
        $sRemoteSocket = "{$aRemoteSocket[0]}://{$aRemoteSocket[1]}";
        //$sRemoteSocket = "{$aRemoteSocket[1]}";
        if( isset( $aRemoteSocket[2] ) )
        {
            $iPort = $aRemoteSocket[2];
        }else{
            $iPort = 80;
        }
        $sRemoteSocket .= ":$iPort";
        //echo $sRemoteSocket."\n";
        $rsSh = stream_socket_client( $sRemoteSocket, $aErrNu, $aErrStr, 0, STREAM_CLIENT_ASYNC_CONNECT|STREAM_CLIENT_CONNECT );
        stream_set_timeout( $rsSh, 0, $iTimeOut );
        stream_set_blocking($rsSh, 0);
        if( !$rsSh )
        {
            return false;
        }
        return $rsSh;
    }

    /**
     * @brief: 接收socket返回
     * @return: array    返回接到的数据
     */
    private function a_SelectSockets()
    {
        $aResult = $aW = $aE = array();
        $iPollTime       = $this->iPollTime;
        $iReadBlockSize = $this->iReadBlockSize;
        $aTmpSockets = $this->aSockets;
        while( count( $this->aSockets ) )
        {
            $aRead = $this->aSockets;
            $i = stream_select( $aRead, $aW, $aE, 1, $iPollTime );
            if( $i > 0 )
            {
                foreach( $aRead as $rsR )
                {

                    $iId = array_search( $rsR, $aTmpSockets );
                    $sData = fread( $rsR, $iReadBlockSize );
                    if( $this->bPool and ( $b_isContinue = $this->b_ContinueReadHTTP( $iId,$sData ) ))
                    {
                        $this->aFinishSockets[$iId] = $rsR;
                        unset( $this->aSockets[$iId] );
                    }elseif( strlen( $sData ) == 0 ){
                        $this->aFinishSockets[$iId] = $rsR;
                        unset( $this->aSockets[$iId] );
                    }else{
                        if( !isset( $aResult[$iId] ) )
                            $aResult[$iId] = '';
                        $aResult[$iId] .= $sData;
                    }
                }
            }else{
                break;
            }
        }
        ksort( $aResult );
        return $aResult;
    }

    /**
     * @brief: 将传入的参数写入Header中
     */
    private function RequestParam2Header( $sReType, $aUrls, $aParams=array() )
    {
        $aBaseHeader = $this->aBaseHeader;
        $aScheme = $this->aScheme;

        foreach( $aUrls as $iKey => $sUrl )
        {
            $sHeader = $sParam = '';
            $aRemoteSocket = array();
            $aParsedUrl = parse_url( $sUrl );
            $aRemoteSocket[] = $aScheme[$aParsedUrl['scheme']];
            $aHost = explode( ":", $aParsedUrl['host'] );
            foreach( $aHost as $sHostInfo )
            {
                $aRemoteSocket[] = $sHostInfo;
            }
            $sPath = isset($aParsedUrl['path']) ? $aParsedUrl['path'] : '/';
            if( isset( $aParsedUrl['query'] ) )
            {
                $sPath .= "?{$aParsedUrl['query']}";
            }
            $sHeader = "$sReType $sPath HTTP/1.1\r\n";
            foreach( $aBaseHeader as $sHeaderName => $sHeaderValue )
            {
                $sHeader .= "$sHeaderName: $sHeaderValue\r\n";
            }
            $sHeader .= "Host: {$aParsedUrl['host']}\r\n";

            if( isset( $aParams[$iKey] ) )
            {
                $sHeader .= "Content-Type: application/x-www-form-urlencoded\r\n";
                $sParam = http_build_query( $aParams[$iKey] );
                $iLength = strlen( $sParam );
                $sHeader .= "Content-Length: $iLength\r\n";
            }
            if( !$this->bPool )
            {
                $sHeader .= "Connection: Close\r\n\r\n";
            }
            $sHeader .= "$sParam\r\n";
            $this->aHeaders[$iKey] = $sHeader;
            $this->aRemoteSockets[$iKey] = $aRemoteSocket;
        }
    }

    /**
     * @brief: 拆分HTTP请求返回结果
     * @param: $sResult    string    返回的字符串
     * @return: array    拆分返回值的数组
     *          array(
     *              'header' => '',
     *              'content' => ''
     *          )
     */
    private function a_SplitResult( $sResult )
    {
        $aTmp = explode( "\r\n\r\n", $sResult, 2 );
        $aResult = array(
            'header'  => $aTmp[0],
            'content' => $aTmp[1]
        );
        return $aResult;
    }

    /**
     * @brief: 关闭socket连接
     * */
    private function CloseSocket()
    {
        $aFinishSockets = $this->aFinishSockets;
        if( count( $aFinishSockets ) < 1 )
        {
            return true;
        }

        if( $this->bPool )
        {
            foreach( $this->aPoolSockets as $rsSockets )
            {
                fclose( $rsSockets );
            }
            $this->aFinishSockets = array();
        }else{
            foreach( $aFinishSockets as $rsFinishSocket )
            {
                fclose( $rsFinishSocket );
            }
        }
    }

    /**
     * @brief: 创建连接并返回结果
     * @param: $aRemoteSocket    array    要连接的远程服务端地址
     * @return: array    服务端返回的结果
     */
    private function a_ConnResult( $aRemoteSockets )
    {
        $aResults = $aTmpResults = array();
        $iPoolSize = $this->iPoolSize;
        $aPoolSockets = $this->aPoolSockets;
        $bPool = $this->bPool;
        $i = 0;
        foreach( $aRemoteSockets as $iKey => $aRemoteSocket )
        {
            if( ($i == $iPoolSize) and $bPool )
            {
                $aTmpResults = $this->a_Result();
                $aResults = array_merge( $aResults, $aTmpResults );
                $i = 1;
                $this->aSockets = array();
            }
            $sHeader = $this->aHeaders[$iKey];
            if( $bPool )
            {
                $iIndex = $iKey % $iPoolSize;
                if( isset( $aPoolSockets[$iIndex] ) )
                {
                    $reSh = $aPoolSockets[$iIndex];
                }else{
                    $reSh = false;
                }
            }else{
                //print_r( $aRemoteSocket );
                $reSh = $this->rs_Connect( $aRemoteSocket );
            }

            if( $reSh )
            {
                //echo $sHeader."\n";
                if( stream_socket_sendto( $reSh, $sHeader ) )
                {
                    $this->aSockets[$iKey] = $reSh;
                    echo $reSh."\n";
                }else{
                    unset( $this->aRemoteSockets[$iKey] );
                }
            }else{
                unset( $this->aRemoteSockets[$iKey] );
            }
            $i++;
        }
        $aTmpResults = $this->a_Result();
        $aResults = array_merge( $aResults, $aTmpResults );
        return $aResults;
    }

    /**
     * @brief: 初始化连接池
     * @param: $aRemoteSocket    array    远程服务端信息
     */
    private function InitPool( $aRemoteSocket )
    {
        $iPoolSize = $this->iPoolSize;
        $this->aPoolSockets = array();

        for( $i=0; $i<$iPoolSize; $i++ )
        {
            $rsSh = $this->rs_Connect( $aRemoteSocket );
            if( $rsSh )
            {
                $this->aPoolSockets[] = $rsSh;
            }
        }
    }
    /**
     * @brief: 解析HTTP头
     * @param: $sData    string    远程服务器返回的字符串
     * @param: $iKey    int    数组键值
     * @return: booble    是否继续读
     */
    private function b_ContinueReadHTTP( $iKey,$sData )
    {
        if( !isset( $this->aTmpHttp[$iKey] ) )
        {
            $this->aTmpHttp[$iKey]['data'] = $sData;
        }elseif( isset( $this->aTmpHttp[$iKey]['content'] ) ){
            $this->aTmpHttp[$iKey]['content'] .= $sData;
        }else{
            $this->aTmpHttp[$iKey]['data'] .= $sData;
        }

        if( !isset( $this->aTmpHttp[$iKey]['content-length'] ) )
        {
            $aTmp = explode( "\r\n\r\n", $this->aTmpHttp[$iKey]['data'], 2 );
            if( count( $aTmp ) == 2 )
            {
                if( preg_match( '/Content-Length[^\d]+(\d+)/i', $aTmp[0], $aMatch ) )
                {
                    $this->aTmpHttp[$iKey]['content-length'] = $aMatch[1];
                    $this->aTmpHttp[$iKey]['content'] = $aTmp[1];
                }else{
                    return false;
                }
            }
        }else{
            if( strlen( $this->aTmpHttp[$iKey]['content'] ) >= $this->aTmpHttp[$iKey]['content-length'] )
            {
                return false;
            }
        }
        return true;
    }
}
?>
