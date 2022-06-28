<?php
ob_start();
session_start();
extract($_POST);
//error_reporting(0);
include('../includes/config.php');
include('../includes/global_functions.php');
$json = array();
$content = "";
$date_chat = "";
$time_chat = "";
$user_chat = "";
$path = "";
try {
    if (!isset($textContent)){
        throw new Exception("No text chat!");
    }
    if ($textContent == ""){
        throw new Exception("Empty Message!");
    }
    if (!isset($idStream)){
        throw new Exception("No id Stream!");
    }
    if (intval($idStream) == false){
        throw new Exception("Wrong id stream format!");
    }
    $sql = "SELECT stream_id FROM stream JOIN channel c on c.id_channel = stream.id_channel WHERE c.id_channel = '$idStream'";
    $result = odbc_exec($con, $sql);
    $table = odbc_fetch_object($result);
    $stream_unique_id = $table->stream_id;
    $date_content = date("d-m-Y");
    $time_content = date("h:i");
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/GameFy/chat/stream_" . $stream_unique_id. ".txt")){
        $fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/GameFy/chat/stream_" . $table->stream_id . ".txt","a");
    }
    else{
        $fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/GameFy/chat/stream_" . $table->stream_id . ".txt","w");
    }
    $file_content = $_SESSION['id'] . "|" . $date_content . "|" . $time_content . "|" . $textContent . "\n";
    fwrite($fp, $file_content);
    fclose($fp);
    $date_chat = date("M d, Y");
    $time_chat = date("h:i A");
    $sql = "SELECT id_user, username_user FROM user WHERE id_user = " . $_SESSION['id'];
    $result = odbc_exec($con, $sql);
    $user = odbc_fetch_object($result);
    $user_chat = strval($user->username_user);
    $content = $textContent;
    $fileName = $_SERVER["DOCUMENT_ROOT"] . "/GameFy/" . PATH_IMG_USER . $user->id_user . ".jpeg";
    if (file_exists($fileName)) {
        $path = PATH_IMG_USER . $table->user_channel . ".jpeg";
    } else {
        $path = "https://secure.gravatar.com/avatar/83232f25bace98c04afdba2ef9eedd8d?s=61&d=mm&r=g";
    }
    $json['path'] = $path;
    $json['date'] = $date_chat;
    $json['time'] = $time_chat;
    $json['username'] = $user_chat;
    $json['content'] = $content;
    $json['id'] = $_SESSION['id'];
    $json['error'] = "";
}
catch (Exception $exception){
    $json['error'] = $exception->getMessage();
}
die(json_encode($json));
