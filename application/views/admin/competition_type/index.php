<h3 id="page-heading"><?php echo $title; ?></h3>
<div class="row">
    <div class="col-lg-12 col-xs-11">
        <p class="text-info">Every competition has a type. This provides scoring, division and registration form configuration. When you create a competition, a dropdown list will have all options below is available.</p>
        <a href="<?php echo base_url(); ?>admin/competition_type/add" class="btn btn-cdd btn-sm pull-right">Add Competition Type <i class="icon-plus"></i></a>        
    </div>
</div>
<br />
<div class="row">
    <div class="col-lg-12 col-xs-11">
        <table class="table table-bordered table-striped table-hover footable toggle-circle toggle-medium" data-page-navigation=".page" data-page-size="20">
            <thead>
                <tr>
                    <th data-sort-ignore="true" data-toggle="true">&nbsp;</th>
                    <th data-sort-ignore="true">&nbsp;</th>
                    <th data-hide="phone">Type</th>
                    <th>Name</th>
                    <th data-hide="all">Divisions</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php if(!empty($competition_types)) foreach($competition_types as $row): ?>
                <tr>
                    <td>&nbsp;</td>
                    <td><img src="<?php echo base_url().''.$row->image; ?>" class="img-responsive" /></td>
                    <td><?php echo $row->type; ?></td>
                    <td><?php echo $row->name; ?></td>
                    <td>
                        <ul>
                        <?php if(!empty($row->division)) foreach($row->division as $division): ?>
                            <li><?php echo $division->name; ?></li>
                        <?php endforeach; ?>                        
                        </ul>
                    </td>
                    <td><a href="<?php echo base_url(); ?>admin/competition_type/edit/<?php echo $row->id; ?>" class="btn btn-cdd btn-sm">Edit <i class="icon-edit"></i></a></td>
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




