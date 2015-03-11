              <?PHP

//printf("Hello World")



?>
<!DOCTYPE HTML>
<HTML>
<Head>
	<title>Little Sister Productions Recent Additions</title>
  <script src="./jquery/jquery-1.9.1.js"></script>
  <script src="./jquery/flexigrid.js"></script>

  <script language="javascript">
    $(document).ready(function(){
      //alert("I'm Ready");
       // JQuery methods here
            var numrows = 5000;
            var beginning = 0;
            var bookselection = "";

            // Combined Ajax function
            function getResults(){

                var location = 'newsongs.php';
                var postData = { "sortfactor" : "Artist", "rowmax" : numrows, "start" : beginning };

                var request = $.ajax({
                    url: location,
                    data: postData,
                    type: "POST"
                });
                request.done(function(response){
                    //alert("Hello");
                    //alert(response);
                  jsonObj = $.parseJSON(response);
                  //*************

                  var html = "";
                  var colorchange;
                  //alert(jsonObj.Results.length);
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
                  //alert(html);
                });
                request.fail(function(){
                    alert("Error Connecting to Database");
                });
            }; // end of function getResults
        getResults();

        $("#SuggestionButton").click(function(){
               $("#SuggestionBox").show();


        }); // end of ("#SuggestionButton").click()


        $("#SuggestionBox").click(function(){
                $(this).hide();

        });

		$("#BookButton").click(function(){
			window.location = "songbook.php";
		});
		$("#RecentButton").click(function(){
			window.location = "showrecent.php";
		});
		$("#SearchButton").click(function(){
			window.location = "index.php";
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
                background-image:url('./images/rose-background.jpg');
				background-repeat:repeat;
            }
		ul
			{
				list-style:none;
				padding:0;
				margin:0;
				
			}
		li
			{
				margin-bottom:10px;
				margin-top:10px;
				margin-left:10px;
				
			}
			#PageWrapper
            {
                Width:800px;
                min-height:100%;
                background-image:url('./images/parchment-background.jpg');
				background-repeat:repeat;
                margin:0 auto;
                padding:10px;

            }


		#SearchPane
			{
				background-image:url('./images/rose-background.jpg');
				background-repeat:repeat;
				width:683px;
				height:200px;
				border:2px solid black;
				position:relative;
                margin-top:10px;
                margin-left:auto;
                margin-right:auto;
			}
		#Logo
			{
				border:2px solid black;
				height:150px;
				width:150px;
				position:absolute;
				top:10px;
				left:10px;
			}
		#SearchInput
			{
				border:2px solid black;
				background-color:white;
				height:180px;
				width:290px;
				position:absolute;
				top:10px;
				left:200px;

			}
		#MenuPane
			{
				border:2px solid black;
				background-color:white;
				height: 180px;
				width:170px;
				position:absolute;
				top:10px;
				left:500px;
				
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
				width:150px;
				height:40px;
			}
		#SearchInput H1
			{
				font-family:Arial,Helvetica,sans-serif;
				font-size:18px;
				font-weight:bold;
			}
        #SearchInput H2
            {
                font-family:Arial,Helvetica,sans-serif;
                font-size:16px;
                font-weight:bold;
                margin-top:5px;
                margin-bottom:5px;
            }
        #SearchInput .inline-link
            {
                display:inline;
                color:blue;
                cursor:pointer;

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
                border:2px solid black;
				background-color:white;
				height:36px;
				width:276px;
				position:absolute;
				top:140px;
				left:200px;
                padding:7px;
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




        #ResultPane
            {
                width:600px;
                height:auto;
                border: 1px solid black;
                margin-top:25px;
                margin-left:auto;
                margin-right:auto;
                padding:10px;
                position:relative;
                background-image:url('./images/rose-background.jpg');

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
				font-size:14px;

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


        	<div id="SearchPane" class="shadow1">
        		<div class="content">
        			<div id="Logo">
        				<img src="./images/LSP-cropped.jpg" height="180" width="180">
        			</div>

                    <form action="/" id="SearchForm">
            			<div id="SearchInput">
        					<H1 class="center">Karaoke Song Book</H1>
                            <H1 class="center">Recent Additions</H1>

            			</div>

                    </form>
					<div id="MenuPane">
						
							<ul>
								<li>
									<div class="MenuButton" id="SearchButton">
										<img src="./images/SearchButton-big.jpg">
									</div>
								</li>
								<li>
									<div class="MenuButton" id="BookButton">
										<img src="./images/BookButton-big.jpg">
									</div>
								</li>
								<li>
									<div class="MenuButton" id="RecentButton">
										<img src="./images/RecentButton-big.jpg">
									</div>
								</li>
							</ul>
						
					</div> <!-- end of MenuPane  -->
        		</div>
        	</div>



            <!-- End of Search Window -->

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