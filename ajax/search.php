<?php
ob_start();
session_start();
extract($_POST);
include('../includes/config.php');
include('../includes/global_functions.php');
$json = array();
$content = "";

$sql = 'SELECT id_channel as id_search, name_channel as name_search, is_live as is_live, type_search FROM(
        SELECT id_channel, name_channel, is_live, "Channel" as type_search FROM channel WHERE channel.name_channel LIKE "%test%" OR channel.name_channel LIKE "test%" OR channel.name_channel LIKE "%test" OR 1 = 1
        UNION ALL
        SELECT id_stream, name_stream, is_live_stream, "Stream" FROM stream WHERE stream.name_stream LIKE "%test%" OR stream.name_stream LIKE "test%" OR stream.name_stream LIKE "%test" OR 1 = 1
        UNION ALL 
        SELECT id_user, username_user, false, "Users" FROM user WHERE user.username_user LIKE "%test%" OR user.username_user LIKE "%test" OR user.username_user LIKE "test%" OR 1 = 1
        ) as search';
$result = odbc_exec($con, $sql);
while ($table = odbc_fetch_object($result)){
    if ($table->type_search == "Channel"){
        $content .= '
            <a href="#" class="beeteam368-suggestion-item beeteam368-suggestion-item-default flex-row-control flex-vertical-middle">
                <span class="beeteam368-icon-item small-item">
                    <i class="fas fa-quote-left"></i>
                </span>
                <span class="beeteam368-suggestion-item-content">
                    <span class="beeteam368-suggestion-item-title h6 h-light">
                        Red Roses
                    </span>
                    <span class="beeteam368-suggestion-item-tax font-size-10">
                        Channel
                    </span>
                </span>
                <span class="beeteam368-suggestion-item-image"><img
                    src=""
                    class="blog-img" alt=""
                    srcset=""
                    sizes="(max-width: 150px) 100vw, 150px" width="150"
                    height="150">
                </span>
            </a>
        ';
    }
    elseif ($table->type_search == "Stream" AND $table->is_live == "1"){ // Stream
        $content .= '
            <a href="#" class="beeteam368-suggestion-item beeteam368-suggestion-item-default flex-row-control flex-vertical-middle">
                <span class="beeteam368-icon-item small-item">
                    <i class="fas fa-quote-left"></i>
                </span>
                <span class="beeteam368-suggestion-item-content">
                    <span class="beeteam368-suggestion-item-title h6 h-light">
                        Red Roses
                    </span>
                    <span class="beeteam368-suggestion-item-tax font-size-10">
                        Stream
                    </span>
                </span>
                <span class="beeteam368-suggestion-item-image"><img
                    src=""
                    class="blog-img" alt=""
                    srcset=""
                    sizes="(max-width: 150px) 100vw, 150px" width="150"
                    height="150">
                </span>
            </a>
        ';
    }
    elseif ($table->type_search == "Stream" AND $table->is_live == "0"){ // Video
        $content .= '
            <a href="#" class="beeteam368-suggestion-item beeteam368-suggestion-item-default flex-row-control flex-vertical-middle">
                <span class="beeteam368-icon-item small-item">
                    <i class="fas fa-quote-left"></i>
                </span>
                <span class="beeteam368-suggestion-item-content">
                    <span class="beeteam368-suggestion-item-title h6 h-light">
                        Red Roses
                    </span>
                    <span class="beeteam368-suggestion-item-tax font-size-10">
                        Video
                    </span>
                </span>
                <span class="beeteam368-suggestion-item-image"><img
                    src=""
                    class="blog-img" alt=""
                    srcset=""
                    sizes="(max-width: 150px) 100vw, 150px" width="150"
                    height="150">
                </span>
            </a>
        ';
    }
    elseif($table->type_search == "Users"){
        $content .= '
            <a href="#" class="beeteam368-suggestion-item beeteam368-suggestion-item-default flex-row-control flex-vertical-middle">
                <span class="beeteam368-icon-item small-item">
                    <i class="fas fa-quote-left"></i>
                </span>
                <span class="beeteam368-suggestion-item-content">
                    <span class="beeteam368-suggestion-item-title h6 h-light">
                        Red Roses
                    </span>
                    <span class="beeteam368-suggestion-item-tax font-size-10">
                        User
                    </span>
                </span>
                <span class="beeteam368-suggestion-item-image"><img
                    src=""
                    class="blog-img" alt=""
                    srcset=""
                    sizes="(max-width: 150px) 100vw, 150px" width="150"
                    height="150">
                </span>
            </a>
        ';
    }
}