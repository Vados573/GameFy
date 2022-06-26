<?php
ob_start();
session_start();
extract($_POST);
include('../includes/config.php');
include('../includes/global_functions.php');
$json = array();
$content = "";
$filter = "";
$principal = '<a class="filtering selected-filter" data-id="0" href="" title="Filter: No Filter"><span>Filter: No Filter</span></a>';
if ($id_filter == "1"){
    $filter = 'WHERE type_search = "Channel"';
    $principal = '<a class="filtering" data-id="1" href="" title="Filter: Channels"><span>Filter: Channels</span></a>';
}
elseif($id_filter == "2"){
    $filter = 'WHERE type_search = "Stream" AND is_live = "1"';
    $principal = '<a class="filtering" data-id="2" href="" title="Filter: Streams"><span>Filter: Streams</span></a>';
}
elseif ($id_filter == "3"){
    $filter = 'WHERE type_search = "Stream" AND is_live = "0"';
    $principal = '<a class="filtering" data-id="3" href="" title="Filter: Videos"><span>Filter: Videos</span></a>';
}
elseif($id_filter == "4"){
    $filter = 'WHERE type_search = "Users"';
    $principal = '<a class="filtering" data-id="4" href="" title="Filter: Users"><span>Filter: Users</span></a>';
}

$sql = 'SELECT id_channel as id_search, name_channel as name_search, is_live as is_live, type_search, id_user, username_user, followers_channel as metrics, description_channel as description, secondary_id FROM
        (SELECT id_channel, name_channel, is_live, "Channel" as type_search, channel.id_user, user.username_user, channel.followers_channel, channel.description_channel, false as secondary_id FROM channel JOIN user ON user.id_user = channel.id_user
        WHERE LOWER(channel.name_channel) LIKE "%' . $search_value . '%" OR LOWER(channel.name_channel) LIKE "' . $search_value . '%" OR LOWER(channel.name_channel) LIKE "%' . $search_value . '" 
        UNION ALL 
        SELECT id_stream, name_stream, is_live_stream, "Stream", channel.id_user, user.username_user, stream.views_stream, stream.description_stream, channel.id_channel FROM stream JOIN channel ON channel.id_channel = stream.id_channel JOIN user ON user.id_user = channel.id_user
        WHERE LOWER(stream.name_stream) LIKE "%' . $search_value . '%" OR LOWER(stream.name_stream) LIKE "' . $search_value . '%" OR LOWER(stream.name_stream) LIKE "%' . $search_value . '" 
        UNION ALL 
        SELECT id_user, username_user, false, "Users", false, false, false, user.description_user, false FROM user 
        WHERE LOWER(user.username_user) LIKE "%' . $search_value . '%" OR LOWER(user.username_user) LIKE "%' . $search_value . '" OR LOWER(user.username_user) LIKE "' . $search_value . '%"  
        ) as search 
        ' . $filter . ' ORDER BY CASE 
        WHEN LOWER(name_search) = "' . $search_value . '" THEN 0 WHEN LOWER(name_search) LIKE "' . $search_value . '%" THEN 1 WHEN LOWER(name_search) LIKE "%' . $search_value . '%" THEN 2 WHEN LOWER(name_search) LIKE "%' . $search_value . '" THEN 3 
        ELSE 4 END, name_search ASC, metrics DESC';
$r = odbc_exec($con, $sql);
$number_of_rows = odbc_num_rows($r);

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
        $content .= '
        <article id="post- ' . $id_user . '"
                 class="post-item site__col flex-row-control post-550 vidmov_video type-vidmov_video status-publish has-post-thumbnail hentry tag-y-2017 tag-y-2019 tag-y-2021 tag-animation tag-crime tag-drama tag-french tag-german tag-italy tag-japan tag-japanese tag-kids tag-korea tag-reality tag-soap tag-tv-14 tag-tv-g tag-tv-y tag-war-politics vidmov_video_category-gaming">
            <div class="post-item-wrap flex-column-control">
                <div class="blog-author-element flex-row-control flex-vertical-middle">
                    <a href="<?php ?>" class="author-avatar-wrap"
                       title=" ' . ucfirst($username) . '">
                        <img alt="Author Avatar"
                             src=" ' . $path . '"
                             sizes="(max-width: 50px) 100vw, 50px"
                             srcset=" ' . $path . '"
                             class="author-avatar" width="50" height="50"> </a>
                    <div class="author-avatar-name-wrap">
                        <h5 class="author-avatar-name max-1line">
                            <a href="channel.php?id=' . $table->id_search . '"
                               class="author-avatar-name-link" title=" ' . ucfirst($username) . '">';
        if ($table->is_live == "1") {
            $content .= '
                                    <i class="fas fa-check-circle author-verified is-verified"></i>';
        }
        $content .= '
                                <span> ' . ucfirst($username) . '</span>
                            </a>
                        </h5>
                        <span class="author-meta font-meta">
                                            <i class="icon far fa-heart"></i><span
                                class="subscribers-count subscribers-count-control"
                                data-author-id="1"><span>' . getMinNumber($table->metrics) . '</span><span
                                    class="info-text">Followers</span></span>
</span>
                    </div>
                </div>
                <div class="post-featured-image preview-mode-control" data-id="550">
                    <a data-post-id="550" data-post-type="vidmov_video"
                       href="<?php ?>"
                       title=" ' . ucfirst($username) . '"
                       class="blog-img-link blog-img-link-control"><img
                            src=" ' . $path_channel . '"
                            class="blog-img" alt=""
                            srcset=" ' . $path_channel . '"
                            sizes="(max-width: 420px) 100vw, 420px" width="420"
                            height="237"></a>
                </div>
                <div class="posted-on top-post-meta font-meta">
                    <a data-tax-id="tax_5" data-tax="vidmov_video_category"
                       data-post-type="vidmov_video"
                       href="<?php ?>" title=" ' . "Channel" . '"
                       class="category-item"
                       style="color:#ff5100"> ' . "Channel" . '</a><span
                        class="seperate"></span>
                </div>
                <h3 class="entry-title post-title max-2lines h4-mobile">
                    <a class="post-listing-title"
                       href="<?php ?>"
                       title="<?php ?>"> ' . $table->name_search . '</a>
                </h3>
                <div class="entry-content post-excerpt">
                     ' . utf8_encode($table->description) . '</div>
        </div>
        </article>
        ';
    } elseif ($table->type_search == "Stream" and $table->is_live == "1") {
        $fileName = $_SERVER["DOCUMENT_ROOT"] . "/GameFy/" . PATH_IMG_CHANNEL . $table->secondary_id . ".jpeg";
        if (file_exists($fileName)) {
            $path_channel = PATH_IMG_CHANNEL . $table->secondary_id . ".jpeg";
        } else {
            $path_channel = "https://i.pinimg.com/originals/3e/f1/d4/3ef1d460e6bb89eaa7d2fcf283795191.jpg";
        }
        $content .= '
        <article id="post- ' . $id_user . '"
                 class="post-item site__col flex-row-control post-550 vidmov_video type-vidmov_video status-publish has-post-thumbnail hentry tag-y-2017 tag-y-2019 tag-y-2021 tag-animation tag-crime tag-drama tag-french tag-german tag-italy tag-japan tag-japanese tag-kids tag-korea tag-reality tag-soap tag-tv-14 tag-tv-g tag-tv-y tag-war-politics vidmov_video_category-gaming">
            <div class="post-item-wrap flex-column-control">
                <div class="blog-author-element flex-row-control flex-vertical-middle">
                    <a href="<?php ?>" class="author-avatar-wrap"
                       title=" ' . ucfirst($username) . '">
                        <img alt="Author Avatar"
                             src=" ' . $path . '"
                             sizes="(max-width: 50px) 100vw, 50px"
                             srcset=" ' . $path . '"
                             class="author-avatar" width="50" height="50"> </a>
                    <div class="author-avatar-name-wrap">
                        <h5 class="author-avatar-name max-1line">
                            <a href="<?php ?>"
                               class="author-avatar-name-link" title=" ' . ucfirst($username) . '">';
        if ($table->is_live == "1") {
            $content .= '
                                    <i class="fas fa-check-circle author-verified is-verified"></i>';
        }
        $content .= '
                                <span> ' . ucfirst($username) . '</span>
                            </a>
                        </h5>
                        <span class="author-meta font-meta">
                                            <i class="icon far fa-eye"></i><span
                                class="subscribers-count subscribers-count-control"
                                data-author-id="1"><span>' . getMinNumber($table->metrics) . '</span><span
                                    class="info-text">Viewers</span></span>
</span>
                    </div>
                </div>
                <div class="post-featured-image preview-mode-control" data-id="550">
                    <a data-post-id="550" data-post-type="vidmov_video"
                       href="<?php ?>"
                       title=" ' . ucfirst($username) . '"
                       class="blog-img-link blog-img-link-control"><img
                            src=" ' . $path_channel . '"
                            class="blog-img" alt=""
                            srcset=" ' . $path_channel . '"
                            sizes="(max-width: 420px) 100vw, 420px" width="420"
                            height="237"></a>
                </div>
                <div class="posted-on top-post-meta font-meta">
                    <a data-tax-id="tax_5" data-tax="vidmov_video_category"
                       data-post-type="vidmov_video"
                       href="<?php ?>" title=" ' . "Stream" . '"
                       class="category-item"
                       style="color:#51ff00"> ' . "Stream" . '</a><span
                        class="seperate"></span>
                </div>
                <h3 class="entry-title post-title max-2lines h4-mobile">
                    <a class="post-listing-title"
                       href="<?php ?>"
                       title="<?php ?>"> ' . $table->name_search . '</a>
                </h3>
                <div class="entry-content post-excerpt">
                     ' . utf8_encode($table->description) . '</div>
        </div>
        </article>
        ';
    } elseif ($table->type_search == "Stream" and $table->is_live == "0") {
        $fileName = $_SERVER["DOCUMENT_ROOT"] . "/GameFy/" . PATH_IMG_CHANNEL . $table->secondary_id . ".jpeg";
        if (file_exists($fileName)) {
            $path_channel = PATH_IMG_CHANNEL . $table->secondary_id . ".jpeg";
        } else {
            $path_channel = "https://i.pinimg.com/originals/3e/f1/d4/3ef1d460e6bb89eaa7d2fcf283795191.jpg";
        }
        $content .= '
        <article id="post- ' . $id_user . '"
                 class="post-item site__col flex-row-control post-550 vidmov_video type-vidmov_video status-publish has-post-thumbnail hentry tag-y-2017 tag-y-2019 tag-y-2021 tag-animation tag-crime tag-drama tag-french tag-german tag-italy tag-japan tag-japanese tag-kids tag-korea tag-reality tag-soap tag-tv-14 tag-tv-g tag-tv-y tag-war-politics vidmov_video_category-gaming">
            <div class="post-item-wrap flex-column-control">
                <div class="blog-author-element flex-row-control flex-vertical-middle">
                    <a href="<?php ?>" class="author-avatar-wrap"
                       title=" ' . ucfirst($username) . '">
                        <img alt="Author Avatar"
                             src=" ' . $path . '"
                             sizes="(max-width: 50px) 100vw, 50px"
                             srcset=" ' . $path . '"
                             class="author-avatar" width="50" height="50"> </a>
                    <div class="author-avatar-name-wrap">
                        <h5 class="author-avatar-name max-1line">
                            <a href="<?php ?>"
                               class="author-avatar-name-link" title=" ' . ucfirst($username) . '">';
        if ($table->is_live == "1") {
            $content .= '
                                    <i class="fas fa-check-circle author-verified is-verified"></i>';
        }
        $content .= '
                                <span> ' . ucfirst($username) . '</span>
                            </a>
                        </h5>
                        <span class="author-meta font-meta">
                                            <i class="icon far fa-eye"></i><span
                                class="subscribers-count subscribers-count-control"
                                data-author-id="1"><span>' . getMinNumber($table->metrics) . '</span><span
                                    class="info-text">Viewers</span></span>
</span>
                    </div>
                </div>
                <div class="post-featured-image preview-mode-control" data-id="550">
                    <a data-post-id="550" data-post-type="vidmov_video"
                       href="<?php ?>"
                       title=" ' . ucfirst($username) . '"
                       class="blog-img-link blog-img-link-control"><img
                            src=" ' . $path_channel . '"
                            class="blog-img" alt=""
                            srcset=" ' . $path_channel . '"
                            sizes="(max-width: 420px) 100vw, 420px" width="420"
                            height="237"></a>
                </div>
                <div class="posted-on top-post-meta font-meta">
                    <a data-tax-id="tax_5" data-tax="vidmov_video_category"
                       data-post-type="vidmov_video"
                       href="<?php ?>" title=" ' . "Video" . '"
                       class="category-item"
                       style="color:#ff375f"> ' . "Video" . '</a><span
                        class="seperate"></span>
                </div>
                <h3 class="entry-title post-title max-2lines h4-mobile">
                    <a class="post-listing-title"
                       href="<?php ?>"
                       title="<?php ?>"> ' . $table->name_search . '</a>
                </h3>
                <div class="entry-content post-excerpt">
                     ' . utf8_encode($table->description) . '</div>
        </div>
        </article>
        ';
    } elseif ($table->type_search == "Users") {
        $content .= '
        <article id="post- ' . $id_user . '"
                 class="post-item site__col flex-row-control post-550 vidmov_video type-vidmov_video status-publish has-post-thumbnail hentry tag-y-2017 tag-y-2019 tag-y-2021 tag-animation tag-crime tag-drama tag-french tag-german tag-italy tag-japan tag-japanese tag-kids tag-korea tag-reality tag-soap tag-tv-14 tag-tv-g tag-tv-y tag-war-politics vidmov_video_category-gaming">
            <div class="post-item-wrap flex-column-control">
                <div class="blog-author-element flex-row-control flex-vertical-middle">
                    <a href="<?php ?>" class="author-avatar-wrap"
                       title=" ' . ucfirst($username) . '">
                        <img alt="Author Avatar"
                             src=" ' . $path . '"
                             sizes="(max-width: 50px) 100vw, 50px"
                             srcset=" ' . $path . '"
                             class="author-avatar" width="50" height="50"> </a>
                    <div class="author-avatar-name-wrap">
                        <h5 class="author-avatar-name max-1line">
                            <a href="<?php ?>"
                               class="author-avatar-name-link" title=" ' . ucfirst($username) . '">';
        if ($table->is_live == "1") {
            $content .= '
                                    <i class="fas fa-check-circle author-verified is-verified"></i>';
        }
        $content .= '
                                <span> ' . ucfirst($username) . '</span>
                            </a>
                        </h5>
                    </div>
                </div>
                <div class="posted-on top-post-meta font-meta">
                    <a data-tax-id="tax_5" data-tax="vidmov_video_category"
                       data-post-type="vidmov_video"
                       href="<?php ?>" title=" ' . "User" . '"
                       class="category-item"
                       style="color:#f39473"> ' . "User" . '</a><span
                        class="seperate"></span>
                </div>
                <h3 class="entry-title post-title max-2lines h4-mobile">
                    <a class="post-listing-title"
                       href="<?php ?>"
                       title="<?php ?>"> ' . ucfirst($table->name_search) . '</a>
                </h3>
                <div class="entry-content post-excerpt">
                     ' . utf8_encode($table->description) . '</div>
        </div>
        </article>
        ';
    }
}
$json['principal'] = $principal;
$json['error'] = "";
$json['number'] = $number_of_rows;
$json['content'] = $content;
die(json_encode($json));