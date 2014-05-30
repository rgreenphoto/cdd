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
        <p class="text-info">Select which dog you're playing with and then select their division. Each entry will be added to the page, you can add multiple entries.</p>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <form name="register-form" id="register-form" method="post" class="">
            <input type="hidden" name="user_id" id="user_id" value="<?php echo $the_user->id; ?>" />
            <input type="hidden" name="competition_id" id="competition_id" value="<?php echo $event->id; ?>" />
            <?php if(!empty($the_family)): ?>
                <div class="form-group">
                    <p class="text-info">You may also register other family members. Select a family member below, a new list of dogs will display. Make sure you have a division selected above.</p>
                    <select name="new_id" id="new_id" class="form-control input-sm">
                        <option value="">Select a Family Member</option>
                        <option value="<?php echo $the_user->id; ?>"><?php echo $the_user->full_name; ?></option>
                        <?php foreach($the_family as $row): ?>
                            <option value="<?php echo $row->id; ?>"><?php echo $row->full_name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <p>Currently Registering: <span id="current-user" class="label label-warning"><?php echo $the_user->first_name.' '.$the_user->last_name; ?></span></p>
            <?php endif; ?>
            <div id="error-info"><p class="text-danger"></p></div>
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
            <div id="pairs_partner" class="form-group" style="display:none;">
                <?php echo form_label('Pairs Partner', 'pairs'); echo form_input('pairs', '', 'id="pairs"'); ?>
                <p class="text-warning">Note: You only need to sign up once for pairs. The partner listed does not need to submit a registration.</p>
            </div>
            <div class="form-group">
                <img src="<?php echo base_url(); ?>assets/images/ajax-loader.gif" id="loader" style="display:none" />
                <input type="submit" class="btn btn-sm btn-success" value="Submit Entry" />
            </div>
        </form>        
    </div>
</div>
<?php endif; ?>