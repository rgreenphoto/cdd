/*====================/

jQuery Math
Russ Green
http://www.mikedoesweb.com
A Jquery Plugin to do basic match and insert it into an input element
(c) 2014

=====================*/

(function($) {
    $.fn.math = function(operation, a, b) {
        switch(operation) {
            case '+':
                result = (Number(a) + Number(b));
                break;
            case '-':
                result = (Number(a) - Number(b));
                break;
            case '*':
                result = (Number(a) * Number(b));
                break;
            case '/':
                if(b !== 0) {
                    result = (Number(a) / Number(b));
                } else {
                    result = "undefined";
                }
                break;
        }

        if(result == 0) {
            result = 0.0;
        }

        $(this).val(result);
        return result;
    };  
})(jQuery);