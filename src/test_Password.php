<?php

/* unit test for Password Table */

require_once 'common_require.php';
require_once 'PasswordTable.php';

$logger = LoggerSingleton::GetInstance();
$logger->LogError("******************  PASSWORD UNIT TEST **************************");

// get database name
$dbhostname = 'localhost';
$dbname = "tododb";
$username = "dbuser";
$password = "password";

global $PasswordTable_Name;
global $PasswordTable_Id;
global $PasswordTable_Password;
global $PasswordTable_User;


$status = true;

// get handle
$dbhandle = new mysqli($dbhostname, $username, $password, $dbname);
if(false == $dbhandle)
{
    $status = false;
    $logger->LogError("Unable to connect to database : $dbhandle->error");
}

// check if existing
if(true == $status)
{
    $status = IsExisting_Password($dbhandle);
    $logger->LogInfo("IsExisting Password table status :" . var_export($status, true));
}

// Create table
if(false == $status)
{
    $status = CreateTable_Password($dbhandle);
    $logger->LogInfo("Create Password table status : " . var_export($status, true));
}

// insert into table

$user = 'george';
$password = 'password';
$id = null;
if(true == $status)
{
    $status = InsertInto_Password($dbhandle, $id, $user, $password);
    $logger->LogInfo("Insert into table status : " . var_export($status, true));
}

// select and display record
if(true == $status)
{
    $status = SelectByIdFrom_Password($dbhandle, $id, $user, $password);
    $logger->LogInfo("Select into Password table status : " . var_export($status, true));
}

// display record 
if(true == $status)
{
    $logger->LogInfo("userid - $id, username - $user, password - $password");
}

// update password
if(true == $status)
{
    $status = UpdateInto_Password($dbhandle, $id, $user, "NewPassword");
    $logger->LogInfo("UpdateInto Password table status : " . var_export($status, true));
}

// select and display record
if(true == $status)
{
    $status = SelectByUserFrom_Password($dbhandle, $id, $user, $password);
    $logger->LogInfo("Select into Password table status : " . var_export($status, true));
}

// display record 
if(true == $status)
{
    $logger->LogInfo("userid - $id, username - $user, password - $password");
}

// drop into table
if(true == $status)
{
    $status = DropTable_Password($dbhandle);
    $logger->LogInfo("Drop Password table status : " . var_export($status, true));
}

$logger->LogInfo("Exit from test script");

?>
