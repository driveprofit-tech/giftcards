<!DOCTYPE html>
<html>

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title><?=$pgtitle?></title>

        <?
        if (globals::getvalue("site_favicon") != "")
            {
        ?>
        <link rel="shortcut icon" href="<?="../assets/" . globals::getvalue("site_favicon")?>" type="image/x-icon" />
        <?
            }
        ?>

        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="../code/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="../code/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="../code/Ionicons/css/ionicons.min.css">
        <link rel="stylesheet" href="../code/jvectormap/jquery-jvectormap.css">
        <link rel="stylesheet" href="../code/datatables.net-bs/css/dataTables.bootstrap.min.css">
        <link rel="stylesheet" href="../code/css/AdminLTE.min.css">
        <link rel="stylesheet" href="../code/css/skins/_all-skins.min.css">

        <script src="../code/jquery/dist/jquery.min.js"></script>
        <script src="../code/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="../code/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="../code/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
        <script src="../code/fastclick/lib/fastclick.js"></script>
        <script src="../code/scripts/adminlte.min.js"></script>
        <script src="../code/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
        <script src="../code/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <script src="../code/chart.js/Chart.js"></script>
        <script type="text/javascript" src="../code/scripts/validator.min.js"></script>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    </head>

    <body class="hold-transition skin-black-light sidebar-mini">

        <div class="wrapper">

            <header class="main-header">

                <!-- Logo -->
                <a href="index.php?page=home" class="logo">

                    <span class="logo-mini"><i class="fa fa-bus"></i></span>

                    <span class="logo-lg" style="padding-top: 0px;">
                    <?
                    if (globals::getvalue("site_logo") != "")
                    {
                    ?>
                        <img src="<?="../assets/" . globals::getvalue("site_logo")?>" alt="<?=globals::getvalue("site_name")?>" />
                    <?
                        }
                        else
                        {
                    ?>
                        <?=globals::getvalue("site_name")?>
                    <?
                        }
                    ?>
                    </span>

                </a>

                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top">

                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    </a>

                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <li>
                                <a href="index.php?page=globals"><i class="fa fa-gears"></i> Settings</a>
                            </li>
                            <li>
                                <a href="index.php?page=logout"><i class="fa fa-sign-out"></i> Logout</a>
                            </li>
                        </ul>
                    </div>

                </nav>

            </header>

            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu" data-widget="tree">

                        <li class="<?=(in_array($_GET['page'], array("home", "account")) ? "active" : "")?>">
                            <a href="index.php?page=home"><i class="fa fa-users"></i> <span>Accounts</span></a>
                        </li>

                        <li class="<?=(in_array($_GET['page'], array("notify-users")) ? "active" : "")?>">
                           <a href="index.php?page=notify-users"><i class="fa fa-comments"></i> <span>Notify users</span></a>
                        </li>

                        <li class="<?=(in_array($_GET['page'], array("categories", "category")) ? "active" : "")?>">
                            <a href="index.php?page=categories"><i class="fa fa-bars"></i> <span>Giftcard Categories</span></a>
                        </li>

                        <li class="<?=(in_array($_GET['page'], array("giftcards", "giftcard")) ? "active" : "")?>">
                            <a href="index.php?page=giftcards"><i class="fa fa-picture-o"></i> <span>Giftcards</span></a>
                        </li>

                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">

                <!-- Content Header (Page header) -->
                <section class="content-header">

                    <h1><?=$onpgtitle?></h1>

                </section>

                <!-- Main content -->
                <section class="content">
 
