<?php
if (!function_exists("mb_check_encoding")) {
    die('mbstring extension is not enabled');
}

include_once("mpdf60/mpdf.php");
include_once "config.php";
include_once "generate.php";
include_once "root.php";

include_once( $root_path."Model/DBModel/DbModel.php");
include_once( $root_path."Model/Business_Action_Model/po_model.php");
include_once( $root_path."Model/Masters/BuyerMaster_Model.php");
include_once($root_path."Model/Param/param_model.php");

$CompanyInfo = ParamModel::GetCompanyInfo();
$param = new ParamModel();
$challanItem = array();
$txtType='';
$htmlHED='';
$htmlFooter='';

session_start();



$mpdf=new mPDF('c','A4','','',10,10,20,10,10,10); 

$mpdf->mirrorMargins = 1;	// Use different Odd/Even headers and footers and mirror margins
$header='<div style="  font-weight: bold; color: #000;" align="center">		
			<table width="100%">
			<tr>
				<td width="100%" align="center">PICK LIST</td>
			</tr>
			</table>			
		</div>';
$headerE='<div style="  font-weight: bold; color: #000;" align="center">		
			<table width="100%">
			<tr>
				<td width="100%" align="center">PICK LIST</td>
			</tr>
			</table>
			
		</div>';
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
$htmlFooter=' <div style="padding-top:15px;">
			<table width="100%" border="0" cellpadding="0" cellspacing="0" style=" height: 100px; color: #000;" >
				<tr>
					<td></td>
					<td style=" font-weight: bold; color: #000;" align="right"><strong>for, Multiweld Engineering Pvt. Ltd.</strong></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td style=" font-weight: bold; color: #000;" align="right">&nbsp;</td>
				</tr>

			<tr>
					<td></td>
					<td align="right">'.$_SESSION['USER_NAME'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				</tr>
				
				
			</table>   
		</div>';
		$buyer = BuyerMaster_Model::LoadBuyerDetails($_POST['buyerIDs'],"A",null,null);
		$pod = Purchaseorder_Model::LoadPurchaseByID($_POST['poID'],'N');
		
		$htmlHED.='<div>

        <table style="width: 100%; border:1px solid #4a4a4a;" cellpadding="0" cellspacing="0">
        <tr >
			<td rowspan="2" style="width:50%;border-right: 1px solid #4a4a4a; "><span>To, <br />
				M/s &nbsp; '.$buyer[0]->_buyer_name.'</span><br />
				'.$buyer[0]->_bill_add1.','.$buyer[0]->_bill_add2.'</td>
			<td height="50"><span>Pick List Date : '.date("d/m/Y").'</span></td>
			<td ><span> </span> </td>
		</tr>
        <tr>
			<td height="50"> <span>Order No.</span> : '.$pod[0]->pon.'</td>
			<td><span>Date </span> : '.$pod[0]->pod.'</td>
        </tr>

    </table>   
     <div>
    <table style="width: 100%; border:1px solid #4a4a4a;" cellpadding="0" cellspacing="0"><thead>
        <tr style=" border-right:1px solid #2c2c2c; border-left:1px solid #2c2c2c; padding-left:5px; font-weight: bold; color: #000;">
			<th style="width:10%;border-bottom:1px solid #2c2c2c;" height="40">S.NO.</th>	
			<th style="width:25%;border-left:1px solid #2c2c2c;border-bottom:1px solid #2c2c2c;">ITEM CODEPART</th>		
			<th style="width:20%;border-left:1px solid #2c2c2c;border-bottom:1px solid #2c2c2c;">DESCRIPTION</th>
			<th style="width:15%;border-left:1px solid #2c2c2c;border-bottom:1px solid #2c2c2c;">REQUIRED QTY</th>
			<th style="width:20%;border-left:1px solid #2c2c2c;border-bottom:1px solid #2c2c2c;">PICKED QTY</th>
			   
        </tr></thead><tbody>';
		$i=0;
		$totalItems = $_POST['totalCount'];
		$totalQty = 0;
	
	for($i=1; $i<= $totalItems ; $i++){
		
			if(isset($_POST['checkbox'.$i]) && $_POST['checkbox'.$i] == $i ){
				
			$htmlPage.=' <tr style="border-right:1px solid #2c2c2c; border-left:1px solid #2c2c2c;font-weight: bold; color: #000;">
				<td style="padding-left:20px;" height="50">'.$i.'</td>
				<td style="padding-left:20px;border-left:1px solid #2c2c2c;">'.$_POST['Item_Code_Partno'.$i].'</td>
				<td style="padding-left:20px;border-left:1px solid #2c2c2c;">'.$_POST['Item_Desc'.$i].'</td>
				<td style="padding-left:30px;border-left:1px solid #2c2c2c;">'.$_POST['OrderQty'.$i].'</td>				
				<td style="padding-left:40px;border-left:1px solid #2c2c2c;">'.$_POST['pickQty'.$i].'</td>
				
			</tr>';
		$totalQty = $totalQty + $_POST['pickQty'.$i];
			
			}				
	  
		
		}
		 if(($totalItems < 13)){
		
			for($k=0; $k < (13-($totalItems));$k++ ){
			
				$htmlPage.=' <tr style=" border-right:1px solid #2c2c2c; border-left:1px solid #2c2c2c;font-weight: bold; color: #000;">
				<td style="padding-left:20px;" height="47"></td>
				<td style="padding-left:20px;border-left:1px solid #2c2c2c;"></td>
				<td style="padding-left:20px;border-left:1px solid #2c2c2c;"></td>
				<td style="padding-left:30px;border-left:1px solid #2c2c2c;"></td>
				<td style="padding-left:40px;border-left:1px solid #2c2c2c;"></td>				
			</tr>';
			}
		
		}			
     $htmlPage.='
     <tr style="border-right:1px solid #2c2c2c;border-right:1px solid #2c2c2c; border-left:1px solid #2c2c2c;font-weight: bold; color: #000;">
			<td colspan="4" style="border-top:1px solid #2c2c2c;" height="40" align="right"><strong>TOTAL QTY&nbsp;&nbsp;&nbsp;</strong></td>
			<td style="border-left:1px solid #2c2c2c;border-top:1px solid #2c2c2c" align="center"><strong>'.$totalQty.'</strong></td>
	</tr>   
     </tbody></table></div>'; 
    

$mpdf->SetHTMLHeader($header);
$mpdf->SetHTMLHeader($headerE,'E');
$mpdf->SetHTMLFooter($footer);
$mpdf->SetHTMLFooter($footerE,'E');
$html = $htmlHED.$htmlPage.$htmlFooter;

$mpdf->WriteHTML($html);
$mpdf->Output();
return;
