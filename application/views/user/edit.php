<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-cdd">
            <div class="panel-heading">
                <ul class="nav nav-pills">
                    <li class="active"><a href="#info" data-toggle="tab">General Info</a></li>
                    <li><a href="#family" data-toggle="tab">Family</a></li>
                    <li><a href="#dogs" data-toggle="tab">Dogs</a></li>
                </ul> 
            </div>
            <div class="panel-body">
                <div class="tab-content">
<!-- info tab pane -->
                    <div class="tab-pane fade in active" id="info">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="row">
                                    <h4>Member #: <span class="label label-default"><?php echo $this->the_user->member_id; ?></span></h4>
                                    <h4>Expiration: <span class="label label-default"><?php echo ($this->the_user->membership_date != '0000-00-00' && !empty($this->the_user->membership_date)) ? date('m/d/Y', strtotime($this->the_user->membership_date . " + 365 day")): 'Not a current member.' ?></span></h4> 
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <?php echo form_open(base_url().'user/edit', $attributes, $hidden);?>
                                <form action="<?php echo base_url(); ?>admin/user/edit" method="post">
                                <input type="hidden" name="id" value="<?php echo $this->the_user->id; ?>" />
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label for="first_name">First Name <?php echo form_error('first_name'); ?></label>
                                        <input type="text" name="first_name" class="form-control" value="<?php echo $this->the_user->first_name; ?>" />
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="last_name">Last Name <?php echo form_error('last_name'); ?></label>
                                        <input type="text" name="last_name" class="form-control" value ="<?php echo $this->the_user->last_name; ?>" />
                                    </div>
                                </div>
                                <br />
                                <div class="row">
                                    <div class="col-lg-5">
                                        <label for="address">Address <?php echo form_error('address'); ?></label>
                                        <input type="text" name="address" class="form-control" value="<?php echo $this->the_user->address; ?>" />
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="city">City <?php echo form_error('city'); ?></label>
                                        <input type="text" name="city" class="form-control" value="<?php echo $this->the_user->city; ?>" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label for="state">State <?php echo form_error('state'); ?></label>
                                        <input type="text" name="state" class="form-control" value="<?php echo $this->the_user->state; ?>" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label for="zip">Zip <?php echo form_error('zip'); ?></label>
                                        <input type="zip" name="zip" class="form-control" value="<?php echo $this->the_user->zip; ?>" />
                                    </div>
                                </div>
                                <br />
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" class="form-control" value="<?php echo $this->the_user->email; ?>" />
                                    </div>
                                </div>
                                <br />
                                <div class="row">
                                    <div class="col-lg-12">
                                        <?php echo form_submit('submit', 'Save', 'class="btn btn-cdd pull-right"'); ?>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
<!-- Family Tab Pane -->
                    <div class="tab-pane fade" id="family">
                        <div class="row">
                            <div class="col-lg-12">
                                <p>Here is a list of family members. You can quickly add new family using the form below.</p>
                                <div class="col-lg-6">
                                    <table class="table table-condensed table-bordered table-striped">
                                        <thead>
                                            <tr class="cdd">
                                                <th>Name</th>
                                            </tr>                
                                        </thead>
                                        <tbody>
                                            <?php if(!empty($this->the_family)) foreach($this->the_family as $row): ?>
                                            <tr>
                                                <td><?php echo $row->full_name; ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-lg-6">
                                    <?php echo form_open('user/add_family', array('class' => 'form-inline'), array()); ?>
                                    <form action="<?php echo base_url(); ?>user/add_family">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <label for="first_name">First Name:</label>
                                                <input type="text" class="form-control" name="first_name" />
                                            </div>
                                            <div class="col-lg-6">
                                                <label for="last_name">Last Name:</label>
                                                <input type="text" class="form-control" name="last_name" />
                                            </div>    
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <p>Select which dogs to add to this family member. Or add a new dog.</p>
                                                
                                                <?php if(!empty($the_dogs)) foreach($the_dogs as $dog): ?>
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" name="dogs[]" value="<?php echo $dog->name; ?>">
                                                        <?php echo $dog->name; ?>
                                                    </label>
                                                </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                        <br />
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <label for="other_name">Other Dog:</label>
                                                <input type="text" name="other_name" class="form-control" />
                                            </div>
                                        </div>
                                        <br />
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <input type="submit" name="submit" value="Submit" class="btn btn-cdd pull-right" /> 
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
<!-- Dogs Tab Pane -->
                    <div class="tab-pane fade" id="dogs">
                        <div class="row">
                            <div class="col-lg-9">
                                <div class="alert alert-info">
                                    <p>Here are the dogs we currently have on record. You can add additional dogs or edit existing ones.</p>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <a href="<?php echo base_url(); ?>canine/add/" class="btn btn-sm btn-cdd pull-right">Add New Dog <i class="icon-plus"></i></a>
                            </div>
                        </div>
                        <br />
                        <?php if(!empty($this->the_dogs)): ?>
                        <div class="row">
                            <div class="col-lg-12">
                                <table class="table table-bordered table-condensed">
                                    <thead>
                                        <tr class="cdd">
                                            <th>Name</th>
                                            <th>&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($this->the_dogs as $dog): ?>
                                        <tr>
                                            <td><?php echo $dog->name; ?></td>
                                            <td><a href="<?php echo base_url(); ?>canine/edit/<?php echo $dog->id; ?>">Edit</a></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
<script>
var hash = document.location.hash;
console.log(hash);
var prefix = "tab_";
if (hash) {
    $('.nav-pills a[href='+hash.replace(prefix,"")+']').tab('show');
} 

// Change hash for page-reload
$('.nav-pills a').on('shown', function (e) {
    window.location.hash = e.target.hash.replace("#", "#" + prefix);
});
</script>
    

