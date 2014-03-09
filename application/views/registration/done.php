<div class="page-header">
    <h1>Thank you, see you at the event!</h1>
</div>
<div class="row-fluid">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Event/Competition</th>
                <th>Date</th>
                <th>Dog</th>
                <th>Human</th>
                <th>Division</th>
                <th>Entry Fee</th>
            </tr>
        </thead>
        <tbody>
            <?php $total = 0; if(!empty($registrations)) foreach($registrations as $row): ?>
                <tr>
                    <td><?php echo $row->competition->name; ?></td>
                    <td><?php echo $row->competition->date; ?></td>
                    <td><?php echo $row->canine->name; ?></td>
                    <td><?php echo $row->user->full_name; ?><?php if(!empty($row->pairs)) echo '/'.$row->pairs; ?></td>
                    <td><?php echo $row->division->name; ?></td>
                    <td><?php echo $row->fees; ?></td>
                </tr>
            <?php $total = $total + $row->fees; ?>    
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>Total: <?php echo $total; ?>.00</th>
        </tfoot>
    </table>    
</div>
<div id="payment" class="controls pull-right">
    <span class="span12">
        <a href="<?php echo base_url(); ?>registration/p" class="btn btn-primary" target="_blank"><i class="icon-print"></i> Print</a>
    </span>
</div>