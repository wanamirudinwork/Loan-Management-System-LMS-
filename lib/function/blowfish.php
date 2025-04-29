<?php
function encryptPassword($password) {
	$hash = '$2a$07$'.'np65plSrOACM8PPpL57zcO';
	if(!empty($password)){
		return crypt($password, $hash);
	} else {
		return false;
	}
}

function tokenEncode($str, $key = 'wtfbbq'){
	$encrypted = encrypt($str, $key);
	return bin2hex($encrypted);
}

function tokenDecode($str, $key = 'wtfbbq'){
	$encrypted = hex2bin($str);
	$decrypted = decrypt($encrypted, $key);
	return $decrypted;
}

function encrypt($pure_string, $encryption_key = 'wtfbbq') {
    $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, $encryption_key, utf8_encode($pure_string), MCRYPT_MODE_ECB, $iv);
    return $encrypted_string;
}

function decrypt($encrypted_string, $encryption_key = 'wtfbbq') {
    $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $decrypted_string = mcrypt_decrypt(MCRYPT_BLOWFISH, $encryption_key, $encrypted_string, MCRYPT_MODE_ECB, $iv);
    return $decrypted_string;
}
?>