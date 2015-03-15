<!-- LOADING ICON =============================================== -->
<!-- show loading icon if the loading variable is set to true -->

<p class="text-center" ng-show="loading"><span class="fa fa-meh-o fa-5x fa-spin"></span></p>


<style>
	.venueThumb {
		width:100px;
		display:inline-block;
		margin-right:20px;
		overflow:hidden;
	}


	.venueThumb	img {
		width:100px;
		height:auto;
	}
	.bigThumb {
		padding:10px;
		border:1px solid black;
		background-color:lightgrey;
		width:220px;
		min-height:200px;
		margin-bottom:10px;
	}
	.bigThumb img{
		width:200px;
		height:auto;
	}
	.imgPlaceHolder {
		width:200px;
		height:200px;
	}
	.venueName {
		width:500px;
	}
	.venueDesc {
		display:block;
		width:300px;
		float:left;
		margin-bottom:20px;

	}
	.address {
		display:block;
	}
	.venueRepeater {
		clear:both;
	}
	.venueWrapper {
		
		padding:20px;
		border-bottom:2px solid black;
		min-height:200px;
		overflow:hidden;
	}
	.event_time, .event_day {
		color:#A62A23;
	}
	.event_time {
		font-size:18px;
	}
	.editForm {
		float:left;
		min-width:300px;
		margin-right:20px;
	}
	.editForm_block{
		width:300px;
		float:left;
		margin-right:20px;
	}
	.drop-box {
    background: #F8F8F8;
    border: 5px dashed #DDD;
    width: 200px;
    height: 120px;
    text-align: center;
    padding-top: 0px;
    margin: 10px;
    cursor:pointer;

	}
	.dragover {
	    border: 5px dashed blue;
	}

</style>
<H1><Strong> New Venue </Strong></H1>
<hr>


	<div class="venueWrapper">
		<!-- Form -->
		<div class="editForm">
		
			<form method="post" id="form_{{venue.id}}">
				<div class="editForm_block">	
					<div class="form-group">
						<label for="name_{{venue.id}}">Venue Name</label>
						<input type="text" size="50" id="name_{{venue.id}}" placeholder="Venue Name" class="form-control" ng-model="venue.venueName">
					</div>
					
					<div class="form-group">
						<label for="text_{{venue.id}}">Venue Description</label>
						<textarea id="text_{{venue.id}}" size="255" placeholder="Venue Description" class="form-control" ng-model="venue.venueText"></textarea>
					</div>
					<div class="form-group">
						<label for="address_{{venue.id}}">Address</label>
						<input type="text" id="address_{{venue.id}}" size="128" placeholder="Street Address" class="form-control" ng-model="venue.venueAddress">
					</div>
					<div class="form-group">
						<label for="city_{{venue.id}}">City</label>
						<input type="text" id="city_{{venue.id}}" size="128" placeholder="City" class="form-control" ng-model="venue.venueCity">
					</div>
					<div class="form-group">
						<label for="state_{{venue.id}}">State</label>
						<input type="text" id="state_{{venue.id}}" size="2" placeholder="State" class="form-control" ng-model="venue.venueState">
					</div>
					<div class="form-group">
						<label for="zip_{{venue.id}}">Zip</label>
						<input type="text" id="zip_{{venue.id}}" size="5" placeholder="Zip" class="form-control" ng-model="venue.venueZip">
					</div>
				</div>
				<div class="editForm_block">
					<div class="form-group">
						<label for="day_{{venue.id}}">Event Day <small> (ex: "Sunday")</small></label>
						<input type="text" id="day_{{venue.id}}" size="20" placeholder="Event Day" class="form-control" ng-model="venue.eventDay">
					</div>
					<div class="form-group">
						<label for="start_{{venue.id}}">Event Time</label>
						<input type="text" id="start_{{venue.id}}" size="30" placeholder="Event Time" class="form-control" ng-model="venue.eventTime">
					</div>
					<div><label for="image_{{venue.id}}">Image</label></div>
					<!-- Image Selection ================================ -->
					<div ng-if="venue.venueImage != null">
						<div class="bigThumb">
							<img ng-src="images/venues/{{venue.venueImage}}">
						</div>
						<P>&nbsp;</P>
					</div>
					
					<div ng-if="venue.venueImage == null">
						<div class="bigThumb">
							<div class="imgPlaceHolder">&nbsp;</div>
						</div>
						
						
					</div>
					<button type="button" ng-click='toggleModal()' class="btn btn-success btn-lg AdminOption">Change Image</button>
					<!-- END of Image Selection ========================= -->

					<!-- Modal Window Popup ============================= -->
					<!--<button ng-click='toggleModal()'>Open Modal Dialog</button>-->
					<modal-dialog show='modalShown' width='750px' height='60%' >
						<div ng-controller="NewVenuesController">
							  <h1>Choose Existing Image<h1>
							  <div style="clear:both;">
								  <div class="venueThumb" ng-repeat="image in images">
								  	<img ng-src="images/venues/{{image.url}}">
								  </div>
							  </div>
							  <div style="display:block; clear:both; margin-top:20px; margin-bottom:20px;">
							  <HR>
							  </div>
							  <div style="clear:both;">
							  <h1>Add New Image</h1>
							  		<div ng-file-drop ng-file-select ng-model="files" class="drop-box" 
							  			drag-over-class="dragover" ng-multiple="true" allow-dir="true">
							  			<span style="font-size:20px;">Drop images here or click to upload</span>
							  		</div>
							  		<div ng-no-file-drop>File Drag/Drop is not supported for this browser</div>
						  		    <ul>
								        <li ng-repeat="f in files" style="font:smaller">{{f.name}}</li>
								    </ul>

							  </div>
					  	</div>
					</modal-dialog>
					<!-- End of Modal Window ============================ -->
					
				</div> <!-- editform_block -->
				
			</form>
		</div>

		<!--  Preview -->
		<div style="float:left">
			<div class="event_day lobster"><H2>{{venue.eventDay}}</H2></div>

			<div class="venueThumb">
				<img ng-src="images/venues/{{venue.venueImage}}">
			</div>

			<div class="venueDesc">
				<div class="venueName">
				
				<H2><Strong>{{venue.venueName}}</Strong></H2>
				<div class="event_time">{{venue.eventTime}}</div>
			</div>
				<h3><span style="white-space:pre-wrap">{{venue.venueText}}</span></h3>
				<UL class="list-unstyled">
		            <li>{{venue.venueAddress}}</li>
		            <li>{{venue.venueCity}}, {{venue.venueState}} {{venue.venueZip}}</li>
		        </UL>
			</div>
		</div> <!-- Preview Pane -->
	</div>  <!-- VenueWrapper -->
	<P>
		<button type="button" class="btn btn-primary btn-lg AdminOption">Save Venue</button>
	</P>

