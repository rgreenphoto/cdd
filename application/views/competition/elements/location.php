<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6">
            <?php echo $event->location; ?>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="well">
                <div id="parkMapCanvas" style="height:250px; min-width:250px;"></div>
            </div>

        </div>
    </div>
</div>
<script>
    function openParkMap() {
        $('#parkMapCanvas').gmap3({
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
    }
</script>
