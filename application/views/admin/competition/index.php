<h3><?php echo $title; ?></h3>
<p>All competitions are listed below. Use the search box or column sorts to locate a competition. You can also add new competitions using the Add button.
    Demos are listed here <a href="<?php echo base_url(); ?>admin/show">Demo Schedule</a></p>
<table class="table table-striped table-hover table-bordered footable toggle-circle toggle-medium" data-page-navigation=".page" data-page-size="20" data-filter="#filter">
    <caption>
        <div class="row">
            <div class="col-lg-11 col-xs-8">
                <input id="filter" type="text" class="form-control" placeholder="Search">
            </div>
            <div class="col-lg-1 col-xs-2">
                <a href="<?php echo base_url(); ?>admin/competition/add" class="btn btn-cdd">Add <i class="icon-plus"></i></a>
            </div>
        </div>
        <br />
    </caption>    
    <thead>
        <tr>
            <th data-toggle="true" data-type="numeric">Date</th>
            <th>Name</th>
            <th data-hide="phone,tablet">Type</th>
            <th data-hide="phone,tablet">Location</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($competitions)) foreach($competitions as $row): ?>
        <tr>
            <td><?php echo $row->date; ?></td>
            <td><?php echo $row->name; ?></td>
            <td><?php echo $row->competition_type->name; ?></td>
            <td><?php echo $row->location; ?></td>
            <td>
                <a href="<?php echo base_url().'admin/competition/edit/'.$row->id; ?>" class="btn btn-cdd btn-xs">Edit <i class="icon-edit"></i></a>
                <a href="<?php echo base_url().'admin/competition_result/index/'.$row->id; ?>" class="btn btn-info btn-xs">Results <i class="icon-list-ol"></i></a>
                <a href="<?php echo base_url().'admin/gameday/'.$row->id; ?>" class="btn btn-warning btn-xs">Game Day <i class="icon-dashboard"></i></a>
                <a href="<?php echo base_url().'admin/competition/delete/'.$row->id; ?>" class="confirm btn btn-danger btn-xs">Delete <i class="icon-ban-circle"></i></a>
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



