/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function() {
    $('#myCarousel').carousel(); 
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
    
//    //check to see if footable to present
//    var table = $('table').attr('class');
//    if(table && table.contains('footable')) {
//        $('.footable').footable();
//    }
});

