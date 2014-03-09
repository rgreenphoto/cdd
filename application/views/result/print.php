<style>
    table.data, 
    table.data th,
    table.data td {
        border: 1px solid black;
    }
    tr.grey {
        background-color: #999;
    }
    tr.odd {
        background-color: #E5D9C3;
    }
</style>
<table width="75%" align="center">
    <thead>
        <tr>
            <td>
                <h2><img src="<?php echo $competition->competition_type->image; ?>" /> <?php echo $competition->name; ?> - <?php echo $competition->date; ?></h2>
                <h2><?php echo $result->handler; ?> & <?php echo $result->canine; ?></h2>
                <h3><?php echo $result->division->name; ?> Division</h3>
            </td>
        </tr>        
    </thead>
</table>
<?php if($result->division->freestyle == 1): ?>
<?php $labels = explode(',', $competition->competition_type->freestyle_labels); ?>
<table width="75%" align="center" cellpadding="0" cellspacing="0" class="data">
    <caption>
        <h2>Freestyle</h2>
    </caption>
    <thead>
        <tr class="grey">
            <th>&nbsp;</th>
            <th><?php echo $labels[0]; ?></th>
            <th><?php echo $labels[1]; ?></th>
            <th><?php echo $labels[2]; ?></th>
            <th><?php echo $labels[3]; ?></th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <tr align="center">
            <td>Round 1</td>
            <td><?php echo $result->fs_1_1; ?></td>
            <td><?php echo $result->fs_2_1; ?></td>
            <td><?php echo $result->fs_3_1; ?></td>
            <td><?php echo $result->fs_4_1; ?></td>
            <td><?php echo $result->fs_total_1; ?></td>
        </tr>
        <tr align="center">
            <td>Round 2</td>
            <td><?php echo $result->fs_1_2; ?></td>
            <td><?php echo $result->fs_2_2; ?></td>
            <td><?php echo $result->fs_3_2; ?></td>
            <td><?php echo $result->fs_4_2; ?></td>
            <td><?php echo $result->fs_total_2; ?></td>
        </tr>
    </tbody>
</table>
<?php endif; ?>
<table width="75%" align="center" class="data" cellspacing="0" cellpadding="0">
    <caption>
        <h3>Toss & Catch</h3>
    </caption>
    <thead>
        <tr class="grey">
            <th>&nbsp;</th>
            <th>Individual Throws</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <tr align="center">
            <td>Round 1</td>
            <td><?php echo $result->tc_cat_1; ?></td>
            <td><?php echo $result->tc_total_1; ?></td>
        </tr>
        <tr align="center">
            <td>Round 2</td>
            <td><?php echo !empty($result->tc_cat_2) ? $result->tc_cat_2: '&nbsp;'; ?></td>
            <td><?php echo !empty($result->tc_total_2) ? $result->tc_total_2: '&nbsp;'; ?></td>
        </tr>
    </tbody>
</table>
<table width="75%" align="center" class="data" cellspacing="0" cellpadding="0">
    <caption>
        <h3>Results</h3>
    </caption>
    <thead>
        <tr class="grey">
            <?php if($result->division->freestyle == 1): ?>
            <th>Freestyle Total x <?php echo $competition->competition_type->multiplier; ?></th>
            <?php endif; ?>
            <th>TC Total</th>
            <th>Total</th>
            <th>Overall Place</th>
            <th>CDD Place</th>
        </tr>
    </thead>
    <tbody>
        <tr align="center">
            <?php if($result->division->freestyle == 1): ?>
            <td><?php echo $result->fs_total_1 * 3; ?></td>
            <?php endif; ?>
            <td><?php echo $result->tc_total_1 + $result->tc_total_2; ?></td>
            <td><?php echo $result->total; ?></td>
            <td><?php echo $result->place; ?></td>
            <td><?php echo $result->cdd_place; ?></td>
        </tr>
    </tbody>
</table>