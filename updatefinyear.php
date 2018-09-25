<?php
function updateFinancialYear($searchfor){
$file = 'finyear.txt';
$next_year  = (int)$searchfor  + 1 ;
$new_finYear = $searchfor.'-'.$next_year;
		// the following line prevents the browser from parsing this as HTML.
		header('Content-Type: text/plain');

		// get the file contents, assuming the file to be readable (and exist)
		$contents = file_get_contents($file);
		// escape special characters in the query
		$pattern = preg_quote($next_year, '/');
		// finalise the regular expression, matching the whole line
		$pattern = "/^.*$pattern.*\$/m";
		// search, and store all matching occurences in $matches
		
		if(preg_match_all($pattern, $contents, $matches)){
		   echo "Found matches:\n";
		   echo implode("\n", $matches[0]);
		}else{
			$new_finYear.="\n".$contents;
			file_put_contents($file,$new_finYear);
		}
}
$year = date("Y");
if((strtotime($year.'-04-01')- strtotime(date("Y-m-d"))) == 0){
	updateFinancialYear($year);
}

/*
 chron jon for 1/4/16
 00 00 01 04 * /home/public_html/updatefinyear.php
 
 */
 
?>

