<?php
/**
 * Generates a random string to be used as a salt
 * @param $length int Length of the salt to generate. Default value 15 if not specified in function call
 * @return string Generated salt
 */

function saltGenerator($length = 15)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

/**
 * Check if the date given is an actual date and if it's in the specified format
 * @param $date string Date we want to check
 * @param $format string Format of the date we want. Default Y-m-d if not specified in function call
 * @return bool false if $date is not in the same format as $format else it returns true
 */

function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}

/**
 * Checks if country exists and the city exists in that country
 * @param $name string name of the city
 * @param $country string name of the country
 * @return bool False if city or country doesn't exist, True if they exist
 * @author Azmi Ayoub <azmiayoub50@gmail.com>
 */

function checkCityOrCountry($name, $country)
{
    $postData = http_build_query(
        array(
            'country' => $country,
        )
    );
    $opts = array('http' =>
        array(
            'method' => 'POST',
            'header' => 'Content-Type: application/x-www-form-urlencoded',
            'content' => $postData
        )
    );
    $context = stream_context_create($opts);
    $cities = file_get_contents('https://countriesnow.space/api/v0.1/countries/cities', false, $context);
    $arr = json_decode($cities, true);
    if ($arr['error'] == false) {
        foreach ($arr['data'] as $city) {
            if (mb_strtolower($city) === mb_strtolower($name)) {
                return true;
            }
        }
    }
    return false;
}

/**
 * Verify if phone number provided exists or not, using an API
 * (The free plan of the api limits us to 20 check each day and 100 each month)
 * @param $number string Phone number to verify
 * @return bool|string Returns False if Phone doesn't exist Else it returns the result of the API.
 */

function verifyPhone($number)
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.apilayer.com/number_verification/validate?number=$number",
        CURLOPT_HTTPHEADER => array(
            "Content-Type: text/plain",
            "apikey: n142J7oRCBUDOuRVE8NAiGS41IBkaVre"
        ),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET"
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

/**
 * Function that checks the strength of a given password
 * @param $password string Password to check
 * @return bool true if password is strong enough, false otherwise
 */
function checkPasswordStrength($password, $lengthPassword)
{
    $uppercase = preg_match('@[A-Z]@', $password); // Checks if password has an uppercase
    $lowercase = preg_match('@[a-z]@', $password); // Checks if password has a lowercase
    $number = preg_match('@[0-9]@', $password); // Checks if password has a number
    $specialChars = preg_match('@[^\w]@', $password); // Checks if password has a special character
    if (!$uppercase || !$lowercase || !$number ||
        !$specialChars || strlen($password) < $lengthPassword) {
        return false;
    }
    return true;
}

/**
 * Function that retrieve the current temperature of a city
 * @param $city string The name of the city
 * @return float The temperature in celsius
 */
function getTemperature($city)
{
    $apiKey = "d304413310ca6494bbae66a7dedbb73d";
    $response = file_get_contents("https://api.openweathermap.org/data/2.5/weather?q=$city&appid=$apiKey");
    $response = json_decode($response, true);
    $temperature = $response["main"]["temp"]; // In kelvin
    return $temperature - 273.15; // Convert to celsius and return
}

/**
 * @param $number numeric The number to format
 * @return string The formatted number
 */
function getMinNumber($number){
    if ($number < 1000000) {
        // Anything less than a million
        $format = number_format($number);
    } else if ($number < 1000000000) {
        // Anything less than a billion
        $format = number_format($number / 1000000, 2) . 'M';
    } else {
        // At least a billion
        $format = number_format($number / 1000000000, 2) . 'B';
    }

    return $format;
}

/**
 * Checks if string doesn't contain special characters
 * @param $string string The text to check
 * @return bool True if the text is clean false otherwise
 */
function checkString($string) {
    if (preg_match('/[£$%*()}{@#~><|=_+¬-]/', $string)){
        return false;
    }
    else{
        return true;
    }
}

/**
 * Create live stream. This function is in Beta and still need a lot of upgrades
 * @param $name string The name of the stream to create
 * @param int $record If the user is recording
 */
function createLive($name ,$record = true, $public = true){
    if ($_SESSION['authTime'] <= strtotime("-1 hour")){
        refreshApi();
    }
    $authToken = $_SESSION['authToken'];
    $curl = curl_init();
    $authorization = "Authorization: Bearer $authToken";
    $data = array("name" => $name, "record" => $record, "public" => $public);
    $postData = json_encode($data);
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://ws.api.video/live-streams",
        CURLOPT_HTTPHEADER => array(
            "Content-Type: text/plain",
            $authorization
        ),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => $postData,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST"
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

/**
 * Send authentication request to api
 * @return bool|string False on error or Json string that contains the auth Token and refresh Token
 */
function authApi(){
    $curl = curl_init();
    $data = array("apiKey" => API_KEY);
    $postData = json_encode($data);
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://ws.api.video/auth/api-key",
        CURLOPT_HTTPHEADER => array(
            "Content-Type: text/plain",
        ),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => $postData,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST"
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

function refreshApi(){
    $curl = curl_init();
    $data = array("refreshToken" => $_SESSION['refreshToken']);
    $postData = json_encode($data);
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://ws.api.video/auth/refresh",
        CURLOPT_HTTPHEADER => array(
            "Content-Type: text/plain",
        ),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => $postData,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST"
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    $refreshJson = json_decode($response, true);
    $_SESSION['authToken'] = $refreshJson['access_token'];
    $_SESSION['refreshToken'] = $refreshJson['refresh_token'];
    $_SESSION['authTime'] = strtotime(date('y-m-d H:i:s'));
}

/**
 * @param $idLive string Live of the id to update
 * @param $name string Updated name of the stream
 * @param $record bool True if live should be recorded, False otherwise
 * @return bool True on success or False on fail
 */
function updateLive($idLive, $name = null, $record = null){
    if ($_SESSION['authTime'] <= strtotime("-1 hour")){
        refreshApi();
    }
    $authToken = $_SESSION['authToken'];
    $authorization = "Authorization: Bearer $authToken";
    $curl = curl_init();
    $data = array();
    if ($name != null){
        $data["name"] = $name;
    }
    if($record != null){
        $data["record"] = $record;
    }
    else{
        $data["record"] = false;
    }
    $data["record"] = boolval($data["record"]);
    $postData = json_encode($data);
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://ws.api.video/live-streams/" . $idLive,
        CURLOPT_HTTPHEADER => array(
            "Content-Type: text/plain",
            $authorization
        ),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => $postData,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "PATCH"
    ));
    $response = curl_exec($curl);
    if ($response != false){
        $response = true;
    }
    return $response;
}

/**
 * @param $idStream string stream id of the video
 * @param $sortBy string The variable to sort with
 * @param $sortOrder string Order by asc or desc
 * @return bool|string Response on success or False on fail
 */
function getVideos($idStream, $sortBy,  $sortOrder = "desc"){
    if ($_SESSION['authTime'] <= strtotime("-1 hour")){
        print_r($_SESSION['authTime'] . " ");
        print_r(strtotime("-1 hour"));
        refreshApi();
    }
    $authToken = $_SESSION['authToken'];
    $authorization = "Authorization: Bearer $authToken";
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://ws.api.video/videos?liveStreamId=" . $idStream ."&sortBy=" . $sortBy . "&sortOrder=" . $sortOrder ,
        CURLOPT_HTTPHEADER => array(
            "Content-Type: text/plain",
            $authorization
        ),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET"
    ));
    $response = curl_exec($curl);
    return $response;
}

function get_time_ago( $time )
{
    $time_difference = time() - $time;

    if( $time_difference < 1 ) { return 'less than 1 second ago'; }
    $condition = array( 12 * 30 * 24 * 60 * 60 =>  'year',
        30 * 24 * 60 * 60       =>  'month',
        24 * 60 * 60            =>  'day',
        60 * 60                 =>  'hour',
        60                      =>  'minute',
        1                       =>    'second'
    );

    foreach( $condition as $secs => $str )
    {
        $d = $time_difference / $secs;

        if( $d >= 1 )
        {
            $t = round( $d );
            return 'about ' . $t . ' ' . $str . ( $t > 1 ? 's' : '' ) . ' ago';
        }
    }
}





















