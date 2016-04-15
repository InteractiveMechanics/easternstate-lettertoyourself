<?php
	function make_safe($data) 
	{
		
	   $data = filter_var($data, FILTER_SANITIZE_STRING);
	   return $data; 
	}
	
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	
	$email = make_safe(urldecode($_GET['email']));
	
	$mysql_hostname = "localhost";
    $mysql_user = "staging_esp";
    $mysql_password = "e_F5ju90";
    $mysql_database = "staging_esp";
    
    $con = mysqli_connect($mysql_hostname, $mysql_user, $mysql_password, $mysql_database);
    
    $sql = "UPDATE esp_postcard SET is_subscribed=0 WHERE email='$email'";
    $query = mysqli_query($con, $sql);
    
    if(mysqli_query($con, $sql)){
	    echo "You have been removed from the email list";
	} else {
		
	}
	
?>