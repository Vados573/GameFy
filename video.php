<?php
session_start();
require('includes/config.php');
require('includes/global_functions.php');
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
<!--oncontextmenu="return false"-->
<body>
<?php require('includes/sidebar.php'); ?>
<div id="beeteam368-site-wrap-parent" class="beeteam368-site-wrap-parent beeteam368-site-wrap-parent-control">
    <?php require('includes/header.php'); ?>
    <?php
    $sql = "SELECT * FROM stream JOIN channel c on stream.id_channel = c.id_channel JOIN user u on c.id_user = u.id_user 
                WHERE is_live_stream = 0 AND id_stream = " . $_GET['id'];
    $result = odbc_exec($con, $sql);
    if ($result == false) {
        header("Location: index.php");
    }
    $stream = odbc_fetch_object($result);
    ?>
    <div id="beeteam368-primary-cw" class="beeteam368-primary-cw">
        <div class="site__container main__container-control" style="margin-bottom: 100px">
            <div id="sidebar-direction" class="site__row flex-row-control sidebar-direction">
                <main id="main-content" class="site__col main-content global-post-page-content">
                    <div class="classic-pos-video-player is-single-post-main-player">
                        <div id="beeteam368_player_75361655217589" class="beeteam368-player beeteam368-player-control">
                            <div class="beeteam368-player-wrapper beeteam368-player-wrapper-control pd-player player-loaded"
                                 style="padding-top:42.5%;">
                                <iframe src="https://embed.api.video/vod/<?php echo $stream->path_video_stream?>" width="100%"
                                        height="100%" frameborder="0" scrolling="no" allowfullscreen="true">

                                </iframe>
                            </div>
                        </div>
                    </div>
                    <div class="beeteam368-single-author flex-row-control flex-vertical-middle">
                        <div class="author-wrapper flex-row-control flex-vertical-middle">
                            <a href="user.php?id=<?php echo $stream->id_user ?>" class="author-avatar-wrap"
                               title="<?php echo $stream->username_user ?>">
                                <img alt="Author Avatar"
                                     src="<?php echo $path ?>"
                                     sizes="(max-width: 61px) 100vw, 61px"
                                     srcset="<?php echo $path ?>"
                                     class="author-avatar" width="61" height="61"> </a>
                            <div class="author-avatar-name-wrap">
                                <h4 class="author-avatar-name max-1line">
                                    <a href="channel.php?id=<?php echo $stream->id_channel ?>"
                                       class="author-avatar-name-link" title="<?php echo $stream->name_channel ?>">
                                        <i class="fas fa-check-circle author-verified is-verified"></i><span><?php echo $stream->name_channel ?></span>
                                    </a>
                                </h4>
                                <span class="author-meta font-meta">
                                <i class="icon far fa-heart"></i><span
                                            class="subscribers-count subscribers-count-control"
                                            data-author-id="1"><span><?php echo $stream->followers_channel ?></span><span
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
                            if ($stream->id_user == $_SESSION['id']) {
                                ?>
                                <div class="author-subscribe">
                                    <button class="subscribe-button is-disabled"><i
                                                class="icon fas fa-user-lock"></i><span>This is your Video</span>
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
                            }
                        }
                        if (intval($_SESSION['is_admin']) == 1 OR $stream->id_user == $_SESSION['id']) {
                            ?>
                            <div class="author-subscribe">
                                <a href="#"
                                   id="<?php echo $_GET['id']; ?>"
                                   data-note="Ban"
                                   class="btnn-default btnn-primary subscribe-button reg-log-popup-control delete-video"
                                   data-author-id="1" data-post-id="-1" style=" background-color: #ff0000">
                                    <i class="icon fas fa-xmark-circle"></i><span>Delete Video</span>
                                </a>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <article id="post-117"
                             class="post-117 vidmov_video type-vidmov_video status-publish has-post-thumbnail hentry tag-y-2017 tag-y-2019 tag-y-2021 tag-animation tag-crime tag-drama tag-french tag-german tag-italy tag-japan tag-japanese tag-kids tag-korea tag-reality tag-soap tag-tv-14 tag-tv-g tag-tv-y tag-war-politics vidmov_video_category-movies">
                        <h2 class="post-description-title">Description:</h2>
                        <div class="entry-content entry-content-in-single collapse-content collapse-content-control" style="min-height: 50px">
                            <p>
                                <?php echo $stream->description_stream ?>
                            </p>
                        </div>
                </main>
            </div>
        </div>
        <?php require('includes/footer.php'); ?>
    </div>
    <?php require('includes/scripts.php'); ?>
</body>
</html>
