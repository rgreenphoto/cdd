/**
 * Created by Russ Green on 6/24/14.
 *
 * This includes events and functions for the events. This calculates the scored for the front end.
 *
 * This module depends on assets/js/jmath.js
 *
 *
 */

jQuery(document).ready(function($) {
    //click event to remove TC score
    $('.remove-score').click(function(e) {
        e.preventDefault();
        round = $('#round').val();
        position = $(this).attr('data-position');
        $.fn.removeTCScore(round, position);
    });

    //click event to add TC score
    $('.tc_btn').click(function(e) {
        e.preventDefault();
        score = $(this).attr('data-value');
        round = $('#round').val();
        if(score && round) {
            $('#last_entered_score').html(score);
            $('#scoreConfirm').attr('href', 'javascript:$.fn.calculateTCScore('+score+', '+round+')');
            $('#scoreModal').modal('show');
        }
    });

    //change event to calc FS scores
    $('.fs_score').change(function() {
       round = $(this).attr('round');
       if(round) {
           $.fn.calculateFSScore(round);
       }
    });
});


(function($) {
    $.fn.calculateFSScore = function(round) {
        fs_1 = Number($('#fs_1_'+ round).val());
        fs_2 = Number($('#fs_2_'+ round).val());
        fs_3 = Number($('#fs_3_'+ round).val());
        fs_4 = Number($('#fs_4_'+ round).val());
        fs_5 = Number($('#fs_5_'+round).val());
        deduct = $('#deduct_'+ round).val();
        fs_total = (fs_1 + fs_2 + fs_3 + fs_4 + fs_5);
        total = (fs_total - deduct);
        new_total = Math.round(total*10)/10;
        $('#fs_total_'+ round).val(new_total);
    };


    $.fn.calculateTCScore = function(val, round) {
        throw_order = $.fn.position(round);
        $('#last_entered_score').html(val);
        $('#label_' + throw_order).text(val);
        $('#tc_' + round + '_' + throw_order).val(val);
        new_label = $('#focus_target_'+ round +'_' + throw_order).attr('class');
        if(new_label === 'danger score-label') {
            new_label = 'active score-label';
        }
        $('#focus_target_'+ round +'_' + throw_order).show().removeClass().addClass(new_label);
        $.fn.total(val, round);
        $('#scoreModal').modal('hide');
    };


    $.fn.position = function (round) {
        var i=1;
        $('.score-label').each(function() {
            value_set = $('#tc_' + round + '_'+i).val();
            if(value_set) {
                i++;
            }
        });
        $('#focus_target_'+ round +'_'+(i - 1)).removeClass().addClass('active score-label');
        return i;
    };

    $.fn.total = function(val, round) {
        var current = $('#tc_total_'+ round).val();
        if(!current) {
            current = 0;
        }
        if($.isNumeric(val) && $.isNumeric(current)) {
            $('#tc_total_' + round).math('+', current, val);
            total = $.fn.math('+', current, val);
            $('#total_badge').html(total);
            $('#tc_total_' + round).effect('highlight', 'slow');
            $('#total_badge').effect('highlight', 'slow');
            $('#last_throw_badge').html(val).effect('highlight', 'slow');
        } else {
            $('#last_throw_badge').html(val).effect('highlight', 'slow');
            $('#tc_total_' + round).math('+', current, '0.0');
        }
    };

    $.fn.removeTCScore = function(round, position) {
        previous_value = $('#tc_' + round +'_' + position).val();
        previous_total = $('#tc_total_'+ round).val();
        $('#tc_' + round + '_' + position).val('');
        if($.isNumeric(previous_value) && $.isNumeric(previous_total)) {
            $('#tc_total_' + round).math('-', previous_total, previous_value);
        } else {
            $('#tc_total_' + round).val('0.0');
        }
        $('#focus_target_'+round+'_' + position).removeClass().addClass('danger score-label');
    }


})(jQuery);