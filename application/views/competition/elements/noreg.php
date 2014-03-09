<div class="row">
    <div class="col-lg-12">
        <p>Online registration is not available on our site for this event.</p>
        <?php if(!empty($event->external_reg_link)): ?>
        <p>You can register for this event at the following link. (will open in a new window)</p>
        <p><a href="<?php echo $event->external_reg_link; ?>" target="_blank"><?php echo $event->name; ?></a></p>
        <?php endif; ?>        
    </div>
</div>