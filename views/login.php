<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo SITE_NAME . ' Control Panel';?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="description" content="">
        <meta name="keywords" content="coco bootstrap template, coco admin, bootstrap,admin template, bootstrap admin,">
        <meta name="author" content="Huban Creative">

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
        <link href="<?php echo url_for('/assets/libs/jquery-icheck/skins/all.css'); ?>" rel="stylesheet" />
        <link href="<?php echo url_for('/assets/libs/jquery-notifyjs/styles/metro/notify-metro.css'); ?>" rel="stylesheet" />
        <!-- Code Highlighter for Demo -->
        <link href="<?php echo url_for('/assets/libs/prettify/github.css'); ?>" rel="stylesheet" />
        
                <!-- Extra CSS Libraries Start -->
                <link href="<?php echo url_for('/assets/css/style.css'); ?>" rel="stylesheet" type="text/css" />
                <!-- Extra CSS Libraries End -->
        <link href="<?php echo url_for('/assets/css/style-responsive.css'); ?>" rel="stylesheet" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js'); ?>"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js'); ?>"></script>
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
        <script src="<?php echo url_for('/assets/libs/jqueryui/jquery-ui-1.10.4.custom.min.js'); ?>"></script>
    </head>
    <body class="fixed-left login-page">

		
	<!-- Modal Logout -->
	<div class="md-modal md-just-me" id="logout-modal">
		<div class="md-content">
			<h3><strong>Logout</strong> Confirmation</h3>
			<div>
				<p class="text-center">Are you sure want to logout from this awesome system?</p>
				<p class="text-center">
				<button class="btn btn-danger md-close">Nope!</button>
				<a href="login.html" class="btn btn-success md-close">Yeah, I'm sure</a>
				</p>
			</div>
		</div>
	</div>        <!-- Modal End -->		
	<!-- Begin page -->
	<div class="container">
		<div class="full-content-center">
			<div class="login-wrap animated flipInX">
				<div class="login-block">
					<form id="loginform">
						<div class="form-group login-input">
						<i class="fa fa-user overlay"></i>
						<input type="text" class="form-control text-input" name="username" placeholder="Username">
						</div>
						<div class="form-group login-input">
						<i class="fa fa-key overlay"></i>
						<input type="password" class="form-control text-input" name="password" placeholder="********">
						</div>
						
						<div class="row text-center">
							<div class="col-sm-12">
								<button type="submit" class="btn btn-success btn-block">LOGIN</button>
							</div>
						</div>
					</form>
				</div>
			</div>
			
		</div>
	</div>
	<!-- the overlay modal element -->
	<div class="md-overlay"></div>
	<!-- End of eoverlay modal -->
	<script>
		var resizefunc = [];
	</script>
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="<?php echo url_for('/assets/libs/jquery/jquery-1.11.1.min.js'); ?>"></script>
	<script src="<?php echo url_for('/assets/libs/bootstrap/js/bootstrap.min.js'); ?>"></script>
	<script src="<?php echo url_for('/assets/libs/jqueryui/jquery-ui-1.10.4.custom.min.js'); ?>"></script>
	<script src="<?php echo url_for('/assets/libs/jquery-ui-touch/jquery.ui.touch-punch.min.js'); ?>"></script>
	<script src="<?php echo url_for('/assets/libs/jquery-detectmobile/detect.js'); ?>"></script>
	<script src="<?php echo url_for('/assets/libs/jquery-animate-numbers/jquery.animateNumbers.js'); ?>"></script>
	<script src="<?php echo url_for('/assets/libs/ios7-switch/ios7.switch.js'); ?>"></script>
	<script src="<?php echo url_for('/assets/libs/fastclick/fastclick.js'); ?>"></script>
	<script src="<?php echo url_for('/assets/libs/jquery-blockui/jquery.blockUI.js'); ?>"></script>
	<script src="<?php echo url_for('/assets/libs/bootstrap-bootbox/bootbox.min.js'); ?>"></script>
	<script src="<?php echo url_for('/assets/libs/jquery-slimscroll/jquery.slimscroll.js'); ?>"></script>
	<script src="<?php echo url_for('/assets/libs/jquery-sparkline/jquery-sparkline.js'); ?>"></script>
	<script src="<?php echo url_for('/assets/libs/nifty-modal/js/classie.js'); ?>"></script>
	<script src="<?php echo url_for('/assets/libs/nifty-modal/js/modalEffects.js'); ?>"></script>
	<script src="<?php echo url_for('/assets/libs/sortable/sortable.min.js'); ?>"></script>
	<script src="<?php echo url_for('/assets/libs/bootstrap-fileinput/bootstrap.file-input.js'); ?>"></script>
	<script src="<?php echo url_for('/assets/libs/bootstrap-select/bootstrap-select.min.js'); ?>"></script>
	<script src="<?php echo url_for('/assets/libs/bootstrap-select2/select2.min.js'); ?>"></script>
	<script src="<?php echo url_for('/assets/libs/magnific-popup/jquery.magnific-popup.min.js'); ?>"></script> 
	<script src="<?php echo url_for('/assets/libs/pace/pace.min.js'); ?>"></script>
	<script src="<?php echo url_for('/assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.js'); ?>"></script>
	<script src="<?php echo url_for('/assets/libs/jquery-icheck/icheck.min.js'); ?>"></script>
    <script src="<?php echo url_for('/assets/libs/jquery-notifyjs/notify.min.js'); ?>"></script>
    <script src="<?php echo url_for('/assets/libs/jquery-notifyjs/styles/metro/notify-metro.js'); ?>"></script>

	<!-- Demo Specific JS Libraries -->
    <script src="<?php echo url_for('/assets/libs/prettify/prettify.js'); ?>"></script>
	<script src="<?php echo url_for('/assets/js/init.js'); ?>"></script>
    <script src="<?php echo url_for('/assets/js/script.js'); ?>"></script>
	</body>
</html>