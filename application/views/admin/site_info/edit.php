<ul class="breadcrumb">
    <li><a href="<?php echo base_url(); ?>admin">Home</a> <span class="divider">/</span></li>
    <li class="active"><?php echo $title; ?></li>
</ul>
<div class="control-group">
<?php echo form_open(current_url(), $attributes, $hidden); ?>
    <fieldset>
        <legend><?php echo $title; ?></legend>
        <br />
        <div class="row-fluid">
            <span class="span5">
                <?php echo form_label('Site Title', 'site_title', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo form_error('site_title');  echo form_input($site_title); ?>
                </div>
            </span>
            <span class="span5">
                <?php echo form_label('Site Name', 'site_name', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo form_error('site_name');  echo form_input($site_name); ?>
                </div>                    
            </span>
        </div>
        <br />
        <div class="row-fluid">
            <span class="span5">
                <?php echo form_label('Site Email', 'site_email', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo form_error('site_email'); echo form_email($site_email); ?>
                </div>                   
            </span>
            <span class="span5">
                <?php echo form_label('Site URL', 'site_url', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo form_error('site_url');  echo form_input($site_url); ?>
                </div>                    
            </span>
        </div>            
    </fieldset>
    <br />
    <fieldset>
        <legend>Site Description</legend>
        <div class="row-fluid">
            <span class="span12">
                <?php echo form_error('site_description');  echo form_textarea($site_description); ?>
            </span>
        </div>
    </fieldset>
    <div class="form-actions">
        <?php echo form_submit('submit', 'Save', 'class="btn btn-primary pull-right"'); ?>
    </div>
<?php echo form_close(); ?>    
</div>

            
