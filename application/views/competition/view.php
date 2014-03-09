<div class="row">
    <div class="col-xs-12 col-lg-3 col-lg-push-9">
        <img src="<?php echo base_url(); ?><?php echo $event->competition_type->large_image; ?>" class="img-responsive" />
    </div>    
    <div class="col-xs-12 col-lg-9 col-lg-pull-3">
        <h2><?php echo $event->name; ?></h2>
        <h3><?php echo $event->long_date; ?></h3>
        <h4><?php echo $event->location; ?></h4>
    </div>
</div>
<div class="row">    
    <div class="col-lg-3 col-lg-push-9">
        <?php $date = date('Y-m-d'); if($event->registration_start <= $date && $event->registration_end >= $date): ?>
            <?php if(empty($the_user) && $event->online_reg == '1'): ?>
                <a href="<?php echo base_url(); ?>auth/login" class="btn btn-lg btn-danger">Log in to Register</a>
            <?php endif; ?>
            <?php if(!empty($the_user) && $event->online_reg == '1'): ?>
                <a id="regWindow" class="btn btn-lg btn-danger">Register Online Now</a>
            <?php endif; ?>
            <hr />
            <a href="<?php echo base_url(); ?>competition/registered/<?php echo $event->slug; ?>" class="btn btn-sm btn-warning">Registered Teams</a>
        <?php endif; ?>               
    </div>    
    <div class="col-lg-9 col-lg-pull-3">
        <?php if($event->online_reg == '1'): ?>
        <div id="regInfo" class="row">
            <div class="col-lg-6">
                <p><span class="text-success">Registration Opens: <?php if(!empty($event->registration_start)) echo date('m/d/Y', strtotime($event->registration_start)); ?></span></p>
            </div>
            <div class="col-lg-6">
                <p><span class="text-danger">Registration Closes: <?php if(!empty($event->registration_end)) echo date('m/d/Y', strtotime($event->registration_end)); ?>*</span></p>
            </div>
            <div class="col-lg-12">
                <p class="text-danger">* Online registration will close 48hrs prior to event at which time running orders will be posted. If you register at the event, you will be added to end of running order, in the same order they register. We will make reasonable attempts to separate single dogs from running too close.</p>
            </div>
        </div>
        <?php endif; ?>
    </div>   
</div>
<br />
<div id="regForm" class="row" style="display:none;">
    <div class="col-lg-8">
        <?php $this->load->view('competition/elements/form'); ?>
    </div>
    <div class="col-lg-4">
        <?php $this->load->view('competition/elements/existing'); ?>
    </div>
</div> 
<div class="row">
    <div class="col-lg-3 col-lg-push-9">
        <?php if($event->online_reg == '1'): ?>
            <?php $this->load->view('competition/elements/divisions'); ?>
        <?php endif; ?>
        <?php if($event->online_reg == '0'): ?>
            <?php $this->load->view('competition/elements/noreg'); ?>
        <?php endif; ?>         
    </div>
    <div class="col-lg-9 col-lg-pull-3">
        <div class="row">
            <div class="col-xs-6 col-lg-3">
                <a id="viewMap" class="btn btn-success btn-sm">View Map</a>
            </div>
            <div class="col-xs-6 col-lg-3">
                <?php if(!empty($event->hotel_lat_long)): ?>
                <a id="hotelMap" class="btn btn-success btn-sm">View Hotel Info</a>
                <?php endif; ?>
            </div>
        </div>
        <?php if(!empty($event->lat_long)): ?>
        <div id="mapView" class="row" style="display:none;">
            <div class="col-lg-12">
                <?php $this->load->view('competition/elements/location'); ?>
            </div>
        </div>
        <?php endif; ?>
        <?php if(!empty($event->hotel_lat_long)): ?>
        <div id="hotelMapView" class="row" style="display:none;">
            <div class="col-lg-12">
                <?php $this->load->view('competition/elements/hotel'); ?>
            </div>
        </div>
        <?php endif; ?>
        <br />
        <div class="row">
            <div class="col-lg-12">
                <?php echo $event->event_description; ?>
            </div>
        </div>
    </div>
</div>

<script>
    
    $('#regWindow').click(function() {
        $('#regForm').slideToggle('slow', function(){});
        $('#regInfo').slideToggle('slow', function(){});
    });
    
//    $(document).ready(function() {
//        $('#regWindow').click(function() {
//           $('#regForm').slideToggle('slow', function(){});
//           $('#regInfo').slideToggle('slow', function(){});
//        });    
//    });
    
</script>
