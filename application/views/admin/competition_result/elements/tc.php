<ul class="breadcrumb">
    <li><a href="<?php echo base_url(); ?>admin/gameday/<?php echo $item->competition->id; ?>">Game Day Dashboard</a></li>
    <li><a href="<?php echo base_url(); ?>admin/competition_result/running/<?php echo $item->competition->id; ?>/<?php echo $breadcrumb->id; ?>"><?php echo $breadcrumb->name; ?> - Running Order</a></li>
    <li class="active"><?php echo $item->user->full_name.'-'.$item->canine->name; ?></li>
</ul>
<div class="row">
    <div class="col-lg-12">
        <table class="table table-condensed table-bordered">
            <thead>
                <tr class="success">
                    <th>Human</th>
                    <th>Canine</th>
                    <th>Division</th>
                    <th>Place</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr class="info">
                    <td><?php echo $item->user->full_name; ?></td>
                    <td><?php echo $item->canine->name; ?></td>
                    <td><?php echo $item->division->name; ?><?php if($dual == '1') echo ' (Dual)'; ?></td>
                    <td><?php echo form_input('place', $item->place, 'class="form-control" id="place"'); ?></td>
                    <td><?php echo form_input('total', $item->total, 'class="form-control" id="total"'); ?></td>
                </tr>
            </tbody>    
        </table>        
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-sm-6 col-xs-6" id="score-labels">
        <?php if(!empty($labels['tc_labels'])) foreach($labels['tc_labels'] as $tc_label): ?>
        <button class="btn btn-success btn-sm btn-block tc_btn change-button" data-value="<?php echo $tc_label; ?>"><?php echo $tc_label; ?> <i class="icon-plus"></i></button>
        <?php endforeach; ?>
    </div>
    <div class="col-lg-6 col-sm-6 col-xs-6">
        <table id="queue" class="table table-bordered table-condensed table-striped">
            <tbody>
                <?php 
                    for($i=1; $i<=10; $i++) {
                        $class="success";
                        if($i % 2 == 0) {
                            $class="info";
                        }
                        echo '<tr class="'.$class.' score-label">';
                        echo '<td>'.$i.'</td>';
                        echo '<td>';
                        echo '<ul id=cell_1_'.$i.' class="list-inline">';
                        echo '</ul>';
                        echo '<input type="hidden" name="tc_1_'.$i.'" class="form-control tc_1 input-xs" id="tc_1_'.$i.'" /></td>';
                        echo '</tr>';
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-lg-3">
        <label for="calculate_scores">Calculate Scores?</label>
        <select name="calculate_scores" class="form-control">
            <option value="Yes">Yes</option>
            <option value="No">No</option>
        </select>
    </div>
    <div class="col-lg-9">
        <?php echo form_submit('submit', 'Save', 'class="btn btn-cdd pull-right"'); ?>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.tc_btn').click(function(e) {
        e.preventDefault();
        var queue = $('#queue');
        
        val = $(this).attr('data-value');
        if(val) {
            position();
            input = '<li><span class="label label-info">' + val + '</span>';
            input = input + '<div class="dropdown">';
            input = input + ' <a href="#" data-toggle="dropdown" data-position="' + throw_order + '" class="btn btn-xs btn-cdd change-score">Change <i class="icon-refresh"></i></a>';
            input = input + '<ul id="new_' + throw_order + '" class="dropdown-menu" role="menu" aria-labelledby="dLabel">';
            input = input + '</ul>';
            input = input + '</div>';
            input = input + ' <a href="#" data-postition="' + throw_order + '" class="btn btn-xs btn-danger remove-score">Remove <i class="icon-refresh"></i></a>';
            input = input + '</li>';
             
            $('#tc_1_' + throw_order).val(val);
            $('#cell_1_' + throw_order).append(input);
            $('.remove-score').click(function(e) {
                e.preventDefault();
                console.log(this);
                val = $(this).attr('data');
                dp = $(this).attr('data-position');
                $('#score-label_' + val).remove();
                $('#score-input_' + dp).remove();
            });
            $('.change-score').click(function(e) {
                e.preventDefault();
                val = $(this).attr('data-position');
                labels(val);
                $('.change-button').click(function(e) {
                    new_val = $(this).attr('data-value');
                    console.log(new_val);
                });
            });
        }
    }); 
function position() {
    i=1;
    $('.score-label').each(function() {
        value_set = $('#tc_1_'+i).val();
        if(value_set) {
            i++;
        }
        throw_order = i;
    });
}

function labels(position) {
    $('.tc_btn').each(function() {
        val = $(this).attr('data-value');
        li = '<li>';
        li = li + '<a href="" data-position="' + position + '">' + val + '</a>';
        li = li + '</li>';
        if(li) {
            $('#new_' + position).append(li);
            $('.dropdown-toggle').dropdown();

            console.log(li);
        }
    });
  
}

});

</script>