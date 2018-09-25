<?php



$html = '<style>@page{
     margin: 40px;
    }</style>
<div style="padding: 0; margin: 60px auto 0; width: 710px; overflow: hidden;">

	<div class="double" style="margin: 10px 0 0; width: auto;">
    	<div class="common left" style="padding: 0; width: 220px; float: left;">
        	<div class="img">
            	<img src="http://192.168.1.93/mpdf60/examples/img220x175.jpg" alt="" />
            </div>
        </div>
        <div class="common right" style="padding: 0; width: 220px; float: right;">
            <div class="img">
				<img src="http://192.168.1.93/mpdf60/examples/img220x175.jpg" alt="" />
            </div>
        </div>
        <div style="clear: both; overflow: hidden; height: 0;"></div>
    </div>
    
    <div class="single" style="margin: 40px 0 0; width: auto;">
    	<div class="fullimage">
            <div class="img">
	            <img src="http://192.168.1.93/mpdf60/examples/img524x275.jpg" alt="" />
            </div>

        </div>
    </div>
    
</div>

';

$html1 = '<div class="imagedrive" style="padding: 25px; margin: auto; width: 710px; overflow: hidden;">

	<div class="double">
    	<div class="common" style="padding: 0; width: 461px;">
        	<div class="img">
            	<img src="http://192.168.1.93/mpdf60/examples/img461x135.jpg" alt="" />
            </div>
        </div>
        <div class="common" style="margin: 30px 0; width: 461px;">
        	<div class="img">
            	<img src="http://192.168.1.93/mpdf60/examples/img461x135.jpg" alt="" />
            </div>
        </div>
        <div class="common" style="padding: 0; width: 461px;">
        	<div class="img">
            	<img src="http://192.168.1.93/mpdf60/examples/img461x135.jpg" alt="" />
            </div>
        </div>
    </div>
    
</div>
';
//==============================================================
//==============================================================
//==============================================================
include("../mpdf.php");
$mpdf=new mPDF('utf-8', array(152,152));
$mpdf->WriteHTML($html);
$mpdf->AddPage();
$mpdf->WriteHTML($html1);
$mpdf->Output();
exit;
//==============================================================
//==============================================================
//==============================================================
//==============================================================
//==============================================================


?>