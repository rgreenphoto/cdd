<div class="row">
    <div class="col-lg-12">
        <?php echo form_open('admin/competition_result/edit/'.$id.'/'.$division_id, '', $hidden); ?>
        <input type="hidden" name="tc_cat_1" value="<?php echo $item->tc_cat_1; ?>" />
        <input type="hidden" name="tc_total_1" value="<?php echo $item->tc_total_1; ?>" />
        <input type="hidden" name="tc_cat_2" value="<?php echo $item->tc_cat_2; ?>" />
        <input type="hidden" name="tc_total_2" value="<?php echo $item->tc_total_2; ?>" />
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
                            <?php if($division_id == 5): ?>
                            <th class="text-center"><?php //echo $labels['fs_labels'][4]; ?></th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                    <tr class="active">
                        <td><input type="number" name="fs_1_1" class="fs_1 form-control" id="fs_1_1" value="<?php echo $item->fs_1_1; ?>" step=".1" /></td>
                        <td><input type="number" name="fs_2_1" class="fs_1 form-control" id="fs_2_1" value="<?php echo $item->fs_2_1; ?>" step=".1" /></td>
                        <td><input type="number" name="fs_3_1" class="fs_1 form-control" id="fs_3_1" value="<?php echo $item->fs_3_1; ?>" step=".1" /></td>
                        <td><input type="number" name="fs_4_1" class="fs_1 form-control" id="fs_4_1" value="<?php echo $item->fs_4_1; ?>" step=".1" /></td>
                        <?php if($division_id == 5): ?>
                        <td><input type="number" name="fs_5_1" class="fs_1 form-control" id="fs_5_1" value="<?php echo $item->fs_5_1; ?>" step=".1" /></td>
                        <?php endif; ?>
                    </tr>
                    <tr class="warning">
                        <th colspan="3" class="text-right">Catch Ratio</th>
                        <td><input type="number" name="cr_1" class="cr_1 form-control" id="cr_1" value="<?php echo $item->cr_1; ?>" step=".1" /></td>
                    </tr>
                    <tr class="danger">
                        <th colspan="3" class="text-right">Deduct</th>
                        <td><input type="number" name="deduct_1" class="fs_1 form-control" id="deduct_1" step=".1" value="<?php echo $item->deduct_1; ?>" /></td>
                    </tr>
                    <tr class="success">
                        <th colspan="3" class="text-right">Total</th>
                        <td><input type="number" name="fs_total_1" class="form-control" id="fs_total_1" value="<?php echo $item->fs_total_1; ?>" step=".1" /></td>
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
                            <?php if($division_id == 5): ?>
                                <th class="text-center"><?php //echo $labels['fs_labels'][4]; ?></th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                    <tr class="active">
                        <td><input type="number" name="fs_1_2" class="fs_2 form-control" id="fs_1_2" value="<?php echo $item->fs_1_2; ?>" step=".1" /></td>
                        <td><input type="number" name="fs_2_2" class="fs_2 form-control" id="fs_2_2" value="<?php echo $item->fs_2_2; ?>" step=".1" /></td>
                        <td><input type="number" name="fs_3_2" class="fs_2 form-control" id="fs_3_2" value="<?php echo $item->fs_3_2; ?>" step=".1" /></td>
                        <td><input type="number" name="fs_4_2" class="fs_2 form-control" id="fs_4_2" value="<?php echo $item->fs_4_2; ?>" step=".1" /></td>
                        <?php if($division_id == 5): ?>
                            <td><input type="number" name="fs_5_2" class="fs_1 form-control" id="fs_5_2" value="<?php echo $item->fs_5_1; ?>" step=".1" /></td>
                        <?php endif; ?>
                    </tr>
                    <tr class="warning">
                        <th colspan="3" class="text-right">Catch Ratio</th>
                        <td><input type="number" name="cr_2" class="cr_2 form-control" id="cr_2" value="<?php echo $item->cr_2; ?>" step=".1" /></td>
                    </tr>
                    <tr class="danger">
                        <th colspan="3" class="text-right">Deduct</th>
                        <td><input type="number" name="deduct_2" class="fs_2 form-control" id="deduct_2" step=".1" value="<?php echo $item->deduct_2; ?>"/></td>
                    </tr>
                    <tr class="success">
                        <th colspan="3" class="text-right">Total</th>
                        <td><input type="number" name="fs_total_2" class="form-control" id="fs_total_2" value="<?php echo $item->fs_total_2; ?>" step=".1" /></td>
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
//       fs_5 = Number($('#fs_5_1').val());
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
//       fs_5 = Number($('#fs_5_2').val());
       deduct_1 = $('#deduct_2').val();
       fs_total = (fs_1 + fs_2 + fs_3 + fs_4);
       total = (fs_total - deduct_1);
       new_total = Math.round(total*10)/10;
       $('#fs_total_2').val(new_total);
   }); 
});
</script>