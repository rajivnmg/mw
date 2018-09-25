<?php
define ("SITE_URL", "http://localhost/mw/");
if(session_id() == '') {
    session_start();
}
$_SESSION['SITE_URLS'] = SITE_URL;
if(isset($_SESSION['SITENAME']) && $_SESSION['SITENAME']=='GURGAON'){
		
		define("GURGAON",1); // set 1 to access the particular site and invoice settion 
		define("HARIDWAR",0);
		define("RUDRAPUR",0);
		define("MANESAR",0);
		
		//Site Database config
		//define('DB_HOST', 'multiwelddb.clxgvhnxdo1g.us-west-2.rds.amazonaws.com');
		//~ define('DB_HOST', 'bluefin1.cawafssaai0v.us-east-1.rds.amazonaws.com');
		//~ define('DB_USER', 'mwdevuser');
		//~ define('DB_PORT', '');
		//~ define('DB_PASS', 'Rajiv#2018');
		//define('DB_DATA', 'dev_rudrapur');
		//define('DB_DATA', 'mwdb_rudra');
		define('DB_HOST', 'localhost');
		define('DB_USER', 'root');
		define('DB_PORT', '');
		define('DB_PASS', 'root');
		//define('DB_DATA', 'dev_rudrapur');
		define('DB_DATA', 'mwdb_ggn');
		define('CURRENT_BRANCH_STATE_ID', 1);

}else if(isset($_SESSION['SITENAME']) && $_SESSION['SITENAME']=='RUDRAPUR'){

		define("GURGAON",0); // set 1 to access the particular site and invoice settion 
		define("HARIDWAR",0);
		define("RUDRAPUR",1);
		define("MANESAR",0);
		
		//Site Database config
		//~ define('DB_HOST', 'multiwelddb.clxgvhnxdo1g.us-west-2.rds.amazonaws.com');
		//~ define('DB_USER', 'multidbuser');
		//~ define('DB_PORT', '');
		//~ define('DB_PASS', 'multi4359');
		// define('DB_HOST', 'bluefin1.cawafssaai0v.us-east-1.rds.amazonaws.com');
		// define('DB_USER', 'mwdevuser');
		// define('DB_PORT', '');
		// define('DB_PASS', 'Rajiv#2018');
		define('DB_HOST', 'localhost');
		define('DB_USER', 'root');
		define('DB_PORT', '');
		define('DB_PASS', 'root');
		//define('DB_DATA', 'dev_rudrapur');
		define('DB_DATA', 'mwdb_rudra');
		define('CURRENT_BRANCH_STATE_ID', 22);
	
		
}else if(isset($_SESSION['SITENAME']) && $_SESSION['SITENAME']=='MANESAR'){
		define("GURGAON",0); // set 1 to access the particular site and invoice settion 
		define("HARIDWAR",0);
		define("RUDRAPUR",0);
		define("MANESAR",1);
		
		//Site Database config
		define('DB_HOST', 'multiwelddb.clxgvhnxdo1g.us-west-2.rds.amazonaws.com');
		define('DB_USER', 'multidbuser');
		define('DB_PORT', '');
		define('DB_PASS', 'multi4359');
		//~ define('DB_DATA', 'dev_manesar');
		define('DB_DATA', 'code1_manesar_gst');
		define('CURRENT_BRANCH_STATE_ID', 1);
}else if(isset($_SESSION['SITENAME']) && $_SESSION['SITENAME']=='HARIDWAR'){
		define("GURGAON",0); // set 1 to access the particular site and invoice settion 
		define("HARIDWAR",1);
		define("RUDRAPUR",0);
		define("MANESAR",0);
		
		//Site Database config
		define('DB_HOST', 'multiwelddb.clxgvhnxdo1g.us-west-2.rds.amazonaws.com');
		define('DB_USER', 'multidbuser');
		define('DB_PORT', '');
		define('DB_PASS', 'multi4359');
		//~ define('DB_DATA', 'dev_haridwar');
		define('DB_DATA', 'code1_haridwar_gst');
		define('CURRENT_BRANCH_STATE_ID', 22);
}else{
		//echo '<script type="text/javascript">alert("Access Denied!");</script>'; 
		
		echo 'Access Denied!';
		echo '<p><a href="'.SITE_URL.'gurgaon">Click Here</a> To Login As Gurgaon</p>';
		echo '<p><a href="'.SITE_URL.'haridwar">Click Here</a> To Login As Haridwar</p>';
		echo '<p><a href="'.SITE_URL.'manesar">Click Here</a> To Login As Manesar</p>';
		echo '<p><a href="'.SITE_URL.'rudrapur">Click Here</a> To Login As Rudrapur</p>';
		exit;
}


//Site URL setting 
define("SitePath", SITE_URL."View/home/Dashboard.php");
define("AdminHomePath", SITE_URL."View/home/Dashboard.php");
define("SalesExecutiveHomePath", SITE_URL."View/SalesExecutive/Dashboard.php");
define("ManagementHomePath", SITE_URL."/View/Management/Dashboard.php");


// Set percentage for minimum profit margin in case of less will go for management approval
define("PROFIT_MARGIN", 5);
define("MAX_AMOUNT", 50000); //maximum payable amount without management approval 
define("GRACE_TIME", 10); //GRACE TIME AFTER CREDIT PERIOD TIME END


	//event_type for sending mail sms
    define("EVENT_MAIL_TYPE", 1);
    define("EVENT_SMS_TYPE", 2);
    define("EVENT_ADMIN_ONLY_MAIL_TYPE", 3);
    define("MAIL_TITLE", "Multiweld");
    define("GMAIL_USER", "customer.service@multiweld.in");
	define("GMAIL_PASS", "9958871558");
	define("From", "customer.service@multiweld.in");
	define("FromName", "customer.service@multiweld.in");
	define("AdminEmail", "rajivkr00@gmail.com");	
	define("AdminCC", "sujit@multiweld.in,rajivkr00@gmail.com");	
	define("REGARDS_NAME", "Team &#8377;x");
	//event_name for choosing template
    define("EVENT_PO_ACKNOWLEDGE", 1);
    define("EVENT_INVOICE_OE", 2);
	define("EVENT_INVOICE_ONE", 3);
    define("EVENT_ADMIN_MAIL", 4);
    define("EVENT_PAYMENT", 5);
    define("EVENT_QUOTATION", 6);
    define("EVENT_REGISTER_NEW_USER", 7);
	//event_name for choosing Mail Subject 
    $mailSubjects = array(
        1 => "Order Acknowledgement",
        2 => "Dispatch Information", //Outgoing Excise Invoice mail subject
		3 => "Dispatch Information", //Outgoing NonExcise Invoice mail subject
        4 => "PO For Approval ",
        5 => "Quotation",
        6 => "Payment ",
        7 => "New User Registered"
    );

    define("EMAIL_SUBJECTS", serialize($mailSubjects));


?>
