<?php
session_start();

$mysqli = new mysqli('localhost','user','password','LittleSister');
if($mysqli->connect_errno){
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " .$mysqli->connect_error;
}


$errorMsg = "";
//This code runs if the form has been submitted
if (isset($_POST['submit'])) {



    //This makes sure they did not leave any fields blank

    if (!$_POST['username'] || !$_POST['pass']){
     	      $errorMsg = "Please complete all required fields.";

 	}else{
        $password = trim($_POST['pass']);
        $user = trim($_POST['username']);

        $sqlStr = "SELECT users.DisplayName, privileges.Access FROM users, privileges WHERE users.UserName = '$user' AND users.Password = '$password' AND users.UserID = privileges.UserID AND privileges.Access = 'admin'";
        //echo "$sqlStr <BR>";
        if (!$result = $mysqli->query($sqlStr)){
            die("There was an error running the exact search \n".$sqlStr);
        }

        $resultCount = $result->num_rows;

        //echo "Found $resultCount results \n";

        if($resultCount == 1){
            while($row = $result->fetch_assoc()){
                $_SESSION['user'] = $row['DisplayName'];
                $_SESSION['access'] = $row['Access'];

                //$backURL = empty($_SESSION['backURL']) ? '/' : $_SESSION['backURL'];
                //unset($_SESSION['backURL']);
                //header('Location: ' . $backURL);
                //echo "success... ".$_SESSION['user']." with priviledges: ".$_SESSION['access'];
                header("Location: http://littlesisterkaraoke.com/songSearch/admin/index.php");
                exit;
            }
        }else{
            $errorMsg = "Invalid Login";
          // $echo session_id();

        }

    }

} //end of isset($_POST['submit'])
//
?>
<!Doctype HTML>
<HTML>
<HEAD>
    <style>
        #Title a
            {
                color:blue;
                text-decoration:none;
            }


    </style>
</HEAD>

<BODY>
        <div id="Title">
            Please Log In or <a href="../index.php">Return to Song Search</a>
           <BR><?php echo session_id(); ?></BR>
        </div>
        <div id="Login">
            <form action="login.php" method="POST">
                <Table>
                    <TR>
                        <TD colspan="2"><? echo $errorMsg; ?></td>
                    </TR>
                    <TR>
                        <TD>Login:</TD><TD><input type="text" name="username" width="150"></TD>
                    </TR>
                    <TR>
                        <TD>Password:</TD><TD><input type="password" name="pass" width="150"></TD>
                    </TR>
                    <TR>
                         <TD colspan="2"><input type="submit" name="submit" value="Submit"></td>
                    </TR>

                </table>
            </form>


        </div>

</BODY>

</HTML>