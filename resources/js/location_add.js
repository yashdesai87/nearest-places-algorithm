// This example requires the Places library. Include the libraries=places
// parameter when you first load the API. For example:
// <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

function initMap() {
	var map = new google.maps.Map(document.getElementById('map'), {
		center: {lat: 20.593684, lng: 78.96288000000004},
		zoom: 6
	});
	var card = document.getElementById('pac-card');
	var input = document.getElementById('pac-input');
	var latitude = document.getElementById('latitude');
	var longitude = document.getElementById('longitude');
	var google_place_name = document.getElementById('google_place_name');
	var google_place_address = document.getElementById('google_place_address');

	map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);

	var autocomplete = new google.maps.places.Autocomplete(input);

	// Bind the map's bounds (viewport) property to the autocomplete object,
	// so that the autocomplete requests use the current map bounds for the
	// bounds option in the request.
	autocomplete.bindTo('bounds', map);

	var infowindow = new google.maps.InfoWindow();
	var infowindowContent = document.getElementById('infowindow-content');
	infowindow.setContent(infowindowContent);
	var marker = new google.maps.Marker({
		map: map,
		anchorPoint: new google.maps.Point(0, -29)
	});

	// call when address exists after form invalidates
	if(latitude.value !== "" && longitude.value !== "") {
		setLocation();
	}

	// call event when user types a new location
	autocomplete.addListener('place_changed', function() {
		infowindow.close();
		marker.setVisible(false);
		var place = autocomplete.getPlace();
		if (!place.geometry) {
			// User entered the name of a Place that was not suggested and
			// pressed the Enter key, or the Place Details request failed.
			return;
		}

		latitude.value = place.geometry.location.lat();
		longitude.value = place.geometry.location.lng();

		var address = '';
		if (place.address_components) {
			address = [
			(place.address_components[0] && place.address_components[0].short_name || ''),
			(place.address_components[1] && place.address_components[1].short_name || ''),
			(place.address_components[2] && place.address_components[2].short_name || '')
			].join(' ');
		}

		google_place_name.value = place.name;
		google_place_address.value = address;
		setLocation();
	});


	function setLocation() {
		var location = new google.maps.LatLng(latitude.value, longitude.value);
		map.setCenter(location);
		map.setZoom(17);
		setMarker(location);
		setInfoWindow(google_place_name.value, google_place_address.value);
	}

	function setMarker(location) {
		marker.setPosition(location);
		marker.setVisible(true);
	}

	function setInfoWindow(name, address) {
		infowindowContent.children['place-name'].textContent = name;
		infowindowContent.children['place-address'].textContent = address;
		infowindow.open(map, marker);
	}
}