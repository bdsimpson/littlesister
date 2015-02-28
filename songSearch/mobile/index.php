<?PHP

//printf("Hello World")



?>
<!DOCTYPE HTML>
<HTML>
<Head>
	<meta name="viewport" content="width=320">
	<title>Little Sister Productions Song Lookup</title>
  <script src="../jquery/jquery-1.9.1.js"></script>
  <script src="../jquery/flexgrid-1.1/js/flexgrid.js"></script>
  
  <script language="javascript">
    $(document).ready(function(){
      //alert("I'm Ready");
       // JQuery methods here
        $("#SearchForm").submit(function(event) {
              //stop form from submitting normally
              event.preventDefault();

              //get values from form elements
              var $form = $(this);
              var $inputs = $form.find("input, select, button, textarea");

              var serializedData = $form.serialize();
			  var location = '../search.php';
			  getResults(location,serializedData);
		});
		
		function getResults(location,serializedData){
              var request = $.ajax({
                    url: location,
                    type: "post",
                    data:serializedData
              });

              //callback handler that will be called on success
              request.done(function(response, textStatus, jqXHR){
                  //alert(response);
                  jsonObj = $.parseJSON(response);
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
                           html += '<TR><TD' + colorchange + '>' + jsonObj.Results[i].Artist + '</TD><TD' + colorchange + '>' + jsonObj.Results[i].SongName + '</TD></TR>';

                      }
                      $("#ResultTable > tbody > tr").remove();
                      $("#ResultTable > tbody").append(html);

                  } // end of if/else error

              });
              request.fail(function(jqXHR, textStatus, errorThrown){
                  alert(textStatus, errorThrown);
              });



        }; // end of getResults(location, serializedData)
		function clearResults(){
			$("#ResultTable > tbody > tr").remove();
		};
        $("#SuggestionButton").click(function(){
               $("#SuggestionBox").show();


        }); // end of ("#SuggestionButton").click()


        $("#SuggestionBox").click(function(){
                $(this).hide();

        });
		
		$("#SearchButton").click(function(){
			
			$("#MenuPane").hide();
			//($("#SearchInput").fadeIn());
				$("#SearchInput").fadeIn();
				$("#Mini-Menu").fadeIn();
			
		});
		
		$("#BookButton").click(function(){
			$("#MenuPane").hide();
			showBookPane();
			$("#Mini-Menu").fadeIn();
		});
		
		$("#RecentButton").click(function(){
			$("#MenuPane").hide();
			$("#RecentPane").fadeIn();
			$("#Mini-Menu").fadeIn();
			var location="../newsongs.php";
			var serializedData = { "sortfactor" : "Artist" };
			getResults(location, serializedData);
		});
		
		$("#Mini-Menu").click(function(){
			clearResults();
			$("#Mini-Menu").hide();
			$("#MenuPane").fadeIn();
			$("#SearchInput").hide();
			$("#BookPane").hide();
			$("#RecentPane").hide();
		});
		
		function showBookPane(){
			$("#select-artist").val('None');
			$("#select-title").val('None');
			$("#BookPane").fadeIn();
		
		}
		
		$("#select-title").change(function() {
			$("#select-artist").val('None');
			if($(this).val() != 'None'){
				//alert ("Title changed: query=Song-"+$(this).val());
				var location = "../booklisting.php";
				var serializedData= { "query" : "Song-"+$(this).val() };
				getResults(location, serializedData);
			}
		});
		
		$("#select-artist").change(function() {
			$("#select-title").val('None');
			//alert ("Artist changed");
			if($(this).val() != 'None'){
				var location = "../booklisting.php";
				var serializedData= { "query" : "Artist-"+$(this).val() };
				getResults(location, serializedData);
			}
		});
    }); // end of (document.ready()


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

  </script>
	
  
  <style>
        html, body
            {
                padding:0px;
                margin:0px;
                height:100%;
                width:100%;

            }
        body
            {
                background-image:url('../images/rose-background.jpg');
				background-repeat:repeat;
				
            }
		ul
			{
				list-style:none;
				
			}
		li
			{
				margin-bottom:10px;
			}
        #PageWrapper
            {
                Width:320px;
                min-height:100%;
                margin:0 auto;
                padding:0px;

            }

		#MenuPane
			{
				background-image:url('../images/rose-background.jpg');
				background-repeat:repeat;
				width:318px;
				height:180px;
				border:2px solid black;
				position:relative;
                margin-top:0px;
                margin-left:auto;
                margin-right:auto;
				z-index:2;
			}
		#Logo
			{
				border:2px solid black;
				height:150px;
				width:150px;
				float:left;
				margin-right:5px;
				margin-left:5px;
			}
		.MenuButton
			{
				width:150px;
				height:40px;
				padding:0px;
				margin-top:0px;
				margin-bottom:5px;
				display:inline;
				position:relative;
				cursor:pointer;
			}
		.MenuButton img
			{
				height:40px;
				width:150px;
			}
		#Mini-Menu
			{
				
				background-image:url('../images/parchment-background.jpg');
				background-repeat:repeat;
				display:none;
				border: 2px solid black;
				text-align:center;
				cursor:pointer;
				height:24px;
				font-size:24px;
				margin-bottom:5px;
			}
		#SearchButton
			{
				width:150px;
				height:40px;
				
			}
		#SearchInput
			{
				border:2px solid black;
				background-color:white;
				height:120px;
				width:290px;
				margin-left:10px;
				display:none;
				
				
			}

		H1
			{
				font-family:Arial,Helvetica,sans-serif;
				font-size:18px;
				font-weight:bold;
			}
		#SearchInput .searchText
			{
				
				font-family:Arial,Helvetica,sans-serif;
				font-size:16px;
				width:250px;
				margin-left:20px;
			}
         #SuggestionBox
            {
                position:absolute;
                display:none;
                left:100px;
                width:250px;
                min-height:100px;
                border:1px solid darkred;
                z-index:5;
                background-color:white;
                padding-left:10px;
                padding-right:10px;
            }

        #SearchInput .searchButton
			{
				
				width:100px;
				margin-top:10px;
				margin-left:95px;
                background: #F5F5DC;
			}


        .radiobutton
            {
                float:left;
                max-width:35%;
                min-width:27%;
                margin-right:auto;
                margin-left:auto;
                font-family:Arial,Helvetica,sans-serif;
				font-size:12px;
                margin-top:8px;
                height:20px;
                padding-left:4px;

            }
        #SearchOptions
            {
                
				background-color:white;
				height:36px;
				
				display:block;
				margin-left:0px;
                padding:2px;
            }

        #SuggestionButton
            {
                float:right;
                font-size:10px;
                margin-top:10px;
                margin-right:8px;
                font-weight:bold;
                color:blue;
                cursor:pointer;
            }
		
		#BookPane
			{
				border:2px solid black;
				background-image:url('../images/parchment-background.jpg');
				height:120px;
				width:290px;
				margin-left:10px;
				display:none;
				padding-left:5px;
				padding-right:5px;
			}
		.BookSelection
			{
				background-color:white;
				width:138px;
				height:70px;
				display:inline-block;
				border:1px solid black;
				text-align:center;
				font-weight:bold;
				border-radius:4px;
			}
		.SelectWrapper
			{
				width:60px;
				background-color:blue;
				border-radius:4px;
				overflow:hidden;
				margin-right:auto;
				margin-left:auto;
				margin-top:10px;
				
				
			}
		.SelectWrapper select
			{
				width:80px;
				-moz-appearance: none;
				-webkit-appearance:none;
				appearance:none;
				text-align:center;
				background-color:blue;
				color:white;
				font-size:16px;
			}
		#RecentPane
			{
				border:2px solid black;
				background-image:url('../images/parchment-background.jpg');
				height:120px;
				width:290px;
				margin-left:10px;
				display:none;
				padding-top:50px;
				padding-left:5px;
				padding-right:5px;
			
			}

        #ResultPane
            {
                width:300px;
                height:auto;
                border: 1px solid black;
                
                margin-left:auto;
                margin-right:auto;
                padding:10px;
				position:absolute;
				top:200px;
                display:block;
                background-image:url('../images/parchment-background.jpg');
				

            }
        #ResultTable
            {

              width:100%;
              height:auto;
              margin-left:auto;
              margin-right:auto;
              border-collapse:collapse;
              position:relative;



            }
		#ResultTable th, td
            {
                border:1px solid black;
                background-color:white;
                padding-left:7px;
                padding-right:7px;
            }
        #ResultTable td
            {
                text-align:left;
                /*white-space:nowrap;   */
                font-family:Arial,Helvetica,sans-serif;
				font-size:12px;

            }
        #ResultTable th
            {
                text-align:center;
                height:20px;
            }
		.altRow
            {
                background-color:#F5F5DC;
            }
		.shadow1 
			{
				
				margin:10px;
				background-color: rgb(68,68,68); /* Needed for IEs */

				-moz-box-shadow: 5px 5px 5px rgba(68,68,68,0.6);
				-webkit-box-shadow: 5px 5px 5px rgba(68,68,68,0.6);
				box-shadow: 5px 5px 5px rgba(68,68,68,0.6);

				filter: progid:DXImageTransform.Microsoft.Blur(PixelRadius=3,MakeShadow=true,ShadowOpacity=0.30);
				-ms-filter: "progid:DXImageTransform.Microsoft.Blur(PixelRadius=3,MakeShadow=true,ShadowOpacity=0.30)";
				zoom: 1;
			}
		.shadow1 .content 
			{
				position: relative; /* This protects the inner element from being blurred */
				/*padding: 100px;*/
				
			}
		
		.center
			{
                text-align:center;
			}
	
	</style>
</head>

<body>
    
    <div id="PageWrapper">

			<div id="Mini-Menu">
				Menu
			</div>

        	<div id="MenuPane" class="shadow1">
        		<div class="content">
        			
					<div id="Logo">
						<img src="../images/LSP-cropped.jpg" height="150" width="150">
					</div>
					<ul>
					
						<li>
							<div class="MenuButton" id="SearchButton">
								<img src="../images/SearchButton-big.jpg">
							</div>
						</li>
						<li>
							<div class="MenuButton" id="BookButton">
								<img src="../images/BookButton-big.jpg">
							</div>
						</li>
						<li>
							<div class="MenuButton" id="RecentButton">
								<img src="../images/RecentButton-big.jpg">
							</div>
						</li>
					</ul>
					
							
				</div>
			</div>  <!-- end of MenuPane -->

                    <form action="/" id="SearchForm">
            			<div id="SearchInput">
        					<H1 class="center">Karaoke Song Search</H1>
        					<input type="text" class="searchText" id="SearchField" name="SearchField" width="150">
                                <div id="SuggestionBox">
                                    <P>
                                        If you Cannot find the song you are looking for, try searching for partial phrases.
                                    </p>
                                    <p>
                                        For Example, searching "Pat Ben" will find Pat Benatar
                                    </p>
                                </div>
        					<input type="Submit" id="searchButton" class="searchButton" value="Search">
                            <div id="SuggestionButton">
                                Need Help?
                            </div>
							<div id="SearchOptions">
								<div class="radiobutton"><input type="radio" name="parameters" value="SongName">Song Name</div>
								<div class="radiobutton"><input type="radio" name="parameters" value="Artist">Artist</div>
								<div class="radiobutton"><input type="radio" name="parameters" value="Both" checked>Search Both</div>
							</div>
                        </div>
                    </form>
					<!-- End of SearchForm -->
        	
            <!-- End of Search Window -->
			
			<!-- ********************  BookPane  *******************************  -->
			<div id="BookPane">
				<H1 class="center">Full Song Book</H1>
				<form>
				<div class="BookSelection">
					Artist A-Z
					<br>
					<div class="SelectWrapper">
						<select name="select-artist" id="select-artist">
							<option value="None">Choose:</option>
							<option value="A">A</option>
							<option value="B">B</option>
							<option value="C">C</option>
							<option value="D">D</option>
							<option value="E">E</option>
							<option value="F">F</option>
							<option value="G">G</option>
							<option value="H">H</option>
							<option value="I">I</option>
							<option value="J">J</option>
							<option value="K">K</option>
							<option value="L">L</option>
							<option value="M">M</option>
							<option value="N">N</option>
							<option value="O">O</option>
							<option value="P">P</option>
							<option value="Q">Q</option>
							<option value="R">R</option>
							<option value="S">S</option>
							<option value="T">T</option>
							<option value="U">U</option>
							<option value="V">V</option>
							<option value="W">W</option>
							<option value="X">X</option>
							<option value="Y">Y</option>
							<option value="Z">Z</option>
							<option value="#">#</option>
						</select>
					</div>
				</div>
				<div class="BookSelection">
					Titles A-Z
					<br>
					<div class="SelectWrapper">
						<select name="select-title" id="select-title">
							<option value="None" selected>Choose</option>
							<option value="A">A</option>
							<option value="B">B</option>
							<option value="C">C</option>
							<option value="D">D</option>
							<option value="E">E</option>
							<option value="F">F</option>
							<option value="G">G</option>
							<option value="H">H</option>
							<option value="I">I</option>
							<option value="J">J</option>
							<option value="K">K</option>
							<option value="L">L</option>
							<option value="M">M</option>
							<option value="N">N</option>
							<option value="O">O</option>
							<option value="P">P</option>
							<option value="Q">Q</option>
							<option value="R">R</option>
							<option value="S">S</option>
							<option value="T">T</option>
							<option value="U">U</option>
							<option value="V">V</option>
							<option value="W">W</option>
							<option value="X">X</option>
							<option value="Y">Y</option>
							<option value="Z">Z</option>
							<option value="#">#</option>
						</select>
					</div>
				</div>
				</form>
			</div>
			
			<!--  End of Book Pane  -->
			
			<!-- ******************************Recent Pane ************************ -->
			<div id="RecentPane">
				<H1 class="center">Songs added in the last 60 Days</H1>
			</div>
			
			<!-- End of Recent Pane -->

            <div id="ResultPane" class="shadow1">
                <div class="content">
                    <table id="ResultTable">
                        <thead>
                            <TR>
                                <TH>Artist</TH>
                                <TH>Song Name</TH>
                            </TR>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>  <!-- Do Not Modify Table Body... changes made through javascript -->
                </div>
            </div>

    </div> <!-- End of Page Wrapper-->
</body>

</html>