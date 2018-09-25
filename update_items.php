<?php 
/*
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 
*/

include_once("Model/DBModel/DbModel.php");
include_once("Model/DBModel/Enum_Model.php");
$invSql="SELECT * FROM item_master_temp where hsn_code != '' and hsn_code != 'D'";
$result = DBConnection::SelectQuery($invSql);
while ($Row = mysql_fetch_array($result, MYSQL_ASSOC)){
	if($Row['hsn_code'] == 'D'){
		
	}else{
		$hsnCode = $Row['hsn_code'];
		$itemId = $Row['item_id'];
		$taxRate = !empty($Row['tax_rate']) ? $Row['tax_rate'] : 0;
		$sql = "SELECT tax_id from tax_master where tax_rate='$taxRate' limit 1";
		$tax_result = DBConnection::SelectQuery($sql);
		$TAX = mysql_fetch_array($tax_result, MYSQL_ASSOC);
		$Tax_ID = $TAX['tax_id'];
		$sql = "UPDATE item_master set Tarrif_Heading='$hsnCode' where ItemId='$itemId'";
		DBConnection::UpdateQuery($sql);
		$sql = "SELECT * from hsn_master where hsn_code='$hsnCode'";
		$hsn_result = DBConnection::SelectQuery($sql);
		$getRow = mysql_num_rows($hsn_result);
		if($getRow == 0) {
			$sql = "insert into hsn_master (hsn_code,tax_id) values('$hsnCode','$Tax_ID')";
			DBConnection::InsertQuery($sql);
		}
		echo $hsnCode."<br />";
		echo $itemId."<br />";
		echo $taxRate."<br />";
	}
}
?>
