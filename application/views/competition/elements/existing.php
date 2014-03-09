<?php $style = 'display:none'; if(!empty($registrations)) $style = ''; ?>
<table class="table table-striped table-bordered table-condensed" id="registered-teams" style="<?php echo $style; ?>">
        <tr class="danger">
            <th>Human</th>
            <th>Dog</th>
            <th>Division</th>
            <th>Fee</th>
        </tr>
    </thead>
    <tbody id="holding">
    <?php if(!empty($registrations)) foreach($registrations as $row): ?>
        <tr>
            <td><?php echo $row->user->first_name.' '.$row->user->last_name; ?></td>
            <td><?php echo $row->canine->name; ?></td>
            <td><?php echo $row->division->name; ?></td>
            <td><?php echo $row->fees; ?></td>                                
        </tr>
    <?php endforeach; ?>
    </tbody>
</table> 