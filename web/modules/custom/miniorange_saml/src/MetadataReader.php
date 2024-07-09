<?php


namespace Drupal\miniorange_saml;

class MetadataReader
{
    private $identityProviders;
    private $serviceProviders;
    public function __construct(\DOMNode $A3 = NULL)
    {
        $this->identityProviders = array();
        $this->serviceProviders = array();
        $kJ = Utilities::xpQuery($A3, "\56\57\x73\x61\x6d\154\x5f\155\145\164\141\x64\141\164\x61\x3a\105\156\x74\151\x74\x79\x44\x65\163\x63\x72\x69\x70\164\x6f\x72");
        foreach ($kJ as $U0) {
            $mK = Utilities::xpQuery($U0, "\56\57\163\x61\x6d\x6c\137\x6d\145\x74\x61\144\x61\x74\x61\x3a\x49\104\120\x53\123\x4f\x44\x65\x73\x63\162\x69\x70\x74\157\x72");
            if (!(isset($mK) && !empty($mK))) {
                goto oa;
            }
            array_push($this->identityProviders, new IdentityProviders($U0));
            oa:
            PK:
        }
        Wz:
    }
    public function getIdentityProviders()
    {
        return $this->identityProviders;
    }
    public function getServiceProviders()
    {
        return $this->serviceProviders;
    }
}
class IdentityProviders
{
    private $idpName;
    private $entityID;
    private $loginDetails;
    private $logoutDetails;
    private $signingCertificate;
    private $encryptionCertificate;
    private $signedRequest;
    public function __construct(\DOMElement $A3 = NULL)
    {
        $this->idpName = '';
        $this->loginDetails = array();
        $this->logoutDetails = array();
        $this->signingCertificate = array();
        $this->encryptionCertificate = array();
        if (!$A3->hasAttribute("\x65\x6e\164\151\x74\x79\x49\x44")) {
            goto y7;
        }
        $this->entityID = $A3->getAttribute("\x65\x6e\x74\151\x74\x79\111\x44");
        y7:
        if (!$A3->hasAttribute("\x57\x61\x6e\164\101\165\x74\x68\156\122\145\x71\165\x65\x73\x74\x73\x53\x69\147\156\145\144")) {
            goto O_;
        }
        $this->signedRequest = $A3->getAttribute("\x57\141\156\x74\x41\165\x74\x68\156\122\x65\161\165\x65\163\x74\163\x53\x69\x67\156\145\144");
        O_:
        $mK = Utilities::xpQuery($A3, "\56\57\x73\141\155\154\x5f\x6d\x65\164\141\144\x61\164\x61\x3a\111\104\x50\123\123\x4f\104\145\x73\x63\162\x69\160\x74\x6f\162");
        if (count($mK) > 1) {
            goto Vy;
        }
        if (empty($mK)) {
            goto rz;
        }
        goto B4;
        Vy:
        throw new Exception("\x4d\157\x72\145\40\164\150\141\156\40\x6f\156\145\x20\74\x49\x44\x50\x53\x53\117\104\x65\163\143\162\151\x70\x74\x6f\x72\x3e\40\x69\x6e\40\74\x45\156\x74\x69\164\x79\x44\x65\x73\143\x72\151\x70\x74\x6f\162\76\x2e");
        goto B4;
        rz:
        throw new Exception("\115\151\163\163\151\x6e\x67\x20\162\x65\x71\x75\151\x72\145\x64\x20\x3c\x49\104\120\x53\x53\117\x44\x65\163\143\162\151\160\164\157\162\x3e\x20\x69\156\x20\74\105\x6e\x74\151\164\x79\x44\145\x73\143\162\151\160\x74\157\x72\76\56");
        B4:
        $eJ = $mK[0];
        $NY = Utilities::xpQuery($A3, "\56\57\x73\x61\155\154\x5f\155\x65\164\x61\x64\x61\164\x61\72\x45\170\x74\145\156\x73\x69\157\156\163");
        if (!$NY) {
            goto nT;
        }
        $this->parseInfo($eJ);
        nT:
        $this->parseSSOService($eJ);
        $this->parseSLOService($eJ);
        $this->parsex509Certificate($eJ);
    }
    private function parseInfo($A3)
    {
        $H1 = Utilities::xpQuery($A3, "\x2e\x2f\x6d\x64\x75\x69\72\125\111\111\156\146\157\57\155\x64\x75\151\x3a\104\x69\163\x70\x6c\141\171\116\141\x6d\x65");
        foreach ($H1 as $tb) {
            if (!($tb->hasAttribute("\x78\x6d\x6c\x3a\154\x61\156\x67") && $tb->getAttribute("\170\155\154\72\154\x61\156\147") == "\145\x6e")) {
                goto Vs;
            }
            $this->idpName = $tb->textContent;
            Vs:
            T2:
        }
        Ck:
    }
    private function parseSSOService($A3)
    {
        $qx = Utilities::xpQuery($A3, "\x2e\x2f\163\x61\155\154\137\x6d\145\164\141\144\141\x74\x61\72\x53\x69\x6e\x67\x6c\x65\123\151\147\x6e\x4f\156\x53\145\x72\x76\151\x63\145");
        foreach ($qx as $Fc) {
            $v7 = str_replace("\165\162\156\x3a\157\141\x73\x69\x73\x3a\x6e\x61\155\x65\163\x3a\x74\x63\72\x53\x41\x4d\114\72\62\56\x30\72\142\151\156\x64\x69\x6e\x67\x73\x3a", '', $Fc->getAttribute("\x42\151\x6e\144\151\x6e\x67"));
            $this->loginDetails = array_merge($this->loginDetails, array($v7 => $Fc->getAttribute("\114\x6f\x63\141\164\x69\x6f\156")));
            mb:
        }
        Et:
    }
    private function parseSLOService($A3)
    {
        $Yh = Utilities::xpQuery($A3, "\x2e\x2f\163\x61\x6d\154\137\x6d\x65\x74\141\144\141\x74\141\x3a\x53\x69\156\x67\154\145\x4c\157\x67\x6f\165\164\123\x65\162\166\151\x63\145");
        foreach ($Yh as $NV) {
            $v7 = str_replace("\x75\x72\156\x3a\x6f\141\x73\151\163\72\156\141\155\x65\x73\x3a\x74\x63\x3a\x53\101\x4d\x4c\x3a\62\56\60\x3a\x62\x69\x6e\144\151\x6e\147\163\72", '', $NV->getAttribute("\x42\x69\x6e\144\151\x6e\x67"));
            $this->logoutDetails = array_merge($this->logoutDetails, array($v7 => $NV->getAttribute("\114\157\x63\x61\164\151\157\156")));
            Pj:
        }
        g4:
    }
    private function parsex509Certificate($A3)
    {
        foreach (Utilities::xpQuery($A3, "\x2e\x2f\x73\x61\155\x6c\137\x6d\145\164\x61\x64\141\164\x61\72\113\x65\171\x44\x65\163\143\162\x69\160\x74\x6f\x72") as $UE) {
            if ($UE->hasAttribute("\165\163\x65")) {
                goto mi;
            }
            $this->parseSigningCertificate($UE);
            goto Up;
            mi:
            if ($UE->getAttribute("\165\x73\145") == "\145\156\143\x72\x79\x70\x74\151\x6f\x6e") {
                goto Yr;
            }
            $this->parseSigningCertificate($UE);
            goto oT;
            Yr:
            $this->parseEncryptionCertificate($UE);
            oT:
            Up:
            VJ:
        }
        CK:
    }
    private function parseSigningCertificate($A3)
    {
        $Fj = Utilities::xpQuery($A3, "\56\x2f\144\x73\72\x4b\x65\171\111\x6e\146\x6f\57\144\x73\72\130\65\x30\71\x44\x61\164\141\57\x64\x73\x3a\130\65\60\71\x43\x65\162\x74\x69\146\x69\x63\141\x74\145");
        $Ze = trim($Fj[0]->textContent);
        $Ze = str_replace(array("\15", "\xa", "\11", "\x20"), '', $Ze);
        if (empty($Fj)) {
            goto Kq;
        }
        array_push($this->signingCertificate, Utilities::sanitize_certificate($Ze));
        Kq:
    }
    private function parseEncryptionCertificate($A3)
    {
        $Fj = Utilities::xpQuery($A3, "\x2e\x2f\x64\163\x3a\113\145\x79\x49\x6e\146\157\57\144\163\x3a\x58\65\x30\x39\104\x61\164\141\x2f\x64\163\x3a\x58\65\x30\71\103\x65\162\164\151\146\x69\143\x61\x74\145");
        $Ze = trim($Fj[0]->textContent);
        $Ze = str_replace(array("\15", "\12", "\11", "\40"), '', $Ze);
        if (empty($Fj)) {
            goto sO;
        }
        array_push($this->encryptionCertificate, $Ze);
        sO:
    }
    public function getIdpName()
    {
        return '';
    }
    public function getEntityID()
    {
        return $this->entityID;
    }
    public function getLoginURL($v7)
    {
        return $this->loginDetails[$v7];
    }
    public function getLogoutURL($v7)
    {
        return isset($this->logoutDetails[$v7]) ? $this->logoutDetails[$v7] : '';
    }
    public function getLoginDetails()
    {
        return $this->loginDetails;
    }
    public function getLogoutDetails()
    {
        return $this->logoutDetails;
    }
    public function getSigningCertificate()
    {
        return $this->signingCertificate;
    }
    public function getEncryptionCertificate()
    {
        return $this->encryptionCertificate[0];
    }
    public function isRequestSigned()
    {
        return $this->signedRequest;
    }
}
class ServiceProviders
{
}
