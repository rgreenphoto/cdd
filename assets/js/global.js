/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function() {
    $('#myCarousel').carousel(); 
    //handles accordian chevron
    $('.collapse').on('show.bs.collapse', function() {
       val = $(this).attr('data');
       $('#chev_' + val).removeClass('fa fa-plus').addClass('fa fa-minus');
       //$('span #chev').removeClass('icon-chevron-down').addClass('icon-chevron-up');
    });
    // Reverse it for hide:
    $('.collapse').on('hide.bs.collapse', function() {
       val = $(this).attr('data');
       $('#chev_' + val).removeClass('fa fa-minus').addClass('fa fa-plus');
    });
    
//    //check to see if footable to present
//    var table = $('table').attr('class');
//    if(table && table.contains('footable')) {
//        $('.footable').footable();
//    }
});

