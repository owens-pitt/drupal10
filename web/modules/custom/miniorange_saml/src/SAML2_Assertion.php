<?php


namespace Drupal\miniorange_saml;

use DOMElement;
use DOMText;
use Exception;
class SAML2_Assertion
{
    private $id;
    private $issueInstant;
    private $issuer;
    private $nameId;
    private $encryptedNameId;
    private $encryptedAttribute;
    private $encryptionKey;
    private $notBefore;
    private $notOnOrAfter;
    private $validAudiences;
    private $sessionNotOnOrAfter;
    private $sessionIndex;
    private $authnInstant;
    private $authnContextClassRef;
    private $authnContextDecl;
    private $authnContextDeclRef;
    private $AuthenticatingAuthority;
    private $attributes;
    private $nameFormat;
    private $signatureKey;
    private $certificates;
    private $signatureData;
    private $requiredEncAttributes;
    private $SubjectConfirmation;
    protected $wasSignedAtConstruction = FALSE;
    public function __construct(DOMElement $A3 = NULL)
    {
        $this->id = Utilities::generateId();
        $this->issueInstant = Utilities::generateTimestamp();
        $this->issuer = '';
        $this->authnInstant = Utilities::generateTimestamp();
        $this->attributes = array();
        $this->nameFormat = "\165\x72\156\x3a\157\141\x73\x69\163\72\156\141\x6d\145\x73\x3a\164\143\x3a\123\101\115\x4c\x3a\61\56\61\x3a\156\141\x6d\145\x69\x64\55\x66\x6f\162\155\141\x74\72\165\156\163\160\x65\143\151\146\151\145\144";
        $this->certificates = array();
        $this->AuthenticatingAuthority = array();
        $this->SubjectConfirmation = array();
        if (!($A3 === NULL)) {
            goto wV;
        }
        return;
        wV:
        if (!($A3->localName === "\105\156\143\x72\x79\160\x74\145\x64\101\x73\163\145\x72\164\x69\157\156")) {
            goto yV;
        }
        $nZ = Utilities::xpQuery($A3, "\56\x2f\x78\145\156\x63\x3a\105\156\x63\162\x79\x70\164\x65\x64\104\141\164\x61");
        $Wg = Utilities::xpQuery($A3, "\x2f\x2f\170\145\156\143\72\105\156\143\162\x79\160\164\x65\144\x4b\145\171\x2f\x78\145\156\143\72\x45\156\x63\162\171\160\164\151\x6f\156\115\145\x74\x68\157\x64");
        $I1 = '';
        foreach ($Wg as $au) {
            $I1 = $au->getAttribute("\101\154\147\157\x72\151\x74\x68\x6d");
            LO:
        }
        IU:
        $F6 = Utilities::getEncryptionAlgorithm($I1);
        if (count($nZ) === 0) {
            goto at;
        }
        if (count($nZ) > 1) {
            goto cJ;
        }
        goto sP;
        at:
        throw new Exception("\115\151\163\x73\x69\156\x67\x20\x65\156\143\x72\x79\160\x74\x65\144\40\144\x61\164\x61\40\151\156\x20\74\x73\141\155\x6c\x3a\x45\x6e\x63\162\x79\x70\x74\145\x64\x41\x73\163\145\x72\x74\151\x6f\156\76\56");
        goto sP;
        cJ:
        throw new Exception("\x4d\x6f\x72\x65\x20\x74\x68\141\156\40\x6f\156\145\40\145\x6e\x63\x72\171\x70\x74\145\x64\40\144\x61\x74\x61\x20\145\x6c\145\x6d\x65\x6e\x74\x20\x69\156\40\74\x73\x61\x6d\x6c\72\x45\156\x63\x72\171\160\x74\x65\x64\x41\x73\x73\145\162\x74\151\x6f\156\76\x2e");
        sP:
        $Bn = \Drupal::config("\x6d\x69\156\x69\x6f\x72\x61\x6e\x67\x65\x5f\x73\141\x6d\x6c\x2e\x73\145\x74\164\151\156\x67\x73")->get("\155\151\156\151\x6f\162\141\x6e\147\145\x5f\163\x61\155\x6c\137\x70\162\x69\x76\x61\x74\145\x5f\x63\x65\162\x74\x69\146\x69\143\141\x74\x65");
        $C2 = new XMLSecurityKey($F6, array("\x74\171\160\145" => "\160\162\151\166\141\x74\x65"));
        $r4 = !is_null($Bn) && !empty($Bn) ? $Bn : MiniorangeSAMLConstants::MINIORANGE_PRIVATE_KEY;
        $C2->loadKey($r4, FALSE);
        $rF = array();
        $A3 = Utilities::decryptElement($nZ[0], $C2, $rF);
        yV:
        if ($A3->hasAttribute("\x49\x44")) {
            goto pH;
        }
        throw new Exception("\x4d\x69\163\163\151\156\x67\40\111\104\x20\x61\164\164\x72\151\x62\165\x74\x65\40\x6f\x6e\x20\x53\x41\115\114\40\x61\163\x73\x65\162\x74\151\x6f\x6e\x2e");
        pH:
        $this->id = $A3->getAttribute("\111\104");
        if (!($A3->getAttribute("\x56\145\162\163\151\x6f\156") !== "\62\x2e\x30")) {
            goto yH;
        }
        throw new Exception("\x55\156\x73\165\160\160\157\x72\x74\145\144\40\166\x65\x72\x73\151\x6f\x6e\72\40" . $A3->getAttribute("\x56\x65\162\x73\x69\x6f\x6e"));
        yH:
        $this->issueInstant = Utilities::xsDateTimeToTimestamp($A3->getAttribute("\111\163\163\165\145\111\x6e\163\x74\141\156\x74"));
        $fl = Utilities::xpQuery($A3, "\x2e\57\163\x61\155\154\137\x61\163\x73\x65\162\164\151\157\156\72\x49\x73\163\165\x65\162");
        if (!empty($fl)) {
            goto nJ;
        }
        throw new Exception("\115\151\163\x73\x69\x6e\x67\40\74\163\x61\155\154\x3a\x49\163\x73\x75\145\x72\76\40\x69\156\40\x61\163\163\145\162\164\151\x6f\x6e\56");
        nJ:
        $this->issuer = trim($fl[0]->textContent);
        $this->parseConditions($A3);
        $this->parseAuthnStatement($A3);
        $this->parseAttributes($A3);
        $this->parseEncryptedAttributes($A3);
        $this->parseSignature($A3);
        $this->parseSubject($A3);
    }
    private function parseSubject(DOMElement $A3)
    {
        $Q5 = Utilities::xpQuery($A3, "\56\57\163\141\155\154\x5f\x61\163\x73\145\162\x74\151\x6f\156\x3a\123\x75\142\x6a\145\x63\x74");
        if (empty($Q5)) {
            goto eR;
        }
        if (count($Q5) > 1) {
            goto Wf;
        }
        goto Ly;
        eR:
        return;
        goto Ly;
        Wf:
        throw new Exception("\115\157\x72\x65\x20\164\x68\x61\x6e\x20\x6f\156\x65\x20\74\163\141\x6d\x6c\72\123\165\x62\x6a\x65\x63\x74\x3e\40\x69\156\40\74\x73\141\155\154\x3a\101\x73\x73\x65\162\x74\151\157\x6e\x3e\56");
        Ly:
        $Q5 = $Q5[0];
        $bu = Utilities::xpQuery($Q5, "\x2e\x2f\x73\x61\155\154\137\x61\x73\163\x65\162\164\x69\x6f\x6e\x3a\x4e\x61\x6d\x65\111\104\x20\x7c\x20\x2e\x2f\x73\141\155\154\137\x61\163\x73\x65\162\x74\x69\x6f\156\x3a\x45\x6e\143\x72\171\160\x74\x65\144\x49\104\x2f\170\x65\156\143\x3a\x45\156\143\162\x79\160\164\145\x64\104\141\x74\141");
        if (empty($bu)) {
            goto Am;
        }
        if (count($bu) > 1) {
            goto OH;
        }
        goto K_;
        Am:
        throw new Exception("\x4d\151\x73\163\151\x6e\x67\40\x3c\x73\x61\x6d\154\x3a\116\x61\155\x65\x49\x44\x3e\x20\x6f\162\40\74\163\141\x6d\154\72\x45\156\143\162\171\160\x74\x65\x64\x49\x44\76\40\151\x6e\40\x3c\x73\141\x6d\x6c\x3a\123\x75\142\152\145\143\x74\x3e\x2e");
        goto K_;
        OH:
        throw new Exception("\x4d\x6f\x72\145\40\x74\150\141\x6e\40\157\x6e\x65\40\x3c\x73\x61\x6d\x6c\72\116\141\155\x65\x49\104\x3e\40\x6f\162\x20\74\163\x61\155\x6c\x3a\x45\156\x63\x72\x79\x70\x74\x65\x64\104\x3e\x20\x69\x6e\x20\x3c\x73\141\x6d\x6c\72\x53\x75\x62\x6a\145\x63\164\x3e\x2e");
        K_:
        $bu = $bu[0];
        if ($bu->localName === "\105\156\143\162\171\160\164\145\144\x44\141\x74\141") {
            goto Kt;
        }
        $this->nameId = Utilities::parseNameId($bu);
        goto wa;
        Kt:
        $this->encryptedNameId = $bu;
        wa:
    }
    private function parseConditions(DOMElement $A3)
    {
        $Ty = Utilities::xpQuery($A3, "\56\57\x73\141\x6d\154\137\141\x73\x73\x65\162\164\151\x6f\156\x3a\x43\157\x6e\x64\151\164\151\x6f\x6e\x73");
        if (empty($Ty)) {
            goto Uw;
        }
        if (count($Ty) > 1) {
            goto qN;
        }
        goto xr;
        Uw:
        return;
        goto xr;
        qN:
        throw new Exception("\x4d\x6f\x72\x65\40\164\x68\x61\x6e\x20\x6f\x6e\x65\40\74\163\141\x6d\x6c\72\x43\x6f\156\144\151\x74\x69\x6f\x6e\x73\x3e\x20\151\x6e\40\74\163\141\155\x6c\72\101\x73\163\145\x72\x74\x69\x6f\156\x3e\x2e");
        xr:
        $Ty = $Ty[0];
        if (!$Ty->hasAttribute("\116\157\164\x42\145\x66\x6f\162\145")) {
            goto p5;
        }
        $LC = Utilities::xsDateTimeToTimestamp($Ty->getAttribute("\116\157\x74\x42\x65\146\157\162\145"));
        if (!($this->notBefore === NULL || $this->notBefore < $LC)) {
            goto HI;
        }
        $this->notBefore = $LC;
        HI:
        p5:
        if (!$Ty->hasAttribute("\116\157\164\x4f\156\x4f\162\x41\x66\x74\145\162")) {
            goto J1;
        }
        $y1 = Utilities::xsDateTimeToTimestamp($Ty->getAttribute("\116\157\164\117\x6e\x4f\x72\x41\146\164\x65\162"));
        if (!($this->notOnOrAfter === NULL || $this->notOnOrAfter > $y1)) {
            goto iG;
        }
        $this->notOnOrAfter = $y1;
        iG:
        J1:
        $au = $Ty->firstChild;
        lH:
        if (!($au !== NULL)) {
            goto Jl;
        }
        if (!$au instanceof DOMText) {
            goto T_;
        }
        goto V3;
        T_:
        if (!($au->namespaceURI !== "\165\162\x6e\72\157\x61\163\x69\x73\72\156\141\155\x65\x73\72\164\143\x3a\123\x41\115\114\72\62\56\60\72\141\x73\163\145\x72\x74\x69\x6f\x6e")) {
            goto Oj;
        }
        throw new Exception("\125\x6e\x6b\156\157\167\x6e\x20\x6e\x61\x6d\x65\x73\x70\141\x63\x65\40\x6f\x66\40\143\x6f\156\x64\x69\164\151\157\x6e\72\40" . var_export($au->namespaceURI, TRUE));
        Oj:
        switch ($au->localName) {
            case "\x41\x75\x64\151\145\x6e\x63\x65\x52\x65\163\164\x72\151\x63\164\151\157\156":
                $Nc = Utilities::extractStrings($au, "\165\162\x6e\x3a\157\x61\163\151\163\72\156\141\155\145\163\72\x74\x63\x3a\x53\101\115\114\72\62\x2e\x30\72\x61\163\x73\x65\x72\x74\151\x6f\x6e", "\x41\x75\x64\x69\145\156\143\x65");
                if ($this->validAudiences === NULL) {
                    goto UH;
                }
                $this->validAudiences = array_intersect($this->validAudiences, $Nc);
                goto vd;
                UH:
                $this->validAudiences = $Nc;
                vd:
                goto aX;
            case "\x4f\x6e\145\x54\151\155\145\x55\x73\x65":
                goto aX;
            case "\120\162\157\x78\171\x52\x65\163\x74\162\151\x63\x74\x69\x6f\x6e":
                goto aX;
            default:
                throw new Exception("\x55\156\x6b\x6e\x6f\x77\x6e\x20\x63\157\x6e\144\x69\x74\151\x6f\156\x3a\x20" . var_export($au->localName, TRUE));
        }
        AI:
        aX:
        V3:
        $au = $au->nextSibling;
        goto lH;
        Jl:
    }
    private function parseAuthnStatement(DOMElement $A3)
    {
        $C9 = Utilities::xpQuery($A3, "\x2e\x2f\x73\141\x6d\x6c\137\141\x73\163\145\x72\164\x69\x6f\156\x3a\101\165\164\150\x6e\123\164\141\164\145\x6d\145\156\164");
        if (empty($C9)) {
            goto vY;
        }
        if (count($C9) > 1) {
            goto XX;
        }
        goto B1;
        vY:
        $this->authnInstant = NULL;
        return;
        goto B1;
        XX:
        throw new Exception("\115\157\162\145\x20\164\150\x61\x74\x20\x6f\156\x65\x20\74\x73\x61\155\x6c\x3a\x41\165\x74\150\x6e\123\164\x61\x74\x65\155\x65\x6e\x74\76\40\151\x6e\x20\74\163\x61\x6d\154\x3a\101\163\163\x65\162\164\x69\157\156\x3e\40\x6e\x6f\164\40\x73\x75\x70\x70\x6f\162\x74\x65\144\56");
        B1:
        $y2 = $C9[0];
        if ($y2->hasAttribute("\x41\x75\164\x68\x6e\111\156\x73\x74\141\x6e\164")) {
            goto nb;
        }
        throw new Exception("\115\x69\x73\163\x69\x6e\x67\x20\x72\145\161\165\151\x72\x65\144\x20\x41\x75\164\150\156\x49\x6e\x73\x74\x61\156\164\x20\141\x74\164\162\x69\x62\165\x74\x65\x20\157\x6e\40\x3c\163\141\155\154\72\x41\x75\164\x68\x6e\123\x74\141\164\145\x6d\x65\x6e\x74\x3e\56");
        nb:
        $this->authnInstant = Utilities::xsDateTimeToTimestamp($y2->getAttribute("\x41\x75\164\150\x6e\x49\x6e\163\x74\141\156\164"));
        if (!$y2->hasAttribute("\x53\145\163\163\151\x6f\156\x4e\157\164\x4f\156\117\162\x41\146\x74\x65\x72")) {
            goto l0;
        }
        $this->sessionNotOnOrAfter = Utilities::xsDateTimeToTimestamp($y2->getAttribute("\123\145\163\163\151\x6f\156\x4e\x6f\x74\117\x6e\x4f\x72\x41\146\x74\x65\x72"));
        l0:
        if (!$y2->hasAttribute("\x53\x65\163\x73\x69\x6f\156\111\156\x64\x65\x78")) {
            goto g1;
        }
        $this->sessionIndex = $y2->getAttribute("\x53\x65\163\163\151\x6f\156\111\156\144\x65\x78");
        g1:
        $this->parseAuthnContext($y2);
    }
    private function parseAuthnContext(DOMElement $YE)
    {
        $zG = Utilities::xpQuery($YE, "\56\x2f\163\x61\x6d\x6c\137\x61\163\x73\x65\162\x74\x69\x6f\156\x3a\x41\165\x74\150\156\x43\157\156\164\x65\170\164");
        if (count($zG) > 1) {
            goto DX;
        }
        if (empty($zG)) {
            goto Ev;
        }
        goto ZU;
        DX:
        throw new Exception("\x4d\157\162\x65\40\164\150\x61\156\x20\157\x6e\145\40\74\163\141\x6d\154\72\x41\x75\164\x68\156\x43\x6f\156\164\145\x78\x74\x3e\40\151\156\40\x3c\x73\x61\x6d\154\x3a\x41\165\x74\x68\156\123\x74\x61\164\145\155\x65\x6e\x74\76\56");
        goto ZU;
        Ev:
        throw new Exception("\x4d\x69\x73\x73\151\x6e\x67\40\x72\145\x71\165\x69\x72\145\144\40\x3c\163\141\x6d\x6c\72\101\165\164\x68\156\103\157\x6e\164\145\x78\164\x3e\x20\x69\156\x20\74\x73\x61\x6d\x6c\x3a\101\165\x74\x68\x6e\x53\164\141\x74\145\x6d\145\156\164\76\x2e");
        ZU:
        $Vg = $zG[0];
        $hW = Utilities::xpQuery($Vg, "\56\57\163\x61\155\154\x5f\x61\x73\163\145\x72\x74\151\x6f\x6e\72\101\x75\164\x68\156\103\157\156\x74\145\x78\x74\x44\x65\x63\154\122\x65\x66");
        if (count($hW) > 1) {
            goto ND;
        }
        if (count($hW) === 1) {
            goto pu;
        }
        goto vW;
        ND:
        throw new Exception("\115\157\162\145\x20\x74\x68\141\x6e\40\x6f\x6e\145\40\x3c\163\141\155\154\x3a\x41\165\164\150\156\103\157\x6e\164\x65\x78\x74\x44\x65\143\154\x52\145\x66\76\40\146\x6f\x75\x6e\x64\x3f");
        goto vW;
        pu:
        $this->setAuthnContextDeclRef(trim($hW[0]->textContent));
        vW:
        $g6 = Utilities::xpQuery($Vg, "\56\57\x73\x61\155\154\137\x61\163\x73\145\x72\164\151\157\x6e\x3a\101\165\164\150\x6e\103\157\x6e\164\145\x78\164\x44\145\143\x6c");
        if (count($g6) > 1) {
            goto F1;
        }
        if (count($g6) === 1) {
            goto kQ;
        }
        goto Zu;
        F1:
        throw new Exception("\115\x6f\162\145\40\164\150\141\x6e\40\x6f\156\x65\x20\x3c\x73\x61\x6d\x6c\72\101\x75\x74\150\x6e\103\157\x6e\x74\x65\170\x74\x44\145\x63\154\76\x20\146\157\x75\156\144\x3f");
        goto Zu;
        kQ:
        $this->setAuthnContextDecl(new SAML2_XML_Chunk($g6[0]));
        Zu:
        $Gk = Utilities::xpQuery($Vg, "\x2e\x2f\x73\x61\x6d\x6c\137\x61\163\x73\145\x72\x74\151\x6f\x6e\x3a\x41\x75\164\150\156\x43\x6f\x6e\164\x65\170\x74\x43\154\x61\163\163\122\x65\x66");
        if (count($Gk) > 1) {
            goto e0;
        }
        if (count($Gk) === 1) {
            goto zc;
        }
        goto fg;
        e0:
        throw new Exception("\115\x6f\x72\145\40\x74\150\141\x6e\x20\157\156\x65\x20\x3c\x73\x61\x6d\x6c\x3a\x41\165\x74\x68\x6e\x43\x6f\x6e\164\145\170\x74\103\x6c\141\x73\x73\122\x65\146\76\40\151\x6e\40\74\163\x61\155\154\72\101\165\164\150\156\x43\157\156\164\145\170\x74\76\56");
        goto fg;
        zc:
        $this->setAuthnContextClassRef(trim($Gk[0]->textContent));
        fg:
        if (!(empty($this->authnContextClassRef) && empty($this->authnContextDecl) && empty($this->authnContextDeclRef))) {
            goto iL;
        }
        throw new Exception("\x4d\151\163\x73\x69\156\x67\x20\145\151\x74\150\145\162\40\x3c\x73\141\x6d\x6c\72\x41\x75\164\x68\x6e\103\157\156\x74\145\170\164\x43\x6c\141\163\163\122\x65\146\76\x20\x6f\162\40\x3c\x73\x61\155\x6c\72\x41\165\164\150\156\103\157\156\x74\x65\x78\x74\x44\x65\x63\154\122\x65\146\76\40\157\162\x20\74\163\141\155\x6c\x3a\101\165\164\150\156\103\157\156\x74\x65\x78\x74\104\x65\143\x6c\76");
        iL:
        $this->AuthenticatingAuthority = Utilities::extractStrings($Vg, "\165\162\x6e\x3a\157\141\x73\151\163\x3a\156\x61\x6d\145\x73\x3a\x74\x63\x3a\123\x41\x4d\x4c\72\62\x2e\x30\72\141\x73\163\145\x72\x74\151\x6f\156", "\x41\x75\164\x68\x65\x6e\x74\151\143\x61\x74\x69\x6e\x67\101\165\164\150\157\162\151\x74\x79");
    }
    private function parseAttributes(DOMElement $A3)
    {
        $AM = TRUE;
        $aR = Utilities::xpQuery($A3, "\56\57\163\141\155\x6c\137\141\x73\163\x65\x72\164\x69\x6f\x6e\72\x41\x74\164\162\x69\x62\165\164\145\x53\x74\141\164\145\x6d\x65\x6e\164\x2f\163\141\155\x6c\x5f\x61\163\163\x65\162\x74\151\157\x6e\x3a\101\x74\x74\162\151\142\165\x74\145");
        foreach ($aR as $fh) {
            if ($fh->hasAttribute("\116\141\155\145")) {
                goto YG;
            }
            throw new Exception("\115\151\163\x73\x69\156\147\x20\x6e\x61\155\145\40\x6f\156\40\x3c\163\141\155\x6c\72\101\164\x74\162\x69\142\x75\x74\x65\x3e\40\145\x6c\x65\155\x65\x6e\x74\56");
            YG:
            $tb = $fh->getAttribute("\116\141\x6d\x65");
            if ($fh->hasAttribute("\x4e\x61\x6d\145\x46\157\x72\155\141\x74")) {
                goto IO;
            }
            $Qv = "\165\162\156\72\157\141\x73\151\163\72\x6e\141\x6d\145\163\x3a\164\x63\72\x53\x41\x4d\x4c\x3a\61\56\x31\72\x6e\x61\x6d\x65\x69\144\x2d\146\x6f\162\x6d\x61\164\x3a\x75\x6e\x73\x70\145\x63\x69\x66\151\145\x64";
            goto xu;
            IO:
            $Qv = $fh->getAttribute("\116\x61\155\x65\106\157\162\155\x61\164");
            xu:
            if ($AM) {
                goto bL;
            }
            if (!($this->nameFormat !== $Qv)) {
                goto Gs;
            }
            $this->nameFormat = "\165\x72\156\x3a\157\141\163\151\x73\x3a\x6e\141\155\145\x73\x3a\164\x63\72\x53\101\x4d\114\x3a\61\x2e\x31\72\x6e\141\155\145\x69\144\x2d\146\x6f\x72\155\x61\x74\x3a\x75\x6e\163\x70\x65\x63\151\x66\x69\x65\144";
            Gs:
            goto Dy;
            bL:
            $this->nameFormat = $Qv;
            $AM = FALSE;
            Dy:
            if (array_key_exists($tb, $this->attributes)) {
                goto uh;
            }
            $this->attributes[$tb] = array();
            uh:
            $Yv = Utilities::xpQuery($fh, "\56\x2f\163\141\155\x6c\137\141\x73\163\x65\x72\x74\x69\157\156\x3a\101\x74\164\x72\x69\142\x75\x74\145\x56\141\154\x75\x65");
            foreach ($Yv as $hs) {
                $this->attributes[$tb][] = trim($hs->textContent);
                LN:
            }
            lm:
            qf:
        }
        fj:
    }
    private function parseEncryptedAttributes(DOMElement $A3)
    {
        $this->encryptedAttribute = Utilities::xpQuery($A3, "\x2e\57\163\x61\155\x6c\x5f\141\163\x73\145\x72\164\151\157\x6e\72\101\x74\164\162\x69\142\165\164\145\x53\x74\x61\x74\x65\155\x65\156\x74\57\163\141\155\x6c\137\x61\x73\x73\145\x72\x74\151\157\x6e\x3a\x45\x6e\x63\162\x79\160\x74\145\144\x41\164\164\x72\x69\x62\165\164\145");
    }
    private function parseSignature(DOMElement $A3)
    {
        $xw = Utilities::validateElement($A3);
        if (!($xw !== FALSE)) {
            goto KX;
        }
        $this->wasSignedAtConstruction = TRUE;
        $this->certificates = $xw["\103\145\x72\x74\x69\x66\x69\x63\x61\164\145\x73"];
        $this->signatureData = $xw;
        KX:
    }
    public function validate(XMLSecurityKey $C2)
    {
        if (!($this->signatureData === NULL)) {
            goto DS;
        }
        return FALSE;
        DS:
        Utilities::validateSignature($this->signatureData, $C2);
        return TRUE;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setId($Vn)
    {
        $this->id = $Vn;
    }
    public function getIssueInstant()
    {
        return $this->issueInstant;
    }
    public function setIssueInstant($KW)
    {
        $this->issueInstant = $KW;
    }
    public function getIssuer()
    {
        return $this->issuer;
    }
    public function setIssuer($fl)
    {
        $this->issuer = $fl;
    }
    public function getNameId()
    {
        if (!($this->encryptedNameId !== NULL)) {
            goto Gm;
        }
        throw new Exception("\101\164\x74\x65\155\x70\x74\x65\x64\x20\164\x6f\40\x72\x65\x74\162\x69\x65\166\145\x20\145\x6e\x63\162\x79\x70\164\x65\144\40\x4e\x61\155\x65\x49\104\40\x77\151\x74\150\x6f\x75\x74\x20\144\145\143\162\x79\x70\x74\151\x6e\147\x20\151\164\x20\x66\151\162\x73\164\x2e");
        Gm:
        return $this->nameId;
    }
    public function setNameId($bu)
    {
        $this->nameId = $bu;
    }
    public function isNameIdEncrypted()
    {
        if (!($this->encryptedNameId !== NULL)) {
            goto r5;
        }
        return TRUE;
        r5:
        return FALSE;
    }
    public function encryptNameId(XMLSecurityKey $C2)
    {
        $cj = new DOMDocument();
        $x1 = $cj->createElement("\162\157\x6f\164");
        $cj->appendChild($x1);
        Utilities::addNameId($x1, $this->nameId);
        $bu = $x1->firstChild;
        Utilities::getContainer()->debugMessage($bu, "\x65\x6e\x63\162\171\x70\164");
        $O1 = new XMLSecEnc();
        $O1->setNode($bu);
        $O1->type = XMLSecEnc::Element;
        $Xg = new XMLSecurityKey(XMLSecurityKey::AES128_CBC);
        $Xg->generateSessionKey();
        $O1->encryptKey($C2, $Xg);
        $this->encryptedNameId = $O1->encryptNode($Xg);
        $this->nameId = NULL;
    }
    public function decryptNameId(XMLSecurityKey $C2, array $rF = array())
    {
        if (!($this->encryptedNameId === NULL)) {
            goto Qi;
        }
        return;
        Qi:
        $bu = Utilities::decryptElement($this->encryptedNameId, $C2, $rF);
        Utilities::getContainer()->debugMessage($bu, "\144\x65\x63\162\x79\160\x74");
        $this->nameId = Utilities::parseNameId($bu);
        $this->encryptedNameId = NULL;
    }
    public function decryptAttributes(XMLSecurityKey $C2, array $rF = array())
    {
        if (!($this->encryptedAttribute === NULL)) {
            goto LL;
        }
        return;
        LL:
        $AM = TRUE;
        $aR = $this->encryptedAttribute;
        foreach ($aR as $Rn) {
            $fh = Utilities::decryptElement($Rn->getElementsByTagName("\x45\x6e\x63\x72\x79\x70\164\145\144\104\x61\164\x61")->item(0), $C2, $rF);
            if ($fh->hasAttribute("\x4e\141\x6d\145")) {
                goto vq;
            }
            throw new Exception("\x4d\x69\x73\163\151\156\x67\40\x6e\x61\x6d\x65\40\x6f\156\40\74\163\141\155\154\x3a\x41\164\x74\162\151\x62\165\x74\x65\76\x20\145\154\x65\155\x65\156\164\x2e");
            vq:
            $tb = $fh->getAttribute("\x4e\141\x6d\x65");
            if ($fh->hasAttribute("\x4e\x61\155\x65\106\157\x72\155\x61\x74")) {
                goto fY;
            }
            $Qv = "\x75\162\156\x3a\x6f\141\x73\151\163\72\x6e\x61\x6d\x65\x73\x3a\x74\143\72\x53\x41\115\x4c\x3a\62\56\x30\x3a\x61\164\164\162\x6e\141\155\145\x2d\146\x6f\162\155\x61\164\72\165\x6e\163\x70\x65\143\x69\146\x69\x65\x64";
            goto fK;
            fY:
            $Qv = $fh->getAttribute("\116\x61\x6d\145\106\157\162\155\141\x74");
            fK:
            if ($AM) {
                goto kR;
            }
            if (!($this->nameFormat !== $Qv)) {
                goto Hn;
            }
            $this->nameFormat = "\x75\162\x6e\x3a\157\x61\x73\x69\163\72\156\x61\155\x65\163\x3a\x74\143\x3a\123\x41\x4d\114\x3a\62\x2e\60\x3a\x61\164\164\162\x6e\141\x6d\145\x2d\146\x6f\x72\155\141\x74\x3a\165\156\x73\x70\x65\143\x69\x66\151\x65\x64";
            Hn:
            goto US;
            kR:
            $this->nameFormat = $Qv;
            $AM = FALSE;
            US:
            if (array_key_exists($tb, $this->attributes)) {
                goto QB;
            }
            $this->attributes[$tb] = array();
            QB:
            $Yv = Utilities::xpQuery($fh, "\x2e\57\x73\141\155\154\137\141\163\x73\x65\162\164\x69\157\x6e\72\101\164\x74\162\x69\x62\x75\164\x65\x56\141\154\x75\x65");
            foreach ($Yv as $hs) {
                $this->attributes[$tb][] = trim($hs->textContent);
                sc:
            }
            uK:
            mN:
        }
        KE:
    }
    public function getNotBefore()
    {
        return $this->notBefore;
    }
    public function setNotBefore($LC)
    {
        $this->notBefore = $LC;
    }
    public function getNotOnOrAfter()
    {
        return $this->notOnOrAfter;
    }
    public function setNotOnOrAfter($y1)
    {
        $this->notOnOrAfter = $y1;
    }
    public function setEncryptedAttributes($Ta)
    {
        $this->requiredEncAttributes = $Ta;
    }
    public function getValidAudiences()
    {
        return $this->validAudiences;
    }
    public function setValidAudiences(array $Xr = NULL)
    {
        $this->validAudiences = $Xr;
    }
    public function getAuthnInstant()
    {
        return $this->authnInstant;
    }
    public function setAuthnInstant($n5)
    {
        $this->authnInstant = $n5;
    }
    public function getSessionNotOnOrAfter()
    {
        return $this->sessionNotOnOrAfter;
    }
    public function setSessionNotOnOrAfter($qd)
    {
        $this->sessionNotOnOrAfter = $qd;
    }
    public function getSessionIndex()
    {
        return $this->sessionIndex;
    }
    public function setSessionIndex($q5)
    {
        $this->sessionIndex = $q5;
    }
    public function getAuthnContext()
    {
        if (empty($this->authnContextClassRef)) {
            goto fr;
        }
        return $this->authnContextClassRef;
        fr:
        if (empty($this->authnContextDeclRef)) {
            goto c3;
        }
        return $this->authnContextDeclRef;
        c3:
        return NULL;
    }
    public function setAuthnContext($rP)
    {
        $this->setAuthnContextClassRef($rP);
    }
    public function getAuthnContextClassRef()
    {
        return $this->authnContextClassRef;
    }
    public function setAuthnContextClassRef($YA)
    {
        $this->authnContextClassRef = $YA;
    }
    public function setAuthnContextDecl(SAML2_XML_Chunk $k5)
    {
        if (empty($this->authnContextDeclRef)) {
            goto qU;
        }
        throw new Exception("\x41\x75\x74\150\156\x43\157\156\164\x65\170\164\104\145\x63\154\122\x65\146\40\x69\x73\40\x61\154\x72\x65\x61\x64\171\x20\162\x65\x67\151\x73\164\145\x72\145\x64\x21\x20\115\x61\171\40\x6f\156\154\x79\40\x68\x61\166\145\40\145\151\164\150\x65\x72\x20\x61\x20\104\145\143\x6c\x20\x6f\x72\40\141\x20\104\145\x63\x6c\122\145\146\54\x20\156\x6f\x74\40\142\x6f\x74\150\x21");
        qU:
        $this->authnContextDecl = $k5;
    }
    public function getAuthnContextDecl()
    {
        return $this->authnContextDecl;
    }
    public function setAuthnContextDeclRef($nI)
    {
        if (empty($this->authnContextDecl)) {
            goto Vx;
        }
        throw new Exception("\101\x75\x74\150\156\103\x6f\156\164\145\170\x74\x44\x65\143\x6c\40\151\163\40\141\x6c\162\x65\141\x64\x79\x20\162\145\x67\x69\163\164\x65\x72\145\x64\x21\x20\115\x61\171\40\157\x6e\154\x79\40\150\x61\166\145\x20\x65\x69\x74\150\145\x72\x20\x61\40\x44\145\143\154\x20\x6f\x72\40\141\x20\104\145\x63\154\x52\145\x66\x2c\40\156\157\164\40\x62\x6f\x74\x68\41");
        Vx:
        $this->authnContextDeclRef = $nI;
    }
    public function getAuthnContextDeclRef()
    {
        return $this->authnContextDeclRef;
    }
    public function getAuthenticatingAuthority()
    {
        return $this->AuthenticatingAuthority;
    }
    public function setAuthenticatingAuthority($iz)
    {
        $this->AuthenticatingAuthority = $iz;
    }
    public function getAttributes()
    {
        return $this->attributes;
    }
    public function setAttributes(array $aR)
    {
        $this->attributes = $aR;
    }
    public function getAttributeNameFormat()
    {
        return $this->nameFormat;
    }
    public function setAttributeNameFormat($Qv)
    {
        $this->nameFormat = $Qv;
    }
    public function getSubjectConfirmation()
    {
        return $this->SubjectConfirmation;
    }
    public function setSubjectConfirmation(array $UZ)
    {
        $this->SubjectConfirmation = $UZ;
    }
    public function getSignatureKey()
    {
        return $this->signatureKey;
    }
    public function getSignatureData()
    {
        return $this->signatureData;
    }
    public function setSignatureKey(XMLsecurityKey $qS = NULL)
    {
        $this->signatureKey = $qS;
    }
    public function getEncryptionKey()
    {
        return $this->encryptionKey;
    }
    public function setEncryptionKey(XMLSecurityKey $GJ = NULL)
    {
        $this->encryptionKey = $GJ;
    }
    public function setCertificates(array $NN)
    {
        $this->certificates = $NN;
    }
    public function getCertificates()
    {
        return $this->certificates;
    }
    public function getWasSignedAtConstruction()
    {
        return $this->wasSignedAtConstruction;
    }
    public function toXML(DOMNode $y6 = NULL)
    {
        if ($y6 === NULL) {
            goto gX;
        }
        $PP = $y6->ownerDocument;
        goto iJ;
        gX:
        $PP = new DOMDocument();
        $y6 = $PP;
        iJ:
        $x1 = $PP->createElementNS("\165\162\x6e\x3a\x6f\141\x73\x69\x73\x3a\x6e\141\x6d\145\163\x3a\164\143\72\123\101\x4d\114\x3a\62\x2e\60\72\141\x73\x73\145\162\164\151\157\x6e", "\163\x61\155\x6c\x3a" . "\101\163\163\145\162\164\151\157\156");
        $y6->appendChild($x1);
        $x1->setAttributeNS("\165\x72\x6e\x3a\x6f\141\x73\x69\163\x3a\x6e\141\x6d\x65\163\x3a\x74\143\x3a\123\x41\x4d\114\72\62\56\x30\x3a\x70\x72\157\x74\x6f\143\157\x6c", "\163\141\155\154\160\72\164\x6d\160", "\x74\155\160");
        $x1->removeAttributeNS("\x75\x72\x6e\x3a\157\x61\x73\x69\163\72\x6e\141\155\x65\163\x3a\x74\x63\x3a\x53\101\x4d\x4c\x3a\x32\56\x30\72\160\162\157\164\x6f\x63\x6f\154", "\x74\x6d\x70");
        $x1->setAttributeNS("\150\164\x74\160\72\57\x2f\x77\x77\x77\56\x77\63\x2e\157\162\x67\x2f\x32\x30\x30\x31\57\130\x4d\114\x53\143\x68\145\155\141\x2d\151\x6e\163\x74\x61\156\x63\145", "\170\163\151\72\164\x6d\160", "\164\155\160");
        $x1->removeAttributeNS("\x68\164\x74\x70\72\57\x2f\x77\167\x77\56\167\63\56\157\162\x67\x2f\x32\x30\x30\61\57\130\115\x4c\x53\143\150\x65\x6d\x61\55\x69\x6e\x73\164\141\x6e\x63\145", "\164\155\x70");
        $x1->setAttributeNS("\x68\164\x74\160\72\x2f\x2f\x77\167\167\x2e\167\x33\x2e\x6f\x72\147\x2f\x32\60\x30\x31\x2f\x58\x4d\x4c\123\x63\x68\x65\155\141", "\170\x73\x3a\x74\155\160", "\164\155\x70");
        $x1->removeAttributeNS("\150\164\x74\x70\72\x2f\x2f\167\x77\x77\x2e\167\63\x2e\x6f\162\x67\x2f\62\x30\60\x31\57\x58\115\114\123\x63\150\145\155\x61", "\x74\155\160");
        $x1->setAttribute("\111\104", $this->id);
        $x1->setAttribute("\x56\145\162\x73\151\x6f\x6e", "\x32\56\60");
        $x1->setAttribute("\111\163\x73\165\x65\111\156\x73\x74\141\156\164", gmdate("\x59\x2d\x6d\x2d\144\134\124\x48\x3a\x69\x3a\x73\x5c\x5a", $this->issueInstant));
        $fl = Utilities::addString($x1, "\x75\162\156\72\x6f\x61\x73\x69\163\x3a\x6e\x61\155\145\163\72\x74\x63\x3a\123\101\115\114\x3a\x32\x2e\x30\x3a\141\x73\163\145\162\x74\x69\157\156", "\x73\x61\x6d\x6c\72\x49\163\x73\x75\x65\162", $this->issuer);
        $this->addSubject($x1);
        $this->addConditions($x1);
        $this->addAuthnStatement($x1);
        if ($this->requiredEncAttributes == FALSE) {
            goto yA;
        }
        $this->addEncryptedAttributeStatement($x1);
        goto rM;
        yA:
        $this->addAttributeStatement($x1);
        rM:
        if (!($this->signatureKey !== NULL)) {
            goto eL;
        }
        Utilities::insertSignature($this->signatureKey, $this->certificates, $x1, $fl->nextSibling);
        eL:
        return $x1;
    }
    private function addSubject(DOMElement $x1)
    {
        if (!($this->nameId === NULL && $this->encryptedNameId === NULL)) {
            goto iw;
        }
        return;
        iw:
        $Q5 = $x1->ownerDocument->createElementNS("\x75\162\x6e\x3a\x6f\x61\x73\151\163\x3a\156\x61\155\145\x73\x3a\164\x63\72\x53\x41\x4d\x4c\72\x32\x2e\60\x3a\x61\163\x73\145\x72\164\151\x6f\x6e", "\163\x61\x6d\154\x3a\123\165\x62\x6a\x65\x63\x74");
        $x1->appendChild($Q5);
        if ($this->encryptedNameId === NULL) {
            goto Ni;
        }
        $GN = $Q5->ownerDocument->createElementNS("\x75\162\156\72\157\x61\163\151\x73\72\156\x61\x6d\x65\x73\x3a\x74\143\72\123\x41\x4d\x4c\x3a\x32\56\x30\72\x61\x73\163\145\162\164\x69\x6f\x6e", "\x73\141\155\x6c\72" . "\x45\x6e\x63\162\x79\x70\x74\145\x64\x49\x44");
        $Q5->appendChild($GN);
        $GN->appendChild($Q5->ownerDocument->importNode($this->encryptedNameId, TRUE));
        goto Ng;
        Ni:
        Utilities::addNameId($Q5, $this->nameId);
        Ng:
        foreach ($this->SubjectConfirmation as $pL) {
            $pL->toXML($Q5);
            VZ:
        }
        Jz:
    }
    private function addConditions(DOMElement $x1)
    {
        $PP = $x1->ownerDocument;
        $Ty = $PP->createElementNS("\165\162\156\72\157\141\163\151\x73\72\x6e\141\x6d\145\163\72\164\x63\x3a\x53\101\115\114\x3a\x32\56\x30\72\141\x73\x73\145\162\x74\151\157\x6e", "\163\141\x6d\154\x3a\x43\x6f\x6e\x64\151\164\x69\157\156\163");
        $x1->appendChild($Ty);
        if (!($this->notBefore !== NULL)) {
            goto FX;
        }
        $Ty->setAttribute("\116\157\164\102\x65\146\x6f\x72\145", gmdate("\131\x2d\x6d\x2d\x64\x5c\x54\110\x3a\151\72\x73\134\x5a", $this->notBefore));
        FX:
        if (!($this->notOnOrAfter !== NULL)) {
            goto T1;
        }
        $Ty->setAttribute("\116\157\x74\117\x6e\117\162\101\x66\164\x65\x72", gmdate("\x59\x2d\x6d\x2d\144\134\x54\110\72\151\72\163\134\x5a", $this->notOnOrAfter));
        T1:
        if (!($this->validAudiences !== NULL)) {
            goto ut;
        }
        $zV = $PP->createElementNS("\x75\x72\x6e\72\x6f\x61\163\x69\163\x3a\x6e\141\x6d\x65\163\x3a\164\143\72\123\101\x4d\x4c\72\x32\56\60\72\141\x73\163\x65\x72\164\x69\x6f\x6e", "\x73\x61\x6d\x6c\72\x41\165\x64\151\145\x6e\x63\x65\122\145\x73\x74\x72\151\x63\164\151\157\x6e");
        $Ty->appendChild($zV);
        Utilities::addStrings($zV, "\x75\162\x6e\72\157\x61\x73\x69\x73\72\x6e\141\155\145\163\x3a\x74\143\72\x53\x41\115\114\x3a\x32\x2e\60\72\141\x73\x73\145\162\164\x69\157\x6e", "\163\141\x6d\154\72\x41\165\x64\x69\145\x6e\143\145", FALSE, $this->validAudiences);
        ut:
    }
    private function addAuthnStatement(DOMElement $x1)
    {
        if (!($this->authnInstant === NULL || $this->authnContextClassRef === NULL && $this->authnContextDecl === NULL && $this->authnContextDeclRef === NULL)) {
            goto kb;
        }
        return;
        kb:
        $PP = $x1->ownerDocument;
        $YE = $PP->createElementNS("\x75\x72\156\72\x6f\141\163\x69\163\72\x6e\x61\155\145\163\x3a\164\x63\72\x53\x41\x4d\114\72\x32\x2e\60\x3a\141\163\x73\145\162\x74\x69\x6f\x6e", "\163\141\x6d\154\72\101\x75\x74\150\x6e\x53\164\x61\x74\x65\155\145\x6e\164");
        $x1->appendChild($YE);
        $YE->setAttribute("\x41\165\x74\150\156\x49\156\x73\x74\141\x6e\x74", gmdate("\x59\55\155\55\144\134\124\x48\72\151\72\163\x5c\x5a", $this->authnInstant));
        if (!($this->sessionNotOnOrAfter !== NULL)) {
            goto JM;
        }
        $YE->setAttribute("\x53\x65\163\x73\x69\157\x6e\116\x6f\164\x4f\156\x4f\162\x41\146\164\145\162", gmdate("\x59\x2d\155\55\144\134\x54\110\72\x69\72\x73\x5c\132", $this->sessionNotOnOrAfter));
        JM:
        if (!($this->sessionIndex !== NULL)) {
            goto vU;
        }
        $YE->setAttribute("\123\x65\x73\x73\x69\x6f\x6e\111\x6e\144\145\170", $this->sessionIndex);
        vU:
        $Vg = $PP->createElementNS("\165\x72\156\x3a\x6f\141\x73\151\163\x3a\x6e\x61\155\x65\x73\x3a\x74\x63\72\123\x41\x4d\x4c\72\x32\56\x30\x3a\141\x73\163\145\x72\x74\x69\157\x6e", "\x73\x61\155\x6c\x3a\101\x75\x74\150\x6e\103\157\156\x74\x65\170\164");
        $YE->appendChild($Vg);
        if (empty($this->authnContextClassRef)) {
            goto uH;
        }
        Utilities::addString($Vg, "\x75\x72\x6e\x3a\x6f\x61\x73\x69\163\72\156\x61\155\145\x73\72\x74\x63\x3a\x53\101\x4d\x4c\x3a\62\56\60\72\x61\163\163\x65\x72\164\151\x6f\156", "\163\x61\155\x6c\x3a\101\x75\164\150\x6e\103\x6f\156\164\145\x78\164\103\x6c\x61\x73\x73\x52\145\146", $this->authnContextClassRef);
        uH:
        if (empty($this->authnContextDecl)) {
            goto MC;
        }
        $this->authnContextDecl->toXML($Vg);
        MC:
        if (empty($this->authnContextDeclRef)) {
            goto Zi;
        }
        Utilities::addString($Vg, "\165\x72\156\72\x6f\141\x73\151\x73\x3a\156\141\x6d\145\163\72\x74\143\x3a\123\x41\x4d\x4c\x3a\x32\56\x30\72\141\x73\163\x65\x72\164\x69\157\156", "\x73\x61\x6d\x6c\x3a\101\x75\164\150\x6e\103\x6f\x6e\164\145\x78\164\x44\145\143\x6c\x52\145\x66", $this->authnContextDeclRef);
        Zi:
        Utilities::addStrings($Vg, "\165\x72\156\72\x6f\x61\x73\151\x73\72\156\x61\x6d\145\163\x3a\x74\143\72\x53\x41\x4d\x4c\72\x32\56\60\x3a\141\x73\x73\x65\162\x74\151\x6f\x6e", "\x73\141\155\154\72\101\165\164\150\145\x6e\x74\x69\x63\141\164\151\156\147\x41\165\x74\150\x6f\x72\x69\164\x79", FALSE, $this->AuthenticatingAuthority);
    }
    private function addAttributeStatement(DOMElement $x1)
    {
        if (!empty($this->attributes)) {
            goto Xt;
        }
        return;
        Xt:
        $PP = $x1->ownerDocument;
        $SY = $PP->createElementNS("\165\x72\x6e\72\157\x61\163\151\163\72\x6e\x61\x6d\145\163\x3a\x74\x63\72\x53\x41\115\x4c\72\62\56\60\x3a\x61\163\163\x65\162\164\x69\x6f\x6e", "\163\141\x6d\x6c\72\101\164\x74\162\x69\x62\x75\164\145\x53\164\x61\x74\145\155\145\156\164");
        $x1->appendChild($SY);
        foreach ($this->attributes as $tb => $Yv) {
            $fh = $PP->createElementNS("\x75\162\156\72\x6f\141\x73\x69\x73\72\156\x61\155\145\163\x3a\164\143\x3a\x53\101\x4d\x4c\x3a\62\56\60\x3a\141\163\163\x65\162\x74\151\x6f\156", "\x73\x61\x6d\x6c\x3a\101\x74\x74\162\151\142\165\x74\x65");
            $SY->appendChild($fh);
            $fh->setAttribute("\116\141\155\x65", $tb);
            if (!($this->nameFormat !== "\165\162\156\72\x6f\141\x73\151\163\x3a\x6e\x61\x6d\145\x73\72\x74\143\72\123\101\x4d\114\72\x32\x2e\x30\x3a\141\x74\164\x72\156\x61\x6d\x65\x2d\146\x6f\162\x6d\x61\x74\x3a\x75\156\163\160\145\x63\x69\146\151\x65\144")) {
                goto Pk;
            }
            $fh->setAttribute("\116\141\x6d\145\106\157\162\x6d\x61\164", $this->nameFormat);
            Pk:
            foreach ($Yv as $hs) {
                if (is_string($hs)) {
                    goto ZJ;
                }
                if (is_int($hs)) {
                    goto nP;
                }
                $tK = NULL;
                goto T5;
                ZJ:
                $tK = "\x78\x73\72\x73\x74\162\x69\156\147";
                goto T5;
                nP:
                $tK = "\170\163\72\151\x6e\164\x65\x67\x65\162";
                T5:
                $nS = $PP->createElementNS("\x75\162\156\72\x6f\141\163\x69\x73\x3a\156\141\155\x65\x73\x3a\x74\143\x3a\123\x41\115\x4c\x3a\62\56\x30\x3a\141\163\163\145\162\164\151\x6f\156", "\163\x61\155\154\72\x41\x74\164\x72\151\142\165\164\x65\x56\x61\154\165\145");
                $fh->appendChild($nS);
                if (!($tK !== NULL)) {
                    goto gs;
                }
                $nS->setAttributeNS("\150\164\164\x70\x3a\x2f\57\167\x77\167\x2e\167\x33\x2e\157\x72\147\57\x32\60\x30\x31\x2f\x58\x4d\x4c\x53\x63\150\x65\155\141\55\151\x6e\x73\x74\x61\156\143\145", "\x78\x73\x69\72\164\x79\x70\x65", $tK);
                gs:
                if (!is_null($hs)) {
                    goto UC;
                }
                $nS->setAttributeNS("\x68\164\164\x70\72\57\57\167\x77\167\56\x77\63\x2e\x6f\162\x67\x2f\62\60\x30\61\x2f\130\x4d\x4c\x53\x63\x68\x65\x6d\x61\55\x69\156\163\x74\141\x6e\x63\x65", "\170\x73\x69\72\x6e\x69\x6c", "\x74\162\x75\x65");
                UC:
                if ($hs instanceof DOMNodeList) {
                    goto SF;
                }
                $nS->appendChild($PP->createTextNode($hs));
                goto Yl;
                SF:
                $Yu = 0;
                KD:
                if (!($Yu < $hs->length)) {
                    goto fk;
                }
                $au = $PP->importNode($hs->item($Yu), TRUE);
                $nS->appendChild($au);
                Gz:
                $Yu++;
                goto KD;
                fk:
                Yl:
                P0:
            }
            wg:
            TE:
        }
        YB:
    }
    private function addEncryptedAttributeStatement(DOMElement $x1)
    {
        if (!($this->requiredEncAttributes == FALSE)) {
            goto Hy;
        }
        return;
        Hy:
        $PP = $x1->ownerDocument;
        $SY = $PP->createElementNS("\165\162\x6e\72\x6f\141\163\x69\163\x3a\x6e\141\155\x65\163\72\x74\143\72\x53\x41\115\114\x3a\62\56\60\x3a\141\163\163\145\162\164\x69\157\156", "\163\141\x6d\154\72\101\x74\x74\x72\x69\x62\x75\x74\x65\123\164\141\x74\145\x6d\145\156\164");
        $x1->appendChild($SY);
        foreach ($this->attributes as $tb => $Yv) {
            $Uo = new DOMDocument();
            $fh = $Uo->createElementNS("\165\162\156\72\157\x61\163\151\x73\x3a\x6e\x61\x6d\145\x73\x3a\164\143\72\123\x41\115\x4c\x3a\62\x2e\x30\72\x61\x73\163\x65\162\164\151\157\156", "\x73\x61\155\x6c\x3a\x41\164\164\162\151\142\x75\x74\x65");
            $fh->setAttribute("\116\x61\155\145", $tb);
            $Uo->appendChild($fh);
            if (!($this->nameFormat !== "\x75\x72\x6e\x3a\x6f\x61\x73\151\163\72\x6e\141\x6d\x65\163\x3a\164\x63\72\123\x41\115\x4c\72\x32\x2e\60\x3a\x61\x74\164\162\156\141\155\x65\55\x66\157\x72\155\x61\164\72\165\x6e\x73\x70\x65\143\151\x66\151\x65\x64")) {
                goto Mm;
            }
            $fh->setAttribute("\x4e\141\155\145\106\x6f\x72\155\141\164", $this->nameFormat);
            Mm:
            foreach ($Yv as $hs) {
                if (is_string($hs)) {
                    goto gY;
                }
                if (is_int($hs)) {
                    goto oL;
                }
                $tK = NULL;
                goto Pc;
                gY:
                $tK = "\x78\x73\72\x73\164\x72\151\x6e\147";
                goto Pc;
                oL:
                $tK = "\170\x73\x3a\x69\x6e\164\145\x67\145\x72";
                Pc:
                $nS = $Uo->createElementNS("\165\x72\156\72\x6f\141\x73\x69\x73\x3a\x6e\141\x6d\x65\163\72\164\143\72\123\x41\115\x4c\x3a\x32\x2e\60\72\x61\163\x73\x65\x72\x74\151\x6f\x6e", "\163\x61\155\154\72\101\164\x74\162\151\x62\x75\x74\x65\126\141\154\x75\x65");
                $fh->appendChild($nS);
                if (!($tK !== NULL)) {
                    goto Ts;
                }
                $nS->setAttributeNS("\150\x74\164\x70\72\x2f\57\x77\x77\167\56\167\x33\x2e\x6f\162\147\x2f\62\60\x30\61\57\x58\115\114\123\x63\x68\145\155\141\x2d\151\x6e\163\x74\x61\x6e\143\145", "\x78\x73\x69\x3a\x74\171\160\145", $tK);
                Ts:
                if ($hs instanceof DOMNodeList) {
                    goto K1;
                }
                $nS->appendChild($Uo->createTextNode($hs));
                goto VC;
                K1:
                $Yu = 0;
                Tg:
                if (!($Yu < $hs->length)) {
                    goto Xw;
                }
                $au = $Uo->importNode($hs->item($Yu), TRUE);
                $nS->appendChild($au);
                AX:
                $Yu++;
                goto Tg;
                Xw:
                VC:
                HK:
            }
            MN:
            $yk = new XMLSecEnc();
            $yk->setNode($Uo->documentElement);
            $yk->type = "\x68\164\164\x70\72\57\x2f\167\167\167\x2e\x77\63\x2e\x6f\162\x67\x2f\x32\60\x30\x31\57\60\64\57\170\x6d\154\145\156\143\x23\105\x6c\145\x6d\145\x6e\164";
            $Xg = new XMLSecurityKey(XMLSecurityKey::AES256_CBC);
            $Xg->generateSessionKey();
            $yk->encryptKey($this->encryptionKey, $Xg);
            $te = $yk->encryptNode($Xg);
            $Qc = $PP->createElementNS("\x75\x72\156\x3a\x6f\141\163\151\x73\72\156\141\x6d\145\x73\72\x74\x63\72\x53\101\115\114\x3a\x32\x2e\60\x3a\141\x73\x73\145\x72\164\151\157\156", "\163\141\x6d\154\x3a\x45\156\143\162\x79\x70\x74\x65\144\101\x74\x74\162\151\x62\165\x74\x65");
            $SY->appendChild($Qc);
            $Oo = $PP->importNode($te, TRUE);
            $Qc->appendChild($Oo);
            qP:
        }
        CR:
    }
}
