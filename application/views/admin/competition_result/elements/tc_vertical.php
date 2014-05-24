<div class="row">
    <div class="col-lg-3 col-sm-3 col-xs-3">
        <div class="list-group">
            <?php if(!empty($labels['tc_labels'])) foreach($labels['tc_labels'] as $tc_label): ?>
                <a href="#" class="tc_btn list-group-item <?php echo is_numeric($tc_label)?'list-group-item-success':'list-group-item-danger'; ?>" data-value="<?php echo $tc_label; ?>">
                    <h5 class="list-group-item-heading"><?php echo $tc_label;  ?> <i class="icon-plus-sign pull-right"></i></h5>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    
    <div class="col-lg-9 col-sm-9 col-xs-9">
        <?php echo form_open('admin/competition_result/edit/'.$id.'/'.$division_id, '', $hidden); ?>
        <input type="hidden" name="round" id="round" value="<?php echo !empty($item->tc_total_2)&&$item->tc_total_2=='0.0'?'2':'1'; ?>" />
        <ul class="nav nav-pills">
            <li class="<?php if(empty($item->tc_total_1) && $item->tc_total_1 != '0.0') echo 'active '; ?>"><a href="#round_1" data="1" data-toggle="tab">Round 1</a></li>
            <li class="<?php if(!empty($item->tc_total_2) && $item->tc_total_2 == '0.0') echo 'active '; ?>"><a href="#round_2" data="2" data-toggle="tab">Round 2</a></li>
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
                                        <?php echo form_number('tc_total_1', $item->tc_total_1, 'class="form-control" id="tc_total_1"'); ?>
                                        <span class="input-group-addon">Total</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>                 
            </div>
            <div class="tab-pane fade <?php if(!empty($item->tc_total_2) && $item->tc_total_2 == '0.0') echo 'in active '; ?>" id="round_2">
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
                                        <?php echo form_number('tc_total_2', $item->tc_total_2, 'class="form-control" id="tc_total_2"'); ?>
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
                    <tr>
                        <td>
                            <label>Calc overall</label><br />
                            <label class="radio-inline">
                                <input type="radio" name="calculate_scores" value="Yes" checked="checked" /> Yes
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="calculate_scores" value="No" /> No
                            </label>
                        </td>
                        <td class="text-right">
                            <?php echo form_submit('submit', 'Save Score', 'class="btn btn-primary"'); ?>
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
      console.log(round);
      $('#round').val(round);
    });    
});
</script>