<?php

include_once ("Model/DBModel/Enum_Model.php");

include_once ("Model/DBModel/DbModel.php");



$inventory = "select * from inventory";



$inventoryResult = DBConnection::SelectQuery($inventory);

$i = 0;

while ($Rows = mysql_fetch_array($inventoryResult,MYSQL_ASSOC))

{

	

	//print_r($Rows); exit;

	 $code_partNo=$Rows['code_partNo'];

     $tot_exciseQty=$Rows['tot_exciseQty'];

     $tot_nonExciseQty=$Rows['tot_nonExciseQty'];

	 $invSql="SELECT * FROM openinginventory where code_partNo=".$code_partNo;

	 

	 $invSqlResult = DBConnection::SelectQuery($invSql);

	 $Row = mysql_fetch_array($invSqlResult,MYSQL_ASSOC);

	if(empty($Row['code_partNo'])){

		

		 $InsertopeningStock = "INSERT INTO openinginventory (code_partNo,openingExciseQty, openingNonExciseQty) VALUES('".$Rows['code_partNo']."','".$Rows['tot_exciseQty']."','".$Rows['tot_nonExciseQty']."')";

	}else{

		 $InsertopeningStock = "UPDATE openinginventory SET openingExciseQty = '".$Rows['tot_exciseQty']."',openingNonExciseQty = '".$Rows['tot_nonExciseQty']."' WHERE code_partNo = '".$Rows['code_partNo']."'";

	} 

	

	

	// echo $InsertopeningStock; exit;

	

     DBConnection::InsertQuery($InsertopeningStock);

$i =$i +1 ;

}





echo $i;






