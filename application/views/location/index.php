<section class="jumbotron text-center">
    <div class="container">
        <h1 class="display-4">Places</h1>
        <p class="lead text-muted">List all the places on the map and filter them based on nearest by the distance</p>
        <p>
            <a href="<?php echo site_url('location/add'); ?>" class="btn btn-primary">Add Location</a>
        </p>
    </div>
</section>

<div class="container">

	<?php if($this->session->flashdata('success_message')): ?>
		<div class="alert alert-success alert-dismissible fade show" role="alert">
			<?php echo $this->session->flashdata('success_message'); ?>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	<?php endif; ?>

	<?php if($this->session->flashdata('error_message')): ?>
		<div class="alert alert-danger alert-dismissible fade show" role="alert">
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
					<th scope="col" class="w-50 text-center">Address</th>
					<th scope="col" class="w-25 text-center">Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php if(!empty($locations)): ?>
					<?php foreach($locations as $location): ?>
						<tr>
							<td scope="row" class="text-center"><?php echo $location['name']; ?></td>
							<td scope="row" class="text-center"><?php echo ($location['address'] !== null) ? $location['address'] : "-"; ?></td>
							<td scope="row" class="text-center">
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