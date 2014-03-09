<table class="table table-condensed table-bordered table-striped table-hover footable toggle-circle toggle-medium" data-filter="#filter">
    <thead>
        <tr class="cdd">
            <th data-toggle="true" data-type="numeric">Place</th>
            <th>Handler</th>
            <th>Dog</th>
            <th data-type="numeric">Points</th>
            <th data-hide="phone">Comps</th>
            <th data-hide="all">Summary</th>
            <th data-hide="all">Lowest Competition</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($standings)) foreach($standings as $row): ?>
        <tr>
            <td><?php echo $row->place; ?></td>
            <td><?php echo $row->handler; ?></td>
            <td><?php echo $row->canine; ?></td>
            <td><?php echo $row->total; ?></td>
            <td><?php echo $row->comps; ?></td>
            <td>
            <?php $stats = explode('|', $row->stats); 
                if(!empty($stats)) {
                    echo '<ol>';
                    foreach($stats as $stat) {
                        echo '<li>'.$stat.'</li>';
                    }
                    echo '</ol>';
                }
            ?>
            </td>
            <td><?php echo $row->lowest_competition; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
