<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&amp;language=en"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/gmap3.min.js"></script>
<ol class="breadcrumb">
    <li><a href="<?php echo base_url(); ?>show">Show Schedule</a></li>
    <li class="active"><?php echo $demo->name; ?></li>
</ol>

<div class="panel panel-default">
    <div class="panel-body">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <h3><?php echo $demo->name.'  -  '.$demo->date; ?></h3>
                    <p><?php echo $demo->description; ?></p>
                </div>
                <div class="col-lg-4 well">
                    <div id="map" style="height:250px; min-width:250px;"></div>
                </div>
            </div>
        </div>  
    </div>
</div>
<script>
$(window).bind('load', function() {
    var location = '<?php echo $demo->lat_long; ?>';
    var array = location.split(',');
    if(location) {
        $('#map_row').show();
        $('#map').gmap3({
            map: {
                options: {
                    center: [array[0], array[1]],
                    zoom:14
                }
            },
            marker: {
                latLng: [array[0], array[1]]
            }
        });
    } 
});
</script>