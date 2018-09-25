<?php
session_start();
if(!file_exists("Config.php")) {
    echo "Config file does not Exist!"; exit;
}else{
	/*
	if(isset($_SESSION['SITENAME']) && $_SESSION['SITENAME']=='GURGAON'){
		require_once($root_path."Config.gurgaon.php");
	}else if(isset($_SESSION['SITENAME']) && $_SESSION['SITENAME']=='RUDRAPUR'){
		require_once($root_path."Config.rudrapur.php");
	}else if(isset($_SESSION['SITENAME']) && $_SESSION['SITENAME']=='MANESAR'){
		require_once($root_path."Config.manesar.php");
	}else if(isset($_SESSION['SITENAME']) && $_SESSION['SITENAME']=='HARIDWAR'){
		require_once($root_path."Config.haridwar.php");
	}else{
		echo '<script type="text/javascript">alert("Access Denied!");</script>'; 
		echo 'Access Denied!';
		exit;
	}	
  */
	require_once('Config.php');		
	
	// check is user alreay logged In in any sites that will redirect to the Dsahboard not in hHomePage
	if(isset($_SESSION['SITENAME']) && ($_SESSION['SITENAME']=='GURGAON' || $_SESSION['SITENAME']=='RUDRAPUR' || $_SESSION['SITENAME']=='MANESAR' || $_SESSION['SITENAME']=='HARIDWAR')){
				
		if(isset($_SESSION["USER"]) && $_SESSION["USER"]!=null && ($_SESSION["USER_TYPE"] =='A' || $_SESSION["USER_TYPE"] =='M')){
			header('Location:'.AdminHomePath); exit;
		}else if(isset($_SESSION["USER"]) && $_SESSION["USER"]!=null && ($_SESSION["USER_TYPE"] =='B' || $_SESSION["USER_TYPE"] =='E')){
			header('Location:'.SalesExecutiveHomePath); exit;
		}else if(isset($_SESSION["USER"]) && $_SESSION["USER"]!=null && ($_SESSION["USER_TYPE"] =='S')){
			header('Location:'.AdminHomePath); exit;
		}		
				
	}
	
	
	
	
}

require_once('root.php');
require_once($root_path."GlobalConfig.php");

$_SESSION["USER"]=null;
$message ="";
if(isset($_GET["se"])) {
	$message = "Login Session is Expired. Please Login Again";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="cache-control" content="max-age=0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
<meta http-equiv="pragma" content="no-cache" />

<title>Login</title>
<link href="View/css/boot_css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
<link href="View/css/boot_css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

<!-- Custom CSS -->
<link href="View/css/boot_css/sb-admin-2.css" rel="stylesheet">

<!-- Custom Fonts -->
<link href="View/css/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="View/css/style.css" rel="stylesheet" type="text/css" />
<script type='text/javascript' src='View/js/jquery.min.js'></script>
<script type='text/javascript' src='View/js/ang_js/angular.js'></script>
<script type="text/javascript">
$(function() {
    // setTimeout() function will be fired after page is loaded
    // it will wait for 5 sec. and then will fire
    // $("#successMessage").hide() function
    setTimeout(function() {
        $("#messageSession").hide(20000)});
});
var SitePath = "<?php echo SitePath ?>";
var AdminHomePath = "<?php echo AdminHomePath ?>";
var SalesExecutiveHomePath = "<?php echo SalesExecutiveHomePath ?>";
var ManagementHomePath = "<?php echo ManagementHomePath ?>";
</script>

<script type='text/javascript' src='View/js/Masters_js/User.js'></script>
</head>
<body ng-app ="Login_app">
<!--logo container start-->
<!--mid start-->
<form name="f1" ng-controller="Login_Controller" ng-submit="login();" class="smart-green"  style="width:500px; margin-top:120px;">
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4" style="margin-left: 500px; margin-top: -40px;">
            <div class="login-panel panel panel-default">
				<?php if($message!="") { ?>
<div id="messageSession" style="color:red;" align="center"><?php echo $message; ?></div>
<?php } ?>
                <div class="panel-heading">
                    <h3 class="panel-title">Please Sign In</h3>
                </div>
                <div class="panel-body">
                    <form role="form">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="User name" ng-model="Login.USERID" required name="email" type="text" autofocus>
                            </div>
                            <div class="form-group">
                                <input id="txtpassword" class="form-control" placeholder="Password" name="password" type="password" ng-model="Login.PASSWD" required>
                            </div>
                            <input type="submit" value="Login" class="btn btn-lg btn-primary btn-block"/>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<script src="View/js/boot_js/jquery-1.11.0.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="View/js/boot_js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="View/js/boot_js/plugins/metisMenu/metisMenu.min.js"></script>

<!-- Custom Theme JavaScript -->
<script src="View/js/boot_js/sb-admin-2.js"></script>
</div>
  
</body>
</html>
