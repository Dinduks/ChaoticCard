$(document).ready(function() {
    
    $("a").click(function() {
        if (!/mailto\:.*/.test($(this).attr('href'))
         && !$(this).hasClass('target-self')) {
            window.open(this.href, '_blank');
            return false;
        }
    });
    
});

(function ($) {
// VERTICALLY ALIGN FUNCTION
$.fn.vAlign = function(){
    return this.each(function(i){
    var ah = $(this).height();
    var ph = $(this).parent().height();
    var mh = Math.ceil((ph-ah) / 2);
    $(this).css('margin-top', mh);
    });
};

/**
 * This function is from the Konami Code Plugin
 * http://www.gethifi.com/blog/konami-code-jquery-plugin-pointlessly-easy
 */
$.fn.konami = function(callback, code) {
    if(code == undefined) code = "38,38,40,40,37,39,37,39,66,65";

    return this.each(function() {
        var kkeys = [];
        $(this).keydown(function(e){
            kkeys.push( e.keyCode );
            if ( kkeys.toString().indexOf( code ) >= 0 ){
                $(this).unbind('keydown', arguments.callee);
                callback(e);
            }
        });
    });
}
})(jQuery);
