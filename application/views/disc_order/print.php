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
<table width="95%">
    <tr>
        <td><img src="assets/images/CDD-Official-Logo.png" width="125" height="125"/></td>
        <td>
            <h2>Colorado Disc Dogs Bulk Disc Order <?php echo date('Y'); ?></h2>
            <h4><?php echo $the_user->full_name; ?></h4>
        </td>
    </tr>
</table>
<hr />
<table border="1" cellspacing="0" cellpadding="0" width="95%">
    <thead>
        <tr class="grey">
            <th>Disc Type/Brand</th>
            <th>Color</th>
            <th># of Discs</th>
            <th>Total Amount</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($order as $row): ?>
        <tr>
            <th><?php echo $row->disc_type->name; ?></th>
            <th><?php echo $row->color; ?></th>
            <th><?php echo $row->total_discs; ?></th>
            <th><?php echo $row->total; ?></th>
        </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="2">Totals</th>
            <th><?php echo !empty($stats->total_discs)?$stats->total_discs:''; ?></th>
            <th><?php echo !empty($stats->total)?$stats->total:''; ?></th>
        </tr>
    </tfoot>
</table>