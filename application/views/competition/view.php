<div class="container-fluid">
    <div class="row">
        <div class="hidden-xs col-sm-3 col-lg-3 col-md-3">
            <img src="<?php echo base_url(); ?><?php echo $event->competition_type->large_image; ?>" class="img-responsive" />
        </div>
        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">

            <div class="row">
                <div class="col-lg-12">
                    <h3><?php echo $event->name; ?></h3>
                    <h4><?php echo $event->long_date; ?> <small><?php echo $event->location; ?></small></h4>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="btn-group btn-group-sm btn-group-justified">
                        <?php if(!empty($event->lat_long)): ?>
                            <div class="btn-group">
                                <a id="parkMap" class="btn btn-cdd view-map" data-view="parkMap" data="<?php echo $event->lat_long; ?>">Park Map <i class="fa fa-map-marker fa"></i></a>
                            </div>
                        <?php endif; ?>

                        <?php if(!empty($event->hotel_lat_long)): ?>
                            <div class="btn-group">
                                <a id="hotelMap" class="btn btn-cdd view-map" data-view="hotelMap" data="<?php echo $event->hotel_lat_long; ?>">Hotel Info <i class="fa fa-map-marker fa"></i></a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <br />
            <div class="row">
                <?php if(!empty($event->lat_long)): ?>
                    <div id="parkMapView" style="display:none;">
                        <div class="col-lg-12">
                            <?php $this->load->view('competition/elements/location'); ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if(!empty($event->hotel_lat_long)): ?>
                    <div id="hotelMapView" style="display:none;">
                        <div class="col-lg-12">
                            <?php $this->load->view('competition/elements/hotel'); ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>


        <?php if($event->online_reg == 1): ?>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <h5>Registration Opens: <span class="text-info"><?php if(!empty($event->registration_start)) echo date('m/d/Y', strtotime($event->registration_start)); ?></span></h5>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <h5>Registration Closes: <a href="#" id="regCloseInfo" data-toggle="tooltip" data-placement="left" data-trigger="hover click" title="Online registration will close 48hrs prior to event at which time running orders will be posted. If you register at the event, you will be added to end of running order, in the same order they register. We will make reasonable attempts to separate single dogs from running too close."><span class="text-danger"><?php if(!empty($event->registration_end)) echo date('m/d/Y', strtotime($event->registration_end)); ?>*</span></a></h5>
                </div>
            </div>
        <?php endif; ?>

            <div class="row">
                <div class="col-lg-12">
                    <div class="btn-group btn-group-sm btn-group-justified">
                        <?php if(!empty($registration_total)): ?>
                        <div class="btn-group">
                            <a href="<?php echo base_url(); ?>competition/registered/<?php echo $event->slug; ?>" class="btn btn-info">Teams <i class="fa fa-users fa"></i></a>
                        </div>
                        <?php endif; ?>
                        <div class="btn-group">
                            <?php $date = date('Y-m-d'); if($event->registration_start <= $date && $event->registration_end >= $date): ?>
                                <?php if(empty($the_user) && $event->online_reg == '1'): ?>
                                    <a href="<?php echo base_url(); ?>auth/login" class="btn btn-warning">Log in to Register</a>
                                <?php endif; ?>
                                <?php if(!empty($the_user) && $event->online_reg == '1'): ?>
                                    <a href="#" id="regWindow" class="btn btn-danger">Register Now <i class="fa fa-check fa"></i></a>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php if($event->online_reg == '0'): ?>
                                <?php $this->load->view('competition/elements/noreg'); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="row">
        <?php if($event->online_reg == '1'): ?>
            <div id="regForm" style="display:none;">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <?php $this->load->view('competition/elements/form'); ?>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <?php $this->load->view('competition/elements/existing'); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <br />

    <br />
    <div class="row">
        <div class="col-lg-12">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#info" data-toggle="tab">Event Info</a></li>
                <li><a href="#divisions" data-toggle="tab">Divisions & Fees</a></li>
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
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {

        $('#regWindow').click(function() {
            $('#regForm').toggle('drop');
        });

        $('#regCloseInfo').tooltip();

        $('.view-map').click(function() {
            view = $(this).attr('data-view');
            lat_long = $(this).attr('data');
            options = {};
            switch(view) {
                case 'parkMap':
                    $('#parkMapView').show('blind', options, 500);
                    $('#hotelMapView').hide('clip', options, 500);
                    openParkMap();
                    break;
                case 'hotelMap':
                    $('#parkMapView').hide('clip', options, 500);
                    $('#hotelMapView').show('blind', options, 500);
                    openHotelMap();
                    break;
            }
        });
    });
</script>
