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
                                                <span class="main-title">Top Videos</span> <span class="hd-line"></span>
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
                                                        <!--           TODO:    Add sql loop here for mini slider on the right                                         -->
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
                                                     aria-disabled="false"><i class="fas fa-long-arrow-alt-right"></i>
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
            </div>
        </div>
    </article>
    <?php require('includes/footer.php'); ?>
</div>
<?php require('includes/scripts.php'); ?>
</body>
</html>