$(document).ready(function() {
    
    $("#homePage a").click(function() {
        window.open(this.href, '_blank');
        return false;
    });

    $("#content > .top > .websites").vAlign();
    $("#content > .top > .contact").vAlign();
    
    // new email address template
    var emailsToAdd = 1;
    var emailTemplate = '<p>' +
                            '<label>' + translations.email_address + '</label>' +
                            '<input type="text" name="email[]" id="email-${counter}" />' +
                        '</p>' +
                        '<p>' +
                            '<label>' + translations.position + '</label>' +
                            '<input type="text" name="emailPosition[]" id="emailPosition-${counter}" class="position" value="${(counter-1)*5}" />' +
                        '</p>';
    onTheFlyInputs(emailsToAdd, emailTemplate, '.newEmail');
    
    // new phone number template
    var phoneNumberPosition = 0;
    var phoneNumbersToAdd = 1;
    var phoneNumberTemplate = '<p>' +
                                  '<label for="phoneNumber">' + translations.phone_number + '</label>' +
                                  '<input type="text" name="phoneNumber[]" id="phoneNumber-${counter}" />' +
                              '</p>' +
                              '<p>' +
                                  '<label>' + translations.position + '</label>' +
                                  '<input type="text" name="phoneNumberPosition[]" id="phoneNumberPosition-${counter}" class="position" value="${(counter-1)*5}" />' +
                              '</p>';
    onTheFlyInputs(phoneNumbersToAdd, phoneNumberTemplate, '.newPhoneNumber');
    
    // new website template
    var websitesToAdd = 1;
    var websiteTemplate = '<div>' +
                              '<p>' +
                                  '<label for="websiteurl">URL</label>' +
                                  '<input type="text" name="websiteurl[]" id="websiteurl-${counter}" value="http://" />' +
                              '<p>' +
                              '<p>' +
                                  '<label for="websitetitle" class="websitetitleLabel">' + translations.website_title +'</label>' +
                                  '<input type="text" name="websitetitle[]" id="websitetitle-${counter}" />' +
                              '<p>' +
                              '<p>' +
                                  '<label class="websitePositionLabel">' + translations.position + '</label>' +
                                  '<input type="text" name="websitePosition[]" id="websitePosition-${counter}" class="position" value="${(counter-1)*5}" />' +
                              '</p>' +
                          '</div>';
    onTheFlyInputs(websitesToAdd, websiteTemplate, '.newWebsite');
    
    // new link template
    var linksToAdd = 1;
    var linkTemplate = '<div class="aLink aLink-${counter}">' +
                           '<p>' +
                               '<label for="linkurl-${counter}">URL</label>' +
                               '<input type="text" name="linkurl[]" id="linkurl-${counter}" value="http://" />' +
                           '</p>' +
                           '<p>' +
                               '<label for="linktitle-${counter}">' + translations.link_title +'</label>' +
                               '<input type="text" name="linktitle[]" id="linktitle-${counter}" value="" />' +
                           '</p>' +
                           '<p>' +
                               '<label for="linkicon-${counter}">' + translations.icon +' (16x16)</label>' +
                               '<input type="file" name="linkicon[]" id="linkicon-${counter}" />' +
                           '</p>' +
                           '<p>' +
                               '<label>' + translations.position + '</label>' +
                               '<input type="text" name="linkPosition[]" id="linkPosition-${counter}" class="position" value="${(counter-1)*5}" />' +
                           '</p>' +
                       '</div>';
    onTheFlyInputs(linksToAdd, linkTemplate, '.newLink');
    
    $("#firstname").keyup(function() {
        var firstname = $("#firstname").val();
        var cardtitle = $("#cardtitle").val();
        // TODO : Autofill the Title input
    });
    
    // "About me" block's height
    aboutHeight = $("#about").height();
    rightColumnHeight = $("#rightColumn").height();
    if (aboutHeight<rightColumnHeight)
        $("#about").height(rightColumnHeight-20);
    
});

(function ($) {
// VERTICALLY ALIGN FUNCTION
$.fn.vAlign = function() {
    return this.each(function(i) {
    var ah = $(this).height();
    var ph = $(this).parent().height();
    var mh = Math.ceil((ph-ah) / 2);
    $(this).css('margin-top', mh);
    });
};
})(jQuery);

function onTheFlyInputs(counter, template, trigger) {
    $.tmpl(template, {'counter' : counter}).insertBefore(trigger);
    $(trigger + ' > a').click(function(e) {
        counter++;
        $.tmpl(template, {'counter' : counter}).insertBefore(trigger);
        e.preventDefault();
    });
}