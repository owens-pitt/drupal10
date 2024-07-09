<?php


namespace Drupal\miniorange_saml;

use DOMDocument;
use DOMElement;
use DOMNode;
use DOMXPath;
use Exception;
class XMLSecurityDSig
{
    const XMLDSIGNS = "\150\164\x74\160\x3a\x2f\57\x77\x77\x77\56\x77\x33\x2e\x6f\x72\147\57\x32\60\x30\60\57\x30\71\57\x78\x6d\x6c\144\163\x69\x67\43";
    const SHA1 = "\150\x74\164\160\72\57\57\x77\x77\167\x2e\x77\x33\x2e\157\x72\x67\x2f\x32\x30\x30\60\57\60\71\x2f\170\x6d\154\144\x73\x69\x67\43\x73\150\141\x31";
    const SHA256 = "\x68\x74\x74\160\72\x2f\57\167\167\x77\56\167\63\56\157\162\147\x2f\x32\x30\x30\x31\x2f\x30\x34\57\x78\155\x6c\x65\x6e\143\x23\x73\150\141\x32\x35\66";
    const SHA384 = "\150\164\x74\x70\72\57\x2f\x77\167\x77\x2e\x77\x33\x2e\x6f\162\x67\57\62\60\60\x31\57\60\x34\x2f\170\155\x6c\x64\x73\x69\x67\55\x6d\x6f\162\145\43\x73\150\141\63\x38\x34";
    const SHA512 = "\x68\164\164\x70\72\57\x2f\167\167\x77\x2e\x77\63\x2e\157\162\x67\57\62\x30\x30\61\57\x30\x34\57\x78\x6d\x6c\x65\x6e\x63\43\x73\x68\x61\x35\61\x32";
    const RIPEMD160 = "\150\164\x74\160\x3a\x2f\x2f\x77\167\167\56\167\x33\x2e\x6f\162\x67\57\62\x30\60\x31\57\60\64\x2f\170\x6d\x6c\145\x6e\x63\43\162\151\160\145\x6d\144\61\x36\60";
    const C14N = "\150\x74\x74\160\72\57\x2f\x77\167\x77\56\x77\63\x2e\x6f\x72\x67\57\x54\x52\x2f\x32\60\60\61\x2f\x52\105\x43\55\170\155\x6c\x2d\143\x31\x34\x6e\55\x32\x30\x30\61\x30\63\x31\x35";
    const C14N_COMMENTS = "\150\164\164\160\72\x2f\57\x77\167\167\56\x77\63\56\x6f\x72\147\x2f\124\122\57\62\x30\x30\x31\x2f\x52\105\103\55\x78\155\x6c\55\x63\61\64\x6e\x2d\x32\60\x30\x31\x30\63\x31\65\43\127\x69\x74\x68\x43\157\x6d\155\145\x6e\x74\163";
    const EXC_C14N = "\x68\x74\164\160\72\x2f\57\x77\x77\x77\x2e\x77\63\56\157\x72\147\57\x32\60\x30\x31\57\x31\x30\x2f\x78\155\154\x2d\145\x78\143\x2d\x63\61\64\156\43";
    const EXC_C14N_COMMENTS = "\150\164\x74\160\72\57\x2f\x77\x77\167\56\x77\x33\x2e\x6f\x72\x67\57\x32\x30\x30\x31\x2f\61\60\57\170\155\154\55\145\x78\143\x2d\143\x31\x34\x6e\x23\127\x69\x74\150\x43\x6f\155\x6d\145\x6e\x74\x73";
    const template = "\74\x64\x73\72\x53\x69\147\x6e\x61\x74\x75\x72\x65\x20\170\155\154\x6e\x73\72\x64\x73\75\x22\150\164\164\160\x3a\57\x2f\x77\x77\167\x2e\167\x33\x2e\157\x72\x67\x2f\62\x30\x30\x30\x2f\x30\71\57\170\155\154\x64\163\151\x67\x23\42\76\xd\xa\40\x20\x3c\144\x73\x3a\x53\x69\x67\x6e\145\144\111\156\146\157\76\xd\12\40\40\x20\x20\x3c\x64\x73\72\123\151\147\156\141\x74\165\162\x65\x4d\x65\x74\150\x6f\x64\40\x2f\x3e\15\xa\40\x20\x3c\x2f\144\x73\72\x53\151\x67\x6e\x65\x64\x49\156\146\x6f\76\xd\12\x3c\x2f\144\163\72\x53\151\x67\x6e\141\x74\x75\x72\x65\x3e";
    const BASE_TEMPLATE = "\74\123\x69\x67\x6e\141\x74\x75\x72\x65\x20\x78\155\x6c\x6e\163\75\x22\150\x74\x74\x70\72\57\57\x77\x77\x77\x2e\167\x33\x2e\x6f\162\147\57\x32\60\60\60\57\x30\x39\57\170\155\154\x64\163\151\147\x23\42\x3e\15\12\x20\40\74\x53\x69\147\156\x65\x64\111\156\x66\x6f\x3e\15\12\40\x20\x20\x20\x3c\123\151\147\x6e\x61\x74\165\162\145\115\145\164\150\157\x64\x20\x2f\76\xd\xa\x20\x20\74\x2f\x53\x69\147\156\145\144\x49\156\146\157\76\xd\xa\x3c\x2f\123\151\x67\x6e\141\x74\165\162\145\x3e";
    public $sigNode = null;
    public $idKeys = array();
    public $idNS = array();
    private $signedInfo = null;
    private $xPathCtx = null;
    private $canonicalMethod = null;
    private $prefix = '';
    private $searchpfx = "\163\x65\143\x64\x73\151\147";
    private $validatedNodes = null;
    public function __construct($sX = "\144\163")
    {
        $W2 = self::BASE_TEMPLATE;
        if (empty($sX)) {
            goto mY;
        }
        $this->prefix = $sX . "\72";
        $ng = array("\x3c\123", "\74\x2f\123", "\170\x6d\154\156\163\x3d");
        $gv = array("\74{$sX}\72\123", "\74\57{$sX}\x3a\123", "\170\155\x6c\x6e\163\x3a{$sX}\x3d");
        $W2 = str_replace($ng, $gv, $W2);
        mY:
        $rZ = new DOMDocument();
        $rZ->loadXML($W2);
        $this->sigNode = $rZ->documentElement;
    }
    private function resetXPathObj()
    {
        $this->xPathCtx = null;
    }
    private function getXPathObj()
    {
        if (!(empty($this->xPathCtx) && !empty($this->sigNode))) {
            goto EW;
        }
        $vG = new DOMXPath($this->sigNode->ownerDocument);
        $vG->registerNamespace("\163\x65\x63\144\x73\151\x67", self::XMLDSIGNS);
        $this->xPathCtx = $vG;
        EW:
        return $this->xPathCtx;
    }
    public static function generateGUID($sX = "\160\146\170")
    {
        $dG = md5(uniqid(mt_rand(), true));
        $CW = $sX . substr($dG, 0, 8) . "\x2d" . substr($dG, 8, 4) . "\x2d" . substr($dG, 12, 4) . "\x2d" . substr($dG, 16, 4) . "\55" . substr($dG, 20, 12);
        return $CW;
    }
    public static function generate_GUID($sX = "\x70\x66\170")
    {
        return self::generateGUID($sX);
    }
    public function locateSignature($HA, $Om = 0)
    {
        if ($HA instanceof DOMDocument) {
            goto DQ;
        }
        $cj = $HA->ownerDocument;
        goto AE;
        DQ:
        $cj = $HA;
        AE:
        if (!$cj) {
            goto UB;
        }
        $vG = new DOMXPath($cj);
        $vG->registerNamespace("\163\145\x63\x64\163\x69\147", self::XMLDSIGNS);
        $Qa = "\x2e\x2f\x2f\163\x65\x63\x64\163\151\147\x3a\x53\151\147\x6e\141\x74\x75\x72\145";
        $dw = $vG->query($Qa, $HA);
        $this->sigNode = $dw->item($Om);
        $Qa = "\56\57\x73\145\143\144\163\151\x67\72\123\151\x67\x6e\145\144\111\156\146\x6f";
        $dw = $vG->query($Qa, $this->sigNode);
        if (!($dw->length > 1)) {
            goto oY;
        }
        throw new Exception("\111\x6e\x76\141\x6c\x69\144\40\x73\x74\162\165\x63\164\x75\162\x65\x20\55\40\x54\x6f\x6f\x20\155\141\x6e\171\40\123\x69\147\156\x65\144\x49\x6e\x66\x6f\x20\x65\154\145\x6d\x65\x6e\164\163\x20\146\x6f\165\x6e\144");
        oY:
        return $this->sigNode;
        UB:
        return null;
    }
    public function createNewSignNode($tb, $hs = null)
    {
        $cj = $this->sigNode->ownerDocument;
        if (!is_null($hs)) {
            goto ya;
        }
        $au = $cj->createElementNS(self::XMLDSIGNS, $this->prefix . $tb);
        goto J0;
        ya:
        $au = $cj->createElementNS(self::XMLDSIGNS, $this->prefix . $tb, $hs);
        J0:
        return $au;
    }
    public function setCanonicalMethod($I1)
    {
        switch ($I1) {
            case "\x68\x74\x74\x70\72\x2f\x2f\x77\167\x77\56\x77\x33\56\x6f\x72\x67\57\124\x52\x2f\62\60\60\x31\x2f\122\105\x43\55\x78\x6d\154\x2d\143\61\x34\x6e\55\62\x30\x30\x31\60\x33\x31\65":
            case "\x68\x74\164\x70\72\57\57\167\x77\x77\56\x77\63\56\x6f\162\147\x2f\x54\122\x2f\62\x30\60\61\57\x52\105\103\x2d\170\x6d\x6c\x2d\143\x31\64\156\55\62\60\x30\x31\x30\63\x31\65\43\127\151\x74\150\x43\x6f\155\155\145\x6e\164\x73":
            case "\x68\x74\x74\x70\72\57\x2f\x77\167\x77\x2e\167\63\x2e\x6f\162\x67\57\62\60\x30\61\x2f\x31\60\x2f\x78\155\154\x2d\145\x78\x63\55\143\x31\x34\156\x23":
            case "\150\164\x74\160\72\x2f\x2f\167\167\x77\x2e\x77\x33\56\x6f\x72\147\57\x32\x30\x30\x31\x2f\x31\60\57\170\155\x6c\55\145\170\x63\x2d\143\61\64\x6e\43\127\151\x74\x68\x43\x6f\x6d\155\x65\156\164\163":
                $this->canonicalMethod = $I1;
                goto N4;
            default:
                throw new Exception("\x49\156\x76\141\154\x69\x64\x20\x43\141\x6e\157\x6e\x69\143\141\x6c\40\115\145\x74\x68\x6f\144");
        }
        IP:
        N4:
        if (!($vG = $this->getXPathObj())) {
            goto CS;
        }
        $Qa = "\56\57" . $this->searchpfx . "\72\123\151\x67\x6e\x65\x64\x49\x6e\x66\x6f";
        $dw = $vG->query($Qa, $this->sigNode);
        if (!($DH = $dw->item(0))) {
            goto b7;
        }
        $Qa = "\56\57" . $this->searchpfx . "\103\141\x6e\157\156\151\x63\x61\154\x69\172\x61\164\151\x6f\156\x4d\x65\164\150\157\x64";
        $dw = $vG->query($Qa, $DH);
        if ($BT = $dw->item(0)) {
            goto sQ;
        }
        $BT = $this->createNewSignNode("\103\141\156\x6f\156\151\x63\141\154\x69\x7a\141\164\151\157\x6e\115\145\164\150\x6f\144");
        $DH->insertBefore($BT, $DH->firstChild);
        sQ:
        $BT->setAttribute("\x41\x6c\147\x6f\162\151\164\x68\x6d", $this->canonicalMethod);
        b7:
        CS:
    }
    private function canonicalizeData($au, $Qw, $ZT = null, $nA = null)
    {
        $Ky = false;
        $jF = false;
        switch ($Qw) {
            case "\150\x74\164\160\72\x2f\x2f\167\x77\x77\x2e\167\63\56\x6f\x72\147\x2f\x54\122\x2f\62\x30\x30\61\x2f\x52\x45\103\55\x78\155\154\x2d\x63\61\x34\x6e\55\x32\x30\60\61\60\63\x31\65":
                $Ky = false;
                $jF = false;
                goto s9;
            case "\150\x74\164\160\x3a\x2f\57\x77\x77\167\56\167\x33\x2e\157\x72\147\x2f\124\x52\x2f\x32\60\x30\61\x2f\122\105\103\55\170\155\154\x2d\x63\61\x34\x6e\x2d\x32\60\x30\x31\60\x33\x31\65\43\127\151\x74\x68\x43\157\x6d\x6d\x65\x6e\164\163":
                $jF = true;
                goto s9;
            case "\x68\x74\x74\x70\72\57\57\x77\167\167\56\167\x33\56\157\x72\147\x2f\62\x30\60\x31\57\61\x30\x2f\170\x6d\154\55\145\x78\x63\x2d\143\61\x34\x6e\43":
                $Ky = true;
                goto s9;
            case "\150\164\x74\160\72\57\57\x77\x77\167\56\x77\x33\x2e\157\x72\x67\57\x32\x30\60\x31\x2f\x31\60\57\x78\155\x6c\x2d\145\x78\x63\x2d\x63\61\x34\x6e\43\x57\151\x74\x68\103\157\155\x6d\x65\x6e\x74\163":
                $Ky = true;
                $jF = true;
                goto s9;
        }
        zU:
        s9:
        if (!(is_null($ZT) && $au instanceof DOMNode && $au->ownerDocument !== null && $au->isSameNode($au->ownerDocument->documentElement))) {
            goto Gt;
        }
        $Dh = $au;
        VI:
        if (!($vy = $Dh->previousSibling)) {
            goto Yd;
        }
        if (!($vy->nodeType == XML_PI_NODE || $vy->nodeType == XML_COMMENT_NODE && $jF)) {
            goto X3;
        }
        goto Yd;
        X3:
        $Dh = $vy;
        goto VI;
        Yd:
        if (!($vy == null)) {
            goto TM;
        }
        $au = $au->ownerDocument;
        TM:
        Gt:
        return $au->C14N($Ky, $jF, $ZT, $nA);
    }
    public function canonicalizeSignedInfo()
    {
        $cj = $this->sigNode->ownerDocument;
        $Qw = null;
        if (!$cj) {
            goto ga;
        }
        $vG = $this->getXPathObj();
        $Qa = "\56\57\163\145\143\144\163\151\147\x3a\x53\151\x67\x6e\x65\x64\111\x6e\x66\x6f";
        $dw = $vG->query($Qa, $this->sigNode);
        if (!($dw->length > 1)) {
            goto EO;
        }
        throw new Exception("\111\x6e\x76\x61\154\x69\144\x20\163\x74\162\165\143\164\165\162\x65\x20\x2d\40\124\x6f\x6f\x20\155\x61\x6e\x79\40\123\x69\x67\156\145\x64\111\156\x66\157\40\x65\154\x65\155\x65\156\x74\163\x20\x66\x6f\165\x6e\144");
        EO:
        if (!($of = $dw->item(0))) {
            goto UL;
        }
        $Qa = "\56\57\x73\x65\143\x64\x73\151\x67\x3a\103\141\156\x6f\x6e\151\143\141\154\151\x7a\x61\x74\x69\157\156\115\x65\164\x68\x6f\144";
        $dw = $vG->query($Qa, $of);
        $nA = null;
        if (!($BT = $dw->item(0))) {
            goto sU;
        }
        $Qw = $BT->getAttribute("\101\154\147\157\162\x69\x74\150\x6d");
        foreach ($BT->childNodes as $au) {
            if (!($au->localName == "\111\x6e\x63\x6c\x75\x73\151\x76\x65\x4e\141\x6d\145\x73\x70\141\143\145\x73")) {
                goto cL;
            }
            if (!($zk = $au->getAttribute("\x50\x72\145\146\x69\x78\x4c\151\163\164"))) {
                goto rJ;
            }
            $qc = array_filter(explode("\x20", $zk));
            if (!(count($qc) > 0)) {
                goto Xl;
            }
            $nA = array_merge($nA ? $nA : array(), $qc);
            Xl:
            rJ:
            cL:
            Jy:
        }
        BC:
        sU:
        $this->signedInfo = $this->canonicalizeData($of, $Qw, null, $nA);
        return $this->signedInfo;
        UL:
        ga:
        return null;
    }
    public function calculateDigest($fP, $nZ, $O_ = true)
    {
        switch ($fP) {
            case self::SHA1:
                $Ay = "\163\x68\x61\61";
                goto h3;
            case self::SHA256:
                $Ay = "\163\150\141\x32\x35\66";
                goto h3;
            case self::SHA384:
                $Ay = "\163\x68\141\63\70\64";
                goto h3;
            case self::SHA512:
                $Ay = "\163\150\141\65\x31\x32";
                goto h3;
            case self::RIPEMD160:
                $Ay = "\x72\x69\x70\x65\155\x64\61\66\60";
                goto h3;
            default:
                throw new Exception("\x43\141\156\156\x6f\x74\40\x76\x61\154\x69\x64\141\164\x65\40\144\151\x67\145\x73\x74\72\x20\125\x6e\x73\165\x70\x70\157\162\164\x65\x64\x20\101\154\147\x6f\x72\151\164\x68\x6d\40\74{$fP}\76");
        }
        n3:
        h3:
        $vu = hash($Ay, $nZ, true);
        if (!$O_) {
            goto O7;
        }
        $vu = base64_encode($vu);
        O7:
        return $vu;
    }
    public function validateDigest($ea, $nZ)
    {
        $vG = new DOMXPath($ea->ownerDocument);
        $vG->registerNamespace("\163\x65\143\x64\163\x69\147", self::XMLDSIGNS);
        $Qa = "\x73\x74\162\151\156\147\50\56\57\163\145\x63\x64\x73\x69\147\72\x44\151\x67\x65\x73\164\115\145\164\x68\x6f\144\57\100\x41\x6c\x67\157\162\x69\x74\150\155\x29";
        $fP = $vG->evaluate($Qa, $ea);
        $N2 = $this->calculateDigest($fP, $nZ, false);
        $Qa = "\x73\x74\162\x69\156\147\x28\56\x2f\163\145\143\144\x73\151\x67\x3a\104\151\147\145\x73\164\126\x61\154\165\x65\x29";
        $GW = $vG->evaluate($Qa, $ea);
        return $N2 === base64_decode($GW);
    }
    public function processTransforms($ea, $p4, $iU = true)
    {
        $nZ = $p4;
        $vG = new DOMXPath($ea->ownerDocument);
        $vG->registerNamespace("\163\145\143\144\163\151\147", self::XMLDSIGNS);
        $Qa = "\56\x2f\163\145\x63\144\163\x69\147\x3a\x54\162\141\x6e\x73\146\157\x72\155\163\x2f\163\145\143\144\163\x69\x67\x3a\x54\162\141\156\x73\146\x6f\162\155";
        $Sg = $vG->query($Qa, $ea);
        $t8 = "\x68\x74\x74\x70\72\57\x2f\x77\x77\x77\56\x77\x33\56\x6f\x72\147\x2f\124\122\x2f\x32\60\x30\x31\x2f\122\105\103\x2d\170\155\154\55\143\61\64\156\55\x32\60\x30\x31\60\63\61\x35";
        $ZT = null;
        $nA = null;
        foreach ($Sg as $ww) {
            $PF = $ww->getAttribute("\x41\x6c\x67\x6f\162\151\x74\150\x6d");
            switch ($PF) {
                case "\150\x74\x74\x70\72\57\57\x77\167\x77\56\x77\x33\x2e\157\162\x67\57\62\60\x30\x31\57\61\x30\57\x78\155\154\x2d\x65\x78\143\x2d\x63\61\x34\x6e\x23":
                case "\x68\x74\164\x70\72\57\x2f\x77\167\167\x2e\167\63\56\157\162\x67\57\x32\x30\x30\x31\x2f\61\x30\57\x78\x6d\154\55\145\x78\x63\55\143\61\x34\x6e\43\127\x69\x74\x68\103\157\x6d\x6d\x65\x6e\164\163":
                    if (!$iU) {
                        goto aU;
                    }
                    $t8 = $PF;
                    goto Yc;
                    aU:
                    $t8 = "\150\x74\x74\160\x3a\x2f\x2f\167\x77\x77\x2e\167\x33\56\157\x72\x67\57\62\x30\x30\x31\x2f\61\60\57\x78\155\x6c\55\x65\170\x63\55\143\x31\x34\156\43";
                    Yc:
                    $au = $ww->firstChild;
                    tO:
                    if (!$au) {
                        goto eG;
                    }
                    if (!($au->localName == "\111\156\143\x6c\165\x73\x69\x76\x65\x4e\x61\x6d\x65\x73\x70\141\143\x65\x73")) {
                        goto dA;
                    }
                    if (!($zk = $au->getAttribute("\x50\162\145\x66\x69\x78\114\151\x73\x74"))) {
                        goto cI;
                    }
                    $qc = array();
                    $xe = explode("\40", $zk);
                    foreach ($xe as $zk) {
                        $D_ = trim($zk);
                        if (empty($D_)) {
                            goto D6;
                        }
                        $qc[] = $D_;
                        D6:
                        B6:
                    }
                    b5:
                    if (!(count($qc) > 0)) {
                        goto OC;
                    }
                    $nA = $qc;
                    OC:
                    cI:
                    goto eG;
                    dA:
                    $au = $au->nextSibling;
                    goto tO;
                    eG:
                    goto Lh;
                case "\150\x74\x74\160\x3a\57\57\x77\167\x77\x2e\x77\63\x2e\x6f\x72\x67\x2f\124\122\x2f\62\x30\x30\x31\57\122\x45\103\55\170\x6d\154\55\143\x31\64\x6e\x2d\x32\60\x30\x31\60\x33\61\65":
                case "\150\164\164\x70\72\x2f\57\x77\x77\167\x2e\167\x33\56\x6f\162\x67\x2f\x54\122\57\x32\x30\x30\x31\57\x52\105\103\x2d\170\x6d\x6c\55\x63\x31\64\156\x2d\x32\x30\x30\x31\x30\x33\x31\x35\x23\x57\x69\x74\150\103\x6f\x6d\x6d\x65\156\164\x73":
                    if (!$iU) {
                        goto uE;
                    }
                    $t8 = $PF;
                    goto VE;
                    uE:
                    $t8 = "\x68\164\x74\160\x3a\57\x2f\167\167\167\x2e\x77\x33\56\x6f\162\x67\57\x54\122\57\x32\60\x30\61\57\122\105\103\x2d\x78\x6d\x6c\x2d\x63\x31\64\x6e\x2d\x32\x30\60\61\x30\63\x31\x35";
                    VE:
                    goto Lh;
                case "\150\164\x74\160\72\x2f\57\167\x77\167\56\x77\x33\56\157\162\x67\57\x54\122\x2f\61\x39\71\71\57\x52\x45\x43\x2d\x78\x70\x61\164\150\x2d\61\x39\71\x39\61\x31\61\66":
                    $au = $ww->firstChild;
                    JO:
                    if (!$au) {
                        goto tn;
                    }
                    if (!($au->localName == "\130\120\x61\164\150")) {
                        goto rA;
                    }
                    $ZT = array();
                    $ZT["\x71\x75\x65\162\171"] = "\50\x2e\57\x2f\x2e\x20\174\x20\56\x2f\57\x40\x2a\x20\x7c\x20\56\57\x2f\156\141\x6d\x65\163\160\141\x63\145\x3a\72\52\x29\133" . $au->nodeValue . "\x5d";
                    $ZT["\156\141\155\145\x73\160\141\143\145\x73"] = array();
                    $wD = $vG->query("\56\x2f\x6e\141\x6d\145\163\160\x61\x63\x65\72\x3a\x2a", $au);
                    foreach ($wD as $vo) {
                        if (!($vo->localName != "\x78\x6d\x6c")) {
                            goto Qn;
                        }
                        $ZT["\x6e\x61\x6d\x65\163\x70\x61\143\145\x73"][$vo->localName] = $vo->nodeValue;
                        Qn:
                        D_:
                    }
                    LZ:
                    goto tn;
                    rA:
                    $au = $au->nextSibling;
                    goto JO;
                    tn:
                    goto Lh;
            }
            aA:
            Lh:
            Rj:
        }
        FE:
        if (!$nZ instanceof DOMNode) {
            goto SM;
        }
        $nZ = $this->canonicalizeData($p4, $t8, $ZT, $nA);
        SM:
        return $nZ;
    }
    public function processRefNode($ea)
    {
        $vn = null;
        $iU = true;
        if ($XV = $ea->getAttribute("\125\x52\x49")) {
            goto Cz;
        }
        $iU = false;
        $vn = $ea->ownerDocument;
        goto Nx;
        Cz:
        $UF = parse_url($XV);
        if (!empty($UF["\160\x61\x74\x68"])) {
            goto q4;
        }
        if ($Jc = $UF["\x66\x72\x61\x67\x6d\145\156\x74"]) {
            goto Ey;
        }
        $vn = $ea->ownerDocument;
        goto W2;
        Ey:
        $iU = false;
        $cG = new DOMXPath($ea->ownerDocument);
        if (!($this->idNS && is_array($this->idNS))) {
            goto yN;
        }
        foreach ($this->idNS as $Lp => $ui) {
            $cG->registerNamespace($Lp, $ui);
            H1:
        }
        OG:
        yN:
        $sF = "\x40\x49\x64\75\x22" . XPath::filterAttrValue($Jc, XPath::DOUBLE_QUOTE) . "\42";
        if (!is_array($this->idKeys)) {
            goto Rs;
        }
        foreach ($this->idKeys as $YP) {
            $sF .= "\x20\x6f\162\40\x40" . XPath::filterAttrName($YP) . "\x3d\x22" . XPath::filterAttrValue($Jc, XPath::DOUBLE_QUOTE) . "\x22";
            Yg:
        }
        fi:
        Rs:
        $Qa = "\57\x2f\x2a\133" . $sF . "\x5d";
        $vn = $cG->query($Qa)->item(0);
        W2:
        q4:
        Nx:
        $nZ = $this->processTransforms($ea, $vn, $iU);
        if ($this->validateDigest($ea, $nZ)) {
            goto wt;
        }
        return false;
        wt:
        if (!$vn instanceof DOMNode) {
            goto iv;
        }
        if (!empty($Jc)) {
            goto C_;
        }
        $this->validatedNodes[] = $vn;
        goto mp;
        C_:
        $this->validatedNodes[$Jc] = $vn;
        mp:
        iv:
        return true;
    }
    public function getRefNodeID($ea)
    {
        if (!($XV = $ea->getAttribute("\x55\x52\111"))) {
            goto Dk;
        }
        $UF = parse_url($XV);
        if (!empty($UF["\x70\x61\x74\150"])) {
            goto S7;
        }
        if (!($Jc = $UF["\x66\x72\x61\147\x6d\145\x6e\x74"])) {
            goto Ce;
        }
        return $Jc;
        Ce:
        S7:
        Dk:
        return null;
    }
    public function getRefIDs()
    {
        $aJ = array();
        $vG = $this->getXPathObj();
        $Qa = "\x2e\x2f\163\145\143\144\x73\151\x67\72\x53\151\147\x6e\x65\x64\111\156\146\x6f\133\x31\x5d\57\x73\145\143\144\163\151\x67\72\122\145\x66\x65\162\x65\x6e\143\x65";
        $dw = $vG->query($Qa, $this->sigNode);
        if (!($dw->length == 0)) {
            goto SR;
        }
        throw new Exception("\122\x65\x66\145\162\145\156\143\x65\x20\x6e\x6f\x64\145\x73\x20\x6e\157\164\x20\x66\x6f\x75\156\x64");
        SR:
        foreach ($dw as $ea) {
            $aJ[] = $this->getRefNodeID($ea);
            y8:
        }
        pK:
        return $aJ;
    }
    public function validateReference()
    {
        $CP = $this->sigNode->ownerDocument->documentElement;
        if ($CP->isSameNode($this->sigNode)) {
            goto Pp;
        }
        if (!($this->sigNode->parentNode != null)) {
            goto y4;
        }
        $this->sigNode->parentNode->removeChild($this->sigNode);
        y4:
        Pp:
        $vG = $this->getXPathObj();
        $Qa = "\56\57\x73\x65\x63\x64\163\x69\x67\x3a\123\151\147\x6e\x65\144\x49\x6e\x66\157\133\61\135\57\163\145\x63\144\x73\x69\147\x3a\122\145\x66\x65\162\x65\x6e\x63\x65";
        $dw = $vG->query($Qa, $this->sigNode);
        if (!($dw->length == 0)) {
            goto YC;
        }
        throw new Exception("\x52\x65\146\145\162\x65\x6e\x63\x65\x20\x6e\x6f\x64\145\x73\x20\156\x6f\164\40\146\157\165\x6e\x64");
        YC:
        $this->validatedNodes = array();
        foreach ($dw as $ea) {
            if ($this->processRefNode($ea)) {
                goto aL;
            }
            $this->validatedNodes = null;
            throw new Exception("\x52\145\x66\x65\x72\145\156\143\x65\x20\166\x61\x6c\151\144\x61\164\151\157\156\40\x66\x61\151\x6c\x65\x64");
            aL:
            ho:
        }
        n_:
        return true;
    }
    private function addRefInternal($zo, $au, $PF, $o0 = null, $dk = null)
    {
        $sX = null;
        $Qd = null;
        $Th = "\x49\x64";
        $dW = true;
        $FP = false;
        if (!is_array($dk)) {
            goto On;
        }
        $sX = empty($dk["\x70\162\145\x66\x69\170"]) ? null : $dk["\160\x72\x65\146\x69\170"];
        $Qd = empty($dk["\x70\162\x65\146\151\170\x5f\156\163"]) ? null : $dk["\x70\162\x65\146\151\170\x5f\x6e\163"];
        $Th = empty($dk["\151\144\x5f\x6e\141\x6d\145"]) ? "\111\x64" : $dk["\x69\144\x5f\x6e\x61\155\x65"];
        $dW = !isset($dk["\x6f\166\145\162\167\x72\x69\164\145"]) ? true : (bool) $dk["\157\x76\145\162\x77\162\151\x74\145"];
        $FP = !isset($dk["\x66\157\x72\143\x65\x5f\x75\x72\x69"]) ? false : (bool) $dk["\146\x6f\162\x63\145\x5f\165\x72\151"];
        On:
        $m_ = $Th;
        if (empty($sX)) {
            goto aB;
        }
        $m_ = $sX . "\72" . $m_;
        aB:
        $ea = $this->createNewSignNode("\122\x65\x66\145\x72\145\156\x63\145");
        $zo->appendChild($ea);
        if (!$au instanceof DOMDocument) {
            goto XY;
        }
        if ($FP) {
            goto IX;
        }
        goto WV;
        XY:
        $XV = null;
        if ($dW) {
            goto XW;
        }
        $XV = $Qd ? $au->getAttributeNS($Qd, $Th) : $au->getAttribute($Th);
        XW:
        if (!empty($XV)) {
            goto ly;
        }
        $XV = self::generateGUID();
        $au->setAttributeNS($Qd, $m_, $XV);
        ly:
        $ea->setAttribute("\125\x52\x49", "\x23" . $XV);
        goto WV;
        IX:
        $ea->setAttribute("\x55\122\111", '');
        WV:
        $FJ = $this->createNewSignNode("\124\162\141\x6e\163\146\157\162\155\x73");
        $ea->appendChild($FJ);
        if (is_array($o0)) {
            goto SP;
        }
        if (!empty($this->canonicalMethod)) {
            goto hs;
        }
        goto Ez;
        SP:
        foreach ($o0 as $ww) {
            $Ig = $this->createNewSignNode("\x54\162\141\x6e\163\146\157\162\155");
            $FJ->appendChild($Ig);
            if (is_array($ww) && !empty($ww["\x68\x74\x74\x70\x3a\x2f\x2f\167\x77\167\x2e\167\63\56\x6f\x72\x67\57\x54\x52\x2f\x31\71\x39\x39\x2f\x52\105\x43\55\170\160\x61\164\x68\55\61\x39\71\71\61\x31\61\x36"]) && !empty($ww["\x68\164\x74\x70\x3a\x2f\x2f\167\167\167\x2e\x77\x33\x2e\157\x72\147\57\x54\x52\57\x31\x39\x39\71\57\122\x45\x43\x2d\x78\160\141\164\x68\x2d\61\71\x39\x39\x31\61\x31\x36"]["\161\x75\145\162\x79"])) {
                goto Pi;
            }
            $Ig->setAttribute("\x41\x6c\147\x6f\162\x69\164\x68\155", $ww);
            goto i8;
            Pi:
            $Ig->setAttribute("\x41\154\x67\x6f\x72\151\x74\x68\x6d", "\x68\164\x74\x70\x3a\57\57\x77\167\167\x2e\x77\63\56\157\x72\147\x2f\124\122\57\x31\x39\x39\71\x2f\x52\x45\x43\55\x78\160\141\164\150\55\x31\x39\x39\71\x31\x31\x31\x36");
            $H2 = $this->createNewSignNode("\x58\120\141\164\x68", $ww["\x68\x74\164\x70\72\x2f\x2f\x77\167\167\x2e\x77\63\x2e\157\x72\147\x2f\124\122\57\61\x39\71\x39\x2f\x52\105\103\x2d\170\x70\141\164\150\55\x31\x39\x39\x39\61\61\x31\x36"]["\161\x75\145\162\x79"]);
            $Ig->appendChild($H2);
            if (empty($ww["\150\x74\x74\x70\72\x2f\x2f\167\167\x77\56\x77\63\56\157\x72\x67\57\x54\122\x2f\x31\x39\x39\71\x2f\x52\105\103\55\170\x70\141\x74\x68\x2d\61\71\x39\x39\61\x31\61\66"]["\156\141\155\x65\x73\x70\141\143\145\163"])) {
                goto L1;
            }
            foreach ($ww["\x68\164\164\x70\x3a\57\x2f\x77\167\x77\x2e\x77\63\56\x6f\162\147\57\x54\122\57\61\x39\x39\x39\x2f\122\x45\x43\55\170\x70\x61\164\x68\x2d\61\x39\71\71\61\61\x31\x36"]["\156\141\155\x65\x73\160\x61\143\x65\x73"] as $sX => $yp) {
                $H2->setAttributeNS("\x68\164\164\160\x3a\x2f\57\x77\167\167\x2e\167\x33\x2e\x6f\x72\x67\57\x32\x30\x30\x30\57\x78\155\154\156\x73\57", "\170\x6d\x6c\x6e\x73\x3a{$sX}", $yp);
                Kx:
            }
            rT:
            L1:
            i8:
            z2:
        }
        Zm:
        goto Ez;
        hs:
        $Ig = $this->createNewSignNode("\124\162\x61\x6e\163\x66\157\x72\155");
        $FJ->appendChild($Ig);
        $Ig->setAttribute("\x41\154\147\157\x72\151\164\x68\155", $this->canonicalMethod);
        Ez:
        $Hg = $this->processTransforms($ea, $au);
        $N2 = $this->calculateDigest($PF, $Hg);
        $im = $this->createNewSignNode("\x44\x69\x67\x65\163\164\115\145\164\150\x6f\144");
        $ea->appendChild($im);
        $im->setAttribute("\101\x6c\147\x6f\x72\x69\x74\150\155", $PF);
        $GW = $this->createNewSignNode("\x44\x69\x67\145\x73\164\x56\x61\x6c\165\x65", $N2);
        $ea->appendChild($GW);
    }
    public function addReference($au, $PF, $o0 = null, $dk = null)
    {
        if (!($vG = $this->getXPathObj())) {
            goto Jg;
        }
        $Qa = "\56\x2f\163\x65\143\x64\163\x69\x67\72\123\151\x67\156\x65\x64\x49\156\146\157";
        $dw = $vG->query($Qa, $this->sigNode);
        if (!($L1 = $dw->item(0))) {
            goto Fr;
        }
        $this->addRefInternal($L1, $au, $PF, $o0, $dk);
        Fr:
        Jg:
    }
    public function addReferenceList($vm, $PF, $o0 = null, $dk = null)
    {
        if (!($vG = $this->getXPathObj())) {
            goto G7;
        }
        $Qa = "\56\57\x73\x65\143\x64\163\x69\147\x3a\123\x69\x67\156\145\144\111\x6e\x66\157";
        $dw = $vG->query($Qa, $this->sigNode);
        if (!($L1 = $dw->item(0))) {
            goto UK;
        }
        foreach ($vm as $au) {
            $this->addRefInternal($L1, $au, $PF, $o0, $dk);
            YH:
        }
        NO:
        UK:
        G7:
    }
    public function addObject($nZ, $IG = null, $XX = null)
    {
        $ql = $this->createNewSignNode("\x4f\x62\x6a\145\143\164");
        $this->sigNode->appendChild($ql);
        if (empty($IG)) {
            goto FC;
        }
        $ql->setAttribute("\115\x69\x6d\x65\124\171\160\145", $IG);
        FC:
        if (empty($XX)) {
            goto Ay;
        }
        $ql->setAttribute("\x45\x6e\x63\x6f\x64\x69\156\x67", $XX);
        Ay:
        if ($nZ instanceof DOMElement) {
            goto vb;
        }
        $Y9 = $this->sigNode->ownerDocument->createTextNode($nZ);
        goto N9;
        vb:
        $Y9 = $this->sigNode->ownerDocument->importNode($nZ, true);
        N9:
        $ql->appendChild($Y9);
        return $ql;
    }
    public function locateKey($au = null)
    {
        if (!empty($au)) {
            goto FS;
        }
        $au = $this->sigNode;
        FS:
        if ($au instanceof DOMNode) {
            goto Qv;
        }
        return null;
        Qv:
        if (!($cj = $au->ownerDocument)) {
            goto b_;
        }
        $vG = new DOMXPath($cj);
        $vG->registerNamespace("\x73\145\x63\144\163\151\x67", self::XMLDSIGNS);
        $Qa = "\163\x74\162\x69\156\147\x28\56\x2f\x73\145\143\x64\163\151\x67\x3a\123\151\147\156\x65\x64\x49\156\146\157\57\x73\x65\x63\144\163\151\x67\72\123\x69\x67\x6e\x61\164\x75\x72\145\x4d\145\x74\x68\x6f\144\57\x40\101\154\x67\157\x72\x69\x74\x68\155\51";
        $PF = $vG->evaluate($Qa, $au);
        if (!$PF) {
            goto yJ;
        }
        try {
            $ue = new XMLSecurityKey($PF, array("\x74\171\x70\145" => "\160\165\x62\154\x69\143"));
        } catch (Exception $Ep) {
            return null;
        }
        return $ue;
        yJ:
        b_:
        return null;
    }
    public function verify($ue)
    {
        $cj = $this->sigNode->ownerDocument;
        $vG = new DOMXPath($cj);
        $vG->registerNamespace("\x73\145\143\144\x73\x69\147", self::XMLDSIGNS);
        $Qa = "\x73\x74\x72\x69\156\x67\x28\56\57\163\145\143\144\x73\x69\x67\x3a\123\x69\x67\x6e\141\x74\x75\162\x65\126\141\154\165\145\51";
        $W3 = $vG->evaluate($Qa, $this->sigNode);
        if (!empty($W3)) {
            goto YL;
        }
        throw new Exception("\x55\x6e\141\142\x6c\145\x20\x74\x6f\40\x6c\157\143\141\164\x65\x20\x53\151\147\156\x61\164\165\162\145\x56\x61\154\x75\x65");
        YL:
        return $ue->verifySignature($this->signedInfo, base64_decode($W3));
    }
    public function signData($ue, $nZ)
    {
        return $ue->signData($nZ);
    }
    public function sign($ue, $W0 = null)
    {
        if (!($W0 != null)) {
            goto cD;
        }
        $this->resetXPathObj();
        $this->appendSignature($W0);
        $this->sigNode = $W0->lastChild;
        cD:
        if (!($vG = $this->getXPathObj())) {
            goto n7;
        }
        $Qa = "\56\57\x73\145\x63\144\x73\x69\x67\72\123\x69\147\x6e\x65\144\x49\x6e\146\x6f";
        $dw = $vG->query($Qa, $this->sigNode);
        if (!($L1 = $dw->item(0))) {
            goto lP;
        }
        $Qa = "\56\x2f\163\145\x63\x64\x73\x69\x67\72\x53\151\147\x6e\x61\164\x75\162\x65\x4d\x65\x74\x68\x6f\144";
        $dw = $vG->query($Qa, $L1);
        $Mx = $dw->item(0);
        $Mx->setAttribute("\101\x6c\147\157\x72\x69\164\150\x6d", $ue->type);
        $nZ = $this->canonicalizeData($L1, $this->canonicalMethod);
        $W3 = base64_encode($this->signData($ue, $nZ));
        $YH = $this->createNewSignNode("\123\x69\147\156\x61\x74\x75\x72\x65\x56\x61\154\165\x65", $W3);
        if ($ZY = $L1->nextSibling) {
            goto b1;
        }
        $this->sigNode->appendChild($YH);
        goto Sc;
        b1:
        $ZY->parentNode->insertBefore($YH, $ZY);
        Sc:
        lP:
        n7:
    }
    public function appendCert()
    {
    }
    public function appendKey($ue, $qt = null)
    {
        $ue->serializeKey($qt);
    }
    public function insertSignature($au, $du = null)
    {
        $PP = $au->ownerDocument;
        $oH = $PP->importNode($this->sigNode, true);
        if ($du == null) {
            goto kN;
        }
        return $au->insertBefore($oH, $du);
        goto m9;
        kN:
        return $au->insertBefore($oH);
        m9:
    }
    public function appendSignature($IB, $P8 = false)
    {
        $du = $P8 ? $IB->firstChild : null;
        return $this->insertSignature($IB, $du);
    }
    public static function get509XCert($J_, $aF = true)
    {
        $hx = self::staticGet509XCerts($J_, $aF);
        if (empty($hx)) {
            goto AR;
        }
        return $hx[0];
        AR:
        return '';
    }
    public static function staticGet509XCerts($hx, $aF = true)
    {
        if ($aF) {
            goto Gy;
        }
        return array($hx);
        goto XO;
        Gy:
        $nZ = '';
        $jV = array();
        $WI = explode("\12", $hx);
        $h7 = false;
        foreach ($WI as $Lv) {
            if (!$h7) {
                goto T6;
            }
            if (!(strncmp($Lv, "\x2d\55\55\x2d\55\105\116\104\40\103\105\122\124\111\x46\111\103\101\x54\x45", 20) == 0)) {
                goto V1;
            }
            $h7 = false;
            $jV[] = $nZ;
            $nZ = '';
            goto Eo;
            V1:
            $nZ .= trim($Lv);
            goto VB;
            T6:
            if (!(strncmp($Lv, "\55\x2d\x2d\55\55\x42\x45\x47\x49\x4e\40\103\x45\122\x54\111\x46\111\x43\101\x54\105", 22) == 0)) {
                goto SK;
            }
            $h7 = true;
            SK:
            VB:
            Eo:
        }
        v6:
        return $jV;
        XO:
    }
    public static function staticAdd509Cert($vh, $J_, $aF = true, $pf = false, $vG = null, $dk = null)
    {
        if (!$pf) {
            goto PI;
        }
        $J_ = file_get_contents($J_);
        PI:
        if ($vh instanceof DOMElement) {
            goto qa;
        }
        throw new Exception("\x49\156\166\x61\154\151\144\40\x70\x61\x72\145\156\164\40\116\x6f\x64\145\x20\160\x61\162\141\155\145\x74\145\162");
        qa:
        $Td = $vh->ownerDocument;
        if (!empty($vG)) {
            goto x2;
        }
        $vG = new DOMXPath($vh->ownerDocument);
        $vG->registerNamespace("\163\x65\143\144\163\x69\x67", self::XMLDSIGNS);
        x2:
        $Qa = "\56\x2f\x73\x65\143\x64\163\151\x67\x3a\x4b\145\x79\x49\x6e\146\x6f";
        $dw = $vG->query($Qa, $vh);
        $cL = $dw->item(0);
        $Va = '';
        if (!$cL) {
            goto xS;
        }
        $zk = $cL->lookupPrefix(self::XMLDSIGNS);
        if (empty($zk)) {
            goto EP;
        }
        $Va = $zk . "\x3a";
        EP:
        goto nB;
        xS:
        $zk = $vh->lookupPrefix(self::XMLDSIGNS);
        if (empty($zk)) {
            goto Dv;
        }
        $Va = $zk . "\72";
        Dv:
        $AR = false;
        $cL = $Td->createElementNS(self::XMLDSIGNS, $Va . "\x4b\145\171\x49\x6e\146\157");
        $Qa = "\56\x2f\x73\145\143\x64\x73\x69\147\72\x4f\142\152\x65\143\164";
        $dw = $vG->query($Qa, $vh);
        if (!($f8 = $dw->item(0))) {
            goto xh;
        }
        $f8->parentNode->insertBefore($cL, $f8);
        $AR = true;
        xh:
        if ($AR) {
            goto Hf;
        }
        $vh->appendChild($cL);
        Hf:
        nB:
        $hx = self::staticGet509XCerts($J_, $aF);
        $IX = $Td->createElementNS(self::XMLDSIGNS, $Va . "\x58\x35\x30\x39\x44\141\164\x61");
        $cL->appendChild($IX);
        $Tw = false;
        $tH = false;
        if (!is_array($dk)) {
            goto K3;
        }
        if (empty($dk["\x69\x73\x73\165\145\x72\x53\x65\x72\x69\141\x6c"])) {
            goto nl;
        }
        $Tw = true;
        nl:
        if (empty($dk["\163\x75\x62\x6a\x65\x63\164\116\x61\x6d\145"])) {
            goto Yx;
        }
        $tH = true;
        Yx:
        K3:
        foreach ($hx as $Rd) {
            if (!($Tw || $tH)) {
                goto kt;
            }
            if (!($Ze = openssl_x509_parse("\x2d\55\x2d\55\55\x42\x45\107\111\116\40\x43\105\x52\x54\111\x46\x49\x43\101\x54\105\x2d\x2d\55\55\55\12" . chunk_split($Rd, 64, "\xa") . "\55\x2d\55\x2d\55\105\116\104\40\103\x45\122\124\111\106\x49\x43\101\x54\x45\x2d\x2d\x2d\x2d\x2d\12"))) {
                goto xc;
            }
            if (!($tH && !empty($Ze["\x73\165\142\152\145\143\x74"]))) {
                goto By;
            }
            if (is_array($Ze["\x73\x75\x62\152\145\x63\164"])) {
                goto Op;
            }
            $I9 = $Ze["\151\163\163\165\x65\162"];
            goto lr;
            Op:
            $k9 = array();
            foreach ($Ze["\163\x75\142\152\x65\143\164"] as $C2 => $hs) {
                if (is_array($hs)) {
                    goto A2;
                }
                array_unshift($k9, "{$C2}\75{$hs}");
                goto Wv;
                A2:
                foreach ($hs as $KU) {
                    array_unshift($k9, "{$C2}\x3d{$KU}");
                    R1:
                }
                pz:
                Wv:
                MG:
            }
            xK:
            $I9 = implode("\54", $k9);
            lr:
            $zt = $Td->createElementNS(self::XMLDSIGNS, $Va . "\x58\65\x30\71\123\x75\142\x6a\145\143\164\x4e\x61\x6d\145", $I9);
            $IX->appendChild($zt);
            By:
            if (!($Tw && !empty($Ze["\x69\x73\163\165\145\162"]) && !empty($Ze["\x73\145\162\151\141\x6c\x4e\x75\x6d\x62\145\x72"]))) {
                goto ui;
            }
            if (is_array($Ze["\x69\163\163\165\x65\162"])) {
                goto EA;
            }
            $Na = $Ze["\x69\x73\x73\165\145\162"];
            goto TN;
            EA:
            $k9 = array();
            foreach ($Ze["\x69\x73\x73\165\145\162"] as $C2 => $hs) {
                array_unshift($k9, "{$C2}\75{$hs}");
                jl:
            }
            Kl:
            $Na = implode("\54", $k9);
            TN:
            $Bq = $Td->createElementNS(self::XMLDSIGNS, $Va . "\130\65\60\71\111\163\x73\165\145\162\123\145\162\151\x61\154");
            $IX->appendChild($Bq);
            $In = $Td->createElementNS(self::XMLDSIGNS, $Va . "\x58\65\x30\x39\x49\x73\x73\x75\x65\x72\x4e\141\155\x65", $Na);
            $Bq->appendChild($In);
            $In = $Td->createElementNS(self::XMLDSIGNS, $Va . "\x58\x35\x30\71\123\145\162\151\x61\x6c\116\165\155\x62\x65\162", $Ze["\x73\x65\x72\151\141\154\x4e\165\x6d\x62\145\162"]);
            $Bq->appendChild($In);
            ui:
            xc:
            kt:
            $id = $Td->createElementNS(self::XMLDSIGNS, $Va . "\x58\65\60\x39\x43\145\162\x74\151\146\x69\143\x61\164\x65", $Rd);
            $IX->appendChild($id);
            V2:
        }
        TG:
    }
    public function add509Cert($J_, $aF = true, $pf = false, $dk = null)
    {
        if (!($vG = $this->getXPathObj())) {
            goto Rw;
        }
        self::staticAdd509Cert($this->sigNode, $J_, $aF, $pf, $vG, $dk);
        Rw:
    }
    public function appendToKeyInfo($au)
    {
        $vh = $this->sigNode;
        $Td = $vh->ownerDocument;
        $vG = $this->getXPathObj();
        if (!empty($vG)) {
            goto bv;
        }
        $vG = new DOMXPath($vh->ownerDocument);
        $vG->registerNamespace("\x73\145\143\144\x73\x69\147", self::XMLDSIGNS);
        bv:
        $Qa = "\56\x2f\163\145\143\144\163\151\147\x3a\113\145\171\111\156\x66\x6f";
        $dw = $vG->query($Qa, $vh);
        $cL = $dw->item(0);
        if ($cL) {
            goto IZ;
        }
        $Va = '';
        $zk = $vh->lookupPrefix(self::XMLDSIGNS);
        if (empty($zk)) {
            goto J8;
        }
        $Va = $zk . "\72";
        J8:
        $AR = false;
        $cL = $Td->createElementNS(self::XMLDSIGNS, $Va . "\x4b\145\171\111\156\x66\x6f");
        $Qa = "\56\57\163\x65\x63\x64\163\151\x67\x3a\117\x62\x6a\145\x63\x74";
        $dw = $vG->query($Qa, $vh);
        if (!($f8 = $dw->item(0))) {
            goto dd;
        }
        $f8->parentNode->insertBefore($cL, $f8);
        $AR = true;
        dd:
        if ($AR) {
            goto OZ;
        }
        $vh->appendChild($cL);
        OZ:
        IZ:
        $cL->appendChild($au);
        return $cL;
    }
    public function getValidatedNodes()
    {
        return $this->validatedNodes;
    }
}
