<?php
	require("./sendgrid-php.php");
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	
	$mysql_hostname = "localhost";
    $mysql_user = "staging_esp";
    $mysql_password = "e_F5ju90";
    $mysql_database = "staging_esp";
    
    $con = mysqli_connect($mysql_hostname, $mysql_user, $mysql_password, $mysql_database);
    $date_today = '2016-03-26'; //date('Y-m-d');
    
    $two_month_sql = "Select * FROM esp_postcard Where is_subscribed = 1 AND two_month_date = '$date_today'";
    $one_year_sql = "Select * FROM esp_postcard Where is_subscribed = 1 AND one_year_date = '$date_today'";
    $two_year_sql = "Select * FROM esp_postcard Where is_subscribed = 1 AND two_year_date = '$date_today'";
    
    $query = mysqli_query($con, $two_month_sql);
	//$rowt = mysqli_fetch_assoc($query); 
	
	$sendgrid = get_sendgrid();
	$email = get_sendgrid_email();
	
	while($row = mysqli_fetch_assoc($query)) {
       send_email($row, $sendgrid, $email, '2 Months Ago', $row['postcardid_1']);
    }
    
    $query = mysqli_query($con, $one_year_sql);
    while($row = mysqli_fetch_assoc($query)) {
       send_email($row, $sendgrid, $email, '2 Years Ago', $row['postcardid_2']);
    }
    
    $query = mysqli_query($con, $two_year_sql);
    while($row = mysqli_fetch_assoc($query)) {
       send_email($row, $sendgrid, $email, '3 Years Ago', $row['postcardid_3']);
    }

	
	
	

	/*$sendgrid = new SendGrid('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');
	$email = new SendGrid\Email();
	$email
	    ->addTo('jeff@interactivemechanics.com')
	    ->setFrom('jeff@interactivemechanics.com')
	    ->setSubject("Here's what you thought just two months ago.")
	    ->setHtml("<html> <head> </head> <body style='margin: 0; padding: 0; background:white; font-family:sans-serif'> <div class='email-wrapper' style='max-width:600px; width:600px; margin:0 auto;'> <img src='http://i.imgur.com/0ZCJfEe.jpg' /> <p style='font-weight:bold; font-size:15px; text-transform:uppercase; text-align:center; color:#aaa;'><strong>2 months ago</strong></p> <div style='width:525px; margin-right: auto; margin-left:auto;'> <h1 style='font-weight: 500; line-height: 35px; font-family: American Typewriter; color:black; font-weight:bold; font-size:24px; text-align:center; font-weight: 500; line-height: 35px; margin-top:30px;'> This will be some title of the email, which will related to the content below and might be related to your time at ESP. </h1> <p style='line-height: 32px; font-weight: 200; font-size: 16px; margin: 30px 0;'> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. </p> <p style='line-height: 32px; font-weight: 200; font-size: 16px; margin: 30px 0;'> Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. </p> <p style='line-height: 32px; font-weight: 200; font-size: 16px; margin: 30px 0; 60px;'> Duis aute irure dolor in reprehenderit in voluptate <a href='javascript: void(0);' style='font-weight:bold; color:black;'>velit esse cillum dolore </a>eu fugiat nulla pariatur. </p> <div style='text-align:center;'> <img src='http://i.imgur.com/CDXM9aZ.jpg' /> </div> <p style='font-weight:200; font-size:10px; margin:35px 0 10px;; line-height:20px; text-transform:uppercase; text-align:center; color:#aaa;'>This email is automatically generated because you completed the <em>'Postcard to your futureself'</em> activity at Eastern State Penitentiary's Prisons Today exhibit on January 26th, 2016</p> <div style='text-align:center;'> <ul style='margin:15px 0 30px; padding:0px;'> <li style='font-weight:bold; font-size:13px; text-align:center; list-style:none; display:inline; margin-right:20px;'> <a style='color:#888;' href='javascript:void(0);'><em>Unsubscribe</em></a> </li> <li style='font-weight:bold; font-size:13px; text-align:center; color:#aaa; list-style:none; display:inline;'> <a style='color:#888;' href='http://www.easternstate.org'><em>Visit Website</em></a> </li> </ul> </div> </div> </div> </body> </html>");
	    
	$response = $sendgrid->send($email);*/

	    
	
		//var_dump($row);
	
	function get_sendgrid(){
		return $sendgrid = new SendGrid('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');
	}
	
	
	function get_sendgrid_email(){
		return $email = new SendGrid\Email();
	}
	
	function send_email($row, $sendgrid, $email, $email_date, $postcard_id) {
		
		$email_body = set_html($row, $postcard_id, $email_date);
		var_dump(2);
		$email
	    ->addTo('jeff@interactivemechanics.com')
	    ->setFrom('jeff@interactivemechanics.com')
	    ->setSubject("Here's what you thought just " . $email_date . ".")
	    ->setHtml($email_body);
	    var_dump(3);
	    $response = $sendgrid->send($email);
	    var_dump(4);
		return $response;
	}
	
	function set_html($row, $postcard_id, $email_date) {
		$email_str = "<html> <head> </head> <body style='margin: 0; padding: 0; background:white; font-family:sans-serif'> <div class='email-wrapper' style='max-width:600px; width:600px; margin:0 auto;'> <img src='{{POSTCARD_IMAGE}}' /> <p style='font-weight:bold; font-size:15px; text-transform:uppercase; text-align:center; color:#aaa;'><strong>{{DATE_HERE}}</strong></p> <div style='width:525px; margin-right: auto; margin-left:auto;'> <h1 style='font-weight: 500; line-height: 35px; font-family: American Typewriter; color:black; font-weight:bold; font-size:24px; text-align:center; font-weight: 500; line-height: 35px; margin-top:30px;'> {{HEADING_TITLE_HERE}} </h1> <p style='line-height: 32px; font-weight: 200; font-size: 16px; margin: 30px 0;'> {{TEXT_AREA_1_SECTION}} </p> <p style='line-height: 32px; font-weight: 200; font-size: 16px; margin: 30px 0;'> {{TEXT_AREA_2_SECTION}} </p> <p style='line-height: 32px; font-weight: 200; font-size: 16px; margin: 30px 0;'> {{TEXT_AREA_3_SECTION}} </p> <p style='line-height: 32px; font-weight: 200; font-size: 16px; margin: 30px 0; 60px;'> {{CHECK_BOX_DATA}} </p> <div style='text-align:center;'> <img src='http://i.imgur.com/CDXM9aZ.jpg' /> </div> <p style='font-weight:200; font-size:10px; margin:35px 0 10px;; line-height:20px; text-transform:uppercase; text-align:center; color:#aaa;'>This email is automatically generated because you completed the <em>'Postcard to your futureself'</em> activity at Eastern State Penitentiary's Prisons Today exhibit on {{DATE_VISITED}}</p> <div style='text-align:center;'> <ul style='margin:15px 0 30px; padding:0px;'> <li style='font-weight:bold; font-size:13px; text-align:center; list-style:none; display:inline; margin-right:20px;'> <a style='color:#888;' href='{{UNSUBSCRIBE_LINK}}'><em>Unsubscribe</em></a> </li> <li style='font-weight:bold; font-size:13px; text-align:center; color:#aaa; list-style:none; display:inline;'> <a style='color:#888;' href='http://www.easternstate.org'><em>Visit Website</em></a> </li> </ul> </div> </div> </div> </body> </html>";
		
		$email_str = str_replace('{{POSTCARD_IMAGE}}', get_postcard($postcard_id), $email_str);
		$email_str = str_replace('{{DATE_HERE}}', $email_date, $email_str);
		$email_str = str_replace('{{HEADING_TITLE_HERE}}', 'Title of the email that we will send will go here.', $email_str);
		$email_str = str_replace('{{TEXT_AREA_1_SECTION}}', $row['textarea_1'], $email_str);
		$email_str = str_replace('{{TEXT_AREA_2_SECTION}}', $row['textarea_2'], $email_str);
		$email_str = str_replace('{{TEXT_AREA_3_SECTION}}', $row['textarea_3'], $email_str);
		$email_str = str_replace('{{CHECK_BOX_DATA}}', $row['checkboxes_1'], $email_str);
		$email_str = str_replace('{{DATE_VISITED}}', date('F j, Y', strtotime($row['datetime'])), $email_str);
		$email_str = str_replace('{{UNSUBSCRIBE_LINK}}', unsubscribe_link($row['email']), $email_str);
		
		return $email_str;
		
	}
	
	function get_postcard($id) {
		return 'http://i.imgur.com/0ZCJfEe.jpg';
	}
	
	function unsubscribe_link($email) {
		return "http://staging.interactivemechanics.com/esp-letters/data/api/unsubscribe.php?email=" . urlencode($email);
	}
?>