// This example displays a marker at the center of Australia.
// When the user clicks the marker, an info window opens.

function initMap() {
	var location = { lat: latitude, lng: longitude };
	var map = new google.maps.Map(document.getElementById('map'), {
		zoom: 12,
		center: location
	});

	var contentString = '<div id="content">'+
	'<span>' + address + '</span>'+
	'</div>';

	var infowindow = new google.maps.InfoWindow({
		content: contentString
	});

	var marker = new google.maps.Marker({
		position: location,
		map: map,
		title: name
	});
}