<?php

//~ //error_reporting(E_ALL);
//~ ini_set('display_errors', 1); 
//~ ini_set('display_startup_errors', 1);
//~ error_reporting(E_ALL); 


// define path to save the generated invoice by crowntab
if (!isset($_SESSION) ) {session_start(); }
if(isset($_REQUEST['SITENAME']) && ($_REQUEST['SITENAME']=='GURGAON')){ 	// Check and set the  sitename in SESSION to work cronjob properly
	$_SESSION['SITENAME']='GURGAON';
	
}else if(isset($_REQUEST['SITENAME']) && ($_REQUEST['SITENAME']=='RUDRAPUR')){	// Check and set the  sitename in SESSION to work cronjob properly
	$_SESSION['SITENAME']='GURGAON';
	$_SESSION['SITENAME']='RUDRAPUR';
	
}else if(isset($_REQUEST['SITENAME']) && ($_REQUEST['SITENAME']=='MANESAR')){	// Check and set the  sitename in SESSION to work cronjob properly
	$_SESSION['SITENAME']='GURGAON';
	$_SESSION['SITENAME']='MANESAR';
	
}else if(isset($_REQUEST['SITENAME']) && ($_REQUEST['SITENAME']=='HARIDWAR')){	// Check and set the  sitename in SESSION to work cronjob properly
	$_SESSION['SITENAME']='GURGAON';
	$_SESSION['SITENAME']='HARIDWAR';
		
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
include_once( "Model/ReportModel/StockStatementModel.php"); 
                                                
require_once('PHPMailer_v5.1/class.phpmailer.php'); //library added in download source to send email.

	// function to start the process of sending email.
	function actionItemStockProcessEvents() {			
		$less="";
		$more="";
		$m = 0;
		$l = 0;
		$message2 = '';
		$message1 = '';
		$event=new Event();	
		
		 // PREPARE THE BODY OF THE MESSAGE


						 $result =  StockStatementModel::GetExciseStockLevelReportEMAIL();                                       
						 
							while($row=mysql_fetch_array($result, MYSQL_ASSOC)){ 
								
								if(($row["tot_Qty"] > $row["Usc"])){                                              
									$more.='<tr>';
									$more.='<td>'.$row["SN"].'</td>';
									$more.='<td>'.$row["Item_Code_Partno"].'</td>';
									$more.='<td>'.$row["Item_Desc"].'</td>';									
									$more.='<td>'.$row["Lsc"].'</td>';
									$more.='<td>'.$row["Usc"].'</td>';
									$more.='<td>'.$row["tot_Qty"].'</td>';                                                   
									$more.='<tr>';
									$m = $m+1;
									 
								}else if($row["tot_Qty"] < $row["Lsc"]){
									$less.='<tr>';
									$less.='<td>'.$row["SN"].'</td>';
									$less.='<td>'.$row["Item_Code_Partno"].'</td>';	
									$less.='<td>'.$row["Item_Desc"].'</td>';															                                              
									$less.='<td>'.$row["Lsc"].'</td>';
									$less.='<td>'.$row["Usc"].'</td>';
									$less.='<td>'.$row["tot_Qty"].'</td>';                                                   
									$less.='<tr>';
									$l = $l+1; 
								}
								
							}
		//if(mysql_num_rows($Result) > 0){
			$message = '<html><body><p>Dear All</p><p>Bellow Are the stock details : </p><br/>';
			//$message .= '<img src="http://css-tricks.com/examples/WebsiteChangeRequestForm/images/wcrf-header.png" alt="Website Change Request" />';
		if($l > 0){
			$message2.= '<h3>Stock Below the limit : </h3><table rules="all" style="border-color: #666;" cellpadding="10">';
			$message2.= "<tr style='background: #eee;'>
								<td>SN</td>
								<td>Item_Code_Partno</td>
								<td>Item Description</td>
								<td>Lsc</td>
								<td>Usc</td>
								<td>tot_Qty</td>
						 </tr>";
			
			//$message .= "<tr><td><strong>Email:</strong> </td><td>" . strip_tags($_POST['req-email']) . "</td></tr>";
			$message2.= $less;
			$message2.= "</table>";
		}
		if($m > 0){
			$message1.= '<br/><h3>Stock Above the limit : </h3><table rules="all" style="border-color: #666;" cellpadding="10">';
			$message1.= "<tr style='background: #eee;'>
								<td>SN</td>
								<td>Item_Code_Partno</td>
								<td>Item Description</td>
								<td>Lsc</td>
								<td>Usc</td>
								<td>tot_Qty</td>
						 </tr>";
			
			//$message .= "<tr><td><strong>Email:</strong> </td><td>" . strip_tags($_POST['req-email']) . "</td></tr>";
			$message1.= $more;
			$message1.= "</table>"; 
		}
			$message3.= "</body></html>";

			$body = $message.$message2.$message1.$message3;
		//~ }else{
			//~ $body  ='No Items are Below OR above the limit';
		//~ }
		//$body = $event->findMailbody(6, 'TESTTETTETETET');
		 
		//print_r($body); die;
		$subject = 'Item Stock Detail of '.$_SESSION['SITENAME'];
		//$to   = AdminEmail;			
		$to   = 'rajivkr00@gmail.com';			
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
		//$mail1->AddCC('BCC: rajivkrnmg@gmail.com');
		$mail1->AddCC('sujit@multiweld.net');
		$mail1->Subject = $subject;
		$mail1->Body = $body;
		$mail1->AddAddress($to);	
		return print_r($mail1->Send());
	}
//echo $dir; exit;
$response = actionItemStockProcessEvents();


