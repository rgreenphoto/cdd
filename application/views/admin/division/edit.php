<ul class="breadcrumb">
    <li><a href="<?php echo base_url(); ?>admin/competition_type/edit/<?php if(!empty($division->competition_type->id)) echo $division->competition_type->id; ?>"><?php if(!empty($division->competition_type->name)) echo $division->competition_type->name; ?></a></li>
    <li class="active"><?php if(!empty($division->name)) echo $division->name; ?></li>
</ul>
<h2><?php echo $title; ?> for <?php if(!empty($division->competition_type->name)) echo $division->competition_type->name; ?></h2>
<?php echo form_open_multipart(current_url(), '', $hidden); ?>
<fieldset>
    <div class="row">
        <div class="col-lg-6">
            <label for="name">Division Name <span class="text-danger"><?php echo form_error('name'); ?></span></label>
            <input type="text" name="name" class="form-control" value="<?php echo $division->name; ?>" />
        </div>
        <div class="col-lg-6">
            <label for="points_type">Points Category <span class="text-danger"><?php echo form_error('points_guide'); ?></span></label>
            <select name="points_type" class="form-control">
                <?php if(!empty($points)) foreach($points as $k=>$v): ?>
                <option value="<?php echo $k; ?>" <?php if($division->points_type == $k) echo 'selected'; ?>><?php echo $v; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <p class="text-success">If this is a freestyle division, use the drop down below to Yes. With Dual divisions, you can select if it's a Dual registration category, then each Advanced or Open division that constitutes should be labeled Dual Division</p>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <label for="freestyle">Freestyle Division? <span class="text-danger"><?php echo form_error('freestyle'); ?></span></label>
            <label class="radio-inline">
                <input type="radio" name="freestyle" value="1" <?php if($division->freestyle == 1) echo 'checked'; ?> />Yes
            </label>
            <label class="radio-inline">
                <input type="radio" name="freestyle" value="0" <?php if($division->freestyle == 0) echo 'checked'; ?> />No
            </label>
        </div>
        <div class="col-lg-6">
            <label for="dual">Dual<span class="text-danger"><?php echo form_error('dual'); ?></span></label>
            <select name="dual" class="form-control">
                <?php if(!empty($dual_categories)) foreach($dual_categories as $k=>$v): ?>
                <option value="<?php echo $k; ?>" <?php if($division->dual == $k) echo 'selected'; ?>><?php echo $v; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <p class="text-success">Upload a new registration template below. Click the link to view the current template.</p>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Registration Template</th>
                        <th>Upload New Template</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php if(!empty($division->template)) echo '<a href="'.base_url().'uploads/templates/'.$division->template.'" target="_blank">'.$division->template.'</a>'; ?></td>
                        <td>
                            <label for="template"><span class="text-danger"><?php echo form_error('template'); ?></span></label>
                            <?php echo form_upload('template'); ?>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2">
                            <div class="row">
                                <div class="col-lg-12">
                                    <p class="text-info">You can create a new template using a Word document with place holders for dynamic data. These place holders will be replaced with event info, competitor info and other information needed to complete the registration form. The place holders available are listed below. Insert the place holder including dollar sign and curly brackets.</p>
                                </div>                
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <ul class="text-warning">
                                        <li>${last_name} = Last Name</li>
                                        <li>${first_name} = First Name</li>
                                        <li>${handlerName} = Full Name</li>
                                        <li>${phone} = Phone Number</li>
                                        <li>${email} = Email Address</li>
                                        <li>${address} = Full Address</li>                    
                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <ul class="text-warning">
                                        <li>${dog} = Dog Name</li>
                                        <li>${fee} = Event Fee</li>
                                        <li>${division} = Division</li>
                                        <li>${event_name} = Event Name</li>
                                        <li>${event_date} = Event Date</li>
                                        <li>${event_location} = Event Location</li>
                                    </ul>
                                </div>                
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>           
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="form-actions">
                <?php echo form_submit('submit', 'Save', 'class="btn btn-cdd pull-right"'); ?>
            </div>   
        </div>
    </div>
</fieldset>
<?php echo form_close(); ?>
