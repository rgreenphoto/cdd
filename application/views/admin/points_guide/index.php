<h2><?php echo $title; ?></h2>
<ul class="nav nav-tabs">
<?php if(!empty($types)) foreach($types as $item): ?>
    <li class="<?php echo $type==$item?'active':''; ?>"><a href="<?php echo base_url(); ?>admin/points_guide/<?php echo $item; ?>"><?php echo $item; ?></a></li>
<?php endforeach; ?>
</ul>
<br />
<div class="row">
    <div class="col-lg-7">
        <p class="text-info">You may add addition points here. If you need to change points, just delete and re-add. Points will be added to the currently select type.</p>
    </div>
    <div class="col-lg-5">
        <?php echo form_open(current_url(), array('class' => 'form-inline', 'role' => 'form'), $hidden); ?>
            <div class="form-group">
                <label class="sr-only" for="place">Place <span class="text-danger"><?php echo form_error('place'); ?></span></label>
                <input type="text" name="place" class="form-control" placeholder="Place" />
            </div>
            <div class="form-group">
                <label class="sr-only" for="points">Points <span class="text-danger"><?php echo form_error('points'); ?></span></label>
                <input type="text" name="points" class="form-control" placeholder="Points" />
            </div>
            <?php echo form_submit('submit', 'Add', 'class="btn btn-cdd"'); ?>       
        <?php echo form_close(); ?>        
    </div>
</div>
<hr />
<div class="row">
    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th>Type</th>
                <th>Place</th>
                <th>Points</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($current)) foreach($current as $row): ?>
            <tr>
                <td><?php echo $row->type; ?></td>
                <td><?php echo $row->place; ?></td>
                <td><?php echo $row->points; ?></td>
                <td><a href="<?php echo base_url(); ?>admin/points_guide/delete/<?php echo $row->id; ?>" class="btn btn-warning btn-sm">Delete <i class="icon-warning-sign"></i></a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>    
</div>

