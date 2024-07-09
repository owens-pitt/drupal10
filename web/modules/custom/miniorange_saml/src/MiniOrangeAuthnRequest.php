<?php


namespace Drupal\miniorange_saml;

use DOMElement;
use Symfony\Component\HttpFoundation\RedirectResponse;
class MiniOrangeAuthnRequest
{
    public function initiateLogin($Ww, $DR, $fl, $xL, $Kh, $uA, $hR, $xa)
    {
        $AA = Utilities::createAuthnRequest($Ww, $fl, $Kh, $DR, $uA, "\x66\x61\x6c\x73\145");
        $this->sendSamlRequestByBindingType($AA, $uA, $xL, $DR, $hR, $xa);
    }
    function sendSamlRequestByBindingType($ua, $uA, $Fx, $Qi, $hR, $xa)
    {
        if (empty($uA) || $uA == "\x48\x54\124\x50\x2d\122\145\144\151\x72\145\143\x74") {
            goto Kn;
        }
        if ($hR) {
            goto om;
        }
        $Cn = base64_encode($ua);
        Utilities::postSAMLRequest($Qi, $Cn, $Fx);
        exit;
        om:
        $Cn = Utilities::signXML($ua, Utilities::getPublicCertificate(), Utilities::getPrivateKey(), $xa, "\x4e\x61\155\x65\111\x44\x50\157\x6c\151\x63\171");
        Utilities::postSAMLRequest($Qi, $Cn, $Fx);
        goto rN;
        Kn:
        $oa = $Qi;
        if (strpos($Qi, "\x3f") !== false) {
            goto p6;
        }
        $oa .= "\77";
        goto GU;
        p6:
        $oa .= "\x26";
        GU:
        $ua = "\123\101\115\x4c\x52\x65\x71\x75\x65\x73\164\x3d" . $ua . "\x26\122\145\x6c\141\x79\123\164\x61\164\145\75" . urlencode($Fx);
        if (!$hR) {
            goto Tn;
        }
        $V4 = array("\x74\x79\160\x65" => "\x70\162\x69\x76\141\x74\x65");
        if ($xa == "\x52\123\x41\x5f\123\110\x41\62\65\x36") {
            goto d9;
        }
        if ($xa == "\122\123\101\x5f\x53\110\x41\x33\x38\x34") {
            goto N6;
        }
        if ($xa == "\122\123\101\x5f\x53\110\101\65\x31\62") {
            goto V_;
        }
        if ($xa == "\x52\123\101\137\123\x48\x41\61") {
            goto Se;
        }
        goto w8;
        d9:
        $ua .= "\x26\x53\x69\147\x41\x6c\147\75" . urlencode(XMLSecurityKey::RSA_SHA256);
        $C2 = new XMLSecurityKey(XMLSecurityKey::RSA_SHA256, $V4);
        goto w8;
        N6:
        $ua .= "\x26\123\151\147\101\154\x67\75" . urlencode(XMLSecurityKey::RSA_SHA384);
        $C2 = new XMLSecurityKey(XMLSecurityKey::RSA_SHA384, $V4);
        goto w8;
        V_:
        $ua .= "\x26\x53\151\147\x41\x6c\x67\x3d" . urlencode(XMLSecurityKey::RSA_SHA512);
        $C2 = new XMLSecurityKey(XMLSecurityKey::RSA_SHA512, $V4);
        goto w8;
        Se:
        $ua .= "\x26\x53\151\x67\x41\x6c\x67\75" . urlencode(XMLSecurityKey::RSA_SHA1);
        $C2 = new XMLSecurityKey(XMLSecurityKey::RSA_SHA1, $V4);
        w8:
        $C2->loadKey(Utilities::getPrivateKey(), FALSE);
        $Pz = new XMLSecurityDSig();
        $Tv = $C2->signData($ua);
        $Tv = base64_encode($Tv);
        $ua .= "\x26\123\x69\147\156\141\x74\165\x72\145\75" . urlencode($Tv);
        Tn:
        $oa .= $ua;
        $ld = new RedirectResponse($oa);
        $ld->send();
        rN:
    }
}
