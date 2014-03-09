<div class="container">
    <div class="col-xs-12 col-lg-8">
        <?php if($event->date == date('m/d/Y')): ?>
        <div class="row">
            <div class="col-lg-12">
                <a href="<?php echo base_url(); ?>/liveresults" class="btn btn-success btn-lg">View Live Results!</a>
            </div>        
        </div>
        <br /> 
       <?php endif; ?>         
        <div class="row">
            <?php $date = date('Y-m-d'); if(!empty($the_user) && $event->registration_start <= $date && $event->registration_end >= $date): ?>
                <?php $this->load->view('competition/elements/form'); ?>
            <?php endif; ?>       
        </div>        
    </div>
    <div class="col-xs-12 col-lg-4">
    </div>
</div>
           