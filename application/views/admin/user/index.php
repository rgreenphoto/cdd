<h3><?php echo $title; ?></h3>
<p>Use the options below to find the user you are looking for. Most users will either be in the <span class="text-info">General User, Member or Provisional</span> categories. Club offices will also be a member of the <span class="text-danger">Administrator</span> category.</p>
<ul class="nav nav-pills">
<?php if(!empty($user_list)) foreach($user_list as $group): ?>
    <li class="<?php if($group_id == $group->id) echo 'active'; ?>">
        <a href="<?php echo base_url(); ?>admin/user/index/<?php echo $group->id; ?>"><?php echo $group->description; ?> <span class="badge"><?php echo $group->num_users; ?></span></a>
    </li>
<?php endforeach; ?>
</ul>
<br />
<table class="table table-bordered table-hover table-striped footable toggle-circle toggle-medium">
    <caption>
        <div class="row">
            <div class="col-lg-11 col-xs-8">
                <input id="filter" type="text" class="form-control" placeholder="Search" data-source="<?php echo base_url(); ?>admin/user/quick_search/" data-link="<?php echo base_url(); ?>admin/user/edit/">
            </div>
            <div class="col-lg-1 col-xs-2">
                <a href="<?php echo base_url(); ?>admin/user/add" class="btn btn-cdd">Add <i class="icon-plus"></i></a>
            </div>
        </div>
        <br />
    </caption>        
    <thead>
        <tr>
            <th data-toggle="true" data-sort-initial="true">Last Name</th>
            <th>First Name</th>
            <th data-hide="phone">Email</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($users)) foreach($users as $row): ?>
        <tr>
            <td><?php echo $row->last_name; ?></td>
            <td><?php echo $row->first_name; ?></td>
            <td><?php echo $row->email; ?></td>
            <td>
                <a href="<?php echo base_url(); ?>admin/user/edit/<?php echo $group_id; ?>/<?php echo $row->id; ?>" class="btn btn-cdd">Edit <i class="icon-edit"></i></a>
                <a href="<?php echo base_url(); ?>admin/user/delete/<?php echo $group_id; ?>/<?php echo $row->id; ?>" class="btn btn-danger">Delete <i class="icon-remove-circle"></i></a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5" align="center"><?php echo $links; ?></td>
        </tr>
    </tfoot>
</table>