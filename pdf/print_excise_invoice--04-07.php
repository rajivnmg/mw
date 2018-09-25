<?php

if (!function_exists("mb_check_encoding")) {
    die('mbstring extension is not enabled');
}
include_once("mpdf60/mpdf.php");
include_once "config.php";
include_once "generate.php";
include_once "function.php";
include_once "root.php";
$dir  = scandir("images");
include_once( $root_path."Model/DBModel/DbModel.php");
include_once( $root_path."Model/Business_Action_Model/Outgoing_Invoice_NonExcise_Model.php");
include_once( $root_path."Model/Business_Action_Model/Outgoing_Invoice_Excise_Model.php");
include_once( $root_path."Model/Business_Action_Model/Incoming_Invoice_Excise_Model.php");
include_once( $root_path."Model/Business_Action_Model/po_model.php");
include_once( $root_path."Model/Masters/BuyerMaster_Model.php");
include_once( $root_path."Model/Masters/Principal_Supplier_Master_Model.php");
include($root_path."Model/Param/param_model.php");
include($root_path."Model/Masters/StateMaster_Model.php");
outInvExPDF($_REQUEST['invoiceId'],$_REQUEST['printtype']);
function outInvExPDF($oinvoice_exciseID,$printType){
	$CompanyInfo = ParamModel::GetCompanyInfo();
	//print_r($CompanyInfo);exit;
	$param = new ParamModel();
	$custhelp = new CustomHelper();
	$challanItem = array();
	$txtType='';

	if($printType==1){
		$txtType='ORIGINAL FOR BUYER';
	}else if($printType==2){
		$txtType='DUPLICATE FOR TRANSPORTER';
	}else if($printType==3){
		$txtType='COPY';
	}else if($printType==4){
		$txtType='QUADUPLICATE FOR ASSESSE';
	}else if($printType==5){
		$txtType='TRIPLICATE FOR CENTRAL EXCISE';
	}else{

	}
		
	//$oinvoice_exciseID =14891,14896,13691;13404,13405,13406// $_REQUEST['OutgoingInvoiceExciseNum'];
	$Print = Outgoing_Invoice_Excise_Model::LoadOutgoingInvoiceExcise($oinvoice_exciseID);
	//$CompanyInfo = ParamModel::GetCompanyInfo();
	$mpdf=new mPDF('c','USLETTER','','',5,5,1,4,1,2); 
	$mpdf->mirrorMargins = 1;	// Use different Odd/Even headers and footers and mirror margins
	$html = '';
	foreach($Print as $outgoing_invoice_excise_h){
		$pod = Purchaseorder_Model::LoadPurchaseByID($outgoing_invoice_excise_h->pono,'N');
		$buyer = BuyerMaster_Model::LoadBuyerDetails($outgoing_invoice_excise_h->BuyerID,"A",null,null);
		$Query = "SELECT gst_no FROM buyer_gst_details WHERE buyer_id = ".$buyer[0]->_buyer_id." AND gst_state_id = ".$buyer[0]->_state_id."";
		$Result = DBConnection::SelectQuery($Query);
		$Row = mysql_fetch_array($Result, MYSQL_ASSOC);
		$billedGstNo = empty($Row['gst_no'])?'':$Row['gst_no'];
		$_reverse_charge_payable = ($outgoing_invoice_excise_h->reverse_charge_payable==1)?'Yes':'No';
		switch ($outgoing_invoice_excise_h->mode_delivery) {
			case 'H':
				$mode_delivery = "By Hand";
				break;
			case 'T':
				$mode_delivery = "By Transport";
				break;
			case 'C':
				$mode_delivery = "By Courier";
				break;
			case 'M':
				$mode_delivery = "By Tempo";
				break;
			default:
				$mode_delivery = "";
		}
		//echo "<pre>"; print_r($pod); exit;
		foreach($pod as $pod_value) {
			$shippedState = StateMasterModel::LoadAll($pod_value->sstate1);
			$Query = "SELECT gst_no FROM buyer_gst_details WHERE buyer_id = ".$buyer[0]->_buyer_id." AND gst_state_id = ".$shippedState[0]->_stateId."";
			$Result = DBConnection::SelectQuery($Query);
			$Row = mysql_fetch_array($Result, MYSQL_ASSOC);
			$shippedGstNo = empty($Row['gst_no'])?'':$Row['gst_no'];
		//print_r($shippedState);exit;
			$html .= '<div style="width:100%; border: 1px solid #aaa; width: 1000px; margin:auto;">
				<div style=" border-bottom: 1px solid #aaa;">
					<div style=" border: 1px solid #aaa; width:10%; padding:5px;	display:inline; margin: 15px 0 0 15px; float:left;">
						<img src="images/logo2.jpg" />
					</div>
					<div style="display:inline; float:left; width:82%; margin-bottom: 10px; text-align: center;">
						<center>
						<h1>'.$CompanyInfo['Name'].'</h1>
						<span>'.$CompanyInfo['Address'].'</span><br/>
						<span>'.$CompanyInfo['Phone'].'</span><br/>
						<span>'.$CompanyInfo['email'].'</span><br/>
						<span>'.$CompanyInfo['Website'].'</span><br/>
						</center>
					</div>
					<div style="clear:both;"></div>
				</div>
				<div  style="">
					<div style=" border-right: 1px solid #aaa; width:47%; padding: 10px; float:left;">
						<span> GSTIN Number: '.$CompanyInfo['gstin_number'].'</span><br/>
						<span> Tax is payable on Reverse Charge (Yes/No): '.$_reverse_charge_payable.'</span><br/>
						<span> Invoice Number: '.$outgoing_invoice_excise_h->oinvoice_No.'</span><br/>
						<span> Invoice Date: '.$outgoing_invoice_excise_h->oinv_date.'</span><br/>
						<span> Order Number: '.$pod_value->pon.'</span><br/>
						<span> Order Date: '.$pod_value->pod.'</span><br/>
						<span> Dispatch Time: '.$outgoing_invoice_excise_h->dispatch_time.'</span><br/>
					</div>
					<div style=" width:47%; padding: 10px; float:left;">
						<span> Transportation Mode: '.$outgoing_invoice_excise_h->mode_delivery.'</span><br/>
						<span> Veh. No.: '.$outgoing_invoice_excise_h->_vehcle_no.'</span><br/>
						<span> Date & Time of Supply: '.$outgoing_invoice_excise_h->_dnt_supply.'</span><br/>
						<span> Place of Supply: '.$outgoing_invoice_excise_h->_supply_place.'</span><br/>
					</div>
					<div style="clear:both;"></div>
				</div>
				<div  style=" border-top: 1px solid #aaa;">
					<div style=" border-right: 1px solid #aaa; width:49%; float:left;">
						<div style=" border-bottom: 1px solid #aaa; text-align:center;">Details of Receiver (Billed to)</div>
						<div style="padding: 10px;">
							<span> Name: '.$outgoing_invoice_excise_h->Buyer_Name.'</span><br/>
							<span> Address: '.$buyer[0]->_bill_add1.','.$buyer[0]->_bill_add2.'</span><br/>
							<span> State: '.$buyer[0]->_state_name.'</span><br/>
							<span> State Code: '.$buyer[0]->_state_id.'</span><br/>
							<span> GSTIN NUMBER: '.$billedGstNo.'</span><br/>
						</div>
					</div>
					<div style="width:50%; float:left;">
						<div style="width:102%; border-bottom: 1px solid #aaa; text-align:center;">Details of Consignee (Shipped to)</div>
						<div style="padding: 10px;">
							<span> Name: '.$outgoing_invoice_excise_h->Buyer_Name.'</span><br/>
							<span> Address: '.$pod_value->sadd1.','.$pod_value->sadd2.'</span><br/>
							<span> State: '.$shippedState[0]->_stateName.'</span><br/>
							<span> State Code: '.$shippedState[0]->_stateId.'</span><br/>
							<span> GSTIN NUMBER: '.$shippedGstNo.'</span><br/>
						</div>
					</div>
					<div style="clear:both;"></div>
				</div>
				<div  style="">
					<table style="table-layout:fixed; width:100%; border-collapse: collapse;">
						<tr>
							<td rowspan="2" style=" width:3%;">S. No </th>
							<td rowspan="2" style=" width:10%;">Code / Part No.</th>
							<td rowspan="2" style=" width:25%;"> Description</th>
							<td rowspan="2" style=" width:10%;">HSN Code</th>
							<td rowspan="2" style=" width:5%;"> Qty</th>
							<td rowspan="2" style=" width:5%;"> Rate</th>
							<td rowspan="2" style=" width:5%;">Total</th>
							<td rowspan="2" style=" width:8%;">Discount</th>
							<td rowspan="2" style=" width:5%;">Taxable Value</th>
							<td colspan="2" style=" width:8%;">CGST</th>
							<td colspan="2" style=" width:8%;">SGST</th>
							<td colspan="2" style=" width:8%;">IGST</th>
						</tr>
						<tr>
							<td style=" border: 1px solid #aaa;">Rate</th>
							<td style=" border: 1px solid #aaa;">Amt</th>
							<td style=" border: 1px solid #aaa;">Rate</th>
							<td style=" border: 1px solid #aaa;">Amt</th>
							<td style=" border: 1px solid #aaa;">Rate</th>
							<td style=" border: 1px solid #aaa;">Amt</th>
						</tr>';
						$i1=1;
						$item_taxable_total = $cgst_amt_total = $sgst_amt_total = $igst_amt_total = 0;
						foreach($outgoing_invoice_excise_h->_itmes as $row_value) {
							$incInvDet = Incoming_Invoice_Excise_Model_Details::getIncomingInvoiceDetailsById($row_value->entryDId);
							$item_taxable_total = $item_taxable_total + $row_value->item_taxable_total;
							$cgst_amt_total = $cgst_amt_total + $row_value->cgst_amt;
							$sgst_amt_total = $sgst_amt_total + $row_value->sgst_amt;
							$igst_amt_total = $igst_amt_total + $row_value->igst_amt;
							//print_r($row_value);exit;
						$html .= '<tr>
							<td style=" border: 1px solid #aaa; height:100px;">'.$i1.'</td>
							<td style=" border: 1px solid #aaa; height:100px;">'.$row_value->oinv_codePartNo.'</td>
							<td style=" border: 1px solid #aaa; height:100px;">'.$row_value->codePartNo_desc.'</td>
							<td style=" border: 1px solid #aaa; height:100px;">'.$row_value->hsn_code.'</td>
							<td style=" border: 1px solid #aaa; height:100px;">'.$row_value->issued_qty.' '.$incInvDet[0]->_itemID_unitname.'</td>
							<td style=" border: 1px solid #aaa; height:100px;">'.$row_value->oinv_price.'</td>
							<td style=" border: 1px solid #aaa; height:100px;">'.$row_value->tot_price.'</td>
							<td style=" border: 1px solid #aaa; height:100px;">'.$row_value->item_discount.'</td>
							<td style=" border: 1px solid #aaa; height:100px;">'.$row_value->item_taxable_total.'</td>
							<td style=" border: 1px solid #aaa; height:100px;">'.$row_value->cgst_rate.'</td>
							<td style=" border: 1px solid #aaa; height:100px;">'.$row_value->cgst_amt.'</td>
							<td style=" border: 1px solid #aaa; height:100px;">'.$row_value->sgst_rate.'</td>
							<td style=" border: 1px solid #aaa; height:100px;">'.$row_value->sgst_amt.'</td>
							<td style=" border: 1px solid #aaa; height:100px;">'.$row_value->igst_rate.'</td>
							<td style=" border: 1px solid #aaa; height:100px;">'.$row_value->igst_amt.'</td>
							
						</tr>';
						$i1++;
					}
					$Total = $item_taxable_total + $cgst_amt_total + $sgst_amt_total + $igst_amt_total;
					$InvoiceTotal = $Total + $outgoing_invoice_excise_h->freight_amount + $outgoing_invoice_excise_h->pf_chrg + $outgoing_invoice_excise_h->incidental_chrg + $outgoing_invoice_excise_h->ins_charge + $outgoing_invoice_excise_h->othc_charge;
						$html .= '<tr>
							<td style=" border: 1px solid #aaa;text-align:right;" colspan="3">Total</td>
							<td style=" border: 1px solid #aaa;"></td>
							<td style=" border: 1px solid #aaa;"></td>
							<td style=" border: 1px solid #aaa;"></td>
							<td style=" border: 1px solid #aaa;"></td>
							<td style=" border: 1px solid #aaa;"></td>
							<td style=" border: 1px solid #aaa;">'.$item_taxable_total.'</td>
							<td style=" border: 1px solid #aaa;"></td>
							<td style=" border: 1px solid #aaa;">'.$cgst_amt_total.'</td>
							<td style=" border: 1px solid #aaa;"></td>
							<td style=" border: 1px solid #aaa;">'.$sgst_amt_total.'</td>
							<td style=" border: 1px solid #aaa;"></td>
							<td style=" border: 1px solid #aaa;">'.$igst_amt_total.'</td>
						</tr>
						<tr>
							<td style=" border: 1px solid #aaa; text-align:center;" colspan="9">Invoice Value (In Words)</td>
							<td style=" border: 1px solid #aaa; text-align:right;" colspan="5">Total</td>
							<td style=" border: 1px solid #aaa;">'.$Total.'</td>
						</tr>
						<tr>
							<td style=" border: 1px solid #aaa; text-align:center;" colspan="9" rowspan="5"></td>
							<td style=" border: 1px solid #aaa; text-align:right;" colspan="5">Freight Charges</td>
							<td style=" border: 1px solid #aaa;">'.$outgoing_invoice_excise_h->freight_amount.'</td>
						</tr>
						<tr>
							<td style=" border: 1px solid #aaa; text-align:right;" colspan="5">Packing & Forwarding Charges</td>
							<td style=" border: 1px solid #aaa;">'.$outgoing_invoice_excise_h->pf_chrg.'</td>
						</tr>
						<tr>
							<td style=" border: 1px solid #aaa; text-align:right;" colspan="5">Incidental Charges</td>
							<td style=" border: 1px solid #aaa;">'.$outgoing_invoice_excise_h->incidental_chrg.'</td>
						</tr>
						<tr>
							<td style=" border: 1px solid #aaa; text-align:right;" colspan="5">Insurance Charges</td>
							<td style=" border: 1px solid #aaa;">'.$outgoing_invoice_excise_h->ins_charge.'</td>
						</tr>
						<tr>
							<td style=" border: 1px solid #aaa; text-align:right;" colspan="5">Other Charges</td>
							<td style=" border: 1px solid #aaa;">'.$outgoing_invoice_excise_h->othc_charge.'</td>
						</tr>
						<tr>
							<td style=" border: 1px solid #aaa; text-align:right;" colspan="14">Invoice Total</td>
							<td style=" border: 1px solid #aaa;">'.$InvoiceTotal.'</td>
						</tr>
						<tr>
							<td style=" border: 1px solid #aaa; text-align:right;" colspan="9">Amount of Tax Subject to Reverse Charge</td>
							<td style=" border: 1px solid #aaa;"></td>
							<td style=" border: 1px solid #aaa;">'.$cgst_amt_total.'</td>
							<td style=" border: 1px solid #aaa;"></td>
							<td style=" border: 1px solid #aaa;">'.$sgst_amt_total.'</td>
							<td style=" border: 1px solid #aaa;"></td>
							<td style=" border: 1px solid #aaa;">'.$igst_amt_total.'</td>
						</tr>
					</table>
				</div>
				<div  style="">
					<div style=" border-right: 1px solid #aaa; width:47%; padding:10px; height:20px; display:inline; float:left;">
						<span> Certified that the Particulars given in this invoice are true and correct </span><br/>
					</div>
					<div style=" width:47%; padding:10px; height:20px; display:inline; float:left;">
						<span> Electronic Reference Number: </span><br/>
					</div>
					<div style="clear:both;"></div>
				</div>
				<div  style=" border-top: 1px solid #aaa;">
					<div style=" border-right: 1px solid #aaa; width:49%; height:220px; display:inline; float:left;">
						<div style="border-bottom: 1px solid #aaa; text-align:center;">Terms & Conditions of Sale </div>
						<div style="padding:10px;">
							<span> 1. All disputes are Subject to Gurgaon Jurisdiction.  </span><br/>
							<span> 2. Our responsibility ceases on delivery of goods.  </span><br/>
							<span> 3. All Taxes extra , as applicable at the time of supply.  </span><br/>
							<span> 4. Interest @24% per annum will be charged after due date.  </span><br/>
						</div>
					</div>
					<div style="width:50%; height:220px; display:inline; float:left;">
						<div style="border-bottom: 1px solid #aaa; text-align:center;">MULTIWELD ENGINEERING PVT. LTD.</div>
						<div style="padding:10px;"><span> Signature: </span></div>
						<div style="border-top: 1px solid #aaa; border-bottom: 1px solid #aaa; width:102%;"><center> Authorised Signatory</center> </div>
						<div style="padding:10px;">
							<span> Name: </span><br/>
							<span> Designation: </span>
						</div>
					</div>
					<div style="clear:both;"></div>
				</div>
			</div>';
		}
	}
	$stylesheet = file_get_contents("style.css");
	$mpdf -> WriteHTML($stylesheet,1);
	$mpdf->WriteHTML($html);
	$mpdf->Output();
	exit;
}
?>
