<section class="jumbotron text-center mb-4">
    <div class="container">
        <h1 class="display-4">Places</h1>
        <p class="lead text-muted">List all the places on the map and filter them based on nearest by the distance</p>
        <p>
            <a href="<?php echo site_url('location/add'); ?>" class="btn btn-primary">Add Location</a>
            <a class="btn btn-secondary" data-toggle="collapse" href="#collapseFilter" aria-expanded="false" aria-controls="collapseFilter">Filter Locations</a>
        </p>
    </div>
</section>

<div class="container">

	<div class="collapse <?php echo ($filter == TRUE) ? 'show' : ''; ?>" id="collapseFilter">
		<div class="card mb-4">
			<div class="card-header">
				<label class="lead">Find Nearby Locations</label>
			</div>
			<div class="card-body">
				<form method="post">
					<?php if(validation_errors()): ?>
						<div class="alert alert-danger" role="alert">
							<?php echo validation_errors(); ?>
						</div>
					<?php endif; ?>
					<div class="row">
						<div class="col-md-5">
							<input id="pac-input" type="text" name="address" class="form-control" onfocus="geolocate()" placeholder="Enter a location" value="<?php echo $this->input->post('address'); ?>">
							<input name="latitude" id="latitude" type="hidden" value="<?php echo $this->input->post('latitude'); ?>">
							<input name="longitude" id="longitude" type="hidden" value="<?php echo $this->input->post('longitude'); ?>">
						</div>
						<div class="col-md-4">
							<div class="row">
								<div class="col-md-6">
									<input type="text" readonly class="form-control-plaintext" id="staticEmail2" value="Radius (kms) [optional]" >
								</div>
								<div class="col-md-6">
									<input name="radius" type="text" value="<?php echo $this->input->post('radius'); ?>" class="form-control">
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<button class="btn btn-primary">Search</button>
							<a class="btn btn-outline-secondary"href="<?php echo site_url(); ?>">Reset</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<?php if(!empty($locations)): ?>
		<div class="card mb-4">
			<div id="map_wrapper">
			    <div id="map_canvas" class="mapping"></div>
			</div>
		</div>
	<?php endif; ?>

	<?php if($this->session->flashdata('success_message')): ?>
		<div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
			<?php echo $this->session->flashdata('success_message'); ?>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	<?php endif; ?>

	<?php if($this->session->flashdata('error_message')): ?>
		<div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
			<?php echo $this->session->flashdata('error_message'); ?>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	<?php endif; ?>

	<div class="table-responsive">
		<table class="table table-bordered">
			<thead class="thead-light">
				<tr>
					<th scope="col" class="w-25 text-center">Name</th>
					<th scope="col" class="w-25 text-center">Address</th>
					<th scope="col" class="w-25 text-center">Distance</th>
					<th scope="col" class="w-25 text-center">Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php if(!empty($locations)): ?>
					<?php foreach($locations as $location): ?>
						<tr>
							<td scope="row" class="text-center"><?php echo $location['name']; ?></td>
							<td scope="row" class="text-center"><?php echo ($location['address'] !== null) ? $location['address'] : "-"; ?></td>
							<td scope="row" class="text-center"><?php echo ($filter == true) ? $location['distance'] . " kms" : "-"; ?></td>
							<td scope="row" class="text-center">
								<a href="<?php echo site_url('location/map/'.$location['id']) ?>" class="btn btn-outline-success btn-sm">View Map</a>
								<a href="<?php echo site_url('location/edit/'.$location['id']) ?>" class="btn btn-outline-warning btn-sm">Edit</a>
								<a href="<?php echo site_url('location/delete/'.$location['id']) ?>" class="btn btn-outline-danger btn-sm">Delete</a>
							</td>
						</tr>
					<?php endforeach; ?>
				<?php else: ?>
					<tr>
						<td colspan="4" class="text-center">No locations added / filtered</td>
					</tr>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
</div>

<script>
	var locations = [];
	<?php foreach($locations as $location): ?>
	 	location_data = {
	 		name: '<?php echo $location['name']; ?>',
	 		latitude: '<?php echo $location['latitude']; ?>',
	 		longitude: '<?php echo $location['longitude']; ?>',
	 		address: '<?php echo $location['address']; ?>',
	 	}
    	locations.push(location_data);
    <?php endforeach; ?>
</script>
<script src="<?php echo base_url('resources/js/location_index.js'); ?>"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_API_KEY; ?>&libraries=places&callback=initAutocomplete"></script>