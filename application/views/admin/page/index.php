<h2><?php echo $title; ?></h2>
<table class="table table-bordered table-striped table-hover footable toggle-circle toggle-medium" data-page-navigation=".page" data-page-size="20" data-filter="#filter">
    <caption>
        <div class="row">
            <div class="col-lg-11 col-xs-8">
                <input id="filter" type="text" class="form-control" placeholder="Search">
            </div>
            <div class="col-lg-1 col-xs-2">
                <a href="<?php echo base_url(); ?>admin/page/add" class="btn btn-cdd">Add <i class="icon-plus"></i></a>
            </div>
        </div>
        <br />
    </caption>     
    <thead>
        <tr>
            <th>Page</th>
            <th data-hide="phone">Link</th>
            <th data-hide="phone">Created</th>
            <th data-hide="phone">Modified</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($contents)) foreach($contents as $content): ?>
        <tr>
            <td><?php echo $content->name; ?></td>
            <td><?php echo $content->slug; ?></td>
            <td><?php echo $content->created; ?></td>
            <td><?php echo $content->modified; ?></td>
            <td>
                <a href="<?php echo base_url(); ?>admin/page/edit/<?php echo $content->id; ?>" class="btn btn-cdd">Edit <i class="icon-edit"></i></a>
                <a href="<?php echo base_url(); ?>admin/page/delete/<?php echo $content->id; ?>" class="btn btn-danger">Delete <i class="icon-remove"></i></a>
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


