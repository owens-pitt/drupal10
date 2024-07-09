<?php


namespace Drupal\miniorange_saml\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\Core\Ajax\RedirectCommand;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\OpenModalDialogCommand;
use Drupal\miniorange_saml\AESEncryption;
use Drupal\miniorange_saml\MiniorangeSAMLCustomer;
use Drupal\miniorange_saml\Utilities;
class MiniorangeSAMLRemoveLicense extends FormBase
{
    public function getFormId()
    {
        return "\x6d\151\x6e\151\157\162\x61\x6e\147\x65\137\x73\141\155\x6c\x5f\x72\145\155\x6f\x76\x65\x5f\x6c\151\x63\x65\156\163\145";
    }
    public function buildForm(array $form, FormStateInterface $form_state, $dk = NULL)
    {
        $form["\x23\x70\162\145\146\151\170"] = "\74\x64\x69\x76\40\x69\x64\75\x22\155\157\x64\141\154\137\x65\170\x61\x6d\x70\154\145\x5f\x66\157\x72\155\x22\x3e";
        $form["\x23\x73\165\146\x66\151\x78"] = "\x3c\57\x64\x69\x76\76";
        $form["\163\164\141\164\165\163\x5f\155\x65\x73\163\x61\147\x65\163"] = ["\43\x74\171\160\x65" => "\x73\x74\141\164\165\163\x5f\x6d\x65\x73\163\141\x67\145\x73", "\x23\167\145\x69\x67\x68\164" => -10];
        $form["\155\151\x6e\151\x6f\162\141\x6e\147\x65\x5f\x73\141\155\154\x5f\x63\x6f\156\x74\145\156\x74"] = array("\43\155\141\x72\x6b\165\x70" => "\x41\x72\x65\40\171\x6f\165\x20\x73\x75\x72\145\x20\171\x6f\x75\x20\167\141\x6e\x74\40\x74\157\40\162\x65\x6d\x6f\x76\x65\x20\164\150\x65\40\114\151\143\145\156\163\x65\40\x6b\145\x79\x3f\x20\124\x68\x65\40\143\157\x6e\146\x69\x67\165\162\141\x74\151\x6f\156\163\x20\163\x61\x76\x65\144\x20\167\151\154\154\40\156\x6f\x74\x20\x62\x65\40\154\157\x73\164\56");
        $form["\141\143\164\x69\157\x6e\163"] = array("\x23\x74\171\x70\145" => "\x61\x63\164\151\x6f\156\x73");
        $form["\141\143\x74\x69\157\156\163"]["\x73\145\156\x64"] = ["\43\164\x79\160\145" => "\163\165\x62\x6d\151\164", "\x23\x76\x61\154\165\x65" => $this->t("\103\157\156\146\x69\162\155"), "\43\x61\x74\164\162\151\142\165\164\x65\163" => ["\143\154\141\x73\x73" => ["\165\163\x65\55\141\152\x61\170"]], "\43\x61\152\141\170" => ["\x63\x61\x6c\154\x62\141\143\x6b" => [$this, "\x73\x75\x62\x6d\151\164\x4d\157\144\x61\154\x46\x6f\162\x6d\x41\152\x61\x78"], "\145\166\x65\156\x74" => "\x63\154\x69\143\153"]];
        $form["\43\x61\164\x74\141\143\150\145\x64"]["\154\x69\x62\162\141\x72\171"][] = "\x63\x6f\162\145\57\144\x72\165\160\141\x6c\56\x64\151\141\x6c\x6f\x67\56\141\152\x61\170";
        return $form;
    }
    public function submitModalFormAjax(array $form, FormStateInterface $form_state)
    {
        $ll = \Drupal::config("\155\x69\156\x69\157\x72\141\x6e\x67\145\137\x73\141\x6d\x6c\56\x73\x65\164\164\x69\156\x67\163");
        $C2 = $ll->get("\155\151\x6e\x69\x6f\162\x61\x6e\147\145\x5f\163\x61\x6d\x6c\137\x63\x75\x73\164\157\x6d\x65\162\x5f\141\x64\x6d\x69\156\x5f\x74\157\153\145\156");
        $QT = \Drupal::configFactory()->getEditable("\155\x69\156\151\157\x72\141\156\x67\x65\137\x73\x61\x6d\154\x2e\163\x65\x74\164\151\x6e\147\163");
        $kM = AESEncryption::decrypt_data($QT->get("\155\x69\x6e\157\x72\141\156\147\145\x5f\x73\141\x6d\154\137\143\165\x73\x74\157\x6d\145\162\x5f\141\144\155\151\156\137\x66\162\x61\x75\144\137\143\150\x65\143\153"), $C2);
        $Yd = Utilities::moStoreDomainInDatabase($C2, 1);
        $ld = new AjaxResponse();
        if ($form_state->hasAnyErrors()) {
            goto cM;
        }
        if (!($ll->get("\155\151\156\x69\x6f\x72\x61\x6e\x67\x65\x5f\x73\141\155\154\x5f\154\151\143\145\156\163\x65\137\153\x65\171") != NULL)) {
            goto IQ;
        }
        $V5 = new MiniorangeSAMLCustomer($ll->get("\155\x69\156\151\157\x72\x61\156\x67\145\137\163\141\155\x6c\137\x63\x75\163\x74\x6f\155\x65\x72\x5f\141\144\155\x69\x6e\x5f\145\155\141\x69\x6c"), $ll->get("\x6d\151\156\x69\157\162\x61\x6e\147\145\137\163\x61\155\154\x5f\143\165\x73\x74\157\x6d\145\x72\137\x61\144\155\x69\156\x5f\x70\x68\157\156\145"), NULL, NULL);
        if (!($Yd == $kM)) {
            goto HW;
        }
        $HV = $V5->updateStatus() !== NULL ? json_decode($V5->updateStatus()) : '';
        if (!(!is_object($HV) || !isset($HV->status) || empty($HV->status))) {
            goto y6;
        }
        \Drupal::messenger()->addMessage(t("\105\162\162\x6f\x72\x3a\x53\x6f\x6d\145\164\150\x69\156\147\40\167\x65\x6e\x74\40\167\x72\157\156\x67\40\x77\150\151\x6c\x65\40\160\x72\x6f\143\x65\x73\x73\151\x6e\147\x20\171\157\x75\x72\40\x72\x65\x71\165\x65\163\x74\x2e\x20\122\x65\x66\x65\162\145\x6e\143\145\x20\116\x6f\56\x3a\x44\70\123\x53\x45\174\x30\60\x30\71"), "\x65\x72\x72\157\x72");
        return;
        y6:
        HW:
        $QT->clear("\155\x69\x6e\151\157\162\141\x6e\x67\145\137\x73\x61\155\x6c\137\154\151\143\x65\x6e\163\145\x5f\153\x65\x79")->save();
        $QT->clear("\155\151\156\x69\x6f\162\141\x6e\147\145\137\163\141\x6d\154\x5f\143\165\x73\164\157\155\145\x72\137\141\144\155\151\156\x5f\145\155\x61\151\154")->save();
        $QT->clear("\x6d\x69\156\151\x6f\x72\141\156\147\x65\x5f\x73\x61\155\x6c\137\143\x75\x73\x74\157\x6d\x65\162\x5f\141\144\155\151\156\137\x70\x68\x6f\156\145")->save();
        $QT->clear("\155\x69\156\151\x6f\162\141\156\x67\145\137\163\141\x6d\154\x5f\x63\165\x73\164\157\x6d\x65\x72\137\x61\160\x69\137\x6b\x65\171")->save();
        $QT->clear("\x6d\151\156\x69\157\x72\x61\x6e\147\x65\x5f\163\141\x6d\x6c\x5f\143\165\x73\164\x6f\155\145\162\137\x61\144\155\151\x6e\137\x74\157\153\145\156")->save();
        $QT->set("\155\151\x6e\151\157\x72\141\x6e\147\145\x5f\163\x61\x6d\x6c\x5f\x73\x74\141\x74\x75\x73", "\x43\125\123\x54\117\115\105\x52\x5f\123\105\x54\x55\120")->save();
        if (empty($QT->get("\155\151\x6e\x69\157\x72\141\x6e\x67\145\137\x73\141\155\x6c\x5f\154\151\143\x65\156\x73\x65\x5f\x6b\145\171"))) {
            goto dw;
        }
        \Drupal::messenger()->addMessage(t("\x45\162\x72\157\x72\72\123\x6f\155\x65\164\x68\x69\156\147\x20\167\x65\x6e\x74\40\167\x72\157\x6e\x67\40\167\150\151\154\145\40\160\162\157\x63\x65\x73\163\151\156\147\x20\x79\157\x75\x72\x20\162\145\x71\x75\145\163\164\x2e\x20\122\145\146\145\x72\x65\x6e\143\145\40\x4e\157\56\x3a\x44\x38\x53\x53\105\x7c\60\60\61\60"), "\145\162\x72\157\162");
        goto gu;
        dw:
        \Drupal::messenger()->addMessage(t("\131\157\x75\x72\40\x41\143\143\x6f\165\x6e\164\x20\x48\141\x73\x20\x42\145\x65\x6e\40\x52\x65\x6d\157\x76\145\x64\40\x53\x75\x63\x63\145\163\163\x66\165\x6c\x6c\171\41"), "\x73\164\x61\x74\x75\x73");
        gu:
        IQ:
        $ld->addCommand(new RedirectCommand(\Drupal\Core\Url::fromRoute("\x6d\x69\156\x69\157\162\141\x6e\x67\145\x5f\163\141\x6d\154\56\x63\165\163\164\157\x6d\145\162\x5f\163\145\164\x75\x70")->toString()));
        goto Fu;
        cM:
        $ld->addCommand(new ReplaceCommand("\x23\x6d\x6f\144\x61\x6c\x5f\145\x78\141\155\160\154\145\x5f\146\157\162\155", $form));
        Fu:
        return $ld;
    }
    public function validateForm(array &$form, FormStateInterface $form_state)
    {
    }
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
    }
    protected function getEditableConfigNames()
    {
        return ["\x63\x6f\156\x66\151\147\56\x6d\x69\156\151\157\x72\x61\156\x67\x65\x5f\x73\x61\x6d\154\137\x72\145\x6d\157\x76\145\x5f\154\x69\143\x65\x6e\163\145"];
    }
}
