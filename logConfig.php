<?php
// Include and configure log4php
include('log4php/Logger.php'); 
array( 
'appenders' => array( 
'myAppender' => array( 
'class' => 'LoggerAppenderRollingFile', 
'layout' => array( 
'class' => 'LoggerLayoutPattern', 
'params' => array('conversionPattern' => '%date{d.m.Y H:i:s,u} %logger %-5level From:%server{REMOTE_ADDR}:%server{REMOTE_PORT} Request:[%request] %msg%n%ex')), 
'params' => array( 
'file' => __DIR__ . '/log/log.log', 
'maxFileSize' => '1MB', 
'maxBackupIndex' => '20'))), 
'loggers' => array(), 
'renderers' => array(), 
'rootLogger' => array( 
'level' => 'info', 
'appenders' => array('myAppender'))); 

?>