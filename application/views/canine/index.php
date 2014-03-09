<h2>Your Dogs (or dogs you've played with)</h2>
<p>All the dogs you've played with are listed below. Click on each to edit the information.</p>
<div class="row">
    <div class="col-lg-12">
        <a href="<?php echo base_url(); ?>canine/add/" class="btn btn-sm btn-cdd pull-right">Add New Dog <i class="icon-plus"></i></a>
    </div>
</div>
<br />
<div class="row">
    <div class="col-lg-12">
        <div class="list-group">
            <?php if(!empty($canines)) foreach($canines as $row): ?>
                <a href="<?php echo base_url(); ?>canine/edit/<?php echo $row->id; ?>" class="list-group-item">
                    <span class="glyphicon glyphicon-chevron-right pull-right"></span>
                    <h4 class="list-group-item-heading"><?php echo $row->name; ?></h4>
                    <br />
                    <?php if(!empty($row->image)): ?>
                        <img src="<?php echo base_url(); ?>uploads/profiles/<?php echo $row->image; ?>" class="img-responsive img-rounded" width="120" height="120"/>
                    <?php endif; ?>
                </a>            
            <?php endforeach; ?>
        </div>
    </div>
</div>
