<ul class="breadcrumb">
    <li><a href="<?php echo base_url(); ?>admin/gameday/<?php echo $registration->competition_id; ?>">Game Day Dashboard</a></li>
    <li class="active"><?php echo $title; ?></li>
</ul>
<div class="row">
    <div class="col-lg-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Human</th>
                    <th>Dog</th>
                    <th>Division</th>
                    <th>Fee</th>
                    <th>Paid</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <tr class="success">
                    <td><?php echo $registration->user->full_name; ?></td>
                    <td><?php echo $registration->canine->name; ?></td>
                    <td>                    
                        <?php echo form_open($form_open, $attributes, $hidden); ?>
                        <?php echo form_dropdown('division_id', $divisions, $registration->division_id); ?>
                        <input type="submit" name="submit" value="Save" class="btn btn-cdd" />
                        <?php echo form_close(); ?>
                    </td>
                    <td>$<?php echo $registration->fees; ?></td>
                    <td><?php echo ($registration->isPaid == '0' ? 'No': 'Yes'); ?></td>
                    <td>
                        <a href="<?php echo base_url(); ?>admin/registration/delete/<?php echo $registration->id; ?>/<?php echo $registration->competition->id; ?>/<?php echo $registration->user->id; ?>/<?php echo $registration->canine->id; ?>/<?php echo $registration->division_id; ?>" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
            </tbody>
        </table>        
    </div>
</div>
