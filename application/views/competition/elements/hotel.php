<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6">
            <address>
                <strong><?php echo $event->hotel_name; ?></strong><br />
                <?php echo $event->hotel_address; ?><br />
                <?php echo $event->hotel_city; ?>, <?php echo $event->hotel_state; ?> <?php echo $event->hotel_zip; ?><br />
                <?php echo $event->hotel_phone; ?>
            </address>
            <?php echo $event->hotel_description; ?>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="well">
                <?php if(!empty($event->hotel_lat_long)): ?>
                    <div id="hotelMapCanvas" style="height:250px; min-width:150px;" class=""></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<script>
    function openHotelMap() {
        $('#hotelMapCanvas').gmap3({
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
    }
</script>