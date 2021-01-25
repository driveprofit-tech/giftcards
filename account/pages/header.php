<!DOCTYPE html>
<html>

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title><?=$pgtitle?></title>

        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="../code/bootstrap/dist/css/bootstrap.min.css">
        <!-- <link rel="stylesheet" href="../code/font-awesome/css/font-awesome.min.css"> -->
        <link rel="stylesheet" href="../code/fontawesome-5/css/all.min.css?v=5.15.2">
        <link rel="stylesheet" href="../code/Ionicons/css/ionicons.min.css">
        <link rel="stylesheet" href="../code/jvectormap/jquery-jvectormap.css">
        <link rel="stylesheet" href="../code/datatables.net-bs/css/dataTables.bootstrap.min.css">
        <link rel="stylesheet" href="../code/css/AdminLTE.min.css">
        <link rel="stylesheet" href="../code/css/skins/_all-skins.min.css">
        <link rel="stylesheet" href="../code/css/pretty-checkbox.min.css">
        <link rel="stylesheet" href="../code/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
        <link rel="stylesheet" href="../code/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css">
        <link rel="stylesheet" href="../code/css/dashboard.min.css">

		<script src="../code/gsap/gsap.min.js?v=3.6.0"></script>
		<script src="../code/gsap/ScrollTrigger.min.js?v=3.6.0"></script>
        <script src="../code/jquery/dist/jquery.min.js"></script>
        <script src="../code/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="../code/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="../code/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
        <script src="../code/fastclick/lib/fastclick.js"></script>
        <script src="../code/scripts/adminlte.min.js"></script>
        <script src="../code/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
        <script src="../code/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <script src="../code/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
        <script src="../code/scripts/moment.min.js"></script>
        <script src="../code/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>


        <!-- Vaildator -->
        <script src="../code/scripts/validator.min.js"></script>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

        <link rel="shortcut icon" type="image/x-icon" href="<?="../assets/" . $_SESSION['user']['account_id'] . "/" . account_globals::getvalue($_SESSION['user']['account_id'], "site_favicon")?>">

    </head>

    <body class="hold-transition sidebar-mini">

        <div class="wrapper">

            <header id="main-header" class="main-header">

                <!-- Logo -->
                <a href="index.php?page=home" class="logo">

                    <span class="logo-mini"><i class="fas fa-fw fa-globe"></i></span>
                    <span class="logo-lg">
                    <?
                    if (account_globals::getvalue($_SESSION['user']['account_id'], "site_logo") != "")
                    {
                    ?>
                        <img class="img-responsive center-block" src="<?="../assets/" . $_SESSION['user']['account_id'] . "/" . account_globals::getvalue($_SESSION['user']['account_id'], "site_logo")?>" alt="<?=account_globals::getvalue($_SESSION['user']['account_id'], "site_name")?>">
                    <?
                        }
                        else
                        {
                    ?>
                        <?=account_globals::getvalue($_SESSION['user']['account_id'], "site_name")?>
                    <?
                        }
                    ?>
                    </span>

                </a>

                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top">

					<button type="button" name="button" class="sidebar-toggle d-md-none" data-toggle="push-menu"><i class="fas fa-fw fa-caret-right"></i></button>

                    <div class="navbar-custom-menu mr-2 mr-md-3">
                        <ul class="nav navbar-nav">
                            <?if($_SESSION['user']['admin'] == "on"){?>
                            <li>
                                <a href="index.php?page=globals"><i class="fas fa-fw fa-sliders-h"></i> Settings</a>
                            </li>
                            <?}?>
                            <li>
                                <a href="index.php?page=logout"><i class="fas fa-fw fa-sign-out-alt"></i> Logout</a>
                            </li>
                        </ul>
                    </div>

                </nav>

            </header>

            <!-- Left side column. contains the logo and sidebar -->
            <aside id="main-sidebar" class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar p-2">
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu py-4" data-widget="tree">

                        <li class="<?=(in_array($_GET['page'], array("home")) ? "active" : "")?>">
                            <a href="index.php?page=home"><i class="fas fa-fw fa-house-user"></i> <span>Dashboard</span></a>
                        </li>
                        <?if($_SESSION['user']['admin'] == "on"){?>
                        <li class="<?=(in_array($_GET['page'], array("manage-users", "user")) ? "active" : "")?>">
                            <a href="index.php?page=manage-users"><i class="fas fa-fw fa-user-friends"></i> <span>Users</span></a>
                        </li>
                        <li class="<?=(in_array($_GET['page'], array("manage-giftcards", "giftcard", "giftcard-gallery")) ? "active" : "")?>">
                            <a href="index.php?page=manage-giftcards"><i class="fas fa-fw fa-gift"></i> <span>Giftcards</span></a>
                        </li>
                        <li class="<?=(in_array($_GET['page'], array("manage-purchases")) ? "active" : "")?>">
                            <a href="index.php?page=manage-purchases"><i class="fas fa-fw fa-shopping-cart"></i> <span>Giftcards purchased</span></a>
                        </li>
                        <?}?>

                        <? $account = MyActiveRecord::FindFirst('account', array("id"=>$_SESSION['user']['id'])); ?>
                        <li class="">
                            <a href="<?=BASE_PATH . $account->name . "/send-giftcard"?>" target="_blank"><i class="fas fa-fw fa-laptop-house"></i> <span>Landing page</span></a>
                        </li>

                    </ul>

					<button type="button" name="button" class="sidebar-toggle d-none d-md-inline-block w-100" data-toggle="push-menu"><i class="fas fa-fw fa-caret-left"></i></button>

                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div id="main-content" class="content-wrapper p-5">

                <!-- Content Header (Page header) -->
                <section class="content-header">

                    <h1><?=$onpgtitle?></h1>

					<?php
					if( ! empty( $pagebreadcrumb ) ) {
						?>
						<ol class="breadcrumb mt-4">
							<?php
							?>
							<li><a href="index.php?page=home"><i class="fas fa-fw fa-house-user"></i> Dashboard</a></li>
							<?php
							foreach( $pagebreadcrumb as $index => $page ) {
								if( $index + 1 == count( $pagebreadcrumb ) ) {
									?>
									<li class="active"><span><?= $page[ 'page' ] ?></span></li>
									<?php
								} else {
									?>
									<li><a href="index.php?page=<?= $page[ 'url' ] ?>"><?= $page[ 'page' ] ?></a></li>
									<?php
								}
							}
							?>
						</ol>
						<?php
					}
					?>

                </section>

                <!-- Main content -->
                <section class="content">
