<h1>Edit User</h1>
Please enter the users information below.
<div class="form">
<?php echo form_open(current_url());?>
    <?php echo form_hidden('id', $user->id);?>
    <?php echo form_hidden($csrf); ?>
    <div class="row"><?php echo form_error('first_name'); echo form_label('First Name', 'first_name'); echo form_input($first_name);?></div>
    <div class="row"><?php echo form_error('last_name'); echo form_label('Last Name', 'last_name'); echo form_input($last_name);?></div>      
    <div class="row"><?php echo form_error('phone'); echo form_label('Phone', 'phone'); echo form_input($phone);?></div>
    <div class="row"><?php echo form_error('password'); echo form_label('Password (if changing)', 'password'); echo form_input($password);?></div>
    <div class="row"><?php echo form_error('password_confirm'); echo form_label('Confirm Password: (if changing)', 'password_confirm'); echo form_input($password_confirm);?></div>
    <div class="row align_right"><?php echo form_submit('submit', 'Save User');?></div>

<?php echo form_close();?>
</div>