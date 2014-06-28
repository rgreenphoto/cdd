<div class="row">
    <div class="col-lg-12">
        <?php echo form_open('admin/competition_result/edit/'.$item->id.'/'.$item->division->id, '', $hidden); ?>
        <?php $round = (isset($item->fs_total_1))?'2':'1'; ?>
        <?php $style = ($item->division->id == 5)?'':'display:none;'; ?>
        <?php $type = ($item->division->id == 5)?'number':'hidden'; ?>
        <input type="hidden" id="round" name="round" value="<?php echo $round; ?>" />
        <ul class="nav nav-pills">
            <li class="<?php echo ($round == 1)?'active':''; ?>"><a href="#round_1" data-toggle="tab" data="1">Round 1</a></li>
            <li class="<?php echo ($round == 2)?'active':''; ?>"><a href="#round_2" data-toggle="tab" data="2">Round 2</a></li>
        </ul>
        <br />
        <div class="tab-content">
            <div class="tab-pane fade <?php echo ($round == 1)?'in active':''; ?>" id="round_1">
                <table class="table table-bordered table-condensed table-striped">
                    <thead>
                        <tr class="info">
                            <th class="text-center"><?php echo $labels['fs_labels'][0]; ?></th>
                            <th class="text-center"><?php echo $labels['fs_labels'][1]; ?></th>
                            <th class="text-center"><?php echo $labels['fs_labels'][2]; ?></th>
                            <th class="text-center"><?php echo $labels['fs_labels'][3]; ?></th>
                            <th class="text-center" style="<?php echo $style; ?>"><?php echo $labels['fs_labels'][4]; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr class="active">
                        <td><input type="number" round="1" name="fs_1_1" class="fs_score form-control" id="fs_1_1" value="<?php echo $item->fs_1_1; ?>" step=".1" /></td>
                        <td><input type="number" round="1" name="fs_2_1" class="fs_score form-control" id="fs_2_1" value="<?php echo $item->fs_2_1; ?>" step=".1" /></td>
                        <td><input type="number" round="1" name="fs_3_1" class="fs_score form-control" id="fs_3_1" value="<?php echo $item->fs_3_1; ?>" step=".1" /></td>
                        <td><input type="number" round="1" name="fs_4_1" class="fs_score form-control" id="fs_4_1" value="<?php echo $item->fs_4_1; ?>" step=".1" /></td>
                        <td style="<?php echo $style; ?>"><input type="<?php echo $type; ?>" name="fs_5_1" class="fs_score form-control" id="fs_5_1" value="<?php echo $item->fs_5_1; ?>" step=".1" /></td>
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
            <div class="tab-pane fade <?php echo ($round == 2)?'in active':''; ?>" id="round_2">
                <table class="table table-bordered table-condensed table-striped">
                    <thead>
                        <tr class="info">
                            <th class="text-center"><?php echo $labels['fs_labels'][0]; ?></th>
                            <th class="text-center"><?php echo $labels['fs_labels'][1]; ?></th>
                            <th class="text-center"><?php echo $labels['fs_labels'][2]; ?></th>
                            <th class="text-center"><?php echo $labels['fs_labels'][3]; ?></th>
                            <th class="text-center" style="<?php echo $style; ?>"><?php echo $labels['fs_labels'][4]; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr class="active">
                        <td><input type="number" round="2" name="fs_1_2" class="fs_score form-control" id="fs_1_2" value="<?php echo $item->fs_1_2; ?>" step=".1" /></td>
                        <td><input type="number" round="2" name="fs_2_2" class="fs_score form-control" id="fs_2_2" value="<?php echo $item->fs_2_2; ?>" step=".1" /></td>
                        <td><input type="number" round="2" name="fs_3_2" class="fs_score form-control" id="fs_3_2" value="<?php echo $item->fs_3_2; ?>" step=".1" /></td>
                        <td><input type="number" round="2" name="fs_4_2" class="fs_score form-control" id="fs_4_2" value="<?php echo $item->fs_4_2; ?>" step=".1" /></td>
                        <td style="<?php echo $style; ?>"><input type="<?php echo $type; ?>" name="fs_5_2" class="fs_score form-control" id="fs_5_2" value="<?php echo $item->fs_5_2; ?>" step=".1" /></td>
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