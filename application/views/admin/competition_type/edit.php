<ul class="breadcrumb">
    <li><a href="<?php echo base_url(); ?>admin/competition_type/">Competition Types</a></li>
    <li class="active"><?php if(!empty($competition_type)) echo $competition_type->name; ?></li>
</ul>
<?php echo form_open_multipart(current_url()); ?> 
    <fieldset>
        <div class="row">
            <div class="col-lg-12 col-xs-10">
                <legend><?php echo $title; ?></legend>
                <p class="text-info">Add basic information about this competition type. </p>                
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2 col-xs-10">
                <label for="name">Name: <?php echo form_error('name'); ?></label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo !empty($competition_type) ? $competition_type->name: ''; ?>" />
            </div>
            <div class="col-lg-2 col-xs-10">
                <label for="type">Score Category <?php echo form_error('type'); ?></label>
                <select id="type" name="type" class="form-control">
                    <?php if(!empty($types)) foreach($types as $k=>$v): ?>
                    <option value="<?php echo $v; ?>"<?php echo (!empty($competition_type) && $competition_type->type == $v) ? 'selected="selected"': ''; ?>"><?php echo $v; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-lg-2 col-xs-10">
                <label for="freestyle_labels">Freestyle Categories <span class="text-danger"><?php echo form_error('freestyle_labels'); ?></span></label>
                <input type="text" name="freestyle_labels" class="form-control" value="<?php echo !empty($competition_type->freestyle_labels) ? $competition_type->freestyle_labels: ''; ?>" />
            </div>
            <div class="col-lg-2 col-xs-10">
                <label for="multiplier">Freestyle Multiplier:</label>
                <input type="text" name="multiplier" class="form-control" value="<?php echo !empty($competition_type->multiplier) ? $competition_type->multiplier:''; ?>" />
            </div>
            <div class="col-lg-2 col-xs-10">
                <label for="tc_labels">D/A Zones</label>
                <input type="text" name="tc_labels" class="form-control" value="<?php echo !empty($competition_type->tc_labels) ? $competition_type->tc_labels:''; ?>" />
            </div>
            <div class="col-lg-1 col-xs-10">
                <label for="tc_outofbounds">Out of Bounds</label>
                <select name="tc_outofbounds" class="form-control">
                    <option value="">Please select...</option>
                    <option value="1" <?php echo (!empty($competition_type) && $competition_type->tc_outofbounds == 1) ? 'selected':''; ?>>Yes</option>
                    <option value="0" <?php echo (!empty($competition_type) && $competition_type->tc_outofbounds == 0) ? 'selected':''; ?>>No</option>
                </select>
            </div>
            <div class="col-lg-1 col-xs-10">
                <label for="tc_airbonus">Air Bonus</label>
                <input type="text" name="tc_airbonus" class="form-control" value="<?php echo !empty($competition_type->tc_airbonus) ? $competition_type->tc_airbonus:''; ?>" />
            </div>
        </div>
        <br />
        <div class="row">
            <div class="col-lg-1">
                <?php if(!empty($competition_type->image)) echo '<img src="'.base_url().''.$competition_type->image.'" />'; ?>
            </div>            
            <div class="col-lg-3">
                <label for="image">Image: <?php echo form_error('image'); ?></label>
                <input type="file" id="image" name="image" />
            </div>
            <div class="col-lg-3">
                <?php if(!empty($competition_type->large_image)) echo '<img src="'.base_url().''.$competition_type->large_image.'" />'; ?>
            </div>            
            <div class="col-lg-3">
                <label for="large_image">Large Image: <?php echo form_error('large_image'); ?></label>
                <input type="file" id="large_image" name="large_image" />
            </div>             
        </div>
        <br />
        <div class="row">
            <div class="col-lg-12 col-xs-11">
                <?php !empty($competition_type->division) ? $view = 'edit_divisions': $view = 'add_divisions'; ?>
                <?php echo $this->load->view('admin/competition_type/elements/'.$view); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-xs-10">
                <?php echo form_submit('submit', 'Save', 'class="btn btn-cdd pull-right"'); ?>              
            </div>
        </div>
        <br />
    </fieldset>
<?php echo form_close(); ?>   