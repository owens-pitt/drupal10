<?php


namespace Drupal\miniorange_saml;

use DOMDocument;
use DOMElement;
use DOMNode;
use DOMXPath;
use Exception;
class XMLSecEnc
{
    const template = "\74\x78\x65\156\x63\72\x45\x6e\143\162\x79\x70\x74\x65\x64\104\x61\164\x61\40\170\155\154\x6e\x73\72\x78\x65\156\143\75\47\150\x74\164\x70\x3a\x2f\57\x77\167\x77\x2e\x77\x33\56\157\162\x67\57\62\x30\60\61\x2f\60\x34\x2f\170\155\x6c\x65\156\x63\x23\x27\x3e\xd\xa\40\40\40\x3c\170\145\156\143\72\x43\151\160\x68\145\162\x44\x61\x74\141\x3e\15\xa\40\40\x20\x20\40\40\74\x78\145\156\143\72\103\x69\x70\x68\x65\162\x56\x61\x6c\x75\145\76\x3c\57\170\x65\156\143\x3a\x43\151\160\150\x65\162\x56\141\x6c\x75\x65\76\15\xa\40\40\40\74\x2f\x78\145\156\143\x3a\x43\x69\x70\x68\145\x72\x44\x61\x74\141\x3e\15\12\74\57\170\x65\x6e\143\72\105\156\143\162\171\160\164\145\x64\x44\141\164\141\x3e";
    const Element = "\x68\164\164\x70\72\x2f\x2f\x77\x77\167\56\x77\x33\x2e\x6f\162\147\x2f\x32\60\x30\61\x2f\60\64\x2f\x78\155\x6c\145\156\143\43\105\154\145\155\x65\156\x74";
    const Content = "\150\x74\164\160\x3a\57\57\167\x77\x77\56\x77\63\56\x6f\x72\x67\57\62\x30\x30\x31\57\60\x34\x2f\x78\155\x6c\x65\x6e\143\x23\x43\x6f\156\x74\145\156\164";
    const URI = 3;
    const XMLENCNS = "\150\164\x74\x70\x3a\x2f\x2f\x77\167\167\56\x77\63\x2e\x6f\x72\147\57\62\x30\x30\x31\57\60\64\x2f\170\155\154\x65\x6e\x63\x23";
    private $encdoc = null;
    private $rawNode = null;
    public $type = null;
    public $encKey = null;
    private $references = array();
    public function __construct()
    {
        $this->_resetTemplate();
    }
    private function _resetTemplate()
    {
        $this->encdoc = new DOMDocument();
        $this->encdoc->loadXML(self::template);
    }
    public function addReference($tb, $au, $tK)
    {
        if ($au instanceof DOMNode) {
            goto eE;
        }
        throw new Exception("\x24\x6e\x6f\144\x65\40\151\163\x20\x6e\x6f\164\x20\x6f\x66\x20\x74\x79\160\x65\40\x44\117\x4d\116\157\x64\x65");
        eE:
        $pC = $this->encdoc;
        $this->_resetTemplate();
        $Wi = $this->encdoc;
        $this->encdoc = $pC;
        $w2 = XMLSecurityDSig::generateGUID();
        $Dh = $Wi->documentElement;
        $Dh->setAttribute("\111\x64", $w2);
        $this->references[$tb] = array("\156\157\x64\145" => $au, "\x74\171\x70\145" => $tK, "\x65\x6e\143\156\x6f\144\145" => $Wi, "\162\x65\146\165\162\x69" => $w2);
    }
    public function setNode($au)
    {
        $this->rawNode = $au;
    }
    public function encryptNode($ue, $gv = true)
    {
        $nZ = '';
        if (!empty($this->rawNode)) {
            goto FU;
        }
        throw new Exception("\116\157\144\145\40\x74\x6f\x20\x65\156\143\162\171\x70\164\x20\150\141\x73\x20\x6e\x6f\x74\40\142\145\145\156\40\x73\x65\x74");
        FU:
        if ($ue instanceof XMLSecurityKey) {
            goto Ee;
        }
        throw new Exception("\111\156\x76\x61\154\151\144\x20\113\145\x79");
        Ee:
        $cj = $this->rawNode->ownerDocument;
        $cG = new DOMXPath($this->encdoc);
        $CZ = $cG->query("\57\x78\x65\x6e\x63\x3a\105\156\x63\162\x79\160\x74\145\x64\x44\x61\164\141\57\x78\145\x6e\143\72\103\151\160\150\145\162\x44\x61\164\x61\x2f\170\x65\156\x63\x3a\x43\151\160\150\145\x72\x56\141\154\165\x65");
        $Kq = $CZ->item(0);
        if (!($Kq == null)) {
            goto F0;
        }
        throw new Exception("\105\x72\162\157\x72\x20\154\157\x63\141\x74\151\156\x67\40\103\151\160\150\145\162\126\x61\154\165\145\40\x65\154\145\155\x65\x6e\x74\40\x77\x69\164\x68\x69\x6e\x20\x74\145\155\x70\x6c\141\x74\x65");
        F0:
        switch ($this->type) {
            case self::Element:
                $nZ = $cj->saveXML($this->rawNode);
                $this->encdoc->documentElement->setAttribute("\124\x79\160\x65", self::Element);
                goto S9;
            case self::Content:
                $sI = $this->rawNode->childNodes;
                foreach ($sI as $Kg) {
                    $nZ .= $cj->saveXML($Kg);
                    Bs:
                }
                pi:
                $this->encdoc->documentElement->setAttribute("\x54\171\x70\x65", self::Content);
                goto S9;
            default:
                throw new Exception("\x54\171\x70\145\40\x69\163\x20\143\165\162\x72\145\x6e\x74\154\x79\x20\x6e\157\164\x20\x73\165\160\x70\157\x72\x74\x65\x64");
        }
        Gi:
        S9:
        $Pj = $this->encdoc->documentElement->appendChild($this->encdoc->createElementNS(self::XMLENCNS, "\170\x65\156\143\72\x45\156\143\x72\171\x70\x74\151\x6f\x6e\x4d\x65\164\x68\x6f\144"));
        $Pj->setAttribute("\101\154\147\x6f\x72\x69\164\x68\x6d", $ue->getAlgorithm());
        $Kq->parentNode->parentNode->insertBefore($Pj, $Kq->parentNode->parentNode->firstChild);
        $en = base64_encode($ue->encryptData($nZ));
        $hs = $this->encdoc->createTextNode($en);
        $Kq->appendChild($hs);
        if ($gv) {
            goto Iz;
        }
        return $this->encdoc->documentElement;
        goto B0;
        Iz:
        switch ($this->type) {
            case self::Element:
                if (!($this->rawNode->nodeType == XML_DOCUMENT_NODE)) {
                    goto kj;
                }
                return $this->encdoc;
                kj:
                $a8 = $this->rawNode->ownerDocument->importNode($this->encdoc->documentElement, true);
                $this->rawNode->parentNode->replaceChild($a8, $this->rawNode);
                return $a8;
            case self::Content:
                $a8 = $this->rawNode->ownerDocument->importNode($this->encdoc->documentElement, true);
                zM:
                if (!$this->rawNode->firstChild) {
                    goto L_;
                }
                $this->rawNode->removeChild($this->rawNode->firstChild);
                goto zM;
                L_:
                $this->rawNode->appendChild($a8);
                return $a8;
        }
        EQ:
        pm:
        B0:
    }
    public function encryptReferences($ue)
    {
        $wN = $this->rawNode;
        $NP = $this->type;
        foreach ($this->references as $tb => $m3) {
            $this->encdoc = $m3["\x65\156\x63\156\x6f\x64\x65"];
            $this->rawNode = $m3["\156\x6f\x64\145"];
            $this->type = $m3["\x74\171\x70\x65"];
            try {
                $xr = $this->encryptNode($ue);
                $this->references[$tb]["\x65\156\x63\x6e\x6f\144\145"] = $xr;
            } catch (Exception $Ep) {
                $this->rawNode = $wN;
                $this->type = $NP;
                throw $Ep;
            }
            PC:
        }
        qe:
        $this->rawNode = $wN;
        $this->type = $NP;
    }
    public function getCipherValue()
    {
        if (!empty($this->rawNode)) {
            goto UZ;
        }
        throw new Exception("\116\x6f\144\x65\x20\164\157\x20\x64\x65\x63\162\171\x70\164\x20\150\x61\x73\x20\x6e\157\164\x20\142\145\145\x6e\40\163\x65\x74");
        UZ:
        $cj = $this->rawNode->ownerDocument;
        $cG = new DOMXPath($cj);
        $cG->registerNamespace("\x78\x6d\154\x65\156\x63\x72", self::XMLENCNS);
        $Qa = "\56\x2f\170\x6d\x6c\x65\x6e\x63\x72\72\103\151\x70\x68\145\x72\104\x61\164\141\x2f\x78\x6d\154\145\x6e\x63\162\72\x43\151\x70\150\145\162\x56\x61\154\165\x65";
        $dw = $cG->query($Qa, $this->rawNode);
        $au = $dw->item(0);
        if ($au) {
            goto k2;
        }
        return null;
        k2:
        return base64_decode($au->nodeValue);
    }
    public function decryptNode($ue, $gv = true)
    {
        if ($ue instanceof XMLSecurityKey) {
            goto l4;
        }
        throw new Exception("\x49\x6e\166\x61\154\x69\144\40\113\145\171");
        l4:
        $i2 = $this->getCipherValue();
        if ($i2) {
            goto py;
        }
        throw new Exception("\103\x61\x6e\x6e\157\164\x20\154\x6f\143\141\164\145\x20\145\156\143\162\x79\160\164\x65\x64\40\x64\x61\x74\x61");
        goto yd;
        py:
        $Ma = $ue->decryptData($i2);
        if ($gv) {
            goto lF;
        }
        return $Ma;
        goto PP;
        lF:
        switch ($this->type) {
            case self::Element:
                $FW = new DOMDocument();
                $FW->loadXML($Ma);
                if (!($this->rawNode->nodeType == XML_DOCUMENT_NODE)) {
                    goto x9;
                }
                return $FW;
                x9:
                $a8 = $this->rawNode->ownerDocument->importNode($FW->documentElement, true);
                $this->rawNode->parentNode->replaceChild($a8, $this->rawNode);
                return $a8;
            case self::Content:
                if ($this->rawNode->nodeType == XML_DOCUMENT_NODE) {
                    goto LH;
                }
                $cj = $this->rawNode->ownerDocument;
                goto N2;
                LH:
                $cj = $this->rawNode;
                N2:
                $sD = $cj->createDocumentFragment();
                $sD->appendXML($Ma);
                $qt = $this->rawNode->parentNode;
                $qt->replaceChild($sD, $this->rawNode);
                return $qt;
            default:
                return $Ma;
        }
        VT:
        i3:
        PP:
        yd:
    }
    public function encryptKey($xO, $EL, $TM = true)
    {
        if (!(!$xO instanceof XMLSecurityKey || !$EL instanceof XMLSecurityKey)) {
            goto EC;
        }
        throw new Exception("\x49\156\x76\141\154\x69\x64\x20\113\145\171");
        EC:
        $dV = base64_encode($xO->encryptData($EL->key));
        $x1 = $this->encdoc->documentElement;
        $DK = $this->encdoc->createElementNS(self::XMLENCNS, "\x78\145\156\x63\72\x45\x6e\143\162\x79\160\x74\x65\x64\x4b\x65\x79");
        if ($TM) {
            goto fM;
        }
        $this->encKey = $DK;
        goto YP;
        fM:
        $cL = $x1->insertBefore($this->encdoc->createElementNS("\150\164\164\x70\x3a\57\57\x77\x77\x77\x2e\x77\63\56\x6f\x72\147\x2f\x32\60\60\x30\57\x30\71\x2f\170\x6d\x6c\x64\163\x69\x67\43", "\x64\163\x69\147\x3a\x4b\145\x79\x49\x6e\146\157"), $x1->firstChild);
        $cL->appendChild($DK);
        YP:
        $Pj = $DK->appendChild($this->encdoc->createElementNS(self::XMLENCNS, "\170\145\x6e\143\72\x45\156\143\162\x79\160\164\x69\157\156\115\145\164\x68\157\x64"));
        $Pj->setAttribute("\x41\x6c\x67\x6f\162\x69\164\x68\155", $xO->getAlgorith());
        if (empty($xO->name)) {
            goto Ih;
        }
        $cL = $DK->appendChild($this->encdoc->createElementNS("\x68\x74\164\160\72\x2f\x2f\167\167\x77\56\x77\x33\x2e\157\x72\147\x2f\62\x30\x30\60\57\x30\x39\57\170\x6d\154\x64\163\x69\147\x23", "\x64\163\151\147\72\113\x65\x79\x49\156\146\x6f"));
        $cL->appendChild($this->encdoc->createElementNS("\x68\164\164\160\72\57\x2f\x77\167\167\x2e\x77\x33\x2e\x6f\162\x67\57\62\x30\x30\60\x2f\60\71\x2f\x78\155\154\x64\x73\151\147\43", "\144\x73\x69\147\72\x4b\x65\171\x4e\141\x6d\145", $xO->name));
        Ih:
        $Kb = $DK->appendChild($this->encdoc->createElementNS(self::XMLENCNS, "\x78\145\x6e\143\x3a\103\151\160\150\x65\x72\x44\141\x74\141"));
        $Kb->appendChild($this->encdoc->createElementNS(self::XMLENCNS, "\x78\145\x6e\x63\72\103\x69\x70\x68\145\162\x56\141\x6c\165\145", $dV));
        if (!(is_array($this->references) && count($this->references) > 0)) {
            goto Wu;
        }
        $Xp = $DK->appendChild($this->encdoc->createElementNS(self::XMLENCNS, "\x78\x65\156\143\x3a\122\x65\x66\145\162\145\156\x63\145\114\151\x73\x74"));
        foreach ($this->references as $tb => $m3) {
            $w2 = $m3["\162\145\146\165\162\151"];
            $zO = $Xp->appendChild($this->encdoc->createElementNS(self::XMLENCNS, "\x78\145\156\x63\72\104\141\164\x61\122\x65\146\x65\x72\x65\x6e\143\x65"));
            $zO->setAttribute("\125\122\x49", "\x23" . $w2);
            GN:
        }
        mA:
        Wu:
        return;
    }
    public function decryptKey($DK)
    {
        if ($DK->isEncrypted) {
            goto y1;
        }
        throw new Exception("\113\x65\x79\x20\x69\163\40\156\157\x74\x20\105\x6e\143\x72\171\x70\164\x65\144");
        y1:
        if (!empty($DK->key)) {
            goto lh;
        }
        throw new Exception("\113\x65\171\x20\x69\163\40\x6d\151\163\x73\151\156\147\40\x64\141\164\x61\40\x74\157\40\x70\x65\162\x66\x6f\162\x6d\x20\x74\x68\x65\x20\144\x65\x63\162\x79\x70\x74\x69\x6f\x6e");
        lh:
        return $this->decryptNode($DK, false);
    }
    public function locateEncryptedData($Dh)
    {
        if ($Dh instanceof DOMDocument) {
            goto oN;
        }
        $cj = $Dh->ownerDocument;
        goto Xb;
        oN:
        $cj = $Dh;
        Xb:
        if (!$cj) {
            goto E1;
        }
        $vG = new DOMXPath($cj);
        $Qa = "\x2f\x2f\52\133\x6c\157\x63\141\154\x2d\156\141\x6d\145\x28\51\x3d\47\105\x6e\x63\x72\171\160\x74\x65\144\x44\141\164\x61\47\40\x61\x6e\144\x20\156\x61\x6d\145\x73\x70\x61\x63\145\55\x75\162\x69\50\51\75\x27" . self::XMLENCNS . "\x27\135";
        $dw = $vG->query($Qa);
        return $dw->item(0);
        E1:
        return null;
    }
    public function locateKey($au = null)
    {
        if (!empty($au)) {
            goto Pt;
        }
        $au = $this->rawNode;
        Pt:
        if ($au instanceof DOMNode) {
            goto uv;
        }
        return null;
        uv:
        if (!($cj = $au->ownerDocument)) {
            goto aa;
        }
        $vG = new DOMXPath($cj);
        $vG->registerNamespace("\170\155\154\x73\145\x63\145\x6e\x63", self::XMLENCNS);
        $Qa = "\56\57\x2f\170\x6d\x6c\x73\145\x63\145\156\143\x3a\x45\x6e\x63\162\171\x70\164\x69\x6f\x6e\x4d\145\x74\x68\157\144";
        $dw = $vG->query($Qa, $au);
        if (!($lJ = $dw->item(0))) {
            goto td;
        }
        $M2 = $lJ->getAttribute("\x41\154\147\x6f\162\x69\164\x68\x6d");
        try {
            $ue = new XMLSecurityKey($M2, array("\x74\x79\160\x65" => "\160\x72\x69\166\x61\x74\145"));
        } catch (Exception $Ep) {
            return null;
        }
        return $ue;
        td:
        aa:
        return null;
    }
    public static function staticLocateKeyInfo($nL = null, $au = null)
    {
        if (!(empty($au) || !$au instanceof DOMNode)) {
            goto ba;
        }
        return null;
        ba:
        $cj = $au->ownerDocument;
        if ($cj) {
            goto zJ;
        }
        return null;
        zJ:
        $vG = new DOMXPath($cj);
        $vG->registerNamespace("\170\155\154\x73\x65\143\x65\x6e\x63", self::XMLENCNS);
        $vG->registerNamespace("\170\155\154\163\145\x63\x64\163\x69\x67", XMLSecurityDSig::XMLDSIGNS);
        $Qa = "\x2e\57\x78\155\x6c\163\x65\x63\144\163\151\147\72\x4b\x65\171\111\x6e\146\157";
        $dw = $vG->query($Qa, $au);
        $lJ = $dw->item(0);
        if ($lJ) {
            goto hE;
        }
        return $nL;
        hE:
        foreach ($lJ->childNodes as $Kg) {
            switch ($Kg->localName) {
                case "\113\x65\x79\116\x61\155\145":
                    if (empty($nL)) {
                        goto WH;
                    }
                    $nL->name = $Kg->nodeValue;
                    WH:
                    goto xn;
                case "\x4b\145\171\x56\x61\x6c\165\x65":
                    foreach ($Kg->childNodes as $tD) {
                        switch ($tD->localName) {
                            case "\104\x53\101\113\145\x79\126\141\154\165\x65":
                                throw new Exception("\x44\x53\x41\x4b\145\171\x56\141\x6c\x75\145\40\x63\x75\x72\x72\x65\156\x74\x6c\x79\x20\156\157\164\40\163\x75\x70\x70\x6f\162\x74\145\144");
                            case "\x52\123\101\x4b\x65\x79\126\x61\x6c\x75\145":
                                $vv = null;
                                $q6 = null;
                                if (!($mi = $tD->getElementsByTagName("\x4d\157\144\165\x6c\165\x73")->item(0))) {
                                    goto VL;
                                }
                                $vv = base64_decode($mi->nodeValue);
                                VL:
                                if (!($x0 = $tD->getElementsByTagName("\105\x78\160\157\x6e\x65\x6e\164")->item(0))) {
                                    goto VR;
                                }
                                $q6 = base64_decode($x0->nodeValue);
                                VR:
                                if (!(empty($vv) || empty($q6))) {
                                    goto bc;
                                }
                                throw new Exception("\115\x69\x73\163\x69\156\147\40\115\157\144\165\x6c\x75\163\x20\157\x72\x20\105\170\x70\x6f\156\x65\x6e\164");
                                bc:
                                $yT = XMLSecurityKey::convertRSA($vv, $q6);
                                $nL->loadKey($yT);
                                goto YA;
                        }
                        Cg:
                        YA:
                        lw:
                    }
                    cQ:
                    goto xn;
                case "\x52\x65\x74\162\x69\x65\x76\141\154\115\145\x74\150\157\144":
                    $tK = $Kg->getAttribute("\x54\171\x70\145");
                    if (!($tK !== "\x68\x74\x74\160\72\x2f\57\x77\167\167\56\167\63\56\157\x72\x67\57\62\x30\x30\61\57\x30\64\57\x78\155\154\x65\x6e\143\43\105\156\x63\162\x79\160\x74\x65\144\113\x65\171")) {
                        goto kG;
                    }
                    goto xn;
                    kG:
                    $XV = $Kg->getAttribute("\125\x52\x49");
                    if (!($XV[0] !== "\x23")) {
                        goto Z2;
                    }
                    goto xn;
                    Z2:
                    $Vn = substr($XV, 1);
                    $Qa = "\57\57\170\x6d\x6c\x73\145\143\145\x6e\143\x3a\105\156\x63\x72\171\160\164\145\x64\x4b\x65\171\133\100\111\x64\x3d\x22" . XPath::filterAttrValue($Vn, XPath::DOUBLE_QUOTE) . "\x22\x5d";
                    $NM = $vG->query($Qa)->item(0);
                    if ($NM) {
                        goto fb;
                    }
                    throw new Exception("\x55\x6e\141\142\154\145\40\x74\x6f\x20\x6c\x6f\143\141\164\x65\x20\105\x6e\x63\x72\171\x70\x74\x65\144\113\145\x79\40\167\x69\164\x68\40\100\x49\144\75\x27{$Vn}\47\x2e");
                    fb:
                    return XMLSecurityKey::fromEncryptedKeyElement($NM);
                case "\105\x6e\x63\162\171\x70\164\x65\144\113\145\171":
                    return XMLSecurityKey::fromEncryptedKeyElement($Kg);
                case "\x58\65\60\71\x44\141\x74\x61":
                    if (!($Xq = $Kg->getElementsByTagName("\130\65\60\71\103\x65\x72\164\x69\x66\151\x63\141\x74\145"))) {
                        goto h7;
                    }
                    if (!($Xq->length > 0)) {
                        goto Zs;
                    }
                    $ct = $Xq->item(0)->textContent;
                    $ct = str_replace(array("\15", "\xa", "\x20"), '', $ct);
                    $ct = "\55\55\x2d\55\x2d\102\105\107\111\116\x20\x43\105\x52\124\111\x46\111\x43\x41\124\x45\55\x2d\55\55\x2d\xa" . chunk_split($ct, 64, "\xa") . "\55\x2d\x2d\55\55\105\x4e\x44\x20\103\105\122\124\x49\x46\x49\103\101\124\x45\x2d\55\55\55\x2d\12";
                    $nL->loadKey($ct, false, true);
                    Zs:
                    h7:
                    goto xn;
            }
            d8:
            xn:
            X9:
        }
        pc:
        return $nL;
    }
    public function locateKeyInfo($nL = null, $au = null)
    {
        if (!empty($au)) {
            goto mm;
        }
        $au = $this->rawNode;
        mm:
        return self::staticLocateKeyInfo($nL, $au);
    }
}
