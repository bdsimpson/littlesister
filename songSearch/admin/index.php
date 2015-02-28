<?php
//session_start();
require_once("session.php");


?>

<!DOCTYPE HTML>
<HTML>

<Head>

	<title>Little Sister Productions Admin</title>
    <script src="../jquery/jquery-1.9.1.js"></script>
    <script src="../jquery/flexgrid-1.1/js/flexgrid.js"></script>

  <script language="javascript">
    $(document).ready(function(){
      //alert("I'm Ready");
       // JQuery methods here
        $("#Excel").click(function(){
            location.href="exceloutput.php";
        });

        $("#AddSongs").click(function(){
            window.location="addsong.php";
        });

        $("#RemoveSongs").click(function(){
            window.location="removesong.php";
        });


    }); // end of (document.ready()




   </script>
    <style>
        html, body
            {
                height:100%;
                padding:0px;
                margin:0px;
            }
        body
            {
                background-image:url('../images/rose-background.jpg');
            }
        #Welcome
            {
                border-bottom:1px solid black;
                background:white;
                margin:0px;
            }
        #Welcome a
            {
                text-decoration:none;
                color:blue;
            }
        #Menu
            {
                width:80%;
                height:100%;
                background-image:url('../images/parchment-background.jpg');

                margin:0 auto;
                border:1px solid black;
                text-align:center;
            }

        .Button
            {
                width:120px;
                display:inline-block;
                margin-top:10px;
                height:30px;
                text-align:center;
                background:rgb(102,204,255);
                cursor:pointer;
                border:3px inset rgb(0,0,102);
                -webkit-touch-callout: none;
                -webkit-user-select: none;
                -khtml-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
            }
    </style>

</Head>

<BODY>
    <div id="Welcome">
        Welcome <? echo $_SESSION['user']; ?>. &nbsp &nbsp  <a href="logout.php">Log Out</a>
    </div>
    <div id="Menu">
        <div class="MenuTitle">
            <H2>Little Sister Karaoke Admin Menu</h2>
            <H3>Song List Adjustments</H3>
        </div>
        <div class="Button" id="AddSongs">
            Add Songs
        </div>
        <div class="Button" id="RemoveSongs">
            Remove Songs
        </div>
        <div class="Button" id="Excel">
            Create Excel File
        </div>
    </div>

</BODY>

</HTML>
