<div class="alert alert-success" style="display:none;">
  <p id="alert-data"></p>
</div>
<?php if(!empty($teams)): ?>
<table id="sort" class="table">
    <thead>
        <tr>
            <th>Order</th>
            <th>Human</th>
            <th>Canine</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($teams as $row): ?>
        <tr id="<?php echo $row->id; ?>" class="clickable">
            <td><?php echo $row->sort; ?></td>
            <td><?php echo $row->user->full_name; ?></td>
            <td><?php echo $row->canine->name; ?></td>
            <td><a href="<?php echo base_url(); ?>admin/competition_result/edit/<?php echo $row->competition_id; ?>/<?php echo $row->user->id; ?>/<?php echo $row->canine->id; ?>/<?php echo $row->division->id; ?>" class="btn btn-small">Add Score</a></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>

<script>
    $(document).ready(function() {
        $('#sort tbody').sortable({
            update: function(event, ui) {
                var order = $(this).sortable('toArray').toString();
                if(order) {
                    $.ajax({
                        type: "POST", 
                        async: false, 
                        url: '<?php echo base_url(); ?>admin/registration/set_order/',   
                        data: {
                            order: order,
                            competition_id: '<?php echo $competition->id; ?>',
                            division_id: '<?php echo $division_id; ?>'

                        },
                        success: function(data){
                            data = $.parseJSON(data);
                            var html = '';
                            $.each(data, function(i, val) {
                                html += '<tr id="' + val.id + '">';
                                html += '<td>' + val.sort + '</td>';
                                html += '<td>' + val.human + '</td>';
                                html += '<td>' + val.canine + '</td>';
                                html += '<td><a href="<?php echo base_url(); ?>admin/competition_result/edit/<?php echo $competition->id; ?>/'+val.user_id+'/'+val.canine_id+'/<?php echo $division_id; ?>" class="btn btn-small">Add Score</a></td>';
                                html += '</tr>';
                                
                            });
                            
                            $('#sort tbody').html(html).effect('highlight', 'slow');
                            $('#alert-data').html('Reorder Successful');
                            $('.alert').show();
                        },
                        error: function(){alert('error');}
                     });                                                        
                }
              }
            });
        });

</script>
