<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/my_temp.css" rel="stylesheet" type="text/css" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../css/menu.css" type="text/css" media="screen" />
<!-- Bootstrap Core CSS -->
    <link href="../css/boot_css/bootstrap.min.css" rel="stylesheet">
<!--<script type='text/javascript' src="header.js"></script>-->

   
</head>
<body>
<form name="f1" method="post" >
<?php 
if($_SESSION["USER"]!=null)
{ 
$TYPE = $_SESSION["USER_TYPE"]; //echo($TYPE);

$TYPE = $_SESSION["USER_TYPE"];

if($actual_url == 'View/home/Dashboard.php' && ($TYPE == 'E' || $TYPE == 'B')){
 echo 'Permission Denied'; exit;
}

if($accessKey!='' || $accessKey != NULL){

	if(!checkPermission($accessKey)){
		echo 'Permission Denied-1'; exit;
	}
}
if(isset($_SESSION["USER"]) and $_SESSION["USER"] != NULL){
	  if(isLoginSessionExpired()) {
		die('<script type="text/javascript">window.location.href="../../logout.php?se=1";</script>');
	 }  
}   

?>

<div class="clr"></div>


<div>
<ul id="menu">
   
   <?php
     if($TYPE=='E' || $TYPE=='B'){
	
    ?>
     <li id="Home" ><a href="<?php print SITE_URL.SalesExecutiveDASHBOARD; ?>" class="drop"> <img src="<?php print SITE_URL.'View/img/dashboard-icon.png'; ?>"/>Dashboard </a> </li>
    <?php }else{?>
    <li id="Home" ><a href="<?php print SITE_URL.DASHBOARD; ?>" class="drop"> <img src="<?php print SITE_URL.'View/img/dashboard-icon.png'; ?>"/>Dashboard </a> </li>
    <?php }?>
    
  
    <li id="Masters">
     <a href="#" class="drop"><img src="<?php print SITE_URL.'View/img/master.png'; ?>"/> Masters <img src="<?php print SITE_URL.'View/img/arrow-down.png'; ?>"/></a> 
       <div class="dropdown_1column" style ="width:265px;">
           <div class="col_1">
            <ul class="simple">
          <?php
            if(checkPermission('unit_view')||checkPermission('unit_add')||checkPermission('unit_edit'))
            {
			  echo '<li id="unitmast"><a href="'.SITE_URL.UNITMASTER.'">Unit Master</a></li>';	
			}
			
			if(checkPermission('group_view')||checkPermission('group_add')||checkPermission('group_edit'))
            {
			  echo '<li id="groupmast"><a href="'.SITE_URL.GROUPMASTER.'">Group Master</a></li>';	
			}
			
			if(checkPermission('state_view')||checkPermission('state_add')||checkPermission('state_edit'))
            {
			  echo '<li id="statemast"><a href="'.SITE_URL.STATEMASTER.'">State Master</a></li>';	
			}
			
			if(checkPermission('city_view')||checkPermission('city_add')||checkPermission('city_edit'))
            {
			  echo '<li id="citymast"><a href="'.SITE_URL.CITYMASTER.'">City Master</a></li>';	
			}
			if(checkPermission('location_view')||checkPermission('location_add')||checkPermission('location_edit'))
            {
			  echo ' <li id="locationmast"><a href="'.SITE_URL.LOCATIONMASTER.'">Location Master</a></li>';	
			}
			if(checkPermission('principal_view')||checkPermission('principal_add')||checkPermission('principal_edit'))
            {
			  echo '<li id="principalmast"><a href="'.SITE_URL.VIEWPRINCIPALMASTER.'">Principal Master</a></li>';	
			}
			if(checkPermission('supplier_view')||checkPermission('supplier_add')||checkPermission('supplier_edit'))
            {
			  echo '<li id="suppliermast"><a href="'.SITE_URL.VIEWSUPPLIERMASTER.'">Supplier Master</a></li>';	
			}
			if(checkPermission('item_view')||checkPermission('item_add')||checkPermission('item_edit'))
            {
			  echo '<li id="itemmast"><a href="'.SITE_URL.ITEMMASTER.'">Item Master</a></li>';	
			}
			if(checkPermission('buyer_view')||checkPermission('buyer_add')||checkPermission('buyer_edit'))
            {
			  echo '<li id="Buyermast"><a href="'.SITE_URL.VIEWBUYERMASTER.'">Buyer Master</a></li>';	
			}
			/* BOF for adding Tax Master by Ayush Giri on 05-06-2017 */
			if(checkPermission('tax_view')||checkPermission('tax_add')||checkPermission('tax_edit'))
            {
			  echo '<li id="taxmast"><a href="'.SITE_URL.TAXMASTER.'">Tax Master</a></li>';	
			}
			if(checkPermission('hsn_view')||checkPermission('hsn_add')||checkPermission('hsn_edit'))
            {
			  echo '<li id="hsnmast"><a href="'.SITE_URL.HSNMASTER.'">HSN Master</a></li>';	
			}
			/* EOF for adding Tax Master by Ayush Giri on 05-06-2017 */
			if(checkPermission('buyer_view')||checkPermission('buyer_add')||checkPermission('buyer_edit'))
            {
			  echo '<li id="company_info"><a href="'.SITE_URL.MANAGECOMPANYINFO.'">Manage Company Info</a></li>';	
			}
            ?>
            
                </ul>
            </div>
		</div>
    </li>
    <!---####----->
     <li id="BusinessAction"><a href="#" class="drop"> <img src="<?php print SITE_URL.'View/img/schedule.png'; ?>"/> Order's <img src="<?php print SITE_URL.'View/img/arrow-down.png'; ?>"/></a>
        <div class="dropdown_2columns">
            <div class="col_2">
                <ul class="simple">
                             <?php
       if(checkPermission('challan_view')||checkPermission('challan_add')||checkPermission('challan_edit'))
       {
		 echo '<li id="Challan"><a href="'.SITE_URL.VIEW_CHALLAN.'">Challan</a></li>';	
	   }
	   
	   if(checkPermission('quotation_view')||checkPermission('quotation_add')||checkPermission('quotation_edit'))
       {
		 echo '<li id="Quotation"><a href="'.SITE_URL.VIEWQUATION.'">Quotation</a></li>';	
	   }
	   
	   if(checkPermission('po_view')||checkPermission('po_add')||checkPermission('po_edit'))
       {
		 echo '<li id="SearchPurchaseOrder"><a href="'.SITE_URL.BUNDLE_PO.'">Bundle PO</a></li>';
		 echo '<li id="SearchPurchaseOrder"><a href="'.SITE_URL.PO.'">Purchase Order</a></li>';
		 	
	   }
	   
	   if(checkPermission('recurringpo_view')||checkPermission('recurringpo_add')||checkPermission('recurringpo_edit'))
       {
		 echo ' <li id="POSCHEDULE"><a href="'.SITE_URL.POSCHEDULE.'">Recurring Purchase Order</a></li>';	
	   }
	if(checkPermission('stock_transfer_view')||checkPermission('stock_transfer_add')||checkPermission('stock_transfer_edit'))
       {
		 echo '<li id="StockCheck"><a href="'.SITE_URL.VIEW_STOCK_TRANSFER.'">Stock Transfer</a></li>';	
	   }
	   if(checkPermission('stock_check_view')||checkPermission('stock_check_add')||checkPermission('stock_check_edit'))
       {
		 echo '<li id="StockCheck"><a href="'.SITE_URL.VIEW_STOCK_Check.'">Stock Check</a></li>';	
	   }
	   if(checkPermission('pendingpo_view')||checkPermission('pendingpo_add')||checkPermission('pendingpo_edit'))
       {
 echo '<li id="POPending"><a href="'.SITE_URL.PO_PENDING_STATEMENT.'?repType=pending">Pending Purchase Order</a></li>';	
	   }
	   
	   if(checkPermission('partialpo_view')||checkPermission('partialpo_add')||checkPermission('partialpo_edit'))
       {
		 echo '<li id="Partial"><a href="'.SITE_URL.PO_PARTIAL_DELIVERED_STATEMENT.'?repType=partial">Purchase Order Partialy Deliver</a></li>';	
	   }
	   
	   if(checkPermission('deliveredpo_view')||checkPermission('deliveredpo_add')||checkPermission('deliveredpo_edit'))
       {
		 echo '<li id="Delivered"><a href="'.SITE_URL.PO_DELIVERD_STATEMENT.'?repType=complete">Purchase Order Deliver</a></li>';	
	   }
       ?>
                </ul>
            </div>
		</div>
    </li>
  <li id="BusinessAction"><a href="#" class="drop"> <img src="<?php print SITE_URL.'View/img/business-new.png'; ?>"/> Business Actions <img src="<?php print SITE_URL.'View/img/arrow-down.png'; ?>"/></a>
        <div class="dropdown_2columns">
            <div class="col_2">
                <ul class="simple">
				<?php
				   if(checkPermission('inexcise_view')||checkPermission('inexcise_add')||checkPermission('inexcise_edit')){
					
					 echo '<li><a href="'.SITE_URL.VIEW_BUNDLE_INVOICE.'" >Bundle Invoice</a></li>';	
				   }
				   
				?>
					
                    <li><a href="#" >Invoices Generation</a>
                       <ul  class="simple">
                         <?php
       if(checkPermission('inexcise_view')||checkPermission('inexcise_add')||checkPermission('inexcise_edit'))
       {
		
		 echo '<li><a href="'.SITE_URL.VIEW_INCOMING_INVOICE_EXCISE.'" >In-Coming</a></li>';	
	   }
	   	   
	   //~ if(checkPermission('innonexcise_view')||checkPermission('innonexcise_add')||checkPermission('innonexcise_edit'))
       //~ {
		 //~ echo '<li><a href="'.SITE_URL.VIEW_INCOMINGINVOICENONEXCISE.'">In-Coming Non Excise</a></li>';	
	   //~ }
	  
	   
        ?>
                       </ul>
                    </li>
                    <li><!--<a href="#" class="drop">Outgoing Invoice Generation</a>-->
						<div>
						<ul class="simple" style="font-size:11px;">
						<?php
						 if(checkPermission('outexcise_view')||checkPermission('outexcise_add')||checkPermission('outexcise_edit'))
       {
		 echo '<li><a href="'.SITE_URL.VIEW_OUTGOING_INVOICE_EXCISE.'" >Out-Going</a></li>';	
	   }
	   //~ if(checkPermission('outnonexcise_view')||checkPermission('outnonexcise_add')||checkPermission('outnonexcise_edit'))
       //~ {
		 //~ echo '<li><a href="'.SITE_URL.VIEW_OUTGOING_INVOICE_NonEXCISE.'">Out-Going Non Excise</a></li>';	
	   //~ }
						?>
						</ul>
						</div>
                    </li>
                    
                </ul>
            </div>
		</div>
    </li>
     <li id="BusinessAction"><a href="#" class="drop"> <img src="<?php print SITE_URL.'View/img/payment-icon.png'; ?>"/>Payment<img src="<?php print SITE_URL.'View/img/arrow-down.png'; ?>"/></a>
        <div class="dropdown_2columns">
            <div class="col_2">
                <ul class="simple">
                <?php
        if(checkPermission('payment_view')||checkPermission('payment_add'))
       {
		 echo '<li><a href="'.SITE_URL.PAYMENT_RECEIVED_LIST.'">Make Payment</a></li>';	
	   }
	   
	   if(checkPermission('payment_view')||checkPermission('payment_add'))
       {
		 echo '<li><a href="'.SITE_URL.OINVOICE_PAYMENT_PENDING_LIST.'" >Payment Pending Invoice List</a></li>';	
	   }
	   if(checkPermission('pendinginv_view')||checkPermission('pendinginv_add'))
       {
		//echo ' <li><a href="'.SITE_URL.OINVOICE_BUYER_PAYMENT_PENDING_LIST.'">Payment Pending Buyer List</a></li>';	
	   }
	   
	   
        ?>
        <li><a href="<?php print SITE_URL.VIEW_FINALCIAL_YEAR_WISE_REVENUE; ?>" >Financial Year Wise Buyer Revenue Detail</a></li>
            <li><a href="<?php print SITE_URL.VIEW_BUYER_WISE_REVENUE; ?>">Buyer Wise Revenue detail</a></li>
            
        
					  	  <?php if($TYPE =="M"){ 
					           $ma_rep="POs for Approve/Reject";
					       }else if($TYPE =="S"){ 
					           $ma_rep="POs for Management Decision ";
	   			          }
 else {
     $ma_rep="POs for Approve/Reject";
 }?>
	                        <li><a href="<?php print SITE_URL.POsMS; ?>"><?php echo($ma_rep); ?></a></li>
                </ul>
            </div>
		</div>
    </li>
                
  <li id="Reports"><a href="#" class="drop"> <img src="<?php print SITE_URL.'View/img/report-new.png'; ?>"/> Reports <img src="<?php print SITE_URL.'View/img/arrow-down.png'; ?>"/></a>
      <div class="dropdown_1column" style="width:265px;">
       <div class="col_1">
        <ul class="simple">
     <?php
	if(checkPermission('excisestockval_View'))
	{
		/* BOF to hide unused Reports by Ayush Giri on 14-07-2017 */
		//echo '<li id="salsereport"><a href="'.SITE_URL.EX_STOCK_STMT_WV.'">Excise Stock Statement With Value</a></li>';
		echo '<li id="salsereport"><a href="'.SITE_URL.EX_STOCK_STMT_WV.'">Stock Statement With Value</a></li>';
		/* BOF to hide unused Reports by Ayush Giri on 14-07-2017 */
	}
         
      //~ if(checkPermission('nonexcisestockval_view'))
     //~ {
	   //~ echo '<li id="salsereport"><a href="'.SITE_URL.NONEX_STOCK_STMT_WV.'">Non Excise Stock Statement With Value</a></li>';
	 //~ }
	 
	if(checkPermission('excisestockval_View'))
	{
		/* BOF to hide unused Reports by Ayush Giri on 14-07-2017 */
		//echo '<li id="salsereport"><a href="'.SITE_URL.EX_STOCK_STMT_DATE_WV.'">Excise Stock Statement With Date/Value</a></li>';
		echo '<li id="salsereport"><a href="'.SITE_URL.EX_STOCK_STMT_DATE_WV.'">Stock Statement With Date/Value</a></li>';
		/* EOF to hide unused Reports by Ayush Giri on 14-07-2017 */
	}
         
      //~ if(checkPermission('nonexcisestockval_view'))
     //~ {
	   //~ echo '<li id="salsereport"><a href="'.SITE_URL.NONEX_STOCK_STMT_DATE_WV.'">Non Excise Stock Statement With Date/Value</a></li>';
	 //~ }
	
	/* BOF to hide unused Reports by Ayush Giri on 14-07-2017 */
	/* if(checkPermission('excisenonexcixestoc_view'))
	{
		echo ' <li id="salsereport"><a href="'.SITE_URL. EX__NEX_CHALLAN_STOCK_STMT.'">Excise,Non-Excise,Challan Stock-Statement</a></li>';
	} */
	/* EOF to hide unused Reports by Ayush Giri on 14-07-2017 */
	
	if(checkPermission('excisestockstmt_view'))
	{
		/* BOF to hide unused Reports by Ayush Giri on 14-07-2017 */
		//echo '<li id="salsereport"><a href="'.SITE_URL.EX_STOCK_STMT.'">Excise Stock Statement</a></li>';
		echo '<li id="salsereport"><a href="'.SITE_URL.EX_STOCK_STMT.'">Excise Stock Statement</a></li>';
		/* EOF to hide unused Reports by Ayush Giri on 14-07-2017 */
	}
	     
	     //~ if(checkPermission('nonexcisestockstmt_view'))
         //~ {
		//~ echo '<li id="salsereport"><a href="'.SITE_URL.NONEX_STOCK_STMT.'">Non Excise Stock Statement</a></li>';
	     //~ }
		if(checkPermission('excisesecondsal_view'))
		{
			/* BOF to hide unused Reports by Ayush Giri on 14-07-2017 */
			//echo '<li id="salsereport"><a href="'.SITE_URL.EX_SECONDARY_SALSE_STATEMENT.'">Excise Secondary Sales Statement</a></li>';
			echo '<li id="salsereport"><a href="'.SITE_URL.EX_SECONDARY_SALSE_STATEMENT.'">Secondary Sales Statement</a></li>';
			/* EOF to hide unused Reports by Ayush Giri on 14-07-2017 */
		}
		
		/* BOF to hide unused Reports by Ayush Giri on 14-07-2017 */
		/* if(checkPermission('nonexcisesecondsal_view'))
		{
			echo '<li id="salsereport"><a href="'.SITE_URL.NONEX_SECONDARY_SALSE_STATEMENT.'">Non Excise Secondary Sales Statement</a></li>';
		} */
		/* EOF to hide unused Reports by Ayush Giri on 14-07-2017 */
		
	if(checkPermission('excisesalstmt_view'))
	{
		/* BOF to hide unused Reports by Ayush Giri on 14-07-2017 */
		//echo '<li id="salsereport"><a href="'.SITE_URL.EX_SALSE_STATEMENT.'">Excise Sales Statement</a></li>';
		echo '<li id="salsereport"><a href="'.SITE_URL.EX_SALSE_STATEMENT.'">Sales Statement</a></li>';
		/* EOF to hide unused Reports by Ayush Giri on 14-07-2017 */
	}
	
	/* BOF to hide unused Reports by Ayush Giri on 14-07-2017 */
	/* if(checkPermission('nonexcisesalstmt_view'))
    {
	echo '<li id="salsereport"><a href="'.SITE_URL.NONEX_SALSE_STATEMENT.'">Non Excise Sales Statement</a></li>';
	} */
	/* EOF to hide unused Reports by Ayush Giri on 14-07-2017 */
	
	if(checkPermission('exciseproductledger_view'))
    {
		/* BOF to hide unused Reports by Ayush Giri on 14-07-2017 */
		//echo '<li id="salsereport"><a href="'.SITE_URL.EX_ProductLedger.'">Excise Product Ledger</a></li>';
		echo '<li id="salsereport"><a href="'.SITE_URL.EX_ProductLedger.'">Product Ledger</a></li>';
		/* BOF to hide unused Reports by Ayush Giri on 14-07-2017 */
	} 
	/* BOF to hide unused Reports by Ayush Giri on 14-07-2017 */
	/* if(checkPermission('nonexciseproductledger_view'))
    {
	echo '<li id="salsereport"><a href="'.SITE_URL.NON_ProductLedger.'">Non Excise Product Ledger</a></li>';
	}
	
	
	if(checkPermission('salestaxreturnexcise_view'))
    {
	echo '<li id="salsereport"><a href="'.SITE_URL.EX_SalesTaxReturn.'">Sales Tax Return Excise</a></li>';
	}
	
	if(checkPermission('salestaxreturnnonexcise_view'))
    {
	echo '<li id="salsereport"><a href="'.SITE_URL.NON_SalesTaxReturn.'">Sales Tax Return Non Excise</a></li>';
	} 
	
	if(checkPermission('inexcisereturn_view'))
    {
	echo '<li id="salsereport"><a href="'.SITE_URL.INCOMING_EXCISERETURN.'">Incoming Excise Return</a></li>';
	}  
	
	if(checkPermission('innonexcisereturn_view'))
    {
	echo '<li id="salsereport"><a href="'.SITE_URL.OUTGOING_EXCISERETURN.'">Outgoing Excise Return</a></li>';
	} 
	
	if(checkPermission('innonexcisereturn_view'))
    {
	echo ' <li id="salsereport"><a href="'.SITE_URL.STOCKTRANSFER_EXCISERETURN.'">Stock Transfer Excise Return</a></li>';
	} */
	/* EOF to hide unused Reports by Ayush Giri on 14-07-2017 */
	
	if(checkPermission('marginreport_view'))
    {
		/* BOF to hide unused Reports by Ayush Giri on 14-07-2017 */
		//echo '<li id="salsereport"><a href="'.SITE_URL.MARGINREPORT.'">Margin Report Excise</a></li>';
		echo '<li id="salsereport"><a href="'.SITE_URL.MARGINREPORT.'">Margin Report</a></li>';
		/* EOF to hide unused Reports by Ayush Giri on 14-07-2017 */
	}
	/* BOF to hide unused Reports by Ayush Giri on 14-07-2017 */
	/* if(checkPermission('marginreport_view'))
    {
	echo '<li id="salsereport"><a href="'.SITE_URL.MARGINREPORTNONEXCISE.'">Margin Report Non-Excise</a></li>';
	} */
	/* EOF to hide unused Reports by Ayush Giri on 14-07-2017 */
	if(checkPermission('purchasereport_view'))
    {
	echo '<li id="salsereport"><a href="'.SITE_URL.PURCHASEREPORT.'">Purchase Report</a></li>';
	}
	if(checkPermission('dailysalesreport_view'))
    {
	echo '<li id="salsereport"><a href="'.SITE_URL.DAILYSALSEREPORT.'">Daily Sales Report</a></li>';
	}
	if(checkPermission('salestallyreport_view'))
    {
	echo '<li id="salestallyreport"><a href="'.SITE_URL.SALESTALLYREPORT.'">SALES Tally Report</a></li>';
	}
	/* BOF to hide unused Reports by Ayush Giri on 14-07-2017 */
	/* if(checkPermission('rg23dreport_view'))
    {
		echo '<li id="salsereport"><a href="'.SITE_URL.RG23DREPORT.'">Rg 23D Report</a></li>';
	} */
	/* EOF to hide unused Reports by Ayush Giri on 14-07-2017 */
	
	/* if(checkPermission('chalanreport_view'))
    {
		echo '<li id="salsereport"><a href="'.SITE_URL.CHALANREPORT.'">Chalan Status Report </a></li>';
	}
	if(checkPermission('quotationreport_view'))
    {
		echo '<li id="salsereport"><a href="'.SITE_URL.QUOTATIONREPORT.'">Quotation Report</a></li>';
	}*/
     ?>
    </ul>
            </div>
		</div>
    </li>


    <li id="Masters">
     <a href="#" class="drop"><img src="<?php print SITE_URL.'View/img/master.png'; ?>"/> Manage Users <img src="<?php print SITE_URL.'View/img/arrow-down.png'; ?>"/></a> 
        <div class="dropdown_1column">
          <div class="col_1">
          <ul class="simple">
          <?php
          if(checkPermission('user_view')||checkPermission('user_add')||checkPermission('user_edit'))
          {
		  	 echo '<li id="usermast"><a href="'.SITE_URL.VIEWUSERMASTER.'">User Master</a></li>';
		  }
		  
		   if(checkPermission('privilege_view')||checkPermission('privilege_add')||checkPermission('privilege_edit'))
          {
		  	echo '<li><a href="'.SITE_URL.USERSLIST.'">Add Privilege</a></li>';
		  }
		  
		   if(checkPermission('groupperm_view')||checkPermission('groupperm_add')||checkPermission('groupperm_edit'))
          {  
            echo '<li><a href="'.SITE_URL.GROUPPERMISSION.'">Group Permission</a></li>';
		  }
         
          
      
          ?>
              
           
            
         </ul>
         </div>
		</div>
    </li>
    
  <li class="menu_right"> <a href="#" class="drop"><img src="<?php print SITE_URL.'View/img/seting.png'; ?>"/></a>
  
 
     <div class="dropdown_1column align_right">
	 	            <div class="col_1">
	 	                <ul class="simple">
	 	                    <li><a href="<?php print SITE_URL.CHANGEPASSWORD; ?>">Change Password</a></li>
	 	                    <li><a href="<?php print SITE_URL.LOGOUT; ?>">Logout</a></li>
	 	                </ul>
	 	                
	 	            </div>
			</div>
			
    </li

</ul>
</div>

<span style="float:right; margin-right:20px;"><i class="fa fa-caret-down"></i> <?php echo($_SESSION["SITENAME"]); ?> Instance</span>
<?php } 
else
{

    //echo 'notinsession';
    header("Location: ".SITE_URL.LOGIN);
    
}
?>
</body>
</form>
</html>
