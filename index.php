<?php
ini_set('display_errors', 0);

//require_once "phpqrcode/qrlib.php";
// require_once '../currencyToWords.php';
// require_once 'TCPDF/tcpdf.php';
// require_once '../fpdf181/fpdf.php';
require_once 'assets/vendors/phpmailer/autoload.php';
require_once 'assets/vendors/email.php';
require_once 'lib/limonade.php';
require_once 'lib/config.php';

function configure(){
  option('env', ENV_DEVELOPMENT);
  option('site_uri', ROOTPATH);
  option('base_uri', ROOTPATH);
}

function before($route){
	global $cms;
    set('currPath', $route['callback'][1]);
	set('settings', $cms->settings);
	set('cms', $cms);
}

if($cms->admin->logged){
	dispatch('/', array($cms, 'home'));
	dispatch('/profile', array($cms, 'profile'));
	dispatch('/admin', array($cms, 'admin'));
	dispatch('/admin/insert', array($cms, 'adminInsert'));
	dispatch('/admin/:id', array($cms, 'adminUpdate'));

	// Role CMS
	dispatch('/role', array($cms, 'role'));
	dispatch('/role/insert', array($cms, 'roleInsert'));
	dispatch('/role/:id', array($cms, 'roleUpdate'));
	dispatch('/settings', array($cms, 'site_settings'));

	// LMS Borrowers

	dispatch('/borrowers', array($cms, 'borrowers'));
	dispatch('/borrowers/insert', array($cms, 'borrowerInsert'));
	dispatch('/borrowers/export', array($cms, 'borrowerExport'));
	dispatch('/borrowers/:id', array($cms, 'borrowerUpdate'));
	dispatch('/borrowers/:bid/:id', array($cms, 'borrowerUpdateID'));
	dispatch('/borrowers/contact/:bid/insert', array($cms, 'borrowerContactInsert'));
	dispatch('/borrowers/contact/:bid/update/:id', array($cms, 'borrowerContactUpdate'));
	dispatch('/borrowers/employment/:bid/insert', array($cms, 'borrowerEmploymentInsert'));
	dispatch('/borrowers/employment/:bid/update/:id', array($cms, 'borrowerEmploymentUpdate'));
	dispatch('/borrowers/spouse/:bid/insert', array($cms, 'borrowerSpouseInsert'));
	dispatch('/borrowers/spouse/:bid/update/:id', array($cms, 'borrowerSpouseUpdate'));
	dispatch('/borrowers/spouse_employment/:bid/insert', array($cms, 'borrowerSpouseEmploymentInsert'));
	dispatch('/borrowers/spouse_employment/:bid/update/:id', array($cms, 'borrowerSpouseEmploymentUpdate'));
	dispatch('/borrowers/guarantor/:bid/insert', array($cms, 'borrowerGuarantorInsert'));
	dispatch('/borrowers/guarantor/:bid/update/:id', array($cms, 'borrowerGuarantorUpdate'));
	dispatch('/borrowers/reference/:bid/insert', array($cms, 'borrowerReferenceInsert'));
	dispatch('/borrowers/reference/:bid/update/:id', array($cms, 'borrowerReferenceUpdate'));
	dispatch('/borrowers/remark/:bid/insert', array($cms, 'borrowerRemarkInsert'));
  	dispatch('/borrowers/:id/export/pdf', array($cms, 'borrowerDetailsExport'));

	// dispatch('/borrowers/remark/:bid/update/:id', array($cms, 'borrowerRemarkUpdate'));
	// dispatch('/borrowers/spouse_employment/insert/:id', array($cms, 'borrowerSpouseEmploymentInsert'));

	dispatch('/pages', array($cms, 'pages'));
	dispatch('/pages/:id', array($cms, 'pageUpdate'));
	dispatch('/customers', array($cms, 'customers'));
	dispatch('/customers/insert', array($cms, 'customerInsert'));
        dispatch('/customers/testing', array($cms, 'customerTesting'));
	dispatch('/customers/:id', array($cms, 'customerUpdate'));
	dispatch('/applications', array($cms, 'applications'));
	dispatch('/applications/update/:id', array($cms, 'applicationUpdate'));
	dispatch('/applications/insert', array($cms, 'applicationInsert'));
	dispatch('/applications/:id', array($cms, 'approverApplicationUpdate'));

	dispatch_post('/customers', array($post, 'exportToCSV'));
	dispatch_post('/delete', array($post, 'delete'));
	dispatch_post('/profile', array($post, 'profile'));
	dispatch_post('/admin', array($post, 'admin'));
	dispatch_post('/admin/insert', array($post, 'adminInsert'));
	dispatch_post('/admin/:id', array($post, 'adminUpdate'));

	// Role POST
	dispatch_post('/role', array($post, 'role'));
	dispatch_post('/role/insert', array($post, 'roleInsert'));
	dispatch_post('/role/:id', array($post, 'roleUpdate'));

	dispatch_post('/settings', array($post, 'site_settings'));
	dispatch_post('/pages/:id', array($post, 'pageUpdate'));

	dispatch('/articles', array($cms, 'articles'));
	dispatch('/articles/insert-new', array($cms, 'articleInsert'));
	dispatch('/articles/:id', array($cms, 'articleUpdate'));


	dispatch('/analytic', array($cms, 'analytic'));
	dispatch('/inquiry', array($cms, 'inquiry'));
	dispatch('/inquiry/insert', array($cms, 'inquiryInsert'));
	dispatch('/inquiry/:id', array($cms, 'inquiryUpdate'));

	dispatch('/unsubscribe', array($cms, 'unsubscribe'));

	dispatch('/investment', array($cms, 'investment'));
	dispatch('/investment/insert', array($cms, 'investmentInsert'));
	dispatch('/investment/update/:id', array($cms, 'investmentUpdate'));
	dispatch('/investment/details/:id', array($cms, 'investmentDetails'));


	dispatch('/loan', array($cms, 'loan'));
	dispatch('/loanApproval', array($cms, 'loanApproval'));
	dispatch('/loan/recovery/:id', array($cms, 'loanRecovery'));
	dispatch('/loan/update/:id', array($cms, 'loanUpdate'));
	dispatch('/loanApproval/update/:id', array($cms, 'loanApprovalUpdate'));
	dispatch('/loan/insert', array($cms, 'loanInsert'));
	dispatch('/loan/:id', array($cms, 'loanView'));		//loan view from borrower_id
	dispatch('/loan/insert/:id', array($cms, 'loanInsertId'));
  dispatch('/loan/:id/export/:type', array($cms, 'loanExport'));





	dispatch('/mortgage', array($cms, 'mortgage'));
	dispatch('/mortgage/details/:id', array($cms, 'mortgageDetails'));
	dispatch('/mortgage/insert', array($cms, 'mortgageInsert'));
	dispatch('/mortgage/details/edit/:id', array($cms, 'mortgageStatusChange'));

	dispatch('/recovery', array($cms, 'recovery'));
	dispatch('/recovery/update/:id', array($cms, 'recoveryUpdate'));

	//Risk
	dispatch('/risk', array($cms, 'risk'));
	dispatch('/risk/update/:id', array($cms, 'riskUpdate'));

	//collection
	dispatch('/collection', array($cms, 'collection'));

	//Report
	dispatch('/report/loan', array($cms, 'reportLoan'));
	dispatch('/report/payment', array($cms, 'reportPayment'));
	dispatch('/report/collection-report', array($cms, 'reportCollectionReport'));
	dispatch('/report/collection-schedule-report', array($cms, 'reportCollectionScheduleReport'));
	dispatch('/report/collection-schedule-view-report/:id', array($cms, 'reportCollectionScheduleViewReport'));
	dispatch('/report/collection-schedule-view-report-id/:bid/:id', array($cms, 'reportCollectionScheduleViewReportID'));
	dispatch('/report/individualcollection', array($cms, 'individualcollection'));
	dispatch('/report/headcollection', array($cms, 'headcollection'));
	dispatch('/report/summarycollection', array($cms, 'summarycollection'));

	//Dashboard
	dispatch('/dashboard-bad-debt', array($cms, 'dashboardBadDebt'));
	dispatch('/dashboard-collection', array($cms, 'dashboardCollection'));
	dispatch('/dashboard-recovered', array($cms, 'dashboardRecovered'));
	dispatch('/dashboard-year-collection', array($cms, 'dashboardYearCollection'));
	dispatch('/dashboard-new-borrowers', array($cms, 'dashboardNewBorrowers'));
	dispatch('/dashboard-total-borrowers', array($cms, 'dashboardTotalBorrowers'));
	dispatch('/dashboard-active-borrowers', array($cms, 'dashboardActiveBorrowers'));
	dispatch('/dashboard-total-loan', array($cms, 'dashboardTotalLoan'));


	// LMS borrower

	dispatch_post('/borrowers/insert', array($post, 'borrowerInsert'));
	dispatch_post('/borrowers/:id', array($post, 'borrowerUpdate'));
	dispatch_post('/borrowers/:bid/delete', array($post, 'borrowerDelete'));
	dispatch_post('/borrowers/contact/:bid/insert', array($post, 'borrowerContactInsert'));
	dispatch_post('/borrowers/contact/:bid/update/:id', array($post, 'borrowerContactUpdate'));
	dispatch_post('/borrowers/contact/:bid/delete/:id', array($post, 'borrowerContactDelete'));
	dispatch_post('/borrowers/employment/:bid/insert', array($post, 'borrowerEmploymentInsert'));
	dispatch_post('/borrowers/employment/:bid/update/:id', array($post, 'borrowerEmploymentUpdate'));
	dispatch_post('/borrowers/employment/:bid/delete/:id', array($post, 'borrowerEmploymentDelete'));
	dispatch_post('/borrowers/spouse/:bid/insert', array($post, 'borrowerSpouseInsert'));
	dispatch_post('/borrowers/spouse/:bid/update/:id', array($post, 'borrowerSpouseUpdate'));
	dispatch_post('/borrowers/spouse/:bid/delete/:id', array($post, 'borrowerSpouseDelete'));
	dispatch_post('/borrowers/spouse_employment/:bid/insert', array($post, 'borrowerSpouseEmploymentInsert'));
	dispatch_post('/borrowers/spouse_employment/:bid/update/:id', array($post, 'borrowerSpouseEmploymentUpdate'));
	dispatch_post('/borrowers/spouse_employment/:bid/delete/:id', array($post, 'borrowerSpouseEmploymentDelete'));

	dispatch_post('/borrowers/guarantor/:bid/insert', array($post, 'borrowerGuarantorInsert'));
	dispatch_post('/borrowers/guarantor/:bid/update/:id', array($post, 'borrowerGuarantorUpdate'));
	dispatch_post('/borrowers/guarantor/:bid/delete/:id', array($post, 'borrowerGuarantorDelete'));

	dispatch_post('/borrowers/reference/:bid/insert', array($post, 'borrowerReferenceInsert'));
	dispatch_post('/borrowers/reference/:bid/update/:id', array($post, 'borrowerReferenceUpdate'));
	dispatch_post('/borrowers/reference/:bid/delete/:id', array($post, 'borrowerReferenceDelete'));
	dispatch_post('/borrowers/remark/:bid/insert', array($post, 'borrowerRemarkInsert'));
	// dispatch_post('/borrowers/remark/:bid/update/:id', array($cms, 'borrowerRemarkUpdate'));

	dispatch_post('/customers/insert', array($post, 'customerInsert'));
	dispatch_post('/customers/:id', array($post, 'customerUpdate'));
        //dispatch_post('/customers/testing', array($post, 'customerTesting'));

	dispatch_post('/applications/insert', array($post, 'applicationInsert'));

	dispatch_post('/applications/update/:id', array($post, 'applicationUpdate'));


	dispatch_post('/inquiry/insert', array($post, 'inquiryInsert'));
	dispatch_post('/inquiry/:id', array($post, 'inquiryUpdate'));


	dispatch_post('/loan/update/:id', array($post, 'loanUpdate'));
	dispatch_post('/loanApproval/update/:id', array($post, 'loanApprovalUpdate'));
	dispatch_post('/loan/insert', array($post, 'loanInsert'));
	dispatch_post('/loan/insert/:id', array($post, 'loanInsertID'));

	dispatch_post('/recovery/update/:id', array($post, 'recoveryUpdate'));

	dispatch_post('/risk/update/:id', array($post, 'riskUpdate'));

	dispatch_post('/articles/insert-new', array($post, 'articleInsert'));
	dispatch_post('/articles/:id', array($post, 'articleUpdate'));


}else{
	dispatch('**', array($cms, 'login'));
}


dispatch_post('/login', array($post, 'login'));
dispatch('/logout', array($cms, 'logout'));

dispatch('/products-rent/status/:id', array($cms, 'productRentStatusUpdate'));
dispatch_post('/products-rent/status/:id', array($post, 'productRentStatusUpdate'));

function not_found($errno, $errstr, $errfile=null, $errline=null){
    set('errno', $errno);
    set('errstr', $errstr);
    set('errfile', $errfile);
    set('errline', $errline);
    return render('layout/404.php');
}

function determineMonth($month){



	switch($month){
		case "1":
			echo 'January';
			break;
		case "2":
			echo 'Febuary';
			break;
		case "3":
			echo 'March';
			break;
		case "4":
			echo 'April';
			break;
		case "5":
			echo 'May';
			break;
		case "6":
			echo 'June';
			break;
		case "7":
			echo 'July';
			break;
		case "8":
			echo 'August';
			break;
		case "9":
			echo 'September';
			break;
		case "10":
			echo 'October';
			break;
		case "11":
			echo 'November';
			break;
		case "12":
			echo 'December';
			break;
	}
}

function default_status($status){
	switch($status){
		case "1":
			echo '<span class="text-success">Active</span>';
			break;
		case "2":
			echo '<span class="text-warning">Pending Processing Head</span>';
			break;
		case "3":
			echo '<span class="text-red-1">Rejected</span>';
			break;
		case "4":
			echo '<span class="text-warning">Pending Finance</span>';
			break;
		case "5":
			echo '<span class="text-warning">Pending Approval</span>';
			break;
		case "6":
			echo '<span class="text-warning">Pending Reschedule</span>';
			break;
		case "7":
			echo '<span class="text-red-1">Rejected Finance</span>';
			break;
		case "8":
			echo '<span class="text-success">Rescheduled</span>';
			break;
		case "99":
			echo '<span class="text-blue-3">Inactive</span>';
			break;
		case "990":
			echo '<span class="text-orange-5">Completed</span>';
			break;
		case "992":
			echo '<span class="text-blue-3">Old Rescheduled Loan</span>';
			break;
	}
}

function risk_status($status){
	switch($status){
		case "1":
			echo '<span class="text-success">Pending</span>';
			break;
		case "2":
			echo '<span class="text-warning">Confirmed</span>';
			break;
		case "3":
			echo '<span class="text-warning">Rejected</span>';
			break;
	}
}

function report_status($status){
	switch($status){
		case "1":
			echo '<span class="text-warning">Unpaid</span>';
			break;
		case "2":
			echo '<span class="text-success">Paid</span>';
			break;
		case "3":
			echo '<span class="text-warning">Unpaid</span>';
			break;
		case "4":
			echo '<span class="text-warning">Unpaid</span>';
			break;
	}
}

function report_status_interest($status){
	switch($status){
		case "1":
			echo '<span class="text-warning">Unpaid</span>';
			break;
		case "2":
			echo '<span class="text-success">Interest Paid</span>';
			break;
		case "3":
			echo '<span class="text-warning">Unpaid</span>';
			break;
		case "4":
			echo '<span class="text-warning">Unpaid</span>';
			break;
	}
}

function borrower_status($status){
	switch($status){
		case "1":
			echo '<span class="text-success">Approved</span>';
			break;
		case "2":
			echo '<span class="text-warning">Pending Processing Head</span>';
			break;
		case "3":
			echo '<span class="text-red-1">Rejected</span>';
			break;
		case "4":
			echo '<span class="text-warning">Pending Admin</span>';
			break;
		case "5":
			echo '<span class="text-blue-3">New from CTOS</span>';
			break;
	}
}

function borrower_restatus($status){
	switch($status){
		case "1":
			echo '<span class="text-success">Approved</span>';
			break;
		case "2":
			echo '<span class="text-warning">Pending Approval</span>';
			break;
		case "3":
			echo '<span class="text-warning">Rejected</span>';
			break;
	}
}

function loan_restatus($status){
	switch($status){
		case "1":
			echo '<span class="text-success">Active</span>';
			break;
		case "5":
			echo '<span class="text-warning">Pending Approval</span>';
			break;
		case "6":
			echo '<span class="text-warning">Pending Reschedule</span>';
			break;
		case "3":
			echo '<span class="text-warning">Rejected</span>';
			break;
		case "7":
			echo '<span class="text-warning">Rejected Finance</span>';
			break;
	}
}

function loanApproval_status($status){
	switch($status){
		case "1":
			echo '<span class="text-success">Approved</span>';
			break;
		case "2":
			echo '<span class="text-warning">Pending Processing Head</span>';
			break;
		case "3":
			echo '<span class="text-warning">Rejected</span>';
			break;
		case "4":
			echo '<span class="text-warning">Pending Finance</span>';
			break;
	}
}

function customer_type($type){
	switch($type){
		case "1":
			echo '<span class="text-success">Borrower</span>';
			break;
		case "2":
			echo '<span class="text-success">Lender</span>';
			break;
	}
}

function marital_status($type){
	switch($type){
		case "1":
			echo '<span class="text-success">Single</span>';
			break;
		case "2":
			echo '<span class="text-success">Married</span>';
			break;
		case "3":
			echo '<span class="text-success">Divorced</span>';
			break;
		case "4":
			echo '<span class="text-success">Widowed</span>';
			break;
	}
}

function gender_type($type){
	switch($type){
		case "1":
			echo '<span class="text-success">Male</span>';
			break;
		case "2":
			echo '<span class="text-success">Female</span>';
			break;
	}
}

function relation_type($type){
	switch($type){
		case "1":
			echo '<span class="text-success">BROTHER</span>';
			break;
		case "2":
			echo '<span class="text-success">BROTHER IN LAW</span>';
			break;
		case "3":
			echo '<span class="text-success">COUSIN</span>';
			break;
		case "4":
			echo '<span class="text-success">DAUGHTER</span>';
			break;
		case "5":
			echo '<span class="text-success">FATHER</span>';
			break;
		case "6":
			echo '<span class="text-success">FRIEND</span>';
			break;
		case "7":
			echo '<span class="text-success">HUSBAND</span>';
			break;
		case "8":
			echo '<span class="text-success">MOTHER</span>';
			break;
		case "9":
			echo '<span class="text-success">MOTHER IN LAW</span>';
			break;
		case "10":
			echo '<span class="text-success">RECOMMENDER</span>';
			break;
		case "11":
			echo '<span class="text-success">SISTER</span>';
			break;
		case "12":
			echo '<span class="text-success">SISTER IN LAW</span>';
			break;
		case "13":
			echo '<span class="text-success">SON</span>';
			break;
		case "14":
			echo '<span class="text-success">SON IN LAW</span>';
			break;
		case "15":
			echo '<span class="text-success">SPOUSE</span>';
			break;
		case "16":
			echo '<span class="text-success">UNCLE</span>';
			break;
		case "17":
			echo '<span class="text-success">WIFE</span>';
			break;
		case "18":
			echo '<span class="text-success">WIFE NO 2</span>';
			break;
	}
}


run();
?>
