(function($) {
		"use strict";
		jQuery(document).ready(function() {

			// Google Map

			var map;

			function initialize() {

				var lat = "14.106417";
        var long = "-87.208296";

				var myLatLng=new google.maps.LatLng(lat, long);

				var mapOptions = {
					zoom: 19,
					scrollwheel : false,
					center: myLatLng,
					draggable: !("ontouchend" in document)
				};

			map = new google.maps.Map(document.getElementById('mymap'), mapOptions)

			var iconBase = 'images/pingreen.png';
			var marker = new google.maps.Marker({

			  position: myLatLng,
			  map: map,
			  icon: iconBase,
			  title: 'CreditoSolidario'
			});

			marker.setMap(map);

		}

		google.maps.event.addDomListener(window, 'load', initialize);

		});

	})($);
