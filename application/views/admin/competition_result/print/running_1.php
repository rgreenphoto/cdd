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
</style>
<h2><?php echo $competition->name; ?></h2>
<h3><?php echo $division->name; ?></h3>
<p><strong>Running Order</strong></p>
<?php if(!empty($teams)): ?>   
    <table cellpadding="0" cellspacing="0">
        <tbody>
            <?php $i=0; foreach($teams as $row): ?>
            <?php $class = ''; if($odd = $i%2) { $class = 'odd'; } ?>
            <tr class="<?php echo $class; ?>">
                <td><?php echo $row->sort; ?></td>
                <td><?php echo $row->user->full_name; ?></td>
                <td><?php if(!empty($row->canine->name)) echo $row->canine->name; ?></td>
            </tr>
            <?php $i++; endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

