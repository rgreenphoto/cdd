<div class="row">
    <div class="col-lg-12">
        <p><?php if(!empty($cms_content)) echo $cms_content->description; ?></p>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="list-group">
            <?php if(!empty($demos)) foreach($demos as $row): ?>
                <a href="<?php echo base_url(); ?>show/view/<?php echo $row->slug; ?>" class="list-group-item">
                    <span class="glyphicon glyphicon-chevron-right pull-right"></span>
                    <h4 class="list-group-item-heading"><?php echo $row->name; ?></h4>
                    <p class="list-group-item-text"><?php echo date('m/d/Y H:i:s', strtotime($row->date)); ?></p>
                    <p class="list-group-item-text"><?php echo $row->location; ?></p>
                </a>            
            <?php endforeach; ?>
        </div>        
    </div>
</div>