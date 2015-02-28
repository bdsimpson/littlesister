<?php
require_once("session.php");

$mysqli = new mysqli('localhost','user','password','LittleSister');
if($mysqli->connect_errno){
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " .$mysqli->connect_error;
}
$rowmax = 10;
$rowStart = (isset($_GET['start']) ? $_GET['start'] : 0);
/*
$orderFactor = "Artist";
$htmlString = "";

$sqlString = "SELECT * FROM songlist WHERE Date BETWEEN SYSDATE() - INTERVAL 30 DAY AND SYSDATE() ";
$sqlString .="ORDER BY $orderFactor ";
$sqlString .="LIMIT $rowStart, $rowmax ";

if(!$result = $mysqli->query($sqlString)){
    die("Error getting songs from last 30 days");
}
if($result->num_rows > 0){

    while($row = $result->fetch_assoc()){

            $htmlString .= "<TR";
            //if($i%2 == 0){
            //    $htmlString .= " class=\"evenrow\"";
            //}
            $htmlString .=">\n";
            $htmlString .= "<TD class = \"delete\" id=\"".$row['SongID']."\"><img src=\"../images/delete.gif\"></TD>";
            $htmlString .= "<TD><span class=\"editableSpan\">".$row['SongName']."</span><input type=\"text\" id=\"Song".$row['SongID']."\" class=\"editableField\" value=\"".$row['SongName']."\"></TD>";
            $htmlString .= "<TD><span class=\"editableSpan\">".$row['Artist']."</span><input type=\"text\" id=\"Artist".$row['SongID']."\" class=\"editableField\" value=\"".$row['Artist']."\"></TD>\n";
            $htmlString .= "</TR>\n";

    }
}else{
         for($i=0; $i < $rowmax; $i++){
            $htmlString .= "<TR";
            if($i%2 == 0){
                $htmlString .= " class=\"evenrow\"";
            }
            $htmlString .=">\n";
            $htmlString .= "<TD>sample Song Name</TD><TD>sample Artist</TD>\n";
            $htmlString .= "</TR>\n";
        }

}
*/
?>

<!DOCTYPE HTML>
<HTML>
<HEAD>
    <script src="../jquery/jquery-1.9.1.js"></script>
    <script language="javascript">
        $(document).ready(function(){
          //alert("I'm Ready");
           // JQuery methods here

            var numrows = $("#numrows").val();
            var beginning = 0;
            var bookselection = "";

            // Combined Ajax function
            function getResults(){
                var display = $("#ActiveDisplay").val();
                if(display == "search"){
                    var location = '../search.php';
                    var postData = { "SearchField" : $("#SearchBox").val(), "parameters" : "Both", "rowmax" : numrows, "start" : beginning };
                }else if(display == "recent"){
                    var location = '../newsongs.php';
                    var postData = { "sortfactor" : "Artist", "rowmax" : numrows, "start" : beginning };
                }else if(display == "songbook"){
                    var location = '../booklisting.php';
                    var postData = { "query" : bookselection, "sortfactor" : "Artist", "rowmax" : numrows, "start" : beginning };
                }
                var request = $.ajax({
                    url: location,
                    data: postData,
                    type: "POST"
                });
                request.done(function(data){
                    displayResults(data);
                });
                request.fail(function(){
                    alert("Error Connecting to Database");
                });
            }; // end of function getResults

           //default behavior is to load screen with recent additions
            $("#ActiveDisplay").val("recent");
            getResults();

            //******************************************************************
            // Combined handler for displaying Results
            function displayResults(data){

                //alert(data);
                jsonObj = $.parseJSON(data);
                  //*************

                  var html = "";
                  var colorchange;
                  //alert(jsonObj.Results.length);
                  if(jsonObj.Results[0].Error){
                        alert("No Results Found");
                        html = "";
                  }else{

                      for(i=0;i<jsonObj.Results.length;i++){
                           if (i%2 == 0){
                                colorchange = " class=\"altRow\"";
                           }else{
                                colorchange = "";
                           }
                           // Delete "button"
                           html += '<TR><TD class = "delete" id="' + jsonObj.Results[i].SongID + '"><img src="../images/delete.gif"></TD>';

                           //Artist Listing
                           html += '<TD' + colorchange + ' class="clickable"><span class="editableSpan">' + jsonObj.Results[i].Artist + '</span>';
                           html += '<input type="text" class="editableField" id="Artist_' + jsonObj.Results[i].SongID + '" value="' + jsonObj.Results[i].Artist + '"></TD>';

                           //Song Name Listing
                           html += '<TD' + colorchange + ' class="clickable"><span class="editableSpan">' + jsonObj.Results[i].SongName + '</span>';
                           html += '<input type="text" class="editableField" id="SongName_' + jsonObj.Results[i].SongID + '" value="' + jsonObj.Results[i].SongName + '"></TD>';

                           //Date Listing
                           html += '<TD' + colorchange + '>' + jsonObj.Results[i].Date +'</td></tr>';
                      }
                      $("#ResultTable > tbody > tr").remove();
                      $("#ResultTable > tbody").append(html);

                  } // end of if/else error
            };

            //***********************************************************************************
            //  End of Ajax display handler

            $("#SongSearch").on('click', function(){
                $("#SearchWindow").show();
                $("#BookWindow").hide();
                $("#RecentWindow").hide();
            });
            $("#Recent").on('click', function(){
                $("#SearchWindow").hide();
                $("#BookWindow").hide();
                $("#RecentWindow").show();
                $("#ActiveDisplay").val("recent");
                getResults();

            });
            $("#SongBook").on('click', function(){
                $("#BookWindow").show();
                $("#SearchWindow").hide();
                $("#RecentWindow").hide();
            });
            $(".inline-link").on('click', function() {
                if(bookselection != $(this).attr("id")){
                    bookselection = $(this).attr("id");
                    $("#ActiveDisplay").val("songbook");
                    beginning=0;
                    getResults();
                }

            });

            $("#Menu").click(function(){
                window.location="index.php";
            });
            $("#ResultTable").on('click', '.delete', function(){
                var remove = confirm("Deleting Song: "+this.id+": "+$(this).next().next().text()+" by "+$(this).next().text());
                if(remove){
                    var result = $.ajax({
                        url: 'deletesong.php',
                        data: { "SongID" : this.id },
                        type: "POST"
                    });
                    result.done(function(data){
                        getResults();
                    });
                    result.fail(function(){
                        alert("Error Deleting Song");
                    });
                }
            });
            function editRecord(SongID, newData){
                var result = $.ajax({
                    url: 'update.php',
                    data: {"SongID" : SongID , "newvalue" : newData },
                    type: "POST"
                }).done(function(data){
                    if(data != "Success"){
                        alert(data);
                    }
                });
            };

            $("#ResultTable").on('click', '.editableSpan', function(){
                $(this).hide().next().show().focus();
            });
            $("#ResultTable").on('blur', '.editableField', function(){
                //alert("Ajax changes to " + this.id + " => " + this.value);
                $(this).hide().prev().show().html($(this).val());
                editRecord(this.id, this.value);
                //alert("Ajax this change");
            });
            $("#ResultTable").on('keydown', '.editableField', function(e){
                if(e.keyCode == 13){
                    $(this).blur();
                }
            });
            $("#SearchBox").on('focus', function(){
                if(this.value=="Enter Search Phrase"){
                    this.value="";
                    $(this).css("font-style","normal");
                    $(this).css("color","black");
                }

            });
            $("#SearchBox").blur(function(){
                if(this.value==""){
                    this.value="Enter Search Phrase";
                    $(this).css("font-style","italic");
                    $(this).css("color","grey");
                }else{
                    //alert("Ajax search.php");
                    $("#ActiveDisplay").val("search");
                    beginning=0;
                    getResults();
                }
            });


            $("#SearchBox").on('keydown', function(e){
                if(e.keyCode == 13){
                    $(this).blur();
                }

            });
            $("#numrows").on('blur', function(){
                if(numrows != this.value){
                    numrows = this.value;
                    //var active=$("#ActiveDisplay").val();
                    //var end = parseFloat(beginning) + parseFloat(numrows);
                    //alert("Ajax => " + active + " records: " + beginning + " through " + end);
                    getResults();
                }
            }).on('keydown', function(e){
                if(e.keyCode == 13){
                    $(this).blur();
                }
            });

            $("#next_button").on('click', function(){
                numrows = $("#numrows").val();
                beginning = parseFloat(beginning) + parseFloat(numrows);
                getResults();

            });
            $("#previous_button").on('click', function(){
                if(beginning > 0){
                    var newbeginning = parseFloat(beginning) - parseFloat(numrows);
                    if(newbeginning < 0){
                        beginning = 0;
                    }else{
                        beginning = newbeginning;
                    }
                    getResults();
                }
            });


            //****************************************************************************************
            $(function(){
                /*
                 * this swallows backspace keys on any non-input element.
                 * stops backspace -> back
                 */
                var rx = /INPUT|SELECT|TEXTAREA/i;

                $(document).bind("keydown keypress", function(e){
                    if( e.which == 8 ){ // 8 == backspace
                        if(!rx.test(e.target.tagName) || e.target.disabled || e.target.readOnly ){
                            e.preventDefault();
                        }
                    }
                });
            });

    }); // end of (document.ready()




   </script>
    <style>

        .editableField
            {
                display:none;
            }
        .editableSpan
            {
                width:250px;
                height:20px;
            }
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
        #content
            {
                width:80%;
                min-height:100%;
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
        #insertlist
            {
                width:520px;
                margin-right:auto;
                margin-left:auto;
            }
        tbody tr
            {
                background-color:white;
            }
        .altRow
            {
                background-color:lightcyan;

            }
        td
            {
                padding-left:0px;
                padding-right:0px;
                padding-top:0px;
                padding-bottom:0px;
                margin:0px;
                border:1px solid black;
                height:20px;
                width:250px;
            }
        td input, td span
            {
                margin:0px;
                height:20px;
                width:240px;
                text-align:center;
            }
        td img
            {
                width:25px;
            }
        .delete
            {
                width:25px;
                cursor:pointer;
            }
        table
            {
                border-collapse:collapse;
            }
        table input
            {

                padding-left:2px;
            }
        .center
            {
                text-align:center;
            }

        #navigation
            {
                display:inline;
            }
        span.icon
            {
                display:inline-block;
                cursor:pointer;
                text-indent: -9999px;

            }
        span.songbook
            {
                width:55px;
                height:40px;
                background: url(../images/book_sprite.gif) top left no-repeat;

            }
        span.songbook:hover
            {
                background-position: 0px -40px;
            }
        span.recent
            {
                width:40px;
                height:40px;
                background: url(../images/recent_sprite.gif) top left no-repeat;
            }
        span.recent:hover
            {
                background-position: 0px -40px;
            }
        span.search
            {
                width:40px;
                height:40px;
                background: url(../images/search_sprite.gif) top left no-repeat;
            }
        span.search:hover
            {
                background-position: 0px -40px;
            }
        #previous_button
            {
                background:url(../images/previous.gif) top left no-repeat;
            }
        #next_button
            {
                background:url(../images/next.gif) top left no-repeat;
            }
        .navigation
            {
                width:40px;
                height:40px;
                text-indent:-9999px;
                display:inline-block;
            }

        #SearchWindow
            {
                padding-bottom:10px;
                display:none;

            }
        #SearchBox
            {
                margin-top:10px;
                color:grey;
                font-style:italic;
                height:22px;
                width: 230px;
                border:2px solid black;
                border-radius:10px;

            }
        #RecentWindow
            {
                padding-bottom:10px;
            }
        #BookWindow
            {
                padding-bottom:10px;
                display:none;
            }
        H3
            {
                padding-top:0px;
                margin:0px;
            }
        .inline-link
            {
                display:inline;
                color:blue;
                cursor:pointer;

            }
        .sidebyside
            {
                display:inline-block;
                margin-left:10px;
                margin-right:10px;
            }
    </style>

</HEAD>


<BODY>
    <div id="Welcome">
        Welcome <? echo $_SESSION['user']; ?>. &nbsp &nbsp  <a href="logout.php">Log Out</a>
    </div>
    <div id="content">
        <div id="insertlist">
            <div class="MenuTitle">
                <H2>Little Sister Karaoke Admin</h2>
                <H3>Remove/Edit Songs</H3>
                <div id="navigation">
                    <span id="Recent" class="recent icon" id="recent" Title="Recent Additions"></span>
                    <span id="SongSearch" class="search icon" id="search" Title="Song Search"></span>
                    <span id="SongBook" class="songbook icon" id="songbook" Title="Song Book"></span>
                </div>
                <div id="RecentWindow">
                    <H3>Recent Additions</H3>
                </div>
                <div id="SearchWindow">
                    <H3>Song Search</H3>
                    <input type="text" name="SearchBox" id="SearchBox" value="Enter Search Phrase">
                </div>
                <div id="BookWindow">
                    <H3>Song Book</H3>

                    <div class="sidebyside">
                        <P><B>Artist</B></P>
                        <div id="Artist-#" class="inline-link"> # </div>
                        <div id="Artist-A" class="inline-link"> A </div>
                        <div id="Artist-B" class="inline-link"> B </div>
                        <div id="Artist-C" class="inline-link"> C </div>
                        <div id="Artist-D" class="inline-link"> D </div>
                        <div id="Artist-E" class="inline-link"> E </div>
                        <div id="Artist-F" class="inline-link"> F </div>
                        <div id="Artist-G" class="inline-link"> G </div>
                        <div id="Artist-H" class="inline-link"> H </div>
                        <div id="Artist-I" class="inline-link"> I </div>
                        <div id="Artist-J" class="inline-link"> J </div>
                        <div id="Artist-K" class="inline-link"> K </div>
                        <div id="Artist-L" class="inline-link"> L </div>
                        <div id="Artist-M" class="inline-link"> M </div>
                        <BR>
                        <div id="Artist-N" class="inline-link"> N </div>
                        <div id="Artist-O" class="inline-link"> O </div>
                        <div id="Artist-P" class="inline-link"> P </div>
                        <div id="Artist-Q" class="inline-link"> Q </div>
                        <div id="Artist-R" class="inline-link"> R </div>
                        <div id="Artist-S" class="inline-link"> S </div>
                        <div id="Artist-T" class="inline-link"> T </div>
                        <div id="Artist-U" class="inline-link"> U </div>
                        <div id="Artist-V" class="inline-link"> V </div>
                        <div id="Artist-W" class="inline-link"> W </div>
                        <div id="Artist-X" class="inline-link"> X </div>
                        <div id="Artist-Y" class="inline-link"> Y </div>
                        <div id="Artist-Z" class="inline-link"> Z </div>
                    </div>

                    <div class="sidebyside">
                        <P><B>Song Name</B></P>
                        <div id="Song-#" class="inline-link"> # </div>
                        <div id="Song-A" class="inline-link"> A </div>
                        <div id="Song-B" class="inline-link"> B </div>
                        <div id="Song-C" class="inline-link"> C </div>
                        <div id="Song-D" class="inline-link"> D </div>
                        <div id="Song-E" class="inline-link"> E </div>
                        <div id="Song-F" class="inline-link"> F </div>
                        <div id="Song-G" class="inline-link"> G </div>
                        <div id="Song-H" class="inline-link"> H </div>
                        <div id="Song-I" class="inline-link"> I </div>
                        <div id="Song-J" class="inline-link"> J </div>
                        <div id="Song-K" class="inline-link"> K </div>
                        <div id="Song-L" class="inline-link"> L </div>
                        <div id="Song-M" class="inline-link"> M </div>
                        <BR>
                        <div id="Song-N" class="inline-link"> N </div>
                        <div id="Song-O" class="inline-link"> O </div>
                        <div id="Song-P" class="inline-link"> P </div>
                        <div id="Song-Q" class="inline-link"> Q </div>
                        <div id="Song-R" class="inline-link"> R </div>
                        <div id="Song-S" class="inline-link"> S </div>
                        <div id="Song-T" class="inline-link"> T </div>
                        <div id="Song-U" class="inline-link"> U </div>
                        <div id="Song-V" class="inline-link"> V </div>
                        <div id="Song-W" class="inline-link"> W </div>
                        <div id="Song-X" class="inline-link"> X </div>
                        <div id="Song-Y" class="inline-link"> Y </div>
                        <div id="Song-Z" class="inline-link"> Z </div>
                    </div>

                </div>
            </div>
            <form action="removesong.php" method="POST">
                <Table id = "ResultTable">
                    <Thead>
                        <TR>
                            <TH></TH><TH>Artist</TH><TH>Song Name</TH><TH>Date Added</TH>
                        </TR>
                    </Thead>
                    <Tbody>

                    </Tbody>


                </Table>
                <div class="center">
                    Max Number of Rows: <input type="text" style="width:20px" id="numrows" name="numrows" value="10" >
                </Div>
                <input type="hidden" id="ActiveDisplay" value="Recent">
<!--                <div class="center">
                    <input type = "submit" value="Submit" name="Submit">
                </div>
-->
            </form>
            <div id="previous_button" class="navigation">Previous</div><div id="next_button" class="navigation">Next</div>
            <HR>
            <div class="Button" id="Menu">
                Admin Menu
            </div>
        </div>
    </div>

</BODY>

</HTML>