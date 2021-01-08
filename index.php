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

session_name("fasttrak-forms-front");
session_set_cookie_params(3600 * 24);
session_start();

include_once('php/config.php');
include_once('php/db_config.php');
include_once('php/lib/myactiverecord.php');
include_once('php/lib/PHPMailer_v5.1/class.phpmailer.php');
include_once('php/functions.php');
include_once('php/db_classes.php');
include_once('php/frontendController.php');

if(strlen($_GET['page']) < 1){
    $_GET['page'] = "home";
}
else
{
	if (strpos($_GET['page'], "/") > 0)
	{
		$page_data = explode("/", $_GET['page']);

		if($page_data[0] != "" && ($page_data[1] == "send-giftcard" || $page_data[1] == "check-giftcard" || $page_data[1] == "payment" || $page_data[1] == "payment-confirm" || $page_data[1] == "paypal"))
		{
			$_GET['page'] = $page_data[1];			
			$account = MyActiveRecord::FindFirst('account', array("name"=>$page_data[0], "status"=>"active"));
			if(!empty($account))
			{
				$_GET['account'] = $account->id;

				if($page_data[1] == "send-giftcard" && isset($page_data[2]) && in_array($page_data[2], array("step-2", "step-3")))
				{
					$_GET['step'] = str_replace("step-", "", $page_data[2]);
				}			
			}
			else
			{
				header("Location: " . BASE_PATH, true, 301);
				exit();
			}
		}
		else
		{
			header("Location: " . BASE_PATH, true, 301);
			exit();
		}
	}
}

$c = new controller();

$ctrlname = str_replace("-", "_", $_GET['page']);

if(method_exists($c, $ctrlname)){
    $c->$ctrlname();
} else {
    $c->error404();
}

?>