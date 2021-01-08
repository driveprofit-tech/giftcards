<!DOCTYPE html>
<html>

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <base href="<?=BASE_PATH?>" />

        <title><?=$site_name?> - <?=ucwords(str_replace("-", " ", $_GET['page']))?></title>

        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="code/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="code/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="code/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css">

        <script src="code/jquery/dist/jquery.min.js"></script>
        <script src="code/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="code/scripts/moment.min.js"></script>
        <script src="code/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>    
        <script src="code/jquery-ui/jquery-ui.min.js"></script> 

        <!-- Vaildator -->
        <script src="code/scripts/validator.min.js"></script>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

        <link rel="shortcut icon" type="image/x-icon" href="<?="assets/" . $_GET['account'] . "/" . account_globals::getvalue($_GET['account'], "site_favicon")?>">

<?

    $custom_css = account_globals::getvalue($account->id, "custom_css");

    $main_color = account_globals::getvalue($account->id, "main_color");
    $main_color = ($main_color == "") ? "#0000FF" : $main_color;
    $main_color = (strtolower($main_color) == "transparent") ? "transparent" : ((strpos($main_color, "rgba") !== false) ? $main_color : ("#" . str_replace("#", "", $main_color)));
    
    $background_color = account_globals::getvalue($account->id, "background_color");
    $background_color = ($background_color == "") ? "#FFF" : $background_color;
    $background_color = (strtolower($background_color) == "transparent") ? "transparent" : ((strpos($background_color, "rgba") !== false) ? $background_color : ("#" . str_replace("#", "", $background_color)));
    
    $text_color = account_globals::getvalue($account->id, "text_color");
    $text_color = ($text_color == "") ? "#000" : $text_color;    
    $text_color = (strtolower($text_color) == "transparent") ? "transparent" : ((strpos($text_color, "rgba") !== false) ? $text_color : ("#" . str_replace("#", "", $text_color)));

    $font_family = account_globals::getvalue($account->id, "font_family");
    if($font_family != "")
    {
        $font_family_quoted = "";
        $family_parts = explode(",", $font_family);
        $idx = 0;
        foreach ($family_parts as $part) {          
            if($idx < sizeof($family_parts) - 1)
            {
                $font_family_quoted .= "'" . trim($part) . "', ";
            }
            else
            {
                $font_family_quoted .= trim($part);
            }
            $idx ++;
        }
        $font_family = $font_family_quoted;
    }

    $font_size = account_globals::getvalue($account->id, "font_size");
    if(!($font_size > 0))
    {
        $font_size = "";
    }

    $font_unit_size = account_globals::getvalue($account->id, "font_unit_size");
    if($font_size_unit == "")
    {
        $font_size_unit = "px";
    }

    $background_image = account_globals::getvalue($account->id, "background_image");
    $header_image = account_globals::getvalue($account->id, "header_image");

    $site_logo = account_globals::getvalue($account->id, "site_logo");
    $site_link = account_globals::getvalue($account->id, "site_link");
    $contact_link = account_globals::getvalue($account->id, "contact_link");
    $terms_of_use_link = account_globals::getvalue($account->id, "terms_of_use_link");
    $privacy_policy_link = account_globals::getvalue($account->id, "privacy_policy_link");

?>

<style>

/*****generate some style from settings****/


body { 
    <?if($background_image != ""){?>
    background: url('assets/<?=$account->id?>/<?=$background_image?>') no-repeat center center fixed; 
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
    <?}?>
    background-color: <?=$background_color?> !important;
    <?if($font_family != ""){?>
    font-family: <?=$font_family?> !important;
    <?}?>
    <?if($font_size != ""){?>
    font-size: <?=$font_size?><?=$font_size_unit?> !important;
    <?}?>
    <?if($text_color != ""){?>
    color: <?=$text_color?> !important;
    <?}?>
}

a {
    <?if($font_family != ""){?>
    font-family: <?=$font_family?> !important;
    <?}?>
    <?if($font_size != ""){?>
    font-size: <?=$font_size?><?=$font_size_unit?> !important;
    <?}?>
}

.form-control {
    <?if($font_family != ""){?>
    font-family: <?=$font_family?> !important;
    <?}?>
    <?if($font_size != ""){?>
    font-size: <?=$font_size?><?=$font_size_unit?> !important;
    <?}?>
}

.btn-primary {
    color: #fff !important;
	padding: 4px 22px;
    background-color: <?=$main_color?> !important;
    border-color: <?=color_luminance($main_color, -0.10)?> !important;
    <?if($font_family != ""){?>
    font-family: <?=$font_family?> !important;
    <?}?>
    <?if($font_size != ""){?>
    font-size: <?=$font_size?><?=$font_size_unit?> !important;
    <?}?>
}

.btn-primary-preview {
    color: #fff !important;
    padding: 6px 22px;
    background-color: <?=$main_color?> !important;
    border: 1px solid <?=color_luminance($main_color, -0.10)?> !important;
    <?if($font_family != ""){?>
    font-family: <?=$font_family?> !important;
    <?}?>
    font-size: 14px !important;
}

.btn-primary:hover, .btn-primary:active, .btn-primary:focus, .btn-primary:active:focus {
    background-color: <?=color_luminance($main_color, -0.20)?> !important;
    border-color: <?=color_luminance($main_color, -0.30)?> !important;
}

.navbar-nav > li.active > a, .navbar-nav > li.active > a:hover, .navbar-nav > li.active > a:focus {
    background-color: #ffffff !important;
    font-weight: 900;
    text-transform: uppercase;
    padding-bottom: 15px;
	text-decoration: none; 
	position: relative;
}

.navbar-nav > li.active > a:after {
	position: absolute;
	content: '';
	height: 4px;
	bottom: 10px;
	margin: 0 auto;
	left: 0;
	right: 0;
	width: 100%;
	background: <?=$main_color?>;
}

.navbar-nav > li > a {
    font-weight: 600;
    text-transform: uppercase;
    padding-bottom: 5px;
}

hr {
    border-top: 1px solid <?=color_luminance($main_color, 0.25)?> !important;
}

.custom-container
{
    margin-top: 10px;
    margin-bottom: 20px;
    padding: 30px;
    background-color: #ffffff;
	box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
}

.custom-navbar
{
    margin-top: 20px;
    margin-bottom: 20px;
    padding: 10px;
    background-color: #ffffff;
	border-radius: 0px;
	box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
}

.custom-logo
{
	margin-right: 10px;
}

.giftcards-container
{
	box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
	transition: 0.3s;
	background-color: #f9f9f9;
	margin: 20px 0;
	padding: 10px;
	display: inline-block;
}

.giftcards-container:hover
{
	box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
}

.giftcard-column
{
	float: left;
	width: 50%;
	padding: 0 10px;
}

.giftcard-column-preview
{
	margin-left: auto;
	margin-right: auto;
	width: 60%;
	padding: 0 10px;
}


.giftcards-row
{
	margin: 0 -5px;
}


.giftcards-row:after
{
	content: "";
	display: table;
	clear: both;
}

@media screen and (max-width: 600px) {
	.giftcard-column {
		width: 100%;
		display: block;
		margin-bottom: 20px;
	}
	.checkbox-inline+.checkbox-inline, .radio-inline+.radio-inline {
		margin-left: 0px;
	}
	.giftcard-column-preview {
		width: 100%;
	}
}

.giftcard-img-container
{
	display: flex;
	justify-content: center;
	align-items: center;
	min-height: 132px;
	padding: 0 5px;
}

.giftcard-img
{
	border-radius: 10px;
}

.giftcard-title
{
    font-size: 120%;
    font-weight: bold;
	padding-top: 10px;
}

.giftcard-description
{
    
}

.giftcard-message
{
    font-style: italic;
}

.giftcard-price
{
    font-size: 110%;
    font-weight: bold;
	line-height: 31px;
}

.custom-footer-links
{
	text-align: center;
}

.custom-footer-links a
{
	<?if($text_color != ""){?>
    color: <?=$text_color?> !important;
    <?}?>
	padding: 5px;
	text-decoration: none;
	font-weight: 600;
}

.custom-footer-links a:hover
{
	text-decoration: underline; 
}

.help-block
{
	text-align: center;
}



/*****add custom css manually defined****/

<?=$custom_css?>

</style>

    </head>

    <body>

        <div class="container">

            <nav class="navbar navbar-default custom-navbar">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <?if ($site_logo != ""){?>
                        <a class="navbar-left custom-logo" href="<?=$site_link?>" target="_blank">
                            <img src="assets/<?=$account->id?>/<?=$site_logo?>" alt="<?=$site_name?>" class="img-responsive" style="max-height: 50px;">
                        </a>
                        <?}else{?>
                        <a class="navbar-brand" href="<?=$site_link?>" target="_blank"><?=$site_name?></a>                    
                        <?}?>
                    </div>
                    <div id="navbar" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">
                            <li class="<?=(isset($_GET['page']) && ($_GET['page'] == "send-giftcard") ? "active" : "")?>" ><a href="<?=$account->name?>/send-giftcard"><i class="fa fa-envelope" aria-hidden="true"></i> Send giftcard</a></li>
                            <li class="<?=(isset($_GET['page']) && ($_GET['page'] == "check-giftcard") ? "active" : "")?>"><a href="<?=$account->name?>/check-giftcard"><i class="fa fa-search" aria-hidden="true"></i> Check giftcard</a></li>
                            <?if ($contact_link != ""){?>
                            <li><a href="<?=$contact_link?>" target="_blank"><i class="fa fa-address-card" aria-hidden="true"></i> Contact Us</a></li>
                            <?}?>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="<?=$site_link?>" target="_blank"><i class="fa fa-external-link" aria-hidden="true"></i> Visit our website!</a></li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="row">
                <div class="col-xs-12">
                    <div class="custom-container">