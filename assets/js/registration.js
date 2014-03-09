/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function() {
    var location = '<?php echo $event->lat_long; ?>';
    var hotel_location = '<?php echo $event->hotel_lat_long; ?>';
    if(location) {
        $('#map').gmap3({
            map: {
                options: {
                    center: ['<?php echo $event->lat_long; ?>'],
                    zoom: 14,
                    scrollwheel: false,
                    backgroundColor: '#FFFFFF'
                }
            },
            marker: {
                latLng: ['<?php echo $event->lat_long; ?>'],
                options: {
                    icon: "http://maps.google.com/mapfiles/marker_green.png",
                    animation: google.maps.Animation.DROP
                }
            }
        });

    }
    if(hotel_location) {
        $('#hotel_map').gmap3({
            action: 'init',
            map: {
                options: {
                    center: ['<?php echo $event->hotel_lat_long; ?>'],
                    zoom: 14,
                    scrollwheel: false
                }                
            },
            marker: {
                latLng: ['<?php echo $event->hotel_lat_long; ?>'],
                options: {
                    icon: "http://maps.google.com/mapfiles/marker_green.png",
                    animation: google.maps.Animation.DROP
                }
            }

        });        
    }      
});

