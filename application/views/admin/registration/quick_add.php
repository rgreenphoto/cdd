<div class="row">
    <div class="col-lg-12">
        <a href="#" id="close-edit-user" class="pull-right">Close <span class="glyphicon glyphicon-remove-circle"></span></a>
        <?php if(!isset($user_id)): ?>
        <p>When entering a new user into the system, please make sure all other search options did not yield sufficient results. This process adds a new user and dog record to the system. If the new user was in the system previously, scores will no longer match current records and cup points will not calculate correctly.</p>
        <?php endif; ?>
    </div>
</div>
<?php if(!empty($registrations)): ?>
<div class="row">
    <div class="col-lg-10 col-lg-push-1">
        <div class="alert alert-danger">
            <p class="lead">Registered with:</p>
            <ul class="list-unstyled">
                <?php foreach($registrations as $registration): ?>
                <li><?php echo '<strong>'.$registration->canine->name.'</strong> <em>'.$registration->division->name.'</em>'; ?></li>
                <?php endforeach; ?>
            </ul>        
        </div>
    </div>
</div>
<?php endif; ?>
<div class="row">
    <div class="col-lg-12">
        <?php echo form_open('admin/registration/quick_add/', array('method' => 'post', 'id' => 'quick-add-form'), $hidden); ?>
        <?php if(!empty($competitors)): ?>
        <input type="hidden" name="create_result" id="create_result" value="1"/>
        <?php endif; ?>
        <div class="row">
            <div class="col-lg-6">
                <label for="first_name" class="control-label">First Name</label>
                <input type="text" name="first_name" value="<?php if(!empty($user)) echo $user->first_name; ?>" class="form-control" />    
            </div>
            <div class="col-lg-6">
                <label for="last_name" class="control-label">Last name</label>
                <input type="text" name="last_name" value="<?php if(!empty($user)) echo $user->last_name; ?>"  class="form-control"/>    
            </div>            
        </div>
        <div class="row">
            <div class="col-lg-12">
                <label for="email" class="control-label">Email</label>
                <input type="text" name="email" value="<?php if(!empty($user)) echo $user->email; ?>" class="form-control" />
            </div>            
        </div>
        <div class="row">
            <div class="col-lg-6">
                <label for="division_id" class="control-label">Division</label>
                <select name="division_id" class="form-control">
                    <?php foreach($divisions as $k=>$v): ?>
                    <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <?php if(empty($user->canine)): ?>
            <div class="col-lg-6">
                <label for="canine" class="control-label">Dog Name</label>
                <input type="text" name="canine" class="form-control" />      
            </div>
            <br />
            <?php endif; ?>

            <?php if(!empty($user->canine)): ?>
            <div class="col-lg-6">
                <label for="canine_id" class="control-label">Dog</label>
                <select name="canine_id" id="canine_id" class="form-control">
                    <option value="">Select Dog</option>
                    <?php foreach($user->canine as $dog): ?>
                    <option value="<?php echo $dog->id; ?>"><?php echo $dog->name; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php endif; ?>            
        </div>
        <div class="row">
            <?php if(!empty($user->canine)): ?>
            <div class="col-lg-12">
                <label for="canine" class="control-label">Other Dog (if not listed above)</label>
                <input type="text" name="canine" class="form-control" />
            </div>
            <?php endif; ?>
        </div>
        <br />
        <div class="row">
            <div class="col-lg-12">
                <input type="submit" name="submit" value="Save" class="btn btn-cdd pull-right" />
            </div>
        </div>
        <?php echo form_close(); ?>    
    </div>            
</div> 
<script>
$(document).ready(function() {
   var form = $('#quick-add-form');
   var competition_id = '<?php echo $competition_id; ?>';
   var user_id = '<?php echo !empty($user_id)?$user_id:''; ?>';
   $('#quick-add-form').submit(function(e) { 
      e.preventDefault();
      $('#ajax-loader').show();
      $.ajax({
         type: "POST",
         url: '<?php echo base_url(); ?>admin/registration/quick_add/',
         data: form.serialize(),
         success: function(data) {
             message = $.parseJSON(data);
             if(message.message) {
               url = '<?php echo base_url(); ?>admin/registration/quick_add_form/' + competition_id;
                if(user_id) {
                    url = url + '/' + user_id;
                }
               $('#user-edit').load(url, function(){
                   var success_message = 'User Information Updated';
                    $('#freeow').freeow("Success", success_message, {
                        classes: ["gray"],
                        autoHide: true
                    });
                   $('#ajax-loader').hide();
                   $('#details_forms').load('<?php echo base_url(); ?>admin/gameday/' + competition_id + ' #details_forms', function(){
                      $('.footable').footable(); 
                   });
               });
             } else {
                   var error_message = message.error_message;
                    $('#freeow').freeow("Success", error_message, {
                        classes: ["gray", "error"],
                        autoHide: true
                    });   
             }
         }
      });
   });
   $('#close-edit-user').click(function(e) {
        e.preventDefault();
        $('#user-edit').toggle();
    });
});

</script>
