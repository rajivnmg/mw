<?php
header("Content-type: application/x-msexcel");
header("Content-Type: application/vnd.ms-excel");

include '../../Model/DBModel/DbModel.php';
include '../../Model/ReportModel/StockStatementModel.php';
include '../../Model/Masters/GroupMaster_Model.php';
header("Content-disposition: attachment; filename=StockLevelReport.xls");
echo 'SNo' . "\t" . 'PartNo'."\t".'Product Description' . "\t" . 'HSN Code'."\t". 'LSC'."\t". 'USC'."\t".'Quantity' 
        . "\t" . 'Unit'."\t"."\n";
$groupData = GroupMasterModel::GetGroupList();
while ($grouprow = mysql_fetch_array($groupData,MYSQL_ASSOC))
{
    $objQuery = StockStatementModel::GetExciseStockLevelReport($grouprow["GroupId"]);
    if(mysql_num_rows($objQuery) > 0)
    {
        echo "Group : ". $grouprow["GroupDesc"]."\t"."\n";
        while ($row = mysql_fetch_array($objQuery,MYSQL_ASSOC))
        {
            echo $row['SN'] . "\t" . $row['Item_Code_Partno'] ."\t".$row['Item_Desc'] . "\t" . $row['Tarrif_Heading'] 
                    ."\t". $row['Lsc']."\t". $row['Usc']."\t".$row['tot_Qty'] . "\t" . $row['UNITNAME'] ."\t"."\n";
        }
    }
}
