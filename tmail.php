<?php
require_once('PHPMailer_v5.1/class.phpmailer.php');
/*
$to = "rajiv@codefire.in";
$subject = "HTML email";

$message = "
<html>
<head>
<title>HTML email</title>
</head>
<body>
<p>This email contains HTML Tags!</p>
<table>
<tr>
<th>Firstname</th>
<th>Lastname</th>
</tr>
<tr>
<td>John</td>
<td>Doe</td>
</tr>
</table>
</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: abhayjeet@codefire.in' . "\r\n";
$headers .= 'FromName: ABHAY' . "\r\n";
$headers .= 'Cc: manu@codefire.in' . "\r\n";

mail($to,$subject,$message,$headers);  */
$message = "
<html>
<head>
<title>Gmail Server email</title>
</head>
<body>
<p>This email contains HTML Tags!</p>
<table>
<tr>
<th>Firstname</th>
<th>Lastname</th>
</tr>
<tr>
<td>Rajiv</td>
<td>Kumar - 465</td>
</tr>
</table>
</body>
</html>
";
	define("GMAIL_USER", "customer.service@multiweld.in");
	define("GMAIL_PASS", "9958871558");
    define("From", "customer.service@multiweld.in");
	define("FromName", "customer.service@multiweld.in");
	define("AdminEmail", "rajiv@codefire.in");	
		$subject = 'Testing mail for gmail server';
     	$to   ='rajiv@codefire.in';			
		$mail1 = new PHPMailer();
		$mail1->IsSMTP(); // enable SMTP
		$mail1->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
		$mail1->SMTPAuth = true; // authentication enabled
		//$mail1->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
		$mail1->SMTPSecure = 'tls';
		$mail1->Host = "smtp.gmail.com";
		$mail1->Port =25;// 465; // or 587
		$mail1->Username = GMAIL_USER;
		$mail1->Password = GMAIL_PASS;		
		$mail1->IsHTML(true);
		$mail1->From = From;
		$mail1->Timeout = 3600;
		$mail1->FromName = FromName;
		$mail1->AddCC('sujit@multiweld.in');
		$mail1->addBCC('rajiv@codefire.in');
		$mail1->Subject = $subject;
		$mail1->Body = $message;
		$mail1->AddAddress($to);
		$mail1->Send();
		print_r($mail1->Send());
