<?php
/*
Version Table
contains code for CRUd on version table
*/

require_once 'common_require.php';

/**
* Check if Version table exists
*
* @param    $dbhandle   handle to the database
* @return   $status     true if table exists
*/
function IsExisting_Version($dbhandle)
{
    $logger = LoggerSingleton::GetInstance();
    $logger->LogInfo("IsExisting_Version : Enter");

    global $VersionTable_Name;

    // check if table exists
    $query = "SELECT 1 FROM $VersionTable_Name LIMIT 1";
    $status = $dbhandle->query($query);

    $logger->LogInfo("IsExisting_Version : Exit - ");
    return $status;
}


/**
* Creates Version table. 
*
* @param    $dbhandle   handle to the database
* @return   $status     true if he operation is successful
*/
function CreateTable_Version($dbhandle)
{
    $logger = LoggerSingleton::GetInstance();
    $logger->LogInfo("CreateTable_Version : Enter");

    global $VersionTable_Id;
    global $VersionTable_Name;
    global $VersionTable_MajorVersion;
    global $VersionTable_MinorVersion;
    global $VersionTable_DbState;
    global $VersionTable_Notes;

    $query = "CREATE TABLE $VersionTable_Name
        (
            $VersionTable_Id INT NOT NULL AUTO_INCREMENT, 
            $VersionTable_MajorVersion INT NOT NULL,
            $VersionTable_MinorVersion INT NOT NULL, 
            $VersionTable_DbState INT NOT NULL, 
            PRIMARY KEY($VersionTable_Id)
        )";

    // create table
    $status = $dbhandle->query($query);

    if(false == $status)
    {
        $logger->LogError("CreateTable_Version : Unable to create table - 
                            $dbhandle->error");    
    }

    $logger->LogInfo("CreateTable_Version : Status - $status");
    return $status;
}


/**
* Drops Version table. All the data in the table is deleted. 
*
* @param    $dbhandle   handle to the database
* @return   $status     true if he operation is successful
*/

function DropTable_Version($dbhandle)
{
    $logger = LoggerSingleton::GetInstance();
    $logger->LogInfo("DropTable_Version : enter");

    global $VersionTable_Name;

    $query = "DROP TABLE $VersionTable_Name";
    $status = $dbhandle->query($query);

    if(false == $status)
    {
        $logger->LogError("DeleteTable_Version : Unable to Delete table - 
                            $dbhandle->error");    
    }

    $logger->LogInfo("DeleteTable_Version : Status - $status");
    return $status;
}

/**
* Insert row into tables
* 
* @param    table variables
* @param    $id      passed by reference. returns primar key of row 
* @return   $status  true if the operation is successful
*/
function InsertInto_Version($dbhandle, &$id, $MajorVersion, $MinorVersion, $dbState)
{
    $logger = LoggerSingleton::GetInstance();
    $logger->LogInfo("InsertInto_Version : Enter");

    global $VersionTable_Id;
    global $VersionTable_Name;
    global $VersionTable_MajorVersion;
    global $VersionTable_MinorVersion;
    global $VersionTable_DbState;
    $status = true;

    // validate input argumets
    if(IsNullOrEmptyString($MajorVersion) || IsNullOrEmptyString($MinorVersion) 
        || IsNullOrEmptyString($dbState)) 
    {
        $logger->LogError("InsertInto_Version : Null or empty input parameters
            Major - IsNullOrEmptyString($MajorVersion),
                Minor - IsNullOrEmptyString($MinorVersion),
                     dbState - IsNullOrEmptyString($dbState)");
        $status = false;
    }

    // insert a version row
    if(true == $status)
    {
        $query = "INSERT INTO $VersionTable_Name 
        (   $VersionTable_MajorVersion, $VersionTable_MinorVersion, $VersionTable_DbState
        ) 
        VALUES
        (   $MajorVersion, $MinorVersion, $dbState
        )";

        $status = $dbhandle->query($query);
        if(true == $status)
        {
            $id = $dbhandle->insert_id;
        }

        if(false == $status)
        {
            $logger->LogError("InsertInto_Version : Unable to insert record - $dbhandle->error");
        }
    }

    $logger->LogInfo("InsertInto_Version : $status");
    return $status;
}

/**
* Update row into tables. This is not a selective upgrade where
* we upgrade only few fields. the whole row is written back. 
* 
* @param    table variables
* @param    $id      provide id of the record to update
* @return   $status  true if the operation is successful
*/
function UpdateInto_Version($dbhandle, $id, $MajorVersion, $MinorVersion, $dbState)
{
    $logger = LoggerSingleton::GetInstance();
    $logger->LogInfo("UpdateInto_Version : Enter");

    global $VersionTable_Id;
    global $VersionTable_Name;
    global $VersionTable_MajorVersion;
    global $VersionTable_MinorVersion;
    global $VersionTable_DbState;
    $status = true;

    // validate input argumets
    if(IsNullOrEmptyString($MajorVersion) || IsNullOrEmptyString($MinorVersion) 
        || IsNullOrEmptyString($dbState) || IsNullOrEmptyString($id)) 
    {
        $logger->LogError("UpdateInto_Version : Null or empty input parameters");
        $status = false;
    }

    // update a version row
    $query = null;
    if(true == $status)
    {
        $query = "UPDATE $VersionTable_Name SET 
            $VersionTable_MajorVersion = $MajorVersion,
            $VersionTable_MinorVersion = $MinorVersion,
            $VersionTable_DbState = $dbState
            WHERE $VersionTable_Id = $id";
         
        // execute update query
        $status = $dbhandle->query($query);
    }

    if(false == $status)
    {
        $logger->LogError("UpdateInto_Version : Unable to insert record - $dbhandle->error");
    }
 
    $logger->LogInfo("UpdateInto_Version : $status");
    return $status;
}

/**
* Select row into tables
* 
* @param    table variables
* @param    $id      provide id of the record to retrieve
* @param    rest to return values by reference // not a good idea
* @return   $status  true if the operation is successful
*/
function SelectByIdFrom_Version($dbhandle, $id, &$MajorVersion, &$MinorVersion, &$dbState)
{
    $logger = LoggerSingleton::GetInstance();	
    $logger->LogInfo("SelectByIdFrom_Version : Enter ($id)");

    global $VersionTable_Id;
    global $VersionTable_Name;
    global $VersionTable_MajorVersion;
    global $VersionTable_MinorVersion;
    global $VersionTable_DbState;

    // select
    $query = "SELECT * FROM $VersionTable_Name 
            WHERE $VersionTable_Id = $id";

    // execte
    $result = $dbhandle->query($query);

    if(FALSE == $result)
    {
        $logger->LogError("SelectByIdFrom_Vesion : No records with id - $id found");
        $status = false;
    }

    $num_rows = $result->num_rows;
    if($num_rows > 0)
    {
        while($row = $result->fetch_assoc())
        {
            $MajorVersion = $row["$VersionTable_MajorVersion"];
            $MinorVersion = $row["$VersionTable_MinorVersion"];
            $dbState = $row["$VersionTable_DbState"];
        }

        $status = true;
    } 
    else
    {
        $logger->LogError("SelectByIdFrom_Vesion : No records found");
        $status = false;
    }

    return $status;
} 

/**
* Select row into tables
* 
* @param    table variables
* @param    $id      provide id of the record to retrieve
* @param    rest to return values by reference // not a good idea
* @return   $status  true if the operation is successful
*/
function SelectLastRowFrom_Version($dbhandle, &$id, &$MajorVersion, &$MinorVersion, &$dbState)
{
    $logger = LoggerSingleton::GetInstance();
    $logger->LogInfo("SelectLastRowFrom_Version : Enter");

    global $VersionTable_Id;
    global $VersionTable_Name;
    global $VersionTable_MajorVersion;
    global $VersionTable_MinorVersion;
    global $VersionTable_DbState;

    // select
    $query = "SELECT * FROM $VersionTable_Name 
            ORDER BY $VersionTable_Id DESC LIMIT 1";

    // execte
    $result = $dbhandle->query($query);

    if($result->num_rows > 0)
    {
        while($row = $result->fetch_assoc())
        {
            $MajorVersion = $row["$VersionTable_MajorVersion"];
            $MinorVersion = $row["$VersionTable_MinorVersion"];
            $dbState = $row["$VersionTable_DbState"];
            $id = $row["$VersionTable_Id"];
        }

        $status = true;
    } 
    else
    {
        $logger->LogError("SelectLastRowFrom_Vesion : No records found");
        $status = false;
    }

    return $status;
} 


/**
* Delete row into tables
* 
* @param    $id      provide id of the record to delete
* @return   $status  true if the operation is successful
*/
function DeleteFrom_Version($dbhandle, $id)
{
    $logger = LoggerSingleton::GetInstance();
    $logger->LogInfo("DeleteFrom_Version : Enter");

    global $VersionTable_Id;
    global $VersionTable_Name;
    global $VersionTable_MajorVersion;
    global $VersionTable_MinorVersion;
    global $VersionTable_DbState;

    // select
    $query = "DELETE FROM $VersionTable_Name WHERE $VersionTable_Id = $id";

    // execte
    $status = $dbhandle->query($query);

    if(false == $status)
    {
        $logger->LogError("DeleteFrom_Version : Could not delete record - $dbhandle->error");
    }

    return $status;
} 


?>
