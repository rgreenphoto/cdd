<div class="row">
    <div class="col-lg-9 col-md-9 col-sm-9">
        <div class="btn-toolbar">
            <div class="btn-group btn-group-vertical">
                <?php if(!empty($labels['tc_labels']['no_catch_group'])) foreach($labels['tc_labels']['no_catch_group'] as $label): ?>
                    <button class="btn btn-danger btn-lg tc_btn" data-value="<?php echo $label; ?>"><h3><?php echo $label; ?> <i class="icon-plus-sign"></i></h3></button>
                <?php endforeach; ?>
                    <button class="btn btn-success btn-lg tc_btn" data-value="0.0"><h3>0 <i class="icon-plus-sign"></i></h3></button>
            </div>
            <?php if(!empty($labels['tc_labels']['airbonus'])): ?>
                <?php foreach($labels['tc_labels']['catch_group'] as $label): ?>
                    <?php if($label != 0): ?>
                    <div class="btn-group btn-group-vertical">
                        <button class="btn btn-success btn-lg tc_btn" data-value="<?php echo ($label + $labels['tc_labels']['airbonus']); ?>"><h3><?php echo ($label + $labels['tc_labels']['airbonus']); ?> <i class="icon-plus-sign"></i></h3></button>
                        <button class="btn btn-success btn-lg tc_btn" data-value="<?php echo $label; ?>"><h3><?php echo $label; ?> <i class="icon-plus-sign"></i></h3></button>
                    </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
            <?php if(empty($labels['tc_labels']['airbonus'])): ?>
            <div class="btn-group btn-group-lg">
                <?php foreach($labels['tc_labels']['catch_group'] as $label): ?>
                 <button class="btn btn-success btn-lg tc_btn <?php if(!empty($bonus_iterator) && $label == 2.5): ?>iterate<?php endif; ?>" <?php if(!empty($bonus_iterator) && $label == 2.5): ?>data-iterate="true"<?php endif; ?> data-value="<?php echo $label; ?>"><h3><span><?php echo $label; ?></span> <i class="icon-plus-sign"></i></h3></button>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-3">
        <div class="well pull-right">
            <h1><small>Last</small><br /> <span class="label label-info" id="last_throw_badge">&nbsp;</span></h1>
            <h1><small>Total</small><br /> <span class="label label-primary" id="total_badge">0</span></h1>
        </div>
    </div>
</div>
<br />
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <?php echo form_open('admin/competition_result/edit/'.$item->id.'/'.$division->id, '', $hidden); ?>
        <?php echo form_submit('submit', 'Save Score', 'class="btn btn-primary pull-right"'); ?>
        <input type="hidden" name="round" id="round" value="<?php echo isset($item->tc_total_1)?'2':'1'; ?>" />
        <ul class="nav nav-pills">
            <li class="<?php if(empty($item->tc_total_1)) echo 'active '; ?>"><a href="#round_1" data="1" data-toggle="tab">Round 1</a></li>
            <li class="<?php if(!empty($item->tc_total_1)) echo 'active '; ?>"><a href="#round_2" data="2" data-toggle="tab">Round 2</a></li>
        </ul>
        <br />
        <div class="tab-content">
            <div class="tab-pane fade <?php if(empty($item->tc_total_1) && $item->tc_total_1 != '0.0') echo 'in active '; ?>" id="round_1">
                <table id="queue" class="table table-bordered table-striped">
                    <thead>
                        <tr class="info">
                            <td colspan="2">Round 1 Scores</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            for($i=1; $i<=10; $i++) {
                                $style = ($i == 1 || !empty($item->{"tc_1_$i"}))?'':'display:none;';
                                $class = ($i == 1 || !empty($item->{"tc_1_$i"}))?'active':'warning';
                                echo '<tr id="focus_target_1_'.$i.'" class="'.$class.' score-label" style="'.$style.'">';
                                echo '<td colspan="2">';
                                echo '<div class="col-lg-12">';
                                echo '<div class="input-group">';
                                echo '<input type="text" name="tc_1_'.$i.'" class="form-control tc_1" id="tc_1_'.$i.'" value="'.$item->{"tc_1_$i"}.'" />';
                                echo '<span class="input-group-addon"><a href="#" data-position="'.$i.'" class="remove-score">Clear <i class="icon-refresh"></i></a></span>';
                                echo '</div>';
                                echo '</div>';                        
                                echo '</td>';
                                echo '</tr>';
                            }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr id="total_row" class="success">
                            <td colspan="2">
                                <div class="col-lg-12">
                                    <div class="input-group">
                                        <input type="number" name="tc_total_1" class="form-control" id="tc_total_1" value="<?php echo $item->tc_total_1; ?>" step=".1" />
                                        <span class="input-group-addon">Total</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>                 
            </div>
            <div class="tab-pane fade <?php if(isset($item->tc_total_1)) echo 'in active '; ?>" id="round_2">
                <table id="queue" class="table table-bordered table-striped">
                    <thead>
                        <tr class="info">
                            <td colspan="2">Round 2 Scores</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            for($i=1; $i<=10; $i++) {
                                $style = ($i == 1 || !empty($item->{"tc_2_$i"}))?'':'display:none;';
                                $class = (!empty($item->{"tc_2_$i"}))?'active':'warning';
                                echo '<tr id="focus_target_2_'.$i.'" class="'.$class.' score-label" style="'.$style.'">';
                                echo '<td colspan="2">';
                                echo '<div class="col-lg-12">';
                                echo '<div class="input-group">';
                                echo '<input type="text" name="tc_2_'.$i.'" class="form-control tc_2" id="tc_2_'.$i.'" value="'.$item->{"tc_2_$i"}.'" />';
                                echo '<span class="input-group-addon"><a href="#" data-position="'.$i.'" class="remove-score">Clear <i class="icon-refresh"></i></a></span>';
                                echo '</div>';
                                echo '</div>';                        
                                echo '</td>';
                                echo '</tr>';
                            }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr id="total_row" class="success">
                            <td colspan="2">
                                <div class="col-lg-12">
                                    <div class="input-group">
                                        <?php echo form_input('tc_total_2', $item->tc_total_2, 'class="form-control" id="tc_total_2"'); ?>
                                        <span class="input-group-addon">Total</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <table class="table table-condensed">
                <tbody>
                        <td class="text-right">
                            <?php echo form_reset('Clear All', 'Clear All', 'id="clear_form" class="btn btn-danger"'); ?>&nbsp;
                            <?php echo form_submit('submit', 'Save Score', 'class="btn btn-primary pull-right"'); ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<script>
$(document).ready(function() {
    //set a hidden variable for round for use in above JQuery 
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
      round = $(e.target).attr('data');
      $('#round').val(round);
    });

    $('#clear_form').click(function() {
        $('#total_badge').html('0');
        $('#last_throw_badge').html('0');
    });
});
</script>