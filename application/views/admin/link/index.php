<h2><?php echo $title; ?></h2>
<div class="row">
    <table class="table table-bordered table-striped table-hover footable toggle-circle toggle-medium" data-page-navigation=".page" data-page-size="20" data-filter="#filter">
        <caption>
            <div class="row">
                <div class="col-lg-11 col-xs-8">
                    <input id="filter" type="text" class="form-control" placeholder="Search">
                </div>
                <div class="col-lg-1 col-xs-2">
                    <a href="<?php echo base_url(); ?>admin/link/add" class="btn btn-cdd">Add <i class="icon-plus"></i></a>
                </div>
            </div>
            <br />
        </caption>
        <thead>
            <tr>
                <th data-sort-initial="true">Name</th>
                <th>Category</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($clubs)) foreach($clubs as $club): ?>
            <tr>
                <td><?php echo $club->name; ?></td>
                <td><?php echo $club->link_type->name; ?></td>
                <td>
                    <a href="<?php echo base_url(); ?>admin/link/edit/<?php echo $club->id; ?>" class="btn btn-cdd btn-sm">Edit <i class="icon-edit"></i></a>
                    <a href="<?php echo base_url(); ?>admin/link/delete/<?php echo $club->id; ?>" class="btn btn-danger btn-sm">Delete <i class="icon-ban-circle"></i> </a>
                </td>
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

