$(document).ready(function(){
    $("#homePage a").click(function(){
        window.open(this.href, '_blank');
        return false;
    });

    $("#content > .top > .websites").vAlign();
    $("#content > .top > .emails").vAlign();
    
    // new email address template
    var emailsToAdd = 1;
    var emailTemplate = '<p>' +
                            '<label>&nbsp;</label>' +
                            '<input type="text" name="email[]" id="email-${counter}" />' +
                        '</p>';
    onTheFlyInputs(emailsToAdd, emailTemplate, '.newEmail');
    
    // new phone number template
    var phoneNumbersToAdd = 1;
    var phoneNumberTemplate = '<p>' +
                                   '<label for="phoneNumber">&nbsp;</label>' +
                                   '<input type="text" name="phoneNumber[]" id="phoneNumber-${counter}" value="" />' +
                              '</p>';
    onTheFlyInputs(phoneNumbersToAdd, phoneNumberTemplate, '.newPhoneNumber');
    
    // new website template
    var websitesToAdd = 1;
    var websiteTemplate = '<p>' +
                               '<label for="website">&nbsp;</label>' +
                               '<input type="text" name="website[]" id="website-${counter}" value="" />' +
                          '</p>';
    onTheFlyInputs(websitesToAdd, websiteTemplate, '.newWebsite');
    
    // new link template
    var linksToAdd = 1;
    var linkTemplate = '<div class="aLink-${counter}">' +
                           '<p>' +
                               '<label for="linkurl-${counter}">URL</label>' +
                               '<input type="text" name="linkurl[]" id="linkurl-${counter}" value="http://" />' +
                           '</p>' +
                           '<p>' +
                               '<label for="linktitle-${counter}">Link title</label>' +
                               '<input type="text" name="linktitle[]" id="linktitle-${counter}" value="" />' +
                           '</p>' +
                           '<p>' +
                               '<label for="linkicon-${counter}">Icon (16x16)</label>' +
                               '<input type="file" name="linkicon[]" id="linkicon-${counter}" />' +
                           '</p>' +
                       '</div>';
    onTheFlyInputs(linksToAdd, linkTemplate, '.newLink');
});

(function ($) {
// VERTICALLY ALIGN FUNCTION
$.fn.vAlign = function() {
    return this.each(function(i){
    var ah = $(this).height();
    var ph = $(this).parent().height();
    var mh = Math.ceil((ph-ah) / 2);
    $(this).css('margin-top', mh);
    });
};
})(jQuery);

function onTheFlyInputs(counter, template, trigger) {
    $.tmpl(template, {'counter' : counter}).insertBefore(trigger);
    $(trigger + ' > a').click(function(e){
        counter++;
        $.tmpl(template, {'counter' : counter}).insertBefore(trigger);
        e.preventDefault();
    });
}