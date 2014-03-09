<br />
<div class="row">
    <div class="col-lg-6">
        <address>
            <strong><?php echo $event->hotel_name; ?></strong><br />
            <?php echo $event->hotel_address; ?><br />
            <?php echo $event->hotel_city; ?>, <?php echo $event->hotel_state; ?> <?php echo $event->hotel_zip; ?><br />
            <?php echo $event->hotel_phone; ?>
        </address>
        <?php echo $event->hotel_description; ?>
    </div>
    <div class="col-lg-6 well">
        <?php if(!empty($event->hotel_lat_long)): ?>
        <div id="hotel_map" style="height:250px; min-width:250px;" class=""></div>
        <?php endif; ?>
    </div>
</div>
<script>
    $('#hotelMap').click(function(){
         $('#hotelMapView').slideToggle('slow', function(){});
         $('#hotel_map').gmap3({
            action: 'init',
            map: {
                options: {
                    center: [<?php echo $event->hotel_lat_long; ?>],
                    zoom: 14,
                    scrollwheel: false
                }                
            },
            marker: {
                latLng: [<?php echo $event->hotel_lat_long; ?>],
                options: {
                    icon: "http://maps.google.com/mapfiles/marker_green.png",
                    animation: google.maps.Animation.DROP
                }
            }

        });
        //check if other map is open
        if($('#mapView').is(':visible')) {
            $('#mapView').hide('slow', function(){});
        }        
    });
</script>