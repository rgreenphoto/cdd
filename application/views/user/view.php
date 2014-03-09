<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/shadowbox/shadowbox.css"/>
<script type="text/javascript" src="<?php echo base_url();?>assets/shadowbox/shadowbox.js"></script>
 <?php if(!empty($user)): ?>
<div class="row">
    <div class="col-lg-6">
        <h3>Bio</h3>
        <?php echo $user->member_bio; ?>
    </div>
    <div class="col-xs-10 col-lg-6">
        <h3>Accomplishments</h3>
         <?php if(!empty($user->standing)): ?>
        <table class="table table-condensed table-striped table-hover footable" data-page-navigation=".page" data-page-size="5">
            <thead>
                <tr class="cdd">
                    <th data-type="numeric">Place</th>
                    <th>Dog</th>
                    <th>Award</th>
                    <th data-type="numeric">Season</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($user->standing as $row): ?>
                <tr>
                    <td><?php echo $row->place; ?></td>
                    <td><?php echo $row->canine; ?></td>
                    <td><?php echo $row->type; ?></td>
                    <td><?php echo $row->season; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" align="center"><div class="page hide-if-no-paging"></div></td>
                </tr>
            </tfoot>
        </table>
        <?php endif; ?>   
    </div>    
</div>
<br />
<div class="row">
<?php if(!empty($canines)): ?>
<div class="panel-group" id="canineAccord">    
    <?php foreach($canines as $row): ?>
    <?php if($row->display_profile == '1'): ?>
        
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>
                        <a class="accordian-toggle" data-toggle="collapse" data-parent="#canineAccord" href="#collapse<?php echo $row->id; ?>">Team: <?php echo $row->name; ?> <span id="chev<?php echo $row->id; ?>" class="icon-chevron-up pull-right"></span> </a>
                    </h4>
                </div>
                <div id="collapse<?php echo $row->id; ?>" class="panel-collapse collapse in" data="<?php echo $row->id; ?>">
                    <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-4 col-lg-push-8">
                                    <?php if(!empty($row->image)): ?>
                                    <a href="<?php echo base_url(); ?>uploads/profiles/<?php echo $row->image; ?>" rel="shadowbox"><img src="<?php echo base_url(); ?>uploads/profiles/<?php echo $row->image; ?>" class="img-responsive" /></a>
                                    <?php endif; ?>
                                </div>                                
                                <div class="col-lg-8 col-lg-pull-4">
                                    <div class="row">
                                        <span class="col-sm-4"><p><span class="label label-cdd">Name:</span> <?php echo $row->name; ?></p></span>
                                        <span class="col-sm-4"><p><span class="label label-cdd">Breed:</span> <?php echo $row->breed; ?></p></span>
                                        <span class="col-sm-4"><p><span class="label label-cdd">Age:</span> <?php echo $row->age; ?></p></span>
                                    </div>
                                    <div class="row">
                                        <span class="col-sm-4"><p><span class="label label-cdd">Rescue:</span> <?php if($row->rescue != '0') echo $row->rescue; ?></p></span>
                                        <span class="col-sm-8"><p><span class="label label-cdd">Rescue Group:</span> <?php echo $row->rescue_group; ?></p></span>
                                    </div>
                                    <div class="row">
                                        <span class="col-lg-10">
                                            <legend>Bio</legend>
                                            <p><?php echo $row->bio; ?></p>
                                        </span>
                                    </div>                                        
                                </div>
                            </div>                                
                            <div class="row">
                                <div class="col-xs-10 col-lg-12">
                                <legend>Stats</legend>
                                <table class="table table-condensed table-striped table-hover footable toggle-circle toggle-medium" data-page-navigation=".page" data-page-size="5">
                                    <thead>
                                        <tr class="cdd">
                                            <th data-toggle="true" data-type="numeric">Place</th>
                                            <th data-hide="phone">Division</th>
                                            <th>Competition</th>
                                            <th data-type="numeric">Season</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(!empty($row->competition_result)) foreach($row->competition_result as $result): ?>
                                        <tr>
                                            <td><?php echo $result->place; ?></td>
                                            <td><?php echo $result->division; ?></td>
                                            <td><?php echo $result->competition; ?></td>
                                            <td><?php echo $result->season; ?></td>
                                        </tr>
                                        <?php endforeach; ?>                                        
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4" align="center"><div class="page hide-if-no-paging"></div></td>
                                        </tr>
                                    </tfoot>                                    
                                </table>                                        
                                </div>
                            </div>                        
                    </div>
                </div>
            </div>
    <?php endif; ?>    
    <?php endforeach; ?>
</div>   
<?php endif; ?>
<?php endif; ?>    
    
</div>
   
<script>
        Shadowbox.init();
//        $('.dataTable').dataTable({
//            "bFilter": false,
//            "bInfo": true,
//            "bStateSave": true,
//            "iDisplayLength": 5,
//            "bLengthChange": false
//        });
  
  $('.footable').footable();
    
        $('.collapse').on('hide.bs.collapse', function() {
            var chev = $(this).attr('data');
            $('#chev' + chev).removeClass('icon-chevron-up').addClass('icon-chevron-down'); 
        });
        
        $('.collapse').on('show.bs.collapse', function() {
            var chev = $(this).attr('data');
            $('#chev' + chev).removeClass('icon-chevron-down').addClass('icon-chevron-up'); 
        });
        
        pagination = $('.page ul').attr('class');
        if(!pagination) {
            $('.page ul').addClass('pagination pagination-sm');
        }

</script>

