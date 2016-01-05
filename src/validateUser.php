<html>
<?php
function IsValidUser()
{
    $status = false; 

    if (isset($_POST['username']) && isset($_POST['password']))
    {
        $username = $_POST['username'];
        $password = $_POST['password'];


        session_start();
        $_SESSION['ValidUser'] = true;
        $_SESSION['UserName'] = $username;
        $_SESSION['Password'] = $password;

        $status = true;
    }

    return $status;
}

// main()
{
    if(IsValidUser() == true)
    {
        header("Location:home.php");
    }
    else
    {
        echo "Please relogin again";
    }
}


?>
</html>
