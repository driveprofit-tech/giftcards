<?php

class controller
{
///////////////////////////////////////////////////////////////////////////////////

    function controller(){
        

    }//end function controller (constructor)

///////////////////////////////////////////////////////////////////////////////////

    function home(){
        
        echo "Nothing here!";
        exit;
        
    }//end home

///////////////////////////////////////////////////////////////////////////////////

    function send_giftcard()
    {
    
        $account = MyActiveRecord::FindFirst('account', array("id"=>$_GET['account'], "status"=>"active"));
        if (!is_object($account))
        {
            header("Location: " . BASE_PATH);
            exit();
        }
        $site_name = account_globals::getvalue($account->id, "site_name");       

        if(isset($_GET['step']) && $_GET['step'] > 0)
        {
            $step = $_GET['step'];
        }
        else
        {
            $step = 1;
        } 

        if(($step > 1 && !isset($_SESSION["giftcards"]['step1'])) || ($step > 2 && !isset($_SESSION["giftcards"]['step2'])))
        {
            header('Location:' . BASE_PATH . $account->name . "/send-giftcard");
        }  

        if(isset($_POST) && sizeof($_POST) > 0)
        {
            if ($_POST['step'] == 1)
            {

                $_SESSION["giftcards"]['step1'] = $_POST;
                header('Location:' . BASE_PATH . $account->name . "/send-giftcard/step-2");
                exit;
                
            }
            elseif ($_POST['step'] == 2)
            {

                $_SESSION["giftcards"]['step2'] = $_POST;
                header('Location:' . BASE_PATH . $account->name . "/send-giftcard/step-3");
                exit;
                
            }
            elseif ($_POST['step'] == 3)
            {

                $DATA1 = $_SESSION["giftcards"]['step1'];
                $DATA2 = $_SESSION["giftcards"]['step2'];
                
                $giftcard = MyActiveRecord::FindFirst('account_giftcard', array("account_id"=>$account->id, "id"=>$DATA1['giftcard_id']), "id DESC");

                $payment_gateway = account_globals::getvalue($account->id, "payment_gateway");

                $NEW_DATA = array();
                $NEW_DATA['sender_code'] = strtoupper(gen_uuid(8));
                $NEW_DATA['receiver_code'] = strtoupper(gen_uuid(8));
                $NEW_DATA['account_id'] = $account->id;
                $NEW_DATA['account_giftcard_id'] = $DATA1['giftcard_id'];
                $NEW_DATA['benefits'] = $giftcard->description; 
                $NEW_DATA['sender_name'] = $DATA2['sender_name'];
                $NEW_DATA['receiver_name'] = $DATA2['receiver_name'];
                $NEW_DATA['sender_email'] = $DATA2['sender_email'];
                $NEW_DATA['receiver_email'] = $DATA2['receiver_email'];
                $NEW_DATA['message'] = $DATA2['message'];
                $NEW_DATA['send_on'] = ($DATA2['send_when'] == "future") ? date_format(date_create_from_format('m/d/Y h:i a', $DATA2['send_on']), 'Y-m-d H:i:s') : date('Y-m-d H:i:s');
                $NEW_DATA['price_total'] = $giftcard->price;                                
                $NEW_DATA['payment_gateway'] = $payment_gateway;
                $NEW_DATA['payment_status'] = "not_paid";
                $NEW_DATA['payment_response'] = "";
                $NEW_DATA['sent_status'] = "queued";
                $NEW_DATA['opened_status'] = "not_opened";
                $NEW_DATA['received_notification'] = isset($DATA2['received_notification']) && $DATA2['received_notification'] == 1 ? "on" : "off";
                $NEW_DATA['received_notified'] = "off";
                $NEW_DATA['redeemed'] = "off";

                $account_purchase = new account_purchase();
                $account_purchase->populate($NEW_DATA);
                $account_purchase->save();

                unset($_SESSION["giftcards"]);

                $x_description = $giftcard->description;

                switch ($payment_gateway)
                {
                    case 'authorize':
                        $authorize_sandbox = account_globals::getvalue($account->id, "authorize_sandbox");
                        if ($authorize_sandbox == "on")
                        {
                            $authorize_api_login_id = AUTHORIZENET_API_LOGIN_ID_SANDBOX;
                            $authorize_transaction_key = AUTHORIZENET_TRANSACTION_KEY_SANDBOX;
                            $authorize_signature_key = AUTHORIZENET_SIGNATURE_SANDBOX;
                            $payment_url = AUTHORIZENET_PAYMENT_URL_SANDBOX;
                        }
                        else
                        {
                            $authorize_api_login_id = account_globals::getvalue($account->id, "authorize_api_login_id");
                            $authorize_transaction_key = account_globals::getvalue($account->id, "authorize_transaction_key");
                            $authorize_signature_key = account_globals::getvalue($account->id, "authorize_signature_key");
                            $payment_url = AUTHORIZENET_PAYMENT_URL_LIVE;
                        }
                        break;
                    case 'paypal':
                        $payment_url = BASE_PATH . $account->name . "/paypal";
                        break;
                    default:
                        $_SESSION['tempalert'] = "There was a problem saving your request!";
                        header("Location: " . BASE_PATH . $account->name);
                        exit();
                }

                $AUTH_DATA['x_login'] = $authorize_api_login_id;
                $AUTH_DATA['x_show_form'] = "PAYMENT_FORM";
                $AUTH_DATA['x_cust_id'] = $account_purchase->id;
                $AUTH_DATA['x_email'] = $NEW_DATA['sender_email'];
                $AUTH_DATA['x_email_customer'] = "TRUE";
                $AUTH_DATA['x_amount'] = $NEW_DATA['price_total'];
                $AUTH_DATA['x_currency_code'] = "USD";
                $AUTH_DATA['x_invoice_num'] =  $NEW_DATA['sender_code'];
                $AUTH_DATA['x_description'] = "Giftcard";
                $AUTH_DATA['x_relay_response'] = "TRUE";
                $AUTH_DATA['x_relay_url'] = BASE_PATH . $account->name . "/payment-confirm";
                $AUTH_DATA['x_fp_sequence'] = $account_purchase->id;

                date_default_timezone_set('UTC');
                $AUTH_DATA['x_fp_timestamp'] = time();
                date_default_timezone_set('America/New_York');

                $signatureKey = $authorize_signature_key;
                $signatureKey = hex2bin($signatureKey);
                $AUTH_DATA['x_fp_hash'] = strtoupper(HASH_HMAC('sha512', $authorize_api_login_id . "^" . $AUTH_DATA['x_fp_sequence'] . "^" . $AUTH_DATA['x_fp_timestamp'] . "^" . $AUTH_DATA['x_amount'] . "^" . $AUTH_DATA['x_currency_code'], $signatureKey));

                //var_dump($AUTH_DATA);
                //exit;

                echo "
                    <html>
                        <head>
                            <meta name=\"robots\" content=\"noindex\" />
                        </head>
                        <body>
                            <form name=\"post_it\" method=\"post\" action=\"" . $payment_url . "\">";
                foreach ($AUTH_DATA as $key => $value) {
                    echo "<input type=\"hidden\" name=\"" . $key . "\" value=\"" . $value . "\" />";
                }

                echo "      </form>
                            <script language=\"JavaScript\">document.post_it.submit();</script>
                        </body>
                    </html>";
                exit();
                
            }

        }

        include_once("pages/header.php");
        include_once("pages/send-giftcard.php");
        include_once("pages/footer.php");
        
    }//end send_giftcard

    /////////////////////////////////

    function check_giftcard()
    {
    
        $account = MyActiveRecord::FindFirst('account', array("id"=>$_GET['account'], "status"=>"active"));
        if (!is_object($account))
        {
            header("Location: " . BASE_PATH);
            exit();
        }
        $site_name = account_globals::getvalue($account->id, "site_name");    

        $err_msg = "";
        if(isset($_GET['code']) && ($_GET['code'] != ""))
        {
            $purchase = MyActiveRecord::FindFirst('account_purchase', "account_id = " . MyActiveRecord::Escape($account->id) . " AND (UPPER(sender_code) = " . MyActiveRecord::Escape(strtoupper($_GET['code'])) . " OR UPPER(receiver_code) = " . MyActiveRecord::Escape(strtoupper($_GET['code'])) . ") AND (DATE_ADD(sent_on, INTERVAL 10 DAY) > NOW() OR sent_status = 'queued')");
            if(empty($purchase))
            {
                 $err_msg = "The code does not exist or has expired!";
            }
            else
            {
                if(strtoupper($purchase->receiver_code) == strtoupper($_GET['code']) && $purchase->received_notification == "on" && $purchase->received_notified == "off")
                {
                    $purchase->received_notified = "on";    
                    $purchase->save();

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
                    $mail->Subject = "Giftcard has been viewed by " . $purchase->receiver_name . "!";

                    $body_content = '
                    Hi ' . $purchase->sender_name . ',
                    <br/><br/>
                    <p>' . $purchase->receiver_name . ' has just viewed the giftcard (' . $purchase->sender_code . ') you sent on ' . date("j M Y", strtotime($purchase->sent_on)) . '.</p>
                    <p>Note: This is an auto generated email. Please do not reply.</p>
                    <br/><br/>
                    Thanks!
                    ';

                    $body = file_get_contents('email-template/notification.html');
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
            }
        }   

        include_once("pages/header.php");
        include_once("pages/check-giftcard.php");
        include_once("pages/footer.php");
        
    }//end check_giftcard

    /////////////////////////////////

    function paypal() {

        $account = MyActiveRecord::FindFirst('account', array("id"=>$_GET['account'], "status"=>"active"));
        if (!is_object($account))
        {
            header("Location: " . BASE_PATH);
            exit();
        }
        $site_name = account_globals::getvalue($account->id, "site_name");   
       
        if ($_POST['gateway'] == 'PayPal') 
        {
            
            require_once("php/lib/paypal_pro.inc.php");

            $account_purchase = MyActiveRecord::FindFirst('account_purchase', array("id" => $_POST['purchase']));
            $account_id = $account_purchase->account_id;
            $price_total = $account_purchase->price_total;

            $API_SANDBOX = account_globals::getvalue($account->id, "paypal_sandbox") == "on";
            
            if($API_SANDBOX) {
                $API_USERNAME = PAYPAL_API_USERNAME;
                $API_PASSWORD = PAYPAL_API_PASSWORD;
                $API_SIGNATURE = PAYPAL_API_SIGNATURE;
               
            } else {
                $API_USERNAME = account_globals::getvalue($account->id, "paypal_username");
                $API_PASSWORD = account_globals::getvalue($account->id, "paypal_password");
                $API_SIGNATURE = account_globals::getvalue($account->id, "paypal_signature");
            }
            
            $pp = [];
            $pp['PAYMENTACTION'] = urlencode("Sale");
            $pp['AMT'] = urlencode($price_total);
            $pp['CREDITCARDTYPE'] = urlencode($_POST['card_type']);
            $pp['ACCT'] = urlencode($_POST['card_number']);
            $pp['EXPDATE'] = urlencode($_POST['expiry_month'] . $_POST['expiry_year']);
            $pp['CVV2'] = urlencode($_POST['cvv']);
            $pp['FIRSTNAME'] = urlencode(explode(' ', $_POST['name_on_card'])[0]);
            $pp['LASTNAME'] = urlencode(explode(' ', $_POST['name_on_card'])[1]);
            $pp['STREET'] = urlencode($_POST['address']);
            $pp['CITY'] = urlencode($_POST['city']);
            $pp['STATE'] = urlencode($_POST['state']);
            $pp['ZIP'] = urlencode($_POST['zip']);
            $pp['COUNTRYCODE'] = urlencode($_POST['US']);
            $pp['CURRENCYCODE'] = urlencode($_POST['USD']);

            $nvpstr = '';
            foreach ($pp as $k => $v)
                $nvpstr .= "&$k=$v";

            $paypalPro = new paypal_pro($API_USERNAME, $API_PASSWORD, $API_SIGNATURE, '', '', $API_SANDBOX);
            $resArray = $paypalPro->hash_call('doDirectPayment', $nvpstr);

            $resArray['x_response_code'] = $resArray['AVSCODE'];
            $resArray['x_trans_id'] = $resArray['TRANSACTIONID'];
            $resArray['x_amount'] = $resArray['AMT'];
            $resArray['x_SHA2_Hash'] = $resArray['CORRELATIONID'];
            $resArray['x_cust_id'] = $_POST['purchase'];
            $resArray['x_description'] = $_POST['description'];
            $resArray['x_response_reason_text'] = $resArray['L_LONGMESSAGE0'];

            $resArray['x_address'] = $_POST['address'];
            $resArray['x_city'] = $_POST['city'];
            $resArray['x_state'] = $_POST['state'];
            $resArray['x_zip'] = $_POST['zip'];
            $resArray['x_card_type'] = $_POST['card_type'];

            echo "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"><meta name=\"robots\" content=\"noindex\" /></head>
            <body><form name=\"post_it\" method=\"post\" action=\"" . BASE_PATH . $account->name . "/payment-confirm\">";
            foreach ($resArray as $key => $value) {
                echo "<input type=\"hidden\" name=\"" . $key . "\" value=\"" . $value . "\" />";
            }
            echo "</form><script language=\"JavaScript\">document.post_it.submit();</script></body></html>";
            exit();
        }
        
        $account_purchase = MyActiveRecord::FindFirst('account_purchase', array("id" => $_POST['x_cust_id']));
        $x_description = $_POST['x_description'];
        $total_price = $_POST['x_amount'];
        
        include_once("pages/header.php");
        include_once("pages/paypal.php");
        include_once("pages/footer.php");
    }

    /////////////////////////////////

    function payment()
    {
    
        $account = MyActiveRecord::FindFirst('account', array("id"=>$_GET['account'], "status"=>"active"));
        if (!is_object($account))
        {
            header("Location: " . BASE_PATH);
            exit();
        }
        $site_name = account_globals::getvalue($account->id, "site_name");    



        include_once("pages/header.php");
        include_once("pages/payment.php");
        include_once("pages/footer.php");
        
    }//end payment

    /////////////////////////////////

    function payment_confirm()
    {
    
        $account = MyActiveRecord::FindFirst('account', array("id"=>$_GET['account'], "status"=>"active"));
        if (!is_object($account))
        {
            header("Location: " . BASE_PATH);
            exit();
        }
        $site_name = account_globals::getvalue($account->id, "site_name");    

        /*
         // Send email with payment response
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = "smtp.sparkpostmail.com";
        $mail->Port = 587;
        $mail->Username = "SMTP_Injection";
        $mail->Password = "294a7e4e65999ea3515939f2a992c0170cac6376";
        $mail->Subject = "AUTH POST";
        $mail->AltBody = 'Please use a HTML compatible email client to read this message!';
        $mail->MsgHTML(serialize($_POST));
        $mail->AddAddress("roxana@tech360group.com");
        $mail->SetFrom('no-reply@driveprofit.com', account_globals::getvalue($account_id, "site_name"));

        if (!$mail->Send()) {
            $mail->Send();
        }

        exit;
        */
            
        $POST_DATA = $_POST;
        
        /*
        $POST_DATA = unserialize('a:22:{s:9:"TIMESTAMP";s:20:"2021-01-08T07:14:31Z";s:13:"CORRELATIONID";s:13:"d789a72a5dd17";s:3:"ACK";s:7:"Success";s:7:"VERSION";s:4:"57.0";s:5:"BUILD";s:8:"55025969";s:3:"AMT";s:5:"25.00";s:12:"CURRENCYCODE";s:3:"USD";s:7:"AVSCODE";s:1:"A";s:9:"CVV2MATCH";s:1:"M";s:13:"TRANSACTIONID";s:17:"6DA860660X780772F";s:15:"x_response_code";s:1:"A";s:10:"x_trans_id";s:17:"6DA860660X780772F";s:8:"x_amount";s:5:"25.00";s:11:"x_SHA2_Hash";s:13:"d789a72a5dd17";s:9:"x_cust_id";s:0:"";s:13:"x_description";s:8:"Giftcard";s:22:"x_response_reason_text";s:0:"";s:9:"x_address";s:3:"fdg";s:6:"x_city";s:1:"g";s:7:"x_state";s:2:"IN";s:5:"x_zip";s:3:"dfg";s:11:"x_card_type";s:0:"";}');
        echo "<pre>";
        print_r($POST_DATA);
        echo "</pre>";
        exit;
        */    

        if ((sizeof($POST_DATA) > 0) && isset($POST_DATA['x_response_code']) && isset($POST_DATA['x_trans_id']) && isset($POST_DATA['x_amount']) && isset($POST_DATA['x_SHA2_Hash'])) 
        {

            $account_purchase = MyActiveRecord::FindFirst('account_purchase', array("id" => $POST_DATA['x_cust_id']));
            $account_id = $account_purchase->account_id;
            $account = MyActiveRecord::FindFirst('account', array("id" => $account_id, "status" => "active")); 

            switch (account_globals::getvalue($account->id, "payment_gateway")) {
                case 'authorize':
                    $authorize_sandbox = account_globals::getvalue($account->id, "authorize_sandbox");
                    if ($authorize_sandbox == "on") {
                        $authorize_api_login_id = AUTHORIZENET_API_LOGIN_ID_SANDBOX;
                        $authorize_transaction_key = AUTHORIZENET_TRANSACTION_KEY_SANDBOX;
                        $authorize_signature_key = AUTHORIZENET_SIGNATURE_SANDBOX;
                    } else {
                        $authorize_api_login_id = account_globals::getvalue($account->id, "authorize_api_login_id");
                        $authorize_transaction_key = account_globals::getvalue($account->id, "authorize_transaction_key");
                        $authorize_signature_key = account_globals::getvalue($account->id, "authorize_signature_key");
                    }                   

                    $signatureKey = $authorize_signature_key;
                    $signatureKey = hex2bin($signatureKey);
                    $fields_keys = array("x_trans_id", "x_test_request", "x_response_code", "x_auth_code", "x_cvv2_resp_code", "x_cavv_response", "x_avs_code", "x_method", "x_account_number", "x_amount", "x_company", "x_first_name", "x_last_name", "x_address", "x_city", "x_state", "x_zip", "x_country", "x_phone", "x_fax", "x_email", "x_ship_to_company", "x_ship_to_first_name", "x_ship_to_last_name", "x_ship_to_address", "x_ship_to_city", "x_ship_to_state", "x_ship_to_zip", "x_ship_to_country", "x_invoice_num");
                    $fields = array();
                    foreach ($fields_keys as $key) {
                        $fields[] = isset($POST_DATA[$key]) ? $POST_DATA[$key] : "";
                    }
                    $check_hash = strtoupper(HASH_HMAC('sha512', '^' . implode('^', $fields) . '^', $signatureKey));
                    $payment_success = hash_equals($check_hash, $POST_DATA['x_SHA2_Hash']);

                    break;
                
                case 'paypal':

                    $POST_DATA['x_response_code'] = (strtoupper($POST_DATA["ACK"]) == "SUCCESS") * 1;
                    $POST_DATA['x_first_name'] = $account_purchase->sender_name;
                    $POST_DATA['x_last_name'] = "";
                    $POST_DATA['x_country'] = 'US';
                    $POST_DATA['x_email'] = $account_purchase->sender_email;
                    $POST_DATA['x_phone'] = "";
                    $POST_DATA['x_ship_to_first_name'] = $account_purchase->sender_name;
                    $POST_DATA['x_ship_to_last_name'] = "";
                    $POST_DATA['x_ship_to_address'] = $POST_DATA['x_address'];
                    $POST_DATA['x_ship_to_city'] = $POST_DATA['x_city'];
                    $POST_DATA['x_ship_to_zip'] = $POST_DATA['x_zip'];
                    $POST_DATA['x_ship_to_country'] = 'US';
                    $POST_DATA['x_auth_code'] = $POST_DATA['CORRELATIONID'];
                    $POST_DATA['x_card_type'] = 'Paypal';
                    $POST_DATA['x_account_number'] = $POST_DATA['x_email'];
                    $POST_DATA['x_invoice_num'] = $account_purchase->sender_code;
                    $payment_success = 1;
                    break;

                default : $payment_success = 0;
            }

            if ($payment_success) {

                if (!empty($account_purchase) && ($account_purchase->payment_status == "not_paid")) {

                    if ($POST_DATA['x_response_code'] == 1)
                    {

                        $account_purchase->populate(array("payment_status" => "paid", "payment_response" => serialize(($POST_DATA))));
                        $account_purchase->save();

                        $check_url_with_code = BASE_PATH . $account->name . "/check-giftcard?code=" . $account_purchase->sender_code;
                        $check_url = BASE_PATH . $account->name . "/check-giftcard";
                        
                        // Send email to sender
                        $mail = new PHPMailer();
                        $mail->IsSMTP();
                        $mail->SMTPAuth = true;
                        $mail->Host = "smtp.sparkpostmail.com";
                        $mail->Port = 587;
                        $mail->Username = "SMTP_Injection";
                        $mail->Password = "294a7e4e65999ea3515939f2a992c0170cac6376";
                        $mail->Subject = "Giftcard confirmation";

                        $body_content = '
                        Hi ' . $account_purchase->sender_name . ',
                        <br/><br/>
                        <p>Thank you for your purchase! Your giftcard will reach ' . $account_purchase->receiver_name . '\'s mailbox according to the selected schedule and you will receive a notification at the time of sending!</p>
                        <p>In the meantime, you can view it by clicking here: <a href="' . $check_url_with_code . '">' . $check_url_with_code . '</a></p>
                        <p>Or if you prefer, you can go to <a href="' . $check_url . '">' . $check_url . '</a> and type your giftcard code (' . $account_purchase->sender_code . ') in the "Search" box. The code is valid for 10 days from the moment the giftcard is sent.</p>
                        <p>Note: This is an auto generated email. Please do not reply.</p>
                        <br/><br/>
                        Thanks!
                        ';

                        $body = file_get_contents('email-template/notification.html');
                        $body = str_replace("%site_name%", account_globals::getvalue($account_id, "site_name"), $body);
                        $body = str_replace("%site_link%", account_globals::getvalue($account_id, "site_link"), $body);
                        $body = str_replace("%site_logo%", BASE_PATH . "assets/" . $account_id . "/" . account_globals::getvalue($account_id, "site_logo"), $body);
                        $body = str_replace("%texthere%", $body_content, $body);
                        $mail->AltBody = 'Please use a HTML compatible email client to read this message!';
                        $mail->MsgHTML($body);
                        $mail->AddAddress($account_purchase->sender_email);
                        $mail->SetFrom('no-reply@driveprofit.com', account_globals::getvalue($account_id, "site_name"));

                        if (!$mail->Send()) {
                            $mail->Send();
                        }

                        header('Location:' . $check_url_with_code);            
                        exit();

                    } 
                    else
                    {
                        $account_purchase->populate(array("payment_status" => "rejected", "payment_response" => serialize(($_POST))));
                        $account_purchase->save();

                        header("Location: " . BASE_PATH . $account->name);
                        exit();
                    }
                }
            }

            // If some error and non of the redirects above was made 
            header("Location: " . BASE_PATH . $account->name);
            exit;
        }


    }//end payment_confirm

    /////////////////////////////////

    function error404(){

        include_once("pages/error404.php");

    }//end error404

///////////////////////////////////////////////////////////////////////////////////


}//end class c_ajax

?>