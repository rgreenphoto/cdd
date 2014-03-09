<img src="<?php echo base_url(); ?>assets/images/CDD-Club-Banner.png" />
<h1>Register</h1>

<div class="row-fluid">
<p class="text-error" style="display:none;" id="error"><?php if(!empty($message)) echo $message; ?></p>
    <fieldset>
        <div class="control-group">
            <?php echo form_open(current_url(), $attributes, $hidden);?>
                <legend>&nbsp;</legend>
                <div class="row-fluid">
                    <span class="span5">
                        <?php echo form_label('First Name *', 'first_name', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo form_error('first_name'); echo form_input($first_name);?>
                        </div>                
                    </span>
                    <span class="span5">
                        <?php echo form_label('Last Name *','last_name', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo form_error('last_name');  echo form_input($last_name); ?>
                        </div>
                    </span>
                </div>
                <br />
                <div class="row-fluid">
                    <span class="span10">
                        <?php echo form_label('Address', 'address', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo form_error('address'); echo form_input($address); ?>
                        </div>
                    </span>
                </div>
                <br />
                <div class="row-fluid">
                    <span class="span5">
                        <?php echo form_label('City', 'city', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo form_error('city'); echo form_input($city); ?>
                        </div>
                    </span>
                    <span class="span2">
                        <?php echo form_label('State (CO)', 'state', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo form_error('state'); echo form_input($state); ?>
                        </div>
                    </span>
                    <span class="span3">
                        <?php echo form_label('Zip', 'zip', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo form_error('zip'); echo form_input($zip); ?>
                        </div>
                    </span>
                </div>
                <br />
                <div class="row-fluid">
                    <span class="span5">
                        <?php echo form_label('Phone', 'phone', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo form_error('phone');  echo form_input($phone); ?>
                        </div>
                    </span>
                    <span class="span5">
                        <?php echo form_label('Email *', 'email', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo form_error('email'); echo form_input($email);?>
                        </div>                
                    </span>                    
                </div>
             <hr />
             <div class="row-fluid">
                 <span class="span5">
                    <?php echo form_label('Password *', 'password', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo form_error('password');  echo form_input($password); ?>
                    </div>                     
                 </span>
                 <span class="span5">
                    <?php echo form_label('Confirm Password *', 'password_confirm', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo form_error('password_confirm');  echo form_input($password_confirm);?>       
                    </div>                     
                 </span>
             </div>
             <legend>Dog(s)</legend>
             <div id="dog">
                 <div class="row-fluid">
                     <span class="span5">
                         <label for="dog_name[]" class="control-label">Dog Name:</label>
                         <div class="controls">
                             <input type="text" name="dog_name[]" class="span12" />
                         </div>
                     </span>
                 </div>                 
             </div>
             <div id="dog-container">
                 
             </div>
             <br />
             <div class="row-fluid">
                 <span class="span5">
                     <a id="add-dog" class="btn btn-primary pull-right"><i class="icon-plus-sign"></i> Add</a>
                 </span>
             </div>
                <div class="form-actions span10">
                    <?php echo form_submit('submit', 'Submit', 'class="btn btn-primary pull-right"'); ?>
                </div>
                <?php echo form_close();?>
            </div>
    </fieldset>    
</div>
<script>
$(document).ready(function() {
    $('#add-dog').click(function() {
       val = $('#dog').html();
       $('#dog-container').append('<br />' + $('#dog').html());
    });
    error = '<?php if(!empty($message)) echo $message; ?>';
    if(error) {
        $('#error').show().effect('highlight', {}, 3000);
    }
});    

</script>
