<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&amp;language=en"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/gmap3.min.js"></script>
<ul class="breadcrumb">
    <li><a href="<?php echo base_url(); ?>admin/competition">Competitions</a></li>
    <li class="active"><?php echo $title; ?></li>
</ul>
<?php echo form_open(current_url()); ?>
    <input type="hidden" id="id" name="id" value="<?php echo !empty($competition->id) ? $competition->id: ''; ?>" />
    <input type="hidden" id="lat_long" name="lat_long" value="<?php echo !empty($competition->lat_long) ? $competition->lat_long: ''; ?>" />
    <input type="hidden" id="hotel_lat_long" name="hotel_lat_long" value="<?php echo !empty($competition->hotel_lat_long) ? $competition->hotel_lat_long: ''; ?>" />
    <fieldset>
        <div class="row">
            <div class="col-lg-12 col-xs-11">
                <legend>Event Information</legend>
                <p class="text-info">Enter basic information about the event. Select the event type and if the event is eligible for cup points.</p>
            </div>    
        </div>
        
        <div class="row">
            <div class="col-lg-6 col-xs-5">
                <label for="competition_type_id">Event Type: <span class="text-danger"><?php echo form_error('competition_type_id'); ?></span></label>
                <select id="competition_type_id" name="competition_type_id" class="form-control">
                    <?php if(!empty($competition_types)) foreach($competition_types as $k=>$v): ?>
                    <option value="<?php echo $k; ?>" <?php echo (!empty($competition->competition_type_id) && $competition->competition_type_id == $k) ? 'selected': ''; ?>><?php echo $v; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-lg-6 col-xs-5">
                <label for="cup_points">Cup Points: <span class="text-danger"><?php echo form_error('cup_points'); ?></span></label>
                <div class="radio-inline">
                    <label>
                    <input type="radio" name="cup_points"  value="1" <?php if($competition->cup_points == 1) echo 'checked'; ?>/>
                    Yes
                    </label>                    
                </div>
                <div class="radio-inline">
                    <label>
                    <input type="radio" name="cup_points" value="0" <?php if($competition->cup_points == 0) echo 'checked'; ?> />
                    No
                    </label>                    
                </div>       
            </div>
        </div>
        <br />
        <div class="row">
            <div class="col-lg-6 col-xs-5">
                <label for="name">Name: <span class="text-danger"><?php echo form_error('name'); ?></span></label>
                <input type="text" name="name" class="form-control" value="<?php echo !empty($competition->name) ? $competition->name: ''; ?>" />               
            </div>
            <div class="col-lg-6 col-xs-5">
                <label for="date">Event Date: <span class="text-danger"><?php echo form_error('date'); ?></span></label>
                <input type="date" name="date" class="form-control" value="<?php echo !empty($competition->date) ? $competition->date: ''; ?>" />
            </div>
        </div>
        <br />
        <div id="division-loader" style="display:none;">
            <button class="btn btn-cdd">Fetching Divisions...<img src="<?php echo base_url(); ?>assets/images/dog-loader.gif" /></button>
        </div>
        <?php if(!empty($previous_comps)): ?>
            <div class="pull-right">
                <label for="previous_fees" id="desc_message" class="text-danger"></label>
                <select id="previous_fees" name="previous_fees">
                    <option value="">Select previous fees</option>
                    <?php foreach($previous_comps as $pcomp): ?>
                    <option data="<?php echo $pcomp->competition_type_id; ?>" value="<?php echo $pcomp->id; ?>"><?php echo $pcomp->name; ?></option>
                    <?php endforeach; ?>
                </select>                        
            </div>
        <?php endif; ?>
        <div id="division-list" style="display:none;"></div>
        <br />
        <div class="row">
            <div class="col-lg-12 col-xs-11">
                <p class="text-info">Set the dates when registration for this event will occur. You will want to end registration a couple of days before the event to allow prep time. If no online registration is offered, leave all fields blank. Some events like the CCC will have other registration requirements. UFO provides a link to their site for CCC registration. Include the link below and leave the above date fields blank.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-xs-10">
                <label for="online_reg">Online Registration: <span class="text-danger"><?php echo form_error('online_reg'); ?></span></label>
                <div class="radio-inline">
                    <label>
                        <input type="radio" name="online_reg" value="1" <?php echo $competition->online_reg == 1?'checked':''; ?> />
                        Yes
                    </label>
                </div>
                <div class="radio-inline">
                    <label>
                        <input type="radio" name="online_reg" value="0" <?php echo $competition->online_reg == 0?'checked':''; ?> />
                        No
                    </label>
                </div>
            </div>
            <div class="col-lg-3 col-xs-10">
                <label for="registration_start">Registration Start Date: <span class="text-danger"><?php echo form_error('registration_start'); ?></span></label>
                <input type="date" name="registration_start" class="form-control datepicker" value="<?php echo !empty($competition->registration_start) ? $competition->registration_start: ''; ?>" />            
            </div>
            <div class="col-lg-3 col-xs-10">
                <label for="registration_end">Registration End Date: <span class="text-danger"><?php echo form_error('registration_end'); ?></span></label>
                <input type="date" name="registration_end" class="form-control datepicker" value="<?php echo !empty($competition->registration_end) ? $competition->registration_end: ''; ?>" />            
            </div>
            <div class="col-lg-3 col-xs-10">
                <label for="external_reg_link">External Link: <span class="text-danger"><?php echo form_error('external_reg_link'); ?></span></label>
                <input type="text" name="external_reg_link" class="form-control" value="<?php echo !empty($competition->external_reg_link) ? $competition->external_reg_link: ''; ?>" />          
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
                            <input type="text" id="location" name="location" title="Enter Address, Park Name City, Lat/Long" class="form-control" value="<?php echo !empty($competition->location) ? $competition->location: ''; ?>" />
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
                    <label for="event_description">Description: <span class="text-danger"><?php echo form_error('event_description'); ?></span></label>
                    <?php if(!empty($previous_comps)): ?>
                    <div class="pull-right">
                        <label for="previous_description" id="desc_message" class="text-danger"></label>
                        <select id="previous_description" name="previous_description">
                            <option value="">Select previous description</option>
                            <?php foreach($previous_comps as $pcomp): ?>
                            <option value="<?php echo $pcomp->id; ?>"><?php echo $pcomp->name; ?></option>
                            <?php endforeach; ?>
                        </select>                        
                    </div>
                    <?php endif; ?>
                    <textarea id="event_description" name="event_description"><?php echo !empty($competition->event_description) ? $competition->event_description: ''; ?></textarea>
            </div>
        </div>                                           
    <br />
    <div class="row">
        <div class="col-lg-6 col-xs-5">
            <label for="hotel_name">Hotel Name: <span class="text-danger"><?php echo form_error('hotel_name'); ?></span></label>
            <input type="text" id="hotel_name" name="hotel_name" class="form-control" value="<?php echo !empty($competition->hotel_name) ? $competition->hotel_name: ''; ?>" />
        </div>
        <div class="col-lg-6 col-xs-5">
            <label for="hotel_phone">Phone: <span class="text-danger"><?php echo form_error('hotel_phone'); ?></span></label>
            <input type="text" id="hotel_phone" name="hotel_phone" class="form-control" value="<?php echo !empty($competition->hotel_phone) ? $competition->hotel_phone: ''; ?>" />  
        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-lg-6 col-xs-10">
            <label for="hotel_address">Address: <span class="text-danger"><?php echo form_error('hotel_address'); ?></span></label>
            <input type="text" id="hotel_address" name="hotel_address" class="form-control" value="<?php echo !empty($competition->hotel_address) ? $competition->hotel_address: ''; ?>" />
        </div>
        <div class="col-lg-2 col-xs-10">
            <label for="hotel_city">City: <span class="text-danger"><?php echo form_error('hotel_city'); ?></span></label>
            <input type="text" id="hotel_city" name="hotel_city" class="form-control" value="<?php echo !empty($competition->hotel_city) ? $competition->hotel_city: ''; ?>" />           
        </div>
        <div class="col-lg-1 col-xs-10">
            <label for="hotel_state">State: <span class="text-danger"><?php echo form_error('hotel_state'); ?></span></label>
            <input type="text" id="hotel_state" name="hotel_state" class="form-control" value="<?php echo !empty($competition->hotel_state) ? $competition->hotel_state: ''; ?>" />         
        </div>
        <div class="col-lg-3 col-xs-10">
            <label for="hotel_zip">Zip: <span class="text-danger"><?php echo form_error('hotel_zip'); ?></span></label>
            <div class="input-group">
                <input type="text" id="hotel_zip" name="hotel_zip" class="form-control" value="<?php echo !empty($competition->hotel_zip) ? $competition->hotel_zip: ''; ?>" />
                <span id="hotel_lookup" class="input-group-addon btn">Get Map <i class="icon-search"></i></span>
            </div>
        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-lg-4 col-lg-push-8 col-xs-10">
            <div id="hotel_map" style="height:250px;width:100%;" class="well"></div>
        </div>
        <div class="col-lg-8 col-lg-pull-4 col-xs-10">
            <label for="hotel_description">Rate Information: <span class="text-danger"><?php echo form_error('hotel_description'); ?></span></label>
            <textarea id="hotel_description" name="hotel_description"><?php echo !empty($competition->hotel_description) ? $competition->hotel_description: ''; ?></textarea>
        </div>
    </div>
    </fieldset> 
    <div class="row">
        <div class="col-lg-6 col-xs-10 text-warning">
            <?php if(!empty($competition->created)): ?>
                <p>Created By: <?php echo $competition->created_by; ?> (<?php echo date('l, F jS Y g:iA', strtotime($competition->created)); ?>)</p>
            <?php endif; ?>                  
        </div>
        <div class="col-lg-6 col-xs-10 text-warning">
            <?php if(!empty($competition->modified)): ?>
                <p>Modified By: <?php echo $competition->modified_by; ?> (<?php echo date('l, F jS Y g:iA', strtotime($competition->modified)); ?>)</p>
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
        
        $('#hotel_lookup').click(function() {
          var location = $('#hotel_address').val() + ' ' + $('#hotel_city').val() + ' ' + $('#hotel_state').val() + ' '  + $('#hotel_zip').val();
          $("#hotel_map").gmap3({
              getlatlng:{
                address:  location,
                callback: function(results){
                  if ( !results ) return;
                  $('#hotel_lat_long').val(results[0].geometry.location);
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
            $('#hotel_map_row').show();
        });
     
        $('#competition_type_id').change(function() {
            var competition_id = $('#id').val();
            var competition_type_id = $('#competition_type_id').val();
            if(competition_type_id) {
                getDivisions(competition_id, competition_type_id);
            }
        });
        
        $('#previous_fees').change(function() {
            var competition_id = $(this).val();
            var competition_type_id = $('#competition_type_id').val();
            if(competition_type_id) {
                getDivisions(competition_id, competition_type_id);
            }
        });
        
        $('#previous_description').change(function() {
            var id = $(this).val();
            $.ajax({
                type: "POST", 
                async: false, 
                url: '<?php echo base_url(); ?>admin/competition/get_previous_description/',   
                data: {
                    id: id
                },
                success: function(data){
                    var result = $.parseJSON(data);
                    var ed = tinyMCE.get('event_description');
                    ed.setContent(result.description);
                    $('#desc_message').text(result.message);
                },
                error: function(){alert('error');}
             });
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
    var hotel_location = $('#hotel_lat_long').val();
    var array = location.split(',');
    var hotel_array = hotel_location.split(',');
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
    
    if(hotel_location) {
        $('#collapse').show();
        $('#arrow').removeClass('icon-chevron-down').addClass('icon-chevron-up');
        $('#hotel_map_row').show();
        $('#hotel_map').gmap3({
            map: {
                options: {
                    center: [hotel_array[0], hotel_array[1]],
                    zoom:14
                }
            },
            marker: {
                latLng: [hotel_array[0], hotel_array[1]]
            }
        });    
    }
    var competition_id = $('#id').val();
    var competition_type_id = $('#competition_type_id').val();
    if(competition_type_id && competition_id) {
        getDivisions(competition_id, competition_type_id);
    }
   
    
});

    function getDivisions(competition_id, competition_type_id) {
        $.ajax({
            type: "POST", 
            async: false, 
            url: '<?php echo base_url(); ?>admin/division/get_divisions/',   
            data: {
                competition_type_id: competition_type_id,
                competition_id: competition_id
            },
            beforeSend: function() {
                $('#division-loader').show();
                $('#division-list').hide();
            },
            success: function(data){
                $('#division-loader').hide();
                $('#division-list').html(data).slideDown().effect('highlight', 'slow');
            },
            error: function(){alert('error');}
         }); 

    }
</script>