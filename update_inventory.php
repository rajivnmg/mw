<?php 

/*

ini_set('display_errors', 1); 

ini_set('display_startup_errors', 1);

error_reporting(E_ALL); 

*/



include_once("Model/DBModel/DbModel.php");

include_once("Model/DBModel/Enum_Model.php");

include_once("Model/Business_Action_Model/Stocktransfer_Model.php");

include_once("Model/Business_Action_Model/Transaction_Model.php");

include_once("Model/Masters/Principal_Supplier_Master_Model.php");

include_once("Model/Business_Action_Model/Incoming_Inventory_Model.php");

include_once("Model/Business_Action_Model/Incoming_Invoice_Excise_Model.php");

include_once("Model/Business_Action_Model/Inventory_Model.php");

//include_once("Model/Param/param_model.php");

//#SCRIPT TO GET TOTAL QUENTITY OF A CODEPART IN EXCISE

  $i = 0;

  $curentFinYear = '2016-2017';//ParamModel::getFinYear();

  $invSql="SELECT * FROM inventory";

  $result = DBConnection::SelectQuery($invSql);

   echo "<table>";

   echo "<tr><td style='border:1px solid black;'>codepart</td><td style='border:1px solid black;'>Excise</td><td style='border:1px solid black;'>NON Excise</td></tr>";

	while ($Row = mysql_fetch_array($result, MYSQL_ASSOC)) {       

         $code_partNo=$Row['code_partNo'];

         $tot_exciseQty=$Row['tot_exciseQty'];

         $tot_nonExciseQty=$Row['tot_nonExciseQty'];

		 

		  //Inventory_Model::UpdateInventory("E",$obj->_items[$i]->itemid,$obj->_items[$i]->_issued_qty,"S");

		  $eBalance_qty = Inventory_Model::checkAndUpdateInventory("E",$code_partNo,$curentFinYear);

					  

		  //Inventory_Model::UpdateInventory("N",$obj->_items[$i]->itemid,$obj->_items[$i]->_issued_qty,"A");

		  $nBalance_qty = Inventory_Model::checkAndUpdateInventory("N",$code_partNo,$curentFinYear);

		  $i =$i +1 ;

		  $style = 'border:1px solid black;';

		  if($eBalance_qty<0){

			  $style = 'border:1px solid red;';

		  }

		  echo "<tr><td style='border:1px solid black;'>".$code_partNo.'</td><td style="'.$style.'">'.$eBalance_qty."</td>";

		  $style = 'border:1px solid black;';

		  if($nBalance_qty<0){

			  $style = 'border:1px solid red;';

		  }

		  echo '<td style="'.$style.'">'.$nBalance_qty."</td></tr>";

   }

   echo "</table>";

   echo $i;

?>


