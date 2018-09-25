<?php
if (!function_exists("mb_check_encoding")) {
    die('mbstring extension is not enabled');
}
include("mpdf60/mpdf.php");
include "config.php";
include "generate.php";
$dir  = scandir("images");
include "../Model/DBModel/DbModel.php";
include_once( "../Model/Business_Action_Model/Outgoing_Invoice_NonExcise_Model.php");
include_once( "../Model/Business_Action_Model/Outgoing_Invoice_Excise_Model.php");
$challanItem = array();
 $oinvoice_exciseID =20;// $_REQUEST['OutgoingInvoiceNonExciseNum'];
 $Print = Outgoing_Invoice_NonExcise_Model::LoadOutgoingInvoiceNonExcise($oinvoice_exciseID);
//$challanItem = json_encode($Print); 

define ("SITE_URL", "http://192.168.1.121/multiGurgaonNew/View");
$dir = "images";

$mpdf=new mPDF('c','A4','','',10,10,37,37,10,10); 

$mpdf->mirrorMargins = 1;	// Use different Odd/Even headers and footers and mirror margins

$header = '
<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 9pt; color: #000088;">
		
		<tr>
			<td colspan="2">&nbsp;</td>			
		</tr>
		<tr>
			<td colspan="2"><img src="images/Qthead.png" /></td>			
		</tr>

</table>
';
$headerE = '
<table width="100%" style="border-bottom: 1px solid #000000; vertical-align: bottom;font-family: serif; font-size: 9pt; color: #000088;">
		
		<tr>
			<td colspan="2"><img src="images/Qthead.png" /></td>			
		</tr>
</table>
';

$footer = '<table width="100%" style="border-bottom: 1px solid #000000; vertical-align: bottom; font-family: serif; font-size: 9pt; color: #000088;">
	<tr>
		<td align="center"><img src="images/footer.png"/></td>
	</tr>
</table>
</div>';
$footerE = '<table width="100%" style="border-bottom: 1px solid #000000; vertical-align: bottom; font-family: serif; font-size: 9pt; color: #000088;">
	<tr>
		<td align="center"><img src="images/footer.png"/></td>
	</tr></table>
</div>';



$html ='<style>
.table1 { 
	background-image: -moz-linear-gradient(left, #07cdde 20%, #00f200 ); 
}
.bgimage { 
	background-image-resolution: 280dpi;
	background: transparent url(../images/Qbg.png) repeat scroll left top;
}
</style>';
$html1 ='';
$html2 ='';


	$html1.='<form id="form1" ng-controller="Outgoing_Invoice_NonExcise_Controller" class="smart-green">   
    <div id="main">

<div class="tx_ivc">
<div id="printableArea">
    <div style="width: 100%; height: 150px; border: 0px solid #000;">
        <div style="width: 68%; height: 150px; float: left;">
            <div style="height:120px;">
                <div style="width: 50%; padding-top: 60px; float: left;" class="invc_tp_one invc_runng">
                    
                    TIN 06911916320</div>
                <div style="width: 50%; float: left;" align="center">
                    <div class="invc_tp_hedi" style="height:40px;">
                        <span id="vat_invoice" style="display: none;">TAX INVOICE</span>
                        <span id="cst_invoice" style="display: none;">RETAIL INVOICE</span>
                    </div>
                    <div>
                        <div id="vat_invoice2" class="invc_tp_tw" style="display: none;">VALID FOR INPUT TAX</div>
                    </div>
                </div>
                <div class="clr"></div>
            </div>
            <div><span style=" color: #000; font-weight: bolder; font-size: 20px; ">MULTIWELD ENGINEERING PVT. LTD.</span></div>
        </div>
        <div style="width: 32%;height: 150px; float: left; font-size: 14px;">
            <div class="invc_tp_three invc_runng" style="height:55px;"><span id="invtypetext" ></span></div>
            <div class="invc_tp_three invc_runng">
                B-583A, Sushantlok, Phase-I, <br />
                Gurgaon-122002(Hr.)<br />
                Ph. 4063759, 4377027<br />
                E-Mail : multiweld@vsnl.net<br />
                Website : www.multiweld.net
            </div>
        </div>
        <div class="clr"></div>
    </div>';
		foreach($Print as $OutgoingInvoiceNonExciseNum){
    
    $html1.='<div >

        <table style="width: 100%; height: 120px; border:1px solid #4a4a4a;" cellpadding="0" cellspacing="0">
        <tr>
        <td rowspan="3" class="invc_runng_one" style=" border-right: 1px solid #4a4a4a;"><span>To, <br />
            M/s &nbsp; {{BuyerDetaile._buyer_name}} </span><br />
            {{BuyerDetaile._bill_add1}},{{BuyerDetaile._bill_add2}}<!--,{{BuyerDetaile._location_name}}, {{BuyerDetaile._city_name}}--> </td>
                <td  class="invc_two invc_runng_one"><span>Tax Invoice No. : '.$OutgoingInvoiceNonExciseNum->oinvoice_No.'</span></td>
                <td class="invc_three invc_runng_one"><span>Date </span> : '.$OutgoingInvoiceNonExciseNum->oinv_date.'</td>


        </tr>

        <tr>
        <td class="invc_runng_one"><span>Order No.</span> : {{PODetaile.pon}}</td>
        <td class="invc_runng_one"><span>Date </span> : {{PODetaile.pod}}</td>


        </tr>

        <tr>
        <td class="invc_runng_one"><span>Through </span> : '.$OutgoingInvoiceNonExciseNum->mod_delivery_text.'</td>
        <td class="invc_runng_one">&nbsp;</td>
        </tr>
    </table>
    <div class="clr"></div>
    </div>

	 <div>
    <table width="100%" border="0" cellpadding="0" cellspacing="0"  style="margin:auto;border:1px solid #2c2c2c;border-top:0px solid #2c2c2c;"><thead>
        <tr style=" border-right:1px solid #2c2c2c; border-left:1px solid #2c2c2c; padding-left:5px; font-weight: bold; color: #000;">
			<th>S.No.</th>
			<th>Customer Item Code</th>
			<th>DESCRIPTION</th>
			<th>QTY</th>
			<th>RATE</th>
			<th>AMOUNT</th>
            
        </tr></thead><tbody>';
		
		foreach($OutgoingInvoiceNonExciseNum->_items as $item) {
        $html1.=' <tr style=" border-right:1px solid #2c2c2c; border-left:1px solid #2c2c2c; padding-left:5px; font-weight: bold; color: #000;">
			<td></td>
			<td>'.$item->oinv_codePartNo.'</td>
			<td>'.$item->codePartNo_desc.' '.$item->cpart.'</td>
			<td>'.$item->issued_qty.'</td>
			<td>'.$item->oinv_price.'</td>
			<td>'.$item->item_amount.toFixed(2).'</td>
            
        </tr>';
	}		

     $html1.='</tbody></table>
    <div class="clr"></div>
    </div>
    <div style="margin:auto; height:auto;">
    <table width="100%" border="0" cellpadding="0" cellspacing="0"  style="color: #000;">
        <tr>
            <td rowspan="4" valign="top" class="tin_one" style=" border-right:1px solid #2c2c2c; border-left:1px solid #2c2c2c; padding-left:5px; font-weight: bold; color: #000;">TIN NO. : {{BuyerDetaile._tin}}</td>
            <td class="tin_two" style="border-bottom:1px solid #2c2c2c;  padding:5px;">
                <div style=" font-weight: bold; color: #000;">Total Amount</div>
                <div id="discountdetails">- Discount @ {{BillDetaile.discount_percent}} %</div>
                <div id="pfblog">+ P&F Charge @ {{BillDetaile.pf_percent}} %</div>
                <div id="inciblog">Incidental Charge @ {{BillDetaile.inci_percent}} %</div>
            </td>
            <td class="tin_three" style="border-bottom:1px solid #2c2c2c; border-right:1px solid #2c2c2c;">
                <div>{{BillDetaile.basic_amount.toFixed(2)}}</div>
                <div id="discountdetails2">{{BillDetaile.discount_amt}}</div>
                <div id="pfblog2">{{BillDetaile.pf_amt}}</div>
                <div id="inciblog2">{{BillDetaile.inci_amt}}</div>
            </td>
        </tr>
        <tr>
            <td class="tin_two" style="border-bottom:1px solid #2c2c2c; padding-left:5px;">Taxable Amount</td>
            <td class="tin_three" style="border-bottom:1px solid #2c2c2c; border-right:1px solid #2c2c2c; padding-left:5px;">{{BillDetaile.TaxableAmount}}</td>
        </tr>
        <tr>
            <td class="tin_two" style="border-bottom:1px solid #2c2c2c; padding:5px;">
                <div>+ {{TaxDetaile.SALESTAX_DESC}}</div>
                <div id="surchargeblog">+ {{TaxDetaile.SURCHARGE_DESC}}</div>
                <div id="ferightblog">+ Freight  {{BillDetaile.feright_percent}} </div>
            </td>
            <td class="tin_three" style="border-bottom:1px solid #2c2c2c; border-right:1px solid #2c2c2c; padding-left:5px;">
                <div>{{BillDetaile.SaleTaxAmount}}</div>
                <div id="surchargeblog2">{{BillDetaile.SurchargeAmount}}</div>
                <div id="ferightblog2">{{BillDetaile.feright_amt}}</div>
            </td>
        </tr>
        <tr>
            <td class="tin_two" style="padding-left:5px; font-weight: bold; color: #000;">Total Payable Amount</td>
            <td class="tin_three" style=" border-right:1px solid #2c2c2c; font-weight: bold; color: #000;">'.$OutgoingInvoiceNonExciseNum->bill_value.'</td>
        </tr>
        <tr>
            <td colspan="3" class="tin_fr" style="border-bottom: 1px solid #2c2c2c; border-right:1px solid #2c2c2c; border-left:1px solid #2c2c2c; padding:5px; font-weight: bold; color: #000;">Rupees: '.$OutgoingInvoiceNonExciseNum->toatlvalueinword.' Only</td>

        </tr>

    </table>
    <div class="clr"></div>
    </div>

    <div style="padding-top:5px;">
        <table width="100%" border="0" cellpadding="0" cellspacing="0" style=" height: 110px; color: #000;" >
        <tr>
            <td class="all_txt">1. All disputes are Subject to Gurgaon Jurisdiction.</td>
            <td class="multi" style=" font-weight: bold; color: #000;"><strong>for, Multiweld Engineering Pvt. Ltd.</strong></td>
        </tr>

        <tr>
            <td class="all_txt">2. Our responsibility ceases on delivery of goods.</td>
            <td >&nbsp;</td>
        </tr>
        <tr>
            <td class="all_txt">3. All Taxes extra, as applicable at the time of supply.</td>
            <td >&nbsp;</td>
        </tr>
        <tr>
            <td class="all_txt">4. Interest @ 24% per annum will be charged after due date.</td>
            <td >&nbsp;</td>
        </tr>

        <tr>
            <td colspan="2" class="auth">Authorised Dealers</td>
        </tr>
    </table>
    <div class="clr"></div>
    </div>

    <div>
        <table width="100%" border="0" cellpadding="0" cellspacing="0" style="color: #000;">
        
        <tr>
            <td align="center" style=" font-weight: bold; color: #000;"><strong>OKS</strong></td>
            <td align="center" style=" font-weight: bold; color: #000;"><strong>HENKEL LOCTITE</strong></td>
            <td align="center" style=" font-weight: bold; color: #000;"><strong>FESTO</strong></td>
        </tr>

        <tr>
            <td align="center" >Lubricants</td>
            <td align="center" >Adhesives</td>
            <td align="center" >Pneumatics</td>
        </tr>

    </table>
    <div class="clr"></div>
    </div>
    <div class="regi" style="  font-weight: bold; color: #000;">
        <hr style="border: 1px solid #000;" />
        <span>Registered Office : B3/83A LAWRENCE ROAD, NEW DELHI-35</span>
    </div>
</div>
</div>
</div>';
}
$html1.='</form>';

$mpdf->SetHTMLHeader($header);
$mpdf->SetHTMLHeader($headerE,'E');
$mpdf->SetHTMLFooter($footer);
$mpdf->SetHTMLFooter($footerE,'E');


$html = $html.$html1.$html2.$html3;
//$html = file_get_contents(SITE_URL . "/Business_View/print_challan.php?TYP=SELECT&ID=16");
//$html = str_replace ("%SITE_URL%", SITE_URL, $html);
$mpdf->WriteHTML($html);

$mpdf->Output();
exit;

?>