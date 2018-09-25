<?php
include("mpdf60/mpdf.php");
include "config.php";
include "generate.php";
$dir  = scandir("images");
include "../Model/DBModel/DbModel.php";
include_once( "../Model/Business_Action_Model/Quation_Model.php");
session_start();
$challanItem = array();
$Print = Quotation_Model::LoadQuotation($_GET['QUOTATIONNUMBER'],0,0,null,null);
//$challanItem = json_encode($Print); 

//define ("SITE_URL", "http://192.168.1.121/multiGurgaonNew/View");
$dir = "images";

$mpdf=new mPDF('c','A4','','',15,15,47,47,10,10); 

$mpdf->mirrorMargins = 1;	// Use different Odd/Even headers and footers and mirror margins

$header = '<table width="100%">		
			<tr>
				<td colspan="2" style="border:none; padding:0;">
				   <img src="images/qthead_'.trim($_SESSION['SITENAME']).'.png" style="width:100% !important;"/>
				</td>			
			</tr>
		</table>';
$headerE = '<table width="100%" style="border-bottom: 1px solid #000000; vertical-align: bottom;font-family: serif; font-size: 9pt; color: #000088;">
				<tr>
					<td colspan="2">
					 <img src="images/qthead_'.trim($_SESSION['SITENAME']).'.png" style="width:100% !important;"/>
					</td>
				</tr>
			</table>';

$footer = '<table width="100%">
	<tr>
		<td align="center" style="border:none;">
		<img src="images/footer.jpg" style="width:100% !important;"/>
		</td>
	</tr>
</table>
';
$footerE = '<table width="100%" style="border-bottom: 1px solid #000000; vertical-align: bottom; font-family: serif; font-size: 9pt; color: #000088;">
	<tr>
		<td align="center"><img src="images/footer.png"/></td>
	</tr></table>
';



/* $html ='<style>
.bgimage {  
	background-image-resolution: 280dpi;
	background: transparent url(../images/Qbg.png) no-repeat scroll center center;	
}
</style>'; */
$html1 ='';
$html2 ='';

foreach($Print as $quot) {

	
	$html1.='<div class="bgimage">
	<table style="table-layout:fixed; width:100%; border-collapse: collapse; border:none;">
        <tr>
        <td colspan="2" align="center"><strong><u>QUOTATION</u><strong></td> 
        </tr>
		
        <tr>
        <td style="width:450px;"><span >Our Ref: '.$quot->_quotation_no.'<!--  MW/QTN/13099 --></span></td>
        <td><span>Date: '.$quot->_quotation_date.'<!-- 05/06/2014 --> </span></td>
        
        
        </tr>
<tr>
        <td style="width:450px;"><span >Your Ref: '.$quot->_coustomer_ref_no.'<!--  MW/QTN/13099 --></span></td>
        <td ><span>Ref Date: '.$quot->_coustomer_ref_date.'<!-- 05/06/2014 --> </span></td>
        </tr>
        <tr>
        <td><span>M/S '.$quot->_coustomer_name.' <br />'.$quot->_coustomer_add.' </span></td>
        <td>&nbsp;</td>
        </tr>

        <tr>
        <td><span><u>Kind attention: '.$quot->_contact_persone.'<!--  Nawanshu Dwivedi --></u></span></td>
        <td>&nbsp;</td>
        </tr>

        <tr>
        <td>Dear Sir/Madam,</td>
        <td>&nbsp;</td>
        </tr>
        <tr>
        <td colspan="2">We thank you for your valuable enquiries. We are pleased to offer our rates for the following <span>'.$quot->_principal_name.'</span>  products</td>
        
        </tr>
    </table>
	<br>
	<table style="width: 100%;border:1px solid #aaa; table-layout:fixed; width:100%; border-collapse: collapse; ">
        <tr>
            <th height="35" style="border-right:1px solid #aaa;padding-left:5px;border-bottom:1px solid #aaa;" width="7%">S.No.</th>
            <th style="border-right:1px solid #aaa;padding-left:5px;border-bottom:1px solid #aaa;"width="43%">Material Description </th>
            <th style="border-right:1px solid #aaa;padding-left:5px;border-bottom:1px solid #aaa;"width="10%">Code Part/<br/>HSN Code</th>
            <th style="border-right:1px solid #aaa;padding-left:5px;border-bottom:1px solid #aaa;"width="10%">QTY/MOQ</th>
			<th style="border-right:1px solid #aaa;padding-left:5px;border-bottom:1px solid #aaa;"width="10%">Rate/Unit</th>
			<th style="border-right:1px solid #aaa;padding-left:5px;border-bottom:1px solid #aaa;"width="5%">Discount</th>
			<th style="border-right:1px solid #aaa;padding-left:5px;border-bottom:1px solid #aaa;"width="5%">CGST</th>
			<th style="border-right:1px solid #aaa;padding-left:5px;border-bottom:1px solid #aaa;"width="5%">SGST</th>
			<th style="border-bottom:1px solid #aaa;";width="5%">IGST</th>
        </tr>';
	$i=1;	
	
	
	foreach($quot->_itmes as $item) {
		$html2.='<tr><td height="30" align="center" width="10px" style="border-right:1px solid #aaa;border-bottom:1px solid #aaa;" >'.$i++.'</td>
			<td height="30" style="border-right:1px solid #aaa;padding-left:5px;border-bottom:1px solid #aaa;" >'.$item->_item_descp.'</td>
			<td height="30" style="border-right:1px solid #aaa;padding-left:5px;border-bottom:1px solid #aaa;" >'.$item->_item_code_part_no.'/<br/>'.$item->_hsn_code.'</td>
			<td height="30" align="center" style="border-right:1px solid #aaa;padding-left:5px;border-bottom:1px solid #aaa;">'.$item->_quantity.'</td>
			<td height="30" style="border-right:1px solid #aaa;padding-left:5px;border-bottom:1px solid #aaa;" >'.$item->_price_per_unit.'/'.$item->_unit_name.'</td>
			<td height="30" style="border-right:1px solid #aaa;padding-left:5px;border-bottom:1px solid #aaa;" >'.$item->_item_discount.'</td>
			<td height="30" style="border-right:1px solid #aaa;padding-left:5px;border-bottom:1px solid #aaa;" >'.$item->_cgst_rate.'</td>
			<td height="30" style="border-right:1px solid #aaa;padding-left:5px;border-bottom:1px solid #aaa;" >'.$item->_sgst_rate.'</td>
			<td height="30" align="center" style="border-bottom:1px solid #aaa;">'.$item->_igst_rate.'</td>
		</tr>';
	}
	$html3.='</table>';
	
	$html3.='<br>
	<table style="width: 100%;border:1px solid #aaa; table-layout:fixed; width:100%; border-collapse: collapse; ">
        <tr>
            <td colspan="2"><strong><u>Terms & Conditions:</u></strong></td>
        </tr>';
		if($quot->_discount > 0){
        $html3.='<tr id="show_print_discount" style="display:none;">
            <td >Discount</td>
            <td>:'.$quot->_discount.' %<!--  VAT @ 4% against From DI & surcharge on VAT @ 5% --></td>
        </tr>'; 
		}if(!empty($quot->sale_tax_text)){
        $html3.='<tr id="show_print_saletax" style="display:none;">
            <td>Sales Tax</td>
            <td>'.$quot->sale_tax_text.'<!--  VAT @ 4% against From DI & surcharge on VAT @ 5% --></td>
        </tr>';
		}
		if(!empty($quot->edu_text)){
        $html3.='<tr id="show_print_edu" style="display:none;">
            <td>Excise Duty & EDU. Cess</td>
            <td>'.$quot->edu_text.' <!-- Inclusive --></td>
        </tr>';
		}
		if(!empty($quot->Delivery_text)){
        $html3.='<tr id="show_print_delivery" style="display:none;">
            <td>Delivery</td>
            <td>'.$quot->Delivery_text.' <!-- Ex-Stock/Within 07-15 Days --></td>
        </tr>';
		}
		if(!empty($quot->_credit_period)){
			if(is_numeric($quot->_credit_period)){
				$html3.='<tr id="show_print_payment" style="display:none;">
							<td >Payment</td>
							<td>Within '.$quot->_credit_period.' Days</td>
						</tr>';
			}else{			
				$html3.='<tr id="show_print_payment" style="display:none;">
							<td >Payment</td>
							<td>: '.$quot->_credit_period.'</td>
						</tr>';
			}
		}
		if(!empty($quot->frgp)){
        $html3.='<tr id="ifrgp" style="display:none;">
            <td >Freight</td>
            <td>'.$quot->frgp.' %</td>
        </tr>';
		}
		if(!empty($quot->frga)){
        $html3.='<tr id="ifrga" style="display:none;">
            <td>Freight</td>
            <td>'.$quot->frga.' INR.</td>
        </tr>';
		}
		if((!empty($quot->_incidental_chrg))&&($quot->_incidental_chrg > 0)){
        $html3.='<tr id="show_print_incidental" style="display:none;">
            <td >Incidental Charges</td>
            <td>'.$quot->_incidental_chrg.' %</td>
        </tr>';
		}
		if((!empty($quot->_pnf))&&($quot->_pnf > 0)){
        $html3.='<tr id="show_print_pnf" style="display:none;">
            <td >P&F charges</td>
            <td>'.$quot->_pnf.' %</td>
        </tr>';
		}
		if((!empty($quot->_ins))&&($quot->_ins > 0)){
        $html3.='<tr id="show_print_ins" style="display:none;">
            <td >Insurance charges</td>
            <td>'.$quot->_ins.' %</td>
        </tr>';
		}
		if((!empty($quot->_othc))&&($quot->_othc > 0)){
        $html3.='<tr id="show_print_othc" style="display:none;">
            <td >Other charges</td>
            <td>'.$quot->_othc.' %</td>
        </tr>';
		}
		if(!empty($quot->_cvd)){
        $html3.='<tr id="show_print_cvd" style="display:none;">
            <td>Cvd Charge</td>
            <td>'.$quot->_cvd.' %</td>
        </tr>';
		}
        if(!empty($quot->_remarks)){
		$html3.='<tr>
			<td>Remarks</td>
            <td>'.$quot->_remarks.'</td>           
        </tr>';
		}
		$html3.='<tr>
            <td colspan="2">We look forward to receive your valuable orders.</td>           
        </tr><tr>
            <td colspan="2">Thanking You, <br /> Yours faithfully <br /> For Multiweld Engineering Pvt. Ltd.</td>           
        </tr>
		<tr>
            <td colspan="2" style="padding-top:10px; margin-right:20px;">'.strtoupper($quot->cuserId).'</td>           
        </tr>
		
    </table></div>';
	break;
}
$stylesheet = file_get_contents("style.css");
$mpdf -> WriteHTML($stylesheet,1);
$mpdf->SetHTMLHeader($header);
$mpdf->SetHTMLHeader($headerE,'E');
$mpdf->SetHTMLFooter($footer);
$mpdf->SetHTMLFooter($footerE,'E');
$html = $html.$html1.$html2.$html3;
$mpdf->WriteHTML($html);
$mpdf->Output();
exit;

?>
