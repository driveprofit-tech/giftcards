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

session_name("fasttrak-forms-account");
session_set_cookie_params(3600 * 24);
session_start();

include_once('../php/config.php');
include_once('../php/db_config.php');
include_once('../php/lib/myactiverecord.php');
include_once('../php/lib/PHPMailer_v5.1/class.phpmailer.php');
include_once('../php/functions.php');
include_once('../php/db_classes.php');
include_once('../php/accountController.php');

$c = new controller();
if ($_GET['page'] == ""){
	$_GET['page'] = "login";
}

$ctrlname = str_replace("-", "_", $_GET['page']);

$c->$ctrlname();

?>

