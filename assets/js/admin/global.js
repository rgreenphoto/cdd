/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function() {
    //check to see if we need to initialize footable anywhere on the page
    ftable = $('.footable').attr('class');
    if(ftable) {
        $('.footable').footable();
    }
    //adds bootstrap pagination to pagination
    pagination = $('.page ul').attr('class');
    if(!pagination) {
        $('.page ul').addClass('pagination pagination-sm');
    }       

    $(".confirm").click(function(e) {
        e.preventDefault();
        var targetUrl = $(this).attr("data");
        $('#dialog-confirm').modal('show');
        $("#continue_button").attr("href", targetUrl);

      });
          
    //handles accordian chevron

    $('.accordion').on('show', function() {
       //val = $(this).attr('id').val();
       $(this).find('#chev').removeClass('icon-chevron-down').addClass('icon-chevron-up');
       //$('span #chev').removeClass('icon-chevron-down').addClass('icon-chevron-up');
    });
    // Reverse it for hide:
    $('.accordion').on('hide', function() {
       $(this).find('#chev').removeClass('icon-chevron-up').addClass('icon-chevron-down');
    });
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
                total = $.fn.math('+', current, val);
                $('#total_badge').html(total);
                $('#tc_total_' + round).effect('highlight', 'slow');
                $('#total_badge').effect('highlight', 'slow');
                $('#last_throw_badge').html(val).effect('highlight', 'slow');
            } else {
                $('#last_throw_badge').html(val).effect('highlight', 'slow');
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
});


