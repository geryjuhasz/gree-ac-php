<?php namespace App;
class DeviceFinder
{
    const DEFAULT_KEY = 'a3K8Bx%2r8Y7#xDh';

    public function scan()
    {
        $fp = fsockopen("udp://192.168.1.109", 7000, $errno, $errstr);
        if (!$fp) {
            echo "ERROR: $errno - $errstr<br />\n";
        } else {
            // loop 100 times sending 100 Bytes messages
            for($i=0; $i<=100; $i++){
                fwrite($fp, "{\"t\":\"scan\"}");
                $x= fread($fp, 1024);  // read the reply back from the server
                if ($x) {
                    $oData = json_decode($x);
                    fclose($fp);
                    return json_decode($this->fnDecrypt($oData->pack, self::DEFAULT_KEY));
                }
//                echo "$i - $x\n";
            }
            fclose($fp);
        }
    }

    function fnDecrypt($sValue, $sSecretKey, $sMethod = 'aes-128-ecb')
    {
        $sText = base64_decode($sValue);
        return openssl_decrypt($sText, $sMethod, $sSecretKey, OPENSSL_RAW_DATA);
    }
}
