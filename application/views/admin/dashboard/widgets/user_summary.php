<div class="col-lg-4">
    <div class="panel panel-default">
        <div class="panel-heading">Users/Groups</div>
        <div class="panel-body">
            <table class="table table-striped table-hover footable toggle-circle toggle-medium">
                <caption><strong></strong></caption>
                <thead>
                    <tr>
                        <th data-hide="all">&nbsp;</th>
                        <th data-toggle="true">Group</th>
                        <th>Users</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($user_list)) foreach($user_list as $row): ?>
                    <tr>
                        <td><a href="<?php echo base_url(); ?>admin/user/index/<?php echo $row->id; ?>">View All</a> | <a href="<?php echo base_url(); ?>admin/user/print_summary/<?php echo $row->id; ?>">Download (Excel)</a></td>
                        <td><?php echo $row->description; ?></td>
                        <td><span class="label label-primary"><?php echo $row->num_users; ?></span></td>
                    </tr>
                    <?php endforeach;  ?>
                </tbody>
            </table>
            <a href="<?php echo base_url(); ?>admin/user" class="pull-right">View All Users</a>
        </div>
    </div>       
</div>