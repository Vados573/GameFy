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