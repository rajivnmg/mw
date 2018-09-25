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
		//print_r($outgoing_invoice_excise_h);exit;
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
					<h1>MULTIWELD ENGINEERING PVT. LTD.</h1>
					<span>B-583A, Sushantlok, Phase-I, ,Gurgaon-122002(Hr.)</span><br/>
					<span>Ph. 0124 - 4063759,4377027</span><br/>
					<span>E-Mail : multiweld@vsnl.net</span><br/>
					<span>Website : www.multiweld.net</span><br/>
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
		<div><strong>PAN:</strong> AAFCM4981L</div> 
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
						 <span>Palam Gurgaon Road, Gurgaon 122001,<br>
	City : Gurgaon <br>
	State : HARYANA - 122051</span> 
						 <br>
						  <div style=" padding-top:20px;"><strong>GSTIN Number:</strong> 06AAACM0829Q1Z8</div> 
		</div>
		</td>
		<td style="width:33%;">
		<div style="padding: 10px; text-align:left;">
						<span style="text-decoration:underline;"> Details of Consignee (Shipped To)</span><br>
						<br/>
						 <strong>'.$outgoing_invoice_excise_h->Buyer_Name.'</strong><br>
						 <br/>
						 <span>Palam Gurgaon Road, Gurgaon 122001, <br>
	City : Gurgaon <br>
	State : HARYANA - 122051</span> 
						 <br>
						  <div style=" padding-top:20px;"><strong>GSTIN Number:</strong> 06AAACM0829Q1Z8</div> 
		</div>
		</td>
		<td style="padding:0; width:34%;" valign="top">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:none;" class="invoiceTbl">
	  <tr>
		<td colspan="2" align="center"><strong style="text-align:center">M01-17000001</strong></td>
	  </tr>
		<tr>
		<td><strong>Date of Issue </strong></td>
		 <td>:  03/07/2017</td>
	  </tr>
	  <tr>
		<td><strong>Time of Issue<br>
		</strong></td>
		<td>: 14:30</td>
	  </tr>
	  <tr>
		<td><strong>Vender Code</strong></td>
		<td>:  M080</td>
	  </tr>
	  <tr>
		<td><strong>Tax Code</strong></td>
		<td>:  GST INTRA STATE SALE  (GLS)<br></td>
	  </tr>
	  <tr>
		<td><strong>PO No.</strong></td>
		<td>: PO-7312798<br></td>
	  </tr>
	  <tr>
		<td><strong>Date</strong></td>
		<td>: 03/07/2017<br></td>
	  </tr>

	 
	</table>
	   
		</td>
	  </tr>
	</table>

			<div class="invoiceMainTbl">
			  <table style="table-layout:fixed; width:100%; border-collapse: collapse;">
					<tr>
						<td rowspan="2" style=" width:4%;"><strong>S. No </strong></td>				
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
						</tr>
					<tr>
						<td style=" border: 1px solid #aaa;">1</td>
						<td style=" border: 1px solid #aaa;">Loctite 5900 RTV Silicone - 20 Kg.<br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(43761) <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(M1501500015) </td>
						<td style=" border: 1px solid #aaa; height:100px;">32141000</td>
						<td style=" border: 1px solid #aaa;">NOS</td>
						<td style=" border: 1px solid #aaa;"> 3.00</td>
						<td style=" border: 1px solid #aaa;"> 33860.38</td>
						<td style=" border: 1px solid #aaa;"> 101581.14</td>
						<td style=" border: 1px solid #aaa;">0.00</td>
						<td style=" border: 1px solid #aaa;">101581.14</td>
						<td style=" border: 1px solid #aaa;">14.00</td>
						<td style=" border: 1px solid #aaa;">14221.36</td>
						<td style=" border: 1px solid #aaa;">14.00</td>
						<td style=" border: 1px solid #aaa;">14221.36</td>
						<td style=" border: 1px solid #aaa;">0.00</td>
						<td style=" border: 1px solid #aaa;">0.00</td>
						<td style=" border: 1px solid #aaa;">130023.86 </td>
					</tr>
					<tr>
					  <td style=" border: 1px solid #aaa;text-align:right;" colspan="4"><strong>Total:</strong></td>
					  <td style=" border: 1px solid #aaa;"><strong> 3.00</strong></td>
					  <td style=" border: 1px solid #aaa;"></td>
					  <td style=" border: 1px solid #aaa;"><strong>101581.14</strong></td>
					  <td style=" border: 1px solid #aaa;"></td>
					  <td style=" border: 1px solid #aaa;"><strong>101581.14<br>
						</strong></td>
					  <td style=" border: 1px solid #aaa;"></td>
					  <td style=" border: 1px solid #aaa;"><strong> 14221.36</strong></td>
					  <td style=" border: 1px solid #aaa;"></td>
					  <td style=" border: 1px solid #aaa;"><strong> 14221.36</strong></td>
					  <td style=" border: 1px solid #aaa;"></td>
					  <td style=" border: 1px solid #aaa;"><strong>0.00</strong></td>
					  <td style=" border: 1px solid #aaa;"><strong>130023.86																																																			 </strong></td>
				  </tr>
				  <tr>
					  <td colspan="4" valign="top" rowspan="8" style=" border: 1px solid #aaa;text-align:left;">                 
					<div style="padding:10px;">
					<span style="text-decoration:underline;"><strong>Terms and Conditions :</strong><br>
					<br>
					</span>
						<span> 1. All disputes are Subject to Gurgaon Jurisdiction.  </span><br/>
						<span> 2. Our responsibility ceases on delivery of goods.  </span><br/>
						<span> 3. All Taxes extra , as applicable at the time of supply.  </span><br/>
						<span> 4. Interest @24% per annum will be charged after due date.  </span><br/>
					</div>
					  </td>
					  <td colspan="4" align="right" style=" border: 1px solid #aaa;"><strong>Freight:</strong></td>
					  <td style=" border: 1px solid #aaa;">0.00</td>
					  <td style=" border: 1px solid #aaa;">0.00</td>
					  <td style=" border: 1px solid #aaa;">0.00</td>
					  <td style=" border: 1px solid #aaa;">0.00</td>
					  <td style=" border: 1px solid #aaa;">0.00</td>
					  <td style=" border: 1px solid #aaa;">0.00</td>
					  <td style=" border: 1px solid #aaa;">0.00</td>
					  <td style=" border: 1px solid #aaa;">0.00</td>
				  </tr>
					<tr>
					  <td colspan="4" align="right" style=" border: 1px solid #aaa;"><strong>Insurance:</strong></td>
					  <td style=" border: 1px solid #aaa;">0.00</td>
					  <td style=" border: 1px solid #aaa;">0.00</td>
					  <td style=" border: 1px solid #aaa;">0.00</td>
					  <td style=" border: 1px solid #aaa;">0.00</td>
					  <td style=" border: 1px solid #aaa;">0.00</td>
					  <td style=" border: 1px solid #aaa;">0.00</td>
					  <td style=" border: 1px solid #aaa;">0.00</td>
					  <td style=" border: 1px solid #aaa;">0.00</td>
				  </tr>
					<tr>
					  <td colspan="4" align="right" style=" border: 1px solid #aaa;"><strong>Packing and Forwarding Charges:</strong></td>
					  <td style=" border: 1px solid #aaa;">0.00</td>
					  <td style=" border: 1px solid #aaa;">0.00</td>
					  <td style=" border: 1px solid #aaa;">0.00</td>
					  <td style=" border: 1px solid #aaa;">0.00</td>
					  <td style=" border: 1px solid #aaa;">0.00</td>
					  <td style=" border: 1px solid #aaa;">0.00</td>
					  <td style=" border: 1px solid #aaa;">0.00</td>
					  <td style=" border: 1px solid #aaa;">0.00</td>
				  </tr>
					<tr>
					  <td colspan="4" align="right" style=" border: 1px solid #aaa;"><strong>Total:</strong></td>
					  <td style=" border: 1px solid #aaa;"><strong>101581.14</strong></td>
					  <td style=" border: 1px solid #aaa;">&nbsp;</td>
					  <td style=" border: 1px solid #aaa;"><strong> 14221.36</strong></td>
					  <td style=" border: 1px solid #aaa;">&nbsp;</td>
					  <td style=" border: 1px solid #aaa;"><strong>14221.36</strong></td>
					  <td style=" border: 1px solid #aaa;">&nbsp;</td>
					  <td style=" border: 1px solid #aaa;"><strong>0.00</strong></td>
					  <td style=" border: 1px solid #aaa;"><strong> 130023.86</strong></td>
				  </tr>
					<tr>
					  <td colspan="4" align="right" style=" border: 1px solid #aaa;">&nbsp;</td>
					  <td colspan="8" style=" border: 1px solid #aaa;">&nbsp;</td>
				  </tr>
					<tr>
					  <td colspan="4" align="right" style=" border: 1px solid #aaa;"><strong>Total Bill Value (In Figure):</strong></td>
					  <td colspan="8" align="right" style=" border: 1px solid #aaa;">130023.86</td>
				  </tr>
					<tr>
					  <td colspan="4" align="right" style=" border: 1px solid #aaa;"><strong>Total Bill Value (In Words):</strong></td>
					  <td colspan="8" align="left" style=" border: 1px solid #aaa;">Rs. One Lakh Thirty Thousand Twenty Three And Eighty Six Paise  Only</td>
				  </tr>	
				  <tr>
					  <td colspan="4" align="right" style=" border: 1px solid #aaa;"><strong>Bill Amount Subjected to Reverse Charges:<br>
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
	$stylesheet = file_get_contents("style1.css");
	$mpdf -> WriteHTML($stylesheet,1);
	$mpdf->WriteHTML($html);
	$mpdf->Output();
	exit;			
}
	

 
?>
<html>
<head>

<style>
  table td{font-size: 11px;
    padding: 5px;
	border: 1px solid #aaa; }
  body{ font-family:'Verdana'; font-size:13px; }
  .invoiceTbl tr td{ border:none; border-bottom: 1px solid #aaa;}
</style>


</head>
<body>
	<div style="width:100%; width: 1200px; margin:auto;">
    <div style="text-align:center; padding-bottom:5px;">
    <div style="text-align:center; margin-bottom:-17px; font-weight:bold;">TAX INVOICE FOR SUPPLY OF GOODS</div>
    <div style="float:right;">Original for Buyer Valid for Input Tax Credit</div>
    </div>
    <div style="clear:both;"></div>
    
    <div style="border: 1px solid #aaa;">    
		<div  style=" border-bottom: 1px solid #aaa;">	
        <div  style=" border-bottom: 1px solid #aaa;">
			<div style=" border: 1px solid #aaa; width:10%; padding:5px;	display:inline; margin: 15px 0 0 15px; float:left;">
				<img src="../pdf/images/logo.png" style="width:100%;">
			</div>
			<div style="display:inline; float:left; width:82%; margin-bottom: 10px;">
				<center>
				<h1>MULTIWELD ENGINEERING PVT. LTD.</h1>
				<span>B-583A, Sushantlok, Phase-I, ,Gurgaon-122002(Hr.)</span><br/>
				<span>Ph. 4063759,4377027</span><br/>
				<span>E-Mail : multiweld@vsnl.in</span><br/>
				<span>Website : www.multiweld.in</span><br/>
				</center>
			</div>
			<div style="clear:both;"></div>
		</div>		
		  <!--<div style="display:inline-block; width:100%; margin-bottom: 10px; padding-top:15px;">
				<center>
               <span>[ UNDER SECTION 31 OF CGST ACT, 2017 AND RULE 7-TAX INVOICE]</span><br/>
				<h1 style="margin: 10px 0px;font-size: 20px;">SUNVISORS INDIA PVT. LTD.</h1>
				PLOT NO. 384, SECTOR-18, ELECTRONIC CITY, GURGAON-122015 <br>
				State Code : 06    State Name : HARYANA<br>
				<br/>
				</center>
			</div>-->
			<div style="clear:both;"></div>
		</div>
        
       <table style="table-layout:fixed; width:100%; border-collapse: collapse;">
  <tr>
    <td align="left" width="33%" style="width:33%;">
    <div style="float:left"><strong>GSTIN Number:</strong> 06AAACS2016B1Z6</div> 
    <div style="float:right"><strong>CIN :</strong></div>    
    </td>
       <td align="center" width="33%" style="width:33%;">
    <div><strong>PAN:</strong> 06AAACS2016B1Z6</div> 
    </td>
          <td align="center" width="34%"  style="width:34%;">
    <div><strong> INVOICE No. </strong></div> 
    </td>
  </tr>
  <tr>
    <td style="width:34%;">
    <div style="padding: 10px; text-align:left;">
					<span style="text-decoration:underline;"> Details of Receiver (Billed To)</span><br>
					<br/>
                     <strong>MARUTI SUZUKI INDIA LIMITED (MANESAR)  (AD01M00002)</strong><br>
                     <br/>
                     <span>PLOT NO.1,<br>
PHASE-3A <br>
City : MANESAR <br>
State : HARYANA - 122051</span> 
				     <br>
                      <div style=" padding-top:20px;"><strong>GSTIN Number:</strong> 06AAACS2016B1Z6</div> 
    </div>
    </td>
    <td>
    <div style="padding: 10px; text-align:left;">
					<span style="text-decoration:underline;"> Details of Receiver (Billed To)</span><br>
					<br/>
                     <strong>MARUTI SUZUKI INDIA LIMITED (MANESAR)  (AD01M00002)</strong><br>
                     <br/>
                     <span>PLOT NO.1,<br>
PHASE-3A <br>
City : MANESAR <br>
State : HARYANA - 122051</span> 
				     <br>
                      <div style=" padding-top:20px;"><strong>GSTIN Number:</strong> 06AAACS2016B1Z6</div> 
    </div>
    </td>
    <td style="padding:0;" valign="top">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:none;" class="invoiceTbl">
  <tr>
    <td colspan="2" align="center"><strong style="text-align:center">SBG-000001</strong></td>
  </tr>
    <tr>
    <td><strong>Date of Issue </strong></td>
     <td>: 23/06/2017</td>
  </tr>
  <tr>
    <td><strong>Time of Issue<br>
    </strong></td>
    <td>: 10:31</td>
  </tr>
  <tr>
    <td><strong>Vender Code</strong></td>
    <td>:  S612</td>
  </tr>
  <tr>
    <td><strong>Tax Code</strong></td>
    <td>:  GST INTRA STATE SALE  (GLS)<br></td>
  </tr>
  <tr>
    <td><strong>PO No.</strong></td>
    <td>: 1709453<br></td>
  </tr>
  <tr>
    <td><strong>Date</strong></td>
    <td>: 23/06/2017<br></td>
  </tr>

 
</table>
   
    </td>
  </tr>
</table>

		<div style="">
		  <table style="table-layout:fixed; width:100%; border-collapse: collapse;">
				<tr>
					<td rowspan="2" style=" width:2%;"><strong>S. No </strong></td>				
					<td rowspan="2" style=" width:26%;"><strong> Description Of Goods
			      </strong></td>
					<td rowspan="2" style=" width:10%;"><strong>HSN Code</strong></td>                    
					<td rowspan="2" style=" width:4%;"><strong>Unit</strong></td>
					<td rowspan="2" style=" width:5%;"><strong> Qty</strong></td>
					<td rowspan="2" style=" width:5%;"><strong> Rate</strong></td>
					<td rowspan="2" style=" width:7%;"><strong>Total<br>
				    Value
			      </strong></td>
					<td rowspan="2" style=" width:4%;"><strong>Disc%</strong></td>
					<td rowspan="2" style=" width:7%;"><strong>Taxable Value</strong></td>
					<td colspan="2" style=" width:13%;"><strong>CGST</strong></td>
					<td colspan="2" style=" width:13%;"><strong>SGST</strong></td>
					<td colspan="2" style=" width:13%;"><strong>IGST</strong></td>
                    	<td rowspan="2" style=" width:7%;"><strong> Total Amount</strong></td>
				</tr>
				<tr>
					<td style=" border: 1px solid #aaa;" width="10%"><strong>Rate%</strong></td>
					<td style=" border: 1px solid #aaa;" width="20%"><strong>Amt</strong></td>
					<td style=" border: 1px solid #aaa;" width="10%"><strong>Rate%</strong></td>
					<td style=" border: 1px solid #aaa;" width="20%"><strong>Amt</strong></td>
					<td style=" border: 1px solid #aaa;" width="10%"><strong>Rate%</strong></td>
					<td style=" border: 1px solid #aaa;" width="20%"><strong>Amt</strong></td>
                    </tr>
				<tr>
					<td style=" border: 1px solid #aaa; height:100px;">1</td>
					<td style=" border: 1px solid #aaa; height:100px;">00SUNVISOR RH (84801M76M00-6GS)</td>
					<td style=" border: 1px solid #aaa; height:100px;">87082900NOS</td>
					<td style=" border: 1px solid #aaa; height:100px;">NOS</td>
					<td style=" border: 1px solid #aaa; height:100px;"> 210.00</td>
					<td style=" border: 1px solid #aaa; height:100px;"> 97.44</td>
					<td style=" border: 1px solid #aaa; height:100px;"> 20,462.40</td>
					<td style=" border: 1px solid #aaa; height:100px;">0.00</td>
					<td style=" border: 1px solid #aaa; height:100px;">20,462.40</td>
					<td style=" border: 1px solid #aaa; height:100px;">14.00</td>
					<td style=" border: 1px solid #aaa; height:100px;">2,864.74</td>
					<td style=" border: 1px solid #aaa; height:100px;">14.00</td>
					<td style=" border: 1px solid #aaa; height:100px;">2,864.74</td>
					<td style=" border: 1px solid #aaa; height:100px;">0.00</td>
					<td style=" border: 1px solid #aaa; height:100px;">0.00</td>
                    <td style=" border: 1px solid #aaa; height:100px;">26,191.88 </td>
				</tr>
				<tr>
				  <td style=" border: 1px solid #aaa;text-align:right;" colspan='4'><strong>Total:</strong></td>
				  <td style=" border: 1px solid #aaa;"><strong> 210.00</strong></td>
				  <td style=" border: 1px solid #aaa;"></td>
				  <td style=" border: 1px solid #aaa;"><strong>20,462.40</strong></td>
				  <td style=" border: 1px solid #aaa;"></td>
				  <td style=" border: 1px solid #aaa;"><strong>20,462.40<br>
				    </strong></td>
				  <td style=" border: 1px solid #aaa;"></td>
				  <td style=" border: 1px solid #aaa;"><strong> 2,864.74</strong></td>
				  <td style=" border: 1px solid #aaa;"></td>
				  <td style=" border: 1px solid #aaa;"><strong> 2,864.74</strong></td>
				  <td style=" border: 1px solid #aaa;"></td>
				  <td style=" border: 1px solid #aaa;"><strong>0.00</strong></td>
				  <td style=" border: 1px solid #aaa;"><strong>26,191.88 </strong></td>
			  </tr>
              <tr>
				  <td colspan='4' valign="top" rowspan="8" style=" border: 1px solid #aaa;text-align:left;">                 
				<div style="padding:10px;">
                <span style="text-decoration:underline;"><strong>Terms and Condition :</strong><br>
                <br>
                </span>
					<span> 1. All disputes are Subject to Gurgaon Jurisdiction.  </span><br/>
					<span> 2. Our responsibility ceases on delivery of goods.  </span><br/>
					<span> 3. All Taxes extra , as applicable at the time of supply.  </span><br/>
					<span> 4. Interest @24% per annum will be charged after due date.  </span><br/>
				</div>
                  </td>
				  <td colspan="4" align="right" style=" border: 1px solid #aaa;"><strong>Freight:</strong></td>
				  <td style=" border: 1px solid #aaa;">0.00</td>
				  <td style=" border: 1px solid #aaa;">14.00</td>
				  <td style=" border: 1px solid #aaa;">0.00</td>
				  <td style=" border: 1px solid #aaa;">14.00</td>
				  <td style=" border: 1px solid #aaa;">0.00</td>
				  <td style=" border: 1px solid #aaa;">0.00</td>
				  <td style=" border: 1px solid #aaa;">0.00</td>
				  <td style=" border: 1px solid #aaa;">0.00</td>
			  </tr>
				<tr>
				  <td colspan="4" align="right" style=" border: 1px solid #aaa;"><strong>Insurance:</strong></td>
				  <td style=" border: 1px solid #aaa;">0.00</td>
				  <td style=" border: 1px solid #aaa;">14.00</td>
				  <td style=" border: 1px solid #aaa;">0.00</td>
				  <td style=" border: 1px solid #aaa;">14.00</td>
				  <td style=" border: 1px solid #aaa;">0.00</td>
				  <td style=" border: 1px solid #aaa;">0.00</td>
				  <td style=" border: 1px solid #aaa;">0.00</td>
				  <td style=" border: 1px solid #aaa;">0.00</td>
			  </tr>
				<tr>
				  <td colspan="4" align="right" style=" border: 1px solid #aaa;"><strong>Packing and Forwarding Charges:</strong></td>
				  <td style=" border: 1px solid #aaa;">0.00</td>
				  <td style=" border: 1px solid #aaa;">14.00</td>
				  <td style=" border: 1px solid #aaa;">0.00</td>
				  <td style=" border: 1px solid #aaa;">14.00</td>
				  <td style=" border: 1px solid #aaa;">0.00</td>
				  <td style=" border: 1px solid #aaa;">0.00</td>
				  <td style=" border: 1px solid #aaa;">0.00</td>
				  <td style=" border: 1px solid #aaa;">0.00</td>
			  </tr>
				<tr>
				  <td colspan="4" align="right" style=" border: 1px solid #aaa;"><strong>Total:</strong></td>
				  <td style=" border: 1px solid #aaa;"><strong>20,462,40</strong></td>
				  <td style=" border: 1px solid #aaa;">&nbsp;</td>
				  <td style=" border: 1px solid #aaa;"><strong> 2,864.74</strong></td>
				  <td style=" border: 1px solid #aaa;">&nbsp;</td>
				  <td style=" border: 1px solid #aaa;"><strong>2,864.74</strong></td>
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
				  <td colspan="4" align="right" style=" border: 1px solid #aaa;"><strong>Bill Amount Subjected to Reverse Charges:<br>
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
			</table>
            
           	<table style="table-layout:fixed; width:100%; border-collapse: collapse;">
  
  <tr>
    <td valign="middle">Certified that the particular given above are true &amp; correct and the amount indicated represents the price actually charged and that there is no flow of any additional consideration directly or indirectly from the buyer.</td>
    <td align="right"><strong>For SUNVISORS INDIA PVT. LTD.<br>
      <br>
      <br>
      Authorised Signatory<br>
    </strong></td>
  </tr>
</table>

            
            
            
		</div>
		
		
	</div>
    </div>
</body>
</html>
