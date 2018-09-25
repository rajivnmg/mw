﻿var URL = "../../Controller/Business_Action_Controller/IncomingInvoiceNonExcise_controller.php";
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
function ActionOnPrincipal(value, data) {
    if (value != "" && data > 0) {
        $("#principalid").val(data);
        //SearchByPrincipal(data);
    }
}
function NonePrincipal() {
    $("#principalid").val(0);
}
function LoadIncomingInvoiceNonExciseData() {
   // alert("here");
    $(".flexme4").flexigrid({
        url: "",
        dataType: 'json',
        colModel: [{ display: 'Invoice ID', name: 'INCOMININVOICENONEXCISEID', width: 100, sortable: true, align: 'center', process: procme },
                             { display: 'Invoice Number', name: 'INCOMININVOICENONEXCISENUMBER', width: 160, sortable: true, align: 'left' },
                                 { display: 'Invoice Receive Date', name: 'rece_date', width: 170, sortable: true, align: 'left' },   
                             { display: 'Date', name: 'DATE', width: 150, sortable: true, align: 'left' },
                             { display: 'Principal', name: 'PRINCIPALNAME', width: 330, sortable: true, align: 'left' },
                             { display: 'Supplier', name: 'SUPPLIERNAME', width: 210, sortable: true, align: 'left' },
                             { display: 'Bill Amount', name: 'BILLAMOUNT', width: 170, sortable: true, align: 'left' }
                         ],
       // buttons: [{ name: 'Edit', bclass: 'edit', onpress: UserMasterGrid }, { separator: true}],
        //searchitems : [ { display : 'USERID', name : 'USERID'}, { display : 'PASSWD', name : 'PASSWD', isdefault : false } ],
        sortorder: "asc",
        usepager: true,
        //title : 'UNIT Master',
        useRp: true,
        rp: 10,
        showTableToggleBtn: false,
        width: 1310,
        height: 400

    });

}
LoadIncomingInvoiceNonExciseData();

function procme(celDiv,id)
{
$(celDiv).click(function(){
var displayid=celDiv.innerText;
jQuery.ajax({
    url: URL,
    type: "post",
    data: { TYP: "GET_WIN_NUM_BY_DISPLAY", DISPLAYID: displayid,YEAR:$("#ddlfinancialyear").val() },
    success: function (jsondata) {
        var obj = jQuery.parseJSON(jsondata);
        var IncomingInvoiceNonExciseNum = parseInt(obj);
        //alert(IncomingInvoiceExciseNum);
        var path = 'invoice_incoming_nonexciseduty.php?TYP=SELECT&ID=' + IncomingInvoiceNonExciseNum;
        //alert(path);
        window.location.href = path;
    }
});
});
}
function SearchByPrincipal(Principalid) {
    var path = URL + '?TYP=SEARCH&coulam=Principal&val1=' + Principalid + "&val2=&val3=&val4=";
    $(".flexme4").flexOptions({ url: path });
    $(".flexme4").flexReload();
}
function SearchIncomingInvoiceNonExcise() {
    var iin =$("#txtinvoicenumber").val();
    var Fromdate = $("#txtdatefrom").val();
    var Todate = $("#txtdateto").val();
    var principalId = $("#principalid").val();
    var year = $("#ddlfinancialyear").val();
    var path = URL + '?TYP=SEARCH&YEAR='+year+'&val1=' + iin + '&val2='+Fromdate+ '&val3=' +Todate+ '&val4='+principalId;
   // alert(path);
    $(".flexme4").flexOptions({ url: path });
    $(".flexme4").flexReload();
}
SearchIncomingInvoiceNonExcise();
/*
$('#txtinvoicenumber').on('keypress', function (e) {
    var code = (e.keyCode ? e.keyCode : e.which);
    if (code == 13) {
        e.preventDefault();
        if ($('#txtinvoicenumber').val() != "") {
            var path = URL + '?TYP=SEARCH&coulam=InvoiceNumber&val1=' + $('#txtinvoicenumber').val() + '&val2=&val3=&val4=';
            $(".flexme4").flexOptions({ url: path });
            $(".flexme4").flexReload();
        }
        else {
            $(".flexme4").flexOptions({ url: URL });
            $(".flexme4").flexReload();
        }
    }
});
*/
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
