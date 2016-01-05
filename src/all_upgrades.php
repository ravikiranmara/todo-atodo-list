<?php

// includes
require_once 'common_require.php';
require_once 'VersionTable.php';
require_once 'PasswordTable.php';
require_once 'UserDetailsTable.php';
require_once 'TodoListTable.php';

/**
* Upgrades for MajorVersion = 0, MinorVersion = 0
*
* Add code to perform actual database updgrad operation 
* For first version, create supporting tables
*
* @param $dbhandle  handle to database
* @return $status   true if operation was successful
*/
function V_Major0_Minor0_Upgrade($dbhandle)
{
    $logger = LoggerSingleton::GetInstance();
    $logger->LogInfo("V0_0_Upgrade - Enter ");
    $status = true;

    /* create password table if not persent */
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

    /* Create UserDetails table if not present */
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

    /* Create TodoList table if not present already */
    if(true == $status)
    {
        $status = IsExisting_TodoList($dbhandle);
        $logger->LogInfo("IsExisting TodoList table status :" . var_export($status, true));
    }

    // Create table
    if(false == $status)
    {
        $status = CreateTable_TodoList($dbhandle);
        $logger->LogInfo("Create TodoList table status : " . var_export($status, true));
    }

    $logger->LogInfo("Exit form V_Major0_Minor0_Upgrade with status :" . var_export($status, true));

    return $status;
}

?>
