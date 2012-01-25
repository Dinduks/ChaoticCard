$(document).ready(function() {
    $("a").click(function() {
        if (!/mailto\:.*/.test($(this).attr('href')) && !/#.*/.test($(this).attr('href'))
            && !$(this).hasClass('target-self')) {
            window.open(this.href, '_blank');
            return false;
        }
    });
    
    
    if ($('#contactForm').length != 0) {
        $('#contactForm').modal({
            keyboard: true,
            backdrop: true,
            show: false
        });

        $('#contactForm .cancel').click(function() {
            $('#contactForm').modal('hide');
            return false;
        });

        $('#contactForm form').submit(function() {
            url     = $(this).attr('action');
            name    = $('#form_name').val();
            email   = $('#form_email').val();
            website = $('#form_website').val();
            subject = $('#form_subject').val();
            message = $('#form_message').val();
            _token  = $('#form__token').val();
            
            $.ajax({
                url: url,
                data: {
                    'form[name]':    name,
                    'form[email]':   email,
                    'form[website]': website,
                    'form[subject]': subject,
                    'form[message]': message,
                    'form[_token]':  _token
                },
                type: 'POST',
                success: function(msg) {
                    if (msg == 'ok') {
                        $('#contactForm').modal('hide');
                        $('#contactFormSuccess').modal('show');
                    } else {
//                        $('#contactForm').html(msg);
                    }
                }
            })
            return false;
        }); 
    }
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
