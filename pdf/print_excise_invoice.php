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
include_once( $root_path."Model/Masters/UnitMaster_Model.php");
include_once( $root_path."Model/Masters/Principal_Supplier_Master_Model.php");
include($root_path."Model/Param/param_model.php");
include($root_path."Model/Masters/StateMaster_Model.php");
include($root_path."Model/Masters/CityMaster_Model.php");
outInvExPDF($_REQUEST['invoiceId'],$_REQUEST['printtype']);

function outInvExPDF($oinvoice_exciseID,$printType){
	$CompanyInfo = ParamModel::GetCompanyInfo();
	//print_r($CompanyInfo);exit;
	$param = new ParamModel();
	$custhelp = new CustomHelper();
	$challanItem = array();
	$txtType='';

	if($printType==1){
		//$txtType='ORIGINAL FOR BUYER';
		//$txtType='Original For Buyer';
		$txtType='Original for Recipient';
	}else if($printType==2){
		$txtType='Duplicate For Transporter';
	}else if($printType==3){
		$txtType='Copy';
	}else if($printType==4){
		$txtType='Quaduplicate For Assesse';
	}else if($printType==5){
		$txtType='Triplicate For Central Excise';
	}else{

	}
	$Print = Outgoing_Invoice_Excise_Model::LoadOutgoingInvoiceExcise($oinvoice_exciseID);
	$mpdf=new mPDF('c','USLETTER','','',5,5,1,4,1,2); 
	$mpdf->mirrorMargins = 1;	// Use different Odd/Even headers and footers and mirror margins
	$html = '';

	foreach($Print as $outgoing_invoice_excise_h){
		//print_r($outgoing_invoice_excise_h);exit;
		$pod = Purchaseorder_Model::LoadPurchaseByID($outgoing_invoice_excise_h->pono,'N');
		//echo '<br/>'.$outgoing_invoice_excise_h->BuyerID; 
		$buyer = BuyerMaster_Model::LoadBuyerDetails($outgoing_invoice_excise_h->BuyerID,"A",null,null);
		//print_r($buyer);exit;
		$principal = Principal_Supplier_Master_Model::Load_Principal_Supplier($outgoing_invoice_excise_h->principalID,"A",null,null);
		//print_r($principal);exit;
		//if($buyer[0]->_state_id == )
		//print_r($buyer);exit;
		$Query = "SELECT gst_no FROM buyer_gst_details WHERE buyer_id = ".$buyer[0]->_buyer_id." AND gst_state_id = ".$buyer[0]->_state_id."";
		//echo '<br/>'. $Query.'<br/>'; exit(0);
		$Result = DBConnection::SelectQuery($Query);
		$Row = mysql_fetch_array($Result, MYSQL_ASSOC);
		//print_r($Query);exit;
		$billedGstNo = empty($Row['gst_no'])?'':$Row['gst_no'];
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
	//print_r($buyer[0]->_state_id);exit;
		foreach($pod as $pod_value) {
		//print_r($pod_value);exit;
		$shippedState = StateMasterModel::LoadAll($pod_value->sstate1);
		$billedState = StateMasterModel::LoadAll($buyer[0]->_state_id);
		//print_r($billedState);exit;
		$shippedCity = CityMasterModel::LoadCity($pod_value->scity1,'CITY');
			
		//~ $GstType = 'INTER';
		//~ 
		//~ if($buyer[0]->_state_id == $principal[0]->_state_id) {
			//~ $GstType = "INTRA";
		//~ }
		
		
		//$TotalFGST =  $outgoing_invoice_excise_h->freight_amount;
		//print_r($shippedState[0]->_stateId);exit;
		$Query = "SELECT gst_no FROM buyer_gst_details WHERE buyer_id = ".$buyer[0]->_buyer_id." AND gst_state_id = ".$shippedState[0]->_stateId."";
			$Result = DBConnection::SelectQuery($Query);
			$Row = mysql_fetch_array($Result, MYSQL_ASSOC);
			$shippedGstNo = empty($Row['gst_no'])?'':$Row['gst_no'];
		$html .= '<body>
		<div style="width:100%; width: 1200px; margin:auto;">
		<div style="text-align:center; padding-bottom:1px;">
		 <table style="table-layout:fixed; width:100%; border-collapse: collapse; border:none;">
					<tr>
						<td align="right" style="border:none; width:63%"><strong>TAX INVOICE FOR SUPPLY OF GOODS</strong></td>				
						<td align="right" style="border:none;"><strong>'.$txtType.' Valid for Input Tax Credit</strong></td>
					  </tr>
					  </table>		
		</div>
		<div style="clear:both;"></div>
		<div style="border: 1px solid #aaa;">    
			<div  style=" border-bottom: 1px solid #aaa;">	
			<div  style=" border-bottom: 1px solid #aaa;">
				<div style=" border: 1px solid #aaa; width:10%; padding:5px;	display:inline; margin: 15px 0 0 15px; float:left; text-align:center;">
					<img src="images/logo2.jpg" style="width:75px !important;"/>
				</div>
				<div style="display:inline; float:left; text-align:center; width:80%; margin-bottom: 10px;">
					<center>
					<h1 class="heading">'.$CompanyInfo['Name'].'</h1>
					<span>'.$CompanyInfo['Address'].'</span><br/>
					<span>'.$CompanyInfo['Phone'].'</span><br/>
					<span>'.$CompanyInfo['email'].'</span>, &nbsp;
					<span>'.$CompanyInfo['Website'].'</span><br/>
					</center>
				</div>
				<div style="clear:both;"></div>
			</div>
						<div style="clear:both;"></div>
			</div>
			
		   <table style="table-layout:fixed; width:100%; border-collapse: collapse;">
	  <tr>
		<td align="left" style="width:33%;">
		<div style="float:left"><strong>GSTIN Number:</strong> '.$CompanyInfo['gstin_number'].'</div> 
		<div style="float:right"><strong>CIN :</strong>U93030DL2008PTC176427</div>    
		</td>
		   <td align="center" style="width:33%;">
		<div><strong>PAN:</strong> '.$CompanyInfo['PAN'].'</div> 
		</td>
			  <td style="width:33%;">
		<div><strong> INVOICE No. </strong>'.$outgoing_invoice_excise_h->oinvoice_No.' &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  <strong> Date: </strong>'.$outgoing_invoice_excise_h->oinv_date.'</div> 
		</td>
	  </tr>
	  <tr>
		<td style="width:33%; padding-top:5px;" valign="top">
		<div style="padding: 10px; text-align:left;">
						<span style="text-decoration:underline;"> Details of Receiver (Billed To)</span><br>
						<br/>
						 <strong>'.$outgoing_invoice_excise_h->Buyer_Name.'</strong><br>
						 <br/>
						 <span>'.$buyer[0]->_bill_add1.','.$buyer[0]->_bill_add2.'<br>
	City : '.$buyer[0]->_city_name.' <br>
	State & State Code : '.$billedState[0]->_stateName.' - '.sprintf("%02d", $billedState[0]->tin_no).'  <br> Contact Name : '.$outgoing_invoice_excise_h->bname.' <br> Email : '.$outgoing_invoice_excise_h->bemailId.'</span> 
						 <br>
						  <div style=" padding-top:20px;"><strong>GSTIN Number:</strong> '.$billedGstNo.'</div> 
		</div>
		</td>
		<td style="width:33%; padding-top:5px;" valign="top">
		<div style="padding: 10px; text-align:left;">
				<span style="text-decoration:underline;">Details of Consignee (Shipped To)</span><br><br>
						 <strong>'.$outgoing_invoice_excise_h->Buyer_Name.'</strong><br>
						 <br/>
						 <span>'.$pod_value->sadd1.','.$pod_value->sadd2.' <br>
	City : '.$shippedCity[0]->_city_nameame.' <br>
	State & State Code : '.$shippedState[0]->_stateName.' - '.sprintf("%02d", $billedState[0]->tin_no).'<br> Contact Name : '.$outgoing_invoice_excise_h->bname.' <br> Email : '.$outgoing_invoice_excise_h->bemailId.'</span> 
						 <br>
						  <div style=" padding-top:20px;"><strong>GSTIN Number:</strong> '.$shippedGstNo.'</div> 
		</div>
		</td>
		<td style="padding:0; width:34%;" valign="top">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:none;" class="invoiceTbl">
	  <tr>
		<td><strong>Transportation Mode </strong></td>
		 <td>: '.$mode_delivery.'</td>
	  </tr>
		<tr>
		<td><strong>Date & Time of Supply </strong></td>
		 <td>: '.$outgoing_invoice_excise_h->_dnt_supply.'</td>
	  </tr>
	  <tr>
		<td><strong>Place of Supply</strong></td>
		<td>:  '.$outgoing_invoice_excise_h->_supply_place.'</td>
	  </tr>
	  <tr>
		<td><strong>LD/Docket No<br>
		</strong></td>
		<td>: '.$outgoing_invoice_excise_h->_docket_no.'</td>
	  </tr>
	  <tr>
		<td><strong>Vender Code</strong></td>
		<td>:  '.$buyer[0]->_vendor_code.'</td>
	  </tr>
	  
	  <tr>
		<td><strong>PO No.</strong></td>
		<td>: '.$pod_value->pon.'<br></td>
	  </tr>
	  <tr>
		<td><strong>PO Date</strong></td>
		<td>: '.$pod_value->pod.'<br></td>
	  </tr>

	 
	</table>
	   
		</td>
	  </tr>
	</table>

			<div class="invoiceMainTbl">
			  <table style="table-layout:fixed; width:100%; border-collapse: collapse;">
					<tr>
						<td rowspan="2" style=" width:6%;"><strong>S. No </strong></td>		
						<td rowspan="2" style=" width:10%;"><strong>Code / Part No.</strong></th>		
						<td rowspan="2" style=" width:26%;"><strong> Description Of Goods
					  </strong></td>
						<td rowspan="2" style=" width:10%;"><strong>HSN Code</strong></td>                    
						<td rowspan="2" style=" width:6%;"><strong>Unit</strong></td>
						<td rowspan="2" style=" width:10%;"><strong> Qty</strong></td>
						<td rowspan="2" style=" width:13%;"><strong> Rate</strong></td>
						<td rowspan="2" style=" width:14%;"><strong>Total<br>Value </strong></td>
						<td rowspan="2" style=" width:8%;"><strong>Disc%</strong></td>
						<td rowspan="2" style=" width:12%;"><strong>Taxable Value</strong></td>
						<td colspan="2" style=" width:5%;"><strong>CGST</strong></td>
						<td colspan="2" style=" width:5%;"><strong>SGST</strong></td>
						<td colspan="2" style=" width:5%;"><strong>IGST</strong></td>
							<td rowspan="2" style=" width:12%;"><strong> Total Amount</strong></td>
					</tr>
					<tr>
						<td style=" border: 1px solid #aaa;" width="9%"><strong>Rate%</strong></td>
						<td style=" border: 1px solid #aaa;" width="10%"><strong>Amt</strong></td>
						<td style=" border: 1px solid #aaa;" width="9%"><strong>Rate%</strong></td>
						<td style=" border: 1px solid #aaa;" width="10%"><strong>Amt</strong></td>
						<td style=" border: 1px solid #aaa;" width="9%"><strong>Rate%</strong></td>
						<td style=" border: 1px solid #aaa;" width="10%"><strong>Amt</strong></td>
						</tr>';
					$i1=1;
					$item_taxable_total = $cgst_amt_total = $sgst_amt_total = $igst_amt_total = $qty = $tot_price = $final_tot_price = 0;
					foreach($outgoing_invoice_excise_h->_itmes as $row_value) {
						$incInvDet = UnitMasterModel::GetUnitDetatils($row_value->UnitId);
						$unitDetail = mysql_fetch_array($incInvDet, MYSQL_ASSOC);
						$unit = $unitDetail['UNITNAME'];
							//~ $incInvDet = Incoming_Invoice_Excise_Model_Details::getIncomingInvoiceDetailsById($row_value->entryDId);
							//print_r($row_value); exit;
							$item_taxable_total = $item_taxable_total + $row_value->item_taxable_total;
							$cgst_amt_total = $cgst_amt_total + $row_value->cgst_amt;
							$sgst_amt_total = $sgst_amt_total + $row_value->sgst_amt;
							$igst_amt_total = $igst_amt_total + $row_value->igst_amt;
							$qty = $qty + $row_value->issued_qty;
							$tot_price = $tot_price + $row_value->tot_price;
							$totalValue = $row_value->issued_qty * $row_value->oinv_price;
							$final_tot_price = $final_tot_price + $totalValue;
						$html .='<tr>
							<td style=" border: 1px solid #aaa;">'.$i1.'</td>
							<td style=" border: 1px solid #aaa;">'.$row_value->buyer_item_code.'</td>
							<td style=" border: 1px solid #aaa;">'.$row_value->codePartNo_desc.' ('.$row_value->oinv_codePartNo.')</td>
							<td style=" border: 1px solid #aaa; height:100px;">'.$row_value->hsn_code.'</td>
							<td style=" border: 1px solid #aaa;">'.$unit.'</td>
							<td style=" border: 1px solid #aaa;"> '.$custhelp->numberFormate($row_value->issued_qty).'</td>
							<td style=" border: 1px solid #aaa;"> '.$custhelp->numberFormate($row_value->oinv_price).'</td>
							<td style=" border: 1px solid #aaa;"> '.$custhelp->numberFormate($totalValue).'</td>
							<td style=" border: 1px solid #aaa;">'.$custhelp->numberFormate($row_value->item_discount).'</td>
							<td style=" border: 1px solid #aaa;">'.$custhelp->numberFormate($row_value->item_taxable_total).'</td>
							<td style=" border: 1px solid #aaa;">'.$custhelp->numberFormate($row_value->cgst_rate).'</td>
							<td style=" border: 1px solid #aaa;">'.$custhelp->numberFormate($row_value->cgst_amt).'</td>
							<td style=" border: 1px solid #aaa;">'.$custhelp->numberFormate($row_value->sgst_rate).'</td>
							<td style=" border: 1px solid #aaa;">'.$custhelp->numberFormate($row_value->sgst_amt).'</td>
							<td style=" border: 1px solid #aaa;">'.$custhelp->numberFormate($row_value->igst_rate).'</td>
							<td style=" border: 1px solid #aaa;">'.$custhelp->numberFormate($row_value->igst_amt).'</td>
							<td style=" border: 1px solid #aaa;">'.$custhelp->numberFormate($row_value->tot_price).' </td>
						</tr>';
						$i1++;
					}
					$FCGST_Rate = 0;
					$FSGST_Rate = 0;
					$FIGST_Rate = $outgoing_invoice_excise_h->freight_gst_rate;
					$InsIGST_Rate = $outgoing_invoice_excise_h->ins_gst_rate;
					$pfIGST_Rate = $outgoing_invoice_excise_h->p_f_gst_rate;
					$IncIGST_Rate = $outgoing_invoice_excise_h->inc_gst_rate;
					$otIGST_Rate = $outgoing_invoice_excise_h->othc_gst_rate;
					$FCGST_Amt = 0;
					$FSGST_Amt = 0;
					$FIGST_Amt = 0;
					$TaxableFreight =0;
					$TaxableInsurance = $InsCGST_Rate = $InsSGST_Rate = $InsCGST_Amt = $InsSGST_Amt = $InsIGST_Amt = 0;
					$TaxableIncidental = $IncCGST_Rate = $IncSGST_Rate = $IncCGST_Amt = $IncSGST_Amt = $IncIGST_Amt = 0;
					$TaxablePF = $pfCGST_Rate = $pfSGST_Rate = $pfCGST_Amt = $pfSGST_Amt = $pfIGST_Amt = 0;
					$TaxableOT = $otCGST_Rate = $otSGST_Rate = $otCGST_Amt = $otSGST_Amt = $otIGST_Amt = 0;
					$TaxableOT = ($item_taxable_total * $outgoing_invoice_excise_h->othc_charge)/100;
					$TaxablePF = ($item_taxable_total * $outgoing_invoice_excise_h->pf_chrg)/100;
					$TaxableIncidental = ($item_taxable_total * $outgoing_invoice_excise_h->incidental_chrg)/100;
					$TaxableInsurance = ($item_taxable_total * $outgoing_invoice_excise_h->ins_charge)/100;
					if(!empty($outgoing_invoice_excise_h->freight_percent) && $outgoing_invoice_excise_h->freight_percent > 0 )  {
						$TaxableFreight = ($item_taxable_total * $outgoing_invoice_excise_h->freight_percent)/100;
						
					}
					if(!empty($outgoing_invoice_excise_h->freight_amount) && $outgoing_invoice_excise_h->freight_amount > 0){
						$TaxableFreight = $outgoing_invoice_excise_h->freight_amount;
					}
					//echo $TaxableFreight;exit;
					//if($buyer[0]->_state_id == $principal[0]->_state_id) {
					if($buyer[0]->_state_id == CURRENT_BRANCH_STATE_ID) {
						$FCGST_Rate = ((float)$outgoing_invoice_excise_h->freight_gst_rate/2);
						$FSGST_Rate = ((float)$outgoing_invoice_excise_h->freight_gst_rate/2);
						$InsCGST_Rate = ((float)$outgoing_invoice_excise_h->ins_gst_rate/2);
						$InsSGST_Rate = ((float)$outgoing_invoice_excise_h->ins_gst_rate/2);
						$FIGST_Rate = 0;
						$InsIGST_Rate = 0;
						$IncCGST_Rate = ((float)$outgoing_invoice_excise_h->inc_gst_rate/2);
						$IncSGST_Rate = ((float)$outgoing_invoice_excise_h->inc_gst_rate/2);
						$IncIGST_Rate = 0;
						$pfCGST_Rate = ((float)$outgoing_invoice_excise_h->p_f_gst_rate/2);
						$pfSGST_Rate = ((float)$outgoing_invoice_excise_h->p_f_gst_rate/2);
						$pfIGST_Rate = 0;
						$otCGST_Rate = ((float)$outgoing_invoice_excise_h->othc_gst_rate/2);
						$otSGST_Rate = ((float)$outgoing_invoice_excise_h->othc_gst_rate/2);
						$otIGST_Rate = 0;
						
						$pfSGST_Amt = $pfCGST_Amt = ((float)$outgoing_invoice_excise_h->p_f_gst_amount/2);
						$otSGST_Amt = $otCGST_Amt = ((float)$outgoing_invoice_excise_h->othc_gst_amount/2);
						$InsSGST_Amt = $InsCGST_Amt = ((float)$outgoing_invoice_excise_h->ins_gst_amount/2);
						$IncSGST_Amt = $IncCGST_Amt = ((float)$outgoing_invoice_excise_h->inc_gst_amount/2);
						$FSGST_Amt = $FCGST_Amt = ((float)$outgoing_invoice_excise_h->freight_gst_amount/2);
						$TotalPfAmt = $TaxablePF + $pfSGST_Amt + $pfCGST_Amt;
						$TotalOtAmt = $TaxableOT + $otSGST_Amt + $otCGST_Amt;
						$TotalIncidentalAmt = $TaxableIncidental + $IncSGST_Amt + $IncCGST_Amt;
						$TotalInsuranceAmt = $TaxableInsurance + $InsSGST_Amt + $InsCGST_Amt;
						$TotalFreightAmt = $TaxableFreight + $FSGST_Amt + $FCGST_Amt;
					}else{
						$FIGST_Amt = ((float)$outgoing_invoice_excise_h->freight_gst_amount);
						$pfIGST_Amt = ((float)$outgoing_invoice_excise_h->p_f_gst_amount);
						$otIGST_Amt = ((float)$outgoing_invoice_excise_h->othc_gst_amount);
						$InsIGST_Amt = ((float)$outgoing_invoice_excise_h->ins_gst_amount);
						$IncIGST_Amt = ((float)$outgoing_invoice_excise_h->inc_gst_amount);
						//$TaxableFreight = ($outgoing_invoice_excise_h->freight_amount*(100-($FIGST_Rate)))/100;
						$TotalOtAmt = $TaxableOT + $otIGST_Amt;
						$TotalPfAmt = $TaxablePF + $pfIGST_Amt;
						$TotalIncidentalAmt = $TaxableIncidental + $IncIGST_Amt;
						$TotalInsuranceAmt = $TaxableInsurance + $InsIGST_Amt;
						$TotalFreightAmt = $TaxableFreight + $FIGST_Amt;
					}
					

					$html .='<tr>
					  <td style=" border: 1px solid #aaa;text-align:right;" colspan="5"><strong>Total:</strong></td>
					  <td style=" border: 1px solid #aaa;"><strong> '.$custhelp->numberFormate($qty).'</strong></td>
					  <td style=" border: 1px solid #aaa;"></td>
					  <td style=" border: 1px solid #aaa;"><strong>'.$custhelp->numberFormate($final_tot_price).'</strong></td>
					  <td style=" border: 1px solid #aaa;"></td>
					  <td style=" border: 1px solid #aaa;"><strong>'.$custhelp->numberFormate($item_taxable_total).'<br>
						</strong></td>
					  <td style=" border: 1px solid #aaa;"></td>
					  <td style=" border: 1px solid #aaa;"><strong> '.$custhelp->numberFormate($cgst_amt_total).'</strong></td>
					  <td style=" border: 1px solid #aaa;"></td>
					  <td style=" border: 1px solid #aaa;"><strong> '.$custhelp->numberFormate($sgst_amt_total).'</strong></td>
					  <td style=" border: 1px solid #aaa;"></td>
					  <td style=" border: 1px solid #aaa;"><strong>'.$custhelp->numberFormate($igst_amt_total).'</strong></td>
					  <td style=" border: 1px solid #aaa;"><strong>'.$custhelp->numberFormate($tot_price).' </strong></td>
				  </tr>
				  <tr>
					  <td colspan="5" valign="top" rowspan="9" style=" border: 1px solid #aaa;text-align:left;">                 
					<div style="padding:10px;">
					<span style="text-decoration:underline;"><strong>Terms and Condition :</strong><br>
					<br>
					</span>
						<span> 1. All disputes are Subject to Gurgaon Jurisdiction.  </span><br/>
						<span> 2. Our responsibility ceases on delivery of goods.  </span><br/>
						<span> 3. All Taxes extra , as applicable at the time of supply.  </span><br/>
						<span> 4. Interest @24% per annum will be charged after due date.  </span><br/>
					</div>
					  </td>';
				 if((!empty($outgoing_invoice_excise_h->freight_amount) && $outgoing_invoice_excise_h->freight_amount > 0) || (!empty($outgoing_invoice_excise_h->freight_percent) && $outgoing_invoice_excise_h->freight_percent > 0)) {
					 $html .= '<td colspan="4" align="right" style=" border: 1px solid #aaa;"><strong>Freight:</strong></td>
					  <td style=" border: 1px solid #aaa;">'.$custhelp->numberFormate($TaxableFreight).'</td>
					  <td style=" border: 1px solid #aaa;">'.$custhelp->numberFormate($FCGST_Rate).'</td>
					  <td style=" border: 1px solid #aaa;">'.$custhelp->numberFormate($FCGST_Amt).'</td>
					  <td style=" border: 1px solid #aaa;">'.$custhelp->numberFormate($FSGST_Rate).'</td>
					  <td style=" border: 1px solid #aaa;">'.$custhelp->numberFormate($FSGST_Amt).'</td>
					  <td style=" border: 1px solid #aaa;">'.$custhelp->numberFormate($FIGST_Rate).'</td>
					  <td style=" border: 1px solid #aaa;">'.$custhelp->numberFormate($FIGST_Amt).'</td>
					  <td style=" border: 1px solid #aaa;">'.$custhelp->numberFormate($TotalFreightAmt).'</td>';
				  }
				  $html .= ' </tr>';
				  if(!empty($outgoing_invoice_excise_h->ins_charge) && $outgoing_invoice_excise_h->ins_charge > 0) {
				$html .=	'<tr>
					  <td colspan="4" align="right" style=" border: 1px solid #aaa;"><strong>Insurance:</strong></td>
					  <td style=" border: 1px solid #aaa;">'.$custhelp->numberFormate($TaxableInsurance).'</td>
					  <td style=" border: 1px solid #aaa;">'.$custhelp->numberFormate($InsCGST_Rate).'</td>
					  <td style=" border: 1px solid #aaa;">'.$custhelp->numberFormate($InsCGST_Amt).'</td>
					  <td style=" border: 1px solid #aaa;">'.$custhelp->numberFormate($InsSGST_Rate).'</td>
					  <td style=" border: 1px solid #aaa;">'.$custhelp->numberFormate($InsSGST_Amt).'</td>
					  <td style=" border: 1px solid #aaa;">'.$custhelp->numberFormate($InsIGST_Rate).'</td>
					  <td style=" border: 1px solid #aaa;">'.$custhelp->numberFormate($InsIGST_Amt).'</td>
					  <td style=" border: 1px solid #aaa;">'.$custhelp->numberFormate($TotalInsuranceAmt).'</td>
				  </tr>';
			  }
			    if(!empty($outgoing_invoice_excise_h->incidental_chrg) && $outgoing_invoice_excise_h->incidental_chrg > 0) {
				$html .=	'<tr>
					  <td colspan="4" align="right" style=" border: 1px solid #aaa;"><strong>Incidental:</strong></td>
					  <td style=" border: 1px solid #aaa;">'.$custhelp->numberFormate($TaxableIncidental).'</td>
					  <td style=" border: 1px solid #aaa;">'.$custhelp->numberFormate($IncCGST_Rate).'</td>
					  <td style=" border: 1px solid #aaa;">'.$custhelp->numberFormate($IncCGST_Amt).'</td>
					  <td style=" border: 1px solid #aaa;">'.$custhelp->numberFormate($IncSGST_Rate).'</td>
					  <td style=" border: 1px solid #aaa;">'.$custhelp->numberFormate($IncSGST_Amt).'</td>
					  <td style=" border: 1px solid #aaa;">'.$custhelp->numberFormate($IncIGST_Rate).'</td>
					  <td style=" border: 1px solid #aaa;">'.$custhelp->numberFormate($IncIGST_Amt).'</td>
					  <td style=" border: 1px solid #aaa;">'.$custhelp->numberFormate($TotalIncidentalAmt).'</td>
				  </tr>';
			  }
			  if(!empty($outgoing_invoice_excise_h->pf_chrg) && $outgoing_invoice_excise_h->pf_chrg > 0) {
					$html .=	'<tr>
					  <td colspan="4" align="right" style=" border: 1px solid #aaa;"><strong>Packing and Forwarding Charges:</strong></td>
					  <td style=" border: 1px solid #aaa;">'.$custhelp->numberFormate($TaxablePF).'</td>
					  <td style=" border: 1px solid #aaa;">'.$custhelp->numberFormate($pfCGST_Rate).'</td>
					  <td style=" border: 1px solid #aaa;">'.$custhelp->numberFormate($pfCGST_Amt).'</td>
					  <td style=" border: 1px solid #aaa;">'.$custhelp->numberFormate($pfSGST_Rate).'</td>
					  <td style=" border: 1px solid #aaa;">'.$custhelp->numberFormate($pfSGST_Amt).'</td>
					  <td style=" border: 1px solid #aaa;">'.$custhelp->numberFormate($pfIGST_Rate).'</td>
					  <td style=" border: 1px solid #aaa;">'.$custhelp->numberFormate($pfIGST_Amt).'</td>
					  <td style=" border: 1px solid #aaa;">'.$custhelp->numberFormate($TotalPfAmt).'</td>
				  </tr>';
			  }
			  if(!empty($outgoing_invoice_excise_h->othc_charge) && $outgoing_invoice_excise_h->othc_charge > 0) {
					$html .=	'<tr>
					  <td colspan="4" align="right" style=" border: 1px solid #aaa;"><strong>Other:</strong></td>
					  <td style=" border: 1px solid #aaa;">'.$custhelp->numberFormate($TaxableOT).'</td>
					  <td style=" border: 1px solid #aaa;">'.$custhelp->numberFormate($otCGST_Rate).'</td>
					  <td style=" border: 1px solid #aaa;">'.$custhelp->numberFormate($otCGST_Amt).'</td>
					  <td style=" border: 1px solid #aaa;">'.$custhelp->numberFormate($otSGST_Rate).'</td>
					  <td style=" border: 1px solid #aaa;">'.$custhelp->numberFormate($otSGST_Amt).'</td>
					  <td style=" border: 1px solid #aaa;">'.$custhelp->numberFormate($otIGST_Rate).'</td>
					  <td style=" border: 1px solid #aaa;">'.$custhelp->numberFormate($otIGST_Amt).'</td>
					  <td style=" border: 1px solid #aaa;">'.$custhelp->numberFormate($TotalOtAmt).'</td>
				  </tr>';
			  }
			  $TotalTaxableValue = $TaxableFreight + $TaxableInsurance + $TaxableIncidental + $TaxablePF + $TaxableOT;
			  $TotalCGSTAndOther = $FCGST_Amt + $InsCGST_Amt + $IncCGST_Amt + $pfCGST_Amt + $otCGST_Amt;
			  $TotalSGSTAndOther = $FSGST_Amt + $InsSGST_Amt + $IncSGST_Amt + $pfSGST_Amt + $otSGST_Amt;
			  $TotalIGSTAndOther = $FIGST_Amt + $InsIGST_Amt + $IncIGST_Amt + $pfIGST_Amt + $otIGST_Amt;
			  $TotalAmtOther = $TotalTaxableValue + $TotalCGSTAndOther + $TotalSGSTAndOther + $TotalIGSTAndOther;
			  $Total = $TotalAmtOther + $tot_price;
			  $Total = number_format((float)$Total, 2, '.', '');
			  
			  $TotalDecimal = explode('.',$Total);
			  $decimalValue = '';
			  if(isset($TotalDecimal[1])){
				  $decimalValue = $custhelp->number_to_words($TotalDecimal[1]);
			  } 
			  $decimalValue = trim($decimalValue);
				
			  if(!empty($decimalValue)){
				  $decimalValue = 'and '.$decimalValue.' Paise';
			  }
			  
					$html .=	'<tr>
					  <td colspan="4" align="right" style=" border: 1px solid #aaa;"><strong>Component Total:</strong></td>
					  <td style=" border: 1px solid #aaa;"><strong>'.$TotalTaxableValue.'</strong></td>
					  <td style=" border: 1px solid #aaa;">&nbsp;</td>
					  <td style=" border: 1px solid #aaa;"><strong> '.$TotalCGSTAndOther.'</strong></td>
					  <td style=" border: 1px solid #aaa;">&nbsp;</td>
					  <td style=" border: 1px solid #aaa;"><strong>'.$TotalSGSTAndOther.'</strong></td>
					  <td style=" border: 1px solid #aaa;">&nbsp;</td>
					  <td style=" border: 1px solid #aaa;"><strong>'.$TotalIGSTAndOther.'</strong></td>
					  <td style=" border: 1px solid #aaa;"><strong> '.$TotalAmtOther.'</strong></td>
				  </tr>
					<tr>
					  <td colspan="4" align="right" style=" border: 1px solid #aaa;">&nbsp;</td>
					  <td colspan="8" style=" border: 1px solid #aaa;">&nbsp;</td>
				  </tr>
					<tr>
					  <td colspan="4" align="right" style=" border: 1px solid #aaa;font-size:24px;"><strong>Total Bill Value (In Figure):</strong></td>
					  <td colspan="8" align="right" style=" border: 1px solid #aaa;font-size:24px;" ><strong>'.$Total.'</strong></td>
				  </tr>
					<tr>
					  <td colspan="4" align="right" style=" border: 1px solid #aaa;"><strong>Total Bill Value (In Words):</strong></td>
					  <td colspan="8" align="left" style=" border: 1px solid #aaa;"><strong>Rs. '.$custhelp->number_to_words($Total).''.$decimalValue.'  Only</strong></td>
				  </tr>	
				  <tr>
					  <td colspan="4" align="right" style=" border: 1px solid #aaa;"><strong>Bill Amount Subjected to Reverse Charges:<br>
					  </strong></td>
					  <td style=" border: 1px solid #aaa;">&nbsp;</td>
					  <td style=" border: 1px solid #aaa;">&nbsp;</td>
					  <!--<td style=" border: 1px solid #aaa;">'.$cgst_amt_total.'</td> -->
					  <td style=" border: 1px solid #aaa;">0</td>
					  <td style=" border: 1px solid #aaa;">&nbsp;</td>
					  <!--<td style=" border: 1px solid #aaa;">'.$sgst_amt_total.'</td>-->
					  <td style=" border: 1px solid #aaa;">0</td>
					  <td style=" border: 1px solid #aaa;">&nbsp;</td>
					  <td style=" border: 1px solid #aaa;">'.$igst_amt_total.'</td>
					  <td style=" border: 1px solid #aaa;">&nbsp;</td>
				  </tr>
				  <tr>
					  <td colspan="9" align="right" style=" border: 1px solid #aaa;"><strong>Electronic Reference Number:<br>
					  </strong></td>					 
				  </tr>
				</table>
				
				<table style="table-layout:fixed; width:100%; border-collapse: collapse;">
	  
	   <tr>
		<td style=" font-size:13px; width:60%;">Certified that the particular given above are true &amp; correct.</td>
		<td align="right" style=" font-size:13px;  width:40%;"><strong>For MULTIWELD ENGINEERING PVT. LTD.<br>
		  <br>
		  <br>
		  Authorised Signatory<br>
		</strong></td>
	  </tr>

	</table>

				
				
				
			</div>
			
			
		</div>
		</div>
	</body>';
}
}
//print_r($html); die;
	$stylesheet = file_get_contents("style.css");
	$mpdf -> WriteHTML($stylesheet,1);
	$mpdf->WriteHTML($html);
	$mpdf->Output();
	exit;			
}
	

 
?>
