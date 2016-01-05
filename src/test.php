<?php

require_once 'LoggerSingleton.php';
require_once 'KLogger.php';

$logger = LoggerSingleton::GetInstance();
$logger->LogError("log me error");


?>
