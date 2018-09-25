<?php
include_once ("Model/DBModel/Enum_Model.php");
include_once ("Model/DBModel/DbModel.php");

$inventory = "select code_partNo, tot_Qty from inventory";

$inventoryResult = DBConnection::SelectQuery($inventory);
$i = 0;
while ($Rows = mysql_fetch_array($inventoryResult,MYSQL_ASSOC))
{
	//print_r($Rows); exit;
	$code_partNo = $Rows['code_partNo'];
	$tot_Qty = $Rows['tot_Qty'];
	
	$invSql= "SELECT code_partNo FROM openinginventory where code_partNo = ".$code_partNo;
	 
	$invSqlResult = DBConnection::SelectQuery($invSql);
	$Row = mysql_fetch_array($invSqlResult,MYSQL_ASSOC);
	
	if(empty($Row['code_partNo']))
	{
		$InsertopeningStock = "INSERT INTO openinginventory (code_partNo,openingQty) VALUES('".$code_partNo."','".$tot_Qty."')";
	}
	else
	{
		$InsertopeningStock = "UPDATE openinginventory SET openingQty = '".$tot_Qty."' WHERE code_partNo = '".$code_partNo."'";
	}

	echo '<br/>'.$InsertopeningStock; //exit;

	DBConnection::InsertQuery($InsertopeningStock);
	$i =$i +1 ;
}


echo '<br/>'.$i;


