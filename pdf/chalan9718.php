<?php
if (!function_exists("mb_check_encoding")) {
    die('mbstring extension is not enabled');
}
ini_set('max_execution_time', 300);
include("mpdf60/mpdf.php");
include "config.php";
include "generate.php";
$dir  = scandir("images");
include "../Model/DBModel/DbModel.php";
include_once("../Model/Business_Action_Model/Challan_Model.php");
$challanItem = array();
$Print = Challan_Model::LoadChallan($_GET['ID']);
//$challanItem = json_encode($Print);
if(session_id() == '') {
	session_start();
}  
$imgname = '';
if($_SESSION['SITENAME'] =='RUDRAPUR'){
	$imgname = 'qthead_RUDRAPUR.png';
}elseif($_SESSION['SITENAME'] =='MANESAR'){
	$imgname = 'qthead_MANESAR.png';
}elseif($_SESSION['SITENAME'] =='HARIDWAR'){
	$imgname = 'qthead_HARIDWAR.png';
}else{
	$imgname = 'qthead_GURGAON.png';
}



//define ("SITE_URL", "http://192.168.1.121/multiGurgaonNew/View");
define ("SITE_URL", "http://localhost/multiweld/View");
$dir = "images";

$mpdf=new mPDF('c','A4','','',32,25,47,47,10,10); 

$mpdf->mirrorMargins = 0;	// Use different Odd/Even headers and footers and mirror margins

$header = '
<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 9pt; color: #000088;margin-bottom:5px;">
		<tr>
			<td align="left" style="font-size: 16pt; color: #000088; width:45%;"></td>
			<td align="left" style="font-size: 16pt; color: #000088;">CHALLAN</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>			
		</tr>
		<tr>
			<td colspan="2"><img src="images/'.$imgname.'" /></td>			
		</tr>

</table>
';
$headerE = '
<table width="100%" style="border-bottom: 1px solid #000000; vertical-align: bottom;font-family: serif; font-size: 9pt; color: #000088;margin-bottom:5px;">
		<tr>
			<td align="left" style="font-size: 16pt; color: #000088;width:30%">TIN 06911916320</td>
			<td align="left" style="font-size: 16pt; color: #000088;">CHALLAN</td>
		</tr>
		<tr>
			<td colspan="2"><img src="images/'.$imgname.'" /></td>			
		</tr>
</table>
';

$footer = '<table width="100%" style="border-bottom: 1px solid #000000; vertical-align: bottom; font-family: serif; font-size: 9pt; color: #000088;">
	<tr>
		<td align="center"><img src="../images/footer.png"/></td>
	</tr>
</table>
</div>';
$footerE = '<table width="100%" style="border-bottom: 1px solid #000000; vertical-align: bottom; font-family: serif; font-size: 9pt; color: #000088;">
	<tr>
		<td align="center"><img src="../images/footer.png"/></td>
	</tr></table>
</div>';



$html ='<style>
.bgimage { 
	background-image-resolution: 360dpi;
	background: transparent url(../images/Qbg.png) no-repeat scroll center center;
}
</style>';
$html1 ='';
$html2 ='';

foreach($Print as $chalan) {
	
	$html1.='<div class="bgimage">
<table style="width: 100%; border:1px solid #4a4a4a;margin-top:20px; padding:5px;">
	<tr>
        <td rowspan="3" class="invc_runng_one" style=" border-right: 1px solid #4a4a4a;"><span>To, <br />M/s &nbsp;'.$chalan->_BuyerName.'        
		</span><br /> '.$chalan->_CustAddress.','.$chalan->_bill_add2.'</td>			
      <td class="invc_two invc_runng_one"><span>Challan No. </span>:  '.$chalan->_ChallanNo.'</td>
      <td><span>Date </span> :  '.$chalan->_ChallanDate.'</td>
    </tr>
    <tr>
        <td><span>G.C Note.</span> :'.$chalan->_gc_note.'</td>
        <td><span>Date </span> : '.$chalan->_gc_note_date.'</td>
	</tr>
     <tr>
        <td ><span>Your Order No. </span> : '.$chalan->_gc_note_date.'</td>
        <td><span>Date </span> : '.$chalan->_gc_note_date.'</td>
      </tr>
    </table>
	<table style="width:100%;border:1px solid #4a4a4a;margin-top:20px;" >
	<tr>
        <td style="border-bottom:1px solid #4a4a4a;margin-top:15px;border-right:1px solid #4a4a4a;" height="35" align="center" width="110px">S.No.</td>
		<td style="border-bottom:1px solid #4a4a4a;margin-top:15px;border-right:1px solid #4a4a4a;" height="35" align="center" width="120px">Part No.</td>
		<td style="border-bottom:1px solid #4a4a4a;margin-top:15px;border-right:1px solid #4a4a4a;" height="35" align="center">Description</td>
		<td style="border-bottom:1px solid #4a4a4a;margin-top:15px;" height="35" align="center">Quantity</td>
	</tr>';
	
	foreach($chalan->_items as $item) {
		
	$html2.='<tr><td height="30" align="center" width="110px" style="border-right:1px solid #4a4a4a;" >'.$item->_SrNo.'</td>
		<td height="30" width="120px" style="border-right:1px solid #4a4a4a;padding-left:5px;" >'.$item->_code_part_no.'</td>
		<td height="30" style="border-right:1px solid #4a4a4a;padding-left:5px;" >'.$item->item_desc.'</td>
		<td height="30" align="center">'.$item->_qty.'</td>
	</tr>';
	}	
	$html3.='</table><table width="100%" style="color: #000;">
        <tr>
            <td rowspan="4" style=" border-right:1px solid #2c2c2c;border-bottom:1px solid #2c2c2c; border-left:1px solid #2c2c2c; padding-left:0px; font-weight: bold; color: #000; width:500px;  padding-right:10px; " align="right" height="30">TOTAL </td>         
            <td style="border-bottom:1px solid #2c2c2c; border-right:1px solid #2c2c2c;font-weight: bold;text-align: center;" height="35">
            <div>'.$chalan->_total_Qty.'</div>              
            </td>
        </tr>   
    </table> <table width="100%" style=" min-height:auto; color: #000;">
        <tbody> <tr><td>&nbsp;</td><td>&nbsp;</td></tr>';		
		$html3.='<tr>		
	       <td><b>TIN 06911916320</b></td>
           <td width="60%;" align="right">FOR <strong>MULTIWELD ENGINEERING PVT. LTD.</strong></td>
        </tr> 
		<tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
		
		<tr>
            <td>1. All disputes are Subject to Gurgaon Jurisdiction.</td>
			 <td>&nbsp;</td>
        </tr>

        <tr>
            <td>2. Our responsibility ceases on delivery of goods.</td>
            <td></td>
        </tr>
        <tr>
            <td>3. All Taxes extra, as applicable at the time of supply.</td>
            <td>&nbsp;</td> </tr>     
    </tbody></table></div>';
}

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
