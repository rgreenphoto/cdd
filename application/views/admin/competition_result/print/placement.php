<style>
    table {
        width: 100%;
    }
    tr {
        background-color: #fbf9ee;
    }
    tr.odd {
        background-color: #E5D9C3;
    }
    th {
        text-align: left;
    }
    .white {
        background-color: #FFF;
    }
</style>
<h2><?php echo $competition->name; ?></h2>
<h3><?php echo $division->name; ?></h3>
<p><strong>Final Standings</strong></p>
<table cellspacing="0" cellpadding="0">
    <tr class="white">
        <th>&nbsp;</th>
        <th>Human</th>
        <th>Dog</th>
        <?php if($division->freestyle == '1'): ?>
        <th>FS 1</th>
        <th>FS 2</th>
        <?php endif; ?>
        <th>TC 1</th>
        <th>TC 2</th>
        <th>Total</th>
    </tr>
    <?php $i=0; if(!empty($results)) foreach($results as $row): ?>
    <?php $class = ''; if($odd = $i%2) { $class = 'odd'; } ?>
    <tr class="<?php echo $class; ?>">
        <td><?php echo $row->place; ?></td>
        <td><?php echo $row->user->full_name; ?></td>
        <td><?php echo $row->canine->name; ?></td>
        <?php if($division->freestyle == '1'): ?>
        <td><?php if(!empty($row->fs_total_1)) { echo $row->fs_total_1; } else { echo ''; } ?></td>
        <td><?php if(!empty($row->fs_total_2))  { echo $row->fs_total_2; } else { echo ''; } ?></td>
        <?php endif; ?>
        <td><?php if(!empty($row->tc_total_1)) { echo $row->tc_total_1; } else { echo ''; } ?></td>
        <td><?php if(!empty($row->tc_total_2)) { echo $row->tc_total_2; } else { echo ''; } ?> </td>
        <td><?php echo $row->total; ?></td>
    </tr>
    <?php $i++; endforeach; ?>
</table>