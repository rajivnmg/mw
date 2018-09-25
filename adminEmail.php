<?php
/*
//error_reporting(E_ALL);
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); */

require_once('PHPMailer_v5.1/class.phpmailer.php'); //library added in download source.
function sendMailToAdminForApproval ($event_fields,$reason) {
		$event=new Event();		
		$body = $event->findAdminMailbody(5,$event_fields,$reason); // get the email body on the basis of E-mail type
		$subject = 'PO For Approval';
     	//$to   = AdminEmail;	// Receiver email id
		$to   = 'sujit@multiweld.in';
		$mail1 = new PHPMailer();
		$mail1->IsSMTP(); // enable SMTP
		$mail1->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
		$mail1->SMTPAuth = true; // authentication enabled
		$mail1->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
		$mail1->Host = "smtp.gmail.com";
		$mail1->Port = 465; // or 587
		$mail1->Username = GMAIL_USER; // Gmail E-mailid
		$mail1->Password = GMAIL_PASS; // Gmail password
		
		$mail1->IsHTML(true);
		$mail1->From = From; // Sender email id 
		$mail1->FromName = FromName;  // Sender name
		$mail1->AddCC('rajiv@codefire.in');  // email carbo copy will be send on this email
		$mail1->addBCC('rajiv@codefire.in');
		$mail1->Subject = $subject;
		$mail1->Body = $body;
		$mail1->AddAddress($to);
		//return $mail1;
		//$mail1->Send();
		if(!$mail1->send()) 
		{
			return "Mailer Error: " . $mail1->ErrorInfo;
		} 
		else 
		{
			return "Message has been sent successfully";
		}
	}


