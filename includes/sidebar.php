<div class="beeteam368_color_bar beeteam368_color_loading_control"></div>
<div id="beeteam368-side-menu" class="beeteam368-side-menu beeteam368-side-menu-control">
    <div id="beeteam368-side-menu-body"
         class="beeteam368-side-menu-body os-host os-theme-dark os-host-resize-disabled os-host-scrollbar-horizontal-hidden os-host-transition os-host-overflow os-host-overflow-y">
        <div class="os-resize-observer-host observed">
            <div class="os-resize-observer" style="left: 0px; right: auto;"></div>
        </div>
        <div class="os-size-auto-observer observed" style="height: calc(100% + 1px); float: left;">
            <div class="os-resize-observer"></div>
        </div>
        <div class="os-content-glue" style="margin: -3px -25px -25px; width: 248px; height: 647px;"></div>
        <div class="os-padding">
            <div class="os-viewport os-viewport-native-scrollbars-invisible os-viewport-native-scrollbars-overlaid"
                 style="overflow-y: scroll;">
                <div class="os-content" style="padding: 3px 0px 25px; height: 100%; width: 100%;">
                    <div class="side-close-btn ctrl-show-hidden-elm flex-row-control flex-vertical-middle">
                        <div class="layer-hidden">
                            <div class="beeteam368-logo-wrap elm-logo-side">
                                <a href="index.php" title="VidMov Theme"
                                   class="beeteam368-logo-link h6 side-logo-control">
                                    <img alt="VidMov Theme" src="assets/images/secondLogo.png"
                                         sizes="(max-width: 92px) 100vw, 92px" width="92" height="30"> </a>
                            </div>
                        </div>
                        <div class="layer-show">
                            <div class="beeteam368-icon-item svg-side-btn oc-btn-control open-close open">
                                <svg width="100%" height="100%" version="1.1" viewBox="0 0 20 20" x="0px" y="0px"
                                     class="side-menu-close">
                                    <g>
                                        <path d="M4 16V4H2v12h2zM13 15l-1.5-1.5L14 11H6V9h8l-2.5-2.5L13 5l5 5-5 5z"></path>
                                    </g>
                                </svg>
                                <svg width="100%" height="100%" version="1.1" viewBox="0 0 20 20" x="0px" y="0px"
                                     class="side-menu-open" style="display: none">
                                    <g>
                                        <path d="M16 16V4h2v12h-2zM6 9l2.501-2.5-1.5-1.5-5 5 5 5 1.5-1.5-2.5-2.5h8V9H6z"></path>
                                    </g>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="side-nav-default">
                        <a href="https://vm.beeteam368.net/"
                           class="ctrl-show-hidden-elm home-items flex-row-control flex-vertical-middle side-active">
<span class="layer-show">
<span class="beeteam368-icon-item">
<i class="fas fa-home"></i>
</span>
</span>
                            <span class="layer-hidden">
<span class="nav-font category-menu">Home</span>
</span>
                        </a>
                        <ul id="side-menu-navigation" class="side-row side-menu-navigation nav-font nav-font-size-13"
                            style="display: none;">
                            <li id="menu-item-80"
                                class="menu-item menu-item-type-taxonomy menu-item-object-vidmov_video_category menu-item-80">
                                <a href="https://vm.beeteam368.net/video-category/gaming/">Streams</a></li>
                            <li id="menu-item-81"
                                class="menu-item menu-item-type-taxonomy menu-item-object-vidmov_video_category menu-item-81">
                                <a href="https://vm.beeteam368.net/video-category/movies/">Videos</a></li>
                            <li id="menu-item-82"
                                class="menu-item menu-item-type-taxonomy menu-item-object-vidmov_video_category menu-item-82">
                                <a href="https://vm.beeteam368.net/video-category/sports/">Events</a></li>
                            <li id="menu-item-79"
                                class="menu-item menu-item-type-taxonomy menu-item-object-vidmov_video_category menu-item-79">
                                <a href="https://vm.beeteam368.net/video-category/entertainment/">Blogs</a></li>
                        </ul>
                        <?php
                        if (isset($_SESSION['id'])) {
                            ?>
                            <h5 class="h5 widget-title flex-row-control flex-vertical-middle layer-hidden"
                                style="display: none; margin: 0 0 10px 0">
                                <span class="widget-title-wrap">Followed Channels:
                                    <span class="wg-line" style="height: 1px; width: 100%;">

                                    </span>
                                </span>
                            </h5>
                            <div id="follow-area">
                                <?php
                                $sql = "SELECT u.id_user, channel.id_user as user_channel , uc.username_user, 
                                    channel.id_channel, channel.name_channel, channel.followers_channel, channel.is_live 
                                    FROM follow 
                                    JOIN user u ON u.id_user = follow.id_user 
                                    JOIN channel ON channel.id_channel = follow.id_channel
                                    JOIN user uc ON channel.id_user = uc.id_user
                                    WHERE follow.id_user = " . $_SESSION['id'] . "
                                    ORDER BY channel.followers_channel DESC LIMIT 10
                                    ;";
                                $result = odbc_exec($con, $sql);
                                $counter = 0;
                                while ($table = odbc_fetch_object($result)) {
                                    $counter++;
                                    $fileName = $_SERVER["DOCUMENT_ROOT"] . "/GameFy/" . PATH_IMG_USER . $table->user_channel . ".jpeg";
                                    if (file_exists($fileName)) {
                                        $path = PATH_IMG_USER . $table->user_channel . ".jpeg";
                                    } else {
                                        $path = "https://secure.gravatar.com/avatar/83232f25bace98c04afdba2ef9eedd8d?s=61&d=mm&r=g";
                                    }
                                    $followers = getMinNumber(intval($table->followers_channel));
                                    ?>
                                    <article class="post-item site__col flex-row-control"
                                             style="width: var(--width__side-menu-hide);padding: 10px 0;">
                                        <div class="post-item-wrap" style="width: 100%;">
                                            <div class="author-wrapper flex-row-control flex-vertical-middle">
                                                <a href="profile.php?id=<?php echo $table->id_user?>"
                                                   class="author-avatar-wrap"
                                                   title="<?php echo $table->name_channel ?>" style="margin: auto">
                                                    <img alt="Author Avatar"
                                                         src="<?php echo $path ?>"
                                                         sizes="(max-width: 61px) 100vw, 61px"
                                                         srcset="<?php echo $path ?>"
                                                         class="author-avatar" width="61" height="61"> </a>
                                                <div class="author-avatar-name-wrap layer-hidden" style="display:none;">
                                                    <h4 class="h5 author-avatar-name max-1line">
                                                        <a href="channel.php?id=<?php echo $table->id_channel?>""
                                                           class="author-avatar-name-link"
                                                           title="<?php echo $table->name_channel ?>">
                                                            <?php
                                                            if ($table->is_live == "1") { // Checks if user is live

                                                                ?>
                                                                <i class="fas fa-check-circle author-verified is-verified"></i>
                                                                <?php
                                                            }
                                                            ?>
                                                            <span><?php echo $table->name_channel ?></span>
                                                        </a>
                                                    </h4>
                                                    <span class="author-meta font-meta">
<i class="icon far fa-heart"></i><span class="subscribers-count subscribers-count-control"
                                       data-author-id="1"><span><?php echo $followers; ?></span><span
                                                                    class="info-text">Followers</span></span>
</span>
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                <?php } ?>
                            </div>
                            <?php
                            if ($counter >= 10) {
                                ?>
                                <nav class="beeteam368-pagination pagination-loadmore beeteam368-pagination flex-row-control flex-row-center flex-vertical-middle layer-hidden"
                                     style="display: none; margin-left: 0"
                                     data-paged="1" data-template="template-parts/archive/item"
                                     data-style="marguerite-author-widget"
                                     data-append-id="#blog_wrapper_1715015991654711050"
                                     data-query-id="blog_wrapper_1715015991654711050" data-total-pages="2">
                                    <button class="loadmore-btn loadmore-btn-control load-more following"
                                            data-count="0">
                                        <span class="loadmore-text loadmore-text-control">Load More</span>
                                        <span class="loadmore-loading">
<span class="loadmore-indicator">
<svg><polyline class="lm-back" points="1 6 4 6 6 11 10 1 12 6 15 6"></polyline> <polyline class="lm-front"
                                                                                          points="1 6 4 6 6 11 10 1 12 6 15 6"></polyline></svg>
</span>
</span>
                                    </button>
                                </nav>
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <div class="sidemenu-sidebar side-row" style="display:none;">
                        <div id="beeteam368_channel_extensions-3"
                             class="widget r-widget-control vidmov-channel-extensions">
                            <h5 class="h5 widget-title flex-row-control flex-vertical-middle">
                                <span class="widget-title-wrap">Recommended Channels:
                                    <span class="wg-line" style="height: 1px; width: 100%;">

                                    </span>
                                </span>
                            </h5>
                            <div id="recommend-area">
                                <?php
                                if (isset($_SESSION['id'])) {
                                    $sql = "SELECT u.id_user, channel.id_user as user_channel , u.username_user,
                                    channel.id_channel, channel.name_channel, channel.followers_channel, channel.is_live 
                                    FROM channel
                                    JOIN user u ON u.id_user = channel.id_user 
                                    WHERE u.id_user <> " . $_SESSION['id'] . " AND " . $_SESSION['id'] . " NOT IN (SELECT id_user FROM follow WHERE id_channel = channel.id_channel)
                                    ORDER BY followers_channel DESC LIMIT 10;";
                                    $result = odbc_exec($con, $sql);
                                    while ($table = odbc_fetch_object($result)) {
                                        $fileName = $_SERVER["DOCUMENT_ROOT"] . "/GameFy/" . PATH_IMG_USER . $table->user_channel . ".jpeg";
                                        if (file_exists($fileName)) {
                                            $path = PATH_IMG_USER . $table->user_channel . ".jpeg";
                                        } else {
                                            $path = "https://secure.gravatar.com/avatar/83232f25bace98c04afdba2ef9eedd8d?s=61&d=mm&r=g";
                                        }
                                        $followers = getMinNumber(intval($table->followers_channel));
                                        ?>
                                        <div id="blog_wrapper_1715015991654711050"
                                             class="blog-wrapper global-blog-wrapper blog-wrapper-control flex-row-control site__row"
                                             style="margin-bottom: 20px;">
                                            <article class="post-item site__col flex-row-control">
                                                <div class="post-item-wrap">
                                                    <div class="author-wrapper flex-row-control flex-vertical-middle">
                                                        <a href="profile.php?id=<?php echo $table->id_user?>""
                                                           class="author-avatar-wrap"
                                                           title="<?php echo $table->name_channel ?>">
                                                            <img alt="Author Avatar"
                                                                 src="<?php echo $path ?>"
                                                                 sizes="(max-width: 61px) 100vw, 61px"
                                                                 srcset="<?php echo $path ?>"
                                                                 class="author-avatar" width="61" height="61"> </a>
                                                        <div class="author-avatar-name-wrap">
                                                            <h4 class="h5 author-avatar-name max-1line">
                                                                <a href="channel.php?id=<?php echo $table->id_channel?>""
                                                                   class="author-avatar-name-link"
                                                                   title="<?php echo $table->name_channel ?>">
                                                                    <?php
                                                                    if ($table->is_live == "1") { // Checks if user is live
                                                                        ?>
                                                                        <i class="fas fa-check-circle author-verified is-verified"></i>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                    <span><?php echo $table->name_channel ?></span>
                                                                </a>
                                                            </h4>
                                                            <span class="author-meta font-meta">
<i class="icon far fa-heart"></i><span class="subscribers-count subscribers-count-control"
                                       data-author-id="1"><span><?php echo $followers; ?></span><span
                                                                            class="info-text">Followers</span></span>
</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                        <?php
                                    }
                                } else {
                                    $sql = "SELECT u.id_user, channel.id_user as user_channel , u.username_user,
                                    channel.id_channel, channel.name_channel, channel.followers_channel, channel.is_live 
                                    FROM channel
                                    JOIN user u ON u.id_user = channel.id_user 
                                    WHERE channel.is_live = 1
                                    ORDER BY followers_channel DESC
                                    LIMIT 10
                                    ";
                                    $result = odbc_exec($con, $sql);
                                    $result_number = odbc_num_rows($result);
                                    $counter = 0;
                                    while ($table = odbc_fetch_object($result)) {
                                        $counter++;
                                        $fileName = $_SERVER["DOCUMENT_ROOT"] . "/GameFy/" . PATH_IMG_USER . $table->user_channel . ".jpeg";
                                        if (file_exists($fileName)) {
                                            $path = PATH_IMG_USER . $table->user_channel . ".jpeg";
                                        } else {
                                            $path = "https://secure.gravatar.com/avatar/83232f25bace98c04afdba2ef9eedd8d?s=61&d=mm&r=g";
                                        }
                                        $followers = getMinNumber(intval($table->followers_channel));
                                        ?>
                                        <div id="blog_wrapper_1715015991654711050"
                                             class="blog-wrapper global-blog-wrapper blog-wrapper-control flex-row-control site__row"
                                             style="margin-bottom: 20px;">
                                            <article class="post-item site__col flex-row-control">
                                                <div class="post-item-wrap">
                                                    <div class="author-wrapper flex-row-control flex-vertical-middle">
                                                        <a href="#"
                                                           class="author-avatar-wrap"
                                                           title="<?php echo $table->name_channel ?>">
                                                            <img alt="Author Avatar"
                                                                 src="<?php echo $path ?>"
                                                                 sizes="(max-width: 61px) 100vw, 61px"
                                                                 srcset="<?php echo $path ?>"
                                                                 class="author-avatar" width="61" height="61"> </a>
                                                        <div class="author-avatar-name-wrap">
                                                            <h4 class="h5 author-avatar-name max-1line">
                                                                <a href="#"
                                                                   class="author-avatar-name-link"
                                                                   title="<?php echo $table->name_channel ?>">
                                                                    <?php
                                                                    if ($table->is_live == "1") { // Checks if user is live
                                                                        ?>
                                                                        <i class="fas fa-check-circle author-verified is-verified"></i>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                    <span><?php echo $table->name_channel ?></span>
                                                                </a>
                                                            </h4>
                                                            <span class="author-meta font-meta">
<i class="icon far fa-heart"></i><span class="subscribers-count subscribers-count-control"
                                       data-author-id="1"><span><?php echo $followers; ?></span><span
                                                                            class="info-text">Followers</span></span>
</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                            <script>
                                vidmov_jav_js_object['blog_wrapper_1715015991654711050_params'] = {"beeteam368_author_query_order_id": "most_subscriptions"};
                            </script>
                            <script>
                                vidmov_jav_js_object['blog_wrapper_1715015991654711050'] = {
                                    "blog_id": 1,
                                    "role": "",
                                    "role__in": [],
                                    "role__not_in": [],
                                    "capability": "",
                                    "capability__in": [],
                                    "capability__not_in": [],
                                    "meta_key": "beeteam368_subscribe_count",
                                    "meta_value": "",
                                    "meta_compare": "",
                                    "include": [],
                                    "exclude": [],
                                    "search": "",
                                    "search_columns": [],
                                    "orderby": "meta_value_num",
                                    "order": "DESC",
                                    "offset": "",
                                    "number": 6,
                                    "paged": 1,
                                    "count_total": true,
                                    "fields": "all",
                                    "who": "",
                                    "has_published_posts": null,
                                    "nicename": "",
                                    "nicename__in": [],
                                    "nicename__not_in": [],
                                    "login": "",
                                    "login__in": [],
                                    "login__not_in": []
                                };
                            </script>
                            <?php
                            if ($counter >= 10) {
                                ?>
                                <nav class="beeteam368-pagination pagination-loadmore beeteam368-pagination flex-row-control flex-row-center flex-vertical-middle"
                                     data-paged="1" data-template="template-parts/archive/item"
                                     data-style="marguerite-author-widget"
                                     data-append-id="#blog_wrapper_1715015991654711050"
                                     data-query-id="blog_wrapper_1715015991654711050" data-total-pages="2">
                                    <button class="loadmore-btn loadmore-btn-control recommended load-more"
                                            data-count="0">
                                        <span class="loadmore-text loadmore-text-control">Load More</span>
                                        <span class="loadmore-loading">
<span class="loadmore-indicator">
<svg><polyline class="lm-back" points="1 6 4 6 6 11 10 1 12 6 15 6"></polyline> <polyline class="lm-front"
                                                                                          points="1 6 4 6 6 11 10 1 12 6 15 6"></polyline></svg>
</span>
</span>
                                    </button>
                                </nav>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="os-scrollbar os-scrollbar-horizontal os-scrollbar-unusable os-scrollbar-auto-hidden">
            <div class="os-scrollbar-track os-scrollbar-track-off">
                <div class="os-scrollbar-handle" style="width: 100%; transform: translate(0px);"></div>
            </div>
        </div>
        <div class="os-scrollbar os-scrollbar-vertical os-scrollbar-auto-hidden">
            <div class="os-scrollbar-track os-scrollbar-track-off">
                <div class="os-scrollbar-handle" style="height: 37.156%; transform: translate(0px);"></div>
            </div>
        </div>
        <div class="os-scrollbar-corner"></div>
    </div>
</div>