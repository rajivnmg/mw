<?php
header("Content-type: application/x-msexcel");
header("Content-Type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename=Non_Excise_StockStatement_WithValue.xls");
include '../../Model/DBModel/DbModel.php';
include '../../Model/ReportModel/StockStatementModel.php';
include '../../Model/Masters/GroupMaster_Model.php';
echo 'SNo' . "\t" . 'PartNo'."\t".'Product Description' . "\t" . 'TarifHeading'."\t".'Quantity' 
        . "\t" . 'Unit'."\t". 'Price' . "\t" . 'TotalPrice'."\t"."\n";
        
		$Type = $_REQUEST['st_type'];
		$curentFinYear = $_REQUEST['finyear'];
		$date = $_REQUEST['tilldate'];	
		$data =array();
		if($Type == 'E'){
			$data =  StockStatementModel::GetExciseStockWithValue();
		}else{
			$data =  StockStatementModel::GetNonExciseStockWithValue();
		}

$groupData = GroupMasterModel::GetGroupList();
$GrandTotal = 0.00;
while ($grouprow = mysql_fetch_array($groupData,MYSQL_ASSOC))
{
    $objQuery = StockStatementModel::GetNonExciseStock($grouprow["GroupId"]);
    if(mysql_num_rows($objQuery) > 0)
    {
		
        echo "Group : ". $grouprow["GroupDesc"]."\t"."\n";
        $GrossTotal = 0.00;
        while ($row = mysql_fetch_array($objQuery,MYSQL_ASSOC))
        {
		$code_partNo = $row["ItemId"];
		$qty = 0;
		$qty = StockStatementModel::checkInventoryByDateFromTransaction($Type,$code_partNo,$curentFinYear,$date);    
		$total = 0;
		$total =  ($row['Cost_Price'] * $qty);
				
            echo $row['SN'] . "\t" . $row['Item_Code_Partno'] ."\t".$row['Item_Desc'] . "\t" . $row['Tarrif_Heading'] 
                    ."\t".$qty . "\t" . $row['UNITNAME'] ."\t".$row['Cost_Price'] 
                    . "\t" . number_format((float)$total, 2, '.', '')."\t"."\n";
            $GrossTotal = $GrossTotal + $total;
        }
        echo "\t"."\t"."\t"."\t"."\t"."\t"."Gross Total : ". $GrossTotal."\t"."\n";
        $GrandTotal = $GrandTotal + $GrossTotal;
    }
}
echo "\t"."\t"."\t"."\t"."\t"."\t"."Grand Total : ". $GrandTotal."\t"."\n";
