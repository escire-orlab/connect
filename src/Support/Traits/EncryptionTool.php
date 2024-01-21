<?php

namespace EscireOrlab\Connect\Support\Traits;

use RuntimeException;
use OpenSSL;

trait EncryptionTool
{

    const METHOD = 'AES-256-CBC';

    public static function encrypt($data, $key)
    {
        if (!$data) {
            throw new \InvalidArgumentException('No data provided for encryption.');
        }

        $ivLength = openssl_cipher_iv_length(self::METHOD);
        $iv = openssl_random_pseudo_bytes($ivLength);

        $encrypted = openssl_encrypt($data, self::METHOD, $key, 0, $iv);
        if ($encrypted === false) {
            throw new RuntimeException('Unable to encrypt the data.');
        }

        return base64_encode($iv . $encrypted);
    }

    public static function decrypt($data, $key)
    {
        if (!$data) {
            throw new \InvalidArgumentException('No data provided for decryption.');
        }

        $ivLength = openssl_cipher_iv_length(self::METHOD);
        $decodedData = base64_decode($data);
        $iv = substr($decodedData, 0, $ivLength);
        $encryptedData = substr($decodedData, $ivLength);

        $decrypted = openssl_decrypt($encryptedData, self::METHOD, $key, 0, $iv);
        if ($decrypted === false) {
            throw new RuntimeException('Unable to decrypt the data.');
        }

        return $decrypted;
    }

}