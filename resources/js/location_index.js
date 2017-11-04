// This example displays an address form, using the autocomplete feature
// of the Google Places API to help users fill in the information.

// This example requires the Places library. Include the libraries=places
// parameter when you first load the API. For example:
// <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

var placeSearch, autocomplete;

function initAutocomplete() {
	// Create the autocomplete object, restricting the search to geographical
	// location types.
	autocomplete = new google.maps.places.Autocomplete(
		/** @type {!HTMLInputElement} */
		(document.getElementById('pac-input')),
		{types: ['geocode']}
	);

	// When the user selects an address from the dropdown, populate the address
	// fields in the form.
	autocomplete.addListener('place_changed', fillInAddress);

	if(typeof initialize == "function") {
		initialize();
	}
}

function fillInAddress() {
	// Get the place details from the autocomplete object.
	var place = autocomplete.getPlace();
	var latitude = document.getElementById('latitude');
	var longitude = document.getElementById('longitude');

	latitude.value = place.geometry.location.lat();
	longitude.value = place.geometry.location.lng();
}

// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function(position) {
			var geolocation = {
				lat: position.coords.latitude,
				lng: position.coords.longitude
			};
		});
	}
}

function initialize() {
    var map;
    var bounds = new google.maps.LatLngBounds();
    var mapOptions = {
        mapTypeId: 'roadmap'
    };

    // Display a map on the page
    map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
    map.setTilt(45);

    // Multiple Markers
    var markers = [];
    for (var i = locations.length - 1; i >= 0; i--) {
    	markers.push([locations[i].name, locations[i].latitude, locations[i].longitude]);
    }

    // Info Window Content
    var infoWindowContent = [];
	for (var i = locations.length - 1; i >= 0; i--) {
		infoWindowContent.push(['<div class="info_content">' +
	        '<span>' + locations[i].address + '</span>' +
	        '</div>']);
    }

    // Display multiple markers on a map
    var infoWindow = new google.maps.InfoWindow(), marker, i;
    
    // Loop through our array of markers & place each one on the map  
    for( i = 0; i < markers.length; i++ ) {
        var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
        bounds.extend(position);
        marker = new google.maps.Marker({
            position: position,
            map: map,
            title: markers[i][0]
        });
        
        // Allow each marker to have an info window    
        google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
                infoWindow.setContent(infoWindowContent[i][0]);
                infoWindow.open(map, marker);
            }
        })(marker, i));

        // Automatically center the map fitting all markers on the screen
        map.fitBounds(bounds);
    }

    // Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
    var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
        google.maps.event.removeListener(boundsListener);
    });
}