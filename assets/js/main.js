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
                $('#fo' +
                    'llow-area').html(data.content);
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
                    if (follow_change.hasClass("icon-weight")) {
                        follow_change.children("i").css("font-weight", "900");
                    }
                }
            }, 'json');
        } else if ($(this).hasClass("remove")) {
            $.post('ajax/follow.php', {remove: 1, id_Channel: $(this).attr('id')}, function (data) {
                if (data.error === "") {
                    follow_change.css('background-color', '#646464');
                    follow_change.removeClass("remove");
                    follow_change.addClass("add");
                    reload_follower();
                    if (follow_change.hasClass("icon-weight")) {
                        follow_change.children("i").css("font-weight", "400");
                    }
                }
            }, 'json');
        }
    });

    $(".search-area").on("keyup", null, null, function () {
        let search_value = $(this).val();
        $.post('ajax/search.php', {search_value: search_value}, function (data) {
            if (data.error === "") {
                if ($('#search-result').html() !== "data.content") {
                    $('#search-result').html(data.content);
                }
            } else {
                $('#search-result').empty();
            }
        }, 'json')

    });

    $('.filter-block').on("click", null, null, function () {
        if ($(this).hasClass("priority-in")) {
            $(this).removeClass("priority-in");
            $(this).children(".default-item").removeClass("active-item");
        } else {
            $(this).addClass("priority-in");
            $(this).children(".default-item").addClass("active-item");
        }
    });

    $('.filtering').on("click", null, null, function (event) {
        let id_filter = $(this).attr('data-id');
        let search_value = getUrlParameter("s");
        let this_element = $(this);
        event.preventDefault();
        event.stopPropagation();
        $.post('ajax/search_page.php', {
            id_filter: id_filter, search_value: search_value
        }, function (data) {
            if (data.error === "") {
                $('#beeteam368_main-search-page').html(data.content);
                $('#number_elements').html(" There are " + data.number + " items in this page ");
                $('.selected-filter').removeClass('selected-filter');
                $('.filtering').eq(parseInt(id_filter) + 1).addClass('selected-filter');
                $('#principal_filter').html(data.principal);
            }
        }, 'json')
    });

    $(".beeteam368-global-open-popup-control").on('click', null, null, function () {
        $(".beeteam368-global-popup").addClass('active-item');
    });

    $(".beeteam368-popup-close-control").on('click', null, null, function () {
        $(".beeteam368-global-popup").removeClass('active-item');
    });

    $('.form-submit-add-control').on('submit', null, null, function (event) {
        event.preventDefault();
        let formData = new FormData(this);
        $.ajax({
            url: 'ajax/create.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (data) {
                if (data.error === "") {
                    window.location.href = "channel.php?id=" + data.id;
                } else {
                    console.log(data.error);
                    $('#alert_popup').html(data.error);
                    $('.form-submit-add-alerts').css('display', 'block');
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });

    $('#create_channel').on('click', null, null, function () {
        $('.form-submit-add-control').trigger('submit');
    });

    $('#channel_image').on('change', null, null, function (event) {
        let image = $('.beeteam368_media_upload ');
        let url = URL.createObjectURL(event.target.files[0]);
        image.css('background-image', 'url(' + url + ')');
        image.css('background-repeat', 'no-repeat');
        image.css('background-size', 'contain');
        image.css('background-position', 'center');
        $('#upload_icon').css('opacity', '0');
        $('.text-upload-dd').css('opacity', '0');
    });

    $('#logout-button').on('click', null, null, function () {
        window.location.href = "logout.php";
    });

    $('.live-button').on('click', null, null, function () {
        let live_button = $(this);
        let name_stream = $('#streamName').val();
        let desc_stream = $('#streamDesc').val();
        let game_stream_id = $('#streamGames').val();
        let is_record = 0;
        if ($('#is_record').is(':checked')) {
            is_record = 1;
        }
        let id_channel = $(this).data('id');
        if (live_button.hasClass("go-live")) {
            $.post("ajax/live.php", {
                start: 1,
                nameStream: name_stream,
                descStream: desc_stream,
                gameId: game_stream_id,
                isRecord: is_record,
                idChannel: id_channel
            }, function (data) {
                if (data.error === "") {
                    live_button.children('span').html("Stop Live");
                    live_button.removeClass("go-live");
                    live_button.addClass("stop-live");
                    $('#streamName').prop("disabled", true);
                    $('#streamDesc').prop("disabled", true);
                    $('#streamGames').prop("disabled", true);
                    $('#is_record').prop("disabled", true);
                    $('#streamKey').prop("disabled", false);
                    $('#streamKey')[0].type = 'password';
                    $('#streamKey').prop("disabled", true);
                }
            }, 'json');
        } else if (live_button.hasClass("stop-live")) {
            $.post("ajax/live.php", {stop: 1, idChannel: id_channel}, function (data) {
                if (data.error === "") {
                    live_button.children('span').html("Go Live");
                    live_button.removeClass("stop-live");
                    live_button.addClass("go-live");
                    $('#streamName').prop("disabled", false);
                    $('#streamDesc').prop("disabled", false);
                    $('#streamGames').prop("disabled", false);
                    $('#is_record').prop("disabled", false);
                    $('#streamKey').prop("disabled", false);
                    $('#streamKey')[0].type = 'text';
                    $('#streamKey').prop("disabled", true);
                    $('#streamName').val('');
                    $('#streamDesc').val('');
                    $('#is_record').prop('checked',false);
                    $('#streamGames').val('0');
                }
            }, 'json');
        }
    });

    function reload_follower() {
        $('#follow-area').empty();
        $('#follow-area').append(loader);
        $('#follow-area').css('text-align', 'center');
        $.post('ajax/load-more.php', {recommended: 1, followed: 1, count: 0, flag: 0}, function (data) {
            if (data.content !== "" || data.flag === 1) {
                $('#follow-area').empty();
                $('#follow-area').css('text-align', 'left');
                $('#follow-area').html(data.content);
                $('#recommend-area').empty();
                $('#recommend-area').css('text', 'left');
                $('#recommend-area').html(data.recommend);
            }
        }, 'json');
    }

    $('.tab-item').on('click', null, null, function (){
        if ($(this).attr('title') === "Stream"){
            $(".channel-content").hide();
            $(".is-tab-content-stream").show();
        }
        if ($(this).attr('title') === "Videos"){
            $(".channel-content").hide();
            $(".is-tab-content-videos").show();
        }
        $(".active-item").removeClass("active-item");
        $(this).addClass("active-item");
    });
});

let getUrlParameter = function getUrlParameter(sParam) {
    let sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
    return false;
};