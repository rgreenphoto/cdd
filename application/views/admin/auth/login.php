<div class="container">
<?php echo form_open(current_url(), $attributes, $hidden);?>
        <h3 class="form-signin-heading">Enter the magic words</h3>
        <?php echo form_input($identity);?>
        <?php echo form_input($password);?>
        <label class="checkbox" for="remember">Remember Me:<?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?></label>
        <a href="forgot_password">Forgot your password?</a><br />
        <?php echo form_submit('submit', 'Login', 'class="btn btn-lg btn-cdd btn-block"');?>
        <?php echo form_close();?> 
        <div id="infoMessage" class="align_center"><?php if(!empty($message)) echo $message;?></div>        
</div>
