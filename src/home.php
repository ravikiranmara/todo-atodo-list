<html>
<?php
require_once 'print_header.php';

session_start();
if(isset($_SESSION['ValidUser']) == true)
{
    $session = $_SESSION['ValidUser'];
    echo "session : $session";
    echo "Hello World!!! Hooooome page";
    $username = $_SESSION['UserName'];
    $password = $_SESSION['Password'];

    echo "user : $username password : $password";

    session_destroy();
}
else
{
    header("Location:sessionExpired.php");
}

?>

</html>
