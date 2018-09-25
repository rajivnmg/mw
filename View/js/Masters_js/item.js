function LoadItem(){
$(".flexme4").flexigrid({
    url: '../../Controller/Master_Controller/Item_Controller.php?TYP=&TAG=&ID=',
                dataType : 'json',
                colModel : [ {display : 'Item ID',name : 'ITEMID', width : 50,sortable : false, align : 'center'},
                {display : 'Group Code',name : 'GC', width : 100,sortable : false, align : 'left'},
                {display : 'Group Descp',name : 'GD', width : 150,sortable : false, align : 'left'},
                {display : 'Principal Name',name : 'PNAME', width : 150,sortable : false, align : 'left'},
                {display : 'Item Code Part NO', name : 'ITEM_CODE_PARTNO', width : 100, sortable : false, align : 'left' },
                {display : 'Item DESCP', name : 'ITME_DESCP', width : 100, sortable : false, align : 'left' },
                {display : 'Unit Name', name : 'UNITNAME', width : 50,sortable : false,align : 'left'},
                {display : 'Item Identification Mark',name : 'ITEM_IDENTIFICATION_MARK',width : 100,sortable : false, align : 'left'},
				/* BOF for replacing Tarrif with HSN Code by Ayush Giri on 07-06-2017 */ 
                //{display : 'Item Tarrif Heading',name : 'ITEM_TARRIF_HEADING',width : 150,sortable : false,align : 'left'},
				{display : 'HSN CODE',name : 'HSN_CODE',width : 150,sortable : false,align : 'left'},
				/* EOF for replacing Tarrif with HSN Code by Ayush Giri on 07-06-2017 */
				{display : 'Tax Rate',name : 'TAX_RATE',width : 150,sortable : false,align : 'left'},
                {display : 'Item Cost Price', name : 'ITEM_COST_PRICE', width : 150, sortable : false, align : 'left'},
                {display : 'LSC', name : 'LSC',width : 100,sortable : false,align : 'left'},
                { display: 'USC', name: 'USC', width: 100, sortable: false, align: 'left' },
				/* BOF for merging Excise and Non Excise quantity  by Ayush Giri on 08-06-2017 */
                //{ display: 'Excise Quantity', name: 'exq', width: 100, sortable: false, align: 'left' },
                //{ display: 'Non-Excise Quantity', name: 'nexq', width: 100, sortable: false, align: 'left' },
				{ display: 'Quantity', name: 'qty', width: 100, sortable: false, align: 'left' },
				/* EOF for merging Excise and Non Excise quantity  by Ayush Giri on 08-06-2017 */
                {display : 'Remarks',name : 'REMARKS',width : 200,sortable : false,align : 'left'},
                {display : 'Blocked',name : 'blocked',width : 200,sortable : false,align : 'left'},],
                buttons : [ {
                        name : 'New',
                        bclass : 'new',
                        onpress : NewGroup
                    },
                    {
                        name : 'Edit',
                        bclass : 'edit',
                        onpress : EditItem
                    }
                    ,
                    {
                        separator : true
                    }
                ],
                searchitems : [ {
                    display : 'City Id',
                    name : 'CITYID'
                    }, {
                        display : 'City Name',
                        name : 'CITYNAME',
                        isdefault : false
                } ],
                sortorder : "asc",
                usepager : true,
                //title : 'Item Master',
                useRp : true,
                rp : 10,
                //page: 1,
                //total: 1,
                showTableToggleBtn : false,
                width : 1330,
                height : 300,
                singleSelect: true
            });
}
LoadItem();
function SearchItem(Type) { 
    var Id = 0;
    switch (Type) {
        case "G":
            Id = $("#gd_search").val();
            break;
        case "P":
            Id = $("#principal_search").val();
            break;
        case "U":
            Id = $("#unit_search").val();
            break;
        case "I":
            Id = $("#identification_search").val();
            break;
        case "C":
            Id = $("#txt_search_codepart").val();
            break;
        case "D":
            Id = $("#txt_search_codepart_desc").val();
            break;
        case "L":
            break;
        case "U":
            break;
        case "E":
            break;
        case "N":
            break;
        default:
            break;
    }
    var newurl = "";
	var group = $("#gd_search").val();
	var principal  = $("#principal_search").val();
	var unit  = $("#unit_search").val();
	var identity  = $("#identification_search").val();
	if(Type == "C"){ 		
				newurl = "../../Controller/Master_Controller/Item_Controller.php?TYP=&TAG=" + Type + "&ID="+Id+"&group="+group+"&principal="+principal+"&unit=" + unit+"&identity=" + identity;
			
	}else if(Type == "D"){ 
			
				newurl = "../../Controller/Master_Controller/Item_Controller.php?TYP=&TAG=" + Type + "&ID=" + Id+"&group=" + group+"&principal=" + principal+"&unit=" + unit+"&identity=" + identity;
			
	}else{	
			if (Id > 0 || Id != '') {
				newurl = "../../Controller/Master_Controller/Item_Controller.php?TYP=&TAG=" + Type + "&ID=" + Id;
			}
			else {
				newurl = "../../Controller/Master_Controller/Item_Controller.php?TYP=&TAG=" + Type + "&ID=0";
			}
		}
   
    $(".flexme4").flexOptions({ url: newurl });
    $(".flexme4").flexReload();
}
function Cancle(){
$("#Form_Div").hide();
$("#ShowData_Div").show();
$("#btnadditem").show();
$("#btnupdateitem").hide()
$("#btnBlockitem").hide()
$("#btnuUnblockitem").hide();
//document.getElementById("ir").value = "";
//document.getElementById("irid").value = "";
Exception.clear();
}
function NewGroup(){
$("#ShowData_Div").hide();
$("#Form_Div").show();
$("#btnadditem").show();
$("#btnupdateitem").hide();
$("#btnBlockitem").hide()
$("#btnuUnblockitem").hide();
document.getElementById("item_id").value = "";
document.getElementById("txtcodepart").value = "";
document.getElementById("txtdesc").value = "";
/* BOF for replacing Tarrif with HSN Code by Ayush Giri on 07-06-2017 */ 
//document.getElementById("txttarif").value = "";
document.getElementById("hsn_c").value = 0;
/* BOF for replacing Tarrif with HSN Code by Ayush Giri on 07-06-2017 */ 
document.getElementById("txtcostprice").value = "";
document.getElementById("txtlsc").value = "";
document.getElementById("txtusc").value = "";
document.getElementById("txtremarks").value = "";
document.getElementById("gd").value = 0;
document.getElementById("gd2").value = 0;
document.getElementById("ddlunit").value = 0;
}
function EditItem(com, grid) {
        if (com == 'Edit') {
        if(true){
            $.each($('.trSelected', grid),
                function (key, value) {
                    // collect the data
                    var id = value.children[0].innerText || value.children[0].textContent;
                    jQuery.ajax({
                        url: "../../Controller/Master_Controller/Item_Controller.php",
                        type: "POST",
                        data: { TYP: "LOADITEM", ITEMID: id },
                        //cache: false,
                        success: function (jsondata) {
                            var objs = jQuery.parseJSON(jsondata);
                            if (jsondata != "") {
                                document.getElementById("item_id").value = objs[0]._item_id;
                                document.getElementById("txtcodepart").value = objs[0]._item_code_partno;
                                document.getElementById("txtdesc").value = objs[0]._item_descp;
                                //document.getElementById("txttarif").value = objs[0]._item_tarrif_heading;
								document.getElementById("hsn_c").value = objs[0]._hsn_code;
								document.getElementById("txttaxrate").value = objs[0]._tax_rate;
                                document.getElementById("txtcostprice").value = objs[0]._item_cost_price;
                                document.getElementById("txtlsc").value = objs[0]._lsc;
                                document.getElementById("txtusc").value = objs[0]._usc;
                                document.getElementById("txtremarks").value = objs[0]._remarks;
                                $("#gd").val(objs[0]._group_id);
                                $("#gd2").val(objs[0]._principal_id);
                                $("#ddlunit").val(objs[0]._unit_id);
                                $("#ddlidentification").val(objs[0]._item_identification_marks);
                                //                                $("#gd option[title='" + value.children[2].innerText || value.children[2].textContent + "']").attr("selected", "true");
                                //                                $("#gd2 option[title='" + value.children[3].innerText || value.children[3].textContent + "']").attr("selected", "true");
                                //                                $("#ddlunit option[title='" + value.children[6].innerText || value.children[6].textContent + "']").attr("selected", "true");
                                //                                $("#ddlidentification option[title='" + value.children[7].innerText || value.children[7].textContent + "']").attr("selected", "true");

                                $("#Form_Div").show();
                                $("#ShowData_Div").hide();
                                $("#btnadditem").hide();
                                
                                $("#btnupdateitem").show();
                                if(objs[0]._blocked =='Yes'){
										$("#btnBlockitem").hide()
										$("#btnuUnblockitem").show();
								}else{
										$("#btnBlockitem").show()
										$("#btnuUnblockitem").hide();
								}
                                
                                document.getElementById('txtcodepart').focus();
                            }
                        }
                    });


                });
        }
    }
}
function AddItemMaster() {
    Exception.validate("form1");
    var result = Exception.validStatus;

    if (result) {

        var TYPE = "INSERT";
        var groupid = document.getElementById("gd").value;
        var principalid = document.getElementById("gd2").value;
        var codepartno = document.getElementById("txtcodepart").value;
        var descp = document.getElementById("txtdesc").value;
        var unitid = document.getElementById("ddlunit").value;
        var identificationmark = document.getElementById("ddlidentification").value;
	var newidentification = document.getElementById("newidentification").value;
		/* BOF for replacing Tarrif with HSN Code by Ayush Giri on 08-06-2017 */
        //var tarrifheading = document.getElementById("txttarif").value;
		var hsn_code = document.getElementById("hsn_c").value;
		/* EOF for replacing Tarrif with HSN Code by Ayush Giri on 08-06-2017 */
        var costprice = document.getElementById("txtcostprice").value;
        var lsc = document.getElementById("txtlsc").value;
        var usc = document.getElementById("txtusc").value;
        var remarks = document.getElementById("txtremarks").value;
	if((identificationmark == "NEW") && (newidentification.trim().length > 0)){ 
		if (descp != "" && principalid > 0) {
		    jQuery.ajax({
		        url: "../../Controller/Master_Controller/Item_Controller.php",
		        type: "POST",
				/* BOF for replacing Tarrif with HSN Code by Ayush Giri on 08-06-2017 */
		        //data: { TYP: TYPE, GROUPID: groupid, PRINCIPALID: principalid, ITEM_CODE_PARTNO: codepartno, ITME_DESCP: descp, UNITID: unitid, ITEM_IDENTIFICATION_MARK: identificationmark, ITEM_TARRIF_HEADING: tarrifheading, ITEM_COST_PRICE: costprice, LSC: lsc, USC: usc, REMARKS: remarks,NEWIDENTIFICATION: newidentification},
				data: { TYP: TYPE, GROUPID: groupid, PRINCIPALID: principalid, ITEM_CODE_PARTNO: codepartno, ITME_DESCP: descp, UNITID: unitid, ITEM_IDENTIFICATION_MARK: identificationmark, HSN_CODE: hsn_code, ITEM_COST_PRICE: costprice, LSC: lsc, USC: usc, REMARKS: remarks,NEWIDENTIFICATION: newidentification},
				/* EOF for replacing Tarrif with HSN Code by Ayush Giri on 08-06-2017 */
		        //cache: false,
		        success: function (jsondata) {
		            if (jsondata != "") {
		                document.getElementById("txtcodepart").value = "";
		                $(".flexme4").flexReload();
		                $("#Form_Div").hide();
		                $("#ShowData_Div").show();
		            }
		            else {
		            }
		        }
		    });
		}
	}else if(identificationmark != "NEW"){
		if (descp != "" && principalid > 0) {
		    jQuery.ajax({
		        url: "../../Controller/Master_Controller/Item_Controller.php",
		        type: "POST",
				/* BOF for replacing Tarrif with HSN Code by Ayush Giri on 08-06-2017 */
		        //data: { TYP: TYPE, GROUPID: groupid, PRINCIPALID: principalid, ITEM_CODE_PARTNO: codepartno, ITME_DESCP: descp, UNITID: unitid, ITEM_IDENTIFICATION_MARK: identificationmark, ITEM_TARRIF_HEADING: tarrifheading, ITEM_COST_PRICE: costprice, LSC: lsc, USC: usc, REMARKS: remarks },
				data: { TYP: TYPE, GROUPID: groupid, PRINCIPALID: principalid, ITEM_CODE_PARTNO: codepartno, ITME_DESCP: descp, UNITID: unitid, ITEM_IDENTIFICATION_MARK: identificationmark, HSN_CODE: hsn_code, ITEM_COST_PRICE: costprice, LSC: lsc, USC: usc, REMARKS: remarks },
				/* EOF for replacing Tarrif with HSN Code by Ayush Giri on 08-06-2017 */
		        //cache: false,
		        success: function (jsondata) {
		            if (jsondata != "") {
		                document.getElementById("txtcodepart").value = "";
		                $(".flexme4").flexReload();
		                $("#Form_Div").hide();
		                $("#ShowData_Div").show();
		            }
		            else {
		            }
		        }
		    });
		}
	}else{
		alert("Please Enter New Identification Mark!");
			
	}
	
    }
}
function UpdateItemMaster() { 
    Exception.validate("form1");
    var result = Exception.validStatus;
    if (result) {
	
        var TYPE = "UPDATE";
        var item_id = document.getElementById("item_id").value.replace(/(\r\n|\n|\r)/gm, "");
        var codepartno = document.getElementById("txtcodepart").value;
        var descp = document.getElementById("txtdesc").value;
        var identificationmark = document.getElementById("ddlidentification").value;
		/* BOF for replacing Tarrif with HSN Code by Ayush Giri on 08-06-2017 */
        //var tarrifheading = document.getElementById("txttarif").value;
		var hsn_code = document.getElementById("hsn_c").value;
		/* BOF for replacing Tarrif with HSN Code by Ayush Giri on 08-06-2017 */
        var costprice = document.getElementById("txtcostprice").value;
        var lsc = document.getElementById("txtlsc").value;
        var usc = document.getElementById("txtusc").value;
        var remarks = document.getElementById("txtremarks").value;
        var group = document.getElementById("gd").value;
        var principal = document.getElementById("gd2").value;
        var unit = document.getElementById("ddlunit").value;
        var identification = document.getElementById("ddlidentification").value;

        if (descp != "") {
            jQuery.ajax({
                url: "../../Controller/Master_Controller/Item_Controller.php",
                type: "POST",
				/* BOF for replacing Tarrif with HSN Code by Ayush Giri on 08-06-2017 */
                //data: { TYP: TYPE, ITEMID: item_id, ITEM_CODE_PARTNO: codepartno, ITME_DESCP: descp, ITEM_IDENTIFICATION_MARK: identificationmark, ITEM_TARRIF_HEADING: tarrifheading, ITEM_COST_PRICE: costprice, LSC: lsc, USC: usc, REMARKS: remarks, GID: group, PID: principal, UID: unit, IDENTITY: identification},
				data: { TYP: TYPE, ITEMID: item_id, ITEM_CODE_PARTNO: codepartno, ITME_DESCP: descp, ITEM_IDENTIFICATION_MARK: identificationmark, HSN_CODE: hsn_code, ITEM_COST_PRICE: costprice, LSC: lsc, USC: usc, REMARKS: remarks, GID: group, PID: principal, UID: unit, IDENTITY: identification},
				/* EOF for replacing Tarrif with HSN Code by Ayush Giri on 08-06-2017 */
                //cache: false,
                success: function (jsondata) {
                    if (jsondata != "") {
                        $(".flexme4").flexReload();
                        $("#Form_Div").hide();
                        $("#ShowData_Div").show();
                    }
                    else {
                    }
                }
            });
        }
    }
}

// function to block/Unblock the item from added on 29-june 2018 
function BlockUnblockItem(block) { 
	
	if(block == 'Yes'){
			var isConfirmed = confirm("Are you sure to BLOCK this Item ?");
	}else{
			var isConfirmed = confirm("Are you sure to UNBLOCK this Item ?");
	}
     
      if(isConfirmed){
        var TYPE = "BlockUnBlockItem";
        var item_id = document.getElementById("item_id").value.replace(/(\r\n|\n|\r)/gm, "");
        var blocked = block;
        
            jQuery.ajax({
                url: "../../Controller/Master_Controller/Item_Controller.php",
                type: "POST",
				/* BOF for replacing Tarrif with HSN Code by Ayush Giri on 08-06-2017 */
                //data: { TYP: TYPE, ITEMID: item_id, ITEM_CODE_PARTNO: codepartno, ITME_DESCP: descp, ITEM_IDENTIFICATION_MARK: identificationmark, ITEM_TARRIF_HEADING: tarrifheading, ITEM_COST_PRICE: costprice, LSC: lsc, USC: usc, REMARKS: remarks, GID: group, PID: principal, UID: unit, IDENTITY: identification},
				data: { TYP: TYPE, ITEMID: item_id, blocked: blocked},
				/* EOF for replacing Tarrif with HSN Code by Ayush Giri on 08-06-2017 */
                //cache: false,
                success: function (jsondata) {
                    if (jsondata != "") {
                        $(".flexme4").flexReload();
                        $("#Form_Div").hide();
                        $("#ShowData_Div").show();
                    }
                    else {
                    }
                }
            });
      }else{
        return false;
      }
}



// function to add new Identification Mark 14-1-2016
function NewIdentificationMark(val){
	if(val=="NEW"){
		$("#newidentificationDiv").show();
	}else{
		$("#newidentificationDiv").hide();
	}
}

/* BOF for showing tax rate with HSN Code by Ayush Giri on 15-06-2017 */
function selectTAX(val)
{
	var TYPE = "SELECT_TAX";
	jQuery.ajax({
		url: "../../Controller/Master_Controller/Item_Controller.php",
		type: "POST",
		data: { TYP: TYPE, HSN_CODE: val },
		//cache: false,
		success: function (jsondata) {
			var objs = jQuery.parseJSON(jsondata);
			if (jsondata != "") {
				$('#txttaxrate').val(objs);
			}
			else {
				$('#txttaxrate').val(objs);
			}
		}
	});
}
/* EOF for showing tax rate with HSN Code by Ayush Giri on 15-06-2017 */
