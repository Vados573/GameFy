$(function () {
    let open_close_button = $('.open-close');
    let open_close_button_mobile = $('.open-close-bis');
    let sub_menu_mobile = $('ul.menu-items-lyt-control > li');
    let loader = "<img src='assets/images/loader_dark.gif' width='100px'>";
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

    $('.beeteam368-is-login-member').on('click', null, null, function () {
        if ($(this).hasClass('active-item')) {
            $(this).removeClass('active-item');
        } else {
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

    $('.load-more').on('click', null, null, function () {
        let count = $(this).data('count');
        if ($(this).hasClass('following')) {
            $('#follow-area').empty();
            $('#follow-area').append(loader);
            $('#follow-area').css('text-align', 'center');
            $.post('ajax/load-more.php', {
                followed: 1,
                count: count
            }, function (data) {
                $('#follow-area').empty();
                $('#follow-area').css('text-align', 'left');
                $('#follow-area').html(data.content);
                $(this).data('count', count++);
                if (data.error !== "") {
                    $('.following').hide();
                }
            }, 'json');
        } else if ($(this).hasClass('recommended')) {
            $('#recommend-area').empty();
            $('#recommend-area').append(loader);
            $('#recommend-area').css('text-align', 'center');
            $.post('ajax/load-more.php', {
                recommended: 1,
                count: count
            }, function (data) {
                $('#recommend-area').empty();
                $('#recommend-area').css('text-align', 'left');
                $('#recommend-area').html(data.recommend);
                $(this).data('count', count++);
                if (data.error !== "") {
                    $('.recommended').hide();
                }
            }, 'json');
        }
    });

    $(".follow-change").on("click", null, null, function () {
        let follow_change = $(this);
        if ($(this).hasClass("add")) {
            $.post('ajax/follow.php', {add: 1, id_Channel: $(this).attr('id')}, function (data) {
                if (data.error === "") {
                    follow_change.removeClass("add");
                    follow_change.addClass("remove");
                    follow_change.css('background-color', '#FF375F');
                    reload_follower();

                }
            }, 'json');
        } else if ($(this).hasClass("remove")) {
            $.post('ajax/follow.php', {remove: 1, id_Channel: $(this).attr('id')}, function (data) {
                if (data.error === "") {
                    follow_change.css('background-color', '#646464');
                    follow_change.removeClass("remove");
                    follow_change.addClass("add");
                    reload_follower();
                }
            }, 'json');
        }
    });
    function reload_follower(){
        $('#follow-area').empty();
        $('#follow-area').append(loader);
        $('#follow-area').css('text-align', 'center');
        $.post('ajax/load-more.php', {recommended: 1, followed: 1, count: 0, flag: 0}, function (data){
            if (data.content !== "" || data.flag === "1") {
                $('#follow-area').empty();
                $('#follow-area').css('text-align', 'left');
                $('#follow-area').html(data.content);
            }
        }, 'json');
    }

    $(".search-area").on('change', null, null, function(){
        let search_value = $(this).val();
        $.post('ajax/search.php', {search_value:search_value}, function (data){
            if (data.error === ""){

            }
        }, 'json')

    });
});