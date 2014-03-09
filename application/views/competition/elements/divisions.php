<table class="table table-striped table-bordered table-condensed">
    <thead>
        <tr class="success">
            <th>Division</th>
            <th>Fee</th>
        </tr>
    </thead>    
   <tbody> 
   <?php if(!empty($divisions)) foreach($divisions as $row): ?>    
        <tr>
            <td><?php echo $row->name; ?></td>
            <td><?php echo $row->fee; ?></td>
        </tr>
    <?php endforeach; ?>    
    </tbody>
</table>