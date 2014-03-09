<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&amp;language=en"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/gmap3.min.js"></script>
<ul class="breadcrumb">
    <li><a href="<?php echo base_url(); ?>admin/show">Demos & Shows</a></li>
    <li class="active"><?php echo $title; ?></li>
</ul>
<?php echo form_open(current_url()); ?>
    <input type="hidden" id="id" name="id" value="<?php echo !empty($show->id) ? $show->id: ''; ?>" />
    <input type="hidden" id="lat_long" name="lat_long" value="<?php echo !empty($show->lat_long) ? $show->lat_long: ''; ?>" />
    <fieldset>
        <div class="row">
            <div class="col-lg-12 col-xs-11">
                <legend>Demo or Show Information</legend>
                <p class="text-info">Enter basic information about the show. Enter a location which will produce a map to the show.</p>
            </div>    
        </div>
        <br />
        <div class="row">
            <div class="col-lg-6 col-xs-5">
                <label for="name">Name: <span class="text-danger"><?php echo form_error('name'); ?></span></label>
                <input type="text" name="name" class="form-control" value="<?php echo !empty($show->name) ? $show->name: ''; ?>" />               
            </div>
            <div class="col-lg-6 col-xs-5">
                <label for="date">Event Date: <span class="text-danger"><?php echo form_error('date'); ?></span></label>
                <input type="date" name="date" class="form-control datepicker" value="<?php echo !empty($show->date) ? $show->date: ''; ?>" />              
            </div>
        </div>
        <br />
        <div class="row">
            <div class="col-lg-12 col-xs-11">
                <p class="text-info">Enter the location of the event below. You can type in the name of the park (Cornerstone Park, Littleton CO) or an exact address. As well, you can enter the latitude and longitude of the location for more specific marker placement. Press the Get Map button to generate a map.</p>
            </div>
        </div>     
        <div class="row">
            <div class="col-lg-4 col-xs-10">
                <div class="row">
                    <div class="col-lg-12">
                        <label for="location">Location (Park): <span class="text-danger"><?php echo form_error('location'); ?></span></label>
                        <div class="input-group">
                            <input type="text" id="location" name="location" title="Enter Address, Park Name City, Lat/Long" class="form-control" value="<?php echo !empty($show->location) ? $show->location: ''; ?>" />
                            <span id="locate" class="input-group-addon btn">Get Map <i class="icon-search"></i></span>
                        </div>
                    </div>                  
                </div>
                <br />
                <div class="row">
                    <div class="col-lg-12">
                        <div id="map" style="height:250px; width:100%;" class="well"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-xs-10">
                    <label for="description">Description: <span class="text-danger"><?php echo form_error('description'); ?></span></label>
                    <textarea id="description" name="description"><?php echo !empty($show->description) ? $show->description: ''; ?></textarea>
            </div>
        </div>                                           
    </fieldset> 
    <div class="row">
        <div class="col-lg-6 col-xs-10 text-warning">
            <?php if(!empty($show->created)): ?>
                <p>Created By: <?php echo $show->created_by; ?> (<?php echo date('l, F jS Y g:iA', strtotime($show->created)); ?>)</p>
            <?php endif; ?>                  
        </div>
        <div class="col-lg-6 col-xs-10 text-warning">
            <?php if(!empty($show->modified)): ?>
                <p>Modified By: <?php echo $show->modified_by; ?> (<?php echo date('l, F jS Y g:iA', strtotime($show->modified)); ?>)</p>
            <?php endif; ?>
        </div>                
    </div>
    <div class="row">
        <div class="col-lg-12 col-xs-11">
            <?php echo form_submit('submit', $title, 'class="btn btn-cdd pull-right"'); ?>
            <?php echo form_close(); ?>            
        </div>
    </div>
    <br />
<script type="text/javascript" >
    $(document).ready(function() {
        $('#location').tooltip({
            trigger: 'focus',
            placement: 'top',
            html: true
        });
        
        $('#locate').click(function() {
            var location = $('#location').val();
            $("#map").gmap3({
              getlatlng:{
                address:  location,
                callback: function(results){
                  if ( !results ) return;
                  $('#lat_long').val(results[0].geometry.location);
                  $(this).gmap3({
                    map: {
                        options:{
                            center:results[0].geometry.location,
                            zoom: 14
                        }
                    },
                    marker:{
                      latLng:results[0].geometry.location
                    }
                  });
                }
              }
            });           
           $('#map_row').show(); 
        });        
    }); 
 $(window).bind('load', function() {
     tinyMCE.init({
            mode : "textareas",
            theme : "advanced",
            width: "100%",
            theme_advanced_resizing : true,
            theme_advanced_resizing_use_cookie : false,
            plugins : "paste",
            theme_advanced_buttons3_add : "pastetext,pasteword,selectall"

    });   
    
    var location = $('#lat_long').val();
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