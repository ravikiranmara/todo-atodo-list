<?php

require_once 'LoggerSingleton.php';
require_once 'KLogger.php';
require_once 'constants.php';
require_once 'VersionTable.php';

$logger = LoggerSingleton::GetInstance();
$logger->LogError("log me error");

// get database name
$dbhostname = 'localhost';
$dbname = "tododb";
$username = "dbuser";
$password = "password";

$status = true;

// get handle
$dbhandle = new mysqli($dbhostname, $username, $password, $dbname);
if(false == $dbhandle)
{
    $status = false;
    $logger->LogError("Unable to connect to database : $dbhandle->error");
}

// Create table
if(true == $status)
{
    $status = CreateTable_Version($dbhandle);
    $logger->LogInfo("Create table status : $status");
}

// insert into table
if(true == $status)
{
    $status = InsertInto_Version($dbhandle, $VersionTable_V0MajorVersion, 
        $VersionTable_V0MinorVersion, $VersionTable_dbStateGood, $id);
    $logger->LogInfo("Insert into table status : $status");
}

// select and display record
if(true == $status)
{
    $status = SelectByIdFrom_Version($dbhandle, $id, $MajorVersion, $MinorVersion, $dbState);
    $logger->LogInfo("Select into table status : $status");
}

// display record 
if(true == $status)
{
    $logger->LogInfo("Major - $MajorVersion, Minor - $MinorVersion, dbState - $dbState");
}

// select and display record
if(true == $status)
{
    $status = SelectLastRowFrom_Version($dbhandle, $id, $MajorVersion, $MinorVersion, $dbState);
    $logger->LogInfo("Select into table status : $status");
}

// display record 
if(true == $status)
{
    $logger->LogInfo("Major - $MajorVersion, Minor - $MinorVersion, dbState - $dbState");
}


// delete record
if(true == $status)
{
    $status = DeleteFrom_Version($dbhandle, $id);
    $logger->LogInfo("Delete into table status : $status");
}

// Drop table
if($status == true)
{
    $status = DropTable_Version($dbhandle);
    $logger->LogInfo("Drop table status : $status");
}

?>
