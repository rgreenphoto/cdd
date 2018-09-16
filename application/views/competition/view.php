<div class="container-fluid">

    <?php if(!empty($registrations)): ?>
        <div class="row">
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <p>You have already registered teams. If you want to add more, please do so.</p>
            </div>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="hidden-xs col-sm-3 col-lg-3 col-md-3">
            <img src="<?php echo base_url(); ?><?php echo $event->competition_type->large_image; ?>" class="img-responsive" />
        </div>
        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">

            <div class="row">
                <div class="col-lg-12">
                    <h3><?php echo $event->name; ?></h3>
                    <h4><?php echo $event->long_date; ?> <a id="parkMap" class="clickable" data-view="parkMap" data="<?php echo $event->lat_long; ?>"><small><?php echo $event->location; ?> <i class="fa fa-map-marker fa-2x"></i></small></a></h4>
                </div>
            </div>

            <?php if($event->online_reg == 1): ?>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <h5>Registration Opens: <span class="text-info"><?php if(!empty($event->registration_start)) echo $event->registration_start; ?></span></h5>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <h5>Registration Closes: <a href="#" id="regCloseInfo" data-toggle="tooltip" data-placement="left" data-trigger="hover click" title="Register before this date."><span class="text-danger"><?php if(!empty($event->registration_end)) echo $event->registration_end; ?>*</span></a></h5>
                    </div>
                </div>
            <?php endif; ?>

            <div class="row">
                <?php if(!empty($event->lat_long)): ?>
                    <div id="parkMapView" style="display:none;">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="well">
                                <div id="parkMapCanvas" style="height:250px; min-width:150px;"></div>
                            </div>

                        </div>
                    </div>
                <?php endif; ?>
            </div>




            <div class="row">
                <div class="col-lg-6 col-md-5 col-sm-5">
                    <?php $date = date('Y-m-d H:i:s'); if(date('Y-m-d H:i:s',strtotime($event->registration_start)) <= $date && date('Y-m-d H:i:s', strtotime($event->registration_end)) >= $date): ?>
                        <?php if(empty($the_user) && $event->online_reg == '1'): ?>
                            <a href="<?php echo base_url(); ?>auth/login" class="btn btn-warning">Log in to Register</a>
                            <p>--OR--</p>
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <p>Enter your first and last name in the field below, if we have you in our system already click on your name. This will open the registration form.</p>
                                    <div class="ui-widget">
                                        <div class="input-group">
                                            <input id="filter" type="text" class="form-control" placeholder="First Name Last Name" data-source="<?php echo base_url(); ?>registration/quick_user_search" data-link="<?php echo base_url(); ?>registration/quick_add_form/<?php echo $event->id; ?>/" data-ajax="#user-edit">
                                            <span class="input-group-addon"><i class="fa fa-search"></i></span>
                                        </div>
                                    </div>
                                    <br />
                                    <div id="ajax-loader" class="pull-right" style="display:none;">
                                        Loading User Information: <img src="<?php echo base_url(); ?>assets/images/dog-loader.gif" />
                                    </div>
                                    <br />
                                    <div id="user-edit"></div>
                                    <p>If there are no results from above, enter your info here <a href="#" id="quick-add">Quick Add</a></p>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if(!empty($the_user) && $event->online_reg == '1'): ?>
                            <a href="#" id="regWindow" class="reg-window btn btn-danger openWindow" data="regForm" data-toggle="positionForm">Register Now <i class="fa fa-check fa"></i></a>
                        <?php endif; ?>
                        <?php if(!empty($the_user) && !empty($positions)): ?>
                            <a href="#" id="postionWindow" class="position-window btn btn-info openWindow" data="positionForm" data-toggle="regForm">Volunteer <i class="fa fa-flag fa"></i></a>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if($event->date == date('m/d/Y')): ?>
                            <a href="<?php echo base_url(); ?>/liveresults" class="btn btn-success btn-lg">View Live Results!</a>
                    <?php endif; ?>
                    <?php if($event->online_reg == '0'): ?>
                        <?php $this->load->view('competition/elements/noreg'); ?>
                    <?php endif; ?>
                </div>
                <?php if($event->online_reg == '1'): ?>
                <div class="col-lg-6 col-md-5 col-sm-5">
                    <a href="<?php echo base_url(); ?>competition/registered/<?php echo $event->slug; ?>" class="btn btn-info">View Registered Teams <i class="fa fa-users"></i></a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php if($event->online_reg == '1'): ?>
    <div class="row">
        <div id="regForm" style="display:none;">
            <?php $this->load->view('competition/elements/registration'); ?>
        </div>
    </div>
    <?php endif; ?>
    <?php if(!empty($positions)): ?>
    <div class="row">
        <div id="positionForm" style="display:none;">
            <?php echo $this->load->view('competition/elements/positions'); ?>
        </div>
    </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-12">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#info" data-toggle="tab">Event Info</a></li>
                <li><a href="#divisions" data-toggle="tab">Divisions & Fees</a></li>
                <?php if(!empty($event->hotel_lat_long)): ?>
                <li><a href="#hotel" data-toggle="tab" onclick="openHotelMap();">Hotel Info</a></li>
                <?php endif; ?>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="info">
                    <p><?php echo $event->event_description; ?></p>
                </div>
                <div class="tab-pane" id="divisions">
                    <?php if($event->online_reg == '1' && !empty($divisions)): ?>
                        <?php $this->load->view('competition/elements/divisions'); ?>
                    <?php endif; ?>
                </div>
                <?php if(!empty($event->hotel_lat_long)): ?>
                <div class="tab-pane" id="hotel">
                    <div class="col-lg-12">
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
                                        <div id="hotelMapCanvas" style="height:250px; min-width:150px;"></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php //$this->load->view('competition/elements/hotel'); ?>
                    </div>
                </div>
                <?php endif; ?>
                <?php if(!empty($positions)): ?>
                <div class="tab-pane" id="volunteer">
                    <div class="col-lg-12">
                        <div class="row">
                            <?php echo form_open(current_url()); ?>

                        </div>
                        <div class="row">
                            <?php echo form_submit('submit', 'Submit', 'class="btn btn-cdd pull-right"'); ?>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#parkMap').click(function(e) {
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
            $('#parkMapView').slideToggle();
        });

        $('.openWindow').click(function(e) {
            e.preventDefault();
            var newWindow = $(this).attr('data');
            var oldWindow = $(this).attr('data-toggle');
            $('#'+newWindow).show('slide');
            $('#'+oldWindow).hide('slide');
        });

        $('#regCloseInfo').tooltip();


        $('#quick-add').click(function(e) {
            e.preventDefault();
            competition_id = $('#competition_id').val();
            url = '<?php echo base_url(); ?>registration/quick_add_form/' + competition_id;
            $('#ajax-loader').show();
            $('#user-edit').load(url, function() {
                $('#ajax-loader').hide();
                display = $('#user-edit').attr('style');
                if(display === 'display: none;') {
                    $('#user-edit').toggle();
                }
            });
        });
    });

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
