<div class="panel panel-default">
    <div class="panel-body">
        <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>assets/images/CDD-Official-Logo.png" class="img-responsive"></a>      
    </div>
</div>
<div class="list-group">
    <a href="<?php echo base_url(); ?>show" class="list-group-item">
        <span class="glyphicon glyphicon-chevron-right pull-right"></span>
        <p class="list-group-item-heading">Demo Team</p>
    </a>
    <a href="<?php echo base_url(); ?>profile" class="list-group-item">
        <span class="glyphicon glyphicon-chevron-right pull-right"></span>
        <p class="list-group-item-heading">Member Profiles</p>
    </a>
    <a href="<?php echo base_url(); ?>link" class="list-group-item">
        <span class="glyphicon glyphicon-chevron-right pull-right"></span>
        <p class="list-group-item-heading">Links</p>
    </a>
    <?php if(!empty($this->data['menu'])) foreach($this->data['menu'] as $row): ?>
    <a href="<?php echo base_url(); ?>page/<?php echo $row->slug; ?>" class="list-group-item">
        <span class="glyphicon glyphicon-chevron-right pull-right"></span>
        <p class="list-group-item-heading"><?php echo $row->name; ?></p>
    </a>
    <?php endforeach; ?>
</div> 
