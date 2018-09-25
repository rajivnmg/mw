<?php
require_once($root_path."Config.php");
$alink = $_SERVER['PHP_SELF'];
$actual_url = strstr($alink,"View");
define("DASHBOARD",'View/home/Dashboard.php');
define("SalesExecutiveDASHBOARD",'View/SalesExecutive/Dashboard.php');
define("ManagementDASHBOARD",'View/ManageManagement/Dashboard.php');
define("INDEX",'index.php');
define('LOGIN','index.php');
define('LOGOUT','logout.php');
//###################
define('GROUPPERMISSION','View/masters/GroupPermission.php');
define('USERSLIST','View/masters/UsersList.php');
define('UPDATEUSRPASSWORD','View/masters/updateUserPassword.php');

//#################
define('USERMASTER','View/masters/CreateUser.php');
define('VIEWUSERMASTER','View/masters/userinfo.php');
define('UserMenu','View/masters/UserMenu.php');
define('ADMINHOME','AdminHome.php');

define('UNITMASTER','View/masters/unit.php');
define("GROUPMASTER",'View/masters/group.php');
define("STATEMASTER",'View/masters/state.php');
define('CITYMASTER','View/masters/city.php');
define("LOCATIONMASTER",'View/masters/location.php');
define("ITEMMASTER",'View/masters/item.php');

define('PRINCIPALMASTER','View/masters/principal.php?ID=');
define('VIEWPRINCIPALMASTER','View/masters/ViewPrincipal.php');

define("SUPPLIERMASTER",'View/masters/supplier.php?ID=');
define("VIEWSUPPLIERMASTER",'View/masters/ViewSupplier.php');

define("BUYERMASTER",'View/masters/buyer.php?ID=');
define("VIEWBUYERMASTER",'View/masters/ViewBuyer.php');
/* BOF for adding TAX Master and HSN Master by Ayush Giri on 06-06-2017 */
define("TAXMASTER",'View/masters/taxmaster.php');
define("HSNMASTER",'View/masters/hsnmaster.php');
/* EOF for adding TAX Master and HSN Master by Ayush Giri on 06-06-2017 */
define("MANAGECOMPANYINFO",'View/masters/companyinfo.php');

define("CHANGEPASSWORD",'View/masters/ChangePassword.php');
define("LOGINUSER",'View/masters/LoginUser.php');


define("QUATION",'View/Business_View/quotation.php?QUOTATIONNUMBER=');
define("VIEWQUATION",'View/Business_View/viewQuotation.php');
define("PRINTQUATION",'View/Business_View/quotation_report.php');
define("PRINTQUATIONPDF",'pdf/quot.php');

define("NEW_INCOMINGINVOICENONEXCISE",'View/Business_View/invoice_incoming_nonexciseduty.php?ID=');
define("VIEW_INCOMINGINVOICENONEXCISE",'View/Business_View/IncomingInvoiceNonExciseView.php');

define("PO",'View/Business_View/purchaseorder.php?POID=&USER=&fromPage=');
define("BUNDLE_PO",'View/Business_View/bundle.php?POID=&USER=&fromPage=');
define("VIEWPO",'View/ViewPurchaseOrder.php');
define("POSEARCH",'View/Business_View/Search.php');
define("POsMS",'View/Business_View/PO_Approval_Form.php');

define("POSCHEDULE",'View/Business_View/po_schedule.php?POID=');

define("NEW_STOCK_TRANSFER",'View/Business_View/StockTransfer.php?ID=');
define("VIEW_STOCK_TRANSFER",'View/Business_View/StockTransferView.php');

define("VIEW_STOCK_Check",'View/Business_View/StockCheck.php?POID=');

define("NEW_CHALLAN",'View/Business_View/Challan.php?ID=');
define("VIEW_CHALLAN",'View/Business_View/ChallanView.php');
define("PRINTCHALLAN",'View/Business_View/print_challan.php');
define("PRINTCHALLANPDF",'pdf/chalan.php');

define("NEW_INCOMING_INVOICE_EXCISE",'View/Business_View/new_incoming_invoice_excise.php?IncomingInvoiceExciseNum=');
define("VIEW_INCOMING_INVOICE_EXCISE",'View/Business_View/view_incoming_invoice_excise.php');
define("PRINT_INCOMING_INVOICE_EXCISE",'View/Business_View/print_incoming_invoice_excise.php');

define("NEW_OUTGOING_INVOICE_EXCISE",'View/Business_View/new_Outgoing_Invoice_Excise.php?OutgoingInvoiceNonExciseNum=');
define("VIEW_OUTGOING_INVOICE_EXCISE",'View/Business_View/view_Outgoing_Invoice_Excise.php');
define("PRINT_OUTGOING_INVOICE_EXCISE",'View/Business_View/print_outgoingexcise.php');
define("PRINT_INVOICE",'View/Business_View/print_type.php');

define("NEW_OUTGOING_INVOICE_NonEXCISE",'View/Business_View/new_Outgoing_Invoice_NonExcise.php?OutgoingInvoiceNonExciseNum=');
define("VIEW_OUTGOING_INVOICE_NonEXCISE",'View/Business_View/view_Outgoing_Invoice_NonExcise.php');
define("PRINT_OUTGOING_INVOICE_NonEXCISE",'View/Business_View/print_outgoingNonExcise.php');

define("NEW_BUNDLE_INVOICE",'View/Business_View/new_bundle_invoice.php?bundle=');
define("VIEW_BUNDLE_INVOICE",'View/Business_View/view_bundle_invoice.php');
define("PRINT_BUNDLE_INVOICE",'View/Business_View/print_bundle.php');

define("PO_APPROVE",'View/Business_View/PO_Approval_Form.php');

define("SALSE_PURCHASE_REPORT",'View/ReportView/SalseReport.php');

define("STOCK_REPORT",'View/ReportView/stock_report.php');
define("EX_STOCK_STMT_WV",'View/ReportView/excise_stockstatement.php');
define("EX__NEX_CHALLAN_STOCK_STMT",'View/ReportView/excise_nonexcise_challan_stockstatement.php');
define("NONEX_STOCK_STMT_WV",'View/ReportView/nonexcise_stockstatement.php');

define("EX_STOCK_STMT_DATE_WV",'View/ReportView/excise_ondate_stockstatement.php');
define("NONEX_STOCK_STMT_DATE_WV",'View/ReportView/nonexcise_ondate_stockstatement.php');

define("EX_STOCK_STMT",'View/ReportView/excise_stock.php');
define("STOCKLEVELREPORT",'View/ReportView/stockLevelReport.php');
define("NONEX_STOCK_STMT",'View/ReportView/non_excise_stock.php');

define("EX_SECONDARY_SALSE_STATEMENT",'View/ReportView/SecondarySalesStatement.php');
define("NONEX_SECONDARY_SALSE_STATEMENT",'View/ReportView/NonSecondarySalesStatement.php');

define("EX_SALSE_STATEMENT",'View/ReportView/SalesStatement.php');
define("NONEX_SALSE_STATEMENT",'View/ReportView/NonSalesStatement.php');

define("PO_PENDING_STATEMENT",'View/ReportView/po_pending_report.php');
define("PO_DELIVERD_STATEMENT",'View/ReportView/po_delivered_report.php');
define("PO_PARTIAL_DELIVERED_STATEMENT",'View/ReportView/po_partial_delivered_report.php');

define("EX_ProductLedger",'View/ReportView/ProductLedgerExcise.php');
define("NON_ProductLedger",'View/ReportView/ProductLedgerNonExcise.php');

define("EX_SalesTaxReturn",'View/ReportView/SalesTaxReturnExcise.php');
define("NON_SalesTaxReturn",'View/ReportView/SalesTaxReturnNonExcise.php');

define("INCOMING_EXCISERETURN",'View/ReportView/incomingexcisereturn.php');
define("OUTGOING_EXCISERETURN",'View/ReportView/outgoingexcisereturn.php');
define("STOCKTRANSFER_EXCISERETURN",'View/ReportView/stocktransferexcisereturn.php');

define("OINVOICE_PAYMENT_PENDING_LIST",'View/ReportView/outgoing_invoice_payment_pending_list.php');
define("OINVOICE_BUYER_PAYMENT_PENDING_LIST",'View/ReportView/outgoing_invoice_Buyer_payment_pending_list.php');
define("VIEW_BUYER_WISE_REVENUE",'View/ReportView/buyer_wise_revenue_report.php');
define("VIEW_FINALCIAL_YEAR_WISE_REVENUE",'View/ReportView/finalcial_year_wise_revenue_report.php');

define("MARGINREPORT",'View/ReportView/marginreport.php');
define("MARGINREPORTNONEXCISE",'View/ReportView/marginreportNonExcise.php');


define("PURCHASEREPORT",'View/ReportView/purchasereport.php');
define("DAILYSALSEREPORT",'View/ReportView/dailysalesreport.php');
define("SALESTALLYREPORT",'View/ReportView/salestally_report.php');

define("RG23DREPORT",'View/ReportView/rg_23d_report.php');
//define("PAYMENT",'View/Business_View/payment.php?BUYERID=');
define("PAYMENT",'View/Business_View/payment.php?trxnId=');
define("PAYMENT_RECEIVED_LIST",'View/Business_View/payment_received_list.php');

?>
