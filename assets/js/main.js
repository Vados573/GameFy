$(function () {
    let open_close_button = $('.open-close');
    let open_close_button_mobile = $('.open-close-bis');
    let sub_menu_mobile = $('ul.menu-items-lyt-control > li');
    open_close_button.on('click', null, null, function () {
        if (open_close_button.hasClass('open')) {
            open_close_button.removeClass('open');
            document.body.style.setProperty('--width__side-menu-hide', '250px');
            $('.layer-hidden').show();
            $('.layer-show').css('width', 'auto');
            $('.os-content').css('padding', '3px 25px 25px');
            $('#side-menu-navigation').show();
            $('.sidemenu-sidebar').show();
            $('.side-menu-close').hide();
            $('.side-menu-open').show();
        } else {
            open_close_button.addClass('open');
            document.body.style.setProperty('--width__side-menu-hide', '60px');
            $('.layer-hidden').hide();
            $('.layer-show').css('width', 'var(--width__side-menu-hide)');
            $('.os-content').css('padding', '3px 0 25px');
            $('#side-menu-navigation').hide();
            $('.sidemenu-sidebar').hide();
            $('.side-menu-close').show();
            $('.side-menu-open').hide();
        }
    });
    open_close_button_mobile.on('click', null, null, function () {
        if (open_close_button_mobile.hasClass('open')) {
            console.log('test 2')
            open_close_button_mobile.removeClass('open');
            $('html').addClass('mobile-active');
            $('.oc-mb-mn-btn').addClass('active');
        } else {
            open_close_button_mobile.addClass('open');
            $('html').removeClass('mobile-active');
            $('.oc-mb-mn-btn').removeClass('active');
        }
    });
    sub_menu_mobile.on('click', null, null, function (event) {
        $(this).toggleClass('active-sub-menu');
        event.preventDefault();
    });

    $('.beeteam368-is-login-member').on('click', null, null, function (){
       if ($(this).hasClass('active-item')){
           $(this).removeClass('active-item');
       }
       else{
           $(this).addClass('active-item');
       }
    });
    // slide(0, 0);
    // function slide(count, flag ) {
    //     let seconds = 5; // Time to move to next slide
    //     seconds = seconds * 1000;
    //     let number_post = $(".slider-count").length;
    //     number_post = number_post - 1;
    //     console.log(count + ' ' + number_post + ' ' + flag);
    //     if (flag === 0) {
    //         count++;
    //         setTimeout(function () {
    //             $('.slider-button-next').trigger("click");
    //             if (count === number_post) {
    //                 flag = 1;
    //             }
    //             if (count === 0) {
    //                 flag = 0;
    //             }
    //             slide(count, flag);
    //         }, seconds);
    //     } else {
    //         setTimeout(function () {
    //             $('.slider-button-prev').trigger("click");
    //             if (count === number_post) {
    //                 flag = 1;
    //             }
    //             if (count === 0) {
    //                 flag = 0;
    //             }
    //             slide(count, flag);
    //         }, seconds);
    //         count--;
    //     }
    // } TODO improve this function
});