$(document).ready(function(){
    
    $("a").click(function(){
        if (!/mailto\:.*/.test($(this).attr('href'))
            || !/target\-self.*/.test($(this).attr('class')
            ) {
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
})(jQuery);
