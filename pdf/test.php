<?php
error_reporting(2);
require_once('mpdf60/mpdf.php'); 
 $pdf = new mPDF('utf-8', array(152.4, 152.4));
$pdf->WriteHTML("dsfdsf");   
$pdf->Output();
exit;
