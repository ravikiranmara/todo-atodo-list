<?php
/* 
UserDetails table
Contains crud operations for UserDetails table
*/

require_once 'common_require.php';

/**
* Check if UserDetails table exists
*
* @param    $dbhandle   handle to the database
* @return   $status     true if table exists
*/
function IsExisting_UserDetails($dbhandle)
{
    $logger = LoggerSingleton::GetInstance();
    $logger->LogInfo("IsExisting_UserDetails : Enter");

    global $UserDetailsTable_Name;

    // check if table exists
    $query = "SELECT 1 FROM $UserDetailsTable_Name LIMIT 1";
    $status = $dbhandle->query($query);

    $logger->LogInfo("IsExisting_UserDetails : Exit - ");
    return $status;
}


/**
* Creates UserDetails table. 
*
* @param    $dbhandle   handle to the database
* @return   $status     true if he operation is successful
*/
function CreateTable_UserDetails($dbhandle)
{
    $logger = LoggerSingleton::GetInstance();
    $logger->LogInfo("CreateTable_UserDetails : Enter");
    
    global $UserDetailsTable_Name;
    global $UserDetailsTable_Id;
    global $UserDetailsTable_UserName;
    global $PasswordTable_Name;
    global $PasswordTable_Id;

    $query = "CREATE TABLE $UserDetailsTable_Name
        (
            $UserDetailsTable_Id INT NOT NULL AUTO_INCREMENT, 
            $UserDetailsTable_UserName VARCHAR(15) UNIQUE, 
            CONSTRAINT FOREIGN KEY($UserDetailsTable_Id)
            REFERENCES $PasswordTable_Name($PasswordTable_Id)
            ON DELETE CASCADE
        )";

    // create table
    $status = $dbhandle->query($query);

    if(false == $status)
    {
        $logger->LogError("CreateTable_UserDetails : Unable to create table - 
                            $dbhandle->error");    
    }

    $logger->LogInfo("CreateTable_UserDetails : Status - $status");
    return $status;
}


/**
* Drops UserDetails table. All the data in the table is deleted. 
*
* @param    $dbhandle   handle to the database
* @return   $status     true if he operation is successful
*/

function DropTable_UserDetails($dbhandle)
{
    $logger = LoggerSingleton::GetInstance();
    $logger->LogInfo("DropTable_UserDetails : enter");

    global $UserDetailsTable_Name;

    $query = "DROP TABLE $UserDetailsTable_Name";
    $status = $dbhandle->query($query);

    if(false == $status)
    {
        $logger->LogError("DeleteTable_UserDetails : Unable to Delete table - 
                            $dbhandle->error");    
    }

    $logger->LogInfo("DeleteTable_UserDetails : Status - $status");
    return $status;
}

/**
* Insert row into tables
* 
* @param    table variables
* @param    $id      passed by reference. returns primar key of row 
* @return   $status  true if the operation is successful
*/
function InsertInto_UserDetails($dbhandle, &$id, $user)
{
    $logger = LoggerSingleton::GetInstance();
    $logger->LogInfo("InsertInto_UserDetails : Enter");

    global $UserDetailsTable_Id;
    global $UserDetailsTable_Name;
    global $UserDetailsTable_UserName;
    $status = true;

    // validate input argumets
    if(IsNullOrEmptyString($user))
    {
        $logger->LogError("InsertInto_UserDetails : Null or empty input parameters");
        $status = false;
    }

    // insert a UserDetails row
    if(true == $status)
    {
        $query = "INSERT INTO $UserDetailsTable_Name 
            (   $UserDetailsTable_UserName
        ) 
        VALUES
        (   '$user'
        )";

        $status = $dbhandle->query($query);
        if(true == $status)
        {
            $id = $dbhandle->insert_id;
        }

        if(false == $status)
        {
            $logger->LogError("InsertInto_UserDetails : Unable to insert record - $dbhandle->error");
        }
    }

    $logger->LogInfo("InsertInto_UserDetails : $status");
    return $status;
}

/**
* Update row into tables
* 
* @param    table variables
* @param    $id      passed by reference. returns primar key of row 
* @return   $status  true if the operation is successful
*/
function UpdateInto_UserDetails($dbhandle, $id, $user)
{
    $logger = LoggerSingleton::GetInstance();
    $logger->LogInfo("UpdateInto_UserDetails : Enter");

    global $UserDetailsTable_Id;
    global $UserDetailsTable_Name;
    global $UserDetailsTable_UserName;
    $status = true;

    // validate input argumets
    if(IsNullOrEmptyString($user))
    {
        $logger->LogError("UpdateInto_UserDetails : Null or empty input parameters");
        $status = false;
    }

    // insert a UserDetails row
    if(true == $status)
    {
        $query = "UPDATE $UserDetailsTable_Name 
        SET     $UserDetailsTable_UserName = '$user'
        WHERE   $UserDetailsTable_Id = $id";

        $status = $dbhandle->query($query);
        if(false == $status)
        {
            $logger->LogError("UpdateInto_UserDetails : Unable to insert record - $dbhandle->error");
        }
    }

    $logger->LogInfo("UpdateInto_UserDetails : $status");
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
function SelectByIdFrom_UserDetails($dbhandle, $id, &$user)
{
    $logger = LoggerSingleton::GetInstance();	
    $logger->LogInfo("SelectByIdFrom_UserDetails : Enter ($id)");

    global $UserDetailsTable_Id;
    global $UserDetailsTable_Name;
    global $UserDetailsTable_UserName;
    
    // select
    $query = "SELECT * FROM $UserDetailsTable_Name
            WHERE $UserDetailsTable_Id = $id";

    // execte
    $result = $dbhandle->query($query);

    if(FALSE == $result)
    {
        $logger->LogError("SelectByIdFrom_UserDetails : No records with id - $id found");
        $status = false;
    }

    $num_rows = $result->num_rows;
    if($num_rows > 0)
    {
        while($row = $result->fetch_assoc())
        {
            $user = $row["$UserDetailsTable_UserName"];
        }

        $status = true;
    } 
    else
    {
        $logger->LogError("SelectByIdFrom_UserDetails : No records found");
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
function DeleteFrom_UserDetails($dbhandle, $id)
{
    $logger = LoggerSingleton::GetInstance();
    $logger->LogInfo("DeleteFrom_UserDetails : Enter");

    global $UserDetailsTable_Id;
    global $UserDetailsTable_Name;
    
    // delete
    $query = "DELETE FROM $UserDetailsTable_Name WHERE $UserDetailsTable_Id = $id";

    // execte
    $status = $dbhandle->query($query);

    if(false == $status)
    {
        $logger->LogError("DeleteFrom_UserDetails : Could not delete record - $dbhandle->error");
    }

    return $status;
} 

?>
