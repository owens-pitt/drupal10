<?php


namespace Drupal\miniorange_saml;

use DOMElement;
use DOMDocument;
class LogoutRequest
{
    private $tagName;
    private $id;
    private $issuer;
    private $destination;
    private $issueInstant;
    private $certificates;
    private $validators;
    private $notOnOrAfter;
    private $encryptedNameId;
    private $nameId;
    private $sessionIndexes;
    public function __construct(DOMElement $A3 = NULL)
    {
        $this->tagName = "\x4c\x6f\147\157\x75\x74\x52\x65\161\x75\x65\163\x74";
        $this->id = Utilities::generateID();
        $this->issueInstant = time();
        $this->certificates = array();
        $this->validators = array();
        if (!($A3 === NULL)) {
            goto A5;
        }
        return;
        A5:
        if ($A3->hasAttribute("\x49\104")) {
            goto Ru;
        }
        throw new Exception("\115\x69\x73\163\x69\x6e\147\40\x49\x44\40\x61\x74\x74\162\151\142\x75\164\x65\x20\x6f\156\x20\123\x41\x4d\114\40\155\x65\x73\x73\141\147\145\x2e");
        Ru:
        $this->id = $A3->getAttribute("\111\104");
        if (!($A3->getAttribute("\x56\145\162\163\x69\157\x6e") !== "\62\56\x30")) {
            goto BS;
        }
        throw new Exception("\x55\x6e\163\165\160\160\157\162\164\145\144\40\166\x65\162\163\151\157\x6e\72\x20" . $A3->getAttribute("\126\x65\162\163\151\x6f\156"));
        BS:
        $this->issueInstant = Utilities::xsDateTimeToTimestamp($A3->getAttribute("\111\x73\163\165\x65\x49\156\163\x74\x61\156\164"));
        if (!$A3->hasAttribute("\104\145\163\164\151\x6e\141\x74\151\x6f\x6e")) {
            goto ta;
        }
        $this->destination = $A3->getAttribute("\x44\145\x73\x74\x69\x6e\x61\164\x69\x6f\156");
        ta:
        $fl = Utilities::xpQuery($A3, "\56\x2f\x73\x61\x6d\x6c\137\x61\163\x73\145\x72\x74\151\157\156\72\111\x73\163\x75\145\x72");
        if (empty($fl)) {
            goto J6;
        }
        $this->issuer = trim($fl[0]->textContent);
        J6:
        try {
            $xw = Utilities::validateElement($A3);
            if (!($xw !== FALSE)) {
                goto nf;
            }
            $this->certificates = $xw["\x43\x65\x72\x74\x69\146\151\x63\141\x74\x65\163"];
            $this->validators[] = array("\x46\165\x6e\143\x74\151\157\x6e" => array("\x55\x74\151\154\151\164\x69\145\x73", "\x76\141\154\151\144\141\164\x65\x53\x69\x67\156\x61\x74\165\x72\145"), "\104\141\164\141" => $xw);
            nf:
        } catch (Exception $Ep) {
        }
        $this->sessionIndexes = array();
        if (!$A3->hasAttribute("\x4e\157\x74\117\x6e\117\x72\101\x66\x74\x65\162")) {
            goto sg;
        }
        $this->notOnOrAfter = Utilities::xsDateTimeToTimestamp($A3->getAttribute("\116\x6f\164\117\x6e\117\x72\101\x66\x74\x65\x72"));
        sg:
        $bu = Utilities::xpQuery($A3, "\56\x2f\163\x61\x6d\154\x5f\x61\163\163\145\162\x74\x69\x6f\x6e\x3a\x4e\141\x6d\x65\x49\104\40\174\x20\x2e\x2f\163\x61\x6d\x6c\137\x61\x73\163\145\x72\164\x69\x6f\156\72\105\156\143\162\x79\160\x74\x65\x64\111\x44\x2f\170\x65\x6e\x63\72\x45\x6e\x63\x72\171\x70\164\145\144\x44\x61\164\x61");
        if (empty($bu)) {
            goto QQ;
        }
        if (count($bu) > 1) {
            goto b0;
        }
        goto yY;
        QQ:
        throw new Exception("\115\x69\163\x73\151\156\147\x20\74\163\x61\x6d\x6c\72\x4e\141\x6d\x65\111\104\x3e\x20\x6f\162\x20\74\x73\141\155\154\72\x45\x6e\143\x72\171\x70\x74\x65\144\x49\x44\x3e\x20\151\156\40\x3c\x73\141\155\154\160\x3a\x4c\x6f\x67\x6f\165\164\x52\x65\x71\x75\x65\x73\164\x3e\56");
        goto yY;
        b0:
        throw new Exception("\x4d\157\x72\145\x20\164\x68\x61\156\40\157\x6e\x65\40\x3c\x73\141\155\154\x3a\x4e\x61\x6d\145\111\104\76\40\x6f\x72\x20\x3c\163\141\x6d\x6c\x3a\105\156\143\162\x79\x70\x74\x65\x64\104\76\x20\151\x6e\x20\74\163\141\x6d\x6c\160\72\x4c\x6f\x67\157\x75\164\122\x65\161\165\x65\x73\x74\x3e\56");
        yY:
        $bu = $bu[0];
        if ($bu->localName === "\x45\x6e\143\x72\x79\x70\x74\x65\144\x44\141\164\x61") {
            goto tU;
        }
        $this->nameId = Utilities::parseNameId($bu);
        goto Kb;
        tU:
        $this->encryptedNameId = $bu;
        Kb:
        $m9 = Utilities::xpQuery($A3, "\x2e\x2f\x73\x61\155\154\x5f\x70\162\157\164\x6f\143\157\154\x3a\x53\145\163\x73\x69\157\156\111\x6e\x64\145\x78");
        foreach ($m9 as $q5) {
            $this->sessionIndexes[] = trim($q5->textContent);
            JY:
        }
        X1:
    }
    public function getNotOnOrAfter()
    {
        return $this->notOnOrAfter;
    }
    public function setNotOnOrAfter($y1)
    {
        assert("\x69\163\x5f\151\x6e\x74\50\44\156\157\x74\x4f\156\117\162\x41\x66\164\x65\x72\51\x20\x7c\x7c\x20\x69\x73\137\x6e\x75\x6c\154\x28\x24\156\x6f\164\x4f\156\117\x72\x41\146\164\x65\162\51");
        $this->notOnOrAfter = $y1;
    }
    public function isNameIdEncrypted()
    {
        if (!($this->encryptedNameId !== NULL)) {
            goto V6;
        }
        return TRUE;
        V6:
        return FALSE;
    }
    public function encryptNameId(XMLSecurityKey $C2)
    {
        $cj = new DOMDocument();
        $x1 = $cj->createElement("\162\x6f\x6f\x74");
        $cj->appendChild($x1);
        SAML2_Utils::addNameId($x1, $this->nameId);
        $bu = $x1->firstChild;
        SAML2_Utils::getContainer()->debugMessage($bu, "\x65\156\x63\162\x79\x70\x74");
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
            goto wC;
        }
        return;
        wC:
        $bu = SAML2_Utils::decryptElement($this->encryptedNameId, $C2, $rF);
        SAML2_Utils::getContainer()->debugMessage($bu, "\x64\x65\143\162\x79\160\164");
        $this->nameId = SAML2_Utils::parseNameId($bu);
        $this->encryptedNameId = NULL;
    }
    public function getNameId()
    {
        if (!($this->encryptedNameId !== NULL)) {
            goto Xz;
        }
        throw new Exception("\101\x74\164\145\155\x70\x74\145\x64\40\164\157\x20\x72\x65\164\162\x69\x65\166\145\x20\x65\156\143\162\171\x70\x74\145\x64\x20\116\x61\155\145\111\104\40\167\x69\164\x68\x6f\165\164\40\x64\x65\143\162\x79\x70\x74\x69\156\x67\40\151\x74\40\x66\x69\162\x73\164\56");
        Xz:
        return $this->nameId;
    }
    public function setNameId($bu)
    {
        assert("\x69\x73\137\141\x72\162\141\x79\x28\x24\156\x61\155\x65\x49\x64\x29");
        $this->nameId = $bu;
    }
    public function getSessionIndexes()
    {
        return $this->sessionIndexes;
    }
    public function setSessionIndexes(array $m9)
    {
        $this->sessionIndexes = $m9;
    }
    public function getSessionIndex()
    {
        if (!empty($this->sessionIndexes)) {
            goto fm;
        }
        return NULL;
        fm:
        return $this->sessionIndexes[0];
    }
    public function setSessionIndex($q5)
    {
        assert("\151\163\x5f\163\x74\x72\151\x6e\x67\x28\x24\163\145\x73\163\x69\157\156\111\156\144\x65\x78\x29\40\174\x7c\40\151\163\x5f\156\165\154\x6c\50\44\163\145\x73\x73\151\157\156\x49\156\144\x65\x78\51");
        if (is_null($q5)) {
            goto GZ;
        }
        $this->sessionIndexes = array($q5);
        goto OA;
        GZ:
        $this->sessionIndexes = array();
        OA:
    }
    public function getId()
    {
        return $this->id;
    }
    public function setId($Vn)
    {
        assert("\x69\163\137\163\x74\162\x69\x6e\x67\x28\x24\151\144\51");
        $this->id = $Vn;
    }
    public function getIssueInstant()
    {
        return $this->issueInstant;
    }
    public function setIssueInstant($KW)
    {
        assert("\151\163\137\x69\156\x74\50\44\151\163\x73\x75\x65\x49\x6e\x73\164\x61\156\164\x29");
        $this->issueInstant = $KW;
    }
    public function getDestination()
    {
        return $this->destination;
    }
    public function setDestination($yE)
    {
        assert("\x69\163\x5f\163\164\162\151\x6e\147\x28\x24\x64\145\163\164\151\156\141\164\151\x6f\156\51\x20\174\174\40\151\163\137\156\x75\x6c\x6c\x28\x24\x64\x65\x73\164\x69\156\x61\164\151\x6f\x6e\x29");
        $this->destination = $yE;
    }
    public function getIssuer()
    {
        return $this->issuer;
    }
    public function setIssuer($fl)
    {
        assert("\x69\x73\x5f\x73\164\162\151\x6e\147\50\44\x69\163\x73\x75\145\x72\51\40\x7c\174\x20\151\x73\137\156\165\x6c\154\x28\44\x69\x73\x73\x75\145\x72\51");
        $this->issuer = $fl;
    }
}
