<div class="alert alert-success" style="display:none;">
  <a href="#" class="close" data-dismiss="alert">&times;</a>
  <p id="alert-data"></p>
</div>
<ul class="breadcrumb">
    <li><a href="<?php echo base_url(); ?>admin/competition/manage/<?php echo $competition->id; ?>">Game Day Dashboard</a> <span class="divider">/</span></li>
    <li class="active"><?php echo $division->name; ?></li>
</ul>
<div class="row-fluid">
    <span class="span8">
        <h3><img src="<?php echo base_url(); ?>assets/images/<?php echo $competition->competition_type->image; ?>" /> <?php echo $competition->name; ?></h3>
        <h4><?php echo $division->name; ?> - Running Order</h4>
        <p>A random order has been generated. If for you need to adjust this running order, drag and drop the row to the new position.</p>
    </span>
    <span class="span4">
        <table class="table">
            <tr>
                <td><a href="<?php echo base_url(); ?>admin/registration/p_running/<?php echo $competition->id; ?>/<?php echo $division->id; ?>" class="btn btn-small btn-primary"><i class="icon-print"></i> Running Order</a></td>
                <td><a href="<?php echo base_url(); ?>admin/competition_result/placement/<?php echo $competition->id; ?>/<?php echo $division->id; ?>" class="btn btn-small btn-primary"><i class="icon-print"></i> Final Results</a></td>
            </tr>
        </table>
    </span>
</div>
<?php if(!empty($teams)): ?>
<div class="row-fluid">
    <table id="sort" class="table table-striped table-hover">
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
                <td><?php if(!empty($row->canine->name)) echo $row->canine->name; ?></td>
                <td><a href="<?php echo base_url(); ?>admin/competition_result/edit/<?php echo $row->competition_id; ?>/<?php echo $row->user->id; ?>/<?php if(!empty($row->canine->id)) echo $row->canine->id; ?>/<?php echo $row->division->id; ?>" class="btn btn-small btn-success"><i class="icon-plus"></i> Add Score</a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>    
</div>
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
                                html += '<td><a href="<?php echo base_url(); ?>admin/competition_result/edit/<?php echo $competition->id; ?>/'+val.user_id+'/'+val.canine_id+'/<?php echo $division_id; ?>" class="btn btn-small btn-success"><i class="icon-plus"></i> Add Score</a></td>';
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
