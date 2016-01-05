<?php

/* unit test for UserDetails Table */

require_once 'common_require.php';
require_once 'PasswordTable.php';
require_once 'UserDetailsTable.php';

$logger = LoggerSingleton::GetInstance();
$logger->LogError("******************  USERDETAILS UNIT TEST **************************");

// get database name
$dbhostname = 'localhost';
$dbname = "tododb";
$username = "dbuser";
$password = "password";

global $UserDetailsTable_Name;
global $UserDetailsTable_Id;
global $UserDetailsTable_UserName;


$status = true;

// get handle
$dbhandle = new mysqli($dbhostname, $username, $password, $dbname);
if(false == $dbhandle)
{
    $status = false;
    $logger->LogError("Unable to connect to database : $dbhandle->error");
}

/* setup password table as we have a dependency on it */
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

/** UserDetails Table Operations **/

// check if existing
if(true == $status)
{
    $status = IsExisting_UserDetails($dbhandle);
    $logger->LogInfo("IsExisting UserDetails table status :" . var_export($status, true));
}

// Create table
if(false == $status)
{
    $status = CreateTable_UserDetails($dbhandle);
    $logger->LogInfo("Create UserDetails table status : " . var_export($status, true));
}

// insert into table
$user = 'george_name';
if(true == $status)
{
    $status = InsertInto_UserDetails($dbhandle, $id, $user);
    $logger->LogInfo("Insert into UserDetails table status : " . var_export($status, true));
}

// select and display record
if(true == $status)
{
    $status = SelectByIdFrom_UserDetails($dbhandle, $id, $user);
    $logger->LogInfo("Select into UserDetails table status : " . var_export($status, true));
}

// display record 
if(true == $status)
{
    $logger->LogInfo("userid - $id, username - $user");
}

// update password
$user = "george_newname";
if(true == $status)
{
    $status = UpdateInto_UserDetails($dbhandle, $id, $user);
    $logger->LogInfo("UpdateInto Password table status : " . var_export($status, true));
}

// select and display record
if(true == $status)
{
    $status = SelectByIdFrom_UserDetails($dbhandle, $id, $user);
    $logger->LogInfo("Select into Password table status : " . var_export($status, true));
}

// display record 
if(true == $status)
{
    $logger->LogInfo("userid - $id, username - $user");
}

// delete recored
if(true == $status)
{
    $status = DeleteFrom_UserDetails($dbhandle, $id);
    $logger->LogInfo("Delete from UserDetails table status : " . var_export($status, true));
}

// drop into table
if(true == $status)
{
    $status = DropTable_UserDetails($dbhandle);
    $logger->LogInfo("Drop Password table status : " . var_export($status, true));
}


/** UserDetails Operations End **/

// delete record
if(true == $status)
{
    $status = DeleteFrom_Password($dbhandle, $id);
    $logger->LogInfo("Delete From Password table : " . var_export($status, true));
}

// drop into table
if(true == $status)
{
    $status = DropTable_Password($dbhandle);
    $logger->LogInfo("Drop Password table status : " . var_export($status, true));
}

$logger->LogInfo("Exit from test script");

?>
