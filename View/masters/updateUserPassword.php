<?php
include('root.php');
include($root_path."GlobalConfig.php");
//include("../home/head.php"); 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>Employee Password Update</title>
<link href="../css/my_temp.css" rel="stylesheet" type="text/css" />
<script type='text/javascript' src='../js/jquery.js'></script>
<script type='text/javascript' src='../js/jquery.min.js'></script>
<script type='text/javascript' src='../js/ang_js/angular.js'></script>
<script type="text/javascript">
		var SitePath = "<?php echo SitePath ?>";
		var AdminHomePath = "<?php echo AdminHomePath ?>";
		var SalesExecutiveHomePath = "<?php echo SalesExecutiveHomePath ?>";
		var ManagementHomePath = "<?php echo ManagementHomePath ?>";
</script>

<script type='text/javascript' src='../js/Masters_js/User.js'></script>

</head>
<body ng-app ="UpdateUserPassword_app">
<?php   
//include '../SalesExecutive/header.php';
include("../../header.php") 
 ?>

<form id="form1" ng-controller="UpdateUserPassword_Controller"  ng-submit="submitForm()" class="smart-green" data-ng-init="init('<?php echo  $_GET['ID'];?>')">
<div align="center"><h1>Employee  Update Password Form</h1></div>
<div style="margin-left:470px;">
	
      <div style="width:50%; float:left;">
        <label>
            <span>User</span>
            <select name="USERID" ID="USERID" ng-model="UpdatePassword.USERID" tabindex="1" required>
            <option value="" title="select">Select User</option>
            <?php 
                    $result =  UserModel::LoadALLUser();
                    while($row=mysql_fetch_array($result, MYSQL_ASSOC)){                                                 
                    echo "<option value='".$row['USERID']."' title='".$row['USER_NAME']."'>".$row['USER_NAME']."</option>";
                    }?>
            </select>
        </label>
      </div>
       <div class="clr"></div>
      <div style="width:50%; float:left;" id="pd">
        <label>
            <span>Password:</span>
            <input type="password" ID="newpass" placeholder="User Password" ng-model="UpdatePassword.newpass" tabindex="2" required></input>
        </label>
      </div>
       <div class="clr"></div>
      <div style="width:50%; float:left;" id="pd">
        <label>
            <span>Confirm Password:</span>
            <input type="password" ID="confirmpass" placeholder="User Confirm Password" ng-model="UpdatePassword.confirmpass" tabindex="3" required></input>
        </label>
      </div>      
      <div class="clr"></div>
     
      
</div></br>
<div align="center">
<label>
    <input type="submit" class="button" name="B1" value="Save" id="btnsave" ng-model="UpdatePassword.save" tabindex="9" ></input>
     
    <a style="text-decoration: none;" class="button" href="<?php print SITE_URL.VIEWUSERMASTER; ?>">Cancel</a>
   
</label>
</div></br>
</form>
 <?php include("../../footer.php") ?> 
 <script src="../js/boot_js/jquery-1.11.0.js"></script>
<script src="../js/boot_js/bootstrap.min.js"></script>
<script src="../js/boot_js/plugins/metisMenu/metisMenu.min.js"></script>
<script src="../js/boot_js/sb-admin-2.js"></script> 
</body>
</html>
