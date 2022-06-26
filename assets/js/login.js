$(function () {
    $('.submit-btn').on('click', null, null, function () {
        let username = $('#username').val();
        let password = $('#password').val();
        if ($(this).hasClass('register')) {
            let usernameR = $('#usernameR').val();
            let confirm = $('#confirmpassword').val();
            let password = $('#passwordR').val();
            let email = $('#email').val();
            $.post('ajax/register.php',
                {
                    email: email,
                    password: password,
                    username: usernameR,
                    confirm: confirm,
                    captchaResponse: grecaptcha.getResponse()
                }, function (data) {
                    if (data.error !== "") {
                        $('#error').html('<b>' + data.error + '</b>');
                        $('#error-div').show();
                        $('#error-message-div').show('slow');
                        $('html, body').animate({scrollTop: 0}, 'slow');
                        return;
                    }
                    // if (id !== false) {
                    //     window.location.href = "login-register.php?id=" + id;
                    // } else {
                        window.location.href = "login-registration.php";
                    // }
                }, 'json');
            return;
        }
        $.post('ajax/login.php',
            {
                username: username,
                password: password,
                captchaResponse: grecaptcha.getResponse()
            }, function (data) {
                if (data.error !== "") {
                    $('#error').html('<b>' + data.error + '</b>');
                    $('#error-div').show();
                    $('#error-message-div').show('slow');
                    $('html, body').animate({scrollTop: 0}, 'slow');
                    return;
                }
                // if (id !== false) {
                //     // window.location.href = "product-details.php?id=" + id;
                // } else {
                    window.location.href = "index.php";
                // }
            }, 'json');
    });
    $('.register_switch').on('click', null, null, function () {
        $('#login').hide('slow');
        $('.captchaL').empty();
        $('.captchaR').append('<div class="g-recaptcha" data-sitekey="6Lcb2w0gAAAAAHuidaQ1moOAE1l5OAHobm1SDnYS" data-theme="dark"></div>');
        reload_js('https://www.google.com/recaptcha/api.js');
        $('#error').html('');
        $('#error-div').hide();
        $('#register').show('slow');
    });

    $('.login_switch').on('click', null, null, function () {
        $('#register').hide('slow');
        $('.captchaR').empty();
        $('.captchaL').append('<div class="g-recaptcha" data-sitekey="6Lcb2w0gAAAAAHuidaQ1moOAE1l5OAHobm1SDnYS" data-theme="dark"></div>');
        reload_js('https://www.google.com/recaptcha/api.js');
        $('#error').html('');
        $('#error-div').hide();
        $('#login').show('slow');
    });

    // let getUrlParameter = function getUrlParameter(sParam) {
    //     let sPageURL = window.location.search.substring(1),
    //         sURLVariables = sPageURL.split('&'),
    //         sParameterName,
    //         i;
    //
    //     for (i = 0; i < sURLVariables.length; i++) {
    //         sParameterName = sURLVariables[i].split('=');
    //
    //         if (sParameterName[0] === sParam) {
    //             return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
    //         }
    //     }
    //     return false;
    // };

    function reload_js(src) {
        $('script[src="' + src + '"]').remove();
        $('<script>').attr('src', src).appendTo('head');
    }
});