<div class="col-lg-4">
    <div class="panel panel-default">
        <div class="panel-heading">Registration Stats</div>
        <div class="panel-body">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Competition</th>
                        <th>Teams</th>
                        <th>Forms</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($comp_reg)) foreach($comp_reg as $row): ?>
                    <tr>
                        <td><a href="<?php echo base_url(); ?>admin/competition/edit/<?php echo $row->id; ?>"><?php echo $row->name; ?></a></td>
                        <td><span class="label label-primary"><?php echo $row->num_user; ?></span></td>
                        <td>
                            <a href="<?php echo base_url(); ?>admin/gameday/<?php echo $row->id; ?>">Game Day Dashboard</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a href="<?php echo base_url(); ?>admin/competition" class="pull-right">View Competitions</a>
        </div>            
    </div>
</div>