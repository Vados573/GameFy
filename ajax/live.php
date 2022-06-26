<?php
ob_start();
session_start();
extract($_POST);
//error_reporting(0);
include('../includes/config.php');
include('../includes/global_functions.php');
$json = array();
$content = "";
try {
    if (!isset($_SESSION['id'])){
        throw new Exception("You need to log in");
    }
    if (!isset($idChannel)){
        throw new Exception("Something went wrong!");
    }
    if (isset($start)){
        if (!isset($nameStream)){
            throw new Exception("Please enter the name of your stream! (Required)");
        }
        elseif($nameStream == ""){
            throw new Exception("Please enter the name of your stream! (Required)");
        }
        if (!isset($descStream)){
            $descStream = "";
        }
        if (!isset($gameId)){
            $gameId = "100"; //Set the game to Others
        }
        elseif ($gameId == "0"){
            $gameId = "100";
        }
        if (!isset($isRecord)){
            $isRecord = 0;
        }
        $sql = "SELECT stream_id FROM channel WHERE id_channel = " . $idChannel;
        $result = odbc_exec($con, $sql);
        $stream = odbc_fetch_object($result);
        if ($result == false){
            throw new Exception("Error Database");
        }
        if (intval($isRecord) == 1){
            if (updateLive($stream->stream_id, null,1) == false){
                throw new Exception("Error Record");
            }
        }
        else{
            if (updateLive($stream->stream_id, null,0) == false){
                throw new Exception("Error Record");
            }
        }
        $sql = "UPDATE channel SET is_live = 1 WHERE id_user = " . $_SESSION['id'] . ";";
        $result = odbc_exec($con, $sql);
        if ($result == false){
            throw new Exception("Error something went wrong");
        }
        $preparation = odbc_prepare($con, "INSERT INTO stream VALUES (null, ?, 1, 0, ?, null, ?, ?, ?, null)");
        if ($preparation == false){
            throw new Exception("Error something went wrong");
        }
        $array_value = array();
        array_push($array_value, $nameStream, $descStream, $idChannel, $gameId, $isRecord);
        $result = odbc_execute($preparation, $array_value);
        if ($result == false){
            $sql = "UPDATE channel SET is_live = 0 WHERE id_user = " . $_SESSION['id'] . ";";
            $result = odbc_exec($con, $sql);
            throw new Exception("Error something went wrong");
        }
        $json['error'] = "";
    }
    elseif (isset($stop)){
        $sql = "SELECT stream_id FROM channel WHERE id_channel = " . $idChannel;
        $result = odbc_exec($con, $sql);
        $stream = odbc_fetch_object($result);
        if ($result == false){
            throw new Exception("Error Database");
        }
        $sql = "SELECT is_recorded FROM stream WHERE is_live_stream = 1 AND id_channel = $idChannel";
        $result = odbc_exec($con, $sql);
        if ($result == false){
            throw new Exception("Error something went wrong");
        }
        $is_recorded = odbc_fetch_object($result);
        $is_recorded = $is_recorded->is_recorded;
        if (intval($is_recorded) == 1){
            $videoString = getVideos($stream->stream_id, "publishedAt", "desc");
            if ($videoString == false){
                throw new Exception("Something went wrong while creating your channel!", 500);
            }
            $videoJson = json_decode($videoString, true);
            $videoId = $videoJson['data'][0]['videoId'];
            $sql = "SELECT count(*) AS COUNTER from stream WHERE path_video_stream = '$videoId' ";
            $result = odbc_exec($con, $sql);
            $arr = odbc_fetch_array($result);
            $number_rows = $arr['COUNTER'];
            if ( $number_rows == -1){
                throw new Exception("Something wrong happened");
            }
            if ($number_rows == 0){
                $sql = "UPDATE stream SET path_video_stream = '$videoId' AND date_stream = '" . date("Y-m-d H:i:s") . "' WHERE is_live_stream = 1 AND id_channel = $idChannel";
                $sql = odbc_exec($con, $sql);
            }
            $sql = "UPDATE stream SET is_live_stream = 0 WHERE is_live_stream = 1 AND id_channel = $idChannel";
        }
        else{
            $sql = "DELETE FROM stream WHERE id_channel = $idChannel AND is_live_stream = 1";
        }
        $result = odbc_exec($con, $sql);
        if ($result == false){
            throw new Exception("Error something went wrong");
        }
        $sql = "UPDATE channel SET is_live = 0 WHERE id_user = " . $_SESSION['id'] . ";";
        $result = odbc_exec($con, $sql);
        if ($result == false){
            throw new Exception("Error something went wrong");
        }
        $json['error'] = "";
    }
}
catch (Exception $exception){
    $json['error'] = $exception->getMessage();
}
die(json_encode($json));