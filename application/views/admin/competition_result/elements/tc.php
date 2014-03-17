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
    <div class="col-lg-1 col-sm-3 col-xs-3">
        <div class="btn-group-vertical btn-group-lg">
            <?php if(!empty($labels['tc_labels'])) foreach($labels['tc_labels'] as $tc_label): ?>
            <button class="btn btn-success btn-md tc_btn" data-value="<?php echo $tc_label; ?>"><?php echo $tc_label; ?> <i class="icon-plus"></i></button>
            <?php endforeach; ?>    
        </div>
    </div>
    
    <div class="col-lg-11 col-sm-9 col-xs-9">
        <?php echo form_open('admin/competition_result/edit/'.$id.'/'.$division_id, '', $hidden); ?>
        <input type="hidden" name="round" id="round" value="1" />
        <ul class="nav nav-pills">
            <li class="active"><a href="#round_1" data="1" data-toggle="tab">Round 1</a></li>
            <li><a href="#round_2" data="2" data-toggle="tab">Round 2</a></li>
        </ul>
        <br />
        <div class="tab-content">
            <div class="tab-pane fade in active" id="round_1">
                <table id="queue" class="table table-bordered table-striped">
                    <thead>
                        <tr class="info">
                            <td colspan="2">Scores</td>
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
            <div class="tab-pane fade" id="round_2">
                <table id="queue" class="table table-bordered table-striped">
                    <thead>
                        <tr class="info">
                            <td colspan="2">Scores</td>
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
    $('.tc_btn').click(function(e) {
        e.preventDefault();
        val = $(this).attr('data-value');
        round = $('#round').val();
        if(val) {
            throw_order = position(round);
            $('#label_' + throw_order).text(val);
            $('#tc_' + round + '_' + throw_order).val(val);
            new_label = $('#focus_target_'+ round +'_' + throw_order).attr('class');
            if(new_label === 'danger score-label') {
                new_label = 'active score-label';
            }
            $('#focus_target_'+ round +'_' + throw_order).show().removeClass().addClass(new_label);
            total(val, round);
        }
        $('.remove-score').click(function(e) {
            e.preventDefault();
            dp = $(this).attr('data-position');
            previous_value = $('#tc_' + round +'_' + dp).val();
            previous_total = $('#tc_total_'+ round).val();
            $('#tc_' + round + '_' + dp).val('');
            if($.isNumeric(previous_value) && $.isNumeric(previous_total)) {
                $('#tc_total_' + round).math('-', previous_total, previous_value);
            }
            $('#focus_target_'+round+'_' + dp).removeClass().addClass('danger score-label');

        });
        function position(round) {
            var i=1;
            $('.score-label').each(function() {
                value_set = $('#tc_' + round + '_'+i).val();
                if(value_set) {
                    i++;
                }
            });
            $('#focus_target_'+ round +'_'+(i - 1)).removeClass().addClass('active score-label');
            return i;
        }
        function total(val, round) {
            var current = $('#tc_total_'+ round).val();
            if(!current) {
                current = 0;
            }
            if($.isNumeric(val) && $.isNumeric(current)) {
                $('#tc_total_' + round).math('+', current, val);
                $('#tc_total_' + round).effect('highlight', 'slow');   
            }
        }
    });
    $('.remove-score').click(function(e) {
        e.preventDefault();
        round = $('#round').val();
        dp = $(this).attr('data-position');
        previous_value = $('#tc_' + round +'_' + dp).val();
        previous_total = $('#tc_total_'+ round).val();
        $('#tc_' + round + '_' + dp).val('');
        if($.isNumeric(previous_value) && $.isNumeric(previous_total)) {
            $('#tc_total_' + round).math('-', previous_total, previous_value);
        }
        $('#focus_target_'+round+'_' + dp).removeClass().addClass('danger score-label');

    });
    //set a hidden variable for round for use in above JQuery 
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
      round = $(e.target).attr('data');
      $('#round').val(round);
    });    
});
</script>