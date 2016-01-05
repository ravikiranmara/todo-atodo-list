<!-- Drop Table -->

<?php

// includes 
require_once 'common_require.php';
require_once 'VersionTable.php';
require_once 'UserDetailsTable.php';
require_once 'PasswordTable.php';
require_once 'TodoListTable.php';

// main
{
    $logger = LoggerSingleton::GetInstance();
    $logger->LogError("*************************************************************");
    $logger->LogError("*\n*  TODO LIST  DROP \n*\n");
    $logger->LogError("*************************************************************");


    /*
    if ($argc < 4)
    {
        die("Invalid Syntax. Try : $argv[0] <database name> <username> <password>\n");
    }
    */

    // get database name
    $dbhostname = 'localhost';
    $dbname = 'tododb';
    $username = 'dbuser';
    $password = 'password';

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
        $status = DropTable_Version($dbhandle);
        if(false == $status)
        {
           $logger->LogError("Unable to delete Version Table : $dbhandle->error");
        }
    }

    // drop table Todo List
    {
        $status = DropTable_TodoList($dbhandle);
        $logger->LogInfo("Drop TodoList Table status : " . var_export($status, true));
    }

    // drop UserDetails tabl
    {
        $status = DropTable_UserDetails($dbhandle);
        $logger->LogInfo("Drop Password table status : " . var_export($status, true));
    }

    // drop into table
    {
        $status = DropTable_Password($dbhandle);
        $logger->LogInfo("Drop Password table status : " . var_export($status, true));
    }

    
    $logger->LogInfo("End of program");
}

?>
