<h3><img src="<?php echo base_url(); ?><?php echo $competition->competition_type->image; ?>" /> <?php echo $competition->name; ?> <?php echo $competition->date; ?></h3>
<div class="row">
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-body">
            <?php if(empty($competitors)): ?>
                <div id="registrations">
                    <h4>Process Registrations</h4>
                    <p>Before we can start the competition, we need to import all registrations. This creates the appropriate running orders and score sheets. Once you've run this, all additional registrations will be added to the end of the running order.</p>
                    <a href="<?php echo base_url(); ?>admin/competition_result/competitior_setup/<?php echo $competition->id; ?>" class="btn btn-xs btn-danger pull-right">Process online registrations <i class="icon-refresh"></i></a>    
                </div>
            <?php endif; ?>
            <?php if(!empty($competitors)): ?>
                <div id="competitors">
                    <h4>Enter Scores</h4>
                    <p>Select which division you would like to edit. From this screen select each competitor and enter their scores.</p>
                    <div class="btn-group pull-right">
                        <button type="button" class="btn btn-sm btn-warning dropdown-toggle" data-toggle="dropdown">Select Division <span class="caret"></span></button>
                        <ul class="dropdown-menu" role="menu">
                            <?php if(!empty($divisions)) foreach ($divisions as $division):?>
                            <?php if($division->dual != 2): ?>
                            <li><a href="<?php echo base_url(); ?>admin/competition_result/running/<?php echo $competition->id; ?>/<?php echo $division->id; ?>">
                                <?php echo $division->name; ?></a></li>
                            <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>                    
                </div>
            <?php endif; ?>  
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <h4>Add Walk-up Registrations</h4>
                <p>Enter the first and last name of the competitor. If we have them in our system, click on the name when it appears.</p>
                <div class="ui-widget">
                    <div class="input-group">
                        <input id="filter" type="text" class="form-control" placeholder="First Name Last Name" data-source="<?php echo base_url(); ?>admin/user/quick_search" data-link="<?php echo base_url(); ?>admin/registration/quick_add_form/<?php echo $competition->id; ?>/" data-ajax="#user-edit">
                        <span class="input-group-addon"><i class="icon-search"></i></span>
                    </div>
                </div>
                <br />
                <div id="ajax-loader" class="pull-right" style="display:none;">
                    Loading User Information: <img src="<?php echo base_url(); ?>assets/images/dog-loader.gif" />
                </div>
                <br />
                <div id="user-edit"></div>
                <p>If there are no results from above, enter a new user <a href="#" id="quick-add">Quick Add</a></p>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-body" id="details_forms">
                <h4>Detailed Info & Forms</h4>
                <ul class="list-inline hidden-xs">
                    <li>
                        <a href="<?php echo base_url(); ?>admin/registration/generate_list/<?php echo $competition->id; ?>">
                        <img src="<?php echo base_url(); ?>assets/images/Excel-icon.png" width="25" height="25" /> Payment Status</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>admin/registration/generate_mailmerge/<?php echo $competition->id; ?>">
                        <img src="<?php echo base_url(); ?>assets/images/Excel-icon.png" width="25" height="25" /> Mail Merge</a>   
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>admin/registration/generate_spreadsheet/<?php echo $competition->id; ?>">
                        <img src="<?php echo base_url(); ?>assets/images/Excel-icon.png" width="25" height="25" /> Backup Score Sheets</a>
                    </li>
                </ul>
                <table class="table table-striped table-hover table-condensed footable toggle-circle toggle-medium">
                    <thead>
                        <tr>
                            <th data-hide="all">&nbsp;</th>
                            <th data-toggle="true">Division</th>
                            <th># Teams</th>
                            <th>Score Sheets</th>
                        </tr>
                    </thead>
                    <tbody>        
                        <?php if(!empty($forms->registrations)) foreach($forms->registrations as $division): ?>
                        <tr>
                            <td>
                                <?php if(!empty($division->teams)): ?>
                                <table class="table table-condensed table-striped">
                                    <thead>
                                        <th>Handler</th>
                                        <th>Dog</th>
                                        <th>&nbsp;</th>
                                    </thead>
                                    <tbody>
                                        <?php foreach($division->teams as $reg): ?>
                                        <tr>
                                            <td><a href="<?php echo base_url(); ?>admin/registration/edit/<?php echo $reg->id; ?>"><?php echo $reg->user->full_name; ?></a></td>
                                            <td><?php if(!empty($reg->canine->name)) echo $reg->canine->name; ?></td>
                                            <td><a href="<?php echo base_url(); ?>admin/registration/edit/<?php echo $reg->id; ?>" class="btn btn-xs btn-cdd">Edit <i class="icon-edit"></i></a></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <?php endif; ?>                          
                            </td>
                            <td><?php echo $division->division; ?></td>
                            <td><?php echo $division->total; ?></td>
                            <td><a href="<?php echo base_url(); ?>admin/registration/generate_forms/<?php echo $competition->id; ?>/<?php echo $division->division_id; ?>"><img src="<?php echo base_url(); ?>assets/images/ms_word_2.png" height="25" width="25"></a></td>
                        </tr>
                        <?php endforeach; ?>       
                    </tbody>
                    <tfoot>
                        <tr class="info">
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td><span class="pull-right"><strong>Registered:</strong></span></td>
                            <td><span class="label label-info pull-right"><?php echo $forms->total_reg; ?></span></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr class="success">
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td><span class="pull-right"><strong>Total Fees:</strong></span></td>
                            <td><span class="label label-success pull-right">$<?php echo $forms->grand_total; ?></span></td>
                            <td>&nbsp;</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
            
    </div>
</div>
<input type="hidden" name="competition_id" id="competition_id" value="<?php echo $competition->id; ?>" />
<script>
    $(document).ready(function() {
       var registrations = $('#registrations');
       if(registrations) {
           var options = {};
           $('#registrations').parent().animate({
               backgroundColor: "#FBFFB2",
               color: "#FF0734"
           }, 1500);
       }
       
       $('#quick-add').click(function(e) {
           e.preventDefault();
           competition_id = $('#competition_id').val();
           url = '<?php echo base_url(); ?>admin/registration/quick_add_form/' + competition_id;
           $('#ajax-loader').show();
           $('#user-edit').load(url, function() {
               $('#ajax-loader').hide();
               display = $('#user-edit').attr('style');
               if(display === 'display: none;') {
                   $('#user-edit').toggle();
               }
           });
       });
       
    });
</script> 