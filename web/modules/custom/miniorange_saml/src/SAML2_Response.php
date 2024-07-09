<?php


namespace Drupal\miniorange_saml;

use DOMDocument;
use DOMElement;
use Drupal\miniorange_saml\XMLSecurityKey;
class SAML2_Response
{
    private $assertions;
    private $destination;
    private $certificates;
    private $signatureData;
    public function __construct(DOMElement $A3 = NULL)
    {
        $this->assertions = array();
        $this->certificates = array();
        if (!($A3 === NULL)) {
            goto Qb;
        }
        return;
        Qb:
        $xw = Utilities::validateElement($A3);
        if (!($xw !== FALSE)) {
            goto p8;
        }
        $this->certificates = $xw["\103\x65\x72\x74\x69\146\151\143\141\x74\x65\163"];
        $this->signatureData = $xw;
        p8:
        if (!$A3->hasAttribute("\x44\x65\x73\x74\x69\x6e\x61\164\x69\x6f\156")) {
            goto w3;
        }
        $this->destination = $A3->getAttribute("\104\145\163\164\151\x6e\x61\x74\x69\x6f\x6e");
        w3:
        $au = $A3->firstChild;
        wO:
        if (!($au !== NULL)) {
            goto KH;
        }
        if (!($au->namespaceURI !== "\x75\x72\x6e\x3a\x6f\x61\x73\x69\x73\72\156\141\x6d\145\x73\72\x74\x63\x3a\123\101\115\114\x3a\x32\56\x30\x3a\141\163\x73\x65\x72\164\x69\157\156")) {
            goto zp;
        }
        goto z8;
        zp:
        if (!($au->localName === "\x41\x73\163\x65\x72\x74\151\x6f\156" || $au->localName === "\x45\156\143\x72\x79\x70\x74\145\x64\x41\x73\x73\x65\162\x74\x69\157\156")) {
            goto jA;
        }
        $this->assertions[] = new SAML2_Assertion($au);
        jA:
        z8:
        $au = $au->nextSibling;
        goto wO;
        KH:
    }
    public function getAssertions()
    {
        return $this->assertions;
    }
    public function setAssertions(array $XE)
    {
        $this->assertions = $XE;
    }
    public function getDestination()
    {
        return $this->destination;
    }
    public function getCertificates()
    {
        return $this->certificates;
    }
    public function getSignatureData()
    {
        return $this->signatureData;
    }
}
