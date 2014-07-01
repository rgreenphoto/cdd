<ul class="breadcrumb">
    <li><a href="<?php echo base_url(); ?>admin/competition/">Competitions</a></li>
    <li class="active"><?php echo $competition->name; ?> / <?php echo $division->name; ?></li>
</ul>
<div class="row">
    <div class="col-lg-2 col-lg-push-10">
        <div class="dropdown">
            <a class="btn btn-cdd" data-toggle="dropdown" href="#">Select Division <span class="glyphicon glyphicon-chevron-down"></span></a>
            <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
            <?php $i=0; if(!empty($divisions)) foreach($divisions as $row): ?>
                <?php if($row->id != '5' && $row->id != '10'): ?>
                    <li><a href="<?php echo base_url(); ?>admin/competition_result/index/<?php echo $competition->id; ?>/<?php echo $row->id; ?>" class=""><?php echo $row->name; ?></a></li>
                <?php endif; ?>
            <?php $i++; endforeach; ?>                    
            </ul>
        </div>
    </div>
    <div class="col-lg-10 col-lg-pull-2">
        <h4><?php echo $competition->name; ?> <?php echo $division->name; ?> - <a href="<?php echo base_url(); ?>admin/competition_result/export_results/<?php echo $competition->id; ?>">Export All Scores</a></h4>
    </div>        
</div>
<table class="table table-condensed table-bordered table-striped table-hover footable toggle-circle toggle-medium" data-page-size="100" data-filter="#filter">
    <caption>
        <div class="form-group col-lg-12">
            <input id="filter" type="text" class="form-control" placeholder="Search">
        </div>
    </caption>
    <thead>
        <tr>
            <th data-toggle="true" data-type="numeric">Place</th>
            <th data-class="highlight">Handler</th>
            <th>Dog</th>
            <?php if($division->freestyle == '1'): ?>
            <?php $labels = explode(',',$competition->competition_type->freestyle_labels); ?>
            <th data-hide="all" data-type="numeric"><?php echo $labels[0]; ?></th>
            <th data-hide="all" data-type="numeric"><?php echo $labels[1]; ?></th>
            <th data-hide="all" data-type="numeric"><?php echo $labels[2]; ?></th>
            <th data-hide="all" data-type="numeric"><?php echo $labels[3]; ?></th>
            <th data-hide="phone" data-type="numeric">FS Total (1)</th>
            <th data-hide="all" data-type="numeric"><?php echo $labels[0]; ?></th>
            <th data-hide="all" data-type="numeric"><?php echo $labels[1]; ?></th>
            <th data-hide="all" data-type="numeric"><?php echo $labels[2]; ?></th>
            <th data-hide="all" data-type="numeric"><?php echo $labels[3]; ?></th>
            <th data-hide="phone" data-type="numeric">FS Total (2)</th>
            <?php endif; ?>
            <th data-hide="phone,tablet">TC 1</th>
            <th data-hide="phone" data-type="numeric">TC Total (1)</th>
            <th data-hide="phone,tablet">TC 2</th>
            <th data-hide="phone" data-type="numeric">TC Total (2)</th>
            <th data-type="numeric">Total</th>
            <th data-hide="phone" data-type="numeric">CDD Place</th>
            <th data-hide="phone" data-type="numeric">Cup Points</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($competition_result)) foreach($competition_result as $result): ?>
        <tr>
            <td class=" "><?php echo $result->place; ?></td>
            <td><?php echo $result->handler; ?></td>
            <td><?php echo $result->canine; ?></td>
            <?php if($division->freestyle == '1'): ?>
            <td><?php echo $result->fs_1_1; ?></td>
            <td><?php echo $result->fs_2_1; ?></td>
            <td><?php echo $result->fs_3_1; ?></td>
            <td><?php echo $result->fs_4_1; ?></td>
            <td><?php echo ($result->fs_total_1 != '0.0' ? $result->fs_total_1: ''); ?></td>
            <td><?php echo $result->fs_1_2; ?></td>
            <td><?php echo $result->fs_2_2; ?></td>
            <td><?php echo $result->fs_3_2; ?></td>
            <td><?php echo $result->fs_4_2; ?></td>
            <td><?php echo ($result->fs_total_2 != '0.0' ? $result->fs_total_2: ''); ?></td>
            <?php endif; ?>
            <td><?php echo $result->tc_cat_1; ?></td>
            <td><?php echo $result->tc_total_1; ?></td>
            <td><?php echo $result->tc_cat_2; ?></td>
            <td><?php echo ($result->tc_total_2 != '0.0' ? $result->tc_total_2: ''); ?></td>
            <td><?php echo $result->total; ?></td>
            <td><?php echo $result->cdd_place; ?></td>
            <td><?php echo $result->cup_points; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
    