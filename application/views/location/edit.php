<section class="jumbotron text-center mb-4">
    <div class="container">
        <h1 class="display-4">Edit Place</h1>
        <p class="lead text-muted">Update an existing place by searching through google place search</p>
    </div>
</section>

<div class="container">
	<form method="post">
		<div class="form-group">
			<label for="placeName">Name</label>
			<input type="text" class="form-control" name="name" id="placeName" aria-describedby="nameHelp" placeholder="Enter name" value="<?php echo ($this->input->post('name')) ? $this->input->post('name') : $location['name']; ?>">
			<?php echo form_error("name"); ?>
		</div>
		<div class="form-group">
			<label for="placeName">Location</label>
			<div class="pac-card" id="pac-card">
				<h3 class="bg-primary text-white p-2">Search</h3>
				<div id="pac-container">
					<input id="pac-input" type="text" name="address" class="form-control" placeholder="Type the address" value="<?php echo ($this->input->post('address')) ? $this->input->post('address') : $location['address']; ?>">
					<input name="latitude" id="latitude" type="hidden" value="<?php echo ($this->input->post('latitude')) ? $this->input->post('latitude') : $location['latitude']; ?>">
					<input name="longitude" id="longitude" type="hidden" value="<?php echo ($this->input->post('longitude')) ? $this->input->post('longitude') : $location['longitude']; ?>">
					<input name="google_place_name" id="google_place_name" type="hidden" value="<?php echo ($this->input->post('google_place_name')) ? $this->input->post('google_place_name') : $location['google_place_name']; ?>">
					<input name="google_place_address" id="google_place_address" type="hidden" value="<?php echo ($this->input->post('google_place_address')) ? $this->input->post('google_place_address') : $location['google_place_address']; ?>">
				</div>
			</div>
			<div id="map-top">
				<div id="map"></div>
			</div>
			<div id="infowindow-content">
				<span id="place-name"  class="title"></span><br>
				<span id="place-address"></span>
			</div>
			<small id="nameHelp" class="form-text text-muted">Search place by typing in the box given on the map.</small>
			<?php echo form_error("address"); ?>
		</div>
  		<button type="submit" class="btn btn-primary">Save</button>
  		<a href="<?php echo site_url(); ?>" class="btn btn-secondary">Back</a>
	</form>
</div>

<script src="<?php echo base_url('resources/js/location_edit.js'); ?>"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_API_KEY; ?>&libraries=places&callback=initMap" async defer></script>