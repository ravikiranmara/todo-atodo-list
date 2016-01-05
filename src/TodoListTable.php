<?php
/* 
TodoList table
Contains crud operations for TodoList table
*/

require_once 'common_require.php';
require_once 'PasswordTable.php';

/**
* Check if TodoList table exists
*
* @param    $dbhandle   handle to the database
* @return   $status     true if table exists
*/
function IsExisting_TodoList($dbhandle)
{
    $logger = LoggerSingleton::GetInstance();
    $logger->LogInfo("IsExisting_TodoList : Enter");

    global $TodoListTable_Name;

    // check if table exists
    $query = "SELECT 1 FROM $TodoListTable_Name LIMIT 1";
    $status = $dbhandle->query($query);

    $logger->LogInfo("IsExisting_TodoList : Exit - ");
    return $status;
}

/**
* Creates TodoList table. 
*
* @param    $dbhandle   handle to the database
* @return   $status     true if he operation is successful
*/
function CreateTable_TodoList($dbhandle)
{
    $logger = LoggerSingleton::GetInstance();
    $logger->LogInfo("CreateTable_TodoList : Enter");
    
    global $TodoListTable_Name;
    global $TodoListTable_Id;
    global $TodoListTable_UserId;
    global $TodoListTable_Priority;
    global $TodoListTable_Status;
    global $TodoListTable_CreatedDate;
    global $TodoListTable_EstimatedDate;
    global $TodoListTable_CompletedDate;
    global $TodoListTable_Remainder;
    global $TodoListTable_TaskDescription;
    global $PasswordTable_Name;
    global $PasswordTable_Id;

    $query = "CREATE TABLE $TodoListTable_Name
        (
            $TodoListTable_Id INT NOT NULL AUTO_INCREMENT, 
            $TodoListTable_UserId INT NOT NULL,
            $TodoListTable_Priority TINYINT NOT NULL,
            $TodoListTable_Status TINYINT NOT NULL, 
            $TodoListTable_CreatedDate DATE NOT NULL,
            $TodoListTable_EstimatedDate DATE, 
            $TodoListTable_CompletedDate DATE,
            $TodoListTable_Remainder DATE,
            $TodoListTable_TaskDescription VARCHAR(150) NOT NULL,
            
            PRIMARY KEY($TodoListTable_Id),
            CONSTRAINT fk_Password FOREIGN KEY($TodoListTable_UserId)
            REFERENCES $PasswordTable_Name($PasswordTable_Id)
            ON DELETE CASCADE
        )";

    // create table
    $status = $dbhandle->query($query);

    if(false == $status)
    {
        $logger->LogError("CreateTable_TodoList : Unable to create table - 
                            $dbhandle->error");    
    }

    $logger->LogInfo("CreateTable_TodoList : Status - $status");
    return $status;
}

/**
* Drops TodoList table. All the data in the table is deleted. 
*
* @param    $dbhandle   handle to the database
* @return   $status     true if he operation is successful
*/

function DropTable_TodoList($dbhandle)
{
    $logger = LoggerSingleton::GetInstance();
    $logger->LogInfo("DropTable_TodoList : enter");

    global $TodoListTable_Name;

    $query = "DROP TABLE $TodoListTable_Name";
    $status = $dbhandle->query($query);

    if(false == $status)
    {
        $logger->LogError("DeleteTable_TodoList : Unable to Delete table - 
                            $dbhandle->error");    
    }

    $logger->LogInfo("DeleteTable_TodoList : Status - $status");
    return $status;
}

/**
* Insert row into tables
* 
* @param    table variables
* @param    $id      passed by reference. returns primar key of row 
* @return   $status  true if the operation is successful
*/
function InsertInto_TodoList($dbhandle, &$id, $userId, $priority, $task_status, $task, $createdDate,
                              $estimatedDate, $completedDate, $remainderDate)
{
    $logger = LoggerSingleton::GetInstance();
    $logger->LogInfo("InsertInto_UserDetails : Enter");

    global $TodoListTable_Name;
    global $TodoListTable_Id;
    global $TodoListTable_UserId;
    global $TodoListTable_Priority;
    global $TodoListTable_Status;
    global $TodoListTable_CreatedDate;
    global $TodoListTable_EstimatedDate;
    global $TodoListTable_CompletedDate;
    global $TodoListTable_Remainder;
    global $TodoListTable_TaskDescription;
    $status = true;

    // validate input argumets
    if(IsNullOrEmptyString($userId) || IsNullOrEmptyString($priority) || IsNullOrEmptyString($task_status) || 
    IsNullOrEmptyString($createdDate) || IsNullOrEmptyString($task))
    {
        $logger->LogError("InsertInto_TodoList : Null or empty input parameters");
        $status = false;
    }

    // insert a TodoList row
    if(true == $status)
    {
        $query = "INSERT INTO $TodoListTable_Name 
        (   
            $TodoListTable_UserId,
            $TodoListTable_Priority,
            $TodoListTable_Status,
            $TodoListTable_CreatedDate,
            $TodoListTable_EstimatedDate,
            $TodoListTable_CompletedDate,
            $TodoListTable_Remainder,
            $TodoListTable_TaskDescription
        ) 
        VALUES
        (   $userId,
            $priority,
            $task_status,
            '$createdDate',
            '$estimatedDate',
            '$completedDate',
            '$remainderDate',
            '$task'
        )";

        $status = $dbhandle->query($query);
        if(true == $status)
        {
            $id = $dbhandle->insert_id;
        }

        if(false == $status)
        {
            $logger->LogError("InsertInto_TodoList : Unable to insert record - $dbhandle->error");
        }
    }

    $logger->LogInfo("InsertInto_TodoList : $status");
    return $status;
}

/**
* Update row into tables
* 
* @param    table variables
* @param    $id      passed by reference. returns primar key of row 
* @return   $status  true if the operation is successful
*/
function UpdateInto_TodoList($dbhandle, $id, $userId, $priority, $task_status, $task, $createdDate,
                              $estimatedDate, $completedDate, $remainderDate)
{
    $logger = LoggerSingleton::GetInstance();
    $logger->LogInfo("UpdateInto_TodoList : Enter");

    global $TodoListTable_Name;
    global $TodoListTable_Id;
    global $TodoListTable_UserId;
    global $TodoListTable_Priority;
    global $TodoListTable_Status;
    global $TodoListTable_CreatedDate;
    global $TodoListTable_EstimatedDate;
    global $TodoListTable_CompletedDate;
    global $TodoListTable_Remainder;
    global $TodoListTable_TaskDescription;
    $status = true;

    // validate input argumets
    if(IsNullOrEmptyString($userId) || IsNullOrEmptyString($priority) || IsNullOrEmptyString($task_status) || 
    IsNullOrEmptyString($createdDate) || IsNullOrEmptyString($task) || IsNullOrEmptyString($id))
    {
        $logger->LogError("UpdateInto_TodoList : Null or empty input parameters");
        $status = false;
    }

    // insert a TodoList row
    if(true == $status)
    {
        $query = "UPDATE $TodoListTable_Name 
        SET     $TodoListTable_UserId = $userId,
                $TodoListTable_Priority = $priority,
                $TodoListTable_Status = $task_status,
                $TodoListTable_CreatedDate = '$createdDate',
                $TodoListTable_EstimatedDate = '$estimatedDate',
                $TodoListTable_CompletedDate = '$completedDate',
                $TodoListTable_Remainder = '$remainderDate',
                $TodoListTable_TaskDescription = '$task'
        WHERE   $TodoListTable_Id = $id";

        $status = $dbhandle->query($query);
        if(false == $status)
        {
            $logger->LogError("UpdateInto_TodoList : Unable to insert record - $dbhandle->error");
        }
    }

    $logger->LogInfo("UpdateInto_TodoList : $status");
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
function SelectByIdFrom_TodoList($dbhandle, $id, &$userId, &$priority, &$task_status, &$task, &$createdDate,
                              &$estimatedDate, &$completedDate, &$remainderDate)
{
    $logger = LoggerSingleton::GetInstance();	
    $logger->LogInfo("SelectByIdFrom_TodoList : Enter ($id)");

    global $TodoListTable_Name;
    global $TodoListTable_Id;
    global $TodoListTable_UserId;
    global $TodoListTable_Priority;
    global $TodoListTable_Status;
    global $TodoListTable_CreatedDate;
    global $TodoListTable_EstimatedDate;
    global $TodoListTable_CompletedDate;
    global $TodoListTable_Remainder;
    global $TodoListTable_TaskDescription;
    $status = true;
    
    // select
    $query = "SELECT * FROM $TodoListTable_Name
            WHERE $TodoListTable_Id = $id";

    // execte
    $result = $dbhandle->query($query);

    if(FALSE == $result)
    {
        $logger->LogError("SelectByIdFrom_TodoList : No records with id - $id found");
        $status = false;
    }

    $num_rows = $result->num_rows;
    if($num_rows > 0)
    {
        while($row = $result->fetch_assoc())
        {
            $id = $row["$TodoListTable_Id"];
            $userId = $row["$TodoListTable_UserId"];
            $priority = $row["$TodoListTable_Priority"];
            $task_status = $row["$TodoListTable_Status"];
            $task = $row["$TodoListTable_TaskDescription"];
            $createdDate = $row["$TodoListTable_CreatedDate"];
            $estimatedDate = $row["$TodoListTable_EstimatedDate"];
            $completedDate = $row["$TodoListTable_CompletedDate"];
            $remainderDate = $row["$TodoListTable_Remainder"];
        }

        $status = true;
    } 
    else
    {
        $logger->LogError("SelectByIdFrom_TodoList : No records found");
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
function DeleteFrom_TodoList($dbhandle, $id)
{
    $logger = LoggerSingleton::GetInstance();
    $logger->LogInfo("DeleteFrom_TodoList : Enter");

    global $TodoListTable_Id;
    global $TodoListTable_Name;
    
    // delete
    $query = "DELETE FROM $TodoListTable_Name WHERE $TodoListTable_Id = $id";

    // execte
    $status = $dbhandle->query($query);

    if(false == $status)
    {
        $logger->LogError("DeleteFrom_TodoList : Could not delete record - $dbhandle->error");
    }

    return $status;
} 


/**
* Select row into tables
* 
* @param    table variables
* @param    $userid      provide id of the record to retrieve
* @param    are arrays, to return values by reference // not a good idea
* @return   $status  true if the operation is successful
*/
function SelectByUserIdFrom_TodoList($dbhandle, &$id, $userId, &$priority, &$task_status, &$task, &$createdDate,
                              &$estimatedDate, &$completedDate, &$remainderDate)
{
    $logger = LoggerSingleton::GetInstance();	
    $logger->LogInfo("SelectByIdFrom_TodoList : Enter ($id)");

    global $TodoListTable_Name;
    global $TodoListTable_Id;
    global $TodoListTable_UserId;
    global $TodoListTable_Priority;
    global $TodoListTable_Status;
    global $TodoListTable_CreatedDate;
    global $TodoListTable_EstimatedDate;
    global $TodoListTable_CompletedDate;
    global $TodoListTable_Remainder;
    global $TodoListTable_TaskDescription;
    $status = true;
    
    // select
    $query = "SELECT * FROM $TodoListTable_Name
            WHERE $TodoListTable_Id = $id";

    // execte
    $result = $dbhandle->query($query);

    if(FALSE == $result)
    {
        $logger->LogError("SelectByIdFrom_TodoList : No records with id - $id found");
        $status = false;
    }

    $num_rows = $result->num_rows;
    if($num_rows > 0)
    {
        while($row = $result->fetch_assoc())
        {
            array_push($id, $row["$TodoListTable_Id"]);
            array_push($userId, $row["$TodoListTable_UserId"]);
            array_push($priority, $row["$TodoListTable_Priority"]);
            array_push($task_status, $row["$TodoListTable_Status"]);
            array_push($task, $row["$TodoListTable_TaskDescription"]);
            array_push($createdDate, $row["$TodoListTable_CreatedDate"]);
            array_push($estimatedDate, $row["$TodoListTable_EstimatedDate"]);
            array_push($completedDate, $row["$TodoListTable_CompletedDate"]);
            array_push($remainderDate, $row["$TodoListTable_Remainder"]);
        }

        $status = true;
    } 
    else
    {
        $logger->LogError("SelectByIdFrom_TodoList : No records found");
        $status = false;
    }

    return $status;
} 

?>
