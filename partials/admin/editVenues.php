
<!-- LOADING ICON =============================================== -->
<!-- show loading icon if the loading variable is set to true -->

<p class="text-center" ng-show="loading"><span class="fa fa-meh-o fa-5x fa-spin"></span></p>


<style>
	.venueThumb {
		width:100px;
		float:left;
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

</style>
<H1><Strong> Our Shows </Strong></H1>
<hr>

<div ng-repeat="venue in venues" class="venueRepeater">
	<div class="venueWrapper">
		<!-- Form -->
		<div class="editForm">
		
			<form method="post" id="form_{{venue.id}}">
				<div class="editForm_block">	
					<div class="form-group">
						<label for="name_{{venue.id}}">Venue Name</label>
						<input type="text" size="50" id="name_{{venue.id}}" value="{{venue.venueName}}" class="form-control" ng-model="venue.venueName">
					</div>
					
					<div class="form-group">
						<label for="text_{{venue.id}}">Venue Description</label>
						<textarea id="text_{{venue.id}}" size="255" class="form-control" ng-model="venue.venueText"></textarea>
					</div>
					<div class="form-group">
						<label for="address_{{venue.id}}">Address</label>
						<input type="text" id="address_{{venue.id}}" size="128" value="{{venue.venueAddress}}" class="form-control" ng-model="venue.venueAddress">
					</div>
					<div class="form-group">
						<label for="city_{{venue.id}}">City</label>
						<input type="text" id="city_{{venue.id}}" size="128" value="{{venue.venueCity}}" class="form-control" ng-model="venue.venueCity">
					</div>
					<div class="form-group">
						<label for="state_{{venue.id}}">State</label>
						<input type="text" id="state_{{venue.id}}" size="2" value="{{venue.venueState}}" class="form-control" ng-model="venue.venueState">
					</div>
					<div class="form-group">
						<label for="zip_{{venue.id}}">Zip</label>
						<input type="text" id="zip_{{venue.id}}" size="5" value="{{venue.venueZip}}" class="form-control" ng-model="venue.venueZip">
					</div>
				</div>
				<div class="editForm_block">
					<div class="form-group">
						<label for="day_{{venue.id}}">Event Day</label>
						<input type="text" id="day_{{venue.id}}" size="20" value="{{venue.eventDay}}" class="form-control" ng-model="venue.eventDay">
					</div>
					<div class="form-group">
						<label for="start_{{venue.id}}">Event Time</label>
						<input type="text" id="start_{{venue.id}}" size="30" value="{{venue.eventTime}}" class="form-control" ng-model="venue.eventTime">
					</div>
					<div><label for="image_{{venue.id}}">Image</label></div>
					<!-- Image Selection ================================ -->
					<div ng-if="venue.venueImage != null">
						<div class="bigThumb">
							<img ng-src="images/venues/{{venue.venueImage}}">
						</div>
						<P>&nbsp;</P>
						<button type="button" class="btn btn-success btn-lg AdminOption">Change Image</button>
					</div>
					
					<div ng-if="venue.venueImage == null">
						<div class="bigThumb">
							<div class="imgPlaceHolder">&nbsp;</div>
						</div>
						<button type="button" class="btn btn-success btn-lg AdminOption">Change Image</button>
						
					</div>
					<!-- END of Image Selection ========================= -->
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
</div> <!-- VenueRepeater -->
