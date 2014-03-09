<h3><img src="<?php echo base_url(); ?>assets/images/<?php echo $competition->competition_type->image; ?>" /> <?php echo $competition->name; ?> - <?php echo $competition->date; ?></h3>
<div class="row-fluid">
    <span class="span8">
        <p>Select which division you would like to work with and click 'Go'. If a running order hasn't been previously set, a random order will be genereated.
        From this screen select each competitor and enter their scores.</p>
    </span>
    <span class="span4">
        <?php echo form_open('admin/competition_result/running/'.$competition->id, 'class="form-inline"', ''); ?>
        <?php echo form_dropdown('division_id', $divisions); ?>
        <?php echo form_submit('submit', 'Go', 'class="btn btn-primary"'); ?>
        <?php echo form_close(); ?>
    </span>
</div>    

<?php if(!empty($competitors)): ?>
        <div class="row-fluid">
            <span class="span12">
                <h5>All Registered Teams</h5>
                <p>When adding a potential walk up registration, do a quick search for the competitor to make sure they're not already in the system.
                    If they are not in the list, add a new competitor. <a href="<?php echo base_url(); ?>admin/user/quick_add/<?php echo $competition->id; ?>" class="btn btn-mini btn-success"><i class="icon-plus"></i> Quick Add</a></p>
                <table class="table table-striped table-hover" id="mytable">
                    <thead>
                        <th>&nbsp;</th>
                        <th>Human</th>
                        <th>Canine</th>
                        <th>Division</th>
                    </thead>
                    <tbody>
                        <?php $i=1; if(!empty($competitors)) foreach($competitors as $row): ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $row->user->full_name; ?></td>
                            <td><?php echo $row->canine->name; ?></td>
                            <td><?php echo $row->division->name; ?></td>
                        </tr>
                        <?php $i++; endforeach; ?>
                    </tbody>
                </table>                
            </span>  
        </div>
<?php endif; ?>



