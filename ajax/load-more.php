<?php
ob_start();
session_start();
extract($_POST);
include('../includes/config.php');
include('../includes/global_functions.php');
$json = array();
$content_recommend = "";
$content = "";
$flag_follow = 0;
$flag_rec = 0;
if (isset($recommended)) {
    $flag_follow = 1;
    $top = (intval($count) + 1) * 10;
    $top = strval($top);
    if (isset($_SESSION)) {
        $sql = "SELECT u.id_user, channel.id_user as user_channel , u.username_user,
                channel.id_channel, channel.name_channel, channel.followers_channel, channel.is_live 
                FROM channel
                JOIN user u ON u.id_user = channel.id_user 
                WHERE u.id_user <> " . $_SESSION['id'] . " 
                AND " . $_SESSION['id'] . " NOT IN (SELECT id_user FROM follow WHERE id_channel = channel.id_channel)
                ORDER BY followers_channel DESC 
                LIMIT $top;";
    } else {
        $sql = "SELECT u.id_user, channel.id_user as user_channel , u.username_user,
            channel.id_channel, channel.name_channel, channel.followers_channel, channel.is_live 
            FROM channel
            JOIN user u ON u.id_user = channel.id_user 
            WHERE channel.is_live = 1
            ORDER BY followers_channel DESC;
            LIMIT $top";
    }
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
        $content_recommend .= '<div id="blog_wrapper_1715015991654711050"
                                             class="blog-wrapper global-blog-wrapper blog-wrapper-control flex-row-control site__row"
                                             style="margin-bottom: 20px;">
                                            <article class="post-item site__col flex-row-control">
                                                <div class="post-item-wrap">
                                                    <div class="author-wrapper flex-row-control flex-vertical-middle">
                                                        <a href="#"
                                                           class="author-avatar-wrap"
                                                           title="' . $table->name_channel . '">
                                                            <img alt="Author Avatar"
                                                                 src="' . $path . '"
                                                                 sizes="(max-width: 61px) 100vw, 61px"
                                                                 srcset="' . $path . '"
                                                                 class="author-avatar" width="61" height="61"> </a>
                                                        <div class="author-avatar-name-wrap">
                                                            <h4 class="h5 author-avatar-name max-1line">
                                                                <a href="#"
                                                                   class="author-avatar-name-link"
                                                                   title=" ' . $table->name_channel . '">';

        if ($table->is_live == "1") { // Checks if user is live

            $content_recommend .= '<i class="fas fa-check-circle author-verified is-verified"></i>';

        }
        $content_recommend .= '<span>' . $table->name_channel . '</span></a>
                                                            </h4>
                                                            <span class="author-meta font-meta">
<i class="icon far fa-heart"></i><span class="subscribers-count subscribers-count-control"
                                       data-author-id="1"><span>' . $followers . '</span><span
                                                                            class="info-text">Followers</span></span>
</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
        ';
    }
}
if (isset($followed)) {
    $flag_follow= 1;
    $top = (intval($count) + 1) * 10;
    $top = strval($top);
    $sql = "SELECT u.id_user, channel.id_user as user_channel , uc.username_user, 
                                    channel.id_channel, channel.name_channel, channel.followers_channel, channel.is_live 
                                    FROM follow 
                                    JOIN user u ON u.id_user = follow.id_user 
                                    JOIN channel ON channel.id_channel = follow.id_channel
                                    JOIN user uc ON channel.id_user = uc.id_user
                                    WHERE follow.id_user = " . $_SESSION['id'] . "
                                    ORDER BY channel.followers_channel DESC
                                    LIMIT $top
                                    ";
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
        $content .= '
            <article class="post-item site__col flex-row-control"
                                             style="width: var(--width__side-menu-hide);padding: 10px 0;">
                                        <div class="post-item-wrap" style="width: 100%;">
                                            <div class="author-wrapper flex-row-control flex-vertical-middle">
                                                <a href="#"
                                                   class="author-avatar-wrap"
                                                   title="' . $table->name_channel . '" style="margin: auto">
                                                    <img alt="Author Avatar"
                                                         src="' . $path . '"
                                                         sizes="(max-width: 61px) 100vw, 61px"
                                                         srcset="' . $path . '"
                                                         class="author-avatar" width="61" height="61"> </a>
                                                <div class="author-avatar-name-wrap layer-hidden">
                                                    <h4 class="h5 author-avatar-name max-1line">
                                                        <a href="#"
                                                           class="author-avatar-name-link"
                                                           title="' . $table->name_channel . '">
                                                           ';
        if ($table->is_live == "1") { // Checks if user is live
            $content .= '<i class="fas fa-check-circle author-verified is-verified"></i>';
        }
        $content .= '<span>' . $table->name_channel . '</span>
                                                        </a>
                                                    </h4>
                                                    <span class="author-meta font-meta">
<i class="icon far fa-heart"></i><span class="subscribers-count subscribers-count-control"
                                       data-author-id="1"><span>' . $followers . '</span><span
                                                                    class="info-text">Followers</span></span>
</span>
                                                </div>
                                            </div>
                                        </div>
                                    </article>
        ';
    }
}
if ($flag_follow == 1){
    $json['flag'] = 1;
}
else{
    $json['flag'] = 0;
}
$json['content'] = $content;
$json['recommend'] = $content_recommend;
if ($counter <= $top and !isset($flag)) {
    $json['error'] = "There is nothing more to show!";
    die(json_encode($json));
}
$json['error'] = "";
die(json_encode($json));