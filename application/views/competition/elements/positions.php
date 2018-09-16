<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-xs-12 col-lg-8 col-md-6 col-sm-6">
                <?php if(!empty($positions)): ?>
                    <p class="text-info">Would you like to volunteer to help at the event? Hover over selection for a description of what's needed.</p>
                    <form id="volunteerForm" name="volunteerForm" method="POST" class="">
                        <input type="hidden" name="user_id" value="<?php echo $the_user->id; ?>" />
                        <input type="hidden" name="competition_id" id="competition_id" value="<?php echo $event->id; ?>" />
                        <?php foreach($positions as $position_row): ?>
                            <div class="form-group">
                                <?php foreach($position_row as $position): ?>
                                    <div class="checkbox-inline">
                                        <label for="position_<?php echo $position->id; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo strip_tags($position->description); ?>">
                                        <input id="position_<?php echo $position->id; ?>" type="checkbox" value="<?php echo $position->id; ?>" class="" name="position[]" /><?php echo $position->name; ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                        <div id="message" class="alert alert-info" style="display:none;">Thanks for your help!</div>
                        <button type="submit" name="submit" class="btn btn-primary pull-left">Volunteer <i class="fa fa-flag-o"></i></button>
                        <img src="<?php echo base_url(); ?>assets/images/ajax-loader.gif" id="loader" style="display:none" />
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>