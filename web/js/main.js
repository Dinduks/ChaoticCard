$(document).ready(function(){
    
    $("#content > .top > .websites").vAlign();
    $("#content > .top > .contact").vAlign();
    
    $("#homePage a").click(function(){
        if (!/mailto\:.*/.test($(this).attr('href'))) {
            window.open(this.href, '_blank');
            return false;
        }
    });
    
    // "About me" block's height
    aboutHeight = $("#about").height();
    rightColumnHeight = $("#rightColumn").height();
    if (aboutHeight<rightColumnHeight)
        $("#about").height(rightColumnHeight-20);
    
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
