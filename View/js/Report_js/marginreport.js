var URL = "../../Controller/ReportController/SalseReportController.php";
var method = "POST";
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
function ActionOnPrincipal(value, data) {
    if (value != "" && data > 0) {
        $("#principalid").val(data);
       // Search("PRINCIPAL",data);
    }
}
function NonePrincipal() {
    $("#principalid").val(0);
}
﻿var BuyerList = {};
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
            //$('#selction-ajax-buyer').html('You selected: none');
        }
    });
}
/*
jQuery.ajax({
    url: "../../Controller/Master_Controller/Buyer_Controller.php",
    type: "post",
    data: { TYP: "SELECT", BUYERID: 0 },
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
*/

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

function ActionOnBuyer(value, data) {
    //$("#new_buyer").show();
    if (value != "" && data > 0) {
        $("#buyerid").val(data);
      //  Search("BUYER",data);
    }
}
function NoneBuyer() {
    $("#buyerid").val(0);
}

function Loadmarginreport() {
    //alert('url'+ URL);
    $(".marginreport").flexigrid({
        url: "",
        dataType: 'json',
        colModel: [{ display: 'S. No.', name: 'SN', width: 50, sortable: false, align: 'center' },
                { display: 'Invoice No.', name: 'oinvoice_No', width: 110, sortable: false, align: 'left' },
                { display: 'Invoice Date', name: 'oinv_date', width: 110, sortable: false, align: 'left' },
                { display: 'Principal Name', name: 'Principal_Supplier_Name', width: 350, sortable: false, align: 'left' },
                { display: 'Buyer Name', name: 'BuyerName', width: 250, sortable: false, align: 'left' },
                { display: 'CodePart', name: 'Item_Code_Partno', width: 120, sortable: false, align: 'left' },
				{ display: 'CodePart Desc', name: 'codePartNo_desc', width: 250, sortable: false, align: 'left' },
                { display: 'Issued Qty.', name: 'issued_qty', width: 80, sortable: false, align: 'right'},
                { display: 'Selling Price', name: 'Salling', width: 100, sortable: false, align: 'right'},
                { display: 'Landing Price', name: 'landing_price', width: 100, sortable: false, align: 'right'},
                { display: 'Margin', name: 'Margin', width: 100, sortable: false, align: 'right'},
                { display: '% Margin', name: 'percentageMargin', width: 100, sortable: false, align: 'right'},
                { display: 'Bill Amount', name: 'bill_value', width: 100, sortable: false, align: 'right'},
				{ display: 'Industry Segment', name: 'ms', width: 70, sortable: false, align: 'left'}
        ],
        sortorder: "asc",
        usepager: true,
        useRp: true,
        rp: 10,
        showTableToggleBtn: false,
        width: 1280,
        height: 300
    });
}
Loadmarginreport();
function Search(type,value) {
    var Fromdate = $("#txtdatefrom").val();
    var Todate = $("#txtdateto").val();
    var finyear = $("#ddlfinancialyear").val();
    var marketsegment = $("#marketsegment").val();
    
    var principalid = $("#principalid").val();
    var buyerid = $("#buyerid").val();
    var txtinvoicenumber = $('#txtinvoicenumber').val();
    var path = URL + '?TYP=MARGINREPORT'+'&todate='+Todate+'&fromdate='+Fromdate+'&principalid='+principalid+'&buyerid='+ buyerid+'&txtinvoicenumber='+txtinvoicenumber+"&finyear="+finyear+"&marketsegment="+marketsegment;
    if (Fromdate != "" && Todate != "") {
        $('.marginreport').flexOptions({ url: path });
        $('.marginreport').flexReload();
    }
    else {
        alert("Please select date");
    }
}
$('#txtinvoicenumber').on('keypress', function (e) { return false;
	var Fromdate = $("#txtdatefrom").val();
    var Todate = $("#txtdateto").val();
    var code = (e.keyCode ? e.keyCode : e.which);
    if (code == 13) {
	     e.preventDefault();
        if ($('#txtinvoicenumber').val() != "") {
            var path = URL + '?TYP=MARGINREPORT'+'&todate='+Todate+'&fromdate='+Fromdate+'&tag=INVOICENO&value=' + $('#txtinvoicenumber').val();
            $(".marginreport").flexOptions({ url: path });
            $(".marginreport").flexReload();
        }
    }
});
function Getpdf() {
    var Fromdate = $("#txtdatefrom").val();
    var Todate = $("#txtdateto").val();
    var finyear = $("#ddlfinancialyear").val();
    var marketsegment = $("#marketsegment").val();
    
    var principalid = $("#principalid").val();
    var buyerid = $("#buyerid").val();
    var txtinvoicenumber = $('#txtinvoicenumber').val();
    if (Fromdate != "" && Todate != "") { 
		window.open('marginreport_pdf.php?todate='+Todate+'&fromdate='+Fromdate+'&principalid='+principalid+'&buyerid='+ buyerid+'&txtinvoicenumber='+txtinvoicenumber+"&finyear="+finyear+"&marketsegment="+marketsegment,'_blank');
    }else {
        alert("Please select date");
    }
}
function Getexcel() {
   var Fromdate = $("#txtdatefrom").val();
    var Todate = $("#txtdateto").val();
    var finyear = $("#ddlfinancialyear").val();
    var marketsegment = $("#marketsegment").val();
    
    var principalid = $("#principalid").val();
    var buyerid = $("#buyerid").val();
    var txtinvoicenumber = $('#txtinvoicenumber').val();
    if (Fromdate != "" && Todate != "") { 
		window.open('marginreport_excel.php?todate='+Todate+'&fromdate='+Fromdate+'&principalid='+principalid+'&buyerid='+ buyerid+'&txtinvoicenumber='+txtinvoicenumber+"&finyear="+finyear+"&marketsegment="+marketsegment,'_blank');
    }else {
        alert("Please select date");
    }
}
