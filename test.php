<?php
/*
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 
*/
$id ='';
$emp ='0';

$bla = ' ';
if(!empty($id)){
	echo 'id test';
}

if(!empty($emp)){
	echo 'emp 0';
}

if(!empty($bla)){
	echo 'id -----';
}
 
   function getIP() {
      foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
         if (array_key_exists($key, $_SERVER) === true) {
            foreach (explode(',', $_SERVER[$key]) as $ip) {
               if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
                  return $ip;
               }
            }
         }
      }
   }

$tags=json_decode(file_get_contents('http://getcitydetails.geobytes.com/GetCityDetails?fqcn=192.168.1.30'), true);
if($tags['geobyteslocationcode']!='')
{
  //  echo '<p>Welcome to visitors from '.$tags['geobytesfqcn'].'. '.PHP_EOL ;
}
print_r($tags);
echo PHP_EOL ;
print_r($tags[geobytescity]);
echo PHP_EOL.'<p>The value of GeobytesCity is:'.$tags[geobytescity].'</p>';
