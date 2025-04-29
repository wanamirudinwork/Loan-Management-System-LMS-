<?php
function OpenCon()
 {
 $dbhost = "localhost";
 $dbuser = "homecrowd_admin";
 $dbpass = "Password123";
 $db = "homecrowd";
 $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect faileds: %s\n". $conn -> error);
 
 return $conn;
 }
 
function CloseCon($conn)
 {
 $conn -> close();
 }

 function encryptPassword($password) {
	$hash = '$2a$07$'.'np65plSrOACM8PPpL57zcO';
	if(!empty($password)){
		return crypt($password, $hash);
	} else {
		return false;
	}
}

function isLoginSessionExpired() {
	$login_session_duration = 21600; 
	$current_time = time(); 
	if(isset($_SESSION['loggedin_time']) and isset($_SESSION["login_user"])){  
		if(((time() - $_SESSION['loggedin_time']) > $login_session_duration)){ 
			return true; 
		} 
	}
	return false;
}

   
?>
