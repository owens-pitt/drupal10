<?php


namespace Drupal\miniorange_saml;

use Drupal\miniorange_saml\MiniorangeSAMLConstants;
use GuzzleHttp\Exception\RequestException;
class MiniorangeSamlSupport
{
    public $email;
    public $phone;
    public $query;
    public $query_type;
    public function __construct($qW, $iF, $Qa, $cf)
    {
        $this->email = $qW;
        $this->phone = $iF;
        $this->query = $Qa;
        $this->query_type = $cf;
    }
    public function sendSupportQuery()
    {
        $kp = \Drupal::service("\145\170\x74\x65\156\163\151\157\156\56\154\151\x73\164\56\155\157\144\165\154\x65")->getExtensionInfo("\x6d\151\x6e\x69\x6f\162\x61\x6e\147\145\137\x73\x61\155\154");
        $GF = $kp["\166\x65\162\163\151\x6f\x6e"];
        $bd = phpversion();
        $Io = $this->query_type === "\116\145\167\40\x46\145\141\x74\x75\x72\145\40\122\x65\x71\x75\145\x73\x74" ? "\x28\116\145\167\40\106\x65\141\164\x75\162\145\40\122\145\161\x75\x65\x73\164\x29" : '';
        $this->query = "\x5b\104\162\x75\x70\141\154\40" . Utilities::mo_get_drupal_core_version() . "\40\x53\101\115\114\40\x53\120\40" . ucfirst(strtolower(MiniorangeSAMLConstants::PLUGIN_VERSION)) . "\40" . $Io . "\40\174\40" . $GF . "\40\174\40\x50\110\120\x20" . $bd . "\x20\x5d\x20" . $this->query;
        $w1 = array("\x63\157\155\160\x61\x6e\171" => $_SERVER["\123\x45\122\126\x45\122\137\x4e\x41\115\105"], "\145\155\x61\x69\154" => $this->email, "\143\143\x45\x6d\x61\151\154" => "\x64\x72\x75\160\141\154\163\x75\x70\x70\157\x72\164\x40\170\145\x63\x75\x72\151\146\x79\x2e\143\157\x6d", "\x70\150\x6f\x6e\145" => $this->query_type != "\104\145\x6d\x6f\40\x52\x65\x71\165\x65\163\164" ? $this->phone : '', "\161\165\x65\162\171" => $this->query);
        $iO = json_encode($w1);
        $GM = MiniorangeSAMLConstants::BASE_URL . "\57\155\157\141\x73\57\162\145\163\164\x2f\143\x75\x73\x74\x6f\155\145\x72\x2f\143\x6f\156\164\x61\143\164\55\165\163";
        try {
            $ld = \Drupal::httpClient()->request("\120\x4f\x53\x54", $GM, ["\x62\x6f\x64\171" => $iO, "\141\154\154\x6f\x77\x5f\x72\145\x64\x69\x72\145\x63\x74\163" => TRUE, "\150\164\x74\160\x5f\x65\x72\x72\157\162\x73" => FALSE, "\x64\145\x63\157\144\x65\x5f\x63\x6f\156\x74\145\156\164" => true, "\x76\145\162\151\146\x79" => FALSE, "\150\x65\x61\144\145\162\163" => array("\103\x6f\x6e\164\x65\156\164\x2d\x54\x79\160\x65" => "\x61\x70\x70\x6c\x69\x63\x61\x74\151\157\156\57\152\163\x6f\156", "\x41\x75\x74\150\x6f\162\x69\172\x61\164\x69\x6f\156" => "\102\141\163\x69\x63")]);
        } catch (RequestException $BD) {
            \Drupal::logger("\155\151\156\151\x6f\x72\x61\156\147\145\137\163\141\x6d\154")->notice("\x45\x72\162\157\162\x20\141\164\40\45\x6d\x65\x74\150\157\144\x20\157\146\40\x25\x66\151\154\x65\x3a\x20\x25\x65\162\162\157\162", array("\x25\x6d\x65\164\x68\157\x64" => "\x73\145\156\144\123\x75\160\160\x6f\x72\x74\121\x75\x65\162\x79", "\x25\146\x69\x6c\145" => "\x4d\x69\x6e\x69\157\x72\141\156\147\x65\x53\101\x4d\x4c\x53\165\160\160\x6f\x72\164\x2e\160\x68\160", "\45\145\x72\162\157\162" => $BD->getMessage()));
            return false;
        }
        return true;
    }
}
