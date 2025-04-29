<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>404 Not Found | <?php echo PANEL_TITLE;?></title>   
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
        <link href="<?php echo url_for('/assets/libs/jquery-icheck/skins/all.css'); ?>" rel="stylesheet" />        
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
    </head>
    <body class="fixed-left full-content">
		
	<!-- Begin page -->
	<div class="container">
		<div class="full-content-center animated flipInX">
			<h1>OOPS!</h1>
			<h2>You don't have permission to access this resource</h2><br>
			<a class="btn btn-primary btn-sm" href="<?php echo url_for('/'); ?>"><i class="fa fa-angle-left"></i> Back to Dashboard</a>
		</div>
	</div>
	<!-- End of page -->
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

	<!-- Demo Specific JS Libraries -->
	<script src="<?php echo url_for('/assets/libs/prettify/prettify.js'); ?>"></script>
	<script src="<?php echo url_for('/assets/js/init.js'); ?>"></script>
	</body>
</html>