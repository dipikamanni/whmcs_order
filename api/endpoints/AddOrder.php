<?php
/**
 * AddOrder Api 
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
if (isset($_POST['clientid']) && !empty($_POST['clientid'] && isset($_POST['email']) && !empty($_POST['email']))) {

    $param=santizeInput($_POST);
    $configoptions=[];
    foreach ($param['configoptions'] as $key => $val) {
        //$temp = array($key =>$val);
        //array_push($configoptions, $temp);
        $configoptions[$key] = $val;
    }
    // print_r($configoptions);
    $args=[
        'action' => 'AddOrder',
        'clientid' => $param['clientid'],
        'pid' => $param['pid'],
        'billingcycle' => $param['billingcycle'],
        'configoptions' => base64_encode(serialize($configoptions)),
        'promocode' => $param['promocode'],
        'paymentmethod' => $param['paymentmethod'],
        'hostname' => $param['hostname'],
        'rootpw' => $param['rootpw'],
    ];

    $email = $param['email'];
    // Define WHMCS URL & AutoAuth Key
    $whmcsurl = "https://portal.hostworld.uk/dologin.php";
    $autoauthkey = "5cac423cb4d4cb3ca0a62c37a432093b";
     
    $timestamp = time(); // Get current timestamp
    $email = $email; // Clients Email Address to Login
    $goto = 'clientarea.php?action=invoices';
     
    $hash = sha1($email . $timestamp . $autoauthkey); // Generate Hash
    
    $response = curlCall($args);
    
    if ($response["status"]=="success") {
        $goto = 'viewinvoice.php?id='.$response['invoiceid'];
        // Generate AutoAuth URL & Redirect
        $url = $whmcsurl . "?email=".$email."&timestamp=".$timestamp."&hash=".$hash."&goto=" . urlencode($goto);
            $result = [
                'status' => 'success',
                'value'  =>  $response,
                'url' => $url,
                'time' => date("y-m-d H:i:s"),
            ];

    } else {
        // $goto = 'clientarea.php?action=invoices';
        // Generate AutoAuth URL & Redirect
        $args=[
            'action' => 'FraudOrder',
            'orderid' => $response['orderid'],
        ];
        $response2 = curlCall($args);
        if ($response2["status"]=="success") {
            $result=[
                "status" => "error",
                "message" => "fraud order",
            ];
        }
    }
    printSuccess($result);

}
