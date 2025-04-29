<?php

 
    function OpenCon(){
 $dbhost = "localhost";
 $dbuser = "homecrowd_admin";
 $dbpass = "Password123";
 $db = "homecrowd";
 $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect faileds: %s\n". $conn -> error);
 
 return $conn;
 }

    // specify your own database credentials
   
?>
