<?php
require('includes/config.php');
require('includes/global_functions.php');
session_start();
?>
<html lang="en">
<head>
    <title>Gamify</title>
    <?php require('includes/head.php');
    ?>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="assets/css/main.css">

</head>
<!--oncontextmenu="return false"-->
<body>
<?php require('includes/sidebar.php'); ?>
<div id="beeteam368-site-wrap-parent" class="beeteam368-site-wrap-parent beeteam368-site-wrap-parent-control">
    <?php require('includes/header.php'); ?>
    <?php
    $sql = "SELECT count(*) as counter FROM channel WHERE is_live = 1";
    $result = odbc_exec($con, $sql);
    $num_rows = odbc_fetch_object($result);
    $num_rows = $num_rows->counter;
    if ($num_rows != 0) {
    ?>
    <article id="post-19" class="post-19 page type-page status-publish hentry">
        <div class="entry-content">
            <div data-elementor-type="wp-page" data-elementor-id="19" class="elementor elementor-19">
                <section
                        class="elementor-section elementor-top-section elementor-element elementor-element-7c5b8a8 elementor-section-full_width elementor-section-height-default elementor-section-height-default"
                        data-id="7c5b8a8" data-element_type="section">
                    <div class="elementor-container elementor-column-gap-no">
                        <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-c176166"
                             data-id="c176166" data-element_type="column">
                            <div class="elementor-widget-wrap elementor-element-populated">
                                <div class="elementor-element elementor-element-7075459 hide-heading-control elementor-widget elementor-widget-beeteam368_slider_addon"
                                     data-id="7075459" data-element_type="widget"
                                     data-widget_type="beeteam368_slider_addon.default">
                                    <div class="elementor-widget-container">
                                        <div class="top-section-title ">
                                            <h2 class="h1 h3-mobile main-title-heading">
                                                <span class="main-title">Top Videos</span> <span
                                                        class="hd-line"></span>
                                            </h2>
                                        </div>
                                        <div class="beeteam368-slider-container container-silder-style-cyclamen ">
                                            <div id="beeteam368_slider_168101654796201"
                                                 class="swiper slider-larger swiper-initialized swiper-horizontal swiper-pointer-events swiper-backface-hidden">
                                                <div class="swiper-wrapper" id="swiper-wrapper-5b109653102af4e772"
                                                     aria-live="polite">
                                                    <?php
                                                    if (isset($_SESSION['id'])) {
                                                        $sql = "SELECT channel.followers_channel, channel.name_channel, channel.id_channel, 
                                                            stream.id_stream, game.name_game, stream.views_stream, stream.name_stream,
                                                            CASE
                                                                WHEN " . $_SESSION['id'] . " IN (SELECT id_user FROM follow WHERE follow.id_channel = channel.id_channel) THEN 1
                                                                ELSE 0
                                                            END AS Following
                                                            FROM stream 
                                                            JOIN channel ON channel.id_channel = stream.id_channel
                                                            JOIN game ON stream.id_game = game.id_game 
                                                            WHERE is_live_stream = 1
                                                            ORDER BY channel.followers_channel DESC";
                                                    } else {
                                                        $sql = "SELECT channel.followers_channel, channel.name_channel, channel.id_channel, 
                                                            stream.id_stream, game.name_game, stream.views_stream, stream.name_stream
                                                            FROM stream 
                                                            JOIN channel ON channel.id_channel = stream.id_channel
                                                            JOIN game ON stream.id_game = game.id_game 
                                                            WHERE is_live_stream = 1
                                                            ORDER BY channel.followers_channel DESC";
                                                    }
                                                    $result = odbc_exec($con, $sql);
                                                    $counter = 0;
                                                    $slider = "";
                                                    while ($table = odbc_fetch_object($result)) {
                                                        if ($counter == 8) {
                                                            break;
                                                        }
                                                        if ($counter == 0) {
                                                            $slider = "swiper-slide-active";
                                                        } elseif ($counter == 1) {
                                                            $slider = "swiper-slide-next";
                                                        }
                                                        $fileName = $_SERVER["DOCUMENT_ROOT"] . "/GameFy/" . PATH_IMG_CHANNEL . $table->id_channel . ".jpeg";
                                                        if (file_exists($fileName)) {
                                                            $path = PATH_IMG_CHANNEL . $table->id_channel . ".jpeg";
                                                        } else {
                                                            $path = "https://i.pinimg.com/originals/3e/f1/d4/3ef1d460e6bb89eaa7d2fcf283795191.jpg";
                                                        }
                                                        $views = getMinNumber(intval($table->views_stream));
                                                        $followers = getMinNumber(intval($table->followers_channel));
                                                        ?>
                                                        <div class="swiper-slide <?php echo $slider ?>"
                                                             style="width: 1860px;"
                                                             role="group">
                                                            <article
                                                                    class="post-item flex-vertical-middle slider-preview-control"
                                                                    style="background-image: url(<?php echo $path ?>);">
                                                                <div class="post-item-wrap site__container main__container-control site__container-fluid">
                                                                    <div class="site__row">
                                                                        <div class="site__col">
                                                                            <div class="slider-content">
                                                                                <div class="posted-on ft-post-meta font-meta font-meta-size-12 flex-row-control">
                                                                                    <div class="post-lt-ft-left flex-row-control flex-vertical-middle">
                                                                                        <div class="post-footer-item post-lt-comments post-lt-comment-control">
                                                                                            <?php
                                                                                            if (!isset($_SESSION['id'])) {
                                                                                                ?>
                                                                                                <span class="beeteam368-icon-item small-item"
                                                                                                      style="background-color: #646464; cursor: default"
                                                                                                      id="<?php echo $table->id_channel ?>"><i
                                                                                                            class="fas fa-heart"></i></span>
                                                                                                <?php
                                                                                            } else {
                                                                                                if ($table->Following == 0) {
                                                                                                    ?>
                                                                                                    <span class="beeteam368-icon-item small-item follow-change add"
                                                                                                          style="background-color: #646464"
                                                                                                          id="<?php echo $table->id_channel ?>"><i
                                                                                                                class="fas fa-heart"></i></span>
                                                                                                    <?php
                                                                                                } else {
                                                                                                    ?>
                                                                                                    <span class="beeteam368-icon-item small-item follow-change remove"
                                                                                                          style="background-color: #FF375F"
                                                                                                          id="<?php echo $table->id_channel ?>"><i
                                                                                                                class="fas fa-heart"></i></span>
                                                                                                    <?php
                                                                                                }
                                                                                            }
                                                                                            ?>
                                                                                            <span
                                                                                                    class="item-number"><?php echo $followers ?></span>
                                                                                            <span class="item-text">Followers</span>
                                                                                        </div>
                                                                                        <span class="post-footer-item post-lt-views post-lt-views-control">
<span class="beeteam368-icon-item small-item"><i
            class="fas fa-eye"></i></span><span class="item-number"><?php echo $views ?></span>
<span class="item-text">viewers</span>
</span></div>
                                                                                </div>
                                                                                <h3 class="entry-title post-title max-2lines ">
                                                                                    <a class="post-listing-title"
                                                                                       href="#"
                                                                                       title="<?php echo $table->name_stream ?>"><?php echo $table->name_stream ?></a>
                                                                                </h3>
                                                                                <span class="entry-title post-title max-2lines"
                                                                                      style="font-size: 20px; font-family: var(--font__heading);">
                                                                                Channel: <b><?php echo $table->name_channel ?></b>
                                                                            </span>
                                                                                <span class="entry-title post-title max-1lines"
                                                                                      style="font-size: 15px; font-family: var(--font__heading);">
                                                                                Game: <b><?php echo $table->name_game ?></b>
                                                                            </span>
                                                                                <div class="btn-slider-pro">
                                                                                    <a href="#"
                                                                                       class="btnn-default btnn-primary"><i
                                                                                                class="icon far fa-play-circle"></i><span>Watch NOW</span></a>
                                                                                    <button class="reverse slider-preview preview-mode-control"
                                                                                            data-id="117">
                                                                                        <i class="icon far fa-eye"></i><span>Preview</span>
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </article>
                                                        </div>
                                                        <?php
                                                        $counter++;
                                                    }
                                                    ?>
                                                </div>
                                                <span class="swiper-notification" aria-live="assertive"
                                                      aria-atomic="true"></span></div>
                                            <div class="slider-small site__container main__container-control">
                                                <div dir="ltr" id="beeteam368_slider_168101654796201_small"
                                                     class="swiper swiper-initialized swiper-vertical swiper-pointer-events swiper-free-mode swiper-watch-progress swiper-backface-hidden swiper-thumbs">
                                                    <div class="swiper-wrapper"
                                                         style="transform: translate3d(0px, 0px, 0px);"
                                                         id="swiper-wrapper-6bb2302f63dafadd" aria-live="polite">
                                                        <?php
                                                        $sql = "SELECT channel.name_channel, channel.id_channel, stream.id_stream, stream.name_stream 
                                                            FROM stream 
                                                            JOIN channel ON channel.id_channel = stream.id_channel
                                                            WHERE is_live_stream = 1
                                                            ORDER BY channel.followers_channel DESC";
                                                        $result = odbc_exec($con, $sql);
                                                        $counter = 0;
                                                        $slider = "";
                                                        while ($table = odbc_fetch_object($result)) {
                                                            if ($counter == 8) {
                                                                break;
                                                            }
                                                            if ($counter == 0) {
                                                                $slider = "swiper-slide-visible swiper-slide-active swiper-slide-thumb-active";
                                                            } elseif ($counter == 1) {
                                                                $slider = "swiper-slide-visible swiper-slide-next";
                                                            } elseif ($counter == 2) {
                                                                $slider = "swiper-slide-visible";
                                                            }
                                                            $fileName = $_SERVER["DOCUMENT_ROOT"] . "/GameFy/" . PATH_IMG_CHANNEL . $table->id_channel . ".jpeg";
                                                            if (file_exists($fileName)) {
                                                                $path = PATH_IMG_CHANNEL . $table->id_channel . ".jpeg";
                                                            } else {
                                                                $path = "https://i.pinimg.com/originals/3e/f1/d4/3ef1d460e6bb89eaa7d2fcf283795191.jpg";
                                                            }
                                                            ?>
                                                            <div class="swiper-slide <?php echo $slider ?>"
                                                                 style="margin-bottom: 30px;" role="group">
                                                                <article class="post-item">
                                                                    <h3 style="display:none !important"><?php echo $table->name_stream ?></h3>
                                                                    <div class="post-featured-image preview-mode-control"
                                                                         data-id="117">
                                                                        <div class="beeteam368-bt-to-img flex-row-control flex-vertical-middle dark-mode first-show">
                                                                        <span class="trending-icon font-size-12 flex-vertical-middle"><i
                                                                                    class="fas fa-bolt"></i>&nbsp;&nbsp;<span>#1</span></span>
                                                                        </div>
                                                                        <img src="https://vm.beeteam368.net/wp-content/uploads/2021/11/zombie-1801470_1920-300x169.jpg"
                                                                             class="blog-img slider-count" alt=""
                                                                             srcset="<?php echo $path ?>"
                                                                             sizes="(max-width: 300px) 100vw, 300px"
                                                                             width="300" height="169">
                                                                        <div class="beeteam368-bt-ft-img second-show flex-row-control flex-vertical-middle tiny-icons dark-mode">
                                                                            <a class="beeteam368-icon-item reg-log-popup-control"
                                                                               href="https://vm.beeteam368.net/main-login/"
                                                                               data-note="Sign in to add posts to watch later."
                                                                               data-id="117">
                                                                                <i class="fas fa-clock"></i>
                                                                            </a>
                                                                        </div>
                                                                        <div class="beeteam368-bt-ft-img first-show flex-row-control flex-vertical-middle">
                                                                       <span class="post-footer-item post-lt-views post-lt-views-control"
                                                                             style="margin: 0">
                                                                        <span class="beeteam368-icon-item small-item"
                                                                              style="background-color: red;width: 39px; height:20px; border-radius: 5px">Live</span>
                                                                       </span>
                                                                        </div>
                                                                    </div>
                                                                </article>
                                                            </div>
                                                            <?php
                                                            $counter++;
                                                        }
                                                        ?>
                                                    </div>
                                                    <span class="swiper-notification" aria-live="assertive"
                                                          aria-atomic="true"></span></div>
                                                <div class="slider-button-prev beeteam368_slider_168101654796201-prev dark-mode swiper-button-disabled"
                                                     tabindex="-1" role="button" aria-label="Previous slide"
                                                     aria-controls="swiper-wrapper-5b109653102af4e772"
                                                     aria-disabled="true"><i class="fas fa-long-arrow-alt-left"></i>
                                                </div>
                                                <div class="slider-button-next beeteam368_slider_168101654796201-next dark-mode"
                                                     tabindex="0" role="button" aria-label="Next slide"
                                                     aria-controls="swiper-wrapper-5b109653102af4e772"
                                                     aria-disabled="false"><i
                                                            class="fas fa-long-arrow-alt-right"></i>
                                                </div>
                                                <div class="beeteam368_slider_168101654796201-pagination swiper-pagination dark-mode swiper-pagination-progressbar swiper-pagination-vertical">
                                                    <span class="swiper-pagination-progressbar-fill"
                                                          style="transform: translate3d(0px, 0px, 0px) scaleX(1) scaleY(0.142857); transition-duration: 300ms;"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <script type="module">
                                            if (document.getElementById('swiper-css') === null) {
                                                document.head.innerHTML += '<link id="swiper-css" rel="stylesheet" href="https://vm.beeteam368.net/wp-content/themes/vidmov/js/swiper-slider/swiper-bundle.min.css" media="all">';
                                            }

                                            import Swiper
                                                from './assets/js/vendor/swiper.js';

                                            var beeteam368_slider_168101654796201_params = {
                                                "navigation": {
                                                    "nextEl": ".slider-button-next",
                                                    "prevEl": ".slider-button-prev"
                                                },
                                                "pagination": {
                                                    "el": ".swiper-pagination",
                                                    "clickable": true,
                                                    "type": "progressbar"
                                                }
                                            };

                                            const beeteam368_slider_168101654796201_small = new Swiper(
                                                '#beeteam368_slider_168101654796201_small',
                                                {
                                                    "spaceBetween": 30,
                                                    "slidesPerView": "auto",
                                                    "freeMode": {"enabled": true, "sticky": true},
                                                    "watchSlidesVisibility": true,
                                                    "watchSlidesProgress": true,
                                                    "direction": "vertical",
                                                    "navigation": {
                                                        "nextEl": ".beeteam368_slider_168101654796201-next",
                                                        "prevEl": ".beeteam368_slider_168101654796201-prev"
                                                    },
                                                    "pagination": {
                                                        "el": ".beeteam368_slider_168101654796201-pagination",
                                                        "clickable": true,
                                                        "type": "progressbar"
                                                    },
                                                    "breakpoints": {
                                                        "0": {
                                                            "slidesPerView": "auto",
                                                            "spaceBetween": 20,
                                                            "direction": "horizontal"
                                                        },
                                                        "480": {
                                                            "slidesPerView": 2,
                                                            "spaceBetween": 20,
                                                            "direction": "horizontal"
                                                        },
                                                        "768": {
                                                            "slidesPerView": 3,
                                                            "spaceBetween": 20,
                                                            "direction": "horizontal"
                                                        },
                                                        "992": {
                                                            "spaceBetween": 20,
                                                            "direction": "vertical",
                                                            "slidesPerView": "auto"
                                                        },
                                                        "1281": {
                                                            "spaceBetween": 30,
                                                            "direction": "vertical",
                                                            "slidesPerView": "auto"
                                                        }
                                                    }
                                                });

                                            beeteam368_slider_168101654796201_params['thumbs'] = {
                                                swiper: beeteam368_slider_168101654796201_small,
                                            }

                                            beeteam368_slider_168101654796201_params['navigation'] = {
                                                'nextEl': '.beeteam368_slider_168101654796201-next',
                                                'prevEl': '.beeteam368_slider_168101654796201-prev',
                                            }


                                            const beeteam368_slider_168101654796201 = new Swiper('#beeteam368_slider_168101654796201', beeteam368_slider_168101654796201_params);

                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <?php
                }
                ?>
                <section
                        class="elementor-section elementor-top-section elementor-element elementor-element-afdcbdd elementor-section-boxed elementor-section-height-default elementor-section-height-default"
                        data-id="afdcbdd" data-element_type="section">
                    <div class="elementor-container elementor-column-gap-no">
                        <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-fdf09e4"
                             data-id="fdf09e4" data-element_type="column">
                            <div class="elementor-widget-wrap elementor-element-populated">
                                <div class="elementor-element elementor-element-3adae6d elementor-widget elementor-widget-beeteam368_slider_addon"
                                     data-id="3adae6d" data-element_type="widget"
                                     data-widget_type="beeteam368_slider_addon.default">
                                    <div class="elementor-widget-container">
                                        <div class="top-section-title has-icon">
                                            <span class="beeteam368-icon-item"><i class="fas fa-gamepad"></i></span>
                                            <h2 class="h1 h3-mobile main-title-heading">
                                                <span class="main-title">Best Games</span> <span class="hd-line"></span>
                                            </h2>
                                        </div>
                                        <div id="beeteam368_slider_865801656250291"
                                             class="swiper beeteam368-slider-container container-silder-style-rose swiper-initialized swiper-horizontal swiper-pointer-events swiper-free-mode swiper-backface-hidden">
                                            <div class="swiper-wrapper blog-wrapper global-slider-wrapper site__row blog-style-rose "
                                                 style="transform: translate3d(0px, 0px, 0px);"
                                                 id="swiper-wrapper-6fad6e483ec8c39f" aria-live="polite">
                                                <div class="swiper-slide site__col swiper-slide-active" role="group"
                                                     aria-label="1 / 10">
                                                    <article
                                                            class="post-item site__col flex-row-control post-326 vidmov_video type-vidmov_video status-publish has-post-thumbnail hentry tag-y-2016 tag-y-2018 tag-y-2020 tag-y-2022 tag-action-adventure tag-chinese tag-comedy tag-documentary tag-english tag-family tag-france tag-germany tag-korean tag-mystery tag-nr tag-sci-fi-fantasy tag-talk tag-tv-ma tag-tv-pg tag-tv-y7 tag-united-states tag-westen vidmov_video_category-movies">
                                                        <div class="post-item-wrap">
                                                            <div class="post-featured-image preview-mode-control"
                                                                 data-id="326">
                                                                <a data-post-id="326" data-post-type="vidmov_video"
                                                                   href="https://vm.beeteam368.net/video/love-and-monsters/"
                                                                   title="Love and Monsters"
                                                                   class="blog-img-link blog-img-link-control"><img
                                                                            src="https://vm.beeteam368.net/wp-content/uploads/2021/11/fashion-5043026_1920-234x351.jpg"
                                                                            class="blog-img" alt=""
                                                                            srcset="https://vm.beeteam368.net/wp-content/uploads/2021/11/fashion-5043026_1920-234x351.jpg 234w, https://vm.beeteam368.net/wp-content/uploads/2021/11/fashion-5043026_1920-88x132.jpg 88w, https://vm.beeteam368.net/wp-content/uploads/2021/11/fashion-5043026_1920-420x630.jpg 420w, https://vm.beeteam368.net/wp-content/uploads/2021/11/fashion-5043026_1920-800x1200.jpg 800w"
                                                                            sizes="(max-width: 234px) 100vw, 234px"
                                                                            width="234" height="351"></a>
                                                                <div class="beeteam368-bt-ft-img first-show flex-row-control flex-vertical-middle">
                                                                    <h3 class="entry-title post-title max-2lines h5 h6-mobile">
                                                                        <a class="post-listing-title"
                                                                           href="https://vm.beeteam368.net/video/love-and-monsters/"
                                                                           title="Love and Monsters">Love and
                                                                            Monsters</a>
                                                                    </h3></div>
                                                            </div>
                                                        </div>
                                                    </article>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </section>
                <section
                        class="elementor-section elementor-top-section elementor-element elementor-element-bd51d9b elementor-section-boxed elementor-section-height-default elementor-section-height-default"
                        data-id="bd51d9b" data-element_type="section">
                    <div class="elementor-container elementor-column-gap-no">
                        <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-7f6a828"
                             data-id="7f6a828" data-element_type="column">
                            <div class="elementor-widget-wrap elementor-element-populated">
                                <div class="elementor-element elementor-element-996c171 elementor-widget elementor-widget-beeteam368_slider_addon"
                                     data-id="996c171" data-element_type="widget"
                                     data-widget_type="beeteam368_slider_addon.default">
                                    <div class="elementor-widget-container">
                                        <div class="top-section-title has-icon">
                                            <span class="beeteam368-icon-item"><i class="fas fa-play"></i></span><a
                                                    href="https://vm.beeteam368.net/video/" class="sub-title-link"><span
                                                        class="sub-title font-main">All Videos</span></a>
                                            <h2 class="h1 h3-mobile main-title-heading">
                                                <span class="main-title">Premium Videos</span> <span
                                                        class="hd-line"></span>
                                            </h2>
                                        </div>
                                        <div id="beeteam368_slider_305161656250291"
                                             class="swiper beeteam368-slider-container container-silder-style-lily swiper-initialized swiper-horizontal swiper-pointer-events swiper-free-mode swiper-backface-hidden">
                                            <div class="swiper-wrapper blog-wrapper global-slider-wrapper site__row blog-style-lily  is-fw-mode"
                                                 style="transform: translate3d(0px, 0px, 0px);"
                                                 id="swiper-wrapper-b1a6a24dbae38215"
                                                 aria-live="polite">
                                                <div class="swiper-slide site__col swiper-slide-active"
                                                     style="width: 422.5px; margin-right: 30px;" role="group"
                                                     aria-label="1 / 6">
                                                    <article
                                                            class="post-item site__col flex-row-control post-557 vidmov_video type-vidmov_video status-publish has-post-thumbnail hentry tag-y-2016 tag-y-2018 tag-y-2020 tag-y-2022 tag-action-adventure tag-chinese tag-comedy tag-documentary tag-english tag-family tag-france tag-germany tag-korean tag-mystery tag-nr tag-premium-video tag-sci-fi-fantasy tag-talk tag-tv-ma tag-tv-pg tag-tv-y7 tag-united-states tag-westen vidmov_video_category-gaming">
                                                        <div class="post-item-wrap">
                                                            <div class="post-featured-image preview-mode-control"
                                                                 data-id="557">
                                                                <div class="beeteam368-bt-to-img flex-row-control flex-vertical-middle dark-mode first-show">
                                                        <span class="trending-icon font-size-12 flex-vertical-middle"><i
                                                                    class="fas fa-bolt"></i>&nbsp;&nbsp;<span>#10</span></span>
                                                                    <span class="beeteam368-duration font-size-12 flex-vertical-middle">01:20</span>
                                                                    <span class="membership-icon font-size-12 flex-vertical-middle"
                                                                          data-plan-id="4"><i
                                                                                class="fas fa-crown"></i>&nbsp;&nbsp;<span>Extreme Level</span></span>
                                                                </div>
                                                                <a data-post-id="557" data-post-type="vidmov_video"
                                                                   href="https://vm.beeteam368.net/video/official-season-six-trailer/"
                                                                   title="Official Season Six Trailer"
                                                                   class="blog-img-link blog-img-link-control"><img
                                                                            src="https://vm.beeteam368.net/wp-content/uploads/2021/12/call-of-duty-8-420x237.jpg"
                                                                            class="blog-img" alt=""
                                                                            srcset="https://vm.beeteam368.net/wp-content/uploads/2021/12/call-of-duty-8-420x237.jpg 420w, https://vm.beeteam368.net/wp-content/uploads/2021/12/call-of-duty-8-300x169.jpg 300w, https://vm.beeteam368.net/wp-content/uploads/2021/12/call-of-duty-8-1024x576.jpg 1024w, https://vm.beeteam368.net/wp-content/uploads/2021/12/call-of-duty-8-768x432.jpg 768w, https://vm.beeteam368.net/wp-content/uploads/2021/12/call-of-duty-8-1536x864.jpg 1536w, https://vm.beeteam368.net/wp-content/uploads/2021/12/call-of-duty-8-1600x900.jpg 1600w, https://vm.beeteam368.net/wp-content/uploads/2021/12/call-of-duty-8-800x450.jpg 800w, https://vm.beeteam368.net/wp-content/uploads/2021/12/call-of-duty-8.jpg 1920w"
                                                                            sizes="(max-width: 420px) 100vw, 420px"
                                                                            width="420"
                                                                            height="237"></a>
                                                                <div class="beeteam368-bt-ft-img second-show flex-row-control flex-vertical-middle tiny-icons dark-mode"><span
                                                                            class="beeteam368-icon-item add-to-watch-later add-to-watch-later-control tooltip-style "
                                                                            data-id="557">
<i class="fas fa-clock"></i>
</span>
                                                                    <div class="post-footer-item post-lt-reactions post-lt-reaction-control"
                                                                         data-id="557" data-active="0"
                                                                         data-count="{&quot;like&quot;:&quot;12&quot;,&quot;dislike&quot;:&quot;4&quot;,&quot;cry&quot;:&quot;4&quot;,&quot;squint_tears&quot;:&quot;1&quot;}">
                                                            <span class="reaction-item beeteam368-icon-item tiny-item like-reaction"><i
                                                                        class="fas fa-heart"></i></span><span
                                                                                class="reaction-item beeteam368-icon-item tiny-item dislike-reaction"><i
                                                                                    class="fas fa-thumbs-down"></i></span><span
                                                                                class="reaction-item beeteam368-icon-item tiny-item cry-reaction"><i
                                                                                    class="far fa-sad-cry"></i></span>
                                                                        <span
                                                                                class="item-number item-number-control">21</span>
                                                                        <span class="item-text item-text-control">reactions</span>
                                                                    </div>
                                                                </div>
                                                                <div class="beeteam368-bt-ft-img first-show flex-row-control flex-vertical-middle">
                                                        <span class="review-score-wrapper review-score-wrapper-control small-size dark-mode  rv-percent"
                                                              data-id="557"
                                                              style="background-image:linear-gradient(270deg, var(--color__main-circle-score-percent) 50%, transparent 50%), linear-gradient(370.8deg, var(--color__main-circle-score-percent) 50%, var(--color__sub-circle-score-percent) 50%);"><span
                                                                    class="review-score-percent review-score-percent-control h6"
                                                                    data-id="557">78<span
                                                                        class="review-percent font-main font-size-8">%</span></span></span><span
                                                                            class="label-icon sales-count font-size-12"><i
                                                                                class="fas fa-chart-line"></i>&nbsp;&nbsp; 1</span>
                                                                    <h3 class="entry-title post-title max-2lines h4 h5-mobile">
                                                                        <a class="post-listing-title"
                                                                           href="https://vm.beeteam368.net/video/official-season-six-trailer/"
                                                                           title="Official Season Six Trailer">Official
                                                                            Season Six
                                                                            Trailer</a>
                                                                    </h3></div>
                                                            </div>
                                                        </div>
                                                    </article>
                                                </div>
                                                <div class="swiper-slide site__col swiper-slide-next"
                                                     style="width: 422.5px; margin-right: 30px;" role="group"
                                                     aria-label="2 / 6">
                                                    <article
                                                            class="post-item site__col flex-row-control post-556 vidmov_video type-vidmov_video status-publish has-post-thumbnail hentry tag-y-2017 tag-y-2019 tag-y-2021 tag-animation tag-crime tag-drama tag-french tag-german tag-italy tag-japan tag-japanese tag-kids tag-korea tag-premium-video tag-reality tag-soap tag-tv-14 tag-tv-g tag-tv-y tag-war-politics vidmov_video_category-gaming">
                                                        <div class="post-item-wrap">
                                                            <div class="post-featured-image preview-mode-control"
                                                                 data-id="556">
                                                                <div class="beeteam368-bt-to-img flex-row-control flex-vertical-middle dark-mode first-show">
                                                        <span class="trending-icon font-size-12 flex-vertical-middle"><i
                                                                    class="fas fa-bolt"></i>&nbsp;&nbsp;<span>#25</span></span>
                                                                    <span class="beeteam368-duration font-size-12 flex-vertical-middle">00:51</span>
                                                                    <span class="membership-icon font-size-12 flex-vertical-middle"
                                                                          data-plan-id="6"><i
                                                                                class="fas fa-crown"></i>&nbsp;&nbsp;<span>Platinum Elite</span></span>
                                                                </div>
                                                                <a data-post-id="556" data-post-type="vidmov_video"
                                                                   href="https://vm.beeteam368.net/video/shadow-company-trailer/"
                                                                   title="Shadow Company Trailer"
                                                                   class="blog-img-link blog-img-link-control"><img
                                                                            src="https://vm.beeteam368.net/wp-content/uploads/2021/12/call-of-duty-10-420x237.jpg"
                                                                            class="blog-img" alt=""
                                                                            srcset="https://vm.beeteam368.net/wp-content/uploads/2021/12/call-of-duty-10-420x237.jpg 420w, https://vm.beeteam368.net/wp-content/uploads/2021/12/call-of-duty-10-300x169.jpg 300w, https://vm.beeteam368.net/wp-content/uploads/2021/12/call-of-duty-10-1024x576.jpg 1024w, https://vm.beeteam368.net/wp-content/uploads/2021/12/call-of-duty-10-768x432.jpg 768w, https://vm.beeteam368.net/wp-content/uploads/2021/12/call-of-duty-10-1536x864.jpg 1536w, https://vm.beeteam368.net/wp-content/uploads/2021/12/call-of-duty-10-1600x900.jpg 1600w, https://vm.beeteam368.net/wp-content/uploads/2021/12/call-of-duty-10-800x450.jpg 800w, https://vm.beeteam368.net/wp-content/uploads/2021/12/call-of-duty-10.jpg 1920w"
                                                                            sizes="(max-width: 420px) 100vw, 420px"
                                                                            width="420"
                                                                            height="237"></a>
                                                                <div class="beeteam368-bt-ft-img second-show flex-row-control flex-vertical-middle tiny-icons dark-mode"><span
                                                                            class="beeteam368-icon-item add-to-watch-later add-to-watch-later-control tooltip-style "
                                                                            data-id="556">
<i class="fas fa-clock"></i>
</span>
                                                                    <div class="post-footer-item post-lt-reactions post-lt-reaction-control"
                                                                         data-id="556" data-active="0"
                                                                         data-count="{&quot;like&quot;:&quot;6&quot;,&quot;dislike&quot;:&quot;2&quot;,&quot;cry&quot;:&quot;2&quot;,&quot;squint_tears&quot;:0}">
                                                            <span class="reaction-item beeteam368-icon-item tiny-item like-reaction"><i
                                                                        class="fas fa-heart"></i></span><span
                                                                                class="reaction-item beeteam368-icon-item tiny-item dislike-reaction"><i
                                                                                    class="fas fa-thumbs-down"></i></span><span
                                                                                class="reaction-item beeteam368-icon-item tiny-item cry-reaction"><i
                                                                                    class="far fa-sad-cry"></i></span>
                                                                        <span
                                                                                class="item-number item-number-control">10</span>
                                                                        <span class="item-text item-text-control">reactions</span>
                                                                    </div>
                                                                </div>
                                                                <div class="beeteam368-bt-ft-img first-show flex-row-control flex-vertical-middle">
                                                        <span class="review-score-wrapper review-score-wrapper-control small-size dark-mode  rv-percent"
                                                              data-id="556"
                                                              style="background-image:linear-gradient(270deg, var(--color__main-circle-score-percent) 50%, transparent 50%), linear-gradient(414deg, var(--color__main-circle-score-percent) 50%, var(--color__sub-circle-score-percent) 50%);"><span
                                                                    class="review-score-percent review-score-percent-control h6"
                                                                    data-id="556">90<span
                                                                        class="review-percent font-main font-size-8">%</span></span></span><span
                                                                            class="label-icon sales-count font-size-12"><i
                                                                                class="fas fa-chart-line"></i>&nbsp;&nbsp; 0</span>
                                                                    <h3 class="entry-title post-title max-2lines h4 h5-mobile">
                                                                        <a class="post-listing-title"
                                                                           href="https://vm.beeteam368.net/video/shadow-company-trailer/"
                                                                           title="Shadow Company Trailer">Shadow Company
                                                                            Trailer</a>
                                                                    </h3></div>
                                                            </div>
                                                        </div>
                                                    </article>
                                                </div>
                                                <div class="swiper-slide site__col"
                                                     style="width: 422.5px; margin-right: 30px;"
                                                     role="group" aria-label="3 / 6">
                                                    <article
                                                            class="post-item site__col flex-row-control post-555 vidmov_video type-vidmov_video status-publish has-post-thumbnail hentry tag-y-2016 tag-y-2018 tag-y-2020 tag-y-2022 tag-action-adventure tag-chinese tag-comedy tag-documentary tag-english tag-family tag-france tag-germany tag-korean tag-mystery tag-nr tag-premium-video tag-sci-fi-fantasy tag-talk tag-tv-ma tag-tv-pg tag-tv-y7 tag-united-states tag-westen vidmov_video_category-gaming">
                                                        <div class="post-item-wrap">
                                                            <div class="post-featured-image preview-mode-control"
                                                                 data-id="555">
                                                                <div class="beeteam368-bt-to-img flex-row-control flex-vertical-middle dark-mode first-show">
                                                        <span class="trending-icon font-size-12 flex-vertical-middle"><i
                                                                    class="fas fa-bolt"></i>&nbsp;&nbsp;<span>#30</span></span>
                                                                    <span class="beeteam368-duration font-size-12 flex-vertical-middle">00:45</span>
                                                                    <span class="membership-icon font-size-12 flex-vertical-middle"
                                                                          data-plan-id="2"><i
                                                                                class="fas fa-crown"></i>&nbsp;&nbsp;<span>Pastel Level</span></span>
                                                                </div>
                                                                <a data-post-id="555" data-post-type="vidmov_video"
                                                                   href="https://vm.beeteam368.net/video/games-of-summer-trailer/"
                                                                   title="Games of Summer Trailer"
                                                                   class="blog-img-link blog-img-link-control"><img
                                                                            src="https://vm.beeteam368.net/wp-content/uploads/2021/12/call-of-duty-2-420x237.jpg"
                                                                            class="blog-img" alt=""
                                                                            srcset="https://vm.beeteam368.net/wp-content/uploads/2021/12/call-of-duty-2-420x237.jpg 420w, https://vm.beeteam368.net/wp-content/uploads/2021/12/call-of-duty-2-300x169.jpg 300w, https://vm.beeteam368.net/wp-content/uploads/2021/12/call-of-duty-2-1024x576.jpg 1024w, https://vm.beeteam368.net/wp-content/uploads/2021/12/call-of-duty-2-768x432.jpg 768w, https://vm.beeteam368.net/wp-content/uploads/2021/12/call-of-duty-2-1536x864.jpg 1536w, https://vm.beeteam368.net/wp-content/uploads/2021/12/call-of-duty-2-1600x900.jpg 1600w, https://vm.beeteam368.net/wp-content/uploads/2021/12/call-of-duty-2-800x450.jpg 800w, https://vm.beeteam368.net/wp-content/uploads/2021/12/call-of-duty-2.jpg 1920w"
                                                                            sizes="(max-width: 420px) 100vw, 420px"
                                                                            width="420"
                                                                            height="237"></a>
                                                                <div class="beeteam368-bt-ft-img second-show flex-row-control flex-vertical-middle tiny-icons dark-mode"><span
                                                                            class="beeteam368-icon-item add-to-watch-later add-to-watch-later-control tooltip-style "
                                                                            data-id="555">
<i class="fas fa-clock"></i>
</span>
                                                                    <div class="post-footer-item post-lt-reactions post-lt-reaction-control"
                                                                         data-id="555" data-active="0"
                                                                         data-count="{&quot;like&quot;:&quot;10&quot;,&quot;dislike&quot;:&quot;1&quot;,&quot;cry&quot;:&quot;1&quot;,&quot;squint_tears&quot;:0}">
                                                            <span class="reaction-item beeteam368-icon-item tiny-item like-reaction"><i
                                                                        class="fas fa-heart"></i></span><span
                                                                                class="reaction-item beeteam368-icon-item tiny-item dislike-reaction"><i
                                                                                    class="fas fa-thumbs-down"></i></span><span
                                                                                class="reaction-item beeteam368-icon-item tiny-item cry-reaction"><i
                                                                                    class="far fa-sad-cry"></i></span>
                                                                        <span
                                                                                class="item-number item-number-control">12</span>
                                                                        <span class="item-text item-text-control">reactions</span>
                                                                    </div>
                                                                </div>
                                                                <div class="beeteam368-bt-ft-img first-show flex-row-control flex-vertical-middle">
                                                        <span class="review-score-wrapper review-score-wrapper-control small-size dark-mode  rv-percent"
                                                              data-id="555"
                                                              style="background-image:linear-gradient(270deg, var(--color__main-circle-score-percent) 50%, transparent 50%), linear-gradient(414deg, var(--color__main-circle-score-percent) 50%, var(--color__sub-circle-score-percent) 50%);"><span
                                                                    class="review-score-percent review-score-percent-control h6"
                                                                    data-id="555">90<span
                                                                        class="review-percent font-main font-size-8">%</span></span></span><span
                                                                            class="label-icon sales-count font-size-12"><i
                                                                                class="fas fa-chart-line"></i>&nbsp;&nbsp; 0</span>
                                                                    <h3 class="entry-title post-title max-2lines h4 h5-mobile">
                                                                        <a class="post-listing-title"
                                                                           href="https://vm.beeteam368.net/video/games-of-summer-trailer/"
                                                                           title="Games of Summer Trailer">Games of
                                                                            Summer
                                                                            Trailer</a>
                                                                    </h3></div>
                                                            </div>
                                                        </div>
                                                    </article>
                                                </div>
                                                <div class="swiper-slide site__col"
                                                     style="width: 422.5px; margin-right: 30px;"
                                                     role="group" aria-label="4 / 6">
                                                    <article
                                                            class="post-item site__col flex-row-control post-554 vidmov_video type-vidmov_video status-publish has-post-thumbnail hentry tag-y-2017 tag-y-2019 tag-y-2021 tag-animation tag-crime tag-drama tag-french tag-german tag-italy tag-japan tag-japanese tag-kids tag-korea tag-premium-video tag-reality tag-soap tag-tv-14 tag-tv-g tag-tv-y tag-war-politics vidmov_video_category-gaming">
                                                        <div class="post-item-wrap">
                                                            <div class="post-featured-image preview-mode-control"
                                                                 data-id="554">
                                                                <div class="beeteam368-bt-to-img flex-row-control flex-vertical-middle dark-mode first-show">
                                                        <span class="trending-icon font-size-12 flex-vertical-middle"><i
                                                                    class="fas fa-bolt"></i>&nbsp;&nbsp;<span>#14</span></span>
                                                                    <span class="beeteam368-duration font-size-12 flex-vertical-middle">01:02</span>
                                                                </div>
                                                                <a data-post-id="554" data-post-type="vidmov_video"
                                                                   href="https://vm.beeteam368.net/video/mobile-official-season-13-winter-war-trailer/"
                                                                   title="Mobile Official Season 13 Winter War Trailer"
                                                                   class="blog-img-link blog-img-link-control"><img
                                                                            src="https://vm.beeteam368.net/wp-content/uploads/2021/12/call-of-duty-3-420x237.jpg"
                                                                            class="blog-img" alt=""
                                                                            srcset="https://vm.beeteam368.net/wp-content/uploads/2021/12/call-of-duty-3-420x237.jpg 420w, https://vm.beeteam368.net/wp-content/uploads/2021/12/call-of-duty-3-300x169.jpg 300w, https://vm.beeteam368.net/wp-content/uploads/2021/12/call-of-duty-3-1024x576.jpg 1024w, https://vm.beeteam368.net/wp-content/uploads/2021/12/call-of-duty-3-768x432.jpg 768w, https://vm.beeteam368.net/wp-content/uploads/2021/12/call-of-duty-3-1536x864.jpg 1536w, https://vm.beeteam368.net/wp-content/uploads/2021/12/call-of-duty-3-1600x900.jpg 1600w, https://vm.beeteam368.net/wp-content/uploads/2021/12/call-of-duty-3-800x450.jpg 800w, https://vm.beeteam368.net/wp-content/uploads/2021/12/call-of-duty-3.jpg 1920w"
                                                                            sizes="(max-width: 420px) 100vw, 420px"
                                                                            width="420"
                                                                            height="237"></a>
                                                                <div class="beeteam368-bt-ft-img second-show flex-row-control flex-vertical-middle tiny-icons dark-mode"><span
                                                                            class="beeteam368-icon-item add-to-watch-later add-to-watch-later-control tooltip-style "
                                                                            data-id="554">
<i class="fas fa-clock"></i>
</span>
                                                                    <div class="post-footer-item post-lt-reactions post-lt-reaction-control"
                                                                         data-id="554" data-active="0"
                                                                         data-count="{&quot;like&quot;:&quot;6&quot;,&quot;squint_tears&quot;:&quot;1&quot;,&quot;cry&quot;:&quot;1&quot;,&quot;dislike&quot;:0}">
                                                            <span class="reaction-item beeteam368-icon-item tiny-item like-reaction"><i
                                                                        class="fas fa-heart"></i></span><span
                                                                                class="reaction-item beeteam368-icon-item tiny-item squint_tears-reaction"><i
                                                                                    class="far fa-grin-squint-tears"></i></span><span
                                                                                class="reaction-item beeteam368-icon-item tiny-item cry-reaction"><i
                                                                                    class="far fa-sad-cry"></i></span>
                                                                        <span
                                                                                class="item-number item-number-control">8</span>
                                                                        <span class="item-text item-text-control">reactions</span>
                                                                    </div>
                                                                </div>
                                                                <div class="beeteam368-bt-ft-img first-show flex-row-control flex-vertical-middle">
                                                        <span class="review-score-wrapper review-score-wrapper-control small-size dark-mode  rv-percent"
                                                              data-id="554"
                                                              style="background-image:linear-gradient(270deg, var(--color__main-circle-score-percent) 50%, transparent 50%), linear-gradient(385.2deg, var(--color__main-circle-score-percent) 50%, var(--color__sub-circle-score-percent) 50%);"><span
                                                                    class="review-score-percent review-score-percent-control h6"
                                                                    data-id="554">82<span
                                                                        class="review-percent font-main font-size-8">%</span></span></span><span
                                                                            class="label-icon sales-count font-size-12"><i
                                                                                class="fas fa-chart-line"></i>&nbsp;&nbsp; 1</span>
                                                                    <h3 class="entry-title post-title max-2lines h4 h5-mobile">
                                                                        <a class="post-listing-title"
                                                                           href="https://vm.beeteam368.net/video/mobile-official-season-13-winter-war-trailer/"
                                                                           title="Mobile Official Season 13 Winter War Trailer">Mobile
                                                                            Official Season 13 Winter War Trailer</a>
                                                                    </h3></div>
                                                            </div>
                                                        </div>
                                                    </article>
                                                </div>
                                                <div class="swiper-slide site__col"
                                                     style="width: 422.5px; margin-right: 30px;"
                                                     role="group" aria-label="5 / 6">
                                                    <article
                                                            class="post-item site__col flex-row-control post-553 vidmov_video type-vidmov_video status-publish has-post-thumbnail hentry tag-y-2016 tag-y-2018 tag-y-2020 tag-y-2022 tag-action-adventure tag-chinese tag-comedy tag-documentary tag-english tag-family tag-france tag-germany tag-korean tag-mystery tag-nr tag-premium-video tag-sci-fi-fantasy tag-talk tag-tv-ma tag-tv-pg tag-tv-y7 tag-united-states tag-westen vidmov_video_category-gaming">
                                                        <div class="post-item-wrap">
                                                            <div class="post-featured-image preview-mode-control"
                                                                 data-id="553">
                                                                <div class="beeteam368-bt-to-img flex-row-control flex-vertical-middle dark-mode first-show">
                                                        <span class="trending-icon font-size-12 flex-vertical-middle"><i
                                                                    class="fas fa-bolt"></i>&nbsp;&nbsp;<span>#46</span></span>
                                                                    <span class="beeteam368-duration font-size-12 flex-vertical-middle">01:11</span>
                                                                </div>
                                                                <a data-post-id="553" data-post-type="vidmov_video"
                                                                   href="https://vm.beeteam368.net/video/season-three-battle-pass-trailer/"
                                                                   title="Season Three Battle Pass Trailer"
                                                                   class="blog-img-link blog-img-link-control"><img
                                                                            src="https://vm.beeteam368.net/wp-content/uploads/2021/12/call-of-duty-9-420x237.jpg"
                                                                            class="blog-img" alt=""
                                                                            srcset="https://vm.beeteam368.net/wp-content/uploads/2021/12/call-of-duty-9-420x237.jpg 420w, https://vm.beeteam368.net/wp-content/uploads/2021/12/call-of-duty-9-300x169.jpg 300w, https://vm.beeteam368.net/wp-content/uploads/2021/12/call-of-duty-9-1024x576.jpg 1024w, https://vm.beeteam368.net/wp-content/uploads/2021/12/call-of-duty-9-768x432.jpg 768w, https://vm.beeteam368.net/wp-content/uploads/2021/12/call-of-duty-9-1536x864.jpg 1536w, https://vm.beeteam368.net/wp-content/uploads/2021/12/call-of-duty-9-1600x900.jpg 1600w, https://vm.beeteam368.net/wp-content/uploads/2021/12/call-of-duty-9-800x450.jpg 800w, https://vm.beeteam368.net/wp-content/uploads/2021/12/call-of-duty-9.jpg 1920w"
                                                                            sizes="(max-width: 420px) 100vw, 420px"
                                                                            width="420"
                                                                            height="237"></a>
                                                                <div class="beeteam368-bt-ft-img second-show flex-row-control flex-vertical-middle tiny-icons dark-mode"><span
                                                                            class="beeteam368-icon-item add-to-watch-later add-to-watch-later-control tooltip-style "
                                                                            data-id="553">
<i class="fas fa-clock"></i>
</span>
                                                                    <div class="post-footer-item post-lt-reactions post-lt-reaction-control"
                                                                         data-id="553" data-active="0"
                                                                         data-count="{&quot;like&quot;:&quot;2&quot;,&quot;dislike&quot;:&quot;1&quot;,&quot;squint_tears&quot;:&quot;1&quot;,&quot;cry&quot;:0}">
                                                            <span class="reaction-item beeteam368-icon-item tiny-item like-reaction"><i
                                                                        class="fas fa-heart"></i></span><span
                                                                                class="reaction-item beeteam368-icon-item tiny-item dislike-reaction"><i
                                                                                    class="fas fa-thumbs-down"></i></span><span
                                                                                class="reaction-item beeteam368-icon-item tiny-item squint_tears-reaction"><i
                                                                                    class="far fa-grin-squint-tears"></i></span>
                                                                        <span class="item-number item-number-control">4</span>
                                                                        <span class="item-text item-text-control">reactions</span>
                                                                    </div>
                                                                </div>
                                                                <div class="beeteam368-bt-ft-img first-show flex-row-control flex-vertical-middle">
                                                        <span class="review-score-wrapper review-score-wrapper-control small-size dark-mode  rv-percent"
                                                              data-id="553"
                                                              style="background-image:linear-gradient(270deg, var(--color__main-circle-score-percent) 50%, transparent 50%), linear-gradient(392.4deg, var(--color__main-circle-score-percent) 50%, var(--color__sub-circle-score-percent) 50%);"><span
                                                                    class="review-score-percent review-score-percent-control h6"
                                                                    data-id="553">84<span
                                                                        class="review-percent font-main font-size-8">%</span></span></span><span
                                                                            class="label-icon sales-count font-size-12"><i
                                                                                class="fas fa-chart-line"></i>&nbsp;&nbsp; 0</span>
                                                                    <h3 class="entry-title post-title max-2lines h4 h5-mobile">
                                                                        <a class="post-listing-title"
                                                                           href="https://vm.beeteam368.net/video/season-three-battle-pass-trailer/"
                                                                           title="Season Three Battle Pass Trailer">Season
                                                                            Three
                                                                            Battle Pass Trailer</a>
                                                                    </h3></div>
                                                            </div>
                                                        </div>
                                                    </article>
                                                </div>
                                                <div class="swiper-slide site__col"
                                                     style="width: 422.5px; margin-right: 30px;"
                                                     role="group" aria-label="6 / 6">
                                                    <article
                                                            class="post-item site__col flex-row-control post-552 vidmov_video type-vidmov_video status-publish has-post-thumbnail hentry tag-y-2017 tag-y-2019 tag-y-2021 tag-animation tag-crime tag-drama tag-french tag-german tag-italy tag-japan tag-japanese tag-kids tag-korea tag-premium-video tag-reality tag-soap tag-tv-14 tag-tv-g tag-tv-y tag-war-politics vidmov_video_category-gaming">
                                                        <div class="post-item-wrap">
                                                            <div class="post-featured-image preview-mode-control"
                                                                 data-id="552">
                                                                <div class="beeteam368-bt-to-img flex-row-control flex-vertical-middle dark-mode first-show">
                                                        <span class="trending-icon font-size-12 flex-vertical-middle"><i
                                                                    class="fas fa-bolt"></i>&nbsp;&nbsp;<span>#40</span></span>
                                                                    <span class="beeteam368-duration font-size-12 flex-vertical-middle">01:26</span>
                                                                </div>
                                                                <a data-post-id="552" data-post-type="vidmov_video"
                                                                   href="https://vm.beeteam368.net/video/black-ops-cold-war-warzone/"
                                                                   title="Black Ops Cold War &amp; Warzone"
                                                                   class="blog-img-link blog-img-link-control"><img
                                                                            src="https://vm.beeteam368.net/wp-content/uploads/2021/12/call-of-duty-1-420x237.jpg"
                                                                            class="blog-img" alt=""
                                                                            srcset="https://vm.beeteam368.net/wp-content/uploads/2021/12/call-of-duty-1-420x237.jpg 420w, https://vm.beeteam368.net/wp-content/uploads/2021/12/call-of-duty-1-300x169.jpg 300w, https://vm.beeteam368.net/wp-content/uploads/2021/12/call-of-duty-1-1024x576.jpg 1024w, https://vm.beeteam368.net/wp-content/uploads/2021/12/call-of-duty-1-768x432.jpg 768w, https://vm.beeteam368.net/wp-content/uploads/2021/12/call-of-duty-1-1536x864.jpg 1536w, https://vm.beeteam368.net/wp-content/uploads/2021/12/call-of-duty-1-1600x900.jpg 1600w, https://vm.beeteam368.net/wp-content/uploads/2021/12/call-of-duty-1-800x450.jpg 800w, https://vm.beeteam368.net/wp-content/uploads/2021/12/call-of-duty-1.jpg 1920w"
                                                                            sizes="(max-width: 420px) 100vw, 420px"
                                                                            width="420"
                                                                            height="237"></a>
                                                                <div class="beeteam368-bt-ft-img second-show flex-row-control flex-vertical-middle tiny-icons dark-mode"><span
                                                                            class="beeteam368-icon-item add-to-watch-later add-to-watch-later-control tooltip-style "
                                                                            data-id="552">
<i class="fas fa-clock"></i>
</span>
                                                                    <div class="post-footer-item post-lt-reactions post-lt-reaction-control"
                                                                         data-id="552" data-active="0"
                                                                         data-count="{&quot;squint_tears&quot;:&quot;2&quot;,&quot;like&quot;:&quot;1&quot;,&quot;cry&quot;:&quot;1&quot;,&quot;dislike&quot;:0}">
                                                            <span class="reaction-item beeteam368-icon-item tiny-item squint_tears-reaction"><i
                                                                        class="far fa-grin-squint-tears"></i></span><span
                                                                                class="reaction-item beeteam368-icon-item tiny-item like-reaction"><i
                                                                                    class="fas fa-heart"></i></span><span
                                                                                class="reaction-item beeteam368-icon-item tiny-item cry-reaction"><i
                                                                                    class="far fa-sad-cry"></i></span>
                                                                        <span
                                                                                class="item-number item-number-control">4</span>
                                                                        <span class="item-text item-text-control">reactions</span>
                                                                    </div>
                                                                </div>
                                                                <div class="beeteam368-bt-ft-img first-show flex-row-control flex-vertical-middle">
                                                        <span class="review-score-wrapper review-score-wrapper-control small-size dark-mode  rv-percent"
                                                              data-id="552"
                                                              style="background-image:linear-gradient(270deg, var(--color__main-circle-score-percent) 50%, transparent 50%), linear-gradient(406.8deg, var(--color__main-circle-score-percent) 50%, var(--color__sub-circle-score-percent) 50%);"><span
                                                                    class="review-score-percent review-score-percent-control h6"
                                                                    data-id="552">88<span
                                                                        class="review-percent font-main font-size-8">%</span></span></span><span
                                                                            class="label-icon sales-count font-size-12"><i
                                                                                class="fas fa-chart-line"></i>&nbsp;&nbsp; 0</span>
                                                                    <h3 class="entry-title post-title max-2lines h4 h5-mobile">
                                                                        <a class="post-listing-title"
                                                                           href="https://vm.beeteam368.net/video/black-ops-cold-war-warzone/"
                                                                           title="Black Ops Cold War &amp; Warzone">Black
                                                                            Ops Cold
                                                                            War &amp; Warzone</a>
                                                                    </h3></div>
                                                            </div>
                                                        </div>
                                                    </article>
                                                </div>
                                            </div>
                                            <div class="slider-button-prev swiper-button-disabled" tabindex="-1"
                                                 role="button"
                                                 aria-label="Previous slide"
                                                 aria-controls="swiper-wrapper-b1a6a24dbae38215"
                                                 aria-disabled="true"><i class="fas fa-long-arrow-alt-left"></i></div>
                                            <div class="slider-button-next" tabindex="0" role="button"
                                                 aria-label="Next slide"
                                                 aria-controls="swiper-wrapper-b1a6a24dbae38215" aria-disabled="false">
                                                <i
                                                        class="fas fa-long-arrow-alt-right"></i></div>
                                            <div class="swiper-pagination swiper-pagination-progressbar swiper-pagination-horizontal">
                                    <span class="swiper-pagination-progressbar-fill"
                                          style="transform: translate3d(0px, 0px, 0px) scaleX(0.333333) scaleY(1); transition-duration: 300ms;"></span>
                                            </div>
                                            <span class="swiper-notification" aria-live="assertive"
                                                  aria-atomic="true"></span></div>
                                        <script type="module">

                                            if (document.getElementById('swiper-css') === null) {
                                                document.head.innerHTML += '<link id="swiper-css" rel="stylesheet" href="https://vm.beeteam368.net/wp-content/themes/vidmov/js/swiper-slider/swiper-bundle.min.css" media="all">';
                                            }

                                            import Swiper
                                                from './assets/js/vendor/swiper.js';

                                            var beeteam368_slider_305161656250291_params = {
                                                "navigation": {
                                                    "nextEl": ".slider-button-next",
                                                    "prevEl": ".slider-button-prev"
                                                },
                                                "pagination": {
                                                    "el": ".swiper-pagination",
                                                    "clickable": true,
                                                    "type": "progressbar"
                                                },
                                                "breakpoints": {
                                                    "0": {"slidesPerView": 1, "spaceBetween": 20},
                                                    "768": {"slidesPerView": 2, "spaceBetween": 20},
                                                    "992": {"slidesPerView": 3, "spaceBetween": 20},
                                                    "1200": {"slidesPerView": 3, "spaceBetween": 30},
                                                    "1670": {"slidesPerView": 4, "spaceBetween": 30},
                                                    "2200": {"slidesPerView": 5, "spaceBetween": 30}
                                                },
                                                "freeMode": {"enabled": true, "sticky": true}
                                            };


                                            const beeteam368_slider_305161656250291 = new Swiper('#beeteam368_slider_305161656250291', beeteam368_slider_305161656250291_params);

                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </article>
    <?php require('includes/footer.php'); ?>
</div>
<?php require('includes/popup_add.php'); ?>
<?php require('includes/scripts.php'); ?>
</body>
</html>