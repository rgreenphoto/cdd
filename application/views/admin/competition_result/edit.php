<?php echo form_open('admin/competition_result/edit/'.$id.'/'.$division_id, '', $hidden); ?>
<?php if($item->division->freestyle == '1'): ?>
<div class="row">
    <div class="col-lg-12">
        <h5>Freestyle</h5>
        <table class="table table-bordered table-condensed table-striped">
            <thead>
                <tr class="info">
                    <th>Round</th>
                    <th class="text-center"><?php echo $labels['fs_labels'][0]; ?></th>
                    <th class="text-center"><?php echo $labels['fs_labels'][1]; ?></th>
                    <th class="text-center"><?php echo $labels['fs_labels'][2]; ?></th>
                    <th class="text-center"><?php echo $labels['fs_labels'][3]; ?></th>
                    <th class="text-center">Catch Ratio</th>
                    <th class="text-center">Deduct</th>
                    <th class="text-center">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td><?php echo form_input('fs_1_1', $item->fs_1_1, 'class="fs_1 form-control" id="fs_1_1"'); ?></td>
                    <td><?php echo form_input('fs_2_1', $item->fs_2_1, 'class="fs_1 form-control" id="fs_2_1"'); ?></td>
                    <td><?php echo form_input('fs_3_1', $item->fs_3_1, 'class="fs_1 form-control" id="fs_3_1"'); ?></td>
                    <td><?php echo form_input('fs_4_1', $item->fs_4_1, 'class="fs_1 form-control" id="fs_4_1"'); ?></td>
                    <td><?php echo form_input('cr_1', $item->cr_1, 'class="cr_1 form-control" id="cr_1"'); ?></td>
                    <td><?php echo form_input('deduct_1', $item->deduct_1, 'class="fs_1 form-control" id="deduct_1"'); ?></td>
                    <td><?php echo form_input('fs_total_1', $item->fs_total_1, 'class="form-control" id="fs_total_1"'); ?></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td><?php echo form_input('fs_1_2', $item->fs_1_2, 'class="fs_2 form-control" id="fs_1_2"'); ?></td>
                    <td><?php echo form_input('fs_2_2', $item->fs_2_2, 'class="fs_2 form-control" id="fs_2_2"'); ?></td>
                    <td><?php echo form_input('fs_3_2', $item->fs_3_2, 'class="fs_2 form-control" id="fs_3_2"'); ?></td>
                    <td><?php echo form_input('fs_4_2', $item->fs_4_2, 'class="fs_2 form-control" id="fs_4_2"'); ?></td>
                    <td><?php echo form_input('cr_1', $item->cr_1, 'class="cr_1 form-control" id="cr_1"'); ?></td>
                    <td><?php echo form_input('deduct_2', $item->deduct_2, 'class="fs_2 form-control" id="deduct_2"'); ?></td>
                    <td><?php echo form_input('fs_total_2', $item->fs_total_2, 'class="form-control" id="fs_total_2"'); ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>
<div class="row">
    <div class="col-lg-12">
        <h5>Toss and Catch</h5>
        <table class="table table-bordered table-condensed table-striped">
            <thead>
                <tr class="info">
                    <th>Round</th>
                    <?php
                        for($i=1; $i<=10; $i++) {
                            echo '<th class="text-center">'.$i.'</th>';
                        }
                   ?>
                   <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td><?php echo form_input('tc_1_1', $item->tc_1_1, 'class="tc_1 form-control" id="tc_1_1"'); ?></td>
                    <td><?php echo form_input('tc_1_2', $item->tc_1_2, 'class="tc_1 form-control" id="tc_1_2"'); ?></td>
                    <td><?php echo form_input('tc_1_3', $item->tc_1_3, 'class="tc_1 form-control" id="tc_1_3"'); ?></td>
                    <td><?php echo form_input('tc_1_4', $item->tc_1_4, 'class="tc_1 form-control" id="tc_1_4"'); ?></td>
                    <td><?php echo form_input('tc_1_5', $item->tc_1_5, 'class="tc_1 form-control" id="tc_1_5"'); ?></td>
                    <td><?php echo form_input('tc_1_6', $item->tc_1_6, 'class="tc_1 form-control" id="tc_1_6"'); ?></td>
                    <td><?php echo form_input('tc_1_7', $item->tc_1_7, 'class="tc_1 form-control" id="tc_1_7"'); ?></td>
                    <td><?php echo form_input('tc_1_8', $item->tc_1_8, 'class="tc_1 form-control" id="tc_1_8"'); ?></td>
                    <td><?php echo form_input('tc_1_9', $item->tc_1_9, 'class="tc_1 form-control" id="tc_1_9"'); ?></td>
                    <td><?php echo form_input('tc_1_10', $item->tc_1_10, 'class="tc_1 form-control" id="tc_1_10"'); ?></td>
                    <td><?php echo form_input('tc_total_1', $item->tc_total_1, 'class="form-control" id="tc_total_1"'); ?></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td><?php echo form_input('tc_2_1', $item->tc_2_1, 'class="tc_2 form-control" id="tc_2_1"'); ?></td>
                    <td><?php echo form_input('tc_2_2', $item->tc_2_2, 'class="tc_2 form-control" id="tc_2_2"'); ?></td>
                    <td><?php echo form_input('tc_2_3', $item->tc_2_3, 'class="tc_2 form-control" id="tc_2_3"'); ?></td>
                    <td><?php echo form_input('tc_2_4', $item->tc_2_4, 'class="tc_2 form-control" id="tc_2_4"'); ?></td>
                    <td><?php echo form_input('tc_2_5', $item->tc_2_5, 'class="tc_2 form-control" id="tc_2_5"'); ?></td>
                    <td><?php echo form_input('tc_2_6', $item->tc_2_6, 'class="tc_2 form-control" id="tc_2_6"'); ?></td>
                    <td><?php echo form_input('tc_2_7', $item->tc_2_7, 'class="tc_2 form-control" id="tc_2_7"'); ?></td>
                    <td><?php echo form_input('tc_2_8', $item->tc_2_8, 'class="tc_2 form-control" id="tc_2_8"'); ?></td>
                    <td><?php echo form_input('tc_2_9', $item->tc_2_9, 'class="tc_2 form-control" id="tc_2_9"'); ?></td>
                    <td><?php echo form_input('tc_2_10', $item->tc_2_10, 'class="tc_2 form-control" id="tc_2_10"'); ?></td>
                    <td><?php echo form_input('tc_total_2', $item->tc_total_2, 'class="form-control" id="tc_total_2"'); ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-lg-3">
        <?php echo form_label('Calculate Scores?', 'calculate_scores'); echo form_dropdown('calculate_scores', array('Yes' => 'Yes', 'No' => 'No'), 'Yes'); ?>
    </div>
    <div class="col-lg-9">
        <?php echo form_submit('submit', 'Save', 'class="btn btn-info pull-right"'); ?>
    </div>
</div>
<?php echo form_close(); ?>
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
   $('.tc_1').change(function() {
       tc_total = 0;     
       for(var i=1;i<10;i++) {
           if($.isNumeric($('#tc_1_' + i).val())) {
               tc_total += Number($('#tc_1_' + i).val());
           }           
       } 
       $('#tc_total_1').val(tc_total);
});
   $('.tc_2').change(function() {
       tc_total = 0;
        for(var i=1;i<10;i++) {
           if($.isNumeric($('#tc_2_' + i).val())) {
               tc_total += Number($('#tc_2_' + i).val());
           }           
       } 
       $('#tc_total_2').val(tc_total);
   });
});    
</script>   