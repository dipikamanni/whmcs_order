<?php
/**
 * GetProducts Api 
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
if (isset($_POST['action']) && !empty($_POST['action'])) {
    $param=santizeInput($_POST);

    $args=[
        'action' => 'GetProducts',
    ];

    if (isset($param["gid"])) {
        $args["gid"]=$param["gid"];
    }

    if (isset($param["pid"])) {
        $args["pid"]=$param["pid"];
    }
    $response=curlCall($args);

    if ($response["status"]=="success" && $response["totalresults"] > 0) {
        if (isset($param["pid"])) {
            $response=$response["products"]["product"];
        } else {
            unset($response["products"]["product"][0]["configoptions"]);
            unset($response["products"]["product"][0]["customfields"]);
        }
        printSuccess($response);
    } else {
        printError($response);
    } 
}
