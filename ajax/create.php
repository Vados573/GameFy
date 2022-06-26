<?php
ob_start();
session_start();
extract($_POST);
//error_reporting(0);
include('../includes/config.php');
include('../includes/global_functions.php');
$json = array();
$content = "";

if (!isset($_SESSION['id'])) {
    $json['error'] = "Please log in before continuing!";
    die(json_encode($json));
}

if (!isset($name_channel)) {
    $json['error'] = "Please fill the required fields!";
    die(json_encode($json));
}
if ($name_channel == "" or strlen(trim($name_channel)) == 0) {
    $json['error'] = "Please fill the required fields!";
    die(json_encode($json));
}


if (checkString($name_channel) == false OR checkString($description_channel) == false){
    $json['error'] = "Please remove special characters from the fields!";
    die(json_encode($json));
}

try {
    if (($_FILES['channel_image']['name'] != "")) {
        if ($_FILES['channel_image']['error'] !== UPLOAD_ERR_OK) {
            $json['error'] = "Upload failed with error code " . $_FILES['channel_image']['error'];
        }

        $info = getimagesize($_FILES['channel_image']['tmp_name']);
        if ($info === FALSE) {
            throw new Exception("Unable to determine image type of uploaded channel_image");
        }

//        if ($info[0] < 1000 or $info[1] < 350) {
//            throw new Exception("Picture should be bigger (Width: > 1000px, Height: > 350px)");
//        } elseif ($info[1] > 500 or $info[0] > 3000) {
//            throw new Exception("Picture should be smaller (Width: < 2000px, Height: < 500px");
//        }
        if (($info[2] !== IMAGETYPE_GIF) && ($info[2] !== IMAGETYPE_JPEG) && ($info[2] !== IMAGETYPE_PNG)) {
            throw new Exception("Image is not a gif/jpeg/png");
        }
    }
    $preparation = odbc_prepare($con, "INSERT INTO channel VALUE (null, ?, ?, ?, 0, 0, 0, null, null)");
    $array_values = array();
    array_push($array_values, utf8_decode($name_channel), utf8_decode($description_channel), $_SESSION['id']);
    $success = odbc_execute($preparation, $array_values);
    if (!$success){
        throw new Exception("You already have a channel!");
    }
    $json['error'] = "";
    $json['id'] = $_SESSION['id'];
    $liveString = createLive($name_channel);
    if ($liveString == false){
        throw new Exception("Something went wrong while creating your channel!", 500);
    }
    $liveJson = json_decode($liveString, true);
    $streamKey = $liveJson['streamKey'];
    $streamId = $liveJson['streamId'];
    $sql = "UPDATE channel SET streamKey_channel = '$streamKey' AND stream_id = $streamId WHERE id_user = " . $_SESSION['id'];
    $result = odbc_exec($con, $sql);
    if ($result == false){
        throw new Exception("Streamer key was not created for this channel, please contact a support for help!");
    }
    if (($_FILES['channel_image']['name'] != "")) {
        $sql = "SELECT id_channel FROM channel WHERE id_user = " . $_SESSION['id'];
        $result = odbc_exec($con, $sql);
        if ($result == false){
            throw new Exception("Something went wrong while creating your channel!", 500);
        }
        $_SESSION['has_channel'] = 1;
        $id_channel = odbc_fetch_object($result)->id_channel;
        $target_dir = "../assets/images/channel_image/";
        $file = $_FILES['channel_image']['name'];
        $path = pathinfo($file);
        $filename = $path['filename'];
        $ext = $path['extension'];
        $temp_name = $_FILES['channel_image']['tmp_name'];
        $path_filename_ext = $target_dir . "profile_picture_channel" . $id_channel . ".jpeg";
// Check if channel_image already exists
        if (file_exists($path_filename_ext)) {
            throw new Exception("Something went wrong while creating your channel!");
        }
        else {
            move_uploaded_file($temp_name, $path_filename_ext);
        }
    }
}
catch (Exception $exception){
    $json['error'] = $exception->getMessage();
    $sql = "DELETE FROM channel WHERE id_user = " . $_SESSION['id'];
}
die(json_encode($json));

