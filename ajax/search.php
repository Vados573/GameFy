<?php
ob_start();
session_start();
extract($_POST);
include('../includes/config.php');
include('../includes/global_functions.php');
$json = array();
$content = "";
if ($search_value == ""){
    $json['error'] = "Search value empty";
    die(json_encode($json));
}
$sql = 'SELECT id_channel as id_search, name_channel as name_search, is_live as is_live, type_search, id_user FROM
        (SELECT id_channel, name_channel, is_live, "Channel" as type_search, id_user FROM channel 
        WHERE LOWER(channel.name_channel) LIKE "%' . $search_value . '%" OR LOWER(channel.name_channel) LIKE "' . $search_value . '%" OR LOWER(channel.name_channel) LIKE "%' . $search_value . '" 
        UNION ALL 
        SELECT id_stream, name_stream, is_live_stream, "Stream", id_user FROM stream JOIN channel ON channel.id_channel = stream.id_channel 
        WHERE LOWER(stream.name_stream) LIKE "%' . $search_value . '%" OR LOWER(stream.name_stream) LIKE "' . $search_value . '%" OR LOWER(stream.name_stream) LIKE "%' . $search_value . '" 
        UNION ALL 
        SELECT id_user, username_user, false, "Users", false FROM user 
        WHERE LOWER(user.username_user) LIKE "%' . $search_value . '%" OR LOWER(user.username_user) LIKE "%' . $search_value . '" OR LOWER(user.username_user) LIKE "' . $search_value . '%"  
        ) as search 
        ORDER BY CASE 
        WHEN LOWER(name_search) = "' . $search_value . '" THEN 0 WHEN LOWER(name_search) LIKE "' . $search_value . '%" THEN 1 WHEN LOWER(name_search) LIKE "%' . $search_value . '%" THEN 2 WHEN LOWER(name_search) LIKE "%' . $search_value . '" THEN 3 
        ELSE 4 END, name_search ASC';
//die($sql);
$result = odbc_exec($con, $sql);
$count = 0;
while ($table = odbc_fetch_object($result)){
    if ($count == 10){
        break;
    }
    if ($table->type_search == "Users"){
        $id_user = $table->id_search;
    }
    else{
        $id_user = $table->id_user;
    }
    $fileName = $_SERVER["DOCUMENT_ROOT"] . "/GameFy/" . PATH_IMG_USER . $id_user . ".jpeg";
    if (file_exists($fileName)) {
        $path = PATH_IMG_USER . $id_user . ".jpeg";
    } else {
        $path = "https://secure.gravatar.com/avatar/83232f25bace98c04afdba2ef9eedd8d?s=61&d=mm&r=g";
    }
    if ($table->type_search == "Channel"){
        $search = preg_replace("/$search_value/i", "<strong style='color: var(--color__main)'>" . mb_strtoupper($search_value) . "</strong>", $table->name_search);
        $content .= '
            <a href="channel.php?id=' . $table->id_search. '" class="beeteam368-suggestion-item beeteam368-suggestion-item-default flex-row-control flex-vertical-middle">
                <span class="beeteam368-icon-item small-item">
                    <i class="fas fa-tv"></i>
                </span>
                <span class="beeteam368-suggestion-item-content">
                    <span class="beeteam368-suggestion-item-title h6 h-light">
                        ' . $search .'
                    </span>
                    <span class="beeteam368-suggestion-item-tax font-size-10">
                        Channel
                    </span>
                </span>
                <span class="beeteam368-suggestion-item-image"><img
                    src="' . $path . '"
                    class="blog-img" alt=""
                    srcset="' . $path . '"
                    sizes="(max-width: 150px) 100vw, 150px" width="150"
                    height="150">
                </span>
            </a>
        ';
    }
    elseif ($table->type_search == "Stream" AND $table->is_live == "1"){ // Stream
        $search = preg_replace("/$search_value/i", "<strong style='color: var(--color__main)'>" . mb_strtoupper($search_value) . "</strong>", $table->name_search);
        $content .= '
            <a href="#" class="beeteam368-suggestion-item beeteam368-suggestion-item-default flex-row-control flex-vertical-middle">
                <span class="beeteam368-icon-item small-item">
                    <i class="fas fa-video"></i>
                </span>
                <span class="beeteam368-suggestion-item-content">
                    <span class="beeteam368-suggestion-item-title h6 h-light">
                        ' . $search .'
                    </span>
                    <span class="beeteam368-suggestion-item-tax font-size-10">
                        Stream
                    </span>
                </span>
                <span class="beeteam368-suggestion-item-image"><img
                    src="' . $path . '"
                    class="blog-img" alt=""
                    srcset="' . $path . '"
                    sizes="(max-width: 150px) 100vw, 150px" width="150"
                    height="150">
                </span>
            </a>
        ';
    }
    elseif ($table->type_search == "Stream" AND $table->is_live == "0"){ // Video
        $search = preg_replace("/$search_value/i", "<strong style='color: var(--color__main)'>" . mb_strtoupper($search_value) . "</strong>", $table->name_search);
        $content .= '
            <a href="#" class="beeteam368-suggestion-item beeteam368-suggestion-item-default flex-row-control flex-vertical-middle">
                <span class="beeteam368-icon-item small-item">
                    <i class="fas fa-video"></i>
                </span>
                <span class="beeteam368-suggestion-item-content">
                    <span class="beeteam368-suggestion-item-title h6 h-light">
                        ' . $search .'
                    </span>
                    <span class="beeteam368-suggestion-item-tax font-size-10">
                        Video
                    </span>
                </span>
                <span class="beeteam368-suggestion-item-image"><img
                    src="' . $path . '"
                    class="blog-img" alt=""
                    srcset="' . $path . '"
                    sizes="(max-width: 150px) 100vw, 150px" width="150"
                    height="150">
                </span>
            </a>
        ';
    }
    elseif($table->type_search == "Users"){
        $search = preg_replace("/$search_value/i", "<strong style='color: var(--color__main)'>" . mb_strtoupper($search_value) . "</strong>", $table->name_search);
        $content .= '
            <a href="#" class="beeteam368-suggestion-item beeteam368-suggestion-item-default flex-row-control flex-vertical-middle">
                <span class="beeteam368-icon-item small-item">
                    <i class="fas fa-user"></i>
                </span>
                <span class="beeteam368-suggestion-item-content">
                    <span class="beeteam368-suggestion-item-title h6 h-light">
                        ' . $search .'
                    </span>
                    <span class="beeteam368-suggestion-item-tax font-size-10">
                        User
                    </span>
                </span>
                <span class="beeteam368-suggestion-item-image"><img
                    src="' . $path . '"
                    class="blog-img" alt=""
                    srcset="' . $path . '"
                    sizes="(max-width: 150px) 100vw, 150px" width="150"
                    height="150">
                </span>
            </a>
        ';
    }
    $count++;
}
$json['content'] = $content;
$json['error'] = "";
die(json_encode($json));