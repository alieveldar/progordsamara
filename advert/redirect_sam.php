<?	
$a="https://ad.apps.fm/PZVuJ4SYer2CqKiZmOObNl5KLoEjTszcQMJsV6-2VnHFDLXitVHB6BlL95nuoNYfMoDtWtIcmTegVzVP865McgmGBirspynbAMZafK1g6TA0j9XlC6V9v3k9tIkvhATY ";
$i="https://app.appsflyer.com/id506360097?pid=Progorod&c=Progorod_Samara_nov_2016";
$w="https://www.microsoft.com/ru-ru/store/apps/rutaxi%D0%BE%D0%BD%D0%BB%D0%B0%D0%B9%D0%BD/9nblggh0855g";

$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
require_once("mobiledetect.php"); $detect=new Mobile_Detect;


if( $detect->isiOS() ){ @header('Location: '.$i); exit();
} elseif( $detect->isAndroidOS()){ @header('Location: '.$a); exit();
} else { @header('Location: '.$w); exit(); }


?>