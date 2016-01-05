<?php

    /* Version Table */
    $VersionTable_Id = "ID";
    $VersionTable_Name = "VersionTable";
    $VersionTable_MajorVersion = "MajorVersion";
    $VersionTable_MinorVersion = "MinorVersion";
    $VersionTable_DbState = "DbState";
    $VersionTable_Notes  = "Notes";

    $VersionTable_V0MajorVersion = 0;
    $VersionTable_V0MinorVersion = 0;

    $VersionTable_dbStateGood = 0;
    $VersionTable_dbStateUpgrading = 1;
    $VersionTable_dbStateBad = 2;
    $VersionTable_dbStateInit = 3;

    /* Password Table */
    $PasswordTable_Name = "PasswordTable";
    $PasswordTable_Id = "UserId";
    $PasswordTable_User = "UserName";
    $PasswordTable_Password = "Password";

    /* UserDetails Table */
    $UserDetailsTable_Name = "UserDetails";
    $UserDetailsTable_Id = "UserId";
    $UserDetailsTable_UserName = "UserName";

    /* TodoList Table */
    $TodoListTable_Name = "TodoList";
    $TodoListTable_Id   = "ListId";
    $TodoListTable_UserId = "UserId";
    $TodoListTable_Priority = "Priority";
    $TodoListTable_Status = "Status";
    $TodoListTable_CreatedDate = "CreatedDate";
    $TodoListTable_EstimatedDate = "ETA";
    $TodoListTable_CompletedDate = "CompletedDate";
    $TodoListTable_Remainder = "Remainder";
    $TodoListTable_TaskDescription = "Task";

    $TodoListTable_StatusNotStarted = 0;
    $TodoListTable_StatusInProgress = 1;
    $TodoListTable_StatusBlocked = 2;
    $TodoListTable_StatusCompleted = 3;

    $TodoListTable_PriorityVeryHigh = 0;
    $TodoListTable_PriorityHigh = 1;
    $TodoListTable_PriorityNormal = 2;
    $TodoListTable_PriorityLow = 3;
    $TodoListTable_PriorityVeryLow = 4;

?>
