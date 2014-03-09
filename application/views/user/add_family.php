<div class="row-fluid">
    <span class="span12">
        <?php echo form_open(current_url(), array('class' => 'form-inline'), array()); ?>
        <fieldset>
            <div class="control-group">
                <?php echo form_label('First Name: ', 'first_name'); echo form_input('first_name'); ?>
                <?php echo form_label('Last Name: ', 'last_name'); echo form_input('last_name'); ?>
                <input type="submit" name="submit" value="Save" class="btn btn-primary" />
            </div>
        </fieldset>
        <?php echo form_close(); ?>
    </span>
</div>