<?php
function tracking($id){
	switch($id){
		case 0:
			return 'Order in progress';
			break;
		case 1:
			return 'Delivery in progress';
			break;
		case 2:
			return 'Delivered';
			break;
		case 3:
			return 'Collected';
			break;
		case 8:
			return 'Refunded';
			break;
	}
}

function subscriptionStatus($id = ''){
	$status[1] = '<span class="label label-success">Active</span>';
	$status[2] = '<span class="label label-default">Expired</span>';
	$status[9] = '<span class="label label-danger">Cancelled</span>';
	
	if(!empty($status[$id]) || $id == '0'){
		$return = $status[$id];
	}else if($id == 'all'){
		$return = $status;	
	}else{
		$return = $id;	
	}
	
	return $return;
}

function dateTime($date){
	$date = strtotime($date);
	$date = date("d/m/Y g:i:s A", $date);
	return $date;
}

function requestStatus($status){
	switch($status){
		case 1:
		  	return '<span class="statusOpen">Open</span>';
		 	break;
		case 9:
		  	return '<span class="statusClosed">Closed</span>';
		 	break;
	}
}

function requestStatusBackpanel($status){
	switch($status){
		case 1:
		  	return '<span class="label label-success">Open</span>';
		 	break;
		case 9:
		  	return '<span class="label label-default">Closed</span>';
		 	break;
	}
}
?>