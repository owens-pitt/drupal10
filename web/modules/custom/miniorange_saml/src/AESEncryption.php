<?php


namespace Drupal\miniorange_saml;

class AESEncryption
{
    public static function encrypt_data($nZ, $C2)
    {
        $C2 = openssl_digest($C2, "\163\x68\x61\62\65\66");
        $I1 = "\101\105\x53\55\x31\x32\x38\x2d\103\x42\103";
        $ep = openssl_cipher_iv_length($I1);
        $Wk = openssl_random_pseudo_bytes($ep);
        $QV = openssl_encrypt($nZ, $I1, $C2, OPENSSL_RAW_DATA || OPENSSL_ZERO_PADDING, $Wk);
        return base64_encode($Wk . $QV);
    }
    public static function decrypt_data($nZ, $C2, $I1 = "\x41\x45\123\x2d\x31\62\x38\55\103\x42\103")
    {
        if (!($nZ != null)) {
            goto QY;
        }
        $MM = base64_decode($nZ);
        $C2 = openssl_digest($C2, "\163\150\x61\62\x35\x36");
        $ep = openssl_cipher_iv_length($I1);
        $Wk = substr($MM, 0, $ep);
        $nZ = substr($MM, $ep);
        $Cm = openssl_decrypt($nZ, $I1, $C2, OPENSSL_RAW_DATA || OPENSSL_ZERO_PADDING, $Wk);
        return $Cm;
        QY:
    }
}
