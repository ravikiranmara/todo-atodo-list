<?php

// includees
require_once 'common_require.php';
require_once 'all_upgrades.php';
require_once 'VersionTable.php';

global $VersionTable_V0MajorVersion;
global $VersionTable_V0MinorVersion;

// enter current version here
$CurrentMajorVersion = $VersionTable_V0MajorVersion;
$CurrentMinorVersion = $VersionTable_V0MinorVersion;

/**
* IsUpgradable 
* Add code to check if database can be upgraded from current version
*
* @param $dbhandle  handle to database
* @return $status   true if operation was successful
*/
function IsUpgradable($dbhandle)
{
    $status = true;

    return $status;
}

/**
* UpgradeDatabase
* Add code to perform actual database updgrad operation 
*
* @param $dbhandle  handle to database
* @return $status   true if operation was successful
*/
function UpgradeDatabase($dbhandle)
{
    $status = true;

    $status = V_Major0_Minor0_Upgrade($dbhandle);

    return $status;
}

/**
* UpdateDatabaseState
* Add code to perform actual database updgrad operation 
*
* @param $dbhandle  handle to database
* @return $status   true if operation was successful
*/
function UpdateDatabaseState($dbhandle, $state)
{
    $logger = LoggerSingleton::GetInstance();
    $logger->LogInfo("UpdateDatabaseState - Enter ($state)");

    $logger->LogInfo("UpdateDatabaseState - Get last row of version table");
    $status = SelectLastRowFrom_Version($dbhandle, $id, $MajorVersion, $MinorVersion, $dbState);
    if(false == $status)
    {
        $logger->LogError("UpdateDatabaseState - Unable to get last row");
    }

    if(true == $status)
    {
        $logger->LogInfo("UpdateDatabaseState - Update last row with the db state");
        $status = UpdateInto_Version($dbhandle, $id, $MajorVersion, $MinorVersion, $state);
        if(false == $status)
        {
            $logger->LogError("UpdateDatabaseState - Unable to change to new state $state");
        }
    }
    
    $logger->LogInfo("UpdateDatabaseState status - $status");
    return $status;
}

// main
{
    $logger = LoggerSingleton::GetInstance();
    $logger->LogError("*************************************************************");
    $logger->LogError("*\n*  TODO LIST  SETUP \n*\n");
    $logger->LogError("*************************************************************");

/*    if ($argc < 4)
    {
        die("Invalid Syntax. Try : $argv[0] <database name> <username> <password>\n");
    }
 */

    // get database name
    $dbhostname = 'localhost';
    $dbname = 'tododb';
    $username = 'dbuser';
    $password = 'password';
    global $VersionTable_dbStateGood;
    $dbStateGood = $VersionTable_dbStateGood;

    $status = true;

    $logger->LogInfo("Main - Open connection to db");
    $dbhandle = new mysqli($dbhostname, $username, $password, $dbname);
    if($dbhandle->connect_error == true)
    {
        $logger->LogError("Unable to open connection to $dbname : $dbhandle->error");
        $status = false;
    }

    if(true == $status)
    {
        $logger->LogInfo("Checking if this is new deployment");
        if(IsExisting_Version($dbhandle) == false)
        {
            $logger->LogInfo("its a new deployment. Create table");
            $status = CreateTable_Version($dbhandle);

            if($status == false)
            {
                $logger->LogInfo("Unable to create version table");
            }

            else    
            {
                $logger->LogInfo("Insert row into table");
                $status = InsertInto_Version($dbhandle, $id, $CurrentMajorVersion, 
                    $CurrentMinorVersion, $dbStateGood); 
                if(false == $status)
                {
                    $logger->LogInfo("Unable to create row with version zero");
                }
            }
        }
    }

    if(true == $status)
    {
        $logger->LogInfo("checking the version, and if it is upgradable");
        $status = IsUpgradable($dbhandle);

        if(false == $status)
        {
            $logger->LogError("Unable to upgrade the database from current version");
        }
    }

    if(true == $status)
    {
        $logger->LogInfo("Moving database to Upgrading state");

        $dbstate = $VersionTable_dbStateUpgrading;
        $status = UpdateDatabaseState($dbhandle, $dbstate);
        if(false == $status)
        {
            $logger->LogError("Unable to move $dbname to upgrading state\n");
        }
    }

    /* Performing the actual upgrade operation here */
    if(true == $status)
    {
        $logger->LogInfo("Perform actual upgrade operation");
        $status = UpgradeDatabase($dbhandle);
    }

    if(true == $status)
    {
        $logger->LogInfo("moving database to ready state");

        $dbstate = $VersionTable_dbStateGood;
        $status = UpdateDatabaseState($dbhandle, $dbstate);
        if(false == $status)
        {
            $logger->LogError("Error moving $dbname to ready state");
        }
    }
    else    // we were not able to successfully upgrade
    {
        $logger->LogInfo("moving database to bad state");
        $dbState = $VersionTable_dbStateBad;
        $status = UpdateDatabaseState($dbhandle, $dbState);
        if(false == $status)
        {
            $logger->LogError("Error moving $dbname to Bad state");
        }
    }

    $logger->LogError("End of program");
}


?>
