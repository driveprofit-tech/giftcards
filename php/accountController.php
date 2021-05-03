<?php

class controller
{
///////////////////////////////////////////////////////////////////////////////////

	function controller(){

        // Save redirect url in session (if we have some valid one) - We'll use it to force redirects in certain cases
        if (isset($_GET['u']) && ($_GET['u'] != "") && filter_var(rawurldecode($_GET['u']), FILTER_VALIDATE_URL))
        {
            $_SESSION['redirurl'] = rawurldecode($_GET['u']);
        }
        
        if($_SESSION['loggedin'] != "yes" && $_GET['page'] != "login" && $_GET['page'] != "logout" && $_GET['page'] != "sulogin" && $_GET['page'] != "sso"){

             // Check autologin cookie
            $autologin = false;
            $cookie_val = $_COOKIE["remember_login_" . session_name()];
            if ($cookie_val != "")
            {
                // Extract cookie data
                $cookie_decode = base64_decode($cookie_val);
                $cookie_data = explode("~", $cookie_decode);

                // If it seems valid data
                if ($cookie_data[0] != "" && $cookie_data[0] > 0 && $cookie_data[1] != "" && strpos($cookie_data[1], "@"))
                {
                    // Get user by cookie data
                    $theuser = MyActiveRecord::FindFirst('account_user', array("id"=>$cookie_data[0], "email"=>$cookie_data[1], "status"=>"active"));

                    // If user found
                    if (is_object($theuser))
                    {
                        
                        $account = MyActiveRecord::FindFirst('account', array("id"=>$theuser->account_id));

                        $restrict_ip_addresses = array();
                        if ($theuser->access_ip != "")
                        {
                            foreach (explode(",", $theuser->access_ip) as $key => $value) {
                                $restrict_ip_addresses[] = trim($value);
                            }
                        }

                        // Check ip restrictions
                        if ((sizeof($restrict_ip_addresses) == 0) || in_array($_SERVER['REMOTE_ADDR'], $restrict_ip_addresses))
                        {
                            $autologin = true;
                            
                            $_SESSION['loggedin'] = "yes";
                            $_SESSION['errorcount'] = 0;
                            $_SESSION['user']['id'] = $theuser->id;
                            $_SESSION['user']['admin'] = $theuser->admin;
                            $_SESSION['user']['account_id'] = $theuser->account_id;
                            $_SESSION['user']['email'] = $theuser->email;

                            // Save login log
                            $NEW_DATA = array();
                            $NEW_DATA['account_id'] = $theuser->account_id;
                            $NEW_DATA['user_id'] = $theuser->id;
                            $NEW_DATA['sulogin'] = 0;       
                            $NEW_DATA['ip'] = $_SERVER['REMOTE_ADDR'];
                            $NEW_DATA['moment'] = MyActiveRecord::DbDateTime();
                            $account_user_logs = new account_user_logs();
                            $account_user_logs->populate($NEW_DATA);
                            $account_user_logs->save();
                        }

                    }
                    else
                    {
                        // Wrong cookie, clean it up
                        unset($_COOKIE["remember_login_" . session_name()]);
                        setcookie("remember_login_" . session_name(), null, -1);
                    }
                }  
                else
                {
                    // Wrong cookie, clean it up
                    unset($_COOKIE["remember_login_" . session_name()]);
                    setcookie("remember_login_" . session_name(), null, -1);
                }

            }

            // If not autologin, send to login
            if (!$autologin)
            {
                header("Location: index.php?page=logout");
                exit();
            }

        }

        $_SESSION['return_page'] = rawurlencode(str_replace("page=", "", $_SERVER['QUERY_STRING']));

    }
    //end function controller (constructor)

///////////////////////////////////////////////////////////////////////////////////

    function sulogin(){

        if (isset($_GET['sess'])) 
        {
            $sess_data = explode("-", base64_decode($_GET['sess']), 5);
            
            $account_id = $sess_data[0];
            $rand_seed = $sess_data[1];
            $ip = $sess_data[2];
            $time = $sess_data[3] - $rand_seed * $account_id;
            $salt = $sess_data[4];

            // Make sure is the same ip address and the timestamp is not older than 30 minutes
            if((time() - $time <= 30 * 60) && ($ip == $_SERVER['REMOTE_ADDR']) && ($salt == APP_SALT))
            {
                $account = MyActiveRecord::FindFirst('account', array("id"=>$account_id, "status"=>"active"));
                if (!empty($account))
                {
                    $theuser = MyActiveRecord::FindFirst('account_user', array("account_id"=>$account_id, "admin"=>"on", "status"=>"active"), "id ASC");
                    if (!empty($theuser))
                    {
                        $_SESSION['loggedin'] = "yes";
                        $_SESSION['errorcount'] = 0;
                        $_SESSION['user']['id'] = $theuser->id;
                        $_SESSION['user']['admin'] = $theuser->admin;
                        $_SESSION['user']['account_id'] = $theuser->account_id;
                        $_SESSION['user']['email'] = $theuser->email;
                        $_SESSION['user']['fake'] = true;

                        // Save login log
                        $NEW_DATA = array();
                        $NEW_DATA['account_id'] = $theuser->account_id;
                        $NEW_DATA['user_id'] = $theuser->id;
                        $NEW_DATA['sulogin'] = 1;       
                        $NEW_DATA['ip'] = $_SERVER['REMOTE_ADDR'];
                        $NEW_DATA['moment'] = MyActiveRecord::DbDateTime();
                        $account_user_logs = new account_user_logs();
                        $account_user_logs->populate($NEW_DATA);
                        $account_user_logs->save();

                        header("Location: index.php?page=home");
                        exit();
                    }
                }
            }

        }       

    }
    //end sulogin

///////////////////////////////////////////////////////////////////////////////////

    function login(){
        
        if(strlen($_POST['user']) > 2 && strlen($_POST['password']) > 2){
            
            // Only if not too many errors
            if($_SESSION['errorcount'] < 5)
            {
                // Get user by username from post
                $theuser = MyActiveRecord::FindFirst('account_user', array("email" => $_POST['user'], "status"=>"active"));

                // If user found
                if (is_object($theuser))
                {

                    $account = MyActiveRecord::FindFirst('account', array("id"=>$theuser->account_id));

                    $restrict_ip_addresses = array();
                    if ($theuser->access_ip != "")
                    {
                        foreach (explode(",", $theuser->access_ip) as $key => $value) {
                            $restrict_ip_addresses[] = trim($value);
                        }
                    }

                    // Check ip restrictions
                    if ((sizeof($restrict_ip_addresses) == 0) || in_array($_SERVER['REMOTE_ADDR'], $restrict_ip_addresses))
                    {
                        // Check password
                        if(md5($_POST['password']) == $theuser->password)
                        {
                                $_SESSION['loggedin'] = "yes";
                                $_SESSION['errorcount'] = 0;
                                $_SESSION['user']['id'] = $theuser->id;
                                $_SESSION['user']['admin'] = $theuser->admin;
                                $_SESSION['user']['account_id'] = $theuser->account_id;
                                $_SESSION['user']['email'] = $theuser->email;

                                // Save login log
                                $NEW_DATA = array();
                                $NEW_DATA['account_id'] = $theuser->account_id;
                                $NEW_DATA['user_id'] = $theuser->id;
                                $NEW_DATA['sulogin'] = 0;       
                                $NEW_DATA['ip'] = $_SERVER['REMOTE_ADDR'];
                                $NEW_DATA['moment'] = MyActiveRecord::DbDateTime();
                                $account_user_logs = new account_user_logs();
                                $account_user_logs->populate($NEW_DATA);
                                $account_user_logs->save();

                                // Set remember me cookie
                                if ($_POST['remember_login'] == "yes")
                                {
                                    $value = base64_encode($theuser->id . "~" . $theuser->email);
                                    setcookie("remember_login_" . session_name(), $value, time() + (100 * 24 * 60 * 60));
                                }

                                // If we have a certain page that we have to go to
                                if (isset($_SESSION['redirurl']) && ($_SESSION['redirurl'] != ""))
                                {
                                    $redirect_to = $_SESSION['redirurl'];
                                    unset($_SESSION['redirurl']);
                                }
                                // Otherwise, go to home
                                else
                                {
                                    $redirect_to = "index.php?page=home";
                                }
                                header("Location: " . $redirect_to);                    
                                exit();
                        }
                        else
                        {
                            $_SESSION['tempalert'] = "Username or password incorrect!";
                            $_SESSION['errorcount'] ++;
                        }
                    }
                    else
                    {
                        $_SESSION['tempalert'] = "Your user is not permitted to access the system from your current IP address!";                       
                        $msg = "IP address not allowed on: " . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                        $msg .= "<br/>Account ID: " . $theuser->account_id;
                        $msg .= "<br/>User: " . $_POST['user'];
                        $msg .= "<br/>Allowed IP: " . $theuser->access_ip;
                        $msg .= "<br/>IP Address: " . $_SERVER['REMOTE_ADDR'];                  
                        mail("tech@driveprofit.com", "IP address not allowed", $msg);                       
                    }
                } 
                else
                {
                    $_SESSION['tempalert'] = "Username or password incorrect!";
                    $_SESSION['errorcount'] ++;
                }               
            }
            else
            {
                $_SESSION['tempalert'] = "Username or password incorrect! Please note that after 5 failed attempts you are locked out!";
                $msg = "Password wrong on: " . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                $msg .= "<br/>IP Address: " . $_SERVER['REMOTE_ADDR'];
                $msg .= "<br/>POST user: " . $_POST['user'];
                $msg .= "<br/>POST password: " . $_POST['password'];
                mail("tech@driveprofit.com", "Pasword wrong 5 times", $msg);                
            }
        }

        $pgtitle = globals::getvalue("site_name") . " - Login";
        include_once("pages/login.php");

    }
    //end login

///////////////////////////////////////////////////////////////////////////////////

    function logout(){

         // Unset remember cookie
        unset($_COOKIE["remember_login_" . session_name()]);
        setcookie("remember_login_" . session_name(), null, -1);

        unset($_SESSION['loggedin']);
        session_destroy();

        header("Location: index.php?page=login");
        exit();

    }
    //end logout

///////////////////////////////////////////////////////////////////////////////////

    function home(){

        if($_SESSION['user']['admin'] == "on")
        {
            $count_giftcards = MyActiveRecord::Count("account_giftcard", array("account_id"=>$_SESSION['user']['account_id'], "status"=>"active"));
            $count_purchases = MyActiveRecord::Count("account_purchase", array("account_id"=>$_SESSION['user']['account_id'], "payment_status"=>"paid"));
        }

        
        $pgtitle = account_globals::getvalue($_SESSION['user']['account_id'], "site_name") . " - Dashboard";
        $onpgtitle = "Dashboard";
        
        include_once("pages/header.php");
        include_once("pages/home.php");
        include_once("pages/footer.php");

    }
    //end home

///////////////////////////////////////////////////////////////////////////////////

    // Global variables management
    function globals(){

        if($_SESSION['user']['admin'] != "on")
        {
            session_destroy();
            header("Location: index.php?page=login");
            exit();
        }

        $account = MyActiveRecord::FindFirst("account", array("id"=>$_SESSION['user']['account_id']));
        
        ////set allowed values here
        $group_settings = array(
            "general" => array("name"=>"General settings", "hint"=>"", "warning"=>"", "settings"=>array("site_name", "site_link", "site_favicon", "site_logo", "contact_link", "terms_of_use_link", "privacy_policy_link", "payment_gateway", "time_zone")),
            "design_customization" => array("name"=>"Design customization", "hint"=>"", "warning"=>"", "settings"=>array("background_image", "font_family", "font_size", "font_unit_size", "main_color", "background_color", "text_color", "custom_css")),
            "text_customization" => array("name"=>"Text customization", "hint"=>"", "warning"=>"", "settings"=>array("intro_text", "disclaimer_text")),
        );

         // Get a list of existing settings
        $itemstolist = MyActiveRecord::FindBySql('account_globals', "SELECT * FROM account_globals WHERE account_id = " . MyActiveRecord::Escape($_SESSION['user']['account_id']) . " ORDER BY name ASC", "name");

        if ($itemstolist['payment_gateway']->value == "authorize")
        {
            $group_settings['authorize'] = array("name" => "Authorize.Net settings", "hint" => "", "warning" => "For security reasons, the credentials entered here will be partially visible at any other time on this section. If you want to edit a setting, you'll have to re-enter it.", "settings" => array("authorize_sandbox", "authorize_api_login_id", "authorize_transaction_key", "authorize_signature_key"));
        }

        if ($itemstolist['payment_gateway']->value == "paypal")
        {
            $group_settings['paypal'] = array("name" => "PayPal settings", "hint" => "", "warning" => "For security reasons, the credentials entered here will be partially visible at any other time on this section. If you want to edit a setting, you'll have to re-enter it.", "settings" => array("paypal_sandbox", "paypal_username", "paypal_password", "paypal_signature"));
        }
       
        if ($_GET['action'] == "check_domain")
        {
            
            $domain = trim($_POST['check_domain']);
            $domain = str_replace(array("http://", "https://"), "", $domain);                       
            if(!preg_match("/^(?:[-A-Za-z0-9]+\.)+[A-Za-z]{2,6}$/", $domain))
            {
                echo "<span class=\"text-danger\">The domain does not seem valid!</span>";
            }
            else
            {
                $ip = gethostbyname($domain);
                if($ip != MAIN_IP)
                {
                    echo "<span class=\"text-danger\">The domain does not resolve to " . MAIN_IP . "!</span>";
                }
                else
                {
                    echo "<span class=\"text-success\">The domain correctly resolves to " . MAIN_IP . "!</span>";
                }
            }
            exit;
        }
        
        // When the form is submitted
        if (isset($_POST['save']) && ($_POST['save'] == "save"))
        {
            // Loop by existing settings
            foreach ($_POST as $key => $value)
            {
                if($key == "save" || $key == "group"){
                    continue;
                }
                elseif ($key == "authorize_api_login_id" && $value == "")
                {
                    continue;
                } 
                elseif ($key == "authorize_transaction_key" && $value == "")
                {
                    continue;
                }
                elseif ($key == "authorize_mdhash" && $value == "")
                {
                    continue;
                }
                elseif ($key == "authorize_signature_key" && $value == "")
                {
                    continue;
                }
                elseif ($key == "paypal_password" && $value == "")
                {
                    continue;
                }
                elseif ($key == "paypal_signature" && $value == "")
                {
                    continue;
                }
                elseif ($key == "custom_booking_domain")
                {
                    $domain = trim($_POST['custom_booking_domain']);
                    $domain = str_replace(array("http://", "https://"), "", $domain);                       
                    if (preg_match("/^(?:[-A-Za-z0-9]+\.)+[A-Za-z]{2,6}$/", $domain))
                    {
                        $ip = gethostbyname($domain);
                        if($ip != MAIN_IP)
                        {
                            $value = "";
                        }
                        else
                        {
                            $value = $domain;
                        }
                    }
                    else
                    {
                        $value = "";
                    }
                }
                                
                // Update value for setting
                if (isset($_POST[$key]))
                {
                    $global = MyActiveRecord::FindById("account_globals", $itemstolist[$key]->id);
                    if(is_object($global))
                    {
                        $global->value = $value;
                        $global->save();
                    }
                    else
                    {
                        $global = new account_globals();
                        $global->name = $key;
                        $global->value = $value;
                        $global->account_id = $_SESSION['user']['account_id'];
                        $global->save();
                    }
                }
            }
               
            // Loop fields that require uploads
            if (isset($_FILES) && (sizeof($_FILES) > 0))
            {
                foreach($_FILES as $key=>$value)
                {
                    // Special case for site logo
                    if ($key == "site_logo")
                    {
                        // If a file eas uploaded
                        if(isset($_FILES['site_logo']['name']))
                        {
                            $target_dir = "../assets/" . $_SESSION['user']['account_id'] . "/";

                            // File info
                            $path_parts = pathinfo($_FILES['site_logo']['name']);
                            $name = $path_parts['filename'];
                            $extension = $path_parts['extension'];

                            // Check file extension
                            if (in_array(strtolower($extension), array("jpg", "png", "gif")))
                            {                                                                                                                   
                                
                                // Delete old file
                                if ($itemstolist[$key]->value != ""){
                                    @unlink($target_dir . $itemstolist[$key]->value);
                                }

                                // Set unique name
                                if (file_exists($target_dir . $name . "." . $extension)) {
                                    $number = 1;
                                    while (file_exists($target_dir . $name . $number . "." . $extension)){
                                        $number ++;
                                    }
                                    $name = $name . $number; 
                                }
                                
                                // Try to upload file
                                $target_file = $target_dir . $name . "." . $extension;
                                // Set new logo file name
                                if(move_uploaded_file($_FILES['site_logo']['tmp_name'], $target_file))
                                {
                                    
                                    $global = MyActiveRecord::FindById("account_globals", $itemstolist[$key]->id);
                                    if(is_object($global))
                                    {
                                        $global->populate(array("value"=>($name . "." . $extension)));
                                        $global->save();
                                    }
                                    else
                                    {
                                        $global = new account_globals();
                                        $global->name = $key;
                                        $global->value = $name . "." . $extension;
                                        $global->account_id = $_SESSION['user']['account_id'];
                                        $global->save();
                                    }
                                }
                                else
                                {
                                    $global = MyActiveRecord::FindById("account_globals", $itemstolist[$key]->id);
                                    $global->populate(array("value"=>""));
                                    $global->save();
                                }
                            }
                     
                        }
                    }
                    // Special case for site favicon
                    elseif ($key == "site_favicon")
                    {
                        // If a file eas uploaded
                        if(isset($_FILES['site_favicon']['name']))
                        {
                            $target_dir = "../assets/" . $_SESSION['user']['account_id'] . "/";

                            // File info
                            $path_parts = pathinfo($_FILES['site_favicon']['name']);
                            $name = $path_parts['filename'];
                            $extension = $path_parts['extension'];

                            // Check file extension
                            if (in_array(strtolower($extension), array("ico")))
                            {                                                                                                                   
                                
                                // Delete old file
                                if ($itemstolist[$key]->value != ""){
                                    @unlink($target_dir . $itemstolist[$key]->value);
                                }

                                // Set unique name
                                if (file_exists($target_dir . $name . "." . $extension)) {
                                    $number = 1;
                                    while (file_exists($target_dir . $name . $number . "." . $extension)){
                                        $number ++;
                                    }
                                    $name = $name . $number; 
                                }
                                
                                // Try to upload file
                                $target_file = $target_dir . $name . "." . $extension;
                                // Set new favicon file name
                                if(move_uploaded_file($_FILES['site_favicon']['tmp_name'], $target_file))
                                {
                                    $global = MyActiveRecord::FindById("account_globals", $itemstolist[$key]->id);
                                    if(is_object($global))
                                    {
                                        $global->populate(array("value"=>($name . "." . $extension)));
                                        $global->save();
                                    }
                                    else
                                    {
                                        $global = new account_globals();
                                        $global->name = $key;
                                        $global->value = $name . "." . $extension;
                                        $global->account_id = $_SESSION['user']['account_id'];
                                        $global->save();
                                    }
                                }
                                else
                                {
                                    $global = MyActiveRecord::FindById("account_globals", $itemstolist[$key]->id);
                                    $global->populate(array("value"=>""));
                                    $global->save();
                                }
                            }
                        }
                    }
                    // Special case for header image
                    elseif ($key == "header_image")
                    {
                        // If a file eas uploaded
                        if(isset($_FILES['header_image']['name']))
                        {
                            $target_dir = "../assets/" . $_SESSION['user']['account_id'] . "/";

                            // File info
                            $path_parts = pathinfo($_FILES['header_image']['name']);
                            $name = $path_parts['filename'];
                            $extension = $path_parts['extension'];

                            // Check file extension
                            if (in_array(strtolower($extension), array("jpg", "png", "gif")))
                            {                                                                                                                   
                                
                                // Delete old file
                                if ($itemstolist[$key]->value != ""){
                                    @unlink($target_dir . $itemstolist[$key]->value);
                                }

                                // Set unique name
                                if (file_exists($target_dir . $name . "." . $extension)) {
                                    $number = 1;
                                    while (file_exists($target_dir . $name . $number . "." . $extension)){
                                        $number ++;
                                    }
                                    $name = $name . $number; 
                                }
                                
                                // Try to upload file
                                $target_file = $target_dir . $name . "." . $extension;
                                // Set new favicon file name
                                if(move_uploaded_file($_FILES['header_image']['tmp_name'], $target_file))
                                {
                                    $global = MyActiveRecord::FindById("account_globals", $itemstolist[$key]->id);
                                    if(is_object($global))
                                    {
                                        $global->populate(array("value"=>($name . "." . $extension)));
                                        $global->save();
                                    }
                                    else
                                    {
                                        $global = new account_globals();
                                        $global->name = $key;
                                        $global->value = $name . "." . $extension;
                                        $global->account_id = $_SESSION['user']['account_id'];
                                        $global->save();
                                    }
                                }
                                else
                                {
                                    $global = MyActiveRecord::FindById("account_globals", $itemstolist[$key]->id);
                                    $global->populate(array("value"=>""));
                                    $global->save();
                                }
                            }
                        }
                    }
                    // Special case for background image
                    elseif ($key == "background_image")
                    {
                        // If a file eas uploaded
                        if(isset($_FILES['background_image']['name']))
                        {
                            $target_dir = "../assets/" . $_SESSION['user']['account_id'] . "/";

                            // File info
                            $path_parts = pathinfo($_FILES['background_image']['name']);
                            $name = $path_parts['filename'];
                            $extension = $path_parts['extension'];

                            // Check file extension
                            if (in_array(strtolower($extension), array("jpg", "png", "gif")))
                            {                                                                                                                   
                                
                                // Delete old file
                                if ($itemstolist[$key]->value != ""){
                                    @unlink($target_dir . $itemstolist[$key]->value);
                                }

                                // Set unique name
                                if (file_exists($target_dir . $name . "." . $extension)) {
                                    $number = 1;
                                    while (file_exists($target_dir . $name . $number . "." . $extension)){
                                        $number ++;
                                    }
                                    $name = $name . $number; 
                                }
                                
                                // Try to upload file
                                $target_file = $target_dir . $name . "." . $extension;
                                // Set new favicon file name
                                if(move_uploaded_file($_FILES['background_image']['tmp_name'], $target_file))
                                {
                                    $global = MyActiveRecord::FindById("account_globals", $itemstolist[$key]->id);
                                    if(is_object($global))
                                    {
                                        $global->populate(array("value"=>($name . "." . $extension)));
                                        $global->save();
                                    }
                                    else
                                    {
                                        $global = new account_globals();
                                        $global->name = $key;
                                        $global->value = $name . "." . $extension;
                                        $global->account_id = $_SESSION['user']['account_id'];
                                        $global->save();
                                    }
                                }
                                else
                                {
                                    $global = MyActiveRecord::FindById("account_globals", $itemstolist[$key]->id);
                                    $global->populate(array("value"=>""));
                                    $global->save();
                                }
                            }
                        }
                    }
                }
            }

            $_SESSION['tempalert'] = "Settings updated!";
            header("Location: index.php?page=globals" . (isset($_POST['group']) && $_POST['group'] != "" ? ("#" . $_POST['group']) : ""));
            exit();
        }

        $pgtitle = account_globals::getvalue($_SESSION['user']['account_id'], "site_name") . " - Manage account settings";
        $onpgtitle = "Manage account settings";

        $pagebreadcrumb = array(
            array("page"=>"Account settings", "url"=>"globals"),
        );

        include_once("pages/header.php");
        include_once("pages/globals.php");
        include_once("pages/footer.php");

    }//end globals

///////////////////////////////////////////////////////////////////////////////////

    function manage_users(){

        if($_SESSION['user']['admin'] != "on")
        {
            session_destroy();
            header("Location: index.php?page=login");
            exit();
        }

        // Delete users
        if(isset($_GET['delete']))
        {
            $ids = array();
            if(is_numeric($_GET['delete']))
            {
                $ids[] = $_GET['delete'];
            }
            elseif(strpos($_GET['delete'], ","))
            {
                $ids = explode(",", $_GET['delete']);
            }

            if(!empty($ids))
            {
                foreach ($ids as $id) {
                    $user = MyActiveRecord::FindFirst('account_user', array("account_id"=>$_SESSION['user']['account_id'], "id"=>$id), "id DESC");
                    if(!empty($user))
                    {
                        $user->destroy();
                    }
                }
            }
                                
            $_SESSION['tempalert'] = "User(s) removed!";
            header("Location: index.php?page=manage-users");
            exit();
        }
        // Activate users
        if(isset($_GET['activate']))
        {
            $ids = array();
            if(is_numeric($_GET['activate']))
            {
                $ids[] = $_GET['activate'];
            }
            elseif(strpos($_GET['activate'], ","))
            {
                $ids = explode(",", $_GET['activate']);
            }

            if(!empty($ids))
            {
                foreach ($ids as $id) {
                    $user = MyActiveRecord::FindFirst('account_user', array("account_id"=>$_SESSION['user']['account_id'], "id"=>$id), "id DESC");
                    if(!empty($user))
                    {
                        $user->status = "active";
                        $user->save();
                    }
                }
            }               
                                
            $_SESSION['tempalert'] = "User(s) activated!";
            header("Location: index.php?page=manage-users");
            exit();
        }
        // Deactivate users
        if(isset($_GET['deactivate']))
        {
            $ids = array();
            if(is_numeric($_GET['deactivate']))
            {
                $ids[] = $_GET['deactivate'];
            }
            elseif(strpos($_GET['deactivate'], ","))
            {
                $ids = explode(",", $_GET['deactivate']);
            }

            if(!empty($ids))
            {
                foreach ($ids as $id) {
                    $user = MyActiveRecord::FindFirst('account_user', array("account_id"=>$_SESSION['user']['account_id'], "id"=>$id), "id DESC");
                    if(!empty($user))
                    {
                        $user->status = "inactive";
                        $user->save();
                    }
                }
            }               
                                
            $_SESSION['tempalert'] = "User(s) deactivated!";
            header("Location: index.php?page=manage-users");
            exit();
        }

        $items = MyActiveRecord::FindAll('account_user', array("account_id"=>$_SESSION['user']['account_id']), 'id ASC');

        $pgtitle = account_globals::getvalue($_SESSION['user']['account_id'], "site_name") . " - Manage Users";
        $onpgtitle = "Manage Users";

        $pagebreadcrumb = array(
            array("page"=>"Manage Users", "url"=>"manage-users"),
        );

        include_once("pages/header.php");
        include_once("pages/manage-users.php");
        include_once("pages/footer.php");

    }
    //end manage_users

///////////////////////////////////////////////////////////////////////////////////

    
    function user(){
        
        if($_SESSION['user']['admin'] != "on")
        {
            session_destroy();
            header("Location: index.php?page=login");
            exit();
        }

        // Set form action
        $action = (isset($_GET['id']) && ($_GET['id'] > 0)) ? "edit" : "add";
        if ($action == "edit")
        {
            $user = MyActiveRecord::FindFirst('account_user', array("account_id"=>$_SESSION['user']['account_id'], "id"=>$_GET['id']), "id DESC");
            if (empty($user))
            {
                header("Location: index.php?page=manage-users");
                exit();
            }                    
        }
        else
        {
            $user = new account_user();
        }

        $POPULATE_FORM = (isset($_POST['save']) && ($_POST['save'] == "save")) ? $_POST : (($action == "edit") ? get_object_vars($user) : array());

        if (isset($_POST['save']) && ($_POST['save'] == "save"))
        {            

            // Check for errors (required fields)
            $err_msg = "";
            $required_ok = $unique_ok = true;
            $post_required = array($_POST['email'], $_POST['password'], $_POST['admin'], $_POST['name']);
            $required_ok = !in_array("", $post_required);
            $check_unique = MyActiveRecord::FindFirst("account_user", array("email"=>$_POST['email']));
            $unique_ok = (!empty($check_unique) && (($action == "add") || ($action == "edit" && $check_unique->id != $user->id))) ? false : $unique_ok;
            
            if ($required_ok && $unique_ok)
            {

                $NEW_DATA = array();
                $NEW_DATA['account_id'] = $_SESSION['user']['account_id'];
                $NEW_DATA['email'] = $_POST['email'];
                $NEW_DATA['password'] = md5($_POST['password']);
                $NEW_DATA['admin'] = $_POST['admin'];
                $NEW_DATA['status'] = $_POST['status'];
                $NEW_DATA['name'] = $_POST['name'];
                $NEW_DATA['access_ip'] = $_POST['access_ip'];

                $user->populate($NEW_DATA);
                $user->save();

                $_SESSION['tempalert'] = "User successfully " . ($action == "edit" ? "modified" : "added") . "!";
                header("Location: index.php?page=manage-users");
                exit();
            }
            else
            {
                $err_msg .= "User not " . ($action == "edit" ? "modified" : "added") . "!";
                $err_msg .= ($required_ok == false) ? "<br/>Check the required fields." : "";
                $err_msg .= ($unique_ok == false) ? "<br/>The email address is already set for another user." : "";
            }
        } 

        $pgtitle = account_globals::getvalue($_SESSION['user']['account_id'], "site_name") . " - " . ($action == "edit" ? "Edit" : "Add") . " user";
        $onpgtitle = ($action == "edit" ? "Edit" : "Add") . " User";
        $pagebreadcrumb = array(
            array("page"=>"Manage Users", "url"=>"manage-users"),
            array("page"=>$onpgtitle, "url"=>"user"),
        );

        include_once("pages/header.php");
        include_once("pages/user.php");
        include_once("pages/footer.php");
    }
    //end user

///////////////////////////////////////////////////////////////////////////////////   

    function manage_giftcards(){

        if($_SESSION['user']['admin'] != "on")
        {
            session_destroy();
            header("Location: index.php?page=login");
            exit();
        }

        // Delete
        if(isset($_GET['delete']))
        {
            $ids = array();
            if(is_numeric($_GET['delete']))
            {
                $ids[] = $_GET['delete'];
            }
            elseif(strpos($_GET['delete'], ","))
            {
                $ids = explode(",", $_GET['delete']);
            }

            if(!empty($ids))
            {
                foreach ($ids as $id) {
                    $giftcard = MyActiveRecord::FindFirst('account_giftcard', array("account_id"=>$_SESSION['user']['account_id'], "id"=>$id), "id DESC");
                    if(!empty($giftcard))
                    {
                        unlink("../assets/" . $_SESSION['user']['account_id'] . "/" . $giftcard->image);
                        $giftcard->destroy();
                    }
                }
            }
                                
            $_SESSION['tempalert'] = "Giftcard(s) removed!";
            header("Location: index.php?page=manage-giftcards");
            exit();
        }
        // Activate
        if(isset($_GET['activate']))
        {
            $ids = array();
            if(is_numeric($_GET['activate']))
            {
                $ids[] = $_GET['activate'];
            }
            elseif(strpos($_GET['activate'], ","))
            {
                $ids = explode(",", $_GET['activate']);
            }

            if(!empty($ids))
            {
                foreach ($ids as $id) {
                    $giftcard = MyActiveRecord::FindFirst('account_giftcard', array("account_id"=>$_SESSION['user']['account_id'], "id"=>$id), "id DESC");
                    if(!empty($giftcard))
                    {
                        $giftcard->status = "active";
                        $giftcard->save();
                    }
                }
            }               
                                
            $_SESSION['tempalert'] = "Giftcard(s) activated!";
            header("Location: index.php?page=manage-giftcards");
            exit();
        }
        // Deactivate
        if(isset($_GET['deactivate']))
        {
            $ids = array();
            if(is_numeric($_GET['deactivate']))
            {
                $ids[] = $_GET['deactivate'];
            }
            elseif(strpos($_GET['deactivate'], ","))
            {
                $ids = explode(",", $_GET['deactivate']);
            }

            if(!empty($ids))
            {
                foreach ($ids as $id) {
                    $giftcard = MyActiveRecord::FindFirst('account_giftcard', array("account_id"=>$_SESSION['user']['account_id'], "id"=>$id), "id DESC");
                    if(!empty($giftcard))
                    {
                        $giftcard->status = "inactive";
                        $giftcard->save();
                    }
                }
            }               
                                
            $_SESSION['tempalert'] = "Giftcard(s) deactivated!";
            header("Location: index.php?page=manage-giftcards");
            exit();
        }

        if(isset($_GET['action']) && ($_GET['action'] == "edit_giftcard") && isset($_POST['pk']) && ($_POST['pk'] > 0) && isset($_POST['name']) && in_array($_POST['name'], array("name", "description", "price")))
        {
            $giftcard = MyActiveRecord::FindFirst('account_giftcard', array("account_id"=>$_SESSION['user']['account_id'], "id"=>$_POST['pk']), "id DESC");
            if(!empty($giftcard))
            {
                $giftcard->{$_POST['name']} = $_POST['value'];
                $giftcard->save();
            }
            exit;
        }

        $items = MyActiveRecord::FindAll('account_giftcard', array("account_id"=>$_SESSION['user']['account_id']), 'id ASC');

        $pgtitle = account_globals::getvalue($_SESSION['user']['account_id'], "site_name") . " - Manage Giftcards";
        $onpgtitle = "Manage Giftcards";

        $pagebreadcrumb = array(
            array("page"=>"Manage Giftcards", "url"=>"manage-giftcards"),
        );

        include_once("pages/header.php");
        include_once("pages/manage-giftcards.php");
        include_once("pages/footer.php");

    }
    //end manage_giftcards

///////////////////////////////////////////////////////////////////////////////////

    
    function giftcard(){
        
        if($_SESSION['user']['admin'] != "on")
        {
            session_destroy();
            header("Location: index.php?page=login");
            exit();
        }

        // Set form action
        $action = (isset($_GET['id']) && ($_GET['id'] > 0)) ? "edit" : "add";
        if ($action == "edit")
        {
            $account_giftcard = MyActiveRecord::FindFirst('account_giftcard', array("account_id"=>$_SESSION['user']['account_id'], "id"=>$_GET['id']), "id DESC");
            if (empty($account_giftcard))
            {
                header("Location: index.php?page=manage-giftcards");
                exit();
            }                    
        }
        else
        {
            $account_giftcard = new account_giftcard();
        }

        $POPULATE_FORM = (isset($_POST['save']) && ($_POST['save'] == "save")) ? $_POST : (($action == "edit") ? get_object_vars($account_giftcard) : array());

        if (isset($_POST['save']) && ($_POST['save'] == "save"))
        {            

            // Check for errors (required fields)
            $err_msg = "";
            $required_ok = true;
            $post_required = array($_POST['name'], $_POST['status']);
            $required_ok = !in_array("", $post_required);
            
            if ($required_ok)
            {

                $NEW_DATA = array();
                $NEW_DATA['account_id'] = $_SESSION['user']['account_id'];
                $NEW_DATA['name'] = $_POST['name'];
                $NEW_DATA['description'] = $_POST['description'];
                $NEW_DATA['price'] = $_POST['price'];
                $NEW_DATA['status'] = $_POST['status'];

                $account_giftcard->populate($NEW_DATA);
                $account_giftcard->save();

                if ($account_giftcard->id > 0)
                {
                    $image_types = array("image");
                    foreach ($image_types as $type) 
                    {
                        if (isset($_FILES[$type]['name']) && ($_FILES[$type]['name'] != ""))
                        {
                            $target_dir = "../assets/" . $_SESSION['user']['account_id'] . "/";

                            // File info
                            $path_parts = pathinfo($_FILES[$type]['name']);
                            $name = sanitizeFilename($path_parts['filename']);
                            $extension = $path_parts['extension'];
                            $width = $height = $err_img = 0;
                            if (!in_array(strtolower($extension), array("jpg", "png", "gif")))
                            {
                                $err_img = 1;
                            }
                            elseif(($_FILES[$type]['size'] / (1024 * 1024)) > 5)
                            {
                                $err_img = 2;
                            } 
                            else
                            {
                                list($width, $height) = getimagesize($_FILES[$type]['tmp_name']);
                                if ($width > 4000 || $height > 4000)
                                {
                                    $err_img = 3;
                                }
                            }
                            if ($err_img == 0)
                            {                                                                                                                   
                                if (($action == "edit") && ($fleet->{$type} != ""))
                                {
                                    @unlink($target_dir . $fleet->{$type});
                                }        
                                if (file_exists($target_dir . $name . "." . $extension)) {
                                    $number = 1;
                                    while (file_exists($target_dir . $name . $number . "." . $extension)){
                                        $number ++;
                                    }
                                    $name = $name . $number; 
                                }
                                $target_file = $target_dir . $name . "." . $extension;
                                if(move_uploaded_file($_FILES[$type]['tmp_name'], $target_file))
                                {
                                    $account_giftcard->populate(array($type=>($name . "." . $extension)));
                                    $account_giftcard->save();
                                }
                            }
                            else
                            {
                                $files_with_errors[] = $_FILES[$type]['name'];
                            }
                        }
                    }
                }

                $_SESSION['tempalert'] = "Giftcard successfully " . ($action == "edit" ? "modified" : "added") . "!";
                header("Location: index.php?page=manage-giftcards");
                exit();
            }
            else
            {
                $err_msg .= "Giftcard not " . ($action == "edit" ? "modified" : "added") . "!";
                $err_msg .= ($required_ok == false) ? "<br/>Check the required fields." : "";
            }
        } 

        $pgtitle = account_globals::getvalue($_SESSION['user']['account_id'], "site_name") . " - " . ($action == "edit" ? "Edit" : "Add") . " giftcard";
        $onpgtitle = ($action == "edit" ? "Edit" : "Add") . " Giftcard";
        $pagebreadcrumb = array(
            array("page"=>"Manage Giftcards", "url"=>"manage-giftcards"),
            array("page"=>$onpgtitle, "url"=>"giftcard"),
        );

        include_once("pages/header.php");
        include_once("pages/giftcard.php");
        include_once("pages/footer.php");
    }
    //end giftcard

///////////////////////////////////////////////////////////////////////////////////   

    function giftcard_gallery(){

        if($_SESSION['user']['admin'] != "on")
        {
            session_destroy();
            header("Location: index.php?page=login");
            exit();
        }

        if (isset($_POST['save']) && ($_POST['save'] == "save"))
        {
            if(!empty($_POST['sel_giftcard']))
            {
                foreach ($_POST['sel_giftcard'] as $sel)
                {
                    
                    $giftcard = MyActiveRecord::FindFirst('giftcard', array("id"=>$sel), "id DESC");
                    $account_giftcard = new account_giftcard();

                    $source = "../assets/giftcards/" . $giftcard->image;
                    $path_parts = pathinfo($source);
                    $name = sanitizeFilename($path_parts['filename']);
                    $extension = $path_parts['extension'];

                    $target_dir = "../assets/" . $_SESSION['user']['account_id'] . "/";
                                                                                                                                      
                    if (file_exists($target_dir . $name . "." . $extension)) {
                        $number = 1;
                        while (file_exists($target_dir . $name . $number . "." . $extension)){
                            $number ++;
                        }
                        $name = $name . $number; 
                    }
                    $target_file = $target_dir . $name . "." . $extension;
                    copy($source, $target_file);                    

                    $NEW_DATA = array();
                    $NEW_DATA['account_id'] = $_SESSION['user']['account_id'];
                    $NEW_DATA['giftcard_id'] = $sel;
                    $NEW_DATA['name'] = $giftcard->name;
                    $NEW_DATA['description'] = "";
                    $NEW_DATA['image'] = $name . "." . $extension;
                    $NEW_DATA['price'] = 0;
                    $NEW_DATA['status'] = "active";

                    $account_giftcard->populate($NEW_DATA);
                    $account_giftcard->save();
                }

                $_SESSION['tempalert'] = "Giftcards successfully added to your inventory!";
                header("Location: index.php?page=manage-giftcards");
                exit();
            }
            else
            {
                $_SESSION['tempalert'] = "No giftcards selected!";
                header("Location: index.php?page=giftcard-gallery");
                exit();
            }
        }

        $pgtitle = account_globals::getvalue($_SESSION['user']['account_id'], "site_name") . " - Giftcard Gallery";
        $onpgtitle = "Giftcard Gallery";

        $pagebreadcrumb = array(
            array("page"=>"Giftcard Gallery", "url"=>"giftcard-gallery"),
        );

        include_once("pages/header.php");
        include_once("pages/giftcard-gallery.php");
        include_once("pages/footer.php");

    }
    //end giftcards_gallery

///////////////////////////////////////////////////////////////////////////////////

    function manage_purchases() {

        if (isset($_GET['mark_redeemed']) && in_array($_GET['mark_redeemed'], array("on", "off")) && isset($_GET['id']) && ($_GET['id'] > 0)) {
            $purchase = MyActiveRecord::FindFirst('account_purchase', array("account_id" => $_SESSION['user']['account_id'], "id" => $_GET['id']), 'id ASC');
            if (is_object($purchase)) {
                $purchase->populate(array("redeemed" => $_GET['mark_redeemed']));
                $purchase->save();

                $_SESSION['tempalert'] = "Purchase successfully marked as " . ($_GET['mark_redeemed'] == "on" ? "redeemed" : "not redeemed") . "!";
                header("Location: index.php?page=manage-purchases");
                exit();
            }
        }

        // Load events
        if (isset($_GET['load']) && ($_GET['load'] == "data"))
        {
            // Get params
            $params = process_ajax_request($_POST);
            // Get data
            $data = account_purchase::get_list($params);
            // Output data
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $data['row_total'],
                "recordsFiltered" => $data['row_total'],
                "aaData" => $data['row_data']
            );
            echo json_encode($output);
            exit;
        }

        $giftcards = MyActiveRecord::FindAll('account_giftcard', array("account_id"=>$_SESSION['user']['account_id']), 'name ASC');

        // Export to excel
        if (isset($_GET['export']) && ($_GET['export'] == 1)) {            

            $daterangepicker_data = daterangepicker_data($_GET['period'], $_GET['daterange']);
            $predefined_ranges = $daterangepicker_data['predefined_ranges'];
            if ((isset($_GET['period']) && ($_GET['period'] != "")) || (isset($_GET['daterange']) && ($_GET['daterange'] != ""))) {
                $start_interval = $daterangepicker_data['start_interval'];
                $end_interval = $daterangepicker_data['end_interval'];
            }

            $ADD_COND = array();

            $ADD_COND[] = "account_purchase.account_id = " . MyActiveRecord::Escape($_SESSION['user']['account_id']);

            // Set title and conditions depending on selection
            if (isset($_GET['client']) && ($_GET['client'] != "")) {
                $ADD_COND[] = "(code LIKE " . MyActiveRecord::Escape("%" . $_GET['client'] . "%") . " OR receiver_name LIKE " . MyActiveRecord::Escape("%" . $_GET['client'] . "%") . " OR receiver_email LIKE " . MyActiveRecord::Escape("%" . $_GET['client'] . "%") . ")";
            }
            if (isset($_GET['account_giftcard_id']) && ($_GET['account_giftcard_id'] > 0)) {
                $ADD_COND[] = "account_giftcard_id = " . MyActiveRecord::Escape($_GET['account_giftcard_id']);
            }
            if (isset($_GET['payment_status']) && in_array($_GET['payment_status'], array("not_paid", "paid", "rejected"))) {
                $ADD_COND[] = "payment_status = " . MyActiveRecord::Escape($_GET['payment_status']);
            }
            if (isset($_GET['sent_status']) && in_array($_GET['sent_status'], array("queued", "sent", "error"))) {
                $ADD_COND[] = "sent_status = " . MyActiveRecord::Escape($_GET['sent_status']);
            }
            if (isset($_GET['redeemed']) && in_array($_GET['redeemed'], array("on", "off"))) {
                $ADD_COND[] = "redeemed = " . MyActiveRecord::Escape($_GET['redeemed']);
            }
            if (isset($start_interval) && ($start_interval != "")) {
                $ADD_COND[] = "DATE_FORMAT(added_on, '%Y-%m-%d') >= '" . $start_interval . "'";
            }
            if (isset($end_interval) && ($end_interval != "")) {
                $ADD_COND[] = "DATE_FORMAT(added_on, '%Y-%m-%d') <= '" . $end_interval . "'";
            }

            $full_query = "SELECT account_purchase.*,
                            (SELECT account_giftcard.name FROM account_giftcard WHERE account_purchase.account_giftcard_id = account_giftcard.id) AS giftcard_name
                            FROM account_purchase 
                            WHERE " . join(" AND ", $ADD_COND) . "
                            ORDER BY id ASC";

            $items = MyActiveRecord::FindBySql('account_purchase', $full_query);

        
            include 'lib/phpexcel178/Classes/PHPExcel/IOFactory.php';

            // Create new PHPExcel object
            $objPHPExcel = new PHPExcel();
            // Set document properties
            $objPHPExcel->getProperties()->setCreator("DriveProfit")
                    ->setLastModifiedBy("DriveProfit")
                    ->setTitle("Export - DriveProfit")
                    ->setSubject("Export - DriveProfit")
                    ->setDescription("Export - DriveProfit, generated using PHP.")
                    ->setKeywords("office 2007 openxml php")
                    ->setCategory("Export - DriveProfit");
            // Add some data
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'Giftcard')
                    ->setCellValue('B1', 'Receiver Name')
                    ->setCellValue('C1', 'Receiver Email')
                    ->setCellValue('D1', 'Receiver Code')
                    ->setCellValue('E1', 'Price')
                    ->setCellValue('F1', 'Payment')
                    ->setCellValue('G1', 'Sent')
                    ->setCellValue('H1', 'Redeemed')
                    ->setCellValue('I1', 'Purchase Date')
            ;

            $row = 1;
            foreach ($items as $item) {

                $row ++;
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $row, $item->giftcard_name)
                        ->setCellValue('B' . $row, $item->receiver_name)
                        ->setCellValue('C' . $row, $item->receiver_email)
                        ->setCellValue('D' . $row, $item->receiver_code)
                        ->setCellValue('E' . $row, $item->price_total)
                        ->setCellValue('F' . $row, $item->payment_status)
                        ->setCellValue('G' . $row, $item->sent_status)
                        ->setCellValue('H' . $row, $item->redeemed)
                        ->setCellValue('I' . $row, $item->added_on);
            }
            // Rename worksheet
            $objPHPExcel->getActiveSheet()->setTitle('Export - DriveProfit');
            // Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $objPHPExcel->setActiveSheetIndex(0);
            // Redirect output to a client’s web browser (Excel5)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . strtolower(str_replace(' ', '-', globals::getvalue("site_name"))) . '-export-' . date("d-m-y") . '.xls"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            exit();
        }
        
        $pgtitle = account_globals::getvalue($_SESSION['user']['account_id'], "site_name") . " - Giftcards Purchased";
        $onpgtitle = "Giftcards Purchased";

        $pagebreadcrumb = array(
            array("page" => "Giftcards Purchased", "url" => "manage-purchases"),
        );

        include_once("pages/header.php");
        include_once("pages/manage-purchases.php");
        include_once("pages/footer.php");
    }

    //end manage_locations
///////////////////////////////////////////////////////////////////////////////////

	function sso() {
        
		$encrypted_guid = isset($_GET['enguid']) ? $_GET['enguid'] : "";
			
		$decryption_iv = '1234567891011121'; 
		$decryption_key = "mygiftcards-product"; 
		$ciphering = "AES-128-CTR"; 
		$options = 0; 
		$guid = openssl_decrypt($encrypted_guid, $ciphering, $decryption_key, $options, $decryption_iv); 

		if($guid != "")
		{
					
			$theuser = MyActiveRecord::FindFirst('account_user', array("guid" => $guid), "id ASC");		
			
			if (!empty($theuser)) 
			{
				if($theuser->status == "active")
				{
				
					$account = MyActiveRecord::FindFirst('account', array("id" => $theuser->account_id, "status" => "active"));
					
					if($account->status == "active")
					{
						$_SESSION['loggedin'] = "yes";
						$_SESSION['errorcount'] = 0;
						$_SESSION['user']['id'] = $theuser->id;
						$_SESSION['user']['admin'] = $theuser->admin;
						$_SESSION['user']['account_id'] = $theuser->account_id;
						$_SESSION['user']['email'] = $theuser->email;

						// Save login log
						$NEW_DATA = array();
						$NEW_DATA['account_id'] = $theuser->account_id;
						$NEW_DATA['user_id'] = $theuser->id;
						$NEW_DATA['sulogin'] = 2;       
						$NEW_DATA['ip'] = $_SERVER['REMOTE_ADDR'];
						$NEW_DATA['moment'] = MyActiveRecord::DbDateTime();
						$account_user_logs = new account_user_logs();
						$account_user_logs->populate($NEW_DATA);
						$account_user_logs->save();
								
						header("Location: index.php?page=home");
						exit();
					}
					else
					{
						die("Inactive account! GUID: " . $guid);
					}
				}
				else
				{
					die("Inactive user! GUID: " . $guid);
				}
			}
			else
			{
				die("Invalid user! GUID: " . $guid);
			}
		}
		else
		{
			die("Not able to extract GUID! GUID: " . $guid);
		}
    }

    //end sso

   
}//end class c_ajax

?>