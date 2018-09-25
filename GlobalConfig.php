<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
session_start();
$USERID=$_SESSION["USER"];
include($root_path."siteConfig.php"); 
include($root_path."urlConfig.php"); 
include($root_path."Model/DBModel/DbModel.php");
include($root_path."Model/Masters/User_Model.php");

$perm=array();
// Get all permission of the user to access URL (MENU).
$result_perm= UserModel::LoadUserDetails($USERID);
while ($Row_perm = mysql_fetch_array($result_perm, MYSQL_ASSOC)) {
 	//print_r($Row);
	$perm=json_decode($Row_perm['PERMISSION']); 	
}
function checkPermission($permval)
{  //Check User permission
  global $perm;
	if(in_array($permval,$perm)){
		return TRUE;
	}
	return FALSE;
}


if($_SESSION["USER"]!=null)
{ 
	$TYPE = $_SESSION["USER_TYPE"];
	if($actual_url == 'View/home/Dashboard.php' && $TYPE == 'E'){
		echo 'Permission Denied'; exit;
	}
	if($accessKey!='' || $accessKey != NULL){
		// check loggedIn user permission to access URL
		if(!checkPermission($accessKey)){
			echo 'Permission Denied-1'; exit;
		}
	}
}

function isLoginSessionExpired() {
	$login_session_duration = 3600; // session will expired if No activity
	$current_time = time(); 
	if(isset($_SESSION['loggedin_time']) && isset($_SESSION["USER"]) && $_SESSION["USER"] != null ){  
		  // session started more than 30 minutes ago
		if(((time() - $_SESSION['loggedin_time']) > $login_session_duration)){
			 //check user activity delay time for session out.
			return true; 
		} 
	}
	$_SESSION['loggedin_time'] = time(); //Reset loggedin_time at every activity
	return false;	
}
 
?>
