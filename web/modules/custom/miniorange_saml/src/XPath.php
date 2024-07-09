<?php


namespace Drupal\miniorange_saml;

class XPath
{
    const ALPHANUMERIC = "\x5c\x77\134\144";
    const NUMERIC = "\x5c\x64";
    const LETTERS = "\134\x77";
    const EXTENDED_ALPHANUMERIC = "\x5c\167\134\144\134\163\x5c\55\137\x3a\x5c\56";
    const SINGLE_QUOTE = "\x27";
    const DOUBLE_QUOTE = "\x22";
    const ALL_QUOTES = "\133\47\x22\x5d";
    public static function filterAttrValue($hs, $Sw = self::ALL_QUOTES)
    {
        return preg_replace("\43" . $Sw . "\x23", '', $hs);
    }
    public static function filterAttrName($tb, $Wq = self::EXTENDED_ALPHANUMERIC)
    {
        return preg_replace("\x23\x5b\x5e" . $Wq . "\135\43", '', $tb);
    }
}
