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
        <h5>Freestyle</h5>
        <table class="table table-bordered table-condensed table-striped">
            <thead>
                <tr>
                    <th></th>
                    <th><?php echo $labels['fs_labels'][0]; ?></th>
                    <th><?php echo $labels['fs_labels'][1]; ?></th>
                    <th><?php echo $labels['fs_labels'][2]; ?></th>
                    <th><?php echo $labels['fs_labels'][3]; ?></th>
                    <th>Catch Ratio</th>
                    <th>Deduct</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr class="success">
                    <td>1</td>
                    <td><input type="number" name="fs_1_1" class="fs_1 form-control" id="fs_1_1" value="<?php echo $item->fs_1_1; ?>" /></td>
                    <td><input type="number" name="fs_2_1" class="fs_1 form-control" id="fs_2_1" value="<?php echo $item->fs_2_1; ?>" /></td>
                    <td><input type="number" name="fs_3_1" class="fs_1 form-control" id="fs_3_1" value="<?php echo $item->fs_3_1; ?>" /></td>
                    <td><input type="number" name="fs_4_1" class="fs_1 form-control" id="fs_4_1" value="<?php echo $item->fs_4_1; ?>" /></td>
                    <td><input type="number" name="cr_1" class="cr_1 form-control" id="cr_1" value="<?php echo $item->cr_1; ?>" /></td>
                    <td><input type="number" name="deduct_1" class="fs_1 form-control" id="deduct_1" /></td>
                    <td><input type="number" name="fs_total_1" class="form-control" id="fs_total_1" value="<?php echo $item->fs_total_1; ?>" /></td>
                </tr>                
                <tr class="info">
                    <td>2</td>
                    <td><input type="number" name="fs_1_2" class="fs_2 form-control" id="fs_1_2" value="<?php echo $item->fs_1_2; ?>" /></td>
                    <td><input type="number" name="fs_2_2" class="fs_2 form-control" id="fs_2_2" value="<?php echo $item->fs_2_2; ?>" /></td>
                    <td><input type="number" name="fs_3_2" class="fs_2 form-control" id="fs_3_2" value="<?php echo $item->fs_3_2; ?>" /></td>
                    <td><input type="number" name="fs_4_2" class="fs_2 form-control" id="fs_4_2" value="<?php echo $item->fs_4_2; ?>" /></td>
                    <td><input type="number" name="cr_2" class="cr_2 form-control" id="cr_2" value="<?php echo $item->cr_2; ?>" /></td>
                    <td><input type="number" name="deduct_2" class="fs_2 form-control" id="deduct_2" /></td>
                    <td><input type="number" name="fs_total_2" class="form-control" id="fs_total_2" value="<?php echo $item->fs_total_2; ?>" /></td>
                </tr>                
            </tbody>
        </table>
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