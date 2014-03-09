<ul class="nav nav-tabs">
    <li><a href="<?php echo base_url(); ?>admin/user/edit/<?php echo $user->id; ?>">Edit User</a></li>
    <?php if(!empty($user->canine)) foreach($user->canine as $row): ?>
    <li <?php if(!empty($canine) && $canine->id == $row->id) echo 'class="active"'; ?>><a href="<?php echo base_url(); ?>admin/canine/edit/<?php echo $row->id; ?>">Edit <?php echo $row->name; ?></a></li>
    <?php endforeach; ?>
    <li><a href="<?php echo base_url(); ?>admin/canine/add/<?php echo $user->id; ?>">Add Dog</a></li>
</ul>
<div class="control-group">
    <?php echo form_open(current_url(), $attributes, $hidden); ?>
<fieldset>    
    <div class="row-fluid">
        <span class="span5">
            <?php echo form_label('Name', 'name', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo form_error('name'); echo form_input($name); ?>
            </div>
        </span>
        <span class="span5">
            <?php echo form_label('Breed', 'breed', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo form_error('breed'); echo form_input($breed); ?>
            </div>
        </span>
    </div>
    <br />
    <div class="row-fluid">
        <span class="span5">
            <?php //echo form_label('Gender', 'gender'); ?>
            <div class="controls">
                <label class="radio inline">
                    <input type="radio" name="gender" value="Male" <?php if(!empty($canine) && $canine->gender == 'Male') echo 'checked="checked"'; ?>>Male
                </label>
                <label class="radio inline">
                    <input type="radio" name="gender" value="Female" <?php if(!empty($canine) && $canine->gender == 'Female') echo 'checked="checked"'; ?>>Female
                </label>
            </div>
        </span>
        <span class="span5">
            <?php echo form_label('Date of Birth', 'date_of_birth', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo form_error('date_of_birth');  echo form_input($date_of_birth); ?>
            </div>
        </span>
    </div>
    <br />
    <div class="row-fluid">
        <span class="span5">
            <?php echo form_label('Rescue', 'rescue', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo form_error('rescue');  echo form_input($rescue); ?>
            </div>
        </span>
    </div>
    <br />
    <div id="rescue_group_block" class="row-fluid" style="display:none">
        <span class="span12">
            <?php echo form_label('Organization', 'rescue_group', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo form_error('rescue_group');  echo form_input($rescue_group); ?>
            </div>
        </span>
    </div>
</fieldset>    
<fieldset>
    <legend>Bio</legend>
    <div class="row-fluid">
        <span class="span12">
            <?php echo form_error('bio'); echo form_textarea($bio); ?>
        </span>
    </div>
</fieldset>
    <div class="form-actions">
        <?php echo form_submit('submit', $title, 'class="btn btn-primary pull-right"'); ?>
    </div>    
    <?php echo form_close(); ?>
</div>
            
<script type="text/javascript" >
tinyMCE.init({
        mode : "textareas",
        theme : "advanced",
        width: "100%",
        theme_advanced_resizing : true,
        theme_advanced_resizing_use_cookie : false
});
    $(function() {
        
        $("#rescue")
            .click(function () {
                options = '';
                if (this.checked) {
                    $('#rescue_group_block').show('fade', options, 2000);
                    $('#rescue').val(1);
                }
                else {
                    $('#rescue_group_block').hide('fade', options, 2000);
                }
            })
            .filter(function () {
                if(this.checked) {
                    $('#rescue_group_block').show();                    
                }
            })
          });
</script>