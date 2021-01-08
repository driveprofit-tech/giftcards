<?php

error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT & ~E_NOTICE);
date_default_timezone_set('UTC');
ini_set('display_errors', 1);

include_once('../php/config.php');
include_once('../php/db_config.php');
include_once('../php/lib/myactiverecord.php');
include_once('../php/lib/PHPMailer_v5.1/class.phpmailer.php');
include_once('../php/functions.php');
include_once('../php/db_classes.php');

/*
if((isset($_SERVER['argv'][1]) && ($_SERVER['argv'][1] == '--cron') && !isset($_SERVER['HTTP_USER_AGENT'])) || ($_GET['debug'] != "yes"))
{
	// Ok, most probably is from cron 
}
else
{
	exit;
}
*/

// Get active accounts
$accounts = MyActiveRecord::FindAll("account", array("status"=>"active"));
if (!empty($accounts))
{
	// Go through each account
	foreach($accounts as $account)
	{
		
		$site_name = account_globals::getvalue($account->id, "site_name");
		$site_link = account_globals::getvalue($account->id, "site_link");
		$site_logo = account_globals::getvalue($account->id, "site_logo");

		$account_purchases = MyActiveRecord::FindBySql('account_purchase', "SELECT * FROM account_purchase 
																	WHERE account_id = " . MyActiveRecord::Escape($account->id) . " AND payment_status = 'paid' AND sent_status = 'queued' AND send_on < '" . date('Y-m-d H:i:s') . "'
																	ORDER BY id ASC
																	LIMIT 5"
																);
		// If we have some records go through each quote
		if (!empty($account_purchases))
		{
			foreach ($account_purchases as $purchase)
			{

				$check_url_with_code = BASE_PATH . $account->name . "/check-giftcard?code=" . $purchase->receiver_code;
            	$check_url = BASE_PATH . $account->name . "/check-giftcard";

				// Send email to receiver
	            $mail = new PHPMailer();
	            $mail->IsSMTP();
	            $mail->SMTPAuth = true;
	            $mail->Host = "smtp.sparkpostmail.com";
	            $mail->Port = 587;
	            $mail->Username = "SMTP_Injection";
	            $mail->Password = "294a7e4e65999ea3515939f2a992c0170cac6376";
	            $mail->Subject = $purchase->sender_name . " sent you a giftcard!";

	            $body_content = '
	            Hi ' . $purchase->receiver_name . ',
	            <br/><br/>
	            <p>' . $purchase->sender_name . ' just sent you a giftcard!</p>
	            <p>You can view it by clicking here: <a href="' . $check_url_with_code . '">' . $check_url_with_code . '</a></p>
	            <p>Or if you prefer, you can go to <a href="' . $check_url . '">' . $check_url . '</a> and type your giftcard code (' . $purchase->receiver_code . ') in the "Search" box. The code is valid for 10 days from the moment the giftcard is sent.</p>
	            <p>Note: This is an auto generated email. Please do not reply.</p>
	            <br/><br/>
	            Thanks!
	            ';

	            $body = file_get_contents('../email-template/notification.html');
	            $body = str_replace("%site_name%", account_globals::getvalue($account->id, "site_name"), $body);
	            $body = str_replace("%site_link%", account_globals::getvalue($account->id, "site_link"), $body);
	            $body = str_replace("%site_logo%", BASE_PATH . "assets/" . $account->id . "/" . account_globals::getvalue($account->id, "site_logo"), $body);
	            $body = str_replace("%texthere%", $body_content, $body);
	            $mail->AltBody = 'Please use a HTML compatible email client to read this message!';
	            $mail->MsgHTML($body);
	            $mail->AddAddress($purchase->receiver_email);
	            $mail->SetFrom('no-reply@driveprofit.com', account_globals::getvalue($account->id, "site_name"));

				$failed = false;
				$err_msg = "";
				if($mail->Send()){
					// ok 
				}
				else
				{
					$failed = true;
					$err_msg = $mail->ErrorInfo;
				}

				if(!$failed)
				{
					$purchase->sent_status = "sent";	
					$purchase->sent_on = date('Y-m-d H:i:s');	

					$check_url_with_code = BASE_PATH . $account->name . "/check-giftcard?code=" . $purchase->sender_code;
            		$check_url = BASE_PATH . $account->name . "/check-giftcard";

					// Send email to sender
		            $mail = new PHPMailer();
		            $mail->IsSMTP();
		            $mail->SMTPAuth = true;
		            $mail->Host = "smtp.sparkpostmail.com";
		            $mail->Port = 587;
		            $mail->Username = "SMTP_Injection";
		            $mail->Password = "294a7e4e65999ea3515939f2a992c0170cac6376";
		            $mail->Subject = "Giftcard sent to " . $purchase->receiver_name . "!";

		            $body_content = '
		            Hi ' . $purchase->sender_name . ',
		            <br/><br/>
		            <p>Your giftcard has been sent to ' . $purchase->receiver_name . '!</p>
		            <p>You can view it by clicking here: <a href="' . $check_url_with_code . '">' . $check_url_with_code . '</a></p>
		            <p>Or if you prefer, you can go to <a href="' . $check_url . '">' . $check_url . '</a> and type your giftcard code (' . $purchase->sender_code . ') in the "Search" box. The code is valid for 10 days from the moment the giftcard is sent.</p>
		            <p>Note: This is an auto generated email. Please do not reply.</p>
		            <br/><br/>
		            Thanks!
		            ';

		            $body = file_get_contents('../email-template/notification.html');
		            $body = str_replace("%site_name%", account_globals::getvalue($account->id, "site_name"), $body);
		            $body = str_replace("%site_link%", account_globals::getvalue($account->id, "site_link"), $body);
		            $body = str_replace("%site_logo%", BASE_PATH . "assets/" . $account->id . "/" . account_globals::getvalue($account->id, "site_logo"), $body);
		            $body = str_replace("%texthere%", $body_content, $body);
		            $mail->AltBody = 'Please use a HTML compatible email client to read this message!';
		            $mail->MsgHTML($body);
		            $mail->AddAddress($purchase->sender_email);
		            $mail->SetFrom('no-reply@driveprofit.com', account_globals::getvalue($account->id, "site_name"));
	                $mail->Send();				
				}
				else
				{
					$purchase->sent_status = "error";
				}
				$purchase->save();

			}
		}

	}
}

?>