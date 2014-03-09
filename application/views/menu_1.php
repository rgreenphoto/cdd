<div class="container">
    <div class="row">
        <div class="col-xs-10 col-lg-12">
            <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>assets/images/CDD-Official-Logo.png" class="img-responsive"></a>
        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-xs-10 col-lg-12">
            <div class="well sidebar-nav">
                <ul class="nav nav-list">
                    <li><a href="<?php echo base_url(); ?>competition">Schedule</a></li>
                    <li><a href="<?php echo base_url(); ?>result">Results</a></li>
                    <li><a href="<?php echo base_url(); ?>standing">Standings</a></li>
                    <li><a href="<?php echo base_url(); ?>profile">Member Profiles</a></li>
                    <li><a href="<?php echo base_url(); ?>competition/demos">Demo Team & Schedule</a></li>
                    <li><a href="<?php echo base_url(); ?>club">Links</a></li>
                  <?php if(!empty($this->data['menu'])) foreach($this->data['menu'] as $row): ?>
                    <li><a href="<?php echo base_url(); ?>page/<?php echo $row->slug; ?>"><?php echo $row->name; ?></a></li>
                  <?php endforeach; ?>
                </ul>
            </div><!--/.well -->         
        </div>        
    </div>
</div>




