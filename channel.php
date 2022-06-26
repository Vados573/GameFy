<?php
require('includes/config.php');
require('includes/global_functions.php');
session_start();
if (!isset($_GET['id'])) {
    header("Location: index.php");
}
?>
<html lang="en">
<head>
    <title>Gamify</title>
    <?php require('includes/head.php');
    ?>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="assets/css/main.css">

</head>
<body>
<?php require('includes/sidebar.php'); ?>
<div id="beeteam368-site-wrap-parent" class="beeteam368-site-wrap-parent beeteam368-site-wrap-parent-control">
    <?php require('includes/header.php'); ?>
    <?php
    $preparation = odbc_prepare($con, "SELECT * FROM user JOIN channel ON user.id_user = channel.id_user WHERE id_channel = ?");
    $result = odbc_execute($preparation, array($_GET['id']));
    if ($result == false) {
        header("Location: index.php");
    }
    $user = odbc_fetch_object($preparation);
    $fileName = $_SERVER["DOCUMENT_ROOT"] . "/GameFy/" . PATH_IMG_USER . $user->id_user . ".jpeg";
    if (file_exists($fileName)) {
        $path = PATH_IMG_USER . $user->id_user . ".jpeg";
    } else {
        $path = "https://secure.gravatar.com/avatar/83232f25bace98c04afdba2ef9eedd8d?s=61&d=mm&r=g";
    }
    $fileName = $_SERVER["DOCUMENT_ROOT"] . "/GameFy/" . PATH_IMG_BANNER . $user->id_user . ".jpeg";
    if (file_exists($fileName)) {
        $path_banner = "url('" . PATH_IMG_BANNER . $user->id_user . ".jpeg')";
    } else {
        $path_banner = null;
    }
    if ($path_banner != null) {
        ?>
        <div class="channel-banner dark-mode"
             style="width: 1920px; height: 400px; background-size: contain!important; background: <?php echo $path_banner; ?>) no-repeat center;">
            <div class="channel-info site__container main__container-control">
                <div class="site__row flex-row-control">
                    <div class="site__col">
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
    <div id="beeteam368-primary-cw" class="beeteam368-primary-cw">
        <div class="site__container main__container-control">
            <div id="sidebar-direction" class="site__row flex-row-control sidebar-direction">
                <main id="main-content" class="site__col main-content global-post-page-content">
                    <div class="beeteam368-single-author mobile-center flex-row-control flex-vertical-middle">
                        <div class="author-wrapper flex-row-control flex-vertical-middle">
                            <a href="#" class="author-avatar-wrap"
                               title="<?php echo $user->name_channel; ?>">
                                <img alt="Author Avatar"
                                     src="<?php echo $path ?>"
                                     sizes="(max-width: 61px) 100vw, 61px"
                                     srcset="<?php echo $path ?>"
                                     class="author-avatar" width="61" height="61"> </a>
                            <div class="author-avatar-name-wrap">
                                <h4 class="author-avatar-name max-1line">
                                    <a href="channel.php?id=<?php echo $_GET['id']; ?>"
                                       class="author-avatar-name-link" title="<?php echo $user->name_channel; ?>">
                                        <i class="far fa-user-circle author-verified"></i><span><?php echo $user->name_channel; ?></span>
                                    </a>
                                </h4>
                                <span class="author-meta font-meta">
<i class="icon far fa-heart"></i><span class="subscribers-count subscribers-count-control"
                                       data-author-id="306"><span><?php echo getMinNumber(intval($user->followers_channel)) ?></span><span
                                                class="info-text">Followers</span></span>
</span>
                            </div>
                        </div>
                        <?php
                        if (!isset($_SESSION['id'])) {
                            ?>
                            <div class="author-subscribe">
                                <a href="login-registration.php"
                                   data-note="Sign in to follow, only logged in users can follow the channel."
                                   class="btnn-default btnn-primary subscribe-button reg-log-popup-control"
                                   data-author-id="1" data-post-id="-1">
                                    <i class="icon far fa-heart"></i><span>Follow</span>
                                </a>
                            </div>
                            <div class="virtual-gifts">
                                <a href="login-registration.php"
                                   data-note="Sign in to subscribe, only logged in users can subscribe to the channel."
                                   class="icon-style reverse tooltip-style btnn-default reg-log-popup-control"
                                   data-author-id="1" data-post-id="-1">
                                    <i class="far fa-star"></i>
                                    <span class="tooltip-text">Subscribe</span>
                                </a>
                            </div>
                            <?php
                        } else {
                            if ($user->id_user == $_SESSION['id']) {
                                ?>
                                <div class="author-subscribe">
                                    <button class="subscribe-button is-disabled"><i
                                                class="icon fas fa-user-lock"></i><span>This is your channel</span>
                                    </button>
                                </div>
                                <?php
                            } else {
                                $preparation = odbc_prepare($con, "SELECT * FROM follow WHERE id_user = " . $_SESSION['id'] . " AND id_channel = " . $_GET['id']);
                                $result = odbc_execute($preparation);
                                if ($result != false) {
                                    $follow = odbc_num_rows($preparation);
                                }
                                if ($follow == 1) {
                                    ?>
                                    <div class="author-subscribe">
                                        <a href="#"
                                           id="<?php echo $_GET['id']; ?>"
                                           data-note="Follow "
                                           class="btnn-default btnn-primary subscribe-button reg-log-popup-control follow-change remove icon-weight"
                                           data-author-id="1" data-post-id="-1" style="background-color: #FF375F">
                                            <i class="icon far fa-heart"
                                               style="font-weight: 900"></i><span>Follow</span>
                                        </a>
                                    </div>
                                    <?php
                                } else {
                                    ?>
                                    <div class="author-subscribe">
                                        <a href="#"
                                           id="<?php echo $_GET['id']; ?>"
                                           data-note="Follow "
                                           class="btnn-default btnn-primary subscribe-button reg-log-popup-control follow-change add icon-weight"
                                           data-author-id="1" data-post-id="-1" style=" background-color: #646464">
                                            <i class="icon far fa-heart"
                                               style="font-weight: 400;"></i><span>Follow</span>
                                        </a>
                                    </div>
                                    <?php
                                }
                                ?>
                                <div class="virtual-gifts">
                                    <a href="#"
                                       class="icon-style reverse tooltip-style btnn-default reg-log-popup-control"
                                       data-author-id="1" data-post-id="-1">
                                        <i class="far fa-star"></i>
                                        <span class="tooltip-text">Subscribe</span>
                                    </a>
                                </div>
                                <?php
                                if (intval($_SESSION['is_admin']) == 1) {
                                    ?>
                                    <div class="author-subscribe">
                                        <a href="#"
                                           id="<?php echo $_GET['id']; ?>"
                                           data-note="Ban"
                                           class="btnn-default btnn-primary subscribe-button reg-log-popup-control ban-change add"
                                           data-author-id="1" data-post-id="-1" style=" background-color: #ff0000">
                                            <i class="icon fas fa-xmark-circle"></i><span>Ban User</span>
                                        </a>
                                    </div>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </div>
                    <div class="channel-tabs">
                        <div id="beeteam368_channel_306"
                             class="swiper tabs-wrapper swiper-initialized swiper-horizontal swiper-pointer-events swiper-free-mode">
                            <div class="swiper-wrapper tabs-content flex-normal-control"
                                 id="swiper-wrapper-56b110f74d8fdc594" aria-live="polite"
                                 style="height: fit-content; justify-content: center;">
                                <a href="#"
                                   class="swiper-slide tab-item active-item swiper-slide-active" title="Stream"
                                   role="group" aria-label="1 / 7">
<span class="beeteam368-icon-item tab-icon">
<i class="fas fa-video"></i>
</span>
                                    <span class="tab-text h5">Stream</span>
                                    <span class="tab-privacy font-meta font-meta-size-10 is-public">Public</span> </a>
                                <a href="#"
                                   class="swiper-slide tab-item swiper-slide-next" title="Videos"
                                   role="group" aria-label="2 / 7">
<span class="beeteam368-icon-item tab-icon">
<i class="fas fa-video"></i>
</span>
                                    <span class="tab-text h5">Videos</span>
                                    <span class="tab-privacy font-meta font-meta-size-10 is-public">Public</span> </a>
                                <a href="#"
                                   class="swiper-slide tab-item" title="Events" role="group"
                                   aria-label="3 / 7">
<span class="beeteam368-icon-item tab-icon">
<i class="fas fa-calendar"></i>
</span>
                                    <span class="tab-text h5">Events</span>
                                    <span class="tab-privacy font-meta font-meta-size-10 is-public">Public</span> </a>
                                <a href="#"
                                   class="swiper-slide tab-item" title="Blogs" role="group" aria-label="4 / 7">
<span class="beeteam368-icon-item tab-icon">
<i class="fas fa-blog"></i>
</span>
                                    <span class="tab-text h5">Blogs</span>
                                    <span class="tab-privacy font-meta font-meta-size-10 is-public">Public</span> </a>
                                <a href="#"
                                   class="swiper-slide tab-item" title="Subscriptions" role="group" aria-label="5 / 7">
<span class="beeteam368-icon-item tab-icon">
<i class="fas fa-star"></i>
</span>
                                    <span class="tab-text h5">Subscriptions</span>
                                    <span class="tab-privacy font-meta font-meta-size-10 is-public">Private</span> </a>
                                <a href="#"
                                   class="swiper-slide tab-item" title="Watch Later" role="group" aria-label="6 / 7">
<span class="beeteam368-icon-item tab-icon">
<i class="fas fa-clock"></i>
</span>
                                    <span class="tab-text h5">Watch Later</span>
                                    <span class="tab-privacy font-meta font-meta-size-10 is-public">Private</span> </a>
                                <a href="#"
                                   class="swiper-slide tab-item" title="About" role="group" aria-label="7 / 7">
<span class="beeteam368-icon-item tab-icon">
<i class="fas fa-scroll"></i>
</span>
                                    <span class="tab-text h5">About</span>
                                    <span class="tab-privacy font-meta font-meta-size-10 is-public">Public</span> </a>
                            </div>
                            <div class="slider-button-prev swiper-button-disabled" tabindex="-1" role="button"
                                 aria-label="Previous slide" aria-controls="swiper-wrapper-56b110f74d8fdc594"
                                 aria-disabled="true"><i class="fas fa-chevron-left"></i></div>
                            <div class="slider-button-next" tabindex="0" role="button" aria-label="Next slide"
                                 aria-controls="swiper-wrapper-56b110f74d8fdc594" aria-disabled="false"><i
                                        class="fas fa-chevron-right"></i></div>
                            <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
                        <script type="module">
                            if (document.getElementById('swiper-css') === null) {
                                document.head.innerHTML += '<link id="swiper-css" rel="stylesheet" href="https://vm.beeteam368.net/wp-content/themes/vidmov/js/swiper-slider/swiper-bundle.min.css" media="all">';
                            }

                            import Swiper
                                from './assets/js/vendor/swiper.js';

                            var beeteam368_channel_306_params = {
                                'navigation': {
                                    'nextEl': '.slider-button-next',
                                    'prevEl': '.slider-button-prev'
                                },
                                'spaceBetween': 0,
                                'slidesPerView': 'auto',
                                'freeMode': true,
                                'freeModeSticky': true,
                                'on': {
                                    init: function (swiper) {
                                        var parent_item = jQuery('#beeteam368_channel_306');
                                        var active_item = parent_item.find('.tab-item.active-item');
                                        if (active_item.length > 0) {
                                            var offset = active_item.offset();
                                            var check_left = offset.left + active_item.outerWidth();

                                            if (check_left > parent_item.offset().left + parent_item.outerWidth()) {
                                                swiper.slideTo(active_item.index(), 1000);
                                            }
                                        }
                                    }
                                }
                            }

                            const beeteam368_channel_306 = new Swiper('#beeteam368_channel_306', beeteam368_channel_306_params);
                        </script>
                    </div>
                    <div class="channel-content is-tab-content-stream" data-id="306">
                        <div class="site__container main__container-control">
                            <div id="sidebar-direction" class="site__row flex-row-control sidebar-direction">
                                <iframe src="https://embed.api.video/live/<?php echo $user->stream_id ?>"
                                        width="100%"
                                        height="100%" frameborder="0" scrolling="no"
                                        allowfullscreen="true" style="min-height: 500px"></iframe>
                            </div>
                        </div>
                        <aside id="main-sidebar" style="margin-bottom: 10px" class="site__col main-sidebar">
                            <div class="sidebar-content">
                                <div id="beeteam368_channel_extensions-2"
                                     class="widget r-widget-control vidmov-channel-extensions">
                                    <h2 class="h3 widget-title flex-row-control flex-vertical-middle"><span
                                                class="beeteam368-icon-item"><i class="fas fa-comment"></i></span>
                                        <span class="widget-title-wrap max-1line">Chat:
                                        <span class="wg-line">

                                        </span>
                                    </span>
                                    </h2>
                                    <div id="blog_wrapper_524805101655217589"
                                         class="blog-wrapper global-blog-wrapper blog-wrapper-control flex-row-control site__row">
                                        <article class="post-item site__col flex-row-control">
                                            <div class="post-item-wrap">
                                                <div class="author-wrapper flex-row-control flex-vertical-middle">
                                                    <div class="comments-area">
                                                        <ol class="comment-list">
                                                            <li id="comment-142"
                                                                class="comment byuser comment-author-rodav375 even thread-even depth-1">
                                                                <article id="div-comment-142" class="comment-body">
                                                                    <footer class="comment-meta">
                                                                        <div class="comment-author vcard">
                                                                            <img alt=""
                                                                                 src="https://secure.gravatar.com/avatar/83232f25bace98c04afdba2ef9eedd8d?s=61&amp;d=mm&amp;r=g"
                                                                                 srcset="https://secure.gravatar.com/avatar/83232f25bace98c04afdba2ef9eedd8d?s=122&amp;d=mm&amp;r=g 2x"
                                                                                 class="avatar avatar arm_grid_avatar arm-avatar avatar-61 photo"
                                                                                 width="61" height="61"> <b class="fn">rodav573</b>
                                                                            <span class="says">says:</span></div>
                                                                        <div class="comment-metadata">
                                                                            <a href="https://vm.beeteam368.net/video/call-of-duty-vanguard/#comment-142">
                                                                                <time datetime="2022-06-26T12:47:47+00:00">
                                                                                    June 26, 2022 at 12:47 pm
                                                                                </time>
                                                                            </a></div>
                                                                    </footer>
                                                                    <div class="comment-content">
                                                                        KEKW
                                                                    </div>
                                                                </article>
                                                            </li>
                                                        </ol>
                                                    </div>
                                                </div>
                                            </div>
                                        </article>
                                    </div>
                                </div>
                                <div class="tml-field-wrap">
                                    <input type="text" class="tml-field" placeholder="Chat now!" style="width: 90%;">
                                </div>
                        </aside>
                    </div>
                    <?php
                    if (isset($_SESSION['id'])) {
                        if ($_SESSION['id'] == $user->id_user) {
                            ?>
                            <div class="channel-content is-tab-content-stream" data-id="306">
                                <?php
                                $flag = 0;
                                if (!isset($_SESSION['id'])) {
                                    $flag = 1;
                                } elseif ($user->id_user != $_SESSION['id']) {
                                    $flag = 1;
                                }
                                if ($flag == 0) {
                                    $disabled = "";
                                    $nameStream = "";
                                    $descStream = "";
                                    $id_game = 0;
                                    $is_recorded = 0;
                                    $hide = "text";
                                    if (intval($user->is_live) == 1) {
                                        $disabled = "disabled";
                                        $preparation = odbc_prepare($con, "SELECT name_stream, description_stream, is_recorded, id_game FROM stream where is_live_stream = 1 AND id_channel = ?");
                                        $values = array();
                                        $values[] = $user->id_channel;
                                        $result = odbc_execute($preparation, $values);
                                        $hide = "password";
                                        if ($result != false) {
                                            $stream = odbc_fetch_object($preparation);
                                            $nameStream = $stream->name_stream;
                                            $descStream = $stream->description_stream;
                                            $id_game = intval($stream->id_game);
                                            $is_recorded = intval($stream->is_recorded);
                                        }
                                    }
                                    ?>
                                    <div class="site__container main__container-control">
                                        <div id="sidebar-direction"
                                             class="site__row flex-row-control sidebar-direction">
                                            <main id="main-content"
                                                  class="site__col main-content global-post-page-content">
                                                <article id="post-0"
                                                         class="post-0 page type-page status-publish hentry">
                                                    <header class="entry-header single-page-title">
                                                        <h1 class="entry-title h1-single">Stream</h1>
                                                    </header>
                                                    <hr class="space-section">
                                                    <h2 class="h1 h3-mobile profile-section-title">Stream
                                                        Parameters</h2>
                                                    <div class="tml tml-update-profile">
                                                        <div class="tml-alerts password-section-alerts-control"></div>
                                                        <form name="update-password" class="form-password-control"
                                                              method="post" enctype="multipart/form-data">
                                                            <div class="tml-field-wrap tml-user_pass1-wrap">
                                                                <label class="tml-label" for="pass1">Stream Key:</label>
                                                                <input name="user_pass1"
                                                                       value="<?php echo $user->streamKey_channel ?>"
                                                                       disabled
                                                                       type="<?php echo $hide ?>" id="streamKey"
                                                                       autocomplete="off"
                                                                       class="tml-field"
                                                                       style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR4nGP6zwAAAgcBApocMXEAAAAASUVORK5CYII=&quot;);">
                                                            </div>
                                                            <div class="tml-field-wrap tml-user_pass2-wrap">
                                                                <label class="tml-label" for="pass2">Stream
                                                                    Server:</label>
                                                                <input name="user_pass2"
                                                                       value="rtmp://broadcast.api.video/s" type="text"
                                                                       disabled id="streamServer" autocomplete="off"
                                                                       class="tml-field"
                                                                       style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR4nGP6zwAAAgcBApocMXEAAAAASUVORK5CYII=&quot;);">
                                                            </div>
                                                            <div class="tml-field-wrap tml-indicator-wrap">
                                                                <div id="pass-strength-result" class="hide-if-no-js bad"
                                                                     aria-live="polite">Never share your stream key with
                                                                    anyone. Gamify employees will never ask for your
                                                                    streaming key.
                                                                </div>
                                                            </div>
                                                            <div class="tml-field-wrap tml-indicator_hint-wrap">
                                                                <p class="description indicator-hint">Hint: You should
                                                                    use a
                                                                    streaming application like OBS studio.</p>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <hr class="space-section">
                                                    <h2 class="h1 h3-mobile profile-section-title">Stream
                                                        Customization</h2>
                                                    <div class="tml tml-update-profile">
                                                        <div class="tml-alerts password-section-alerts-control"></div>
                                                        <form name="update-password" class="form-password-control"
                                                              method="post" enctype="multipart/form-data">
                                                            <div class="tml-field-wrap tml-user_pass1-wrap">
                                                                <label class="tml-label" for="streamName">Stream
                                                                    Name:</label>
                                                                <input name="stream_name"
                                                                       value="<?php echo $nameStream ?>"
                                                                       type="text"
                                                                       id="streamName" autocomplete="off"
                                                                       class="tml-field"
                                                                       style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR4nGP6zwAAAgcBApocMXEAAAAASUVORK5CYII=&quot;);" <?php echo $disabled ?>>
                                                            </div>
                                                            <div class="tml-field-wrap tml-user_pass2-wrap">
                                                                <label class="tml-label" for="pass2">Stream
                                                                    Description:</label>
                                                                <input name="streamDesc" <?php echo $disabled ?>
                                                                       value="<?php echo $descStream ?>" type="text"
                                                                       id="streamDesc" autocomplete="off"
                                                                       class="tml-field"
                                                                       style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR4nGP6zwAAAgcBApocMXEAAAAASUVORK5CYII=&quot;);">
                                                            </div>
                                                            <?php
                                                            $sql = "SELECT * FROM game;";
                                                            $result = odbc_exec($con, $sql);
                                                            ?>
                                                            <div class="tml-field-wrap">
                                                                <label for="streamGames"
                                                                       class="tml-label">Games:</label>
                                                                <select name="streamGames" id="streamGames"
                                                                        class="privacy-option" <?php echo $disabled ?>>
                                                                    <?php
                                                                    if ($id_game == 0) {
                                                                        ?>
                                                                        <option value="0" selected> ----- Select your
                                                                            game
                                                                            -----
                                                                        </option>
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                        <option value="0"> ----- Select your game
                                                                            -----
                                                                        </option>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                    <?php
                                                                    while ($table = odbc_fetch_object($result)) {
                                                                        if (intval($table->id_game) == $id_game) {
                                                                            ?>
                                                                            <option value="<?php echo $table->id_game ?>"
                                                                                    selected><?php echo $table->name_game ?></option>
                                                                            <?php
                                                                        } else {
                                                                            ?>
                                                                            <option value="<?php echo $table->id_game ?>"><?php echo $table->name_game ?></option>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <div class="tml-field-wrap">
                                                                <label for="is_record" class="tml-label">Do you want to
                                                                    record your stream?</label>
                                                                <?php
                                                                if ($is_recorded == 0) {
                                                                    ?>
                                                                    <input type="checkbox" class="checkbox-element"
                                                                           id="is_record">
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <input type="checkbox" class="checkbox-element"
                                                                           id="is_record" checked>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </div>
                                                            <div class="tml-field-wrap tml-submit-wrap">
                                                                <?php
                                                                if (intval($user->is_live) == 0) {
                                                                    ?>
                                                                    <button type="button"
                                                                            class="tml-button loadmore-btn go-live live-button"
                                                                            data-id="<?php echo $user->id_channel ?>">
                                                                        <span class="loadmore-text loadmore-text-control">Go Live</span>
                                                                    </button>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <button type="button"
                                                                            class="tml-button loadmore-btn stop-live live-button"
                                                                            data-id="<?php echo $user->id_channel ?>">
                                                                        <span class="loadmore-text loadmore-text-control">Stop Live</span>
                                                                    </button>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </article>
                                            </main>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                        }
                    }
                    ?>
                    <div class="channel-content is-tab-content-videos" data-id="306" style="display: none">
                        <div class="blog-info-filter site__row flex-row-control flex-row-space-between flex-vertical-middle filter-blog-style-lily">
                            <div class="posts-filter site__col">
                                <div class="filter-block filter-block-control">
                                    <span class="default-item default-item-control">
                                    <i class="fas fa-sort-numeric-up-alt"></i>
                                    <span>Sort by: Newest Items </span>
                                    <i class="arr-icon fas fa-chevron-down"></i>
                                    </span>
                                    <div class="drop-down-sort drop-down-sort-control">
                                        <a href="https://vm.beeteam368.net/channel/channel-id/1/?pagename=channel&amp;channel-id=1&amp;paged=1&amp;sort_by=new"
                                           title="Newest Items"><i class="fil-icon far fa-arrow-alt-circle-right"></i>
                                            <span>Newest Items</span></a>
                                        <a href="https://vm.beeteam368.net/channel/channel-id/1/?pagename=channel&amp;channel-id=1&amp;paged=1&amp;sort_by=old"
                                           title="Oldest Items"><i class="fil-icon far fa-arrow-alt-circle-right"></i>
                                            <span>Oldest Items</span></a>
                                        <a href="https://vm.beeteam368.net/channel/channel-id/1/?pagename=channel&amp;channel-id=1&amp;paged=1&amp;sort_by=title_a_z"
                                           title="Alphabetical (A-Z)"><i
                                                    class="fil-icon far fa-arrow-alt-circle-right"></i> <span>Alphabetical (A-Z)</span></a>
                                        <a href="https://vm.beeteam368.net/channel/channel-id/1/?pagename=channel&amp;channel-id=1&amp;paged=1&amp;sort_by=title_z_a"
                                           title="Alphabetical (Z-A)"><i
                                                    class="fil-icon far fa-arrow-alt-circle-right"></i> <span>Alphabetical (Z-A)</span></a>
                                        <a href="https://vm.beeteam368.net/channel/channel-id/1/?pagename=channel&amp;channel-id=1&amp;paged=1&amp;sort_by=highest_rating"
                                           title="Highest Rating"><i class="fil-icon far fa-arrow-alt-circle-right"></i>
                                            <span>Highest Rating</span></a>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $sql = "SELECT count(*) as counter FROM stream WHERE is_live_stream = 0 AND id_channel = $user->id_channel AND path_video_stream IS NOT null ORDER BY date_stream";
                            $result = odbc_exec($con, $sql);
                            $num_rows = odbc_fetch_object($result);
                            $sql = "SELECT * FROM stream WHERE is_live_stream = 0 AND id_channel = $user->id_channel AND path_video_stream IS NOT null";
                            $result = odbc_exec($con, $sql);
                            ?>
                            <div class="total-posts site__col">
                                <div class="total-posts-content">
                                    <i class="far fa-chart-bar"></i>
                                    <span>There are <?php echo $num_rows->counter ?> items in this tab </span>
                                </div>
                            </div>
                        </div>
                        <div id="blog_wrapper_21362633751656239639"
                             class="blog-wrapper global-blog-wrapper blog-wrapper-control flex-row-control site__row blog-style-lily">
                            <?php
                            while ($table = odbc_fetch_object($result)) {
                                ?>
                                <article id="post-550"
                                         class="post-item site__col flex-row-control post-550 vidmov_video type-vidmov_video status-publish has-post-thumbnail hentry tag-y-2017 tag-y-2019 tag-y-2021 tag-animation tag-crime tag-drama tag-french tag-german tag-italy tag-japan tag-japanese tag-kids tag-korea tag-reality tag-soap tag-tv-14 tag-tv-g tag-tv-y tag-war-politics vidmov_video_category-gaming">
                                    <div class="post-item-wrap">
                                        <div class="post-featured-image preview-mode-control" data-id="550">
                                            <a data-post-id="550" data-post-type="vidmov_video"
                                               href="<?php ?>"
                                               title="<?php echo $table->name_stream ?>"
                                               class="blog-img-link blog-img-link-control">
                                                <img src="https://cdn.api.video/vod/<?php echo $table->path_video_stream ?>/thumbnail.jpg"
                                                     class="blog-img" alt=""
                                                     srcset="https://cdn.api.video/vod/<?php echo $table->path_video_stream ?>/thumbnail.jpg">
                                            </a>
                                            <div class="beeteam368-bt-ft-img second-show flex-row-control flex-vertical-middle tiny-icons dark-mode">
                                            <span class="beeteam368-icon-item add-to-watch-later add-to-watch-later-control tooltip-style "
                                                  data-id="550">
                                                <i class="fas fa-clock"></i>
                                            </span>
                                                <?php
                                                if ($user->id_user == $_SESSION['id']) {
                                                    ?>
                                                    <span class="beeteam368-icon-item add-to-watch-later delete-video tooltip-style "
                                                          style="margin: 0; background-color: #c52121">
                                                <i class="fas fa-xmark"></i>
                                            </span>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="beeteam368-bt-ft-img first-show flex-row-control flex-vertical-middle">
                                                <h3 class="entry-title post-title max-2lines h4 h5-mobile">
                                                    <a class="post-listing-title"
                                                       href="https://vm.beeteam368.net/video/call-of-duty-vanguard/"
                                                       title="<?php echo $table->name_stream ?>"><?php echo $table->name_stream ?></a>
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="posted-on top-post-meta font-meta">
                                            <time class="entry-date published">
                                                <?php
                                                echo get_time_ago(strtotime($table->date_stream));
                                                ?>
                                            </time>
                                        </div>
                                    </div>
                                </article>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
    <?php require('includes/footer.php'); ?>
</div>
<?php require('includes/popup_add.php'); ?>
<?php require('includes/scripts.php'); ?>
</body>