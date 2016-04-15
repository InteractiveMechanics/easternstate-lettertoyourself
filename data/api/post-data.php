<?php
	
	function make_safe($data) 
	{
		
	   $data = filter_var($data, FILTER_SANITIZE_STRING);
	   return $data; 
	}
	
	
	
	
	$mysql_hostname = "localhost";
    $mysql_user = "staging_esp";
    $mysql_password = "e_F5ju90";
    $mysql_database = "staging_esp";

    $con = mysqli_connect($mysql_hostname, $mysql_user, $mysql_password, $mysql_database);
    
    $postcardid_1 = make_safe($_POST['postcardid_1']);
	$postcardid_2 = make_safe($_POST['postcardid_2']);
	$postcardid_3 = make_safe($_POST['postcardid_3']);
	
	$textarea_1 = make_safe($_POST['textarea_1']);
	$textarea_2 = make_safe($_POST['textarea_2']);
	$textarea_3 = make_safe($_POST['textarea_3']);
	
	$checkbox_1 = make_safe($_POST['checkbox_1']);
	$checkbox_2 = make_safe($_POST['checkbox_2']);
	
	
	$firstname = make_safe($_POST['firstname']);
	$email = make_safe($_POST['email']);
    
    $sql = "INSERT INTO `esp_postcard` (`id`, `datetime`, `postcardid_1`, `postcardid_2`, `postcardid_3`, `textarea_1`, `textarea_2`, `textarea_3`, `checkboxes_1`, `checkboxes_2`, `firstname`, `email`, `is_subscribed`, `two_month_date`, `one_year_date`, `two_year_date`) 
    VALUES ('', NOW(), $postcardid_1, $postcardid_2, $postcardid_3, '$textarea_1', '$textarea_2', '$textarea_1', '$checkbox_1', '$checkbox_2', '$firstname', '$email', '1', NOW() + INTERVAL 60 DAY, NOW() + INTERVAL 365 DAY, NOW() + INTERVAL 1095 DAY)";
    
    $query = mysqli_query($con, $sql);
	$row = mysqli_fetch_row($query); 
	
?>