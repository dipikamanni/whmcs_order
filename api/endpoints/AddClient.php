<?php
/**
 * AddClient Api 
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
    printError(['status' =>'error','data' => 'Invalid Operation.']); 
} 
if (isset($_POST["clientInfo"]["email"]) && !empty($_POST["clientInfo"]["email"]) && isset($_POST["clientInfo"]["email"]) && !empty($_POST["clientInfo"]["email"])) {
    $param=santizeInput($_POST["clientInfo"]);
    
    $args=[
        'action' => 'GetClients',
        'search' => $param['email'],
    ];
    $response=curlCall($args);

    if ($response["totalresults"] > 0) {
        printSuccess(['status' =>'error','exist'=>true,]);
    } else {
        $param=santizeInput($_POST["clientInfo"]);

        $args=[
            'action' => 'AddClient',
            'firstname' => $param["fname"],
            'lastname' => $param["lname"],
            'email' => $param["email"],
            'password2' => $param["password"],
            'phonenumber' => $param["phone"],
            'address1' => $param["address1"],
            'city' => $param["city"],
            'state' => $param["state"],
            'postcode' => $param["postCode"],
            'country' => $param["country"],
            'securityqid' => $param["securityQuestion"],
            'securityqans' => $param["securityAnswer"],
            'companyname' => $param["companyName"],
            'currency' => $param["currency"],
        ];
        $response=curlCall($args);
        if ($response["status"]=="success" && $response["clientid"]==true) {
            printSuccess($response);
        } else {
            printError($response);
        } 
    }
}



// $args=[
//         'action' => 'UpdateClient',
//         'clientid'=>1025,
//         'currency'=>2,
//     ];
//      $response=curlCall($args);
//      print_r($response);