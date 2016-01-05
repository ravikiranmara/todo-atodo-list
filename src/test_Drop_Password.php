<?php

/* unit test for Password Table */

require_once 'common_require.php';
require_once 'PasswordTable.php';
require_once 'UserDetailsTable.php';
require_once 'TodoListTable.php';

$logger = LoggerSingleton::GetInstance();

// get database name
$dbhostname = 'localhost';
$dbname = "tododb";
$username = "dbuser";
$password = "password";

global $PasswordTable_Name;
global $PasswordTable_Id;
global $PasswordTable_Password;
global $PasswordTable_User;
global $UserDetailsTable_Name;

$status = true;

// get handle
$dbhandle = new mysqli($dbhostname, $username, $password, $dbname);
if(false == $dbhandle)
{
    $status = false;
    $logger->LogError("Unable to connect to database : $dbhandle->error");
}

// drop into table
{
    $status = DropTable_UserDetails($dbhandle);
    $logger->LogInfo("Drop Password table status : " . var_export($status, true));
}

// drop table
{
    $status = DropTable_TodoList($dbhandle);
    $logger->LogInfo("Drop TodoList Table status : " . var_export($status, true));
}

// drop into table
{
    $status = DropTable_Password($dbhandle);
    $logger->LogInfo("Drop Password table status : " . var_export($status, true));
}

$dbhandle->close();
$logger->LogInfo("Exit from test script");

?>
