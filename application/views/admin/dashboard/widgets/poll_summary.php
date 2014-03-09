<div class="col-lg-4">
    <div class="panel panel-default">
        <div class="panel-heading">Polls</div>
        <div class="panel-body">
            <table class="table table-striped table-hover footable toggle-circle toggle-medium">
                <thead>
                    <tr>
                        <th data-hide="all">&nbsp;</th>
                        <th data-toggle="true">Poll</th>
                        <th data-toggle="true" data-typ="numeric">Votes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($polls)) foreach($polls as $poll): ?>
                    <tr>
                        <td> 
                        <?php $i=0; if(!empty($poll->stats->results)) foreach($poll->stats->results as $result): ?>
                            <?php $i==0?$class='label-success':$class='label-danger'; ?>
                            <?php echo $result->text; ?> <span class="label <?php echo $class; ?>"><?php echo $result->count; ?></span> <span class="label <?php echo $class; ?>"><?php echo $result->percent; ?>%</span><br />
                        <?php $i++; endforeach; ?>    
                        </td>
                        <td><?php echo $poll->name; ?></td>
                        <td><span class="label label-primary"><?php echo !empty($poll->stats->votes)?$poll->stats->votes:'0'; ?></span></td>       
                    </tr>                     
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a href="<?php echo base_url(); ?>admin/poll" class="pull-right">View All</a>
        </div>
    </div>
</div>