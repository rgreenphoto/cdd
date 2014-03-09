<h2>Polls</h2>
<div class="row">
    <table class="table table-bordered table-striped table-hover footable toggle-circle toggle-medium" data-filter="#filter">
        <caption>
            <div class="row">
                <div class="col-lg-11 col-xs-8">
                    <input id="filter" type="text" class="form-control" placeholder="Search">
                </div>
                <div class="col-lg-1 col-xs-2">
                    <a href="<?php echo base_url(); ?>admin/poll/add" class="btn btn-cdd">Add <i class="icon-plus"></i></a>
                </div>
            </div>
            <br />
        </caption> 
        <thead>
        <tr>
            <th data-hide="all">Results</th>
            <th data-toggle="true">Poll</th>
            <th data-sort-initial="descending">Start</th>
            <th>End</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php if(!empty($polls)) foreach($polls as $poll): ?>
            <tr>
                <td>
                    <?php if(!empty($poll->results->votes)): ?>
                    <h5>Total Votes: <span class="label label-warning"><?php echo $poll->results->votes; ?></span></h5>
                    <ol>
                        <?php $i=0; if(!empty($poll->results->results)) foreach($poll->results->results as $result): ?>
                        <li><span><?php echo $result->text; ?></span> <span class="label <?php if($i==0) { echo 'label-success'; } else { echo 'label-info'; }  ?>"><?php echo $result->count; ?></span> <span class="label <?php if($i==0) { echo 'label-success'; } else { echo 'label-info'; }  ?>"><?php echo $result->percent.'%'; ?></span></li>
                        <?php $i++; endforeach; ?>                        
                    </ol>
                    <?php endif; ?>
                </td>
                <td><?php echo $poll->name; ?></td>
                <td data-value="<?php echo $poll->start_date; ?>"><?php echo $poll->start_date; ?></td>
                <td><?php echo $poll->end_date; ?></td>
                <td>
                    <a href="<?php echo base_url(); ?>admin/poll/edit/<?php echo $poll->id; ?>" class="btn btn-cdd btn-sm"><i class="icon-edit"></i> Edit</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>    
    </table>    
</div>


