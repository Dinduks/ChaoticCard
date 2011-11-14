$(document).ready(function(){
    
    $("#homePage a").click(function(){
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
    
    // about me template
    var aboutMeToAdd = 1;
    var aboutMeTemplate = '<p>' + 
                              '<label for="about-language-${counter}">' + translations.language + '</label>' + 
                              '<input type="text" class="about-language about-language-${counter}" id="about-language-${counter}" name="about-language[]" value="" maxlength="2" />' + 
                              '<label for="about-content-${counter}">' + translations.text + '</label>' + 
                              '<textarea class="about-content about-content-${counter}" id="about-content-${counter}" name="about-content[]" cols="1" rows="1"></textarea>' + 
                          '</p>';
    onTheFlyInputs(aboutMeToAdd, aboutMeTemplate, '.newAboutMe');
    
//    var cardTitleToAdd = 1;
//    var cardTitleTemplate = '<span>' + 
//                                '<input type="text" class="cardTitle-lang cardTitle-lang-${counter}" name="cardTitle-lang[]" />' + 
//                                '<input type="text" class="cardTitle-content cardTitle-content-${counter}" name="cardTitle-content[]" />' + 
//                            '</span>';
//    onTheFlyInputs(cardTitleToAdd, cardTitleTemplate, '.newCardTitle');
    
    var cardSecondaryTitleToAdd = 1;
    var cardSecondaryTitleTemplate = '<p>' + 
                                        '<label style="width:20px;">' + translations.language + '</label>' +
                                        '<input type="text" class="secondaryTitle-lang secondaryTitle-lang-${counter}" name="secondaryTitle-lang[]" />' + 
                                        '<br />' +
                                        '<label style="width:20px;">' + translations.text + '</label>' +
                                        '<input type="text" class="secondaryTitle-content secondaryTitle-content-${counter}" name="secondaryTitle-content[]" />' + 
                                        '' + 
                                     '</p>';
    onTheFlyInputs(cardSecondaryTitleToAdd, cardSecondaryTitleTemplate, '.newSecondaryTitle');
    
    $("#firstname").keyup(function(){
        var firstname = $("#firstname").val();
        var lastname = $("#lastname").val();
        $("#cardtitle").val(firstname + ' ' + lastname);
    });
    
    $("#lastname").keyup(function(){
        var firstname = $("#firstname").val();
        var lastname = $("#lastname").val();
        $("#cardtitle").val(firstname + ' ' + lastname);
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

function onTheFlyInputs(counter, template, trigger){
    $.tmpl(template, {'counter' : counter}).insertBefore(trigger);
    $(trigger + ' > a').click(function(e) {
        counter++;
        $.tmpl(template, {'counter' : counter}).insertBefore(trigger);
        e.preventDefault();
    });
}