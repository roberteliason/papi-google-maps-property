function initMap( slug ) {
    var $searchField = jQuery( '#'+slug+'_search' );
    var $canvas      = jQuery( '#'+slug );
    var lat          = parseFloat( $canvas.attr( 'data-lat' ) );
    var lng          = parseFloat( $canvas.attr( 'data-lng' ) );
    var map          = new google.maps.Map( document.getElementById( slug ), {
        zoom: 15,
        center: {lat: lat, lng: lng}
    });

    var marker = new google.maps.Marker({
        map: map,
        position: {lat: lat, lng: lng}
    });

    var geocoder = new google.maps.Geocoder();
    $searchField.on ( 'keypress', function ( e ) {
        if (e.which == 13) {
            e.preventDefault ();
            geocodeAddress( geocoder, map, slug );
        }
    });

    $searchField.on ( 'blur', function ( e ) {
        e.preventDefault ();
        geocodeAddress( geocoder, map, slug );
    });
}

function geocodeAddress( geocoder, resultsMap, slug ) {
    var address = document.getElementById( slug+'_search' ).value;

    geocoder.geocode( { 'address': address }, function( results, status ) {
        if ( status === google.maps.GeocoderStatus.OK ) {
            resultsMap.setCenter( results[0].geometry.location );
            resultsMap.setZoom( 15 );

            var marker = new google.maps.Marker({
                map: resultsMap,
                position: results[0].geometry.location
            });

            document.getElementById( slug+'_papi-property-map-lat' ).value = results[0].geometry.location.lat();
            document.getElementById( slug+'_papi-property-map-lng' ).value = results[0].geometry.location.lng();
        } else {
            // console.log('Geocode was not successful for the following reason: ' + status);
        }
    });
}