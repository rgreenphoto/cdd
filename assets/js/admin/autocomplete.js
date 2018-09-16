/* 
 * Used to perform a User search. Takes data attributes from search input to creates the link to actions
 * var source = the url to search against
 * var result_link = the link to use when creating results
 * var ajax = if ajax return for result link this is the div to load, else window.location
 */
$(document).ready(function() {
    var source = $('#filter').attr('data-source');
    var result_link = $('#filter').attr('data-link');
    var ajax = $('#filter').attr('data-ajax');
    $('#filter').autocomplete({
       source: source,
       minLength: 2,
       select: function (event, ui) {
           url = result_link  + '/' + ui.item.id;
           if(ajax) {
               $('#ajax-loader').show();
               $(ajax).load(url, function() {
                   $('#ajax-loader').hide();
                   display = $('#user-edit').attr('style');
                   if(display === 'display: none;') {
                       $('#user-edit').toggle();
                   }
               });
           } else {
               window.location = url;
           }
       }
    }).data("ui-autocomplete")._renderItem = function(ul, item) {
       return $("<li>").append("<a>" + item.first_name + " " + item.last_name + "</a>").appendTo(ul);
    }; 
});

