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
	$Print = Outgoing_Invoice_Excise_Model::LoadOutgoingInvoiceExcise($oinvoice_exciseID);
	$mpdf=new mPDF('c','USLETTER','','',5,5,1,4,1,2); 
	$mpdf->mirrorMargins = 1;	// Use different Odd/Even headers and footers and mirror margins
	$html = '';
	foreach($Print as $outgoing_invoice_excise_h){
		$pod = Purchaseorder_Model::LoadPurchaseByID($outgoing_invoice_excise_h->pono,'N');
		//print_r($outgoing_invoice_excise_h);exit;
		$buyer = BuyerMaster_Model::LoadBuyerDetails($outgoing_invoice_excise_h->BuyerID,"A",null,null);
		//if($buyer[0]->_state_id == )
		
		$Query = "SELECT gst_no FROM buyer_gst_details WHERE buyer_id = ".$buyer[0]->_buyer_id." AND gst_state_id = ".$buyer[0]->_state_id."";
		$Result = DBConnection::SelectQuery($Query);
		$Row = mysql_fetch_array($Result, MYSQL_ASSOC);
		$billedGstNo = empty($Row['gst_no'])?'':$Row['gst_no'];
	//print_r($buyer[0]->_state_id);exit;
		foreach($pod as $pod_value) {
		$shippedState = StateMasterModel::LoadAll($pod_value->sstate1);
		$GstType = 'INTER';
		$FCGST_Rate = 0;
		$FSGST_Rate = 0;
		$FIGST_Rate = 18;
		$FCGST_Amt = 0;
		$FSGST_Amt = 0;
		$FIGST_Amt = 0;
		$TaxableFreight =0;
		if($buyer[0]->_state_id == $shippedState[0]->_stateId) {
			$GstType = "INTRA";
			$FCGST_Rate = 9;
			$FSGST_Rate = 9;
			$FIGST_Rate = 0;
			$FSGST_Amt = $FCGST_Amt = ($outgoing_invoice_excise_h->freight_amount * 9) / 100;
			$TaxableFreight = ($outgoing_invoice_excise_h->freight_amount*(100-($FCGST_Rate+$FSGST_Rate)))/100;
			$TotalFreightAmt = $TaxableFreight + $FSGST_Amt + $FCGST_Amt;
		}else{
			$FIGST_Amt = ($outgoing_invoice_excise_h->freight_amount * 18) / 100;
			$TaxableFreight = ($outgoing_invoice_excise_h->freight_amount*(100-($FIGST_Rate)))/100;
			$TotalFreightAmt = $TaxableFreight + $FIGST_Amt;
		} 
		
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
						<td align="right" style="border:none;"><strong>Original for Buyer Valid for Input Tax Credit</strong></td>
					  </tr>
					  </table>		
		</div>
		<div style="clear:both;"></div>
		<div style="border: 1px solid #aaa;">    
			<div  style=" border-bottom: 1px solid #aaa;">	
			<div  style=" border-bottom: 1px solid #aaa;">
				<div style=" border: 1px solid #aaa; width:10%; padding:5px;	display:inline; margin: 15px 0 0 15px; float:left;">
					<img src="images/logo2.jpg" style="width:100%;"/>
				</div>
				<div style="display:inline; float:left; text-align:center; width:80%; margin-bottom: 10px;">
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
			  <td align="center" style="width:33%;">
		<div><strong> INVOICE No. </strong></div> 
		</td>
	  </tr>
	  <tr>
		<td style="width:33%;">
		<div style="padding: 10px; text-align:left;">
						<span style="text-decoration:underline;"> Details of Receiver (Billed To)</span><br>
						<br/>
						 <strong>'.$outgoing_invoice_excise_h->Buyer_Name.'</strong><br>
						 <br/>
						 <span>'.$buyer[0]->_bill_add1.','.$buyer[0]->_bill_add2.'<br>
	City : MANESAR <br>
	State : '.$buyer[0]->_state_name.' - 122051</span> 
						 <br>
						  <div style=" padding-top:20px;"><strong>GSTIN Number:</strong> '.$billedGstNo.'</div> 
		</div>
		</td>
		<td style="width:33%;">
		<div style="padding: 10px; text-align:left;">
						<span style="text-decoration:underline;"> Details of Consignee (Shipped To)</span><br>
						<br/>
						 <strong>'.$outgoing_invoice_excise_h->Buyer_Name.'</strong><br>
						 <br/>
						 <span>'.$pod_value->sadd1.','.$pod_value->sadd2.' <br>
	City : MANESAR <br>
	State : '.$shippedState[0]->_stateName.' - 122051</span> 
						 <br>
						  <div style=" padding-top:20px;"><strong>GSTIN Number:</strong> '.$shippedGstNo.'</div> 
		</div>
		</td>
		<td style="padding:0; width:34%;" valign="top">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:none;" class="invoiceTbl">
	  <tr>
		<td colspan="2" align="center"><strong style="text-align:center">'.$outgoing_invoice_excise_h->oinvoice_No.'</strong></td>
	  </tr>
		<tr>
		<td><strong>Date of Issue </strong></td>
		 <td>: '.$outgoing_invoice_excise_h->oinv_date.'</td>
	  </tr>
	  <tr>
		<td><strong>Time of Issue<br>
		</strong></td>
		<td>: '.$outgoing_invoice_excise_h->oinv_time.'</td>
	  </tr>
	  <tr>
		<td><strong>Vender Code</strong></td>
		<td>:  S612</td>
	  </tr>
	  <tr>
		<td><strong>Tax Code</strong></td>
		<td>:  GST '.$GstType.' STATE SALE  (GLS)<br></td>
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
						<td rowspan="2" style=" width:4%;"><strong>S. No </strong></td>		
						<td rowspan="2" style=" width:10%;"><strong>Code / Part No.</strong></th>		
						<td rowspan="2" style=" width:26%;"><strong> Description Of Goods
					  </strong></td>
						<td rowspan="2" style=" width:10%;"><strong>HSN Code</strong></td>                    
						<td rowspan="2" style=" width:6%;"><strong>Unit</strong></td>
						<td rowspan="2" style=" width:9%;"><strong> Qty</strong></td>
						<td rowspan="2" style=" width:8%;"><strong> Rate</strong></td>
						<td rowspan="2" style=" width:12%;"><strong>Total<br>Value </strong></td>
						<td rowspan="2" style=" width:12%;"><strong>Disc%</strong></td>
						<td rowspan="2" style=" width:12%;"><strong>Taxable Value</strong></td>
						<td colspan="2" style=" width:5%;"><strong>CGST</strong></td>
						<td colspan="2" style=" width:5%;"><strong>SGST</strong></td>
						<td colspan="2" style=" width:5%;"><strong>IGST</strong></td>
							<td rowspan="2" style=" width:12%;"><strong> Total Amount</strong></td>
					</tr>
					<tr>
						<td style=" border: 1px solid #aaa;" width="10%"><strong>Rate%</strong></td>
						<td style=" border: 1px solid #aaa;" width="10%"><strong>Amt</strong></td>
						<td style=" border: 1px solid #aaa;" width="10%"><strong>Rate%</strong></td>
						<td style=" border: 1px solid #aaa;" width="10%"><strong>Amt</strong></td>
						<td style=" border: 1px solid #aaa;" width="10%"><strong>Rate%</strong></td>
						<td style=" border: 1px solid #aaa;" width="10%"><strong>Amt</strong></td>
						</tr>';
					$i1=1;
					$item_taxable_total = $cgst_amt_total = $sgst_amt_total = $igst_amt_total = $qty = $tot_price = 0;
					foreach($outgoing_invoice_excise_h->_itmes as $row_value) {
							$incInvDet = Incoming_Invoice_Excise_Model_Details::getIncomingInvoiceDetailsById($row_value->entryDId);
							$item_taxable_total = $item_taxable_total + $row_value->item_taxable_total;
							$cgst_amt_total = $cgst_amt_total + $row_value->cgst_amt;
							$sgst_amt_total = $sgst_amt_total + $row_value->sgst_amt;
							$igst_amt_total = $igst_amt_total + $row_value->igst_amt;
							$qty = $qty + $row_value->issued_qty;
							$tot_price = $tot_price + $row_value->tot_price;
						$html .='<tr>
							<td style=" border: 1px solid #aaa;">'.$i1.'</td>
							<td style=" border: 1px solid #aaa;">'.$row_value->oinv_codePartNo.'</td>
							<td style=" border: 1px solid #aaa;">'.$row_value->codePartNo_desc.'</td>
							<td style=" border: 1px solid #aaa; height:100px;">'.$row_value->hsn_code.'</td>
							<td style=" border: 1px solid #aaa;">'.$incInvDet[0]->_itemID_unitname.'</td>
							<td style=" border: 1px solid #aaa;"> '.$row_value->issued_qty.'</td>
							<td style=" border: 1px solid #aaa;"> '.$row_value->oinv_price.'</td>
							<td style=" border: 1px solid #aaa;"> '.$row_value->tot_price.'</td>
							<td style=" border: 1px solid #aaa;">'.$row_value->item_discount.'</td>
							<td style=" border: 1px solid #aaa;">'.$row_value->item_taxable_total.'</td>
							<td style=" border: 1px solid #aaa;">'.$row_value->cgst_rate.'</td>
							<td style=" border: 1px solid #aaa;">'.$row_value->cgst_amt.'</td>
							<td style=" border: 1px solid #aaa;">'.$row_value->sgst_rate.'</td>
							<td style=" border: 1px solid #aaa;">'.$row_value->sgst_amt.'</td>
							<td style=" border: 1px solid #aaa;">'.$row_value->igst_rate.'</td>
							<td style=" border: 1px solid #aaa;">'.$row_value->igst_amt.'</td>
							<td style=" border: 1px solid #aaa;">'.$row_value->tot_price.' </td>
						</tr>';
						$i1++;
					}

					$html .='<tr>
					  <td style=" border: 1px solid #aaa;text-align:right;" colspan="5"><strong>Total:</strong></td>
					  <td style=" border: 1px solid #aaa;"><strong> '.$qty.'</strong></td>
					  <td style=" border: 1px solid #aaa;"></td>
					  <td style=" border: 1px solid #aaa;"><strong>'.$tot_price.'</strong></td>
					  <td style=" border: 1px solid #aaa;"></td>
					  <td style=" border: 1px solid #aaa;"><strong>'.$item_taxable_total.'<br>
						</strong></td>
					  <td style=" border: 1px solid #aaa;"></td>
					  <td style=" border: 1px solid #aaa;"><strong> '.$cgst_amt_total.'</strong></td>
					  <td style=" border: 1px solid #aaa;"></td>
					  <td style=" border: 1px solid #aaa;"><strong> '.$sgst_amt_total.'</strong></td>
					  <td style=" border: 1px solid #aaa;"></td>
					  <td style=" border: 1px solid #aaa;"><strong>'.$igst_amt_total.'</strong></td>
					  <td style=" border: 1px solid #aaa;"><strong>'.$tot_price.' </strong></td>
				  </tr>
				  <tr>
					  <td colspan="5" valign="top" rowspan="8" style=" border: 1px solid #aaa;text-align:left;">                 
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
				 if(!empty($outgoing_invoice_excise_h->freight_amount)) {
					 $html .= '<td colspan="4" align="right" style=" border: 1px solid #aaa;"><strong>Freight:</strong></td>
					  <td style=" border: 1px solid #aaa;">'.$TaxableFreight.'</td>
					  <td style=" border: 1px solid #aaa;">'.$FCGST_Rate.'</td>
					  <td style=" border: 1px solid #aaa;">'.$FCGST_Amt.'</td>
					  <td style=" border: 1px solid #aaa;">'.$FSGST_Rate.'</td>
					  <td style=" border: 1px solid #aaa;">'.$FSGST_Amt.'</td>
					  <td style=" border: 1px solid #aaa;">'.$FIGST_Rate.'</td>
					  <td style=" border: 1px solid #aaa;">'.$FIGST_Amt.'</td>
					  <td style=" border: 1px solid #aaa;">'.$TotalFreightAmt.'</td>';
				  }
				  $html .= ' </tr>';
				  if(!empty($outgoing_invoice_excise_h->ins_charge)) {
				$html .=	'<tr>
					  <td colspan="4" align="right" style=" border: 1px solid #aaa;"><strong>Insurance:</strong></td>
					  <td style=" border: 1px solid #aaa;">0.00</td>
					  <td style=" border: 1px solid #aaa;">0.00</td>
					  <td style=" border: 1px solid #aaa;">0.00</td>
					  <td style=" border: 1px solid #aaa;">0.00</td>
					  <td style=" border: 1px solid #aaa;">0.00</td>
					  <td style=" border: 1px solid #aaa;">0.00</td>
					  <td style=" border: 1px solid #aaa;">0.00</td>
					  <td style=" border: 1px solid #aaa;">0.00</td>
				  </tr>';
			  }
			  if(!empty($outgoing_invoice_excise_h->pf_chrg)) {
					$html .=	'<tr>
					  <td colspan="4" align="right" style=" border: 1px solid #aaa;"><strong>Packing and Forwarding Charges:</strong></td>
					  <td style=" border: 1px solid #aaa;">0.00</td>
					  <td style=" border: 1px solid #aaa;">0.00</td>
					  <td style=" border: 1px solid #aaa;">0.00</td>
					  <td style=" border: 1px solid #aaa;">0.00</td>
					  <td style=" border: 1px solid #aaa;">0.00</td>
					  <td style=" border: 1px solid #aaa;">0.00</td>
					  <td style=" border: 1px solid #aaa;">0.00</td>
					  <td style=" border: 1px solid #aaa;">0.00</td>
				  </tr>';
			  }
			  $TotalTaxableValue = $TaxableFreight + $item_taxable_total;
			  $TotalCGSTAndOther = $cgst_amt_total + $FCGST_Amt;
			  $TotalSGSTAndOther = $sgst_amt_total + $FSGST_Amt;
					$html .=	'<tr>
					  <td colspan="4" align="right" style=" border: 1px solid #aaa;"><strong>Total:</strong></td>
					  <td style=" border: 1px solid #aaa;"><strong>'.$TotalTaxableValue.'</strong></td>
					  <td style=" border: 1px solid #aaa;">&nbsp;</td>
					  <td style=" border: 1px solid #aaa;"><strong> '.$TotalCGSTAndOther.'</strong></td>
					  <td style=" border: 1px solid #aaa;">&nbsp;</td>
					  <td style=" border: 1px solid #aaa;"><strong>'.$TotalSGSTAndOther.'</strong></td>
					  <td style=" border: 1px solid #aaa;">&nbsp;</td>
					  <td style=" border: 1px solid #aaa;"><strong>0.00</strong></td>
					  <td style=" border: 1px solid #aaa;"><strong> 26,191.88</strong></td>
				  </tr>
					<tr>
					  <td colspan="4" align="right" style=" border: 1px solid #aaa;">&nbsp;</td>
					  <td colspan="8" style=" border: 1px solid #aaa;">&nbsp;</td>
				  </tr>
					<tr>
					  <td colspan="4" align="right" style=" border: 1px solid #aaa;"><strong>Total Bill Value (In Figure):</strong></td>
					  <td colspan="8" align="right" style=" border: 1px solid #aaa;">26,191.88</td>
				  </tr>
					<tr>
					  <td colspan="4" align="right" style=" border: 1px solid #aaa;"><strong>Total Bill Value (In Words):</strong></td>
					  <td colspan="8" align="left" style=" border: 1px solid #aaa;">Rs. Twenty-Six Thousand One Hundred Ninety-One  And Eighty-Eight Paise  Only</td>
				  </tr>	
				  <tr>
					  <td colspan="4" align="right" style=" border: 1px solid #aaa;"><strong>Electronic Reference Number:<br>
					  </strong></td>
					  <td style=" border: 1px solid #aaa;">&nbsp;</td>
					  <td style=" border: 1px solid #aaa;">&nbsp;</td>
					  <td style=" border: 1px solid #aaa;">-</td>
					  <td style=" border: 1px solid #aaa;">&nbsp;</td>
					  <td style=" border: 1px solid #aaa;">-</td>
					  <td style=" border: 1px solid #aaa;">&nbsp;</td>
					  <td style=" border: 1px solid #aaa;">-</td>
					  <td style=" border: 1px solid #aaa;">&nbsp;</td>
				  </tr>
				  <tr>
					  <td colspan="9" align="right" style=" border: 1px solid #aaa;"><strong>Bill Amount Subjected to Reverse Charges:<br>
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
	$stylesheet = file_get_contents("style.css");
	$mpdf -> WriteHTML($stylesheet,1);
	$mpdf->WriteHTML($html);
	$mpdf->Output();
	exit;			
}
	

 
?>
