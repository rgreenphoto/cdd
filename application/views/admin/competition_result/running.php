<ul class="breadcrumb">
    <li><a href="<?php echo base_url(); ?>admin/gameday/<?php echo $competition->id; ?>">Game Day Dashboard</a></li>
    <li class="active"><?php echo $division->name; ?></li>
</ul>
<div class="row">
    <div class="col-lg-8">
        <h3><img src="<?php echo base_url(); ?><?php echo $competition->competition_type->image; ?>" /> <?php echo $competition->name; ?></h3>
        <h4><?php echo $division->name; ?> - Running Order</h4>
        <p>A random order has been generated. If for you need to adjust this running order, drag and drop the row to the new position.</p>
    </div>
    <div class="col-lg-4 hidden-xs">
        <table class="table">
            <tr class="hidden-sm hidden-xs">
                <td><a href="<?php echo base_url(); ?>admin/competition_result/p_running/<?php echo $competition->id; ?>/<?php echo $division->id; ?>" class="btn btn-sm btn-cdd"><i class="icon-print"></i> Running Order</a></td>
                <td><a href="<?php echo base_url(); ?>admin/competition_result/placement/<?php echo $competition->id; ?>/<?php echo $division->id; ?>" class="btn btn-sm btn-cdd"><i class="icon-print"></i> Final Results</a></td>
            </tr>
            <tr>
                <td colspan="2">
                    <?php if($division->dual == '1' && $division->freestyle == '0'): ?>
                    <p class="text-error">Advanced division will include the Advanced and Open competitors. Advanced teams that are marked as Dual will automatically have their score updated for Open.</p>
                    <?php endif; ?>
                </td>
            </tr>
        </table>
    </div>
</div>
<?php if(!empty($teams)): ?>
<div class="row">
    <table id="sort" class="table table-striped table-hover footable toggle-circle toggle-medium">
        <thead>
            <tr>
                <th data-toggle="true">Order</th>
                <th>Human</th>
                <th>Canine</th>
                <th data-hide="phone,tablet">Division</th>
                <th data-hide="phone,tablet">Rounds Completes</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($teams as $row): ?>
            <tr id="<?php echo $row->id; ?>" class="clickable">
                <td><?php if($division->freestyle == '1') { echo $row->fs_order; } else { echo $row->tc_order; } ?></td>
                <td><?php echo $row->user->full_name; ?></td>
                <td><?php if(!empty($row->canine->name)) echo $row->canine->name; ?></td>
                <td><?php echo $row->division->name; ?> <?php if($row->dual == 1) echo '(Dual)'; ?></td>
                <td class="text-error">
                    <?php if(!empty($row->fs_total_1) && $row->fs_total_1 != '0.0') echo 'FS1 '; ?>
                    <?php if(!empty($row->fs_total_2) && $row->fs_total_2 != '0.0') echo 'FS2 '; ?>
                    <?php if(!empty($row->tc_total_1) && $row->tc_total_1 != '0.0') echo 'TC1 '; ?>
                    <?php if(!empty($row->tc_total_2) && $row->tc_total_2 != '0.0') echo 'TC2 '; ?>
                </td>
                <td>
                    <a href="<?php echo base_url(); ?>admin/competition_result/edit/<?php echo $row->id; ?>/<?php echo $division->id; ?>/tc" class="btn btn-sm btn-success"><i class="icon-plus"></i> Add TC</a>
                    <a href="<?php echo base_url(); ?>admin/competition_result/edit/<?php echo $row->id; ?>/<?php echo $division->id; ?>/<?php echo $division->freestyle == '1'?'fs':''; ?>" class="btn btn-sm btn-success"><i class="icon-plus"></i> Add FS</a>
                    <a href="<?php echo base_url(); ?>admin/competition_result/edit/<?php echo $row->id; ?>/<?php echo $division->id; ?>/edit" class="hidden-xs hidden-sm hidden-md btn btn-sm btn-danger"><i class="icon-edit"></i> Edit</a>
                </td>
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
                    $('#pleaseWaitDialog').modal('show');
                    $.ajax({
                        type: "POST", 
                        async: false, 
                        url: '<?php echo base_url(); ?>admin/competition_result/set_order/',   
                        data: {
                            order: order,
                            competition_id: '<?php echo $competition->id; ?>',
                            division_id: '<?php echo $division_id; ?>',
                            freestyle: '<?php echo $division->freestyle; ?>'

                        },
                        success: function(data){
                            $('#pleaseWaitDialog').modal('hide');
                            data = $.parseJSON(data);
                            var html = '';
                            $.each(data, function(i, val) {
                                html += '<tr id="' + val.id + '">';
                                html += '<td>' + val.order + '</td>';
                                html += '<td>' + val.human + '</td>';
                                html += '<td>' + val.canine + '</td>';
                                html += '<td>' + val.division + '</td>';
                                html += '<td class="text-error">' + val.progress + '</td>';
                                html += '<td><a href="<?php echo base_url(); ?>admin/competition_result/edit/'+val.id+'/'+val.division_id+'" class="btn btn-small btn-success"><i class="icon-plus"></i> Add Score</a></td>';
                                html += '</tr>';
                                
                            });
                            
                            $('#sort tbody').html(html).effect('highlight', 'slow');
                        },
                        error: function(){alert('error');}
                     });                                                        
                }
              }
            });
        });

</script>
