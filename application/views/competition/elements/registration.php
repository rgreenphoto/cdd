<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="container-fluid">
                <div class="row">
                    <button type="button" class="close reg-window"  aria-hidden="true">&times;</button>
                </div>
                <div class="col-xs-12 col-lg-6 col-md-6 col-sm-6">
                    <?php $date = date('Y-m-d'); if(!empty($the_user) && $event->registration_start <= $date && $event->registration_end >= $date): ?>
                        <?php $this->load->view('competition/elements/form'); ?>
                    <?php endif; ?>
                </div>
                <div class="col-xs-12 col-lg-6 col-md-6 col-sm-6">
                    <table class="table table-striped table-bordered table-condensed" id="registered-teams">
                        <tr class="info">
                            <th>Human</th>
                            <th>Dog</th>
                            <th>Division</th>
                            <th>Fee</th>
                        </tr>
                        </thead>
                        <tbody id="holding">
                        <?php if(!empty($registrations)) foreach($registrations as $row): ?>
                            <tr>
                                <td><?php echo $row->user->first_name.' '.$row->user->last_name; ?></td>
                                <td><?php echo $row->canine->name; ?></td>
                                <td><?php echo $row->division->name; ?></td>
                                <td><?php echo $row->fees; ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th colspan="3"><a href="<?php echo base_url(); ?>registration/done/1/0" class="btn btn-primary btn-xs pull-right">Pay at event</a></th>
                            <th><a href="<?php echo base_url(); ?>registration/complete" class="btn btn-xs btn-success pull-right" id="complete-reg">PayPal</a></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>





           