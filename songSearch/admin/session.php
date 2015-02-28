<?php
// Start Session
session_start();

$_SESSION['temp'] = "temp works";

//foreach ($_SESSION as $key=>$val){
//      echo $key. ": ".$val. "<br>";
//}
//echo session_id()." <BR>";

$continue = false;
//echo "Continue:".$continue;
// If user is logged in
if(isset($_SESSION['user']))
    {
        echo $_SESSION['user'];
        if(isset($_SESSION['access']))
            {
                if($_SESSION['access'] == 'admin')
                    {
                        $continue = true;
                    }
            }
    }
// If user not logged in
if(!$continue){
       // echo "Not Logged IN";
        session_destroy();
        session_regenerate_id(true);
        $_SESSION['backURL'] = $_SERVER['REQUEST_URI'];
        header("Location: login.php");
        exit();
    }

?>