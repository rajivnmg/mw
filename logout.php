<?php
session_set_cookie_params(0);
session_start();
	//session_unset();  // unset $_SESSION variable for the run-time 
	unset($_SESSION["USER"]);
	unset($_SESSION["SITENAME"]);
	session_destroy();
	$url = "index.php";
if(isset($_GET["se"])) {
	$url .= "?se=" . $_GET["se"];
}
header("Location:$url");
?>
