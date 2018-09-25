<?php

//error_reporting(E_ALL);
//~ ini_set('display_errors', 1); 
//~ ini_set('display_startup_errors', 1);
//~ error_reporting(E_ALL); 


$dir = 'pdf/invoices/';

// define path to save the generated invoice by crowntab
if (!isset($_SESSION) ) {session_start(); }
if(isset($_REQUEST['SITENAME']) && ($_REQUEST['SITENAME']=='GURGAON')){ 	// Check and set the  sitename in SESSION to work cronjob properly
	$_SESSION['SITENAME']='GURGAON';
	$dir = 'pdf/invoices/gurgaon/';	
}else if(isset($_REQUEST['SITENAME']) && ($_REQUEST['SITENAME']=='RUDRAPUR')){	// Check and set the  sitename in SESSION to work cronjob properly
	$_SESSION['SITENAME']='GURGAON';
	$_SESSION['SITENAME']='RUDRAPUR';
	$dir = 'pdf/invoices/rudrapur/';
}else if(isset($_REQUEST['SITENAME']) && ($_REQUEST['SITENAME']=='MANESAR')){	// Check and set the  sitename in SESSION to work cronjob properly
	$_SESSION['SITENAME']='GURGAON';
	$_SESSION['SITENAME']='MANESAR';
	$dir = 'pdf/invoices/manesar/';	
}else if(isset($_REQUEST['SITENAME']) && ($_REQUEST['SITENAME']=='HARIDWAR')){	// Check and set the  sitename in SESSION to work cronjob properly
	$_SESSION['SITENAME']='GURGAON';
	$_SESSION['SITENAME']='HARIDWAR';
	$dir = 'pdf/invoices/haridwar/';	
}else{
	session_destroy();
	exit;
}

include_once ("Config.php");
include_once ("Model/DBModel/Enum_Model.php");
include_once ("Model/DBModel/DbModel.php");
include_once("Model/Masters/Event.php");
include_once("pdf/outInvNonExcisePdf.php");
include_once("pdf/outInvExcisePdf.php");
require_once('PHPMailer_v5.1/class.phpmailer.php'); //library added in download source to send email.
include_once("log4php/Logger.php");
Logger::configure("config.email.xml");
$logger = Logger::getLogger('CRON EMAIL EVENT ');
	// function to start the process of sending email.
	function actionProcessEvents($dir) {	
       $event=new Event();
		$res =  $event->findAllEmail();	// function to get the record with prosess_id = 0;
		
		while($Rows = mysql_fetch_array($res, MYSQL_ASSOC)){	
			if($Rows['event_type'] == 1) {				
				_sendUserEmail($Rows,$dir);// function call to send emai to customer/user
            
			} elseif($Rows['event_type'] == EVENT_SMS_TYPE) {
				_sendUserSms($Rows);
            } elseif($Rows['event_type'] == EVENT_ADMIN_ONLY_MAIL_TYPE) {
                _sendAdminOnlyMail($Rows); // function call to send emai to admin
            }
	  }
	}
	
	// function defination to send emai to customer/user
	function _sendUserEmail($row,$dir) {
		$event=new Event();		
        $event->updateEvent($row['id'], -1);		
		$event_fields = json_decode($row['event_fields']);
		
		$eventName =$row['event_name'];
		
		$invId =$row['po_inv_id'];
		$logger->debug($invId);	// to create debug type log file
		if($eventName == EVENT_INVOICE_OE){
				outInvExPDF($invId);
		}else if($eventName == EVENT_INVOICE_ONE){
			outInvNonExPDF($invId);
		}
		if($eventName == EVENT_PO_ACKNOWLEDGE && $event_fields->po_hold_state=='H'){
			$body1 = $event->findMailbody(4, $event_fields);
			sendMailToAdmin (4, $event_fields, $body1,$invId);
		}
		$body = $event->findMailbody($eventName, $event_fields);

		/* $sent_mail = sendMail($eventName, $event_fields, $body,$invId,$dir);
		//echo '<pre>';print_r($sent_mail); echo '</pre>';
		var_dump($sent_mail);
		exit; */
		if(sendMail($eventName, $event_fields, $body,$invId,$dir)) {
            $event->updateEvent($row['id'], 1);
            
            //delete invoice after send email 5 July 2018
            $path = '';
            if($eventName == EVENT_INVOICE_OE || $eventName == EVENT_INVOICE_ONE){				
				$filename = $event_fields->oinvoice_No.".pdf"; // Get filename to be attached in email in case of incoice send
				$path = dirname(__FILE__).DIRECTORY_SEPARATOR.$dir.$filename; 
				
				if(file_exists($path)) { // check if file exist and delete
						unlink($path);
				}
				return 1;
			}			
			
        }else {
		  return 0;
		  // echo 'Email not send'; 
		}
	}
	
	function sendMail ($eventName, $eventFields, $body,$invId,$dir) {
         $email = null;
		$filename = null;
		if(isset($eventFields->bemailId)) { // check customer email exist or not in the data
            $email = $eventFields->bemailId;
        }			
        if(empty($email) || $email == null) {
            return false;
        } 	
		$subject = null;
        $subjectArr = unserialize(EMAIL_SUBJECTS);
        if(isset($subjectArr[$eventName])) {
           $subject = $subjectArr[$eventName];
        }
		if($eventName == EVENT_INVOICE_OE){
			$subject = $subject.'-'.$eventFields->oinvoice_No; // Create the subject of email
			$filename = $eventFields->oinvoice_No.".pdf"; // Get filename to be attached in email in case of incoice send
		}else if($eventName == EVENT_INVOICE_ONE){
			$subject = $subject.'-'.$eventFields->oinvoice_No;
			$filename = $eventFields->oinvoice_No.".pdf";
		}else if($eventName == EVENT_PO_ACKNOWLEDGE){
			$subject = $subject.' #MW-'.$invId;
			
		}
	
		$to   = 'rajiv@codefire.in';
		//$to   = $email;	
		//try {
		$mail = new PHPMailer();
		$mail->IsSMTP(); // enable SMTP
		$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
		$mail->SMTPAuth = true; // authentication enabled
		$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
		$mail->Host = "smtp.gmail.com";
		$mail->Port = 465; // or 587
		$mail->IsHTML(true);
		
		$mail->Username = GMAIL_USER;
		$mail->Password = GMAIL_PASS;
		
		$mail->From = From;
		$mail->FromName = FromName;

		//$mail->Sender=$from; // indicates ReturnPath header
		//$mail->AddReplyTo($from, $from_name); // indicates ReplyTo headers
		//$mail->AddCC('dilip@multiweld.in', 'CC: sujit@multiweld.in','BCC: rajiv@codefire.in');
		//$mail->AddCC('dilip@multiweld.net', 'sujit@multiweld.net');
		$mail->Subject = $subject;
		$mail->Body = $body;
		$mail->AddAddress($to);
		
		if($eventName == 2 || $eventName == 3 ){
			// change the invoice name M/E to M_E for manesar. rudrapur and haridwar instamce
			/* if(isset($_SESSION['SITENAME']) && $_SESSION['SITENAME']!='GURGAON'){
				$filename = str_replace('/', '_', $filename);
			} */	
			if(file_exists($dir.$filename )){						
				$mail->AddAttachment($dir.$filename.""); // $path: is your file path which you want to attach like 
			}else{
				return 0;
			}
		}
		return print_r($mail->Send());
	}
	
	
	// function to send email to admin on po create in hold state
	function sendMailToAdmin ($eventName, $eventFields, $body,$invId) {
       	$subject = null;
        $subjectArr1 = unserialize(EMAIL_SUBJECTS);
        if(isset($subjectArr1[$eventName])) {
           $subject = $subjectArr1[$eventName];
        }	
		$subject = $subject.' #MW-'.$invId;
		$to   = AdminEmail;			
		$mail1 = new PHPMailer();
		
		$mail1->IsSMTP(); // enable SMTP
		$mail1->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
		$mail1->SMTPAuth = true; // authentication enabled
		$mail1->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
		$mail1->Host = "smtp.gmail.com";
		$mail1->Port = 465; // or 587
		$mail1->Username = GMAIL_USER;
		$mail1->Password = GMAIL_PASS;
		
		
		$mail1->IsHTML(true);
		$mail1->From = From;
		$mail1->FromName = FromName;
		$mail1->AddCC('dilip@multiweld.in', 'CC: sujit@multiweld.in','BCC: rajiv@codefire.in');
		$mail1->Subject = $subject;
		$mail1->Body = $body;
		$mail1->AddAddress($to);
		return print_r($mail1->Send());
	}
	
//echo $dir; exit;
$response = actionProcessEvents($dir);


