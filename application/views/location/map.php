<div id="map" class="h-600"></div>
<div class="p-3">
	<a href="<?php echo site_url(); ?>">Back to listing</a>
</div>

<script>
	var latitude = <?php echo $location['latitude']; ?>;
	var longitude = <?php echo $location['longitude']; ?>;
	var address = '<?php echo ($location['address'] !== null) ? $location['address'] : $location['name']; ?>';
	var name = '<?php echo $location['name']; ?>';
</script>
<script src="<?php echo base_url('resources/js/location_map.js'); ?>"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_API_KEY; ?>&callback=initMap"></script>