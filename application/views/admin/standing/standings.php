<br />
<div class="row">
    <div class="col-lg-4">
        <?php echo form_open(current_url(), $attributes, $hidden); ?>
        <?php echo form_dropdown('season', $season, '', 'class="form-control"'); ?>
        <?php echo form_submit('submit', 'Execute', 'class="btn btn-cdd pull-right"'); ?>
        <?php echo form_close(); ?>        
    </div>
</div>
