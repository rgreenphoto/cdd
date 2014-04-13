<table class="table table-bordered table-striped table-hover footable toggle-circle toggle-medium">
    <thead>
        <tr>
            <th>Name</th>
            <th data-hide="phone">Score sheet Template</th>
            <th>Action</th>
        </tr>                
    </thead>
    <tbody>
        <?php if(!empty($competition_type->division)) foreach($competition_type->division as $row): ?>
        <tr>
            <td><?php echo $row->name; ?></td>
            <td><a href="<?php echo base_url(); ?>uploads/templates/<?php echo $row->template; ?>" target="_blank"><?php echo $row->template; ?></a></td>
            <td><a href="<?php echo base_url(); ?>admin/division/edit/<?php echo $row->id; ?>" class="btn btn-cdd btn-sm">Edit <i class="icon-edit"></i></a> <a data="<?php echo base_url(); ?>admin/division/delete/<?php echo $row->id; ?>/<?php echo $competition_type->id; ?>" class="btn btn-cdd btn-sm confirm">Delete <i class="icon-ban-circle"></i></a></td>
        </tr>
        <?php endforeach; ?>                 
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3"><a href="<?php echo base_url(); ?>admin/division/add/<?php echo $competition_type->id; ?>" class="btn btn-cdd btn-xs pull-right">Add Division <i class="icon-plus"></i></a></td>
        </tr>
    </tfoot>
</table>