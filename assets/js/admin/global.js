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
    $('#dialog-confirm').modal({
        show: false,
        keyboard: false
    });
        $(".confirm").click(function(e) {
            e.preventDefault();
            var targetUrl = $(this).attr("href");

            $("#dialog-confirm").modal({
                show: true
            });    
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
        
        //fixes header drop down
//        $('body').on('touchstart.dropdown', '.dropdown-menu', function (e) {e.stopPropagation();}).on('touchstart.dropdown', '.dropdown-submenu', function (e) {e.preventDefault();});        

    //datepicker for anything with class .datepicker
        $(".datepicker").datepicker({
            format: 'yyyy-mm-dd'
        });
        
   });  


