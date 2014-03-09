<?php echo form_open(current_url(), $attributes, $hidden);?>
<p class="text-danger"><?php $message = $this->session->flashdata('error_message'); if(!empty($message)) echo $message; ?></p>
<div class="row">
    <label for="identity"><span class="text-danger"><?php echo form_error('identity'); ?></span></label>
    <input type="email" name="identity" placeholder="Email Address" class="form-control" />
</div>
<div class="row">
    <label for="password"><span class="text-danger"><?php echo form_error('password'); ?></span></label>
    <input type="password" name="password" placeholder="Password" class="form-control" />
</div>
<div class="row">
    <a href="forgot_password">Forgot your password?</a><br />
    <?php echo form_submit('submit', 'Login', 'class="btn btn-cdd pull-right"');?>
    <br />
</div>
<?php echo form_close();?> 