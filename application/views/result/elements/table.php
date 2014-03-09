<table id="table<?php echo $division->id; ?>" class="table table-bordered table-condensed table-striped footable toggle-circle toggle-medium" data-filter="#filter<?php echo $division->id; ?>">                         
    <caption>
        <h4 class="pull-left"><?php echo $division->name; ?></h4>
        <a class="refresh pull-right btn btn-cdd btn-xs" data="<?php echo $division->id; ?>">Refresh <i class="icon-refresh"></i></a>
    </caption>
    <thead>
        <tr class="cdd">
            <th data-type="numeric" data-sort-initial="true">Order</th>
            <th data-type="numeric">Place</th>
            <th data-toggle="true">Team</th>
            <?php if($division->freestyle == 1): ?>
            <?php $labels = explode(',',$competition->competition_type->freestyle_labels); ?>
            <th data-hide="all" data-type="numeric"><?php echo $labels[0]; ?></th>
            <th data-hide="all" data-type="numeric"><?php echo $labels[1]; ?></th>
            <th data-hide="all" data-type="numeric"><?php echo $labels[2]; ?></th>
            <th data-hide="all" data-type="numeric"><?php echo $labels[3]; ?></th>
            <th data-hide="all" data-type="numeric">FS Total (1)</th>
            <?php endif; ?>
            <th data-hide="all">TC Round 1</th>
            <th data-hide="all" data-type="numeric">TC Total (1)</th>
            <th data-hide="all">TC Round 2</th>
            <th data-hide="all" data-type="numeric">TC Total (2)</th>
            <th data-hide="phone" data-type="numeric">Total</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($results)) foreach($results as $result): ?>
        <tr>
            <td data-value="<?php echo ($division->freestyle == 1 ? $result->fs_order: $result->tc_order); //echo $result->order; ?>"><?php echo ($division->freestyle == 1 ? $result->fs_order: $result->tc_order); //echo $result->order; ?></td>
            <td><?php echo $result->place; ?></td>
            <td><?php echo $result->handler; ?>/<?php echo $result->canine->name; ?></td>
            <?php if($division->freestyle == 1): ?>
            <td><?php echo ($result->fs_1_1 != '0.0' ? $result->fs_1_1: ''); ?></td>
            <td><?php echo ($result->fs_2_1 != '0.0' ? $result->fs_2_1: ''); ?></td>
            <td><?php echo ($result->fs_3_1 != '0.0' ? $result->fs_3_1: ''); ?></td>
            <td><?php echo ($result->fs_4_1 != '0.0' ? $result->fs_4_1: ''); ?></td>
            <td><?php echo ($result->fs_total_1 != '0.0' ? $result->fs_total_1: ''); ?></td>
            <?php endif; ?>
            <td><?php echo $result->tc_cat_1; ?></td>
            <td><?php echo $result->tc_total_1; ?></td>
            <td><?php echo $result->tc_cat_2; ?></td>
            <td><?php echo ($result->tc_total_2 != '0.0' ? $result->tc_total_2: ''); ?></td>
            <td><?php echo $result->total; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<script>
    $(document).ready(function() {        
        $('.refresh').click(function() {
            division_id = $(this).attr('data');
            get_results(division_id);
        });        
    });
</script>