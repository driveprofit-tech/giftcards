<?php

error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT & ~E_NOTICE);
date_default_timezone_set('UTC');

if(strpos(dirname(__FILE__),'www') !== false){
	ini_set('display_errors', 1);
}
else
{
	ini_set('display_errors', 0);
}
ob_start();

session_name("fasttrak-forms-admin");
session_set_cookie_params(600);
session_start();

include_once('../php/config.php');
include_once('../php/db_config.php');
include_once('../php/lib/myactiverecord.php');
include_once('../php/functions.php');
include_once('../php/db_classes.php');
include_once('../php/adminController.php');


define("RECAPTCHA_SITE_KEY", "6LdaEjYUAAAAANWQkmiUjm1nARoTTwzxrTI3NePT");
define("RECAPTCHA_SECRET_KEY", "6LdaEjYUAAAAAIkEsS519rCEss263_8vqybp56j2");
	
$c = new controller();
if ($_GET['page'] == ""){
	$_GET['page'] = "login";
}//end if

$ctrlname = str_replace("-", "_", $_GET['page']);

$c->$ctrlname();

?>

