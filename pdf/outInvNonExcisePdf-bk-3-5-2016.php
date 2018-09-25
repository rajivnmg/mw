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
include_once( $root_path."Model/Business_Action_Model/po_model.php");
include_once( $root_path."Model/Masters/BuyerMaster_Model.php");
include_once($root_path."Model/Param/param_model.php");

//outInvNonExPDF(6414);

function outInvNonExPDF($oinvoice_exciseID){
$CompanyInfo = ParamModel::GetCompanyInfo();
$param = new ParamModel();
$challanItem = array();
//$oinvoice_exciseID =4670;6408,6401,6403 // $_REQUEST['OutgoingInvoiceNonExciseNum'];
$Print = Outgoing_Invoice_NonExcise_Model::LoadOutgoingInvoiceNonExcise($oinvoice_exciseID);
$custhelp = new CustomHelper();

$mpdf=new mPDF('c','A4','','',10,10,10,10,10,10); 

$mpdf->mirrorMargins = 1;	// Use different Odd/Even headers and footers and mirror margins

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

foreach($Print as $OutgoingInvoiceNonExciseNum1){
foreach($OutgoingInvoiceNonExciseNum1->_itmes as $row_value1) {
			$vatcst1 = $param->GetVATCSTBYId($row_value1->saletaxID);
			$type = $vatcst1['TYPE'];
			break;
		}
		break;
}
$htmlHED='';
$htmlFooter = '';
foreach($Print as $OutgoingInvoiceNonExciseNum2){
$buyer1 = BuyerMaster_Model::LoadBuyerDetails($OutgoingInvoiceNonExciseNum2->BuyerID,"A",null,null);
 $htmlFooter.='<div style="margin:auto; height:auto;">
   <table width="100%" border="0" cellpadding="0" cellspacing="0"  style="color: #000;">
        <tr>
            <td rowspan="4" style=" border-right:1px solid #2c2c2c; border-left:1px solid #2c2c2c; padding-left:5px; font-weight: bold; color: #000; width:260px;" >TIN NO. : '.$buyer1[0]->_tin.'</td>
            <td class="tin_two" style="border-bottom:1px solid #2c2c2c;  padding:5px;">
                <div style=" font-weight: bold; color: #000;">Total Amount</div>';
				if($OutgoingInvoiceNonExciseNum2->discount > 0){
					$htmlFooter.='<div id="discountdetails">- Discount @  %</div>';
					$total1 = $total-$OutgoingInvoiceNonExciseNum2->discount;
				  }
				if($OutgoingInvoiceNonExciseNum2->pf_chrg > 0){
						$htmlFooter.='<div id="pfblog">+ P&F Charge @  %</div>';
				}
				if($OutgoingInvoiceNonExciseNum2->incidental_chrg > 0){
                 $htmlFooter.=' <div id="inciblog">Incidental Charge @  %</div>';
				}
              $htmlFooter.='</td>
            <td style="border-bottom:1px solid #2c2c2c; border-right:1px solid #2c2c2c;padding-left:90px;">
                <div style="font-weight: bold; color: #000;" >'.$total.'</div>';
				if($OutgoingInvoiceNonExciseNum2->discount > 0){
					$htmlFooter.='<div id="discountdetails2"></div>';
				}
				if($OutgoingInvoiceNonExciseNum2->pf_chrg > 0){
					  $htmlFooter.='<div id="pfblog2"></div>';
				}
				if($OutgoingInvoiceNonExciseNum2->incidental_chrg > 0){
					 $htmlFooter.='<div id="inciblog2"></div>';
				}
        $htmlFooter.='</td>
        </tr>
        <tr>
            <td style="border-bottom:1px solid #2c2c2c; padding-left:5px;">Taxable Amount</td>
            <td style="border-bottom:1px solid #2c2c2c; border-right:1px solid #2c2c2c; padding-left:90px;font-weight: bold; color: #000;">'.round($taxable_amt,2).'</td>
        </tr>
        <tr>
            <td style="border-bottom:1px solid #2c2c2c; padding:5px;">';
			if($OutgoingInvoiceNonExciseNum2->po_saleTax > 0){
				 $htmlFooter.=' <div>+'.$vatcstdesc.'</div>';
				 if($vatcstdes != ''){
					$htmlFooter.='<div id="surchargeblog">+ '.$vatcstdes.'</div>';
				  }
		
			}
			if($OutgoingInvoiceNonExciseNum2->freight_amount > 0){
				 $htmlFooter.='<div id="ferightblog">+ Freight  </div>';
			}
			
                
               
              $htmlFooter.='</td>
            <td class="tin_three" style="border-bottom:1px solid #2c2c2c; border-right:1px solid #2c2c2c; padding-left:90px;">';
			if($OutgoingInvoiceNonExciseNum2->po_saleTax > 0){
				 $htmlFooter.='<div></div>';
                  $htmlFooter.='<div id="surchargeblog2"></div>';
			}
			if($OutgoingInvoiceNonExciseNum2->freight_amount > 0){
				  $htmlFooter.=' <div id="ferightblog2"></div>';
			}             
               
             $htmlFooter.='</td>
        </tr>
        <tr>
            <td style="padding-left:5px; font-weight: bold; color: #000;">Total Payable Amount</td>
            <td style=" border-right:1px solid #2c2c2c; font-weight: bold; color: #000;padding-left:90px;"></td>
        </tr>
        <tr>
            <td colspan="3" style="border-bottom: 1px solid #2c2c2c; border-right:1px solid #2c2c2c;border-top: 1px solid #2c2c2c; border-left:1px solid #2c2c2c; padding:5px; font-weight: bold; color: #000;">Rupees:  Only</td>

        </tr>

    </table>
   
    </div>

    <div style="padding-top:15px;">
        <table width="100%" border="0" cellpadding="0" cellspacing="0" style=" height: 100px; color: #000;" >
        <tr>
            <td>1. All disputes are Subject to Gurgaon Jurisdiction.</td>
            <td style=" font-weight: bold; color: #000;"><strong>for, Multiweld Engineering Pvt. Ltd.</strong></td>
        </tr>

        <tr>
            <td >2. Our responsibility ceases on delivery of goods.</td>
            <td >&nbsp;</td>
        </tr>
        <tr>
            <td>3. All Taxes extra, as applicable at the time of supply.</td>
            <td >&nbsp;</td>
        </tr>
        <tr>
            <td>4. Interest @ 24% per annum will be charged after due date.</td>
            <td >&nbsp;</td>
        </tr>
		 <tr>
            <td colspan="2" class="auth" height="20px"></td>
        </tr>
        
    </table>   
  </div>';

}


$filename ='';
$html1 ='';
$html2 ='';
$htmlHED.='<div id="main">

    <div style="width: 100%; height: 150px; border: 0px solid #000;">
        <div style="width: 68%; height: 150px; float: left;">
            <div style="height:120px;">
					<div style="width: 50%; padding-top: 60px; float: left;">                    
                    TIN 06911916320</div>';
                $htmlHED.="";
				if($type == "C"){
                   $htmlHED.="<div style='height:20px;' align='center'>                       
								<span id='cst_invoice'>RETAIL INVOICE</span>
							</div>";
				}else{
					$htmlHED.="<div style='height:20px;' align='center'>
								<span>TAX  &nbsp;INVOICE</span><br/> <span>VALID &nbsp;FOR &nbsp;INPUT TAX</span>
							</div>
					";
					
				}
				
			 $htmlHED.='
                
            </div>
            <div><span style="color: #000; font-weight: bolder; font-size: 20px; ">MULTIWELD ENGINEERING PVT. LTD.</span></div>
        </div>
        <div style="width: 32%;height: 160px; float: right; font-size: 14px;">
            <div style="height:55px;"><span>COPY</span></div>
			  '.wordwrap($CompanyInfo["Address"], 30, "<br />\n").' <br/>
			 '.$CompanyInfo["email"].'  <br/>
			 '.$CompanyInfo["Website"].'
            
        </div>
       
    </div>';
		foreach($Print as $OutgoingInvoiceNonExciseNum){
			$pod = Purchaseorder_Model::LoadPurchaseByID($OutgoingInvoiceNonExciseNum->pono,'N');
			//print_r($pod[0]->bn_name); exit;			
			//$poprincipal = purchaseorder_Details_Model::LoadPrincipal($OutgoingInvoiceNonExciseNum->pono,'N');

			$buyer = BuyerMaster_Model::LoadBuyerDetails($OutgoingInvoiceNonExciseNum->BuyerID,"A",null,null);
			
			$filename = $OutgoingInvoiceNonExciseNum->oinvoice_No;
    $htmlHED.='<div>

        <table style="width: 100%; border:1px solid #4a4a4a;" cellpadding="0" cellspacing="0">
        <tr >
			<td rowspan="3" style="width:50%;border-right: 1px solid #4a4a4a; "><span>To, <br />
				M/s &nbsp; '.$buyer[0]->_buyer_name.'</span><br />
				'.$buyer[0]->_bill_add1.','.$buyer[0]->_bill_add2.'</td>
			<td height="50"><span>Tax Invoice No. : '.$OutgoingInvoiceNonExciseNum->oinvoice_No.'</span></td>
			<td ><span>Date </span> : '.$OutgoingInvoiceNonExciseNum->oinv_date.'</td>
		</tr>
        <tr>
			<td height="50"> <span>Order No.</span> : '.$pod[0]->pon.'</td>
			<td><span>Date </span> : '.$pod[0]->pod.'</td>
        </tr>

        <tr>
			<td><span>Through </span> : '.$OutgoingInvoiceNonExciseNum->mod_delivery_text.'</td>
			<td>&nbsp;</td>
       </tr>
    </table>
   
    </div>

	 <div>
    <table style="width: 100%; border:1px solid #4a4a4a;" cellpadding="0" cellspacing="0"><thead>
        <tr style=" border-right:1px solid #2c2c2c; border-left:1px solid #2c2c2c; padding-left:5px; font-weight: bold; color: #000;">
			<th style="width:10%;border-bottom:1px solid #2c2c2c;" height="40">S.No.</th>
			<th style="width:25%;border-left:1px solid #2c2c2c;border-bottom:1px solid #2c2c2c;">Customer Item Code</th>
			<th style="width:20%;border-left:1px solid #2c2c2c;border-bottom:1px solid #2c2c2c;">DESCRIPTION</th>
			<th style="width:15%;border-left:1px solid #2c2c2c;border-bottom:1px solid #2c2c2c;">QTY</th>
			<th style="width:20%;border-left:1px solid #2c2c2c;border-bottom:1px solid #2c2c2c;">RATE</th>
			<th style="width:20%;border-left:1px solid #2c2c2c;border-bottom:1px solid #2c2c2c;">AMOUNT</th>
            
        </tr></thead><tbody>';
		$i1=1;
		$total = 0;
		$vatcstdesc ='';
		$vatcstdes = '';
		$SALESTAX_CHRG =0;
		$vatcstchrg = 0;
		//print_r($OutgoingInvoiceNonExciseNum->_itmes[0]->oinv_codePartNo); exit;
		foreach($OutgoingInvoiceNonExciseNum->_itmes as $row_value) {
			$total = $total + $row_value->item_amount;
			//print_r($row_value->oinv_codePartNo); exit;
			$vatcst = $param->GetVATCSTBYId($row_value->saletaxID);
			
			
			$vatcstdesc = $vatcst['SALESTAX_DESC'];
			if($vatcst['TYPE'] =="V" || $vatcst['TYPE'] =="C"){
				$vatcstdes = $vatcst['SURCHARGE_DESC'];
				$vatcstchrg = $vatcst['SURCHARGE'];
				$SALESTAX_CHRG = $vatcst['SALESTAX_CHRG'];
				
				
			}
			$htmlPage.=' <tr style=" border-right:1px solid #2c2c2c; border-left:1px solid #2c2c2c;font-weight: bold; color: #000;">
				<td style="padding-left:20px;" height="50">'.$i1.'</td>
				<td style="padding-left:20px;border-left:1px solid #2c2c2c;">'.$row_value->buyer_item_code.'</td>
				<td style="padding-left:20px;border-left:1px solid #2c2c2c;">'.$row_value->codePartNo_desc.'('.$row_value->oinv_codePartNo.')</td>
				<td style="padding-left:30px;border-left:1px solid #2c2c2c;">'.$row_value->issued_qty.'</td>
				<td style="padding-left:40px;border-left:1px solid #2c2c2c;">'.$row_value->oinv_price.'</td>
				<td style="padding-left:40px;border-left:1px solid #2c2c2c;">'.$row_value->item_amount.'</td>
				
			</tr>';
			
			
			
			$totalItems = count($OutgoingInvoiceNonExciseNum->_itmes);
		
	    if(((count($OutgoingInvoiceNonExciseNum->_itmes)  < 8) && ($totalItems == $i1)) || (($totalItems == $i1) && ($totalItems%8 != 0))){
		
			for($k=0; $k < (8-($totalItems%8));$k++ ){
			
				$htmlPage.=' <tr style=" border-right:1px solid #2c2c2c; border-left:1px solid #2c2c2c;font-weight: bold; color: #000;">
				<td style="padding-left:20px;" height="47"></td>
				<td style="padding-left:20px;border-left:1px solid #2c2c2c;"></td>
				<td style="padding-left:20px;border-left:1px solid #2c2c2c;"></td>
				<td style="padding-left:30px;border-left:1px solid #2c2c2c;"></td>
				<td style="padding-left:40px;border-left:1px solid #2c2c2c;"></td>
				<td style="padding-left:40px;border-left:1px solid #2c2c2c;"></td>
				
			</tr>';
			}
		
		}
				
			
			
			
			
		
			if($i1%8 == 0 || $i1 == count($OutgoingInvoiceNonExciseNum->_itmes)) {
				
				$html1 .= $htmlHED. $htmlPage 
						.'</tbody></table>';
				if($i1 != count($OutgoingInvoiceNonExciseNum->_itmes)) {
					$html1 .= $htmlFooter
						. '<div style="page-break-after:always"></div>';
				}	
				
				$htmlPage = "";
			}
			$i1 ++;	
						
		}
		
		
		$taxable_amt = ($total - $OutgoingInvoiceNonExciseNum->discount);
		
		
     $html1.='</tbody></table></div>
    <div style="margin:auto; height:auto;">
   <table width="100%" border="0" cellpadding="0" cellspacing="0"  style="color: #000;">
        <tr>
            <td rowspan="4" style=" border-right:1px solid #2c2c2c; border-left:1px solid #2c2c2c; padding-left:5px; font-weight: bold; color: #000; width:260px;" >TIN NO. : '.$buyer[0]->_tin.'</td>
            <td class="tin_two" style="border-bottom:1px solid #2c2c2c;  padding:5px;">
                <div style=" font-weight: bold; color: #000;">Total Amount</div>';
				if($OutgoingInvoiceNonExciseNum->discount > 0){
					$html1.='<div>- Discount @ '.round((($OutgoingInvoiceNonExciseNum->discount * 100 ) / $total),2).' %</div>';
					$total1 = $total-$OutgoingInvoiceNonExciseNum->discount;
				  }
				if($OutgoingInvoiceNonExciseNum->pf_chrg > 0){
						$html1.='<div>+ P&F Charge @ '.round((($OutgoingInvoiceNonExciseNum->pf_chrg * 100 ) / $total),2).' %</div>';
				}
				if($OutgoingInvoiceNonExciseNum->incidental_chrg > 0){
                 $html1.=' <div>Incidental Charge @ '.round((($OutgoingInvoiceNonExciseNum->incidental_chrg * 100 ) / $total1),2).' %</div>';
				}
              $html1.='</td>
            <td style="border-bottom:1px solid #2c2c2c; border-right:1px solid #2c2c2c;text-align: right;">
                '.$custhelp->numberFormate($total).'<br/>';
				if($OutgoingInvoiceNonExciseNum->discount > 0){
					$html1.=''. $custhelp->numberFormate($OutgoingInvoiceNonExciseNum->discount).'<br/>';
				}
				if($OutgoingInvoiceNonExciseNum->pf_chrg > 0){
					  $html1.=''.$custhelp->numberFormate($OutgoingInvoiceNonExciseNum->pf_chrg).'<br/>';
				}
				if($OutgoingInvoiceNonExciseNum->incidental_chrg > 0){
					 $html1.=''.$custhelp->numberFormate($OutgoingInvoiceNonExciseNum->incidental_chrg).'';
				}
        $html1.='</td>
        </tr>
        <tr>
            <td style="border-bottom:1px solid #2c2c2c;" >Taxable Amount</td>
            <td style="border-bottom:1px solid #2c2c2c; border-right:1px solid #2c2c2c;font-weight: bold; color: #000;text-align: right;">'.$custhelp->numberFormate($taxable_amt).'</td>
        </tr>
        <tr>
            <td style="border-bottom:1px solid #2c2c2c;">';
			if($OutgoingInvoiceNonExciseNum->po_saleTax > 0){
				 $html1.=' <div>+ '.$vatcstdesc.'</div>';
				 if($vatcstdes != '' || !empty($vatcstdes)){
					$html1.='<div id="surchargeblog">+ '.$vatcstdes.'</div>';
				  }
		
			}
			if($OutgoingInvoiceNonExciseNum->freight_amount > 0){
				 $html1.='<div id="ferightblog">+ Freight  '.(($OutgoingInvoiceNonExciseNum->freight_amount * 100 ) / $taxable_amt).'</div>';
			}
			
                
               
              $html1.='</td>
            <td style="border-bottom:1px solid #2c2c2c; border-right:1px solid #2c2c2c;text-align: right;">';
			if($OutgoingInvoiceNonExciseNum->po_saleTax > 0){
				 $html1.=''.$custhelp->numberFormate($OutgoingInvoiceNonExciseNum->po_saleTax).'<br/>';
				  if($vatcstdes != '' || !empty($vatcstdes)){
					 $html1.=''.$custhelp->numberFormate((($OutgoingInvoiceNonExciseNum->po_saleTax)* $vatcstchrg)/100).'';
				  }
                 
			}
			if($OutgoingInvoiceNonExciseNum->freight_amount > 0){
				  $html1.=''.$custhelp->numberFormate($OutgoingInvoiceNonExciseNum->freight_amount).'<br/>';
			}             
               
             $html1.=' </td>
        </tr>
        <tr>
            <td style="padding-left:5px; font-weight: bold; color: #000;">Total Payable Amount</td>
            <td style=" border-right:1px solid #2c2c2c; font-weight: bold; color: #000;text-align: right;">'.$custhelp->numberFormate($OutgoingInvoiceNonExciseNum->bill_value).'</td>
        </tr>
        <tr>
            <td colspan="3" style="border-bottom: 1px solid #2c2c2c; border-right:1px solid #2c2c2c;border-top: 1px solid #2c2c2c; border-left:1px solid #2c2c2c; padding:5px; font-weight: bold; color: #000;">Rupees: '.$custhelp->number_to_words(ceil($OutgoingInvoiceNonExciseNum->bill_value)).' Only</td>

        </tr>

    </table>
   
    </div>

    <div style="padding-top:15px;">
        <table width="100%" border="0" cellpadding="0" cellspacing="0" style=" height: 100px; color: #000;" >
        <tr>
            <td>1. All disputes are Subject to Gurgaon Jurisdiction.</td>
            <td style=" font-weight: bold; color: #000;text-align: right;" >for,<strong> Multiweld Engineering Pvt. Ltd.</strong></td>
        </tr>

        <tr>
            <td >2. Our responsibility ceases on delivery of goods.</td>
            <td >&nbsp;</td>
        </tr>
        <tr>
            <td>3. All Taxes extra, as applicable at the time of supply.</td>
            <td >&nbsp;</td>
        </tr>
        <tr>
            <td>4. Interest @ 24% per annum will be charged after due date.</td>
            <td >&nbsp;</td>
        </tr>
		 <tr>
            <td colspan="2" class="auth" height="20px"></td>
        </tr>
        
    </table>   
  </div>
 </div>

';
}

$mpdf->SetHTMLHeader($header);
$mpdf->SetHTMLHeader($headerE,'E');
$mpdf->SetHTMLFooter($footer);
$mpdf->SetHTMLFooter($footerE,'E');
$html = $html.$html1;
$mpdf->WriteHTML($html);
//$mpdf->Output();
//exit;
$mpdf->Output('pdf/invoices/'.$filename.'.pdf', 'F');
return;
}

?>
