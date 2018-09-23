<?php namespace App;
class Device {
    const DEFAULT_KEY = 'a3K8Bx%2r8Y7#xDh';

    public $mac;
    public $mid;
    public $cid;
    public $name;

    private $key = '';

    public function pair()
    {
        $sPack = '{
  "mac": "'.$this->mac.'",
  "t": "bind",
  "uid": 0
}';
        $sEncPack = $this->fnEncrypt($sPack, self::DEFAULT_KEY);
        $sRequest = '{
  "cid": "'.$this->cid.'",
  "i": 1,
  "pack": "'.$sEncPack.'",
  "t": "pack",
  "tcid": "app",
  "uid": 0
}';
//        echo 'sending data: ' . $sRequest.PHP_EOL;
        $fp = fsockopen("udp://192.168.1.109", 7000, $errno, $errstr);
        fwrite($fp, $sRequest);
        $x = fread($fp, 1024);
        if ($x) {
            $oData = json_decode($x);
            $oResponse = json_decode($this->fnDecrypt($oData->pack, self::DEFAULT_KEY));
            $this->key = $oResponse->key;
            fclose($fp);
        }
    }

    public function on()
    {
        $sPack = '{
  "opt": ["Pow"],
  "p": [1],
  "t": "cmd"
}';
        $sEncPack = $this->fnEncrypt($sPack, $this->key);
        $sRequest = '{
  "t": "pack",
  "i": 0,
  "uid": 0,
  "cid": "'.$this->mac.'",
  "tcid": "",
  "pack": "'.$sEncPack.'"
}';
//        echo 'sending data: ' . $sRequest.PHP_EOL;
        $fp = fsockopen("udp://192.168.1.109", 7000, $errno, $errstr);
        fwrite($fp, $sRequest);
        $x = fread($fp, 1024);
        var_dump($x);exit;
        if ($x) {
            var_dump($x);exit;
            $oData = json_decode($x);
            $oResponse = json_decode($this->fnDecrypt($oData->pack, self::DEFAULT_KEY));
            $this->key = $oResponse->key;
            fclose($fp);
        }
    }

    public function setSwing($sValue)
    {
        $sPack = '{
  "opt": ["SwUpDn"],
  "p": ['.$sValue.'],
  "t": "cmd"
}';
        $sEncPack = $this->fnEncrypt($sPack, $this->key);
        $sRequest = '{
  "t": "pack",
  "i": 0,
  "uid": 0,
  "cid": "'.$this->mac.'",
  "tcid": "",
  "pack": "'.$sEncPack.'"
}';
//        echo 'sending data: ' . $sRequest.PHP_EOL;
        $fp = fsockopen("udp://192.168.1.109", 7000, $errno, $errstr);
        fwrite($fp, $sRequest);
        $x = fread($fp, 1024);
        var_dump($x);exit;
        if ($x) {
            var_dump($x);exit;
            $oData = json_decode($x);
            $oResponse = json_decode($this->fnDecrypt($oData->pack, self::DEFAULT_KEY));
            $this->key = $oResponse->key;
            fclose($fp);
        }
    }

    public function setTemp($sTemp)
    {
        $sPack = '{
  "opt": ["TemUn", "SetTem"],
  "p": [0, '.$sTemp.'],
  "t": "cmd"
}';
        $sEncPack = $this->fnEncrypt($sPack, $this->key);
        $sRequest = '{
  "t": "pack",
  "i": 0,
  "uid": 0,
  "cid": "'.$this->mac.'",
  "tcid": "",
  "pack": "'.$sEncPack.'"
}';
//        echo 'sending data: ' . $sRequest.PHP_EOL;
        $fp = fsockopen("udp://192.168.1.109", 7000, $errno, $errstr);
        fwrite($fp, $sRequest);
        $x = fread($fp, 1024);
        var_dump($x);exit;
        if ($x) {
            var_dump($x);exit;
            $oData = json_decode($x);
            $oResponse = json_decode($this->fnDecrypt($oData->pack, self::DEFAULT_KEY));
            $this->key = $oResponse->key;
            fclose($fp);
        }
    }

    public function off()
    {
        $sPack = '{
  "opt": ["Pow"],
  "p": [0],
  "t": "cmd"
}';
        $sEncPack = $this->fnEncrypt($sPack, $this->key);
        $sRequest = '{
  "t": "pack",
  "i": 0,
  "uid": 0,
  "cid": "'.$this->mac.'",
  "tcid": "",
  "pack": "'.$sEncPack.'"
}';
//        echo 'sending data: ' . $sRequest.PHP_EOL;
        $fp = fsockopen("udp://192.168.1.109", 7000, $errno, $errstr);
        fwrite($fp, $sRequest);
        $x = fread($fp, 1024);
        var_dump($x);exit;
        if ($x) {
            var_dump($x);exit;
            $oData = json_decode($x);
            $oResponse = json_decode($this->fnDecrypt($oData->pack, self::DEFAULT_KEY));
            $this->key = $oResponse->key;
            fclose($fp);
        }
    }

    function fnEncrypt($sValue, $sSecretKey, $sMethod = 'aes-128-ecb')
    {
        return base64_encode(openssl_encrypt($sValue, $sMethod, $sSecretKey, OPENSSL_RAW_DATA));
    }

    function fnDecrypt($sValue, $sSecretKey, $sMethod = 'aes-128-ecb')
    {
        $sText = base64_decode($sValue);
        return openssl_decrypt($sText, $sMethod, $sSecretKey, OPENSSL_RAW_DATA);
    }
}
