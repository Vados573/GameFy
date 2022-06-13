<?php
ob_start();
session_start();
extract($_POST);
include('../includes/config.php');
$json = array();

if (!isset($username) or !isset($password)) { // If variable not found
    $json['error'] = "Please fill both fields!";
    die(json_encode($json));
}

if ($username == "" or $password == "" or $username == null or $password == null) { // If fields are empty
    $json['error'] = "Please fill both fields!";
    die(json_encode($json));
}
//if (!filter_var($username, FILTER_VALIDATE_EMAIL)) { // If email is not in the right format
//    $json['error'] = "Please enter a valid Email!";
//    die(json_encode($json));
//}

//if (isset($captchaResponse) && !empty($captchaResponse)) { // Check if Captcha is checked
//    //Site secret key
//    $secret = "6Lcb2w0gAAAAABsJbFlp9zO2wpCZeHAbm-tNlMzG";
//    //Get verify response data
//    $verifyResponse = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $captchaResponse);
//    $responseData = json_decode($verifyResponse);
//    if (!$responseData->success) { // If response is not success
//        $json['error'] = "Robot verification failed, please try again!";
//        die(json_encode($json));
//    }
//} else {
//    $json['error'] = "Please check the Captcha checkbox!";
//    die(json_encode($json));
//}

$sql = "SELECT salt_user, password_user FROM user where username_user = '$username'";
$credentials = odbc_fetch_object(odbc_exec($con, $sql)); // Get the salt and password from database
if ($credentials == false) {
    $json['error'] = 'Wrong Credentials!'; // Username Not found
    die(json_encode($json));
}
$password = $password . $credentials->salt_user; // Concat the salt and the password

$password = hash("sha512", $password); // Hash the password + salt


if ($credentials->password_user != $password) {
    $json['error'] = 'Wrong Credentials!'; // Password doesn't match
    die(json_encode($json));
}
// If you are here both username and password are correct
$sql = "SELECT * FROM user WHERE username_user = '$username'";
$user = odbc_fetch_object(odbc_exec($con, $sql));
// Initialize session parameters
$_SESSION['id'] = $user->id_user;
$_SESSION['username'] = $user->username_user;
$_SESSION['email'] = $user->email_user;
$_SESSION['is_admin'] = $user->is_admin_user;
$_SESSION['is_active'] = $user->is_active_user;
$_SESSION['image_path'] = $user->path_image_user;
if ($user->is_banned_user == "1"){
    $json['error'] = "We are sorry to inform you that you have been banned from our platform!";
    session_unset();
    session_destroy();
    $_SESSION = array();
    die(json_encode($json));
}
$json['error'] = "";
die(json_encode($json));
