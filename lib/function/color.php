<?php
function color($code = ''){
	$keys['nat_wash_teak']['title'] = 'NAT WASH TEAK';
	$keys['nat_wash_teak']['code'] = '#ccc0da';
	
	$keys['dare_wallnut_cp']['title'] = 'DARK WALNUT CP';
	$keys['dare_wallnut_cp']['code'] = '#fde9d9';
	
	$keys['dark_mocha']['title'] = 'DARK MOCHA';
	$keys['dark_mocha']['code'] = '#9bbb59';
	
	$keys['dark_wallnut_2']['title'] = 'DARK WALNUT 2';
	$keys['dark_wallnut_2']['code'] = '#ffc000';
	
	$keys['natural']['title'] = 'NATURAL COLOR';
	$keys['natural']['code'] = '#00b0f0';

	$keys['white']['title'] = 'If spray GREYISH WHITE WASH COLOR';
	$keys['white']['code'] = '#fff';

	$keys['pu_high_gloss']['title'] = 'PU - HIGHGLOSS';
	$keys['pu_high_gloss']['code'] = '#fff';

	$keys['unfinished']['title'] = 'UNFINISHED';
	$keys['unfinished']['code'] = '#fff';
	
	$return = $keys;	
	
	if(!empty($code)){
		$return = $keys[$code];
	}
	
	return $return;
}
?>