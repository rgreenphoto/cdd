<?php echo form_open(current_url(), $attributes, $hidden);?>    
	<p>
		New Password (at least <?php echo $min_password_length;?> characters long): <br />
		<?php echo form_error('new'); echo form_input($new_password);?>
	</p>

	<p>
		Confirm New Password: <br />
		<?php echo form_error('new_confirm'); echo form_input($new_password_confirm);?>
	</p>

	<?php echo form_input($user_id);?>
	<?php echo form_hidden($csrf); ?>
        
	<?php echo form_submit('submit', 'Change', 'class="btn btn-primary pull-right"');?>
        <br />
      
<?php echo form_close();?>
<script>
$(document).ready(function() {
        $('#new').tooltip({
            trigger: 'focus',
            placement: 'top',
            html: true
        }); 
});


</script>
        