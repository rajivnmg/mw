<?php
include_once ("Model/DBModel/Enum_Model.php");
include_once ("Model/DBModel/DbModel.php");

$OutgoingMapQuery = "select oed.oinvoice_exciseID, oed.iinv_no,oem.inner_outgoingInvoiceEx, oem.finyear
from outgoinginvoice_excise_detail as oed
inner join outgoinginvoice_excise as oe on oe.oinvoice_exciseID = oed.oinvoice_exciseID
inner join outgoinginvoice_excise_mapping as oem on oem.inner_outgoingInvoiceEx = oe.oinvoice_exciseID";

$QougoingResult = DBConnection::SelectQuery($OutgoingMapQuery);
while ($Rows = mysql_fetch_array($QougoingResult,MYSQL_ASSOC))
{
    $innerno_query = "select inner_EntryNo from incominginvoice_entryno_mapping where IncomingInvoiceID = ".$Rows['iinv_no']." AND finyear = '".$Rows['finyear']."'";
    $innernoResult = DBConnection::SelectQuery($innerno_query);
    $innerRows = mysql_fetch_array($innernoResult,MYSQL_ASSOC);
    $InsertDetailsQuery = "insert into invoice_map_with_outgoing_excise (outgoing_id, inv_no, new_inv_id) values (".$Rows['oinvoice_exciseID'].",".$Rows['iinv_no'].",".$innerRows['inner_EntryNo'].")";
    echo $InsertDetailsQuery;
    //DBConnection::InsertQuery($InsertDetailsQuery);
}

