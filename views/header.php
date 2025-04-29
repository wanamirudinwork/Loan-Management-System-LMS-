<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo 'Personal Banc :: Loan Management System';?></title>   
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta name="apple-mobile-web-app-capable" content="yes" />

        <!-- Base Css Files -->
        <link href="<?php echo url_for('/assets/libs/jqueryui/ui-lightness/jquery-ui-1.10.4.custom.min.css'); ?>" rel="stylesheet" />
        <link href="<?php echo url_for('/assets/libs/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet" />
        <link href="<?php echo url_for('/assets/libs/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet" />
        <link href="<?php echo url_for('/assets/libs/fontello/css/fontello.css'); ?>" rel="stylesheet" />
        <link href="<?php echo url_for('/assets/libs/animate-css/animate.min.css'); ?>" rel="stylesheet" />
        <link href="<?php echo url_for('/assets/libs/nifty-modal/css/component.css'); ?>" rel="stylesheet" />
        <link href="<?php echo url_for('/assets/libs/magnific-popup/magnific-popup.css'); ?>" rel="stylesheet" /> 
        <link href="<?php echo url_for('/assets/libs/ios7-switch/ios7-switch.css'); ?>" rel="stylesheet" /> 
        <link href="<?php echo url_for('/assets/libs/pace/pace.css'); ?>" rel="stylesheet" />
        <link href="<?php echo url_for('/assets/libs/sortable/sortable-theme-bootstrap.css'); ?>" rel="stylesheet" />
        <link href="<?php echo url_for('/assets/libs/bootstrap-datepicker/css/datepicker.css'); ?>" rel="stylesheet" />
        <link href="<?php echo url_for('/assets/libs/bootstrap/timepicker/bootstrap-datetimepicker.css'); ?>" rel="stylesheet" />
        <link href="<?php echo url_for('/assets/libs/jquery-icheck/skins/all.css'); ?>" rel="stylesheet" />
        <link href="<?php echo url_for('/assets/libs/jquery-notifyjs/styles/metro/notify-metro.css'); ?>" rel="stylesheet" />        
                <!-- Extra CSS Libraries Start -->
                <link href="<?php echo url_for('/assets/libs/rickshaw/rickshaw.min.css'); ?>" rel="stylesheet" type="text/css" />
                <link href="<?php echo url_for('/assets/libs/morrischart/morris.css'); ?>" rel="stylesheet" type="text/css" />
                <link href="<?php echo url_for('/assets/libs/jquery-jvectormap/css/jquery-jvectormap-1.2.2.css'); ?>" rel="stylesheet" type="text/css" />
                <link href="<?php echo url_for('/assets/libs/jquery-clock/clock.css'); ?>" rel="stylesheet" type="text/css" />
                <link href="<?php echo url_for('/assets/libs/bootstrap-calendar/css/bic_calendar.css'); ?>" rel="stylesheet" type="text/css" />
                <link href="<?php echo url_for('/assets/libs/sortable/sortable-theme-bootstrap.css'); ?>" rel="stylesheet" type="text/css" />
                <link href="<?php echo url_for('/assets/libs/jquery-weather/simpleweather.css'); ?>" rel="stylesheet" type="text/css" />
                <link href="<?php echo url_for('/assets/libs/bootstrap-xeditable/css/bootstrap-editable.css'); ?>" rel="stylesheet" type="text/css" />
                <link href="<?php echo url_for('/assets/libs/chosen/chosen.min.css'); ?>" rel="stylesheet" type="text/css" />
                <link href="<?php echo url_for('/assets/libs/colorpicker/css/bootstrap-colorpicker.min.css'); ?>" rel="stylesheet" type="text/css" />
                <link href="<?php echo url_for('/assets/css/style.css'); ?>" rel="stylesheet" type="text/css" />
                <!-- Extra CSS Libraries End -->
        <link href="<?php echo url_for('/assets/libs/bootstrap-select/bootstrap-select.min.css'); ?>" rel="stylesheet" />
        <link href="<?php echo url_for('/assets/css/style-responsive.css'); ?>" rel="stylesheet" />
        <link href="<?php echo url_for('/assets/css/stylesheet.css'); ?>" rel="stylesheet" />
        <link href="<?php echo url_for('/assets/css/whatsapp.css'); ?>" rel="stylesheet" />
        
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <link rel="shortcut icon" href="<?php echo url_for('/assets/img/favicon.ico'); ?>">
        <link rel="apple-touch-icon" href="<?php echo url_for('/assets/img/apple-touch-icon.png'); ?>" />
        <link rel="apple-touch-icon" sizes="57x57" href="<?php echo url_for('/assets/img/apple-touch-icon-57x57.png'); ?>" />
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo url_for('/assets/img/apple-touch-icon-72x72.png'); ?>" />
        <link rel="apple-touch-icon" sizes="76x76" href="<?php echo url_for('/assets/img/apple-touch-icon-76x76.png'); ?>" />
        <link rel="apple-touch-icon" sizes="114x114" href="<?php echo url_for('/assets/img/apple-touch-icon-114x114.png'); ?>" />
        <link rel="apple-touch-icon" sizes="120x120" href="<?php echo url_for('/assets/img/apple-touch-icon-120x120.png'); ?>" />
        <link rel="apple-touch-icon" sizes="144x144" href="<?php echo url_for('/assets/img/apple-touch-icon-144x144.png'); ?>" />
        <link rel="apple-touch-icon" sizes="152x152" href="<?php echo url_for('/assets/img/apple-touch-icon-152x152.png'); ?>" />
        
         <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="<?php echo url_for('/assets/libs/jquery/jquery-1.11.1.min.js'); ?>"></script>
        <script src="<?php echo url_for('/assets/libs/jquery/jquery-migrate-1.1.1.min.js'); ?>"></script>
        <script src="<?php echo url_for('/assets/libs/bootstrap/js/bootstrap.min.js'); ?>"></script>
        <script src="<?php echo url_for('/assets/libs/bootstrap/timepicker/moment-with-locales.js'); ?>"></script>
        <script src="<?php echo url_for('/assets/libs/bootstrap/timepicker/bootstrap-datetimepicker.js'); ?>"></script>
        <script src="<?php echo url_for('/assets/libs/jqueryui/jquery-ui-1.10.4.custom.min.js'); ?>"></script>
    </head>
    <body class="fixed-left">
    <!-- Modal Start -->
	<!-- Modal Logout -->
	<div class="md-modal md-just-me" id="logout-modal">
		<div class="md-content">
			<h3><strong>Logout</strong> Confirmation</h3>
			<div>
				<p class="text-center">Are you sure want to logout from this system?</p>
				<p class="text-center">
				<button class="btn btn-danger md-close">Nope!</button>
				<a href="<?php echo url_for('/logout'); ?>" class="btn btn-success md-close">Yeah, I'm sure</a>
				</p>
			</div>
		</div>
	</div><!-- Modal End -->	
	<!-- Begin page -->
	<div id="wrapper">
		
<!-- Top Bar Start -->
<div class="topbar">
    <div class="topbar-left">
        <div class="logo">
            <h1><a href="<?php echo url_for('/'); ?>"><?php echo 'LMS';?></a></h1>
        </div>
        <button class="button-menu-mobile open-left">
        <i class="fa fa-bars"></i>
        </button>
    </div>
    <!-- Button mobile view to collapse sidebar menu -->
    <div class="navbar navbar-default" role="navigation">
        <div class="container">
            <div class="navbar-collapse2">
                <ul class="nav navbar-nav navbar-right top-navbar">
                    <li class="dropdown iconify hide-phone"><a href="javascript:;" onclick="javascript:toggle_fullscreen()"><i class="icon-resize-full-2"></i></a></li>
                    <li class="dropdown topbar-profile">
                        <a href="index.html#" class="dropdown-toggle" data-toggle="dropdown">
						<?php echo $cms->admin->logged ? $cms->admin->info['admin_username'] : "Guest"; ?> <i class="fa fa-caret-down"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo url_for('/profile'); ?>">My Profile</a></li>
                            <li class="divider"></li>
                            <li><a class="md-trigger" data-modal="logout-modal"><i class="icon-logout-1"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!--/.nav-collapse -->
        </div>
    </div>
</div>
<!-- Top Bar End -->
		    <!-- Left Sidebar Start -->
        <div class="left side-menu">
            <div class="sidebar-inner slimscrollleft">
            	<?php /*
               <!-- Search form -->
                <form role="search" class="navbar-form">
                    <div class="form-group">
                        <input type="text" placeholder="Search" class="form-control">
                        <button type="submit" class="btn search-button"><i class="fa fa-search"></i></button>
                    </div>
                </form>
				<div class="clearfix"></div>
				*/ ?>
                <hr class="divider" />
                <!--- Profile -->
                <div class="profile-info">
                    <div class="col-sm-12">
                        <div class="profile-text profile-buttons">
                        	<a href="javascript:;" class="md-trigger" data-modal="logout-modal" title="Sign Out"><i class="fa fa-power-off text-red-1"></i></a>
                        	Welcome <b><?php echo $cms->admin->logged ? $cms->admin->info['admin_username'] : "Guest"; ?></b>
                        </div>
                    </div>
                </div>
                <!--- Divider -->
                <div class="clearfix"></div>
                <hr class="divider" />
                <div class="clearfix"></div>
                <!--- Divider -->
                <?php echo $cms->admin->logged ? partial('menu.php') : "";  ?>
            <div class="clearfix"></div>
        </div>
        </div>
        <!-- Left Sidebar End -->
