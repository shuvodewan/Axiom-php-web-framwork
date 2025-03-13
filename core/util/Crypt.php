<?php

namespace Core\util;

class Crypt
{
    private $cipher = 'aes-256-cbc';
    private $key;
    private $ivLength;

    public function __construct()
    {
        $this->key=$this->getKey();
        $this->ivLength=openssl_cipher_iv_length($this->cipher);
    }
    private function getKey()
    {
        if(!config('app.key')){
            throw new \Exception('App key missing');
        }

        return config('app.key');
    }

    public function encrypt($data)
    {
        $iv = openssl_random_pseudo_bytes($this->ivLength);
        $encryptedData = openssl_encrypt($data, $this->cipher, $this->key, 0, $iv);
        return base64_encode($iv . $encryptedData);
    }
    public function decrypt($data)
    {
        $data = base64_decode($data);
        $iv = substr($data, 0, $this->ivLength);
        $encryptedData = substr($data, $this->ivLength);
        $decryptedData = openssl_decrypt($encryptedData, $this->cipher, $this->key, 0, $iv);
        return $decryptedData;
    }
}