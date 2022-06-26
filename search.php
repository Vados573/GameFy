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
<body>
<?php
$sql = 'SELECT id_channel as id_search, name_channel as name_search, is_live as is_live, type_search, id_user, username_user, followers_channel as metrics, description_channel as description, secondary_id FROM
        (SELECT id_channel, name_channel, is_live, "Channel" as type_search, channel.id_user, user.username_user, channel.followers_channel, channel.description_channel, false as secondary_id FROM channel JOIN user ON user.id_user = channel.id_user
        WHERE LOWER(channel.name_channel) LIKE "%' . $_GET['s'] . '%" OR LOWER(channel.name_channel) LIKE "' . $_GET['s'] . '%" OR LOWER(channel.name_channel) LIKE "%' . $_GET['s'] . '" 
        UNION ALL 
        SELECT id_stream, name_stream, is_live_stream, "Stream", channel.id_user, user.username_user, stream.views_stream, stream.description_stream, channel.id_channel FROM stream JOIN channel ON channel.id_channel = stream.id_channel JOIN user ON user.id_user = channel.id_user
        WHERE LOWER(stream.name_stream) LIKE "%' . $_GET['s'] . '%" OR LOWER(stream.name_stream) LIKE "' . $_GET['s'] . '%" OR LOWER(stream.name_stream) LIKE "%' . $_GET['s'] . '" 
        UNION ALL 
        SELECT id_user, username_user, false, "Users", false, false, false, user.description_user, false FROM user 
        WHERE LOWER(user.username_user) LIKE "%' . $_GET['s'] . '%" OR LOWER(user.username_user) LIKE "%' . $_GET['s'] . '" OR LOWER(user.username_user) LIKE "' . $_GET['s'] . '%"  
        ) as search ORDER BY CASE 
        WHEN LOWER(name_search) = "' . $_GET['s'] . '" THEN 0 WHEN LOWER(name_search) LIKE "' . $_GET['s'] . '%" THEN 1 WHEN LOWER(name_search) LIKE "%' . $_GET['s'] . '%" THEN 2 WHEN LOWER(name_search) LIKE "%' . $_GET['s'] . '" THEN 3 
        ELSE 4 END, name_search ASC, metrics DESC';
$r = odbc_exec($con, $sql);
$number_of_rows = odbc_num_rows($r);
?>
<?php require('includes/sidebar.php'); ?>
<div id="beeteam368-site-wrap-parent" class="beeteam368-site-wrap-parent beeteam368-site-wrap-parent-control">
    <?php require('includes/header.php'); ?>
    <div id="beeteam368-primary-cw" class="beeteam368-primary-cw" style="background-color:var(--color__body-background);">
        <div class="site__container main__container-control">
            <div id="sidebar-direction" class="site__row flex-row-control sidebar-direction">
                <main id="main-content" class="site__col main-content">
                    <div class="top-section-title in-search-page has-icon">
                        <span class="beeteam368-icon-item trending-icon"><i class="fas fa-search"></i></span>
                        <span class="sub-title font-main">Search Page</span>
                        <h2 class="h2 h3-mobile main-title-heading">
                            <span class="main-title">Search Results for: <?php echo $_GET['s'] ?></span> <span
                                    class="hd-line"></span>
                        </h2>
                    </div>
                    <div class="blog-info-filter site__row flex-row-control flex-row-space-between flex-vertical-middle filter-blog-style-alyssa">
                        <div class="posts-filter site__col">
                            <div class="filter-block filter-block-control">
                                <span class="default-item default-item-control">
                                <i class="fas fa-sort-numeric-up-alt"></i>
                                    <span id="principal_filter">
                                        <a class="filtering" data-id="0" href="" title="Filter: No Filter"><span>Filter: No Filter</span></a>
                                    </span>
                                <i class="arr-icon fas fa-chevron-down"></i>
                                </span>
                                <div class="drop-down-sort drop-down-sort-control">
                                    <a class="filtering selected-filter" data-id="0" href="" title="Filter: No Filter"><span>Filter: No Filter</span></a>
                                    <a class="filtering" data-id="1" href="" title="Filter: Channels"><span>Filter: Channels</span></a>
                                    <a class="filtering" data-id="2" href="" title="Filter: Streams"><span>Filter: Streams</span></a>
                                    <a class="filtering" data-id="3" href="" title="Filter: Videos"><span>Filter: Videos</span></a>
                                    <a class="filtering" data-id="4" href="" title="Filter: Users"><span>Filter: Users</span></a>
                                </div>
                            </div>
                        </div>
                        <div class="total-posts site__col">
                            <div class="total-posts-content">
                                <i class="far fa-chart-bar"></i>
                                <span id="number_elements"> There are <?php echo $number_of_rows ?> items in this page </span>
                            </div>
                        </div>
                    </div>
                    <div id="beeteam368_main-search-page"
                         class="blog-wrapper global-blog-wrapper blog-wrapper-control flex-row-control site__row blog-style-alyssa">
                        <?php
                        while ($table = odbc_fetch_object($r)) {
                            if ($table->type_search == "Users") {
                                $id_user = $table->id_search;
                                $username = $table->name_search;
                            } else {
                                $id_user = $table->id_user;
                                $username = $table->username_user;
                            }
                            $fileName = $_SERVER["DOCUMENT_ROOT"] . "/GameFy/" . PATH_IMG_USER . $id_user . ".jpeg";
                            if (file_exists($fileName)) {
                                $path = PATH_IMG_USER . $id_user . ".jpeg";
                            } else {
                                $path = "https://secure.gravatar.com/avatar/83232f25bace98c04afdba2ef9eedd8d?s=61&d=mm&r=g";
                            }
                            if ($table->type_search == "Channel") {
                                $fileName = $_SERVER["DOCUMENT_ROOT"] . "/GameFy/" . PATH_IMG_CHANNEL . $table->id_search . ".jpeg";
                                if (file_exists($fileName)) {
                                    $path_channel = PATH_IMG_CHANNEL . $table->id_search . ".jpeg";
                                } else {
                                    $path_channel = "https://i.pinimg.com/originals/3e/f1/d4/3ef1d460e6bb89eaa7d2fcf283795191.jpg";
                                }
                                ?>
                                <article id="post-<?php echo $id_user ?>"
                                         class="post-item site__col flex-row-control post-550 vidmov_video type-vidmov_video status-publish has-post-thumbnail hentry tag-y-2017 tag-y-2019 tag-y-2021 tag-animation tag-crime tag-drama tag-french tag-german tag-italy tag-japan tag-japanese tag-kids tag-korea tag-reality tag-soap tag-tv-14 tag-tv-g tag-tv-y tag-war-politics vidmov_video_category-gaming">
                                    <div class="post-item-wrap flex-column-control">
                                        <div class="blog-author-element flex-row-control flex-vertical-middle">
                                            <a href="<?php ?>" class="author-avatar-wrap"
                                               title="<?php echo ucfirst($username)?>">
                                                <img alt="Author Avatar"
                                                     src="<?php echo $path ?>"
                                                     sizes="(max-width: 50px) 100vw, 50px"
                                                     srcset="<?php echo $path ?>"
                                                     class="author-avatar" width="50" height="50"> </a>
                                            <div class="author-avatar-name-wrap">
                                                <h5 class="author-avatar-name max-1line">
                                                    <a href=""
                                                       class="author-avatar-name-link" title="<?php echo ucfirst($username) ?>">
                                                        <?php
                                                        if ($table->is_live == "1") {
                                                            ?>
                                                            <i class="fas fa-check-circle author-verified is-verified"></i>
                                                            <?php
                                                        }
                                                        ?>
                                                        <span><?php echo ucfirst($username) ?></span>
                                                    </a>
                                                </h5>
                                                <span class="author-meta font-meta">
                                            <i class="icon far fa-heart"></i><span
                                                            class="subscribers-count subscribers-count-control"
                                                            data-author-id="1"><span><?php echo getMinNumber($table->metrics) ?></span><span
                                                                class="info-text">Followers</span></span>
</span>
                                            </div>
                                        </div>
                                        <div class="post-featured-image preview-mode-control" data-id="550">
                                            <a data-post-id="550" data-post-type="vidmov_video"
                                               href="<?php ?>"
                                               title="<?php echo ucfirst($username) ?>"
                                               class="blog-img-link blog-img-link-control"><img
                                                        src="<?php echo $path_channel ?>"
                                                        class="blog-img" alt=""
                                                        srcset="<?php echo $path_channel ?>"
                                                        sizes="(max-width: 420px) 100vw, 420px" width="420"
                                                        height="237"></a>
                                        </div>
                                        <div class="posted-on top-post-meta font-meta">
                                            <a data-tax-id="tax_5" data-tax="vidmov_video_category"
                                               data-post-type="vidmov_video"
                                               href="<?php ?>" title="<?php echo "Channel" ?>"
                                               class="category-item"
                                               style="color:#ff5100"><?php echo "Channel" ?></a><span
                                                    class="seperate"></span>
                                        </div>
                                        <h3 class="entry-title post-title max-2lines h4-mobile">
                                            <a class="post-listing-title"
                                               href="channel.php?id=<?php echo $table->id_search?>"
                                               title="<?php ?>"><?php echo $table->name_search ?></a>
                                        </h3>
                                        <div class="entry-content post-excerpt">
                                            <?php echo utf8_encode($table->description) ?>
                                        </div>
                                    </div>
                                </article>
                                <?php
                            }
                            elseif ($table->type_search == "Stream" and $table->is_live == "1") {
                                $fileName = $_SERVER["DOCUMENT_ROOT"] . "/GameFy/" . PATH_IMG_CHANNEL . $table->secondary_id . ".jpeg";
                                if (file_exists($fileName)) {
                                    $path_channel = PATH_IMG_CHANNEL . $table->secondary_id . ".jpeg";
                                } else {
                                    $path_channel = "https://i.pinimg.com/originals/3e/f1/d4/3ef1d460e6bb89eaa7d2fcf283795191.jpg";
                                }
                                ?>
                                <article id="post-<?php echo $id_user ?>"
                                         class="post-item site__col flex-row-control post-550 vidmov_video type-vidmov_video status-publish has-post-thumbnail hentry tag-y-2017 tag-y-2019 tag-y-2021 tag-animation tag-crime tag-drama tag-french tag-german tag-italy tag-japan tag-japanese tag-kids tag-korea tag-reality tag-soap tag-tv-14 tag-tv-g tag-tv-y tag-war-politics vidmov_video_category-gaming">
                                    <div class="post-item-wrap flex-column-control">
                                        <div class="blog-author-element flex-row-control flex-vertical-middle">
                                            <a href="<?php ?>" class="author-avatar-wrap"
                                               title="<?php echo ucfirst($username) ?>">
                                                <img alt="Author Avatar"
                                                     src="<?php echo $path ?>"
                                                     sizes="(max-width: 50px) 100vw, 50px"
                                                     srcset="<?php echo $path ?>"
                                                     class="author-avatar" width="50" height="50"> </a>
                                            <div class="author-avatar-name-wrap">
                                                <h5 class="author-avatar-name max-1line">
                                                    <a href="<?php ?>"
                                                       class="author-avatar-name-link" title="<?php echo ucfirst($username) ?>">
                                                        <?php
                                                        if ($table->is_live == "1") {
                                                            ?>
                                                            <i class="fas fa-check-circle author-verified is-verified"></i>
                                                            <?php
                                                        }
                                                        ?>
                                                        <span><?php echo ucfirst($username) ?></span>
                                                    </a>
                                                </h5>
                                                <span class="author-meta font-meta">
                                            <i class="icon far fa-eye"></i><span
                                                            class="subscribers-count subscribers-count-control"
                                                            data-author-id="1"><span><?php echo getMinNumber($table->metrics) ?></span><span
                                                                class="info-text">Viewers</span></span>
</span>
                                            </div>
                                        </div>
                                        <div class="post-featured-image preview-mode-control" data-id="550">
                                            <a data-post-id="550" data-post-type="vidmov_video"
                                               href="<?php ?>"
                                               title="<?php echo ucfirst($username) ?>"
                                               class="blog-img-link blog-img-link-control"><img
                                                        src="<?php echo $path_channel ?>"
                                                        class="blog-img" alt=""
                                                        srcset="<?php echo $path_channel ?>"
                                                        sizes="(max-width: 420px) 100vw, 420px" width="420"
                                                        height="237"></a>
                                        </div>
                                        <div class="posted-on top-post-meta font-meta">
                                            <a data-tax-id="tax_5" data-tax="vidmov_video_category"
                                               data-post-type="vidmov_video"
                                               href="<?php ?>" title="<?php echo "Stream" ?>"
                                               class="category-item"
                                               style="color:#51ff00"><?php echo "Stream" ?></a><span
                                                    class="seperate"></span>
                                        </div>
                                        <h3 class="entry-title post-title max-2lines h4-mobile">
                                            <a class="post-listing-title"
                                               href="<?php ?>"
                                               title="<?php ?>"><?php echo $table->name_search ?></a>
                                        </h3>
                                        <div class="entry-content post-excerpt">
                                            <?php echo utf8_encode($table->description) ?>
                                        </div>
                                    </div>
                                </article>
                                <?php
                            }
                            elseif($table->type_search == "Stream" AND $table->is_live == "0"){
                                $fileName = $_SERVER["DOCUMENT_ROOT"] . "/GameFy/" . PATH_IMG_CHANNEL . $table->secondary_id . ".jpeg";
                                if (file_exists($fileName)) {
                                    $path_channel = PATH_IMG_CHANNEL . $table->secondary_id . ".jpeg";
                                } else {
                                    $path_channel = "https://i.pinimg.com/originals/3e/f1/d4/3ef1d460e6bb89eaa7d2fcf283795191.jpg";
                                }
                                ?>
                                <article id="post-<?php echo $id_user ?>"
                                         class="post-item site__col flex-row-control post-550 vidmov_video type-vidmov_video status-publish has-post-thumbnail hentry tag-y-2017 tag-y-2019 tag-y-2021 tag-animation tag-crime tag-drama tag-french tag-german tag-italy tag-japan tag-japanese tag-kids tag-korea tag-reality tag-soap tag-tv-14 tag-tv-g tag-tv-y tag-war-politics vidmov_video_category-gaming">
                                    <div class="post-item-wrap flex-column-control">
                                        <div class="blog-author-element flex-row-control flex-vertical-middle">
                                            <a href="<?php ?>" class="author-avatar-wrap"
                                               title="<?php echo ucfirst($username) ?>">
                                                <img alt="Author Avatar"
                                                     src="<?php echo $path ?>"
                                                     sizes="(max-width: 50px) 100vw, 50px"
                                                     srcset="<?php echo $path ?>"
                                                     class="author-avatar" width="50" height="50"> </a>
                                            <div class="author-avatar-name-wrap">
                                                <h5 class="author-avatar-name max-1line">
                                                    <a href="<?php ?>"
                                                       class="author-avatar-name-link" title="<?php echo ucfirst($username) ?>">
                                                        <?php
                                                        if ($table->is_live == "1") {
                                                            ?>
                                                            <i class="fas fa-check-circle author-verified is-verified"></i>
                                                            <?php
                                                        }
                                                        ?>
                                                        <span><?php echo ucfirst($username) ?></span>
                                                    </a>
                                                </h5>
                                                <span class="author-meta font-meta">
                                            <i class="icon far fa-eye"></i><span
                                                            class="subscribers-count subscribers-count-control"
                                                            data-author-id="1"><span><?php echo getMinNumber($table->metrics) ?></span><span
                                                                class="info-text">Viewers</span></span>
</span>
                                            </div>
                                        </div>
                                        <div class="post-featured-image preview-mode-control" data-id="550">
                                            <a data-post-id="550" data-post-type="vidmov_video"
                                               href="<?php ?>"
                                               title="<?php echo ucfirst($username) ?>"
                                               class="blog-img-link blog-img-link-control"><img
                                                        src="<?php echo $path_channel ?>"
                                                        class="blog-img" alt=""
                                                        srcset="<?php echo $path_channel ?>"
                                                        sizes="(max-width: 420px) 100vw, 420px" width="420"
                                                        height="237"></a>
                                        </div>
                                        <div class="posted-on top-post-meta font-meta">
                                            <a data-tax-id="tax_5" data-tax="vidmov_video_category"
                                               data-post-type="vidmov_video"
                                               href="<?php ?>" title="<?php echo "Video" ?>"
                                               class="category-item"
                                               style="color:#ff375f"><?php echo "Video" ?></a><span
                                                    class="seperate"></span>
                                        </div>
                                        <h3 class="entry-title post-title max-2lines h4-mobile">
                                            <a class="post-listing-title"
                                               href="<?php ?>"
                                               title="<?php ?>"><?php echo $table->name_search ?></a>
                                        </h3>
                                        <div class="entry-content post-excerpt">
                                            <?php echo utf8_encode($table->description) ?>
                                        </div>
                                    </div>
                                </article>
                                <?php
                            }
                            elseif($table->type_search == "Users"){
                                ?>
                                <article id="post-<?php echo $id_user ?>"
                                         class="post-item site__col flex-row-control post-550 vidmov_video type-vidmov_video status-publish has-post-thumbnail hentry tag-y-2017 tag-y-2019 tag-y-2021 tag-animation tag-crime tag-drama tag-french tag-german tag-italy tag-japan tag-japanese tag-kids tag-korea tag-reality tag-soap tag-tv-14 tag-tv-g tag-tv-y tag-war-politics vidmov_video_category-gaming">
                                    <div class="post-item-wrap flex-column-control">
                                        <div class="blog-author-element flex-row-control flex-vertical-middle">
                                            <a href="<?php ?>" class="author-avatar-wrap"
                                               title="<?php echo ucfirst($username) ?>">
                                                <img alt="Author Avatar"
                                                     src="<?php echo $path ?>"
                                                     sizes="(max-width: 50px) 100vw, 50px"
                                                     srcset="<?php echo $path ?>"
                                                     class="author-avatar" width="50" height="50"> </a>
                                            <div class="author-avatar-name-wrap">
                                                <h5 class="author-avatar-name max-1line">
                                                    <a href="<?php ?>"
                                                       class="author-avatar-name-link" title="<?php echo ucfirst($username) ?>">
                                                        <span><?php echo ucfirst($username) ?></span>
                                                    </a>
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="posted-on top-post-meta font-meta">
                                            <a data-tax-id="tax_5" data-tax="vidmov_video_category"
                                               data-post-type="vidmov_video"
                                               href="<?php ?>" title="<?php echo "User" ?>"
                                               class="category-item"
                                               style="color:#f39473"><?php echo "User" ?></a><span
                                                    class="seperate"></span>
                                        </div>
                                        <h3 class="entry-title post-title max-2lines h4-mobile">
                                            <a class="post-listing-title"
                                               href="<?php ?>"
                                               title="<?php ?>"><?php echo ucfirst($table->name_search) ?></a>
                                        </h3>
                                        <div class="entry-content post-excerpt">
                                            <?php echo utf8_encode($table->description) ?>
                                        </div>
                                    </div>
                                </article>
                                <?php
                            }
                        }
                        ?>
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
