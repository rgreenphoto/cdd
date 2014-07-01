<h3><?php echo $title; ?></h3>
<?php if(!empty($message)) echo '<div class="message">'.$message.'</div>'; ?>
<ul class="nav nav-pills">
    <?php if(!empty($user)): ?>
    <li class="active"><a href="<?php echo base_url(); ?>admin/user/edit/<?php echo $user->id; ?>">Edit User</a></li>
    <li><a href="admin/user/family/">Edit Family</a></li>
    <?php if(!empty($user->canine)) foreach($user->canine as $row): ?>
    <li><a href="<?php echo base_url(); ?>admin/canine/edit/<?php echo $row->id; ?>">Edit <?php echo $row->name; ?></a></li>
    <?php endforeach; ?>
    <li><a href="<?php echo base_url(); ?>admin/canine/add/<?php echo $user->id; ?>">Add Dog</a></li>
    <?php endif; ?>
</ul>
    <div class="container">
        <?php echo form_open(current_url(), '', $hidden);?>
        <div class="row">
            <div class="col-lg-6">
                <label for="first_name">First Name <span class="text-danger"><?php echo form_error('first_name'); ?></span></label>
                <input type="text" name="first_name" class="form-control" value="<?php echo !empty($user->first_name)?$user->first_name: ''; ?>" />                
            </div>
            <div class="col-lg-6">
                <label for="last_name">Last Name <span class="text-danger"><?php echo form_error('last_name'); ?></span></label>
                <input type="text" name="last_name" class="form-control" value="<?php echo !empty($user->last_name)?$user->last_name: ''; ?>" />
            </div>
        </div>
        <br />
        <div class="row">
            <div class="col-lg-3">
                <label for="group_id">Access Level/Groups <span class="text-danger"><?php echo form_error('group_id'); ?></span></label>
                <?php if(!empty($groups)) foreach($groups as $k=>$v): ?>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="group_id[]" value="<?php echo $k; ?>" <?php if(array_search($k, $in_groups)) echo 'checked'; ?>>
                        <?php echo $v; ?>
                    </label>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="col-lg-3">
                <div class="alert alert-info">
                    Users may belong to multiple groups. It's important to make sure everyone is in the right group. The Member and Provisional group are the only users included when calculating cup points. General user will not be included. Officers should belong to both the Administrator and Member groups. 
                </div>
            </div>
            <div class="col-lg-6">
                <label for="email">Email <span class="text-danger"><?php echo form_error('email'); ?></span></label>
                <input type="email" name="email" class="form-control" value="<?php echo !empty($user->email)?$user->email:''; ?>" />
                <br />
                <label for="membership_date">Membership Paid Date <span class="text-danger"><?php echo form_error('membership_date'); ?></span></label>
                <input type="date" name="membership_date" class="form-control datepicker" value="<?php echo !empty($user->membership_date)?$user->membership_date:''; ?>" />    
            </div>
        </div>
        <br />
        <div class="row">
            <div class="col-lg-6">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="demo_team" value="1" <?php echo !empty($user)&&$user->demo_team == 1?$user->demo_team: ''; ?>/>
                        Demo Team Member
                    </label>
                </div>                
            </div>
            <div class="col-lg-6">
                <label for="rookie_year">Rookie Year <span class="text-danger"><?php echo form_error('rookie_year'); ?></span></label>
                <input type="text" name="rookie_year" class="form-control" value="<?php echo !empty($user->rookie_year)?$user->rookie_year:''; ?>" />
            </div>
        </div>
        <br />
        <div class="row">
            <div class="col-lg-12">
                <label for="address">Address <span class="text-danger"><?php echo form_error('address'); ?></span></label>
                <input type="text" name="address" class="form-control" value="<?php echo !empty($user->address)?$user->address:''; ?>" />
            </div>
        </div>
        <br />
        <div class="row">
            <div class="col-lg-4">
                <label for="city">City <span class="text-danger"><?php echo form_error('city'); ?></span></label>
                <input type="text" name="city" class="form-control" value="<?php echo !empty($user->city)?$user->city: ''; ?>" />
            </div>
            <div class="col-lg-2">
                <label for="state">State <span class="text-danger"><?php echo form_error('state'); ?></span></label>
                <input type="text" name="state" class="form-control" value="<?php echo !empty($user->state)?$user->state: ''; ?>" />
            </div>
            <div class="col-lg-2">
                <label for="zip">Zip <span class="text-danger"><?php echo form_error('zip'); ?></span></label>
                <input type="text" name="zip" class="form-control" value="<?php echo !empty($user->zip)?$user->zip:''; ?>" />
            </div>
            <div class="col-lg-4">
                <label for="phone">Phone <span class="text-danger"><?php echo form_error('phone'); ?></span></label>
                <input type="text" name="phone" class="form-control" value="<?php echo !empty($user->phone)?$user->phone:''; ?>" />
            </div>
        </div>
        <br />
        <div class="row">
            <div class="col-lg-6">
                <label for="password">Password (if changing) <span class="text-danger"><?php echo form_error('password'); ?></span></label>
                <input type="password" name="password" class="form-control" />               
            </div>
            <div class="col-lg-6">
                <label for="password_confirm">Confirm Password <span class="text-danger"><?php echo form_error('password_confirm'); ?></span></label>
                <input type="password" name="password_confirm" class="form-control" />                
            </div>
        </div>
        <br />
        <div class="form-actions">
            <?php echo form_submit('submit', $title, 'class="btn btn-cdd pull-right"'); ?>
        </div>
        <?php echo form_close();?>
     </div>
     <br />    



        
