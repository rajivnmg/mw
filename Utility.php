<?php
Class Utility
{
	function writelog($content)
	{		
		$myFile = "../../log/LOG.txt";
		if (file_exists($myFile)) {
		  $fh = fopen($myFile, 'a');
		  fwrite($fh, $content."\n\n\n");
		} else {
		  $fh = fopen($myFile, 'w');
		  fwrite($fh, $content."\n\n\n");
		}
		fclose($fh);
	}
}



?>