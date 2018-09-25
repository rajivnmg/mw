<?php
define ("ASPECT_RATION_2D4375X5D25", "2D4375X5D25"); // (2D4375/5D25) = .46
define ("ASPECT_RATION_5D25X5D25", "5D25X5D25"); // (5D25/5D25) = 1
define ("ASPECT_RATION_5D25X2D4375", "5D25X2D4375"); //(5D25/2D4375) = 2.15
define ("ASPECT_RATION_2D4375X2D4375", "2D4375X2D4375"); //(2D4375/2D4375) = 1


define ("MIN_2D4375X5D25", .35);
define ("MAX_2D4375X5D25", .74);

define ("MIN_5D25X5D25", 0.75);
define ("MAX_5D25X5D25", 1.25);

define ("MIN_5D25X2D4375", 1.75);
define ("MAX_5D25X2D4375", 2.50);

define ("MIN_2D4375X2D4375", .75);
define ("MAX_2D4375X2D4375", 1.25);


define ("TPL_1_L", "tpl_1_large.php");
define ("TPL_2V", "tpl_2_verticle.php");
define ("TPL_2H", "tpl_2_horizontal.php");
define ("TPL_2H_1V", "tpl_2_horizontal_1_verticle.php");
define ("TPL_2V_1H", "tpl_2_verticle_1_horizontal.php");
define ("TPL_2V_2H", "tpl_2_verticle_2_horizontal.php");

function processImages ($src) {
	$path = "/var/www/image_pdf/images/";
	list($width, $height) = getimagesize($path . $src);
	$ratio = $width / $height;
	
	$imgTpl = null;
	if($ratio > MIN_5D25X5D25 && $ratio < MAX_5D25X5D25) {
		$imgTpl = ASPECT_RATION_5D25X5D25;
	} else if($ratio > MIN_5D25X5D25 && $ratio < MAX_5D25X5D25) {
		$imgTpl = ASPECT_RATION_5D25X5D25;
	} else if($ratio > MIN_5D25X2D4375 && $ratio < MAX_5D25X2D4375) {
		$imgTpl = ASPECT_RATION_5D25X2D4375;
	} else if($ratio > MIN_2D4375X5D25 && $ratio < MAX_2D4375X5D25) {
		$imgTpl = ASPECT_RATION_2D4375X5D25;
	} else {
		$imgTpl = "DEFAULT";
	}
	return array($imgTpl, $src);
}
