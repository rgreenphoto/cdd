<h1>Create Account</h1>
<p>Please enter basic information below. Once set up you can update address, phone and other information.</p>

<div id="infoMessage" class="text-danger"><?php echo $message;?></div>

<?php echo form_open("auth/create_account");?>
<div class="row">
    <div class="col-lg-6">
        <label for="first_name">First Name <span class="text-danger"><?php echo form_error('first_name'); ?></span></label>
        <input type="text" name="first_name" value="<?php echo (!empty($_POST['first_name']) ? $_POST['first_name'] : ''); ?>" class="form-control" />
    </div>
    <div class="col-lg-6">
        <label for="last_name">Last Name <span class="text-danger"><?php echo form_error('last_name'); ?></span></label>
        <input type="text" name="last_name" value="<?php echo (!empty($_POST['last_name']) ? $_POST['last_name'] : ''); ?>" class="form-control" />
    </div>
</div>
<br />
<div class="row">
    <div class="col-lg-12">
        <label for="email">Email <span class="text-danger"><?php echo form_error('email'); ?></span></label>
        <input type="text" name="email" value="<?php echo (!empty($_POST['email']) ? $_POST['email'] : ''); ?>" class="form-control" />
    </div>    
</div>
<br />
<div class="row">
    <div class="col-lg-6">
        <label for="password">Password <span class="text-danger"><?php echo form_error('password'); ?></span></label>
        <input type="password" id="password" name="password" class="form-control" />
        <label for="password_confirm">Confirm Password <span class="text-danger"><?php echo form_error('password_confirm'); ?></span></label>
        <input type="password" id="password_confirm" name="password_confirm" class="form-control" />
    </div>
    <div class="col-lg-6">
        <div class="well">
            <p class="text-danger">Password Requirements:</p>
            <ul>
                <li id="min" class="text-danger">Length (<span>0</span>) Min:<?php echo $this->config->item('min_password_length', 'ion_auth'); ?> Max:<?php echo $this->config->item('max_password_length', 'ion_auth'); ?></li>
                <li id="alpha_num" class="text-danger">Alpha-numberic with at least one capital</li>
            </ul>
        </div>
        <input type="submit" name="submit" value="Create Account" class="btn btn-cdd pull-right" />
    </div>
</div>
<?php echo form_close();?>
<script>
  $(document).ready(function() { 
    $('input[name=password]').keyup(function() {
        var pswd = $(this).val();
        $('#min span').text(pswd.length);
        if(pswd.length >= 8 && pswd.length <= 20) {
            $('#min').attr('class', 'text-success');
        } else {
            $('#min').attr('class', 'text-danger');
        }
        if(pswd.match(/[A-z]/) && pswd.match(/[A-Z]/) && pswd.match(/\d/)) {
            $('#alpha_num').attr('class', 'text-success');
        } else {
            $('#alpha_num').attr('class', 'text-danger');
        }
    });
  });
</script>