<h2><?php echo $title; ?></h2>
<div class="row">
    <table class="table table-bordered table-condensed table-striped table-hover footable toggle-circle toggle-medium" data-filter="#filter_scores">
        <caption>
            <div class="form-group col-lg-12">
                <input id="filter_scores" type="text" class="form-control" placeholder="Search">
            </div>
        </caption>        
        <thead>
            <tr class="cdd">
                <th data-toggle="true" data-type="numeric" data-sort-initial="true">Place</th>
                <th data-hide="all" data-type="numeric">CDD Place</th>
                <th data-type="numeric">Season</th>
                <th>Division</th>
                <th>Competition</th>
                <th>Dog</th>
                <th data-hide="all" data-type="numeric">FS 1</th>
                <th data-hide="all" data-type="numeric">FS 2</th>
                <th data-hide="all" data-type="numeric">FS 3</th>
                <th data-hide="all" data-type="numeric">FS 4</th>
                <th data-type="numeric">Total</th>
                <th data-hide="all" data-type="numeric">FS 1</th>
                <th data-hide="all" data-type="numeric">FS 2</th>
                <th data-hide="all" data-type="numeric">FS 3</th>
                <th data-hide="all" data-type="numeric">FS 4</th>
                <th data-type="numeric">Total</th>
                <th data-hide="all">TC Throws</th>
                <th data-type="numeric">TC Total</th>
                <th data-hide="all">TC Throws</th>
                <th data-type="numeric">TC Total</th>                
                <th data-type="numeric">Score</th>
                <th data-sort-ignore="true">Print</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($user->competition_result)) foreach($user->competition_result as $row): ?>
            <tr>
                <td><?php echo $row->place; ?></td>
                <td><?php echo $row->cdd_place; ?></td>
                <td><?php echo $row->season; ?></td>
                <td><?php echo $row->division; ?></td>
                <td><?php echo $row->competition; ?></td>
                <td><?php echo $row->canine; ?></td>
                <td><?php echo $row->fs_1_1; ?></td>
                <td><?php echo $row->fs_2_1; ?></td>
                <td><?php echo $row->fs_3_1; ?></td>
                <td><?php echo $row->fs_4_1; ?></td>
                <td><?php echo $row->fs_total_1; ?></td>
                <td><?php echo $row->fs_1_2; ?></td>
                <td><?php echo $row->fs_2_2; ?></td>
                <td><?php echo $row->fs_3_2; ?></td>
                <td><?php echo $row->fs_4_2; ?></td>
                <td><?php echo $row->fs_total_2; ?></td>
                <td><?php echo $row->tc_cat_1; ?></td>
                <td><?php echo $row->tc_total_1; ?></td>
                <td><?php echo $row->tc_cat_2; ?></td>
                <td><?php echo $row->tc_total_2; ?></td>                
                <td><?php echo $row->total; ?></td>
                <td><a href="<?php echo base_url(); ?>result/print_results/<?php echo $row->id; ?>" class="btn btn-cdd btn-xs">Print <i class="icon-print"></i></a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>
$(document).ready(function() {
    $('.footable').footable();   
});
</script>