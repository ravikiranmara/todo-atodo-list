<?php
/* 
Passowrd table
Contains crud operations for password table
*/

require_once 'common_require.php';

/**
* Check if Password table exists
*
* @param    $dbhandle   handle to the database
* @return   $status     true if table exists
*/
function IsExisting_Password($dbhandle)
{
    $logger = LoggerSingleton::GetInstance();
    $logger->LogInfo("IsExisting_Password : Enter");

    global $PasswordTable_Name;

    // check if table exists
    $query = "SELECT 1 FROM $PasswordTable_Name LIMIT 1";
    $status = $dbhandle->query($query);

    $logger->LogInfo("IsExisting_Password : Exit - ");
    return $status;
}


/**
* Creates Password table. 
*
* @param    $dbhandle   handle to the database
* @return   $status     true if he operation is successful
*/
function CreateTable_Password($dbhandle)
{
    $logger = LoggerSingleton::GetInstance();
    $logger->LogInfo("CreateTable_Password : Enter");
    
    global $PasswordTable_Name;
    global $PasswordTable_Id;
    global $PasswordTable_Password;
    global $PasswordTable_User;

    $query = "CREATE TABLE $PasswordTable_Name
        (
            $PasswordTable_Id INT NOT NULL AUTO_INCREMENT, 
            $PasswordTable_User VARCHAR(15) UNIQUE, 
            $PasswordTable_Password VARCHAR(30) NOT NULL, 
            PRIMARY KEY($PasswordTable_Id)
        )";

    // create table
    $status = $dbhandle->query($query);

    if(false == $status)
    {
        $logger->LogError("CreateTable_Password : Unable to create table - 
                            $dbhandle->error");    
    }

    $logger->LogInfo("CreateTable_Password : Status - $status");
    return $status;
}


/**
* Drops Password table. All the data in the table is deleted. 
*
* @param    $dbhandle   handle to the database
* @return   $status     true if he operation is successful
*/

function DropTable_Password($dbhandle)
{
    $logger = LoggerSingleton::GetInstance();
    $logger->LogInfo("DropTable_Password : enter");

    global $PasswordTable_Name;

    $query = "DROP TABLE $PasswordTable_Name";
    $status = $dbhandle->query($query);

    if(false == $status)
    {
        $logger->LogError("DeleteTable_Password : Unable to Delete table - 
                            $dbhandle->error");    
    }

    $logger->LogInfo("DeleteTable_Password : Status - $status");
    return $status;
}

/**
* Insert row into tables
* 
* @param    table variables
* @param    $id      passed by reference. returns primar key of row 
* @return   $status  true if the operation is successful
*/
function InsertInto_Password($dbhandle, &$id, $user, $password)
{
    $logger = LoggerSingleton::GetInstance();
    $logger->LogInfo("InsertInto_Password : Enter");

    global $PasswordTable_Id;
    global $PasswordTable_Name;
    global $PasswordTable_User;
    global $PasswordTable_Password;
    $status = true;

    // validate input argumets
    if(IsNullOrEmptyString($password) || IsNullOrEmptyString($user))
    {
        $logger->LogError("InsertInto_Password : Null or empty input parameters");
        $status = false;
    }

    // insert a Password row
    if(true == $status)
    {
        $query = "INSERT INTO $PasswordTable_Name 
            (   $PasswordTable_Password,
                $PasswordTable_User
        ) 
        VALUES
        (   '$password',
            '$user'
        )";

        $status = $dbhandle->query($query);
        if(true == $status)
        {
            $id = $dbhandle->insert_id;
        }

        if(false == $status)
        {
            $logger->LogError("InsertInto_Password : Unable to insert record - $dbhandle->error");
        }
    }

    $logger->LogInfo("InsertInto_Password : $status");
    return $status;
}

/**
* Update row into tables
* 
* @param    table variables
* @param    $id      passed by reference. returns primar key of row 
* @return   $status  true if the operation is successful
*/
function UpdateInto_Password($dbhandle, $id, $user, $password)
{
    $logger = LoggerSingleton::GetInstance();
    $logger->LogInfo("UpdateInto_Password : Enter");

    global $PasswordTable_Id;
    global $PasswordTable_Name;
    global $PasswordTable_Password;
    global $PasswordTable_User;
    $status = true;

    // validate input argumets
    if(IsNullOrEmptyString($password) || IsNullOrEmptyString($user))
    {
        $logger->LogError("UpdateInto_Password : Null or empty input parameters");
        $status = false;
    }

    // insert a Password row
    if(true == $status)
    {
        $query = "UPDATE $PasswordTable_Name 
        SET     $PasswordTable_Password = '$password',
                $PasswordTable_User = '$user'
        WHERE   $PasswordTable_Id = $id";

        $status = $dbhandle->query($query);
        if(false == $status)
        {
            $logger->LogError("UpdateInto_Password : Unable to insert record - $dbhandle->error");
        }
    }

    $logger->LogInfo("UpdateInto_Password : $status");
    return $status;
}

/**
* Select row into tables by username
* 
* @param    table variables
* @param    $id      provide id of the record to retrieve
* @param    rest to return values by reference // not a good idea
* @return   $status  true if the operation is successful
*/
function SelectByUserFrom_Password($dbhandle, &$id, $user, &$password)
{
    $logger = LoggerSingleton::GetInstance();	
    $logger->LogInfo("SelectByUserFrom_Password : Enter ($id)");

    global $PasswordTable_Id;
    global $PasswordTable_Name;
    global $PasswordTable_User;
    global $PasswordTable_Password;
    
    // select
    $query = "SELECT * FROM $PasswordTable_Name
            WHERE $PasswordTable_User = '$user'";

    // execte
    $result = $dbhandle->query($query);

    if(FALSE == $result)
    {
        $logger->LogError("SelectByIdFrom_Password : No records with id - $id found");
        $status = false;
    }

    $num_rows = $result->num_rows;
    if($num_rows > 0)
    {
        while($row = $result->fetch_assoc())
        {
            $id = $row["$PasswordTable_Id"];
            $password = $row["$PasswordTable_Password"];
            $user = $row["$PasswordTable_User"];
        }

        $status = true;
    } 
    else
    {
        $logger->LogError("SelectByIdFrom_Password : No records found");
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
function SelectByIdFrom_Password($dbhandle, $id, &$user, &$password)
{
    $logger = LoggerSingleton::GetInstance();	
    $logger->LogInfo("SelectByIdFrom_Password : Enter ($id)");

    global $PasswordTable_Id;
    global $PasswordTable_Name;
    global $PasswordTable_User;
    global $PasswordTable_Password;
    
    // select
    $query = "SELECT * FROM $PasswordTable_Name
            WHERE $PasswordTable_Id = $id";

    // execte
    $result = $dbhandle->query($query);

    if(FALSE == $result)
    {
        $logger->LogError("SelectByIdFrom_Password : No records with id - $id found");
        $status = false;
    }

    $num_rows = $result->num_rows;
    if($num_rows > 0)
    {
        while($row = $result->fetch_assoc())
        {
            $password = $row["$PasswordTable_Password"];
            $user = $row["$PasswordTable_User"];
        }

        $status = true;
    } 
    else
    {
        $logger->LogError("SelectByIdFrom_Password : No records found");
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
function DeleteFrom_Password($dbhandle, $id)
{
    $logger = LoggerSingleton::GetInstance();
    $logger->LogInfo("DeleteFrom_Password : Enter");

    global $PasswordTable_Id;
    global $PasswordTable_Name;
    global $PasswordTable_Password;
    
    // delete
    $query = "DELETE FROM $PasswordTable_Name WHERE $PasswordTable_Id = $id";

    // execte
    $status = $dbhandle->query($query);

    if(false == $status)
    {
        $logger->LogError("DeleteFrom_Password : Could not delete record - $dbhandle->error");
    }

    return $status;
} 

?>
