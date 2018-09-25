<?php
class generatePdf {
	public $mpdf;
	function __construct () {
		$this->mpdf = new mPDF('utf-8', array(152.4, 152.4));
	}
	function writeHtml ($html) {
		$this->mpdf->WriteHTML($html);
	}
	function AddPage () {
		$this->mpdf->AddPage();
	}
	function Output ($arg1, $arg2) {
		$this->mpdf->Output($arg1, $arg2);
	}
}
