<?php 
include('root.php');
include($root_path."GlobalConfig.php");
include("../home/head.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<script type='text/javascript' src='../js/jquery.js'></script>
<link href="../js/datatable/jquery.dataTables.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/datatable/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="../js/datatable/jquery.dataTables.min.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Excise Stock Statement Report</title>
<script>
    function Getpdf()
    {
        window.open('excise_stock_pdf.php', '_blank');
    }
</script>
</head>

<body>
<form id="form1">
<div id="wrapper">
        <?php include '../home/menu.php'; ?>
           <div id="page-wrapper" style="margin: 0px; padding-top: 20px;">
               <div class="row">
                 <div class="col-lg-8" style="width: 100%;">
                     <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i>Excise Stock Statement Report
                            
                            <img src="../img/pdf_icon.png" onclick="Getpdf();" style=" width: 30px; height: 30px; margin-top: -7px; float: right;cursor:pointer"  title="Click To Download As PDF"/>
                            
                            <a href="excise_stock_excel.php" target="_blank" >
                            <img src="../img/excel_icon.png" style=" width: 30px; height: 32px; margin-top: -7px; margin-right: 5px; float: right;cursor:pointer"  title="Click To Download As Excel"/>
                            </a>
                        </div>
                        <div class="panel-body">
                            <div id="ShowData_Div" style=" margin-top:30px; margin-left:0px;">
                                <table id="example" class="display" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>S. No.</th>
                                            <th>Part No.</th>
                                            <th>GroupDesc</th>
                                            <th>Product Description</th>
                                            <th>Tarrif Heading</th>
                                            <th>Quantity</th>
                                            <th>Unit</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php //include("../../Model/DBModel/DbModel.php"); 
										include( "../../Model/ReportModel/StockStatementModel.php"); 

                                        $result =  StockStatementModel::GetExciseStockWithValue();
                                       
                                                while($row=mysql_fetch_array($result, MYSQL_ASSOC)){                                                 
                                                    echo "<tr>";
                                                    echo "<td>".$row["SN"]."</td>";
                                                    echo "<td>".$row["Item_Code_Partno"]."</td>";
                                                    echo "<td>".$row["GroupDesc"]."</td>";
                                                    echo "<td>".$row["Item_Desc"]."</td>";
                                                    echo "<td>".$row["Tarrif_Heading"]."</td>";
                                                    echo "<td>".$row["tot_Qty"]."</td>";
                                                    echo "<td>".$row["UNITNAME"]."</td>";
                                                    echo "</tr>";
                                                }?>



                                   </tbody>
                                </table>
                            </div>
                        </div>
                     </div>
                 </div>
               </div>
           </div>
       </div>
<script type='text/javascript' src='../js/Report_js/stockstatement.js'></script>
<style>
    tr.group,
tr.group:hover {
    background-color: #ddd !important;
}
</style>
<br/><br/><br/><br/>
</form>
<script src="../js/boot_js/bootstrap.min.js"></script>
<script src="../js/boot_js/plugins/metisMenu/metisMenu.min.js"></script>
<script src="../js/boot_js/sb-admin-2.js"></script>
</body>
</html>
