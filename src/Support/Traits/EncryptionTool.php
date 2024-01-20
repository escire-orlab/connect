<?php

namespace EscireOrlab\Connect\Support\Traits;

use RuntimeException;
use OpenSSL;

trait EncryptionTool
{

    public static function encrypt($data, $key)
    {
        $method = 'AES-256-CBC';
        $ivLength = openssl_cipher_iv_length($method);
        $iv = openssl_random_pseudo_bytes($ivLength);

        $encrypted = openssl_encrypt($data, $method, $key, 0, $iv);
        if ($encrypted === false) {
            throw new RuntimeException('Unable to encrypt the data.');
        }

        // Combina IV y datos encriptados
        return base64_encode($iv . $encrypted);
    }

    public static function decrypt($data, $key)
    {
        $method = 'AES-256-CBC';
        $ivLength = openssl_cipher_iv_length($method);

        $data = base64_decode($data);
        $iv = substr($data, 0, $ivLength);
        $data = substr($data, $ivLength);

        $decrypted = openssl_decrypt($data, $method, $key, 0, $iv);
        if ($decrypted === false) {
            throw new RuntimeException('Unable to decrypt the data.');
        }

        return $decrypted;
    }

}