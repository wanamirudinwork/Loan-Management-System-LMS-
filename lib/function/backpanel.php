<?php
function navActive($currPath, $curr){
	if(is_array($curr)){
		if(in_array($currPath, $curr)){
			echo ' active';
		}
	}else{
		if($currPath == $curr){
			echo ' active';
		}
	}
}

function lstatus($status){
	switch($status){
		case 0:
		  	return '<span style="color:#FF0000">Disabled</span>';
		 	break;
		case 1:
		  	return '<span style="color:#25AB16">Enabled</span>';
		 	break;
	}
}

function applicationStatus($status, $type = '1'){
	
	switch($status){
	case 1:
	  	return '<span style="color:#006400">Active</span>';
	 	break;
	case 2:
	  	return $type == '1' ? '<span style="color:#FFA500">Resubmit Required</span>' : '<span style="color:#FFA500">Pending Veification</span>';
	 	break;	
	case 3:
	  	return '<span style="color:#006400">Verified</span>';
	  	break;
	case 4:
	  	return '<span style="color:#FFA500">Awaiting Documents</span>';
	  	break;
	case 5:
	  	return '<span style="color:#006400">Ongoing Campaign</span>';
	  	break;
	case 6:
	  	return '<span style="color:#006400">Fully Funded</span>';
	  	break;
	case 8:
	  	return '<span style="color:#006400">Loan Created</span>';
	  	break;
	case 9:
	  	return '<span style="color:#006400">Mortgage Activated</span>';
	  	break;
	case 20:
	  	return '<span style="color:#006400">DSR completed</span>';
	  	break;
	case 21:
	  	return '<span style="color:#006400">DSR submitted</span>';
	  	break;
	case 22:
	  	return '<span style="color:#006400">Application info Pending</span>';
	  	break;
	case 23:
	  	return '<span style="color:#006400">application submitted</span>';
	  	break;
	
	}	
}

function approverApplicationStatus($status){
	switch($status){
	
		case 0:
		  	return '<span style="color:#FFA500">Pending</span>';
		 	break;
		case 1:
		  	return '<span style="color:#006400">Approved</span>';
		 	break;	
		case 2:
		  	return '<span style="color:#FF0000">Reject</span>';
		  	break;
	
	}
}

function pstatus($status){
	switch($status){
		case 0:
		  	return '<span style="color:#FFA500">Inactive</span>';
		 	break;
		case 1:
		  	return '<span style="color:#25AB16">Active</span>';
		 	break;
		case 8:
		  	return '<span style="color:#FF0000">Out Of Stock</span>';
		 	break;
		case 9:
		  	return '<span style="color:#FF0000">Rejected</span>';
		 	break;
	}
}

function dateTimeFormat($date){
	$date = strtotime($date);
	$date = date("Y/m/d g:i:s A", $date);
	return $date;
}
?>
