<?php
if (!function_exists("mb_check_encoding")) {
    die('mbstring extension is not enabled');
}
include("mpdf60/mpdf.php");
include "config.php";
include "generate.php";
$dir  = scandir("images");
include "../Model/DBModel/DbModel.php";
include("../Model/Param/param_model.php");
include_once("../Model/Business_Action_Model/Outgoing_Invoice_NonExcise_Model.php");
include_once("../Model/Business_Action_Model/Outgoing_Invoice_Excise_Model.php");
$challanItem = array();
 $oinvoice_exciseID =12888;// $_REQUEST['OutgoingInvoiceExciseNum'];
 $Print = Outgoing_Invoice_Excise_Model::LoadOutgoingInvoiceExcise($oinvoice_exciseID);
//$challanItem = json_encode($Print); 
$CompanyInfo = ParamModel::GetCompanyInfo();
$mpdf=new mPDF('c','A3','','',10,10,47,47,10,10); 

$mpdf->mirrorMargins = 1;	// Use different Odd/Even headers and footers and mirror margins

/* $header = '
<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 9pt; color: #000088;">
		<tr>
			<td align="left" style="font-size: 16pt; color: #000088; width:45%;">TIN 06911916320</td>
			<td align="left" style="font-size: 16pt; color: #000088;">CHALLAN</td>
		</tr>
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
			<td align="left" style="font-size: 16pt; color: #000088;width:30%">TIN 06911916320</td>
			<td align="left" style="font-size: 16pt; color: #000088;">CHALLAN</td>
		</tr>
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
 */


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

foreach($Print as $outgoing_invoice_excise){
$html1.='<form id="form1" ng-controller="Outgoing_Invoice_Excise_Controller" class="smart-green">
    <div id="printableArea">
		<div id="main">
			<div class="exc_cont">
				<div style="width: 100%; font-size: 15px; font-weight: 700; text-align: center;">
        U/R 11 of CENVAT CREDIT RULES 2002
        <span id="invtypetext" style="float:right;z-index: 999; margin-bottom:-17px;"></span>
				</div>
    <div style="width: 100%; height: 95px; border: 1px solid #000; padding: 2px; font-size: 12px;">
        <div style="float: left; width: 43%; border-right: 1px solid #000;">
            <div style="font-weight: bolder; font-size: 22px;">'.$CompanyInfo["Name"].'</div>
            <div>
                <div style="float: left; width: 75%; text-align: left;">'.$CompanyInfo
["Address"].'</div>
                <div style="float: left; width: 20%; text-align: right; font-size: 12px;">AUTHENTICATED</div>
                <div class="clr"></div>
            </div>
            <div>'.$CompanyInfo["Phone"].'</div>
            <div>'.$CompanyInfo["email"].'</div>
            <div>'.$CompanyInfo["Website"].'</div>
            <div>
                <div style="float: left; width: 50%; text-align: left;">'.$outgoing_invoice_excise->Supplier_stage.'</div>
                <div style="float: left; width: 50%; text-align: right;">Authorised Signatory</div>
                <div class="clr"></div>
            </div>
        </div>
		<div style="float: left; width: 28%; text-align: left; font-size: 12px; border-right: 1px solid #000;">
             <div>
                <div style="float: left; width: 36%; text-align: left;">CE Regn No.</div>
                <div style="float: left; width: 64%; text-align: left;">'.$CompanyInfo["CERegnNo"].'</div>
                <div class="clr"></div>
            </div>
            <div>
                <div style="float: left; width: 36%; text-align: left;">Range</div>
                <div style="float: left; width: 64%; text-align: left;">'.$CompanyInfo["RangeMulti"].'</div>
                <div class="clr"></div>
            </div>
            <div style="height: 40px;">
                <div style="float: left; width: 36%; text-align: left;">Division</div>
                <div style="float: left; width: 64%; text-align: left;">'.$CompanyInfo["Division"].'</div>
                <div class="clr"></div>
            </div>
            <div>
                <div style="float: left; width: 36%; text-align: left;">Commisionarate</div>
                <div style="float: left; width: 64%; text-align: left;">'.$CompanyInfo["Commisionarate"].'</div>
                <div class="clr"></div>
            </div>
            <div>
                <div style="float: left; width: 36%; text-align: left;">ECC No.</div>
                <div style="float: left; width: 64%; text-align: left;">'.$CompanyInfo["ECCNo"].'</div>
                <div class="clr"></div>
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
                <div class="clr"></div>
            </div>
            <div style=" font-size: 12px;">
                <div style="float: left; width: 50%;">Date :</div>
                <div style="float: left;">'.$outgoing_invoice_excise->oinv_date.'</div>
                <div class="clr"></div>
            </div>
            <div style=" font-size: 12px;">
                <div style="float: left; width: 50%;">Time :</div>
                <div style="float: left;">'.$outgoing_invoice_excise->oinv_time.'</div>
                <div class="clr"></div>
            </div>
        </div>
        <div class="clr"></div>
    </div>

    <div style="width: 100%; height: 110px; border-left: 1px solid #000;border-right: 1px solid #000; padding: 2px; font-size: 12px; float: left; border-bottom: 1px solid #000">
        <div style="float: left; height: 105px; width: 53%; border-right: 1px solid #000;">
            <div style="float: left; width: 62%;">
                <div style="font-size: 12px; font-weight: 700;">Name & Address of Buyer</div>
                <div style="font-size: 16px; font-weight: bold;">M/s '.$outgoing_invoice_excise->Buyer_Name.'</div>
                <div  style="font-size: 14px;">
{{BuyerDetaile._bill_add1}}{{BuyerDetaile._bill_add2}}
                </div>
            </div>
            <div style="float: left; width: 38%;">
                <div style="font-size: 14px; font-weight: bold; margin-bottom: 3px;">
                    <div style="float: left; width: 50%;">Order No : </div>
                    <div style="float: left; width: 48%;">{{PODetaile.pon}}</div>
                    <div class="clr"></div>
                </div>
                <div style="font-size: 14px; font-weight: bold; margin-bottom: 3px;">
                    <div style="float: left; width: 50%;">Order Date : </div>
                    <div style="float: left; width: 48%;">{{PODetaile.pod}}</div>
                    <div class="clr"></div>
                </div>
                <div style="font-size: 12px; margin-bottom: 3px;">
                    <div style="float: left; width: 52%;">Despatch Time : </div>
                    <div style="float: left; width: 45%;">'.$outgoing_invoice_excise->dispatch_time.'</div>
                    <div class="clr"></div>
                </div>
                <div style="font-size: 14px;">
                    Through '.$outgoing_invoice_excise->mod_delivery_text.'
                </div>
            </div>
            <div class="clr"></div>
        </div>
        <div style="float: left; width: 46.9%;">
            <div style="text-align: center;font-size: 14px; font-weight: bold; border-bottom: 1px solid #000;">
                <div style="float: left; width: 30%; border-right: 1px solid #000;">&nbsp;</div>
                <div style="float: left; width: 30%; border-right: 1px solid #000;">MANUFACTURER</div>
                <div style="float: left; width: 35%;">BUYER</div>
                <div class="clr"></div>
            </div>
            <div style="text-align: left;font-size: 12px; border-bottom: 1px solid #000;">
                <div style="float: left; width: 30%; border-right: 1px solid #000;">CE Regn No.</div>
                <div style="float: left; width: 30%; border-right: 1px solid #000;">&nbsp;</div>
                <div style="float: left; width: 35%;">&nbsp;</div>
                <div class="clr"></div>
            </div>
            <div style="text-align: left;font-size: 12px; border-bottom: 1px solid #000;">
                <div style="float: left; width: 30%; border-right: 1px solid #000;">Range Div & Collectrate</div>
                <div style="float: left; width: 30%; border-right: 1px solid #000;">&nbsp;</div>
                <div style="float: left; width: 35%;">&nbsp;</div>
                <div class="clr"></div>
            </div>
            <div style="text-align: left;font-size: 12px; border-bottom: 1px solid #000;">
                <div style="float: left; width: 30%; border-right: 1px solid #000;">Sales Tax No.</div>
                <div style="float: left; width: 30%; border-right: 1px solid #000;">{{PrincipalDetaile._tin_no}}</div>
                <div style="float: left; width: 35%;">{{BuyerDetaile._tin}}</div>
                <div class="clr"></div>
            </div>
            <div style="text-align: left;font-size: 12px; border-bottom: 1px solid #000;">
                <div style="float: left; width: 30%; border-right: 1px solid #000;">PIT NO.</div>
                <div style="float: left; width: 30%; border-right: 1px solid #000;">&nbsp;</div>
                <div style="float: left; width: 35%;">&nbsp;</div>
                <div class="clr"></div>
            </div>
            <div style="text-align: left;font-size: 12px; border-bottom: 1px solid #000;">
                <div style="float: left; width: 30%; border-right: 1px solid #000;">ECC Code No.</div>
                <div style="float: left; width: 30%; border-right: 1px solid #000;">{{PrincipalDetaile._ecc_codeno}}</div>
                <div style="float: left; width: 35%;">{{BuyerDetaile._ecc}}</div>
                <div class="clr"></div>
            </div>
            <div style="text-align: center;font-size: 14px;">
                <div style="float: left; width: 49.8%; border-right: 1px solid #000;">EXCISE DUTY</div>
                <div style="float: left; width: 48%;">MANUFACTURER</div>
                <div class="clr"></div>
            </div>
        </div>
        <div class="clr"></div>
    </div>
    
 <div style=" width: 100%; border-left:1px solid #000; border-right:1px solid #000; padding-right: 4px; height:190px;">
        <div style="float: left;height:190px; width: 30px; text-align: center; font-size: 12px; border-right: 1px solid #000;">
            <div style="border-bottom: 1px solid #000; height: 45px;  line-height: 16px; text-align: center;font-weight: bold;">S.No.</div>
            <div style=" height: 40px;" ng-repeat="item in PODetaile._items2">{{item.sn}}</div>
        </div>
        <div style="float: left;height:190px; width: 82px; text-align: center; font-size: 12px; border-right: 1px solid #000;">
            <div style="border-bottom: 1px solid #000; height: 45px;  line-height: 16px; text-align: center;font-weight: bold;">Code/Part No</div>
            <div style=" height: 40px;" ng-repeat="item in PODetaile._items2">{{item.codepart}}</div>
        </div>
        <div style="float: left;height:190px; width: 115px; text-align: left; font-size: 12px; border-right: 1px solid #000;">
            <div style="border-bottom: 1px solid #000;  height: 45px;  line-height: 16px; text-align: center;font-weight: bold;">Decription</div>
            <div style=" height: 40px;" ng-repeat="item in PODetaile._items2">{{item.desc}}-{{item.cpart}}</div>
        </div>
        <div style="float: left;height:190px; width: 45px; text-align: center; font-size: 12px; border-right: 1px solid #000;">
            <div style="border-bottom: 1px solid #000;  height: 45px;  line-height: 16px; text-align: center;font-weight: bold;">ID Mark</div>
            <div style="height: 40px;" ng-repeat="item in PODetaile._items2">{{item.idmark}}</div>
        </div>
        <div style="float: left;height:190px; width: 60px; text-align: right; font-size: 12px; border-right: 1px solid #000;">
            <div style="border-bottom: 1px solid #000; height: 45px;  line-height: 16px; text-align: center;font-weight: bold;">Tarif Heading</div>
            <div style=" height: 40px;" ng-repeat="item in PODetaile._items2">{{item.tarrif}}</div>
        </div>
        <div style="float: left;height:190px; width: 30px; text-align: right; font-size: 12px; border-right: 1px solid #000;">
            <div style="border-bottom: 1px solid #000;height: 45px;  line-height: 16px; text-align: center;font-weight: bold;">Qty</div>
            <div style="height: 40px;" ng-repeat="item in PODetaile._items2">{{item.qty}} {{item.unitname}}</div>
        </div>
        <div style="float: left;height:190px; width: 45px; text-align: center; font-size: 12px; border-right: 1px solid #000;">
            <div style="border-bottom: 1px solid #000;  height: 45px;  line-height: 16px; text-align: center;font-weight: bold;">Rate</div>
            <div style=" height: 40px;" ng-repeat="item in PODetaile._items2">{{item.rate}}</div>
        </div>
        <div style="float: left;height:190px; width: 60px; text-align: center; font-size: 12px; border-right: 1px solid #000;">
            <div style="border-bottom: 1px solid #000;  height: 45px;  line-height: 16px; text-align: center;font-weight: bold;">Amount</div>
            <div style=" height: 40px;" ng-repeat="item in PODetaile._items2">{{item.amount.toFixed(2)}}</div>
        </div>
        <div style="float: left;height:190px; width: 50px; text-align: left; font-size: 12px; border-right: 1px solid #000;">
            <div style="border-bottom: 1px solid #000; height: 45px;  line-height: 16px; text-align: center;font-weight: bold;">Amount of ED</div>
            <div style=" height: 40px;" ng-repeat="item in PODetaile._items2">{{item.amt_ed}}</div>
        </div>
        <div style="float: left;height:190px; width: 40px; text-align: center; font-size: 12px; border-right: 1px solid #000;">
            <div style="border-bottom: 1px solid #000; height: 45px;  line-height: 16px; text-align: center;font-weight: bold;">EDU CESS</div>
            <div style="height: 40px;" ng-repeat="item in PODetaile._items2">{{item.edu_cess.toFixed(2)}}</div>
        </div>
        <div style="float: left;height:190px; width: 30px; text-align: right; font-size: 12px; border-right: 1px solid #000;">
            <div style="border-bottom: 1px solid #000; height: 45px;  line-height: 16px; text-align: center;font-weight: bold;">Rate of ED</div>
            <div style=" height: 40px;" ng-repeat="item in PODetaile._items2">{{item.rate_ed}}%</div>
        </div>
        <div style="float: left;height:190px; width: 40px; text-align: right; font-size: 12px; border-right: 1px solid #000;">
            <div style="border-bottom: 1px solid #000; height: 45px;  line-height: 16px; text-align: center;font-weight: bold;">Duty Per Unit</div>
            <div style=" height: 40px;" ng-repeat="item in PODetaile._items2">{{item.duty_per_unit}}</div>
        </div>
        <div style="float: left;height:190px; width: 45px; text-align: center; font-size: 12px; border-right: 1px solid #000;">
            <div style="border-bottom: 1px solid #000; height: 45px;  line-height: 16px; text-align: center; font-weight: bold;">Entry in 23D</div>
            <div style="height: 40px;" ng-repeat="item in PODetaile._items2">{{item.entry_in23d}}</div>
        </div>
        <div style="float: left;height:190px; width: 70px; text-align: center; font-size: 12px; border-right: 1px solid #000;">
            <div style="border-bottom: 1px solid #000; height: 45px;  line-height: 16px; text-align: center;font-weight: bold; ">Invoice No.</div>
            <div style=" height: 40px;" ng-repeat="item in PODetaile._items2">{{item.invno}}</div>
        </div>
        <div style="float: left;height:190px; width: 63px; text-align: left; font-size: 12px; border-right: 1px solid #000;">
            <div style="border-bottom: 1px solid #000; height: 45px;  line-height: 16px; text-align: center; font-weight: bold;">Date</div>
            <div style=" height: 40px;" ng-repeat="item in PODetaile._items2">{{item.date}}</div>
        </div>
        <div style="float: left;height:190px; width: 47px; text-align: center; font-size: 12px; border-right: 1px solid #000;">
            <div style="border-bottom: 1px solid #000; height: 45px;  line-height: 16px; text-align: center;font-weight: bold;">Qty</div>
            <div style=" margin-left: 2px; height: 43px;" ng-repeat="item in PODetaile._items2">{{item.princqty}} {{item.unitname}}</div>
        </div>
        <div style="float: left;height:190px; width: 58px; text-align: right; font-size: 12px; border-right: 1px solid #000;">
            <div style="border-bottom: 1px solid #000; height: 45px;  line-height: 16px; text-align: center;font-weight: bold;">Assess. Value</div>
            <div style=" height: 40px;" ng-repeat="item in PODetaile._items2">{{item.ass_val}}</div>
        </div>
        <div style="float: left;height:190px; width: 55px; text-align: right; font-size: 12px; border-right: 0px solid #000;">
            <div style="border-bottom: 1px solid #000; height: 45px;  line-height: 16px; text-align: center; font-weight: bold;">Amount of ED & Cess</div>
            <div style="height: 40px;" ng-repeat="item in PODetaile._items2">{{item.amt_edu}} <br />{{item.amt_cess}}</div>
        </div>
        <div class="clr"></div>
    </div>

    <div style="width: 100%;  border-left: 1px solid #000;border-right: 1px solid #000; padding: 2px; font-size: 12px;">
        <div style="float: left; height: 220px;  width: 48%; border-right: 1px solid #000;">
            <div style="height: 205px; border-top:1px solid #000;">
                <div style=" float: left;width: 48%; margin-top: 60px;">
                    1. '.$CompanyInfo["txt1"].'<br />
                    2. '.$CompanyInfo["txt2"].'<br />
                    3. '.$CompanyInfo["txt3"].'<br />
                    4. '.$CompanyInfo["txt4"].'<br />
                    <div style="font-size: 16px; font-weight: bold;">TIN: {{BuyerDetaile._tin}}</div>
                </div>
                <div style="font-size: 12px; height:205px; float: left;width: 51%; border-left: 1px solid #000;">
                    <div style="height: 90px; border-bottom: 1px solid #000;">
                        <div>
                            <div style="float: left;width: 50%;">Total Amount</div>
                            <div align="right" style="float: left;width: 48%;">{{BillDetaile.basic_amount.toFixed(2)}}</div>
                            <div class="clr"></div>
                        </div>
                        <div>
                            <div style="float: left;width: 50%;"><div id="discountblog1">- Discount @ {{BillDetaile.discount_percent}}%</div></div>
                            <div align="right" style="float: left;width: 48%;"><div id="discountblog2">{{BillDetaile.discount_amt}}</div></div>
                            <div class="clr"></div>
                        </div>
                        <div id="excisebill">
                            <div style="float: left;width: 50%;">+ Excise Duty</div>
                            <div align="right" style="float: left;width: 48%;">{{BillDetaile.ed_amt.toFixed(2)}}</div>
                            <div class="clr"></div>
                        </div>
                        <div id="edubill">
                            <div style="float: left;width: 50%;">+ EDU CESS</div>
                            <div align="right" style="float: left;width: 48%;">{{(BillDetaile.edu_amt + BillDetaile.hedu_amt).toFixed(2)}}</div>
                            <div class="clr"></div>
                        </div>
                        <div id="cvdbill">
                            <div style="float: left;width: 50%;">+ CVD</div>
                            <div align="right" style="float: left;width: 48%;">{{BillDetaile.cvd_amt.toFixed(2)}}</div>
                            <div class="clr"></div>
                        </div>
                        <div>
                            <div style="float: left;width: 52%;"><div id="pfblog">+ P&F Charges @ {{(BillDetaile.pf_percent)}} %</div></div>
                            <div align="right" style="float: left;width: 46%;"><div id="pfblog2">{{(BillDetaile.pf_amt)}}</div></div>
                            <div class="clr"></div>
                        </div>
                        <div>
                            <div style="float: left;width: 50%;"><div id="inciblog">+ Incidental Charges @ {{BillDetaile.inci_percent}} %</div></div>
                            <div align="right" style="float: left;width: 48%;"><div id="inciblog2">{{(BillDetaile.inci_amt)}}</div></div>
                            <div class="clr"></div>
                        </div>
                    </div>
                    <div style="height:55px; border-bottom: 1px solid #000;">
                        <div>
                            <div style="float: left;width: 50%;">Taxable Amount</div>
                            <div align="right" style="float: left;width: 48%;">{{BillDetaile.TaxableAmount}}</div>
                            <div class="clr"></div> 
                        </div>
                        <div>
                            <div style="float: left;width: 70%;">+{{TaxDetaile.SALESTAX_DESC}}</div>
                            <div align="right" style="float: left;width: 28%;">{{BillDetaile.SaleTaxAmount}}</div>
                            <div class="clr"></div>
                        </div>
                        <div>
                            <div style="float: left;width:70%;"><div id="surchargeblog">+ {{TaxDetaile.SURCHARGE_DESC}}</div></div>
                            <div align="right" style="float: left;width: 28%;"><div id="surchargeblog2">{{BillDetaile.SurchargeAmount}}</div></div>
                            <div class="clr"></div>
                        </div>
                        <div>
                            <div style="float: left;width: 50%;"><div id="ferightblog">+ Freight {{BillDetaile.feright_percent}} </div></div>
                            <div align="right" style="float: left;width: 48%;"><div id="ferightblog2">{{BillDetaile.feright_amt}}</div></div>
                            <div class="clr"></div>
                        </div>
                    </div>
                    <div style="height: 28px; border-bottom: 1px solid #000;">
                        <div>
                            <div style="float: left;width: 50%;">Total Amount</div>
                            <div align="right" style="float: left;width: 48%;">'.$outgoing_invoice_excise->bill_value.'</div>
                            <div class="clr"></div>
                        </div>
                        <div>
                            <div style="float: left;width: 50%;">Round Off</div>
                            <div align="right" style="float: left;width: 48%;">'.$outgoing_invoice_excise->round_off_value.'</div>
                            <div class="clr"></div>
                        </div>
                    </div>
                    <div style="height: 17px; font-weight: bold;">
                        <div style="float: left;width: 54%;">Total Payable Amount</div>
                        <div align="right" style="float: left;width: 46%;">'.$outgoing_invoice_excise->final_pay_value.'</div>
                        <div class="clr"></div>
                    </div>
                </div>
                <div class="clr"></div>
            </div>
            <div style="font-size: 12px; font-weight: bold; border-top: 1px solid #000;">
                Grand Total(Rs.)  '.$outgoing_invoice_excise->final_pay_inwords.' Only
            </div>
        </div>
        <div style="float: left; height: 220px;  width: 51.9%;">
            <div style="height: 75px; border-bottom: 1px solid #000;">
                <div style="font-size: 12px;height: 35px; border-top:1px solid #000;">
                    <div style="float: left; width: 15%;">{{BillDetaile.ed_amt.toFixed(2)}}</div>
                    <div style="float: left; width: 85%;">Excise Duty Amount (RS.) {{BillDetaile.exice_amt_inword}} only</div>
                    <div class="clr"></div>
                </div>
                <div>Rate of Duty in Words: 
{{BillDetaile.ed_percentinword}} &nbsp; &nbsp; &nbsp; 
&nbsp; EDU CESS {{BillDetaile.edu_percent}}% &nbsp;&nbsp; 
{{(BillDetaile.edu_amt).toFixed(2)}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </div>
                <div style="padding-top: 5px;">
                     Higher 
EDU Cess {{BillDetaile.hedu_percent}}%&nbsp;&nbsp; 
{{BillDetaile.hedu_amt.toFixed(2)}}  &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;
<span id="cvdblog">CVD {{BillDetaile.cvd_percent}}%&nbsp;&nbsp;&nbsp;&nbsp;{{BillDetaile.cvd_amt.toFixed(2)}} </span>
                </div>
            </div>
            <div  style="height: 145px;">
                <div style="height: 145px;float: left; width: 60%;font-size: 12px; padding-left: 2px; border-right: 1px solid #000; ">
                    Name & Address of Manufacturer<br />
                    {{PrincipalDetaile._principal_supplier_name}} <br />
{{PrincipalDetaile._add1}},{{PrincipalDetaile._add2}} , {{PrincipalDetaile._city_name}}
,{{PrincipalDetaile._state_name}}
                </div>
                <div align="left" style="height: 195px;float: left; width: 37%; padding-top: 45px;">
                    '.$CompanyInfo["txt5"].'<br /><br />
                    '.$CompanyInfo["txt6"].'
                </div>
                <div class="clr"></div>
            </div>
        </div>
        <div class="clr"></div>
    </div>';
   
}
$html1.='<div  style="width: 100.7%;">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
<td class="exc_bdr_top_lft">'.$CompanyInfo["txt7"].':</td>
<td class="multi exc_bdr_top_rght" rowspan="2">for, <span>'.$CompanyInfo["Name"].'</span></td>
</tr>

<tr>
<td class="exc_bdr_left_rght" colspan="2">'.$CompanyInfo["txt8"].' &nbsp; &nbsp; &nbsp; &nbsp;</td>
</tr>

<tr>
<td class="exc_bdr_left_rght" colspan="2">'.$CompanyInfo["txt9"].' {{PrincipalDetaile._principal_supplier_name}} ,
{{PrincipalDetaile._add1}},{{PrincipalDetaile._add2}} , {{PrincipalDetaile._city_name}},{{PrincipalDetaile._state_name}}</td>
</tr>

<tr>
<td class="exc_bdr_left_rght" colspan="2">'.$CompanyInfo
["txt10"].'</td>
</tr>

<tr>
<td class="exc_bdr_lft_rght_btm" colspan="2">PLACE &nbsp; &nbsp; : '.$CompanyInfo["PLACE"].'. DATE &nbsp; 
{{outgoing_invoice_excise.oinv_date}}</td>
</tr>

<tr>
<td colspan="2" style="text-align:center;"><b>'.$CompanyInfo
["txt11"].'</b></td>
</tr>

</table>

</div>
</div>





<div class="clr"></div>
</div>
</div>
<div class="clr"></div>
</div>
</form>';

$mpdf->SetHTMLHeader($header);
$mpdf->SetHTMLHeader($headerE,'E');
$mpdf->SetHTMLFooter($footer);
$mpdf->SetHTMLFooter($footerE,'E');


$html = $html.$html1.$html2.$html3;
//$html = file_get_contents(SITE_URL . "/Business_View/print_challan.php?TYP=SELECT&ID=16");
//$html = str_replace ("%SITE_URL%", SITE_URL, $html);
//$mpdf->SetDisplayMode('fullpage');
$mpdf->WriteHTML($html);
$mpdf->Output();
/*$filePath = SITE_URL. "pdf/invoices/20_cover.pdf";
$mpdf->Output($filePath, "F"); */
//$mpdf->Output('invoices/invoice'.$oinvoice_exciseID.'.pdf', 'F');
exit;
?>