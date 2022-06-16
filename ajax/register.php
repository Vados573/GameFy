<?php
ob_start();
session_start();
extract($_POST);
include('../includes/config.php'); // Retrieve database connection from the config file
include('../includes/global_functions.php'); // Retrieve global functions
$json = array();

if (!isset($username) or !isset($password) or !isset($email) or !isset($confirm)) { // If variable not found
    $json['error'] = "Please fill all fields!";
    die(json_encode($json));
}

if ($username == "" or $password == "" or $confirm == "" or $email == "") { // If fields are empty
    $json['error'] = "Please fill all fields!";
    die(json_encode($json));
}

$username = filter_var($username, FILTER_SANITIZE_STRING);

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // If email is not in the right format
    $json['error'] = "Please enter a valid Email!";
    die(json_encode($json));
}

$sql = "SELECT * FROM user where username_user = '$username'";
$num = odbc_num_rows(odbc_exec($con, $sql)); // Get number of rows
if ($num > 0) {
    $json['error'] = 'This email already exist, Try to login instead!'; // Email Already in Database
    die(json_encode($json));
}

$uppercase = preg_match('@[A-Z]@', $password); // Checks if password has an uppercase
$lowercase = preg_match('@[a-z]@', $password); // Checks if password has a lowercase
$number = preg_match('@[0-9]@', $password); // Checks if password has a number
$specialChars = preg_match('@[^\w]@', $password); // Checks if password has a special character
if (!$uppercase || !$lowercase || !$number ||
    !$specialChars || strlen($password) < $lengthPassword) {
    $json['error'] = "Your password must be " . $lengthPassword . " characters long and must contain at least one uppercase, one lowercase, one number 
    and one special character!";
    die(json_encode($json));
}

if ($password != $confirm) {
    $json['error'] = "Passwords don't match!";
    die(json_encode($json));
}

if (isset($captchaResponse) && !empty($captchaResponse)) { // Check if Captcha is checked
    //Site secret key
    $secret = "6Lcb2w0gAAAAABsJbFlp9zO2wpCZeHAbm-tNlMzG";
    //Get verify response data
    $verifyResponse = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $captchaResponse);
    $responseData = json_decode($verifyResponse);
    if (!$responseData->success) { // If response is not success
        $json['error'] = "Robot verification failed, please try again!";
        die(json_encode($json));
    }
} else {
    $json['error'] = "Please check the Captcha checkbox!";
    die(json_encode($json));
}

$salt = saltGenerator();
$password = $password . $salt;
$password = hash("sha512", $password);

try {
    $preparation = odbc_prepare($con, 'INSERT INTO user VALUES (null, ?, ?, ?, ?, ?, ?, ?)');
    $array_param = array();
    array_push($array_param, $username, $password, $salt, $email, 0, 1, 0);
    $success = odbc_execute($preparation, $array_param);
    if (!$success) {
        throw new Exception("Something went wrong! Account creation failed! Please Try again later!");
    }
} catch (Exception $exception) {
    $json['error'] = $exception;
    die(json_encode($json));
}

$json['error'] = "";
die(json_encode($json));
