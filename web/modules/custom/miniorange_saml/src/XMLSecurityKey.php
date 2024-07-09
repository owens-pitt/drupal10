<?php


namespace Drupal\miniorange_saml;

use DOMDocument;
use DOMElement;
use DOMXPath;
use Exception;
class XMLSecurityKey
{
    const TRIPLEDES_CBC = "\150\164\164\160\x3a\x2f\x2f\x77\x77\x77\56\x77\63\x2e\157\162\147\x2f\x32\x30\60\x31\x2f\60\x34\57\170\x6d\154\145\156\x63\43\164\162\x69\x70\x6c\x65\144\x65\163\x2d\x63\142\143";
    const AES128_CBC = "\150\164\x74\160\72\x2f\x2f\167\167\x77\56\x77\x33\x2e\x6f\162\147\57\x32\60\x30\x31\x2f\60\64\x2f\x78\x6d\x6c\x65\x6e\x63\43\141\145\x73\61\62\x38\x2d\143\x62\143";
    const AES192_CBC = "\x68\164\164\x70\72\57\x2f\x77\x77\x77\x2e\x77\63\56\157\x72\x67\57\x32\x30\60\61\57\60\x34\x2f\x78\x6d\x6c\145\x6e\x63\43\x61\x65\x73\x31\x39\x32\x2d\x63\142\143";
    const AES256_CBC = "\x68\x74\164\x70\72\x2f\x2f\x77\167\x77\x2e\x77\63\56\x6f\x72\147\57\x32\x30\60\61\57\x30\x34\57\170\x6d\154\x65\156\143\x23\141\x65\163\62\x35\x36\55\x63\142\143";
    const AES128_GCM = "\150\164\x74\160\72\x2f\57\x77\x77\x77\x2e\x77\63\56\157\x72\147\57\x32\60\60\x39\57\x78\155\x6c\145\x6e\143\61\61\x23\141\x65\x73\x31\x32\70\55\147\x63\155";
    const AES192_GCM = "\x68\164\x74\160\72\57\57\167\x77\167\56\167\x33\56\157\162\147\x2f\62\60\x30\71\57\170\x6d\154\x65\x6e\143\61\61\x23\141\145\x73\61\71\x32\x2d\147\143\x6d";
    const AES256_GCM = "\x68\164\164\160\72\x2f\57\167\167\167\56\x77\63\56\x6f\x72\x67\57\x32\60\60\71\x2f\x78\x6d\154\145\x6e\x63\x31\x31\43\x61\x65\163\62\x35\x36\x2d\x67\143\x6d";
    const RSA_1_5 = "\x68\164\164\160\x3a\x2f\57\x77\x77\167\x2e\x77\x33\56\157\x72\147\x2f\x32\60\x30\x31\x2f\60\x34\57\170\x6d\154\145\x6e\x63\x23\162\x73\x61\55\x31\137\65";
    const RSA_OAEP_MGF1P = "\150\x74\164\x70\72\57\x2f\167\167\x77\56\x77\63\x2e\157\x72\x67\x2f\x32\60\x30\61\x2f\x30\64\57\x78\x6d\x6c\x65\156\x63\43\x72\x73\141\x2d\x6f\x61\145\x70\55\155\147\x66\x31\160";
    const RSA_OAEP = "\x68\x74\x74\160\72\x2f\x2f\167\x77\x77\56\x77\x33\x2e\157\162\x67\x2f\62\x30\60\71\x2f\x78\x6d\x6c\145\x6e\143\x31\61\43\162\x73\x61\x2d\x6f\x61\x65\x70";
    const DSA_SHA1 = "\x68\x74\x74\160\72\57\57\167\x77\167\x2e\x77\x33\56\157\162\147\x2f\x32\60\x30\x30\x2f\60\x39\x2f\x78\155\154\144\163\151\x67\x23\x64\163\141\x2d\x73\x68\x61\61";
    const RSA_SHA1 = "\x68\x74\164\x70\72\x2f\57\167\167\167\x2e\x77\63\x2e\x6f\x72\147\x2f\x32\60\x30\60\x2f\60\x39\x2f\x78\x6d\154\x64\x73\151\147\43\x72\163\x61\x2d\x73\150\x61\61";
    const RSA_SHA256 = "\150\164\x74\160\x3a\x2f\57\x77\x77\x77\x2e\x77\x33\56\157\x72\x67\57\x32\60\60\61\57\x30\x34\x2f\170\155\x6c\144\163\151\147\55\x6d\x6f\x72\x65\43\162\x73\x61\55\x73\x68\x61\62\65\x36";
    const RSA_SHA384 = "\150\x74\x74\x70\x3a\57\x2f\167\167\x77\56\x77\x33\56\157\x72\x67\57\62\60\x30\61\57\60\64\x2f\170\155\x6c\x64\163\151\x67\55\x6d\157\162\145\x23\x72\x73\x61\x2d\163\x68\x61\x33\70\64";
    const RSA_SHA512 = "\150\164\164\160\x3a\x2f\57\x77\167\x77\56\167\x33\56\x6f\162\x67\x2f\x32\x30\60\x31\57\x30\x34\x2f\170\155\x6c\144\x73\x69\147\55\x6d\157\x72\x65\x23\x72\163\x61\x2d\x73\150\141\65\61\x32";
    const HMAC_SHA1 = "\150\x74\x74\x70\x3a\57\57\x77\167\167\56\x77\63\x2e\157\x72\x67\x2f\x32\x30\60\x30\57\x30\x39\x2f\170\x6d\x6c\144\x73\x69\x67\x23\150\x6d\141\x63\x2d\x73\x68\x61\61";
    const AUTHTAG_LENGTH = 16;
    private $cryptParams = array();
    public $type = 0;
    public $key = null;
    public $passphrase = '';
    public $iv = null;
    public $name = null;
    public $keyChain = null;
    public $isEncrypted = false;
    public $encryptedCtx = null;
    public $guid = null;
    private $x509Certificate = null;
    private $X509Thumbprint = null;
    public function __construct($tK, $tI = null)
    {
        switch ($tK) {
            case self::TRIPLEDES_CBC:
                $this->cryptParams["\x6c\x69\x62\162\141\x72\171"] = "\x6f\160\145\156\163\163\x6c";
                $this->cryptParams["\x63\151\x70\x68\x65\x72"] = "\x64\145\163\55\x65\144\x65\63\x2d\x63\x62\143";
                $this->cryptParams["\164\171\160\x65"] = "\163\x79\x6d\155\x65\x74\162\151\143";
                $this->cryptParams["\155\145\164\150\157\144"] = "\x68\164\164\x70\x3a\57\x2f\x77\167\167\x2e\x77\63\x2e\157\162\x67\57\62\x30\60\61\57\x30\x34\x2f\x78\x6d\x6c\145\156\x63\x23\164\162\x69\160\x6c\145\x64\x65\163\x2d\x63\142\143";
                $this->cryptParams["\153\x65\x79\x73\x69\172\145"] = 24;
                $this->cryptParams["\x62\x6c\x6f\143\x6b\x73\151\x7a\145"] = 8;
                goto DU;
            case self::AES128_CBC:
                $this->cryptParams["\154\x69\142\162\141\x72\x79"] = "\157\x70\145\156\x73\163\154";
                $this->cryptParams["\143\151\160\x68\145\162"] = "\141\x65\163\x2d\x31\x32\70\55\x63\142\x63";
                $this->cryptParams["\164\x79\x70\x65"] = "\163\x79\x6d\x6d\145\x74\x72\151\143";
                $this->cryptParams["\155\145\x74\x68\x6f\x64"] = "\x68\x74\x74\160\x3a\x2f\x2f\167\x77\x77\56\167\x33\x2e\x6f\x72\147\x2f\x32\60\60\61\57\x30\64\x2f\x78\155\x6c\145\x6e\x63\43\x61\145\x73\61\62\70\x2d\x63\x62\143";
                $this->cryptParams["\153\x65\171\x73\x69\172\145"] = 16;
                $this->cryptParams["\x62\x6c\x6f\x63\x6b\163\151\172\145"] = 16;
                goto DU;
            case self::AES192_CBC:
                $this->cryptParams["\x6c\151\142\162\141\x72\x79"] = "\x6f\x70\145\156\x73\x73\x6c";
                $this->cryptParams["\143\151\x70\150\x65\x72"] = "\x61\x65\163\x2d\61\x39\62\55\x63\142\143";
                $this->cryptParams["\164\171\x70\x65"] = "\x73\171\155\155\145\x74\x72\x69\143";
                $this->cryptParams["\x6d\x65\164\150\x6f\144"] = "\x68\x74\x74\x70\72\57\57\x77\x77\167\x2e\x77\63\56\157\x72\x67\x2f\x32\60\60\61\57\60\x34\57\170\155\x6c\x65\156\143\x23\x61\145\x73\x31\x39\62\55\143\142\x63";
                $this->cryptParams["\153\145\171\x73\151\172\x65"] = 24;
                $this->cryptParams["\142\x6c\x6f\143\153\x73\151\x7a\145"] = 16;
                goto DU;
            case self::AES256_CBC:
                $this->cryptParams["\154\151\x62\162\141\x72\x79"] = "\157\x70\x65\156\163\163\154";
                $this->cryptParams["\143\151\160\150\x65\162"] = "\141\x65\163\x2d\x32\x35\66\55\143\142\x63";
                $this->cryptParams["\x74\x79\160\x65"] = "\x73\171\x6d\x6d\x65\x74\162\x69\x63";
                $this->cryptParams["\155\145\164\150\157\144"] = "\x68\x74\164\160\x3a\x2f\x2f\167\167\x77\x2e\167\x33\56\x6f\x72\147\x2f\x32\60\x30\61\57\60\x34\x2f\170\x6d\154\145\x6e\143\43\141\145\x73\62\65\x36\55\x63\x62\143";
                $this->cryptParams["\x6b\x65\171\163\x69\x7a\145"] = 32;
                $this->cryptParams["\142\x6c\157\x63\x6b\163\x69\x7a\x65"] = 16;
                goto DU;
            case self::AES128_GCM:
                $this->cryptParams["\154\x69\142\x72\x61\x72\x79"] = "\157\160\145\156\x73\163\154";
                $this->cryptParams["\143\x69\x70\150\x65\x72"] = "\x61\x65\163\55\61\x32\70\x2d\x67\143\x6d";
                $this->cryptParams["\164\171\160\x65"] = "\x73\171\x6d\x6d\x65\164\162\151\143";
                $this->cryptParams["\x6d\x65\164\x68\157\144"] = "\150\164\x74\x70\x3a\57\57\167\x77\167\56\167\x33\x2e\157\162\147\57\62\x30\60\x39\x2f\170\155\154\145\x6e\143\x31\x31\x23\x61\x65\163\x31\x32\x38\55\x67\143\x6d";
                $this->cryptParams["\x6b\145\171\163\151\172\145"] = 16;
                $this->cryptParams["\142\154\157\143\x6b\163\x69\172\145"] = 16;
                goto DU;
            case self::AES192_GCM:
                $this->cryptParams["\x6c\151\x62\162\x61\x72\171"] = "\x6f\160\145\x6e\x73\163\154";
                $this->cryptParams["\x63\x69\x70\x68\145\162"] = "\x61\x65\163\x2d\x31\x39\62\x2d\147\143\x6d";
                $this->cryptParams["\x74\171\160\x65"] = "\163\171\155\x6d\145\164\162\151\x63";
                $this->cryptParams["\x6d\145\164\x68\157\x64"] = "\150\164\x74\160\x3a\57\x2f\167\x77\x77\56\167\x33\56\x6f\162\x67\x2f\x32\x30\60\x39\57\x78\155\x6c\x65\x6e\x63\x31\x31\x23\141\145\x73\61\x39\62\55\x67\x63\155";
                $this->cryptParams["\153\x65\171\x73\151\172\x65"] = 24;
                $this->cryptParams["\142\154\157\x63\153\163\x69\172\145"] = 16;
                goto DU;
            case self::AES256_GCM:
                $this->cryptParams["\154\x69\x62\162\141\x72\171"] = "\157\160\145\x6e\x73\x73\154";
                $this->cryptParams["\143\151\160\x68\145\162"] = "\x61\145\x73\55\62\x35\x36\55\147\x63\x6d";
                $this->cryptParams["\x74\x79\x70\145"] = "\163\x79\x6d\x6d\x65\164\x72\x69\x63";
                $this->cryptParams["\x6d\145\164\x68\x6f\x64"] = "\x68\164\164\x70\x3a\57\57\x77\x77\167\x2e\167\x33\56\x6f\162\147\x2f\62\x30\60\x39\x2f\x78\x6d\x6c\145\x6e\143\61\61\43\141\145\x73\x32\65\66\55\147\143\x6d";
                $this->cryptParams["\x6b\x65\171\x73\151\172\145"] = 32;
                $this->cryptParams["\x62\154\157\x63\153\163\151\x7a\x65"] = 16;
                goto DU;
            case self::RSA_1_5:
                $this->cryptParams["\154\x69\x62\162\141\x72\x79"] = "\x6f\160\145\156\163\x73\x6c";
                $this->cryptParams["\x70\141\x64\144\151\x6e\147"] = OPENSSL_PKCS1_PADDING;
                $this->cryptParams["\x6d\x65\x74\150\x6f\x64"] = "\x68\164\x74\x70\72\x2f\57\x77\167\x77\56\167\63\x2e\x6f\162\x67\x2f\62\x30\x30\x31\x2f\60\x34\x2f\170\x6d\154\x65\x6e\x63\x23\162\x73\141\x2d\x31\137\65";
                if (!(is_array($tI) && !empty($tI["\x74\x79\x70\x65"]))) {
                    goto xy;
                }
                if (!($tI["\164\x79\160\145"] == "\x70\165\142\154\x69\143" || $tI["\x74\171\160\x65"] == "\x70\162\x69\166\141\x74\145")) {
                    goto pf;
                }
                $this->cryptParams["\164\171\160\145"] = $tI["\164\171\x70\x65"];
                goto DU;
                pf:
                xy:
                throw new Exception("\103\145\x72\164\151\146\151\143\x61\164\x65\x20\x22\x74\171\160\145\x22\x20\x28\x70\162\x69\166\x61\164\145\x2f\160\165\x62\x6c\151\143\x29\40\155\165\x73\164\40\x62\145\x20\x70\x61\163\163\x65\x64\x20\x76\x69\x61\x20\160\x61\x72\141\x6d\x65\164\145\x72\x73");
            case self::RSA_OAEP_MGF1P:
                $this->cryptParams["\154\151\142\x72\x61\162\x79"] = "\x6f\x70\x65\156\x73\163\154";
                $this->cryptParams["\x70\141\144\x64\x69\x6e\147"] = OPENSSL_PKCS1_OAEP_PADDING;
                $this->cryptParams["\x6d\145\164\150\x6f\144"] = "\x68\164\164\160\x3a\x2f\57\x77\x77\x77\x2e\167\x33\x2e\x6f\x72\x67\x2f\x32\60\x30\61\57\60\x34\x2f\170\155\154\145\x6e\x63\43\162\163\x61\x2d\157\x61\x65\160\55\x6d\x67\x66\x31\160";
                $this->cryptParams["\150\141\163\150"] = null;
                if (!(is_array($tI) && !empty($tI["\x74\x79\x70\145"]))) {
                    goto Ej;
                }
                if (!($tI["\164\x79\x70\x65"] == "\160\165\142\154\151\x63" || $tI["\x74\171\160\x65"] == "\x70\x72\x69\166\141\x74\x65")) {
                    goto Sr;
                }
                $this->cryptParams["\164\171\x70\145"] = $tI["\164\x79\x70\x65"];
                goto DU;
                Sr:
                Ej:
                throw new Exception("\x43\x65\x72\x74\151\146\151\x63\141\164\145\40\x22\x74\x79\x70\x65\x22\x20\x28\x70\x72\151\x76\141\164\145\57\x70\x75\x62\x6c\151\x63\51\40\155\x75\163\x74\40\x62\x65\x20\160\x61\x73\163\x65\x64\40\166\151\x61\40\x70\141\162\141\x6d\x65\164\x65\162\163");
            case self::RSA_OAEP:
                $this->cryptParams["\154\151\142\162\141\x72\171"] = "\157\x70\x65\156\163\163\154";
                $this->cryptParams["\x70\141\144\144\x69\x6e\147"] = OPENSSL_PKCS1_OAEP_PADDING;
                $this->cryptParams["\x6d\x65\x74\150\x6f\144"] = "\150\164\x74\160\x3a\x2f\x2f\167\167\167\x2e\x77\x33\x2e\x6f\x72\147\x2f\x32\x30\60\71\x2f\170\x6d\x6c\145\156\143\61\61\x23\x72\x73\141\55\157\x61\x65\160";
                $this->cryptParams["\150\x61\x73\150"] = "\150\x74\x74\160\72\57\x2f\167\x77\x77\56\x77\x33\56\x6f\x72\147\57\x32\60\x30\71\x2f\x78\155\154\145\x6e\x63\61\x31\43\155\x67\146\61\x73\150\141\61";
                if (!(is_array($tI) && !empty($tI["\164\171\160\x65"]))) {
                    goto gO;
                }
                if (!($tI["\x74\171\160\145"] == "\160\165\142\x6c\x69\x63" || $tI["\x74\171\x70\x65"] == "\x70\x72\151\x76\x61\x74\145")) {
                    goto Es;
                }
                $this->cryptParams["\x74\171\x70\145"] = $tI["\164\171\x70\145"];
                goto DU;
                Es:
                gO:
                throw new Exception("\103\x65\x72\164\x69\x66\151\143\x61\x74\x65\40\42\164\x79\x70\145\42\40\x28\x70\x72\x69\x76\141\164\145\57\160\165\142\154\151\143\x29\40\x6d\x75\163\164\40\x62\x65\x20\x70\141\163\x73\x65\x64\x20\x76\151\141\40\160\x61\162\x61\x6d\145\164\145\162\163");
            case self::RSA_SHA1:
                $this->cryptParams["\x6c\151\x62\x72\141\x72\x79"] = "\157\160\145\156\x73\x73\154";
                $this->cryptParams["\155\145\x74\150\x6f\144"] = "\x68\x74\x74\160\72\x2f\57\x77\167\x77\56\x77\63\x2e\x6f\162\x67\57\x32\60\60\60\57\60\71\57\x78\x6d\154\144\163\151\147\43\x72\x73\x61\55\x73\150\141\x31";
                $this->cryptParams["\x70\x61\x64\x64\x69\x6e\147"] = OPENSSL_PKCS1_PADDING;
                if (!(is_array($tI) && !empty($tI["\164\171\160\x65"]))) {
                    goto Fv;
                }
                if (!($tI["\164\171\x70\145"] == "\x70\x75\142\x6c\x69\x63" || $tI["\164\171\x70\145"] == "\160\x72\151\166\x61\164\x65")) {
                    goto se;
                }
                $this->cryptParams["\164\x79\x70\145"] = $tI["\x74\171\x70\145"];
                goto DU;
                se:
                Fv:
                throw new Exception("\x43\145\162\x74\151\146\x69\x63\x61\x74\x65\40\x22\164\171\x70\145\42\40\50\x70\x72\151\166\x61\x74\x65\57\160\x75\x62\x6c\151\143\x29\x20\155\165\163\164\40\x62\145\x20\x70\x61\163\163\x65\x64\x20\x76\151\141\40\160\141\162\x61\x6d\145\164\x65\162\x73");
            case self::RSA_SHA256:
                $this->cryptParams["\x6c\151\x62\162\141\x72\x79"] = "\157\160\x65\x6e\x73\x73\154";
                $this->cryptParams["\155\145\x74\x68\157\144"] = "\150\164\164\160\72\57\57\x77\x77\167\x2e\x77\63\56\x6f\162\x67\57\62\x30\60\x31\57\x30\x34\57\x78\x6d\154\144\163\151\x67\55\155\157\162\x65\x23\162\x73\x61\55\163\150\x61\62\65\66";
                $this->cryptParams["\160\141\x64\x64\x69\156\147"] = OPENSSL_PKCS1_PADDING;
                $this->cryptParams["\144\151\x67\145\163\164"] = "\123\x48\101\62\x35\x36";
                if (!(is_array($tI) && !empty($tI["\164\x79\160\145"]))) {
                    goto df;
                }
                if (!($tI["\164\x79\x70\x65"] == "\160\165\142\x6c\151\x63" || $tI["\164\171\x70\x65"] == "\x70\x72\151\x76\x61\164\145")) {
                    goto XL;
                }
                $this->cryptParams["\164\171\160\x65"] = $tI["\164\171\160\x65"];
                goto DU;
                XL:
                df:
                throw new Exception("\103\x65\x72\x74\x69\x66\151\143\141\164\145\40\42\x74\171\x70\145\42\x20\x28\160\x72\151\x76\141\x74\145\x2f\x70\165\142\154\x69\x63\51\40\x6d\165\x73\x74\40\x62\x65\40\160\x61\163\x73\145\x64\x20\166\x69\x61\x20\x70\141\162\x61\x6d\x65\x74\145\162\163");
            case self::RSA_SHA384:
                $this->cryptParams["\154\151\x62\x72\141\162\171"] = "\x6f\x70\x65\156\x73\163\154";
                $this->cryptParams["\155\145\164\150\157\x64"] = "\x68\164\x74\x70\x3a\x2f\57\167\x77\x77\x2e\167\x33\x2e\x6f\x72\147\x2f\x32\60\60\x31\x2f\60\64\57\x78\x6d\x6c\144\163\x69\x67\x2d\x6d\x6f\162\x65\43\162\x73\141\x2d\163\x68\141\63\x38\x34";
                $this->cryptParams["\x70\141\144\x64\151\156\x67"] = OPENSSL_PKCS1_PADDING;
                $this->cryptParams["\x64\x69\x67\x65\163\164"] = "\123\110\x41\63\70\x34";
                if (!(is_array($tI) && !empty($tI["\164\x79\x70\145"]))) {
                    goto Yz;
                }
                if (!($tI["\x74\x79\x70\x65"] == "\x70\165\x62\154\151\143" || $tI["\164\x79\x70\145"] == "\x70\162\151\x76\x61\164\145")) {
                    goto iA;
                }
                $this->cryptParams["\164\171\x70\145"] = $tI["\164\x79\160\145"];
                goto DU;
                iA:
                Yz:
                throw new Exception("\103\x65\x72\164\x69\x66\151\x63\141\164\145\x20\42\x74\x79\x70\145\x22\40\50\x70\162\x69\166\141\x74\x65\57\160\x75\x62\154\151\143\x29\40\x6d\165\163\164\40\142\x65\40\x70\x61\x73\163\145\144\40\166\151\141\40\160\141\162\x61\x6d\145\164\x65\x72\163");
            case self::RSA_SHA512:
                $this->cryptParams["\154\151\142\162\141\x72\x79"] = "\x6f\x70\x65\156\x73\163\154";
                $this->cryptParams["\x6d\145\164\150\157\144"] = "\x68\164\164\x70\x3a\57\57\167\167\167\x2e\167\x33\x2e\x6f\x72\147\57\62\x30\x30\x31\x2f\x30\x34\57\170\x6d\154\144\x73\151\147\x2d\155\157\162\145\43\x72\x73\x61\x2d\x73\150\x61\x35\61\x32";
                $this->cryptParams["\160\x61\x64\x64\151\156\147"] = OPENSSL_PKCS1_PADDING;
                $this->cryptParams["\144\x69\x67\x65\163\164"] = "\x53\110\x41\65\61\x32";
                if (!(is_array($tI) && !empty($tI["\x74\171\160\x65"]))) {
                    goto Ig;
                }
                if (!($tI["\x74\x79\160\145"] == "\x70\165\x62\154\151\143" || $tI["\x74\x79\160\x65"] == "\160\x72\x69\166\x61\x74\x65")) {
                    goto Vp;
                }
                $this->cryptParams["\164\171\160\x65"] = $tI["\164\x79\x70\145"];
                goto DU;
                Vp:
                Ig:
                throw new Exception("\103\145\x72\x74\151\x66\x69\x63\141\x74\145\x20\x22\164\171\x70\x65\x22\40\50\160\162\x69\x76\x61\x74\145\x2f\160\x75\x62\x6c\x69\143\51\40\x6d\x75\163\x74\x20\x62\145\40\x70\x61\163\x73\145\x64\40\166\x69\141\40\x70\x61\x72\x61\155\145\164\145\x72\163");
            case self::HMAC_SHA1:
                $this->cryptParams["\154\x69\142\x72\141\162\171"] = $tK;
                $this->cryptParams["\155\x65\164\150\x6f\x64"] = "\x68\x74\x74\160\72\57\57\167\x77\167\x2e\167\63\56\157\x72\147\57\x32\60\x30\x30\57\x30\x39\x2f\170\x6d\154\144\x73\x69\x67\x23\150\x6d\141\x63\x2d\163\x68\x61\61";
                goto DU;
            default:
                throw new Exception("\111\x6e\166\x61\154\x69\x64\x20\x4b\145\171\x20\124\171\x70\145");
        }
        tI:
        DU:
        $this->type = $tK;
    }
    public function getSymmetricKeySize()
    {
        if (isset($this->cryptParams["\x6b\145\171\163\x69\x7a\145"])) {
            goto Fz;
        }
        return null;
        Fz:
        return $this->cryptParams["\153\x65\x79\163\151\172\x65"];
    }
    public function generateSessionKey()
    {
        if (isset($this->cryptParams["\x6b\x65\171\x73\x69\172\145"])) {
            goto uY;
        }
        throw new Exception("\x55\156\x6b\156\157\x77\156\40\x6b\x65\171\40\163\x69\172\145\x20\x66\157\x72\40\x74\171\160\145\40\42" . $this->type . "\x22\56");
        uY:
        $rp = $this->cryptParams["\153\x65\x79\x73\151\x7a\x65"];
        $C2 = openssl_random_pseudo_bytes($rp);
        if (!($this->type === self::TRIPLEDES_CBC)) {
            goto Xm;
        }
        $Yu = 0;
        Ff:
        if (!($Yu < strlen($C2))) {
            goto HX;
        }
        $Mk = ord($C2[$Yu]) & 0xfe;
        $O5 = 1;
        $DG = 1;
        Q3:
        if (!($DG < 8)) {
            goto V5;
        }
        $O5 ^= $Mk >> $DG & 1;
        bw:
        $DG++;
        goto Q3;
        V5:
        $Mk |= $O5;
        $C2[$Yu] = chr($Mk);
        yX:
        $Yu++;
        goto Ff;
        HX:
        Xm:
        $this->key = $C2;
        return $C2;
    }
    public static function getRawThumbprint($J_)
    {
        $WI = explode("\xa", $J_);
        $nZ = '';
        $h7 = false;
        foreach ($WI as $Lv) {
            if (!$h7) {
                goto NN;
            }
            if (!(strncmp($Lv, "\x2d\x2d\55\55\55\x45\x4e\104\40\103\x45\122\124\111\106\111\103\x41\x54\x45", 20) == 0)) {
                goto vt;
            }
            goto Em;
            vt:
            $nZ .= trim($Lv);
            goto Gx;
            NN:
            if (!(strncmp($Lv, "\55\55\x2d\x2d\x2d\x42\x45\x47\111\116\x20\103\x45\x52\124\111\106\111\103\x41\x54\105", 22) == 0)) {
                goto pR;
            }
            $h7 = true;
            pR:
            Gx:
            HD:
        }
        Em:
        if (empty($nZ)) {
            goto UX;
        }
        return strtolower(sha1(base64_decode($nZ)));
        UX:
        return null;
    }
    public function loadKey($C2, $Dr = false, $an = false)
    {
        if ($Dr) {
            goto OK;
        }
        $this->key = $C2;
        goto uN;
        OK:
        $this->key = file_get_contents($C2);
        uN:
        if ($an) {
            goto tL;
        }
        $this->x509Certificate = null;
        goto RZ;
        tL:
        $this->key = openssl_x509_read($this->key);
        openssl_x509_export($this->key, $Hy);
        $this->x509Certificate = $Hy;
        $this->key = $Hy;
        RZ:
        if (!($this->cryptParams["\x6c\x69\142\x72\x61\162\x79"] == "\x6f\x70\x65\x6e\x73\163\x6c")) {
            goto tv;
        }
        switch ($this->cryptParams["\164\x79\x70\x65"]) {
            case "\x70\165\142\154\x69\x63":
                if (!$an) {
                    goto JH;
                }
                $this->X509Thumbprint = self::getRawThumbprint($this->key);
                JH:
                $this->key = openssl_get_publickey($this->key);
                if ($this->key) {
                    goto Zx;
                }
                throw new Exception("\x55\156\x61\x62\154\x65\40\164\157\40\x65\170\x74\162\141\143\x74\40\x70\x75\142\154\x69\143\40\x6b\x65\x79");
                Zx:
                goto J9;
            case "\x70\162\x69\166\x61\x74\x65":
                $this->key = openssl_get_privatekey($this->key, $this->passphrase);
                goto J9;
            case "\163\x79\155\x6d\x65\164\162\151\143":
                if (!(strlen($this->key) < $this->cryptParams["\x6b\x65\171\x73\x69\172\x65"])) {
                    goto S8;
                }
                throw new Exception("\113\x65\x79\40\x6d\x75\163\164\40\x63\157\156\164\141\x69\x6e\40\141\x74\x20\154\145\141\x73\164\40" . $this->cryptParams["\x6b\x65\x79\x73\151\172\145"] . "\x20\x63\x68\x61\x72\141\143\x74\x65\162\x73\40\146\157\162\40\164\150\151\x73\40\x63\151\160\x68\145\162\x2c\x20\x63\157\x6e\x74\141\x69\156\x73\40" . strlen($this->key));
                S8:
                goto J9;
            default:
                throw new Exception("\x55\x6e\x6b\156\157\x77\156\x20\x74\x79\160\145");
        }
        fT:
        J9:
        tv:
    }
    private function padISO10126($nZ, $SN)
    {
        if (!($SN > 256)) {
            goto rv;
        }
        throw new Exception("\102\x6c\x6f\143\153\40\x73\x69\x7a\x65\x20\x68\151\147\x68\x65\x72\x20\x74\150\x61\x6e\40\62\65\x36\40\x6e\157\164\40\x61\154\154\x6f\167\x65\x64");
        rv:
        $Tt = $SN - strlen($nZ) % $SN;
        $Yx = chr($Tt);
        return $nZ . str_repeat($Yx, $Tt);
    }
    private function unpadISO10126($nZ)
    {
        $Tt = substr($nZ, -1);
        $fY = ord($Tt);
        return substr($nZ, 0, -$fY);
    }
    private function encryptSymmetric($nZ)
    {
        $this->iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->cryptParams["\143\151\160\x68\x65\x72"]));
        $mP = null;
        if (in_array($this->cryptParams["\143\x69\160\x68\145\x72"], ["\141\x65\x73\x2d\61\62\70\55\147\143\x6d", "\141\145\163\x2d\61\71\x32\x2d\x67\x63\155", "\141\x65\x73\x2d\62\x35\x36\x2d\x67\143\x6d"])) {
            goto vm;
        }
        $nZ = $this->padISO10126($nZ, $this->cryptParams["\x62\x6c\157\143\x6b\x73\151\172\x65"]);
        $n1 = openssl_encrypt($nZ, $this->cryptParams["\x63\x69\160\x68\145\x72"], $this->key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $this->iv);
        goto Kj;
        vm:
        if (!(version_compare(PHP_VERSION, "\x37\x2e\61\x2e\x30") < 0)) {
            goto Hd;
        }
        throw new Exception("\120\110\120\40\x37\56\x31\56\60\x20\151\163\40\162\145\161\165\x69\x72\x65\x64\40\164\157\40\165\163\x65\40\x41\105\123\x20\x47\x43\115\x20\x61\x6c\x67\157\162\151\x74\150\x6d\163");
        Hd:
        $mP = openssl_random_pseudo_bytes(self::AUTHTAG_LENGTH);
        $n1 = openssl_encrypt($nZ, $this->cryptParams["\143\x69\160\x68\x65\162"], $this->key, OPENSSL_RAW_DATA, $this->iv, $mP);
        Kj:
        if (!(false === $n1)) {
            goto Rx;
        }
        throw new Exception("\x46\141\x69\154\165\x72\145\40\145\x6e\143\162\171\160\164\151\156\x67\x20\104\x61\164\x61\x20\50\157\x70\x65\x6e\163\x73\x6c\40\163\x79\155\x6d\145\164\x72\x69\143\x29\x20\55\40" . openssl_error_string());
        Rx:
        return $this->iv . $n1 . $mP;
    }
    private function decryptSymmetric($nZ)
    {
        $gq = openssl_cipher_iv_length($this->cryptParams["\x63\151\160\150\x65\x72"]);
        $this->iv = substr($nZ, 0, $gq);
        $nZ = substr($nZ, $gq);
        $mP = null;
        if (in_array($this->cryptParams["\143\151\x70\x68\145\x72"], ["\x61\145\163\x2d\61\x32\70\55\x67\143\x6d", "\x61\145\x73\x2d\61\x39\x32\x2d\x67\x63\x6d", "\x61\145\163\x2d\x32\65\x36\55\x67\143\x6d"])) {
            goto eH;
        }
        $Ma = openssl_decrypt($nZ, $this->cryptParams["\x63\151\x70\150\145\162"], $this->key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $this->iv);
        goto sJ;
        eH:
        if (!(version_compare(PHP_VERSION, "\67\56\x31\x2e\60") < 0)) {
            goto am;
        }
        throw new Exception("\x50\x48\x50\x20\x37\x2e\x31\56\60\40\x69\x73\x20\162\x65\x71\x75\151\x72\145\144\40\164\x6f\40\165\x73\145\40\x41\105\123\x20\107\103\115\40\141\x6c\x67\x6f\x72\151\164\x68\155\163");
        am:
        $Qb = 0 - self::AUTHTAG_LENGTH;
        $mP = substr($nZ, $Qb);
        $nZ = substr($nZ, 0, $Qb);
        $Ma = openssl_decrypt($nZ, $this->cryptParams["\x63\151\x70\x68\x65\162"], $this->key, OPENSSL_RAW_DATA, $this->iv, $mP);
        sJ:
        if (!(false === $Ma)) {
            goto ks;
        }
        throw new Exception("\106\141\151\x6c\165\162\145\x20\144\145\143\x72\x79\160\164\x69\x6e\x67\40\x44\141\x74\141\40\x28\157\x70\145\x6e\x73\163\154\40\163\171\155\155\145\x74\x72\151\x63\51\40\55\40" . openssl_error_string());
        ks:
        return null !== $mP ? $Ma : $this->unpadISO10126($Ma);
    }
    private function encryptPublic($nZ)
    {
        if (openssl_public_encrypt($nZ, $n1, $this->key, $this->cryptParams["\160\141\x64\144\x69\x6e\x67"])) {
            goto L5;
        }
        throw new Exception("\x46\141\151\x6c\x75\162\145\40\145\x6e\x63\162\171\x70\164\151\156\147\40\104\141\x74\x61\x20\50\x6f\x70\145\x6e\x73\163\x6c\x20\160\x75\142\154\151\143\x29\x20\55\40" . openssl_error_string());
        L5:
        return $n1;
    }
    private function decryptPublic($nZ)
    {
        if (openssl_public_decrypt($nZ, $Ma, $this->key, $this->cryptParams["\x70\x61\x64\144\x69\x6e\x67"])) {
            goto ry;
        }
        throw new Exception("\x46\141\x69\x6c\x75\x72\145\40\x64\145\x63\x72\x79\x70\x74\x69\x6e\147\40\x44\141\164\x61\x20\x28\157\160\145\x6e\x73\163\154\40\x70\165\x62\154\151\x63\x29\40\55\40" . openssl_error_string());
        ry:
        return $Ma;
    }
    private function encryptPrivate($nZ)
    {
        if (openssl_private_encrypt($nZ, $n1, $this->key, $this->cryptParams["\x70\141\x64\x64\x69\156\x67"])) {
            goto EH;
        }
        throw new Exception("\106\x61\151\154\165\162\x65\x20\145\x6e\143\162\x79\160\164\151\156\147\40\104\x61\x74\x61\x20\x28\x6f\160\145\x6e\x73\x73\154\40\x70\162\x69\166\x61\164\145\51\x20\x2d\x20" . openssl_error_string());
        EH:
        return $n1;
    }
    private function decryptPrivate($nZ)
    {
        if (openssl_private_decrypt($nZ, $Ma, $this->key, $this->cryptParams["\160\141\144\x64\151\156\x67"])) {
            goto va;
        }
        throw new Exception("\106\x61\x69\x6c\165\x72\x65\40\144\x65\143\x72\x79\x70\x74\151\156\147\40\x44\x61\164\x61\40\x28\x6f\160\x65\156\x73\163\154\x20\x70\162\x69\166\141\164\x65\51\x20\x2d\x20" . openssl_error_string());
        va:
        return $Ma;
    }
    private function signOpenSSL($nZ)
    {
        $F6 = OPENSSL_ALGO_SHA1;
        if (empty($this->cryptParams["\144\x69\147\x65\163\164"])) {
            goto fW;
        }
        $F6 = $this->cryptParams["\x64\x69\x67\145\163\164"];
        fW:
        if (openssl_sign($nZ, $Tv, $this->key, $F6)) {
            goto u0;
        }
        throw new Exception("\106\x61\x69\154\165\162\x65\40\x53\151\147\156\x69\156\x67\40\x44\141\x74\141\x3a\x20" . openssl_error_string() . "\x20\x2d\40" . $F6);
        u0:
        return $Tv;
    }
    private function verifyOpenSSL($nZ, $Tv)
    {
        $F6 = OPENSSL_ALGO_SHA1;
        if (empty($this->cryptParams["\144\x69\x67\x65\163\x74"])) {
            goto q8;
        }
        $F6 = $this->cryptParams["\x64\x69\147\x65\x73\164"];
        q8:
        return openssl_verify($nZ, $Tv, $this->key, $F6);
    }
    public function encryptData($nZ)
    {
        if (!($this->cryptParams["\x6c\151\x62\162\x61\162\171"] === "\x6f\x70\x65\156\x73\163\x6c")) {
            goto Zc;
        }
        switch ($this->cryptParams["\164\171\160\145"]) {
            case "\163\x79\155\x6d\145\164\162\x69\x63":
                return $this->encryptSymmetric($nZ);
            case "\160\165\142\154\151\143":
                return $this->encryptPublic($nZ);
            case "\x70\162\x69\166\x61\x74\145":
                return $this->encryptPrivate($nZ);
        }
        J_:
        qH:
        Zc:
    }
    public function decryptData($nZ)
    {
        if (!($this->cryptParams["\x6c\151\x62\x72\141\162\171"] === "\157\160\145\x6e\x73\163\154")) {
            goto fv;
        }
        switch ($this->cryptParams["\164\171\x70\145"]) {
            case "\163\171\155\155\145\x74\x72\x69\143":
                return $this->decryptSymmetric($nZ);
            case "\x70\x75\142\154\151\x63":
                return $this->decryptPublic($nZ);
            case "\x70\x72\x69\x76\141\164\145":
                return $this->decryptPrivate($nZ);
        }
        nU:
        wF:
        fv:
    }
    public function signData($nZ)
    {
        switch ($this->cryptParams["\x6c\151\x62\x72\x61\x72\171"]) {
            case "\157\160\x65\156\163\163\154":
                return $this->signOpenSSL($nZ);
            case self::HMAC_SHA1:
                return hash_hmac("\163\x68\x61\61", $nZ, $this->key, true);
        }
        E6:
        zR:
    }
    public function verifySignature($nZ, $Tv)
    {
        switch ($this->cryptParams["\x6c\151\x62\x72\141\x72\171"]) {
            case "\x6f\160\x65\156\x73\x73\154":
                return $this->verifyOpenSSL($nZ, $Tv);
            case self::HMAC_SHA1:
                $sE = hash_hmac("\x73\150\x61\x31", $nZ, $this->key, true);
                return strcmp($Tv, $sE) == 0;
        }
        K2:
        WJ:
    }
    public function getAlgorith()
    {
        return $this->getAlgorithm();
    }
    public function getAlgorithm()
    {
        return $this->cryptParams["\x6d\145\x74\150\157\144"];
    }
    public static function makeAsnSegment($tK, $hp)
    {
        switch ($tK) {
            case 0x2:
                if (!(ord($hp) > 0x7f)) {
                    goto MY;
                }
                $hp = chr(0) . $hp;
                MY:
                goto jq;
            case 0x3:
                $hp = chr(0) . $hp;
                goto jq;
        }
        RO:
        jq:
        $JM = strlen($hp);
        if ($JM < 128) {
            goto Oi;
        }
        if ($JM < 0x100) {
            goto dX;
        }
        if ($JM < 0x10000) {
            goto ID;
        }
        $Mb = null;
        goto us;
        ID:
        $Mb = sprintf("\x25\x63\x25\x63\45\143\x25\x63\x25\x73", $tK, 0x82, $JM / 0x100, $JM % 0x100, $hp);
        us:
        goto W1;
        dX:
        $Mb = sprintf("\45\143\45\x63\45\x63\x25\x73", $tK, 0x81, $JM, $hp);
        W1:
        goto HH;
        Oi:
        $Mb = sprintf("\45\143\x25\143\x25\x73", $tK, $JM, $hp);
        HH:
        return $Mb;
    }
    public static function convertRSA($vv, $q6)
    {
        $ij = self::makeAsnSegment(0x2, $q6);
        $WR = self::makeAsnSegment(0x2, $vv);
        $tN = self::makeAsnSegment(0x30, $WR . $ij);
        $gn = self::makeAsnSegment(0x3, $tN);
        $tw = pack("\110\x2a", "\63\x30\60\104\x30\x36\60\x39\x32\x41\70\66\64\70\70\66\106\x37\60\x44\x30\61\x30\61\x30\61\60\65\60\60");
        $jg = self::makeAsnSegment(0x30, $tw . $gn);
        $cJ = base64_encode($jg);
        $XX = "\55\55\55\x2d\x2d\x42\105\107\111\x4e\40\120\125\102\x4c\x49\x43\x20\x4b\x45\x59\x2d\55\x2d\x2d\55\12";
        $Qb = 0;
        ef:
        if (!($Zr = substr($cJ, $Qb, 64))) {
            goto k5;
        }
        $XX = $XX . $Zr . "\12";
        $Qb += 64;
        goto ef;
        k5:
        return $XX . "\55\55\x2d\55\55\x45\116\104\40\120\x55\x42\114\111\x43\x20\113\x45\x59\x2d\55\x2d\x2d\55\xa";
    }
    public function serializeKey($qt)
    {
    }
    public function getX509Certificate()
    {
        return $this->x509Certificate;
    }
    public function getX509Thumbprint()
    {
        return $this->X509Thumbprint;
    }
    public static function fromEncryptedKeyElement(DOMElement $Dh)
    {
        $F9 = new XMLSecEnc();
        $F9->setNode($Dh);
        if ($ue = $F9->locateKey()) {
            goto ze;
        }
        throw new Exception("\125\156\x61\x62\x6c\x65\40\164\x6f\40\154\x6f\143\141\164\x65\40\141\x6c\147\157\162\x69\x74\x68\x6d\x20\146\x6f\x72\x20\164\x68\151\163\40\105\156\x63\162\x79\160\x74\x65\144\40\113\145\x79");
        ze:
        $ue->isEncrypted = true;
        $ue->encryptedCtx = $F9;
        XMLSecEnc::staticLocateKeyInfo($ue, $Dh);
        return $ue;
    }
}
