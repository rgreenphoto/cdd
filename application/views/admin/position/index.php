<h3 id="page-heading"><?php echo $title; ?></h3>
<div class="row">
    <div class="col-lg-12 col-xs-11">
        <p class="text-info">Every competition has a type. This provides scoring, division and registration form configuration. When you create a competition, a dropdown list will have all options below is available.</p>
        <a href="<?php echo base_url(); ?>admin/position/add" class="btn btn-cdd btn-sm pull-right">Add Position <i class="icon-plus"></i></a>
    </div>
</div>
<br />
<div class="row">
    <div class="col-lg-12 col-xs-11">
        <table class="table table-bordered table-striped table-hover footable toggle-circle toggle-medium" data-page-navigation=".page" data-page-size="20">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php if(!empty($positions)) foreach($positions as $row): ?>
                <tr>
                    <td><?php echo $row->name; ?></td>
                    <td><a href="<?php echo base_url(); ?>admin/position/edit/<?php echo $row->id; ?>" class="btn btn-cdd btn-sm">Edit <i class="icon-edit"></i></a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" align="center"><div class="page hide-if-no-paging"></div></td>
                </tr>
            </tfoot>         
        </table>        
    </div>
</div>




