<?php
class Des{

    /**
     +----------------------------------------------------------
     * 加密字符串
     *
     +----------------------------------------------------------
     * @access static
     +----------------------------------------------------------
     * @param string $str 字符串
     * @param string $key 加密key
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     * @throws ThinkExecption
     +----------------------------------------------------------
     */
    function encrypt($str, $key)
    {
        if ($str == "") {
            return "";
        }
        return self::_des($key,$str,1);
    }

    /**
     +----------------------------------------------------------
     * 解密字符串
     *
     +----------------------------------------------------------
     * @access static
     +----------------------------------------------------------
     * @param string $str 字符串
     * @param string $key 加密key
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     * @throws ThinkExecption
     +----------------------------------------------------------
     */
    function decrypt($str, $key)
    {
        if ($str == "") {
            return "";
        }
        return self::_des($key,$str,0);
    }

    /**
     +----------------------------------------------------------
     * Des算法
     *
     +----------------------------------------------------------
     * @access static
     +----------------------------------------------------------
     * @param string $str 字符串
     * @param string $key 加密key
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     * @throws ThinkExecption
     +----------------------------------------------------------
     */
    function _des($key, $message, $encrypt, $mode=0, $iv=null) {
      //declaring this locally speeds things up a bit
      $spfunction1 = array (0x1010400,0,0x10000,0x1010404,0x1010004,0x10404,0x4,0x10000,0x400,0x1010400,0x1010404,0x400,0x1000404,0x1010004,0x1000000,0x4,0x404,0x1000400,0x1000400,0x10400,0x10400,0x1010000,0x1010000,0x1000404,0x10004,0x1000004,0x1000004,0x10004,0,0x404,0x10404,0x1000000,0x10000,0x1010404,0x4,0x1010000,0x1010400,0x1000000,0x1000000,0x400,0x1010004,0x10000,0x10400,0x1000004,0x400,0x4,0x1000404,0x10404,0x1010404,0x10004,0x1010000,0x1000404,0x1000004,0x404,0x10404,0x1010400,0x404,0x1000400,0x1000400,0,0x10004,0x10400,0,0x1010004);
      $spfunction2 = array (-0x7fef7fe0,-0x7fff8000,0x8000,0x108020,0x100000,0x20,-0x7fefffe0,-0x7fff7fe0,-0x7fffffe0,-0x7fef7fe0,-0x7fef8000,-0x80000000,-0x7fff8000,0x100000,0x20,-0x7fefffe0,0x108000,0x100020,-0x7fff7fe0,0,-0x80000000,0x8000,0x108020,-0x7ff00000,0x100020,-0x7fffffe0,0,0x108000,0x8020,-0x7fef8000,-0x7ff00000,0x8020,0,0x108020,-0x7fefffe0,0x100000,-0x7fff7fe0,-0x7ff00000,-0x7fef8000,0x8000,-0x7ff00000,-0x7fff8000,0x20,-0x7fef7fe0,0x108020,0x20,0x8000,-0x80000000,0x8020,-0x7fef8000,0x100000,-0x7fffffe0,0x100020,-0x7fff7fe0,-0x7fffffe0,0x100020,0x108000,0,-0x7fff8000,0x8020,-0x80000000,-0x7fefffe0,-0x7fef7fe0,0x108000);
      $spfunction3 = array (0x208,0x8020200,0,0x8020008,0x8000200,0,0x20208,0x8000200,0x20008,0x8000008,0x8000008,0x20000,0x8020208,0x20008,0x8020000,0x208,0x8000000,0x8,0x8020200,0x200,0x20200,0x8020000,0x8020008,0x20208,0x8000208,0x20200,0x20000,0x8000208,0x8,0x8020208,0x200,0x8000000,0x8020200,0x8000000,0x20008,0x208,0x20000,0x8020200,0x8000200,0,0x200,0x20008,0x8020208,0x8000200,0x8000008,0x200,0,0x8020008,0x8000208,0x20000,0x8000000,0x8020208,0x8,0x20208,0x20200,0x8000008,0x8020000,0x8000208,0x208,0x8020000,0x20208,0x8,0x8020008,0x20200);
      $spfunction4 = array (0x802001,0x2081,0x2081,0x80,0x802080,0x800081,0x800001,0x2001,0,0x802000,0x802000,0x802081,0x81,0,0x800080,0x800001,0x1,0x2000,0x800000,0x802001,0x80,0x800000,0x2001,0x2080,0x800081,0x1,0x2080,0x800080,0x2000,0x802080,0x802081,0x81,0x800080,0x800001,0x802000,0x802081,0x81,0,0,0x802000,0x2080,0x800080,0x800081,0x1,0x802001,0x2081,0x2081,0x80,0x802081,0x81,0x1,0x2000,0x800001,0x2001,0x802080,0x800081,0x2001,0x2080,0x800000,0x802001,0x80,0x800000,0x2000,0x802080);
      $spfunction5 = array (0x100,0x2080100,0x2080000,0x42000100,0x80000,0x100,0x40000000,0x2080000,0x40080100,0x80000,0x2000100,0x40080100,0x42000100,0x42080000,0x80100,0x40000000,0x2000000,0x40080000,0x40080000,0,0x40000100,0x42080100,0x42080100,0x2000100,0x42080000,0x40000100,0,0x42000000,0x2080100,0x2000000,0x42000000,0x80100,0x80000,0x42000100,0x100,0x2000000,0x40000000,0x2080000,0x42000100,0x40080100,0x2000100,0x40000000,0x42080000,0x2080100,0x40080100,0x100,0x2000000,0x42080000,0x42080100,0x80100,0x42000000,0x42080100,0x2080000,0,0x40080000,0x42000000,0x80100,0x2000100,0x40000100,0x80000,0,0x40080000,0x2080100,0x40000100);
      $spfunction6 = array (0x20000010,0x20400000,0x4000,0x20404010,0x20400000,0x10,0x20404010,0x400000,0x20004000,0x404010,0x400000,0x20000010,0x400010,0x20004000,0x20000000,0x4010,0,0x400010,0x20004010,0x4000,0x404000,0x20004010,0x10,0x20400010,0x20400010,0,0x404010,0x20404000,0x4010,0x404000,0x20404000,0x20000000,0x20004000,0x10,0x20400010,0x404000,0x20404010,0x400000,0x4010,0x20000010,0x400000,0x20004000,0x20000000,0x4010,0x20000010,0x20404010,0x404000,0x20400000,0x404010,0x20404000,0,0x20400010,0x10,0x4000,0x20400000,0x404010,0x4000,0x400010,0x20004010,0,0x20404000,0x20000000,0x400010,0x20004010);
      $spfunction7 = array (0x200000,0x4200002,0x4000802,0,0x800,0x4000802,0x200802,0x4200800,0x4200802,0x200000,0,0x4000002,0x2,0x4000000,0x4200002,0x802,0x4000800,0x200802,0x200002,0x4000800,0x4000002,0x4200000,0x4200800,0x200002,0x4200000,0x800,0x802,0x4200802,0x200800,0x2,0x4000000,0x200800,0x4000000,0x200800,0x200000,0x4000802,0x4000802,0x4200002,0x4200002,0x2,0x200002,0x4000000,0x4000800,0x200000,0x4200800,0x802,0x200802,0x4200800,0x802,0x4000002,0x4200802,0x4200000,0x200800,0,0x2,0x4200802,0,0x200802,0x4200000,0x800,0x4000002,0x4000800,0x800,0x200002);
      $spfunction8 = array (0x10001040,0x1000,0x40000,0x10041040,0x10000000,0x10001040,0x40,0x10000000,0x40040,0x10040000,0x10041040,0x41000,0x10041000,0x41040,0x1000,0x40,0x10040000,0x10000040,0x10001000,0x1040,0x41000,0x40040,0x10040040,0x10041000,0x1040,0,0,0x10040040,0x10000040,0x10001000,0x41040,0x40000,0x41040,0x40000,0x10041000,0x1000,0x40,0x10040040,0x1000,0x41040,0x10001000,0x40,0x10000040,0x10040000,0x10040040,0x10000000,0x40000,0x10001040,0,0x10041040,0x40040,0x10000040,0x10040000,0x10001000,0x10001040,0,0x10041040,0x41000,0x41000,0x1040,0x1040,0x40040,0x10000000,0x10041000);
      $masks = array (4294967295,2147483647,1073741823,536870911,268435455,134217727,67108863,33554431,16777215,8388607,4194303,2097151,1048575,524287,262143,131071,65535,32767,16383,8191,4095,2047,1023,511,255,127,63,31,15,7,3,1,0);

      //create the 16 or 48 subkeys we will need
      $keys = self::_createKeys ($key);
      $m=0;
      $len = strlen($message);
      $chunk = 0;
      //set up the loops for single and triple des
      $iterations = ((count($keys) == 32) ? 3 : 9); //single or triple des
      if ($iterations == 3) {$looping = (($encrypt) ? array (0, 32, 2) : array (30, -2, -2));}
      else {$looping = (($encrypt) ? array (0, 32, 2, 62, 30, -2, 64, 96, 2) : array (94, 62, -2, 32, 64, 2, 30, -2, -2));}

      $message .= (chr(0) . chr(0) . chr(0) . chr(0) . chr(0) . chr(0) . chr(0) . chr(0)); //pad the message out with null bytes
      //store the result here
      $result = "";
      $tempresult = "";

      if ($mode == 1) { //CBC mode
        $cbcleft = (ord($iv{$m++}) << 24) | (ord($iv{$m++}) << 16) | (ord($iv{$m++}) << 8) | ord($iv{$m++});
        $cbcright = (ord($iv{$m++}) << 24) | (ord($iv{$m++}) << 16) | (ord($iv{$m++}) << 8) | ord($iv{$m++});
        $m=0;
      }

      //loop through each 64 bit chunk of the message
      while ($m < $len) {
        $left = (ord($message{$m++}) << 24) | (ord($message{$m++}) << 16) | (ord($message{$m++}) << 8) | ord($message{$m++});
        $right = (ord($message{$m++}) << 24) | (ord($message{$m++}) << 16) | (ord($message{$m++}) << 8) | ord($message{$m++});

        //for Cipher Block Chaining mode, xor the message with the previous result
        if ($mode == 1) {if ($encrypt) {$left ^= $cbcleft; $right ^= $cbcright;} else {$cbcleft2 = $cbcleft; $cbcright2 = $cbcright; $cbcleft = $left; $cbcright = $right;}}

        //first each 64 but chunk of the message must be permuted according to IP
        $temp = (($left >> 4 & $masks[4]) ^ $right) & 0x0f0f0f0f; $right ^= $temp; $left ^= ($temp << 4);
        $temp = (($left >> 16 & $masks[16]) ^ $right) & 0x0000ffff; $right ^= $temp; $left ^= ($temp << 16);
        $temp = (($right >> 2 & $masks[2]) ^ $left) & 0x33333333; $left ^= $temp; $right ^= ($temp << 2);
        $temp = (($right >> 8 & $masks[8]) ^ $left) & 0x00ff00ff; $left ^= $temp; $right ^= ($temp << 8);
        $temp = (($left >> 1 & $masks[1]) ^ $right) & 0x55555555; $right ^= $temp; $left ^= ($temp << 1);

        $left = (($left << 1) | ($left >> 31 & $masks[31]));
        $right = (($right << 1) | ($right >> 31 & $masks[31]));

        //do this either 1 or 3 times for each chunk of the message
        for ($j=0; $j<$iterations; $j+=3) {
          $endloop = $looping[$j+1];
          $loopinc = $looping[$j+2];
          //now go through and perform the encryption or decryption
          for ($i=$looping[$j]; $i!=$endloop; $i+=$loopinc) { //for efficiency
            $right1 = $right ^ $keys[$i];
            $right2 = (($right >> 4 & $masks[4]) | ($right << 28)) ^ $keys[$i+1];
            //the result is attained by passing these bytes through the S selection functions
            $temp = $left;
            $left = $right;
            $right = $temp ^ ($spfunction2[($right1 >> 24 & $masks[24]) & 0x3f] | $spfunction4[($right1 >> 16 & $masks[16]) & 0x3f]
                  | $spfunction6[($right1 >>  8 & $masks[8]) & 0x3f] | $spfunction8[$right1 & 0x3f]
                  | $spfunction1[($right2 >> 24 & $masks[24]) & 0x3f] | $spfunction3[($right2 >> 16 & $masks[16]) & 0x3f]
                  | $spfunction5[($right2 >>  8 & $masks[8]) & 0x3f] | $spfunction7[$right2 & 0x3f]);
          }
          $temp = $left; $left = $right; $right = $temp; //unreverse left and right
        } //for either 1 or 3 iterations

        //move then each one bit to the right
        $left = (($left >> 1 & $masks[1]) | ($left << 31));
        $right = (($right >> 1 & $masks[1]) | ($right << 31));

        //now perform IP-1, which is IP in the opposite direction
        $temp = (($left >> 1 & $masks[1]) ^ $right) & 0x55555555; $right ^= $temp; $left ^= ($temp << 1);
        $temp = (($right >> 8 & $masks[8]) ^ $left) & 0x00ff00ff; $left ^= $temp; $right ^= ($temp << 8);
        $temp = (($right >> 2 & $masks[2]) ^ $left) & 0x33333333; $left ^= $temp; $right ^= ($temp << 2);
        $temp = (($left >> 16 & $masks[16]) ^ $right) & 0x0000ffff; $right ^= $temp; $left ^= ($temp << 16);
        $temp = (($left >> 4 & $masks[4]) ^ $right) & 0x0f0f0f0f; $right ^= $temp; $left ^= ($temp << 4);

        //for Cipher Block Chaining mode, xor the message with the previous result
        if ($mode == 1) {if ($encrypt) {$cbcleft = $left; $cbcright = $right;} else {$left ^= $cbcleft2; $right ^= $cbcright2;}}
        $tempresult .= (chr($left>>24 & $masks[24]) . chr(($left>>16 & $masks[16]) & 0xff) . chr(($left>>8 & $masks[8]) & 0xff) . chr($left & 0xff) . chr($right>>24 & $masks[24]) . chr(($right>>16 & $masks[16]) & 0xff) . chr(($right>>8 & $masks[8]) & 0xff) . chr($right & 0xff));

        $chunk += 8;
        if ($chunk == 512) {$result .= $tempresult; $tempresult = ""; $chunk = 0;}
      } //for every 8 characters, or 64 bits in the message

      //return the result as an array
      return ($result . $tempresult);
    } //end of des

    /**
     +----------------------------------------------------------
     * createKeys
     * this takes as input a 64 bit key (even though only 56 bits are used)
     * as an array of 2 integers, and returns 16 48 bit keys
     *
     +----------------------------------------------------------
     * @access static
     +----------------------------------------------------------
     * @param string $key 加密key
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     * @throws ThinkExecption
     +----------------------------------------------------------
     */
    function _createKeys ($key) {
      //declaring this locally speeds things up a bit
      $pc2bytes0  = array (0,0x4,0x20000000,0x20000004,0x10000,0x10004,0x20010000,0x20010004,0x200,0x204,0x20000200,0x20000204,0x10200,0x10204,0x20010200,0x20010204);
      $pc2bytes1  = array (0,0x1,0x100000,0x100001,0x4000000,0x4000001,0x4100000,0x4100001,0x100,0x101,0x100100,0x100101,0x4000100,0x4000101,0x4100100,0x4100101);
      $pc2bytes2  = array (0,0x8,0x800,0x808,0x1000000,0x1000008,0x1000800,0x1000808,0,0x8,0x800,0x808,0x1000000,0x1000008,0x1000800,0x1000808);
      $pc2bytes3  = array (0,0x200000,0x8000000,0x8200000,0x2000,0x202000,0x8002000,0x8202000,0x20000,0x220000,0x8020000,0x8220000,0x22000,0x222000,0x8022000,0x8222000);
      $pc2bytes4  = array (0,0x40000,0x10,0x40010,0,0x40000,0x10,0x40010,0x1000,0x41000,0x1010,0x41010,0x1000,0x41000,0x1010,0x41010);
      $pc2bytes5  = array (0,0x400,0x20,0x420,0,0x400,0x20,0x420,0x2000000,0x2000400,0x2000020,0x2000420,0x2000000,0x2000400,0x2000020,0x2000420);
      $pc2bytes6  = array (0,0x10000000,0x80000,0x10080000,0x2,0x10000002,0x80002,0x10080002,0,0x10000000,0x80000,0x10080000,0x2,0x10000002,0x80002,0x10080002);
      $pc2bytes7  = array (0,0x10000,0x800,0x10800,0x20000000,0x20010000,0x20000800,0x20010800,0x20000,0x30000,0x20800,0x30800,0x20020000,0x20030000,0x20020800,0x20030800);
      $pc2bytes8  = array (0,0x40000,0,0x40000,0x2,0x40002,0x2,0x40002,0x2000000,0x2040000,0x2000000,0x2040000,0x2000002,0x2040002,0x2000002,0x2040002);
      $pc2bytes9  = array (0,0x10000000,0x8,0x10000008,0,0x10000000,0x8,0x10000008,0x400,0x10000400,0x408,0x10000408,0x400,0x10000400,0x408,0x10000408);
      $pc2bytes10 = array (0,0x20,0,0x20,0x100000,0x100020,0x100000,0x100020,0x2000,0x2020,0x2000,0x2020,0x102000,0x102020,0x102000,0x102020);
      $pc2bytes11 = array (0,0x1000000,0x200,0x1000200,0x200000,0x1200000,0x200200,0x1200200,0x4000000,0x5000000,0x4000200,0x5000200,0x4200000,0x5200000,0x4200200,0x5200200);
      $pc2bytes12 = array (0,0x1000,0x8000000,0x8001000,0x80000,0x81000,0x8080000,0x8081000,0x10,0x1010,0x8000010,0x8001010,0x80010,0x81010,0x8080010,0x8081010);
      $pc2bytes13 = array (0,0x4,0x100,0x104,0,0x4,0x100,0x104,0x1,0x5,0x101,0x105,0x1,0x5,0x101,0x105);
      $masks = array (4294967295,2147483647,1073741823,536870911,268435455,134217727,67108863,33554431,16777215,8388607,4194303,2097151,1048575,524287,262143,131071,65535,32767,16383,8191,4095,2047,1023,511,255,127,63,31,15,7,3,1,0);

      //how many iterations (1 for des, 3 for triple des)
      $iterations = ((strlen($key) >= 24) ? 3 : 1);
      //stores the return keys
      $keys = array (); // size = 32 * iterations but you don't specify this in php
      //now define the left shifts which need to be done
      $shifts = array (0, 0, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 0);
      //other variables
      $m=0;
      $n=0;

      for ($j=0; $j<$iterations; $j++) { //either 1 or 3 iterations
        $left = (ord($key{$m++}) << 24) | (ord($key{$m++}) << 16) | (ord($key{$m++}) << 8) | ord($key{$m++});
        $right = (ord($key{$m++}) << 24) | (ord($key{$m++}) << 16) | (ord($key{$m++}) << 8) | ord($key{$m++});

        $temp = (($left >> 4 & $masks[4]) ^ $right) & 0x0f0f0f0f; $right ^= $temp; $left ^= ($temp << 4);
        $temp = (($right >> 16 & $masks[16]) ^ $left) & 0x0000ffff; $left ^= $temp; $right ^= ($temp << -16);
        $temp = (($left >> 2 & $masks[2]) ^ $right) & 0x33333333; $right ^= $temp; $left ^= ($temp << 2);
        $temp = (($right >> 16 & $masks[16]) ^ $left) & 0x0000ffff; $left ^= $temp; $right ^= ($temp << -16);
        $temp = (($left >> 1 & $masks[1]) ^ $right) & 0x55555555; $right ^= $temp; $left ^= ($temp << 1);
        $temp = (($right >> 8 & $masks[8]) ^ $left) & 0x00ff00ff; $left ^= $temp; $right ^= ($temp << 8);
        $temp = (($left >> 1 & $masks[1]) ^ $right) & 0x55555555; $right ^= $temp; $left ^= ($temp << 1);

        //the right side needs to be shifted and to get the last four bits of the left side
        $temp = ($left << 8) | (($right >> 20 & $masks[20]) & 0x000000f0);
        //left needs to be put upside down
        $left = ($right << 24) | (($right << 8) & 0xff0000) | (($right >> 8 & $masks[8]) & 0xff00) | (($right >> 24 & $masks[24]) & 0xf0);
        $right = $temp;

        //now go through and perform these shifts on the left and right keys
        for ($i=0; $i < count($shifts); $i++) {
          //shift the keys either one or two bits to the left
          if ($shifts[$i] > 0) {
             $left = (($left << 2) | ($left >> 26 & $masks[26]));
             $right = (($right << 2) | ($right >> 26 & $masks[26]));
          } else {
             $left = (($left << 1) | ($left >> 27 & $masks[27]));
             $right = (($right << 1) | ($right >> 27 & $masks[27]));
          }
          $left = $left & -0xf;
          $right = $right & -0xf;

          //now apply PC-2, in such a way that E is easier when encrypting or decrypting
          //this conversion will look like PC-2 except only the last 6 bits of each byte are used
          //rather than 48 consecutive bits and the order of lines will be according to
          //how the S selection functions will be applied: S2, S4, S6, S8, S1, S3, S5, S7
          $lefttemp = $pc2bytes0[$left >> 28 & $masks[28]] | $pc2bytes1[($left >> 24 & $masks[24]) & 0xf]
                  | $pc2bytes2[($left >> 20 & $masks[20]) & 0xf] | $pc2bytes3[($left >> 16 & $masks[16]) & 0xf]
                  | $pc2bytes4[($left >> 12 & $masks[12]) & 0xf] | $pc2bytes5[($left >> 8 & $masks[8]) & 0xf]
                  | $pc2bytes6[($left >> 4 & $masks[4]) & 0xf];
          $righttemp = $pc2bytes7[$right >> 28 & $masks[28]] | $pc2bytes8[($right >> 24 & $masks[24]) & 0xf]
                    | $pc2bytes9[($right >> 20 & $masks[20]) & 0xf] | $pc2bytes10[($right >> 16 & $masks[16]) & 0xf]
                    | $pc2bytes11[($right >> 12 & $masks[12]) & 0xf] | $pc2bytes12[($right >> 8 & $masks[8]) & 0xf]
                    | $pc2bytes13[($right >> 4 & $masks[4]) & 0xf];
          $temp = (($righttemp >> 16 & $masks[16]) ^ $lefttemp) & 0x0000ffff;
          $keys[$n++] = $lefttemp ^ $temp; $keys[$n++] = $righttemp ^ ($temp << 16);
        }
      } //for each iterations
      //return the keys we've created
      return $keys;
    } //end of des_createKeys

}
/**
 * Description of ErrorMessage
 *
 * @author moi
 */
class ErrorMessage {
    //---------------------------公共错误---------------------------
    //                          1001_10000
    /**
     * 参数错误
     * @var <int>
     */
    public static $PARAMETER_FORMAT_ERROR = 1001;

    /**
     * 操作失败
     * @var <int>
     */
    public static $OPERATION_FAILED = 1002;

    /**
     * 指定记录不存在
     * @var <int>
     */
    public static $RECORD_NOT_EXISTS = 1003;

    /**
     * 保存失败
     * @var <int>
     */
    public static $SAVE_FAILED = 1004;

    /**
     * 联系方式无效
     * @var <int>
     */
    public static $CONTACT_ERROR = 1005;

    /**
     * 无权进行此操作
     * @var <int>
     */
    public static $PERMISSION_LESS = 1006;

    /**
     * 文件路径错误
     * @var <int>
     */
    public static $FILE_PATH_ERROR = 1007;

    /**
     * 对方无权接受此请求
     * @var <int>
     */
    public static $OTHER_NO_PERMISSION_ACCEPT = 1008;

    /**
     * 指定省份不存在
     * @var <int>
     */
    public static $PROVINCE_CODE_NOT_EXISTS = 1009;

    //------------------------用户模块错误------------------------
    //                        10001_13000
    /**
     * 密码格式错误
     * @var <int>
     */
    public static $PASSWORD_FORMAT_ERROR = 10001;

    /**
     * 账户被冻结
     * @var <int>
     */
    public static $ACCOUNT_FREEZED = 10002;

    /**
     * 用户密码错误
     * @var <int>
     */
    public static $PASSWORD_ERROE = 10003;

    /**
     * 账户不存在
     * @var <int>
     */
    public static $ACCOUNT_NOT_EXISTS = 10004;

    /**
     * 用户名格式错误
     * @var <int>
     */
    public static $USERNAME_FORMAT_ERROR = 10005;

    /**
     * 邮箱格式错误
     * @var <int>
     */
    public static $EMAIL_FORMAT_ERROR = 10006;

    /**
     * 用户名已存在
     * @var <int>
     */
    public static $USERNAME_EXISTS = 10007;

    /**
     * 邮箱已存在
     * @var <int>
     */
    public static $EMAIL_EXISTS = 10008;

    /**
     * 昵称已存在
     * @var <int>
     */
    public static $NICK_EXISTS = 10009;

    /**
     * 原密码错误
     * @var <int>
     */
    public static $OLD_PASSWORD_ERROE = 10010;

    /**
     * 新密码格式错误
     * @var <int>
     */
    public static $NEW_PASSWORD_FORMAT_ERROE = 10011;

    /**
     * 指定用户不存在
     * @var <int>
     */
    public static $USER_NOT_EXISTS = 10012;

    /**
     * 指定用户不是经纪人
     * @var <int>
     */
    public static $USER_NOT_AGENT = 10013;

    /**
     * 账户未激活
     * @var <int>
     */
    public static $ACCOUNT_NOT_ACTIVATE = 10014;

    /**
     * 头像文件路径错误
     * @var <int>
     */
    public static $PHOTO_PATH_ERROR = 10015;

    /**
     * 验证码错误
     * @var <int>
     */
    public static $RV_CODE_ERROR = 10016;

    /**
     * 姓名格式错误
     * @var <int>
     */
    public static $NAME_FORMAT_ERROR = 10017;

    /**
     * 身份证号码格式错误
     * @var <int>
     */
    public static $IDNUM_FORMAT_ERROR = 10018;

    /**
     * 企业名称格式错误
     * @var <int>
     */
    public static $ENAME_FORMAT_ERROR = 10019;

    /**
     * 营业执照号码格式错误
     * @var <int>
     */
    public static $LNUM_FORMAT_ERROR = 10020;

    /**
     * 组织机构代码格式错误
     * @var <int>
     */
    public static $OCODE_FORMAT_ERROR = 10021;

    /**
     * COOKIE无效
     * @var <int>
     */
    public static $COOKIE_INVALID = 10022;

    /**
     * 帐号激活码无效
     * @var <int>
     */
    public static $ACTIVE_CODE_INVALID = 10023;

    /**
     * 对方未公开联系方式
     * @var <int>
     */
    public static $USER_NOT_OPEN_CONTACT = 10024;

    /**
     * 指定邮箱不存在
     * @var <int>
     */
    public static $EMAIL_NOT_EXISTS = 10025;

    /**
     * 密码错误导致账户锁定
     * @var <int>
     */
    public static $PWD_ERROR_LOCK = 10026;

    /**
     * 非企业用户无法使用企业登录通道
     * @var <int>
     */
    public static $NOT_COMPANY_ACCOUNT = 10027;
    
    /**
     *固定电话格式错误
     * @var <int> 
     */
    public static $FIXED_PHONE_FORMAT_ERROR=10028;

    //------------------------认证模块错误------------------------
    //                        13001_14000
    /**
     * 邮箱验证码无效
     * @var <int>
     */
    public static $EMAIL_CODE_INVALID = 13001;

    /**
     * 银行卡号已被使用
     * @var <int>
     */
    public static $CARDNUM_EXISTS = 13002;

    /**
     * 指定记录已被审核
     * @var <int>
     */
    public static $RECORD_CHECKED = 13003;

    /**
     * 手机号码格式错误
     * @var <int>
     */
    public static $PHONE_FORMAT_ERROR = 13004;
    
    /**
     * 手机号码已被使用
     * @var <int>
     */
    public static $PHONE_EXISTS = 13005;

    /**
     * 手机验证码无效
     * @var <int>
     */
    public static $PHONE_CODE_INVALID = 13006;

    /**
     * 已经实名认证
     * @var <int>
     */
    public static $REAL_AUTHED = 13007;

    /**
     * 指定身份证号码已被使用
     * @var <int>
     */
    public static $IDNUM_EXISTS = 13008;

    /**
     * 指定营业执照号码已被使用
     * @var <int>
     */
    public static $LNUM_EXISTS = 13009;

    /**
     * 指定组织机构代码已被使用
     * @var <int>
     */
    public static $OCODE_EXISTS = 13010;
    
    /**
     * 指定手机不存在
     * @var <int>
     */
    public static $PHONE_NOT_EXISTS = 13011;

    //------------------------任务模块错误------------------------
    //                        14001_17000
    /**
     * 指定任务不存在
     * @var <int>
     */
    public static $TASK_NOT_EXISTS = 14001;
    
    /**
     * 任务操作权限不足
     * @var <int>
     */
    public static $TASK_DO_PERMISSION_LESS = 14002;

    /**
     * 指定投标稿件不存在
     * @var <int>
     */
    public static $REPLY_NOT_EXISTS = 14003;

    /**
     * 指定投标稿件不属于此任务
     * @var <int>
     */
    public static $REPLY_NOT_IN_TASK = 14004;

    /**
     * 该任务状态下无法选标
     * @var <int>
     */
    public static $TASK_STATUS_NO_BID = 14005;

    /**
     * 没有指定任务类别的发布权限
     * @var <int>
     */
    public static $NO_TCLASS_PPERMISSION = 14006;

    /**
     * 没有指定任务类别的竞标权限
     * @var <int>
     */
    public static $NO_TCLASS_BPERMISSION = 14007;

    /**
     * 不能参与投标自己发布的任务
     * @var <int>
     */
    public static $BID_OWN_TASK = 14008;

    /**
     * 没有选择天数
     * @var <int>
     */
    public static $SERVICE_TOP_DAY = 14009;

    /**
     * 该分类下已有置顶帖
     * @var <int>
     */
    public static $SERVICE_TOP_EXISTS = 14010;

    //------------------------通知模块错误------------------------
    //                        17001_18000

    //------------------------站内信模块--------------------------
    //                        18001_19000
    /**
     * 回复不存在
     * @var <int>
     */
    public static $MREPLY_NOT_EXISTS = 18001;
    
    //------------------------账单模块--------------------------
    //                        19001_20000
    /**
     * 金额错误
     * @var <int>
     */
    public static $MONEY_ERROR = 19001;
    
    /**
     * 指定账单不存在
     * @var <int>
     */
    public static $BILL_NOT_EXISTS = 19002;

    /**
     * 余额不足
     * @var <int>
     */
    public static $MONEY_NOT_ENOUGH = 19003;

    /**
     * 支付失败
     * @var <int>
     */
    public static $PAY_FAILED = 19004;

    /**
     * 订单不存在
     * @var <int>
     */
    public static $ORDER_NOT_EXISTS = 19005;

    //------------------------套餐模块--------------------------
    //                        20001_21000
    /**
     * 套餐不存在
     * @var <int>
     */
    public static $PACKAGE_NOT_EXISTS = 20001;

    /**
     * 套餐价格错误
     * @var <int>
     */
    public static $PACKAGE_MONEY_ERROR = 20002;

    /**
     * 套餐角色错误
     * @var <int>
     */
    public static $PACKAGE_ROLE_ERROR = 20003;

    //------------------------推广位模块-------------------------
    //                         21001_22000
    /**
     *推广位不存在
     * @var <int>
     */
    public static $PROMOTE_NOT_EXISTS=21001;
    
    /**
     *没有抢占该推广位的权限
     * @var <int> 
     */
    public static $NO_HOLD_PROMOTE_PERMISSION=21002;

    /**
     *该推广位已经被占用
     * @var <int>
     */
    public static $IS_HOLD_PROMOTE=21003;

    /**
     * 推广位占用天数越界
     * @var <int>
     */
    public static $PROMOTE_DAYS_ERROR=21004;

    /**
     * 选择的推广服务错误
     * @var <int>
     */
    public static $PROMOTE_SERVICE_ERROR = 21005;

    /**
     * 选择的推广服务天数错误
     * @var <int>
     */
    public static $PROMOTE_SERVICE_DATE_ERROR = 21006;

    /**
     * 推广服务使用人数已满
     * @var <int>
     */
    public static $PROMOTE_USER_FULL = 21007;

    /**
     * 已购买了此推广服务
     * @var <int>
     */
    public static $PROMOTE_HAD = 21008;

    /**
     * 推广位记录已过期
     * @var <int>
     */
    public static $PROMOTE_EXPIRED = 21009;

    //----------------------------------简历---------------------------------
    //                               22001_23000

    /**
     * 求职意向添加失败
     * @var <int>
     */
    public static $JOB_INTENT_ADD_ERROR=22001;

    /**
     * 学历添加失败
     * @var <int>
     */
    public static $DEGREE_ADD_ERROR=22002;

    /**
     * 简历添加失败
     * @var <int> 
     */
    public static $RESUME_ADD_ERROR=22003;

    /**
     * 挂证意向添加失败
     * @var <int>
     */
    public static $HANG_CARD_INTENT_ADD_ERROR=22004;

    /**
     * 简历已公开
     * @var <int>
     */
    public static $RESUME_OPEN=22005;

    /**
     * 简历未公开
     * @var <int>
     */
    public static $RESUME_CLOSE=22006;

    /**
     * 简历已委托
     * @var <int> 
     */
    public static $RESUME_AGENT=22007;

    /**
     * 简历未委托
     * @var <int>
     */
    public static $RESUME_NOT_AGENT=22008;

    /**
     *人才不存在
     * @var <int>
     */
    public static $HUMAN_NOT_EXIST=22009;

    /**
     * 简历未委托给该经纪人
     * @var <int>
     */
    public static $RESUME_NOT_OWN=22010;

    /**
     * 指定简历不存在
     * @var <int>
     */
    public static $RESUME_NOT_EXIST=22011;

    /**
     * 委托简历状态添加失败
     * @var <int>
     */
    public static $DRS_ADD_FAIL=22012;

    /**
     * 委托简历未公开
     * @var <int>
     */
    public static $DRS_NOT_OPEN=22013;

    /**
     * 委托简历状态更新失败
     * @var <int>
     */
    public static $DRS_UPDATE_FAIL=22014;

    /**
     * 委托简历状态格式错误
     * @var <int>
     */
    public static $DRS_FORMAT_FAIL=22015;

    /**
     * 指定人才不是指定经纪人拥有的人才
     */
    public static $HUMAN_NOT_OWN=22016;

    //------------------------证书模块-------------------------
    //                       23001_24000
    /**
     * 指定职称专业不存在
     * @var <int>
     */
    public static $GCM_NOT_EXISTS = 23001;

    /**
     * 指定职称类型不存在
     * @var <int>
     */
    public static $GCT_NOT_EXISTS = 23002;

    /**
     * 注册证书为空
     * @var <int>
     */
    public static $REGISTER_CERTIFICATE_EMPTY = 23003;

    /**
     * 指定注册证书不存在
     * @var <int>
     */
    public static $RC_NOT_EXISTS = 23004;

    /**
     * 证书重复
     * @var <int>
     */
    public static $CERT_REPEAT = 23005;

    /**
     * 证书不存在
     * @var <int>
     */
    public static $CERT_NOT_EXISTS = 23006;

    /**
     * 无证书操作权限
     * @var <int>
     */
    public static $CERT_NO_PERMISSION = 23007;

    //------------------------职位模块-------------------------
    //                       24001_25000
    /**
     * 资质要求不能为空
     * @var <int>
     */
    public static $CERTIFICATE_REQUIRE_EMPTY = 24001;

    /**
     * 资质要求格式错误
     * @var <int>
     */
    public static $CERTIFICATE_REQUIRE_FORMAT_ERROR = 24002;
    
    /**
     * 地区要求不能为空
     * @var <int>
     */
    public static $PLACE_EMPTY = 24003;

    /**
     * 指定职位不存在
     * @var <int>
     */
    public static $JOB_NOT_EXISTS = 24004;

    /**
     * 职位发布权限不足
     * @var <int>
     */
    public static $JOB_PUB_NO_PERMISSION = 24005;

    /**
     * 职位委托权限不足
     * @var <int>
     */
    public static $JOB_ENT_NO_PERMISSION = 24006;

    /**
     * 职位已关闭
     * @var <int>
     */
    public static $JOB_HAS_CLOSED = 24007;

    /**
     * 职位邀请简历权限不足
     * @var <int>
     */
    public static $JOB_INVITE_NO_PERMISSION = 24008;

    /**
     * 职位操作权限不足
     * @var <int>
     */
    public static $JOB_OPERATE_NO_PERMISSION = 24009;

    /**
     * 资质信息格式错误
     * @var <int>
     */
    public static $CERTIFICATE_INFO_FORMAT_ERROR = 24010;

    /**
     * 职位未被代理
     * @var <int>
     */
    public static $JOB_NOT_AGENTED = 24011;

    /**
     * 资质要求和职称要求至少填一个
     * @var <int>
     */
    public static $RC_GC_ONE_AT_LEAST = 24012;

    //------------------------经纪人服务模块-------------------------
    //                       25001_26000
    /**
     * 指定经纪人服务类别不存在
     * @var <int>
     */
    public static $SERVICE_CATEGORY_NOT_EXISTS = 25001;

    //------------------------人脉模块-------------------------
    //                       26001_27000
    /**
     * 已经存在关注关系
     * @var <int>
     */
    public static $FOLLOW_EXISTS = 26001;

    /**
     * 无权关注此用户
     * @var <int>
     */
    public static $FOLLOW_NO_PERMISSION = 26002;

    //-------------------------Blog模块----------------------------------

    /**
     * 指定创建人不是Blog的拥有人
     */
    public static $BLOG_NOT_OWN=27001;
    
    /**
     * Blog状态无效
     */
    public static $BLOG_STATUS_INVALID=27002;

    /**
     * Blog未审核
     */
    public static $BLOG_NOT_AUDIT=27003;

    /**
     * Blog不存在
     */
    public static $BLOG_NOT_EXIST=27004;
    
    //-----------------------------回拨模块--------------------
    
    /**
     * 
     * 用户禁止回拨
     * @var unknown_type
     */
    public static $CALL_NOT=28001;
    
    /**
     * 忙碌中
     * Enter description here ...
     * @var unknown_type
     */
    public static $CALL_BUSY=28002;
    
    /**
     * 不存在
     * Enter description here ...
     * @var unknown_type
     */
    public static $CALL_NOT_CONVENIENT=28003;
    
    /**
     * 通话不存在不存在
     * Enter description here ...
     * @var unknown_type
     */
    public static $CALL_NOT_EXISTS=28004;
    
    /**
     * 通话不存在不存在
     * Enter description here ...
     * @var unknown_type
     */
    public static $CALL_END=28005;
    
    /**
     * 无剩余套餐分钟数
     * Enter description here ...
     * @var unknown_type
     */
    public static $CALL_NO_MIN=28006;
    
    /**
     *active
     * @var type 
     */
    public static $ACTIVE_NOT_PHONE=28007;
    
    public static $PASSIVE_NOT_PHONE=28008;


    protected static $message = array(
        1001    => '参数错误',
        1002    => '操作失败',
        1003    => '指定记录不存在',
        1004    => '保存失败！请检查您的信息是否填写正确！',
        1005    => '操作失败！手机号码为必填的联系方式！',
        1006    => '对不起！您无权进行此操作！',
        1007    => '文件路径错误',
        1008    => '操作失败！对方无权接受此请求！',
        1009    => '指定省份不存在',

        10001   => '密码格式错误',
        10002   => '该账户已被冻结',
        10003   => '登录密码错误',
        10004   => '用户名不存在',
        10005   => '用户名格式错误',
        10006   => '邮箱格式错误',
        10007   => '该用户名已被占用',
        10008   => '该邮箱已被占用',
        10009   => '该昵称已被占用',
        10010   => '原密码错误',
        10011   => '新密码格式错误',
        10012   => '指定用户不存在',
        10013   => '指定用户不是经纪人/公司，无权进行此操作',
        10014   => '该账户未激活',
        10015   => '头像文件路径错误',
        10016   => '验证码错误',
        10017   => '姓名格式错误',
        10018   => '身份证号码格式错误',
        10019   => '企业名称格式错误',
        10020   => '营业执照号码格式错误',
        10021   => '组织机构代码格式错误',
        10022   => '当前COOKIE无效',
        10023   => '帐号激活码无效',
        10024   => '查看失败，对方未公开联系方式！',
        10025   => '指定邮箱不存在！',
        10026   => '你的账户在短时间内密码错误3次，已被锁定，请在15分钟后再进行尝试。',
        10027   => '您不是企业用户，请重新登录!',
        10028   => '固定电话格式错误',

        13001   => '邮箱验证码无效',
        13002   => '该银行卡号已被使用',
        13003   => '指定记录已被审核过了',
        13004   => '手机号码格式错误',
        13005   => '该手机号码已被使用',
        13006   => '手机验证码无效',
        13007   => '你已经进行实名认证了',
        13008   => '指定身份证号码已被使用',
        13009   => '指定营业执照号码已被使用',
        13010   => '指定组织机构代码已被使用',
        13011   => '指定手机不存在或未认证',

        14001   => '指定编号任务不存在',
        14002   => '对不起，您无权操作此任务！',
        14003   => '指定投标稿件不存在',
        14004   => '指定投标稿件不属于此任务！',
        14005   => '指定任务所处状态不允许选标！',
        14006   => '对不起，您没有该任务类别的发布权限！',
        14007   => '对不起，您没有该任务类别的竞标权限！',
        14008   => '对不起，您不能参与投标自己发布的任务！',
        14009   => '请选择置顶天数！',
        14010   => "该任务类下面已有置顶帖！",

        18001   => '回复编号不存在',

        19001   => '金额错误',
        19002   => '指定账单不存在',
        19003   => 'YEBZ0001',              //固定代号，不允许改动
        19004   => '支付失败！',
        19005   => '指定订单不存在！',

        20001   => '指定套餐不存在',
        20002   => '指定套餐价格有误',
        20003   => '对不起，您无法购买该套餐！',

        21001   => '对不起，没有这个推广位',
        21002   => '对不起，您没有抢占这个推广位的权限！',
        21003   => '对不起，这个推广位已经被占用了！',
        21004   => '对不起，你输入的推广位占用天数不合法！',
        21005   => '对不起，你选择的推广服务错误！',
        21006   => '对不起，推广服务购买天数不在指定范围内！',
        21007   => '对不起，该推广服务购买人数已满！',
        21008   => '操作失败，你已购买了该推广服务！',
        21009   => '操作失败，你购买的此推广服务已过期！',

        22001   => '求职意向添加失败！',
        22002   => '学历添加失败！',
        22003   => '简历添加失败！',
        22004   => '挂证意向添加失败',
        22005   => '简历已公开，无法进行此操作',
        22006   => '简历未公开，无法进行此操作',
        22007   => '操作失败，你的简历已委托出去了',
        22008   => '操作失败，你的简历未委托出去',
        22009   => '人才不存在',
        22010   => '简历未委托给该经纪人',
        22011   => '指定简历不存在',
        22012   => '委托简历状态添加失败',
        22013   => '委托简历未公开',
        22014   => '委托简历状态更新失败',
        22015   => '委托简历状态格式错误',
        22016   => '指定人才不是指定经纪人拥有的人才',

        23001   => '指定职称专业不存在',
        23002   => '指定职称类型不存在',
        23003   => '注册证书信息不能为空',
        23004   => '指定注册证书不存在',
        23005   => '不能重复添加证书',
        23006   => '指定证书信息不存在',
        23007   => '对不起，你没有此证书的操作权限',

        24001   => '资质要求不能为空',
        24002   => '资质要求格式错误',
        24003   => '地区要求不能为空',
        24004   => '指定职位不存在',
        24005   => '对不起，你没有此职位的发布权限',
        24006   => '对不起，你没有此职位的委托权限',
        24007   => '职位已关闭，无法进行此操作',
        24008   => '对不起，你没有此职位的邀请简历权限',
        24009   => '对不起，你没有此职位的操作权限',
        24010   => '资质信息格式错误',
        24011   => '职位未被代理',
        24012   => '资质要求和职称要求至少填一个',

        25001   => '指定服务类别不存在',

        26001   => '操作失败！你已经关注了此用户',
        26002   => '对不起！你无权关注此用户',

        27001   => '指定创建人不是Blog的拥有人',
        27002   => 'Blog状态无效',
        27003   => 'Blog未审核',
        27004   => 'Blog不存在',
        
        28001   => '此用户不能电话回拨',
        28002   => '忙碌中',
        28003   => '指定用户不方便接听电话',
        28004   => '通话不存在',
        28005   => '通话已结束',
        28006   => '无剩余拨打电话分钟数',
        28007   => '你的手机未认证，请检查',
        28008   => '此用户电话未认证，或者电话不存在',
    );

    /**
     * 获取错误信息
     * @param  <int> $code 错误编号
     * @return <string> 错误信息
     */
    public static function get_error_message($code){
        return self::$message[$code];
    }
}


/**
 * Description of String
 *
 * @author moi
 */
class ZString {
    /**
     * 过滤HTML注释
     * @param  <string> $text 内容
     * @return <string> 过滤后的内容
     */
    public function filter_html_remark($text){
	return preg_replace('/<!--?.*-->/','',$text);
    }

    /**
     * 将数据封装为JSON格式
     * @param <mixed> $data 数据
     * @return string JSON字符串
     */
    public function json_encode($data){
        if(is_object($data)) {
            //对象转换成数组
            $data = get_object_vars($data);
        }else if(!is_array($data)) {
            if(is_bool($data)) {
                $data = $data?'true':'false';
            }elseif(is_int($data)) {
                $data = intval($data);
            }elseif(is_float($data)) {
                $data = floatval($data);
            }elseif(defined($data) && $data === null) {
                $data = strval(constant($data));
            }elseif(is_string($data)) {
                $data = strtr($data, array("\n" => '<br/>'));       //JSON解析换行符问题
                $data = strtr($data, array("\t" => ''));       //JSON解析换行符问题
                $data = strtr($data, array("\r\n" => ''));       //JSON解析换行符问题
                $data = strtr($data, array("\r" => ''));       //JSON解析换行符问题
                $data = '"'.addslashes($data).'"';
            }
            return $data;
            // 普通格式直接输出
            //return formatJsonValue($data);
        }
        // 判断是否关联数组
        if(empty($data) || is_numeric(implode('',array_keys($data)))) {
            $assoc  =  false;
        }else {
            $assoc  =  true;
        }
        // 组装 Json字符串
        $json = $assoc ? '{' : '[' ;
        foreach($data as $key=>$val) {
            if(!is_null($val)) {
                if($assoc) {
                    $json .= "\"$key\":".$this->json_encode($val).",";
                }else {
                    $json .= $this->json_encode($val).",";
                }
            }
        }
        if(strlen($json)>1) {// 加上判断 防止空数组
            $json  = substr($json,0,-1);
        }
        $json .= $assoc ? '}' : ']' ;
        return $json;
    }

    /**
     * 字符串截取
     * @param  <string> $str     原字符串
     * @param  <int>    $length  截取长度
     * @param  <int>    $start   开始截取位置
     * @param  <string> $charset 编码
     * @param  <bool>   $suffix  是否显示省略号
     * @return <string> 截取后的字符串
     */
    public function substr($str, $length, $start=0, $charset="utf-8", $suffix=true){
        if(function_exists("mb_substr"))
                return mb_substr($str, $start, $length, $charset);
        elseif(function_exists('iconv_substr')) {
                return iconv_substr($str,$start,$length,$charset);
        }
        $re['utf-8']  = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all($re[$charset], $str, $match);
        $slice = join("",array_slice($match[0], $start, $length));
        if($suffix && (strlen($str) - $start > $length)) return $slice."...";
        return $slice;
    }
}

/**
 * Description of Notify
 *
 * @author moi
 */
class Notify {
    //------------------public------------------
    /**
     * 发送通知
     * @param <mixed>  $receiver 接收方
     * @param <string> $name     接收方名称
     * @param <string> $title    通知标题
     * @param <string> $content  通知内容
     */
    public function send($receiver, $name, $title, $content){}

    //-----------------protected-------------------
    /**
     * 检测接收方的合法性
     * @param <mixed> $receiver
     */
    protected function check_receiver($receiver){}
}


class MessageNotify extends Notify{
    //------------------public------------------
    /**
     * 发送通知
     * @param <mixed>  $receiver 接收方
     * @param <string> $name     接收方名称
     * @param <string> $title    通知标题
     * @param <string> $content  通知内容
     */
    public function send($receiver, $name, $title, $content){
        if(!$this->check_receiver($receiver))
            return false;
        $service = new MessageService();
        return $service->send(0, C('SYSTEM_MESSAGE_NAME'), $receiver, $name, $title, $content, 0, 1, false, 2);
    }

    //-----------------protected-------------------
    /**
     * 检测接收方的合法性
     * @param <mixed> $receiver
     */
    protected function check_receiver($receiver){
        return intval($receiver) > 0;
    }
}


class EmailNotify extends Notify{
    //------------------public------------------
    /**
     * 发送通知
     * @param <mixed>  $receiver 接收方
     * @param <string> $name     接收方名称
     * @param <string> $title    通知标题
     * @param <string> $content  通知内容
     */
    public function send($receiver, $name, $title, $content){
        if(!$this->check_receiver($receiver))
            return false;
        require_cache(APP_PATH.'/Common/Function/email.php');
        send_email($receiver, $content, $title, '职讯网', $name);
    }

    //-----------------protected-------------------
    /**
     * 检测接收方的合法性
     * @param <mixed> $receiver
     */
    protected function check_receiver($receiver){
        if(strlen($receiver) > 100)
            return false;
        return preg_match(REGULAR_USER_EMAIL, $receiver) == 1;
    }
}

class SMSNotify extends Notify{
    //------------------public------------------
    /**
     * 发送通知
     * @param <mixed>  $receiver 接收方
     * @param <string> $name     接收方名称
     * @param <string> $title    通知标题
     * @param <string> $content  通知内容
     */
    public function send($receiver, $name, $title, $content){
        if(!$this->check_receiver($receiver))
            return false;
        require_cache(APP_PATH.'/Common/Class/SMS.class.php');
        $notify = new SMSFactory();
        $obj = $notify->get_object($receiver, $content);
        $obj->send();
    }

    //------------------protected------------------
    /**
     * 检测接收方的合法性
     * @param <mixed> $receiver
     */
    protected function check_receiver($receiver){
        return preg_match(REGULAR_USER_PHONE, $receiver) == 1;
    }

    /**
     * 标题过滤
     * @param  <string> $title 标题
     * @return <string>
     */
    protected function filter_title($title){
        return htmlspecialchars_decode($title);
    }

    /**
     * 内容过滤
     * @param  <string> $content 内容
     * @return <string>
     */
    protected function filter_content($content){
        return htmlspecialchars_decode($title);
    }
}

/**
 * Description of ZError
 *
 * @author moi
 */
class ZError {
    /**
     * 错误编号
     * @var <int>
     */
    private $error_code;

    /**
     * 错误信息
     * @var <string>
     */
    private $error_message;

    public function  __construct($var) {
        if(is_int($var))
            $this->error_code = $var;
        else
            $this->error_message = $var;
    }

    /**
     * 获取错误编号
     * @return <int> 错误编号
     */
    public function get_code(){
        return $this->error_code;
    }

    /**
     * 获取错误信息
     * @return <string> 错误信息
     */
    public function get_message(){
        if(empty($this->error_message))
            $this->error_message = ErrorMessage::get_error_message($this->error_code);
        return $this->error_message;
    }
}
?>
