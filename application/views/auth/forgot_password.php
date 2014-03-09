<?php echo form_open(current_url(), $attributes, $hidden);?>
<div class="row-fluid">
    <p class="text-info">Please enter your email address so we can send you an email to reset your password.</p>
    <p class="text-error"><?php if(!empty($message)) echo $message; ?></p>    
</div>
<div class="row-fluid">
    <?php echo form_label('Email', 'email'); echo form_error('email'); echo form_input($email);?>    
</div>
<div class="row-fluid">
    <?php echo form_submit('submit', 'Submit', 'class="btn btn-primary pull-right"');?>    
</div>  
<?php echo form_close();?>