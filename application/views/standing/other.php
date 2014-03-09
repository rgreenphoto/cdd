<table class="table table-condensed table-bordered table-striped table-hover footable toggle-circle toggle-medium" data-filter="#filter">
    <thead>
        <tr class="cdd">
            <th data-toggle="true" data-type="numeric">Place</th>
            <th>Handler</th>
            <th>Dog</th>
            <th data-hide="phone" data-type="numeric">Skyhounds</th>
            <th data-hide="phone" data-type="numeric">UFO</th>
            <th data-hide="phone" data-type="numeric">Total</th>
            <th data-type="numeric">Award Points</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($standings)) foreach($standings as $row): ?>
        <tr>
            <td><?php echo $row->place; ?></td>
            <td><?php echo $row->handler; ?></td>
            <td><?php echo $row->canine; ?></td>
            <td><?php echo $row->sky; ?></td>
            <td><?php echo $row->ufo; ?></td>
            <td><?php echo $row->total; ?></td>
            <td><?php echo $row->award; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>