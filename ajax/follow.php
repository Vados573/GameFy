<?php
ob_start();
session_start();
extract($_POST);
include('../includes/config.php');
include('../includes/global_functions.php');
$json = array();
$content = "";
$today = date('Y-m-d');

if (isset($add)){
    $sql = "INSERT INTO follow VALUES(" . $_SESSION['id'] . ", " . $id_Channel . ", '$today')";
    $result = odbc_exec($con, $sql);
    $sql = "UPDATE channel SET followers_channel = followers_channel + 1 WHERE id_channel = $id_Channel";
    $result = odbc_exec($con, $sql);
    if ($result == false){
        $json['error'] = "Something went wrong";
        die(json_encode($json));
    }
}
elseif (isset($remove)){
    $sql = "DELETE FROM follow WHERE id_user = " . $_SESSION['id'] . " AND id_channel = " . $id_Channel;
    $result = odbc_exec($con, $sql);
    $sql = "UPDATE channel SET followers_channel = followers_channel - 1 WHERE id_channel = $id_Channel";
    $result = odbc_exec($con, $sql);
    if ($result == false){
        $json['error'] = "Something went wrong";
        die(json_encode($json));
    }
}
$json['error'] = "";
die(json_encode($json));