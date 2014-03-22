<div class="panel panel-default">
    <div class="panel-body">
        <?php echo form_open(current_url(), $attributes, $hidden); ?>
        <div class="row">
            <div class="col-lg-6">
                <legend>Email Settings</legend>
                <p>You can receive an email anytime a message is sent on the site. At this point, only official club messages will be sent. Other users cannot send you messages.</p>
                <div class="controls">
                    <label class="radio">
                        <input type="radio" name="email_notifications" value="1" <?php if(!empty($user) && $user->email_notifications == 1) echo 'checked=checked'; ?>>Yes
                    </label>
                    <label class="radio">
                        <input type="radio" name="email_notifications" value="0" <?php if(!empty($user) && $user->email_notifications == 0) echo 'checked=checked'; ?>>No
                    </label>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-lg-10">
                        <legend>Privacy Settings</legend>
                        <p class="error">
                         You can control who can view your Member Profile. Other than your name, no data from your Membership Info will be shared. 
                         The current options are Private where only you can view your profile. 
                         Members allows only logged in club members to view and Public allows anyone.
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-10">
                        <div class="controls">
                            <label class="radio">
                                <input type="radio" name="privacy" value="None" <?php if(!empty($user) && $user->privacy == 'None') echo 'checked="checked"'; ?>>Private (only you)
                            </label>
                            <label class="radio">
                                <input type="radio" name="privacy" value="Member" <?php if(!empty($user) && $user->privacy == 'Member') echo 'checked="checked"'; ?>>Members Only
                            </label>
                            <label class="radio">
                                <input type="radio" name="privacy" value="Public" <?php if(!empty($user) && $user->privacy == 'Public') echo 'checked="checked"'; ?>>Public (all)
                            </label>            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-11">
                <?php echo form_submit('submit', 'Save', 'class="btn btn-cdd pull-right"'); ?>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>