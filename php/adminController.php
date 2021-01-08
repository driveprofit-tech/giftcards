<?php

class controller
{
///////////////////////////////////////////////////////////////////////////////////

	function controller(){

        if($_SESSION['loggedin'] != "yes" && $_GET['page'] != "login" && $_GET['page'] != "logout"){
            header("Location: index.php?page=logout");
            exit();
        }
    }
    //end function controller (constructor)

///////////////////////////////////////////////////////////////////////////////////

    function login(){
        
        if(strlen($_POST['user']) > 2 && strlen($_POST['password']) > 2)
        {
            if($_SESSION['errorcount'] < 5)
            {
                if($_POST['user'] == globals::getvalue("admin_user") && md5($_POST['password']) == globals::getvalue("admin_password"))
                {
                    $_SESSION['loggedin'] = "yes";
                    $_SESSION['user']['id'] = 9999;
                    $_SESSION['errorcount'] = 0;
                    header("Location: index.php?page=home");
                    exit();
                }
                else
                {
                    $_SESSION['tempalert'] = "Username or password incorrect!";
                    $_SESSION['errorcount']++;
                }
            } 
            else
            {
                $_SESSION['tempalert'] = "Username or password incorrect!";

                $msg = "Password wrong on: " . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                $msg .= "<br/>IP Address: " . $_SERVER['REMOTE_ADDR'];
                $msg .= "<br/>POST user: " . $_POST['user'];
                $msg .= "<br/>POST password: " . $_POST['password'];
                mail("tech@driveprofit.com", "Pasword wrong 5 times", $msg);
            }
        }

        $pgtitle = globals::getvalue("site_name") . " - Login";
        include_once("pages/login.php");


    }//end login

///////////////////////////////////////////////////////////////////////////////////

    function logout(){

        unset($_SESSION['loggedin']);
        session_destroy();
        header("Location: index.php?page=login");
        exit();

    }//end logout

///////////////////////////////////////////////////////////////////////////////////

    // Global variables management
    function globals(){

        // Get a list of existing settings
        $itemstolist = MyActiveRecord::FindBySql('globals', 'SELECT * FROM globals ORDER BY name ASC', 'name');

        // When the form is submitted
        if (isset($_POST['save']) && ($_POST['save'] == "save"))
        {
            // Loop by existing settings
            foreach ($itemstolist as $key => $value) 
            {
                // Special case for site logo
                if ($key == "site_logo")
                {
                    // If a file is uploaded
                    if(isset($_FILES['site_logo']['name']))
                    {
                        $target_dir = LOCAL_PATH . "assets/";

                        // File info
                        $path_parts = pathinfo($_FILES['site_logo']['name']);
                        $name = $path_parts['filename'];
                        $extension = $path_parts['extension'];

                        // Check file extension
                        if (in_array($extension, array("jpg", "png", "gif")))
                        {                                                                                                                   
                            
                            // Delete old file
                            if ($itemstolist[$key]->value != ""){
                                @unlink(LOCAL_PATH . 'assets/' . $itemstolist[$key]->value);
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
                                $global = MyActiveRecord::FindById("globals", $itemstolist[$key]->id);
                                $global->populate(array("value"=>($name . "." . $extension)));
                                $global->save();
                            }
                            else
                            {
                                $global = MyActiveRecord::FindById("globals", $itemstolist[$key]->id);
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
                        $target_dir = LOCAL_PATH . "assets/";

                        // File info
                        $path_parts = pathinfo($_FILES['site_favicon']['name']);
                        $name = $path_parts['filename'];
                        $extension = $path_parts['extension'];

                        // Check file extension
                        if (in_array($extension, array("ico")))
                        {                                                                                                                   
                            
                            // Delete old file
                            if ($itemstolist[$key]->value != ""){
                                @unlink(LOCAL_PATH . 'assets/' . $itemstolist[$key]->value);
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
                            if(move_uploaded_file($_FILES['site_favicon']['tmp_name'], $target_file))
                            {
                                $global = MyActiveRecord::FindById("globals", $itemstolist[$key]->id);
                                $global->populate(array("value"=>($name . "." . $extension)));
                                $global->save();
                            }
                            else
                            {
                                $global = MyActiveRecord::FindById("globals", $itemstolist[$key]->id);
                                $global->populate(array("value"=>""));
                                $global->save();
                            }
                        }
                 
                    }
                }
                // Special case for admin password
                elseif ($key == "admin_password")
                {
                    if(isset($_POST[$key]) && ($_POST[$key] != ""))
                    {
                        $global = MyActiveRecord::FindById("globals", $itemstolist[$key]->id);
                        $global->populate(array("value"=>md5($_POST[$key])));
                        $global->save();
                    }
                }
                else
                {
                    // Update value for setting
                    if (isset($_POST[$key]))
                    {
                        $global = MyActiveRecord::FindById("globals", $itemstolist[$key]->id);
                        $global->populate(array("value"=>$_POST[$key]));
                        $global->save();
                    }
                }
            }

            $_SESSION['tempalert'] = "Settings updated!";
            header("Location: index.php?page=globals");
            exit();
        }

        $pgtitle = globals::getvalue("site_name") . " - Manage global settings";
        $onpgtitle = "Manage global settings";

        include_once("pages/header.php");
        include_once("pages/globals.php");
        include_once("pages/footer.php");
    }//end globals


///////////////////////////////////////////////////////////////////////////////////

    function home(){

        if (isset($_GET['id']) && is_numeric($_GET['id']))
        {
            $account = MyActiveRecord::FindFirst('account', array("id"=>$_GET['id']));
            if (!empty($account))
            {
                if (isset($_GET['do']) && ($_GET['do'] == "api_key"))
                {
                    $api_key = md5(uniqid($account->id, true));
                    $account->populate(array("api_key"=>$api_key));
                    $account->save();

                    $_SESSION['tempalert'] = "API key successfully regenerated! If the old API key was already in use, you must also update the API integration for this account.";

                    header("Location: index.php?page=home");
                    exit();
                }
            }
            else
            {
                header("Location: index.php?page=home");
                exit();
            }
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
                    $account = MyActiveRecord::FindFirst('account', array("id"=>$id), "id DESC");
                    if(!empty($account))
                    {
                        $account->status = "active";
                        $account->save();
                    }
                }
            }               
                                
            $_SESSION['tempalert'] = "Account(s) activated!";
            header("Location: index.php?page=home");
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
                    $account = MyActiveRecord::FindFirst('account', array("id"=>$id), "id DESC");
                    if(!empty($account))
                    {
                        $account->status = "inactive";
                        $account->save();
                    }
                }
            }               
                                
            $_SESSION['tempalert'] = "Account(s) deactivated!";
            header("Location: index.php?page=home");
            exit();
        }
        
        $items = MyActiveRecord::FindBySql('account', 
                "SELECT account.*, 
                (SELECT value FROM account_globals WHERE account_globals.account_id = account.id AND name = 'site_name' LIMIT 1) AS site_name, 
                (SELECT value FROM account_globals WHERE account_globals.account_id = account.id AND name = 'site_link' LIMIT 1) AS site_link
                FROM account ORDER BY id ASC");

        $pgtitle = globals::getvalue("site_name") . " - Dashboard";
        $onpgtitle = "Dashboard";

        include_once("pages/header.php");
        include_once("pages/home.php");
        include_once("pages/footer.php");
		
    }//end home

///////////////////////////////////////////////////////////////////////////////////

    function account(){
        
        // Set form action
        $action = (isset($_GET['id']) && ($_GET['id'] > 0)) ? "edit" : "add";
        if ($action == "edit")
        {
            $account = MyActiveRecord::FindFirst('account', array("id"=>$_GET['id']), "id DESC");
            $site_name = MyActiveRecord::FindFirst('account_globals', array("account_id"=>$_GET['id'], "name"=>"site_name"));
            $site_link = MyActiveRecord::FindFirst('account_globals', array("account_id"=>$_GET['id'], "name"=>"site_link"));
            if (empty($account))
            {
                header("Location: index.php?page=home");
                exit();
            }                    
        }
        else
        {
            $account = new account();
        }

        // Populate data from post or from db
        $POPULATE_FORM = (isset($_POST['save']) && ($_POST['save'] == "save")) ? $_POST : (($action == "edit") ? array_merge(get_object_vars($account), array("site_name"=>$site_name->value, "site_link"=>$site_link->value)) : array());

        if (isset($_POST['save']) && ($_POST['save'] == "save"))
        {
            
            // Check for errors (required fields)
            $err_msg = "";
            $required_ok = $name_unique_ok = $email_unique_ok = true;
            $post_required = array_merge(array($_POST['name'], $_POST['status'], $_POST['site_name'], $_POST['site_link']), (($action == "edit") ? array() : array($_POST['email'], $_POST['password'], $_POST['user_name'])));
            $check_unique = MyActiveRecord::FindFirst("account", array("name"=>$_POST['name']));
            $name_unique_ok = (!empty($check_unique) && (($action == "add") || ($action == "edit" && $check_unique->id != $account->id))) ? false : $name_unique_ok;
            if ($action == "add")
            {
                $check_email_unique = MyActiveRecord::FindFirst("account_user", array("email"=>$_POST['email']));
                $email_unique_ok = !empty($check_email_unique) ? false : $email_unique_ok;
            }
            
            if ($required_ok && $name_unique_ok && $email_unique_ok)
            {
                $NEW_DATA = array();
                $NEW_DATA['name'] = $_POST['name'];
                $NEW_DATA['status'] = $_POST['status'];
               
                $account->populate($NEW_DATA);
                $account->save();

                if ($account->id > 0)
                {
                    if ($action == "add")
                    {

                        // Save user data
                        $NEW_USER_DATA = array();  
                        $NEW_USER_DATA['account_id'] = $account->id;
                        $NEW_USER_DATA['email'] = $_POST['email'];
                        $NEW_USER_DATA['password'] = $_POST['password'];
                        $NEW_USER_DATA['admin'] = "on";
                        $NEW_USER_DATA['name'] = $_POST['user_name'];
                        $NEW_USER_DATA['status'] = "active";
                        $account_user = new account_user();
                        $account_user->populate($NEW_USER_DATA);
                        $account_user->save();

                        // Save account settings
                        foreach (array("site_name", "site_link") as $setting) {
                            $account_globals = new account_globals();
                            $account_globals->populate(array("account_id"=>$account->id, "name"=>$setting, "value"=>(isset($_POST[$setting]) ? $_POST[$setting] : "")));
                            $account_globals->save();
                        } 

                        // Create account folder
                        mkdir(LOCAL_PATH . "assets/" . $account->id); 
                    } 
                    else
                    {
                        // Save account settings
                        foreach (array("site_name", "site_link") as $setting) {
                            $account_globals = MyActiveRecord::FindFirst('account_globals', array("account_id"=>$account->id, "name"=>$setting));
                            $account_globals->populate(array("value"=>$_POST[$setting]));
                            $account_globals->save();
                        } 
                    }
                }

                $_SESSION['tempalert'] = "Account successfully " . ($action == "edit" ? "modified" : "added") . "!";
                header("Location: index.php?page=home");
                exit();
            }
            else
            {
                $err_msg .= "Account not " . ($action == "edit" ? "modified" : "added") . "!";
                $err_msg .= ($required_ok == false) ? "<br/>Check the required fields." : "";
                $err_msg .= ($name_unique_ok == false) ? "<br/>The name is already set for another account." : "";
                $err_msg .= ($email_unique_ok == false) ? "<br/>The email address is already set for another user." : "";
            }

        } 

        $pgtitle = globals::getvalue("site_name") . " - " . ($action == "edit" ? "Edit" : "Add") . " account";
        $onpgtitle = ($action == "edit" ? "Edit" : "Add") . " account";

        include_once("pages/header.php");
        include_once("pages/account.php");
        include_once("pages/footer.php");

    }//end account

    ///////////////////////////////////////////////////////////////////////////////////

    function notify_users(){


        // Populate data from post or from db
        $POPULATE_FORM = array();

        if (isset($_GET['mode']) && ($_GET['mode'] == "preview") && isset($_SESSION['notify_users']))
        {
            $action = "preview";
        }
        else
        {
            $action = "add";
        }

        if (isset($_POST['preview']) && ($_POST['preview'] == "preview"))
        {

            $_SESSION['notify_users']['message'] = $_POST['message'];
            $_SESSION['notify_users']['type'] = $_POST['type'];

            header("Location: index.php?page=notify-users&mode=preview");
            exit();

        }
        elseif (isset($_POST['save']) && ($_POST['save'] == "save") && isset($_SESSION['notify_users']))
        {
            
            $account_users = MyActiveRecord::FindBySql("account_user", "SELECT account_user.* FROM account_user LEFT JOIN account ON account_user.account_id = account.id WHERE account.status = 'active'");
            
            if (!empty($account_users))
            {
                foreach ($account_users as $user) {

                    $account_user_notification = new account_user_notification();
                    
                    $NEW_DATA = array();
                    $NEW_DATA['account_id'] = $user->account_id;
                    $NEW_DATA['user_id'] = $user->id;
                    $NEW_DATA['message'] = $_SESSION['notify_users']['message'];
                    $NEW_DATA['type'] = $_SESSION['notify_users']['type'];
                    $NEW_DATA['read'] = "no";
                   
                    $account_user_notification->populate($NEW_DATA);
                    $account_user_notification->save();
                }
            } 

            unset($_SESSION['notify_users']);
           
            $_SESSION['tempalert'] = "Message successfully added!";
            header("Location: index.php?page=home");
            exit();
        }

        if (isset($_SESSION['notify_users']))
        {
            $POPULATE_FORM = $_SESSION['notify_users'];
        }

        $pgtitle = globals::getvalue("site_name") . " - Notify Users - " . ($action == "preview" ? "Preview notification" : "Create notification");
        $onpgtitle = ($action == "preview") ? "Preview notification" : "Create notification";

        include_once("pages/header.php");
        include_once("pages/notify-users.php");
        include_once("pages/footer.php");
        
    }//end notify_users

///////////////////////////////////////////////////////////////////////////////////

    function categories(){

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
                    $category = MyActiveRecord::FindFirst('category', array("id"=>$id), "id DESC");
                    if(!empty($category))
                    {
                        $category->status = "active";
                        $category->save();
                    }
                }
            }               
                                
            $_SESSION['tempalert'] = "Category(s) activated!";
            header("Location: index.php?page=categories");
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
                    $category = MyActiveRecord::FindFirst('category', array("id"=>$id), "id DESC");
                    if(!empty($category))
                    {
                        $category->status = "inactive";
                        $category->save();
                    }
                }
            }               
                                
            $_SESSION['tempalert'] = "Category(s) deactivated!";
            header("Location: index.php?page=categories");
            exit();
        }

        $items = MyActiveRecord::FindBySql('category', 
                "SELECT category.*, COUNT(*) AS count_giftcards              
                FROM category 
                LEFT JOIN giftcard ON category_id = category.id
                GROUP BY category.id
                ORDER BY id ASC");

        $pgtitle = globals::getvalue("site_name") . " - Giftcard Categories";
        $onpgtitle = "Giftcard Categories";

        include_once("pages/header.php");
        include_once("pages/categories.php");
        include_once("pages/footer.php");
        
    }//end home

///////////////////////////////////////////////////////////////////////////////////

    function category(){
        
        // Set form action
        $action = (isset($_GET['id']) && ($_GET['id'] > 0)) ? "edit" : "add";
        if ($action == "edit")
        {
            $category = MyActiveRecord::FindFirst('category', array("id"=>$_GET['id']), "id DESC");
            if (empty($category))
            {
                header("Location: index.php?page=home");
                exit();
            }                    
        }
        else
        {
            $category = new category();
        }

        // Populate data from post or from db
        $POPULATE_FORM = (isset($_POST['save']) && ($_POST['save'] == "save")) ? $_POST : (($action == "edit") ? array_merge(get_object_vars($category), array()) : array());

        if (isset($_POST['save']) && ($_POST['save'] == "save"))
        {
            
            // Check for errors (required fields)
            $err_msg = "";
            $required_ok = $name_unique_ok = true;
            $post_required = array($_POST['name'], $_POST['status']);
            $check_unique = MyActiveRecord::FindFirst("category", array("name"=>$_POST['name']));
            $name_unique_ok = (!empty($check_unique) && (($action == "add") || ($action == "edit" && $check_unique->id != $category->id))) ? false : $name_unique_ok;
            
            if ($required_ok && $name_unique_ok)
            {
                $NEW_DATA = array();
                $NEW_DATA['name'] = $_POST['name'];
                $NEW_DATA['description'] = $_POST['description'];
                $NEW_DATA['status'] = $_POST['status'];
               
                $category->populate($NEW_DATA);
                $category->save();

                $_SESSION['tempalert'] = "Category successfully " . ($action == "edit" ? "modified" : "added") . "!";
                header("Location: index.php?page=categories");
                exit();
            }
            else
            {
                $err_msg .= "Category not " . ($action == "edit" ? "modified" : "added") . "!";
                $err_msg .= ($required_ok == false) ? "<br/>Check the required fields." : "";
                $err_msg .= ($name_unique_ok == false) ? "<br/>The name is already set for another category." : "";
            }

        } 

        $pgtitle = globals::getvalue("site_name") . " - " . ($action == "edit" ? "Edit" : "Add") . " category";
        $onpgtitle = ($action == "edit" ? "Edit" : "Add") . " category";

        include_once("pages/header.php");
        include_once("pages/category.php");
        include_once("pages/footer.php");

    }//end account

    ///////////////////////////////////////////////////////////////////////////////////

     function giftcards(){

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
                    $giftcard = MyActiveRecord::FindFirst('giftcard', array("id"=>$id), "id DESC");
                    if(!empty($giftcard))
                    {
                        $giftcard->status = "active";
                        $giftcard->save();
                    }
                }
            }               
                                
            $_SESSION['tempalert'] = "Giftcard(s) activated!";
            header("Location: index.php?page=giftcards");
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
                    $giftcard = MyActiveRecord::FindFirst('giftcard', array("id"=>$id), "id DESC");
                    if(!empty($giftcard))
                    {
                        $giftcard->status = "inactive";
                        $giftcard->save();
                    }
                }
            }               
                                
            $_SESSION['tempalert'] = "Giftcard(s) deactivated!";
            header("Location: index.php?page=giftcards");
            exit();
        }

        $items = MyActiveRecord::FindBySql('giftcard', 
                "SELECT giftcard.*, category.name AS category              
                FROM giftcard 
                LEFT JOIN category ON category_id = category.id
                ORDER BY id ASC");

        $pgtitle = globals::getvalue("site_name") . " - Giftcards";
        $onpgtitle = "Giftcards";

        include_once("pages/header.php");
        include_once("pages/giftcards.php");
        include_once("pages/footer.php");
        
    }//end home

///////////////////////////////////////////////////////////////////////////////////

    function giftcard(){
        
        // Set form action
        $action = (isset($_GET['id']) && ($_GET['id'] > 0)) ? "edit" : "add";
        if ($action == "edit")
        {
            $giftcard = MyActiveRecord::FindFirst('giftcard', array("id"=>$_GET['id']), "id DESC");
            if (empty($giftcard))
            {
                header("Location: index.php?page=home");
                exit();
            }                    
        }
        else
        {
            $giftcard = new giftcard();
        }

        // Populate data from post or from db
        $POPULATE_FORM = (isset($_POST['save']) && ($_POST['save'] == "save")) ? $_POST : (($action == "edit") ? array_merge(get_object_vars($giftcard), array()) : array());

        if (isset($_POST['save']) && ($_POST['save'] == "save"))
        {
            
            // Check for errors (required fields)
            $err_msg = "";
            $required_ok = $name_unique_ok = true;
            $post_required = array($_POST['name'], $_POST['category_id'], $_POST['status']);
            $check_unique = MyActiveRecord::FindFirst("giftcard", array("name"=>$_POST['name']));
            $name_unique_ok = (!empty($check_unique) && (($action == "add") || ($action == "edit" && $check_unique->id != $giftcard->id))) ? false : $name_unique_ok;
            
            if ($required_ok && $name_unique_ok)
            {
                $NEW_DATA = array();
                $NEW_DATA['name'] = $_POST['name'];
                $NEW_DATA['description'] = $_POST['description'];
                $NEW_DATA['category_id'] = $_POST['category_id'];
                $NEW_DATA['status'] = $_POST['status'];
               
                $giftcard->populate($NEW_DATA);
                $giftcard->save();

                if ($giftcard->id > 0)
                {
                    $image_types = array("image");
                    foreach ($image_types as $type) 
                    {
                        if (isset($_FILES[$type]['name']) && ($_FILES[$type]['name'] != ""))
                        {
                            $target_dir = "../assets/giftcards/";

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
                                    $giftcard->populate(array($type=>($name . "." . $extension)));
                                    $giftcard->save();
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
                header("Location: index.php?page=giftcards");
                exit();
            }
            else
            {
                $err_msg .= "Giftcard not " . ($action == "edit" ? "modified" : "added") . "!";
                $err_msg .= ($required_ok == false) ? "<br/>Check the required fields." : "";
                $err_msg .= ($name_unique_ok == false) ? "<br/>The name is already set for another giftcard." : "";
            }

        } 

        $pgtitle = globals::getvalue("site_name") . " - " . ($action == "edit" ? "Edit" : "Add") . " giftcard";
        $onpgtitle = ($action == "edit" ? "Edit" : "Add") . " giftcard";

        include_once("pages/header.php");
        include_once("pages/giftcard.php");
        include_once("pages/footer.php");

    }//end account

    ///////////////////////////////////////////////////////////////////////////////////

}//end class c_ajax

?>