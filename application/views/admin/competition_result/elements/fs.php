<ul class="breadcrumb">
    <li><a href="<?php echo base_url(); ?>admin/gameday/<?php echo $item->competition->id; ?>">Dashboard</a></li>
    <li><a href="<?php echo base_url(); ?>admin/competition_result/running/<?php echo $item->competition->id; ?>/<?php echo $breadcrumb->id; ?>"><?php echo $breadcrumb->name; ?> - Running Order</a></li>
</ul>
<div class="row">
    <div class="col-lg-12">
        <table class="table table-condensed table-bordered">
            <thead>
                <tr class="info">
                    <th>Human</th>
                    <th>Canine</th>
                    <th>Division</th>
                </tr>
            </thead>
            <tbody>
                <tr class="active">
                    <td><?php echo $item->user->full_name; ?></td>
                    <td><?php echo $item->canine->name; ?></td>
                    <td><?php echo $item->division->name; ?><?php if($dual == '1') echo ' (Dual)'; ?></td>
                </tr>
            </tbody>    
        </table>        
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <?php echo form_open('admin/competition_result/edit/'.$id.'/'.$division_id, '', $hidden); ?>
        <ul class="nav nav-pills">
            <li class="active"><a href="#round_1" data-toggle="tab" data="1">Round 1</a></li>
            <li><a href="#round_2" data-toggle="tab" data="2">Round 2</a></li>
        </ul>
        <br />
        <div class="tab-content">
            <div class="tab-pane fade in active" id="round_1">
                <table class="table table-bordered table-condensed table-striped">
                    <thead>
                        <tr class="info">
                            <th class="text-center"><?php echo $labels['fs_labels'][0]; ?></th>
                            <th class="text-center"><?php echo $labels['fs_labels'][1]; ?></th>
                            <th class="text-center"><?php echo $labels['fs_labels'][2]; ?></th>
                            <th class="text-center"><?php echo $labels['fs_labels'][3]; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr class="active">
                        <td><input type="number" name="fs_1_1" class="fs_1 form-control" id="fs_1_1" value="<?php echo $item->fs_1_1; ?>" /></td>
                        <td><input type="number" name="fs_2_1" class="fs_1 form-control" id="fs_2_1" value="<?php echo $item->fs_2_1; ?>" /></td>
                        <td><input type="number" name="fs_3_1" class="fs_1 form-control" id="fs_3_1" value="<?php echo $item->fs_3_1; ?>" /></td>
                        <td><input type="number" name="fs_4_1" class="fs_1 form-control" id="fs_4_1" value="<?php echo $item->fs_4_1; ?>" /></td>
                    </tr>
                    <tr class="warning">
                        <th colspan="3" class="text-right">Catch Ratio</th>
                        <td><input type="number" name="cr_1" class="cr_1 form-control" id="cr_1" value="<?php echo $item->cr_1; ?>" /></td>
                    </tr>
                    <tr class="danger">
                        <th colspan="3" class="text-right">Deduct</th>
                        <td><input type="number" name="deduct_1" class="fs_1 form-control" id="deduct_1" /></td>
                    </tr>
                    <tr class="success">
                        <th colspan="3" class="text-right">Total</th>
                        <td><input type="number" name="fs_total_1" class="form-control" id="fs_total_1" value="<?php echo $item->fs_total_1; ?>" /></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="round_2">
                <table class="table table-bordered table-condensed table-striped">
                    <thead>
                        <tr class="info">
                            <th class="text-center"><?php echo $labels['fs_labels'][0]; ?></th>
                            <th class="text-center"><?php echo $labels['fs_labels'][1]; ?></th>
                            <th class="text-center"><?php echo $labels['fs_labels'][2]; ?></th>
                            <th class="text-center"><?php echo $labels['fs_labels'][3]; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr class="active">
                        <td><input type="number" name="fs_1_2" class="fs_2 form-control" id="fs_1_2" value="<?php echo $item->fs_1_2; ?>" /></td>
                        <td><input type="number" name="fs_2_2" class="fs_2 form-control" id="fs_2_2" value="<?php echo $item->fs_2_2; ?>" /></td>
                        <td><input type="number" name="fs_3_2" class="fs_2 form-control" id="fs_3_2" value="<?php echo $item->fs_3_2; ?>" /></td>
                        <td><input type="number" name="fs_4_2" class="fs_2 form-control" id="fs_4_2" value="<?php echo $item->fs_4_2; ?>" /></td>
                    </tr>
                    <tr class="warning">
                        <th colspan="3" class="text-right">Catch Ratio</th>
                        <td><input type="number" name="cr_2" class="cr_2 form-control" id="cr_2" value="<?php echo $item->cr_2; ?>" /></td>
                    </tr>
                    <tr class="danger">
                        <th colspan="3" class="text-right">Deduct</th>
                        <td><input type="number" name="deduct_2" class="fs_2 form-control" id="deduct_2" /></td>
                    </tr>
                    <tr class="success">
                        <th colspan="3" class="text-right">Total</th>
                        <td><input type="number" name="fs_total_2" class="form-control" id="fs_total_2" value="<?php echo $item->fs_total_2; ?>" /></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <table class="table">
            <tbody>
                <tr>
                    <td class="text-right" colspan="8"><?php echo form_submit('submit', 'Save Score', 'class="btn btn-primary"'); ?></td>
                </tr>
            </tbody>
        </table>
        <?php echo form_close(); ?>
    </div>
</div>
<script>
$(document).ready(function() {
   $('.fs_1').change(function() {
       fs_1 = Number($('#fs_1_1').val());
       fs_2 = Number($('#fs_2_1').val());
       fs_3 = Number($('#fs_3_1').val());
       fs_4 = Number($('#fs_4_1').val());
       deduct_1 = $('#deduct_1').val();
       fs_total = (fs_1 + fs_2 + fs_3 + fs_4); 
       total = (fs_total - deduct_1);
       new_total = Math.round(total*10)/10;
       $('#fs_total_1').val(new_total);
   });
   $('.fs_2').change(function() {
       fs_1 = Number($('#fs_1_2').val());
       fs_2 = Number($('#fs_2_2').val());
       fs_3 = Number($('#fs_3_2').val());
       fs_4 = Number($('#fs_4_2').val());
       deduct_1 = $('#deduct_2').val();
       fs_total = (fs_1 + fs_2 + fs_3 + fs_4); 
       total = (fs_total - deduct_1);
       new_total = Math.round(total*10)/10;
       $('#fs_total_2').val(new_total);
   }); 
});
</script>