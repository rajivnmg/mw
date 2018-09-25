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
//include($root_path."Model/Param/param_model.php");

//outInvExPDF(13406);

function outInvExPDF($oinvoice_exciseID){
$CompanyInfo = ParamModel::GetCompanyInfo();
$param = new ParamModel();
$custhelp = new CustomHelper();
$challanItem = array();
//$oinvoice_exciseID =14891,14896,13691;13404,13405,13406// $_REQUEST['OutgoingInvoiceExciseNum'];
$Print = Outgoing_Invoice_Excise_Model::LoadOutgoingInvoiceExcise($oinvoice_exciseID);
$CompanyInfo = ParamModel::GetCompanyInfo();
$mpdf=new mPDF('c','USLETTER','','',5,5,1,4,1,2); 
$mpdf->mirrorMargins = 1;	// Use different Odd/Even headers and footers and mirror margins

$header = '';
$headerE = '';

$footer = '<div style="  font-weight: bold; color: #000;" align="center">
			<hr style="border: 1px solid #000;" />
			<table width="100%">
			<tr>
				<td width="90%" align="center">Registered Office : B3/83A LAWRENCE ROAD, NEW DELHI-35</td>
				<td width="10%" align="right"><b>Page {PAGENO} / {nbpg}</b></td>
			</tr>
			</table>
		</div>';
$footerE = '<div style="  font-weight: bold; color: #000;" align="center">
			<hr style="border: 1px solid #000;" />
			<table width="100%">
			<tr>
				<td width="90%" align="center">Registered Office : B3/83A LAWRENCE ROAD, NEW DELHI-35</td>
				<td width="10%" align="right"><b>Page {PAGENO} / {nbpg}</b></td>
			</tr>
			</table>
			
		</div>';
		
echo '<div id="printableArea">
			<div id="main">';
$htmlHED='';
$htmlFooter = '';
$html ='';
$html1 ='';
$html2 ='';
$filename ='';

foreach($Print as $outgoing_invoice_excise_h){
		 $poprincipal = Principal_Supplier_Master_Model::Load_Principal_Supplier($outgoing_invoice_excise_h->principalID,"P",1,100);			
		
		$buyer = BuyerMaster_Model::LoadBuyerDetails($outgoing_invoice_excise_h->BuyerID,"A",null,null);
		
		$htmlFooter.='<table width="100%" style="border-collapse: collapse;border: 1px solid black;">		
			<tbody>
				<tr>
					<td rowspan="4" style="border: 1px solid black;">1. '.$CompanyInfo["txt1"].'<br />
                    2. '.$CompanyInfo["txt2"].'<br />
                    3. '.$CompanyInfo["txt3"].'<br />
                    4. '.$CompanyInfo["txt4"].'<br />
					 <div style="font-size: 16px; font-weight: bold;">TIN: '.$buyer[0]->_tin.'</div></td>
					<td colspan="2" style="border: 1px solid black;width:250px;">Total Amount :</td>
					
					<td colspan="2" style="border: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Excise Duty Amount (RS.) only</td>
				</tr>
				<tr>					
					<td colspan="2" style="border: 1px solid black;">Taxable Amount :</td>					
					<td rowspan="4" style="border: 1px solid black;">   Name & Address of Manufacturer<br />
                    '.$poprincipal[0]->_principal_supplier_name.'<br />
					'.$poprincipal[0]->_add1.', '.$poprincipal[0]->_add2.' ,  '.$poprincipal[0]->_city_name.'
					,'.$poprincipal[0]->_state_name.' </td>
					<td  rowspan="4" style="border: 1px solid black;"> '.$CompanyInfo["txt5"].'<br /><br />
                    '.$CompanyInfo["txt6"].'</td>		
					
				</tr>
				<tr >	
					<td colspan="2" style="border: 1px solid black;">Total Amount : </td>					
								
				</tr>
				<tr>		
					<td colspan="2" style="border: 1px solid black;">Total Payable Amount :</td>					
								
				</tr>
				<tr>		
					<td colspan="3"  style="border: 1px solid black;">Grand Total(Rs.)</td>
					
				</tr>
				 
			</tbody>
		</table>';
$htmlFooter.='<br/>
		<table width="99%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td style="width: 59%;">'.$CompanyInfo["txt7"].':</td>
				<td style="width: 40%;" align="right">for, <span>'.$CompanyInfo["Name"].'</span></td>
			</tr>
			<tr>
				<td colspan="2">'.$CompanyInfo["txt8"].' &nbsp; &nbsp; &nbsp; &nbsp;</td>
			</tr>
			<tr>
				<td class="exc_bdr_left_rght" colspan="2">'.$CompanyInfo["txt9"].' <br/> '.$poprincipal[0]->_principal_supplier_name.' ,	'.$poprincipal[0]->_add1.', '.$poprincipal[0]->_add2.' ,  '.$poprincipal[0]->_city_name.','.$poprincipal[0]->_state_name.'</td>
			</tr>

			<tr>
				<td style="width: 59%;">'.$CompanyInfo["txt10"].'</td>
				<td style="width: 40%;" align="right">PLACE &nbsp; &nbsp; : '.$CompanyInfo["PLACE"].'. DATE &nbsp; '.$outgoing_invoice_excise_h->oinv_date.'</td>
			</tr>
			
		</table>';
}
$k=0;
foreach($Print as $outgoing_invoice_excise){
			$pod = Purchaseorder_Model::LoadPurchaseByID($outgoing_invoice_excise->pono,'N');
			$poprincipal = Principal_Supplier_Master_Model::Load_Principal_Supplier($outgoing_invoice_excise->principalID,"P",1,100);			
			$buyer = BuyerMaster_Model::LoadBuyerDetails($outgoing_invoice_excise->BuyerID,"A",null,null);
			$filename = $outgoing_invoice_excise->oinvoice_No;
$sstage='';
if($outgoing_invoice_excise->Supplier_stage == 1){
	$sstage='1ST STAGE DEALER';
}else if($outgoing_invoice_excise->Supplier_stage == 2){
	$sstage='2ST STAGE DEALER';
}else if($outgoing_invoice_excise->Supplier_stage == 'F'){
	$sstage='FREE SAMPLE';
}else{	
}
$htmlHED.='<div class="exc_cont">
				<div style="width: 90%; font-size: 15px; font-weight: 700; text-align: center;float:left">U/R 11 of CENVAT CREDIT RULES 2002 </div>
				<div style="width: 9%; font-size: 18px;float:right;">COPY</div>
				<div style="width: 100%; height: 95px; border: 1px solid #000; padding: 2px; font-size: 12px;">
					<div style="float: left; width: 43%; border-right: 1px solid #000;">
						<div style="font-weight: bolder; font-size: 22px;">'.$CompanyInfo["Name"].'</div>
					<div>
						<div style="float: left; width: 70%; text-align: left;">'.$CompanyInfo["Address"].'</div>
						<div style="float: left; width: 27%; text-align: right; font-size: 12px;">AUTHENTICATED</div>
						
					</div>
					<div>'.$CompanyInfo["Phone"].'</div>
					<div>'.$CompanyInfo["email"].'</div>
					<div>'.$CompanyInfo["Website"].'</div>
					<div>
						<div style="float: left; width: 70%; text-align: left;">'.$sstage.'</div>
						<div style="float: left; width: 27%; text-align: right;">Authorised Signatory</div>
						
					</div>
				</div>
		<div style="float: left; width: 28%; text-align: left; font-size: 12px; border-right: 1px solid #000;">
           <div style="width: 100%;">
                <div style="float: left;width: 36%; text-align: left;">CE Regn No.</div>
                <div style="float: left;width: 63%;text-align: left;">'.$CompanyInfo["CERegnNo"].'</div>
              
            </div>
            <div style="width: 100%;">
                <div style="float: left; width: 36%; text-align: left;">Range</div>
                <div style="float: left; width: 63%; text-align: left;">'.$CompanyInfo["RangeMulti"].'</div>
               
            </div>
            <div style="height: 40px;width: 100%;" >
                <div style="float: left; width: 36%; text-align: left;">Division</div>
                <div style="float: left; width: 63%; text-align: left;">'.$CompanyInfo["Division"].'</div>
               
            </div>
            <div style="width: 100%;">
                <div style="float: left; width: 36%; text-align: left;">Commisionarate</div>
                <div style="float: left; width: 63%; text-align: left;">'.$CompanyInfo["Commisionarate"].'</div>
               
            </div>
            <div style="width: 100%;">
                <div style="float: left; width: 36%; text-align: left;">ECC No.</div>
                <div style="float: left; width: 63%; text-align: left;">'.$CompanyInfo["ECCNo"].'</div>
               
            </div>
        </div>
        <div style="float: left; width: 13%;font-size: 12px; border-right: 1px solid #000;" align="center">
            <div style="height: 30px;">TIN : '.$CompanyInfo["TIN"].'</div>
            <div style="height: 65px;">PA No. '.$CompanyInfo["PAN"].'</div>
        </div>
        <div style="float: left; width: 15%;">
            <div align="center" style="font-weight: bold; border-bottom: 1px solid #000; width: 107%; font-size: 12px;">VALID FOR INPUT TAX</div>
            <div style="font-weight: bold; font-size: 12px;">TAX</div>
            <div style="font-weight: bold; font-size: 12px;">
                <div style="float: left; width: 50%;">Invoice No. :</div>
                <div style="float: left;">'.$outgoing_invoice_excise->oinvoice_No.'</div>
                
            </div>
            <div style=" font-size: 12px;">
                <div style="float: left; width: 50%;">Date :</div>
                <div style="float: left;">'.$outgoing_invoice_excise->oinv_date.'</div>
             
            </div>
            <div style=" font-size: 12px;">
                <div style="float: left; width: 50%;">Time :</div>
                <div style="float: left;">'.$outgoing_invoice_excise->oinv_time.'</div>
              
            </div>
        </div>
      
    </div>

   <div style="width: 100%; height: 110px; border-left: 1px solid #000;border-right: 1px solid #000; padding: 2px; font-size: 12px; float: left; border-bottom: 1px solid #000">
        <div style="float: left; height: 105px; width: 53%; border-right: 1px solid #000;">
            <div style="float: left; width: 62%;">
                <div style="font-size: 12px; font-weight: 700;">Name & Address of Buyer</div>
                <div style="font-size: 16px; font-weight: bold;">M/s '.$outgoing_invoice_excise->Buyer_Name.'</div>
                <div  style="font-size: 14px;">
'.$buyer[0]->_bill_add1.','.$buyer[0]->_bill_add2.'
                </div>
            </div>
            <div style="float: left; width: 36%;">
                <div style="font-size: 14px; font-weight: bold; margin-bottom: 3px;">
                    <div style="float: left; width: 50%;">Order No : </div>
                    <div style="float: left; width: 48%;">'.$pod[0]->pon.'</div>
                   
                </div>
                <div style="font-size: 14px; font-weight: bold; margin-bottom: 3px;">
                    <div style="float: left; width: 50%;">Order Date : </div>
                    <div style="float: left; width: 48%;"> '.$pod[0]->pod.'</div>
                  
                </div>
                <div style="font-size: 12px; margin-bottom: 3px;">
                    <div style="float: left; width: 52%;">Despatch Time : </div>
                    <div style="float: left; width: 45%;">'.$outgoing_invoice_excise->dispatch_time.'</div>
                  
                </div>
                <div style="font-size: 14px;">
                    Through '.$outgoing_invoice_excise->mod_delivery_text.'
                </div>
            </div>
            
        </div>
        <div style="float: left; width: 46.7%;">
            <div style="text-align: center;font-size: 14px; font-weight: bold; border-bottom: 1px solid #000;">
                <div style="float: left; width: 30%; border-right: 1px solid #000;">&nbsp;</div>
                <div style="float: left; width: 30%; border-right: 1px solid #000;">MANUFACTURER</div>
                <div style="float: left; width: 35%;">BUYER</div>
               
            </div>
            <div style="text-align: left;font-size: 12px; border-bottom: 1px solid #000;">
                <div style="float: left; width: 30%; border-right: 1px solid #000;">CE Regn No.</div>
                <div style="float: left; width: 30%; border-right: 1px solid #000;">&nbsp;</div>
                <div style="float: left; width: 35%;">&nbsp;</div>
               
            </div>
            <div style="text-align: left;font-size: 12px; border-bottom: 1px solid #000;">
                <div style="float: left; width: 30%; border-right: 1px solid #000;">Range Div & Collectrate</div>
                <div style="float: left; width: 30%; border-right: 1px solid #000;">&nbsp;</div>
                <div style="float: left; width: 35%;">&nbsp;</div>
                
            </div>
            <div style="text-align: left;font-size: 12px; border-bottom: 1px solid #000;">
                <div style="float: left; width: 30%; border-right: 1px solid #000;">Sales Tax No.</div>
                <div style="float: left; width: 30%; border-right: 1px solid #000;">'.$poprincipal[0]->_tin_no.'</div>
                <div style="float: left; width: 35%;">'.$buyer[0]->_tin.'</div>
               
            </div>
            <div style="text-align: left;font-size: 12px; border-bottom: 1px solid #000;">
                <div style="float: left; width: 30%; border-right: 1px solid #000;">PIT NO.</div>
                <div style="float: left; width: 30%; border-right: 1px solid #000;">&nbsp;</div>
                <div style="float: left; width: 35%;">&nbsp;</div>
               
            </div>
            <div style="text-align: left;font-size: 12px; border-bottom: 1px solid #000;">
                <div style="float: left; width: 30%; border-right: 1px solid #000;">ECC Code No.</div>
                <div style="float: left; width: 30%; border-right: 1px solid #000;">'.$poprincipal[0]->_ecc_codeno.'</div>
                <div style="float: left; width: 35%;">'.$buyer[0]->_ecc.'</div>
              
            </div>
            <div style="text-align: center;font-size: 14px;">
                <div style="float: left; width: 49.8%; border-right: 1px solid #000;border-left: 1px solid #000;">EXCISE DUTY</div>
                <div style="float: left; width: 48%;">MANUFACTURER</div>
                
            </div>
        </div>
       
    </div>';
		$htmlHED.='<table style="border-collapse: collapse;border: 1px solid black;" width="100%">
			<thead>
				<tr>
					<th style="border: 1px solid black;">S.No.</th>
					<th style="border: 1px solid black;">Code/Part No</th>
					<th style="border: 1px solid black;">Decription</th>
					<th style="border: 1px solid black;">ID Mark</th>
					<th style="border: 1px solid black;">Tarif Heading</th>
					<th style="border: 1px solid black;">Qty</th>
					<th style="border: 1px solid black;">Rate</th>
					<th style="border: 1px solid black;">Amount</th>
					<th style="border: 1px solid black;">Amount of ED</th>
					<th style="border: 1px solid black;">EDU CESS</th>
					<th style="border: 1px solid black;">Rate of ED</th>
					<th style="border: 1px solid black;">Duty Per Unit</th>
					<th style="border: 1px solid black;">Entry in 23D</th>
					<th style="border: 1px solid black;">Invoice No.</th>
					<th style="border: 1px solid black;">Date</th>
					<th style="border: 1px solid black;">Qty</th>
					<th style="border: 1px solid black;">Assess. Value</th>
					<th style="border: 1px solid black;">Amount of ED & Cess</th>
				</tr>
			</thead>
			<tbody>
			';
		$i1=1;
		$total = 0;
		$taxable_amt = 0;
		$payable_amt = 0;
		$edu_cess = 0;
		$hdu_cess = 0;
		$ed_total = 0;
		$edu_total = 0;
		$cvd_total = 0;
		$vatcstdesc ='';
		$SURCHARGE_DESC ='';		
		$ed_rate =0;
		$saleTax = 0;
		$surcharge = 0;
		$htmlPage = "";
		
		//print_r($outgoing_invoice_excise->_itmes); exit;
		foreach($outgoing_invoice_excise->_itmes as $row_value) {
			$total = $total + $row_value->tot_price;
			if($outgoing_invoice_excise->inclusive_ed_tag !='I'){
				$ed_total = $ed_total + $row_value->ed_amt;
			}
			
			$edu_cess = $row_value->edu_amt;
			$hdu_cess = $row_value->hedu_amount;
			$edu_total =$edu_total + $row_value->edu_amt+$row_value->hedu_amount;
			$hedu_total = $hedu_amount + $row_value->hedu_amount;
			$cvd_total = $cvd_total + $row_value->cvd_amt;
			$ed_rate = $row_value->ed_percent;
			$incInvDet = Incoming_Invoice_Excise_Model_Details::getIncomingInvoiceDetailsById($row_value->entryDId);
			//print_r($incInvDet); exit;
			 $TaxId = Outgoing_Invoice_Excise_Model::GetTaxByPOID($outgoing_invoice_excise->pono,$outgoing_invoice_excise->principalID,$row_value->_item_id);
			 $vatcst = $param->GetVATCSTBYId($TaxId);
			 $vatcstdesc = $vatcst['SALESTAX_DESC'];
			 $SURCHARGE_DESC = $vatcst['SURCHARGE_DESC'];
			 $saleTax = $vatcst['SALESTAX_CHRG'];
			 $surcharge = $vatcst['SURCHARGE'];
			
			$htmlPage .='<tr>
			<td style="border: 1px solid black;border-bottom: 0px solid black;">'.$i1.'</td>
			<td style="border: 1px solid black;border-bottom: 0px solid black;">'.$row_value->buyer_item_code.'</td>
			<td style="border: 1px solid black;border-bottom: 0px solid black;">'.$row_value->codePartNo_desc.'-('.$row_value->oinv_codePartNo.')</td>
			<td style="border: 1px solid black;border-bottom: 0px solid black;">'.$row_value->Item_Identification_Mark.'</td>
			<td style="border: 1px solid black;border-bottom: 0px solid black;">'.$row_value->Tarrif_Heading.'</td>
			<td style="border: 1px solid black;border-bottom: 0px solid black;">'.$row_value->issued_qty.' '.$incInvDet[0]->_itemID_unitname.'</td>
			<td style="border: 1px solid black;border-bottom: 0px solid black;">'.$row_value->oinv_price.'</td>
			<td style="border: 1px solid black;border-bottom: 0px solid black;">'.$row_value->tot_price.'</td>
			<td style="border: 1px solid black;border-bottom: 0px solid black;">'.$row_value->ed_amt.'</td>
			<td style="border: 1px solid black;border-bottom: 0px solid black;">'.$row_value->edu_amt.'</td>
			<td style="border: 1px solid black;border-bottom: 0px solid black;">'.$row_value->ed_percent.'%</td>
			<td style="border: 1px solid black;border-bottom: 0px solid black;">'.$row_value->ed_perUnit.'</td>
			
			<td style="border: 1px solid black;border-bottom: 0px solid black;">'.$row_value->mappingid.'</td>
			<td style="border: 1px solid black;border-bottom: 0px solid black;">'.$row_value->iinv_no.'</td>
			<td style="border: 1px solid black;border-bottom: 0px solid black;">'. date("d/m/Y", strtotime($row_value->principal_inv_date)).'</td>
			<td style="border: 1px solid black;border-bottom: 0px solid black;">'.$incInvDet[0]->_principal_qty.' '.$incInvDet[0]->_itemID_unitname.'</td>
			<td style="border: 1px solid black;border-bottom: 0px solid black;">'.$incInvDet[0]->_total_ass_value.'</td>
			<td style="border: 1px solid black;border-bottom: 0px solid black;">'.$incInvDet[0]->_ed_amount.'</td>
			
		</tr>';	
		
		
		$totalItems = count($outgoing_invoice_excise->_itmes);
	    if((count($outgoing_invoice_excise->_itmes)  < 3) || (($totalItems == $i1) && ($totalItems%3 != 0))){
		
			for($k=0; $k < (3-($totalItems%3));$k++ ){
				$htmlPage.='<tr style=" border-right:1px solid #2c2c2c; border-left:1px solid #2c2c2c;font-weight: bold; color: #000;">
					<td height="45px" style="border: 1px solid black;"></td>
					<td style="border: 1px solid black;"></td>
					<td style="border: 1px solid black;"></td>
					<td style="border: 1px solid black;"></td>
					<td style="border: 1px solid black;"></td>
					<td style="border: 1px solid black;"></td>
					<td style="border: 1px solid black;"></td>
					<td style="border: 1px solid black;"></td>
					<td style="border: 1px solid black;"></td>
					<td style="border: 1px solid black;"></td>
					<td style="border: 1px solid black;"></td>
					<td style="border: 1px solid black;"></td>
					<td style="border: 1px solid black;"></td>
					<td style="border: 1px solid black;"></td>
					<td style="border: 1px solid black;"></td>
					
					<td style="border: 1px solid black;"></td>
					<td style="border: 1px solid black;"></td>
					<td style="border: 1px solid black;"></td>
					
				
			</tr>';
			}
		} 
				
				
		
			if($i1%3 == 0 || $i1 == count($outgoing_invoice_excise->_itmes)) {
				
				$html1 .= $htmlHED. $htmlPage 
						.'</tbody></table>';
				if($i1 != count($outgoing_invoice_excise->_itmes)) {
					$html1 .= $htmlFooter
						. '<div style="page-break-after:always"></div>';
				}	
				
				$htmlPage = "";
			}
			$i1 ++;		
       }	   
	   
	   $vtcst=0;
	   $vtcstCharge =0;
	   $payable_amt = ($total - $outgoing_invoice_excise->discount + $edu_total +$cvd_total +$ed_total );
	   $html1.='</tbody>
		</table>
		<table width="100%" style="border-collapse: collapse;border: 1px solid black;">		
			<tbody>
				<tr>
					<td rowspan="4" style="border: 1px solid black;">1. '.$CompanyInfo["txt1"].'<br />
                    2. '.$CompanyInfo["txt2"].'<br/>
                    3. '.$CompanyInfo["txt3"].'<br/>
                    4. '.$CompanyInfo["txt4"].'<br/>
					<div style="font-size: 16px; font-weight: bold;">TIN: '.$buyer[0]->_tin.'</div></td>
					<td style="border: 1px solid black;border-right: 0px solid black;vertical-align:top;">Total Amount :<br/>';
					if($outgoing_invoice_excise->discount > 0){
                        $html1.='- Discount @ '.((($outgoing_invoice_excise->discount) * 100)/$total).'%<br/>';
						}
						if($ed_total > 0){
						 $html1.='+ Excise Duty :<br/>';
						}
						if($edu_total > 0){
                        $html1.='+ EDU CESS :<br/>';
						}
						if($cvd_total > 0){
                        $html1.=' + CVD : ';
						}
						if($outgoing_invoice_excise->pf_chrg > 0){
                        $html1.='+ P&F Charges @ % :<br/>';
						}
						if($outgoing_invoice_excise->incidental_chrg > 0){
                        $html1.='+ Incidental Charges @  % :';
						}
						$html1.='</td>
						<td align="right" style="border: 1px solid black;border-left: 0px solid black;vertical-align:top;">'.$custhelp->numberFormate($total).' <br/>';
						if($outgoing_invoice_excise->discount > 0){
                        $html1.=''.$custhelp->numberFormate($outgoing_invoice_excise->discount).'<br/>';
						}
						if($ed_total > 0){
						 $html1.=''.$custhelp->numberFormate($ed_total).'<br/>';
						}
						if($edu_total > 0){
                        $html1.=''.$custhelp->numberFormate($edu_total).'<br/>';
						}
						if($cvd_total > 0){
                        $html1.=''.$custhelp->numberFormate($cvd_total).'<br/>';
						}
						if($outgoing_invoice_excise->pf_chrg > 0){
                        $html1.=''.$custhelp->numberFormate($outgoing_invoice_excise->pf_chrg).'<br/>';
						}
						if($outgoing_invoice_excise->incidental_chrg > 0){
                        $html1.=''.$custhelp->numberFormate($outgoing_invoice_excise->incidental_chrg).' ';
						}
						
						$html1.='</td>
					<td colspan="2" style="border: 1px solid black;border: 1px solid black;">				
						<table>
							<tr>
								<td style="vertical-align:top; padding-right:20px;"><p>'.$custhelp->numberFormate($ed_total).'</p></td>
								<td><p style="">Excise Duty Amount (RS.) '.$custhelp->number_to_words($ed_total).' only</p></td>
							</tr>
						</table>
						<p>Rate OF duty In Word : '.$custhelp->number_to_words(floor($ed_rate)).' &nbsp;&nbsp;&nbsp;EDU CESS '.round($edu_cess).'% : '.$edu_cess.' </p>
						<p>Higher EDU Cess '.round($hdu_cess).'%  : '.$hdu_cess.'</p>
					</td>
				</tr>
				<tr>					
					<td style="border: 1px solid black;border-right: 0px solid black">Taxable Amount :<br/>';
					if(!empty($vatcstdesc) || $vatcstdesc != '' ){
						$html1.='+'.$vatcstdesc.'<br/>';
					}
					if(!empty($SURCHARGE_DESC) || $SURCHARGE_DESC != ''){
                        $html1.='+ '.$SURCHARGE_DESC.'<br/>';
						}
						if($outgoing_invoice_excise->freight_amount > 0){
                       $html1.='+ '.$outgoing_invoice_excise->freight_percent.'<br/>'; 
						}$html1.='</td>
						
						<td style="border: 1px solid black;border-left: 0px solid black;" align="right">'.$custhelp->numberFormate(($total - $outgoing_invoice_excise->discount + $edu_total +$cvd_total +$ed_total )).'<br/>';
						if(!empty($vatcstdesc) || $vatcstdesc != '' ){
							$vtcst = ((($total - $outgoing_invoice_excise->discount + $edu_total +$cvd_total +$ed_total ) * $saleTax)/100);
							$html1.=''.$custhelp->numberFormate(sprintf ("%.2f",((($total - $outgoing_invoice_excise->discount + $edu_total +$cvd_total +$ed_total ) * $saleTax)/100))).'<br/>';
						}
						if(!empty($SURCHARGE_DESC) || $SURCHARGE_DESC != ''){
						$vtcstCharge = $custhelp->numberFormate(sprintf ("%.2f",((((($total - $outgoing_invoice_excise->discount + $edu_total +$cvd_total +$ed_total ) * $saleTax)/100) * $surcharge)/100)));
						
                        $html1.=''.$custhelp->numberFormate(sprintf ("%.2f",((((($total - $outgoing_invoice_excise->discount + $edu_total +$cvd_total +$ed_total ) * $saleTax)/100) * $surcharge)/100))).'<br/>';
						}
						if($outgoing_invoice_excise->freight_amount > 0){
							$html1.=''.$custhelp->numberFormate($outgoing_invoice_excise->freight_amount).''; 
						}$html1.='</td>
					<td rowspan="4" style="border: 1px solid black;">   Name & Address of Manufacturer<br />
                    '.$poprincipal[0]->_principal_supplier_name.'<br />
					'.$poprincipal[0]->_add1.', '.$poprincipal[0]->_add2.' ,  '.$poprincipal[0]->_city_name.'
					,'.$poprincipal[0]->_state_name.' </td>
					<td  rowspan="4" style="border: 1px solid black;"> '.$CompanyInfo["txt5"].'<br /><br />
                    '.$CompanyInfo["txt6"].'</td>		
					
				</tr>
				<tr >	
					<td style="border: 1px solid black;border-right: 0px solid black">Total Amount :<br/>Round Off : </td>					
					<td style="border: 1px solid black;border-left: 0px solid black;" align="right">'.$custhelp->numberFormate(sprintf ("%.2f",($total - $outgoing_invoice_excise->discount + $edu_total +$cvd_total +$ed_total+$vtcst+$vtcstCharge ))).'<br/>';
					$tmpVr = ($total - $outgoing_invoice_excise->discount + $edu_total +$cvd_total +$ed_total + $vtcst + $vtcstCharge );
										
					$r_tmpVr = round ($tmpVr);
					if($r_tmpVr > $tmpVr){
						$round = '+'.sprintf ("%.2f",($r_tmpVr-$tmpVr));
					}else{						
						$round = '-'.sprintf ("%.2f",($tmpVr-$r_tmpVr));
					}
					 $html1.=''.$round.'</td>						
				</tr>
				<tr>		
					<td style="border: 1px solid black;border-right: 0px solid black">Total Payable Amount :</td>					
					<td style="border: 1px solid black;border-left: 0px solid black;">'.$custhelp->numberFormate($r_tmpVr ).'</td>					
				</tr>
				<tr>		
					<td colspan="3" style="border: 1px solid black;">Grand Total(Rs.)  '.$custhelp->number_to_words(round($outgoing_invoice_excise->bill_value)).' Only</td>
					
				</tr>
				 
			</tbody>
		</table>';
		
       
   

$html1.='<br/>
<table width="99%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td style="width: 59%;">'.$CompanyInfo["txt7"].':</td>
		<td style="width: 40%;" align="right">for, <span>'.$CompanyInfo["Name"].'</span></td>
	</tr>
	<tr>
		<td class="exc_bdr_left_rght" colspan="2">'.$CompanyInfo["txt8"].' &nbsp; &nbsp; &nbsp; &nbsp;</td>
	</tr>
	<tr>
		<td class="exc_bdr_left_rght" colspan="2">'.$CompanyInfo["txt9"].'  <br/>'.$poprincipal[0]->_principal_supplier_name.' , '.$poprincipal[0]->_add1.', '.$poprincipal[0]->_add2.' ,  '.$poprincipal[0]->_city_name.','.$poprincipal[0]->_state_name.'</td>
	</tr>

	<tr>
		<td style="width: 59%;">'.$CompanyInfo["txt10"].'</td>
		<td style="width: 40%;" align="right">PLACE &nbsp; &nbsp; : '.$CompanyInfo["PLACE"].'. DATE &nbsp; '.$outgoing_invoice_excise->oinv_date.'</td>
	</tr>
</table>

</div>
</div>
';
}
echo "</div></div>";

$mpdf->SetHTMLHeader($header);
$mpdf->SetHTMLHeader($headerE,'E');
$mpdf->SetHTMLFooter($footer);
$mpdf->SetHTMLFooter($footerE,'E');

$html = $html1;
$mpdf->WriteHTML($html);
//$mpdf->Output();
//exit;
$mpdf->Output('pdf/invoices/'.$filename.'.pdf', 'F');
return;
}
?>
