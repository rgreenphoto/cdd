<div class="list-group">
    <?php if(!empty($pages)) foreach($pages as $row): ?>
        <a href="<?php echo $row->url; ?>" class="list-group-item" target="_blank">
            <span class="glyphicon glyphicon-chevron-right pull-right"></span>
            <h4 class="list-group-item-heading"><?php echo $row->name; ?></h4>
            <p class="list-group-item-text"><?php echo $row->description; ?></p>
        </a>            
    <?php endforeach; ?>
</div>     