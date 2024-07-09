<?php


namespace Drupal\miniorange_saml\Controller;

use Drupal\Core\Field\EntityReferenceFieldItemList;
use Drupal\field\Entity\FieldStorageConfig;
use Drupal\miniorange_saml\HigherUtilities;
use Drupal\profile\Entity\Profile;
use Drupal\taxonomy\Entity\Term;
use Drupal\user\Entity\User;
use Drupal\Component\Utility\Xss;
use Drupal\Core\Form\FormBuilder;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\miniorange_saml\Utilities;
use Drupal\miniorange_saml\MiniOrangeAcs;
use Drupal\miniorange_saml\AESEncryption;
use Drupal\Core\Controller\ControllerBase;
use Drupal\miniorange_saml\XMLSecurityKey;
use Drupal\miniorange_saml\XMLSecurityDSig;
use Drupal\Core\Ajax\OpenModalDialogCommand;
use Drupal\views\Controller\ViewAjaxController;
use Drupal\views\Plugin\views\area\Entity;
use Symfony\Component\HttpFoundation\Response;
use Drupal\miniorange_saml\MiniOrangeAuthnRequest;
use Drupal\miniorange_saml\MiniorangeSAMLCustomer;
use Drupal\miniorange_saml\MiniorangeSAMLConstants;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;
class miniorange_samlController extends ControllerBase
{
    protected $formBuilder;
    public function __construct(FormBuilder $MC)
    {
        $this->formBuilder = $MC;
    }
    public static function saml_login($xL = '', $z5 = '')
    {
        $ll = \Drupal::config("\x6d\151\x6e\151\157\162\x61\156\x67\145\137\163\x61\155\154\x2e\x73\145\x74\x74\x69\156\x67\163");
        if (!(!$ll->get("\x6d\x69\x6e\x69\157\162\x61\156\147\145\x5f\163\x61\x6d\154\x5f\145\x6e\x61\x62\154\x65\x5f\154\157\x67\x69\156") && strcasecmp($z5, "\164\145\163\x74\126\141\154\151\x64\x61\x74\145") != 0)) {
            goto LI;
        }
        $am = "\x43\141\x6e\x20\156\157\x74\x20\151\156\x69\164\x69\141\x74\x65\x20\123\x53\x4f\x2e";
        $i6 = '';
        $vU = "\123\x53\117\40\x69\163\40\156\x6f\x74\x20\x65\156\141\x62\154\x65\144\x2e";
        Utilities::showErrorMessage($am, $i6, $vU, TRUE);
        return new Response();
        LI:
        \Drupal::service("\x70\141\147\145\137\x63\141\x63\x68\145\137\153\151\x6c\154\x5f\163\167\x69\x74\143\150")->trigger();
        $I_ = $ll->get("\155\151\156\x69\x6f\162\x61\x6e\147\x65\137\x73\x61\155\x6c\x5f\x64\145\146\141\165\x6c\164\137\162\145\154\141\171\x73\x74\141\164\145");
        $ca = $ll->get("\155\151\156\x69\157\x72\x61\x6e\147\x65\x5f\163\141\x6d\154\x5f\x72\145\x71\x75\145\x73\x74\137\163\151\147\x6e\x65\144");
        $xa = $ll->get("\x73\145\x63\x75\162\x69\x74\171\137\163\151\x67\x6e\141\x74\165\x72\145\137\x61\154\147\157\x72\151\164\x68\155");
        $DA = $ll->get("\x6d\x69\156\151\x6f\x72\x61\x6e\x67\x65\x5f\x73\141\x6d\154\137\150\x74\164\160\137\142\151\156\x64\151\x6e\x67");
        $f5 = isset($_REQUEST["\144\145\163\164\x69\x6e\141\x74\151\x6f\156"]) ? trim($_REQUEST["\144\145\x73\164\151\156\141\x74\x69\157\x6e"], "\47") : '';
        if (empty($z5)) {
            goto hV;
        }
        $f5 = $z5;
        hV:
        if (!empty($f5)) {
            goto p1;
        }
        $f5 = $I_;
        p1:
        if (!empty($f5)) {
            goto iz;
        }
        $f5 = $xL;
        iz:
        if (!(empty($f5) && isset($_SERVER["\x48\x54\124\120\x5f\122\x45\x46\x45\x52\105\x52"]))) {
            goto xN;
        }
        $f5 = $_SERVER["\110\124\x54\x50\x5f\x52\105\106\x45\x52\x45\x52"];
        xN:
        if (!empty($f5)) {
            goto TL;
        }
        $f5 = Utilities::getBaseUrl();
        TL:
        $Ww = Utilities::getAcsUrl();
        $DR = $ll->get("\x6d\x69\x6e\151\157\162\141\x6e\147\x65\x5f\163\141\x6d\x6c\137\151\x64\160\x5f\154\x6f\147\151\x6e\137\x75\x72\154");
        $Kh = $ll->get("\x6d\x69\156\x69\157\162\141\x6e\x67\x65\137\163\141\x6d\154\x5f\156\x61\155\145\x69\144\137\x66\x6f\162\x6d\x61\x74");
        $lW = new MiniOrangeAuthnRequest();
        $lW->initiateLogin($Ww, $DR, Utilities::getIssuer(), $f5, $Kh, $DA, $ca, $xa);
        return new Response();
    }
    public static function create(ContainerInterface $ly)
    {
        return new static($ly->get("\146\x6f\x72\155\137\x62\x75\151\x6c\144\x65\162"));
    }
    public function saml_response()
    {
        global $base_url;
        global $JA;
        if (isset($_GET["\x53\101\115\114\x52\145\163\x70\x6f\x6e\163\145"])) {
            goto oV;
        }
        $ll = \Drupal::config("\x6d\x69\156\x69\x6f\162\x61\x6e\x67\x65\x5f\163\141\155\x6c\56\x73\x65\x74\x74\151\x6e\147\163");
        $qi = $ll->get("\155\x69\156\151\x6f\162\x61\156\x67\x65\137\x73\x61\155\x6c\x5f\143\165\163\x74\157\x6d\x5f\x61\164\x74\x72\163\137\155\x61\x70\137\x61\x72\162") !== NULL ? json_decode($ll->get("\155\x69\x6e\x69\x6f\x72\141\156\x67\145\x5f\x73\x61\x6d\154\137\x63\x75\163\x74\157\x6d\x5f\x61\x74\x74\x72\163\x5f\x6d\x61\160\x5f\x61\x72\162"), true) : [];
        $B0 = new MiniOrangeAcs();
        $m8 = $ll->get("\155\151\156\x6f\162\x61\156\x67\145\137\x73\141\x6d\x6c\x5f\x63\165\x73\164\157\x6d\x65\x72\x5f\141\144\x6d\151\x6e\x5f\x66\x72\141\x75\x64\x5f\x63\x68\x65\x63\153");
        $td = $ll->get("\x6d\151\x6e\151\157\x72\141\156\147\x65\137\x73\141\155\x6c\137\143\x75\163\164\157\155\145\162\137\x61\x64\155\151\x6e\137\x74\157\x6b\145\156");
        $gR = $ll->get("\155\151\156\x69\x6f\162\x61\x6e\147\x65\137\163\x61\155\154\137\x63\x75\163\x74\157\155\145\162\137\141\144\155\151\156\x5f\x65\155\141\x69\x6c");
        $Cq = \Drupal::request()->server->get("\x44\x4f\x43\x55\x4d\105\x4e\x54\137\122\x4f\x4f\124") . $JA;
        $QN = trim($base_url, "\57");
        if (preg_match("\43\x5e\x68\164\164\x70\50\x73\x29\77\x3a\57\57\43", $QN)) {
            goto bY;
        }
        $QN = "\150\x74\x74\160\x3a\57\x2f" . $QN;
        bY:
        $CO = parse_url($QN);
        $Bu = isset($CO["\x70\x61\x74\150"]) ? $CO["\x70\x61\164\150"] : '';
        $Iw = preg_replace("\57\136\167\x77\167\134\x2e\x2f", '', $CO["\x68\x6f\x73\x74"] . $Bu);
        $Br = $Cq . $Iw;
        $sq = $ll->get("\x6d\x69\x6e\151\x6f\x72\141\x6e\147\x65\x5f\x73\x61\x6d\x6c\137\x69\163\x4d\165\154\x74\151\123\x69\164\x65\120\154\165\x67\x69\x6e\x52\x65\x71\x75\145\x73\164\145\144") == true;
        if (($sq || $Br == AESEncryption::decrypt_data($m8, $td) || $Br == AESEncryption::decrypt_data($m8, $td, "\x41\105\x53\x2d\x31\62\70\x2d\x45\x43\x42")) && $gR != null && $gR != '') {
            goto Mh;
        }
        if ($gR != null && $gR != '') {
            goto QF;
        }
        if (!($gR == null || $gR == '')) {
            goto Zb;
        }
        $am = "\x59\x6f\x75\x20\x61\162\x65\x20\x6e\157\164\x20\x6c\x6f\147\x67\145\x64\x20\x69\x6e\x2e";
        $i6 = "\x50\x6c\x65\141\163\x65\40\x6c\x6f\147\151\x6e\40\146\x69\162\x73\164\x20\x74\x6f\x20\141\143\164\x69\x76\141\164\x65\x20\x73\x69\156\x67\154\145\x20\163\151\x67\156\x20\x6f\156\x2e";
        $vU = "\115\x61\x6b\145\x20\x73\165\x72\x65\40\171\157\165\40\x68\141\x76\x65\x20\154\157\147\x67\x65\144\x20\151\156\x2f\x20\x52\x65\147\151\163\x74\x65\x72\40\x69\x6e\40\164\x6f\x20\x6d\157\144\x75\154\145\56";
        Utilities::showErrorMessage($am, $i6, $vU);
        Zb:
        goto HQ;
        QF:
        if (isset($_POST["\122\x65\154\x61\171\123\164\x61\164\x65"]) && $_POST["\x52\145\x6c\x61\171\123\164\x61\164\x65"] == "\x74\145\163\164\x56\141\x6c\151\x64\141\x74\x65") {
            goto mK;
        }
        $am = "\127\145\x20\x63\157\165\154\144\40\156\157\164\40\x73\x69\x67\x6e\40\x79\157\165\40\x69\156\x2e";
        $i6 = "\x50\154\145\141\x73\145\x20\103\x6f\x6e\164\x61\x63\x74\40\171\x6f\165\162\40\141\144\155\x69\x6e\x69\x73\164\162\141\164\x6f\162\56";
        Utilities::showErrorMessage($am, $i6, "\55");
        goto zB;
        mK:
        $am = "\x4c\151\x63\x65\156\x73\145\x20\153\145\x79\40\171\157\165\x20\150\141\x76\145\40\x65\156\x74\x65\162\x65\144\40\x68\x61\163\x20\141\154\x72\x65\x61\144\x79\40\142\145\145\156\40\165\163\145\x64\x2e";
        $i6 = "\x50\154\x65\141\163\x65\x20\x65\x6e\x74\145\x72\x20\141\40\x6b\x65\x79\40\x77\150\151\143\150\x20\150\141\163\x20\156\x6f\x74\40\x62\x65\x65\156\x20\x75\163\x65\144\x20\142\145\x66\x6f\162\x65\40\x6f\x6e\40\x61\156\x79\40\157\x74\150\145\x72\40\151\156\163\164\141\x6e\143\x65\40\x6f\x72\x20\x69\146\x20\171\157\x75\x20\150\x61\166\x65\40\x65\170\141\165\163\x74\x65\x64\40\x61\154\154\x20\x79\157\165\162\x20\153\145\171\163\x20\x74\x68\x65\x6e\x20\142\165\171\40\155\157\162\145\40\154\x69\x63\145\x6e\163\145\x20\146\162\x6f\155\x20\114\151\x63\145\156\163\151\x6e\147\56";
        Utilities::showErrorMessage($am, $i6, "\x2d");
        zB:
        HQ:
        goto kE;
        Mh:
        \Drupal::moduleHandler()->invokeAll("\x66\x6f\162\x77\x61\x72\x64\x5f\162\x65\x73\160\157\156\163\x65", [$_POST]);
        $K4 = $B0->processSamlResponse($_POST, $qi);
        $ld = $K4["\x72\145\x73\x70\x6f\156\x73\145"];
        $fV = $K4["\x72\145\163\x6f\x75\162\x63\145\x73"];
        kE:
        if (!(MiniorangeSAMLConstants::PLUGIN_VERSION == MiniorangeSAMLConstants::ENTERPRISE_VERSION && \Drupal\miniorange_saml\HigherUtilities::Is_Restricted_Domain($ld["\145\x6d\x61\x69\154"]) === TRUE)) {
            goto SJ;
        }
        $am = "\131\157\165\x20\x61\x72\145\40\156\157\164\x20\x61\154\x6c\x6f\x77\x65\144\40\x74\157\x20\x6c\157\x67\x69\156\40";
        $i6 = "\x50\154\x65\141\163\x65\x20\x43\x6f\x6e\164\141\x63\x74\x20\x79\x6f\x75\x72\40\141\x64\x6d\x69\x6e\x69\x73\x74\162\x61\164\x6f\x72\56";
        $vU = "\x59\x6f\165\x72\x20\144\x6f\x6d\141\x69\156\x20\x6d\x61\171\40\142\x65\x20\142\154\157\x63\x6b\145\144\x20\x62\171\40\141\x64\155\x69\x6e";
        Utilities::showErrorMessage($am, $i6, $vU);
        SJ:
        if ($ll->get("\155\x69\156\151\x6f\x72\x61\156\147\145\x5f\x73\141\x6d\154\x5f\x6c\157\x61\x64\x5f\165\x73\x65\x72") == 1) {
            goto GR;
        }
        $dJ = user_load_by_name($ld["\x75\x73\x65\x72\x6e\141\x6d\145"]);
        goto Bv;
        GR:
        $dJ = user_load_by_mail($ld["\x65\x6d\141\x69\154"]);
        Bv:
        $F2 = 0;
        if (!($dJ == NULL)) {
            goto U6;
        }
        $zP = $ll->get("\155\x69\x6e\x69\157\x72\141\x6e\147\145\137\163\x61\x6d\x6c\x5f\144\151\163\141\x62\154\145\137\x61\165\164\157\x63\x72\x65\141\x74\145\x5f\x75\x73\145\x72\163");
        if ($zP) {
            goto c7;
        }
        $G5 = \Drupal::service("\x70\x61\163\163\x77\157\x72\x64\137\x67\x65\x6e\145\x72\x61\x74\x6f\162")->generate(8);
        $nJ = $ll->get("\155\x69\156\151\x6f\162\x61\156\147\x65\137\x73\141\155\154\137\x64\145\x66\x61\165\x6c\164\137\x72\x6f\x6c\x65");
        $v4 = ["\156\141\155\x65" => $ld["\165\163\x65\162\156\x61\x6d\145"], "\155\141\x69\x6c" => $ld["\145\155\141\151\154"], "\160\x61\163\x73" => $G5, "\x73\164\141\164\x75\163" => 1];
        $dJ = User::create($v4);
        $dJ->save();
        if (!($nJ != "\x61\165\164\150\x65\x6e\x74\x69\x63\141\x74\x65\144" && $ll->get("\155\151\156\x69\157\162\141\156\x67\145\137\163\141\x6d\154\x5f\x65\156\141\x62\154\x65\137\x72\157\154\145\x6d\141\160\160\151\156\x67"))) {
            goto Dw;
        }
        $dJ->addRole($nJ);
        $dJ->save();
        Dw:
        goto Je;
        c7:
        $am = "\x41\143\143\157\165\156\x74\40\x64\157\x65\163\40\x6e\157\164\x20\145\170\151\x73\x74\40\167\151\x74\150\40\171\x6f\x75\x72\x20\x75\x73\145\x72\x6e\141\x6d\x65\56";
        $i6 = "\120\x6c\x65\x61\163\145\x20\103\157\156\x74\141\x63\x74\x20\x79\x6f\165\162\x20\x61\x64\155\x69\156\151\x73\164\162\x61\164\157\162\56";
        $vU = "\x41\165\164\157\x20\143\162\x65\141\x74\151\157\x6e\x20\x6f\x66\x20\165\163\x65\162\x20\151\x73\x20\x6e\x6f\164\x20\x61\154\154\x6f\167\x65\144\40\151\x66\x20\165\163\x65\x72\x20\x64\157\145\163\x20\156\157\x74\x20\145\170\x69\x73\164\x2e";
        Utilities::showErrorMessage($am, $i6, $vU);
        Je:
        U6:
        $iq = array();
        $iq = $ld["\x63\x75\x73\164\157\x6d\x46\151\x65\x6c\144\x41\x74\x74\x72\x69\142\165\x74\x65\163"];
        $dJ = User::load($dJ->id());
        $J0 = $ll->get("\x6d\151\x6e\151\x6f\162\x61\x6e\x67\x65\x5f\x73\x61\x6d\154\137\143\165\x73\164\157\155\137\141\164\x74\x72\163\x5f\x6d\x61\x70\x5f\163\x65\160") !== NULL ? json_decode($ll->get("\x6d\151\x6e\151\157\x72\x61\156\147\145\x5f\163\141\x6d\x6c\x5f\143\x75\163\x74\157\155\x5f\141\164\164\162\163\x5f\x6d\x61\x70\x5f\163\x65\160")) : '';
        foreach ($iq as $C2 => $hs) {
            $lS = $dJ->get($C2);
            $iy = $lS->getFieldDefinition();
            $q0 = $iy->getFieldStorageDefinition();
            if ($q0->getType() === "\x65\x6e\x74\151\164\x79\x5f\x72\145\146\145\x72\x65\156\143\145") {
                goto yM;
            }
            if (Utilities::isMultiple($C2) && !is_null($J0->{$C2})) {
                goto Vh;
            }
            if (!self::isBooleanField($C2)) {
                goto ds;
            }
            $hs = filter_var($hs, FILTER_VALIDATE_BOOLEAN);
            ds:
            $MZ = array($hs);
            goto is;
            Vh:
            $MZ = explode($J0->{$C2}, $hs);
            is:
            $dJ->get($C2)->setValue($MZ);
            $dJ->save();
            goto E_;
            yM:
            $So = $q0->getSetting("\164\x61\x72\147\x65\x74\137\164\x79\x70\x65");
            $Wa = $iy->getSetting("\x68\141\156\x64\x6c\145\x72\137\x73\x65\164\164\x69\x6e\x67\163");
            $j1 = \Drupal::entityTypeManager()->getStorage($So)->loadMultiple(NULL);
            if (!isset($Wa["\164\x61\162\x67\145\x74\137\x62\x75\x6e\144\x6c\145\163"])) {
                goto Nq;
            }
            if (Utilities::isMultiple($C2) && !is_null($J0->{$C2})) {
                goto Rn;
            }
            $MZ = array($hs);
            goto Us;
            Rn:
            $MZ = explode($J0->{$C2}, $hs);
            Us:
            $gf = [];
            $Ql = [];
            foreach ($MZ as $hs) {
                $j1 = \Drupal::entityTypeManager()->getStorage($So)->loadByProperties(["\156\x61\155\145" => $hs]);
                $Or = false;
                foreach ($j1 as $KX) {
                    if (!in_array($KX->bundle(), $Wa["\x74\x61\162\147\145\x74\137\142\x75\x6e\144\154\x65\163"])) {
                        goto BZ;
                    }
                    $gf[] = $KX->id();
                    $Or = true;
                    BZ:
                    cA:
                }
                fz:
                if ($Or) {
                    goto pb;
                }
                $Ql[] = $hs;
                pb:
                Uo:
            }
            He:
            $b2 = isset($Wa["\x61\x75\164\x6f\137\143\x72\145\141\164\145"]) ? $Wa["\x61\x75\x74\x6f\x5f\x63\x72\145\141\x74\145"] : false;
            $NL = isset($Wa["\141\x75\164\157\x5f\143\x72\145\141\x74\145\x5f\x62\x75\156\144\154\x65"]) ? $Wa["\x61\165\164\157\137\143\x72\145\x61\164\145\x5f\x62\x75\156\144\x6c\x65"] : '';
            if (!($b2 && $So == "\x74\141\x78\x6f\156\157\x6d\x79\x5f\x74\145\x72\x6d")) {
                goto U5;
            }
            foreach ($Ql as $TC) {
                $o8 = Term::create(["\x6e\141\x6d\x65" => $TC, "\x76\x69\x64" => $NL]);
                $o8->save();
                $gf[] = $o8->id();
                cn:
            }
            yt:
            U5:
            $lS->setValue($gf);
            $dJ->save();
            Nq:
            E_:
            WM:
        }
        jX:
        if (!(!is_null($dJ) && $ll->get("\x6d\x69\x6e\x69\x6f\162\x61\x6e\147\x65\137\x73\x61\x6d\154\137\145\x6e\x61\x62\x6c\x65\137\162\x6f\x6c\145\x6d\141\x70\160\x69\156\x67"))) {
            goto l9;
        }
        $ip = $ll->get("\155\x69\156\x69\157\162\x61\x6e\x67\x65\137\x73\x61\x6d\154\137\x72\x6f\154\145\x5f\x6d\141\x70\160\x69\156\x67\x5f\141\x72\x72") != null ? (array) json_decode($ll->get("\155\x69\156\x69\x6f\162\x61\x6e\x67\x65\137\163\141\155\154\x5f\x72\157\x6c\x65\x5f\x6d\141\x70\x70\151\156\147\x5f\x61\x72\162")) : [];
        $y9 = $ll->get("\x6d\151\156\151\157\x72\141\x6e\147\145\x5f\163\141\x6d\x6c\x5f\x72\x6f\x6c\145\x5f\x61\x74\x74\x72\137\x73\x65\x70\x61\x72\141\x74\157\162");
        $yI = $ld["\x63\165\163\x74\157\155\x46\151\145\x6c\x64\122\157\x6c\x65\163"];
        $eF = \Drupal::configFactory()->getEditable("\155\151\156\x69\x6f\x72\x61\156\147\x65\x5f\163\x61\155\154\56\163\x65\164\164\x69\x6e\147\163")->get("\x6d\151\156\151\157\x72\141\x6e\147\145\x5f\163\x61\155\x6c\x5f\x64\151\163\x61\x62\154\x65\x5f\162\x6f\x6c\x65\137\x75\x70\144\141\164\x65");
        $JC = $dJ->getRoles();
        if (!(!empty($y9) && str_contains($yI[0], $y9))) {
            goto zN;
        }
        $yI[0] = self::removeBracketsForRoleMapping($yI[0]);
        $yI = explode($y9, $yI[0]);
        zN:
        if ($eF) {
            goto Jp;
        }
        foreach ($JC as $C2 => $hs) {
            if (in_array($hs, array_keys($ip))) {
                goto Ox;
            }
            if (!($hs != $ll->get("\155\151\x6e\151\x6f\x72\141\156\x67\145\137\163\141\155\154\137\144\145\x66\x61\x75\x6c\164\x5f\x72\157\154\145"))) {
                goto ha;
            }
            $dJ->removeRole($hs);
            $dJ->save();
            ha:
            Ox:
            Rf:
        }
        Ze:
        Jp:
        foreach ($ip as $C2 => $hs) {
            $HB = FALSE;
            $G2 = array();
            $Fi = explode("\73", $hs);
            foreach ($Fi as $Sa => $OD) {
                set_error_handler(function ($w7, $KK, $em, $n3) {
                });
                $QH = preg_match($OD, '');
                restore_error_handler();
                $jc = !is_bool($QH);
                if (!is_array($yI)) {
                    goto lN;
                }
                if ($jc) {
                    goto YR;
                }
                if (in_array($OD, $yI)) {
                    goto yl;
                }
                goto TI;
                YR:
                $G2 = preg_grep($OD, $yI);
                if (empty($G2)) {
                    goto pa;
                }
                $HB = TRUE;
                pa:
                goto TI;
                yl:
                $HB = TRUE;
                TI:
                lN:
                Xj:
            }
            m2:
            if ($HB && $C2 != "\141\x75\x74\150\145\156\164\x69\143\x61\x74\x65\144") {
                goto dJ;
            }
            if (!$eF) {
                goto Dq;
            }
            goto fP;
            dJ:
            $dJ->addRole($C2);
            $dJ->save();
            goto fP;
            Dq:
            $dJ->removeRole($C2);
            $dJ->save();
            fP:
            OU:
        }
        TJ:
        l9:
        $Go = $ll->get("\x6d\151\x6e\x69\157\x72\141\x6e\x67\145\x5f\x73\x61\x6d\x6c\x5f\145\x6e\x61\x62\154\x65\137\x70\162\x6f\x66\x69\154\145\x5f\x6d\x61\160\160\x69\156\147");
        if (!(MiniorangeSAMLConstants::PLUGIN_VERSION == MiniorangeSAMLConstants::ENTERPRISE_VERSION && $Go)) {
            goto Wi;
        }
        HigherUtilities::profileFieldMapping($dJ, $fV);
        Wi:
        if (user_is_blocked($ld["\165\x73\145\x72\x6e\x61\x6d\x65"]) == FALSE) {
            goto kw;
        }
        $am = "\x55\163\145\162\x20\102\154\x6f\x63\x6b\x65\x64\40\102\171\40\x41\144\155\151\156\x69\163\x74\162\141\x74\x6f\162\56";
        $i6 = "\x50\x6c\x65\141\x73\145\x20\103\157\x6e\164\x61\x63\x74\x20\171\157\165\x72\x20\141\144\x6d\151\156\x69\163\164\x72\141\x74\157\162\x2e";
        $vU = "\x54\x68\x69\163\x20\x75\x73\x65\x72\x20\141\143\143\x6f\x75\156\x74\x20\151\163\40\x6e\x6f\x74\40\141\x6c\x6c\x6f\167\x65\x64\x20\x74\x6f\x20\154\x6f\x67\151\156\x2e";
        Utilities::showErrorMessage($am, $i6, $vU);
        return new Response();
        goto Uj;
        kw:
        if (!(array_key_exists("\x72\145\154\141\171\x5f\163\x74\141\x74\145", $ld) && !empty($ld["\162\x65\154\141\x79\x5f\163\164\x61\164\x65"]))) {
            goto jT;
        }
        $aQ = $ld["\162\x65\x6c\x61\171\137\x73\164\141\x74\145"];
        jT:
        $v2 = Utilities::getBaseUrl();
        if (!(empty($aQ) || $aQ == "\57")) {
            goto QO;
        }
        $aQ = $v2;
        QO:
        \Drupal::moduleHandler()->invokeAll("\151\156\x76\157\153\x65\137\x6d\x69\x6e\x69\157\x72\x61\x6e\x67\145\x5f\62\x66\141\x5f\x62\145\146\x6f\162\x65\x5f\x6c\157\147\x69\156", [$dJ]);
        \Drupal::moduleHandler()->invokeAll("\x6d\151\x6e\x69\x6f\162\141\156\x67\145\x5f\x73\x61\155\x6c\137\151\x64\160\x5f\x72\x65\163\157\165\162\x63\x65\163", [$dJ, $fV]);
        user_login_finalize($dJ);
        $_SESSION["\163\x65\x73\x73\151\157\156\x49\156\144\145\170"] = $ld["\x73\145\163\163\x69\x6f\156\111\156\144\145\x78"];
        $_SESSION["\116\141\155\x65\x49\104"] = $ld["\116\x61\155\145\x49\x44"];
        $_SESSION["\x6d\157\x5f\x73\x61\x6d\154"]["\x6c\157\x67\147\x65\x64\137\151\x6e\137\167\151\x74\150\x5f\151\x64\160"] = TRUE;
        if (!($ll->get("\x6d\x69\x6e\151\x6f\x72\x61\x6e\147\x65\137\163\141\x6d\x6c\137\162\145\163\x74\x72\x69\x63\x74\x5f\x72\x65\x64\151\x72\x65\143\164\137\157\x75\x74\x73\151\x64\145\137\144\157\155\141\x69\x6e") == TRUE)) {
            goto ld;
        }
        $DV = parse_url($aQ);
        $tR = parse_url($v2);
        $As = isset($tR["\150\x6f\x73\164"]) ? $tR["\150\157\x73\164"] : FALSE;
        $Dj = isset($DV["\x68\x6f\163\x74"]) ? $DV["\150\x6f\x73\x74"] : FALSE;
        if (!($Dj !== FALSE && $As !== $Dj)) {
            goto L9;
        }
        $ES = $aQ;
        $aQ = $v2;
        $NS = $ll->get("\x6d\151\156\151\157\x72\141\156\x67\145\x5f\x73\141\x6d\x6c\137\x77\x68\151\x74\x65\154\151\163\x74\x5f\144\157\155\x61\151\156\163");
        $BN = explode("\x3b", $NS);
        foreach ($BN as $Np) {
            if (!($Np == '' or $Np == "\x2f")) {
                goto UA;
            }
            goto hR;
            UA:
            if (!(strpos($Dj, trim($Np)) !== false)) {
                goto Uy;
            }
            $aQ = $ES;
            goto Vd;
            Uy:
            hR:
        }
        Vd:
        L9:
        ld:
        $ld = new RedirectResponse($aQ);
        $FA = \Drupal::request();
        $FA->getSession()->save();
        $ld->prepare($FA);
        \Drupal::service("\x6b\145\162\156\145\x6c")->terminate($FA, $ld);
        $ld->send();
        exit;
        return new Response();
        Uj:
        goto G3;
        oV:
        $FA = \Drupal::request();
        $FA->getSession()->clear();
        $ld = new RedirectResponse(Utilities::getBaseUrl());
        $ld->send();
        return new Response();
        G3:
        return new Response();
    }
    static function saml_logout()
    {
        $ll = \Drupal::config("\155\151\x6e\151\157\162\x61\156\x67\x65\x5f\163\141\x6d\154\56\163\x65\x74\164\151\x6e\147\x73");
        $xa = $ll->get("\x73\x65\143\x75\162\151\164\171\x5f\x73\151\147\x6e\x61\x74\x75\162\145\137\x61\x6c\147\157\162\x69\x74\150\x6d");
        $UR = Utilities::getBaseUrl();
        $s2 = Utilities::getRedirectUrAfterLogout($UR);
        $O6 = $ll->get("\x6d\151\156\151\x6f\162\141\x6e\x67\x65\137\x73\x61\x6d\154\137\x69\144\x70\137\154\x6f\x67\157\165\164\x5f\x75\162\154");
        $Ok = $ll->get("\x6d\x69\x6e\x69\157\x72\141\x6e\x67\145\x5f\163\141\x6d\x6c\x5f\x73\x6c\157\x5f\x68\x74\164\160\137\142\x69\156\x64\x69\156\147");
        if (!empty($O6)) {
            goto zV;
        }
        $FA = \Drupal::request();
        $FA->getSession()->clear();
        $ld = new RedirectResponse($s2);
        $ld->send();
        return new Response();
        goto Hx;
        zV:
        if (!\Drupal::service("\163\x65\x73\163\151\157\x6e")->getId() || \Drupal::service("\x73\145\163\x73\x69\x6f\156")->getId() == '' || !isset($_SESSION)) {
            goto qx;
        }
        if (!isset($_SESSION["\155\x6f\137\x73\x61\x6d\154"]["\154\157\x67\x67\x65\144\x5f\151\156\137\167\x69\164\150\137\x69\144\x70"])) {
            goto L3;
        }
        unset($_SESSION["\x6d\157\137\x73\141\x6d\x6c"]);
        $q5 = $_SESSION["\163\x65\x73\163\151\157\156\111\x6e\x64\145\170"];
        $bu = $_SESSION["\x4e\141\155\145\111\104"];
        Utilities::checkIfLogoutRequest($_REQUEST, $_GET);
        $Fx = $UR;
        $ua = Utilities::createLogoutRequest($bu, Utilities::getIssuer(), $O6, $Ok, $q5);
        $ca = $ll->get("\155\151\x6e\x69\x6f\162\x61\156\x67\145\x5f\x73\141\155\154\x5f\x72\x65\x71\165\x65\163\x74\137\163\151\147\156\x65\x64");
        if (empty($Ok) || $Ok == "\x48\x54\124\x50\x2d\x52\x65\x64\151\x72\x65\x63\164") {
            goto F6;
        }
        if ($ca) {
            goto IC;
        }
        $Cn = base64_encode($ua);
        Utilities::postSAMLRequest($O6, $Cn, $Fx);
        exit;
        IC:
        $Cn = Utilities::signXML($ua, Utilities::getPublicCertificate(), Utilities::getPrivateKey(), $xa, "\x4e\141\155\x65\111\x44");
        Utilities::postSAMLRequest($O6, $Cn, $Fx);
        goto uc;
        F6:
        $ua = "\x53\x41\x4d\x4c\x52\145\x71\x75\x65\163\164\75" . $ua . "\46\x52\x65\154\x61\x79\x53\x74\141\164\x65\x3d" . urlencode($Fx);
        $oa = $O6;
        if (strpos($O6, "\x3f") !== false) {
            goto Fs;
        }
        $oa .= "\77";
        goto r4;
        Fs:
        $oa .= "\46";
        r4:
        if (!$ca) {
            goto Qx;
        }
        if ($xa == "\x52\x53\x41\137\123\110\101\62\x35\x36") {
            goto xW;
        }
        if ($xa == "\x52\x53\101\137\x53\x48\x41\x33\x38\64") {
            goto gI;
        }
        if ($xa == "\122\123\x41\x5f\123\x48\101\65\x31\62") {
            goto Az;
        }
        if ($xa == "\x52\x53\101\137\123\110\101\x31") {
            goto qt;
        }
        goto bl;
        xW:
        $ua .= "\x26\x53\151\x67\101\154\x67\75" . urlencode(XMLSecurityKey::RSA_SHA256);
        goto bl;
        gI:
        $ua .= "\x26\123\151\147\101\154\147\x3d" . urlencode(XMLSecurityKey::RSA_SHA384);
        goto bl;
        Az:
        $ua .= "\x26\123\x69\147\x41\154\147\75" . urlencode(XMLSecurityKey::RSA_SHA512);
        goto bl;
        qt:
        $ua .= "\x26\123\151\147\x41\x6c\147\75" . urlencode(XMLSecurityKey::RSA_SHA1);
        bl:
        $V4 = array("\x74\x79\x70\145" => "\160\x72\x69\x76\x61\x74\x65");
        $C2 = new XMLSecurityKey(XMLSecurityKey::RSA_SHA256, $V4);
        if ($xa == "\x52\x53\x41\137\x53\x48\x41\63\70\64") {
            goto xU;
        }
        if ($xa == "\122\123\x41\137\123\x48\x41\x35\61\x32") {
            goto gM;
        }
        if ($xa == "\122\x53\x41\x5f\123\110\101\x31") {
            goto nu;
        }
        goto u_;
        xU:
        $C2 = new XMLSecurityKey(XMLSecurityKey::RSA_SHA384, $V4);
        goto u_;
        gM:
        $C2 = new XMLSecurityKey(XMLSecurityKey::RSA_SHA512, $V4);
        goto u_;
        nu:
        $C2 = new XMLSecurityKey(XMLSecurityKey::RSA_SHA1, $V4);
        u_:
        $C2->loadKey(Utilities::getPrivateKey(), FALSE);
        $Pz = new XMLSecurityDSig();
        $Tv = $C2->signData($ua);
        $Tv = base64_encode($Tv);
        $oa .= $ua . "\46\x53\151\x67\156\x61\164\x75\162\x65\75" . urlencode($Tv);
        if ($ll->get("\155\x69\156\x69\157\x72\141\x6e\147\145\137\x73\141\x6d\x6c\x5f\x73\x65\156\144\x5f\163\x6c\x6f\137\151\x6e\137\151\146\162\141\x6d\145")) {
            goto Cb;
        }
        header("\114\x6f\143\x61\x74\x69\x6f\156\72\x20" . $oa);
        exit;
        goto rD;
        Cb:
        echo "\x3c\x69\146\162\141\155\x65\x20\x69\x64\x3d\x27\155\157\137\x73\x61\x6d\154\137\x69\x66\162\x61\x6d\x65\137\x73\154\157\47\40\x73\x72\x63\x3d\47" . $oa . "\47\x20\x73\164\171\154\145\75\47\160\x6f\163\x69\x74\x69\157\156\72\x20\x61\142\163\x6f\x6c\165\x74\x65\73\40\150\x65\151\x67\150\x74\72\x20\60\x3b\40\167\151\144\164\150\x3a\40\60\x3b\x20\x62\157\x72\144\x65\x72\x3a\x20\x30\x3b\x27\40\76\x3c\57\x69\x66\162\x61\x6d\145\76";
        exit;
        rD:
        goto Vt;
        Qx:
        $oa .= $ua;
        if ($ll->get("\x6d\x69\x6e\x69\157\x72\x61\156\x67\x65\137\163\141\155\154\x5f\x73\145\x6e\x64\x5f\163\154\x6f\x5f\x69\156\x5f\x69\146\x72\x61\155\145")) {
            goto fF;
        }
        $ld = new RedirectResponse($oa);
        $ld->send();
        return new Response();
        goto R4;
        fF:
        echo "\x3c\x69\146\x72\x61\x6d\x65\x20\151\x64\75\47\155\157\x5f\163\x61\x6d\154\137\151\x66\x72\x61\155\145\x5f\163\x6c\157\47\x20\163\162\143\75\47" . $oa . "\47\x20\163\x74\x79\154\145\75\47\x70\x6f\163\x69\x74\x69\157\x6e\x3a\40\141\142\163\157\154\x75\164\x65\x3b\x20\x68\x65\x69\147\150\164\72\40\x30\x3b\x20\x77\x69\x64\164\x68\72\x20\x30\73\x20\142\157\162\x64\x65\162\72\40\60\x3b\47\40\76\x3c\57\151\146\x72\x61\155\x65\x3e";
        exit;
        R4:
        Vt:
        uc:
        L3:
        $FA = \Drupal::request();
        $FA->getSession()->clear();
        if (!($ll->get("\155\x69\x6e\151\157\162\x61\x6e\147\145\x5f\163\141\155\x6c\137\163\145\x6e\144\x5f\163\x6c\157\137\x69\x6e\137\x69\x66\162\x61\x6d\145") && !isset($_GET["\146\151\156\x61\154"]))) {
            goto dh;
        }
        echo "\x3c\163\x63\162\151\160\x74\x3e\x20\x77\151\156\x64\x6f\167\56\164\157\x70\56\154\157\x63\141\x74\151\x6f\156\56\150\162\145\x66\40\75\x20\x27" . $UR . "\57\x75\163\145\x72\x2f\x6c\x6f\147\157\x75\x74\x3f\146\151\x6e\141\154\75\164\162\165\145\47\73\40\x3c\57\163\x63\162\x69\160\x74\76";
        exit;
        dh:
        $ld = new RedirectResponse($s2);
        $ld->send();
        return new Response();
        goto eJ;
        qx:
        session_start();
        return new Response();
        eJ:
        Hx:
        return new Response();
    }
    function test_configuration()
    {
        self::saml_login('', "\x74\x65\163\x74\x56\x61\x6c\151\x64\x61\x74\x65");
        return new Response();
    }
    function saml_request()
    {
        $Qi = \Drupal::config("\x6d\151\x6e\x69\x6f\162\x61\156\147\x65\137\x73\x61\x6d\x6c\x2e\x73\x65\x74\164\151\156\147\163")->get("\x6d\151\x6e\x69\157\162\x61\x6e\147\145\x5f\163\x61\155\x6c\137\x69\x64\160\137\154\x6f\147\151\156\x5f\x75\x72\154");
        $Kh = \Drupal::config("\x6d\151\156\151\x6f\162\x61\x6e\147\145\x5f\x73\x61\x6d\x6c\56\163\x65\164\164\151\x6e\x67\163")->get("\155\151\x6e\x69\157\162\x61\x6e\147\x65\137\163\141\x6d\x6c\x5f\x6e\x61\x6d\x65\x69\x64\137\146\x6f\162\x6d\141\x74");
        $UQ = Utilities::createAuthnRequest(Utilities::getAcsUrl(), Utilities::getIssuer(), $Kh, $Qi, "\x48\124\x54\x50\55\120\117\123\124", "\x66\x61\x6c\x73\145");
        $Fx = "\144\x69\163\x70\154\x61\x79\123\101\x4d\114\122\x65\x71\165\x65\x73\164";
        $ca = \Drupal::config("\155\x69\156\151\157\x72\x61\x6e\x67\x65\137\163\x61\x6d\x6c\56\163\145\164\x74\151\156\147\x73")->get("\x6d\x69\156\x69\x6f\162\x61\156\147\x65\x5f\x73\x61\x6d\x6c\x5f\162\145\x71\x75\x65\163\x74\x5f\163\151\x67\x6e\145\x64");
        $xa = \Drupal::config("\155\x69\x6e\151\x6f\x72\x61\156\147\145\137\163\x61\x6d\154\x2e\163\145\x74\x74\151\156\147\x73")->get("\x73\145\x63\165\162\x69\x74\171\137\163\151\147\156\141\x74\165\x72\145\137\141\x6c\147\157\x72\x69\164\150\155");
        if (!$ca) {
            goto lv;
        }
        $Cn = Utilities::signXML($UQ, Utilities::getPublicCertificate(), Utilities::getPrivateKey(), $xa, "\x4e\141\155\x65\111\x44\120\x6f\154\x69\143\x79");
        $UQ = base64_decode($Cn);
        lv:
        Utilities::Print_SAML_Request($UQ, $Fx);
        return new Response();
    }
    function saml_response_generator()
    {
        self::saml_login('', "\144\x69\163\x70\x6c\141\171\123\141\x6d\154\122\x65\x73\160\157\156\163\145");
        return new Response();
    }
    public function openModalForm()
    {
        $ld = new AjaxResponse();
        $QL = $this->formBuilder->getForm("\x5c\104\162\x75\x70\x61\154\x5c\155\x69\156\151\x6f\x72\141\156\x67\145\x5f\163\x61\x6d\154\134\x46\x6f\162\x6d\134\x4d\x69\x6e\x69\x6f\162\x61\156\147\x65\123\101\115\x4c\x52\x65\x6d\157\166\x65\114\151\x63\x65\x6e\163\x65");
        $ld->addCommand(new OpenModalDialogCommand("\x52\145\155\x6f\166\145\x20\x4c\x69\x63\145\156\x73\145\40\x4b\145\x79", $QL, ["\x77\151\x64\164\x68" => "\70\60\60"]));
        return $ld;
    }
    public static function moLicenseFetch($hs = "\x66\x65\164\x63\x68\114\x69\x63\x65\156\x73\x65\x4d\x61\156\x75\141\154\x6c\x79")
    {
        global $base_url;
        $gR = \Drupal::config("\155\151\156\x69\157\x72\141\156\147\x65\137\x73\x61\x6d\x6c\x2e\x73\x65\164\x74\151\x6e\x67\x73")->get("\155\x69\156\151\157\162\x61\156\147\145\x5f\x73\141\x6d\x6c\137\x63\165\163\x74\x6f\x6d\145\162\137\x61\x64\x6d\x69\156\137\x65\x6d\x61\151\154");
        $V5 = new MiniorangeSAMLCustomer($gR, NULL, NULL, NULL);
        $lH = $V5->ccl() !== NULL ? json_decode($V5->ccl(), true) : '';
        if (!empty($lH)) {
            goto uW;
        }
        if ($hs == "\146\x65\164\x63\x68\x4c\151\143\x65\156\163\x65\115\141\x6e\165\x61\x6c\x6c\171") {
            goto Yb;
        }
        \Drupal::logger("\155\151\156\151\157\x72\141\156\x67\x65\137\163\141\155\x6c")->error("\123\157\x6d\145\164\150\x69\156\x67\x20\167\x65\156\164\x20\167\162\x6f\x6e\147\40\x77\x68\x69\154\145\40\146\145\164\x63\150\151\x6e\147\x20\x6c\x69\x63\x65\156\163\145\x20\165\160\144\141\164\x65\x20\x69\x6e\40" . __FUNCTION__ . "\40\x28\154\x69\156\x65\40" . __LINE__ . "\x20\x6f\146\40" . __FILE__ . "\x29");
        return;
        goto UP;
        Yb:
        \Drupal::messenger()->addError(t("\x53\157\155\145\x74\x68\151\x6e\147\40\x77\x65\156\164\40\167\x72\157\x6e\147\40\167\x68\x69\154\145\x20\146\145\164\x63\x68\151\x6e\x67\x20\154\151\143\145\156\163\x65\40\x75\160\x64\x61\x74\x65"));
        $ld = new RedirectResponse($base_url . "\57\141\144\155\x69\x6e\57\143\157\x6e\x66\x69\x67\x2f\160\x65\x6f\x70\154\x65\x2f\x6d\151\156\151\157\162\141\x6e\147\145\137\163\141\x6d\154\x2f\143\x75\163\x74\157\155\145\162\137\x73\x65\164\x75\x70");
        return $ld->send();
        UP:
        uW:
        Utilities::mo_save_expiry_details($lH);
        $k1 = \Drupal::config("\x6d\x69\156\x69\x6f\162\141\156\x67\145\137\x73\x61\x6d\x6c\56\x73\145\x74\x74\151\x6e\x67\163")->get("\x6d\x69\156\151\x6f\x72\x61\x6e\x67\145\x5f\155\141\151\156\x74\x65\x6e\141\156\143\145\137\x65\x78\x70\x69\x72\171");
        $Xc = Utilities::getIsLicenseExpired($k1);
        if (!($Xc["\x4c\x69\143\145\156\163\x65\x41\x6c\162\145\x61\144\x79\105\170\160\151\162\145\144"] == true)) {
            goto dL;
        }
        \Drupal::logger("\x6d\151\156\151\157\162\x61\156\x67\x65\x5f\163\141\155\154")->error("\x59\157\165\x72\x20\x6d\x69\x6e\151\117\162\141\156\x67\x65\40\x53\x41\x4d\114\x20\123\x50\40\x6d\157\x64\x75\x6c\x65\x20\155\141\x69\156\x74\x65\156\141\x6e\x63\145\40\150\x61\163\40\145\x78\x70\x69\x72\145\144\56\x20\x54\150\x69\163\x20\x68\141\x73\40\x70\162\x65\x76\145\x6e\164\145\144\x20\171\157\x75\x20\x66\162\x6f\155\40\162\145\x63\145\151\166\x69\156\147\40\x61\x6e\x79\x20\x6d\157\x64\x75\x6c\145\40\x75\x70\144\141\x74\x65\x73\40\143\157\156\x74\x61\x69\156\x69\156\x67\40\x62\165\147\40\146\x69\x78\145\163\x2c\x20\156\145\x77\40\146\x65\x61\164\x75\162\x65\163\54\40\x61\x6e\x64\40\x65\166\x65\x6e\40\x63\x6f\x6d\x70\141\164\151\142\x69\154\x69\x74\171\40\x63\150\x61\x6e\147\x65\163\56\x20\120\x6c\x65\141\x73\145\x20\143\157\156\164\141\143\164\x20\x75\x73\x20\x6f\x6e\40\74\141\x20\150\x72\145\x66\x20\x3d\42\144\x72\165\x70\141\x6c\163\165\160\x70\157\x72\x74\100\170\145\x63\x75\x72\151\146\x79\x2e\143\x6f\x6d\x22\76\144\x72\x75\x70\141\x6c\163\165\x70\x70\157\162\x74\x40\170\145\143\x75\x72\151\x66\171\56\x63\157\x6d\74\x2f\141\x3e\x20\x74\x6f\40\162\x65\156\145\x77\40\x79\x6f\x75\x72\x20\x6d\141\x69\156\164\x65\156\x61\156\x63\x65\x2e");
        dL:
        if (!($hs == "\146\145\x74\x63\150\x4c\x69\x63\x65\156\x73\x65\115\x61\x6e\165\x61\154\154\x79")) {
            goto cV;
        }
        \Drupal::messenger()->addStatus(t("\x53\165\143\143\x65\163\163\146\165\x6c\154\x79\x20\x66\x65\164\x63\x68\x65\144\x20\164\150\x65\x20\154\151\143\145\x6e\163\145\40\x64\x65\x74\141\x69\154\x73"));
        $ld = new RedirectResponse($base_url . "\57\141\x64\155\x69\156\57\x63\x6f\156\x66\151\147\x2f\160\x65\x6f\160\154\x65\57\155\x69\156\151\157\162\141\156\x67\145\137\x73\141\155\x6c\57\x63\165\x73\x74\x6f\x6d\x65\162\137\163\x65\164\x75\x70");
        return $ld->send();
        cV:
    }
    function saml_metadata()
    {
        $ll = \Drupal::config("\x6d\x69\x6e\x69\x6f\x72\141\x6e\147\x65\x5f\163\141\x6d\154\x2e\x73\145\x74\x74\x69\156\147\163");
        $UR = Utilities::getBaseUrl();
        $rk = Utilities::getIssuer();
        $Ww = Utilities::getAcsUrl();
        $D9 = Utilities::getPublicCertificate();
        $VZ = preg_replace("\57\133\xd\12\135\53\57", '', $D9);
        $VZ = str_replace("\55\55\55\55\55\102\x45\x47\111\x4e\x20\x43\x45\122\124\x49\x46\111\103\101\124\105\55\55\x2d\55\x2d", '', $VZ);
        $VZ = str_replace("\55\x2d\x2d\x2d\x2d\x45\x4e\104\x20\x43\105\122\x54\x49\x46\111\103\101\124\x45\x2d\x2d\55\x2d\x2d", '', $VZ);
        $VZ = str_replace("\x2d\x2d\55\x2d\55\x42\105\x47\111\116\x20\x50\125\x42\x4c\111\x43\40\x4b\x45\x59\55\55\55\55\x2d", '', $VZ);
        $VZ = str_replace("\x2d\x2d\x2d\55\x2d\x45\x4e\104\40\x50\x55\102\x4c\111\103\40\x4b\x45\x59\x2d\x2d\55\x2d\x2d", '', $VZ);
        $VZ = str_replace("\x20", '', $VZ);
        if (isset($_REQUEST["\x64\157\x77\x6e\x6c\x6f\141\144\103\145\x72\x74\x69\146\151\x63\x61\x74\x65"]) && $_REQUEST["\x64\157\x77\x6e\x6c\x6f\141\x64\x43\x65\x72\164\151\146\x69\x63\141\x74\x65"] && boolval($_REQUEST["\x64\x6f\167\x6e\x6c\x6f\x61\x64\x43\x65\x72\x74\x69\146\x69\x63\x61\x74\x65"])) {
            goto Sd;
        }
        if (isset($_REQUEST["\x64\157\x77\x6e\154\157\141\x64"]) && $_REQUEST["\x64\x6f\x77\156\x6c\157\141\144"] && boolval($_REQUEST["\x64\x6f\167\156\x6c\157\x61\144"])) {
            goto Mz;
        }
        $Sl = "\103\157\156\x74\x65\156\x74\55\124\x79\160\145\x3a\40\x74\145\170\x74\x2f\170\155\154";
        goto QU;
        Sd:
        $Sl = "\103\x6f\x6e\x74\x65\x6e\x74\x2d\x44\151\163\160\157\x73\151\x74\x69\157\x6e\72\x20\141\164\x74\141\143\x68\x6d\145\156\x74\73\x20\x66\151\x6c\145\x6e\x61\x6d\145\75\42\163\160\55\143\145\x72\x74\x69\146\x69\x63\x61\164\145\x2e\x63\162\164\42";
        header($Sl);
        echo xss::filter($D9);
        exit;
        goto QU;
        Mz:
        $Sl = "\103\x6f\x6e\x74\145\x6e\164\x2d\104\x69\163\160\x6f\x73\151\x74\151\157\x6e\x3a\x20\x61\x74\164\141\x63\150\155\145\x6e\164\x3b\x20\146\151\154\145\x6e\x61\x6d\145\x3d\x22\x4d\x65\x74\x61\x64\141\x74\141\x2e\170\x6d\154\x22";
        QU:
        header($Sl);
        echo "\x3c\x3f\170\x6d\154\x20\166\x65\162\163\x69\x6f\156\75\42\x31\x2e\60\42\x3f\76\xa\x20\40\x20\x20\40\x20\x20\40\74\155\x64\72\x45\x6e\164\151\164\171\x44\x65\x73\x63\x72\x69\160\164\157\162\40\x78\x6d\154\x6e\163\x3a\155\x64\x3d\x22\165\162\156\x3a\x6f\x61\x73\151\x73\72\x6e\x61\155\145\163\72\164\143\72\x53\101\115\x4c\72\x32\56\60\72\155\145\x74\141\x64\x61\x74\x61\42\40\x76\x61\x6c\151\144\125\x6e\164\151\x6c\x3d\x22\62\60\62\64\55\x30\x33\55\x32\x37\x54\x32\x33\x3a\x35\x39\72\65\71\132\42\x20\x63\x61\x63\x68\x65\104\x75\162\141\164\151\x6f\x6e\75\42\120\x54\61\64\x34\x36\70\60\x38\67\x39\62\123\x22\40\x65\x6e\x74\x69\164\x79\x49\104\x3d\x22" . $rk . "\42\x3e\xa\x20\x20\x20\40\40\x20\x20\40\40\x20\74\x6d\144\72\x53\x50\123\x53\x4f\x44\145\x73\x63\x72\151\x70\x74\x6f\x72\x20\101\165\164\150\x6e\x52\x65\161\165\145\x73\x74\x73\x53\151\x67\x6e\145\x64\x3d\42\164\x72\x75\145\42\x20\127\x61\x6e\x74\x41\163\163\x65\162\x74\x69\x6f\156\163\123\x69\147\x6e\x65\144\x3d\x22\x74\162\x75\145\x22\x20\x70\x72\x6f\164\x6f\x63\x6f\x6c\x53\165\x70\x70\x6f\x72\164\x45\156\165\155\145\x72\141\164\151\157\156\x3d\42\x75\x72\x6e\72\157\141\x73\151\163\x3a\x6e\x61\155\145\x73\x3a\x74\143\x3a\x53\101\115\x4c\72\x32\56\x30\72\x70\x72\x6f\164\157\x63\x6f\x6c\42\x3e\xa\40\40\x20\x20\40\x20\x20\x20\x20\40\x20\x20\x3c\x6d\x64\72\113\145\x79\104\145\x73\143\162\151\x70\164\x6f\x72\40\165\163\145\x3d\x22\163\x69\147\x6e\151\156\147\x22\x3e\xa\40\40\40\40\40\40\40\40\x20\x20\40\x20\40\40\x3c\x64\x73\x3a\x4b\x65\171\x49\156\x66\x6f\x20\x78\x6d\x6c\156\163\72\144\x73\x3d\42\150\164\x74\x70\x3a\x2f\57\x77\x77\167\56\167\x33\x2e\x6f\162\147\x2f\x32\60\x30\x30\x2f\x30\71\57\170\155\154\144\163\151\x67\43\42\x3e\12\40\40\x20\40\40\x20\x20\x20\40\40\x20\x20\x20\x20\40\40\x3c\x64\163\x3a\130\65\60\x39\x44\141\x74\x61\76\12\40\x20\40\x20\x20\x20\40\x20\40\x20\40\x20\x20\40\40\x20\40\40\74\144\163\x3a\130\65\x30\71\x43\145\162\x74\151\146\151\x63\x61\x74\145\76" . $VZ . "\x3c\57\144\163\x3a\x58\65\x30\71\x43\145\162\164\x69\146\x69\143\x61\x74\x65\x3e\xa\x20\40\x20\40\x20\40\x20\x20\40\40\40\40\x20\x20\40\x20\74\57\144\x73\72\x58\x35\x30\x39\104\141\x74\141\76\12\40\40\x20\x20\40\40\40\40\40\x20\x20\40\x20\x20\x3c\57\x64\x73\72\113\145\171\111\156\x66\x6f\76\xa\x20\40\x20\x20\40\x20\x20\40\40\x20\x20\40\74\x2f\x6d\x64\x3a\113\145\171\x44\x65\x73\143\x72\x69\x70\164\x6f\162\76\12\40\40\40\40\x20\40\x20\x20\x20\40\40\x20\x3c\x6d\144\72\x4b\x65\171\x44\145\163\143\x72\151\160\x74\157\x72\x20\165\163\x65\x3d\42\145\156\143\162\171\x70\164\x69\157\156\42\x3e\12\40\40\x20\40\40\40\x20\x20\x20\40\40\40\40\40\74\x64\x73\x3a\x4b\145\171\111\156\x66\157\40\170\155\x6c\156\163\72\144\163\75\42\x68\x74\x74\x70\72\57\x2f\x77\167\167\56\167\x33\x2e\157\162\147\57\62\60\x30\60\x2f\60\71\57\x78\155\154\x64\x73\151\147\x23\x22\x3e\xa\x20\x20\40\40\x20\x20\40\40\x20\x20\x20\x20\x20\40\40\x20\x3c\144\x73\72\x58\x35\60\71\x44\141\164\x61\x3e\xa\x20\40\40\40\x20\x20\x20\40\x20\40\40\x20\x20\x20\x20\40\x20\40\x3c\x64\x73\72\130\65\60\x39\103\x65\x72\164\151\x66\x69\143\141\164\145\76" . $VZ . "\x3c\57\x64\x73\x3a\x58\65\x30\71\103\x65\162\x74\x69\146\151\x63\x61\164\x65\76\12\40\x20\x20\40\x20\x20\40\x20\40\x20\x20\40\x20\x20\x20\x20\x3c\x2f\144\x73\x3a\130\65\60\x39\x44\141\x74\141\x3e\12\x20\40\x20\x20\x20\40\40\40\40\x20\40\x20\40\x20\74\x2f\x64\163\x3a\x4b\145\171\111\156\x66\157\x3e\xa\40\x20\40\40\40\x20\40\x20\40\x20\40\x20\74\57\155\144\72\113\145\171\104\x65\x73\x63\x72\151\x70\164\x6f\162\76\12\40\x20\x20\40\x20\40\40\40\40\40\40\x20\x3c\155\x64\72\x53\151\x6e\x67\x6c\x65\114\157\147\157\165\164\x53\145\162\166\x69\143\145\x20\x42\x69\156\144\151\156\147\75\x22\165\162\156\72\x6f\141\163\x69\163\x3a\x6e\x61\155\145\163\72\x74\143\x3a\x53\x41\115\x4c\x3a\x32\x2e\x30\72\142\151\x6e\x64\x69\x6e\x67\163\72\x48\124\124\x50\x2d\x50\117\x53\x54\42\x20\114\x6f\x63\x61\x74\151\157\x6e\x3d\x22" . $UR . "\x2f\165\163\x65\162\x2f\154\157\147\157\x75\x74\42\57\76\12\x20\40\x20\x20\40\x20\40\x20\40\40\40\40\x3c\155\x64\72\x53\151\x6e\147\154\x65\114\157\x67\x6f\x75\x74\123\145\x72\x76\x69\143\x65\x20\102\151\156\x64\x69\x6e\147\75\42\x75\162\156\x3a\157\x61\x73\x69\163\x3a\156\141\x6d\x65\163\x3a\164\x63\72\123\x41\115\114\72\62\56\60\72\x62\151\156\x64\151\x6e\147\163\72\110\124\124\x50\x2d\122\145\x64\x69\162\145\x63\164\42\40\114\x6f\143\141\x74\151\157\156\75\42" . $UR . "\57\x75\x73\145\162\x2f\154\157\147\x6f\x75\164\x22\57\76\12\x20\x20\x20\x20\x20\40\40\x20\x20\x20\40\x20\x3c\155\x64\x3a\116\141\x6d\145\x49\104\106\x6f\162\155\x61\x74\x3e\165\x72\x6e\72\x6f\x61\163\151\163\x3a\156\x61\x6d\x65\163\x3a\164\143\x3a\x53\101\x4d\x4c\x3a\61\x2e\x31\x3a\x6e\x61\x6d\145\151\144\55\x66\x6f\x72\155\x61\x74\x3a\145\155\x61\151\x6c\101\144\x64\162\x65\x73\x73\x3c\x2f\x6d\x64\x3a\x4e\x61\155\x65\x49\104\106\157\162\x6d\141\164\x3e\xa\40\x20\x20\x20\40\x20\40\x20\40\40\x20\40\74\x6d\x64\x3a\x4e\x61\x6d\x65\x49\104\106\157\162\155\141\x74\76\165\x72\156\72\157\141\x73\151\163\72\156\x61\155\145\163\72\x74\x63\72\123\x41\115\114\x3a\x32\56\x30\72\x6e\x61\155\x65\151\144\55\146\x6f\162\155\141\x74\x3a\x75\x6e\x73\160\x65\x63\151\146\x69\x65\144\x3c\x2f\x6d\x64\72\x4e\x61\x6d\x65\x49\104\x46\157\162\x6d\141\x74\76\12\x20\40\x20\40\x20\x20\x20\40\x20\40\40\x20\74\155\x64\72\x4e\141\155\x65\x49\x44\x46\x6f\162\155\141\x74\x3e\165\162\156\x3a\x6f\141\163\151\163\72\x6e\141\x6d\x65\163\72\x74\143\x3a\123\x41\115\x4c\x3a\62\x2e\60\x3a\x6e\141\x6d\145\x69\x64\55\x66\x6f\162\155\141\x74\72\x74\162\141\x6e\163\151\x65\156\x74\x3c\57\x6d\144\x3a\116\x61\155\x65\x49\x44\x46\157\x72\155\141\164\x3e\12\x20\x20\x20\40\40\40\x20\x20\x20\40\x20\40\74\x6d\144\x3a\101\x73\x73\x65\x72\x74\151\x6f\156\103\157\156\163\x75\x6d\145\162\x53\x65\162\x76\x69\x63\145\40\x42\151\x6e\144\151\156\147\75\x22\165\162\x6e\x3a\157\141\163\x69\163\72\x6e\x61\155\145\x73\x3a\164\143\72\123\x41\x4d\x4c\72\x32\x2e\60\72\142\151\156\x64\151\156\x67\x73\72\x48\124\x54\120\55\x50\117\123\x54\42\40\x4c\x6f\x63\141\x74\151\x6f\156\75\x22" . $Ww . "\42\40\151\156\x64\x65\170\x3d\x22\x31\42\57\76\12\x20\40\x20\x20\x20\40\40\x20\40\40\74\x2f\x6d\144\72\123\x50\123\x53\117\x44\x65\163\143\162\151\160\164\157\162\76\xa\40\x20\40\x20\40\x20\x20\x20\x20\x20\74\155\144\72\x4f\x72\x67\x61\156\151\172\141\164\x69\157\x6e\x3e\xa\40\x20\x20\x20\x20\x20\40\40\x20\x20\x20\40\x3c\x6d\x64\x3a\117\162\147\x61\156\151\x7a\141\x74\151\x6f\x6e\x4e\x61\x6d\x65\40\x78\155\154\72\154\x61\x6e\147\75\x22\x65\156\55\x55\123\42\x3e" . $ll->get("\x6d\x6f\x5f\x73\141\x6d\154\x5f\x6d\x65\x74\141\144\141\164\x61\x5f\117\x72\147\x61\156\151\172\141\x74\151\x6f\x6e\116\x61\x6d\x65") . "\x3c\57\155\144\x3a\x4f\162\x67\141\x6e\151\172\x61\x74\151\157\x6e\x4e\141\x6d\145\x3e\12\x20\x20\40\x20\x20\x20\40\40\40\x20\x20\40\74\155\144\x3a\x4f\x72\147\141\x6e\x69\x7a\x61\164\x69\x6f\156\x44\151\x73\160\x6c\x61\171\x4e\141\155\145\40\170\x6d\154\x3a\x6c\x61\x6e\x67\75\42\x65\x6e\55\x55\x53\42\x3e" . $ll->get("\155\157\137\x73\141\155\x6c\137\117\162\147\141\156\151\172\x61\164\x69\157\x6e\104\x69\163\x70\154\x61\171\x4e\141\155\145") . "\x3c\x2f\x6d\144\x3a\117\x72\147\x61\x6e\151\172\141\164\151\157\x6e\x44\x69\x73\160\x6c\141\171\x4e\x61\155\x65\76\xa\x20\x20\40\x20\x20\x20\40\40\x20\x20\40\x20\74\x6d\144\x3a\117\x72\147\141\x6e\151\172\141\x74\151\x6f\x6e\125\x52\114\40\x78\x6d\x6c\72\x6c\141\156\147\75\42\x65\156\55\125\123\x22\76" . $ll->get("\x6d\157\x5f\x73\x61\155\154\x5f\117\162\x67\141\156\x69\172\141\x74\x69\157\x6e\x55\x52\114") . "\74\x2f\155\144\72\117\x72\147\141\156\x69\172\141\164\x69\157\156\125\x52\114\76\xa\x20\40\x20\x20\40\40\x20\40\40\40\74\x2f\x6d\x64\x3a\117\x72\x67\141\156\x69\x7a\141\164\151\x6f\156\x3e\xa\40\x20\x20\x20\x20\40\x20\40\40\x20\74\x6d\144\x3a\x43\157\x6e\164\141\x63\164\120\145\162\163\157\156\x20\x63\157\156\x74\141\143\164\124\171\x70\145\75\42\164\x65\143\150\x6e\x69\143\141\154\42\76\xa\x20\40\40\40\40\40\40\40\40\x20\x20\x20\74\x6d\x64\x3a\x47\151\x76\145\156\x4e\141\155\x65\76" . $ll->get("\155\157\137\x73\141\155\x6c\x5f\x43\x6f\x6e\164\x61\143\164\120\x65\x72\163\x6f\x6e\x54\x65\143\150\156\151\x63\141\x6c\116\141\155\x65") . "\x3c\x2f\155\144\x3a\x47\x69\x76\x65\156\116\x61\x6d\x65\76\xa\40\x20\x20\40\40\x20\x20\x20\x20\40\x20\40\74\155\x64\72\x45\155\141\151\x6c\x41\144\144\x72\x65\x73\163\76" . $ll->get("\x6d\x6f\x5f\x73\x61\155\154\x5f\x43\x6f\x6e\x74\141\x63\x74\120\x65\162\x73\157\156\x54\145\143\x68\x6e\x69\x63\x61\x6c\x45\x6d\141\x69\154") . "\x3c\57\x6d\144\x3a\x45\x6d\141\151\154\x41\x64\x64\x72\145\x73\x73\76\xa\40\x20\40\x20\x20\40\x20\x20\40\40\74\x2f\155\144\x3a\103\157\x6e\164\x61\x63\164\120\145\162\x73\x6f\x6e\x3e\12\x20\40\40\x20\40\40\x20\x20\x20\x20\x3c\155\x64\72\103\x6f\156\164\x61\x63\164\120\x65\162\163\157\156\40\x63\157\x6e\164\141\x63\164\x54\x79\160\145\x3d\42\163\165\160\160\x6f\x72\x74\42\x3e\12\x20\x20\40\x20\x20\40\40\40\40\x20\40\x20\74\x6d\144\x3a\x47\x69\166\145\156\116\141\x6d\145\76" . $ll->get("\155\x6f\137\x73\141\155\x6c\x5f\103\x6f\x6e\164\141\143\164\x50\145\x72\x73\157\x6e\123\x75\x70\x70\x6f\162\x74\x4e\141\155\145") . "\74\x2f\155\144\72\x47\151\x76\x65\x6e\116\x61\x6d\x65\76\12\40\x20\x20\40\40\x20\x20\x20\40\40\40\x20\74\155\144\x3a\105\155\x61\x69\x6c\x41\x64\144\162\145\x73\163\76" . $ll->get("\155\x6f\137\x73\141\155\154\137\103\157\156\164\x61\x63\x74\120\x65\x72\x73\x6f\x6e\x53\x75\160\x70\x6f\162\164\105\155\x61\x69\x6c") . "\x3c\57\x6d\144\72\105\x6d\141\x69\x6c\101\144\x64\x72\145\163\163\76\12\x20\40\x20\40\40\40\x20\40\40\40\74\57\155\144\72\x43\x6f\156\164\x61\x63\164\x50\145\162\x73\x6f\156\x3e\xa\40\x20\40\40\40\x20\40\40\x3c\x2f\155\144\x3a\105\x6e\x74\x69\x74\171\104\145\163\x63\x72\151\x70\x74\157\x72\x3e";
        exit;
    }
    public static function isBooleanField($A2)
    {
        $KJ = FieldStorageConfig::loadByName("\x75\x73\x65\x72", $A2);
        $ax = $KJ->getType();
        if (!($ax == "\142\157\157\x6c\x65\141\x6e")) {
            goto xM;
        }
        return TRUE;
        xM:
        return FALSE;
    }
    public static function removeBracketsForRoleMapping($hp)
    {
        $hp = str_replace("\42", '', $hp);
        $hp = str_replace("\47", '', $hp);
        $eO = function ($hp) {
            $nq = ["\x7b" => "\175", "\x28" => "\51", "\133" => "\135"];
            if (in_array($hp[0], array_keys($nq))) {
                goto Rq;
            }
            return FALSE;
            goto y9;
            Rq:
            return $nq[$hp[0]] == $hp[-1];
            y9:
        };
        if (!$eO($hp)) {
            goto MV;
        }
        $hp = substr($hp, 1);
        $hp = substr($hp, 0, -1);
        MV:
        return $hp;
    }
}
