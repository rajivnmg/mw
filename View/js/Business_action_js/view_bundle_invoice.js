var URL = "../../Controller/Business_Action_Controller/BundleInvoice_Controller.php";
var method = "POST";
var BuyerList = {};
function CallToBuyer(BuyerList) {
    'use strict';
    var buyerArray = $.map(BuyerList, function (value, key) { return { value: value, data: key }; });
    // Initialize ajax autocomplete:
    $('#autocomplete-ajax-buyer').autocomplete({
        //serviceUrl: '/autosuggest/service/',
        lookup: buyerArray,
        lookupFilter: function (suggestion, originalQuery, queryLowerCase) {
            var re = new RegExp('\\b' + $.Autocomplete.utils.escapeRegExChars(queryLowerCase), 'gi');
            return re.test(suggestion.value);
        },
        onSelect: function (suggestion) {
            ActionOnBuyer(suggestion.value, suggestion.data);
            //$('#selction-ajax-buyer').html('You selected: ' + suggestion.value + ', ' + suggestion.data);
        },
        onHint: function (hint) {
            //$('#autocomplete-ajax-x-buyer').val(hint);
        },
        onInvalidateSelection: function () {
            NoneBuyer();
            //$('#selction-ajax-buyer').html('You selected: none');F
        }
    });
}
function ActionOnBuyer(value, data) {
    if (value != "" && data > 0) {
        $("#buyerid").val(data);
        //SearchByBuyer();
    }
}
function NoneBuyer() {
    $("#buyerid").val(0);
    $('.outgoing_bundle_invoice_list').flexOptions({ url: URL });
    $('.outgoing_bundle_invoice_list').flexReload();
}
var PrincipalList = {};
function CallToPrincipal(PrincipalList) {
    'use strict';
    var principalArray = $.map(PrincipalList, function (value, key) { return { value: value, data: key }; });
    // Initialize ajax autocomplete:
    $('#autocomplete-ajax-principal').autocomplete({
        //serviceUrl: '/autosuggest/service/',
        lookup: principalArray,
        lookupFilter: function (suggestion, originalQuery, queryLowerCase) {
            var re = new RegExp('\\b' + $.Autocomplete.utils.escapeRegExChars(queryLowerCase), 'gi');
            return re.test(suggestion.value);
        },
        onSelect: function (suggestion) {
            ActionOnPrincipal(suggestion.value, suggestion.data);
            //$('#selction-ajax-principal').html('You selected: ' + suggestion.value + ', ' + suggestion.data);
        },
        onHint: function (hint) {
            //$('#autocomplete-ajax-x-principal').val(hint);
        },
        onInvalidateSelection: function () {
            NonePrincipal();
            //$('#selction-ajax-principal').html('You selected: none');
        }
    });
}
$( document ).ready(function() {
    jQuery.ajax({
    url: "../../Controller/Master_Controller/Principal_Controller.php",
    type: "post",
    data: { TYP: "SELECT", PRINCIPALID: 0 },
    success: function (jsondata) {
        var objs = jQuery.parseJSON(jsondata);
        if (jsondata != "") {
            var obj;
            for (var i = 0; i < objs.length; i++) {
                var obj = objs[i];
                PrincipalList[obj._principal_supplier_id] = obj._principal_supplier_name;
            }
            CallToPrincipal(PrincipalList);
        }
    }
});
});

///////////////////////////////// added due to page loading performance on 25-11-2015 by Codefire
 function loadBuyerByName(buyer){ 
	if(buyer.length > 1 && buyer.length < 3){ 
		jQuery.ajax({
			url: "../../Controller/Master_Controller/Buyer_Controller.php",
			type: "post",
			data: { TYP: "SELECT", BUYERID: 0, BUYERNAME: buyer },
			success: function (jsondata) { 
			
				var objs = jQuery.parseJSON(jsondata);
				
				if (jsondata != "") {
					var obj;
					for (var i = 0; i < objs.length; i++) {
						var obj = objs[i];
						BuyerList[obj._buyer_id] = obj._buyer_name;
					}
					
					CallToBuyer(BuyerList);
				}
			}
		});
	}else{
		CallToBuyer(BuyerList);
	}
}
function ActionOnPrincipal(value, data) {
    if (value != "" && data > 0) {
        $("#principalid").val(data);
        //SearchByPrincipal();
    }
}
function NonePrincipal() {
    $("#principalid").val(0);
    $('.outgoing_bundle_invoice_list').flexOptions({ url: URL });
    $('.outgoing_bundle_invoice_list').flexReload();
}
function LoadOutgoingInvoiceNonExcise() {
    //alert('url'+ URL);
    $(".outgoing_bundle_invoice_list").flexigrid({
        url: "",
        dataType: 'json',
        colModel: [{ display: 'Invoice ID', name: 'oinvoice_exciseID', width: 100, sortable: false, align: 'center', process: HitMe },
                { display: 'Invoice Number', name: 'oinvoice_No', width: 200, sortable: false, align: 'left' },
                { display: 'Purchase Order Number', name: 'pono', width: 200, sortable: false, align: 'left' },
                { display: 'Invoice Date', name: 'oinv_date', width: 200, sortable: false, align: 'left' },
                { display: 'Purchase Order Date', name: 'po_date', width: 200, sortable: false, align: 'left' },
                { display: 'Buyer Name', name: 'Buyer_Name', width: 200, sortable: false, align: 'left' },
                { display: 'Principal Name', name: 'Principal_Name', width: 260, sortable: false, align: 'left'}],
        // buttons: [{name: 'New',bclass: 'new',onpress: NewGroup},
        //         {name: 'Edit',bclass: 'edit',onpress: EditItem},
        //      {separator: true}],
        sortorder: "asc",
        usepager: true,
        //title: 'Quation Master',
        useRp: true,
        rp: 10,
        showTableToggleBtn: false,
        width: 1360,
        height: 400
    });
}
function HitMe(celDiv, id) {
    //$(celDiv).click(function () {
        //var OutgoingInvoiceNonExciseNum = celDiv.innerText;
	$(celDiv).bind("click", function () {
	    var OutcomingInvoiceBundleNonExciseNum = celDiv.innerHTML;
        jQuery.ajax({
            url: URL,
            type: "post",
            data: { TYP: "GET_OINV_NUM_BY_DISPLAY", DISPLAYID: OutcomingInvoiceBundleNonExciseNum,YEAR:$("#ddlfinancialyear").val() },
            success: function (jsondata) {
                var obj = jQuery.parseJSON(jsondata);
                var OutcomingInvoiceBundleNonExciseNum = parseInt(obj);
                var path = 'new_bundle_invoice.php?TYP=SELECT&bundle=' + OutcomingInvoiceBundleNonExciseNum;
                window.location.href = path;
            }
        });
    });
}

function SearchOutgoingBundleInvoiceExcise() {
    var oinv = $('#txtinvoicenumber').val();
    var Buyerid = $('#buyerid').val();
    var Principalid = $('#principalid').val();
    var Fromdate = $("#txtdatefrom").val();
    var Todate = $("#txtdateto").val();
    var year = $("#ddlfinancialyear").val();
    var path = URL + '?TYP=SEARCH&YEAR='+year+'&oinv=' + oinv + '&Todate=' + Todate + '&Fromdate='+Fromdate+'&Principalid='+ Principalid +'&Buyerid='+Buyerid;
	$(".outgoing_bundle_invoice_list").flexOptions({ url: path });
    $(".outgoing_bundle_invoice_list").flexReload();
}

LoadOutgoingInvoiceNonExcise();
