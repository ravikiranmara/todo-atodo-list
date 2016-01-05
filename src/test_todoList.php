<?php

/* unit test for UserDetails Table */

require_once 'common_require.php';
require_once 'PasswordTable.php';
require_once 'TodoListTable.php';

$logger = LoggerSingleton::GetInstance();
$logger->LogError("******************  TODOLIST UNIT TEST **************************");

// get database name
$dbhostname = 'localhost';
$dbname = "tododb";
$username = "dbuser";
$password = "password";

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
    
    global $TodoListTable_PriorityNormal;
    global $TodoListTable_PriorityHigh;
    global $TodoListTable_StatusNotStarted;
    global $TodoListTable_StatusCompleted;

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

/** TodoTable Table Operations **/

// check if existing
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

// insert into table
$userid = $id;
$priority = $TodoListTable_PriorityNormal;
$task_status = $TodoListTable_StatusNotStarted;
$task = "Complete this todo task";
$today = date("Y-m-d");
$createdDate = $today;
$estimatedDate = date('Y-m-d', strtotime($today. ' + 2 days'));
$remainderDate = date('Y-m-d', strtotime($today. ' + 1 days'));
$completedDate = null;

//$sometime = mktime(0,0,0,12,31,2015);

if(true == $status)
{
    $status = InsertInto_TodoList($dbhandle, $mid, $userid, $priority, $task_status, $task, 
    $createdDate, $estimatedDate, $completedDate, $remainderDate);
    $logger->LogInfo("Insert into TodoList table status : " . var_export($status, true));
}

// select and display record
if(true == $status)
{
    $status = SelectByIdFrom_TodoList($dbhandle, $mid, $userid, $priority, $task_status, $task,
     $createdDate, $estimatedDate, $completedDate, $remainderDate);
    $logger->LogInfo("Select into TodoList table status : " . var_export($status, true));
}

// display record 
if(true == $status)
{
    $logger->LogInfo("mid = $mid, userid - $userid, priority - $priority, status - $task_status, 
     task - $task, createdDate - $createdDate, estimated - $estimatedDate, 
     completed - $completedDate, remainder - $remainderDate	");
}

// update 
$completedDate = date('Y-m-d');
$task_status = $TodoListTable_StatusCompleted;
if(true == $status)
{
    $status = UpdateInto_TodoList($dbhandle, $mid, $userid, $priority, $task_status, $task,
     $createdDate, $estimatedDate, $completedDate, $remainderDate);
    $logger->LogInfo("Update into TodoList table status : " . var_export($status, true));
}

// select and display record
if(true == $status)
{
    $status = SelectByIdFrom_TodoList($dbhandle, $mid, $userid, $priority, $task_status, $task,
     $createdDate, $estimatedDate, $completedDate, $remainderDate);
    $logger->LogInfo("Select into TodoList table status : " . var_export($status, true));
}

// display record 
if(true == $status)
{
     $logger->LogInfo("mid = $mid, userid - $userid, priority - $priority, status - $task_status, 
     task - $task, createdDate - $createdDate, estimated - $estimatedDate, 
     completed - $completedDate, remainder - $remainderDate	");
}

// delete recored
if(true == $status)
{
    $status = DeleteFrom_TodoList($dbhandle, $mid);
    $logger->LogInfo("Delete from UserDetails table status : " . var_export($status, true));
}

// drop into table
if(true == $status)
{
    $status = DropTable_TodoList($dbhandle);
    $logger->LogInfo("Drop todoList table status : " . var_export($status, true));
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
