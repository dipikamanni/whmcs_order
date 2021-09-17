<?php
/**
 * ValidateLogin Api 
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
if (isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['password']) && !empty($_POST['password'])) {

    $param=santizeInput($_POST);

    $args=[
        'action' => 'ValidateLogin',
        'email' => $param['email'],
        'password2' =>$param['password'],
    ];

    
    $response=curlCall($args);

    if ($response["status"]=="success") {
        $clientid=$response['userid'];

        $args=[
            'action'  => 'GetClientsDetails',
            'clientid'=>  $clientid,
        ];
        $response=curlCall($args);
        $result=[
            'status' => 'success',
            'name'  =>  $response['fullname'],
            'clientid' => $clientid,
        ];
        printSuccess($result);
    } else {
        printError($response);
    } 
}
