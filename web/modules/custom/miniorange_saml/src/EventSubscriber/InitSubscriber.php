<?php


namespace Drupal\miniorange_saml\EventSubscriber;

use Drupal\miniorange_saml\Controller\miniorange_samlController;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\user\Entity\User;
class InitSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [KernelEvents::REQUEST => ["\157\156\105\x76\145\156\164", 0]];
    }
    public function onEvent()
    {
        global $base_url;
        $xL = '';
        $ll = \Drupal::config("\x6d\151\x6e\x69\157\162\x61\156\x67\x65\x5f\x73\141\x6d\x6c\56\x73\x65\x74\x74\x69\156\147\x73");
        $Dc = $ll->get("\155\x69\156\x69\x6f\162\141\x6e\147\x65\x5f\x73\141\155\x6c\x5f\146\x6f\162\x63\145\x5f\141\x75\164\150");
        $Lo = $ll->get("\155\x69\x6e\x69\x6f\x72\141\156\147\145\x5f\x73\141\x6d\x6c\137\x65\156\141\142\154\145\137\154\157\x67\x69\x6e");
        $CE = $ll->get("\155\x69\156\x69\x6f\x72\141\156\x67\x65\x5f\x73\x61\155\x6c\137\x65\x6e\141\142\154\145\137\142\x61\143\153\144\x6f\157\162");
        $zX = $ll->get("\155\x69\156\x69\157\x72\x61\156\147\145\x5f\x73\141\x6d\x6c\137\154\x69\x63\145\156\163\145\137\x6b\145\171");
        $KT = $ll->get("\155\x69\x6e\151\157\x72\141\156\x67\145\137\142\141\x63\153\x64\x6f\x6f\162\137\x71\x75\x65\162\x79");
        if (!$Lo) {
            goto pN;
        }
        if ($CE && isset($_GET["\x73\x61\x6d\154\137\x6c\157\147\151\x6e"]) && $_GET["\163\141\155\x6c\x5f\x6c\x6f\147\151\156"] == $KT) {
            goto Oc;
        }
        if (!($Dc && !\Drupal::currentUser()->isAuthenticated() && !isset($_REQUEST["\123\101\115\114\x52\145\x73\x70\x6f\x6e\163\145"]) && !isset($_POST["\160\141\x73\163"]))) {
            goto i7;
        }
        $GM = \Drupal::request()->getUri();
        if (isset($_SERVER["\110\124\x54\x50\x53"]) && $_SERVER["\x48\124\124\120\123"] === "\x6f\156") {
            goto Nz;
        }
        $BF = "\150\164\164\x70";
        goto h8;
        Nz:
        $BF = "\x68\164\164\x70\x73";
        h8:
        $BF .= "\x3a\57\x2f" . $_SERVER["\110\x54\124\x50\x5f\x48\x4f\123\124"] . "\x2f\x73\143\x69\x6d";
        if (!(strpos($GM, $BF) === FALSE)) {
            goto dS;
        }
        miniorange_samlController::saml_login($GM);
        dS:
        i7:
        goto Co;
        Oc:
        Co:
        if (!($zX == NULL)) {
            goto VN;
        }
        $QT = \Drupal::configFactory()->getEditable("\x6d\x69\156\x69\x6f\x72\141\156\147\x65\137\163\x61\155\154\x2e\x73\x65\164\x74\151\156\x67\x73");
        $QT->clear("\x6d\x69\156\151\x6f\162\x61\156\x67\145\137\x73\141\155\x6c\x5f\145\156\141\x62\x6c\145\137\x6c\x6f\x67\x69\x6e")->save();
        $QT->clear("\155\x69\156\151\157\162\x61\x6e\x67\145\137\x73\x61\155\154\x5f\146\x6f\x72\x63\145\x5f\x61\x75\x74\150")->save();
        $QT->clear("\x6d\x69\x6e\151\x6f\x72\141\156\x67\x65\x5f\163\x61\155\154\x5f\145\x6e\141\142\154\x65\x5f\x62\141\143\153\144\x6f\x6f\162")->save();
        VN:
        pN:
    }
}
