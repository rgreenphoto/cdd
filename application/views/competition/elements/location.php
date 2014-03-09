<br />
<div class="row">
    <div class="col-lg-6">
        <?php echo $event->location; ?>
    </div>
    <div class="col-lg-6 well">
        <div id="map" style="height:250px; min-width:250px;"></div>
    </div>
</div>
<script>
    $('#viewMap').click(function(){
         $('#mapView').slideToggle('slow', function(){});
         $('#map').gmap3({
            action: 'init',
            map: {
                options: {
                    center: [<?php echo $event->lat_long; ?>],
                    zoom: 14,
                    scrollwheel: false
                }                
            },
            marker: {
                latLng: [<?php echo $event->lat_long; ?>],
                options: {
                    icon: "http://maps.google.com/mapfiles/marker_green.png",
                    animation: google.maps.Animation.DROP
                }
            }

        });
        //check if other map is open
        if($('#hotelMapView').is(':visible')) {
            $('#hotelMapView').hide('slow', function(){});
        }
    });
</script>