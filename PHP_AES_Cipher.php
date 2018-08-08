<?php

$ENCRYPT_KEY = "borated-z6xb3a";

/**
 * Generate a random fixed length string
 *
 * @param type $length - length of generated string
 * @return random string
 */

function getRandomString($length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $string = '';

    for ($i = 0; $i < $length; $i++) {
        $string .= $characters[mt_rand(0, strlen($characters) - 1)];
    }

    return $string;
}


class PHP_AES_Cipher {

    private static $OPENSSL_CIPHER_NAME = "aes-128-cbc"; //Name of OpenSSL Cipher
    private static $CIPHER_KEY_LEN = 16; //128 bits

    /**
     * Encrypt data using AES Cipher (CBC) with 128 bit key
     *
     * @param type $key - key to use should be 16 bytes long (128 bits)
     * @param type $iv - initialization vector
     * @param type $data - data to encrypt
     * @return encrypted data in base64 encoding with iv attached at end after a :
     */

    static function encrypt($key, $iv, $data) {
        if (strlen($key) < PHP_AES_Cipher::$CIPHER_KEY_LEN) {
            $key = str_pad("$key", PHP_AES_Cipher::$CIPHER_KEY_LEN, "0"); //0 pad to len 16
        } else if (strlen($key) > PHP_AES_Cipher::$CIPHER_KEY_LEN) {
            $key = substr($str, 0, PHP_AES_Cipher::$CIPHER_KEY_LEN); //truncate to 16 bytes
        }

        $encodedEncryptedData = base64_encode(openssl_encrypt($data, PHP_AES_Cipher::$OPENSSL_CIPHER_NAME, $key, OPENSSL_RAW_DATA, $iv));
        $encodedIV = base64_encode($iv);
        $encryptedPayload = $encodedEncryptedData.":".$encodedIV;

        return $encryptedPayload;
    }
}


$mcrypt = new PHP_AES_Cipher();

$data = json_encode([ 'HTTP_X_MSISDN' => $_SERVER['HTTP_X_MSISDN'], 'HTTP_IMSI' => $_SERVER['HTTP_IMSI'] ]);

$iv = getRandomString(16);

$encrypted = $mcrypt->encrypt($ENCRYPT_KEY, $iv, $data);

echo $encrypted;

?>

