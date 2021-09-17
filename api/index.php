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


header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-sRequest-With');
require_once __DIR__."/function.php";

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    if (file_exists("endpoints/{$action}.php")) {
        define('ORDER_API_CALL', true);
    
        require_once "endpoints/{$action}.php";
    } else {
        printError(['status' =>'error','data' => 'Invalid action.']);    
    }

} else {
    printError(['status' =>'error','data' => 'Action Not Found.']);
}