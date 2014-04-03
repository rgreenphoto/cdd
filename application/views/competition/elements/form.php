<?php if($event->online_reg == '0'): ?>
<div class="row">
    <div class="col-lg-12">
        <p>Online registration is not available on our site for this event.</p>
        <?php if(!empty($event->external_reg_link)): ?>
        <p>You can register for this event at the following link. (will open in a new window)</p>
        <p><a href="<?php echo $event->external_reg_link; ?>" target="_blank"><?php echo $event->name; ?></a></p>
        <?php endif; ?>        
    </div>
</div>    
<?php endif; ?>
<?php if(!empty($the_user) && $event->online_reg == '1'): ?>
<div class="row">
    <div class="col-lg-12">
        <div id="error-info"><p class="text-danger"></p></div>
        <form name="register-form" id="register-form" method="post" class="">
            <input type="hidden" name="user_id" id="user_id" value="<?php echo $the_user->id; ?>" />
            <input type="hidden" name="competition_id" id="competition_id" value="<?php echo $event->id; ?>" />
            <div class="form-group">
                <select name="canine_id" id="canine_id" class="form-control input-sm">
                    <option value="">Select Dog</option>
                    <?php if(!empty($the_dogs)) foreach($the_dogs as $dog): ?>
                    <option value="<?php echo $dog->id; ?>"><?php echo $dog->name; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <select name="division_id" id="division_id" class="form-control input-sm">
                    <option value="">Select Division</option>
                    <?php if(!empty($divisions)) foreach($divisions as $division): ?>
                    <option value="<?php echo $division->division_id; ?>"><?php echo $division->name.' ('.$division->fee.')'; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php if(!empty($the_family)): ?>
            <?php $fam[''] = 'Select a family member'; foreach($the_family as $row) { $fam[$row->id] = $row->full_name; } ?>
            <div class="form-group">
                <p class="text-info">You may also register other family members. Select a family member below, a new list of dogs will display. Make sure you have a division selected above.</p>
                <?php echo form_dropdown('new_id', $fam, '', 'id="new_id"'); ?>
            </div>
            <div class="form-group" style="display:none;" id="new_dog">
                <?php echo form_dropdown('new_canine_id', array('' => 'Family Member Dog'), '', 'id="new_canine_id"'); ?>
                <p id="family-info" class="text-warning">Note: If you do not select a family member, the registration will default to the current user.</p>                            
            </div>
            <p>Currently Registering: <span id="current-user" class="text-error"><?php echo $the_user->first_name.' '.$the_user->last_name; ?></span></p>
            <?php endif; ?>       
            <div id="pairs_partner" class="form-group" style="display:none;">
                <?php echo form_label('Pairs Partner', 'pairs'); echo form_input('pairs', '', 'id="pairs"'); ?>
                <p class="text-warning">Note: You only need to sign up once for pairs. The partner listed does not need to submit a registration.</p>
            </div>
            <div class="form-group">
                <img src="<?php echo base_url(); ?>assets/images/ajax-loader.gif" id="loader" style="display:none" />
                <input type="submit" class="btn btn-sm btn-success" value="Submit Entry" />
                <a href="<?php echo base_url(); ?>registration/done/1/0" class="btn btn-primary btn-xs">Pay at event</a>
                <a href="<?php echo base_url(); ?>registration/complete" class="btn btn-xs btn-success" id="complete-reg">PayPal</a>
            </div>
        </form>        
    </div>
</div>
<br />
<div class="row">
    <div class="col-lg-12">
        <p class="text-info">Select which dog you're playing with and then select their division. Each entry will be added to the page, you can add multiple entries.</p>
    </div>
</div>
<?php endif; ?>
<script>
       current_user = '<?php if(!empty($the_user)) echo $the_user->id; ?>';
       current_username = '<?php if(!empty($the_user)) echo $the_user->first_name.' '.$the_user->last_name; ?>';
       $('#division_id').change(function() {
            val = $('#division_id').val();
            if(val == '5') {
                $('#pairs_partner').show();
            } 
       });

       $('#new_id').change(function() {
            $('#new_dog').show();
            id = $('#new_id').val();
            value = $("#new_id option:selected").text();
            if(id == '') {
                $('#user_id').val(current_user);
                $('#current-user').html(current_username);
                $('#new_dog').hide();
                $('#new_canine_id').empty();
            } else {
                //get list of dogs as well and populate drop down
                $.ajax({
                    type: "POST", 
                    async: false, 
                    url: '<?php echo base_url(); ?>canine/get',   
                    data: {
                        user_id: id
                    },
                    success: function(data){
                        result = $.parseJSON(data);
                        options = $('#new_canine_id');
                        options.empty();
                        options.append('<option>Please select family dog</option>');
                        $.each(result, function() {
                            option = $('<option></options>').attr('value', this.id).text(this.name);
                            options.append(option);
                        });                        
                    },
                    error: function(){alert('error');}
                });                
                
                $('#user_id').val(id);
                $('#current-user').html(value);
            }
       });
       
        $('#register-form').submit(function(e){//
           e.preventDefault();
            var user_id = $('#user_id').val();
            var division_id = $('#division_id').val();
            var competition_id = $('#competition_id').val();
            var canine_id = $('#canine_id').val();
            var new_canine_id = $('#new_canine_id').val();
            var pairs = $('#pairs').val();
            flag = '1';
            if(division_id == '') {
                $('#error-info p').html('Please select a division');
                flag = '0';
            }
            
            if(canine_id == '0') {
                if(new_canine_id == '') {
                    $('#error-info p').html('Please select a dog');
                    flag = '0';                    
                } else {
                    canine_id = new_canine_id;
                }
            }

            if(flag == '1') {
                $('#loader').show();
                $.ajax({
                    type: "POST", 
                    async: false, 
                    url: '<?php echo base_url(); ?>registration/add',   
                    data: {
                        user_id: user_id,
                        division_id: division_id,
                        competition_id: competition_id,
                        canine_id: canine_id,
                        pairs: pairs
                    },
                    success: function(data){
                        data = $.parseJSON(data);
                        if(data == 'Already in the system') {
                            $('#error-info p').html('This dog is already registered in this division');
                            $('#loader').hide();
                        } else {    
                            options = '';
                            $('#actions').show();
                            $('#holding').append(data);
                            $('#collapse').show();
                            $("#holding" ).effect('highlight');
                            $('#complete-reg').show();
                            $('#loader').hide();
                            $('#registered-teams').show();
                            $('#error-info p').html('');
                            $('#freeow').freeow("Registration", "Your registration has been added", {
                                classes: ["gray"],
                                autoHide: true
                            });                            
                        }                        
                    },
                    error: function(){alert('error');}
                });                
            }
        });
</script>