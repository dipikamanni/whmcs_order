<?php
/**
 * Custom Order Api Common Function
 * 
 * PHP version 7
 *
 * @category Api
 * @package  WHMCS
 * @author   Kuroit <hello@kuroit.com>
 * @license  https://portal.hostworld.uk/ License
 * @link     https://portal.hostworld.uk/
 */

if (!defined('ORDER_API_CALL')) {
    return json_encode(
        [
            "status"    => "error",
            "message"   => "module not defined",
        ]
    ); 
}

/**
 * Function printError.
 * printError function return the error messages.
 * printError function get the output in a array format.
 * printError function is return the output in json format
 * printError function returns the status 200 with error. 
 *
 * @param array $args arguments to return in a json format
 *
 * @return array
 */
function printError($args=array())
{
    header("HTTP/1.1 200 OK");
    echo json_encode($args);
    exit;
}

/**
 * Function printSuccess.
 * printSuccess function return the success messages.
 * printSuccess function get the output in a array format.
 * printSuccess function is return the output in json format
 * printSuccess function returns the status 200 with error. 
 *
 * @param array $args arguments to return in a json format
 *
 * @return array
 */
function printSuccess($args=array())
{
    header("HTTP/1.1 200 OK");
    echo json_encode($args);
    exit;
}


/**
 * Function curlCall.
 * curlCall function return the curl api response.
 * curlCall function get the input in a array format.
 * curlCall function is return the output in array format
 *
 * @param array $args arguments to return in a array format
 *
 * @return array
 */
function curlCall($args=array()) 
{
    // define variables area starts
    $whmcsUrl="https://portal.hostworld.uk/includes/api.php";
    $whmcsUser="pPdixkK9OAd7vNinGKSU7ma9aSE9zqtG";
    $whmcsPassword=md5("9rUAaZHGaSFClWyXq1TFSh6x2TmqUdDG");
    $cacheActions=[
        "GetProducts",
    ];
    $cacheDir=__DIR__."/cache/".md5(json_encode($args)).".json";
    // Declaring variables area ends

    $params= array(
        'username'      => $whmcsUser,
        'password'      => $whmcsPassword,
        'responsetype'  => 'json',
    );
    $params=array_merge($params, $args);
    

    if (in_array($params['action'], $cacheActions) && file_exists($cacheDir)) {
        $lastModified=filemtime($cacheDir);
        $fileContent=file_get_contents($cacheDir);
        $currentTime = time();
        $timeDifference = $currentTime - $lastModified;
        if ($fileContent != "" && $timeDifference < 3600) {
            $response=json_decode($fileContent, true);
            $response["status"]=$response["result"];
            unset($response["result"]);
            return $response;
        } 
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $whmcsUrl);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt(
        $ch, CURLOPT_POSTFIELDS,
        http_build_query(
            $params
        )
    );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close($ch);
    if ($response=="" || empty($response)) {
        return [
            "result" => "error",
            "message" => "response not found"
        ];
    } else {
        if (in_array($params['action'], $cacheActions)) {
            file_put_contents($cacheDir, $response) or die("Unable to write");
        }
        $response=json_decode($response, true);
        $response["status"]=$response["result"];
        unset($response["result"]);
        return $response;
    }
}

/**
 * Function santizeInput.
 * santizeInput function return the santized arguments.
 *
 * @param array/string $args arguments to santize
 *
 * @return array/string
 */
function santizeInput($args) 
{
    
    foreach ($args as $key => $value) {
        if (is_array($value)) {
            santizeInput($value);
        } else {
            $args[$key]=filter_var($value, FILTER_SANITIZE_STRING);
        }
    }
    return $args;
}